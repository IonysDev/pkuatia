<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

use Abiliomp\Pkuatia\Helpers\GeoRefHelper;
use DOMElement;

/**
 * Grupo de campos que identifican al emisor gEmis (D100)
 * Nodo Padre gDatGralOpe (D001)
 */

class GEmis
{

    public ?string $dRucEm = null; // RUC del contribuyente emisor (D101)
    public ?int $dDVEmi = null; // Dígito verificador del RUC del contribuyente emisor (D102)
    public ?int $iTipCont = null; // Tipo de contribuyente (D103): 1 = Persona Física | 2 = Persona Jurídica
    public ?int $cTipReg = null; // Tipo de régimen (D104): 1 = Régimen de Turismo | 2 = Importador | 3 = Exportador | 4 = Maquila | 5 = Ley N° 60/90 | 6 = Régimen del Pequeño Productor | 7 = Régimen del Mediano Productor | 8 = Régimen Contable
    public ?string $dNomEmi = null; // Nombre o razón social del emisor del DE (D105)
    public ?string $dNomFanEmi = null; // Nombre de fantasía (D106)
    public ?string $dDirEmi = null; // Dirección del local donde se emite el DE (D107)
    public ?int $dNumCas = null; // Número de casa (D108)
    public ?string $dCompDir1 = null; // Complemento de dirección 1 (D109)
    public ?string $dCompDir2 = null; // Complemento de dirección 2 (D110)
    public ?int $cDepEmi = null; // Código del departamento de emisión (D111)
    public ?int $cDisEmi = null; // Código de la distrito de emisión (D113)
    public ?int $cCiuEmi = null; // Código de la ciudad de emisión (D115)
    public ?string $dTelEmi = null; // Teléfono local de emisión de DE (D117)
    public ?string $dEmailE = null; // Correo electrónico del emisor (D118)
    public ?string $dDenSuc = null; // Denominación comercial de la sucursal (D119)
    public ?GActEco $gActEco = null; // Grupo de campos que describen la actividad económica del emisor
    public ?GRespDE $gRespDE = null; // Grupo de campos que identifican al responsable de la generación del DE


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

    public function setCDisEmi(int $cDisEmi): void
    {
        $this->cDisEmi = $cDisEmi;
    }


    public function setCCiuEmi(int $cCiuEmi): void
    {
        $this->cCiuEmi = $cCiuEmi;
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

    public function getDRucEm(): string | null
    {
        return $this->dRucEm;
    }

    public function getDDVEmi(): int | null
    {
        return $this->dDVEmi;
    }

    public function getITipCont(): int | null
    {
        return $this->iTipCont;
    }

    public function getCTipReg(): int | null
    {
        return $this->cTipReg;
    }

    public function getDNomEmi(): string | null
    {
        return $this->dNomEmi;
    }

    public function getDNomFanEmi(): string  | null
    {
        return $this->dNomFanEmi;
    }

    public function getDDirEmi(): string | null
    {
        return $this->dDirEmi;
    }

    public function getDNumCas(): int | null
    {
        return $this->dNumCas;
    }

    public function getDCompDir1(): string | null
    {
        return $this->dCompDir1;
    }

    public function getDCompDir2(): string | null
    {
        return $this->dCompDir2;
    }

    public function getDDepEmi(): int | null
    {
        return $this->cDepEmi;
    }

    /**
     * D112 Descripción del departamento de emisión
     * 
     * @return string
     */
    public function getDDesDepEmi(): string | null
    {
        return GeoRefHelper::getDepName(strval($this->cDepEmi));
    }

    public function getCDisEmi(): int | null
    {
        return $this->cDisEmi;
    }

    /**
     * D114 Descripción del distrito de emisión
     *
     * @return string
     */
    public function getDDesDisEmi(): string | null
    {
        return GeoRefHelper::getDistName(strval($this->cDisEmi));
    }

    public function getCCiuEmi(): int | null
    {
        return $this->cCiuEmi;
    }

    /**
     *  D116 dDesCiuEmi Descripción de la ciudad de emisión
     *
     * @return string
     */
    public function getDDesCiuEmi(): string | null
    {
        return GeoRefHelper::getCiuName(strval($this->cCiuEmi));
    }

    public function getDTelEmi(): string | null
    {
        return $this->dTelEmi;
    }

    public function getDEmailE(): string | null
    {
        return $this->dEmailE;
    }

    public function getDDenSuc(): string | null
    {
        return $this->dDenSuc;
    }

    public function getGActEco(): GActEco | null
    {
        return $this->gActEco;
    }

    public function getGRespDE(): GRespDE | null
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
        $res->appendChild(new DOMElement('dDesDepEmi', $this->getDDesDepEmi()));
        $res->appendChild(new DOMElement('cDisEmi', $this->cDisEmi));
        $res->appendChild(new DOMElement('dDesDisEmi', $this->getDDesDisEmi()));
        $res->appendChild(new DOMElement('cCiuEmi', $this->cCiuEmi));
        $res->appendChild(new DOMElement('dDesCiuEmi', $this->getDDesCiuEmi()));
        $res->appendChild(new DOMElement('dTelEmi', $this->dTelEmi));
        $res->appendChild(new DOMElement('dEmailE', $this->dEmailE));
        $res->appendChild(new DOMElement('dDenSuc', $this->dDenSuc));
        ///Children
        $res->appendChild($this->gActEco->toDOMElement());
        if (isset($this->gRespDE)) {
            $res->appendChild($this->gRespDE->toDOMElement());
        }
        return $res;
    }

    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return GEmis
    //  */
    // public static function fromDOMElement(DOMElement $xml): GEmis
    // {
    //     if (strcmp($xml->tagName, 'gEmis') == 0 && $xml->childElementCount == 21) {
    //         $res = new GEmis();
    //         $res->setDRucEm($xml->getElementsByTagName('dRucEm')->item(0)->nodeValue);
    //         $res->setDDVEmi(intval($xml->getElementsByTagName('dDVEmi')->item(0)->nodeValue));
    //         $res->setITipCont(intval($xml->getElementsByTagName('iTipCont')->item(0)->nodeValue));
    //         $res->setCTipReg(intval($xml->getElementsByTagName('cTipReg')->item(0)->nodeValue));
    //         $res->setDNomEmi($xml->getElementsByTagName('dNomEmi')->item(0)->nodeValue);
    //         $res->setDNomFanEmi($xml->getElementsByTagName('dNomFanEmi')->item(0)->nodeValue);
    //         $res->setDDirEmi($xml->getElementsByTagName('dDirEmi')->item(0)->nodeValue);
    //         $res->setDNumCas(intval($xml->getElementsByTagName('dNumCas')->item(0)->nodeValue));
    //         $res->setDCompDir1($xml->getElementsByTagName('dCompDir1')->item(0)->nodeValue);
    //         $res->setDCompDir2($xml->getElementsByTagName('dCompDir2')->item(0)->nodeValue);
    //         $res->setCDepEmi(intval($xml->getElementsByTagName('cDepEmi')->item(0)->nodeValue));
    //         $res->setCDisEmi(intval($xml->getElementsByTagName('cDisEmi')->item(0)->nodeValue));
    //         $res->setCCiuEmi(intval($xml->getElementsByTagName('cCiuEmi')->item(0)->nodeValue));
    //         $res->setDTelEmi($xml->getElementsByTagName('dTelEmi')->item(0)->nodeValue);
    //         $res->setDEmailE($xml->getElementsByTagName('dEmailE')->item(0)->nodeValue);
    //         $res->setDDenSuc($xml->getElementsByTagName('dDenSuc')->item(0)->nodeValue);
    //         /////children
    //         $res->setGActEco($res->gActEco->fromDOMElement($xml->getElementsByTagName('gActEco')->item(0)->nodeValue));
    //         $res->setGRespDE($res->gRespDE->fromDOMElement($xml->getElementsByTagName('gRespDE')->item(0)->nodeValue));
    //         return $res;
    //     } else {
    //         throw new \Exception("Invalid XML Element: $xml->tagName");
    //         return null;
    //     }
    // }



    /**
     * Set the value of cDepEmi
     *
     * @param int $cDepEmi
     *
     * @return self
     */
    public function setCDepEmi(int $cDepEmi): self
    {
        $this->cDepEmi = $cDepEmi;

        return $this;
    }

    /**
     * fromResponse
     *
     * @param  mixed $response
     * @return self
     */
    public static function fromResponse($response): self
    {
        $gEmis = new GEmis();
        if (isset($response->dRucEm)) {
            $gEmis->setDRucEm($response->dRucEm);
        }
        if (isset($response->dDVEmi)) {
            $gEmis->setDDVEmi($response->dDVEmi);
        }
        if (isset($response->iTipCont)) {
            $gEmis->setITipCont($response->iTipCont);
        }
        if (isset($response->cTipReg)) {
            $gEmis->setCTipReg($response->cTipReg);
        }
        if (isset($response->dNomEmi)) {
            $gEmis->setDNomEmi($response->dNomEmi);
        }
        if (isset($response->dNomFanEmi)) {
            $gEmis->setDNomFanEmi($response->dNomFanEmi);
        }
        if (isset($response->dDirEmi)) {
            $gEmis->setDDirEmi($response->dDirEmi);
        }
        if (isset($response->dNumCas)) {
            $gEmis->setDNumCas($response->dNumCas);
        }

        if (isset($response->dCompDir1)) {
            $gEmis->setDCompDir1($response->dCompDir1);
        }
        if (isset($response->dCompDir2)) {
            $gEmis->setDCompDir2($response->dCompDir2);
        }
        if (isset($response->cDepEmi)) {
            $gEmis->setCDepEmi($response->cDepEmi);
        }
        if (isset($response->cDisEmi)) {
            $gEmis->setCDisEmi($response->cDisEmi);
        }
        if (isset($response->cCiuEmi)) {
            $gEmis->setCCiuEmi($response->cCiuEmi);
        }
        if (isset($response->dTelEmi)) {
            $gEmis->setDTelEmi($response->dTelEmi);
        }
        if (isset($response->dEmailE)) {
            $gEmis->setDEmailE($response->dEmailE);
        }
        if (isset($response->dDenSuc)) {
            $gEmis->setDDenSuc($response->dDenSuc);
        }
        //Children
        if (isset($response->gActEco)) {
            $gEmis->setGActEco(GActEco::fromResponse($response->gActEco));
        }
        if (isset($response->gRespDE)) {
            $gEmis->setGRespDE(GRespDE::fromResponse($response->gRespDE));
        }
        return $gEmis;
    }
}
