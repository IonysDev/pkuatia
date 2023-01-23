<?php

namespace Abiliomp\Pkuatia\Fields\B;

use DOMElement;

class GOpeDE {
    
    public int $iTipEmi; // Tipo de emision: 1 = Normal | 2 = Contingencia
    public int $dCodSeg; // Código de seguridad: número que debe formatearse al exportar con 9 caracteres con 0s a la izquierda
    public string $dInfoEmi; // Información de interés del emisor respecto al DE
    public string $dInfoFisc; // Información de interés del fisco respecto al DE

    ///////////////////////////////////////////////////////////////////////
    // Constructors
    ///////////////////////////////////////////////////////////////////////

    function __construct() {
        $this->dCodSeg = random_int(0, 999999999);
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setITipEmi(int $iTipEmi): void
    {
        $this->iTipEmi = $iTipEmi;
    }

    public function setDCodSeg(int $dCodSeg): void
    {
        $this->dCodSeg = $dCodSeg;
    }

    public function setDInfoEmi(string $dInfoEmi): void
    {
        $this->dInfoEmi = $dInfoEmi;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getITipEmi(): int
    {
        return $this->iTipEmi;
    }

    public function getDDesTipEmi(): string
    {
        switch($this->iTipEmi) {
            case 1:
                return 'Normal';
                break;
            case 2:
                return 'Contingencia';
                break;
            default:
                return null;
        }
    }

    public function getDCodSeg(): int
    {
        return $this->dCodSeg;
    }

    public function getDInfoEmi(): string
    {
        return $this->dInfoEmi;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gOpeDE');
        $res->appendChild(new DOMElement('iTipEmi', $this->iTipEmi));
        $res->appendChild(new DOMElement('dDesTipEmi', $this->getDDesTipEmi()));
        $res->appendChild(new DOMElement('dCodSeg', str_pad(($this->dCodSeg % 1000000000), 9, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dInfoEmi', $this->dInfoEmi));
        $res->appendChild(new DOMElement('dInfoFisc', $this->dInfoFisc));
        return $res;
    }

}

?> 