<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos;

use DateTime;
use Exception;
use IonysDev\Pkuatia\Core\Constants\GTranspModTrans;
use IonysDev\Pkuatia\Core\Constants\GTranspRespFlete;
use IonysDev\Pkuatia\Core\Constants\GTranspTipTrans;
use IonysDev\Pkuatia\Core\Constants\MotEmiNR;
use IonysDev\Pkuatia\Core\Constants\RespEmiNR;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits\CamposDeTransporte;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits\ItemSinValor;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamNRE;

/**
 * Tipo de Documento Electrónico Sifen: 7 - Nota de Remisión Electrónica
 */
class NotaDeRemision extends DocumentoElectronico
{
    use CamposDeTransporte;
    use ItemSinValor;

    //////////////////////////////////////////
    // Atributos
    //////////////////////////////////////////

    public GCamNRE $gCamNRE; // E500 - E599 - Campos que componen la nota de remisión electrónica

    //////////////////////////////////////////
    // Constructor
    //////////////////////////////////////////

    /**
     * Constructor de la clase Nota de Remisión Electrónica.
     * 
     * Establece el tipo de documento electrónico como Nota de Remisión (C002=7) y
     * inicializa los campos obligatorios básicos:
     * - Campos de la Nota de Remisión (gCamNRE): motivo de emisión y responsable
     * - Campos básicos de transporte (gTransp): tipo, modalidad, responsable de flete y fecha de inicio
     * 
     * NOTA: Los siguientes campos de transporte son obligatorios y deben establecerse después del constructor:
     * - Local de salida (setTransporteLocalSalida)
     * - Al menos un local de entrega (addTransporteLocalEntrega)
     * - Al menos un vehículo (addTransporteVehiculo)
     * - Transportista (setTransporteTransportista)
     * 
     * @param int|MotEmiNR $motivoEmision Motivo de emisión de la nota de remisión (E501). Obligatorio.
     *                                     Valores: 1=Traslado por venta, 2=Traslado por consignación, etc.
     * @param int|RespEmiNR $responsableEmision Responsable de la emisión (E503). Obligatorio.
     *                                           Valores: 1=Emisor de la factura, 2=Poseedor de la factura y bienes, etc.
     * @param int|GTranspTipTrans $tipoTransporte Tipo de transporte (E901). Obligatorio para Nota de Remisión.
     *                                            1=Propio, 2=Tercero
     * @param int|GTranspModTrans $modalidadTransporte Modalidad de transporte (E903). Obligatorio.
     *                                                  1=Terrestre, 2=Fluvial, 3=Aéreo, 4=Multimodal
     * @param int|GTranspRespFlete $responsableFlete Responsable del costo del flete (E905). Obligatorio.
     *                                                1=Emisor, 2=Receptor, 3=Tercero, 4=Agente intermediario, 5=Transporte propio
     * @param DateTime $fechaInicioTraslado Fecha estimada de inicio de traslado (E909). Obligatorio para Nota de Remisión.
     * 
     * @return void
     */
    public function __construct(
        int|MotEmiNR $motivoEmision,
        int|RespEmiNR $responsableEmision,
        int|GTranspTipTrans $tipoTransporte,
        int|GTranspModTrans $modalidadTransporte,
        int|GTranspRespFlete $responsableFlete,
        DateTime $fechaInicioTraslado
    ) {
        parent::__construct();
        
        // Establecer tipo de documento electrónico
        $this->gTimb->setITiDE(TimbTiDE::NotaDeRemision);
        
        // Inicializar y establecer campos obligatorios de la Nota de Remisión (E500-E599)
        $this->gCamNRE = new GCamNRE();
        $this->gCamNRE->setIMotEmiNR($motivoEmision);
        $this->gCamNRE->setIRespEmiNR($responsableEmision);
        
        // Inicializar y establecer campos obligatorios básicos de transporte (E900-E999)
        // Para Nota de Remisión (C002=7), el transporte es obligatorio
        $this->setTransporte(
            $modalidadTransporte,
            $responsableFlete,
            $tipoTransporte
        );
        
        // Establecer fecha de inicio de traslado (obligatorio para Nota de Remisión)
        $this->setTransporteFechasTraslado($fechaInicioTraslado);
    }

    ///////////////////////////////////////////////////////////////////////
    // Métodos para establecer campos de la Nota de Remisión (E500-E599)
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el motivo de emisión de la nota de remisión.
     * 
     * Valor OBLIGATORIO. Este campo ya se establece en el constructor, pero puede ser modificado
     * usando este método si es necesario.
     * 
     * @param int|MotEmiNR $motivoEmision Motivo de emisión de la nota de remisión (E501). Obligatorio.
     *                                     Valores posibles:
     *                                     1=Traslado por venta
     *                                     2=Traslado por consignación
     *                                     3=Exportación
     *                                     4=Traslado por compra
     *                                     5=Importación
     *                                     6=Traslado por devolución
     *                                     7=Traslado entre locales de la empresa
     *                                     8=Traslado de bienes por transformación
     *                                     9=Traslado de bienes por reparación
     *                                     10=Traslado por emisor móvil
     *                                     11=Exhibición o demostración
     *                                     12=Participación en ferias
     *                                     13=Traslado de encomienda
     *                                     14=Decomiso
     *                                     99=Otro (debe consignarse expresamente el motivo)
     * 
     * @return self
     * 
     * @throws Exception Si el motivo de emisión es Importación (5) y no se ha establecido el número de despacho de importación
     */
    public function setMotivoEmision(int|MotEmiNR $motivoEmision): self
    {
        $this->gCamNRE->setIMotEmiNR($motivoEmision);
        
        // Si el motivo es Importación, validar que se haya establecido el número de despacho
        $motivoInt = $motivoEmision instanceof MotEmiNR ? $motivoEmision->value : $motivoEmision;
        if ($motivoInt === 5 && (!isset($this->gTransp) || !isset($this->gTransp->dNuDespImp))) {
            throw new Exception('[NotaDeRemision::setMotivoEmision] Cuando el motivo de emisión es Importación (5), debe establecerse el número de despacho de importación usando setTransporteNumeroDespachoImportacion()');
        }
        
        return $this;
    }

    /**
     * Establece una descripción personalizada del motivo de emisión.
     * 
     * Este método establece automáticamente el motivo de emisión a "Otro" (99) si aún no lo está,
     * y luego establece la descripción personalizada proporcionada.
     * 
     * Para todos los demás motivos (1-14), la descripción se establece automáticamente según el código.
     * Este método es útil cuando se necesita especificar un motivo que no está en la lista estándar.
     * 
     * @param String $descripcion Descripción personalizada del motivo de emisión (E502). 
     *                           Longitud: 5-60 caracteres. Obligatorio cuando se usa motivo "Otro" (99).
     * 
     * @return self
     * 
     * @throws Exception Si la descripción no cumple con la longitud requerida (5-60 caracteres)
     */
    public function setDescripcionMotivoEmision(String $descripcion): self
    {
        // Validar longitud de la descripción
        if (strlen($descripcion) < 5 || strlen($descripcion) > 60) {
            throw new Exception('[NotaDeRemision::setDescripcionMotivoEmision] La descripción del motivo debe tener entre 5 y 60 caracteres. Longitud recibida: ' . strlen($descripcion));
        }
        
        // Establecer automáticamente el motivo de emisión a "Otro" (99) si aún no lo está
        if ($this->gCamNRE->getIMotEmiNR() !== 99) {
            $this->gCamNRE->setIMotEmiNR(MotEmiNR::Otro);
        }
        
        // Establecer la descripción personalizada
        $this->gCamNRE->setDDesMotEmiNR($descripcion);
        return $this;
    }

    /**
     * Establece el responsable de la emisión de la nota de remisión.
     * 
     * Valor OBLIGATORIO. Este campo ya se establece en el constructor, pero puede ser modificado
     * usando este método si es necesario.
     * 
     * @param int|RespEmiNR $responsableEmision Responsable de la emisión (E503). Obligatorio.
     *                                           Valores posibles:
     *                                           1=Emisor de la factura
     *                                           2=Poseedor de la factura y bienes
     *                                           3=Empresa transportista
     *                                           4=Despachante de Aduanas
     *                                           5=Agente de transporte o intermediario
     * 
     * @return self
     */
    public function setResponsableEmision(int|RespEmiNR $responsableEmision): self
    {
        $this->gCamNRE->setIRespEmiNR($responsableEmision);
        return $this;
    }

    /**
     * Establece los kilómetros estimados de recorrido del traslado.
     * 
     * Valor OPCIONAL. Se utiliza para informar la distancia estimada que recorrerá
     * el vehículo durante el traslado de las mercaderías.
     * 
     * @param int $kilometros Kilómetros estimados de recorrido (E505). Valor entre 1 y 99999.
     * 
     * @return self
     * 
     * @throws Exception Si el valor está fuera del rango permitido
     */
    public function setKilometrosRecorrido(int $kilometros): self
    {
        if ($kilometros < 1 || $kilometros > 99999) {
            throw new Exception('[NotaDeRemision::setKilometrosRecorrido] Los kilómetros estimados de recorrido deben estar entre 1 y 99999. Valor recibido: ' . $kilometros);
        }
        
        $this->gCamNRE->setDKmR($kilometros);
        return $this;
    }

    /**
     * Establece la fecha futura de emisión de la factura electrónica.
     * 
     * Valor OPCIONAL. Se utiliza cuando aún no se ha emitido la factura electrónica
     * correspondiente a esta nota de remisión, pero se conoce la fecha en que se emitirá.
     * 
     * Este campo es útil cuando:
     * - La nota de remisión se emite antes que la factura
     * - Se necesita informar la fecha prevista de facturación
     * 
     * @param DateTime $fechaEmision Fecha futura de emisión de la factura (E506). Formato: Y-m-d
     * 
     * @return self
     * 
     * @throws Exception Si la fecha es anterior a la fecha actual
     */
    public function setFechaFuturaEmisionFactura(DateTime $fechaEmision): self
    {
        $hoy = new DateTime();
        if ($fechaEmision < $hoy) {
            throw new Exception('[NotaDeRemision::setFechaFuturaEmisionFactura] La fecha futura de emisión de la factura no puede ser anterior a la fecha actual. Fecha recibida: ' . $fechaEmision->format('Y-m-d'));
        }
        
        $this->gCamNRE->setDFecEm($fechaEmision);
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Método para generar RDE
    ///////////////////////////////////////////////////////////////////////

    /**
     * Genera y devuelve un objeto RDE que contiene todos los campos de esta Nota de Remisión Electrónica.
     * 
     * Este método asigna los campos específicos de la Nota de Remisión (gCamNRE) y los ítems
     * al objeto gDtipDE antes de generar el RDE final.
     * 
     * @return RDE Objeto RDE que contiene todos los campos del documento electrónico
     */
    public function notaDeRemisionToRDE(): RDE
    {
        // Asignar gCamNRE a gDtipDE
        $this->gDtipDE->setGCamNRE($this->gCamNRE);
        
        // Asignar los ítems a gDtipDE (el trait ItemSinValor proporciona la propiedad $items)
        $this->gDtipDE->gCamItem = $this->items;
        
        // Generar el RDE usando el método del padre
        return $this->documentoElectronicoToRDE();
    }

    ///////////////////////////////////////////////////////////////////////
    // Método de validación
    ///////////////////////////////////////////////////////////////////////

    /**
     * Valida que todos los campos obligatorios de la Nota de Remisión estén establecidos
     * según los lineamientos del Manual Técnico Versión 150.
     * 
     * Este método verifica:
     * - Campos básicos del documento (timbrado, emisor, receptor, fecha de emisión)
     * - Campos específicos de la Nota de Remisión (gCamNRE)
     * - Campos obligatorios de transporte (gTransp y sus componentes)
     * - Al menos un ítem en el documento
     * - Validaciones específicas según el motivo de emisión
     * 
     * @return void
     * 
     * @throws Exception Si algún campo obligatorio no está establecido o es inválido
     */
    public function validar(): void
    {
        $errores = [];

        // Validar campos básicos del documento
        if (!isset($this->gTimb->dNumTim)) {
            $errores[] = 'Número de timbrado (C004) es obligatorio';
        }
        if (!isset($this->gTimb->dEst)) {
            $errores[] = 'Establecimiento (C005) es obligatorio';
        }
        if (!isset($this->gTimb->dPunExp)) {
            $errores[] = 'Punto de expedición (C006) es obligatorio';
        }
        if (!isset($this->gTimb->dNumDoc)) {
            $errores[] = 'Número de documento (C007) es obligatorio';
        }
        if (!isset($this->gDatGralOpe->dFeEmiDE)) {
            $errores[] = 'Fecha de emisión del documento (D002) es obligatoria';
        }
        if (!isset($this->gEmis->dRucEm) || !isset($this->gEmis->dDVEmi)) {
            $errores[] = 'RUC y dígito verificador del emisor (D101, D102) son obligatorios';
        }
        if (!isset($this->gDatRec)) {
            $errores[] = 'Datos del receptor (D200) son obligatorios';
        }

        // Validar campos específicos de la Nota de Remisión
        if (!isset($this->gCamNRE)) {
            $errores[] = 'Campos de la Nota de Remisión (gCamNRE - E500) son obligatorios';
        } else {
            if (!isset($this->gCamNRE->iMotEmiNR)) {
                $errores[] = 'Motivo de emisión (E501) es obligatorio';
            }
            if (!isset($this->gCamNRE->iRespEmiNR)) {
                $errores[] = 'Responsable de la emisión (E503) es obligatorio';
            }
            
            // Validación específica: si el motivo es Importación (5), debe tener número de despacho
            if (isset($this->gCamNRE->iMotEmiNR) && $this->gCamNRE->iMotEmiNR === 5) {
                if (!isset($this->gTransp) || !isset($this->gTransp->dNuDespImp)) {
                    $errores[] = 'Número de despacho de importación (E908) es obligatorio cuando el motivo de emisión es Importación (5)';
                }
            }
            
            // Validación específica: si el motivo es "Otro" (99), debe tener descripción personalizada
            if (isset($this->gCamNRE->iMotEmiNR) && $this->gCamNRE->iMotEmiNR === 99) {
                if (!isset($this->gCamNRE->dDesMotEmiNR) || strlen($this->gCamNRE->dDesMotEmiNR) < 5) {
                    $errores[] = 'Descripción del motivo de emisión (E502) es obligatoria y debe tener al menos 5 caracteres cuando el motivo es "Otro" (99)';
                }
            }
            
            // Validación específica: si el motivo es operación interna (7), el RUC del receptor debe ser igual al del emisor
            if (isset($this->gCamNRE->iMotEmiNR) && $this->gCamNRE->iMotEmiNR === 7) {
                if (isset($this->gEmis->dRucEm) && isset($this->gDatRec->dRucRec)) {
                    if ($this->gEmis->dRucEm !== $this->gDatRec->dRucRec) {
                        $errores[] = 'Cuando el motivo de emisión es "Traslado entre locales de la empresa" (7), el RUC del receptor debe ser igual al RUC del emisor';
                    }
                }
            }
        }

        // Validar campos obligatorios de transporte (para C002=7, el transporte es obligatorio)
        if (!isset($this->gTransp)) {
            $errores[] = 'Campos de transporte (gTransp - E900) son obligatorios para Nota de Remisión';
        } else {
            if (!isset($this->gTransp->iTipTrans)) {
                $errores[] = 'Tipo de transporte (E901) es obligatorio para Nota de Remisión';
            }
            if (!isset($this->gTransp->iModTrans)) {
                $errores[] = 'Modalidad de transporte (E903) es obligatoria';
            }
            if (!isset($this->gTransp->iRespFlete)) {
                $errores[] = 'Responsable del flete (E905) es obligatorio';
            }
            if (!isset($this->gTransp->dIniTras)) {
                $errores[] = 'Fecha de inicio de traslado (E909) es obligatoria para Nota de Remisión';
            }
            if (isset($this->gTransp->dIniTras) && !isset($this->gTransp->dFinTras)) {
                $errores[] = 'Fecha de fin de traslado (E910) es obligatoria si se establece fecha de inicio';
            }
            if (!isset($this->gTransp->gCamSal)) {
                $errores[] = 'Local de salida (gCamSal - E920) es obligatorio para Nota de Remisión';
            }
            if (!isset($this->gTransp->gCamEnt) || !is_array($this->gTransp->gCamEnt) || count($this->gTransp->gCamEnt) === 0) {
                $errores[] = 'Al menos un local de entrega (gCamEnt - E940) es obligatorio para Nota de Remisión';
            }
            if (!isset($this->gTransp->gVehTras) || !is_array($this->gTransp->gVehTras) || count($this->gTransp->gVehTras) === 0) {
                $errores[] = 'Al menos un vehículo de traslado (gVehTras - E960) es obligatorio para Nota de Remisión';
            }
            if (!isset($this->gTransp->gCamTrans)) {
                $errores[] = 'Datos del transportista (gCamTrans - E980) son obligatorios para Nota de Remisión';
            }
            
            // Validación específica: si la modalidad es Aéreo (3), al menos un vehículo debe tener número de vuelo
            if (isset($this->gTransp->iModTrans) && $this->gTransp->iModTrans === 3) {
                $tieneNumeroVuelo = false;
                if (isset($this->gTransp->gVehTras) && is_array($this->gTransp->gVehTras)) {
                    foreach ($this->gTransp->gVehTras as $vehiculo) {
                        if (isset($vehiculo->dNroVuelo)) {
                            $tieneNumeroVuelo = true;
                            break;
                        }
                    }
                }
                if (!$tieneNumeroVuelo) {
                    $errores[] = 'Al menos un vehículo debe tener número de vuelo (E966) cuando la modalidad de transporte es Aéreo (3)';
                }
            }
        }

        // Validar que haya al menos un ítem
        if (!isset($this->items) || !is_array($this->items) || count($this->items) === 0) {
            $errores[] = 'Al menos un ítem es obligatorio en la Nota de Remisión';
        }

        // Validar que NO tenga campos que no deben estar para Nota de Remisión (C002=7)
        if (isset($this->gDatGralOpe->gOpeCom)) {
            $errores[] = 'Campos de operación comercial (gOpeCom - D010) no deben informarse para Nota de Remisión (C002=7)';
        }

        // Si hay errores, lanzar excepción con todos los errores
        if (count($errores) > 0) {
            $mensaje = '[NotaDeRemision::validar] La Nota de Remisión tiene los siguientes errores de validación:' . PHP_EOL;
            $mensaje .= implode(PHP_EOL . '- ', $errores);
            throw new Exception($mensaje);
        }
    }
    
}