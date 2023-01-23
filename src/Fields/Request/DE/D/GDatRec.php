<?php

namespace Abiliomp\Pkuatia\Fields\D;

use DOMElement;

/**
 * Grupo de campos que identifican al receptor (D200)
 * Nodo Padre gDatGralOpe (D001)
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

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

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

}

?> 