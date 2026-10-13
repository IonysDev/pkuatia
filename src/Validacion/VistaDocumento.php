<?php

namespace IonysDev\Pkuatia\Validacion;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Autofactura;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronicoComercial;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeCredito;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeDebito;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeRemision;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\B\GOpeDE;
use IonysDev\Pkuatia\Core\Fields\DE\C\GTimb;
use IonysDev\Pkuatia\Core\Fields\DE\D\GDatRec;
use IonysDev\Pkuatia\Core\Fields\DE\D\GEmis;
use IonysDev\Pkuatia\Core\Fields\DE\D\GOpeCom;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamAE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamCond;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamFE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamNCDE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamNRE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCompPub;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupAdi;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupSeg;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupSup;
use IonysDev\Pkuatia\Core\Fields\DE\E\GTransp;
use IonysDev\Pkuatia\Core\Fields\DE\F\GTotSub;
use IonysDev\Pkuatia\Core\Fields\DE\G\GCamGen;
use ReflectionProperty;

/**
 * Vista común de un documento para el validador (Fase C, paso C9): el mismo acceso a los grupos tanto para un
 * documento en construcción (Factura, Autofactura, NotaDeCredito, NotaDeDebito, NotaDeRemision, que guardan los
 * grupos sueltos hasta toRDE()) como para un DE o RDE ya armado o leído de un XML. Lee las propiedades públicas con
 * isset y nunca llama getters, así que un documento a medio armar no termina en Error (deuda Q-B3). No modifica nada.
 */
final class VistaDocumento
{
  private function __construct(private readonly ?DocumentoElectronico $builder, private readonly ?DE $de, private readonly ?RDE $rde = null)
  {
  }

  public static function desde(DocumentoElectronico|DE|RDE $documento): self
  {
    if ($documento instanceof RDE)
      return new self(null, isset($documento->DE) ? $documento->DE : new DE(), $documento);
    return $documento instanceof DE ? new self(null, $documento) : new self($documento, null);
  }

  public function esBuilder(): bool
  {
    return $this->builder !== null;
  }

  /** Tipo de documento (C002 iTiDE), o null si no está informado. */
  public function tipoDocumento(): ?int
  {
    $timb = $this->gTimb();
    return $timb !== null && isset($timb->iTiDE) ? (int) $timb->iTiDE : null;
  }

  /** CDC (Id del DE), solo en un DE ya armado. */
  public function id(): ?string
  {
    return $this->de !== null && isset($this->de->id) ? $this->de->id : null;
  }

  public function dFecFirma(): ?DateTime
  {
    return self::enZonaSifen($this->de !== null && isset($this->de->dFecFirma) ? $this->de->dFecFirma : null);
  }

  /**
   * Las fechas del DE van sin zona en el XML y son hora de Asunción por convención del MT; al leer un rDE el modelo las
   * crea con la zona por defecto de PHP. Para comparar con el reloj del SIFEN se toma la hora de pared en Asunción
   * (hallazgo de C14).
   */
  public static function enZonaSifen(?DateTimeInterface $fecha): ?DateTime
  {
    return $fecha === null ? null : new DateTime($fecha->format('Y-m-d\TH:i:s'), new DateTimeZone(Constants::SIFEN_TIMEZONE));
  }

  /**
   * Árbol sintético con la forma de tDE del XSD, para el recorrido de completitud: los grupos hoja son los objetos
   * del modelo; los contenedores que el builder no arma hasta toRDE() (gDatGralOpe, gDtipDE, gCamEsp) son arreglos.
   *
   * @return array<string, mixed>
   */
  public function raiz(): array
  {
    $gCamEsp = null;
    if ($this->gGrupEner() !== [] || $this->gGrupSeg() !== null || $this->gGrupSup() !== null || $this->gGrupAdi() !== null)
      $gCamEsp = ['gGrupEner' => $this->gGrupEner(), 'gGrupSeg' => $this->gGrupSeg(), 'gGrupSup' => $this->gGrupSup(), 'gGrupAdi' => $this->gGrupAdi()];
    $gCamFE = $this->gCamFE();
    if ($gCamFE !== null && $this->esBuilder() && $this->gCompPub() !== null && !isset($gCamFE->gCompPub))
      $gCamFE = get_object_vars($gCamFE) + ['gCompPub' => $this->gCompPub()];
    return [
      'gOpeDE' => $this->gOpeDE(),
      'gTimb' => $this->gTimb(),
      'gDatGralOpe' => ['dFeEmiDE' => $this->dFeEmiDE(), 'gOpeCom' => $this->gOpeCom(), 'gEmis' => $this->gEmis(), 'gDatRec' => $this->gDatRec()],
      'gDtipDE' => [
        'gCamFE' => $gCamFE,
        'gCamAE' => $this->gCamAE(),
        'gCamNCDE' => $this->gCamNCDE(),
        'gCamNRE' => $this->gCamNRE(),
        'gCamCond' => $this->gCamCond(),
        'gCamItem' => $this->items(),
        'gCamEsp' => $gCamEsp,
        'gTransp' => $this->gTransp(),
      ],
      'gTotSub' => $this->gTotSub(),
      'gCamGen' => $this->gCamGen(),
      'gCamDEAsoc' => $this->gCamDEAsoc(),
    ];
  }

  public function gOpeDE(): ?GOpeDE
  {
    return $this->prop($this->builder, 'gOpeDE') ?? $this->prop($this->de, 'gOpeDe');
  }

  public function gTimb(): ?GTimb
  {
    return $this->prop($this->builder, 'gTimb') ?? $this->prop($this->de, 'gTimb');
  }

  public function dFeEmiDE(): ?DateTime
  {
    $g = $this->prop($this->builder, 'gDatGralOpe') ?? $this->prop($this->de, 'gDatGralOpe');
    $fecha = $this->prop($g, 'dFeEmiDE');
    return $fecha instanceof DateTimeInterface ? self::enZonaSifen($fecha) : null;
  }

  public function gOpeCom(): ?GOpeCom
  {
    if ($this->builder !== null)
      return $this->builder instanceof DocumentoElectronicoComercial ? $this->prop($this->builder, 'gOpeCom') : null;
    return $this->prop($this->prop($this->de, 'gDatGralOpe'), 'gOpeCom');
  }

  public function gEmis(): ?GEmis
  {
    return $this->prop($this->builder, 'gEmis') ?? $this->prop($this->prop($this->de, 'gDatGralOpe'), 'gEmis');
  }

  public function gDatRec(): ?GDatRec
  {
    return $this->prop($this->builder, 'gDatRec') ?? $this->prop($this->prop($this->de, 'gDatGralOpe'), 'gDatRec');
  }

  public function gCamFE(): ?GCamFE
  {
    if ($this->builder !== null)
      return $this->builder instanceof Factura ? $this->prop($this->builder, 'gCamFE') : null;
    return $this->prop($this->gDtipDe(), 'gCamFE');
  }

  public function gCompPub(): ?GCompPub
  {
    if ($this->builder instanceof Factura && isset($this->builder->gCompPub))
      return $this->builder->gCompPub;
    return $this->prop($this->gCamFE(), 'gCompPub');
  }

  public function gCamAE(): ?GCamAE
  {
    if ($this->builder !== null)
      return $this->builder instanceof Autofactura ? $this->prop($this->builder, 'gCamAE') : null;
    return $this->prop($this->gDtipDe(), 'gCamAE');
  }

  public function gCamNCDE(): ?GCamNCDE
  {
    if ($this->builder !== null)
      return ($this->builder instanceof NotaDeCredito || $this->builder instanceof NotaDeDebito) ? $this->prop($this->builder, 'gCamNCDE') : null;
    return $this->prop($this->gDtipDe(), 'gCamNCDE');
  }

  public function gCamNRE(): ?GCamNRE
  {
    if ($this->builder !== null)
      return $this->builder instanceof NotaDeRemision ? $this->prop($this->builder, 'gCamNRE') : null;
    return $this->prop($this->gDtipDe(), 'gCamNRE');
  }

  public function gCamCond(): ?GCamCond
  {
    if ($this->builder !== null)
      return ($this->builder instanceof Factura || $this->builder instanceof Autofactura) ? $this->prop($this->builder, 'gCamCond') : null;
    return $this->prop($this->gDtipDe(), 'gCamCond');
  }

  /** @return list<object> ítems (GCamItem) en orden */
  public function items(): array
  {
    $items = $this->builder !== null ? $this->prop($this->builder, 'items') : $this->prop($this->gDtipDe(), 'gCamItem');
    return is_array($items) ? array_values($items) : [];
  }

  /** @return list<object> medidores (GGrupEner), el principal y los adicionales */
  public function gGrupEner(): array
  {
    if ($this->builder !== null) {
      $principal = $this->prop($this->builder, 'gGrupEner');
      if ($principal === null)
        return [];
      return array_merge([$principal], $this->privada($this->builder, 'gGrupEnerAdicionales') ?? []);
    }
    $esp = $this->prop($this->gDtipDe(), 'gCamEsp');
    if ($esp === null || !isset($esp->gGrupEner))
      return [];
    return method_exists($esp, 'getGGrupEners') ? array_values($esp->getGGrupEners()) : [$esp->gGrupEner];
  }

  public function gGrupSeg(): ?GGrupSeg
  {
    return $this->prop($this->builder, 'gGrupSeg') ?? $this->prop($this->prop($this->gDtipDe(), 'gCamEsp'), 'gGrupSeg');
  }

  public function gGrupSup(): ?GGrupSup
  {
    return $this->prop($this->builder, 'gGrupSup') ?? $this->prop($this->prop($this->gDtipDe(), 'gCamEsp'), 'gGrupSup');
  }

  public function gGrupAdi(): ?GGrupAdi
  {
    return $this->prop($this->builder, 'gGrupAdi') ?? $this->prop($this->prop($this->gDtipDe(), 'gCamEsp'), 'gGrupAdi');
  }

  public function gTransp(): ?GTransp
  {
    return $this->prop($this->builder, 'gTransp') ?? $this->prop($this->gDtipDe(), 'gTransp');
  }

  public function gTotSub(): ?GTotSub
  {
    return $this->prop($this->builder, 'gTotSub') ?? $this->prop($this->de, 'gTotSub');
  }

  public function gCamGen(): ?GCamGen
  {
    return $this->prop($this->builder, 'gCamGen') ?? $this->prop($this->de, 'gCamGen');
  }

  /** @return list<object> documentos asociados (GCamDEAsoc) */
  public function gCamDEAsoc(): array
  {
    $lista = $this->prop($this->builder, 'gCamDEAsoc') ?? $this->prop($this->de, 'gCamDEAsoc');
    return is_array($lista) ? array_values($lista) : [];
  }

  private function gDtipDe(): ?object
  {
    return $this->prop($this->de, 'gDtipDe');
  }

  /** Propiedad pública inicializada y no nula, o null (sin getters ni Error). */
  private function prop(?object $objeto, string $nombre): mixed
  {
    if ($objeto === null || !property_exists($objeto, $nombre))
      return null;
    return isset($objeto->{$nombre}) ? $objeto->{$nombre} : null;
  }

  /** Propiedad privada del builder (los medidores adicionales de Q-B9 no tienen getter). */
  private function privada(object $objeto, string $nombre): mixed
  {
    for ($clase = $objeto::class; $clase !== false; $clase = get_parent_class($clase)) {
      if (property_exists($clase, $nombre)) {
        $p = new ReflectionProperty($clase, $nombre);
        return $p->isInitialized($objeto) ? $p->getValue($objeto) : null;
      }
    }
    return null;
  }

  /** El DE subyacente cuando la vista se armó desde un DE o RDE; null para un documento en construcción. */
  public function de(): ?DE
  {
    return $this->de;
  }

  /** J003 dInfAdic del grupo fuera de la firma (rDE.gCamFuFD); solo un RDE lo lleva, los builders no. */
  public function dInfAdic(): ?string
  {
    $texto = $this->prop($this->prop($this->rde, 'gCamFuFD'), 'dInfAdic');
    return is_string($texto) && trim($texto) !== '' ? $texto : null;
  }
}
