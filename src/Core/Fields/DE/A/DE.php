<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\A;

use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\Core\Fields\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\DE\G\GCamGen;
use Abiliomp\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use DateTime;
use DOMDocument;
use DOMElement;

/**
 * Nodo Id:     A001
 * Nombre:      DE
 * Descripción: Campos firmados del DE
 * Nodo Padre:  AA001 - rDE - Documento Electrónico elemento raíz
 */

class DE extends BaseSifenField
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
   * @return String
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
  public function getDFecFirma(): DateTime | null
  {
    if(isset($this->dFecFirma))
      return $this->dFecFirma;
    else
      return null;
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
    if(isset($this->gTotSub))
      return $this->gTotSub;
    else
      return null;
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
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte el objeto DE a un DOMElement de XML
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('DE');
    $res->setAttribute('Id', $this->getId());
    $res->appendChild(new DOMElement('dDVId', $this->getDDVId()));
    $res->appendChild(new DOMElement('dFecFirma', $this->getDFecFirma()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('dSisFact', $this->getDSisFact()));
    $res->appendChild($this->gOpeDe->toDOMElement($doc));
    $res->appendChild($this->gTimb->toDOMElement($doc));
    $res->appendChild($this->gDatGralOpe->toDOMElement($doc));
    $res->appendChild($this->gDtipDe->toDOMElement($doc));
    if(isset($this->gTotSub))
    {
      $importedNode = $doc->importNode($this->gTotSub->toDOMElement(), true);
      $res->appendChild($importedNode);
    }

    if(isset($this->gCamGen))
    {
      $importedNode = $doc->importNode($this->gCamGen->toDOMElement(), true);
      $res->appendChild($importedNode);
    }

    if(count($this->gCamDEAsoc) > 0)
    {
      foreach($this->gCamDEAsoc as $g)
      {
        $importedNode = $doc->importNode($g->toDOMElement(), true);
        $res->appendChild($importedNode);
      }
    }

    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

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
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    ///se castea en array para la Id porque trae el @atribute y eso no se puede usar con las flechitas
    $array = json_decode(json_encode($object), true);
    $de = new DE();
    if (isset($array['@attributes']['Id'])) {
      $de->setID($array['@attributes']['Id']);
    }
    if (isset($object->dDVId)) {
      $de->setDDVId(intval($object->dDVId));
    }
    if (isset($object->dFecFirma)) {
      $de->setDFecFirma(DateTime::createFromFormat('Y-m-d\TH:i:s', $object->dFecFirma));
    }
    if (isset($object->dSisFact)) {
      $de->setDSisFact($object->dSisFact);
    }
    if (isset($object->gOpeDE)) {
      $de->setGOpeDe(GOpeDE::FromSifenResponseObject($object->gOpeDE));
    }
    if (isset($object->gTimb)) {
      $de->setGTimb(GTimb::FromSifenResponseObject($object->gTimb));
    }
    if (isset($object->gDatGralOpe)) {
      $de->setGDatGralOpe(GDatGralOpe::FromSifenResponseObject($object->gDatGralOpe));
    }
    if (isset($object->gDtipDE)) {
      $de->setGDtipDe(GDtipDE::FromSifenResponseObject($object->gDtipDE));
    }
    if (isset($object->gTotSub)) {
      $de->setGTotSub(GTotSub::FromSifenResponseObject($object->gTotSub));
    }
    if (isset($object->gCamGen)) {
      $de->setGCamGen(GCamGen::FromSifenResponseObject($object->gCamGen));
    }
    if (isset($object->gCamDEAsoc) && count($object->gCamDEAsoc) > 0) {
      foreach ($object->gCamDEAsoc as $g) {
        $de->gCamDEAsoc[] = GCamDEAsoc::FromSifenResponseObject($g);
      }
    }
    return $de;
  }
}
