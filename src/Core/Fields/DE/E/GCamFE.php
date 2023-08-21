<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DateTime;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E010
 * Nombre:      gCamFE
 * Descripción: Campos que componen la factura electrónica (FE)
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico 
 */

class GCamFE
{
  public const INDICADOR_PRESENCIA_OPERACION_PRESENCIAL = 1;
  public const INDICADOR_PRESENCIA_OPERACION_ELECTRONICA = 2;
  public const INDICADOR_PRESENCIA_OPERACION_TELEMARKETING = 3;
  public const INDICADOR_PRESENCIA_VENTA_A_DOMICILIO = 4;
  public const INDICADOR_PRESENCIA_OPERACION_BANCARIA = 5;
  public const INDICADOR_PRESENCIA_OPERACION_CICLICA = 6;
  public const INDICADOR_PRESENCIA_OTRO = 9;

                                // Id - Longitud - Ocurrencia - Descripción
  public int      $iIndPres;    // E011 - 1     - 1-1 - Indicador de presencia
  public String   $dDesIndPres; // E012 - 10-30 - 1-1 - Descripción del indicador de presencia
  public DateTime $dFecEmNR;    // E013 - 10    - 0-1 - Fecha en el formato: AAAA-MM-DD Fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica cuando corresponda. RG 41/14
  public GCompPub $gComPub;     // E020 -       - 0-1 - Campos que describen las informaciones de compras públicas

  /**
   * Constructor
   * Establece los valores por defecto:
   *    > iIndPres = 1
   *    > dDesIndPres = "Operación presencial"
   */
  public function __construct()
  {
    $this->iIndPres = self::INDICADOR_PRESENCIA_OPERACION_PRESENCIAL;
    $this->dDesIndPres = "Operación presencial";
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * establece el valor de iIndPres (código indicador de presencia)
   *
   * @param int $iIndPres
   *
   * @return self
   */
  public function setIIndPres(int $iIndPres): self
  {
    $this->iIndPres = $iIndPres;
    switch ($iIndPres) {
      case 1:
        $this->dDesIndPres = "Operación presencial";
        break;
      case 2:
        $this->dDesIndPres = "Operación electrónica";
        break;
      case 3:
        $this->dDesIndPres = "Operación telemarketing";
        break;
      case 4:
        $this->dDesIndPres = "Venta a domicilio";
        break;
      case 5:
        $this->dDesIndPres = "Operación bancaria";
        break;
      case 6:
        $this->dDesIndPres = "Operación cíclica";
        break;
      case 9:
        $this->dDesIndPres = "Otro";
        break;
      default:
        throw new \Exception("Invalid iIndPres value: " . $iIndPres);
        break;
    }
    return $this;
  }

  /**
   * Set the value of dDesIndPres
   *
   * @param String $dDesIndPres
   *
   * @return self
   */
  public function setDDesIndPres(String $dDesIndPres): self
  {
    if(is_null($dDesIndPres) || strlen($dDesIndPres) == 0)
    {
      $this->dDesIndPres;
    }
    else
    {
      $this->dDesIndPres = substr($dDesIndPres, 0, 30);
    }
    return $this;
  }


  /**
   * Set the value of dFecEmNR
   *
   * @param DateTime $dFecEmNR
   *
   * @return self
   */
  public function setDFecEmNR(DateTime $dFecEmNR): self
  {
    $this->dFecEmNR = $dFecEmNR;
    return $this;
  }


  /**
   * Set the value of gComPub
   *
   * @param GCompPub $gComPub
   *
   * @return self
   */
  public function setGComPub(GCompPub $gComPub): self
  {
    $this->gComPub = $gComPub;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Get the value of iIndPres
   */
  public function getIIndPres(): int
  {
    return $this->iIndPres;
  }

  /**
   * E012 dDesIndPres Descripción del indicador de presencia
   *
   * @return String
   */
  public function getDDesIndPres(): String
  {
    return $this->dDesIndPres;
  }

  /**
   * Get the value of dFecEmNR
   */
  public function getDFecEmNR(): DateTime
  {
    return $this->dFecEmNR;
  }

  

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto del tipo GCamFE a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if(strcmp($node->getName(), 'gCamFE') != 0)
    {
      throw new \Exception("El nodo '" . $node->getName() . "' no corresponde a 'gCamFE'");
    }
    $res = new GCamFE();
    $res->iIndPres = intval($node->iIndPres);
    $res->dDesIndPres = strval($node->dDesIndPres);
    if(isset($node->dFecEmNR))
    {
      $res->dFecEmNR = DateTime::createFromFormat('Y-m-d', strval($node->dFecEmNR));
    }
    if(isset($node->gComPub))
    {
      $res->gComPub = GCompPub::FromSimpleXMLElement($node->gComPub);
    }
    return $res;
  }

  /**
   * XML Element
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $doc = new \DOMDocument();
    $res = $doc->createElement('gCamFE');
    $res->appendChild(new DOMElement('iIndPres', $this->iIndPres));
    $res->appendChild(new DOMElement('dDesIndPres', $this->getDDesIndPres()));
    if(isset($this->dFecEmNR))
      $res->appendChild(new DOMElement('dFecEmNR', $this->dFecEmNR->format('Y-m-d')));
    if(isset($this->gComPub))
    {
      $importNode = $doc->importNode($this->gComPub->toDOMElement(), true);
      $res->appendChild($importNode);
    }
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
    $res = new GCamFE();
    if(isset($object->iIndPres))
    {
      $res->setIIndPres(intval($object->iIndPres));
    }
 
    if(isset($object->dFecEmNR))
    {
      $res->setDFecEmNR(DateTime::createFromFormat('Y-m-d', $object->dFecEmNR));
    }
    //Children
    if(isset($object->gComPub))
    {
      $res->setGComPub(GCompPub::FromSifenResponseObject($object->gComPub));
    }
    return $res;
  }
}
