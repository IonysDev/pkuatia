<?php

namespace Abiliomp\Pkuatia\Fields\AA;

use Abiliomp\Pkuatia\Fields\A\DE;
use Abiliomp\Pkuatia\Fields\I\Signature;
use Abiliomp\Pkuatia\Fields\J\GCamFuFD;
use DOMElement;



/** ID: AA001
 * Campos que identifican el formato electrónico XML (AA001-AA009)
 * PADRE: RAIZ
 */
class RDE
{
  public int $dVerFor;         // AA002 Versión del formato
  public DE $dE;               // Campos firmados del  DE
  public Signature $signature; // Firma Digital del DTE
  public GCamFuFD $gCamFuFD;   // Campos fuera de la firma digital 

  //====================================================//
  //Constructor
  //====================================================//  

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $this->dVerFor = 150;
  }

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of dVerFor
   *
   * @param int $dVerFor
   *
   * @return self
   */
  public function setDVerFor(int $dVerFor): self
  {
    $this->dVerFor = $dVerFor;

    return $this;
  }

  //====================================================//
  ///Getters
  //====================================================//

  /**
   * Get the value of dVerFor
   *
   * @return int
   */
  public function getDVerFor(): int
  {
    return $this->dVerFor;
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
    $res = new DOMElement('rDe');
    $res->appendChild(new DOMElement('dVerFor', $this->getDVerFor()));
    ///Children
    $res->appendChild($this->dE->toDOMElement());
    // $res->appendChild(new DOMElement('signature',$this->signature->toDOMElement()));
    $res->appendChild($this->gCamFuFD->toDOMElement());
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return RDE
   */
  public static function fromDOMElement(DOMElement $xml): RDE
  {
    if (strcmp($xml->tagName, 'rDe') == 0 && $xml->childElementCount == 4) {
      $res = new RDE();
      $res->setDVerFor(intval($xml->getElementsByTagName('dVerFor')->item(0)->nodeValue));
      ///children
      $res->setDE($res->dE->fromDOMElement($xml->getElementsByTagName('DE')->item(0)->nodeValue));
      //Signature
      $res->setGCamFuFD($res->gCamFuFD->fromDOMElement($xml->getElementsByTagName('gCamFuFD')->item(0)->nodeValue));
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }

  //====================================================//
  ///Others
  //====================================================//

  /**
   * Get the value of dE
   *
   * @return DE
   */
  public function getDE(): DE
  {
    return $this->dE;
  }

  /**
   * Set the value of dE
   *
   * @param DE $dE
   *
   * @return self
   */
  public function setDE(DE $dE): self
  {
    $this->dE = $dE;

    return $this;
  }

  /**
   * Get the value of gCamFuFD
   *
   * @return GCamFuFD
   */
  public function getGCamFuFD(): GCamFuFD
  {
    return $this->gCamFuFD;
  }

  /**
   * Set the value of gCamFuFD
   *
   * @param GCamFuFD $gCamFuFD
   *
   * @return self
   */
  public function setGCamFuFD(GCamFuFD $gCamFuFD): self
  {
    $this->gCamFuFD = $gCamFuFD;

    return $this;
  }
}
