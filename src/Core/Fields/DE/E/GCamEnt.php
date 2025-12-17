<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DOMDocument;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use DOMElement;
use IonysDev\Pkuatia\Core\Fields\BaseSifenField;

/**
 * Nodo Id:     E940    
 * Nombre:      gCamEnt    
 * Descripción: Campos que identifican el local de la entrega de las mercaderías
 * Nodo Padre:  E900 - gTransp - Campos que describen  el transporte de mercaderías
 */
class GCamEnt extends BaseSifenField
{
                             // Id - Longitud - Ocurrencia - Descripción
  public String $dDirLocEnt; // E941 - 1-255 - 1-1 - Dirección del local de la entrega 
  public ?int $dNumCasEnt;   // E942 - 1-6   - 1-1 - Número de casa de Entrega
  public String $dComp1Ent;  // E943 - 1-255 - 0-1 - Complemento de dirección 1 Entrega
  public String $dComp2Ent;  // E944 - 1-255 - 0-1 - Complemento de dirección 2 Entrega
  public ?int $cDepEnt;      // E945 - 1-2   - 1-1 - Código del departamento del local de Entrega
  public ?int $cDisEnt;      // E947 - 1-4   - 0-1 - Código del distrito del local de Entrega
  public ?int $cCiuEnt;      // E949 - 1-5   - 1-1 - Código de la ciudad del local de Entrega
  public String $dTelEnt;    // E951 - 6-15  - 0-1 - Teléfono de contacto del local de Entrega

  ///////////////////////////////////////////////////////////////////////
  ///Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dDirLocEnt
   *
   * @param String $dDirLocEnt
   *
   * @return self
   */
  public function setDDirLocEnt(String $dDirLocEnt): self
  {
    $this->dDirLocEnt = $dDirLocEnt;

    return $this;
  }


  /**
   * Establece el valor de dNumCasEnt
   *
   * @param int $dNumCasEnt
   *
   * @return self
   */
  public function setDNumCasEnt(int $dNumCasEnt): self
  {
    $this->dNumCasEnt = $dNumCasEnt;

    return $this;
  }


  /**
   * Establece el valor de dComp1Ent
   *
   * @param String $dComp1Ent
   *
   * @return self
   */
  public function setDComp1Ent(String $dComp1Ent): self
  {
    $this->dComp1Ent = $dComp1Ent;

    return $this;
  }


  /**
   * Establece el valor de dComp2Ent
   *
   * @param String $dComp2Ent
   *
   * @return self
   */
  public function setDComp2Ent(String $dComp2Ent): self
  {
    $this->dComp2Ent = $dComp2Ent;

    return $this;
  }


  /**
   * Establece el valor de cDepEnt
   *
   * @param int $cDepEnt
   *
   * @return self
   */
  public function setCDepEnt(int $cDepEnt): self
  {
    $this->cDepEnt = $cDepEnt;

    return $this;
  }


  /**
   * Establece el valor de cDisEnt
   *
   * @param int $cDisEnt
   *
   * @return self
   */
  public function setCDisEnt(int $cDisEnt): self
  {
    $this->cDisEnt = $cDisEnt;

    return $this;
  }


  /**
   * Establece el valor de cCiuEnt
   *
   * @param int $cCiuEnt
   *
   * @return self
   */
  public function setCCiuEnt(int $cCiuEnt): self
  {
    $this->cCiuEnt = $cCiuEnt;

    return $this;
  }


  /**
   * Establece el valor de dTelEnt
   *
   * @param String $dTelEnt
   *
   * @return self
   */
  public function setDTelEnt(String $dTelEnt): self
  {
    $this->dTelEnt = $dTelEnt;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dDirLocEnt
   *
   * @return String
   */
  public function getDDirLocEnt(): String
  {
    return $this->dDirLocEnt;
  }

  /**
   * Obtiene el valor de dNumCasEnt
   *
   * @return int
   */
  public function getDNumCasEnt(): int
  {
    return $this->dNumCasEnt;
  }

  /**
   * Obtiene el valor de dComp1Ent
   *
   * @return String
   */
  public function getDComp1Ent(): String
  {
    return $this->dComp1Ent;
  }

  /**
   * Obtiene el valor de dComp2Ent
   *
   * @return String
   */
  public function getDComp2Ent(): String
  {
    return $this->dComp2Ent;
  }

  /**
   * Obtiene el valor de cDepEnt
   *
   * @return int
   */
  public function getCDepEnt(): int
  {
    return $this->cDepEnt;
  }

  /**
   * E946 Descripción del departamento del local de la entrega
   *
   * @return String
   */
  public function getDDesDepEnt(): String
  {
    return DepartamentoMapping::getDepName(strval($this->cDepEnt));
  }


  /**
   * Obtiene el valor de cDisEnt
   *
   * @return int
   */
  public function getCDisEnt(): int
  {
    return $this->cDisEnt;
  }

  /**
   * E948 Descripción de distrito del local de entrada
   *
   * @return String
   */
  public function getDDesDisEnt(): String
  {
    return PyGeoCodesMapping::getDistName(strval($this->cDisEnt));
  }

  /**
   * Obtiene el valor de cCiuEnt
   *
   * @return int
   */
  public function getCCiuEnt(): int
  {
    return $this->cCiuEnt;
  }

  /**
   * E950 Descripción de ciudad del local de entrada
   *
   * @return String
   */
  public function getDDesCiuEnt(): String
  {
    return PyGeoCodesMapping::getCiudName(strval($this->cCiuEnt));
  }

  /**
   * Obtiene el valor de dTelEnt
   *
   * @return String
   */
  public function getDTelEnt(): String
  {
    return $this->dTelEnt;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element  
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamEnt');

    $res->appendChild(new DOMElement('dDirLocEnt', $this->getDDirLocEnt()));

    if (isset($this->dNumCasEnt)) {
      $res->appendChild(new DOMElement('dNumCasEnt', $this->getDNumCasEnt()));
    }
    else {
      $res->appendChild(new DOMElement('dNumCasEnt', 0));
    }

    if (isset($this->dComp1Ent))
      $res->appendChild(new DOMElement('dComp1Ent', $this->getDComp1Ent()));

    if (isset($this->dComp2Ent))
      $res->appendChild(new DOMElement('dComp2Ent', $this->getDComp2Ent()));

    $res->appendChild(new DOMElement('cDepEnt', $this->getCDepEnt()));
    $res->appendChild(new DOMElement('dDesDepEnt', $this->getDDesDepEnt()));

    if (isset($this->cDisEnt)) {
      $res->appendChild(new DOMElement('cDisEnt', $this->getCDisEnt()));
    $res->appendChild(new DOMElement('dDesDisEnt', $this->getDDesDisEnt()));
    }
    $res->appendChild(new DOMElement('cCiuEnt', $this->getCCiuEnt()));
    $res->appendChild(new DOMElement('dDesCiuEnt', $this->getDDesCiuEnt()));

    if (isset($this->dTelEnt))
      $res->appendChild(new DOMElement('dTelEnt', $this->getDTelEnt()));

    return $res;
  }
  
  /**
   * Instancia un objeto GCamEnt a partir de un DOMElement que representa el nodo XML del objeto.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto.
   * 
   * @return self Objeto instanciado.
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamEnt') != 0)
      throw new \Exception('[GCamEnt] El nombre del nodo no corresponde a gCamEnt: ' . $node->nodeName);
    $res = new GCamEnt();
    
    if($node->getElementsByTagName('dDirLocEnt')->length > 0)
      $res->setDDirLocEnt($node->getElementsByTagName('dDirLocEnt')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dNumCasEnt')->length > 0)
      $res->setDNumCasEnt(intval($node->getElementsByTagName('dNumCasEnt')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('dComp1Ent')->length > 0)
      $res->setDComp1Ent($node->getElementsByTagName('dComp1Ent')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dComp2Ent')->length > 0)
      $res->setDComp2Ent($node->getElementsByTagName('dComp2Ent')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('cDepEnt')->length > 0)
      $res->setCDepEnt(intval($node->getElementsByTagName('cDepEnt')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('cDisEnt')->length > 0)
      $res->setCDisEnt(intval($node->getElementsByTagName('cDisEnt')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('cCiuEnt')->length > 0)
      $res->setCCiuEnt(intval($node->getElementsByTagName('cCiuEnt')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('dTelEnt')->length > 0)
      $res->setDTelEnt($node->getElementsByTagName('dTelEnt')->item(0)->nodeValue);
    
    return $res;
  }
  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GCamEnt();
    if(isset($object->dDirLocEnt))
    {
      $res->setDDirLocEnt($object->dDirLocEnt);
    }
    if(isset($object->dNumCasEnt))
    {
      $res->setDNumCasEnt($object->dNumCasEnt);
    }
    if(isset($object->dComp1Ent))
    {
      $res->setDComp1Ent($object->dComp1Ent);
    }
    if(isset($object->dComp2Ent))
    {
      $res->setDComp2Ent($object->dComp2Ent);
    }
    if(isset($object->cDepEnt))
    {
      $res->setCDepEnt($object->cDepEnt);
    }
    if(isset($object->cDisEnt))
    {
      $res->setCDisEnt($object->cDisEnt);
    }
    if(isset($object->cCiuEnt))
    {
      $res->setCCiuEnt($object->cCiuEnt);
    }
    if(isset($object->dTelEnt))
    {
      $res->setDTelEnt($object->dTelEnt);
    }
    
    return $res;
    
  }
}
