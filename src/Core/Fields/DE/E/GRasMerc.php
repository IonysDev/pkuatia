<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DateTime;
use DOMElement;

/**
 * Nodo Id:     E750    
 * Nombre:      gRasMerc    
 * Descripción: Grupo de rastreo de la mercadería     
 * Nodo Padre:  E700 - gCamItem - Campos que describen los ítems de la operación
 */
class GRasMerc
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
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gRasMerc');

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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GRasMerc
  //  */
  // public static function fromDOMElement(DOMElement $xml): GRasMerc
  // {
  //   if (strcmp($xml->tagName, 'gRasMerc') === 0 && $xml->childElementCount == 10) {
  //     $res = new GRasMerc();
  //     $res->setDNumLote($xml->getElementsByTagName('dNumLote')->item(0)->nodeValue);
  //     $res->setDVencMerc(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dVencMerc')->item(0)->nodeValue));
  //     $res->setDNSerie($xml->getElementsByTagName('dNSerie')->item(0)->nodeValue);
  //     $res->setDNumPedi($xml->getElementsByTagName('dNumPedi')->item(0)->nodeValue);
  //     $res->setDNumSegui($xml->getElementsByTagName('dNumSegui')->item(0)->nodeValue);
  //     $res->setDNomImp($xml->getElementsByTagName('dNomImp')->item(0)->nodeValue);
  //     $res->setDDirImp($xml->getElementsByTagName('dDirImp')->item(0)->nodeValue);
  //     $res->setDNumFir($xml->getElementsByTagName('dNumFir')->item(0)->nodeValue);
  //     $res->setDNumReg($xml->getElementsByTagName('dNumReg')->item(0)->nodeValue);
  //     $res->setDNumRegEntCom($xml->getElementsByTagName('dNumRegEntCom')->item(0)->nodeValue);
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GRasMerc();
    if(isset($object->dNumLote))
    {
      $res->setDNumLote($object->dNumLote);
    }
    if(isset($object->dVencMerc))
    {
      $res->setDVencMerc(DateTime::createFromFormat('Y-m-d', $object->dVencMerc));
    }
    if(isset($object->dNSerie))
    {
      $res->setDNSerie($object->dNSerie);
    }
    if(isset($object->dNumPedi))
    {
      $res->setDNumPedi($object->dNumPedi);
    }
    if(isset($object->dNumSegui))
    {
      $res->setDNumSegui($object->dNumSegui);
    }
    if(isset($object->dNomImp))
    {
      $res->setDNomImp($object->dNomImp);
    }
    if(isset($object->dDirImp))
    {
      $res->setDDirImp($object->dDirImp);
    }
    if(isset($object->dNumFir))
    {
      $res->setDNumFir($object->dNumFir);
    }
    if(isset($object->dNumReg))
    {
      $res->setDNumReg($object->dNumReg);
    }
    if(isset($object->dNumRegEntCom))
    {
      $res->setDNumRegEntCom($object->dNumRegEntCom);
    }
    return $res;
  }
}
