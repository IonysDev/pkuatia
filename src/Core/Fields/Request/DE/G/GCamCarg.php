<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\G;

use Abiliomp\Pkuatia\Helpers\UMHelper;
use DOMElement;

/**
 * ID:G050 Campos generales de la carga PADRE:G001 
 */
class GCamCarg
{
  public ?int $cUniMedTotVol = null; //G051 Unidad de medida del total de volumen de la mercadería
  public ?int $dTotVolMerc = null; //G053 Total volumen de la mercadería
  public ?int $cUniMedTotPes = null; //G054 Unidad de medida del peso total de la mercadería
  public ?int $dTotPesMerc = null; //G056 Total peso de la mercadería
  public ?int $iCarCarga = null; //G057 Características de la  Carga 

  ///////////////////////////////////////////////////////////////////////
  ///SETTER
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of cUniMedTotVol
   *
   * @param int $cUniMedTotVol
   *
   * @return self
   */
  public function setCUniMedTotVol(int $cUniMedTotVol): self
  {
    $this->cUniMedTotVol = $cUniMedTotVol;

    return $this;
  }


  /**
   * Set the value of dTotVolMerc
   *
   * @param int $dTotVolMerc
   *
   * @return self
   */
  public function setDTotVolMerc(int $dTotVolMerc): self
  {
    $this->dTotVolMerc = $dTotVolMerc;

    return $this;
  }


  /**
   * Set the value of cUniMedTotPes
   *
   * @param int $cUniMedTotPes
   *
   * @return self
   */
  public function setCUniMedTotPes(int $cUniMedTotPes): self
  {
    $this->cUniMedTotPes = $cUniMedTotPes;

    return $this;
  }


  /**
   * Set the value of dTotPesMerc
   *
   * @param int $dTotPesMerc
   *
   * @return self
   */
  public function setDTotPesMerc(int $dTotPesMerc): self
  {
    $this->dTotPesMerc = $dTotPesMerc;

    return $this;
  }


  /**
   * Set the value of iCarCarga
   *
   * @param int $iCarCarga
   *
   * @return self
   */
  public function setICarCarga(int $iCarCarga): self
  {
    $this->iCarCarga = $iCarCarga;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTER
  ///////////////////////////////////////////////////////////////////////


  /**
   * Get the value of cUniMedTotVol
   *
   * @return int
   */
  public function getCUniMedTotVol(): int | null
  {
    return $this->cUniMedTotVol;
  }

  /**
   * G052 Descripción de la unidad de medida del total de volumen de la mercadería
   *
   * @return string
   */
  public function getDDesUniMedTotVol(): string | null
  {
    return UMHelper::getUMDesc(strval($this->cUniMedTotVol)); //Si D202 = 3 utilizar los datos del  WS del link de la DNCP Utilizar el atributo “ID”
  }


  /**
   * Get the value of dTotVolMerc
   *
   * @return int
   */
  public function getDTotVolMerc(): int | null
  {
    return $this->dTotVolMerc;
  }

  /**
   * Get the value of cUniMedTotPes
   *
   * @return int
   */
  public function getCUniMedTotPes(): int | null
  {
    return $this->cUniMedTotPes;
  }


  /**
   * G055 Descripción de la unidad de medida del peso total de la mercadería
   *
   * @return string
   */
  public function getdDesUniMedTotPes(): string | null
  {
    return UMHelper::getUMDesc(strval($this->cUniMedTotPes));//Si D202 = 3 utilizar los datos del  WS del link de la DNCP Utilizar el atributo “ID”
    
  }

  /**
   * Get the value of dTotPesMerc
   *
   * @return int
   */
  public function getDTotPesMerc(): int | null
  {
    return $this->dTotPesMerc;
  }

  /**
   * Get the value of iCarCarga
   *
   * @return int
   */
  public function getICarCarga(): int | null
  {
    return $this->iCarCarga;
  }

  /**
   * G058 Descripción de las características de la carga
   *
   * @return string
   */
  public function getDDesCarCarga(): string | null
  {
    switch ($this->iCarCarga) {
      case 1:
        return "Mercaderías con cadena de frío";
        break;

      case 2:
        return "Carga peligrosa";
        break;

      case 3:
        return "Otro de características similares (especificar)";
        break;

      default:
        return null;
        break;
    }
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gCamCarg');

    $res->appendChild(new DOMElement('cUniMedTotVol', $this->getCUniMedTotPes()));
    $res->appendChild(new DOMElement('dDesUniMedTotVol', $this->getDDesUniMedTotVol()));
    $res->appendChild(new DOMElement('dTotVolMerc', $this->getDTotVolMerc()));
    $res->appendChild(new DOMElement('cUniMedTotPes', $this->getCUniMedTotPes()));
    $res->appendChild(new DOMElement('dDesUniMedTotPes', $this->getCUniMedTotPes()));
    $res->appendChild(new DOMElement('dTotPesMerc', $this->getDTotPesMerc()));
    $res->appendChild(new DOMElement('iCarCarga', $this->getICarCarga()));
    $res->appendChild(new DOMElement('dDesCarCarga', $this->getDDesCarCarga()));

    return $res;
  }

  // public static function fromDOMElement(DOMElement $xml): GCamCarg
  // {
  //   if (strcmp($xml->tagName, 'gCamcarg' == 0) && $xml->childElementCount == 5) {
  //     $res = new GCamCarg();
  //     $res->setCUniMedTotVol(intval($xml->getElementsByTagName('cUniMedTotVol')->item(0)->nodeValue));
  //     $res->setDTotVolMerc(intval($xml->getElementsByTagName('dTotVolMerc')->item(0)->nodeValue));
  //     $res->setCUniMedTotPes(intval($xml->getElementsByTagName('cUniMedTotPes')->item(0)->nodeValue));
  //     $res->setDTotPesMerc(intval($xml->getElementsByTagName('dTotPesMerc')->item(0)->nodeValue));
  //     $res->setICarCarga(intval($xml->getElementsByTagName('iCarCarga')->item(0)->nodeValue));
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
  public static function fromResponse($response):self
  {
    $res = new GCamCarg();
    if(isset($response->cUniMedTotVol))
    {
      $res->setCUniMedTotVol(intval($response->cUniMedTotVol));
    }
    if(isset($response->dTotVolMerc))
    {
      $res->setDTotVolMerc(intval($response->dTotVolMerc));
    }
    if(isset($response->cUniMedTotPes))
    {
      $res->setCUniMedTotPes(intval($response->cUniMedTotPes));
    }
    if(isset($response->dTotPesMerc))
    {
      $res->setDTotPesMerc(intval($response->dTotPesMerc));
    }
    if(isset($response->iCarCarga))
    {
      $res->setICarCarga(intval($response->iCarCarga));
    }
    
    return $res;
  }
}
