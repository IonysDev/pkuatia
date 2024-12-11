<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DOMDocument;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use DOMElement;

/**
 *ID:E940 
 *Campos que identifican el local de la entrega de las mercaderías
 * PADRE:E900
 */
class GCamEnt
{
  public String $dDirLocEnt; // E941 - Dirección del local de la entrega 
  public ?int $dNumCasEnt;    // E942 - Número de casa de Entrega
  public String $dComp1Ent;  // E943 - Complemento de dirección 1 Entrega
  public String $dComp2Ent; // E944 - Complemento de dirección 2 Entrega
  public ?int $cDepEnt;      // E945 - Código del departamento del local de Entrega
  public ?int $cDisEnt;      // E947 - Código del distrito del local de Entrega
  public ?int $cCiuEnt;      // E949 - Código de la ciudad del local de Entrega
  public String $dTelEnt;   // E951 - Teléfono de contacto del local de Entrega

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
      $res->appendChild(new DOMElement('dNumCasEnt', 0));
    } else {
      $res->appendChild(new DOMElement('dNumCasEnt', $this->getDNumCasEnt()));
    }

    $res->appendChild(new DOMElement('dComp1Ent', $this->getDComp1Ent()));
    $res->appendChild(new DOMElement('dComp2Ent', $this->getDComp2Ent()));
    $res->appendChild(new DOMElement('cDepEnt', $this->getCDisEnt()));
    $res->appendChild(new DOMElement('dDesDepEnt', $this->getCDepEnt()));
    $res->appendChild(new DOMElement('cDisEnt', $this->getCDisEnt()));
    $res->appendChild(new DOMElement('dDesDisEnt', $this->getDDesDisEnt()));
    $res->appendChild(new DOMElement('cCiuEnt', $this->getCCiuEnt()));
    $res->appendChild(new DOMElement('dDesCiuEnt', $this->getDDesCiuEnt()));
    $res->appendChild(new DOMElement('dTelEnt', $this->getDTelEnt()));

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
