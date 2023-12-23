<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Constants\CamFEIndPres;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     E010
 * Nombre:      gCamFE
 * Descripción: Campos que componen la factura electrónica (FE)
 * Nodo Padre:  E001 - gDtipDE - Campos específicos por tipo de Documento Electrónico 
 */

class GCamFE extends BaseSifenField
{
  public const INDICADOR_PRESENCIA_OPERACION_PRESENCIAL = 1;
  public const INDICADOR_PRESENCIA_OPERACION_ELECTRONICA = 2;
  public const INDICADOR_PRESENCIA_OPERACION_TELEMARKETING = 3;
  public const INDICADOR_PRESENCIA_VENTA_A_DOMICILIO = 4;
  public const INDICADOR_PRESENCIA_OPERACION_BANCARIA = 5;
  public const INDICADOR_PRESENCIA_OPERACION_CICLICA = 6;
  public const INDICADOR_PRESENCIA_OTRO = 9;

  public const INDICADOR_PRESENCIA_DESCRIPCIONES = [
    self::INDICADOR_PRESENCIA_OPERACION_PRESENCIAL => 'Operación presencial',
    self::INDICADOR_PRESENCIA_OPERACION_ELECTRONICA => 'Operación electrónica',
    self::INDICADOR_PRESENCIA_OPERACION_TELEMARKETING => 'Operación telemarketing',
    self::INDICADOR_PRESENCIA_VENTA_A_DOMICILIO => 'Venta a domicilio',
    self::INDICADOR_PRESENCIA_OPERACION_BANCARIA => 'Operación bancaria',
    self::INDICADOR_PRESENCIA_OPERACION_CICLICA => 'Operación cíclica',
    self::INDICADOR_PRESENCIA_OTRO => 'Otro',
  ];

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
   * Establece el valor de iIndPres (código indicador de presencia)
   *
   * @param int $iIndPres
   *
   * @return self
   */
  public function setIIndPres(int|CamFEIndPres $iIndPres): self
  {
    $this->iIndPres = $iIndPres instanceof CamFEIndPres ? $iIndPres->value : $iIndPres;
    $this->dDesIndPres = $iIndPres instanceof CamFEIndPres ? $iIndPres : CamFEIndPres::getDescripcion($iIndPres);
    return $this;
  }

  /**
   * Establece el valor de dDesIndPres
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
   * Establece el valor de dFecEmNR
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
   * Establece el valor de gComPub
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
   * Obtiene el valor de iIndPres
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
   * Obtiene el valor de dFecEmNR
   */
  public function getDFecEmNR(): DateTime
  {
    return $this->dFecEmNR;
  }

  

  ///////////////////////////////////////////////////////////////////////
  // XML Element
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
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamFE');
    $res->appendChild(new DOMElement('iIndPres', $this->iIndPres));
    $res->appendChild(new DOMElement('dDesIndPres', $this->getDDesIndPres()));
    if(isset($this->dFecEmNR))
      $res->appendChild(new DOMElement('dFecEmNR', $this->dFecEmNR->format('Y-m-d')));
    if(isset($this->gComPub))
      $res->appendChild($this->gComPub->toDOMElement($doc));
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

  /**
   * Instancia un objeto GCamFE a partir de un DOMElement que representa el nodo XML del objeto.
   * 
   * @param DOMElement $node
   * 
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamFE') != 0)
      throw new \Exception('[GCamFE] El nombre del nodo no corresponde a gCamFE: ' . $node->nodeName, 1);
    $res = new GCamFE();
    $res->iIndPres = intval($node->getElementsByTagName('iIndPres')->item(0)->nodeValue);
    $res->dDesIndPres = strval($node->getElementsByTagName('dDesIndPres')->item(0)->nodeValue);
    if($node->getElementsByTagName('dFecEmNR')->length > 0)
      $res->dFecEmNR = DateTime::createFromFormat('Y-m-d', strval($node->getElementsByTagName('dFecEmNR')->item(0)->nodeValue));
    if($node->getElementsByTagName('gComPub')->length > 0)
      $res->gComPub = GCompPub::FromDOMElement($node->getElementsByTagName('gComPub')->item(0));
    return $res;
  }

  /**
   * 
   */

  /**
   * Valida el contenido del objeto de conformidad a lo establecido en el MT
   * 
   * @throws \Exception Si el contenido del objeto no es válido emite una excepción con el mensaje de error.
   */
  public function validate(): void
  {
    $errMsg = "";
    if(!isset($this->iIndPres))
    {
      $errMsg .= "[GCamFE] El campo 'iIndPres' no ha sido informado.\n";
    }
    else if($this->iIndPres < 1 || $this->iIndPres > 9)
    {
      $errMsg .= "[GCamFE] El campo 'iIndPres' debe ser un valor entre 1 y 9.\n";
    }
    if(!isset($this->dDesIndPres))
    {
      $errMsg .= "[GCamFE] El campo 'dDesIndPres' no ha sido informado.\n";
    } 
    else if(strlen($this->dDesIndPres) < 10 || strlen($this->dDesIndPres) > 30)
    {
      $errMsg .= "[GCamFE] El campo 'dDesIndPres' debe tener una longitud entre 10 y 30 caracteres.\n";
    }
    if(isset($this->gComPub))
    {
      try {
        $this->gComPub->validate();
      }
      catch(\Exception $e)
      {
        $errMsg .= $e->getMessage();
      }
    }
    if(strlen($errMsg) > 0)
    {
      throw new \Exception($errMsg);
    }
  }
}

