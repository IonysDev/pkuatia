<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: D140 
 * Descripción: Grupo de campos que identifican al responsable de la generación del DE.
 * Nodo Padre: gEmis (D100) - Grupo de campos que identifican al emisor
 */

/**
 * GRespDE
 */
class GRespDE extends BaseSifenField
{
    
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
     * Establece el valor iTipIDRespDE que corresponde al tipo de documento de identidad del responsable de la generación del DE
     * 
     * @param int $iTipIDRespDE
     * 
     * @return self
     */
    public function setITipIDRespDE(int $iTipIDRespDE): self
    {
        $this->iTipIDRespDE = $iTipIDRespDE;
        switch($this->iTipIDRespDE) {
            case 1:
                $this->dDTipIDRespDE = 'Cédula paraguaya';
                break;
            case 2:
                $this->dDTipIDRespDE = 'Pasaporte';
                break;
            case 3:
                $this->dDTipIDRespDE = 'Cédula extranjera';
                break;
            case 4:
                $this->dDTipIDRespDE = 'Carnet de residencia';
                break;
            case 9:
                $this->dDTipIDRespDE = null;
                break;
            default:
                unset($this->iTipIDRespDE);
                throw new \Exception('[GRespDE] El valor de iTipIDRespDE no es válido: ' . $this->iTipIDRespDE);
        }
        return $this;
    }

    /**
     * Establece el valor dDTipIDRespDE que corresponde a la descripción del tipo de documento de identidad del responsable de la generación del DE.   
     * Se recomienda usar este método SOLO para <iTipIDRespDE> tipo de documento de identidad 9 (Otro).
     * 
     * @param String $dDTipIDRespDE
     * 
     * @return self
     */
    public function setDDTipIDRespDE(String $dDTipIDRespDE): self
    {
        $this->dDTipIDRespDE = $dDTipIDRespDE;
        return $this;
    }

    /**
     * Establece el valor dNumIDRespDE que corresponde al número de documento de identidad del responsable de la generación del DE
     * 
     * @param String $dNumIDRespDE
     * 
     * @return self
     */
    public function setDNumIDRespDE(String $dNumIDRespDE): self
    {
        $this->dNumIDRespDE = $dNumIDRespDE;
        return $this;
    }

    /**
     * Establece el valor dNomRespDE que corresponde al nombre o razón social del responsable de la generación del DE
     * 
     * @param String $dNomRespDE
     * 
     * @return self
     */
    public function setDNomRespDE(String $dNomRespDE): self
    {
        $this->dNomRespDE = $dNomRespDE;
        return $this;
    }

    /**
     * Establece el valor de dCarRespDE que corresponde al cargo del responsable de la generación del DE
     * 
     * @param String $dCarRespDE
     * 
     * @return self
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
     * Devuelve el valor iTipIDRespDE que corresponde al tipo de documento de identidad del responsable de la generación del DE.
     * 
     * @return int
     */
    public function getITipIDRespDE(): int
    {
        return $this->iTipIDRespDE;
    }

    /**
     * Devuelve la descripción del documento de identidad del responsable de la generación del DE
     * 
     * @return String
     */
    public function getDDTipIDRespDE(): String
    {
        return $this->dDTipIDRespDE;
    }

    /**
     * Devuelve el valor dNumIDRespDE que corresponde al número de documento de identidad del responsable de la generación del DE
     * 
     * @return String
     */
    public function getDNumIDRespDE(): String
    {
        return $this->dNumIDRespDE;
    }

    /**
     * Devuelve el valor dNomRespDE que corresponde al nombre o razón social del responsable de la generación del DE.
     * 
     * @return String
     */
    public function getDNomRespDE(): String
    {
        return $this->dNomRespDE;
    }

    /**
     * Devuelve el valor dCarRespDE que corresponde al cargo del responsable de la generación del DE.
     * 
     * @return String
     */
    public function getDCarRespDE(): String
    {
        return $this->dCarRespDE;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////
    
    /**
     * Instancia la clase a partir de un SimpleXMLElement
     * 
     * @param SimpleXMLElement $node
     * 
     * @return GRespDE
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): GRespDE
    {
        if(strcmp($node->getName(),'gRespDE') != 0)
        {
            throw new \Exception('El nombre del nodo no corresponde a "gRespDE"');
        }
        $res = new GRespDE();
        $res->setITipIDRespDE(intval($node->iTipIDRespDE));
        $res->setDNumIDRespDE((String) $node->dNumIDRespDE);
        $res->setDNomRespDE((String) $node->dNomRespDE);
        $res->setDCarRespDE((String) $node->dCarRespDE);
        return $res;
    }

    /**
     * Convierte este GRespDE en un DOMElement
     * 
     * @param DOMDocument $doc Documento DOM donde se creará el nodo SIN insertarse.
     *
     * @return DOMElement Nodo DOM creado pero no insertado.
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
    
    /**
     * FromSifenResponseObject
     *
     * @param  mixed $object
     * @return self
     */
    public static function FromSifenResponseObject($object): self
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

}
