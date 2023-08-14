<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

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
class GRespDE {
    
    public int    $iTipIDRespDE; // D141 - Tipo de documento de identidad del responsable de la generación del DE
    public String $dNumIDRespDE; // D143 - Número de documento de identidad del responsable de la generación del DE
    public String $dNomRespDE;   // D144 - Nombre o razón social del responsable de la generación del DE
    public String $dCarRespDE;   // D145 - Cargo del responsable de la generación del DE 

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
        return $this;
    }

    /**
     * Establece el valor dNumIDRespDE que corresponde al número de documento de identidad del responsable de la generación del DE
     * 
     * @param string $dNumIDRespDE
     * 
     * @return self
     */
    public function setDNumIDRespDE(string $dNumIDRespDE): self
    {
        $this->dNumIDRespDE = $dNumIDRespDE;
        return $this;
    }

    /**
     * Establece el valor dNomRespDE que corresponde al nombre o razón social del responsable de la generación del DE
     * 
     * @param string $dNomRespDE
     * 
     * @return self
     */
    public function setDNomRespDE(string $dNomRespDE): self
    {
        $this->dNomRespDE = $dNomRespDE;
        return $this;
    }

    /**
     * Establece el valor de dCarRespDE que corresponde al cargo del responsable de la generación del DE
     * 
     * @param string $dCarRespDE
     * 
     * @return self
     */
    public function setDCarRespDE(string $dCarRespDE): self
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
     * @return string
     */
    public function getDDTipIDRespDE(): string
    {
        switch($this->iTipIDRespDE) {
            case 1:
                return 'Cédula paraguaya';
                break;
            case 2:
                return 'Pasaporte';
                break;
            case 3:
                return 'Cédula extranjera';
                break;
            case 4:
                return 'Carnet de residencia';
                break;
            case 9:
                return 'Otro';
                break;
            default:
                return "null";
        }
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
     * toDOMElement
     *
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gRespDE');
        $res->appendChild(new DOMElement('iTipIDRespDE', $this->iTipIDRespDE));
        $res->appendChild(new DOMElement('dDTipIDRespDE', $this->getDDTipIDRespDE()));
        $res->appendChild(new DOMElement('dNumIDRespDE', $this->dNumIDRespDE));
        $res->appendChild(new DOMElement('dNomRespDE', $this->dNomRespDE));
        $res->appendChild(new DOMElement('dCarRespDE', $this->dCarRespDE));
        return $res;
    }
    
    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return GRespDE
    //  */
    // public static function fromDOMElement(DOMElement $xml): GRespDE
    // {
    //     if(strcmp($xml->tagName,'gRespDE') == 0 && $xml->childElementCount ==5)
    //     {
    //         $res = new GRespDE();
    //         $res->setITipIDRespDE(intval($xml->getElementsByTagName('iTipIDRespDE')->item(0)->nodeValue));
    //         $res->setDNumIDRespDE($xml->getElementsByTagName('dNumIDRespDE')->item(0)->nodeValue);
    //         $res->setDNomRespDE($xml->getElementsByTagName('dNomRespDE')->item(0)->nodeValue);
    //         $res->setDCarRespDE($xml->getElementsByTagName('dCarRespDE')->item(0)->nodeValue);

    //         return $res;
    //     }
    //     else {
    //         throw new \Exception("Invalid XML Element: $xml->tagName");
    //         return null;
    //       }
    // }
    
    /**
     * fromResponse
     *
     * @param  mixed $response
     * @return self
     */
    public static function fromResponse($response): self
    {
        $res = new GRespDE();
        if(isset($response->iTipIDRespDE))
        {
            $res->setITipIDRespDE(intval($response->iTipIDRespDE));
        }
        if(isset($response->dNumIDRespDE))
        {
            $res->setDNumIDRespDE($response->dNumIDRespDE);
        }
        if(isset($response->dNomRespDE))
        {
            $res->setDNomRespDE($response->dNomRespDE);
        }
        if(isset($response->dCarRespDE))
        {
            $res->setDCarRespDE($response->dCarRespDE);
        }
        

        return $res;
    }

}
