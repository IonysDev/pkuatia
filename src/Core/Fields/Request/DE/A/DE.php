<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\A;




use Abiliomp\Pkuatia\Core\Fields\G\GCamGen;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\H\GCamDEAsoc;
use DateTime;
use DOMElement;

/**
 * ID:A001  Campos firmados del DE PADRE:AA001
 */
class DE
{
  public ?string $iD = null;               // A002 - Identificador del DE
  public ?int $dDVId = null;               // A003 - dígito verificador del dentificador del DE 
  public ?DateTime $dFecFirma = null;      // A004 - Fecha de la firma
  public ?int $dSisFact = null;            // A005 - Sistema de facturación
  public ?GOpeDE $gOpeDe = null;           // Campos inherentes a la operación de DE
  public ?GTimb $gTimb = null;             // Datos del timbrado 
  public ?GDatGralOpe $dDatGralOpe = null; // Campos generales del DE
  public ?GDtipDE $gDtipDe = null;
  public ?GTotSub $gTotSub = null;
  public ?GCamGen $gCamGen = null;
  public ?GCamDEAsoc $gCamDEAsoc = null;

  //====================================================//
  ///Setters
  //====================================================//

  /**
   * Set the value of iD
   *
   * @param string $iD
   *
   * @return self
   */
  public function setID(string $iD): self
  {
    $this->iD = $iD;

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

  //====================================================//
  ///Getters
  //====================================================//

  /**
   * Get the value of iD
   *
   * @return string
   */
  public function getID(): string | null
  {
    return $this->iD;
  }

  /**
   * Get the value of dDVId
   *
   * @return int
   */
  public function getDDVId(): int | null
  {
    return $this->dDVId;
  }

  /**
   * Get the value of dFecFirma
   *
   * @return DateTime
   */
  public function getDFecFirma(): DateTime | null
  {
    return $this->dFecFirma;
  }

  /**
   * Get the value of dSisFact
   *
   * @return int
   */
  public function getDSisFact(): int | null
  {
    return $this->dSisFact;
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
    $res = new DOMElement('DE');

    $res->setAttribute('Id', $this->getID());
    $res->appendChild(new DOMElement('dDVId', $this->getDDVId()));
    $res->appendChild(new DOMElement('dFecFirma', $this->getDFecFirma()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('dSisFact', $this->getDSisFact()));
    ///children
    $res->appendChild($this->gOpeDe->toDOMElement());
    $res->appendChild($this->gTimb->toDOMElement());
    $res->appendChild($this->dDatGralOpe->toDOMElement());
    $res->appendChild($this->gDtipDe->toDOMElement());
    $res->appendChild($this->gTotSub->toDOMElement());
    $res->appendChild($this->gCamGen->toDOMElement());
    $res->appendChild($this->gCamDEAsoc->toDOMElement());

    return $res;
  }


  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return DE
  //  */
  // public static function fromDOMElement(DOMElement $xml): DE
  // {
  //   if (strcmp($xml->tagName, 'DE') == 0 && $xml->childElementCount == 11) {
  //     $res = new DE();
  //     $res->setID($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setDDVId(intval($xml->getElementsByTagName('dDVId')->item(0)->nodeValue));
  //     $res->setDFecFirma(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecFirma')->item(0)->nodeValue));
  //     $res->setDSisFact(intval($xml->getElementsByTagName('dSisFact')->item(0)->nodeValue));
  //     ///Children
  //     $res->setGOpeDe($res->gOpeDe->fromDOMElement($xml->getElementsByTagName('gOpeDE')->item(0)->nodeValue));
  //     $res->setGTimb($res->gTimb->fromDOMElement($xml->getElementsByTagName('gTimb')->item(0)->nodeValue));
  //     $res->setDDatGralOpe($res->dDatGralOpe->fromDOMElement($xml->getElementsByTagName('dDatGralOpe')->item(0)->nodeValue));
  //     $res->setGDtipDe($res->gDtipDe->fromDOMElement($xml->getElementsByTagName('gDtipDe')->item(0)->nodeValue));
  //     $res->setGTotSub($res->gTotSub->fromDOMElement($xml->getElementsByTagName('dTotSub')->item(0)->nodeValue));
  //     $res->setGCamGen($res->gCamGen->fromDOMElement($xml->getElementsByTagName('gCamGen')->item(0)->nodeValue));
  //     $res->setGCamDEAsoc($res->gCamDEAsoc->fromDOMElement($xml->getElementsByTagName('gCamDEAsoc')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  //====================================================//
  //Others
  //====================================================//

  /**
   * Get the value of gOpeDe
   *
   * @return GOpeDE
   */
  public function getGOpeDe(): GOpeDE | null
  {
    return $this->gOpeDe;
  }

  /**
   * Set the value of gOpeDe
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
   * Get the value of gTimb
   *
   * @return GTimb
   */
  public function getGTimb(): GTimb | null
  {
    return $this->gTimb;
  }

  /**
   * Set the value of gTimb
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
   * Get the value of dDatGralOpe
   *
   * @return GDatGralOpe
   */
  public function getDDatGralOpe(): GDatGralOpe | null
  {
    return $this->dDatGralOpe;
  }

  /**
   * Set the value of dDatGralOpe
   *
   * @param GDatGralOpe $dDatGralOpe
   *
   * @return self
   */
  public function setDDatGralOpe(GDatGralOpe $dDatGralOpe): self
  {
    $this->dDatGralOpe = $dDatGralOpe;

    return $this;
  }

  /**
   * Get the value of gDtipDe
   *
   * @return GDtipDE
   */
  public function getGDtipDe(): GDtipDE | null
  {
    return $this->gDtipDe;
  }

  /**
   * Set the value of gDtipDe
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
   * Get the value of gCamDEAsoc
   *
   * @return GCamDEAsoc
   */
  public function getGCamDEAsoc(): GCamDEAsoc | null
  {
    return $this->gCamDEAsoc;
  }

  /**
   * Set the value of gCamDEAsoc
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

  /**
   * Get the value of gCamGen
   *
   * @return GCamGen
   */
  public function getGCamGen(): GCamGen | null
  {
    return $this->gCamGen;
  }

  /**
   * Set the value of gCamGen
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
   * Get the value of gTotSub
   *
   * @return GTotSub
   */
  public function getGTotSub(): GTotSub | null
  {
    return $this->gTotSub;
  }

  /**
   * Set the value of gTotSub
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
    $de->setID($array['@attributes']['Id']);
    $de->setDDVId(intval($response->dDVId));
    $de->setDFecFirma(DateTime::createFromFormat('Y-m-d\TH:i:s', $response->dFecFirma));
    $de->setDSisFact($response->dSisFact);
    ///Children
    $de->setGOpeDe(GOpeDE::fromResponse($response->gOpeDE));
    $de->setGTimb(GTimb::fromResponse($response->gTimb));
    $de->setDDatGralOpe(GDatGralOpe::fromResponse($response->gDatGralOpe));
    $de->setGDtipDe(GDtipDE::fromResponse($response->gDtipDE));
    $de->setGTotSub(GTotSub::fromResponse($response->gTotSub));
    if (isset($response->gCamGen)) {
      $de->setGCamGen(GCamGen::fromResponse($response->gCamGen));
    }
    if (isset($response->gCamDEAsoc)) {
      $de->setGCamDEAsoc(GCamDEAsoc::fromResponse($response->gCamDEAsoc));
    }
    return $de;
  }
}
