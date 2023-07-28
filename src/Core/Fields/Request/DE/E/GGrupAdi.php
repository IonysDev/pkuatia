<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DateTime;
use DOMElement;

/**
 * E820 Grupo de datos adicionales de uso comercial PADRE E790
 */
class GGrupAdi
{
  public ?string $ciclo = null;     //E821 Ciclo 
  public ?DateTime $dFecIniC = null; //E822 Fecha de inicio de ciclo
  public ?DateTime $dFecFinC = null; //E823 Fecha de fin de ciclo
  public ?DateTime $dVencPag = null; //E824 Fecha de vencimiento de pago
  public ?string $dContrato = null; //E825 Número de contrato
  public ?float $dSaltAnt = null;   //E826 Saldo anterior


  /////////////////////////////////////////////
  //setters
  /////////////////////////////////////////////


  /**
   * Set the value of ciclo
   *
   * @param ?string $ciclo
   *
   * @return self
   */
  public function setCiclo(?string $ciclo): self
  {
    $this->ciclo = $ciclo;

    return $this;
  }


  /**
   * Set the value of dFecIniC
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
   * Set the value of dFecFinC
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
   * Set the value of dVencPag
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
   * Set the value of dContrato
   *
   * @param ?string $dContrato
   *
   * @return self
   */
  public function setDContrato(?string $dContrato): self
  {
    $this->dContrato = $dContrato;

    return $this;
  }


  /**
   * Set the value of dSaltAnt
   *
   * @param ?float $dSaltAnt
   *
   * @return self
   */
  public function setDSaltAnt(?float $dSaltAnt): self
  {
    $this->dSaltAnt = $dSaltAnt;

    return $this;
  }

  /////////////////////////////////////////////
  //GETTERS
  /////////////////////////////////////////////
  

  /**
   * Get the value of ciclo
   *
   * @return ?string
   */
  public function getCiclo(): ?string
  {
    return $this->ciclo;
  }

  /**
   * Get the value of dFecIniC
   *
   * @return ?DateTime
   */
  public function getDFecIniC(): ?DateTime
  {
    return $this->dFecIniC;
  }

  /**
   * Get the value of dFecFinC
   *
   * @return ?DateTime
   */
  public function getDFecFinC(): ?DateTime
  {
    return $this->dFecFinC;
  }

  /**
   * Get the value of dVencPag
   *
   * @return ?DateTime
   */
  public function getDVencPag(): ?DateTime
  {
    return $this->dVencPag;
  }

  /**
   * Get the value of dContrato
   *
   * @return ?string
   */
  public function getDContrato(): ?string
  {
    return $this->dContrato;
  }

  /**
   * Get the value of dSaltAnt
   *
   * @return ?float
   */
  public function getDSaltAnt(): ?float
  {
    return $this->dSaltAnt;
  }

  /////////////////////////////////////////////
  //FUNCTIONS
  /////////////////////////////////////////////
  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gGrupoAdi');
    $res->appendChild(new DOMElement('ciclo', $this->ciclo));
    $res->appendChild(new DOMElement('dFecIniC', $this->dFecIniC->format('yyyy-mm-dd')));
    $res->appendChild(new DOMElement('dFecFinC', $this->dFecFinC->format('yyyy-mm-dd')));
    $res->appendChild(new DOMElement('dVencPag', $this->dVencPag->format('yyyy-mm-dd')));
    $res->appendChild(new DOMElement('dContrato', $this->dContrato));
    $res->appendChild(new DOMElement('dSaltAnt', $this->dSaltAnt));
    return $res;
  }
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response):self
  {
    $res = new GGrupAdi();

    if(isset($response->ciclo))
    {
      $res->setCiclo($response->ciclo);
    }

    if(isset($response->dFecIniC))
    {
      $res->setDFecIniC($response->dFecIniC);
    }

    if(isset($response->dFecFinC))
    {
      $res->setDFecFinC($response->dFecFinC);
    }

    if(isset($response->dVencPag))
    {
      $res->setDVencPag($response->dVencPag);
    }

    if(isset($response->dContrato))
    {
      $res->setDContrato($response->dContrato);
    }

    if(isset($response->dSaltAnt))
    {
      $res->setDSaltAnt($response->dSaltAnt);
    }

    return $res;
  }
}
