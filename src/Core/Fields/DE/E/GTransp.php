<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\DataMappings\CountryMapping;
use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * ID:E900 
 *Campos que describen  el transporte de mercaderías
 * PADRE:E001
 */
class GTransp
{
  public ?int $iTipTrans;     // E901 - Tipo de transporte
  public ?int $iModTrans;     // E903 - Modalidad de transporte
  public ?int $iRespFlete;    // E905 - Responsable del costo del flete
  public String $cCondNeg;   // E906 - Condición de la negociación 
  public String $dNuManif;   // E907 - Número de manifiesto o conocimiento de carga/declaración de tránsito aduanero/ Carta de porte internacional 
  public String $dNuDespImp; // E908 - Número de despacho de importación
  public ?DateTime $dIniTras; // E909 - Fecha estimada de inicio de traslado
  public ?DateTime $dFinTras; // E910 - Fecha estimada de fin  de traslado
  public String $cPaisDest;  // E911 - Código del país de destino
  public ?GCamSal $gCamSal;   // Campos que identifican el local de salida de las mercaderías 
  public ?GCamEnt $gCamEnt;   // Campos que identifican el local de la entrega de las mercaderías
  public ?GVehTras $gVehTras; // Campos que identifican al vehículo del traslado de mercaderías
  public ?GCamTrans $gCamTrans; // Campos que identifican al transportista

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iTipTrans
   *
   * @param int $iTipTrans
   *
   * @return self
   */
  public function setITipTrans(int $iTipTrans): self
  {
    $this->iTipTrans = $iTipTrans;

    return $this;
  }


  /**
   * Set the value of iModTrans
   *
   * @param int $iModTrans
   *
   * @return self
   */
  public function setIModTrans(int $iModTrans): self
  {
    $this->iModTrans = $iModTrans;

    return $this;
  }


  /**
   * Set the value of iRespFlete
   *
   * @param int $iRespFlete
   *
   * @return self
   */
  public function setIRespFlete(int $iRespFlete): self
  {
    $this->iRespFlete = $iRespFlete;

    return $this;
  }


  /**
   * Set the value of cCondNeg
   *
   * @param String $cCondNeg
   *
   * @return self
   */
  public function setCCondNeg(String $cCondNeg): self
  {
    $this->cCondNeg = $cCondNeg;

    return $this;
  }


  /**
   * Set the value of dNuManif
   *
   * @param String $dNuManif
   *
   * @return self
   */
  public function setDNuManif(String $dNuManif): self
  {
    $this->dNuManif = $dNuManif;

    return $this;
  }


  /**
   * Set the value of dNuDespImp
   *
   * @param String $dNuDespImp
   *
   * @return self
   */
  public function setDNuDespImp(String $dNuDespImp): self
  {
    $this->dNuDespImp = $dNuDespImp;

    return $this;
  }


  /**
   * Set the value of dIniTras
   *
   * @param DateTime $dIniTras
   *
   * @return self
   */
  public function setDIniTras(DateTime $dIniTras): self
  {
    $this->dIniTras = $dIniTras;

    return $this;
  }


  /**
   * Set the value of dFinTras
   *
   * @param DateTime $dFinTras
   *
   * @return self
   */
  public function setDFinTras(DateTime $dFinTras): self
  {
    $this->dFinTras = $dFinTras;

    return $this;
  }


  /**
   * Set the value of cPaisDest
   *
   * @param String $cPaisDest
   *
   * @return self
   */
  public function setCPaisDest(String $cPaisDest): self
  {
    $this->cPaisDest = $cPaisDest;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///Getters
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of iTipTrans
   *
   * @return int
   */
  public function getITipTrans(): int
  {
    return $this->iTipTrans;
  }

  /**
   * E902 Descripción del tipo de transporte 
   *
   * @return String
   */
  public function getDDesTipTrans(): String
  {
    switch ($this->iTipTrans) {
      case 1:
        return "Propio";
        break;

      case 2:
        return "Tercero";
        break;

      default:
        return null;
        break;
    }
  }

  /**
   * Get the value of iModTrans
   *
   * @return int
   */
  public function getIModTrans(): int
  {
    return $this->iModTrans;
  }

  /**
   * E904 Descripción de la modalidad del transporte
   *
   * @return String
   */
  public function getDDesModTrans(): String
  {
    switch ($this->iModTrans) {
      case 1:
        return "Terrestre";
        break;

      case 2:
        return "Fluvial";
        break;

      case 3:
        return "Aéreo";
        break;

      case 4:
        return "Multimodal";
        break;

      default:
        return null;
        break;
    }
  }



  /**
   * Get the value of iRespFlete
   *
   * @return int
   */
  public function getIRespFlete(): int
  {
    return $this->iRespFlete;
  }

  /**
   * Get the value of cCondNeg
   *
   * @return String
   */
  public function getCCondNeg(): String
  {
    switch ($this->cCondNeg) {
      case 'CFR':
        return "Costo y flete";
        break;
      case 'CIF':
        return "Costo, seguro y flete";
        break;
      case 'CIP':
        return "Transporte y seguro pagados hasta";
        break;
      case 'CPT':
        return "Transporte pagado hasta";
        break;
      case 'DAP':
        return "Entregada en lugar convenido";
        break;
      case 'DAT':
        return "Entregada en terminaL";
        break;
      case 'DDP':
        return "Entregada derechos pagados";
        break;
      case 'EXW':
        return "En fabrica";
        break;
      case 'FAS':
        return "Franco al costado del buque";
        break;
      case 'FCA':
        return "Franco transportista";
        break;
      case 'FOB':
        return "Franco a bordo";
        break;

      default:
        return null;
        break;
    }
  }

  /**
   * Get the value of dNuManif
   *
   * @return String
   */
  public function getDNuManif(): String
  {
    return $this->dNuManif;
  }

  /**
   * Get the value of dNuDespImp
   *
   * @return String
   */
  public function getDNuDespImp(): String
  {
    return $this->dNuDespImp;
  }

  /**
   * Get the value of dIniTras
   *
   * @return DateTime
   */
  public function getDIniTras(): DateTime
  {
    return $this->dIniTras;
  }

  /**
   * Get the value of dFinTras
   *
   * @return DateTime
   */
  public function getDFinTras(): DateTime
  {
    return $this->dFinTras;
  }

  /**
   * Get the value of cPaisDest
   *
   * @return String
   */
  public function getCPaisDest(): String
  {
    return $this->cPaisDest;
  }

  /**
   * E912 Descripción del país de destino
   *
   * @return String
   */
  public function getDDesPaisDest(): String
  {
    return CountryMapping::getCountryDesc($this->cPaisDest);
  }

  ///////////////////////////////////////////////////////////////////////
  // XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gTransp');
    $res->appendChild(new DOMElement('iTipTrans', $this->getITipTrans()));
    if (isset($this->iTipTrans))
      $res->appendChild(new DOMElement('dDesTipTrans', $this->getDDesTipTrans()));
    $res->appendChild(new DOMElement('iModTrans', $this->getIModTrans()));
    $res->appendChild(new DOMElement('dDesModTrans', $this->getDDesModTrans()));
    $res->appendChild(new DOMElement('iRespFlete', $this->getIRespFlete()));
    $res->appendChild(new DOMElement('cCondNeg', $this->getCCondNeg()));
    $res->appendChild(new DOMElement('dNuManif', $this->getDNuManif()));
    $res->appendChild(new DOMElement('dNuDespImp', $this->getDNuDespImp()));
    $res->appendChild(new DOMElement('dIniTras', $this->getDFinTras()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFinTras', $this->getDFinTras()->format('Y-m-d')));
    $res->appendChild(new DOMElement('cPaisDest', $this->getCPaisDest()));
    $res->appendChild(new DOMElement('dDesPaisDest', $this->getDDesPaisDest()));
    $res->appendChild($this->gCamSal->toDOMElement($doc));
    $res->appendChild($this->gCamEnt->toDOMElement($doc));
    $res->appendChild($this->gVehTras->toDOMElement($doc));
    $res->appendChild($this->gCamTrans->toDOMElement($doc));
    return $res;
  }

  /**
   * Instancia un objeto GTransp a partir de un DOMElement obtenido de un documento XML.
   * 
   * @param DOMElement $node Nodo DOMElement que contiene los datos.
   * 
   * @return self Objeto GTransp instanciado.
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gTransp') != 0)
      throw new \Exception('[GTransp] El nombre del nodo no es gTransp: ' . $node->nodeName);
    $res = new self();
    if($node->getElementsByTagName('iTipTrans')->length > 0)
      $res->setITipTrans(intval($node->getElementsByTagName('iTipTrans')->item(0)->nodeValue));
    if($node->getElementsByTagName('iModTrans')->length > 0)
      $res->setIModTrans(intval($node->getElementsByTagName('iModTrans')->item(0)->nodeValue));
    if($node->getElementsByTagName('iRespFlete')->length > 0)
      $res->setIRespFlete(intval($node->getElementsByTagName('iRespFlete')->item(0)->nodeValue));
    if($node->getElementsByTagName('cCondNeg')->length > 0)
      $res->setCCondNeg($node->getElementsByTagName('cCondNeg')->item(0)->nodeValue);
    if($node->getElementsByTagName('dNuManif')->length > 0)
      $res->setDNuManif($node->getElementsByTagName('dNuManif')->item(0)->nodeValue);
    if($node->getElementsByTagName('dNuDespImp')->length > 0)
      $res->setDNuDespImp($node->getElementsByTagName('dNuDespImp')->item(0)->nodeValue);
    if($node->getElementsByTagName('dIniTras')->length > 0)
      $res->setDIniTras(DateTime::createFromFormat('Y-m-d', $node->getElementsByTagName('dIniTras')->item(0)->nodeValue));
    if($node->getElementsByTagName('dFinTras')->length > 0)
      $res->setDFinTras(DateTime::createFromFormat('Y-m-d', $node->getElementsByTagName('dFinTras')->item(0)->nodeValue));
    if($node->getElementsByTagName('cPaisDest')->length > 0)
      $res->setCPaisDest($node->getElementsByTagName('cPaisDest')->item(0)->nodeValue);
    if($node->getElementsByTagName('gCamSal')->length > 0)
      $res->setGCamSal(GCamSal::FromDOMElement($node->getElementsByTagName('gCamSal')->item(0)));
    if($node->getElementsByTagName('gCamEnt')->length > 0)
      $res->setGCamEnt(GCamEnt::FromDOMElement($node->getElementsByTagName('gCamEnt')->item(0)));
    if($node->getElementsByTagName('gVehTras')->length > 0)
      $res->setGVehTras(GVehTras::FromDOMElement($node->getElementsByTagName('gVehTras')->item(0)));
    if($node->getElementsByTagName('gCamTrans')->length > 0)
      $res->setGCamTrans(GCamTrans::FromDOMElement($node->getElementsByTagName('gCamTrans')->item(0)));
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  //Others
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of gCamSal
   *
   * @return GCamSal
   */
  public function getGCamSal(): GCamSal
  {
    return $this->gCamSal;
  }

  /**
   * Set the value of gCamSal
   *
   * @param GCamSal $gCamSal
   *
   * @return self
   */
  public function setGCamSal(GCamSal $gCamSal): self
  {
    $this->gCamSal = $gCamSal;

    return $this;
  }

  /**
   * Get the value of gVehTras
   *
   * @return GVehTras
   */
  public function getGVehTras(): GVehTras
  {
    return $this->gVehTras;
  }

  /**
   * Set the value of gVehTras
   *
   * @param GVehTras $gVehTras
   *
   * @return self
   */
  public function setGVehTras(GVehTras $gVehTras): self
  {
    $this->gVehTras = $gVehTras;

    return $this;
  }

  /**
   * Get the value of gCamTrans
   *
   * @return GCamTrans
   */
  public function getGCamTrans(): GCamTrans
  {
    return $this->gCamTrans;
  }

  /**
   * Set the value of gCamTrans
   *
   * @param GCamTrans $gCamTrans
   *
   * @return self
   */
  public function setGCamTrans(GCamTrans $gCamTrans): self
  {
    $this->gCamTrans = $gCamTrans;

    return $this;
  }

  /**
   * Get the value of gCamEnt
   *
   * @return GCamEnt
   */
  public function getGCamEnt(): GCamEnt
  {
    return $this->gCamEnt;
  }

  /**
   * Set the value of gCamEnt
   *
   * @param GCamEnt $gCamEnt
   *
   * @return self
   */
  public function setGCamEnt(GCamEnt $gCamEnt): self
  {
    $this->gCamEnt = $gCamEnt;

    return $this;
  }

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GTransp();
    if(isset($object->iModTrans))
    {
      $res->setIModTrans(intval($object->iModTrans));
    }
    if(isset($object->iTipTrans))
    {
      $res->setITipTrans(intval($object->iTipTrans));
    }
    if(isset($object->iRespFlete))
    {
      $res->setIRespFlete(intval($object->iRespFlete));
    }
    if(isset($object->cCondNeg))
    {
      $res->setCCondNeg($object->cCondNeg);
    }
    if(isset($object->dNuManif))
    {
      $res->setDNuManif($object->dNuManif);
    }
    if(isset($object->dNuDespImp))
    {
      $res->setDNuDespImp($object->dNuDespImp);
    }
    if(isset($object->dIniTras))
    {
      $res->setDIniTras(DateTime::createFromFormat('Y-m-d', $object->dIniTras));
    }
    if(isset($object->dFinTras))
    {
      $res->setDFinTras(DateTime::createFromFormat('Y-m-d', $object->dFinTras));
    }
    if(isset($object->cPaisDest))
    {
      $res->setCPaisDest($object->cPaisDest);
    }
    if (isset($object->gCamSal)) {
      $res->setGCamSal(GCamSal::FromSifenResponseObject($object->gCamSal));
    }

    if (isset($object->gCamEnt)) {
      $res->setGCamEnt(GCamEnt::FromSifenResponseObject($object->gCamEnt));
    }

    if (isset($object->gVehTras)) {
      $res->setGVehTras(GVehTras::FromSifenResponseObject($object->gVehTras));
    }

    if (isset($object->gCamTrans)) {
      $res->setGCamTrans(GCamTrans::FromSifenResponseObject($object->gCamTrans));
    }

    return $res;
  }

  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    throw new \Exception("[GTransp] Function FromSimpleXMLElement Not implemented");
    $res = new self();
    return $res;
  }
}
