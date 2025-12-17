<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\A;

use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use IonysDev\Pkuatia\Core\Fields\DE\B\GOpeDE;
use IonysDev\Pkuatia\Core\Fields\DE\C\GTimb;
use IonysDev\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use IonysDev\Pkuatia\Core\Fields\DE\E\GDtipDE;
use IonysDev\Pkuatia\Core\Fields\DE\F\GTotSub;
use IonysDev\Pkuatia\Core\Fields\DE\G\GCamGen;
use IonysDev\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use stdClass;

/**
 * Nodo Id:     A001
 * Nombre:      DE
 * Descripción: Campos firmados del DE
 * Nodo Padre:  AA001 - rDE - Documento Electrónico elemento raíz
 * Ocurrencia:  1-1 (obligatorio)
 */

class DE extends BaseSifenField
{
                                   // Id - Longitud - Ocurrencia - Descripción
  public String   $id;             // A002 - 44 - 1-1 - Identificador del DE ubicado en el atributo de <DE>
  public int      $dDVId;          // A003 - 1  - 1-1 - Dígito verificador del dentificador del DE 
  public DateTime $dFecFirma;      // A004 - 19 - 1-1 - Fecha de la firma
  public int      $dSisFact;       // A005 - 1  - 1-1 - Sistema de facturación

  public GOpeDE      $gOpeDe;      // B001 - G - 1-1  - Campos inherentes a la operación de DE
  public GTimb       $gTimb;       // C001 - G - 1-1  - Datos del timbrado 
  public GDatGralOpe $gDatGralOpe; // D001 - G - 1-1  - Campos generales del DE
  public GDtipDE     $gDtipDe;     // E001 - G - 1-1  - Campos específicos por tipo de Documento Electrónico 
  public GTotSub     $gTotSub;     // F001 - G - 0-1  - Campos de subtotales y totales
  public GCamGen     $gCamGen;     // G001 - G - 0-1  - Campos de uso general
  public array       $gCamDEAsoc;  // H001 - G - 0-99 - Campos que identifican al DE asociado (GCamDEAsoc)

  /**
   * Constructor de la clase DE.
   */
  public function __construct()
  {
    $this->dSisFact = Constants::SISTEMA_FACTURACION_CONTRIBUYENTE;
    $this->gCamDEAsoc = [];
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de Id (A002) del documento electrónico (DE).
   * Este valor es equivalente al CDC y se debe generar con el algoritmo de cálculo de CDC cuando se crea un nuevo DE.
   * Cuando se recibe un DE de Sifen, este valor se debe tomar del atributo Id del nodo DE.
   *
   * @param String $id Valor de Id (A002) del documento electrónico (DE)
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setId(String $id): self
  {
    if(strlen($id) != 44)
      throw new \Exception('[DE] Id debe tener 44 caracteres.');
    else if(!preg_match('/^[0-9]{44}$/', $id))
      throw new \Exception('[DE] Id debe contener solo números.');
    $this->id = $id;
    return $this;
  }


  /**
   * Establece el valor de dDVId (A003) del documento electrónico (DE) que corresponde al dígito verificador del Id (A002).
   * Este valor es el útlimo dígito del Id (A002) y se debe generar con el algoritmo de cálculo de CDC cuando se crea un nuevo DE.
   *
   * @param int $dDVId 
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDDVId(int $dDVId): self
  {
    $this->dDVId = $dDVId;
    return $this;
  }


  /**
   * Establece el valor de dFecFirma (A004) que representa la fecha de firma del documento electrónico (DE).
   *
   * @param DateTime $dFecFirma Fecha de firma del documento electrónico (DE).
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDFecFirma(DateTime $dFecFirma): self
  {
    $this->dFecFirma = $dFecFirma;
    return $this;
  }


  /**
   * Establece el valor de dSisFact (A005) que representa el sistema de facturación del documento electrónico (DE).
   * Este método no debe ser llamado directamente, ya que el sistema de facturación es fijo y no debe ser modificado.
   *
   * @param int $dSisFact Sistema de facturación del documento electrónico (DE). Solo puede ser 1 (Contribuyente) o 2 (Sifen gratuito de la SET).
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDSisFact(int $dSisFact): self
  {
    // if($dSisFact != Constants::SISTEMA_FACTURACION_CONTRIBUYENTE && $dSisFact != Constants::SISTEMA_FACTURACION_SIFEN_GRATUITO)
    //   throw new \Exception('[DE] Valor dSisFact inválido: ' . $dSisFact . '. Debe ser 1 (Contribuyente) o 2 (Sifen gratuito de la SET)');
    // $this->dSisFact = $dSisFact;
    // return $this;
    if($dSisFact != Constants::SISTEMA_FACTURACION_CONTRIBUYENTE)
      throw new \Exception('[DE] Valor dSisFact inválido: ' . $dSisFact . '. Debe ser 1 (Contribuyente)');
    $this->dSisFact = $dSisFact;
    return $this;
  }

  /**
   * Establece el valor de gOpeDe (B002) que representa los campos inherentes a la operación de DE.
   * 
   * @param GOpeDE $gOpeDe Campos inherentes a la operación de DE.
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setGOpeDe(GOpeDE $gOpeDe): self
  {
    $this->gOpeDe = $gOpeDe;
    return $this;
  }

  /**
   * Establece el valor de gTimb (C001) que representa los datos del timbrado.
   * 
   * @param GTimb $gTimb Datos del timbrado.
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setGTimb(GTimb $gTimb): self
  {
    $this->gTimb = $gTimb;
    return $this;
  }

  /**
   * Establece el valor de gDatGralOpe (D001) que representa los campos generales del DE.
   * 
   * @param GDatGralOpe $gDatGralOpe Campos generales del DE.
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setGDatGralOpe(GDatGralOpe $gDatGralOpe): self
  {
    $this->gDatGralOpe = $gDatGralOpe;
    return $this;
  }

  /**
   * Establece el valor de gDtipDe (E001) que representa los campos específicos por tipo de Documento Electrónico.
   * 
   * @param GDtipDE $gDtipDe Campos específicos por tipo de Documento Electrónico.
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos. 
   */
  public function setGDtipDe(GDtipDE $gDtipDe): self
  {
    $this->gDtipDe = $gDtipDe;
    return $this;
  }

  /**
   * Establece el valor de gTotSub (F001) que representa los campos de subtotales y totales.
   * 
   * @param GTotSub $gTotSub
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setGTotSub(GTotSub $gTotSub): self
  {
    $this->gTotSub = $gTotSub;
    return $this;
  }

  /**
   * Establece el valor de gCamGen (G001) que representa los campos de uso general.
   * 
   * @param GCamGen $gCamGen Campos de uso general.
   * 
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setGCamGen(GCamGen $gCamGen): self
  {
    $this->gCamGen = $gCamGen;
    return $this;
  }

  /**
   * Establece el valor de gCamDEAsoc (H001) que representa los campos que identifican al DE asociado.
   * 
   * @param array $gCamDEAsoc Arreglo del tipo GCamDEAsoc que representa los campos que identifican al DE asociado.
   *  
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
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
   * Obtiene el valor de Id (A002) del documento electrónico (DE).
   *
   * @return String Id (A002) del documento electrónico (DE).
   */
  public function getId(): String
  {
    return $this->id;
  }

  /**
   * Obtiene el valor de dDVId (A003) del documento electrónico (DE) que corresponde al dígito verificador del Id (A002).
   *
   * @return int Dígito verificador del Id (A002) del documento electrónico (DE).
   */
  public function getDDVId(): int
  {
    return $this->dDVId;
  }

  /**
   * Obtiene el valor de dFecFirma (A004) que representa la fecha de firma del documento electrónico (DE).
   *
   * @return DateTime Fecha de firma del documento electrónico (DE).
   */
  public function getDFecFirma(): DateTime
  {
    if(isset($this->dFecFirma))
      return $this->dFecFirma;
    else
      return null;
  }

  /**
   * Obtiene el valor de dSisFact (A005) que representa el sistema de facturación del documento electrónico (DE).
   *
   * @return int Sistema de facturación del documento electrónico (DE). Solo puede ser 1 (Contribuyente) o 2 (Sifen gratuito de la SET).
   */
  public function getDSisFact(): int
  {
    return $this->dSisFact;
  }

  /**
   * Devuelve el valor de gOpeDe (B002) que representa los campos inherentes a la operación de DE.
   * 
   * @return GOpeDE Campos inherentes a la operación de DE.
   */
  public function getGOpeDe(): GOpeDE
  {
    return $this->gOpeDe;
  }

  /**
   * Devuelve el valor de gTimb (C001) que representa los datos del timbrado.
   * 
   * @return GTimb Datos del timbrado.
   */
  public function getGTimb(): GTimb
  {
    return $this->gTimb;
  }

  /**
   * Devuelve el valor de gDatGralOpe (D001) que representa los campos generales del DE.
   * 
   * @return GDatGralOpe Campos generales del DE.
   */
  public function getGDatGralOpe(): GDatGralOpe
  {
    return $this->gDatGralOpe;
  }

  /**
   * Devuelve el valor de gDtipDe (E001) que representa los campos específicos por tipo de Documento Electrónico.
   * 
   * @return GDtipDE Campos específicos por tipo de Documento Electrónico.
   */
  public function getGDtipDe(): GDtipDE
  {
    return $this->gDtipDe;
  }

  /**
   * Devuelve el valor de gTotSub (F001) que representa los campos de subtotales y totales.
   * 
   * @return GTotSub Campos de subtotales y totales.
   */
  public function getGTotSub(): GTotSub | null
  {
    if(isset($this->gTotSub))
      return $this->gTotSub;
    else
      return null;
  }

  /**
   * Devuelve el valor de gCamGen (G001) que representa los campos de uso general.
   * 
   * @return GCamGen Campos de uso general.
   */
  public function getGCamGen(): GCamGen
  {
    return $this->gCamGen;
  }

  /**
   * Devuelve el valor de gCamDEAsoc (H001) que representa los campos que identifican al DE asociado.
   * 
   * @return array Arreglo del tipo GCamDEAsoc que representa los campos que identifican al DE asociado.
   */
  public function getGCamDEAsoc(): array
  {
    return $this->gCamDEAsoc;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Genera un objeto DE a partir de un nodo DOMElement.
   * 
   * @param DOMElement $node Nodo XML que representa un DE
   * 
   * @return DE Objeto DE con los datos extraídos del nodo XML
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'DE') != 0)
      throw new \Exception('[DE] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new DE();
    $res->id = $node->getAttribute('Id');
    $res->dDVId = intval($node->getElementsByTagName('dDVId')->item(0)->nodeValue);
    $res->dFecFirma = DateTime::createFromFormat('Y-m-d\TH:i:s', trim($node->getElementsByTagName('dFecFirma')->item(0)->nodeValue));
    $res->dSisFact = intval($node->getElementsByTagName('dSisFact')->item(0)->nodeValue);
    $res->gOpeDe = GOpeDE::FromDOMElement($node->getElementsByTagName('gOpeDE')->item(0));
    $res->gTimb = GTimb::FromDOMElement($node->getElementsByTagName('gTimb')->item(0));
    $res->gDatGralOpe = GDatGralOpe::FromDOMElement($node->getElementsByTagName('gDatGralOpe')->item(0));
    $res->gDtipDe = GDtipDE::FromDOMElement($node->getElementsByTagName('gDtipDE')->item(0));
    if($node->getElementsByTagName('gTotSub')->length > 0)
      $res->gTotSub = GTotSub::FromDOMElement($node->getElementsByTagName('gTotSub')->item(0));
    if($node->getElementsByTagName('gCamGen')->length > 0)
      $res->gCamGen = GCamGen::FromDOMElement($node->getElementsByTagName('gCamGen')->item(0));
    if($node->getElementsByTagName('gCamDEAsoc')->length > 0) {
      foreach($node->getElementsByTagName('gCamDEAsoc') as $g)
        $res->gCamDEAsoc[] = GCamDEAsoc::FromDOMElement($g);
    }
    return $res;
  }

  /**
   * Genera un objeto DE a partir de un nodo SimpleXMLElement.
   * 
   * @param SimpleXMLElement $node Nodo XML que representa un DE
   * 
   * @return DE Objeto DE con los datos extraídos del nodo XML
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node)
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
   * Genera un objeto DE a partir de un objeto stdClass que contiene los datos de respuesta del SIFEN que representan un DE.
   *
   * @param stdClass $object Objeto stdClass que contiene los datos de respuesta del SIFEN que representan un DE.
   * 
   * @return self Objeto DE con los datos extraídos del objeto stdClass.
   */
  public static function FromSifenResponseObject(stdClass $object): self
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
  
  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este DE a un DOMElement insertable en el DOMDocument indicado.
   * 
   * @param DOMDocument $doc DOMDocument que generará el DOMElement sin insertarlo
   *
   * @return DOMElement DOMElement generado que representa este DE
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
      $res->appendChild($this->gTotSub->toDOMElement($doc));
    if(isset($this->gCamGen))
      $res->appendChild($this->gCamGen->toDOMElement($doc));
    if(count($this->gCamDEAsoc) > 0)
    {
      foreach($this->gCamDEAsoc as $g)
        $res->appendChild($g->toDOMElement($doc));
    }
    return $res;
  }
}
