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
  public String   $dNomImp;       // E756 - 4-60  - 0-1 - Nombre del Importador
  public String   $dDirImp;       // E757 - 1-255 - 0-1 - Dirección de Importador
  public String   $dNumFir;       // E758 - 20    - 0-1 - Número de registro de la firma del importador
  public String   $dNumReg;       // E759 - 20    - 0-1 - Número de registro del  producto otorgado por  el SENAVE
  public String   $dNumRegEntCom; // E760 - 20    - 0-1 - Número de registro de  entidad comercial otorgado por el SENAVE

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dNumLote
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
   * Set the value of dVencMerc
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
   * Set the value of dNSerie
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
   * Set the value of dNumPedi
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
   * Set the value of dNumSegui
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
   * Set the value of dNomImp
   *
   * @param String $dNomImp
   *
   * @return self
   */
  public function setDNomImp(String $dNomImp): self
  {
    $this->dNomImp = $dNomImp;

    return $this;
  }


  /**
   * Set the value of dDirImp
   *
   * @param String $dDirImp
   *
   * @return self
   */
  public function setDDirImp(String $dDirImp): self
  {
    $this->dDirImp = $dDirImp;

    return $this;
  }


  /**
   * Set the value of dNumFir
   *
   * @param String $dNumFir
   *
   * @return self
   */
  public function setDNumFir(String $dNumFir): self
  {
    $this->dNumFir = $dNumFir;

    return $this;
  }


  /**
   * Set the value of dNumReg
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
   * Set the value of dNumRegEntCom
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

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dNumLote
   *
   * @return int
   */
  public function getDNumLote(): int
  {
    return $this->dNumLote;
  }

  /**
   * Get the value of dVencMerc
   *
   * @return DateTime
   */
  public function getDVencMerc(): DateTime
  {
    return $this->dVencMerc;
  }

  /**
   * Get the value of dNSerie
   *
   * @return String
   */
  public function getDNSerie(): String
  {
    return $this->dNSerie;
  }

  /**
   * Get the value of dNumPedi
   *
   * @return String
   */
  public function getDNumPedi(): String
  {
    return $this->dNumPedi;
  }

  /**
   * Get the value of dNumSegui
   *
   * @return String
   */
  public function getDNumSegui(): String
  {
    return $this->dNumSegui;
  }

  /**
   * Get the value of dNomImp
   *
   * @return String
   */
  public function getDNomImp(): String
  {
    return $this->dNomImp;
  }

  /**
   * Get the value of dDirImp
   *
   * @return String
   */
  public function getDDirImp(): String
  { 
    return $this->dDirImp;
  }

  /**
   * Get the value of dNumFir
   *
   * @return String
   */
  public function getDNumFir(): String
  {
    return $this->dNumFir;
  }

  /**
   * Get the value of dNumReg
   *
   * @return String
   */
  public function getDNumReg(): String
  {
    return $this->dNumReg;
  }

  /**
   * Get the value of dNumRegEntCom
   *
   * @return String
   */
  public function getDNumRegEntCom(): String
  {
    return $this->dNumRegEntCom;
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
    $res->appendChild(new DOMElement('dNomImp', $this->getDNomImp()));
    $res->appendChild(new DOMElement('dDirImp', $this->getDDirImp()));
    $res->appendChild(new DOMElement('dNumFir', $this->getDNumFir()));
    $res->appendChild(new DOMElement('dNumReg', $this->getDNumReg()));
    $res->appendChild(new DOMElement('dNumRegEntCom', $this->getDNumRegEntCom()));
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
    if(isset($node->dNomImp))
    {
      $res->setDNomImp($node->dNomImp);
    }
    if(isset($node->dDirImp))
    {
      $res->setDDirImp($node->dDirImp);
    }
    if(isset($node->dNumFir))
    {
      $res->setDNumFir($node->dNumFir);
    }
    if(isset($node->dNumReg))
    {
      $res->setDNumReg($node->dNumReg);
    }
    if(isset($node->dNumRegEntCom))
    {
      $res->setDNumRegEntCom($node->dNumRegEntCom);
    }
    return $res;
  }
}
