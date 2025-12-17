<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DOMDocument;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use DOMElement;

/**
 * ID:E920
 *Campos que identifican el local de salida de las mercaderías 
 *PADRE:E900 
 */
class GCamSal
{
  public String $dDirLocSal; //E921 Dirección del local de salida
  public ?int $dNumCasSal; //E922 Número de casa de salida
  public String $dComp1Sal; //E923 Complemento de dirección 1 salida
  public String $dComp2Sal; //E924 Complemento de dirección 2 salida
  public ?int $cDepSal; ///E925 Código del departamento del local de salida
  public ?int $cDisSal; //E927 Código del distrito del local de salida
  public ?int $cCiuSal; //E929 Código de la ciudad del local de salida
  public String $dTelSal; /// E931 Teléfono de contacto del local de salida

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////
  /**
   * Establece el valor de dDirLocSal
   *
   * @param String $dDirLocSal
   *
   * @return self
   */
  public function setDDirLocSal(String $dDirLocSal): self
  {
    $this->dDirLocSal = $dDirLocSal;

    return $this;
  }


  /**
   * Establece el valor de dNumCasSal
   *
   * @param int $dNumCasSal
   *
   * @return self
   */
  public function setDNumCasSal(int $dNumCasSal): self
  {
    $this->dNumCasSal = $dNumCasSal;

    return $this;
  }


  /**
   * Establece el valor de dComp1Sal
   *
   * @param String $dComp1Sal
   *
   * @return self
   */
  public function setDComp1Sal(String $dComp1Sal): self
  {
    $this->dComp1Sal = $dComp1Sal;

    return $this;
  }


  /**
   * Establece el valor de dComp2Sal
   *
   * @param String $dComp2Sal
   *
   * @return self
   */
  public function setDComp2Sal(String $dComp2Sal): self
  {
    $this->dComp2Sal = $dComp2Sal;

    return $this;
  }


  /**
   * Establece el valor de cDepSal
   *
   * @param int $cDepSal
   *
   * @return self
   */
  public function setCDepSal(int $cDepSal): self
  {
    $this->cDepSal = $cDepSal;

    return $this;
  }


  /**
   * Establece el valor de cDisSal
   *
   * @param int $cDisSal
   *
   * @return self
   */
  public function setCDisSal(int $cDisSal): self
  {
    $this->cDisSal = $cDisSal;

    return $this;
  }


  /**
   * Establece el valor de cCiuSal
   *
   * @param int $cCiuSal
   *
   * @return self
   */
  public function setCCiuSal(int $cCiuSal): self
  {
    $this->cCiuSal = $cCiuSal;

    return $this;
  }


  /**
   * Establece el valor de dTelSal
   *
   * @param String $dTelSal
   *
   * @return self
   */
  public function setDTelSal(String $dTelSal): self
  {
    $this->dTelSal = $dTelSal;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dDirLocSal
   *
   * @return String
   */
  public function getDDirLocSal(): String
  {
    return $this->dDirLocSal;
  }

  /**
   * Obtiene el valor de dNumCasSal
   *
   * @return int
   */
  public function getDNumCasSal(): int
  {
    return $this->dNumCasSal;
  }

  /**
   * Obtiene el valor de dComp1Sal
   *
   * @return String
   */
  public function getDComp1Sal(): String
  {
    return $this->dComp1Sal;
  }

  /**
   * Obtiene el valor de dComp2Sal
   *
   * @return String
   */
  public function getDComp2Sal(): String
  {
    return $this->dComp2Sal;
  }

  /**
   * Obtiene el valor de cDepSal
   *
   * @return int
   */
  public function getCDepSal(): int
  {
    return $this->cDepSal;
  }

  /**
   * E926 
   *Descripción del departamento del local de salida
   *
   * @return String
   */
  public function getDDesDepSal(): String
  {
    return DepartamentoMapping::getDepName(strval($this->cDepSal));
  }

  /**
   * Obtiene el valor de cDisSal
   *
   * @return int
   */
  public function getCDisSal(): int
  {
    return $this->cDisSal;
  }

  /**
   * E928 Descripción de distrito del local de salida
   *
   * @return String
   */
  public function getDDesDisSal(): String
  {
    return PyGeoCodesMapping::getDistName(strval($this->cDisSal));
  }

  /**
   * Obtiene el valor de cCiuSal
   *
   * @return int
   */
  public function getCCiuSal(): int
  {
    return $this->cCiuSal;
  }


  /**
   * E930 Descripción de ciudad del local de salida
   *
   * @return String
   */
  public function getDDesCiuSal(): String
  {
    return PyGeoCodesMapping::getCiudName(strval($this->cCiuSal));
  }

  /**
   * Obtiene el valor de dTelSal
   *
   * @return String
   */
  public function getDTelSal(): String
  {
    return $this->dTelSal;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element  
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamSal');

    $res->appendChild(new DOMElement('dDirLocSal', $this->getDDirLocSal()));

    if (isset($this->dNumCasSal)) {
      $res->appendChild(new DOMElement('dNumCasSal', $this->getDNumCasSal()));
    } else {
      $res->appendChild(new DOMElement('dNumCasSal', 0));
    }

    if (isset($this->dComp1Sal))
      $res->appendChild(new DOMElement('dComp1Sal', $this->getDComp1Sal()));
    
    if (isset($this->dComp2Sal))
      $res->appendChild(new DOMElement('dComp2Sal', $this->getDComp2Sal()));

    $res->appendChild(new DOMElement('cDepSal', $this->getCDisSal()));
    $res->appendChild(new DOMElement('dDesDepSal', $this->getCDepSal()));

    if (isset($this->cDisSal))
      $res->appendChild(new DOMElement('cDisSal', $this->getCDisSal()));

    if (isset($this->cDisdDesDisSalSal))
      $res->appendChild(new DOMElement('dDesDisSal', $this->getDDesDisSal()));
      
    $res->appendChild(new DOMElement('cCiuSal', $this->getCCiuSal()));
    $res->appendChild(new DOMElement('dDesCiuSal', $this->getDDesCiuSal()));

    if (isset($this->dTelSal))
      $res->appendChild(new DOMElement('dTelSal', $this->getDTelSal()));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCamSal
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamSal
  // {
  //   if (strcmp($xml->tagName, 'gCamSal') === 0 && $xml->childElementCount == 8) {
  //     $res = new GCamSal();
  //     $res->setDDirLocSal($xml->getElementsByTagName('dDirLocSal')->item(0)->nodeValue);
  //     $res->setDNumCasSal(intval($xml->getElementsByTagName('dNumCasSal')->item(0)->nodeValue));
  //     $res->setDComp1Sal($xml->getElementsByTagName('dComp1Sal')->item(0)->nodeValue);
  //     $res->setDComp1Sal($xml->getElementsByTagName('dComp2Sal')->item(0)->nodeValue);
  //     $res->setCDepSal(intval($xml->getElementsByTagName('cDepSal')->item(0)->nodeValue));
  //     $res->setCDisSal(intval($xml->getElementsByTagName('cDisSal')->item(0)->nodeValue));
  //     $res->setCCiuSal(intval($xml->getElementsByTagName('cDiuSal')->item(0)->nodeValue));
  //     $res->setDTelSal($xml->getElementsByTagName('dTelSal')->item(0)->nodeValue);
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  /**
   * Instancia un objeto GCamSal a partir de un DOMElement que representa el nodo XML del objeto.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto.
   * 
   * @return self Objeto instanciado.
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamSal') != 0)
      throw new \Exception('[GCamSal] El nombre del nodo no corresponde a gCamSal: ' . $node->nodeName);
    $res = new GCamSal();
    
    if($node->getElementsByTagName('dDirLocSal')->length > 0)
      $res->setDDirLocSal($node->getElementsByTagName('dDirLocSal')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dNumCasSal')->length > 0)
      $res->setDNumCasSal(intval($node->getElementsByTagName('dNumCasSal')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('dComp1Sal')->length > 0)
      $res->setDComp1Sal($node->getElementsByTagName('dComp1Sal')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dComp2Sal')->length > 0)
      $res->setDComp2Sal($node->getElementsByTagName('dComp2Sal')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('cDepSal')->length > 0)
      $res->setCDepSal(intval($node->getElementsByTagName('cDepSal')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('cDisSal')->length > 0)
      $res->setCDisSal(intval($node->getElementsByTagName('cDisSal')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('cCiuSal')->length > 0)
      $res->setCCiuSal(intval($node->getElementsByTagName('cCiuSal')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('dTelSal')->length > 0)
      $res->setDTelSal($node->getElementsByTagName('dTelSal')->item(0)->nodeValue);
    
    return $res;
  }

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GCamSal();
    if(isset($object->dDirLocSal)){
      $res->setDDirLocSal($object->dDirLocSal);
    }
    if(isset($object->dNumCasSal)){
      $res->setDNumCasSal($object->dNumCasSal);
    }
    if(isset($object->dComp1Sal)){
      $res->setDComp1Sal($object->dComp1Sal);
    }
    if(isset($object->dComp2Sal)){
      $res->setDComp2Sal($object->dComp2Sal);
    }
    if(isset($object->cDepSal)){
      $res->setCDepSal($object->cDepSal);
    }
    if(isset($object->cDisSal)){
      $res->setCDisSal($object->cDisSal);
    }
    if(isset($object->cCiuSal)){
      $res->setCCiuSal($object->cCiuSal);
    }
    if(isset($object->dTelSal)){
      $res->setDTelSal($object->dTelSal);
    }
    
    return $res;
  }
}
