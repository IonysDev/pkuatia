<?php

namespace Abiliomp\Pkuatia\Fields;

use DOMElement;

/**
 * Campos que identifican al receptor (D200)
 * Nodo padre gDatGralOpe (D001): Campos Generales del Documento Electrónico DE
 */

class GDatRec {

    public int $iNatRec; // Naturaleza del receptor (D201): 1 = contribuyente | 2 = no contribuyente
    public int $iTiOpe; // Tipo de operación (D202): 1 = B2B | 2 = B2C | 3 = B2G | 4 = B2F
    public string $cPaisRec; // Código de país del receptor (D203)
    public string $dDesPaisRe; // Descripción del país receptor (D204)
    public int $iTiContRec; // Tipo de contribuyente receptor (D205): 1 = Persona Física | 2 = Persona Jurídica
    public string $dRucRec; // RUC del receptor (D206)
    public int $dDVRec; // Dígito verificador del RUC del receptor (D207)
    public int $iTipIDRec; // Tipo de documento de identidad del receptor (D208): 1 = Cédula Paraguaya | 2 = Pasaporte | 3 = Cédula Extrangera | 4 = País de Residencia | 5 = Innominado | 6 = Tarjeta Diplomática | 9 = Otro
    public string $dNumIDRec; // Número de documento de identidad (D210)
    public string $dNomRec; // Nombre o razón social del receptor del DE (D211)
    public string $dNomFanRec; // Nombre de fantasía (D212)
    public string $dDirRec; // Dirección del receptor (D213)
    public string $dTelRec; // Número de teléfono del receptor (D214)
    public string $dCelRec; // Número de celular del receptor (D215)
    public string $dEmailRec; // Correo electrónico de receptor (D216)
    public string $dCodCliente; // Código del cliente (D217)
    public int $dNumCasRec; // Número de casa del receptor (D218)
    public int $cDepRec; // Código del departamento del receptor (D219)
    public string $dDesDepRec; // Descripción del departamento del receptor (D220)
    public int $cDisRec; // Código del distrito del receptor (D221)
    public string $dDesDisRec; // Descripción del distrito del receptor (D222)
    public int $cCiuRec; // Código del ciudad del receptor (D223)
    public string $dDesCiuRec; // Descripción del ciudad del receptor (D224)
     
    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setINatRec(int $iNatRec): void
    {
        $this->iNatRec = $iNatRec;
    }

    public function setITiOpe(int $iTiOpe): void
    {
        $this->iTiOpe = $iTiOpe;
    }

    public function setCPaisRec(string $cPaisRec): void
    {
        $this->cPaisRec = $cPaisRec;
    }

    public function setDDesPaisRe(string $dDesPaisRe): void
    {
        $this->dDesPaisRe = $dDesPaisRe;
    }

    public function setITiContRec(int $iTiContRec): void
    {
        $this->iTiContRec = $iTiContRec;
    }

    public function setDRucRec(string $dRucRec): void
    {
        $this->dRucRec = $dRucRec;
    }

    public function setDDVRec(int $dDVRec): void
    {
        $this->dDVRec = $dDVRec;
    }

    public function setITipIDRec(int $iTipIDRec): void
    {
        $this->iTipIDRec = $iTipIDRec;
    }

    public function setDNumIDRec(string $dNumIDRec): void
    {
        $this->dNumIDRec = $dNumIDRec;
    }

    public function setDNomRec(string $dNomRec): void
    {
        $this->dNomRec = $dNomRec;
    }

    public function setDNomFanRec(string $dNomFanRec): void
    {
        $this->dNomFanRec = $dNomFanRec;
    }

    public function setDDirRec(string $dDirRec): void
    {
        $this->dDirRec = $dDirRec;
    }

    public function setDTelRec(string $dTelRec): void
    {
        $this->dTelRec = $dTelRec;
    }

    public function setDCelRec(string $dCelRec): void
    {
        $this->dCelRec = $dCelRec;
    }

    public function setDEmailRec(string $dEmailRec): void
    {
        $this->dEmailRec = $dEmailRec;
    }

    public function setDCodCliente(string $dCodCliente): void
    {
        $this->dCodCliente = $dCodCliente;
    }

    public function setDNumCasRec(int $dNumCasRec): void
    {
        $this->dNumCasRec = $dNumCasRec;
    }

    public function setCDepRec(int $cDepRec): void
    {
        $this->cDepRec = $cDepRec;
    }

    public function setDDesDepRec(int $dDesDepRec): void
    {
        $this->dDesDepRec = $dDesDepRec;
    }

    public function setCDisRec(int $cDisRec): void
    {
        $this->cDisRec = $cDisRec;
    }

    public function setDDesDisRec(int $dDesDisRec): void
    {
        $this->dDesDisRec = $dDesDisRec;
    }

    public function setCCiuRec(int $cCiuRec): void
    {
        $this->cCiuRec = $cCiuRec;
    }

    public function setDDesCiuRec(int $dDesCiuRec): void
    {
        $this->dDesCiuRec = $dDesCiuRec;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getINatRec(): int 
    {
        return $this->iNatRec;
    }

    public function getITiOpe(): int 
    {
        return $this->iTiOpe;
    }

    public function getCPaisRec(): string 
    {
        return $this->cPaisRec;
    }

    public function getDDesPaisRe(): string 
    {
        return $this->dDesPaisRe;
    }

    public function getITiContRec(): int 
    {
        return $this->iTiContRec;
    }

    public function getDRucRec(): string 
    {
        return $this->dRucRec;
    }

    public function getDDVRec(): int 
    {
        return $this->dDVRec;
    }

    public function getITipIDRec(): int 
    {
        return $this->iTipIDRec;
    }
    
    public function getDDTipIDRec(): string
    {
        switch($this->iTipIDRec) {
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
            case 5:
                return 'Innominado';
                break;
            case 6:
                return 'Tarjeta Diplomática de exoneración fiscal';
                break;
            default:
                return 'Otro';
                break;
        }
    }

    public function getDNumIDRec(): string 
    {
        return $this->dNumIDRec;
    }

    public function getDNomRec(): string 
    {
        return $this->dNomRec;
    }

    public function getDNomFanRec(): string 
    {
        return $this->dNomFanRec;
    }

    public function getDDirRec(): string 
    {
        return $this->dDirRec;
    }

    public function getDTelRec(): string 
    {
        return $this->dTelRec;
    }

    public function getDCelRec(): string 
    {
        return $this->dCelRec;
    }

    public function getDEmailRec(): string 
    {
        return $this->dEmailRec;
    }

    public function getDCodCliente(): string 
    {
        return $this->dCodCliente;
    }

    public function getDNumCasRec(): int 
    {
        return $this->dNumCasRec;
    }

    public function getCDepRec(): int 
    {
        return $this->cDepRec;
    }

    public function getDDesDepRec(): string 
    {
        return $this->dDesDepRec;
    }

    public function getCDisRec(): int 
    {
        return $this->cDisRec;
    }

    public function getDDesDisRec(): string 
    {
        return $this->dDesDisRec;
    }

    public function getCCiuRec(): int 
    {
        return $this->cCiuRec;
    }

    public function getDDesCiuRec(): string 
    {
        return $this->dDesCiuRec;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gDatRec');
        $res->appendChild(new DOMElement('iNatRec', $this->iNatRec));
        $res->appendChild(new DOMElement('iTiOpe', $this->iTiOpe));
        $res->appendChild(new DOMElement('cPaisRec', $this->cPaisRec));
        $res->appendChild(new DOMElement('dDesPaisRe', $this->dDesPaisRe));
        
        if($this->iNatRec != 2) {
            // No informar si D201 = 2 
            $res->appendChild(new DOMElement('iTiContRec', $this->iTiContRec));
            $res->appendChild(new DOMElement('dRucRec', $this->dRucRec));
            // Obligatorio si existe el campo D206
            $res->appendChild(new DOMElement('dDVRec', $this->dDVRec));
        }

        if($this->iNatRec != 1 && $this->iTiOpe != 4) {
            // No informar si D201 = 1 o D202=4
            $res->appendChild(new DOMElement('iTipIDRec', $this->iTipIDRec));
            // Obligatorio si existe el campo D208
            $res->appendChild(new DOMElement('dDTipIDRec', $this->getDDTipIDRec()));
            // No informar si D201 = 1 o D202=4. En caso de DE innominado, completar con 0 (cero) 
            $res->appendChild(new DOMElement('dNumIDRec', $this->iTipIDRec == 5 ? 0 : $this->dNumIDRec));
        }

        // En caso de DE innominado, completar con “Sin Nombre”
        $res->appendChild(new DOMElement('dNomRec', $this->iTipIDRec == 5 ? "Sin Nombre" : $this->dNomRec));
        if(isset($this->dNomFanRec))
            $res->appendChild(new DOMElement('dNomFanRec', $this->dNomFanRec));
        
        if(isset($this->dDirRec)) {
            $res->appendChild(new DOMElement('dDirRec', $this->dDirRec));
            $res->appendChild(new DOMElement('dNumCasRec', $this->dNumCasRec));
            if($this->iTiOpe != 4) {
                $res->appendChild(new DOMElement('cDepRec', $this->cDepRec));
                $res->appendChild(new DOMElement('dDesDepRec', $this->dDesDepRec));
                $res->appendChild(new DOMElement('cDisRec', $this->cDisRec));
                $res->appendChild(new DOMElement('dDesDisRec', $this->dDesDisRec));
                $res->appendChild(new DOMElement('cCiuRec', $this->cCiuRec));
                $res->appendChild(new DOMElement('dDesCiuRec', $this->dDesCiuRec));
            }
        }

        if(isset($this->dTelRec))
            $res->appendChild(new DOMElement('dTelRec', $this->dTelRec));
        
        if(isset($this->dCelRec))
            $res->appendChild(new DOMElement('dCelRec', $this->dCelRec));
        
        if(isset($this->dEmailRec))
            $res->appendChild(new DOMElement('dEmailRec', $this->dEmailRec));
    
        if(isset($this->dCodCliente))
            $res->appendChild(new DOMElement('dCodCliente', $this->dCodCliente));

        return $res;
    }

}

?> 