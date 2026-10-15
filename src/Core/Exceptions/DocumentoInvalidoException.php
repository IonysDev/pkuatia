<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

use IonysDev\Pkuatia\Validacion\ResultadoValidacion;

/**
 * Un documento no pasó la validación previa al envío (ResultadoValidacion::lanzarSiInvalido() o
 * Config::$validarXsdAntesDeEnviar). Lleva el resultado completo, con un error por problema.
 */
class DocumentoInvalidoException extends ValidacionException
{
  private ?ResultadoValidacion $resultado = null;

  public static function desde(ResultadoValidacion $resultado, string $mensaje): self
  {
    $errores = $resultado->getErrores();
    $detalle = $errores === [] ? '' : ': ' . count($errores) . ' error(es). ' . $errores[0];
    $e = new self($mensaje . $detalle);
    $e->resultado = $resultado;
    $e->contexto['errores'] = count($errores);
    $e->contexto['codigos'] = array_values(array_unique(array_filter(array_map(static fn ($x) => $x->codigoSifen, $errores))));
    return $e;
  }

  public function getResultado(): ?ResultadoValidacion
  {
    return $this->resultado;
  }
}
