<?php

namespace Abiliomp\Pkuatia\Core\Fields\D;

use DOMElement;

/**
 * Grupo de campos que identifican al receptor (D200)
 * Nodo Padre gDatGralOpe (D001)
 */

class GDatRec
{

    public int $iNatRec; // Naturaleza del receptor (D201): 1 = contribuyente | 2 = no contribuyente
    public int $iTiOpe; // Tipo de operación (D202): 1 = B2B | 2 = B2C | 3 = B2G | 4 = B2F
    public string $cPaisRec; // Código de país del receptor (D203)
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
    public int $cDisRec; // Código del distrito del receptor (D221)
    public int $cCiuRec; // Código del ciudad del receptor (D223)


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
    /**
     * Get the value of iNatRec
     */
    public function getINatRec()
    {
        return $this->iNatRec;
    }

    /**
     * Get the value of iTiOpe
     */
    public function getITiOpe()
    {
        return $this->iTiOpe;
    }

    /**
     * Get the value of cPaisRec
     *
     * @return string
     */
    public function getCPaisRec(): string
    {
        return $this->cPaisRec;
    }

    /**
     * D204 dDesPaisRe Descripción del país receptor
     *
     * @return string
     */
    public function getDDesPaisRe(): string
    {
        return "Mordor";
    }


    /**
     * Get the value of iTiContRec
     */
    public function getITiContRec()
    {
        return $this->iTiContRec;
    }

    /**
     * Get the value of dRucRec
     *
     * @return string
     */
    public function getDRucRec(): string
    {
        return $this->dRucRec;
    }

    /**
     * Get the value of dDVRec
     *
     * @return int
     */
    public function getDDVRec(): int
    {
        return $this->dDVRec;
    }

    /**
     * Get the value of iTipIDRec
     */
    public function getITipIDRec()
    {
        return $this->iTipIDRec;
    }

    /**
     * getDDTipIDRec
     *
     * @return string
     */
    public function getDDTipIDRec(): string
    {
        switch ($this->iTipIDRec) {
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




    /**
     * Get the value of dNumIDRec
     *
     * @return string
     */
    public function getDNumIDRec(): string
    {
        return $this->dNumIDRec;
    }

    /**
     * Get the value of dNomRec
     *
     * @return string
     */
    public function getDNomRec(): string
    {
        return $this->dNomRec;
    }

    /**
     * Get the value of dNomFanRec
     *
     * @return string
     */
    public function getDNomFanRec(): string
    {
        return $this->dNomFanRec;
    }

    /**
     * Get the value of dDirRec
     *
     * @return string
     */
    public function getDDirRec(): string
    {
        return $this->dDirRec;
    }

    /**
     * Get the value of dTelRec
     *
     * @return string
     */
    public function getDTelRec(): string
    {
        return $this->dTelRec;
    }

    /**
     * Get the value of dCelRec
     *
     * @return string
     */
    public function getDCelRec(): string
    {
        return $this->dCelRec;
    }

    /**
     * Get the value of dEmailRec
     *
     * @return string
     */
    public function getDEmailRec(): string
    {
        return $this->dEmailRec;
    }

    /**
     * Get the value of dCodCliente
     *
     * @return string
     */
    public function getDCodCliente(): string
    {
        return $this->dCodCliente;
    }

    /**
     * Get the value of dNumCasRec
     *
     * @return int
     */
    public function getDNumCasRec(): int
    {
        return $this->dNumCasRec;
    }

    /**
     * Get the value of cDepRec
     *
     * @return int
     */
    public function getCDepRec(): int
    {
        return $this->cDepRec;
    }

    /**
     * getDDesDepRec
     *
     * @return string
     */
    public function getDDesDepRec(): string
    {
        return "Mordor";
    }

    /**
     * Get the value of cDisRec
     *
     * @return int
     */
    public function getCDisRec(): int
    {
        return $this->cDisRec;
    }

    /**
     * getDDesDisRec
     *
     * @return string
     */
    public function getDDesDisRec(): string
    {
        return "MORDOR";
    }


    /**
     * Get the value of cCiuRec
     *
     * @return int
     */
    public function getCCiuRec(): int
    {
        return $this->cCiuRec;
    }

    /**
     * getDDesCiuRec
     *
     * @return string
     */
    public function getDDesCiuRec(): string
    {
        return "Mordor";
    }

  //====================================================//
  ///XML Element
  //====================================================//

    /**
     * toDOMElement
     *
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gDatRec');
        $res->appendChild(new DOMElement('iNatRec', $this->getINatRec()));
        $res->appendChild(new DOMElement('iTiOpe', $this->getITiOpe()));
        $res->appendChild(new DOMElement('cPaisRec', $this->getCPaisRec()));
        $res->appendChild(new DOMElement('dDesPaisRe', $this->getDDesPaisRe()));
        if($this->iNatRec == 1)
        {
            $res->appendChild(new DOMElement('iTiContRec', $this->getITiContRec()));
            $res->appendChild(new DOMElement('dRucRec', $this->getDRucRec()));
        }

        if(isset($this->dRucRec))
        {
            $res->appendChild(new DOMElement('dDVRec', $this->getDDVRec()));
        }

        if($this->iNatRec == 2 && $this->iTiOpe != 4)
        {
            $res->appendChild(new DOMElement('iTipIDRec', $this->getITipIDRec()));
            $res->appendChild(new DOMElement('dDTipIDRec', $this->getDDTipIDRec()));
            $res->appendChild(new DOMElement('dNumIDRec', $this->getDNumIDRec()));
        }
        $res->appendChild(new DOMElement('dNomRec', $this->getDNomRec()));
        $res->appendChild(new DOMElement('dNomFanRec', $this->getDNomFanRec()));

        if($this->iTiOpe == 2)
        {
            $res->appendChild(new DOMElement('dDirRec', $this->getDDirRec()));
            $res->appendChild(new DOMElement('dNumCasRec', $this->getDNumCasRec()));
        }

        $res->appendChild(new DOMElement('cDepRec', $this->getCDepRec()));
        $res->appendChild(new DOMElement('dDesDepRec', $this->getDDesDepRec()));
        $res->appendChild(new DOMElement('cDisRec', $this->getCDisRec()));
        $res->appendChild(new DOMElement('dDesDisRec', $this->getDDesDisRec()));
        $res->appendChild(new DOMElement('cCiuRec', $this->getCCiuRec()));
        $res->appendChild(new DOMElement('dDesCiuRec', $this->getDDesCiuRec()));
        if($this->cPaisRec == "PRY")
        {
            ////Debe incluir el prefijo de la ciudad si D203 = PRY
            $res->appendChild(new DOMElement('dTelRec', $this->getDTelRec()));
        }else{
            $res->appendChild(new DOMElement('dTelRec', $this->getDTelRec()));
        }
        $res->appendChild(new DOMElement('dCelRec', $this->getDCelRec()));
        $res->appendChild(new DOMElement('dEmailRec', $this->getDEmailRec()));
        $res->appendChild(new DOMElement('dCodCliente', $this->getDCodCliente()));
        return $res;
    }
    
    /**
     * fromDOMElement
     *
     * @param  mixed $xml
     * @return GDatRec
     */
    public static function fromDOMElement(DOMElement $xml): GDatRec
    {
        if(strcmp($xml->tagName, 'gDatRec') == 0 && $xml->childElementCount >=12)
        {
            $res = new GDatRec();
            $res->setINatRec(intval($xml->getElementsByTagName('iNatRec')->item(0)->nodeValue));
            $res->setITiOpe(intval($xml->getElementsByTagName('iTiOpe')->item(0)->nodeValue));
            $res->setCPaisRec($xml->getElementsByTagName('cPaisRec')->item(0)->nodeValue);
            $res->setITiContRec(intval($xml->getElementsByTagName('iTiContRec')->item(0)->nodeValue));
            $res->setDRucRec($xml->getElementsByTagName('dRucRec')->item(0)->nodeValue);
            $res->setDDVRec(intval($xml->getElementsByTagName('dDVRec')->item(0)->nodeValue));
            $res->setITipIDRec(intval($xml->getElementsByTagName('iTipIDRec')->item(0)->nodeValue));
            $res->setDNumIDRec($xml->getElementsByTagName('dNumIDRec')->item(0)->nodeValue);
            $res->setDNomRec($xml->getElementsByTagName('dNomRec')->item(0)->nodeValue);
            $res->setDNomFanRec($xml->getElementsByTagName('dNomFanRec')->item(0)->nodeValue);
            $res->setDDirRec($xml->getElementsByTagName('dDirRec')->item(0)->nodeValue);
            $res->setDNumCasRec(intval($xml->getElementsByTagName('dNumCasRec')->item(0)->nodeValue));
            $res->setCDepRec(intval($xml->getElementsByTagName('cDepRec')->item(0)->nodeValue));
            $res->setCDisRec(intval($xml->getElementsByTagName('cDisRec')->item(0)->nodeValue));
            $res->setCCiuRec(intval($xml->getElementsByTagName('cCiuRec')->item(0)->nodeValue));
            $res->setDTelRec($xml->getElementsByTagName('dTelRec')->item(0)->nodeValue);
            $res->setDCelRec($xml->getElementsByTagName('dCelRec')->item(0)->nodeValue);
            $res->setDEmailRec($xml->getElementsByTagName('dEmailRec')->item(0)->nodeValue);
            $res->setDCodCliente($xml->getElementsByTagName('dCodCliente')->item(0)->nodeValue);

            return $res;
        }
        else {
            throw new \Exception("Invalid XML Element: $xml->tagName");
            return null;
          }
    }


    /**
     * Set the value of cDisRec
     *
     * @param int $cDisRec
     *
     * @return self
     */
    public function setCDisRec(int $cDisRec): self
    {
        $this->cDisRec = $cDisRec;

        return $this;
    }


    /**
     * Set the value of cCiuRec
     *
     * @param int $cCiuRec
     *
     * @return self
     */
    public function setCCiuRec(int $cCiuRec): self
    {
        $this->cCiuRec = $cCiuRec;

        return $this;
    }
}