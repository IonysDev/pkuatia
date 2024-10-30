<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use stdClass;

/**
 * Nodo Id:     E750    
 * Nombre:      gRasMerc    
 * Descripción: Grupo de rastreo de la mercadería     
 * Nodo Padre:  E700 - gCamItem - Campos que describen los ítems de la operación
 */
class GRasMerc extends BaseSifenField
{
  public int      $dNumLote;      // E751 - 1-80  - 0-1 - Número de lote 
  public DateTime $dVencMerc;     // E752 - 10    - 0-1 - Fecha de vencimiento  de la mercadería
  public String   $dNSerie;       // E753 - 1-10  - 0-1 - Número de serie
  public String   $dNumPedi;      // E754 - 1-20  - 0-1 - Número de pedido
  public String   $dNumSegui;     // E755 - 1-20  - 0-1 - Número de  seguimiento del envío
  public String   $dNumReg;       // E759 - 1-20  - 0-1 - Número de registro del  producto otorgado por  el SENAVE
  public String   $dNumRegEntCom; // E760 - 1-20  - 0-1 - Número de registro de  entidad comercial otorgado por el SENAVE
  public String   $dNomPro;       // E761 - 1-30  - 0-1 - Nombre del Producto
  

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dNumLote
   *
   * @param int $dNumLote
   *
   * @return self
   */
  public function setDNumLote(int $dNumLote): self
  {
    $this->dNumLote = $dNumLote;

    return $this;
  }


  /**
   * Establece el valor de dVencMerc
   *
   * @param DateTime $dVencMerc
   *
   * @return self
   */
  public function setDVencMerc(DateTime $dVencMerc): self
  {
    $this->dVencMerc = $dVencMerc;

    return $this;
  }


  /**
   * Establece el valor de dNSerie
   *
   * @param String $dNSerie
   *
   * @return self
   */
  public function setDNSerie(String $dNSerie): self
  {
    $this->dNSerie = $dNSerie;

    return $this;
  }


  /**
   * Establece el valor de dNumPedi
   *
   * @param String $dNumPedi
   *
   * @return self
   */
  public function setDNumPedi(String $dNumPedi): self
  {
    $this->dNumPedi = $dNumPedi;

    return $this;
  }


  /**
   * Establece el valor de dNumSegui
   *
   * @param String $dNumSegui
   *
   * @return self
   */
  public function setDNumSegui(String $dNumSegui): self
  {
    $this->dNumSegui = $dNumSegui;

    return $this;
  }

  /**
   * Establece el valor de dNumReg
   *
   * @param String $dNumReg
   *
   * @return self
   */
  public function setDNumReg(String $dNumReg): self
  {
    $this->dNumReg = $dNumReg;

    return $this;
  }


  /**
   * Establece el valor de dNumRegEntCom
   *
   * @param String $dNumRegEntCom
   *
   * @return self
   */
  public function setDNumRegEntCom(String $dNumRegEntCom): self
  {
    $this->dNumRegEntCom = $dNumRegEntCom;

    return $this;
  }

  /**
   * Establece el valor de dNomPro
   *
   * @param String $dNomPro
   *
   * @return self
   */
  public function setDNomPro(String $dNomPro): self
  {
    $this->dNomPro = $dNomPro;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dNumLote
   *
   * @return int
   */
  public function getDNumLote(): int
  {
    return $this->dNumLote;
  }

  /**
   * Obtiene el valor de dVencMerc
   *
   * @return DateTime
   */
  public function getDVencMerc(): DateTime
  {
    return $this->dVencMerc;
  }

  /**
   * Obtiene el valor de dNSerie
   *
   * @return String
   */
  public function getDNSerie(): String
  {
    return $this->dNSerie;
  }

  /**
   * Obtiene el valor de dNumPedi
   *
   * @return String
   */
  public function getDNumPedi(): String
  {
    return $this->dNumPedi;
  }

  /**
   * Obtiene el valor de dNumSegui
   *
   * @return String
   */
  public function getDNumSegui(): String
  {
    return $this->dNumSegui;
  }

  /**
   * Obtiene el valor de dNumReg
   *
   * @return String
   */
  public function getDNumReg(): String
  {
    return $this->dNumReg;
  }

  /**
   * Obtiene el valor de dNumRegEntCom
   *
   * @return String
   */
  public function getDNumRegEntCom(): String
  {
    return $this->dNumRegEntCom;
  }

  /**
   * Obtiene el valor de dNomPro
   *
   * @return String
   */
  public function getDNomPro(): String
  {
    return $this->dNomPro;
  }

  ///////////////////////////////////////////////////////////////////////
  //XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte este GRasMerc en un DOMElement que puede ser insertado en el DOMDocument especificado.
   * 
   * @param DOMDocument $doc Documento DOM que creará el DOMElement sin insertarlo.
   *
   * @return DOMElement El DOMElement creado.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gRasMerc');
    $res->appendChild(new DOMElement('dNumLote', $this->getDNumLote()));
    $res->appendChild(new DOMElement('dVencMerc', $this->getDVencMerc()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dNSerie', $this->getDNSerie()));
    $res->appendChild(new DOMElement('dNumPedi', $this->getDNumPedi()));
    $res->appendChild(new DOMElement('dNumSegui', $this->getDNumSegui()));
    $res->appendChild(new DOMElement('dNumReg', $this->getDNumReg()));
    $res->appendChild(new DOMElement('dNumRegEntCom', $this->getDNumRegEntCom()));
    $res->appendChild(new DOMElement('dNomPro', $this->getDNomPro()));
    return $res;
  }

  public static function FromSifenResponseObject(stdClass $object): self
  {
    throw new \Exception("Not implemented");
    $res = new self();
    return $res;
  }
  
  /**
   * FromSimpleXMLElement
   *
   * @param  mixed $node
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {

    if(strcmp($node->getName(), 'gRasMerc') != 0)
      throw new \Exception("Invalid gRasMerc XML Node Name: " . $node->getName());

    $res = new GRasMerc();
    if(isset($node->dNumLote))
    {
      $res->setDNumLote($node->dNumLote);
    }
    if(isset($node->dVencMerc))
    {
      $res->setDVencMerc(DateTime::createFromFormat('Y-m-d', $node->dVencMerc));
    }
    if(isset($node->dNSerie))
    {
      $res->setDNSerie($node->dNSerie);
    }
    if(isset($node->dNumPedi))
    {
      $res->setDNumPedi($node->dNumPedi);
    }
    if(isset($node->dNumSegui))
    {
      $res->setDNumSegui($node->dNumSegui);
    }
    if(isset($node->dNumReg))
    {
      $res->setDNumReg($node->dNumReg);
    }
    if(isset($node->dNumRegEntCom))
    {
      $res->setDNumRegEntCom($node->dNumRegEntCom);
    }
    if(isset($node->dNomPro))
    {
      $res->setDNomPro($node->dNomPro);
    }
    return $res;
  }

  /**
   * Instancia un objeto GRasMerc a partir de un DOMElement que lo representa.
   * 
   * @param DOMElement $node
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gRasMerc') != 0)
        throw new \Exception('[GRasMerc] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new self();
    if($node->getElementsByTagName('dNumLote')->length > 0)
      $res->setDNumLote(intval(trim($node->getElementsByTagName('dNumLote')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dVencMerc')->length > 0)
      $res->setDVencMerc(DateTime::createFromFormat('Y-m-d', trim($node->getElementsByTagName('dVencMerc')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dNSerie')->length > 0)
      $res->setDNSerie(trim($node->getElementsByTagName('dNSerie')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNumPedi')->length > 0)
      $res->setDNumPedi(trim($node->getElementsByTagName('dNumPedi')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNumSegui')->length > 0)
      $res->setDNumSegui(trim($node->getElementsByTagName('dNumSegui')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNumReg')->length > 0)
      $res->setDNumReg(trim($node->getElementsByTagName('dNumReg')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNumRegEntCom')->length > 0)
      $res->setDNumRegEntCom(trim($node->getElementsByTagName('dNumRegEntCom')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNomPro')->length > 0)
      $res->setDNomPro(trim($node->getElementsByTagName('dNomPro')->item(0)->nodeValue));
    return $res;
  }
}
