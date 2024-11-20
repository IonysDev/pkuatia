<?php

namespace IonysDev\Pkuatia\Core\Fields\Request\Event\GDE;

use IonysDev\Pkuatia\Core\Constants\EmisRecTipCont;
use IonysDev\Pkuatia\Core\Constants\RecNat;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo: GENFE001 - rGEveNom - Grupos de Campos Generales del Evento 
 * Padre: GDE007 - gGroupTiEvt - Grupo de campos del tipo de evento
 */
class RGEveNom
{
                                // ID       - DESCRIPCION                                      - LONGITUD   - OCURRENCIA
     public string $id;         // GENFE002 - Identificador del DTE                            - 44         - 1-1
     public string $mOtEve;     // GENFE003 - Motivo del evento                                - 5-500      - 1-1
     public int    $iNatRec;    // GENFE004 - Naturaleza del receptor                          - 1          - 1-1
     public int    $iTiOpe;     // GENFE027 - Tipo de operación                                - 1          - 1-1
     public string $cPaisRec;   // GENFE005 - Código de país del receptor                      - 3          - 1-1
     public string $dDesPaisRe; // GENFE006 - Descripción del país receptor                    - 4-50       - 1-1
     public int    $iTiContRec; // GENFE007 - Tipo de contribuyente receptor                   - 1          - 0-1
     public string $dRucRec;    // GENFE008 - RUC del receptor                                 - 3-8        - 0-1
     public int    $dDVRec;     // GENFE009 - Dígito verificador  del RUC del receptor         - 1          - 0-1
     public int    $iTipIDRec;  // GENFE010 - Tipo de documento de identidad del receptor      - 1          - 0-1
     public string $dDTipIDRec; // GENFE011 - Descripción del tipo de documento de identidad   - 9-41       - 0-1
     public string $dNumIDRec;  // GENFE012 - Número de documento de identidad                 - 1-15       - 0-1
     public string $dNomRec;    // GENFE013 - Nombre o razón  social del receptor del DTE      - 4-255      - 1-1
     public string $dNomFanRec; // GENFE014 - Nombre de fantasía                               - 4-255      - 0-1
     public string $dDirRec;    // GENFE015 - Dirección del receptor                           - 1-255      - 0-1
     public int    $dNumCasRec; // GENFE016 - Número de casa del receptor                      - 1-6        - 0-1
     public int    $cDepRec;    // GENFE017 - Código de departamento del receptor              - 1-2        - 0-1
     public string $dDesDepRec; // GENFE018 - Descripción del departamento del receptor        - 6-16       - 0-1
     public int    $cDisRec;    // GENFE019 - Código de distrito del receptor                  - 1-4        - 0-1
     public string $dDesDisRec; // GENFE020 - Descripción del distrito del receptor            - 1-30       - 0-1
     public int    $cCiuRec;    // GENFE021 - Código de ciudad del receptor                    - 1-5        - 0-1
     public string $dDesCiuRec; // GENFE022 - Descripción de la ciudad del receptor            - 1-30       - 0-1
     public string $dTelRec;    // GENFE023 - Número de teléfono del receptor                  - 6-15       - 0-1 
     public string $dCelRec;    // GENFE024 - Número de celular del receptor                   - 10-20      - 0-1
     public string $dEmailRec;  // GENFE025 - Correo electrónico del receptor                  - 3-80       - 0-1
     public string $dCodCliente;// GENFE026 - Código de cliente                                - 3-15       - 0-1

    public const NATURALEZA_CONTRIBUYENTE = 1;
    public const NATURALEZA_NO_CONTRIBUYENTE = 2;

    public const TIPO_OPERACION_B2B = 1;
    public const TIPO_OPERACION_B2C = 2;
    public const TIPO_OPERACION_B2G = 3;
    public const TIPO_OPERACION_B2F = 4;

    public const TIPO_OPERACION_DESCRIPCIONES = [
        self::TIPO_OPERACION_B2B => 'B2B - Negocio a Negocio',
        self::TIPO_OPERACION_B2C => 'B2C - Negocio a Consumidor Final',
        self::TIPO_OPERACION_B2G => 'B2G - Negocio a Gobierno',
        self::TIPO_OPERACION_B2F => 'B2F - Negocio a Financiero',
    ];

    public const TIPO_CONTRIBUYENTE_PERSONA_FISICA = 1;
    public const TIPO_CONTRIBUYENTE_PERSONA_JURIDICA = 2;

    public const TIPO_DOCUMENTO_IDENTIDAD_CEDULA_PARAGUAYA = 1;
    public const TIPO_DOCUMENTO_IDENTIDAD_PASAPORTE = 2;
    public const TIPO_DOCUMENTO_IDENTIDAD_CEDULA_EXTRANJERA = 3;
    public const TIPO_DOCUMENTO_IDENTIDAD_CARNET_RESIDENCIA = 4;
    public const TIPO_DOCUMENTO_IDENTIDAD_INNOMINADO = 5;
    public const TIPO_DOCUMENTO_IDENTIDAD_TARJETA_DIPLOMATICA = 6;
    public const TIPO_DOCUMENTO_IDENTIDAD_OTRO = 9;
    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de id - Identificador del DTE
     *
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Establece el valor de mOtEve - Motivo del evento
     *
     * @param string $mOtEve
     *
     * @return self
     */
    public function setMOtEve(string $mOtEve): self
    {
        $this->mOtEve = $mOtEve;
        return $this;
    }

    /**
     * Establece el valor de iNatRec - Naturaleza del receptor
     *
     * @param int $iNatRec
     *
     * @return self
     */
    public function setINatRec(int|RecNat $iNatRec): self
    {
        $this->iNatRec = $iNatRec instanceof RecNat ? $iNatRec->value : $iNatRec;
        if($this->iNatRec == self::NATURALEZA_CONTRIBUYENTE) {
            unset($this->iTipIDRec);
            unset($this->dDTipIDRec);
            unset($this->dNumIDRec);
        }
        else {
            unset($this->dRucRec);
            unset($this->dDVRec);
        }
        return $this;
    }

    /**
     * Establece el valor de iTiOpe - Tipo de operación
     *
     * @param int $iTiOpe
     *
     * @return self
     */
    public function setITiOpe(int|RecTiOpe $iTiOpe): void
    {
        $this->iTiOpe = $iTiOpe instanceof RecTiOpe ? $iTiOpe->value : $iTiOpe;
    }

    /**
     * Establece el valor de cPaisRec - Código de país del receptor
     *
     * @param string $cPaisRec
     *
     * @return self
     */
    public function setCPaisRec(string $cPaisRec): self
    {
        $this->cPaisRec = $cPaisRec;
        return $this;
    }

    /**
     * Establece el valor de dDesPaisRe - Descripción del país receptor
     *
     * @param string $dDesPaisRe
     *
     * @return self
     */
    public function setDDesPaisRe(string $dDesPaisRe): self
    {
        $this->dDesPaisRe = $dDesPaisRe;
        return $this;
    }

    /**
     * Establece el valor de iTiContRec - Tipo de contribuyente receptor
     *
     * @param int $iTiContRec
     *
     * @return self
     */
    public function setITiContRec(int|EmisRecTipCont $iTiContRec): void
    {
        $this->iTiContRec = $iTiContRec instanceof EmisRecTipCont ? $iTiContRec->value : $iTiContRec;
    }

    /**
     * Establece el valor de dRucRec - RUC del receptor
     *
     * @param string $dRucRec
     *
     * @return self
     */
    public function setDRucRec(string $dRucRec): self
    {
        $this->dRucRec = $dRucRec;
        return $this;
    }

    /**
     * Establece el valor de dDVRec - Dígito verificador  del RUC del receptor
     *
     * @param int $dDVRec
     *
     * @return self
     */
    public function setDDVRec(int $dDVRec): self
    {
        $this->dDVRec = $dDVRec;
        return $this;
    }

    /**
     * Establece el valor de iTipIDRec - Tipo de documento de identidad del receptor
     *
     * @param int $iTipIDRec
     *
     * @return self
     */
    public function setITipIDRec(int|TipIDRec $iTipIDRec): self
    {
        $this->iTipIDRec = $iTipIDRec instanceof TipIDRec ? $iTipIDRec->value : $iTipIDRec;
        $this->dDTipIDRec = $iTipIDRec instanceof TipIDRec ? $iTipIDRec : TipIDRec::getDescripcion($iTipIDRec);
        return $this;
    }

    /**
     * Establece el valor de dDTipIDRec - Descripción del tipo de documento de identidad
     *
     * @param string $dDTipIDRec
     *
     * @return self
     */
    public function setDDTipIDRec(string $dDTipIDRec): self
    {
        $this->dDTipIDRec = $dDTipIDRec;
        return $this;
    }

    /**
     * Establece el valor de dNumIDRec - Número de documento de identidad
     *
     * @param string $dNumIDRec
     *
     * @return self
     */
    public function setDNumIDRec(string $dNumIDRec): self
    {
        $this->dNumIDRec = $dNumIDRec;
        return $this;
    }

    /**
     * Establece el valor de dNomRec - Nombre o razón  social del receptor del DTE
     *
     * @param string $dNomRec
     *
     * @return self
     */
    public function setDNomRec(string $dNomRec): self
    {
        $this->dNomRec = $dNomRec;
        return $this;
    }

    /**
     * Establece el valor de dNomFanRec - Nombre de fantasía
     *
     * @param string $dNomFanRec
     *
     * @return self
     */
    public function setDNomFanRec(string $dNomFanRec): self
    {
        $this->dNomFanRec = $dNomFanRec;
        return $this;
    }

    /**
     * Establece el valor de dDirRec - Dirección del receptor
     *
     * @param string $dDirRec
     *
     * @return self
     */
    public function setDDirRec(string $dDirRec): self
    {
        $this->dDirRec = $dDirRec;
        return $this;
    }

    /**
     * Establece el valor de dNumCasRec - Número de casa del receptor
     *
     * @param int $dNumCasRec
     *
     * @return self
     */
    public function setDNumCasRec(int $dNumCasRec): self
    {
        $this->dNumCasRec = $dNumCasRec;
        return $this;
    }

    /**
     * Establece el valor de cDepRec - Código de departamento del receptor
     *
     * @param int $cDepRec
     *
     * @return self
     */
    public function setCDepRec(int $cDepRec): void
    {
        $this->cDepRec = $cDepRec;
        if(!is_null($cDepRec)) {
            $this->dDesDepRec = DepartamentoMapping::getDepName(strval($this->cDepRec));
        }
    }

    
    /**
     * Establece el valor de dDesDepRec - Descripción del departamento del receptor
     *
     * @param string $dDesDepRec
     *
     * @return self
     */
    public function setDDesDepRec(String $dDesDepRec): self
    {
        $this->dDesDepRec = $dDesDepRec;
        return $this;
    }

    /**
     * Establece el valor de cDisRec - Código de distrito del receptor
     *
     * @param int $cDisRec
     *
     * @return self
     */
    public function setDDesDisRec(String $dDesDisRec): self
    {
        $this->dDesDisRec = $dDesDisRec;
        return $this;
    }

    /**
     * Establece el valor de cDisRec - Código de distrito del receptor
     *
     * @param int $cDisRec
     *
     * @return self
     */
    public function setCCiuRec(int $cCiuRec): self
    {
        $this->cCiuRec = $cCiuRec;
        if(!is_null($cCiuRec)) {
            $this->dDesCiuRec = PyGeoCodesMapping::getCiudName(strval($this->cCiuRec));
        }
        return $this;
    }

    /**
     * Establece el valor de dDesCiuRec - Descripción de la ciudad del receptor
     *
     * @param string $dDesCiuRec
     *
     * @return self
     */
    public function setDDesCiuRec(String $dDesCiuRec): self
    {
        $this->dDesCiuRec = $dDesCiuRec;
        return $this;
    }

    /**
     * Establece el valor de dTelRec - Número de teléfono del receptor
     *
     * @param string $dTelRec
     *
     * @return self
     */
    public function setDTelRec(String $dTelRec): self
    {
        $this->dTelRec = $dTelRec;
        return $this;
    }

    /**
     * Establece el valor de dCelRec - Número de celular del receptor
     *
     * @param string $dCelRec
     *
     * @return self
     */
    public function setDCelRec(String $dCelRec): self
    {
        $this->dCelRec = $dCelRec;
        return $this;
    }

    /**
     * Establece el valor de dEmailRec - Correo electrónico del receptor
     *
     * @param string $dEmailRec
     *
     * @return self
     */
    public function setDEmailRec(String $dEmailRec): self
    {
        $this->dEmailRec = $dEmailRec;
        return $this;
    }

    /**
     * Establece el valor de dCodCliente - Código de cliente
     *
     * @param string $dCodCliente
     *
     * @return self
     */
    public function setDCodCliente(String $dCodCliente): self
    {
        $this->dCodCliente = $dCodCliente;
        return $this;
    }

    
    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////
     
    /**
     * Obtiene el valor de id - Identificador del DTE
     *
     * @return string
     */
    public function getId(): ?string
    {
        if(isset($this->id))
            return $this->id;
        else
            return null;
    }

    /**
     * Obtiene el valor de mOtEve - Motivo del evento
     *
     * @return string
     */
    public function getMOtEve(): ?string
    {
        if(isset($this->mOtEve))
            return $this->mOtEve;
        else
            return null;
    }

    /**
     * Obtiene el valor de iNatRec
     */
    public function getINatRec(): ?int
    {
    if(isset($this->iNatRec))
        return $this->iNatRec;
    else
        return null;
    }

    
    /**
     * Obtiene el valor de iTiOpe
     */
    public function getITiOpe() : ?int
    {
        if(isset($this->iTiOpe))
            return $this->iTiOpe;
        else
            return null;
    }

        /**
     * Obtiene el valor de cPaisRec
     *
     * @return String
     */
    public function getCPaisRec(): ?String
    {
        if(isset($this->cPaisRec))
            return $this->cPaisRec;
        else
            return null;
    }

    /**
     * D204 dDesPaisRe Descripción del país receptor
     *
     * @return String
     */
    public function getDDesPaisRe(): ?String
    {
        if(isset($this->dDesPaisRe))
            return $this->dDesPaisRe;
        else
            return null;
    }

        /**
     * Obtiene el valor de iTiContRec
     */
    public function getITiContRec() : ?int
    {
        if(isset($this->iTiContRec))
            return $this->iTiContRec;
        else
            return null;
    }       

    /**
     * Devuelve el valor de dRucRec (D206 - RUC del receptor)
     *
     * @return String
     */
    public function getDRucRec(): ?String
    {
        if(isset($this->dRucRec))
            return $this->dRucRec;
        else
            return null;
    }

    /**
     * Obtiene el valor de dDVRec
     *
     * @return int
     */
    public function getDDVRec(): ?int
    {
        return $this->dDVRec;
    }

    /**
     * Obtiene el valor de iTipIDRec
     */
    public function getITipIDRec() : ?int
    {
        if(isset($this->iTipIDRec))
            return $this->iTipIDRec;
        else
            return null;
    }

      /**
     * getDDTipIDRec
     *
     * @return String
     */
    public function getDDTipIDRec(): ?String
    {
        if(isset($this->iTipIDRec)) {
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
        else
            return null;
    }

     /**
     * Obtiene el valor de dNumIDRec
     *
     * @return String
     */
    public function getDNumIDRec(): ?String
    {
        if(isset($this->dNumIDRec))
            return $this->dNumIDRec;
        else
            return null;
    }

    /**
     * Obtiene el valor de dNomRec
     *
     * @return String
     */
    public function getDNomRec(): String
    {
        return $this->dNomRec;
    }

    /**
     * Obtiene el valor de dNomFanRec
     *
     * @return String
     */
    public function getDNomFanRec(): ?String
    {
        if(isset($this->dNomFanRec))
            return $this->dNomFanRec;
        else
            return null;
    }

    /**
     * Obtiene el valor de dDirRec 
     *
     * @return String
     */
    public function getDDirRec(): ?String
    {
        if(isset($this->dDirRec))
            return $this->dDirRec;
        else
            return null;
    }

    /**
     * Obtiene el valor de dTelRec
     *
     * @return String
     */
    public function getDTelRec(): String
    {
        return $this->dTelRec;
    }

    /**
     * Obtiene el valor de dCelRec
     *
     * @return String
     */
    public function getDCelRec(): String
    {
        return $this->dCelRec;
    }

    /**
     * Obtiene el valor de dEmailRec
     *
     * @return String
     */
    public function getDEmailRec(): String
    {
        return $this->dEmailRec;
    }

    /**
     * Obtiene el valor de dCodCliente
     *
     * @return String
     */
    public function getDCodCliente(): String
    {
        return $this->dCodCliente;
    }

    /**
     * Obtiene el valor de dNumCasRec
     *
     * @return int
     */
    public function getDNumCasRec(): int
    {
        return $this->dNumCasRec;
    }

    /**
     * Obtiene el valor de cDepRec
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
        return $this->dDesDepRec;
    }

    /**
     * Obtiene el valor de cDisRec
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
        return PyGeoCodesMapping::getDistName(strval($this->cDisRec));
    }


    /**
     * Obtiene el valor de cCiuRec
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
        return PyGeoCodesMapping::getCiudName(strval($this->cCiuRec));
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversiones XML
    ///////////////////////////////////////////////////////////////////////

    
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGEveNom');

    $res->appendChild($doc->createElement('id', $this->getId()));
    $res->appendChild($doc->createElement('mOtEve', $this->getMOtEve()));
    $res->appendChild($doc->createElement('iNatRec', $this->getINatRec()));
    $res->appendChild($doc->createElement('iTiOpe', $this->getITiOpe()));
    $res->appendChild($doc->createElement('cPaisRec', $this->getCPaisRec()));
    $res->appendChild($doc->createElement('dDesPaisRe', $this->getDDesPaisRe()));

    if($this->iNatRec == 1)
    {
      $res->appendChild($doc->createElement('iTiContRec', $this->getITiContRec()));
      $res->appendChild($doc->createElement('dRucRec', $this->getDRucRec()));
    }

    if($this->dDVRec)
    {
      $res->appendChild($doc->createElement('dDVRec', $this->getDDVRec()));
    }

    if($this->iNatRec == 2)
    {
        $res->appendChild($doc->createElement('iTipIDRec', $this->getITipIDRec()));
        $res->appendChild($doc->createElement('dNumIDRec', $this->getDNumIDRec()));
    }

    if($this->iTipIDRec)
    {
      $res->appendChild($doc->createElement('dDTipIDRec', $this->getDDTipIDRec()));
    }

    $res->appendChild($doc->createElement('dNomRec', $this->getDNomRec()));
    $res->appendChild($doc->createElement('dNomFanRec', $this->getDNomFanRec()));
    $res->appendChild($doc->createElement('dDirRec', $this->getDDirRec()));

    if($this->dDirRec)
    {
      $res->appendChild($doc->createElement('dNumCasRec', $this->getDNumCasRec()));
    }

    $res->appendChild($doc->createElement('cDepRec', $this->getCDepRec()));
    $res->appendChild($doc->createElement('dDesDepRec', $this->getDDesDepRec()));
    $res->appendChild($doc->createElement('cDisRec', $this->getCDisRec()));

    if($this->cDisRec)
    {
      $res->appendChild($doc->createElement('dDesDisRec', $this->getDDesDisRec()));
    }

    $res->appendChild($doc->createElement('cCiuRec', $this->getCCiuRec()));
    $res->appendChild($doc->createElement('dDesCiuRec', $this->getDDesCiuRec()));

    $res->appendChild($doc->createElement('dTelRec', $this->getDTelRec()));
    $res->appendChild($doc->createElement('dCelRec', $this->getDCelRec()));
    $res->appendChild($doc->createElement('dEmailRec', $this->getDEmailRec()));
    $res->appendChild($doc->createElement('dCodCliente', $this->getDCodCliente()));

    return $res;

  }

    /**
     * FromSimpleXMLElement
     *
     * @param  SimpleXMLElement $node
     * @return self
     */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if (strcmp($node->getName(), 'rGEveNom') != 0) {
        throw new \Exception("Invalid XML Element: $node->getName()");
        return null;
    }

    $res = new self();
    $res->setId(strval($node->Id));
    $res->setMOtEve(intval($node->mOtEve));

    if(isset($node->iNatRec))
    {
      $res->setINatRec(intval($node->iNatRec));
    }

    if(isset($node->iTiOpe))
    {
      $res->setITiOpe(intval($node->iTiOpe));
    }

    if(isset($node->cPaisRec))
    {
      $res->setCPaisRec(strval($node->cPaisRec));
    }

    if(isset($node->dDesPaisRe))
    {
      $res->setDDesPaisRe(strval($node->dDesPaisRe));
    }

    if(isset($node->iTiContRec))
    {
      $res->setITiContRec(intval($node->iTiContRec));
    }

    if(isset($node->dRucRec))
    {
      $res->setDRucRec(strval($node->dRucRec));
    }

    if(isset($node->dDVRec))
    {
      $res->setDDVRec(intval($node->dDVRec));
    }

    if(isset($node->iTipIDRec))
    {
      $res->setITipIDRec(intval($node->iTipIDRec));
    }

    if(isset($node->dDTipIDRec))
    {
      $res->setDDTipIDRec(strval($node->dDTipIDRec));
    }

    if(isset($node->dNumIDRec))
    {
      $res->setDNumIDRec(strval($node->dNumIDRec));
    }

    if(isset($node->dNomRec))
    {
      $res->setDNomRec(strval($node->dNomRec));
    }

    if(isset($node->dNomFanRec))
    {
      $res->setDNomFanRec(strval($node->dNomFanRec));
    }

    if(isset($node->dDirRec))
    {
      $res->setDDirRec(strval($node->dDirRec));
    }

    if(isset($node->dNumCasRec))
    {
      $res->setDNumCasRec(intval($node->dNumCasRec));
    }

    if(isset($node->cDepRec))
    {
      $res->setCDepRec(intval($node->cDepRec));
    }

    if(isset($node->dDesDepRec))
    {
      $res->setDDesDepRec(strval($node->dDesDepRec));
    }

    if(isset($node->cDisRec))
    {
      $res->setCCiuRec(intval($node->cDisRec));
    }

    if(isset($node->dDesDisRec))
    {
      $res->setDDesDisRec(strval($node->dDesDisRec));
    }

    if(isset($node->cCiuRec))
    {
      $res->setCCiuRec(intval($node->cCiuRec));
    }

    if(isset($node->dDesCiuRec))
    {
      $res->setDDesCiuRec(strval($node->dDesCiuRec));
    }

    if(isset($node->dTelRec))
    {
      $res->setDTelRec(strval($node->dTelRec));
    }

    if(isset($node->dCelRec))
    {
      $res->setDCelRec(strval($node->dCelRec));
    }

    if(isset($node->dEmailRec))
    {
      $res->setDEmailRec(strval($node->dEmailRec));
    }

    if(isset($node->dCodCliente))
    {
      $res->setDCodCliente(strval($node->dCodCliente));
    }

    return $res;

  }
}

