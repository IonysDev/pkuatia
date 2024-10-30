<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Core\Constants\TipIDRespDE;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;
use stdClass;

/**
 * Nodo Id:     D140
 * Nombre:      gRespDE
 * Descripción: Grupo de campos que identifican al responsable de la generación del DE.
 * Nodo Padre:  D100 - gEmis - Grupo de campos que identifican al emisor 
 */
class GRespDE extends BaseSifenField
{
    // Tipos de documento de identidad del responsable de la generación del DE
    public const TIPO_DOCUMENTO_IDENTIDAD_CEDULA_PARAGUAYA    = 1;
    public const TIPO_DOCUMENTO_IDENTIDAD_PASAPORTE           = 2;
    public const TIPO_DOCUMENTO_IDENTIDAD_CEDULA_EXTRANJERA   = 3;
    public const TIPO_DOCUMENTO_IDENTIDAD_CARNET_RESIDENCIA   = 4;
    public const TIPO_DOCUMENTO_IDENTIDAD_OTRO                = 9;

                                  // Id - Longitud - Ocurrencia - Descripción
    public int    $iTipIDRespDE;  // D141 - 1     - 1-1 - Tipo de documento de identidad del responsable de la generación del DE
    public String $dDTipIDRespDE; // D142 - 9-41  - 1-1 - Descripción del tipo de documento de identidad del responsable de la generación del DE
    public String $dNumIDRespDE;  // D143 - 1-20  - 1-1 - Número de documento de identidad del responsable de la generación del DE
    public String $dNomRespDE;    // D144 - 4-255 - 1-1 - Nombre o razón social del responsable de la generación del DE
    public String $dCarRespDE;    // D145 - 4-100 - 1-1 - Cargo del responsable de la generación del DE 

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor iTipIDRespDE (D141) que corresponde al tipo de documento de identidad del responsable de la generación del DE.
     * 
     * @param int|TipIDRespDE $iTipIDRespDE Tipo de documento de identidad del responsable de la generación del DE.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setITipIDRespDE(int|TipIDRespDE $iTipIDRespDE): self
    {
        $this->iTipIDRespDE = $iTipIDRespDE instanceof TipIDRespDE ? $iTipIDRespDE->value : $iTipIDRespDE;
        $this->dDTipIDRespDE = $iTipIDRespDE instanceof TipIDRespDE ? $iTipIDRespDE : TipIDRespDE::getDescripcion($iTipIDRespDE);
        return $this;
    }

    /**
     * Establece el valor dDTipIDRespDE (D142) que corresponde a la descripción del tipo de documento de identidad del responsable de la generación del DE.   
     * Este valor es calculado automáticamente al establecer el valor de iTipIDRespDE (D141).
     * Se recomienda usar este método SOLO para <iTipIDRespDE> tipo de documento de identidad 9 (Otro).
     * 
     * @param String $dDTipIDRespDE Descripción del tipo de documento de identidad del responsable de la generación del DE.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDDTipIDRespDE(String $dDTipIDRespDE): self
    {
        $this->dDTipIDRespDE = $dDTipIDRespDE;
        return $this;
    }

    /**
     * Establece el valor dNumIDRespDE (D143) que corresponde al número de documento de identidad del responsable de la generación del DE
     * 
     * @param String $dNumIDRespDE Número de documento de identidad del responsable de la generación del DE
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDNumIDRespDE(String $dNumIDRespDE): self
    {
        $this->dNumIDRespDE = $dNumIDRespDE;
        return $this;
    }

    /**
     * Establece el valor dNomRespDE (D144) que corresponde al nombre o razón social del responsable de la generación del DE
     * 
     * @param String $dNomRespDE Nombre o razón social del responsable de la generación del DE
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDNomRespDE(String $dNomRespDE): self
    {
        $this->dNomRespDE = $dNomRespDE;
        return $this;
    }

    /**
     * Establece el valor de dCarRespDE (D145) que corresponde al cargo del responsable de la generación del DE
     * 
     * @param String $dCarRespDE Cargo del responsable de la generación del DE
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDCarRespDE(String $dCarRespDE): self
    {
        $this->dCarRespDE = $dCarRespDE;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve el valor iTipIDRespDE (D141) que corresponde al tipo de documento de identidad del responsable de la generación del DE.
     * 
     * @return int Tipo de documento de identidad del responsable de la generación del DE.
     */
    public function getITipIDRespDE(): int
    {
        return $this->iTipIDRespDE;
    }

    /**
     * Devuelve el valor de dDTipIDRespDE (D142) la descripción del documento de identidad del responsable de la generación del DE.
     * 
     * @return String Descripción del tipo de documento de identidad del responsable de la generación del DE.
     */
    public function getDDTipIDRespDE(): String
    {
        return $this->dDTipIDRespDE;
    }

    /**
     * Devuelve el valor dNumIDRespDE (D143) que corresponde al número de documento de identidad del responsable de la generación del DE.
     * 
     * @return String Número de documento de identidad del responsable de la generación del DE.
     */
    public function getDNumIDRespDE(): String
    {
        return $this->dNumIDRespDE;
    }

    /**
     * Devuelve el valor dNomRespDE (D144) que corresponde al nombre o razón social del responsable de la generación del DE.
     * 
     * @return String Nombre o razón social del responsable de la generación del DE.
     */
    public function getDNomRespDE(): String
    {
        return $this->dNomRespDE;
    }

    /**
     * Devuelve el valor dCarRespDE (D145) que corresponde al cargo del responsable de la generación del DE.
     * 
     * @return String Cargo del responsable de la generación del DE.
     */ 
    public function getDCarRespDE(): String
    {
        return $this->dCarRespDE;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////
    
    /**
     * Instancia la clase a partir de un SimpleXMLElement.
     * 
     * @param SimpleXMLElement $node Nodo XML que contiene los datos.
     * 
     * @return self Objeto instanciado.
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        if(strcmp($node->getName(),'gRespDE') != 0)
        {
            throw new \Exception('El nombre del nodo no corresponde a "gRespDE"');
        }
        $res = new self();
        $res->setITipIDRespDE(intval($node->iTipIDRespDE));
        $res->setDNumIDRespDE((String) $node->dNumIDRespDE);
        $res->setDNomRespDE((String) $node->dNomRespDE);
        $res->setDCarRespDE((String) $node->dCarRespDE);
        return $res;
    }

    /**
     * Instancia un GRespDE a partir de un stdClass que contiene los datos de respuesa SOAP del SIFEN.
     *
     * @param stdClass $object Objeto respuesta del SIFEN.
     * 
     * @return self Objeto instanciado.
     */
    public static function FromSifenResponseObject(stdClass $object): self
    {
        $res = new GRespDE();
        if(isset($object->iTipIDRespDE))
            $res->setITipIDRespDE(intval($object->iTipIDRespDE));
        if(isset($object->dNumIDRespDE))
            $res->setDNumIDRespDE($object->dNumIDRespDE);
        if(isset($object->dNomRespDE))
            $res->setDNomRespDE($object->dNomRespDE);
        if(isset($object->dCarRespDE))
            $res->setDCarRespDE($object->dCarRespDE);
        return $res;
    }

    /**
     * Instancia un GRespDE a partir de un DOMElement que lo representa.
     * 
     * @param DOMElement $node Nodo DOM que contiene los datos.
     * 
     * @return self Objeto instanciado.
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if(strcmp($node->nodeName, 'gRespDE') != 0)
            throw new \Exception('[GRespDE] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new GRespDE();
        $res->setITipIDRespDE(intval($node->getElementsByTagName('iTipIDRespDE')->item(0)->nodeValue));
        $res->setDDTipIDRespDE(strval($node->getElementsByTagName('dDTipIDRespDE')->item(0)->nodeValue));
        $res->setDNumIDRespDE(strval($node->getElementsByTagName('dNumIDRespDE')->item(0)->nodeValue));
        $res->setDNomRespDE(strval($node->getElementsByTagName('dNomRespDE')->item(0)->nodeValue));
        $res->setDCarRespDE(strval($node->getElementsByTagName('dCarRespDE')->item(0)->nodeValue));
        return $res;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte este GRespDE en un DOMElement generado en el DOMDocument especificado.
     * 
     * @param DOMDocument $doc DOMDocument que generará el DOMElement.
     *
     * @return DOMElement DOMElement creado pero no insertado.
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('gRespDE');
        $res->appendChild(new DOMElement('iTipIDRespDE', $this->iTipIDRespDE));
        $res->appendChild(new DOMElement('dDTipIDRespDE', $this->getDDTipIDRespDE()));
        $res->appendChild(new DOMElement('dNumIDRespDE', substr($this->dNumIDRespDE, 0, 20)));
        $res->appendChild(new DOMElement('dNomRespDE', substr($this->dNomRespDE, 0, 255)));
        $res->appendChild(new DOMElement('dCarRespDE', substr($this->dCarRespDE, 0, 100)));
        return $res;
    }
}
