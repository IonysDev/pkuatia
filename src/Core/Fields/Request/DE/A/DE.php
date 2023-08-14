<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\A;

use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\G\GCamGen;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\H\GCamDEAsoc;
use DateTime;
use DOMElement;

/**
 * ID:A001  Campos firmados del DE PADRE:AA001
 */
class DE
{
  public String   $id;        // A002 - Identificador del DE
  public int      $dDVId;     // A003 - dígito verificador del dentificador del DE 
  public DateTime $dFecFirma; // A004 - Fecha de la firma
  public int      $dSisFact;  // A005 - Sistema de facturación

  public GOpeDE      $gOpeDe;      // Campos inherentes a la operación de DE
  public GTimb       $gTimb;       // Datos del timbrado 
  public GDatGralOpe $gDatGralOpe; // Campos generales del DE
  public GDtipDE     $gDtipDe;     // Campos específicos por tipo de Documento Electrónico 
  public GTotSub     $gTotSub;     // Campos de subtotales y totales
  public GCamGen     $gCamGen;     // Campos de uso general
  public GCamDEAsoc  $gCamDEAsoc;  // Campos que identifican al DE asociado

  public function __construct()
  {
    $this->dSisFact = Constants::SISTEMA_FACTURACION_CONTRIBUYENTE;
    $this->gOpeDe = new GOpeDE();
    $this->gTimb = new GTimb();
    $this->gDatGralOpe = new GDatGralOpe();
    $this->gDtipDe = new GDtipDE();
    $this->gCamGen = new GCamGen();
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iD
   *
   * @param String $iD
   *
   * @return self
   */
  public function setId(String $id): self
  {
    $this->id = $id;
    return $this;
  }


  /**
   * Set the value of dDVId
   *
   * @param int $dDVId
   *
   * @return self
   */
  public function setDDVId(int $dDVId): self
  {
    $this->dDVId = $dDVId;
    return $this;
  }


  /**
   * Set the value of dFecFirma
   *
   * @param DateTime $dFecFirma
   *
   * @return self
   */
  public function setDFecFirma(DateTime $dFecFirma): self
  {
    $this->dFecFirma = $dFecFirma;
    return $this;
  }


  /**
   * Set the value of dSisFact
   *
   * @param int $dSisFact
   *
   * @return self
   */
  public function setDSisFact(int $dSisFact): self
  {
    $this->dSisFact = $dSisFact;
    return $this;
  }

  /**
   * Establece el valor de gOpeDe
   * 
   * @param GOpeDE $gOpeDe
   * 
   * @return self
   */
  public function setGOpeDe(GOpeDE $gOpeDe): self
  {
    $this->gOpeDe = $gOpeDe;
    return $this;
  }

  /**
   * Establece el valor de gTimb
   * 
   * @param GTimb $gTimb
   * 
   * @return self
   */
  public function setGTimb(GTimb $gTimb): self
  {
    $this->gTimb = $gTimb;
    return $this;
  }

  /**
   * Establece el valor de gDatGralOpe
   * 
   * @param GDatGralOpe $gDatGralOpe
   * 
   * @return self
   */
  public function setGDatGralOpe(GDatGralOpe $gDatGralOpe): self
  {
    $this->gDatGralOpe = $gDatGralOpe;
    return $this;
  }

  /**
   * Establece el valor de gDtipDe
   * 
   * @param GDtipDE $gDtipDe
   * 
   * @return self
   */
  public function setGDtipDe(GDtipDE $gDtipDe): self
  {
    $this->gDtipDe = $gDtipDe;
    return $this;
  }

  /**
   * Establece el valor de gTotSub
   * 
   * @param GTotSub $gTotSub
   * 
   * @return self
   */
  public function setGTotSub(GTotSub $gTotSub): self
  {
    $this->gTotSub = $gTotSub;
    return $this;
  }

  /**
   * Establece el valor de gCamGen
   * 
   * @param GCamGen $gCamGen
   * 
   * @return self
   */
  public function setGCamGen(GCamGen $gCamGen): self
  {
    $this->gCamGen = $gCamGen;
    return $this;
  }

  /**
   * Establece el valor de gCamDEAsoc
   * 
   * @param GCamDEAsoc $gCamDEAsoc
   * 
   * @return self
   */
  public function setGCamDEAsoc(GCamDEAsoc $gCamDEAsoc): self
  {
    $this->gCamDEAsoc = $gCamDEAsoc;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of iD
   *
   * @return string
   */
  public function getId(): String
  {
    return $this->id;
  }

  /**
   * Get the value of dDVId
   *
   * @return int
   */
  public function getDDVId(): int
  {
    return $this->dDVId;
  }

  /**
   * Get the value of dFecFirma
   *
   * @return DateTime
   */
  public function getDFecFirma(): DateTime
  {
    return $this->dFecFirma;
  }

  /**
   * Get the value of dSisFact
   *
   * @return int
   */
  public function getDSisFact(): int
  {
    return $this->dSisFact;
  }

  /**
   * Devuelve el valor de gOpeDe
   * 
   * @return GOpeDE
   */
  public function getGOpeDe(): GOpeDE
  {
    return $this->gOpeDe;
  }

  /**
   * Devuelve el valor de gTimb
   * 
   * @return GTimb
   */
  public function getGTimb(): GTimb
  {
    return $this->gTimb;
  }

  /**
   * Devuelve el valor de gDatGralOpe
   * 
   * @return GDatGralOpe
   */
  public function getGDatGralOpe(): GDatGralOpe
  {
    return $this->gDatGralOpe;
  }

  /**
   * Devuelve el valor de gDtipDe
   * 
   * @return GDtipDE
   */
  public function getGDtipDe(): GDtipDE
  {
    return $this->gDtipDe;
  }

  /**
   * Devuelve el valor de gTotSub
   * 
   * @return GTotSub
   */
  public function getGTotSub(): GTotSub
  {
    return $this->gTotSub;
  }

  /**
   * Devuelve el valor de gCamGen
   * 
   * @return GCamGen
   */
  public function getGCamGen(): GCamGen
  {
    return $this->gCamGen;
  }

  /**
   * Devuelve el valor de gCamDEAsoc
   * 
   * @return GCamDEAsoc
   */
  public function getGCamDEAsoc(): GCamDEAsoc
  {
    return $this->gCamDEAsoc;
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
    $res = new DOMElement('DE');

    $res->setAttribute('Id', $this->getId());
    $res->appendChild(new DOMElement('dDVId', $this->getDDVId()));
    $res->appendChild(new DOMElement('dFecFirma', $this->getDFecFirma()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('dSisFact', $this->getDSisFact()));
    ///children
    $res->appendChild($this->gOpeDe->toDOMElement());
    $res->appendChild($this->gTimb->toDOMElement());
    $res->appendChild($this->gDatGralOpe->toDOMElement());
    $res->appendChild($this->gDtipDe->toDOMElement());
    $res->appendChild($this->gTotSub->toDOMElement());
    $res->appendChild($this->gCamGen->toDOMElement());
    $res->appendChild($this->gCamDEAsoc->toDOMElement());

    return $res;
  }

  /**
   * Devuelve un objeto DE a partir de un SimpleXMLElement
   * 
   * @param \SimpleXMLElement $xml
   * 
   * @return DE 
   */
  public static function FromSimpleXMLElement(\SimpleXMLElement $xml)
  {
    if(strcmp($xml->getName(), 'DE') != 0)
      throw new \Exception('Invalid XML Node Name: ' . $xml->getName());
    
    $res = new DE();
    $res->id = $xml->attributes()['Id'];
    $res->dDVId = intval($xml->dDVId);
    $res->dFecFirma = DateTime::createFromFormat(DateTime::ATOM, $xml->dFecFirma);
    $res->dSisFact = intval($xml->dSisFact);

    $res->gOpeDe = GOpeDE::FromSimpleXMLElement($xml->gOpeDe);
    $res->gTimb = GTimb::FromSimpleXMLElement($xml->gTimb);
    $res->gDatGralOpe = GDatGralOpe::FromSimpleXMLElement($xml->gDatGralOpe);
    $res->gDtipDe = GDtipDE::FromSimpleXMLElement($xml->gDtipDE);
    $res->gTotSub = GTotSub::FromSimpleXMLElement($xml->gTotSub);
    $res->gCamGen = GCamGen::FromSimpleXMLElement($xml->gCamGen);
    $res->gCamDEAsoc = GCamDEAsoc::FromSimpleXMLElement($xml->gCamDEAsoc);

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
    ///se castea en array para la Id porque trae el @atribute y eso no se puede usar con las flechitas
    $array = json_decode(json_encode($response), true);
    $de = new DE();
    if (isset($array['@attributes']['Id'])) {
      $de->setID($array['@attributes']['Id']);
    }
    if (isset($response->dDVId)) {
      $de->setDDVId(intval($response->dDVId));
    }
    if (isset($response->dFecFirma)) {
      $de->setDFecFirma(DateTime::createFromFormat('Y-m-d\TH:i:s', $response->dFecFirma));
    }
    if (isset($response->dSisFact)) {
      $de->setDSisFact($response->dSisFact);
    }
    ///Children
    if (isset($response->gOpeDE)) {
      $de->setGOpeDe(GOpeDE::fromResponse($response->gOpeDE));
    }
    if (isset($response->gTimb)) {
      $de->setGTimb(GTimb::fromResponse($response->gTimb));
    }
    if (isset($response->gDatGralOpe)) {
      $de->setGDatGralOpe(GDatGralOpe::fromResponse($response->gDatGralOpe));
    }
    if (isset($response->gDtipDE)) {
      $de->setGDtipDe(GDtipDE::fromResponse($response->gDtipDE));
    }
    if (isset($response->gTotSub)) {
      $de->setGTotSub(GTotSub::fromResponse($response->gTotSub));
    }
    if (isset($response->gCamGen)) {
      $de->setGCamGen(GCamGen::fromResponse($response->gCamGen));
    }
    if (isset($response->gCamDEAsoc)) {
      $de->setGCamDEAsoc(GCamDEAsoc::fromResponse($response->gCamDEAsoc));
    }
    return $de;
  }
}
