<?php

namespace Abiliomp\Pkuatia\Core\Fields\E;

use DOMElement;

/**
 *ID:E940 
 *Campos que identifican el local de la entrega de las mercaderías
 * PADRE:E900
 */
class GCamEnt
{
  public ?string $dDirLocEnt = null; // E941 - Dirección del local de la entrega 
  public ?int $dNumCasEnt = null;    // E942 - Número de casa de Entrega
  public ?string $dComp1Ent = null;  // E943 - Complemento de dirección 1 Entrega
  public ?string $dComp2Ent = null; // E944 - Complemento de dirección 2 Entrega
  public ?int $cDepEnt = null;      // E945 - Código del departamento del local de Entrega
  public ?int $cDisEnt = null;      // E947 - Código del distrito del local de Entrega
  public ?int $cCiuEnt = null;      // E949 - Código de la ciudad del local de Entrega
  public ?string $dTelEnt = null;   // E951 - Teléfono de contacto del local de Entrega

  //====================================================//
  ///Setters
  //====================================================//

  /**
   * Set the value of dDirLocEnt
   *
   * @param string $dDirLocEnt
   *
   * @return self
   */
  public function setDDirLocEnt(string $dDirLocEnt): self
  {
    $this->dDirLocEnt = $dDirLocEnt;

    return $this;
  }


  /**
   * Set the value of dNumCasEnt
   *
   * @param int $dNumCasEnt
   *
   * @return self
   */
  public function setDNumCasEnt(int $dNumCasEnt): self
  {
    $this->dNumCasEnt = $dNumCasEnt;

    return $this;
  }


  /**
   * Set the value of dComp1Ent
   *
   * @param string $dComp1Ent
   *
   * @return self
   */
  public function setDComp1Ent(string $dComp1Ent): self
  {
    $this->dComp1Ent = $dComp1Ent;

    return $this;
  }


  /**
   * Set the value of dComp2Ent
   *
   * @param string $dComp2Ent
   *
   * @return self
   */
  public function setDComp2Ent(string $dComp2Ent): self
  {
    $this->dComp2Ent = $dComp2Ent;

    return $this;
  }


  /**
   * Set the value of cDepEnt
   *
   * @param int $cDepEnt
   *
   * @return self
   */
  public function setCDepEnt(int $cDepEnt): self
  {
    $this->cDepEnt = $cDepEnt;

    return $this;
  }


  /**
   * Set the value of cDisEnt
   *
   * @param int $cDisEnt
   *
   * @return self
   */
  public function setCDisEnt(int $cDisEnt): self
  {
    $this->cDisEnt = $cDisEnt;

    return $this;
  }


  /**
   * Set the value of cCiuEnt
   *
   * @param int $cCiuEnt
   *
   * @return self
   */
  public function setCCiuEnt(int $cCiuEnt): self
  {
    $this->cCiuEnt = $cCiuEnt;

    return $this;
  }


  /**
   * Set the value of dTelEnt
   *
   * @param string $dTelEnt
   *
   * @return self
   */
  public function setDTelEnt(string $dTelEnt): self
  {
    $this->dTelEnt = $dTelEnt;

    return $this;
  }

  //====================================================//
  ///GETTERS
  //====================================================//

  /**
   * Get the value of dDirLocEnt
   *
   * @return string
   */
  public function getDDirLocEnt(): string | null
  {
    return $this->dDirLocEnt;
  }

  /**
   * Get the value of dNumCasEnt
   *
   * @return int
   */
  public function getDNumCasEnt(): int | null
  {
    return $this->dNumCasEnt;
  }

  /**
   * Get the value of dComp1Ent
   *
   * @return string
   */
  public function getDComp1Ent(): string | null
  {
    return $this->dComp1Ent;
  }

  /**
   * Get the value of dComp2Ent
   *
   * @return string
   */
  public function getDComp2Ent(): string | null
  {
    return $this->dComp2Ent;
  }

  /**
   * Get the value of cDepEnt
   *
   * @return int
   */
  public function getCDepEnt(): int | null
  {
    return $this->cDepEnt;
  }

  /**
   * E946 Descripción del departamento del local de la entrega
   *
   * @return string
   */
  public function getDDesDepEnt(): string | null
  {
    return "Mordor";
  }


  /**
   * Get the value of cDisEnt
   *
   * @return int
   */
  public function getCDisEnt(): int | null
  {
    return $this->cDisEnt;
  }

  /**
   * E948 Descripción de distrito del local de entrada
   *
   * @return string
   */
  public function getDDesDisEnt(): string | null
  {
    return "Mordor";
  }

  /**
   * Get the value of cCiuEnt
   *
   * @return int
   */
  public function getCCiuEnt(): int | null
  {
    return $this->cCiuEnt;
  }

  /**
   * E950 Descripción de ciudad del local de entrada
   *
   * @return string
   */
  public function getDDesCiuEnt(): string | null
  {
    return "Mordor";
  }

  /**
   * Get the value of dTelEnt
   *
   * @return string
   */
  public function getDTelEnt(): string | null
  {
    return $this->dTelEnt;
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
    $res = new DOMElement('gCamEnt');

    $res->appendChild(new DOMElement('dDirLocEnt', $this->getDDirLocEnt()));

    if (isset($this->dNumCasEnt)) {
      $res->appendChild(new DOMElement('dNumCasEnt', 0));
    } else {
      $res->appendChild(new DOMElement('dNumCasEnt', $this->getDNumCasEnt()));
    }

    $res->appendChild(new DOMElement('dComp1Ent', $this->getDComp1Ent()));
    $res->appendChild(new DOMElement('dComp2Ent', $this->getDComp2Ent()));
    $res->appendChild(new DOMElement('cDepEnt', $this->getCDisEnt()));
    $res->appendChild(new DOMElement('dDesDepEnt', $this->getCDepEnt()));
    $res->appendChild(new DOMElement('cDisEnt', $this->getCDisEnt()));
    $res->appendChild(new DOMElement('dDesDisEnt', $this->getDDesDisEnt()));
    $res->appendChild(new DOMElement('cCiuEnt', $this->getCCiuEnt()));
    $res->appendChild(new DOMElement('dDesCiuEnt', $this->getDDesCiuEnt()));
    $res->appendChild(new DOMElement('dTelEnt', $this->getDTelEnt()));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GCamEnt
  //  */
  // public static function fromDOMElement(DOMElement $xml): GCamEnt
  // {
  //   if (strcmp($xml->tagName, 'gCamEnt') === 0 && $xml->childElementCount == 11) {
  //     $res = new GCamEnt();
  //     $res->setDDirLocEnt($xml->getElementsByTagName('dDirLocEnt')->item(0)->nodeValue);
  //     $res->setDNumCasEnt(intval($xml->getElementsByTagName('dNumCasEnt')->item(0)->nodeValue));
  //     $res->setDComp1Ent($xml->getElementsByTagName('dComp1Ent')->item(0)->nodeValue);
  //     $res->setDComp2Ent($xml->getElementsByTagName('dComp2Ent')->item(0)->nodeValue);
  //     $res->setCDepEnt(intval($xml->getElementsByTagName('cdepEnt')->item(0)->nodeValue));
  //     $res->setCDisEnt(intval($xml->getElementsByTagName('cdisEnt')->item(0)->nodeValue));
  //     $res->setCCiuEnt(intval($xml->getElementsByTagName('cciuEnt')->item(0)->nodeValue));
  //     $res->setDTelEnt($xml->getElementsByTagName('dTelEnt')->item(0)->nodeValue);
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
  public static function fromResponse($response):self
  {
    $res = new GCamEnt();
    $res->setDDirLocEnt($response->dDirLocEnt);
    $res->setDNumCasEnt($response->dNumCasEnt);
    $res->setDComp1Ent($response->dComp1Ent);
    $res->setDComp2Ent($response->dComp2Ent);
    $res->setCDepEnt($response->cDepEnt);
    $res->setCDisEnt($response->cDisEnt);
    $res->setCCiuEnt($response->cCiuEnt);
    $res->setDTelEnt($response->dTelEnt);
    return $res;
    
  }
}
