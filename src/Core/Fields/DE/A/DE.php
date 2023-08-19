<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\A;

use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\DE\G\GCamGen;
use Abiliomp\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use DateTime;
use DOMElement;

/**
 * Nodo Id:     A001
 * Nombre:      DE
 * Descripción: Campos firmados del DE
 * Nodo Padre:  AA001 - rDE - Documento Electrónico elemento raíz
 */

class DE
{
                              // Id - Longitud - Ocurrencia - Descripción
  public String   $id;        // A002 - 44 - 1-1 - Identificador del DE ubicado en el atributo de <DE>
  public int      $dDVId;     // A003 - 1  - 1-1 - Dígito verificador del dentificador del DE 
  public DateTime $dFecFirma; // A004 - 19 - 1-1 - Fecha de la firma
  public int      $dSisFact;  // A005 - 1  - 1-1 - Sistema de facturación

  public GOpeDE      $gOpeDe;      // B002 - G - 1-1  - Campos inherentes a la operación de DE
  public GTimb       $gTimb;       // C001 - G - 1-1  - Datos del timbrado 
  public GDatGralOpe $gDatGralOpe; // D001 - G - 1-1  - Campos generales del DE
  public GDtipDE     $gDtipDe;     // E001 - G - 1-1  - Campos específicos por tipo de Documento Electrónico 
  public GTotSub     $gTotSub;     // F001 - G - 0-1  - Campos de subtotales y totales
  public GCamGen     $gCamGen;     // G001 - G - 0-1  - Campos de uso general
  public array       $gCamDEAsoc;  // H001 - G - 0-99 - Campos que identifican al DE asociado (GCamDEAsoc)

  public function __construct()
  {
    $this->dSisFact = Constants::SISTEMA_FACTURACION_CONTRIBUYENTE;
    $this->gOpeDe = new GOpeDE();
    $this->gTimb = new GTimb();
    $this->gDatGralOpe = new GDatGralOpe();
    $this->gDtipDe = new GDtipDE();
    $this->gCamDEAsoc = [];
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
   * @param array $gCamDEAsoc Arreglo del tipo GCamDEAsoc
   * 
   * @return self
   */
  public function setGCamDEAsoc(array $gCamDEAsoc): self
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
   * @return array
   */
  public function getGCamDEAsoc(): array
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
    if(count($this->gCamDEAsoc) > 0)
    {
      foreach($this->gCamDEAsoc as $g)
      {
        $res->appendChild($g->toDOMElement());
      }
    }

    return $res;
  }

  /**
   * Devuelve un objeto DE a partir de un SimpleXMLElement
   * 
   * @param \SimpleXMLElement $node
   * 
   * @return DE 
   */
  public static function FromSimpleXMLElement(\SimpleXMLElement $node)
  {
    if(strcmp($node->getName(), 'DE') != 0)
      throw new \Exception('[DE] Invalid XML Node Name: ' . $node->getName());
    
    $res = new DE();
    $res->id = $node->attributes()['Id'];
    $res->dDVId = intval($node->dDVId);
    $res->dFecFirma = DateTime::createFromFormat('Y-m-d\TH:i:s', $node->dFecFirma);
    $res->dSisFact = intval($node->dSisFact);

    $res->gOpeDe = GOpeDE::FromSimpleXMLElement($node->gOpeDE);
    $res->gTimb = GTimb::FromSimpleXMLElement($node->gTimb);
    $res->gDatGralOpe = GDatGralOpe::FromSimpleXMLElement($node->gDatGralOpe);
    $res->gDtipDe = GDtipDE::FromSimpleXMLElement($node->gDtipDE);
    $res->gTotSub = GTotSub::FromSimpleXMLElement($node->gTotSub);
    if(isset($node->gCamGen))
      $res->gCamGen = GCamGen::FromSimpleXMLElement($node->gCamGen);
    if(isset($node->gCamDEAsoc) && count($node->gCamDEAsoc) > 0)
    {
      foreach($node->gCamDEAsoc as $g)
      {
        $res->gCamDEAsoc[] = GCamDEAsoc::FromSimpleXMLElement($g);
      }
    }

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
