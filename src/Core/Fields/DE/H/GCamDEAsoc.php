<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\H;

use Abiliomp\Pkuatia\Core\Constants\TipDocAso;
use Abiliomp\Pkuatia\Core\Constants\TipoDocImpresoAso;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DateTime;
use DOMDocument;
use DOMElement;
use Exception;
use SimpleXMLElement;

/**
 * Nodo Id:     H001
 * Nombre:      gCamDEAsoc
 * Descripción: Campos que identifican al DE asociado
 * Nodo Padre:  A001 - Campos firmados del DE
 */

class GCamDEAsoc extends BaseSifenField
{
  public const TIPO_DE_DOCUMENTO_ASOCIADO_ELECTRONICO = 1;
  public const TIPO_DE_DOCUMENTO_ASOCIADO_IMPRESO = 2;
  public const TIPO_DE_DOCUMENTO_ASOCIADO_CONSTANCIA_ELECTRONICA = 3;

  public int      $iTipDocAso;    // H002 - 1     - 1-1 - Tipo de documento asociado
  public String   $dDesTipDocAso; // H003 - 7-11  - 1-1 - Descripción del tipo de documento asociado
  public String   $dCdCDERef;     // H004 - 44    - 0-1 - CDC del DTE referenciado
  public int      $dNTimDI;       // H005 - 8     - 0-1 - Nro. timbrado documento impreso de referencia
  public String   $dEstDocAso;    // H006 - 3     - 0-1 - Establecimiento
  public String   $dPExpDocAso;   // H007 - 3     - 0-1 - Punto de expedición
  public String   $dNumDocAso;    // H008 - 7     - 0-1 - Número del documento
  public int      $iTipoDocAso;   // H009 - 1     - 0-1 - Tipo de documento  impreso
  public String   $dDTipoDocAso;  // H010 - 7-16  - 0-1 - Descripción del tipo de documento impreso
  public DateTime $dFecEmiDI;     // H011 - 10    - 0-1 - Fecha de emisión del documento impreso de referencia AAAA-MM-DD
  public String   $dNumComRet;    // H012 - 15    - 0-1 - Número de comprobante de retención
  public String   $dNumResCF;     // H013 - 15    - 0-1 - Número de resolución de crédito fiscal
  public int      $iTipCons;      // H014 - 1     - 0-1 - Tipo de constancia
  public String   $dDesTipCons;   // H015 - 30-34 - 0-1 - Descripción del tipo de constancia
  public int      $dNumCons;      // H016 - 11    - 0-1 - Número de constancia 
  public String   $dNumControl;   // H017 - 8     - 0-1 - Número de control de la constancia 

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de iTipDocAso
   *
   * @param int $iTipDocAso
   *
   * @return self
   */
  public function setITipDocAso(int|TipDocAso $iTipDocAso): self
  {
    $this->iTipDocAso = $iTipDocAso instanceof TipDocAso ? $iTipDocAso->value : $iTipDocAso;
    $this->dDesTipDocAso = TipDocAso::getDescripcion($this->iTipDocAso);
    return $this;
  }

  /**
   * Establece el valor de dDesTipDocAso
   * 
   * @param String $dDesTipDocAso
   * 
   * @return self
   */
  public function setDDesTipDocAso(String $dDesTipDocAso): self
  {
    $this->dDesTipDocAso = $dDesTipDocAso;
    return $this;
  }


  /**
   * Establece el valor de dCdCDERef
   *
   * @param String $dCdCDERef
   *
   * @return self
   */
  public function setDCdCDERef(String $dCdCDERef): self
  {
    $this->dCdCDERef = $dCdCDERef;

    return $this;
  }


  /**
   * Establece el valor de dNTimDI
   *
   * @param int $dNTimDI
   *
   * @return self
   */
  public function setDNTimDI(int $dNTimDI): self
  {
    $this->dNTimDI = $dNTimDI;

    return $this;
  }


  /**
   * Establece el valor de dEstDocAso
   *
   * @param String $dEstDocAso
   *
   * @return self
   */
  public function setDEstDocAso(String $dEstDocAso): self
  {
    $this->dEstDocAso = $dEstDocAso;

    return $this;
  }


  /**
   * Establece el valor de dPExpDocAso
   *
   * @param String $dPExpDocAso
   *
   * @return self
   */
  public function setDPExpDocAso(String $dPExpDocAso): self
  {
    $this->dPExpDocAso = $dPExpDocAso;

    return $this;
  }


  /**
   * Establece el valor de dNumDocAso
   *
   * @param String $dNumDocAso
   *
   * @return self
   */
  public function setDNumDocAso(String $dNumDocAso): self
  {
    $this->dNumDocAso = $dNumDocAso;

    return $this;
  }


  /**
   * Establece el valor de iTipoDocAso
   *
   * @param int $iTipoDocAso
   *
   * @return self
   */
  public function setITipoDocAso(int|TipoDocImpresoAso $iTipoDocAso): self
  {
    $this->iTipoDocAso = $iTipoDocAso instanceof TipoDocImpresoAso ? $iTipoDocAso->value : $iTipoDocAso;
    $this->dDTipoDocAso = TipoDocImpresoAso::getDescripcion($this->iTipoDocAso);
    return $this;
  }

  /**
   * Establece el valor de dDTipoDocAso
   * 
   * @param String $dDTipoDocAso
   * 
   * @return self
   */
  public function setDDTipoDocAso(String $dDTipoDocAso): self
  {
    if(is_null($dDTipoDocAso) || strlen($dDTipoDocAso) == 0)
    {
      $this->dDesTipDocAso;
    }
    else
    {
      $this->dDesTipDocAso = substr($dDTipoDocAso, 0, 16);
    }
    return $this;
  }


  /**
   * Establece el valor de dFecEmiDI
   *
   * @param DateTime $dFecEmiDI
   *
   * @return self
   */
  public function setDFecEmiDI(DateTime $dFecEmiDI): self
  {
    $this->dFecEmiDI = $dFecEmiDI;

    return $this;
  }


  /**
   * Establece el valor de dNumComRet
   *
   * @param String $dNumComRet
   *
   * @return self
   */
  public function setDNumComRet(String $dNumComRet): self
  {
    $this->dNumComRet = $dNumComRet;

    return $this;
  }


  /**
   * Establece el valor de dNumResCF
   *
   * @param String $dNumResCF
   *
   * @return self
   */
  public function setDNumResCF(String $dNumResCF): self
  {
    $this->dNumResCF = $dNumResCF;

    return $this;
  }

  /**
   * Establece el valor de iTipCons
   *
   * @param int $iTipCons
   *
   * @return self
   */
  public function setITipCons(int $iTipCons): self
  {
    $this->iTipCons = $iTipCons;
    switch ($this->iTipCons) {
      case 1:
        $this->setDDesTipCons("Constancia de no ser contribuyente");
        break;
      case 2:
        $this->setDDesTipCons("Constancia de microproductores");
        break;
      default:
        throw new \Exception("Invalid iTipCons: $iTipCons");
        break;
    }
    return $this;
  }

  /**
   * Establece el valor de dDesTipCons
   * 
   * @param String $dDesTipCons
   * 
   * @return self
   */
  public function setDDesTipCons(String $dDesTipCons): self
  {
    if(is_null($dDesTipCons) || strlen($dDesTipCons) == 0)
    {
      $this->dDesTipCons;
    }
    else
    {
      $this->dDesTipCons = substr($dDesTipCons, 0, 34);
    }
    return $this;
  }


  /**
   * Establece el valor de dNumCons
   *
   * @param int $dNumCons
   *
   * @return self
   */
  public function setDNumCons(int $dNumCons): self
  {
    $this->dNumCons = $dNumCons;

    return $this;
  }


  /**
   * Establece el valor de dNumControl
   *
   * @param String $dNumControl
   *
   * @return self
   */
  public function setDNumControl(String $dNumControl): self
  {
    $this->dNumControl = $dNumControl;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de iTipDocAso
   *
   * @return int
   */
  public function getITipDocAso(): int
  {
    return $this->iTipDocAso;
  }

  /**
   * Obtiene el valor de dDesTipDocAso
   *
   * @return String
   */
  public function getDDesTipDocAso(): String
  {
    return $this->dDesTipDocAso;
  }

  /**
   * Obtiene el valor de dCdCDERef
   *
   * @return String
   */
  public function getDCdCDERef(): String
  {
    return $this->dCdCDERef;
  }

  /**
   * Obtiene el valor de dNTimDI
   *
   * @return int
   */
  public function getDNTimDI(): int
  {
    return $this->dNTimDI;
  }  

  /**
   * Obtiene el valor de dEstDocAso
   *
   * @return String
   */
  public function getDEstDocAso(): String
  {
    return $this->dEstDocAso;
  }

  /**
   * Obtiene el valor de dPExpDocAso
   *
   * @return String
   */
  public function getDPExpDocAso(): String
  {
    return $this->dPExpDocAso;
  }

  /**
   * Obtiene el valor de dNumDocAso
   *
   * @return String
   */
  public function getDNumDocAso(): String
  {
    return $this->dNumDocAso;
  }

  /**
   * Obtiene el valor de iTipoDocAso
   *
   * @return int
   */
  public function getITipoDocAso(): int
  {
    return $this->iTipoDocAso;
  }

  /**
   * Obtiene el valor de dDTipoDocAso
   * 
   * @return String
   */
  public function getDDTipoDocAso(): String
  {
    return $this->dDTipoDocAso;
  }

  /**
   * Obtiene el valor de dFecEmiDI
   *
   * @return DateTime
   */
  public function getDFecEmiDI(): DateTime
  {
    return $this->dFecEmiDI;
  }

  /**
   * Obtiene el valor de dNumComRet
   *
   * @return String
   */
  public function getDNumComRet(): String
  {
    return $this->dNumComRet;
  }

  /**
   * Obtiene el valor de dNumResCF
   *
   * @return String
   */
  public function getDNumResCF(): String
  {
    return $this->dNumResCF;
  }

  /**
   * Obtiene el valor de iTipCons
   *
   * @return int
   */
  public function getITipCons(): int
  {
    return $this->iTipCons;
  }

  /**
   * Obtiene el valor de dDesTipCons
   *
   * @return String
   */
  public function getDDesTipCons(): String
  {
    return $this->dDesTipCons;
  }

  /**
   * Obtiene el valor de dNumCons
   *
   * @return int
   */
  public function getDNumCons(): int
  {
    return $this->dNumCons;
  }

  /**
   * Obtiene el valor de dNumControl
   *
   * @return String
   */
  public function getDNumControl(): String
  {
    return $this->dNumControl;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Instancia un objeto GCamDEAsoc a partir de un DOMElement que representa al objeto.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto GCamFuFD
   * 
   * @return GCamDEAsoc Objeto GCamDEAsoc instanciado
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamDEAsoc') != 0)
        throw new Exception('[GCamDEAsoc] Nodo con nombre inválido: ' . $node->nodeName);
    $res = new self();
    $res->setITipDocAso(intval(trim($node->getElementsByTagName('iTipDocAso')->item(0)->nodeValue)));
    $res->setDDesTipDocAso(trim($node->getElementsByTagName('dDesTipDocAso')->item(0)->nodeValue));
    if($node->getElementsByTagName('dCdCDERef')->length > 0)
      $res->setDCdCDERef(trim($node->getElementsByTagName('dCdCDERef')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNTimDI')->length > 0)
      $res->setDNTimDI(intval(trim($node->getElementsByTagName('dNTimDI')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dEstDocAso')->length > 0)
      $res->setDEstDocAso(trim($node->getElementsByTagName('dEstDocAso')->item(0)->nodeValue));
    if($node->getElementsByTagName('dPExpDocAso')->length > 0)
      $res->setDPExpDocAso(trim($node->getElementsByTagName('dPExpDocAso')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNumDocAso')->length > 0)
      $res->setDNumDocAso(trim($node->getElementsByTagName('dNumDocAso')->item(0)->nodeValue));
    if($node->getElementsByTagName('iTipoDocAso')->length > 0)
      $res->setITipoDocAso(trim($node->getElementsByTagName('iTipoDocAso')->item(0)->nodeValue));
    if($node->getElementsByTagName('dDTipoDocAso')->length > 0)
      $res->setDDTipoDocAso(trim($node->getElementsByTagName('dDTipoDocAso')->item(0)->nodeValue));
    if($node->getElementsByTagName('dFecEmiDI')->length > 0)
      $res->setDFecEmiDI(DateTime::createFromFormat('Y-m-d', trim($node->getElementsByTagName('dFecEmiDI')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dNumComRet')->length > 0)
      $res->setDNumComRet(trim($node->getElementsByTagName('dNumComRet')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNumResCF')->length > 0)
      $res->setDNumResCF(trim($node->getElementsByTagName('dNumResCF')->item(0)->nodeValue));
    if($node->getElementsByTagName('iTipCons')->length > 0)
      $res->setITipCons(intval(trim($node->getElementsByTagName('iTipCons')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dDesTipCons')->length > 0)
      $res->setDDesTipCons(trim($node->getElementsByTagName('dDesTipCons')->item(0)->nodeValue));
    if($node->getElementsByTagName('dNumCons')->length > 0)
      $res->setDNumCons(intval(trim($node->getElementsByTagName('dNumCons')->item(0)->nodeValue)));
    if($node->getElementsByTagName('dNumControl')->length > 0)
      $res->setDNumControl(trim($node->getElementsByTagName('dNumControl')->item(0)->nodeValue));
    return $res;
  }

  /**
   * Instancia un objeto GCamDEAsoc a partir de un SimpleXMLElement
   * 
   * @param SimpleXMLElement $nodo
   * 
   * @return GCamDEAsoc
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $nodo): GCamDEAsoc
  {
    if(strcmp($nodo->getName(), 'gCamDEAsoc') != 0)
    {
      throw new \Exception("El nombre del nodo no es gCamDEAsoc");
    }
    $res = new GCamDEAsoc();
    $res->setITipDocAso(intval($nodo->iTipDocAso));
    $res->setDDesTipDocAso(strval($nodo->dDesTipDocAso));
    if(isset($nodo->dCdCDERef))
    {
      $res->setDCdCDERef(strval($nodo->dCdCDERef));
    }
    if(isset($nodo->dNTimDI))
    {
      $res->setDNTimDI(intval($nodo->dNTimDI));
    }
    if(isset($nodo->dEstDocAso))
    {
      $res->setDEstDocAso(strval($nodo->dEstDocAso));
    }
    if(isset($nodo->dPExpDocAso))
    {
      $res->setDPExpDocAso(strval($nodo->dPExpDocAso));
    }
    if(isset($nodo->dNumDocAso))
    {
      $res->setDNumDocAso(strval($nodo->dNumDocAso));
    }
    if(isset($nodo->iTipoDocAso))
    {
      $res->setITipoDocAso(intval($nodo->iTipoDocAso));
    }
    if(isset($nodo->dDTipoDocAso))
    {
      $res->setDDTipoDocAso(strval($nodo->dDTipoDocAso));
    }
    if(isset($nodo->dFecEmiDI))
    {
      $res->setDFecEmiDI(DateTime::createFromFormat('Y-m-d', strval($nodo->dFecEmiDI)));
    }
    if(isset($nodo->dNumComRet))
    {
      $res->setDNumComRet(strval($nodo->dNumComRet));
    }
    if(isset($nodo->dNumResCF))
    {
      $res->setDNumResCF(strval($nodo->dNumResCF));
    }
    if(isset($nodo->iTipCons))
    {
      $res->setITipCons(intval($nodo->iTipCons));
    }
    if(isset($nodo->dDesTipCons))
    {
      $res->setDDesTipCons(strval($nodo->dDesTipCons));
    }
    if(isset($nodo->dNumCons))
    {
      $res->setDNumCons(intval($nodo->dNumCons));
    }
    if(isset($nodo->dNumControl))
    {
      $res->setDNumControl(strval($nodo->dNumControl));
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
    $res = new GCamDEAsoc();
    if(isset($object->iTipDocAso))
    {
      $res->setITipDocAso(intval($object->iTipDocAso));
    }
    if(isset($object->dCdCDERef))
    {
      $res->setDCdCDERef($object->dCdCDERef);
    }
    if(isset($object->dNTimDI))
    {
      $res->setDNTimDI(intval($object->dNTimDI));
    }
    if(isset($object->dEstDocAso))
    {
      $res->setDEstDocAso($object->dEstDocAso);
    }
    if(isset($object->dPExpDocAso))
    {
      $res->setDPExpDocAso($object->dPExpDocAso);
    }
    if(isset($object->dNumDocAso))
    {
      $res->setDNumDocAso(intval($object->dNumDocAso));
    }
    if(isset($object->iTipDocAso))
    {
      $res->setITipDocAso(intval($object->iTipDocAso));
    }
    if(isset($object->dFecEmiDI))
    {
      $res->setDFecEmiDI(DateTime::createFromFormat('Y-m-d', $object->dFecEmiDI));
    }
    if(isset($object->dNumComRet))
    {
      $res->setDNumComRet($object->dNumComRet);
    }
    if(isset($object->dNumResCF))
    {
      $res->setDNumResCF($object->dNumResCF);
    }
    if(isset($object->iTipCons))
    {
      $res->setITipCons(intval($object->iTipCons));
    }
    if(isset($object->dNumCons))
    {
      $res->setDNumCons(intval($object->dNumCons));
    }
    if(isset($object->dNumControl))
    {
      $res->setDNumControl($object->dNumControl);
    }
    
    return $res;
  }

  ///////////////////////////////////////////////////////////////////////
  // Conversores
  ///////////////////////////////////////////////////////////////////////

  /**
   * Convierte el objeto GCamDEAsoc a un DOMElement
   * 
   * @param DOMDocument $doc Documento DOM donde se creará el nodo, pero NO se insertará.
   *
   * @return DOMElement Nodo DOM creado NO insertado en el documento.
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gCamDEAsoc');

    $res->appendChild(new DOMElement('iTipDocAso', $this->getITipDocAso()));
    $res->appendChild(new DOMElement('dDesTipDocAso', $this->getDDesTipDocAso()));

    if ($this->iTipDocAso == 1) {
      $res->appendChild(new DOMElement('dCdCDERef', $this->getDCdCDERef()));
    }
    else if ($this->iTipDocAso == 2) {
      $res->appendChild(new DOMElement('dNTimDI', $this->getDNTimDI()));
      $res->appendChild(new DOMElement('dEstDocAso', str_pad($this->dEstDocAso, 3, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('dPExpDocAso', str_pad($this->dPExpDocAso, 3, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('dNumDocAso', str_pad($this->dNumDocAso, 7, '0', STR_PAD_LEFT)));
      $res->appendChild(new DOMElement('iTipoDocAso', $this->getITipDocAso()));
      $res->appendChild(new DOMElement('dDTipoDocAso', $this->getDDTipoDocAso()));
    }

    if (isset($this->dNTimDI)) {
      $res->appendChild(new DOMElement('dFecEmiDI', $this->getDFecEmiDI()->format('Y-m-d')));
    }

    if(isset($this->dNumComRet))
      $res->appendChild(new DOMElement('dNumComRet', $this->getDNumComRet()));
    
    if(isset($this->dNumResCF))
      $res->appendChild(new DOMElement('dNumResCF', $this->getDNumResCF()));

    if($this->iTipDocAso == 3) {
      $res->appendChild(new DOMElement('iTipCons', $this->getITipCons()));
      $res->appendChild(new DOMElement('dDesTipCons', $this->getDDesTipCons()));
    }

    if ($this->iTipDocAso == 3 && $this->iTipCons == 2) {
      $res->appendChild(new DOMElement('dNumCons', $this->getDNumCons()));
      $res->appendChild(new DOMElement('dNumControl', $this->getDNumControl()));
    }

    return $res;
  }
}
