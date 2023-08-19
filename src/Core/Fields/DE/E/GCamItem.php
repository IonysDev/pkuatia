<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Helpers\CountryHelper;
use Abiliomp\Pkuatia\DataMappings\UnidadMedidaMapping;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: E700
 * Nombre: gCamItem
 * Descripción: Campos que describen los ítems de la operación
 * Nodo Padre: E001
 */
class GCamItem
{
  public String     $dCodInt;      // E701 - 1-20       - 1-1 - Código interno
  public int        $dParAranc;    // E702 - 4          - 0-1 - Partida arancelaria
  public int        $dNCM;         // E703 - 6-8        - 0-1 - Nomenclatura común del Mercosur (NCM)
  public String     $dDncpG;       // E704 - 8          - 0-1 - Código DNCP – Nivel General
  public String     $dDncpE;       // E705 - 3-4        - 0-1 - Código DNCP – Nivel Especifico
  public int        $dGtin;        // E706 - 8,12,13,14 - 0-1 - Código GTIN por producto
  public int        $dGtinPq;      // E707 - 8,12,13,14 - 0-1 - Código GTIN por paquete
  public String     $dDesProSer;   // E708 - 1-120      - 1-1 - Descripción del producto  y/o servicio
  public int        $cUniMed;      // E709 - 1-5        - 1-1 - Unidad de medida
  public String     $dDesUniMed;   // E710 - 1-10       - 1-1 - Descripción de la unidad de medida
  public String     $dCantProSer;  // E711 - 1-10p(0-4) - 1-1 - Cantidad del producto y/o servicio (es un decimal BCMAth)
  public String     $cPaisOrig;    // E712 - 3          - 0-1 - Código del país de origen del producto
  public String     $dDesPaisOrig; // E713 - 4-30       - 0-1 - Descripción del país de origen del producto
  public String     $dInfItem;     // E714 - 1-500      - 0-1 - Información de interés  del emisor con respecto al item;
  public int        $cRelMerc;     // E715 - 1          - 0-1 - Código de datos de relevancia de las  mercaderías
  public String     $dDesRelMerc;  // E716 - 19-21      - 0-1 - Descripción del código de datos de relevancia de las mercaderías	
  public String     $dCanQuiMer;   // E717 - 1-10p(0-4) - 0-1 - Cantidad de quiebra o  merma (decimal BCMath)
  public String     $dPorQuiMer;   // E718 - 1-3p(0-8)  - 0-1 - Porcentaje de quiebra o merma (decimal BCMath)
  public String     $dCDCAnticipo; // E719 - 44         - 0-1 - CDC del anticipo
  public GValorItem $gValorItem;   // E720 -            - 0-1 - Campos que describen los precios, descuentos y valor total por ítem 
  public GCamIVA    $gCamIVa;      // E730 -            - 0-1 - Campos que describen el IVA de la operación
  public GRasMerc   $gRasMerc;     // E750 -            - 0-1 - Grupo de rastreo de la mercadería
  public GVehNuevo  $gVehNuevo;    // E770 -            - 0-1 - Grupo de detalle de vehículos nuevos

  /////////////////////////////////////////////////////////
  // Constructor
  /////////////////////////////////////////////////////////

 

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

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
    $this->setDDesUniMed(UnidadMedidaMapping::GetDesc(strval($cUniMed)));
    return $this;
  }

  /**
   * Set the value of dDesUniMed
   * 
   * @param string $dDesUniMed
   * 
   * @return self
   */
  public function setDDesUniMed(string $dDesUniMed): self
  {
    if(is_null($dDesUniMed) || strlen($dDesUniMed) == 0)
    {
      $this->dDesUniMed = null;
    }
    else
    {
      $this->dDesUniMed = substr($dDesUniMed, 0, 10);
    }
    return $this;
  }


  /**
   * Set the value of dCantProSer
   *
   * @param int $dCantProSer
   *
   * @return self
   */
  public function setDCantProSer(float $dCantProSer): self
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
    $this->setDDesPaisOrig(CountryHelper::getCountryDesc($cPaisOrig));
    return $this;
  }

  /**
   * Set the value of dDesPaisOrig
   * 
   * @param string $dDesPaisOrig
   * 
   * @return self
   */
  public function setDDesPaisOrig(string $dDesPaisOrig): self
  {
    if(is_null($dDesPaisOrig) || strlen($dDesPaisOrig) == 0)
    {
      $this->dDesPaisOrig = null;
    }
    else
    {
      $this->dDesPaisOrig = substr($dDesPaisOrig, 0, 30);
    }
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
    switch ($cRelMerc) {
      case 1:
        $this->setDDesRelMerc("Tolerancia de quiebra");
        break;
      case 2:
        $this->setDDesRelMerc("Tolerancia de merma");
        break;
      default:
        throw new \Exception("Valor '" . $cRelMerc . "'no soportado para cRelMerc");
        break;
    }
    return $this;
  }

  /**
   * Set the value of dDesRelMerc
   * 
   * @param string $dDesRelMerc
   * 
   * @return self
   */
  public function setDDesRelMerc(string $dDesRelMerc): self
  {
    if(is_null($dDesRelMerc) || strlen($dDesRelMerc) == 0)
    {
      $this->dDesRelMerc = null;
    }
    else
    {
      $this->dDesRelMerc = substr($dDesRelMerc, 0, 21);
    }
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

  ///////////////////////////////////////////////////////////////////////
  // Getter
  ///////////////////////////////////////////////////////////////////////

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
   * Devuelve la descripción de la unidad de medida
   *
   * @return string
   */
  public function getDDesUniMed(): string
  {
    return $this->dDesUniMed;
  }

  /**
   * Get the value of dCantProSer
   *
   * @return int
   */
  public function getDCantProSer(): float
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
    return $this->dDesPaisOrig;
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
  public function getDDesRelMerc(): String
  {
    return $this->dDesRelMerc;
  }

  /**
   * Get the value of dCanQuiMer
   *
   * @return String
   */
  public function getDCanQuiMer(): String
  {
    return $this->dCanQuiMer;
  }

  /**
   * Get the value of dPorQuiMer
   *
   * @return String
   */
  public function getDPorQuiMer(): String
  {
    return $this->dPorQuiMer;
  }

  /**
   * Get the value of dCDCAnticipo
   *
   * @return String
   */
  public function getDCDCAnticipo(): String
  {
    return $this->dCDCAnticipo;
  }

  /**
   * Devuelve el grupo de valor item
   * 
   * @return GValorItem
   */
  public function getGValorItem(): GValorItem
  {
    return $this->gValorItem;
  }

  /**
   * Devuelve el grupo de campos del IVA
   * 
   * @return GCamIVA
   */
  public function getGCamIVa(): GCamIVA
  {
    return $this->gCamIVa;
  }

  /**
   * Devuelve el grupo de rastreo de la mercadería
   * 
   * @return GRasMerc
   */
  public function getGRasMerc(): GRasMerc
  {
    return $this->gRasMerc;
  }

  /**
   * Devuelve el grupo de detalle de vehículos nuevos
   * 
   * @return GVehNuevo
   */
  public function getGVehNuevo(): GVehNuevo
  {
    return $this->gVehNuevo;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GCamItem desde un elemento SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return GCamItem
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): GCamItem
  {
    if(strcmp($node->getName(), 'gCamItem') != 0)
    {
      throw new \Exception("El nodo '" . $node->getName() . "' no es un nodo 'gCamItem'");
    }
    $res = new GCamItem();
    $res->setDCodInt(strval($node->dCodInt));
    if(isset($node->dParAranc))
    {
      $res->setDParAranc(intval($node->dParAranc));
    }
    if(isset($node->dNCM))
    {
      $res->setDNCM(intval($node->dNCM));
    }
    if(isset($node->dDncpG))
    {
      $res->setDDncpG(strval($node->dDncpG));
    }
    if(isset($node->dDncpE))
    {
      $res->setDDncpE(strval($node->dDncpE));
    }
    if(isset($node->dGtin))
    {
      $res->setDGtin(intval($node->dGtin));
    }
    if(isset($node->dGtinPq))
    {
      $res->setDGtinPq(intval($node->dGtinPq));
    }
    $res->setDDesProSer(strval($node->dDesProSer));
    $res->setCUniMed(intval($node->cUniMed));
    $res->setDDesUniMed(strval($node->dDesUniMed));
    $res->setDCantProSer(floatval($node->dCantProSer));
    if(isset($node->cPaisOrig))
    {
      $res->setCPaisOrig(strval($node->cPaisOrig));
    }
    if(isset($node->dDesPaisOrig))
    {
      $res->setDDesPaisOrig(strval($node->dDesPaisOrig));
    }
    if(isset($node->dInfItem))
    {
      $res->setDInfItem(strval($node->dInfItem));
    }
    if(isset($node->cRelMerc))
    {
      $res->setCRelMerc(intval($node->cRelMerc));
    }
    if(isset($node->dDesRelMerc))
    {
      $res->setDDesRelMerc(strval($node->dDesRelMerc));
    }
    if(isset($node->dCanQuiMer))
    {
      $res->setDCanQuiMer(floatval($node->dCanQuiMer));
    }
    if(isset($node->dPorQuiMer))
    {
      $res->setDPorQuiMer(floatval($node->dPorQuiMer));
    }
    if(isset($node->dCDCAnticipo))
    {
      $res->setDCDCAnticipo(strval($node->dCDCAnticipo));
    }
    if(isset($node->gValorItem))
    {
      $res->setGValorItem(GValorItem::FromSimpleXMLElement($node->gValorItem));
    }
    if(isset($node->gCamIVA))
    {
      $res->setGCamIVa(GCamIVA::FromSimpleXMLElement($node->gCamIVA));
    }
    if(isset($node->gRasMerc))
    {
      $res->setGRasMerc(GRasMerc::FromSimpleXMLElement($node->gRasMerc));
    }
    if(isset($node->gVehNuevo))
    {
      $res->setGVehNuevo(GVehNuevo::FromSimpleXMLElement($node->gVehNuevo));
    }
    return $res;
  }

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
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {
    $res = new GCamItem();
    if (isset($response->dCodInt)) {
      $res->setDCodInt($response->dCodInt);
    }
    if (isset($response->dParAranc)) {
      $res->setDParAranc($response->dParAranc);
    }
    if (isset($response->dNCM)) {
      $res->setDNCM($response->dNCM);
    }
    if (isset($response->dDDncpG)) {
      $res->setDDncpG($response->dDDncpG);
    }
    if (isset($response->dDDncpE)) {
      $res->setDDncpE($response->dDDncpE);
    }
    if (isset($response->dGtin)) {
      $res->setDGtin($response->dGtin);
    }
    if (isset($response->dGtinPq)) {
      $res->setDGtinPq($response->dGtinPq);
    }
    if (isset($response->dDesProSer)) {
      $res->setDDesProSer($response->dDesProSer);
    }
    if (isset($response->cUniMed)) {
      $res->setCUniMed($response->cUniMed);
    }
    if (isset($response->dCantProSer)) {
      $res->setDCantProSer($response->dCantProSer);
    }
    if (isset($response->cPaisOrig)) {
      $res->setCPaisOrig($response->cPaisOrig);
    }
    if (isset($response->dInfItem)) {
      $res->setDInfItem($response->dInfItem);
    }
    if (isset($response->dRelMerc)) {
      $res->setCRelMerc($response->dRelMerc);
    }
    if (isset($response->dCanQuiMer)) {
      $res->setDCanQuiMer($response->dCanQuiMer);
    }
    if (isset($response->dPorQuiMer)) {
      $res->setDPorQuiMer($response->dPorQuiMer);
    }
    if (isset($response->dCDCAnticipo)) {
      $res->setDCDCAnticipo($response->dCDCAnticipo);
    }
    // //CHILDREN
    if (isset($response->gValorItem)) {
      $res->setGValorItem(GValorItem::fromResponse($response->gValorItem));
    }
    if (isset($response->gCamIVA)) {
      $res->setGCamIVa(GCamIVA::fromResponse($response->gCamIVA));
    }
    if (isset($response->gRasMerc)) {
      $res->setGRasMerc(GRasMerc::fromResponse($response->gRasMerc));
    }
    if (isset($response->gVehNuevo)) {
      $res->setGVehNuevo(GVehNuevo::fromResponse($response->gVehNuevo));
    }
    return $res;
  }
}
