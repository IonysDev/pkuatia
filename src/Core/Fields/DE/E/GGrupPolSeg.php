<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DateTime;
use DOMElement;

/**
 * ID:EA790 gGrupPolSeg Grupo de póliza de seguros
 *PADRE:E800
 */
class GGrupPolSeg
{
  public String $dPoliza; /// EA791 Código de la póliza
  public String $dUnidVig; //EA792 Descripción de la unidad de tiempo de vigencia
  public int $dVigencia; ///EA793 Vigencia de la póliza
  public String $dNumPoliza; /// EA794 Número de la póliza
  public DateTime $dFecIniVig; ///EA795 Fecha de inicio de vigencia
  public DateTime $dFecFinVig; //EA796 Fecha de fin de vigencia
  public String $dCodInt; ///EA797 Código interno del ítem

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dPoliza
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
   * Set the value of dUnidVig
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
   * Set the value of dVigencia
   *
   * @param int $dVigencia
   *
   * @return self
   */
  public function setDVigencia(int $dVigencia): self
  {
    $this->dVigencia = $dVigencia;

    return $this;
  }


  /**
   * Set the value of dNumPoliza
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
   * Set the value of dFecIniVig
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
   * Set the value of dFecFinVig
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
   * Set the value of dCodInt
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
  ///Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of dPoliza
   *
   * @return String
   */
  public function getDPoliza(): String
  {
    return $this->dPoliza;
  }

  /**
   * Get the value of dUnidVig
   *
   * @return String
   */
  public function getDUnidVig(): String
  {
    return $this->dUnidVig;
  }

  /**
   * Get the value of dVigencia
   *
   * @return int
   */
  public function getDVigencia(): int
  {
    return $this->dVigencia;
  }

  /**
   * Get the value of dNumPoliza
   *
   * @return String
   */
  public function getDNumPoliza(): String
  {
    return $this->dNumPoliza;
  }

  /**
   * Get the value of dFecIniVig
   *
   * @return DateTime
   */
  public function getDFecIniVig(): DateTime
  {
    return $this->dFecIniVig;
  }

  /**
   * Get the value of dFecFinVig
   *
   * @return DateTime
   */
  public function getDFecFinVig(): DateTime
  {
    return $this->dFecFinVig;
  }

  /**
   * Get the value of dCodInt
   *
   * @return String
   */
  public function getDCodInt(): String
  {
    return $this->dCodInt;
  }


  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDomElement
   *
   * @return DOMElement
   */
  public function toDomElement(): DOMElement
  {
    $res = new DOMElement('gGrupPolSeg');
    $res->appendChild(new DOMElement('dPoliza', $this->getDPoliza()));
    $res->appendChild(new DOMElement('dUnidVig', $this->getDUnidVig()));
    $res->appendChild(new DOMElement('dVigencia', $this->getDVigencia()));
    $res->appendChild(new DOMElement('dNumPoliza', $this->getDNumPoliza()));
    $res->appendChild(new DOMElement('dFecIniVig', $this->getDFecIniVig()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('dFecFinVig', $this->getDFecFinVig()->format('Y-m-d\TH:i:s')));
    $res->appendChild(new DOMElement('dCodInt', $this->getDCodInt()));

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
    $res = new GGrupPolSeg();
    if(isset($object->dPoliza))
    {
      $res->setDPoliza($object->dPoliza);
    }
    if(isset($object->dUnidVig))
    {
      $res->setDUnidVig($object->dUnidVig);
    }
    if(isset($object->dVigencia))
    {
      $res->setDVigencia($object->dVigencia);
    }
    if(isset($object->dNumPoliza))
    {
      $res->setDNumPoliza($object->dNumPoliza);
    }
    if(isset($object->dFecIniVig))
    {
      $res->setDFecIniVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $object->dFecIniVig));
    }
    if(isset($object->dFecFinVig))
    {
      $res->setDFecFinVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $object->dFecFinVig));
    }
    if(isset($object->dCodInt))
    {
      $res->setDCodInt($object->dCodInt);
    }
    
    return $res;
  }
}
