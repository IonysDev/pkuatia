<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use IonysDev\Pkuatia\DataMappings\CountryMapping;
use IonysDev\Pkuatia\DataMappings\UnidadMedidaMapping;
use IonysDev\Pkuatia\Utils\NumberStringFormatter;
use DOMDocument;
use DOMElement;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Utils\ValueValidations;
use SimpleXMLElement;

/**
 * Nodo Id: E700
 * Nombre: gCamItem
 * Descripción: Campos que describen los ítems de la operación
 * Nodo Padre: E001
 */
class GCamItem extends BaseSifenField
{
  public String     $dCodInt;      // E701 - 1-50       - 1-1 - Código interno
  public int        $dParAranc;    // E702 - 4          - 0-1 - Partida arancelaria
  public int        $dNCM;         // E703 - 6-8        - 0-1 - Nomenclatura común del Mercosur (NCM)
  public String     $dDncpG;       // E704 - 8          - 0-1 - Código DNCP – Nivel General
  public String     $dDncpE;       // E705 - 3-4        - 0-1 - Código DNCP – Nivel Especifico
  public int        $dGtin;        // E706 - 8,12,13,14 - 0-1 - Código GTIN por producto
  public int        $dGtinPq;      // E707 - 8,12,13,14 - 0-1 - Código GTIN por paquete
  public String     $dDesProSer;   // E708 - 1-2000      - 1-1 - Descripción del producto  y/o servicio
  public int        $cUniMed;      // E709 - 1-5        - 1-1 - Unidad de medida
  public String     $dDesUniMed;   // E710 - 1-10       - 1-1 - Descripción de la unidad de medida
  public String     $dCantProSer;  // E711 - 1-10p(0-8) - 1-1 - Cantidad del producto y/o servicio (es un decimal BCMAth)
  public String     $cPaisOrig;    // E712 - 3          - 0-1 - Código del país de origen del producto
  public String     $dDesPaisOrig; // E713 - 4-30       - 0-1 - Descripción del país de origen del producto
  public String     $dInfItem;     // E714 - 1-500      - 0-1 - Información de interés  del emisor con respecto al item;
  public int        $cRelMerc;     // E715 - 1          - 0-1 - Código de datos de relevancia de las  mercaderías
  public String     $dDesRelMerc;  // E716 - 19-21      - 0-1 - Descripción del código de datos de relevancia de las mercaderías	
  public String     $dCanQuiMer;   // E717 - 1-10p(0-4) - 0-1 - Cantidad de quiebra o  merma (decimal BCMath)
  public String     $dPorQuiMer;   // E718 - 1-3p(0-8)  - 0-1 - Porcentaje de quiebra o merma (decimal BCMath)
  public String     $dCDCAnticipo; // E719 - 44         - 0-1 - CDC del anticipo
  public GValorItem $gValorItem;   // E720 -            - 0-1 - Campos que describen los precios, descuentos y valor total por ítem 
  public GCamIVA    $gCamIVA;      // E730 -            - 0-1 - Campos que describen el IVA de la operación
  public GRasMerc   $gRasMerc;     // E750 -            - 0-1 - Grupo de rastreo de la mercadería
  public GVehNuevo  $gVehNuevo;    // E770 -            - 0-1 - Grupo de detalle de vehículos nuevos

  /////////////////////////////////////////////////////////
  // Constructor
  /////////////////////////////////////////////////////////

  public function calcSubtEx() {
    if(isset($this->gValorItem) && isset($this->gValorItem->gValorRestaItem) && isset($this->gCamIVA)) {
      if($this->gCamIVA->getIAfecIVA() == CamIVAAfecIVA::GravadoParcial)
        return $this->gCamIVA->getDBasExe();
      else if($this->gCamIVA->getIAfecIVA() == CamIVAAfecIVA::Exento || $this->gCamIVA->getIAfecIVA() == CamIVAAfecIVA::Exonerado)
        return $this->gValorItem->getGValorRestaItem()->getDTotOpeItem();
      else
        return 0;
    }
    else
      return null;
  }

  public function getFormattedSubtEx() {
    if(is_null($this->calcSubtEx()))
      return null;
    else
      return NumberStringFormatter::FormatBCMAthNumber($this->calcSubtEx(), ',', '.');
  }

  public function calcSubt05() {
    if(isset($this->gValorItem) && isset($this->gValorItem->gValorRestaItem) && isset($this->gCamIVA))
      if($this->gCamIVA->getDTasaIVA() == 5)
        return $this->gCamIVA->getDBasGravIVA() + $this->gCamIVA->getDLiqIVAItem();
      else
        return 0;
    else
      return null;
  }

  public function getFormattedSubt05() {
    if(is_null($this->calcSubt05()))
      return null;
    else
      return NumberStringFormatter::FormatBCMAthNumber($this->calcSubt05(), ',', '.');
  }

  public function calcSubt10() {
    if(isset($this->gValorItem) && isset($this->gValorItem->gValorRestaItem) && isset($this->gCamIVA))
      if($this->gCamIVA->getDTasaIVA() == 10)
        return $this->gCamIVA->getDBasGravIVA() + $this->gCamIVA->getDLiqIVAItem();
      else
        return 0;
    else
      return null;
  }

  public function getFormattedSubt10() {
    if(is_null($this->calcSubt10()))
      return null;
    else
      return NumberStringFormatter::FormatBCMAthNumber($this->calcSubt10(), ',', '.');
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dCodInt
   *
   * @param String $dCodInt
   *
   * @return self
   */
  public function setDCodInt(String $dCodInt): self
  {
    $this->dCodInt = $dCodInt;

    return $this;
  }


  /**
   * Establece el valor de dParAranc
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
   * Establece el valor de dNCM
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
   * Establece el valor de dDncpG
   *
   * @param String $dDncpG
   *
   * @return self
   */
  public function setDDncpG(String $dDncpG): self
  {
    $this->dDncpG = $dDncpG;

    return $this;
  }


  /**
   * Establece el valor de dDncpE
   *
   * @param String $dDncpE
   *
   * @return self
   */
  public function setDDncpE(String $dDncpE): self
  {
    $this->dDncpE = $dDncpE;

    return $this;
  }


  /**
   * Establece el valor de dGtin
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
   * Establece el valor de dGtinPq
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
   * Establece el valor de dDesProSer
   *
   * @param String $dDesProSer
   *
   * @return self
   */
  public function setDDesProSer(String $dDesProSer): self
  {
    $this->dDesProSer = $dDesProSer;

    return $this;
  }


  /**
   * Establece el valor de cUniMed
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
   * Establece el valor de dDesUniMed
   * 
   * @param String $dDesUniMed
   * 
   * @return self
   */
  public function setDDesUniMed(String $dDesUniMed): self
  {
    if(is_null($dDesUniMed) || strlen($dDesUniMed) == 0)
    {
      $this->dDesUniMed;
    }
    else
    {
      $this->dDesUniMed = substr($dDesUniMed, 0, 10);
    }
    return $this;
  }


  /**
   * Establece el valor de dCantProSer (E711) que representa la cantidad del producto y/o servicio.
   *
   * @param int $dCantProSer Cantidad del producto y/o servicio (en cadena de texto decimal BCMath).
   *
   * @return self
   */
  public function setDCantProSer(String $dCantProSer): self
  {
    if(!ValueValidations::isValidStringDecimal($dCantProSer, 15, 0))
    {
      throw new \Exception("Valor inválido de dCantProSer: $dCantProSer");
    }
    $this->dCantProSer = $dCantProSer;
    return $this;
  }


  /**
   * Establece el valor de cPaisOrig
   *
   * @param String $cPaisOrig
   *
   * @return self
   */
  public function setCPaisOrig(String $cPaisOrig): self
  {
    $this->cPaisOrig = $cPaisOrig;
    $this->setDDesPaisOrig(CountryMapping::getCountryDesc($cPaisOrig));
    return $this;
  }

  /**
   * Establece el valor de dDesPaisOrig
   * 
   * @param String $dDesPaisOrig
   * 
   * @return self
   */
  public function setDDesPaisOrig(String $dDesPaisOrig): self
  {
    if(is_null($dDesPaisOrig) || strlen($dDesPaisOrig) == 0)
    {
      $this->dDesPaisOrig;
    }
    else
    {
      $this->dDesPaisOrig = substr($dDesPaisOrig, 0, 30);
    }
    return $this;
  }


  /**
   * Establece el valor de dInfItem
   *
   * @param String $dInfItem
   *
   * @return self
   */
  public function setDInfItem(String $dInfItem): self
  {
    $this->dInfItem = $dInfItem;

    return $this;
  }


  /**
   * Establece el valor de cRelMerc
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
   * Establece el valor de dDesRelMerc
   * 
   * @param String $dDesRelMerc
   * 
   * @return self
   */
  public function setDDesRelMerc(String $dDesRelMerc): self
  {
    if(is_null($dDesRelMerc) || strlen($dDesRelMerc) == 0)
    {
      $this->dDesRelMerc;
    }
    else
    {
      $this->dDesRelMerc = substr($dDesRelMerc, 0, 21);
    }
    return $this;
  }


  /**
   * Establece el valor de dCanQuiMer
   *
   * @param int $dCanQuiMer
   *
   * @return self
   */
  public function setDCanQuiMer(int $dCanQuiMer): self
  {
    if(!ValueValidations::isValidStringDecimal($dCanQuiMer, 15, 0))
    {
      throw new \Exception("Valor inválido de dCanQuiMer: $dCanQuiMer");
    }
    $this->dCanQuiMer = $dCanQuiMer;
    return $this;
  }


  /**
   * Establece el valor de dPorQuiMer
   *
   * @param int $dPorQuiMer
   *
   * @return self
   */
  public function setDPorQuiMer(int $dPorQuiMer): self
  {
    if(!ValueValidations::isValidStringDecimal($dPorQuiMer, 15, 0))
    {
      throw new \Exception("Valor inválido de dPorQuiMer: $dPorQuiMer");
    }
    $this->dPorQuiMer = $dPorQuiMer;
    return $this;
  }


  /**
   * Establece el valor de dCDCAnticipo
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
   * Establece el valor de gValorItem
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
   * Establece el valor de gCamIVa
   * 
   * @param GCamIVA $gCamIVA
   * 
   * @return self
   */
  public function setGCamIVa(GCamIVA $gCamIVA): self
  {
    $this->gCamIVA = $gCamIVA;
    return $this;
  }

  /**
   * Establece el valor de gRasMerc
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
   * Establece el valor de gVehNuevo
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
   * Obtiene el valor de dCodInt
   *
   * @return String
   */
  public function getDCodInt(): String
  {
    return $this->dCodInt;
  }

  /**
   * Obtiene el valor de dParAranc
   *
   * @return int
   */
  public function getDParAranc(): ?int
  {
    if(isset($this->dParAranc))
      return $this->dParAranc;
    else
      return null;
  }

  /**
   * Obtiene el valor de dNCM
   *
   * @return int
   */
  public function getDNCM(): ?int
  {
    if(isset($this->dNCM))
      return $this->dNCM;
    else
      return null;
  }

  /**
   * Obtiene el valor de dDncpG
   *
   * @return String
   */
  public function getDDncpG(): String
  {
    return $this->dDncpG;
  }

  /**
   * Obtiene el valor de dDncpE
   *
   * @return String
   */
  public function getDDncpE(): String
  {
    return $this->dDncpE;
  }

  /**
   * Obtiene el valor de dGtin
   *
   * @return int
   */
  public function getDGtin(): int
  {
    return $this->dGtin;
  }

  /**
   * Obtiene el valor de dGtinPq
   *
   * @return int
   */
  public function getDGtinPq(): int
  {
    return $this->dGtinPq;
  }

  /**
   * Obtiene el valor de dDesProSer
   *
   * @return String
   */
  public function getDDesProSer(): String
  {
    return $this->dDesProSer;
  }

  /**
   * Obtiene el valor de cUniMed
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
   * @return String
   */
  public function getDDesUniMed(): String
  {
    return $this->dDesUniMed;
  }

  /**
   * Obtiene el valor de dCantProSer
   *
   * @return int
   */
  public function getDCantProSer(): String
  {
    return $this->dCantProSer;
  }

  public function getFormattedDCantProSer(int $precision = 8): String
  {
    $rounded = bcadd($this->dCantProSer, '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }

  /**
   * Obtiene el valor de cPaisOrig
   *
   * @return String
   */

  public function getCPaisOrig(): String
  {
    return $this->cPaisOrig;
  }

  /**
   * E713 Descripción del país de origen del producto
   *
   * @return String
   */
  public function getDDesPaisOrig(): String
  {
    return $this->dDesPaisOrig;
  }


  /**
   * Obtiene el valor de dInfItem
   *
   * @return String
   */
  public function getDInfItem(): String
  {
    return $this->dInfItem;
  }

  /**
   * Obtiene el valor de cRelMerc
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
   * @return String
   */
  public function getDDesRelMerc(): String
  {
    return $this->dDesRelMerc;
  }

  /**
   * Obtiene el valor de dCanQuiMer
   *
   * @return String
   */
  public function getDCanQuiMer(): String
  {
    return $this->dCanQuiMer;
  }

  public function getFormattedDCanQuiMer(int $precision = 8): String
  {
    $rounded = bcadd($this->dCanQuiMer, '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }

  /**
   * Obtiene el valor de dPorQuiMer
   *
   * @return String
   */
  public function getDPorQuiMer(): String
  {
    return $this->dPorQuiMer;
  }

  public function getFormattedDPorQuiMer(int $precision = 8): String
  {
    $rounded = bcadd($this->dPorQuiMer, '0', $precision);
    return NumberStringFormatter::FormatBCMAthNumber($rounded, ',', '.');
  }

  /**
   * Obtiene el valor de dCDCAnticipo
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
    return $this->gCamIVA;
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
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamItem');
    $res->appendChild(new DOMElement('dCodInt', $this->getDCodInt()));
    if(isset($this->dParAranc))
      $res->appendChild(new DOMElement('dParAranc', $this->getDParAranc()));
    if(isset($this->dNCM))
      $res->appendChild(new DOMElement('dNCM', $this->getDNCM()));
    if(isset($this->dDncpG))
      $res->appendChild(new DOMElement('dDncpG', str_pad($this->dDncpG, 8, '0', STR_PAD_RIGHT)));
    if(isset($this->dDncpE))
      $res->appendChild(new DOMElement('dDncpE', $this->getDDncpE()));
    if(isset($this->dGtin))
      $res->appendChild(new DOMElement('dGtin', $this->getDGtin()));
    if(isset($this->dGtinPq))
      $res->appendChild(new DOMElement('dGtinPq', $this->getDGtinPq()));
    //check is ddDesProSer has the & character
    $res->appendChild(new DOMElement('dDesProSer', htmlspecialchars($this->getDDesProSer())));
    //$res->appendChild(new DOMElement('dDesProSer', $this->getDDesProSer()));
    $res->appendChild(new DOMElement('cUniMed', $this->getCUniMed()));
    $res->appendChild(new DOMElement('dDesUniMed', $this->getDDesUniMed()));
    $res->appendChild(new DOMElement('dCantProSer', $this->getDCantProSer()));
    if(isset($this->cPaisOrig))
      $res->appendChild(new DOMElement('cPaisOrig', $this->getCPaisOrig()));
    if(isset($this->dDesPaisOrig))
      $res->appendChild(new DOMElement('dDesPaisOrig', $this->getDDesPaisOrig()));
    if(isset($this->dInfItem))
      $res->appendChild(new DOMElement('dInfItem', $this->getDInfItem()));
    if(isset($this->cRelMerc))
      $res->appendChild(new DOMElement('cRelMerc', $this->cRelMerc));
    if(isset($this->dDesRelMerc))
      $res->appendChild(new DOMElement('dDesRelMerc', $this->getDDesRelMerc()));
    if(isset($this->dCanQuiMer))
      $res->appendChild(new DOMElement('dCanQuiMer', $this->getDCanQuiMer()));
    if(isset($this->dPorQuiMer))
      $res->appendChild(new DOMElement('dPorQuiMer', $this->getDPorQuiMer()));
    if(isset($this->dCDCAnticipo))
      $res->appendChild(new DOMElement('dCDCAnticipo', $this->getDCDCAnticipo()));
    
    if(isset($this->gValorItem))
      $res->appendChild($this->gValorItem->toDOMElement($doc));
    if(isset($this->gCamIVA))
      $res->appendChild($this->gCamIVA->toDOMElement($doc));
    if(isset($this->gRasMerc))
      $res->appendChild($this->gRasMerc->toDOMElement($doc));
    if(isset($this->gVehNuevo))
      $res->appendChild($this->gVehNuevo->toDOMElement($doc));
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
    $res = new GCamItem();
    if (isset($object->dCodInt)) {
      $res->setDCodInt($object->dCodInt);
    }
    if (isset($object->dParAranc)) {
      $res->setDParAranc($object->dParAranc);
    }
    if (isset($object->dNCM)) {
      $res->setDNCM($object->dNCM);
    }
    if (isset($object->dDDncpG)) {
      $res->setDDncpG($object->dDDncpG);
    }
    if (isset($object->dDDncpE)) {
      $res->setDDncpE($object->dDDncpE);
    }
    if (isset($object->dGtin)) {
      $res->setDGtin($object->dGtin);
    }
    if (isset($object->dGtinPq)) {
      $res->setDGtinPq($object->dGtinPq);
    }
    if (isset($object->dDesProSer)) {
      $res->setDDesProSer($object->dDesProSer);
    }
    if (isset($object->cUniMed)) {
      $res->setCUniMed($object->cUniMed);
    }
    if (isset($object->dCantProSer)) {
      $res->setDCantProSer($object->dCantProSer);
    }
    if (isset($object->cPaisOrig)) {
      $res->setCPaisOrig($object->cPaisOrig);
    }
    if (isset($object->dInfItem)) {
      $res->setDInfItem($object->dInfItem);
    }
    if (isset($object->dRelMerc)) {
      $res->setCRelMerc($object->dRelMerc);
    }
    if (isset($object->dCanQuiMer)) {
      $res->setDCanQuiMer($object->dCanQuiMer);
    }
    if (isset($object->dPorQuiMer)) {
      $res->setDPorQuiMer($object->dPorQuiMer);
    }
    if (isset($object->dCDCAnticipo)) {
      $res->setDCDCAnticipo($object->dCDCAnticipo);
    }
    // //CHILDREN
    if (isset($object->gValorItem)) {
      $res->setGValorItem(GValorItem::FromSifenResponseObject($object->gValorItem));
    }
    if (isset($object->gCamIVA)) {
      $res->setGCamIVa(GCamIVA::FromSifenResponseObject($object->gCamIVA));
    }
    if (isset($object->gRasMerc)) {
      $res->setGRasMerc(GRasMerc::FromSifenResponseObject($object->gRasMerc));
    }
    if (isset($object->gVehNuevo)) {
      $res->setGVehNuevo(GVehNuevo::FromSifenResponseObject($object->gVehNuevo));
    }
    return $res;
  }


  /**
   * Instancia un objeto GCamItem a partir de un DOMElement que lo representa.
   * 
   * @param DOMElement $node
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamItem') != 0)
        throw new \Exception('[GCamItem] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new self();
    $res->setDCodInt(trim($node->getElementsByTagName('dCodInt')->item(0)->nodeValue));
    if($node->getElementsByTagName('dParAranc')->length > 0)
      $res->setDParAranc(intval(trim($node->getElementsByTagName('dParAranc')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dNCM')->length > 0)
      $res->setDNCM(intval(trim($node->getElementsByTagName('dNCM')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dDncpG')->length > 0)
      $res->setDDncpG(trim($node->getElementsByTagName('dDncpG')->item(0)->nodeValue));
    if($node->getElementsByTagName('dDncpE')->length > 0)
      $res->setDDncpE(trim($node->getElementsByTagName('dDncpE')->item(0)->nodeValue));
    if($node->getElementsByTagName('dGtin')->length > 0)
      $res->setDGtin(intval(trim($node->getElementsByTagName('dGtin')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dGtinPq')->length > 0)
      $res->setDGtinPq(intval(trim($node->getElementsByTagName('dGtinPq')->item(0)->nodeValue)));
    $res->setDDesProSer(trim($node->getElementsByTagName('dDesProSer')->item(0)->nodeValue));
    $res->setCUniMed(intval(trim($node->getElementsByTagName('cUniMed')->item(0)->nodeValue)));
    $res->setDDesUniMed(trim($node->getElementsByTagName('dDesUniMed')->item(0)->nodeValue));
    $res->setDCantProSer(floatval(trim($node->getElementsByTagName('dCantProSer')->item(0)->nodeValue)));
    if($node->getElementsByTagName('cPaisOrig')->length > 0)
      $res->setCPaisOrig(trim($node->getElementsByTagName('cPaisOrig')->item(0)->nodeValue));
    if($node->getElementsByTagName('dDesPaisOrig')->length > 0)
      $res->setDDesPaisOrig(trim($node->getElementsByTagName('dDesPaisOrig')->item(0)->nodeValue));
    if($node->getElementsByTagName('dInfItem')->length > 0)
      $res->setDInfItem(trim($node->getElementsByTagName('dInfItem')->item(0)->nodeValue));
    if($node->getElementsByTagName('cRelMerc')->length > 0)
      $res->setCRelMerc(intval(trim($node->getElementsByTagName('cRelMerc')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dDesRelMerc')->length > 0)
      $res->setDDesRelMerc(trim($node->getElementsByTagName('dDesRelMerc')->item(0)->nodeValue));
    if($node->getElementsByTagName('dCanQuiMer')->length > 0)
      $res->setDCanQuiMer(trim($node->getElementsByTagName('dCanQuiMer')->item(0)->nodeValue));
    if($node->getElementsByTagName('dPorQuiMer')->length > 0)
      $res->setDPorQuiMer(trim($node->getElementsByTagName('dPorQuiMer')->item(0)->nodeValue));
    if($node->getElementsByTagName('dCDCAnticipo')->length > 0)
      $res->setDCDCAnticipo(trim($node->getElementsByTagName('dCDCAnticipo')->item(0)->nodeValue));
    if($node->getElementsByTagName('gValorItem')->length > 0)
      $res->setGValorItem(GValorItem::FromDOMElement($node->getElementsByTagName('gValorItem')->item(0)));
    if($node->getElementsByTagName('gCamIVA')->length > 0)
      $res->setGCamIVa(GCamIVA::FromDOMElement($node->getElementsByTagName('gCamIVA')->item(0)));
    if($node->getElementsByTagName('gRasMerc')->length > 0)
      $res->setGRasMerc(GRasMerc::FromDOMElement($node->getElementsByTagName('gRasMerc')->item(0)));
    if($node->getElementsByTagName('gVehNuevo')->length > 0)
      $res->setGVehNuevo(GVehNuevo::FromDOMElement($node->getElementsByTagName('gVehNuevo')->item(0)));
    return $res;
  }
}
