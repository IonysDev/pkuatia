<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\AA;


use Abiliomp\Pkuatia\Core\Fields\Request\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\I\Signature;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\J\GCamFuFD;
use DOMElement;



/** ID: AA001
 * Campos que identifican el formato electrónico XML (AA001-AA009)
 * PADRE: RAIZ
 */
class RDE
{
  public ?int $dVerFor  = null;         // AA002 Versión del formato
  public ?DE $dE = null;               // Campos firmados del  DE
  public ?Signature $signature = null; // Firma Digital del DTE
  public ?GCamFuFD $gCamFuFD = null;   // Campos fuera de la firma digital 

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
  public function getDVerFor(): int | null
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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RDE
  //  */
  // public static function fromDOMElement(DOMElement $xml): RDE
  // {
  //   if (strcmp($xml->tagName, 'rDe') == 0 && $xml->childElementCount == 4) {
  //     $res = new RDE();
  //     $res->setDVerFor(intval($xml->getElementsByTagName('dVerFor')->item(0)->nodeValue));
  //     ///children
  //     $res->setDE($res->dE->fromDOMElement($xml->getElementsByTagName('DE')->item(0)->nodeValue));
  //     //Signature
  //     $res->setGCamFuFD($res->gCamFuFD->fromDOMElement($xml->getElementsByTagName('gCamFuFD')->item(0)->nodeValue));
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  //====================================================//
  ///Others
  //====================================================//

  /**
   * Get the value of dE
   *
   * @return DE
   */
  public function getDE(): DE | null
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
  public function getGCamFuFD(): GCamFuFD | null
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
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response):self
  {
    $res = new RDE();
    if(isset($response->DE))
    {
      $res->setDE(DE::fromResponse($response->DE));
    }
    if(isset($response->signature))
    {
      $res->setSignature(Signature::fromResponse($response->signature));
    }
      

    if(isset($response->gCamFuFD))
    {
      $res->setGCamFuFD(GCamFuFD::fromResponse($response->gCamFuFD));
    }
  

    return $res;
  }


  /**
   * Get the value of signature
   *
   * @return ?Signature
   */
  public function getSignature(): Signature | null
  {
    return $this->signature;
  }

  /**
   * Set the value of signature
   *
   * @param ?Signature $signature
   *
   * @return self
   */
  public function setSignature( Signature $signature): self
  {
    $this->signature = $signature;

    return $this;
  }
  
}
