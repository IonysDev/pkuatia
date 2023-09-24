<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\G;

use Abiliomp\Pkuatia\DataMappings\UnidadMedidaMapping;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:G050
 * Descripción: Campos generales de la carga 
 * Nodo Padre: G001 - GCamGen - Campos de uso general 
 */
class GCamCarg
{
                                   // Id - Longitud - Ocurrencia - Descripción
  public int    $cUniMedTotVol;    // G051 - 1-5  - 0-1 - Unidad de medida del total de volumen de la mercadería
  public String $dDesUniMedTotVol; // G052 - 1-10 - 0-1 - Descripción de la unidad de medida del total de volumen de la mercadería
  public int    $dTotVolMerc;      // G053 - 1-20 - 0-1 - Total volumen de la mercadería
  public int    $cUniMedTotPes;    // G054 - 1-5  - 0-1 - Unidad de medida del peso total de la mercadería
  public String $dDesUniMedTotPes; // G055 - 1-10 - 0-1 - Descripción de la unidad de medida del peso total de la mercadería
  public int    $dTotPesMerc;      // G056 - 1-20 - 0-1 - Total peso de la mercadería;
  public int    $iCarCarga;        // G057 - 1-1  - 0-1 - Características de la  Carga 
  public String $dDesCarCarga;     // G058 - 1-50 - 0-1 - Descripción de las características de la carga

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
    $this->setDDesUniMedTotVol(UnidadMedidaMapping::GetDesc(strval($cUniMedTotVol)));
    return $this;
  }

  /**
   * Set the value of dDesUniMedTotVol
   * 
   * @param String $dDesUniMedTotVol
   * 
   * @return self
   */
  public function setDDesUniMedTotVol(String $dDesUniMedTotVol): self
  {
    if(is_null($dDesUniMedTotVol) || strlen($dDesUniMedTotVol) == 0)
    {
      $this->dDesUniMedTotVol;
    }
    else
    {
      $this->dDesUniMedTotVol = substr($dDesUniMedTotVol, 0, 10);
    }
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
    $this->setDDesUniMedTotPes(UnidadMedidaMapping::GetDesc(strval($cUniMedTotPes)));
    return $this;
  }

  /**
   * Set the value of dDesUniMedTotPes
   *
   * @param String $dDesUniMedTotPes
   *
   * @return self
   */
  public function setDDesUniMedTotPes(String $dDesUniMedTotPes): self
  {
    if(is_null($dDesUniMedTotPes) || strlen($dDesUniMedTotPes) == 0)
    {
      $this->dDesUniMedTotPes;
    }
    else
    {
      $this->dDesUniMedTotPes = substr($dDesUniMedTotPes, 0, 10);
    }
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
    switch ($iCarCarga) {
      case 1:
        $this->setDDesCarCarga("Mercaderías con cadena de frío");
        break;
      case 2:
        $this->setDDesCarCarga("Carga peligrosa");
        break;
    }
    return $this;
  }

  /**
   * Set the value of dDesCarCarga
   * 
   * @param String $dDesCarCarga
   * 
   * @return self
   */
  public function setDDesCarCarga(String $dDesCarCarga): self
  {
    if(is_null($dDesCarCarga) || strlen($dDesCarCarga) == 0)
    {
      $this->dDesCarCarga;
    }
    else
    {
      $this->dDesCarCarga = substr($dDesCarCarga, 0, 50);
    }
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
  public function getCUniMedTotVol(): int
  {
    return $this->cUniMedTotVol;
  }

  /**
   * G052 Descripción de la unidad de medida del total de volumen de la mercadería
   *
   * @return String
   */
  public function getDDesUniMedTotVol(): String
  {
    return $this->dDesUniMedTotVol;
  }


  /**
   * Get the value of dTotVolMerc
   *
   * @return int
   */
  public function getDTotVolMerc(): int
  {
    return $this->dTotVolMerc;
  }

  /**
   * Get the value of cUniMedTotPes
   *
   * @return int
   */
  public function getCUniMedTotPes(): int
  {
    return $this->cUniMedTotPes;
  }


  /**
   * G055 Descripción de la unidad de medida del peso total de la mercadería
   *
   * @return String
   */
  public function getdDesUniMedTotPes(): String
  {
    return $this->dDesUniMedTotPes;
    
  }

  /**
   * Get the value of dTotPesMerc
   *
   * @return int
   */
  public function getDTotPesMerc(): int
  {
    return $this->dTotPesMerc;
  }

  /**
   * Get the value of iCarCarga
   *
   * @return int
   */
  public function getICarCarga(): int
  {
    return $this->iCarCarga;
  }

  /**
   * G058 Descripción de las características de la carga
   *
   * @return String
   */
  public function getDDesCarCarga(): String
  {
    return $this->dDesCarCarga;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto de la GCamCarg a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node)
  {
    if(strcmp($node->getName(), 'gCamCarg') != 0)
    {
      throw new \Exception("El nombre del nodo no corresponde a 'gCamCarg'");
    }
    $res = new GCamCarg();
    if(isset($node->cUniMedTotVol))
    {
      $res->setCUniMedTotVol(intval($node->cUniMedTotVol));
    }
    if(isset($node->dDesUniMedTotVol))
    {
      $res->setDDesUniMedTotVol(strval($node->dDesUniMedTotVol));
    }
    if(isset($node->dTotVolMerc))
    {
      $res->setDTotVolMerc(intval($node->dTotVolMerc));
    }
    if(isset($node->cUniMedTotPes))
    {
      $res->setCUniMedTotPes(intval($node->cUniMedTotPes));
    }
    if(isset($node->dDesUniMedTotPes))
    {
      $res->setDDesUniMedTotPes(strval($node->dDesUniMedTotPes));
    }
    if(isset($node->dTotPesMerc))
    {
      $res->setDTotPesMerc(intval($node->dTotPesMerc));
    }
    if(isset($node->iCarCarga))
    {
      $res->setICarCarga(intval($node->iCarCarga));
    }
    if(isset($node->dDesCarCarga))
    {
      $res->setDDesCarCarga(strval($node->dDesCarCarga));
    }
    return $res;
  }

  /**
   * Convierte este GCamCarg a un DOMElement
   * 
   * @param DOMDocument $doc Documento DOM donde se generará el nodo, sin insertarse
   *
   * @return DOMElement El nodo DOM generado
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamCarg');
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
  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    $res = new GCamCarg();
    if(isset($object->cUniMedTotVol))
    {
      $res->setCUniMedTotVol(intval($object->cUniMedTotVol));
    }
    if(isset($object->dTotVolMerc))
    {
      $res->setDTotVolMerc(intval($object->dTotVolMerc));
    }
    if(isset($object->cUniMedTotPes))
    {
      $res->setCUniMedTotPes(intval($object->cUniMedTotPes));
    }
    if(isset($object->dTotPesMerc))
    {
      $res->setDTotPesMerc(intval($object->dTotPesMerc));
    }
    if(isset($object->iCarCarga))
    {
      $res->setICarCarga(intval($object->iCarCarga));
    }
    
    return $res;
  }
}
