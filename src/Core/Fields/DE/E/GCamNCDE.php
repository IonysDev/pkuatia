<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use IonysDev\Pkuatia\Core\Constants\MotEmi;

/**
 * Nodo Id:     E400
 * Nombre:      GCamNCDE
 * Descripción: Campos que componen la Nota de Crédito/Débito Electrónica NCE-NDE (E400-E499)
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico 
 */
class GCamNCDE extends BaseSifenField
{
  

                              // Id - Longitud - Ocurrencia - Descripción
  public int    $iMotEmi;     // E401 - 1-2  - 1-1 - Motivo de emisión
  public String $dDesMotEmi;  // E402 - 6-30 - 1-1 - Descripción del motivo de emisión

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iMotEmi (Motivo de emisión) y a la vez establece el valor de dDesMotEmi (Descripción del motivo de emisión)
   *
   * @param int $iMotEmi Valor de iMotEmi que debe estar entre 1 y 8.
   *
   * @return self Retorna una instancia del objeto para encadenar métodos.
   */
  public function setIMotEmi(int|MotEmi $iMotEmi): self
  {
    $mEmi = $iMotEmi instanceof MotEmi ? $iMotEmi->value : $iMotEmi;
    $this->dDesMotEmi = MotEmi::getDescripcion($mEmi);
    $this->iMotEmi = $mEmi;
    return $this;
  }

  /**
   * Establece el valor de dDesMotEmi (Descripción del motivo de emisión).
   * NO SE RECOMIENDA USAR ESTE MÉTODO. Se recomienda usar el método setIMotEmi(int $iMotEmi) que establece el valor de iMotEmi y a la vez establece el valor de dDesMotEmi.
   * 
   * @param String $dDesMotEmi Descripción del motivo de emisión
   * 
   * @return self Retorna una instancia del objeto para encadenar métodos.
   */
  public function setDDesMotEmi(String $dDesMotEmi): self
  {
    $this->dDesMotEmi = $dDesMotEmi;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iMotEmi (Motivo de emisión)
   *
   * @return int El valor de iMotEmi (E401)
   */
  public function getIMotEmi(): int
  {
    return $this->iMotEmi;
  }

  /**
   * Obtiene el valor de dDesMotEmi (Descripción del motivo de emisión)
   *
   * @return String El valor de dDesMotEmi (E402)
   */
  public function getDDesMotEmi(): String
  {
    return $this->dDesMotEmi;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto del tipo GCamNCDE a partir de un DOMElement que representa el nodo XML del objeto GCamNCDE.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GCamNCDE.
   * 
   * @return self Objeto GCamNCDE instanciado.
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamNCDE') != 0)
      throw new \Exception('[GCamNCDE] El nombre del nodo no corresponde a gCamNCDE: ' . $node->nodeName, 1);
    $res = new GCamNCDE();
    $res->iMotEmi = intval($node->getElementsByTagName('iMotEmi')->item(0)->nodeValue);
    $res->dDesMotEmi = strval($node->getElementsByTagName('dDesMotEmi')->item(0)->nodeValue);
    return $res;
  }

  /**
   * Instancia un objeto del tipo GCamNCDE a partir de un objeto stdClass recibido como respuesta desde el SIFEN 
   * que representa el nodo XML del objeto GCamNCDE.
   *
   * @param  mixed $object Objeto stdClass que representa el nodo XML del objeto GCamNCDE.
   *
   *  @return self Objeto GCamNCDE instanciado.
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GCamNCDE();
    if(isset($object->iMotEmi))
    {
      $res->iMotEmi = intval($object->iMotEmi);
      $res->dDesMotEmi = strval($object->dDesMotEmi);
    }
    return $res;
  }

    /**
     * Crea una nueva instancia de GCamNCDE a partir de un objeto SimpleXMLElement.
     *
     * @param \SimpleXMLElement $node
     *
     * @return self
     *
     * @throws \Exception
     */
  public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gCamNCDE') != 0)
    {
      throw new \Exception("El nodo '" . $node->getName() . "' no corresponde a 'gCamNCDE'");
    }
    $res = new GCamNCDE();
    $res->iMotEmi = intval($node->iMotEmi);
    $res->dDesMotEmi = strval($node->dDesMotEmi);
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este objeto GCamNCDE a un DOMElement mediante el DOMDocument proporcionado.
   * 
   * @param DOMDocument $doc - Documento DOM donde se creará el elemento.
   *
   * @return DOMElement El elemento DOM que representa este objeto GCamNCDE.
   */
  public  function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamNCDE');
    $res->appendChild(new DOMElement('iMotEmi', $this->getIMotEmi()));
    $res->appendChild(new DOMElement('dDesMotEmi', $this->getDDesMotEmi()));
    return $res;
  }
}
