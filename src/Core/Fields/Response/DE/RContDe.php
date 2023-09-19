<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\DE;;

use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;
use SimpleXMLElement;

/**
 * ContDE01 - Contenedor de la respuesta del DE consultado
 */
class RContDe
{
  public RDE $rDe; //ContDE02 - Archivo XML del DE ContDE01 
  public String $dProtAut; //ContDE03 - Número De Transacción 
  public RContEv $rContEv; //ContDE04 - Contenedor de Evento

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of rDe
   *
   * @param RDE $rDe
   *
   * @return self
   */
  public function setRDe(RDE $rDe): self
  {
    $this->rDe = $rDe;

    return $this;
  }


  /**
   * Set the value of dProtAut
   *
   * @param String $dProtAut
   *
   * @return self
   */
  public function setDProtAut(String $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }


  /**
   * Set the value of rContEv
   *
   * @param RContEv $rContEv
   *
   * @return self
   */
  public function setRContEv(RContEv $rContEv): self
  {
    $this->rContEv = $rContEv;

    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of rDe
   *
   * @return RDE
   */
  public function getRDe(): RDE | null
  {
    return isset($this->rDe) ? $this->rDe : null;
  }

  /**
   * Get the value of dProtAut
   *
   * @return String
   */
  public function getDProtAut(): String
  {
    return $this->dProtAut;
  }

  /**
   * Get the value of rContEv
   *
   * @return RContEv
   */
  public function getRContEv(): RContEv | null
  {
    return isset($this->rContEv) ? $this->rContEv : null;
  }

  /**
   * Crea una nueva instancia de RContDe a partir de un objeto SimpleXMLElement.
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $xml): self
  {

    if(strcmp($xml->getName(),'rContDe') != 0) {
      throw new \Exception("Invalid XML Element:". $xml->getName());
      return null;
    }
    
    $res = new self();
    if (isset($xml->dProtAut)) {
      $res->setDProtAut((String) $xml->dProtAut);
    }
    if (isset($xml->rDE)) {
      $res->setRDe(RDE::FromSimpleXMLElement($xml->rDE));
    }
    ///el nodo xcontEv  siempre viene, pero puede estar vacio, asi que no se valida
    //se valida su hijo que es rContEv
    if (isset($xml->xContEv->rContEv)) {
      $res->setRContEv(RContEv::FromSimpleXMLElement($xml->xContEv->rContEv));
    }
    return $res;
  }

  /**
   * Crea una nueva instancia de RContDe a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   *
   * @param stdClass $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object) : self
  {
    $res = new self();
    if (isset($object->dProtAut)) {
      $res->setDProtAut($object->dProtAut);
    }
    return $res;
  }
}
