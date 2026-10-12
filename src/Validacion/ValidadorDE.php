<?php

namespace IonysDev\Pkuatia\Validacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;

/**
 * Validador de reglas offline del DE (Fase C, paso C9; decisión Q-C1). Devuelve un ResultadoValidacion con un
 * ErrorValidacion por problema: código con el que el SIFEN rechazaría el documento, campo del MT, elemento, ruta y
 * sugerencia. No serializa, no firma, no toca la red y no modifica el documento.
 *
 * Parte 1 (este paso):
 * - Completitud según el XSD: en cada grupo informado, los elementos con minOccurs = 1 (DE_v150.xsd, a través del
 *   catálogo de elementos de C5). Código 0160 (AE01): es lo que el SIFEN responde ante un XML que no cumple el
 *   esquema. Los campos que la librería completa al serializar o firmar no se exigen.
 * - Presencia de los grupos que exige o prohíbe el tipo de documento (errores-validacion.md: 1200/1201 gOpeCom,
 *   1350/1351 gCamFE, 2550/2551 gCamAE, 1450/1451 gCamNCDE, 2600/2601 gCamNRE, 1500/1501 gCamCond, 2350/2351
 *   gTotSub, 2100/2101 gTransp y sus grupos 2150/2151, 2200/2201, 2250/2251, 2300/2301, 2400 gCamDEAsoc, 1850/1851
 *   gValorItem, 1900/1901/1902 gCamIVA, 2390 gCamCarg).
 * Los mensajes son los del MT (catálogo) y la sugerencia, el método de PKuatia que informa el campo.
 */
final class ValidadorDE
{
  /** Elementos que la librería genera al serializar o firmar (toRDE, FirmarDE): no se exigen en la completitud. */
  private const GENERADOS = ['dDVId', 'dFecFirma', 'dSisFact', 'dVerFor', 'Signature', 'gCamFuFD', 'dCarQR', 'dInfAdic', 'gCamRDE'];
  /** Propiedades del modelo cuyo nombre difiere del elemento del XSD. */
  private const ALIAS = ['gOpeDE' => 'gOpeDe', 'gDtipDE' => 'gDtipDe'];
  /** Marca de un elemento que el modelo no almacena porque lo deriva al serializar (p. ej. dDesDepSal desde cDepSal). */
  private const DERIVADO = "\0derivado";

  public static function validar(DocumentoElectronico|DE|RDE $documento, ?DateTime $ahora = null): ResultadoValidacion
  {
    $vista = VistaDocumento::desde($documento);
    $ahora ??= new DateTime('now', new DateTimeZone(Constants::SIFEN_TIMEZONE));
    $resultado = new ResultadoValidacion();
    self::completitud($vista, $resultado);
    self::presenciaDeGrupos($vista, $resultado);
    return $resultado;
  }

  // --- Completitud ---------------------------------------------------------------------------------------------------

  private static function completitud(VistaDocumento $vista, ResultadoValidacion $r): void
  {
    self::revisar('tDE', $vista->raiz(), 'DE', $r);
  }

  /** Recorre un grupo según los hijos que el XSD declara para su tipo. */
  private static function revisar(string $tipo, array|object $nodo, string $ruta, ResultadoValidacion $r): void
  {
    foreach (CatalogoValidaciones::hijosDe($tipo) as $hijo) {
      if (in_array($hijo->nombre, self::GENERADOS, true))
        continue;
      $valor = self::leer($nodo, $hijo->nombre);
      if ($valor === self::DERIVADO)
        continue; // lo genera toDOMElement a partir de otro campo, que sí se revisa (p. ej. cDepSal)
      $presente = $valor !== null && $valor !== [] && $valor !== '';
      if (!$presente) {
        if ($hijo->esObligatorio())
          $r->agregar(new ErrorValidacion(OrigenError::Completitud,
            sprintf('Falta %s%s, obligatorio en %s (%s).', $hijo->nombre, $hijo->campoMT !== null ? " ({$hijo->campoMT})" : '', self::nombreDelGrupo($ruta), $hijo->cita()),
            '0160', $hijo->campoMT, $hijo->nombre, $ruta, null, self::sugerencia($hijo)));
        continue;
      }
      if (!$hijo->esGrupo)
        continue;
      $tipoHijo = $hijo->tipo ?? $hijo->nombre;
      if ($hijo->esLista()) {
        $lista = is_array($valor) ? array_values($valor) : [$valor];
        foreach ($lista as $i => $item) {
          if (is_object($item) || is_array($item))
            self::revisar($tipoHijo, $item, $ruta . '.' . $hijo->nombre . '[' . ($i + 1) . ']', $r);
        }
      } elseif (is_object($valor) || is_array($valor)) {
        self::revisar($tipoHijo, $valor, $ruta . '.' . $hijo->nombre, $r);
      }
    }
  }

  /** Valor de un elemento en un nodo (arreglo sintético de la vista u objeto del modelo), sin getters ni Error. */
  private static function leer(array|object $nodo, string $nombre): mixed
  {
    if (is_array($nodo))
      return $nodo[$nombre] ?? null;
    foreach ([$nombre, self::ALIAS[$nombre] ?? null] as $propiedad) {
      if ($propiedad !== null && property_exists($nodo, $propiedad))
        return isset($nodo->{$propiedad}) ? $nodo->{$propiedad} : null;
    }
    // Sin propiedad: el modelo lo deriva al serializar (descripciones de departamento, distrito y ciudad del transporte).
    return self::DERIVADO;
  }

  private static function sugerencia(InfoElemento $hijo): ?string
  {
    if ($hijo->campoMT === null)
      return null;
    $metodo = CatalogoValidaciones::metodoPkuatia($hijo->campoMT);
    return $metodo !== null ? "Informar {$hijo->campoMT} con $metodo." : null;
  }

  private static function nombreDelGrupo(string $ruta): string
  {
    $partes = explode('.', $ruta);
    return end($partes);
  }

  // --- Presencia de grupos por tipo de documento --------------------------------------------------------------------

  private static function presenciaDeGrupos(VistaDocumento $v, ResultadoValidacion $r): void
  {
    $tipo = $v->tipoDocumento();
    if ($tipo === null)
      return;
    $esNR = $tipo === 7;
    $esAF = $tipo === 4;
    $esNC = $tipo === 5 || $tipo === 6;
    $esFE = $tipo === 1;
    $sinOperacion = in_array($tipo, [4, 5, 6, 8], true);

    self::regla($r, !$esNR && $v->gOpeCom() === null, '1200', 'gOpeCom', 'DE.gDatGralOpe');
    self::regla($r, $esNR && $v->gOpeCom() !== null, '1201', 'gOpeCom', 'DE.gDatGralOpe');
    self::regla($r, $esFE && $v->gCamFE() === null, '1350', 'gCamFE', 'DE.gDtipDE');
    self::regla($r, !$esFE && $v->gCamFE() !== null, '1351', 'gCamFE', 'DE.gDtipDE');
    self::regla($r, $esAF && $v->gCamAE() === null, '2550', 'gCamAE', 'DE.gDtipDE');
    self::regla($r, !$esAF && $v->gCamAE() !== null, '2551', 'gCamAE', 'DE.gDtipDE');
    self::regla($r, $esNC && $v->gCamNCDE() === null, '1450', 'gCamNCDE', 'DE.gDtipDE');
    self::regla($r, !$esNC && $v->gCamNCDE() !== null, '1451', 'gCamNCDE', 'DE.gDtipDE');
    self::regla($r, $esNR && $v->gCamNRE() === null, '2600', 'gCamNRE', 'DE.gDtipDE');
    self::regla($r, !$esNR && $v->gCamNRE() !== null, '2601', 'gCamNRE', 'DE.gDtipDE');
    self::regla($r, ($esFE || $esAF) && $v->gCamCond() === null, '1500', 'gCamCond', 'DE.gDtipDE');
    self::regla($r, !($esFE || $esAF) && $v->gCamCond() !== null, '1501', 'gCamCond', 'DE.gDtipDE');
    self::regla($r, !$esNR && $v->gTotSub() === null, '2350', 'gTotSub', 'DE');
    self::regla($r, $esNR && $v->gTotSub() !== null, '2351', 'gTotSub', 'DE');
    self::regla($r, ($esAF || $esNC) && $v->gCamDEAsoc() === [], '2400', 'gCamDEAsoc', 'DE');

    $transp = $v->gTransp();
    self::regla($r, $esNR && $transp === null, '2100', 'gTransp', 'DE.gDtipDE');
    self::regla($r, $sinOperacion && $transp !== null, '2101', 'gTransp', 'DE.gDtipDE');
    if ($transp !== null) {
      $salida = isset($transp->gCamSal) ? $transp->gCamSal : null;
      $entrega = isset($transp->gCamEnt) ? $transp->gCamEnt : null;
      $vehiculos = isset($transp->gVehTras) ? $transp->gVehTras : null;
      $transportista = isset($transp->gCamTrans) ? $transp->gCamTrans : null;
      self::regla($r, $esNR && $salida === null, '2150', 'gCamSal', 'DE.gDtipDE.gTransp');
      self::regla($r, $sinOperacion && $salida !== null, '2151', 'gCamSal', 'DE.gDtipDE.gTransp');
      self::regla($r, $esNR && ($entrega === null || $entrega === []), '2200', 'gCamEnt', 'DE.gDtipDE.gTransp');
      self::regla($r, $sinOperacion && $entrega !== null && $entrega !== [], '2201', 'gCamEnt', 'DE.gDtipDE.gTransp');
      self::regla($r, $esNR && ($vehiculos === null || $vehiculos === []), '2250', 'gVehTras', 'DE.gDtipDE.gTransp');
      self::regla($r, $sinOperacion && $vehiculos !== null && $vehiculos !== [], '2251', 'gVehTras', 'DE.gDtipDE.gTransp');
      self::regla($r, $esNR && $transportista === null, '2300', 'gCamTrans', 'DE.gDtipDE.gTransp');
      self::regla($r, $sinOperacion && $transportista !== null, '2301', 'gCamTrans', 'DE.gDtipDE.gTransp');
    }

    $opeCom = $v->gOpeCom();
    $impuesto = $opeCom !== null && isset($opeCom->iTImp) ? (int) $opeCom->iTImp : null;
    foreach ($v->items() as $i => $item) {
      $ruta = 'DE.gDtipDE.gCamItem[' . ($i + 1) . ']';
      $valor = isset($item->gValorItem) ? $item->gValorItem : null;
      $iva = isset($item->gCamIVA) ? $item->gCamIVA : null;
      self::regla($r, !$esNR && $valor === null, '1850', 'gValorItem', $ruta);
      self::regla($r, $esNR && $valor !== null, '1851', 'gValorItem', $ruta);
      self::regla($r, !$esAF && !$esNR && $iva === null && in_array($impuesto, [1, 3, 4, 5], true), '1900', 'gCamIVA', $ruta);
      self::regla($r, ($esAF || $esNR) && $iva !== null, '1901', 'gCamIVA', $ruta);
      self::regla($r, $impuesto === 2 && $iva !== null, '1902', 'gCamIVA', $ruta);
    }

    $gen = $v->gCamGen();
    self::regla($r, $gen !== null && isset($gen->gCamCarg) && !$esFE && !$esNR, '2390', 'gCamCarg', 'DE.gCamGen');
  }

  /** Agrega el error del catálogo (mensaje del MT, campo y método de PKuatia) cuando la condición se cumple. */
  private static function regla(ResultadoValidacion $r, bool $condicion, string $codigo, string $elemento, string $ruta, mixed $valor = null): void
  {
    if (!$condicion)
      return;
    $info = CatalogoValidaciones::describir($codigo);
    $campo = $info?->id !== null ? preg_replace('/[a-z]$/', '', $info->id) : null;
    $metodo = $campo !== null ? CatalogoValidaciones::metodoPkuatia($campo) : null;
    $r->agregar(new ErrorValidacion(OrigenError::Regla, $info?->mensaje ?? "Validación $codigo del SIFEN.", $codigo, $campo, $elemento, $ruta, $valor,
      $metodo !== null ? "Ver $metodo." : null, null, $info !== null && $info->estado === 'AO'));
  }
}
