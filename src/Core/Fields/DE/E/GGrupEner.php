<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E791 
 * Nombre:      gGrupoEner
 * Descripción: Grupo del sector de energía eléctrica 
 * Nodo Padre:  E790
 */
class GGrupEner
{
  public String $dNroMed; // E792 - 1-50   - 0-1 - Número de medidor
  public int    $dActiv;  // E793 - 2      - 0-1 - Código de actividad
  public String $dCateg;  // E794 - 3      - 0-1 - Código de categoría
  public String $dLecAnt; // E795 - 1-11p2 - 0-1 - Lectura anterior (decimal BCMath)
  public String $dLecAct; // E796 - 1-11p2 - 0-1 - Lectura actual (decimal BCMath)
  public String $dConKwh; // E797 - 1-11p2 - 0-1 - Consumo en Kwh (decimal BCMath) - Corresponde a  la diferencia  entre E796-E795

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dNroMed (Número de medidor)
   *
   * @param String $dNroMed
   *
   * @return self
   */
  public function setDNroMed(String $dNroMed): self
  {
    $this->dNroMed = $dNroMed;
    return $this;
  }


  /**
   * Establece el valor de dActiv (Código de actividad)
   *
   * @param int $dActiv
   *
   * @return self
   */
  public function setDActiv(int $dActiv): self
  {
    $this->dActiv = $dActiv;
    return $this;
  }


  /**
   * Establece el valor de dCateg (Código de categoría)
   *
   * @param String $dCateg
   *
   * @return self
   */
  public function setDCateg(String $dCateg): self
  {
    $this->dCateg = $dCateg;
    return $this;
  }


  /**
   * Establece el valor de dLecAnt (Lectura anterior)
   *
   * @param String $dLecAnt
   *
   * @return self
   */
  public function setDLecAnt(String $dLecAnt): self
  {
    if(!ValueValidations::isValidStringDecimal($dLecAnt, 11, 0))
      throw new \Exception('[GGrupEner] dLecAnt debe ser un número decimal con 2 decimales y máximo 11 dígitos enteros: ' . $dLecAnt, 1);
    $this->dLecAnt = $dLecAnt;
    return $this;
  }


  /**
   * Establece el valor de dLecAct (Lectura actual)
   *
   * @param String $dLecAct
   *
   * @return self
   */
  public function setDLecAct(String $dLecAct): self
  {
    if(!ValueValidations::isValidStringDecimal($dLecAct, 11, 0))
      throw new \Exception('[GGrupEner] dLecAct debe ser un número decimal con 2 decimales y máximo 11 dígitos enteros: ' . $dLecAct, 1);
    $this->dLecAct = $dLecAct;
    return $this;
  }

  /**
   * Establece el valor de dConKwh (Consumo en Kwh)
   *
   * @param String $dConKwh
   *
   * @return self
   */
  public function setDConKwh(String $dConKwh): self
  {
    if(!ValueValidations::isValidStringDecimal($dConKwh, 11, 0))
      throw new \Exception('[GGrupEner] dLecAct debe ser un número decimal con 2 decimales y máximo 11 dígitos enteros: ' . $dConKwh, 1);
    $this->dConKwh = $dConKwh;
    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  // Getter
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve el valor de dNroMed (Número de medidor)
   *
   * @return String
   */
  public function getDNroMed(): String
  {
    return $this->dNroMed;
  }

  /**
   * Devuelve el valor de dActiv (Código de actividad)
   *
   * @return int
   */
  public function getDActiv(): int
  {
    return $this->dActiv;
  }

  /**
   * Devuelve el valor de dCateg (Código de categoría)
   *
   * @return String
   */
  public function getDCateg(): String
  {
    return $this->dCateg;
  }

  /**
   * Devuelve el valor de dLecAnt (Lectura anterior)
   *
   * @return String
   */
  public function getDLecAnt(): String
  {
    return $this->dLecAnt;
  }

  /**
   * Devuelve el valor de dLecAct (Lectura actual)
   *
   * @return String
   */
  public function getDLecAct(): String
  {
    return $this->dLecAct;
  }

  /**
   *  Devuelve el valor de dConKwh (Consumo en Kwh)
   *
   * @return String
   */
  public function getDConKwh(): String
  {
    return $this->dLecAct - $this->dLecAct;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////
  
  /**
   * Instancia un objeto GGrupEner a partir de un SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gGrupEner') != 0)
      throw new \Exception('[GGrupEner] El nombre del nodo no corresponde a gGrupEner: ' . $node->getName(), 1);
    $res = new GGrupEner();
    if(isset($node->dNroMed))
    {
      $res->setDNroMed($node->dNroMed);
    }
    if(isset($node->dActiv))
    {
      $res->setDActiv($node->dActiv);
    }
    if(isset($node->dCateg))
    {
      $res->setDCateg($node->dCateg);
    }
    if(isset($node->dLecAnt))
    {
      $res->setDLecAnt($node->dLecAnt);
    }
    if(isset($node->dLecAct))
    {
      $res->setDLecAct($node->dLecAct);
    }
    if(isset($node->dConKwh))
    {
      $res->setDConKwh($node->dConKwh);
    }
    return $res;
  }

  /**
   * Instancia un objeto GGrupEner a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   *
   * @param stdClass $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GGrupEner();
    if(isset($object->dNroMed))
    {
      $res->setDNroMed($object->dNroMed);
    }
    if(isset($object->dActiv))
    {
      $res->setDActiv($object->dActiv);
    }
    if(isset($object->dCateg))
    {
      $res->setDCateg($object->dCateg);
    }
    if(isset($object->dLecAnt))
    {
      $res->setDLecAnt($object->dLecAnt);
    }
    if(isset($object->dLecAct))
    {
      $res->setDLecAct($object->dLecAct);
    }
    if(isset($object->dConKwh))
    {
      $res->setDConKwh($object->dConKwh);
    }
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GGrupEner en un DOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement("gGrupEner");
    if(isset($this->dNroMed))
      $res->appendChild(new DOMElement('dNroMed', $this->getDNroMed()));
    if(isset($this->dActiv))
      $res->appendChild(new DOMElement('dActiv', $this->getDActiv()));
    if(isset($this->dCateg))
      $res->appendChild(new DOMElement('dCateg', $this->getDCateg()));
    if(isset($this->dLecAnt))
      $res->appendChild(new DOMElement('dLecAnt', $this->getDLecAnt()));
    if(isset($this->dLecAct))
      $res->appendChild(new DOMElement('dLecAct', $this->getDLecAct()));
    if(isset($this->dConKwh))
      $res->appendChild(new DOMElement('dConKwh', $this->getDConKwh()));
    return $res;
  }

  /**
   * Convierte este GGrupEner en un String XML
   * 
   * @return String
   */
  public function toXMLString(): String
  {
    $domElement = $this->toDOMElement(new DOMDocument());
    $xmlString = $domElement->ownerDocument->saveXML($domElement);
    if(!$xmlString)
      throw new \Exception('[GGrupEner] Error al convertir el objeto a XML.');
    return $xmlString;
  }

  ///////////////////////////////////////////////////////////////////////
  // Cálculos
  ///////////////////////////////////////////////////////////////////////

  /**
   * Calcula el consumo en Kwh (dConKwh)
   *
   * @return String
   */
  public function calcularDConKwh(): String
  {
    return bcsub($this->getDLecAct(), $this->getDLecAnt(), 2);
  }
  
}
