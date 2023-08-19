<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Helpers\DepartamentoHelper;
use Abiliomp\Pkuatia\Helpers\GeoRefCodesHelper;
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
   * Set the value of dDirLocSal
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
   * Set the value of dNumCasSal
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
   * Set the value of dComp1Sal
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
   * Set the value of dComp2Sal
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
   * Set the value of cDepSal
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
   * Set the value of cDisSal
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
   * Set the value of cCiuSal
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
   * Set the value of dTelSal
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
   * Get the value of dDirLocSal
   *
   * @return String
   */
  public function getDDirLocSal(): String
  {
    return $this->dDirLocSal;
  }

  /**
   * Get the value of dNumCasSal
   *
   * @return int
   */
  public function getDNumCasSal(): int
  {
    return $this->dNumCasSal;
  }

  /**
   * Get the value of dComp1Sal
   *
   * @return String
   */
  public function getDComp1Sal(): String
  {
    return $this->dComp1Sal;
  }

  /**
   * Get the value of dComp2Sal
   *
   * @return String
   */
  public function getDComp2Sal(): String
  {
    return $this->dComp2Sal;
  }

  /**
   * Get the value of cDepSal
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
    return DepartamentoHelper::getDepName(strval($this->cDepSal));
  }

  /**
   * Get the value of cDisSal
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
    return GeoRefCodesHelper::getDistName(strval($this->cDisSal));
  }

  /**
   * Get the value of cCiuSal
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
    return GeoRefCodesHelper::getCiudName(strval($this->cCiuSal));
  }

  /**
   * Get the value of dTelSal
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
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCamSal');

    $res->appendChild(new DOMElement('dDirLocSal', $this->getDDirLocSal()));

    if (isset($this->dNumCasSal)) {
      $res->appendChild(new DOMElement('dNumCasSal', 0));
    } else {
      $res->appendChild(new DOMElement('dNumCasSal', $this->getDNumCasSal()));
    }

    $res->appendChild(new DOMElement('dComp1Sal', $this->getDComp1Sal()));
    $res->appendChild(new DOMElement('dComp2Sal', $this->getDComp2Sal()));
    $res->appendChild(new DOMElement('cDepSal', $this->getCDisSal()));
    $res->appendChild(new DOMElement('dDesDepSal', $this->getCDepSal()));
    $res->appendChild(new DOMElement('cDisSal', $this->getCDisSal()));
    $res->appendChild(new DOMElement('dDesDisSal', $this->getDDesDisSal()));
    $res->appendChild(new DOMElement('cCiuSal', $this->getCCiuSal()));
    $res->appendChild(new DOMElement('dDesCiuSal', $this->getDDesCiuSal()));
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
