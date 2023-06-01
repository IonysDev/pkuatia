<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\DE;;

use Abiliomp\Pkuatia\Core\Fields\Request\DE\AA\RDE;
use DOMDocument;
use DOMElement;

/**
 * ContDE01 Raíz
 */
class TxContenDE
{
  public ?RDE $rDe = null; //ContDE02 - Archivo XML del DE ContDE01 
  public ?string $dProtAut = null; //ContDE03 - Número De Transacción 
  public ?TxContenEv $xContEv = null; //ContDE04 - Contenedor de Evento

  //====================================================//
  ///SETTERS
  //====================================================//

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
   * Set the value of xContEv
   *
   * @param TxContenEv $xContEv
   *
   * @return self
   */
  public function setXContEv(TxContenEv $xContEv): self
  {
    $this->xContEv = $xContEv;

    return $this;
  }


  //====================================================//
  //GETTERS
  //====================================================//


  /**
   * Get the value of rDe
   *
   * @return RDE
   */
  public function getRDe(): RDE | null
  {
    return $this->rDe;
  }

  /**
   * Get the value of dProtAut
   *
   * @return string
   */
  public function getDProtAut(): string | null
  {
    return $this->dProtAut;
  }

  /**
   * Get the value of xContEv
   *
   * @return TxContenEv
   */
  public function getXContEv(): TxContenEv | null
  {
    return $this->xContEv;
  }

  //====================================================//
  ///XML ELEMENT
  //====================================================//     
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('TxContenDe');
    $res->appendChild($this->rDe->toDOMElement());
    $res->appendChild(new DOMElement('dProtAut', $this->dProtAut));
    $res->appendChild($this->xContEv->toDOMElement());

    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return TxContenDE
  //  */
  // public static function fromDOMElement(DOMElement $xml): TxContenDE
  // {
  //   if (strcmp($xml->tagName, 'contenDE') == 0 && $xml->childElementCount == 3) {
  //     $res = new TxContenDE();

  //     $aux = new RDE();
  //     $aux->fromDOMElement($xml->getElementsByTagName('rDe')->item(0)->nodeValue);
  //     $res->setRDe($aux);

  //     $res->setDProtAut($xml->getElementsByTagName('dProtAut')->item(0)->nodeValue);

  //     $aux = new TxContenEv();
  //     $aux->fromDOMElement($xml->getElementsByTagName('contentEv')->item(0)->nodeValue);
  //     $res->setXContEv($aux);

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  /**
   * fromResponse
   *
   * @param  mixed $xml
   * @return self
   */
  public static function fromResponse($xml): self
  {

    ///add the  <rContDe>  before <rDE>
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

    return $txContenDE;
  }
}
