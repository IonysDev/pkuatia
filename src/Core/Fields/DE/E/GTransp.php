<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Constants\GTranspModTrans;
use IonysDev\Pkuatia\Core\Constants\GTranspRespFlete;
use IonysDev\Pkuatia\Core\Constants\GTranspTipTrans;
use IonysDev\Pkuatia\Core\Constants\Incoterm;
use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use IonysDev\Pkuatia\DataMappings\CountryMapping;
use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use Stringable;

/**
 * Nodo Id:     E900    
 * Nombre:      gTransp    
 * Descripción: Campos que describen  el transporte de mercaderías    
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico
 */
class GTransp extends BaseSifenField
{
                                   // Id - Longitud - Ocurrencia - Descripción
  public int        $iTipTrans;    // E901 - 1    - 0-1  - Tipo de transporte
  public String     $dDesTipTrans; // E902 - 6-7  - 0-1  - Descripción del tipo de transporte
  public int        $iModTrans;    // E903 - 1    - 1-1  - Modalidad de transporte
  public String     $dDesModTrans; // E904 - 5-10 - 1-1  - Descripción de la modalidad del transporte
  public int        $iRespFlete;   // E905 - 1    - 1-1  - Responsable del costo del flete
  public ?String    $cCondNeg;     // E906 - 3    - 0-1  - Condición de la negociación 
  public ?String    $dNuManif;     // E907 - 1-15 - 0-1  - Número de manifiesto o conocimiento de carga/declaración de tránsito aduanero/ Carta de porte internacional 
  public ?String    $dNuDespImp;   // E908 - 16   - 0-1  - Número de despacho de importación
  public ?DateTime  $dIniTras;     // E909 - 10   - 0-1  - Fecha estimada de inicio de traslado
  public ?DateTime  $dFinTras;     // E910 - 10   - 0-1  - Fecha estimada de fin  de traslado
  public ?String    $cPaisDest;    // E911 - 3    - 0-1  - Código del país de destino
  public ?String    $dPaisDest;    // E912 - 5-50 - 0-1  - Descripción del país de destino
  public ?GCamSal   $gCamSal;      // E920 - G    - 0-1  - Campos que identifican el local de salida de las mercaderías 
  public ?array     $gCamEnt;      // E940 - G    - 0-99 - Campos que identifican el local de la entrega de las mercaderías
  public ?array     $gVehTras;     // E960 - G    - 0-4  - Campos que identifican al vehículo del traslado de mercaderías
  public ?GCamTrans $gCamTrans;    // E980 - G    - 0-1  - Campos que identifican al transportista

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iTipTrans (E901) que indica el tipo de transporte, así como su descripción dDesTipTrans (E902).
   * Este valor es obligatorio para el tipo de documento electrónico Nota de Remisión (C002 = 7).
   * Los valores permitidos son:
   * - 1: Propio
   * - 2: Tercero
   *
   * @param int|GTranspTipTrans $iTipTrans Código del tipo de transporte.
   * 
   * @return self 
   */
  public function setITipTrans(int|GTranspTipTrans $iTipTrans): self
  {
s    $this->iTipTrans = $iTipTrans instanceof GTranspTipTrans ? $iTipTrans->value : $iTipTrans;
    $this->dDesTipTrans = GTranspTipTrans::getDescripcionFromInt($this->iTipTrans);
    return $this;
  }

  /**
   * Establece la descripción del tipo de transporte (E902).
   * Esta función no debería ser llamada directamente, salvo para deserializar un DE existente, ya que el valor de este campo se establece automáticamente al establecer el valor de iTipTrans (E901).
   * 
   * @param String $dDesTipTrans Descripción del tipo de transporte.
   * 
   * @return self
   */
  public function setDDesTipTrans(String $dDesTipTrans): self
  {
    $this->dDesTipTrans = $dDesTipTrans;
    return $this;
  }


  /**
   * Establece el valor de iModTrans (E903) que indica la modalidad de transporte, así como su descripción dDesModTrans (E904).
   *
   * @param int|GTranspModTrans $iModTrans Código de la modalidad de transporte.
   *
   * @return self
   */
  public function setIModTrans(int|GTranspModTrans $iModTrans): self
  {
    $this->iModTrans = $iModTrans instanceof GTranspModTrans ? $iModTrans->value : $iModTrans;
    $this->dDesModTrans = GTranspModTrans::getDescripcion($this->iModTrans);
    return $this;
  }

  /**
   * Establece la descripción de la modalidad de transporte (E904).
   * Esta función no debería ser llamada directamente, salvo para deserializar un DE existente, ya que el valor de este campo se establece automáticamente al establecer el valor de iModTrans (E903).
   * 
   * @param String $dDesModTrans Descripción de la modalidad de transporte.
   * 
   * @return self
   */
  public function setDDesModTrans(String $dDesModTrans): self
  {
    $this->dDesModTrans = $dDesModTrans;
    return $this;
  }

  /**
   * Establece el valor de iRespFlete (E905) que indica el responsable del costo del flete.
   *
   * @param int $iRespFlete Código del responsable del costo del flete.
   *
   * @return self
   */
  public function setIRespFlete(int|GTranspRespFlete $iRespFlete): self
  {
    $this->iRespFlete = $iRespFlete instanceof GTranspRespFlete ? $iRespFlete->value : $iRespFlete;
    return $this;
  }

  /**
   * Establece el valor de cCondNeg (E906) que indica la condición o INCOTERM de la negociación.
   *
   * @param String|Incoterm $cCondNeg Código de la condición o INCOTERM de la negociación.
   *
   * @return self
   */
  public function setCCondNeg(String|Incoterm $cCondNeg): self
  {
    $this->cCondNeg = $cCondNeg instanceof Incoterm ? $cCondNeg->value : $cCondNeg;
    return $this;
  }


  /**
   * Establece el valor de dNuManif (E907) que indica el número de manifiesto o conocimiento de carga/declaración de tránsito aduanero/ Carta de porte internacional.
   *
   * @param String $dNuManif Número de manifiesto de carga o guía.
   *
   * @return self
   */
  public function setDNuManif(String $dNuManif): self
  {
    $this->dNuManif = $dNuManif;
    return $this;
  }


  /**
   * Establece el valor de dNuDespImp (E908) que indica el número de despacho de importación.
   *
   * @param String $dNuDespImp Número de despacho de importación.
   *
   * @return self
   */
  public function setDNuDespImp(String $dNuDespImp): self
  {
    $this->dNuDespImp = $dNuDespImp;
    return $this;
  }


  /**
   * Establece el valor de dIniTras (E909) que indica la fecha estimada de inicio de traslado.
   *
   * @param DateTime $dIniTras Fecha estimada de inicio de traslado.
   *
   * @return self
   */
  public function setDIniTras(DateTime $dIniTras): self
  {
    $this->dIniTras = $dIniTras;
    return $this;
  }


  /**
   * Establece el valor de dFinTras (E910) que indica la fecha estimada de fin de traslado.
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
   * Establece el valor de cPaisDest
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
   * Obtiene el valor de iTipTrans
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
   * Obtiene el valor de iModTrans
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
   * Obtiene el valor de iRespFlete
   *
   * @return int
   */
  public function getIRespFlete(): int
  {
    return $this->iRespFlete;
  }

  /**
   * Obtiene el valor de cCondNeg
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
   * Obtiene el valor de dNuManif
   *
   * @return String
   */
  public function getDNuManif(): String
  {
    return $this->dNuManif;
  }

  /**
   * Obtiene el valor de dNuDespImp
   *
   * @return String
   */
  public function getDNuDespImp(): String
  {
    return $this->dNuDespImp;
  }

  /**
   * Obtiene el valor de dIniTras
   *
   * @return DateTime
   */
  public function getDIniTras(): DateTime
  {
    return $this->dIniTras;
  }

  /**
   * Obtiene el valor de dFinTras
   *
   * @return DateTime
   */
  public function getDFinTras(): DateTime
  {
    return $this->dFinTras;
  }

  /**
   * Obtiene el valor de cPaisDest
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
   * Obtiene el valor de gCamSal
   *
   * @return GCamSal
   */
  public function getGCamSal(): GCamSal
  {
    return $this->gCamSal;
  }

  /**
   * Establece el valor de gCamSal
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
   * Obtiene el valor de gVehTras
   *
   * @return GVehTras
   */
  public function getGVehTras(): GVehTras
  {
    return $this->gVehTras;
  }

  /**
   * Establece el valor de gVehTras
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
   * Obtiene el valor de gCamTrans
   *
   * @return GCamTrans
   */
  public function getGCamTrans(): GCamTrans
  {
    return $this->gCamTrans;
  }

  /**
   * Establece el valor de gCamTrans
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
   * Obtiene el valor de gCamEnt
   *
   * @return GCamEnt
   */
  public function getGCamEnt(): GCamEnt
  {
    return $this->gCamEnt;
  }

  /**
   * Establece el valor de gCamEnt
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
