<?php

namespace Abiliomp\Pkuatia\Fields;

use DOMElement;

/**
 * Grupo de campos que identifican al responsable de la generación del DE
 */

class GRespDE {
    
    public int $iTipIDRespDE; // Tipo de documento de identidad del responsable de la generación del DE
    public string $dNumIDRespDE; // Número de documento de identidad del responsable de la generación del DE
    public string $dNomRespDE; // Nombre o razón social del responsable de la generación del DE
    public string $dCarRespDE; // Cargo del responsable de la generación del DE 

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

}

?> 