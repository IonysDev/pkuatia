<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

use DOMElement;

/**
 * ID: D140 Grupo de campos que identifican al responsable de la generación del DE PADRE:D100 
 */

/**
 * GRespDE
 */
class GRespDE {
    
    public ?int $iTipIDRespDE = null;    // D141 - Tipo de documento de identidad del responsable de la generación del DE
    public ?string $dNumIDRespDE= null; // D143 - Número de documento de identidad del responsable de la generación del DE
    public ?string $dNomRespDE= null;   // D144 - Nombre o razón social del responsable de la generación del DE
    public ?string $dCarRespDE= null;   // D145 - Cargo del responsable de la generación del DE 

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

    public function getITipIDRespDE(): int | null
    {
        return $this->iTipIDRespDE;
    }

    /**
     * Devuelve la descripción del documento de identidad del responsable de la generación del DE
     * 
     * @return string
     */
    public function getDDTipIDRespDE(): string | null
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

    public function getDNumIDRespDE(): string | null
    {
        return $this->dNumIDRespDE;
    }

    public function getDNomRespDE(): string | null
    {
        return $this->dNomRespDE;
    }

    public function getDCarRespDE(): string | null
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
