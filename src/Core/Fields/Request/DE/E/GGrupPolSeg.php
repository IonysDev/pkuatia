<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\E;

use DateTime;
use DOMElement;

/**
 * ID:EA790 gGrupPolSeg Grupo de póliza de seguros
 *PADRE:E800
 */
class GGrupPolSeg
{
  public ?string $dPoliza = null; /// EA791 Código de la póliza
  public ?string $dUnidVig = null; //EA792 Descripción de la unidad de tiempo de vigencia
  public ?int $dVigencia = null; ///EA793 Vigencia de la póliza
  public ?string $dNumPoliza = null; /// EA794 Número de la póliza
  public ?DateTime $dFecIniVig = null; ///EA795 Fecha de inicio de vigencia
  public ?DateTime $dFecFinVig = null; //EA796 Fecha de fin de vigencia
  public ?string $dCodInt = null; ///EA797 Código interno del ítem

  ///////////////////////////////////////////////////////////////////////
  //SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of dPoliza
   *
   * @param string $dPoliza
   *
   * @return self
   */
  public function setDPoliza(string $dPoliza): self
  {
    $this->dPoliza = $dPoliza;

    return $this;
  }


  /**
   * Set the value of dUnidVig
   *
   * @param string $dUnidVig
   *
   * @return self
   */
  public function setDUnidVig(string $dUnidVig): self
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
   * @param string $dNumPoliza
   *
   * @return self
   */
  public function setDNumPoliza(string $dNumPoliza): self
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
   * @param string $dCodInt
   *
   * @return self
   */
  public function setDCodInt(string $dCodInt): self
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
   * @return string
   */
  public function getDPoliza(): string | null
  {
    return $this->dPoliza;
  }

  /**
   * Get the value of dUnidVig
   *
   * @return string
   */
  public function getDUnidVig(): string | null
  {
    return $this->dUnidVig;
  }

  /**
   * Get the value of dVigencia
   *
   * @return int
   */
  public function getDVigencia(): int | null
  {
    return $this->dVigencia;
  }

  /**
   * Get the value of dNumPoliza
   *
   * @return string
   */
  public function getDNumPoliza(): string | null
  {
    return $this->dNumPoliza;
  }

  /**
   * Get the value of dFecIniVig
   *
   * @return DateTime
   */
  public function getDFecIniVig(): DateTime | null
  {
    return $this->dFecIniVig;
  }

  /**
   * Get the value of dFecFinVig
   *
   * @return DateTime
   */
  public function getDFecFinVig(): DateTime | null
  {
    return $this->dFecFinVig;
  }

  /**
   * Get the value of dCodInt
   *
   * @return string
   */
  public function getDCodInt(): string | null
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

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return GGrupPolSeg
  //  */
  // public static function fromDOMElement(DOMElement $xml): GGrupPolSeg
  // {
  //   if (strcmp($xml->tagName, 'gGrupPolSeg') === 0 && $xml->childElementCount == 7) {
  //     $res = new GGrupPolSeg();
  //     $res->setDPoliza($xml->getElementsByTagName('dDPoliza')->item(0)->nodeValue);
  //     $res->setDUnidVig($xml->getElementsByTagName('dUnidVig')->item(0)->nodeValue);
  //     $res->setDVigencia(intval($xml->getElementsByTagName('dVigencia')->item(0)->nodeValue));
  //     $res->setDNumPoliza($xml->getElementsByTagName('dNumPoliza')->item(0)->nodeValue);
  //     $res->setDFecIniVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dfecIniVig')->item(0)->nodeValue));
  //     $res->setDFecFinVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $xml->getElementsByTagName('dFecFinVig')->item(0)->nodeValue));
  //     $res->setDCodInt($xml->getElementsByTagName('gGrupoPolSeg')->item(0)->nodeValue);
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
    $res = new GGrupPolSeg();
    if(isset($response->dPoliza))
    {
      $res->setDPoliza($response->dPoliza);
    }
    if(isset($response->dUnidVig))
    {
      $res->setDUnidVig($response->dUnidVig);
    }
    if(isset($response->dVigencia))
    {
      $res->setDVigencia($response->dVigencia);
    }
    if(isset($response->dNumPoliza))
    {
      $res->setDNumPoliza($response->dNumPoliza);
    }
    if(isset($response->dFecIniVig))
    {
      $res->setDFecIniVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $response->dFecIniVig));
    }
    if(isset($response->dFecFinVig))
    {
      $res->setDFecFinVig(DateTime::createFromFormat('Y-m-d\TH:i:s', $response->dFecFinVig));
    }
    if(isset($response->dCodInt))
    {
      $res->setDCodInt($response->dCodInt);
    }
    
    return $res;
  }
}
