<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits;

use DateTime;
use Exception;
use IonysDev\Pkuatia\Core\Constants\GTranspModTrans;
use IonysDev\Pkuatia\Core\Constants\GTranspRespFlete;
use IonysDev\Pkuatia\Core\Constants\GTranspTipTrans;
use IonysDev\Pkuatia\Core\Constants\Incoterm;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamEnt;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamSal;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamTrans;
use IonysDev\Pkuatia\Core\Fields\DE\E\GTransp;
use IonysDev\Pkuatia\Core\Fields\DE\E\GVehTras;

/**
 * Trait que proporciona métodos amigables para establecer los campos de transporte de mercaderías.
 * 
 * Este trait facilita la configuración de los campos relacionados con el transporte (E900-E999)
 * de manera más intuitiva y con mejor soporte para intellisense.
 * 
 * @see GTransp Para más información sobre la estructura de datos de transporte
 */
trait CamposDeTransporte
{
    ///////////////////////////////////////////////////////////////////////
    // Métodos principales para establecer transporte
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece los campos básicos del transporte de mercaderías.
     * 
     * Este método inicializa el objeto GTransp y establece los campos obligatorios.
     * Para Nota de Remisión (C002=7), el campo iTipTrans es obligatorio.
     * 
     * @param int|GTranspModTrans $modalidadTransporte Modalidad de transporte (E903). Obligatorio.
     *                                                   1=Terrestre, 2=Fluvial, 3=Aéreo, 4=Multimodal
     * @param int|GTranspRespFlete $responsableFlete Responsable del costo del flete (E905). Obligatorio.
     *                                                 1=Emisor, 2=Receptor, 3=Tercero, 4=Agente intermediario, 5=Transporte propio
     * @param int|GTranspTipTrans|null $tipoTransporte Tipo de transporte (E901). Opcional para Facturas, obligatorio para Nota de Remisión.
     *                                                 1=Propio, 2=Tercero
     * 
     * @return self
     * 
     * @throws Exception Si el objeto gTransp no puede ser inicializado
     */
    public function setTransporte(
        int|GTranspModTrans $modalidadTransporte,
        int|GTranspRespFlete $responsableFlete,
        int|GTranspTipTrans|null $tipoTransporte = null
    ): self {
        if (!isset($this->gTransp)) {
            $this->gTransp = new GTransp();
        }

        $this->gTransp->setIModTrans($modalidadTransporte);
        $this->gTransp->setIRespFlete($responsableFlete);

        if ($tipoTransporte !== null) {
            $this->gTransp->setITipTrans($tipoTransporte);
        }

        return $this;
    }

    /**
     * Establece la condición de negociación (INCOTERM) del transporte.
     * 
     * Valor OPCIONAL. Se utiliza para indicar las condiciones de entrega según los términos comerciales internacionales.
     * 
     * @param String|Incoterm $incoterm Código del INCOTERM (E906). Ejemplos: FOB, CIF, EXW, etc.
     * 
     * @return self
     */
    public function setTransporteIncoterm(String|Incoterm $incoterm): self
    {
        $this->ensureGTransp();
        $this->gTransp->setCCondNeg($incoterm);
        return $this;
    }

    /**
     * Establece el número de manifiesto o conocimiento de carga.
     * 
     * Valor OPCIONAL. Campo abierto para informar la numeración de manifiesto, conocimiento de carga,
     * declaración de tránsito aduanero o carta de porte internacional.
     * 
     * @param String $numeroManifiesto Número de manifiesto o conocimiento de carga (E907). Máximo 15 caracteres.
     * 
     * @return self
     */
    public function setTransporteNumeroManifiesto(String $numeroManifiesto): self
    {
        $this->ensureGTransp();
        $this->gTransp->setDNuManif($numeroManifiesto);
        return $this;
    }

    /**
     * Establece el número de despacho de importación.
     * 
     * Valor OPCIONAL. Obligatorio si el motivo de emisión de la Nota de Remisión es Importación (E501=5).
     * 
     * @param String $numeroDespacho Número de despacho de importación (E908). Exactamente 16 caracteres.
     * 
     * @return self
     */
    public function setTransporteNumeroDespachoImportacion(String $numeroDespacho): self
    {
        $this->ensureGTransp();
        $this->gTransp->setDNuDespImp($numeroDespacho);
        return $this;
    }

    /**
     * Establece las fechas estimadas de inicio y fin del traslado.
     * 
     * Para Nota de Remisión (C002=7), la fecha de inicio es obligatoria.
     * Si se establece la fecha de inicio, la fecha de fin también debe establecerse.
     * 
     * @param DateTime $fechaInicio Fecha estimada de inicio de traslado (E909). Formato: Y-m-d
     * @param DateTime|null $fechaFin Fecha estimada de fin de traslado (E910). Obligatorio si se establece fechaInicio.
     * 
     * @return self
     * 
     * @throws Exception Si se establece fechaInicio pero no fechaFin
     */
    public function setTransporteFechasTraslado(DateTime $fechaInicio, ?DateTime $fechaFin = null): self
    {
        $this->ensureGTransp();
        $this->gTransp->setDIniTras($fechaInicio);
        
        if ($fechaFin !== null) {
            $this->gTransp->setDFinTras($fechaFin);
        } elseif (isset($this->gTransp->dIniTras)) {
            // Si ya había una fecha de inicio pero no se proporciona fin, usar la misma fecha
            $this->gTransp->setDFinTras($fechaInicio);
        }
        
        return $this;
    }

    /**
     * Establece el país de destino del transporte.
     * 
     * Valor OPCIONAL. Código del país según ISO 3166-1 Alpha-3.
     * 
     * @param String $codigoPais Código del país de destino (E911). Ejemplo: "PRY", "ARG", "BRA"
     * 
     * @return self
     */
    public function setTransportePaisDestino(String $codigoPais): self
    {
        $this->ensureGTransp();
        $this->gTransp->setCPaisDest($codigoPais);
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Métodos para establecer local de salida (E920-E939)
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el local de salida de las mercaderías.
     * 
     * Para Nota de Remisión (C002=7), este campo es OBLIGATORIO.
     * Para Factura Electrónica (C002=1), este campo es OPCIONAL.
     * 
     * @param String $direccion Dirección del local de salida (E921). Nombre de la calle principal. Obligatorio.
     * @param int $numeroCasa Número de casa (E922). Si no tiene numeración, usar 0. Obligatorio.
     * @param int $codigoDepartamento Código del departamento (E925). Obligatorio.
     * @param int $codigoCiudad Código de la ciudad (E929). Obligatorio.
     * @param String|null $calleSecundaria Complemento de dirección 1 - Calle secundaria (E923). Opcional.
     * @param String|null $complementoDir Complemento de dirección 2 - Número de departamento/piso/local (E924). Opcional.
     * @param int|null $codigoDistrito Código del distrito (E927). Opcional.
     * @param String|null $telefono Teléfono de contacto (E931). Opcional.
     * 
     * @return self
     */
    public function setTransporteLocalSalida(
        String $direccion,
        int $numeroCasa,
        int $codigoDepartamento,
        int $codigoCiudad,
        ?String $calleSecundaria = null,
        ?String $complementoDir = null,
        ?int $codigoDistrito = null,
        ?String $telefono = null
    ): self {
        $this->ensureGTransp();
        
        $gCamSal = new GCamSal();
        $gCamSal->setDDirLocSal($direccion);
        $gCamSal->setDNumCasSal($numeroCasa);
        $gCamSal->setCDepSal($codigoDepartamento);
        $gCamSal->setCCiuSal($codigoCiudad);
        
        if ($calleSecundaria !== null) {
            $gCamSal->setDComp1Sal($calleSecundaria);
        }
        
        if ($complementoDir !== null) {
            $gCamSal->setDComp2Sal($complementoDir);
        }
        
        if ($codigoDistrito !== null) {
            $gCamSal->setCDisSal($codigoDistrito);
        }
        
        if ($telefono !== null) {
            $gCamSal->setDTelSal($telefono);
        }
        
        $this->gTransp->setGCamSal($gCamSal);
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Métodos para establecer local de entrega (E940-E959)
    ///////////////////////////////////////////////////////////////////////

    /**
     * Agrega un local de entrega de las mercaderías.
     * 
     * Para Nota de Remisión (C002=7), al menos un local de entrega es OBLIGATORIO.
     * Se pueden agregar múltiples locales de entrega (0-99 ocurrencias).
     * 
     * @param String $direccion Dirección del local de entrega (E941). Nombre de la calle principal. Obligatorio.
     * @param int $numeroCasa Número de casa (E942). Si no tiene numeración, usar 0. Obligatorio.
     * @param int $codigoDepartamento Código del departamento (E945). Obligatorio.
     * @param int $codigoCiudad Código de la ciudad (E949). Obligatorio.
     * @param String|null $calleSecundaria Complemento de dirección 1 - Calle secundaria (E943). Opcional.
     * @param String|null $complementoDir Complemento de dirección 2 - Número de departamento/piso/local (E944). Opcional.
     * @param int|null $codigoDistrito Código del distrito (E947). Opcional.
     * @param String|null $telefono Teléfono de contacto (E951). Opcional.
     * 
     * @return self
     */
    public function addTransporteLocalEntrega(
        String $direccion,
        int $numeroCasa,
        int $codigoDepartamento,
        int $codigoCiudad,
        ?String $calleSecundaria = null,
        ?String $complementoDir = null,
        ?int $codigoDistrito = null,
        ?String $telefono = null
    ): self {
        $this->ensureGTransp();
        
        $gCamEnt = new GCamEnt();
        $gCamEnt->setDDirLocEnt($direccion);
        $gCamEnt->setDNumCasEnt($numeroCasa);
        $gCamEnt->setCDepEnt($codigoDepartamento);
        $gCamEnt->setCCiuEnt($codigoCiudad);
        
        if ($calleSecundaria !== null) {
            $gCamEnt->setDComp1Ent($calleSecundaria);
        }
        
        if ($complementoDir !== null) {
            $gCamEnt->setDComp2Ent($complementoDir);
        }
        
        if ($codigoDistrito !== null) {
            $gCamEnt->setCDisEnt($codigoDistrito);
        }
        
        if ($telefono !== null) {
            $gCamEnt->setDTelEnt($telefono);
        }
        
        if (!isset($this->gTransp->gCamEnt) || !is_array($this->gTransp->gCamEnt)) {
            $this->gTransp->gCamEnt = [];
        }
        
        $this->gTransp->gCamEnt[] = $gCamEnt;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Métodos para establecer vehículo de traslado (E960-E979)
    ///////////////////////////////////////////////////////////////////////

    /**
     * Agrega un vehículo de traslado de mercaderías.
     * 
     * Para Nota de Remisión (C002=7), al menos un vehículo es OBLIGATORIO.
     * Se pueden agregar múltiples vehículos (0-4 ocurrencias).
     * 
     * @param String $tipoVehiculo Tipo de vehículo (E961). Debe ser acorde a la modalidad de transporte. Obligatorio.
     * @param String $marca Marca del vehículo (E962). Obligatorio.
     * @param int $tipoIdentificacion Tipo de identificación (E967). 1=Número de identificación, 2=Número de matrícula. Obligatorio.
     * @param String|null $numeroIdentificacion Número de identificación del vehículo (E963). Obligatorio si tipoIdentificacion=1.
     * @param String|null $numeroMatricula Número de matrícula del vehículo (E965). Obligatorio si tipoIdentificacion=2.
     * @param String|null $datosAdicionales Datos adicionales del vehículo (E964). Opcional.
     * @param String|null $numeroVuelo Número de vuelo (E966). Obligatorio si modalidad de transporte es Aéreo (E903=3). Opcional.
     * 
     * @return self
     * 
     * @throws Exception Si los parámetros obligatorios no son proporcionados correctamente
     */
    public function addTransporteVehiculo(
        String $tipoVehiculo,
        String $marca,
        int $tipoIdentificacion,
        ?String $numeroIdentificacion = null,
        ?String $numeroMatricula = null,
        ?String $datosAdicionales = null,
        ?String $numeroVuelo = null
    ): self {
        $this->ensureGTransp();
        
        $gVehTras = new GVehTras();
        $gVehTras->setDTiVehTras($tipoVehiculo);
        $gVehTras->setDMarVeh($marca);
        $gVehTras->setDTipIdenVeh($tipoIdentificacion);
        
        if ($tipoIdentificacion == 1) {
            if ($numeroIdentificacion === null) {
                throw new Exception('[CamposDeTransporte::addTransporteVehiculo] El número de identificación es obligatorio cuando tipoIdentificacion=1');
            }
            $gVehTras->setDNroIDVeh($numeroIdentificacion);
        } elseif ($tipoIdentificacion == 2) {
            if ($numeroMatricula === null) {
                throw new Exception('[CamposDeTransporte::addTransporteVehiculo] El número de matrícula es obligatorio cuando tipoIdentificacion=2');
            }
            $gVehTras->setDNroMatVeh($numeroMatricula);
        }
        
        if ($datosAdicionales !== null) {
            $gVehTras->setDAdicVeh($datosAdicionales);
        }
        
        if ($numeroVuelo !== null) {
            $gVehTras->setDNroVuelo($numeroVuelo);
        }
        
        if (!isset($this->gTransp->gVehTras) || !is_array($this->gTransp->gVehTras)) {
            $this->gTransp->gVehTras = [];
        }
        
        $this->gTransp->gVehTras[] = $gVehTras;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Métodos para establecer transportista (E980-E999)
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece los datos del transportista.
     * 
     * Para Nota de Remisión (C002=7), este campo es OBLIGATORIO.
     * 
     * @param bool $esContribuyente Si el transportista es contribuyente (E981). true=Contribuyente, false=No contribuyente. Obligatorio.
     * @param String $nombre Nombre o razón social del transportista (E982). Obligatorio.
     * @param String $numeroDocumentoChofer Número de documento de identidad del chofer (E990). Obligatorio.
     * @param String $nombreChofer Nombre y apellido del chofer (E991). Obligatorio.
     * @param String|null $ruc RUC del transportista (E983). Obligatorio si esContribuyente=true.
     * @param int|null $digitoVerificadorRuc Dígito verificador del RUC (E984). Obligatorio si esContribuyente=true.
     * @param int|null $tipoDocumentoIdentidad Tipo de documento de identidad (E985). Obligatorio si esContribuyente=false.
     * @param String|null $numeroDocumentoIdentidad Número de documento de identidad (E987). Obligatorio si esContribuyente=false.
     * @param String|null $nacionalidad Código de nacionalidad según ISO 3166-1 Alpha-3 (E988). Opcional.
     * @param String|null $domicilioFiscal Domicilio fiscal del transportista (E992). Opcional.
     * @param String|null $direccionChofer Dirección del chofer (E993). Opcional.
     * 
     * @return self
     * 
     * @throws Exception Si los parámetros obligatorios no son proporcionados correctamente
     */
    public function setTransporteTransportista(
        bool $esContribuyente,
        String $nombre,
        String $numeroDocumentoChofer,
        String $nombreChofer,
        ?String $ruc = null,
        ?int $digitoVerificadorRuc = null,
        ?int $tipoDocumentoIdentidad = null,
        ?String $numeroDocumentoIdentidad = null,
        ?String $nacionalidad = null,
        ?String $domicilioFiscal = null,
        ?String $direccionChofer = null
    ): self {
        $this->ensureGTransp();
        
        $gCamTrans = new GCamTrans();
        $gCamTrans->setINatTrans($esContribuyente ? 1 : 2);
        $gCamTrans->setDNomTrans($nombre);
        $gCamTrans->setDNumIDChof($numeroDocumentoChofer);
        $gCamTrans->setDNomChof($nombreChofer);
        
        if ($esContribuyente) {
            if ($ruc === null || $digitoVerificadorRuc === null) {
                throw new Exception('[CamposDeTransporte::setTransporteTransportista] RUC y dígito verificador son obligatorios cuando el transportista es contribuyente');
            }
            $gCamTrans->setDRucTrans($ruc);
            $gCamTrans->setDDVTrans($digitoVerificadorRuc);
        } else {
            if ($tipoDocumentoIdentidad === null || $numeroDocumentoIdentidad === null) {
                throw new Exception('[CamposDeTransporte::setTransporteTransportista] Tipo y número de documento de identidad son obligatorios cuando el transportista no es contribuyente');
            }
            $gCamTrans->setITipIDTrans($tipoDocumentoIdentidad);
            $gCamTrans->setDNumIDTrans($numeroDocumentoIdentidad);
        }
        
        if ($nacionalidad !== null) {
            $gCamTrans->setCNacTrans($nacionalidad);
        }
        
        if ($domicilioFiscal !== null) {
            $gCamTrans->setDDomFisc($domicilioFiscal);
        }
        
        if ($direccionChofer !== null) {
            $gCamTrans->setDDirChof($direccionChofer);
        }
        
        $this->gTransp->setGCamTrans($gCamTrans);
        return $this;
    }

    /**
     * Establece los datos del agente intermediario del transporte.
     * 
     * Valor OPCIONAL. Se utiliza en casos particulares según RG N° 41/14.
     * 
     * @param String $nombre Nombre o razón social del agente (E994). Obligatorio.
     * @param String|null $ruc RUC del agente (E995). Opcional.
     * @param int|null $digitoVerificadorRuc Dígito verificador del RUC del agente (E996). Obligatorio si se proporciona RUC.
     * @param String|null $direccion Dirección del agente (E997). Opcional.
     * 
     * @return self
     * 
     * @throws Exception Si se proporciona RUC pero no el dígito verificador
     */
    public function setTransporteAgente(
        String $nombre,
        ?String $ruc = null,
        ?int $digitoVerificadorRuc = null,
        ?String $direccion = null
    ): self {
        $this->ensureGTransp();
        
        if (!isset($this->gTransp->gCamTrans)) {
            throw new Exception('[CamposDeTransporte::setTransporteAgente] Debe establecer primero los datos del transportista antes de agregar información del agente');
        }
        
        if ($ruc !== null && $digitoVerificadorRuc === null) {
            throw new Exception('[CamposDeTransporte::setTransporteAgente] El dígito verificador del RUC es obligatorio si se proporciona el RUC del agente');
        }
        
        $this->gTransp->gCamTrans->setDNombAg($nombre);
        
        if ($ruc !== null) {
            $this->gTransp->gCamTrans->setDRucAg($ruc);
            $this->gTransp->gCamTrans->setDDVAg($digitoVerificadorRuc);
        }
        
        if ($direccion !== null) {
            $this->gTransp->gCamTrans->setDDirAge($direccion);
        }
        
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Métodos helper privados
    ///////////////////////////////////////////////////////////////////////

    /**
     * Asegura que el objeto gTransp esté inicializado.
     * 
     * @return void
     * 
     * @throws Exception Si el objeto gTransp no puede ser inicializado
     */
    private function ensureGTransp(): void
    {
        if (!isset($this->gTransp)) {
            $this->gTransp = new GTransp();
        }
    }
}
