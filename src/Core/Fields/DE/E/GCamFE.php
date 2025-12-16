<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
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
                                // Id - Longitud - Ocurrencia - Descripción
  public int      $iIndPres;    // E011 - 1     - 1-1 - Indicador de presencia
  public String   $dDesIndPres; // E012 - 10-30 - 1-1 - Descripción del indicador de presencia
  public DateTime $dFecEmNR;    // E013 - 10    - 0-1 - Fecha en el formato: AAAA-MM-DD Fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica cuando corresponda. RG 41/14
  public GCompPub $gCompPub;    // E020 -       - 0-1 - Campos que describen las informaciones de compras públicas

  /**
   * Constructor
   * Establece los valores por defecto:
   *    > iIndPres = 1
   *    > dDesIndPres = "Operación presencial"
   */
  public function __construct()
  {
    $this->iIndPres = CamFEIndPres::Presencial->value;
    $this->dDesIndPres = CamFEIndPres::getDescripcion(CamFEIndPres::Presencial->value);
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iIndPres (E011) que corresponde al indicador de presencia.
   *
   * @param int $iIndPres Código del indicador de presencia.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setIIndPres(int|CamFEIndPres $iIndPres): self
  {
    $this->iIndPres = $iIndPres instanceof CamFEIndPres ? $iIndPres->value : $iIndPres;
    $this->dDesIndPres = $iIndPres instanceof CamFEIndPres ? $iIndPres : CamFEIndPres::getDescripcion($iIndPres);
    return $this;
  }

  /**
   * Establece el valor de dDesIndPres (E012) que es la descripción del indicador de presencia.
   * No debería utilizarse este método directamente, ya que la descripción del indicador de presencia se establece automáticamente al establecer el código del indicador de presencia.
   * Solo utilizarlo al deserializar un DE.
   *
   * @param String $dDesIndPres Descripción del indicador de presencia.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
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
   * Establece el valor de dFecEmNR (E012) que es fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica, cuando corresponda.
   * 
   * @param DateTime $dFecEmNR Fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setDFecEmNR(DateTime $dFecEmNR): self
  {
    $this->dFecEmNR = $dFecEmNR;
    return $this;
  }


  /**
   * Establece el valor de gCompPub (E020) que corresponde a los campos que describen las informaciones de compras públicas.
   * Obligatorio cuando la operación es B2G (D202 = 3).
   *
   * @param GCompPub $gCompPub Campos que describen las informaciones de compras públicas.
   *
   * @return self Retorna a sí mismo para permitir el encadenamiento de métodos.
   */
  public function setgCompPub(GCompPub $gCompPub): self
  {
    $this->gCompPub = $gCompPub;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iIndPres (E011) que corresponde al indicador de presencia.
   * 
   * @return int Código del indicador de presencia.
   */
  public function getIIndPres(): int
  {
    return $this->iIndPres;
  }

  /**
   * Obtiene el valor de dDesIndPres (E012) que corresponde a la descripción del indicador de presencia.
   *
   * @return String Descripción del indicador de presencia.
   */
  public function getDDesIndPres(): String
  {
    return $this->dDesIndPres;
  }

  /**
   * Obtiene el valor de dFecEmNR (E013) que corresponde a la fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica, cuando corresponda.
   * 
   * @return DateTime Fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica.
   */
  public function getDFecEmNR(): DateTime
  {
    return $this->dFecEmNR;
  }

  /**
   * Obtiene el valor de gCompPub (E020) que corresponde a los campos que describen las informaciones de compras públicas.
   * 
   * @return GCompPub|null Campos que describen las informaciones de compras públicas.
   */
  public function getgCompPub(): ?GCompPub
  {
    if(isset($this->gCompPub))
      return $this->gCompPub;
    else
      return null;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto del tipo GCamFE a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $node Nodo XML que representa el objeto.
   * 
   * @return self Objeto GCamFE instanciado.
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
    if(isset($node->gCompPub))
    {
      $res->gCompPub = GCompPub::FromSimpleXMLElement($node->gCompPub);
    }
    return $res;
  }

  /**
   * Instancia un objeto del tipo GCamFE a partir de un objeto stdClass que es la respuesta de la API de Sifen que contiene un gCamFE.
   * 
   * @param  mixed $object Objeto stdClass que contiene un gCamFE.
   * 
   * @return self Objeto GCamFE instanciado.
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
    if(isset($object->gCompPub))
    {
      $res->setgCompPub(GCompPub::FromSifenResponseObject($object->gCompPub));
    }
    return $res;
  }

  /**
   * Instancia un objeto GCamFE a partir de un DOMElement que representa el nodo XML del objeto.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto.
   * 
   * @return self Objeto GCamFE instanciado.
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
    if($node->getElementsByTagName('gCompPub')->length > 0)
      $res->gCompPub = GCompPub::FromDOMElement($node->getElementsByTagName('gCompPub')->item(0));
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte el objeto GCamFE a un DOMElement.
   * 
   * @param DOMDocument $doc Documento XML en el que se creará el DOMElement.
   *
   * @return DOMElement Objeto DOMElement que representa el objeto GCamFE.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamFE');
    $res->appendChild(new DOMElement('iIndPres', $this->iIndPres));
    $res->appendChild(new DOMElement('dDesIndPres', $this->getDDesIndPres()));
    if(isset($this->dFecEmNR))
      $res->appendChild(new DOMElement('dFecEmNR', $this->dFecEmNR->format('Y-m-d')));
    if(isset($this->gCompPub))
      $res->appendChild($this->gCompPub->toDOMElement($doc));
    return $res;
  }
  
  ///////////////////////////////////////////////////////////////////////
  // Validadores
  ///////////////////////////////////////////////////////////////////////

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
    if(isset($this->gCompPub))
    {
      try {
        $this->gCompPub->validate();
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

