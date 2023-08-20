<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DateTime;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     EA790   
 * Nombre:      gGrupPolSeg   
 * Descripción: Grupo de póliza de seguros  
 * Nodo Padre:  E800  
 */

class GGrupPolSeg extends BaseSifenField
{
                               // Id - Longitud - Ocurrencia - Descripción
  public String   $dPoliza;    // EA791 - 1-20  - 1-1 - Código de la póliza
  public String   $dUnidVig;   // EA792 - 3-15  - 1-1 - Descripción de la unidad de tiempo de vigencia
  public String   $dVigencia;  // EA793 - 1-5p1 - 1-1 - Vigencia de la póliza (decimal BCMath)
  public String   $dNumPoliza; // EA794 - 1-25  - 1-1 - Número de la póliza
  public DateTime $dFecIniVig; // EA795 - 19    - 0-1 - Fecha de inicio de vigencia en formato AAAA-MM-DDThh:mm:ss
  public DateTime $dFecFinVig; // EA796 - 19    - 0-1 - Fecha de fin de vigencia en formato AAAA-MM-DDThh:mm:ss
  public String   $dCodInt;    // EA797 - 1-20  - 0-1 - Código interno de referencia a un ítem

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dPoliza (Código de la póliza)
   *
   * @param String $dPoliza
   *
   * @return self
   */
  public function setDPoliza(String $dPoliza): self
  {
    $this->dPoliza = $dPoliza;

    return $this;
  }


  /**
   * Establece el valor de dUnidVig (Descripción de la unidad de tiempo de vigencia)
   *
   * @param String $dUnidVig
   *
   * @return self
   */
  public function setDUnidVig(String $dUnidVig): self
  {
    $this->dUnidVig = $dUnidVig;

    return $this;
  }


  /**
   * Establece el valor de dVigencia (Vigencia de la póliza)
   *
   * @param String $dVigencia
   *
   * @return self
   */
  public function setDVigencia(String $dVigencia): self
  {
    $this->dVigencia = $dVigencia;

    return $this;
  }


  /**
   * Establece el valor de dNumPoliza (Número de la póliza)
   *
   * @param String $dNumPoliza
   *
   * @return self
   */
  public function setDNumPoliza(String $dNumPoliza): self
  {
    $this->dNumPoliza = $dNumPoliza;

    return $this;
  }


  /**
   * Establece el valor de dFecIniVig (Fecha/hora de inicio de vigencia)  
   *
   * @param DateTime $dFecIniVig
   *
   * @return self
   */
  public function setDFecIniVig(DateTime $dFecIniVig): self
  {
    $this->dFecIniVig = $dFecIniVig;

    return $this;
  }


  /**
   * Establece el valor de dFecFinVig (Fecha/hora de fin de vigencia)
   *
   * @param DateTime $dFecFinVig
   *
   * @return self
   */
  public function setDFecFinVig(DateTime $dFecFinVig): self
  {
    $this->dFecFinVig = $dFecFinVig;

    return $this;
  }


  /**
   * Establece el valor de dCodInt (Código interno de referencia a un ítem)
   *
   * @param String $dCodInt
   *
   * @return self
   */
  public function setDCodInt(String $dCodInt): self
  {
    $this->dCodInt = $dCodInt;

    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve el valor de dPoliza (Código de la póliza)
   *
   * @return String
   */
  public function getDPoliza(): String
  {
    return $this->dPoliza;
  }

  /**
   * Devuelve el valor de dUnidVig (Descripción de la unidad de tiempo de vigencia)
   *
   * @return String
   */
  public function getDUnidVig(): String
  {
    return $this->dUnidVig;
  }

  /**
   * Devuelve el valor de dVigencia (Vigencia de la póliza)
   *
   * @return String
   */
  public function getDVigencia(): String
  {
    return $this->dVigencia;
  }

  /**
   * Devuelve el valor de dNumPoliza (Número de la póliza)
   *
   * @return String
   */
  public function getDNumPoliza(): String
  {
    return $this->dNumPoliza;
  }

  /**
   * Devuelve el valor de dFecIniVig (Fecha/hora de inicio de vigencia)
   *
   * @return DateTime
   */
  public function getDFecIniVig(): DateTime
  {
    return $this->dFecIniVig;
  }

  /**
   * Devuelve el valor de dFecFinVig (Fecha/hora de fin de vigencia)
   *
   * @return DateTime
   */
  public function getDFecFinVig(): DateTime
  {
    return $this->dFecFinVig;
  }

  /**
   * Devuelve el valor de dCodInt (Código interno de referencia a un ítem)
   *
   * @return String
   */
  public function getDCodInt(): String
  {
    return $this->dCodInt;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un GGrupPolSeg a partir de un objeto SimpleXMLElement
   * 
   * @param  SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gGrupPolSeg') != 0)
      throw new \Exception('[GGrupPolSeg] El nombre del nodo no corresponde a gGrupPolSeg: ' . $node->getName(), 1);
    $res = new GGrupPolSeg();
    $res->setDPoliza($node->dPoliza)
        ->setDUnidVig($node->dUnidVig)
        ->setDVigencia($node->dVigencia)
        ->setDNumPoliza($node->dNumPoliza);
    if(isset($node->dFecIniVig))
      $res->setDFecIniVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $node->dFecIniVig));
    if(isset($node->dFecFinVig))
      $res->setDFecFinVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $node->dFecFinVig));
    if(isset($node->dCodInt))
      $res->setDCodInt($node->dCodInt);
    return $res;
  }

  /**
   * Instancia un GGrupPolSeg a partir de un objeto stdClass correspondiente a la respuesta del SIFEN a una consulta SOAP.
   *
   * @param  mixed $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GGrupPolSeg();
    $res->setDPoliza($object->dPoliza);
    $res->setDUnidVig($object->dUnidVig);
    $res->setDVigencia($object->dVigencia);
    $res->setDNumPoliza($object->dNumPoliza);
    if(isset($object->dFecIniVig))
      $res->setDFecIniVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $object->dFecIniVig));
    if(isset($object->dFecFinVig))
      $res->setDFecFinVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $object->dFecFinVig));
    if(isset($object->dCodInt))
      $res->setDCodInt($object->dCodInt);
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte el GGrupPolSeg a un DOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gGrupPolSeg');
    $res->appendChild(new DOMElement('dPoliza', $this->getDPoliza()));
    $res->appendChild(new DOMElement('dUnidVig', $this->getDUnidVig()));
    $res->appendChild(new DOMElement('dVigencia', $this->getDVigencia()));
    $res->appendChild(new DOMElement('dNumPoliza', $this->getDNumPoliza()));
    if($this->getDFecIniVig() != null)
      $res->appendChild(new DOMElement('dFecIniVig', $this->getDFecIniVig()->format('Y-m-d\TH:i:s')));
    if($this->getDFecFinVig() != null)
      $res->appendChild(new DOMElement('dFecFinVig', $this->getDFecFinVig()->format('Y-m-d\TH:i:s')));
    if($this->getDCodInt() != null)
      $res->appendChild(new DOMElement('dCodInt', $this->getDCodInt()));
    return $res;
  }
}
