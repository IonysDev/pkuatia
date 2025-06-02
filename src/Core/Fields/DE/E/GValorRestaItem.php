<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use IonysDev\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use IonysDev\Pkuatia\Utils\NumberStringFormatter;
use SimpleXMLElement;

/**
 * Nodo Id:     EA001 
 * Nombre:      gValorRestaItem
 * Descripción: Campos que describen los descuentos, anticipos valor total por ítem.
 * Nodo Padre:  E720
 */

class GValorRestaItem extends BaseSifenField
{
  public String $dDescItem;       // EA002 - 1-15p(0-8) - 0-1 - Descuento particular sobre el precio unitario por ítem (incluidos impuestos)
  public String $dPorcDesIt;      // EA003 - 1-3p(0-8)  - 0-1 - Porcentaje de descuento particular por ítem
  public String $dDescGloItem;    // EA004 - 1-15p(0-8) - 0-1 - Descuento global sobre el precio unitario por ítem (incluidos impuestos)
  public String $dAntPreUniIt;    // EA006 - 1-15p(0-8) - 0-1 - Anticipo particular sobre el precio unitario por ítem (incluidos impuestos)
  public String $dAntGloPreUniIt; // EA007 - 1-15p(0-8) - 0-1 - Anticipo global sobre el  precio unitario por ítem  (incluidos impuestos)
  public String $dTotOpeItem;     // EA008 - 1-15p(0-8) - 1-1 - Valor total de la operación por ítem 
  public String $dTotOpeGs;       // EA009 - 1-15p(0-8) - 0-1 - Valor total de la operación por ítem en guaraníes

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dDescItem
   *
   * @param String $dDescItem
   *
   * @return self
   */
  public function setDDescItem(String $dDescItem): self
  {
    if(!ValueValidations::isValidStringDecimal($dDescItem, 15, 0))
    {
      throw new \Exception("Valor inválido de dDescItem: $dDescItem");
    }
    $this->dDescItem = $dDescItem;
    return $this;
  }

  /**
   * Establece el valor de dPorcDesIt
   *
   * @param String $dPorcDesIt
   *
   * @return self
   */
  public function setDPorcDesIt(String $dPorcDesIt): self
  {
    if(!ValueValidations::isValidStringDecimal($dPorcDesIt, 3, 0))
    {
      throw new \Exception("Valor inválido de dPorcDesIt: $dPorcDesIt");
    }
    $this->dPorcDesIt = $dPorcDesIt;
    return $this;
  }


  /**
   * Establece el valor de dDescGloItem
   *
   * @param String $dDescGloItem
   *
   * @return self
   */
  public function setDDescGloItem(String $dDescGloItem): self
  {
    if(!ValueValidations::isValidStringDecimal($dDescGloItem, 15, 0))
    {
      throw new \Exception("Valor inválido de dDescGloItem: $dDescGloItem");
    }
    $this->dDescGloItem = $dDescGloItem;
    return $this;
  }


  /**
   * Establece el valor de dAntPreUniIt
   *
   * @param String $dAntPreUniIt
   *
   * @return self
   */
  public function setDAntPreUniIt(String $dAntPreUniIt): self
  {
    if(!ValueValidations::isValidStringDecimal($dAntPreUniIt, 15, 0))
    {
      throw new \Exception("Valor inválido de dAntPreUniIt: $dAntPreUniIt");
    }
    $this->dAntPreUniIt = $dAntPreUniIt;
    return $this;
  }


  /**
   * Establece el valor de dAntGloPreUniIt
   *
   * @param String $dAntGloPreUniIt
   *
   * @return self
   */
  public function setDAntGloPreUniIt(String $dAntGloPreUniIt): self
  {
    if(!ValueValidations::isValidStringDecimal($dAntGloPreUniIt, 15, 0))
    {
      throw new \Exception("Valor inválido de dAntGloPreUniIt: $dAntGloPreUniIt");
    }
    $this->dAntGloPreUniIt = $dAntGloPreUniIt;
    return $this;
  }


  /**
   * Establece el valor de dTotOpeItem
   *
   * @param String $dTotOpeItem
   *
   * @return self
   */
  public function setDTotOpeItem(String $dTotOpeItem): self
  {
    if(!ValueValidations::isValidStringDecimal($dTotOpeItem, 15, 0))
    {
      throw new \Exception("Valor inválido de dTotOpeItem: $dTotOpeItem");
    }
    $this->dTotOpeItem = $dTotOpeItem;
    return $this;
  }

  /**
   * Establece el valor de dTotOpeGs
   *
   * @param String $dTotOpeGs
   *
   * @return self
   */
  public function setDTotOpeGs(String $dTotOpeGs): self
  {
    if(!ValueValidations::isValidStringDecimal($dTotOpeGs, 15, 0))
    {
      throw new \Exception("Valor inválido de dTotOpeGs: $dTotOpeGs");
    }
    $this->dTotOpeGs = $dTotOpeGs;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dDescItem
   *
   * @return String
   */
  public function getDDescItem(): String
  {
    if(!isset($this->dDescItem))
    {
      return '0';
    }
    return $this->dDescItem;
  }

  public function getFormattedDDescItem(int $precision = 8): String
  {
    $rounded = bcadd($this->getDDescItem(), '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }

  /**
   * Obtiene el valor de dPorcDesIt
   *
   * @return String
   */

  public function getDPorcDesIt(): String
  {
    if(!isset($this->dPorcDesIt))
    {
      return '0';
    }
    return $this->dPorcDesIt;
  }

  /**
   * Obtiene el valor de dDescGloItem
   *
   * @return String
   */
  public function getDDescGloItem(): String
  {
    if(!isset($this->dDescGloItem))
    {
      return '0';
    }
    return $this->dDescGloItem;
  }

  public function getFormattedDDescGloItem(int $precision = 8): String
  {
    $rounded = bcadd($this->dDescGloItem, '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }

  public function getSumaDescuentosUnitarios(int $precision = 8): String
  {
    return bcadd($this->getDDescItem(), $this->getDDescGloItem(), $precision);
  }

  public function getFormattedSumaDescuentosUnitarios(int $precision = 8): String
  {
    $rounded = bcadd($this->getSumaDescuentosUnitarios(), '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }



  /**
   * Obtiene el valor de dAntPreUniIt
   *
   * @return String
   */
  public function getDAntPreUniIt(): String
  {
    if(!isset($this->dAntPreUniIt))
    {
      return '0';
    }
    return $this->dAntPreUniIt;
  }

  public function getFormattedDAntPreUniIt(int $precision = 8): String
  {
    $rounded = bcadd($this->dAntPreUniIt, '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }


  /**
   * Obtiene el valor de dAntGloPreUniIt
   *
   * @return String
   */
  public function getDAntGloPreUniIt(): String
  {
    if(!isset($this->dAntGloPreUniIt))
    {
      return '0';
    }
    return $this->dAntGloPreUniIt;
  }

  public function getFormattedDAntGloPreUniIt(int $precision = 8): String
  {
    $rounded = bcadd($this->dAntGloPreUniIt, '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }

  /**
   * Obtiene el valor de dTotOpeItem
   *
   * @return String
   */

  public function getDTotOpeItem(): String
  {
    return $this->dTotOpeItem;
  }

  public function getFormattedDTotOpeItem(int $precision = 8): String
  {
    $rounded = bcadd($this->dTotOpeItem, '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }

  /**
   * Obtiene el valor de dTotOpeGs
   *
   * @return String
   */

  public function getDTotOpeGs(): String
  {
    return $this->dTotOpeGs;
  }

  public function getFormattedDTotOpeGs(int $precision = 8): String
  {
    $rounded = bcadd($this->dTotOpeGs, '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////


  /**
   * Instancia un objeto GValorRestaItem desde un SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return GValorRestaItem
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): GValorRestaItem
  {
    if(strcmp($node->getName(), 'gValorRestaItem') != 0)
    {
      throw new \Exception("El nodo '" . $node->getName() . "' no corresponde a gValorRestaItem");
    }
    $res = new GValorRestaItem();
    if(isset($node->dDescItem))
    {
      $res->setDDescItem(strval($node->dDescItem));
    }
    if(isset($node->dPorcDesIt))
    {
      $res->setDPorcDesIt(strval($node->dPorcDesIt));
    }
    if(isset($node->dDescGloItem))
    {
      $res->setDDescGloItem(strval($node->dDescGloItem));
    }
    if(isset($node->dAntPreUniIt))
    {
      $res->setDAntPreUniIt(strval($node->dAntPreUniIt));
    }
    if(isset($node->dAntGloPreUniIt))
    {
      $res->setDAntGloPreUniIt(strval($node->dAntGloPreUniIt));
    }
    $res->setDTotOpeItem(strval($node->dTotOpeItem));
    if(isset($node->dTotOpeGs))
    {
      $res->setDTotOpeGs(strval($node->dTotOpeGs));
    }
    return $res;
  }

  /**
   * Convierte este GValorRestaItem en un DOMElement que puede ser insertado en el DOMDocument especificado.
   * 
   * @param  DOMDocument $doc Documento DOM que creará el DOMElement sin insertarlo.
   *
   * @return DOMElement El DOMElement creado.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gValorRestaItem');
    if(isset($this->dDescItem))
      $res->appendChild(new DOMElement('dDescItem', $this->dDescItem));
    if(isset($this->dPorcDesIt))
      $res->appendChild(new DOMElement('dPorcDesIt', $this->getDPorcDesIt()));
    if(isset($this->dDescGloItem))
      $res->appendChild(new DOMElement('dDescGloItem', $this->getDDescGloItem()));
    if(isset($this->dAntPreUniIt))
      $res->appendChild(new DOMElement('dAntPreUniIt', $this->getDAntPreUniIt()));
    if(isset($this->dAntGloPreUniIt))
      $res->appendChild(new DOMElement('dAntGloPreUniIt', $this->getDAntGloPreUniIt()));
    $res->appendChild(new DOMElement('dTotOpeItem', $this->getDTotOpeItem()));
    if(isset($this->dTotOpeGs))
      $res->appendChild(new DOMElement('dTotOpeGs', $this->getDTotOpeGs()));
    return $res;
  }
  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GValorRestaItem();
    if( isset($object->dDescItem))
    {
      $res->setDDescItem(strval($object->dDescItem));
    }
    if( isset($object->dPorcDesIt))
    {
      $res->setDPorcDesIt(strval($object->dPorcDesIt));
    }
    if( isset($object->dDescGloItem))
    {
      $res->setDDescGloItem(strval($object->dDescGloItem));
    }

    if( isset($object->dAntPreUniIt))
    {
      $res->setDAntPreUniIt(strval($object->dAntPreUniIt));
    }

    if( isset($object->dAntGloPreUniIt))
    {
      $res->setDAntGloPreUniIt(strval($object->dAntGloPreUniIt));
    }

    if( isset($object->dTotOpeItem))
    {
      $res->setDTotOpeItem(strval($object->dTotOpeItem));
    }

    if( isset($object->dTotOpeGs))
    {
      $res->setDTotOpeGs(strval($object->dTotOpeGs));
    }
    
    return $res;
  }

  /**
   * Instancia un objeto GValorRestaItem a partir de un DOMElement que lo representa.
   * 
   * @param  DOMElement $node
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gValorRestaItem') != 0)
        throw new \Exception('[GValorRestaItem] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new self();
    if($node->getElementsByTagName('dDescItem')->length > 0)
      $res->setDDescItem(trim($node->getElementsByTagName('dDescItem')->item(0)->nodeValue));
    if($node->getElementsByTagName('dPorcDesIt')->length > 0)
      $res->setDPorcDesIt(trim($node->getElementsByTagName('dPorcDesIt')->item(0)->nodeValue));
    if($node->getElementsByTagName('dDescGloItem')->length > 0)
      $res->setDDescGloItem(trim($node->getElementsByTagName('dDescGloItem')->item(0)->nodeValue));
    if($node->getElementsByTagName('dAntPreUniIt')->length > 0)
      $res->setDAntPreUniIt(trim($node->getElementsByTagName('dAntPreUniIt')->item(0)->nodeValue));
    if($node->getElementsByTagName('dAntGloPreUniIt')->length > 0)
      $res->setDAntGloPreUniIt(trim($node->getElementsByTagName('dAntGloPreUniIt')->item(0)->nodeValue));
    $res->setDTotOpeItem(trim($node->getElementsByTagName('dTotOpeItem')->item(0)->nodeValue));
    if($node->getElementsByTagName('dTotOpeGs')->length > 0)
      $res->setDTotOpeGs(trim($node->getElementsByTagName('dTotOpeGs')->item(0)->nodeValue));
    return $res;
  }

}
