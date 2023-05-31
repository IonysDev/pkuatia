<?php

namespace Abiliomp\Pkuatia\Core\Fields\E;

use DOMElement;

/**
 * ID:E920
 *Campos que identifican el local de salida de las mercaderías 
 *PADRE:E900 
 */
class GCamSal
{
  public ?string $dDirLocSal  = null; //E921 Dirección del local de salida
  public ?int $dNumCasSal  = null; //E922 Número de casa de salida
  public ?string $dComp1Sal  = null; //E923 Complemento de dirección 1 salida
  public ?string $dComp2Sal  = null; //E924 Complemento de dirección 2 salida
  public ?int $cDepSal  = null; ///E925 Código del departamento del local de salida
  public ?int $cDisSal  = null; //E927 Código del distrito del local de salida
  public ?int $cCiuSal  = null; //E929 Código de la ciudad del local de salida
  public ?string $dTelSal  = null; /// E931 Teléfono de contacto del local de salida

  //====================================================//
  ///SETTERS
  //====================================================//
  /**
   * Set the value of dDirLocSal
   *
   * @param string $dDirLocSal
   *
   * @return self
   */
  public function setDDirLocSal(string $dDirLocSal): self
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
   * @param string $dComp1Sal
   *
   * @return self
   */
  public function setDComp1Sal(string $dComp1Sal): self
  {
    $this->dComp1Sal = $dComp1Sal;

    return $this;
  }


  /**
   * Set the value of dComp2Sal
   *
   * @param string $dComp2Sal
   *
   * @return self
   */
  public function setDComp2Sal(string $dComp2Sal): self
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
   * @param string $dTelSal
   *
   * @return self
   */
  public function setDTelSal(string $dTelSal): self
  {
    $this->dTelSal = $dTelSal;

    return $this;
  }

  //====================================================//
  ///GETTERS
  //====================================================//

  /**
   * Get the value of dDirLocSal
   *
   * @return string
   */
  public function getDDirLocSal(): string | null
  {
    return $this->dDirLocSal;
  }

  /**
   * Get the value of dNumCasSal
   *
   * @return int
   */
  public function getDNumCasSal(): int | null
  {
    return $this->dNumCasSal;
  }

  /**
   * Get the value of dComp1Sal
   *
   * @return string
   */
  public function getDComp1Sal(): string | null
  {
    return $this->dComp1Sal;
  }

  /**
   * Get the value of dComp2Sal
   *
   * @return string
   */
  public function getDComp2Sal(): string | null
  {
    return $this->dComp2Sal;
  }

  /**
   * Get the value of cDepSal
   *
   * @return int
   */
  public function getCDepSal(): int | null
  {
    return $this->cDepSal;
  }

  /**
   * E926 
   *Descripción del departamento del local de salida
   *
   * @return string
   */
  public function getDDesDepSal(): string | null
  {
    return "Mordor";
  }

  /**
   * Get the value of cDisSal
   *
   * @return int
   */
  public function getCDisSal(): int | null
  {
    return $this->cDisSal;
  }

  /**
   * E928 Descripción de distrito del local de salida
   *
   * @return string
   */
  public function getDDesDisSal(): string | null
  {
    return "Mordor";
  }

  /**
   * Get the value of cCiuSal
   *
   * @return int
   */
  public function getCCiuSal(): int | null
  {
    return $this->cCiuSal;
  }


  /**
   * E930 Descripción de ciudad del local de salida
   *
   * @return string
   */
  public function getDDesCiuSal(): string | null
  {
    return "Mordor";
  }

  /**
   * Get the value of dTelSal
   *
   * @return string
   */
  public function getDTelSal(): string | null
  {
    return $this->dTelSal;
  }

  //====================================================//
  ///XML Element  
  //====================================================//

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
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {
    $res = new GCamSal();
    $res->setDDirLocSal($response->dDirLocSal);
    $res->setDNumCasSal($response->dNumCasSal);
    $res->setDComp1Sal($response->dComp1Sal);
    $res->setDComp2Sal($response->dComp2Sal);
    $res->setCDepSal($response->cDepSal);
    $res->setCDisSal($response->cDisSal);
    $res->setCCiuSal($response->cCiuSal);
    $res->setDTelSal($response->dTelSal);
    return $res;
  }
}
