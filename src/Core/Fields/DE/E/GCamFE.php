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
                                // Id - Longitud - Ocurrencia - Descripción
  public int      $iIndPres;    // E011 - 1     - 1-1 - Indicador de presencia
  public String   $dDesIndPres; // E012 - 10-30 - 1-1 - Descripción del indicador de presencia
  public DateTime $dFecEmNR;    // E013 - 10    - 0-1 - Fecha en el formato: AAAA-MM-DD Fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica cuando corresponda. RG 41/14
  public GCompPub $gComPub;     // E020 -       - 0-1 - Campos que describen las informaciones de compras públicas

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Set the value of iIndPres
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
      $this->dDesIndPres = null;
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
  public function getIIndPres(): int | null
  {
    return $this->iIndPres;
  }

  /**
   * E012 dDesIndPres Descripción del indicador de presencia
   *
   * @return string
   */
  public function getDDesIndPres(): String
  {
    return $this->dDesIndPres;
  }

  /**
   * Get the value of dFecEmNR
   */
  public function getDFecEmNR(): DateTime | null
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
    $res = new DOMElement('gCamFE');
    $res->appendChild(new DOMElement('iIndPres', $this->iIndPres));
    $res->appendChild(new DOMElement('dDesIndPres', $this->getDDesIndPres()));
    $res->appendChild(new DOMElement('dFecEmNR', $this->dFecEmNR->format('Y-m-d')));
    //children
    $res->appendChild($this->gComPub->toDOMElement());
    return $res;
  }
  
  /**
   * fromResponse
   *
   * @param  mixed $response
   * @return self
   */
  public static function fromResponse($response): self
  {
    $res = new GCamFE();
    if(isset($response->iIndPres))
    {
      $res->setIIndPres(intval($response->iIndPres));
    }
 
    if(isset($response->dFecEmNR))
    {
      $res->setDFecEmNR(DateTime::createFromFormat('Y-m-d', $response->dFecEmNR));
    }
    //Children
    if(isset($response->gComPub))
    {
      $res->setGComPub(GCompPub::fromResponse($response->gComPub));
    }
    return $res;
  }
}
