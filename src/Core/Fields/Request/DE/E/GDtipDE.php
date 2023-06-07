<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use Abiliomp\Pkuatia\Core\Fields\E\GTransp;
use DOMElement;

// Campos específicos por tipo de Documento Electrónico (E001-E009)
//ID:E001
//Padre:A001
class GDtipDE
{
  public ?GCamFE $gCamFE = null;      //Campos que componen la FE
  public ?GCamAE $gCamAE = null;      //Campos que componen la Autofactura Electrónica
  public ?GCamNCDE $gCamNCDE = null;  //Campos que componen la Nota de Crédito Electrónica
  public ?GCamNRE $gCamNRE = null;    //Campos que componen la Nota de Remisión Electrónica
  public ?GCamCond $gCamCond = null;  //Campos que describen la condición de la operación
  public ?array $gCamItem = null;     //Campos que describen los ítems de la operación
  public ?GCamEsp $gCamEsp = null;    //complementarios comerciales de uso específico
  public ?GTransp $gTransp = null;    //Campos que describen  el transporte de mercaderías



  public function __construct()
  {
    //Genral
    $this->gCamItem = [];
    $this->gCamEsp = new GCamEsp();
  }

  //====================================================//
  ///Others
  //====================================================//

  /**
   * Get the value of gCamFE
   *
   * @return GCamFE
   */
  public function getGCamFE(): GCamFE | null
  {
    return $this->gCamFE;
  }

  /**
   * Set the value of gCamFE
   *
   * @param GCamFE $gCamFE
   *
   * @return self
   */
  public function setGCamFE(GCamFE $gCamFE): self
  {
    $this->gCamFE = $gCamFE;

    return $this;
  }

  /**
   * Get the value of gCamAE
   *
   * @return GCamAE
   */
  public function getGCamAE(): GCamAE | null
  {
    return $this->gCamAE;
  }

  /**
   * Set the value of gCamAE
   *
   * @param GCamAE $gCamAE
   *
   * @return self
   */
  public function setGCamAE(GCamAE $gCamAE): self
  {
    $this->gCamAE = $gCamAE;

    return $this;
  }

  /**
   * Get the value of gCamNCDE
   *
   * @return GCamNCDE
   */
  public function getGCamNCDE(): GCamNCDE | null
  {
    return $this->gCamNCDE;
  }

  /**
   * Set the value of gCamNCDE
   *
   * @param GCamNCDE $gCamNCDE
   *
   * @return self
   */
  public function setGCamNCDE(GCamNCDE $gCamNCDE): self
  {
    $this->gCamNCDE = $gCamNCDE;

    return $this;
  }

  /**
   * Get the value of gCamNRE
   *
   * @return GCamNRE
   */
  public function getGCamNRE(): GCamNRE | null
  {
    return $this->gCamNRE;
  }

  /**
   * Set the value of gCamNRE
   *
   * @param GCamNRE $gCamNRE
   *
   * @return self
   */
  public function setGCamNRE(GCamNRE $gCamNRE): self
  {
    $this->gCamNRE = $gCamNRE;

    return $this;
  }

  /**
   * Get the value of gCamCond
   *
   * @return GCamCond
   */
  public function getGCamCond(): GCamCond | null
  {
    return $this->gCamCond;
  }

  /**
   * Set the value of gCamCond
   *
   * @param GCamCond $gCamCond
   *
   * @return self
   */
  public function setGCamCond(GCamCond $gCamCond): self
  {
    $this->gCamCond = $gCamCond;

    return $this;
  }



  /**
   * Set the value of gCamItem
   *
   * @param GCamItem $gCamItem
   *
   * @return self
   */
  public function setGCamItem(GCamItem $gCamItem): self
  {
    $this->gCamItem = $gCamItem;

    return $this;
  }

  /**
   * Get the value of gCamEsp
   *
   * @return GCamEsp
   */
  public function getGCamEsp(): GCamEsp | null
  {
    return $this->gCamEsp;
  }

  /**
   * Set the value of gCamEsp
   *
   * @param GCamEsp $gCamEsp
   *
   * @return self
   */
  public function setGCamEsp(GCamEsp $gCamEsp): self
  {
    $this->gCamEsp = $gCamEsp;

    return $this;
  }

  ///XML ELement  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gDtipDE');
    $res->appendChild($this->gCamFE->toDOMElement());
    $res->appendChild($this->gCamAE->toDOMElement());
    $res->appendChild($this->gCamNCDE->toDOMElement());
    $res->appendChild($this->gCamNRE->toDOMElement());
    $res->appendChild($this->gCamCond->toDOMElement());
    $res->appendChild($this->gCamEsp->toDOMElement());
    $res->appendChild($this->gTransp->toDOMElement());
    return $res;
  }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GDtipDE
  //  */
  // public static function fromDOMElement(DOMElement $xml): GDtipDE
  // {
  //   if (strcmp($xml->tagName, 'gDtipDE') == 0 && $xml->childElementCount == 7) {
  //     $res = new GDtipDE();
  //     $res->setGCamFE($res->gCamFE->fromDOMElement($xml->getElementsByTagName('gDtipFE')->item(0)->nodeValue));
  //     $res->setGCamAE($res->gCamAE->fromDOMElement($xml->getElementsByTagName('gCamAE')->item(0)->nodeValue));
  //     $res->setGCamNCDE($res->gCamNCDE->fromDOMElement($xml->getElementsByTagName('gCamNCDE')->item(0)->nodeValue));
  //     $res->setGCamNRE($res->gCamNRE->fromDOMElement($xml->getElementsByTagName('gCamNRE')->item(0)->nodeValue));
  //     $res->setGCamCond($res->gCamCond->fromDOMElement($xml->getElementsByTagName('gCamCond')->item(0)->nodeValue));
  //     $res->setGCamEsp($res->gCamEsp->fromDOMElement($xml->getElementsByTagName('gCamEsp')->item(0)->nodeValue));

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }


  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {
    $res = new GDtipDE();
    if (isset($response->gCamFE)) {
      $res->setGCamFE(GCamFE::fromResponse($response->gCamFE));
    }
    if (isset($response->gCamAE)) {
      $res->setGCamAE(GCamAE::fromResponse($response->gCamAE));
    }

    if (isset($response->gCamNCDE)) {
      $res->setGCamNCDE(GCamNCDE::fromResponse($response->gCamNCDE));
    }

    if (isset($response->gCamNRE)) {
      $res->setGCamNRE(GCamNRE::fromResponse($response->gCamNRE));
    }

    if (isset($response->gCamCond)) {
      $res->setGCamCond(GCamCond::fromResponse($response->gCamCond));
    }


    if (isset($response->gCamItem)) {
      ///BANDERA PARA SABER SI ES MAS DE UN ITEM
      //convert the object to array
      $aux = (array)$response;
      ///dependE del tipo de response
      if (gettype($aux['gCamItem']) == 'array') { ///mas de un objeto viene en arrays
        $count = count($response->gCamItem);
        for ($i = 0; $i < $count; $i++) {
          ///se deuelve el objeto en el array
          $res->gCamItem[] = GCamItem::fromResponse($response->gCamItem[$i]);
        }
      } else if (gettype($aux['gCamItem']) == 'object') {  ///1 objeto, viene en objeto
        ///se deuelve el objeto en el array
        $res->gCamItem[] = GCamItem::fromResponse($response->gCamItem);
      }
    }


    if (isset($response->gCamEsp)) {
      $res->setGCamEsp(GCamEsp::fromResponse($response->gCamEsp));
    }

    if (isset($response->gTransp)) {
      $res->setGTransp(GTransp::fromResponse($response->gTransp));
    }
    return $res;
  }



  /**
   * Get the value of gCamItem
   *
   * @return array
   */
  public function getGCamItem(): array | null
  {
    return $this->gCamItem;
  }

  /**
   * Get the value of gTransp
   *
   * @return GTransp
   */
  public function getGTransp(): GTransp | null
  {
    return $this->gTransp;
  }

  /**
   * Set the value of gTransp
   *
   * @param GTransp $gTransp
   *
   * @return self
   */
  public function setGTransp(GTransp $gTransp): self
  {
    $this->gTransp = $gTransp;

    return $this;
  }

  public function pushIntoGCamItem(GCamItem $gCamItem)
  {
    $this->gCamItem[] = $gCamItem;
  }
}
