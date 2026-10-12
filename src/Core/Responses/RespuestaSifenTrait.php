<?php

namespace IonysDev\Pkuatia\Core\Responses;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\CodigoResultadoWS;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;
use IonysDev\Pkuatia\Validacion\InfoValidacion;

/**
 * Implementación común de RespuestaSifen (Fase C, paso C6): describe el código a partir de getCodigo().
 */
trait RespuestaSifenTrait
{
  public function getCodigoResultado(): ?CodigoResultadoWS
  {
    return CodigoResultadoWS::fromAny($this->getCodigo());
  }

  public function getInfoValidacion(): ?InfoValidacion
  {
    $codigo = $this->getCodigo();
    return $codigo === null ? null : CatalogoValidaciones::describir($codigo);
  }

  /** Código entero o texto a cuatro dígitos con cero inicial; null si no hay código. */
  private static function codigoTexto(int|string|null $codigo): ?string
  {
    if ($codigo === null)
      return null;
    $texto = trim((string) $codigo);
    return $texto === '' ? null : str_pad($texto, 4, '0', STR_PAD_LEFT);
  }

  private static function fechaIso(?DateTime $fecha): ?string
  {
    return $fecha?->format(DATE_ATOM);
  }
}
