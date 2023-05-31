<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DOMElement;

use function PHPSTORM_META\type;

/**
 *ID:E700
 *Campos que describen los ítems de la operación
 *PADRE:E001
 */
class GCamItem
{
  public string $dCodInt; //E701 Código interno
  public int $dParAranc; //E702 Partida arancelaria
  public int $dNCM; //E703 Nomenclatura común del Mercosur (NCM)
  public string $dDncpG; //E704 Código DNCP – Nivel General
  public string $dDncpE; //E705 Código DNCP – Nivel Especifico
  public int $dGtin; //E706 Código GTIN por producto
  public int $dGtinPq; //E707 Código GTIN por paquete
  public string $dDesProSer; //E708  Descripción del producto  y/o servicio
  public int $cUniMed; //E709 Unidad de medida
  public int $dCantProSer; //E711  Cantidad del producto y/o servicio
  public string $cPaisOrig; //E712  Código del país de origen del producto
  public string $dInfItem; //E714 Información de interés  del emisor con respecto al item;
  public int $cRelMerc; //E715 Código de datos de relevancia de las  mercaderías
  public int $dCanQuiMer; //E717 Cantidad de quiebra o  merma
  public int $dPorQuiMer; //E718 Porcentaje de quiebra o merma
  public int $dCDCAnticipo; //E719 CDC del anticipo
  public GValorItem $gValorItem;
  public GCamIVA $gCamIVa;
  public GRasMerc $gRasMerc;
  public GVehNuevo $gVehNuevo;

  //====================================================//
  ////Setters
  //====================================================//

  /**
   * Set the value of dCodInt
   *
   * @param string $dCodInt
   *
   * @return self
   */
  public function setDCodInt(string $dCodInt): self
  {
    $this->dCodInt = $dCodInt;

    return $this;
  }


  /**
   * Set the value of dParAranc
   *
   * @param int $dParAranc
   *
   * @return self
   */
  public function setDParAranc(int $dParAranc): self
  {
    $this->dParAranc = $dParAranc;

    return $this;
  }


  /**
   * Set the value of dNCM
   *
   * @param int $dNCM
   *
   * @return self
   */
  public function setDNCM(int $dNCM): self
  {
    $this->dNCM = $dNCM;

    return $this;
  }


  /**
   * Set the value of dDncpG
   *
   * @param string $dDncpG
   *
   * @return self
   */
  public function setDDncpG(string $dDncpG): self
  {
    $this->dDncpG = $dDncpG;

    return $this;
  }


  /**
   * Set the value of dDncpE
   *
   * @param string $dDncpE
   *
   * @return self
   */
  public function setDDncpE(string $dDncpE): self
  {
    $this->dDncpE = $dDncpE;

    return $this;
  }


  /**
   * Set the value of dGtin
   *
   * @param int $dGtin
   *
   * @return self
   */
  public function setDGtin(int $dGtin): self
  {
    $this->dGtin = $dGtin;

    return $this;
  }


  /**
   * Set the value of dGtinPq
   *
   * @param int $dGtinPq
   *
   * @return self
   */
  public function setDGtinPq(int $dGtinPq): self
  {
    $this->dGtinPq = $dGtinPq;

    return $this;
  }


  /**
   * Set the value of dDesProSer
   *
   * @param string $dDesProSer
   *
   * @return self
   */
  public function setDDesProSer(string $dDesProSer): self
  {
    $this->dDesProSer = $dDesProSer;

    return $this;
  }


  /**
   * Set the value of cUniMed
   *
   * @param int $cUniMed
   *
   * @return self
   */
  public function setCUniMed(int $cUniMed): self
  {
    $this->cUniMed = $cUniMed;

    return $this;
  }


  /**
   * Set the value of dCantProSer
   *
   * @param int $dCantProSer
   *
   * @return self
   */
  public function setDCantProSer(int $dCantProSer): self
  {
    $this->dCantProSer = $dCantProSer;

    return $this;
  }


  /**
   * Set the value of cPaisOrig
   *
   * @param string $cPaisOrig
   *
   * @return self
   */
  public function setCPaisOrig(string $cPaisOrig): self
  {
    $this->cPaisOrig = $cPaisOrig;

    return $this;
  }


  /**
   * Set the value of dInfItem
   *
   * @param string $dInfItem
   *
   * @return self
   */
  public function setDInfItem(string $dInfItem): self
  {
    $this->dInfItem = $dInfItem;

    return $this;
  }


  /**
   * Set the value of cRelMerc
   *
   * @param int $cRelMerc
   *
   * @return self
   */
  public function setCRelMerc(int $cRelMerc): self
  {
    $this->cRelMerc = $cRelMerc;

    return $this;
  }


  /**
   * Set the value of dCanQuiMer
   *
   * @param int $dCanQuiMer
   *
   * @return self
   */
  public function setDCanQuiMer(int $dCanQuiMer): self
  {
    $this->dCanQuiMer = $dCanQuiMer;

    return $this;
  }


  /**
   * Set the value of dPorQuiMer
   *
   * @param int $dPorQuiMer
   *
   * @return self
   */
  public function setDPorQuiMer(int $dPorQuiMer): self
  {
    $this->dPorQuiMer = $dPorQuiMer;

    return $this;
  }


  /**
   * Set the value of dCDCAnticipo
   *
   * @param int $dCDCAnticipo
   *
   * @return self
   */
  public function setDCDCAnticipo(int $dCDCAnticipo): self
  {
    $this->dCDCAnticipo = $dCDCAnticipo;

    return $this;
  }

  //====================================================//
  ///Getter
  //====================================================//

  /**
   * Get the value of dCodInt
   *
   * @return string
   */
  public function getDCodInt(): string
  {
    return $this->dCodInt;
  }

  /**
   * Get the value of dParAranc
   *
   * @return int
   */
  public function getDParAranc(): int
  {
    return $this->dParAranc;
  }

  /**
   * Get the value of dNCM
   *
   * @return int
   */
  public function getDNCM(): int
  {
    return $this->dNCM;
  }

  /**
   * Get the value of dDncpG
   *
   * @return string
   */
  public function getDDncpG(): string
  {
    return $this->dDncpG;
  }

  /**
   * Get the value of dDncpE
   *
   * @return string
   */
  public function getDDncpE(): string
  {
    return $this->dDncpE;
  }

  /**
   * Get the value of dGtin
   *
   * @return int
   */
  public function getDGtin(): int
  {
    return $this->dGtin;
  }

  /**
   * Get the value of dGtinPq
   *
   * @return int
   */
  public function getDGtinPq(): int
  {
    return $this->dGtinPq;
  }

  /**
   * Get the value of dDesProSer
   *
   * @return string
   */
  public function getDDesProSer(): string
  {
    return $this->dDesProSer;
  }

  /**
   * Get the value of cUniMed
   *
   * @return int
   */
  public function getCUniMed(): int
  {
    return $this->cUniMed;
  }

  /**
   * 710  Descripción de la unidad de medida
   *
   * @return string
   */
  public function getDDesUniMed(): string
  {
    return "Unidad de medida de Mordor";
  }

  /**
   * Get the value of dCantProSer
   *
   * @return int
   */
  public function getDCantProSer(): int
  {
    return $this->dCantProSer;
  }

  /**
   * Get the value of cPaisOrig
   *
   * @return string
   */
  public function getCPaisOrig(): string
  {
    return $this->cPaisOrig;
  }

  /**
   * E713 Descripción del país de origen del producto
   *
   * @return string
   */
  public function getDDesPaisOrig(): string
  {
    return "Mordor"; //ver luego
  }


  /**
   * Get the value of dInfItem
   *
   * @return string
   */
  public function getDInfItem(): string
  {
    return $this->dInfItem;
  }

  /**
   * Get the value of cRelMerc
   *
   * @return int
   */
  public function getCRelMerc(): int
  {
    return $this->cRelMerc;
  }

  /**
   * E716 Descripción del código de datos de relevancia de las mercaderías
   *
   * @return string
   */
  public function getDDesRelMerc(): string
  {
    switch ($this->cRelMerc) {
      case 1:
        return "Tolerancia de quiebra";
        break;
      case 2:
        return "Tolerancia de merma";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Get the value of dCanQuiMer
   *
   * @return int
   */
  public function getDCanQuiMer(): int
  {
    return $this->dCanQuiMer;
  }

  /**
   * Get the value of dPorQuiMer
   *
   * @return int
   */
  public function getDPorQuiMer(): int
  {
    return $this->dPorQuiMer;
  }

  /**
   * Get the value of dCDCAnticipo
   *
   * @return int
   */
  public function getDCDCAnticipo(): int
  {
    return $this->dCDCAnticipo;
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
    $res = new DOMElement("gCamItem");

    $res->appendChild(new DOMElement('dCodInt', $this->getDCodInt()));
    $res->appendChild(new DOMElement('dParAranc', $this->getDParAranc()));
    $res->appendChild(new DOMElement('dNCM', $this->getDNCM()));
    $res->appendChild(new DOMElement('dDncpG', str_pad($this->dDncpG, 8, '0', STR_PAD_RIGHT)));

    if (isset($this->dDncpG)) {
      $res->appendChild(new DOMElement('dDncpE', $this->getDDncpE()));
    }

    $res->appendChild(new DOMElement('dGtin', $this->getDGtin()));
    $res->appendChild(new DOMElement('dGtinPq', $this->getDGtinPq()));
    $res->appendChild(new DOMElement('dDesProSer', $this->getDDesProSer()));
    $res->appendChild(new DOMElement('cUniMed', $this->getCUniMed()));
    $res->appendChild(new DOMElement('dDesUniMed', $this->getDDesUniMed()));
    $res->appendChild(new DOMElement('dCantProSer', $this->getDCantProSer()));
    $res->appendChild(new DOMElement('cPaisOrig', $this->getCPaisOrig()));
    $res->appendChild(new DOMElement('dDesPaisOrig', $this->getDDesPaisOrig()));
    $res->appendChild(new DOMElement('dInfItem', $this->getDInfItem()));
    $res->appendChild(new DOMElement('cRelMerc', $this->cRelMerc));
    $res->appendChild(new DOMElement('dDesRelMerc', $this->getDDesRelMerc()));
    $res->appendChild(new DOMElement('dCanQuiMer', $this->getDCanQuiMer()));
    $res->appendChild(new DOMElement('dPorQuiMer', $this->getDPorQuiMer()));
    $res->appendChild(new DOMElement('dCDCAnticipo', $this->getDCDCAnticipo()));

    //children
    $res->appendChild($this->gValorItem->toDOMElement());
    $res->appendChild($this->gCamIVa->toDOMElement());
    $res->appendChild($this->gRasMerc->toDOMElement());
    $res->appendChild($this->gVehNuevo->toDOMElement());
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GCamItem
   */
  public static function fromDOMElement(DOMElement $xml): GCamItem
  {
    if (strcmp($xml->tagName, 'gCamItem') == 0 && $xml->childElementCount >= 20) {
      $res = new GCamItem();
      $res->setDCodInt($xml->childNodes->item(0)->nodeValue);
      $res->setDParAranc(intval($xml->getElementsByTagName('dParAranc')->item(0)->nodeValue));
      $res->setDNCM(intval($xml->getElementsByTagName('dNCM')->item(0)->nodeValue));
      $res->setDDncpG($xml->getElementsByTagName('dDDncpG')->item(0)->nodeValue);
      $res->setDDncpE($xml->getElementsByTagName('dDDncpE')->item(0)->nodeValue);
      $res->setDGtin(intval($xml->getElementsByTagName('dGtin')->item(0)->nodeValue));
      $res->setDGtinPq(intval($xml->getElementsByTagName('dGtinPq')->item(0)->nodeValue));
      $res->setDDesProSer($xml->getElementsByTagName('dDesProSer')->item(0)->nodeValue);
      $res->setCUniMed(intval($xml->getElementsByTagName('cUniMed')->item('0')->nodeValue));
      $res->setDCantProSer(intval($xml->getElementsByTagName('dcantProSer')->item(0)->nodeValue));
      $res->setCPaisOrig($xml->getElementsByTagName('cPaisOrig')->item(0)->nodeValue);
      $res->setDInfItem($xml->getElementsByTagName('dInfItem')->item(0)->nodeValue);
      $res->setCRelMerc(intval($xml->getElementsByTagName('dRelMerc')->item(0)->nodeValue));
      $res->setDCanQuiMer(intval($xml->getElementsByTagName('dcantQuiMer')->item(0)->nodeValue));
      $res->setDPorQuiMer(intval($xml->getElementsByTagName('dporQuiMer')->item(0)->nodeValue));
      $res->setDCDCAnticipo($xml->getElementsByTagName('dCDCAnticipo')->item(0)->nodeValue);

      //children
      $res->setGValorItem($res->gValorItem->fromDOMElement($xml->getElementsByTagName('gValorItem')->item(0)->nodeValue));
      $res->setGCamIVa($res->gCamIVa->fromDOMElement($xml->getElementsByTagName('gCamIVa')->item(0)->nodeValue));
      $res->setGRasMerc($res->gRasMerc->fromDOMElement($xml->getElementsByTagName('gRasMerc')->item(0)->nodeValue));
      $res->setGVehNuevo($res->gVehNuevo->fromDOMElement($xml->getElementsByTagName('gVehNuevo')->item(0)->nodeValue));
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }

  //====================================================//
  ///Others
  //====================================================//

  /**
   * Get the value of gValorItem
   *
   * @return GValorItem
   */
  public function getGValorItem(): GValorItem
  {
    return $this->gValorItem;
  }

  /**
   * Set the value of gValorItem
   *
   * @param GValorItem $gValorItem
   *
   * @return self
   */
  public function setGValorItem(GValorItem $gValorItem): self
  {
    $this->gValorItem = $gValorItem;

    return $this;
  }

  /**
   * Get the value of gCamIVa
   *
   * @return GCamIVA
   */
  public function getGCamIVa(): GCamIVA
  {
    return $this->gCamIVa;
  }

  /**
   * Set the value of gCamIVa
   *
   * @param GCamIVA $gCamIVa
   *
   * @return self
   */
  public function setGCamIVa(GCamIVA $gCamIVa): self
  {
    $this->gCamIVa = $gCamIVa;

    return $this;
  }

  /**
   * Get the value of gRasMerc
   *
   * @return GRasMerc
   */
  public function getGRasMerc(): GRasMerc
  {
    return $this->gRasMerc;
  }

  /**
   * Set the value of gRasMerc
   *
   * @param GRasMerc $gRasMerc
   *
   * @return self
   */
  public function setGRasMerc(GRasMerc $gRasMerc): self
  {
    $this->gRasMerc = $gRasMerc;

    return $this;
  }

  /**
   * Get the value of gVehNuevo
   *
   * @return GVehNuevo
   */
  public function getGVehNuevo(): GVehNuevo
  {
    return $this->gVehNuevo;
  }

  /**
   * Set the value of gVehNuevo
   *
   * @param GVehNuevo $gVehNuevo
   *
   * @return self
   */
  public function setGVehNuevo(GVehNuevo $gVehNuevo): self
  {
    $this->gVehNuevo = $gVehNuevo;

    return $this;
  }

  public static function fromResponse($response):self
  {
    $res = new GCamItem();
    $res->setDCodInt($response->dCodInt);
    if (isset($response->dParAranc))
    {
      $res->setDParAranc($response->dParAranc);
    }
    if (isset($response->dNCM))
    {
      $res->setDNCM($response->dNCM);
    }
    if (isset($response->dDDncpG))
    {
      $res->setDDncpG($response->dDDncpG);
    }
    if (isset($response->dDDncpE))
    {
      $res->setDDncpE($response->dDDncpE);
    }
    if (isset($response->dGtin))
    {
      $res->setDGtin($response->dGtin);
    }
    if (isset($response->dGtinPq))
    {
      $res->setDGtinPq($response->dGtinPq);
    }
    if (isset($response->dDesProSer))
    {
      $res->setDDesProSer($response->dDesProSer);
    }
    if (isset($response->cUniMed))
    {
      $res->setCUniMed($response->cUniMed);
    }
    if (isset($response->dcantProSer))
    {
      $res->setDCantProSer($response->dcantProSer);
    }
    if (isset($response->cPaisOrig))
    {
      $res->setCPaisOrig($response->cPaisOrig);
    }
    if (isset($response->dInfItem))
    {
      $res->setDInfItem($response->dInfItem);
    }
    if (isset($response->dRelMerc))
    {
      $res->setCRelMerc($response->dRelMerc);
    }
    if (isset($response->dcantQuiMer))
    {
      $res->setDCanQuiMer($response->dcantQuiMer);
    }
    if (isset($response->dporQuiMer))
    {
      $res->setDPorQuiMer($response->dporQuiMer);
    }
    if (isset($response->dCDCAnticipo))
    {
      $res->setDCDCAnticipo($response->dCDCAnticipo);
    }
    // //CHILDREN
    // if (isset($response->gValorItem))
    // {
    //   $res->setGValorItem(GValorItem::fromResponse($response->gValorItem));
    // }
    // if (isset($response->gCamIVa))
    // {
    //   $res->setGCamIVa(GCamIVA::fromResponse($response->gCamIVa));
    // }
    // if (isset($response->gRasMerc))
    // {
    //   $res->setGRasMerc(GRasMerc::fromResponse($response->gRasMerc));
    // }
    // if (isset($response->gVehNuevo))
    // {
    //   $res->setGVehNuevo(GVehNuevo::fromResponse($response->gVehNuevo));
    // }
    return $res;
  }
}
