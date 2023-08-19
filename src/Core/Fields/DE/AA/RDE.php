<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\AA;

use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\DE\I\Signature;
use Abiliomp\Pkuatia\Core\Fields\DE\J\GCamFuFD;
use DOMElement;
use SimpleXMLElement;

/** 
 * Nodo Id:     AA001
 * Nombre:      rDE
 * Descripción: Campos que identifican el formato electrónico XML (AA001-AA009)
 * Nodo Padre:  Es nodo raiz.
 */

class RDE
{
  public ?int $dVerFor  = null;         // AA002 Versión del formato
  public ?DE $dE = null;               // Campos firmados del  DE
  public ?Signature $signature = null; // Firma Digital del DTE
  public ?GCamFuFD $gCamFuFD = null;   // Campos fuera de la firma digital

  /**
   * Constructor
   * 
   * @return self
   */
  public function __construct()
  {
    ///General
    $this->dE = new DE();
    $this->setDVerFor(Constants::SIFEN_VERSION);
    $this->signature = new Signature();
    $this->gCamFuFD = new GCamFuFD();
  }

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

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

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dVerFor
   *
   * @return int
   */
  public function getDVerFor(): int
  {
    return $this->dVerFor;
  }

  ///////////////////////////////////////////////////////////////////////
  // XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto RDE a partir de un SimpleXMLElement
   * 
   * @param  mixed $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'rDE') != 0)
      throw new \Exception('[RDE] Invalid XML Node Name: ' . $node->getName());
    $res = new RDE();
    $res->setDVerFor((int)$node->dVerFor);
    $res->setDE(DE::FromSimpleXMLElement($node->DE));
    $res->setGCamFuFD(GCamFuFD::FromSimpleXMLElement($node->gCamFuFD));
    $res->setSignature(Signature::FromSimpleXMLElement($node->Signature));
    return $res;
  }

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
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response) : self
  {
    $res = new RDE();
    if(isset($response->DE))
    {
      $res->setDE(DE::fromResponse($response->DE));
    }
 
    if(isset($response->gCamFuFD))
    {
      $res->setGCamFuFD(GCamFuFD::fromResponse($response->gCamFuFD));
    }
    return $res;
  }   

  ///////////////////////////////////////////////////////////////////////
  // Others
  ///////////////////////////////////////////////////////////////////////

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
