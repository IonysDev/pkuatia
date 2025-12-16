<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use IonysDev\Pkuatia\Core\Fields\DE\E\GTransp;
use DOMDocument;
use DOMElement;

/**
 * Nodo Id:     E001    
 * Nombre:      gDtipDE   
 * Descripción: Campos específicos por tipo de Documento Electrónico (E001-E009)    
 * Nodo Padre:  A001 - DE - Campos firmados del DE    
 */

class GDtipDE extends BaseSifenField
{

  public GCamFE   $gCamFE;   // E010 - - 0-1   - Campos que componen la Factura Electrónica
  public GCamAE   $gCamAE;   // E300 - - 0-1   - Campos que componen la Autofactura Electrónica
  public GCamNCDE $gCamNCDE; // E400 - - 0-1   - Campos que componen la Nota de Crédito o Débito Electrónica
  public GCamNRE  $gCamNRE;  // E500 - - 0-1   - Campos que componen la Nota de Remisión Electrónica
  public GCamCond $gCamCond; // E600 - - 0-1   - Campos que describen la condición de la operación
  public array    $gCamItem; // E700 - - 1-999 - Campos que describen los ítems de la operación (GCamItem[])
  public GCamEsp  $gCamEsp;  // E790 - - 0-1   - Campos complementarios comerciales de uso específico
  public GTransp  $gTransp;  // E900 - - 0-1   - Campos que describen  el transporte de mercaderías

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->gCamItem = [];
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters y Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de gCamFE
   *
   * @return GCamFE|null
   */
  public function getGCamFE(): ?GCamFE
  {
    if(isset($this->gCamFE))
      return $this->gCamFE;
    else
      return null;
  }

  /**
   * Establece el valor de gCamFE
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
   * Obtiene el valor de gCamAE
   *
   * @return GCamAE|null
   */
  public function getGCamAE(): ?GCamAE
  {
    if(isset($this->gCamAE))
      return $this->gCamAE;
    else
      return null;
  }

  /**
   * Establece el valor de gCamAE
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
   * Obtiene el valor de gCamNCDE
   *
   * @return GCamNCDE|null
   */
  public function getGCamNCDE(): ?GCamNCDE
  {
    if(isset($this->gCamNCDE))
      return $this->gCamNCDE;
    else
      return null;
  }

  /**
   * Establece el valor de gCamNCDE
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
   * Obtiene el valor de gCamNRE
   *
   * @return GCamNRE
   */
  public function getGCamNRE(): ?GCamNRE
  {
    if(isset($this->gCamNRE))
      return $this->gCamNRE;
    else
      return null;
  }
  /**
   * Establece el valor de gCamNRE
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
   * Obtiene el valor de gCamCond
   *
   * @return GCamCond|null
   */
  public function getGCamCond(): ?GCamCond
  {
    if(isset($this->gCamCond))
      return $this->gCamCond;
    else
      return null;
  }

  /**
   * Establece el valor de gCamCond
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
   * Establece el valor de gCamItem
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
   * Obtiene el valor de gCamEsp
   *
   * @return GCamEsp
   */
  public function getGCamEsp(): GCamEsp
  {
    return $this->gCamEsp;
  }

  /**
   * Establece el valor de gCamEsp
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

  ///////////////////////////////////////////////////////////////////////
  // XML
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia la clase a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return GDtipDE
   */
  public static function FromSimpleXMLElement(\SimpleXMLElement $xml): GDtipDE
  {
    if(strcmp($xml->getName(), 'gDtipDE') != 0)
      throw new \Exception('El nombre del elemento no es gDtipDE');

    $res = new GDtipDE();
    
    if(isset($xml->gCamFE))
      $res->gCamFE = GCamFE::FromSimpleXMLElement($xml->gCamFE);
    
    if(isset($xml->gCamAE))
      $res->gCamAE = GCamAE::FromSimpleXMLElement($xml->gCamAE);
    
    if(isset($xml->gCamNCDE))
      $res->gCamNCDE = GCamNCDE::FromSimpleXMLElement($xml->gCamNCDE);
    
    if(isset($xml->gCamNRE))
      $res->gCamNRE = GCamNRE::FromSimpleXMLElement($xml->gCamNRE);
    
    if(isset($xml->gCamCond))
      $res->gCamCond = GCamCond::FromSimpleXMLElement($xml->gCamCond);
    
    if(isset($xml->gCamItem) && count($xml->gCamItem) > 0) {
      $res->gCamItem = [];
      foreach($xml->gCamItem as $gCamItem)
        $res->gCamItem[] = GCamItem::FromSimpleXMLElement($gCamItem);
    }

    if(isset($xml->gCamEsp))
      $res->gCamEsp = GCamEsp::FromSimpleXMLElement($xml->gCamEsp);
    
    if(isset($xml->gTransp))
      $res->gTransp = GTransp::FromSimpleXMLElement($xml->gTransp);
    
    return $res;    
  }

  /**
   * Convierte este GDtipDE a un DOMElement que puede ser insertado en el DOMDocument especificado.
   * 
   * @param DOMDocument $doc Documento DOM que creará el DOMElement sin insertarlo.
   *
   * @return DOMElement El DOMElement creado.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gDtipDE');
    if(isset($this->gCamFE))
      $res->appendChild($this->gCamFE->toDOMElement($doc));
    if(isset($this->gCamAE))
      $res->appendChild($this->gCamAE->toDOMElement($doc));
    if(isset($this->gCamNCDE))
      $res->appendChild($this->gCamNCDE->toDOMElement($doc));
    if(isset($this->gCamNRE))
      $res->appendChild($this->gCamNRE->toDOMElement($doc));
    if(isset($this->gCamCond))
      $res->appendChild($this->gCamCond->toDOMElement($doc));
    if(isset($this->gCamItem)) {
      foreach($this->gCamItem as $gCamItem)
        $res->appendChild($gCamItem->toDOMElement($doc));
    }
    if(isset($this->gCamEsp))
      $res->appendChild($this->gCamEsp->toDOMElement($doc));
    if(isset($this->gTransp))
      $res->appendChild($this->gTransp->toDOMElement($doc));
    return $res;
  }

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GDtipDE();
    if (isset($object->gCamFE)) {
      $res->setGCamFE(GCamFE::FromSifenResponseObject($object->gCamFE));
    }
    if (isset($object->gCamAE)) {
      $res->setGCamAE(GCamAE::FromSifenResponseObject($object->gCamAE));
    }

    if (isset($object->gCamNCDE)) {
      $res->setGCamNCDE(GCamNCDE::FromSifenResponseObject($object->gCamNCDE));
    }

    if (isset($object->gCamNRE)) {
      $res->setGCamNRE(GCamNRE::FromSifenResponseObject($object->gCamNRE));
    }

    if (isset($object->gCamCond)) {
      $res->setGCamCond(GCamCond::FromSifenResponseObject($object->gCamCond));
    }
    if (isset($object->gCamItem)) {
      ///BANDERA PARA SABER SI ES MAS DE UN ITEM
      //convert the object to array
      $aux = (array)$object;
      ///dependE del tipo de response
      if (gettype($aux['gCamItem']) == 'array') { ///mas de un objeto viene en arrays
        $count = count($object->gCamItem);
        for ($i = 0; $i < $count; $i++) {
          ///se deuelve el objeto en el array
          $res->gCamItem[] = GCamItem::FromSifenResponseObject($object->gCamItem[$i]);
        }
      } else if (gettype($aux['gCamItem']) == 'object') {  ///1 objeto, viene en objeto
        ///se deuelve el objeto en el array
        $res->gCamItem[] = GCamItem::FromSifenResponseObject($object->gCamItem);
      }
    }
    if (isset($object->gCamEsp)) {
      $res->setGCamEsp(GCamEsp::FromSifenResponseObject($object->gCamEsp));
    }

    if (isset($object->gTransp)) {
      $res->setGTransp(GTransp::FromSifenResponseObject($object->gTransp));
    }
    return $res;
  }

  /**
   * Instancia un objeto GDtipDE a partir de un DOMElement que representa el nodo XML del objeto GDtipDE.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GDtipDE.
   * 
   * @return self Objeto instanciado.
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gDtipDE') != 0)
      throw new \Exception('[GDtipDE] El nombre del nodo no corresponde a gDtipDE: ' . $node->nodeName, 1);
    $res = new GDtipDE();
    if($node->getElementsByTagName('gCamFE')->length > 0)
      $res->setGCamFE(GCamFE::FromDOMElement($node->getElementsByTagName('gCamFE')->item(0)));
    if($node->getElementsByTagName('gCamAE')->length > 0)
      $res->setGCamAE(GCamAE::FromDOMElement($node->getElementsByTagName('gCamAE')->item(0)));
    if($node->getElementsByTagName('gCamNCDE')->length > 0)
      $res->setGCamNCDE(GCamNCDE::FromDOMElement($node->getElementsByTagName('gCamNCDE')->item(0)));
    if($node->getElementsByTagName('gCamNRE')->length > 0)
      $res->setGCamNRE(GCamNRE::FromDOMElement($node->getElementsByTagName('gCamNRE')->item(0)));
    if($node->getElementsByTagName('gCamCond')->length > 0)
      $res->setGCamCond(GCamCond::FromDOMElement($node->getElementsByTagName('gCamCond')->item(0)));
    if($node->getElementsByTagName('gCamItem')->length > 0) {
      $res->gCamItem = [];
      foreach($node->getElementsByTagName('gCamItem') as $gCamItem)
        $res->gCamItem[] = GCamItem::FromDOMElement($gCamItem);
    }
    if($node->getElementsByTagName('gCamEsp')->length > 0)
      $res->setGCamEsp(GCamEsp::FromDOMElement($node->getElementsByTagName('gCamEsp')->item(0)));
    if($node->getElementsByTagName('gTransp')->length > 0)
      $res->setGTransp(GTransp::FromDOMElement($node->getElementsByTagName('gTransp')->item(0)));
    return $res;
  }



  /**
   * Obtiene el valor de gCamItem
   *
   * @return array
   */
  public function getGCamItem(): array
  {
    return $this->gCamItem;
  }

  /**
   * Obtiene el valor de gTransp
   *
   * @return GTransp
   */
  public function getGTransp(): GTransp
  {
    return $this->gTransp;
  }

  /**
   * Establece el valor de gTransp
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
