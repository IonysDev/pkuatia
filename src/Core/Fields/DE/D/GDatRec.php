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

    public ?int $iNatRec; // Naturaleza del receptor (D201): 1 = contribuyente | 2 = no contribuyente
    public ?int $iTiOpe; // Tipo de operación (D202): 1 = B2B | 2 = B2C | 3 = B2G | 4 = B2F
    public String $cPaisRec; // Código de país del receptor (D203)
    public String $dDesPaisRe; // Descripción del país del receptor (D204)
    public ?int $iTiContRec; // Tipo de contribuyente receptor (D205): 1 = Persona Física | 2 = Persona Jurídica
    public String $dRucRec; // RUC del receptor (D206)
    public ?int $dDVRec; // Dígito verificador del RUC del receptor (D207)
    public ?int $iTipIDRec; // Tipo de documento de identidad del receptor (D208): 1 = Cédula Paraguaya | 2 = Pasaporte | 3 = Cédula Extrangera | 4 = País de Residencia | 5 = Innominado | 6 = Tarjeta Diplomática | 9 = Otro
    public ?String $dDTipIDRec; // Descripción del tipo de documento de identidad del receptor (D209)
    public String $dNumIDRec; // Número de documento de identidad (D210)
    public String $dNomRec; // Nombre o razón social del receptor del DE (D211)
    public String $dNomFanRec; // Nombre de fantasía (D212)
    public String $dDirRec; // Dirección del receptor (D213)
    public ?int $dNumCasRec; // Número de casa del receptor (D218)
    public ?int $cDepRec; // Código del departamento del receptor (D219)
    public ?String $dDesDepRec; // Descripción del departamento del receptor (D220)
    public ?int $cDisRec; // Código del distrito del receptor (D221)
    public ?String $dDesDisRec; // Descripción del distrito del receptor (D222)
    public ?int $cCiuRec; // Código del ciudad del receptor (D223)
    public ?String $dDesCiuRec; // Descripción del ciudad del receptor (D224)
    public String $dTelRec; // Número de teléfono del receptor (D214)
    public String $dCelRec; // Número de celular del receptor (D215)
    public String $dEmailRec; // Correo electrónico de receptor (D216)
    public String $dCodCliente; // Código del cliente (D217)

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

    public function setCPaisRec(String $cPaisRec): void
    {
        $this->cPaisRec = $cPaisRec;
    }

    public function setDDesPaisRe(String $dDesPaisRe): void
    {
        $this->dDesPaisRe = $dDesPaisRe;
    }

    public function setITiContRec(int $iTiContRec): void
    {
        $this->iTiContRec = $iTiContRec;
    }

    public function setDRucRec(String $dRucRec): void
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

    public function setDDTipIDRec(String $dDTipIDRec): void
    {
        $this->dDTipIDRec = $dDTipIDRec;
    }

    public function setDNumIDRec(String $dNumIDRec): void
    {
        $this->dNumIDRec = $dNumIDRec;
    }

    public function setDNomRec(String $dNomRec): void
    {
        $this->dNomRec = $dNomRec;
    }

    public function setDNomFanRec(String $dNomFanRec): void
    {
        $this->dNomFanRec = $dNomFanRec;
    }

    public function setDDirRec(String $dDirRec): void
    {
        $this->dDirRec = $dDirRec;
    }

    public function setDTelRec(String $dTelRec): void
    {
        $this->dTelRec = $dTelRec;
    }

    public function setDCelRec(String $dCelRec): void
    {
        $this->dCelRec = $dCelRec;
    }

    public function setDEmailRec(String $dEmailRec): void
    {
        $this->dEmailRec = $dEmailRec;
    }

    public function setDCodCliente(String $dCodCliente): void
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

    public function setDDesDepRec(String $dDesDepRec): self
    {
        $this->dDesDepRec = $dDesDepRec;
        return $this;
    }

    public function setCDisRec(int $cDisRec): self
    {
        $this->cDisRec = $cDisRec;

        return $this;
    }

    public function setDDesDisRec(String $dDesDisRec): self
    {
        $this->dDesDisRec = $dDesDisRec;

        return $this;
    }

    public function setCCiuRec(int $cCiuRec): self
    {
        $this->cCiuRec = $cCiuRec;

        return $this;
    }

    public function setDDesCiuRec(String $dDesCiuRec): self
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
    public function getINatRec(): int
    {
        return $this->iNatRec;
    }

    /**
     * Get the value of iTiOpe
     */
    public function getITiOpe() : int
    {
        return $this->iTiOpe;
    }

    /**
     * Get the value of cPaisRec
     *
     * @return String
     */
    public function getCPaisRec(): String
    {
        return $this->cPaisRec;
    }

    /**
     * D204 dDesPaisRe Descripción del país receptor
     *
     * @return String
     */
    public function getDDesPaisRe(): String
    {
        // return CountryHelper::getCountryDesc($this->cPaisRec);
        return $this->dDesPaisRe;
    }


    /**
     * Get the value of iTiContRec
     */
    public function getITiContRec() : int
    {
        return $this->iTiContRec;
    }

    /**
     * Get the value of dRucRec
     *
     * @return String
     */
    public function getDRucRec(): String
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
    public function getITipIDRec() : int
    {
        return $this->iTipIDRec;
    }

    /**
     * getDDTipIDRec
     *
     * @return String
     */
    public function getDDTipIDRec(): String
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
     * @return String
     */
    public function getDNumIDRec(): String
    {
        return $this->dNumIDRec;
    }

    /**
     * Get the value of dNomRec
     *
     * @return String
     */
    public function getDNomRec(): String
    {
        return $this->dNomRec;
    }

    /**
     * Get the value of dNomFanRec
     *
     * @return String
     */
    public function getDNomFanRec(): String
    {
        return $this->dNomFanRec;
    }

    /**
     * Get the value of dDirRec 
     *
     * @return String
     */
    public function getDDirRec(): String
    {
        return $this->dDirRec;
    }

    /**
     * Get the value of dTelRec
     *
     * @return String
     */
    public function getDTelRec(): String
    {
        return $this->dTelRec;
    }

    /**
     * Get the value of dCelRec
     *
     * @return String
     */
    public function getDCelRec(): String
    {
        return $this->dCelRec;
    }

    /**
     * Get the value of dEmailRec
     *
     * @return String
     */
    public function getDEmailRec(): String
    {
        return $this->dEmailRec;
    }

    /**
     * Get the value of dCodCliente
     *
     * @return String
     */
    public function getDCodCliente(): String
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
     * @return String
     */
    public function getDDesDepRec(): String
    {
        return DepartamentoHelper::getDepName(strval($this->cDepRec));
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
     * @return String
     */
    public function getDDesDisRec(): String
    {
        return GeoRefCodesHelper::getDistName(strval($this->cDisRec));
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
     * @return String
     */
    public function getDDesCiuRec(): String
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
     * FromSifenResponseObject
     *
     * @param  mixed $object
     * @return self
     */
    public static function FromSifenResponseObject($object): self
    {
        $res = new GDatRec();
        if(isset($object->iNatRec)){
            $res->setINatRec(intval($object->iNatRec));
        }
        if (isset($object->iTiOpe)) {
            $res->setITiOpe(intval($object->iTiOpe));
        }
        if (isset($object->cPaisRec)) {
            $res->setCPaisRec($object->cPaisRec);
        }
        if (isset($object->iTiContRec)) {
            $res->setITiContRec(intval($object->iTiContRec));
        }
        if (isset($object->dRucRec)) {
            $res->setDRucRec($object->dRucRec);
        }
        if (isset($object->dDVRec)) {
            $res->setDDVRec(intval($object->dDVRec));
        }
        if (isset($object->iTipIDRec)) {
            $res->setITipIDRec(intval($object->iTipIDRec));
        }
        if (isset($object->dNumIDRec)) {
            $res->setDNumIDRec($object->dNumIDRec);
        }
        if (isset($object->dNomRec)) {
            $res->setDNomRec($object->dNomRec);
        }
        if (isset($object->dNomFanRec)) {
            $res->setDNomFanRec($object->dNomFanRec);
        }
        if (isset($object->dDirRec)) {
            $res->setDDirRec($object->dDirRec);
        }
        if (isset($object->dNumCasRec)) {
            $res->setDNumCasRec(intval($object->dNumCasRec));
        }
        if (isset($object->cDepRec)) {
            $res->setCDepRec(intval($object->cDepRec));
        }
        if (isset($object->cDisRec)) {
            $res->setCDisRec(intval($object->cDisRec));
        }
        if (isset($object->cCiuRec)) {
            $res->setCCiuRec(intval($object->cCiuRec));
        }
        if (isset($object->dTelRec)) {
            $res->setDTelRec($object->dTelRec);
        }
        if (isset($object->dCelRec)) {
            $res->setDCelRec($object->dCelRec);
        }
        if (isset($object->dEmailRec)) {
            $res->setDEmailRec($object->dEmailRec);
        }
        if (isset($object->dCodCliente)) {
            $res->setDCodCliente($object->dCodCliente);
        }
        return $res;
    }
}
