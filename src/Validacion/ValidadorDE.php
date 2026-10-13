<?php

namespace IonysDev\Pkuatia\Validacion;

use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasDeDescripciones;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasDeDocumentosAsociados;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasDeGrupos;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasDeItems;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasDelReceptor;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasDePagos;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasDeTotales;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasDeTransporte;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasEspecificas;
use IonysDev\Pkuatia\Validacion\Reglas\ReglasGenerales;

/**
 * Validador de reglas offline del DE (Fase C, pasos C9 y C10; decisión Q-C1). Devuelve un ResultadoValidacion con
 * un ErrorValidacion por problema: código con el que el SIFEN rechazaría el documento, campo del MT, elemento, ruta y
 * sugerencia. No serializa, no firma, no toca la red y no modifica el documento.
 *
 * - Completitud según el XSD: en cada grupo informado, los elementos con minOccurs = 1 (DE_v150.xsd, a través del
 *   catálogo de elementos de C5). Código 0160 (AE01): es lo que el SIFEN responde ante un XML que no cumple el
 *   esquema. Los campos que la librería completa al serializar o firmar no se exigen.
 * - Conjuntos de reglas del MT §12.4 (Validacion\Reglas): presencia de grupos por tipo de documento, descripciones
 *   que no corresponden al código, reglas generales (CDC, firma, timbrado, fechas, tipo de cambio, emisor, geografía),
 *   receptor, pagos, ítems (precios, descuentos e IVA por ítem, NT-013), totales, transporte, documentos asociados y
 *   campos específicos (compras públicas, nota de remisión, ciclos). Los mensajes son los del MT (catálogo) y la
 *   sugerencia, el método de PKuatia que informa el campo; los importes se recalculan con BCMath.
 */
final class ValidadorDE
{
  /** Elementos que la librería genera al serializar o firmar (toRDE, FirmarDE): no se exigen en la completitud. */
  private const GENERADOS = ['dDVId', 'dFecFirma', 'dSisFact', 'dVerFor', 'Signature', 'gCamFuFD', 'dCarQR', 'dInfAdic', 'gCamRDE'];
  /** Propiedades del modelo cuyo nombre difiere del elemento del XSD. */
  private const ALIAS = ['gOpeDE' => 'gOpeDe', 'gDtipDE' => 'gDtipDe'];
  /** Marca de un elemento que el modelo no almacena porque lo deriva al serializar (p. ej. dDesDepSal desde cDepSal). */
  private const DERIVADO = "\0derivado";
  /** @var list<class-string<Reglas\ConjuntoDeReglas>> en el orden en que se aplican */
  private const CONJUNTOS = [ReglasDeGrupos::class, ReglasDeDescripciones::class, ReglasGenerales::class, ReglasDelReceptor::class, ReglasDePagos::class,
    ReglasDeItems::class, ReglasDeTotales::class, ReglasDeTransporte::class, ReglasDeDocumentosAsociados::class, ReglasEspecificas::class];

  /**
   * @param DateTime|null $ahora Momento de referencia para las reglas de fechas; por defecto, ahora en la zona del SIFEN.
   */
  public static function validar(DocumentoElectronico|DE|RDE $documento, ?DateTime $ahora = null): ResultadoValidacion
  {
    $vista = VistaDocumento::desde($documento);
    $ahora ??= new DateTime('now', new DateTimeZone(Constants::SIFEN_TIMEZONE));
    $resultado = new ResultadoValidacion();
    self::revisar('tDE', $vista->raiz(), 'DE', $resultado);
    foreach (self::CONJUNTOS as $conjunto)
      $conjunto::aplicar($vista, $resultado, $ahora);
    return $resultado;
  }

  // --- Completitud ---------------------------------------------------------------------------------------------------

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
}
