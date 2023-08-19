<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Helpers\CountryHelper;
use Abiliomp\Pkuatia\Helpers\DepartamentoHelper;
use Abiliomp\Pkuatia\Helpers\GeoRefCodesHelper;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: D200
 * Descripción: Grupo de campos que identifican al receptor
 * Nodo Padre: gDatGralOpe (D001)
 */

class GDatRec
{

    public ?int $iNatRec = null; // Naturaleza del receptor (D201): 1 = contribuyente | 2 = no contribuyente
    public ?int $iTiOpe = null; // Tipo de operación (D202): 1 = B2B | 2 = B2C | 3 = B2G | 4 = B2F
    public ?string $cPaisRec = null; // Código de país del receptor (D203)
    public ?string $dDesPaisRe = null; // Descripción del país del receptor (D204)
    public ?int $iTiContRec = null; // Tipo de contribuyente receptor (D205): 1 = Persona Física | 2 = Persona Jurídica
    public ?string $dRucRec = null; // RUC del receptor (D206)
    public ?int $dDVRec = null; // Dígito verificador del RUC del receptor (D207)
    public ?int $iTipIDRec = null; // Tipo de documento de identidad del receptor (D208): 1 = Cédula Paraguaya | 2 = Pasaporte | 3 = Cédula Extrangera | 4 = País de Residencia | 5 = Innominado | 6 = Tarjeta Diplomática | 9 = Otro
    public ?String $dDTipIDRec = null; // Descripción del tipo de documento de identidad del receptor (D209)
    public ?string $dNumIDRec = null; // Número de documento de identidad (D210)
    public ?string $dNomRec = null; // Nombre o razón social del receptor del DE (D211)
    public ?string $dNomFanRec = null; // Nombre de fantasía (D212)
    public ?string $dDirRec = null; // Dirección del receptor (D213)
    public ?int $dNumCasRec = null; // Número de casa del receptor (D218)
    public ?int $cDepRec = null; // Código del departamento del receptor (D219)
    public ?String $dDesDepRec = null; // Descripción del departamento del receptor (D220)
    public ?int $cDisRec = null; // Código del distrito del receptor (D221)
    public ?String $dDesDisRec = null; // Descripción del distrito del receptor (D222)
    public ?int $cCiuRec = null; // Código del ciudad del receptor (D223)
    public ?String $dDesCiuRec = null; // Descripción del ciudad del receptor (D224)
    public ?string $dTelRec = null; // Número de teléfono del receptor (D214)
    public ?string $dCelRec = null; // Número de celular del receptor (D215)
    public ?string $dEmailRec = null; // Correo electrónico de receptor (D216)
    public ?string $dCodCliente = null; // Código del cliente (D217)

    /**
     * GDatRec constructor.
     */
    public function __construct()
    {
        $this->dNomRec = 'Sin Nombre';
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setINatRec(int $iNatRec): self
    {
        $this->iNatRec = $iNatRec;
        return $this;
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

    public function setDDTipIDRec(string $dDTipIDRec): void
    {
        $this->dDTipIDRec = $dDTipIDRec;
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

    public function setDDesDepRec(string $dDesDepRec): self
    {
        $this->dDesDepRec = $dDesDepRec;
        return $this;
    }

    public function setCDisRec(int $cDisRec): self
    {
        $this->cDisRec = $cDisRec;

        return $this;
    }

    public function setDDesDisRec(string $dDesDisRec): self
    {
        $this->dDesDisRec = $dDesDisRec;

        return $this;
    }

    public function setCCiuRec(int $cCiuRec): self
    {
        $this->cCiuRec = $cCiuRec;

        return $this;
    }

    public function setDDesCiuRec(string $dDesCiuRec): self
    {
        $this->dDesCiuRec = $dDesCiuRec;

        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////
    /**
     * Get the value of iNatRec
     */
    public function getINatRec(): int | null
    {
        return $this->iNatRec;
    }

    /**
     * Get the value of iTiOpe
     */
    public function getITiOpe() : int | null
    {
        return $this->iTiOpe;
    }

    /**
     * Get the value of cPaisRec
     *
     * @return string
     */
    public function getCPaisRec(): string | null
    {
        return $this->cPaisRec;
    }

    /**
     * D204 dDesPaisRe Descripción del país receptor
     *
     * @return string
     */
    public function getDDesPaisRe(): string | null
    {
        // return CountryHelper::getCountryDesc($this->cPaisRec);
        return $this->dDesPaisRe;
    }


    /**
     * Get the value of iTiContRec
     */
    public function getITiContRec() : int | null
    {
        return $this->iTiContRec;
    }

    /**
     * Get the value of dRucRec
     *
     * @return string
     */
    public function getDRucRec(): string | null
    {
        return $this->dRucRec;
    }

    /**
     * Get the value of dDVRec
     *
     * @return int
     */
    public function getDDVRec(): int | null
    {
        return $this->dDVRec;
    }

    /**
     * Get the value of iTipIDRec
     */
    public function getITipIDRec() : int | null
    {
        return $this->iTipIDRec;
    }

    /**
     * getDDTipIDRec
     *
     * @return string
     */
    public function getDDTipIDRec(): string | null
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
    public function getDNumIDRec(): string | null
    {
        return $this->dNumIDRec;
    }

    /**
     * Get the value of dNomRec
     *
     * @return string
     */
    public function getDNomRec(): string | null
    {
        return $this->dNomRec;
    }

    /**
     * Get the value of dNomFanRec
     *
     * @return string
     */
    public function getDNomFanRec(): string | null
    {
        return $this->dNomFanRec;
    }

    /**
     * Get the value of dDirRec 
     *
     * @return string
     */
    public function getDDirRec(): string | null
    {
        return $this->dDirRec;
    }

    /**
     * Get the value of dTelRec
     *
     * @return string
     */
    public function getDTelRec(): string | null
    {
        return $this->dTelRec;
    }

    /**
     * Get the value of dCelRec
     *
     * @return string
     */
    public function getDCelRec(): string | null
    {
        return $this->dCelRec;
    }

    /**
     * Get the value of dEmailRec
     *
     * @return string
     */
    public function getDEmailRec(): string | null
    {
        return $this->dEmailRec;
    }

    /**
     * Get the value of dCodCliente
     *
     * @return string
     */
    public function getDCodCliente(): string | null
    {
        return $this->dCodCliente;
    }

    /**
     * Get the value of dNumCasRec
     *
     * @return int
     */
    public function getDNumCasRec(): int | null
    {
        return $this->dNumCasRec;
    }

    /**
     * Get the value of cDepRec
     *
     * @return int
     */
    public function getCDepRec(): int | null
    {
        return $this->cDepRec;
    }

    /**
     * getDDesDepRec
     *
     * @return string
     */
    public function getDDesDepRec(): string | null
    {
        return DepartamentoHelper::getDepName(strval($this->cDepRec));
    }

    /**
     * Get the value of cDisRec
     *
     * @return int
     */
    public function getCDisRec(): int | null
    {
        return $this->cDisRec;
    }

    /**
     * getDDesDisRec
     *
     * @return string
     */
    public function getDDesDisRec(): string | null
    {
        return GeoRefCodesHelper::getDistName(strval($this->cDisRec));
    }


    /**
     * Get the value of cCiuRec
     *
     * @return int
     */
    public function getCCiuRec(): int | null
    {
        return $this->cCiuRec;
    }

    /**
     * getDDesCiuRec
     *
     * @return string
     */
    public function getDDesCiuRec(): string | null
    {
        return GeoRefCodesHelper::getCiudName(strval($this->cCiuRec));
    }

    ///////////////////////////////////////////////////////////////////////
    ///XML Element
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia la clase a partir de un SimpleXMLElement
     * 
     * @param SimpleXMLElement $node
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        if(strcmp($node->getName(), 'gDatRec') != 0){
            throw new \InvalidArgumentException("El nombre del elemento no es gDatRec");
        }

        $res = new GDatRec();
        $res->setINatRec(intval($node->iNatRec));
        $res->setITiOpe(intval($node->iTiOpe));
        $res->setCPaisRec(strval($node->cPaisRec));
        $res->setDDesPaisRe(strval($node->dDesPaisRe));
        if(isset($node->iTiContRec))
            $res->setITiContRec(intval($node->iTiContRec));
        if(isset($node->dRucRec))
            $res->setDRucRec(strval($node->dRucRec));
        if(isset($node->dDVRec))
            $res->setITipIDRec(intval($node->dDVRec));
        if(isset($node->iTipIDRec))
            $res->setDNumIDRec(intval($node->iTipIDRec));
        if(isset($node->dDTipIDRec))
            $res->setDDTipIDRec(strval($node->dDTipIDRec));
        if(isset($node->dNumIDRec))
            $res->setDNomFanRec(strval($node->dNumIDRec));
        $res->setDNomRec(strval($node->dNomRec));
        if(isset($node->dNomFanRec))
            $res->setDNomFanRec(strval($node->dNomFanRec));
        if(isset($node->dDirRec))
            $res->setDDirRec(strval($node->dDirRec));
        if(isset($node->getDNumCasRec))
            $res->setDNumCasRec(intval($node->getDNumCasRec));
        if(isset($node->cDepRec))
            $res->setCDepRec(intval($node->cDepRec));
        if(isset($node->cCiuRec))
            $res->setDDesDepRec(strval($node->dDesDepRec));
        if(isset($node->cDisRec))
            $res->setCDisRec(intval($node->cDisRec));
        if(isset($node->dDesDisRec))
            $res->setDDesDisRec(strval($node->dDesDisRec));
        if(isset($node->cCiuRec))
            $res->setCCiuRec(intval($node->cCiuRec));
        if(isset($node->dDesCiuRec))
            $res->setDDesCiuRec(strval($node->dDesCiuRec));
        if(isset($node->dTelRec))
            $res->setDTelRec(strval($node->dTelRec));
        if(isset($node->dCelRec))
            $res->setDCelRec(strval($node->dCelRec));
        if(isset($node->dEmailRec))
            $res->setDEmailRec(strval($node->dEmailRec));
        if(isset($node->dCodCliente))
            $res->setDCodCliente(strval($node->dCodCliente));
        return $res;
    }

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
        if ($this->iNatRec == 1) {
            $res->appendChild(new DOMElement('iTiContRec', $this->getITiContRec()));
            $res->appendChild(new DOMElement('dRucRec', $this->getDRucRec()));
        }

        if (isset($this->dRucRec)) {
            $res->appendChild(new DOMElement('dDVRec', $this->getDDVRec()));
        }

        if ($this->iNatRec == 2 && $this->iTiOpe != 4) {
            $res->appendChild(new DOMElement('iTipIDRec', $this->getITipIDRec()));
            $res->appendChild(new DOMElement('dDTipIDRec', $this->getDDTipIDRec()));
            $res->appendChild(new DOMElement('dNumIDRec', $this->getDNumIDRec()));
        }
        $res->appendChild(new DOMElement('dNomRec', $this->getDNomRec()));
        $res->appendChild(new DOMElement('dNomFanRec', $this->getDNomFanRec()));

        if ($this->iTiOpe == 2) {
            $res->appendChild(new DOMElement('dDirRec', $this->getDDirRec()));
            $res->appendChild(new DOMElement('dNumCasRec', $this->getDNumCasRec()));
        }

        $res->appendChild(new DOMElement('cDepRec', $this->getCDepRec()));
        $res->appendChild(new DOMElement('dDesDepRec', $this->getDDesDepRec()));
        $res->appendChild(new DOMElement('cDisRec', $this->getCDisRec()));
        $res->appendChild(new DOMElement('dDesDisRec', $this->getDDesDisRec()));
        $res->appendChild(new DOMElement('cCiuRec', $this->getCCiuRec()));
        $res->appendChild(new DOMElement('dDesCiuRec', $this->getDDesCiuRec()));
        if ($this->cPaisRec == "PRY") {
            ////Debe incluir el prefijo de la ciudad si D203 = PRY
            $res->appendChild(new DOMElement('dTelRec', $this->getDTelRec()));
        } else {
            $res->appendChild(new DOMElement('dTelRec', $this->getDTelRec()));
        }
        $res->appendChild(new DOMElement('dCelRec', $this->getDCelRec()));
        $res->appendChild(new DOMElement('dEmailRec', $this->getDEmailRec()));
        $res->appendChild(new DOMElement('dCodCliente', $this->getDCodCliente()));
        return $res;
    }
    
    
    /**
     * fromResponse
     *
     * @param  mixed $response
     * @return self
     */
    public static function fromResponse($response): self
    {
        $res = new GDatRec();
        if(isset($response->iNatRec)){
            $res->setINatRec(intval($response->iNatRec));
        }
        if (isset($response->iTiOpe)) {
            $res->setITiOpe(intval($response->iTiOpe));
        }
        if (isset($response->cPaisRec)) {
            $res->setCPaisRec($response->cPaisRec);
        }
        if (isset($response->iTiContRec)) {
            $res->setITiContRec(intval($response->iTiContRec));
        }
        if (isset($response->dRucRec)) {
            $res->setDRucRec($response->dRucRec);
        }
        if (isset($response->dDVRec)) {
            $res->setDDVRec(intval($response->dDVRec));
        }
        if (isset($response->iTipIDRec)) {
            $res->setITipIDRec(intval($response->iTipIDRec));
        }
        if (isset($response->dNumIDRec)) {
            $res->setDNumIDRec($response->dNumIDRec);
        }
        if (isset($response->dNomRec)) {
            $res->setDNomRec($response->dNomRec);
        }
        if (isset($response->dNomFanRec)) {
            $res->setDNomFanRec($response->dNomFanRec);
        }
        if (isset($response->dDirRec)) {
            $res->setDDirRec($response->dDirRec);
        }
        if (isset($response->dNumCasRec)) {
            $res->setDNumCasRec(intval($response->dNumCasRec));
        }
        if (isset($response->cDepRec)) {
            $res->setCDepRec(intval($response->cDepRec));
        }
        if (isset($response->cDisRec)) {
            $res->setCDisRec(intval($response->cDisRec));
        }
        if (isset($response->cCiuRec)) {
            $res->setCCiuRec(intval($response->cCiuRec));
        }
        if (isset($response->dTelRec)) {
            $res->setDTelRec($response->dTelRec);
        }
        if (isset($response->dCelRec)) {
            $res->setDCelRec($response->dCelRec);
        }
        if (isset($response->dEmailRec)) {
            $res->setDEmailRec($response->dEmailRec);
        }
        if (isset($response->dCodCliente)) {
            $res->setDCodCliente($response->dCodCliente);
        }
        return $res;
    }
}
