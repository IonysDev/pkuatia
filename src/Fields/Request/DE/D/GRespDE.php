<?php

namespace Abiliomp\Pkuatia\Fields\D;

use DOMElement;

/**
 * ID: D140 Grupo de campos que identifican al responsable de la generación del DE PADRE:D100 
 */

class GRespDE {
    
    public int $iTipIDRespDE;    // D141 - Tipo de documento de identidad del responsable de la generación del DE
    public string $dNumIDRespDE; // D143 - Número de documento de identidad del responsable de la generación del DE
    public string $dNomRespDE;   // D144 - Nombre o razón social del responsable de la generación del DE
    public string $dCarRespDE;   // D145 - Cargo del responsable de la generación del DE 

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setITipIDRespDE(int $iTipIDRespDE): void
    {
        $this->iTipIDRespDE = $iTipIDRespDE;
    }

    public function setDNumIDRespDE(string $dNumIDRespDE): void
    {
        $this->dNumIDRespDE = $dNumIDRespDE;
    }

    public function setDNomRespDE(string $dNomRespDE): void
    {
        $this->dNomRespDE = $dNomRespDE;
    }

    public function setDCarRespDE(string $dCarRespDE): void
    {
        $this->dCarRespDE = $dCarRespDE;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

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

    public function getDNumIDRespDE(): string
    {
        return $this->dNumIDRespDE;
    }

    public function getDNomRespDE(): string
    {
        return $this->dNomRespDE;
    }

    public function getDCarRespDE(): string
    {
        return $this->dCarRespDE;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////
    
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
    
    /**
     * fromDOMElement
     *
     * @param  mixed $xml
     * @return GRespDE
     */
    public static function fromDOMElement(DOMElement $xml): GRespDE
    {
        if(strcmp($xml->tagName,'gRespDE') == 0 && $xml->childElementCount ==5)
        {
            $res = new GRespDE();
            $res->setITipIDRespDE(intval($xml->getElementsByTagName('iTipIDRespDE')->item(0)->nodeValue));
            $res->setDNumIDRespDE($xml->getElementsByTagName('dNumIDRespDE')->item(0)->nodeValue);
            $res->setDNomRespDE($xml->getElementsByTagName('dNomRespDE')->item(0)->nodeValue);
            $res->setDCarRespDE($xml->getElementsByTagName('dCarRespDE')->item(0)->nodeValue);

            return $res;
        }
        else {
            throw new \Exception("Invalid XML Element: $xml->tagName");
            return null;
          }
    }

}

?> 