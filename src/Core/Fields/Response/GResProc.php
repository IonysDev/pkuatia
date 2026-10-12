<?php

namespace IonysDev\Pkuatia\Core\Fields\Response;

use DOMElement;
use SimpleXMLElement;
use stdClass;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;
use IonysDev\Pkuatia\Core\Constants\CodigoResultadoWS;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;
use IonysDev\Pkuatia\Validacion\InfoValidacion;

/**
 * ID:PP05 Grupo Resultado de Procesamiento PADRE:PP01 
 */
class GResProc
{
  public const COD_RES_ACEPTADO = 260;

                          // ID - DESC - LONG - OCURRENCIA
  public String $dCodRes; // PP052 - Código del resultado de procesamiento - 4 - 1-1
  public String $dMsgRes; // PP053 - Mensaje del resultado de procesamiento - 1-255 - 1-1

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dCodRes
   *
   * @param int $dCodRes
   *
   * @return self
   */
  public function setDCodRes(String $dCodRes): self
  {
    $this->dCodRes = $dCodRes;

    return $this;
  }


  /**
   * Establece el valor de dMsgRes
   *
   * @param String $dMsgRes
   *
   * @return self
   */
  public function setDMsgRes(String $dMsgRes): self
  {
    $this->dMsgRes = $dMsgRes;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dCodRes
   *
   * @return int
   */
  public function getDCodRes(): String
  {
    return $this->dCodRes;
  }

  /**
   * Obtiene el valor de dMsgRes
   *
   * @return String
   */
  public function getDMsgRes(): String
  {
    return $this->dMsgRes;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////  
  
  /**
   * Instancia un GResProc a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   * 
   * @param stdClass $object
   * 
   * @return GResProc
   */
  public static function FromSifenResponseObject($object): GResProc
  {
    $res = new GResProc();
    $res->setDCodRes($object->dCodRes);
    $res->setDMsgRes($object->dMsgRes);
    return $res;
  }

  /**
   * Instancia un GResProc a partir de un SimpleXMLElement (PP05: dCodRes y dMsgRes, ambos 1-1). No existía
   * hasta 0.2.0: RProtDe::FromSimpleXMLElement lo invocaba y fallaba con Error (PK-25).
   *
   * @param SimpleXMLElement $node Nodo gResProc.
   *
   * @return GResProc
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): GResProc
  {
    if (strcmp($node->getName(), 'gResProc') != 0)
      throw new ValidacionException('[GResProc] El nombre del nodo no corresponde a gResProc: ' . $node->getName());
    if (!isset($node->dCodRes) || !isset($node->dMsgRes))
      throw new ValidacionException('[GResProc] gResProc debe contener dCodRes y dMsgRes.');
    $res = new GResProc();
    $res->setDCodRes((string) $node->dCodRes);
    $res->setDMsgRes((string) $node->dMsgRes);
    return $res;
  }

  // --- Fase C (C6): lectura del código -----------------------------------------------------------------------------

  /** Código como texto de cuatro dígitos con cero inicial ("0260"), tal como lo compara CodigoResultadoWS. */
  public function getCodigo(): string
  {
    return str_pad(trim($this->dCodRes ?? ''), 4, '0', STR_PAD_LEFT);
  }

  public function getMensaje(): string
  {
    return $this->dMsgRes ?? '';
  }

  /** El código como caso del enum, o null si no es un código de web service (p. ej. una validación del DE). */
  public function getCodigoResultado(): ?CodigoResultadoWS
  {
    return CodigoResultadoWS::fromAny($this->getCodigo());
  }

  /** Aprobación según el MT: 0260, 0300, 0362, 0422, 0502, 0520 o 0600. */
  public function esAprobacion(): bool
  {
    return $this->getCodigoResultado()?->esAprobacion() ?? false;
  }

  /** Código de validación del DE (1000-2650, MT §12.4). */
  public function esValidacionDE(): bool
  {
    $n = (int) $this->getCodigo();
    return $n >= 1000 && $n < 4000;
  }

  /** Código de validación de un evento (4000-4499, MT §11.6). */
  public function esValidacionEvento(): bool
  {
    $n = (int) $this->getCodigo();
    return $n >= 4000 && $n < 5000;
  }

  /** Descripción del código según el catálogo del MT (campo, regla, método de PKuatia), o null. */
  public function getInfoValidacion(): ?InfoValidacion
  {
    return CatalogoValidaciones::describir($this->getCodigo());
  }
}
