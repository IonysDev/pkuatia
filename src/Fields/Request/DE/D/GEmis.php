<?php

namespace Abiliomp\Pkuatia\Fields\D;

use DOMElement;

/**
 * Grupo de campos que identifican al emisor gEmis (D100)
 * Nodo Padre gDatGralOpe (D001)
 */

class GEmis {
    
    public string $dRucEm; // RUC del contribuyente emisor (D101)
    public int $dDVEmi; // Dígito verificador del RUC del contribuyente emisor (D102)
    public int $iTipCont; // Tipo de contribuyente (D103): 1 = Persona Física | 2 = Persona Jurídica
    public int $cTipReg; // Tipo de régimen (D104): 1 = Régimen de Turismo | 2 = Importador | 3 = Exportador | 4 = Maquila | 5 = Ley N° 60/90 | 6 = Régimen del Pequeño Productor | 7 = Régimen del Mediano Productor | 8 = Régimen Contable
    public string $dNomEmi; // Nombre o razón social del emisor del DE (D105)
    public string $dNomFanEmi; // Nombre de fantasía (D106)
    public string $dDirEmi; // Dirección del local donde se emite el DE (D107)
    public int $dNumCas; // Número de casa (D108)
    public string $dCompDir1; // Complemento de dirección 1 (D109)
    public string $dCompDir2; // Complemento de dirección 2 (D110)
    public int $cDepEmi; // Código del departamento de emisión (D111)
    public string $dDesDepEmi; // Descripción del departamento de emisión (D112)  
    public int $cDisEmi; // Código de la distrito de emisión (D113)
    public string $dDesDisEmi; // Descripción de la distrito de emisión (D114)
    public int $cCiuEmi; // Código de la ciudad de emisión (D115)
    public string $dDesCiuEmi; // Descripción de la ciudad de emisión (D116)
    public string $dTelEmi; // Teléfono local de emisión de DE (D117)
    public string $dEmailE; // Correo electrónico del emisor (D118)
    public string $dDenSuc; // Denominación comercial de la sucursal (D119)
    public GActEco $gActEco; // Grupo de campos que describen la actividad económica del emisor
    public GRespDE $gRespDE; // Grupo de campos que identifican al responsable de la generación del DE


    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setDRucEm(string $dRucEm): void
    {
        $this->dRucEm = $dRucEm;
    }

    public function setDDVEmi(int $dDVEmi): void
    {
        $this->dDVEmi = $dDVEmi;
    }

    public function setITipCont(int $iTipCont): void
    {
        $this->iTipCont = $iTipCont;
    }

    public function setCTipReg(int $cTipReg): void
    {
        $this->cTipReg = $cTipReg;
    }

    public function setDNomEmi(string $dNomEmi): void
    {
        $this->dNomEmi = $dNomEmi;
    }

    public function setDNomFanEmi(string $dNomFanEmi): void
    {
        $this->dNomFanEmi = $dNomFanEmi;
    }

    public function setDDirEmi(string $dDirEmi): void
    {
        $this->dDirEmi = $dDirEmi;
    }

    public function setDNumCas(int $dNumCas): void
    {
        $this->dNumCas = $dNumCas;
    }

    public function setDCompDir1(string $dCompDir1): void
    {
        $this->dCompDir1 = $dCompDir1;
    }

    public function setDCompDir2(string $dCompDir2): void
    {
        $this->dCompDir2 = $dCompDir2;
    }

    public function setDDepEmi(int $cDepEmi): void
    {
        $this->cDepEmi = $cDepEmi;
    }

    public function setDDesDepEmi(string $dDesDepEmi): void
    {
        $this->dDesDepEmi = $dDesDepEmi;
    }

    public function setCDisEmi(int $cDisEmi): void
    {
        $this->cDisEmi = $cDisEmi;
    }

    public function setDDesDisEmi(string $dDesDisEmi): void
    {
        $this->dDesDisEmi = $dDesDisEmi;
    }

    public function setCCiuEmi(int $cCiuEmi): void
    {
        $this->cCiuEmi = $cCiuEmi;
    }

    public function setDDesCiuEmi(string $dDesCiuEmi): void
    {
        $this->dDesCiuEmi = $dDesCiuEmi;
    }

    public function setDTelEmi(string $dTelEmi): void
    {
        $this->dTelEmi = $dTelEmi;
    }

    public function setDEmailE(string $dEmailE): void
    {
        $this->dEmailE = $dEmailE;
    }

    public function setDDenSuc(string $dDenSuc): void
    {
        $this->dDenSuc = $dDenSuc;
    }

    public function setGActEco(GActEco $gActEco): void
    {
        $this->gActEco = $gActEco;
    }

    public function setGRespDE(GRespDE $gRespDE): void
    {
        $this->gRespDE = $gRespDE;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getDRucEm(): string
    {
        return $this->dRucEm;
    }

    public function getDDVEmi(): int
    {
        return $this->dDVEmi;
    }

    public function getITipCont(): int
    {
        return $this->iTipCont;
    }

    public function getCTipReg(): int
    {
        return $this->cTipReg;
    }

    public function getDNomEmi(): string
    {
        return $this->dNomEmi;
    }

    public function getDNomFanEmi(): string
    {
        return $this->dNomFanEmi;
    }

    public function getDDirEmi(): string
    {
        return $this->dDirEmi;
    }

    public function getDNumCas(): int
    {
        return $this->dNumCas;
    }

    public function getDCompDir1(): string
    {
        return $this->dCompDir1;
    }

    public function getDCompDir2(): string
    {
        return $this->dCompDir2;
    }

    public function getDDepEmi(): int
    {
        return $this->cDepEmi;
    }

    public function getDDesDepEmi(): string
    {
        return $this->dDesDepEmi;
    }

    public function getCDisEmi(): int
    {
        return $this->cDisEmi;
    }

    public function getDDesDisEmi(): string
    {
        return $this->dDesDisEmi;
    }

    public function getCCiuEmi(): int
    {
        return $this->cCiuEmi;
    }

    public function getDDesCiuEmi(): string
    {
        return $this->dDesCiuEmi;
    }

    public function getDTelEmi(): string
    {
        return $this->dTelEmi;
    }

    public function getDEmailE(): string
    {
        return $this->dEmailE;
    }

    public function getDDenSuc(): string
    {
        return $this->dDenSuc;
    }

    public function getGActEco(): GActEco
    {
        return $this->gActEco;
    }

    public function getGRespDE(): GRespDE
    {
        return $this->gRespDE;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gEmis');
        $res->appendChild(new DOMElement('dRucEm', $this->dRucEm));
        $res->appendChild(new DOMElement('dDVEmi', $this->dDVEmi));
        $res->appendChild(new DOMElement('iTipCont', $this->iTipCont));
        $res->appendChild(new DOMElement('cTipReg', $this->cTipReg));
        $res->appendChild(new DOMElement('dNomEmi', $this->dNomEmi));
        $res->appendChild(new DOMElement('dNomFanEmi', $this->dNomFanEmi));
        $res->appendChild(new DOMElement('dDirEmi', $this->dDirEmi));
        $res->appendChild(new DOMElement('dNumCas', $this->dNumCas));
        $res->appendChild(new DOMElement('dCompDir1', $this->dCompDir1));
        $res->appendChild(new DOMElement('dCompDir2', $this->dCompDir2));
        $res->appendChild(new DOMElement('cDepEmi', $this->cDepEmi));
        $res->appendChild(new DOMElement('dDesDepEmi', $this->dDesDepEmi));
        $res->appendChild(new DOMElement('cDisEmi', $this->cDisEmi));
        $res->appendChild(new DOMElement('dDesDisEmi', $this->dDesDisEmi));
        $res->appendChild(new DOMElement('cCiuEmi', $this->cCiuEmi));
        $res->appendChild(new DOMElement('dDesCiuEmi', $this->dDesCiuEmi));
        $res->appendChild(new DOMElement('dTelEmi', $this->dTelEmi));
        $res->appendChild(new DOMElement('dEmailE', $this->dEmailE));
        $res->appendChild(new DOMElement('dDenSuc', $this->dDenSuc));
        $res->appendChild($this->gActEco->toDOMElement());
        if(isset($this->gRespDE)){
            $res->appendChild($this->gRespDE->toDOMElement());
        }
        return $res;
    }

}

?> 