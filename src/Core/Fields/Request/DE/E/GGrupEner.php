<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

/**
 *ID:E791 
 *Grupo del sector de energía eléctrica 
 *PADRE:E790
 */
class GGrupEner
{
  public ?string $dNroMed = null; //E792 Número de medidor
  public ?int $dActiv = null; ///E793 Código de actividad
  public ?string $dCateg = null; ///E794 Código de categoría
  public ?int $dLecAnt = null; ///E795 Lectura anterior
  public ?int $dLecAct = null; ///E796 Lectura actual
  public ?int $dConKwh = null; /// 797 dConKwh Consumo

  //====================================================//
  ///SETTETS
  //====================================================//

  /**
   * Set the value of dNroMed
   *
   * @param string $dNroMed
   *
   * @return self
   */
  public function setDNroMed(string $dNroMed): self
  {
    $this->dNroMed = $dNroMed;

    return $this;
  }


  /**
   * Set the value of dActiv
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
   * Set the value of dCateg
   *
   * @param string $dCateg
   *
   * @return self
   */
  public function setDCateg(string $dCateg): self
  {
    $this->dCateg = $dCateg;

    return $this;
  }


  /**
   * Set the value of dLecAnt
   *
   * @param int $dLecAnt
   *
   * @return self
   */
  public function setDLecAnt(int $dLecAnt): self
  {
    $this->dLecAnt = $dLecAnt;

    return $this;
  }


  /**
   * Set the value of dLecAct
   *
   * @param int $dLecAct
   *
   * @return self
   */
  public function setDLecAct(int $dLecAct): self
  {
    $this->dLecAct = $dLecAct;

    return $this;
  }

  /**
   * Set the value of dConKwh
   *
   * @param int $dConKwh
   *
   * @return self
   */
  public function setDConKwh(int $dConKwh): self
  {
    $this->dConKwh = $dConKwh;

    return $this;
  }


  //====================================================//
  ///Getter
  //====================================================//

  /**
   * Get the value of dNroMed
   *
   * @return string
   */
  public function getDNroMed(): string | null
  {
    return $this->dNroMed;
  }

  /**
   * Get the value of dActiv
   *
   * @return int
   */
  public function getDActiv(): int | null
  {
    return $this->dActiv;
  }

  /**
   * Get the value of dCateg
   *
   * @return string
   */
  public function getDCateg(): string | null
  {
    return $this->dCateg;
  }

  /**
   * Get the value of dLecAnt
   *
   * @return int
   */
  public function getDLecAnt(): int | null
  {
    return $this->dLecAnt;
  }

  /**
   * Get the value of dLecAct
   *
   * @return int
   */
  public function getDLecAct(): int | null
  {
    return $this->dLecAct;
  }

  /**
   * Get the value of dConKwh
   *
   * @return int
   */
  public function getDConKwh(): int | null
  {
    return $this->dLecAct - $this->dLecAct;
  }

  //====================================================//
  ///XML Element
  //====================================================//

  /**
   * toDomElement
   *
   * @return DOMElement
   */
  public function toDomElement(): DOMElement
  {
    $res = new DOMElement('gGrupEner');

    $res->appendChild(new DOMElement('dNroMed', $this->getDNroMed()));
    $res->appendChild(new DOMElement('dActiv', $this->getDActiv()));
    $res->appendChild(new DOMElement('dCateg', $this->getDCateg()));
    $res->appendChild(new DOMElement('dLecAnt', $this->getDLecAnt()));
    $res->appendChild(new DOMElement('dLecAct', $this->getDLecAct()));
    $res->appendChild(new DOMElement('dConKwh', $this->getDConKwh()));

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GGrupEner
  //  */
  // public static function fromDOMElement(DOMElement $xml): GGrupEner
  // {
  //   if (strcmp($xml->tagName, 'gGrupEner') == 0 && $xml->childElementCount == 6) {
  //     $res = new GGrupEner();
  //     $res->setDNroMed($xml->getElementsByTagName('dNroMed')->item(0)->nodeValue);
  //     $res->setDActiv(intval($xml->getElementsByTagName('dActiv')->item(0)->nodeValue));
  //     $res->setDCateg($xml->getElementsByTagName('dCateg')->item(0)->item(0)->nodeValue);
  //     $res->setDLecAnt(intval($xml->getElementsByTagName('dLecAnt')->item(0)->nodeValue));
  //     $res->setDLecAct(intval($xml->getElementsByTagName('dLecAct')->item(0)->nodeValue));
  //     $res->setDConKwh(intval($xml->getElementsByTagName('dConKwh')->item(0)->nodeValue));
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
    $res = new GGrupEner();
    if(isset($response->dNroMed))
    {
      $res->setDNroMed($response->dNroMed);
    }
    if(isset($response->dActiv))
    {
      $res->setDActiv($response->dActiv);
    }
    if(isset($response->dCateg))
    {
      $res->setDCateg($response->dCateg);
    }
    if(isset($response->dLecAnt))
    {
      $res->setDLecAnt($response->dLecAnt);
    }
    if(isset($response->dLecAct))
    {
      $res->setDLecAct($response->dLecAct);
    }
    if(isset($response->dConKwh))
    {
      $res->setDConKwh($response->dConKwh);
    }
    
    return $res;
  }
}
