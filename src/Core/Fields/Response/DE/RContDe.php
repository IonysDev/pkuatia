<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\DE;;

use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;
use SimpleXMLElement;

/**
 * ContDE01 - Contenedor de la respuesta del DE consultado
 */
class RContDe
{
  public ?RDE $rDe = null; //ContDE02 - Archivo XML del DE ContDE01 
  public ?string $dProtAut = null; //ContDE03 - Número De Transacción 
  public ?RContEv $rContEv = null; //ContDE04 - Contenedor de Evento

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
   * @param string $dProtAut
   *
   * @return self
   */
  public function setDProtAut(string $dProtAut): self
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
  public function getRDe(): RDE
  {
    return $this->rDe;
  }

  /**
   * Get the value of dProtAut
   *
   * @return string
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
  public function getRContEv(): RContEv
  {
    return $this->rContEv;
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
      throw new \Exception("Invalid XML Element: $xml->getName()");
      return null;
    }
    $res = new self();
    if (isset($xml->dProtAut)) {
      $res->setDProtAut((string) $xml->dProtAut);
    }
    if (isset($xml->rDE)) {
      $res->setRDe(RDE::FromSimpleXMLElement($xml->rDE));
    }
    if (isset($xml->rContEv)) {
      $res->setRContEv(RContEv::fromDOMElement($xml->rContEv));
    }
    return $res;
  }

  /**
   * fromStdClassObject
   *
   * @param  mixed $xml
   * @return self
   */
  public static function fromStdClassObject($object) : self
  {
    $res = new self();
    if (isset($object->dProtAut)) {
      $res->setDProtAut($object->dProtAut);
    }
    /*///add the  <rContDe>  before <rDE>
    $xml = str_replace('<rDE ', '<rContDe><rDE ', $xml);
    //close the document with </rContDe>
    $xml = $xml . '</rContDe>';

    ///load the xml
    $xml = simplexml_load_string($xml);
    ///convert to json
    $json = json_encode($xml);
    ///convert to object
    $object = json_decode($json);
    ///create the object to return
    $txContenDE = new TxContenDE();
    ///set rDE
    if (isset($object->rDE)) {
      $txContenDE->setRDe(RDE::fromResponse($object->rDE));
    }
    ///set dProtAut
    if (isset($object->dProtAut)) {
      $txContenDE->setDProtAut($object->dProtAut);
    }

    return $txContenDE;*/

    return $res;
  }
}
