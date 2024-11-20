<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DateTime;
use DOMDocument;
use DOMElement;

/**
 * E820 Grupo de datos adicionales de uso comercial PADRE E790
 */
class GGrupAdi
{
  public ?String $dCiclo;     //E821 Ciclo 
  public ?DateTime $dFecIniC; //E822 Fecha de inicio de ciclo
  public ?DateTime $dFecFinC; //E823 Fecha de fin de ciclo
  public ?DateTime $dVencPag; //E824 Fecha de vencimiento de pago
  public ?String $dContrato; //E825 Número de contrato
  public ?String $dSalAnt;   //E826 Saldo anterior
  public ?String $dCodConDncp; //E827 Código de contratación de la DNCP

  /////////////////////////////////////////////
  //setters
  /////////////////////////////////////////////


  /**
   * Establece el valor de ciclo
   *
   * @param String $dCiclo
   *
   * @return self
   */
  public function setDCiclo(String $dCiclo): self
  {
    $this->dCiclo = $dCiclo;

    return $this;
  }


  /**
   * Establece el valor de dFecIniC
   *
   * @param ?DateTime $dFecIniC
   *
   * @return self
   */
  public function setDFecIniC(?DateTime $dFecIniC): self
  {
    $this->dFecIniC = $dFecIniC;

    return $this;
  }


  /**
   * Establece el valor de dFecFinC
   *
   * @param ?DateTime $dFecFinC
   *
   * @return self
   */
  public function setDFecFinC(?DateTime $dFecFinC): self
  {
    $this->dFecFinC = $dFecFinC;

    return $this;
  }


  /**
   * Establece el valor de dVencPag
   *
   * @param ?DateTime $dVencPag
   *
   * @return self
   */
  public function setDVencPag(?DateTime $dVencPag): self
  {
    $this->dVencPag = $dVencPag;

    return $this;
  }


  /**
   * Establece el valor de dContrato
   *
   * @param String $dContrato
   *
   * @return self
   */
  public function setDContrato(String $dContrato): self
  {
    $this->dContrato = $dContrato;

    return $this;
  }


  /**
   * Establece el valor de dSalAnt
   *
   * @param ?String $dSalAnt (decimal BCMAth)
   *
   * @return self
   */
  public function setDSalAnt(?String $dSalAnt): self
  {
    $this->dSalAnt = $dSalAnt;

    return $this;
  }

  /**
   * Establece el valor de dCodConDncp
   *
   * @param ?String $dCodConDncp
   *
   * @return self
   */
  public function setdCodConDncp(?String $dCodConDncp): self
  {
    $this->dCodConDncp = $dCodConDncp;

    return $this;
  }

  /////////////////////////////////////////////
  //GETTERS
  /////////////////////////////////////////////
  

  /**
   * Obtiene el valor de ciclo
   *
   * @return String
   */
  public function getDCiclo(): String
  {
    return $this->dCiclo;
  }

  /**
   * Obtiene el valor de dFecIniC
   *
   * @return ?DateTime
   */
  public function getDFecIniC(): ?DateTime
  {
    return $this->dFecIniC;
  }

  /**
   * Obtiene el valor de dFecFinC
   *
   * @return ?DateTime
   */
  public function getDFecFinC(): ?DateTime
  {
    return $this->dFecFinC;
  }

  /**
   * Obtiene el valor de dVencPag
   *
   * @return ?DateTime
   */
  public function getDVencPag(): ?DateTime
  {
    return $this->dVencPag;
  }

  /**
   * Obtiene el valor de dContrato
   *
   * @return String
   */
  public function getDContrato(): String
  {
    return $this->dContrato;
  }

  /**
   * Obtiene el valor de dSalAnt
   *
   * @return ?float
   */
  public function getDSalAnt(): ?float
  {
    return $this->dSalAnt;
  }


  /**
   * Obtiene el valor de dCodConDncp
   *
   * @return ?String
   */
  public function getdCodConDncp(): ?String
  {
    return $this->dCodConDncp;
  }

  /////////////////////////////////////////////
  //FUNCTIONS
  /////////////////////////////////////////////
  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gGrupAdi');
    $res->appendChild(new DOMElement('dCiclo', $this->dCiclo));
    $res->appendChild(new DOMElement('dFecIniC', $this->dFecIniC->format('yyyy-mm-dd')));
    $res->appendChild(new DOMElement('dFecFinC', $this->dFecFinC->format('yyyy-mm-dd')));
    $res->appendChild(new DOMElement('dVencPag', $this->dVencPag->format('yyyy-mm-dd')));
    $res->appendChild(new DOMElement('dContrato', $this->dContrato));
    $res->appendChild(new DOMElement('dSalAnt', $this->dSalAnt));
    $res->appendChild(new DOMElement('dCodConDncp', $this->dCodConDncp));
    return $res;
  }
  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GGrupAdi();

    if(isset($object->ciclo))
    {
      $res->setDCiclo($object->ciclo);
    }

    if(isset($object->dFecIniC))
    {
      $res->setDFecIniC($object->dFecIniC);
    }

    if(isset($object->dFecFinC))
    {
      $res->setDFecFinC($object->dFecFinC);
    }

    if(isset($object->dVencPag))
    {
      $res->setDVencPag($object->dVencPag);
    }

    if(isset($object->dContrato))
    {
      $res->setDContrato($object->dContrato);
    }

    if(isset($object->dSalAnt))
    {
      $res->setDSalAnt($object->dSalAnt);
    }

    if(isset($object->dCodConDncp))
    {
      $res->setdCodConDncp($object->dCodConDncp);
    }

    return $res;
  }
}
