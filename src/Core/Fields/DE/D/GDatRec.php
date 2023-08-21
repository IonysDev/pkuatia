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
    public const NATURALEZA_CONTRIBUYENTE = 1;
    public const NATURALEZA_NO_CONTRIBUYENTE = 2;

    public const TIPO_OPERACION_B2B = 1;
    public const TIPO_OPERACION_B2C = 2;
    public const TIPO_OPERACION_B2G = 3;
    public const TIPO_OPERACION_B2F = 4;

    public const TIPO_CONTRIBUYENTE_PERSONA_FISICA = 1;
    public const TIPO_CONTRIBUYENTE_PERSONA_JURIDICA = 2;

    public const TIPO_DOCUMENTO_IDENTIDAD_CEDULA_PARAGUAYA = 1;
    public const TIPO_DOCUMENTO_IDENTIDAD_PASAPORTE = 2;
    public const TIPO_DOCUMENTO_IDENTIDAD_CEDULA_EXTRANJERA = 3;
    public const TIPO_DOCUMENTO_IDENTIDAD_CARNET_RESIDENCIA = 4;
    public const TIPO_DOCUMENTO_IDENTIDAD_INNOMINADO = 5;
    public const TIPO_DOCUMENTO_IDENTIDAD_TARJETA_DIPLOMATICA = 6;
    public const TIPO_DOCUMENTO_IDENTIDAD_OTRO = 9;

    public int    $iNatRec;     // D201 - 1     - 1-1 - Naturaleza del receptor: 1 = contribuyente | 2 = no contribuyente
    public int    $iTiOpe;      // D202 - 1     - 1-1 - Tipo de operación: 1 = B2B | 2 = B2C | 3 = B2G | 4 = B2F
    public String $cPaisRec;    // D203 - 3     - 1-1 - Código de país del receptor
    public String $dDesPaisRe;  // D204 - 4-30  - 1-1 - Descripción del país del receptor
    public int    $iTiContRec;  // D205 - 1     - 0-1 - Tipo de contribuyente receptor: 1 = Persona Física | 2 = Persona Jurídica
    public String $dRucRec;     // D206 - 3-8   - 0-1 - RUC del receptor
    public int    $dDVRec;      // D207 - 1     - 0-1 - Dígito verificador del RUC del receptor
    public int    $iTipIDRec;   // D208 - 1     - 0-1 - Tipo de documento de identidad del receptor: 1 = Cédula Paraguaya | 2 = Pasaporte | 3 = Cédula Extrangera | 4 = País de Residencia | 5 = Innominado | 6 = Tarjeta Diplomática | 9 = Otro
    public String $dDTipIDRec;  // D209 - 9-41  - 0-1 - Descripción del tipo de documento de identidad del receptor
    public String $dNumIDRec;   // D210 - 1-20  - 0-1 - Número de documento de identidad
    public String $dNomRec;     // D211 - 4-255 - 1-1 - Nombre o razón social del receptor del DE
    public String $dNomFanRec;  // D212 - 4-255 - 0-1 - Nombre de fantasía
    public String $dDirRec;     // D213 - 1-255 - 0-1 - Dirección del receptor
    public int    $dNumCasRec;  // D218 - 1-6   - 0-1 - Número de casa del receptor
    public int    $cDepRec;     // D219 - 1-2   - 0-1 - Código del departamento del receptor
    public String $dDesDepRec;  // D220 - 6-16  - 0-1 - Descripción del departamento del receptor
    public int    $cDisRec;     // D221 - 1-4   - 0-1 - Código del distrito del receptor
    public String $dDesDisRec;  // D222 - 1-30  - 0-1 - Descripción del distrito del receptor
    public int    $cCiuRec;     // D223 - 1-5   - 0-1 - Código del ciudad del receptor
    public String $dDesCiuRec;  // D224 - 1-30  - 0-1 - Descripción del ciudad del receptor
    public String $dTelRec;     // D214 - 6-15  - 0-1 - Número de teléfono del receptor
    public String $dCelRec;     // D215 - 10-20 - 0-1 - Número de celular del receptor
    public String $dEmailRec;   // D216 - 3-80  - 0-1 - Correo electrónico de receptor
    public String $dCodCliente; // D217 - 3-15  - 0-1 - Código del cliente

    /**
     * Constructor de la clase  
     * Inicializa los valores por defecto       
     *      > iNatRec = No contribuyente        
     *      > iTiOpe = B2C      
     *      > cPaisRec = PRY        
     *      > dDesPaisRe = Paraguay     
     *      > dNomRec = Sin Nombre      
     */
    public function __construct()
    {
        $this->iNatRec = self::NATURALEZA_NO_CONTRIBUYENTE;
        $this->iTiOpe = self::TIPO_OPERACION_B2C;
        $this->iTipIDRec = self::TIPO_DOCUMENTO_IDENTIDAD_INNOMINADO;
        $this->dNumIDRec = 0;
        $this->dNomRec = 'Sin Nombre';
        $this->cPaisRec = 'PRY';
        $this->dDesPaisRe = 'Paraguay';
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de iNatRec
     */
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
     * Devuelve el valor de dRucRec (D206 - RUC del receptor)
     *
     * @return String
     */
    public function getDRucRec(): String
    {
        if(isset($this->dRucRec))
            return $this->dRucRec;
        else
            return null;
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
        if(isset($this->dNumIDRec))
            return $this->dNumIDRec;
        else
            return null;
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
        $doc = new \DOMDocument();
        $res = $doc->createElement('gDatRec');
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
        if(isset($this->dNomFanRec))
            $res->appendChild(new DOMElement('dNomFanRec', $this->getDNomFanRec()));
        if(isset($this->dDirRec))
            $res->appendChild(new DOMElement('dDirRec', $this->getDDirRec()));
        if(isset($this->dNumCasRec))
            $res->appendChild(new DOMElement('dNumCasRec', $this->getDNumCasRec()));
        if(isset($this->cDepRec))
            $res->appendChild(new DOMElement('cDepRec', $this->getCDepRec()));
        if(isset($this->dDesDepRec))
            $res->appendChild(new DOMElement('dDesDepRec', $this->getDDesDepRec()));
        if(isset($this->cDisRec))
            $res->appendChild(new DOMElement('cDisRec', $this->getCDisRec()));
        if(isset($this->dDesDisRec))
            $res->appendChild(new DOMElement('dDesDisRec', $this->getDDesDisRec()));
        if(isset($this->cCiuRec))
            $res->appendChild(new DOMElement('cCiuRec', $this->getCCiuRec()));
        if(isset($this->dDesCiuRec))
            $res->appendChild(new DOMElement('dDesCiuRec', $this->getDDesCiuRec()));
        if(isset($this->dTelRec))
            $res->appendChild(new DOMElement('dTelRec', $this->getDTelRec()));
        if(isset($this->dCelRec))
            $res->appendChild(new DOMElement('dCelRec', $this->getDCelRec()));
        if(isset($this->dEmailRec))
            $res->appendChild(new DOMElement('dEmailRec', $this->getDEmailRec()));
        if(isset($this->dCodCliente))
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
