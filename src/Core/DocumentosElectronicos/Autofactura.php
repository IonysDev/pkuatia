<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos;

use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\OpeComTipImp;
use IonysDev\Pkuatia\Core\Constants\OpeDETipEmi;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\Constants\PagCredCondCred;
use IonysDev\Pkuatia\Core\Constants\PagTarCDDenTarj;
use IonysDev\Pkuatia\Core\Constants\PagTarCDForProPa;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits\ItemValorado;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamAE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamCond;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCuotas;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPaConEIni;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagCheq;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagCred;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagTarCD;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\Utils\ValueValidations;
use DateTime;
use IonysDev\Pkuatia\Core\Constants\CamAENatVen;
use IonysDev\Pkuatia\Core\Constants\CamAETipIDVen;

/**
 * Tipo de Documento Electrónico SIFEN: 4 - Autofactura electrónica (C002).
 *
 * Estructura según Manual Técnico SIFEN v150:
 * - gCamAE (E300): datos del vendedor (persona física no contribuyente o extranjero) y lugar de la transacción.
 * - gCamCond (E600): condición de la operación (contado/crédito) e información de pagos.
 * - gOpeCom (D010): operación comercial (tipo de transacción, impuesto, moneda, etc.), vía DocumentoElectronicoComercial.
 * - gCamItem (E700) y gTotSub (F001): ítems valorizados y totales, vía ItemValorado.
 *
 * Armar el DE con autofacturaToRDE() tras completar emisor, receptor, timbrado, gCamAE, ítems y condiciones de pago.
 */
class Autofactura extends DocumentoElectronicoComercial
{
    use ItemValorado;

    //////////////////////////////////////////
    // Atributos
    //////////////////////////////////////////

    public GCamAE $gCamAE; // E300 - Campos que componen la autofactura electrónica

    public GCamCond $gCamCond; // E600 - Condición de la operación

    //////////////////////////////////////////
    // Constructor
    //////////////////////////////////////////

    /**
     * @param int|CamCondOpe $condicion Condición de operación E601 (contado o crédito).
     */
    public function __construct(int|CamCondOpe $condicion)
    {
        parent::__construct();
        $this->gTimb->setITiDE(TimbTiDE::Autofactura);
        $this->gCamAE = new GCamAE();
        $this->gCamCond = new GCamCond();
        $this->gCamCond->setICondOpe($condicion);
        $this->setTipoDeImpuestoAfectado(OpeComTipImp::IVA);
        $this->setMoneda('PYG');
    }

    //////////////////////////////////////////
    // START - Datos del Vendedor
    //////////////////////////////////////////

    /**
     * Establece todos los datos del vendedor en un solo método.
     * 
     * @param int|CamAENatVen $iNatVen Código o caso de la naturaleza del vendedor.
     * @param int|CamAETipIDVen $iTipIDVen Código o caso del tipo de documento de identidad del vendedor.
     * @param string $dNumIDVen Número de documento de identidad del vendedor.
     * @param string $dNomVen Nombre y apellido del vendedor.
     * @param string $dDirVen Dirección del vendedor.
     * @param int $dNumCasVen Número de casa del vendedor.
     * @param int $cDepVen Código de departamento del vendedor.
     * @param int|null $cDisVen Código de distrito del vendedor.
     * @param int $cCiuVen Código de ciudad del vendedor.
     * 
     * @return self Encadenamiento fluido.
     */
    public function setDatosVendedor(
        int|CamAENatVen $iNatVen,
        int|CamAETipIDVen $iTipIDVen,
        string $dNumIDVen,
        string $dNomVen,
        string $dDirVen,
        int $dNumCasVen,
        int $cDepVen,
        int $cDisVen,
        int $cCiuVen
    ): self {
        $this->gCamAE->setINatVen($iNatVen);
        $this->gCamAE->setITipIDVen($iTipIDVen);
        $this->gCamAE->setDNumIDVen($dNumIDVen);
        $this->gCamAE->setDNomVen($dNomVen);
        $this->gCamAE->setDDirVen($dDirVen);
        $this->gCamAE->setDNumCasVen($dNumCasVen);
        $this->gCamAE->setCDepVen($cDepVen);
        $this->gCamAE->setCDisVen($cDisVen);
        $this->gCamAE->setCCiuVen($cCiuVen);
        return $this;
    }

    public function setNaturalezaVendedor(int|CamAENatVen $iNatVen): self
    {
        $this->gCamAE->setINatVen($iNatVen);
        return $this;
    }
    
    public function setTipoDocumentoIdentidadVendedor(int|CamAETipIDVen $iTipIDVen): self
    {
        $this->gCamAE->setITipIDVen($iTipIDVen);
        return $this;
    }


    public function setNumeroDocumentoVendedor(string $dNumIDVen): self
    {
        $this->gCamAE->setDNumIDVen($dNumIDVen);
        return $this;
    }

    public function setNombreCompletoVendedor(string $dNomVen): self
    {
        $this->gCamAE->setDNomVen($dNomVen);
        return $this;
    }

    public function setDireccionVendedor(string $dDirVen, int $dNumCasVen = 0): self
    {
        $this->gCamAE->setDDirVen($dDirVen);
        $this->gCamAE->setDNumCasVen($dNumCasVen);
        return $this;
    }

    public function setDepartamentoVendedor(int $cDepVen): self
    {
        $this->gCamAE->setCDepVen($cDepVen);
        return $this;
    }

    /** E312: distrito del vendedor (opcional en el esquema). */
    public function setDistritoVendedor(int $cDisVen): self
    {
        $this->gCamAE->setCDisVen($cDisVen);
        return $this;
    }
    
    public function setCiudadVendedor(int $cCiuVen): self
    {
        $this->gCamAE->setCCiuVen($cCiuVen);
        return $this;
    }


    //////////////////////////////////////////
    // END - Datos del Vendedor
    //////////////////////////////////////////

    //////////////////////////////////////////
    // START - Datos del Lugar de la Transacción
    //////////////////////////////////////////


    /**
     * Establece el lugar donde se realiza la transacción (gCamAE: E316–E322).
     *
     * Comprueba que el departamento exista en el catálogo SIFEN antes de asignar. Ciudad y distrito
     * siguen el patrón de {@see GCamAE}: se informa el código (rellena la descripción vía tablas) y,
     * si corresponde, la descripción explícita sustituye ese texto.
     *
     * @param string $dDirProv E316 — Dirección o referencia del lugar de la operación.
     * @param int $cDepProv E317 — Código de departamento (debe existir en {@see DepartamentoMapping}).
     * @param int $cCiuProv E321 — Código de ciudad del lugar de la transacción.
     * @param string $dDesCiuProv E322 — Descripción de la ciudad.
     * @param int|null $cDisProv E319 — Código de distrito del lugar (opcional).
     * @param string|null $dDesDisProv E320 — Descripción del distrito (opcional).
     *
     * @return self Encadenamiento fluido.
     *
     */
    public function setLugarTransaccion(
        string $dDirProv,
        int $cDepProv,
        int|null $cDisProv,
        int $cCiuProv,
    ): self {
        $ae = $this->gCamAE;
        $ae->setDDirProv($dDirProv);
        $ae->setCDepProv($cDepProv);
        $ae->setCDisProv($cDisProv);
        $ae->setCCiuProv($cCiuProv);
        return $this;
    }

    public function setDepartamentoLugarTransaccion(int $cDepProv): self
    {
        $this->gCamAE->setCDepProv($cDepProv);
        return $this;
    }

    public function setDistritoLugarTransaccion(int $cDisProv): self
    {
        $this->gCamAE->setCDisProv($cDisProv);
        return $this;
    }
    
    
    public function setCiudadLugarTransaccion(int $cCiuProv): self
    {
        $this->gCamAE->setCCiuProv($cCiuProv);
        return $this;
    }

    public function setDireccionLugarTransaccion(string $dDirProv): self
    {
        $this->gCamAE->setDDirProv($dDirProv);
        return $this;
    }

    //////////////////////////////////////////
    // END - Datos del Lugar de la Transacción
    //////////////////////////////////////////

    //////////////////////////////////////////
    // Pagos y crédito (misma convención que Factura)
    //////////////////////////////////////////

    /**
     * Agrega un pago al contado. Para tarjeta o cheque usar los métodos específicos.
     *
     * @param String|null $tasaDeCambio Obligatoria si la moneda no es PYG.
     */
    public function addPago(
        int|PaConEIniTiPago $tipoDePago,
        string $monto,
        string $moneda = 'PYG',
        ?string $tasaDeCambio = null
    ): self {
        if (strcmp($moneda, 'PYG') !== 0 && $tasaDeCambio === null) {
            throw new \Exception('[Autofactura] La tasa de cambio es obligatoria para pagos en moneda extranjera.');
        }
        $gPaConEIni = new GPaConEIni();
        $gPaConEIni->setITiPago($tipoDePago);
        $gPaConEIni->setDMonTiPag($monto);
        $gPaConEIni->setCMoneTiPag($moneda);
        if ($tasaDeCambio !== null) {
            $gPaConEIni->setDTiCamTiPag($tasaDeCambio);
        }
        $this->gCamCond->addGPaConEIni($gPaConEIni);
        return $this;
    }

    public function addPagoPYGPorTarjeta(
        bool $esTarjetaCredito,
        string $monto,
        string|int|PagTarCDDenTarj $denomTarjeta,
        int|PagTarCDForProPa $formaProc,
        ?int $codAutorizacion = null,
        ?string $nombreTitular = null,
        ?string $ult4NroTarjeta = null
    ): self {
        $gPagTarCD = new GPagTarCD();
        if ($denomTarjeta instanceof PagTarCDDenTarj || is_int($denomTarjeta)) {
            $gPagTarCD->setIDenTarj($denomTarjeta);
        } else {
            $gPagTarCD->setIDenTarj(PagTarCDDenTarj::Otro);
            $gPagTarCD->setDDesDenTarj($denomTarjeta);
        }
        $gPagTarCD->setIForProPa($formaProc);
        if ($codAutorizacion !== null) {
            $gPagTarCD->setDCodAuOpe($codAutorizacion);
        }
        if ($nombreTitular !== null) {
            $gPagTarCD->setDNomTit($nombreTitular);
        }
        if ($ult4NroTarjeta !== null) {
            $gPagTarCD->setDNumTarj($ult4NroTarjeta);
        }
        $gPaConEIni = new GPaConEIni();
        $gPaConEIni->setITiPago($esTarjetaCredito ? PaConEIniTiPago::TarjetaCredito : PaConEIniTiPago::TarjetaDebito);
        $gPaConEIni->setDMonTiPag($monto);
        $gPaConEIni->setCMoneTiPag('PYG');
        $gPaConEIni->setGPagTarCD($gPagTarCD);
        $this->gCamCond->addGPaConEIni($gPaConEIni);
        return $this;
    }

    public function addPagoPorCheque(
        string $monto,
        string $numeroCheque,
        string $bancoEmisor,
        string $moneda = 'PYG',
        ?string $tasaDeCambio = null
    ): self {
        $gPagCheq = new GPagCheq();
        $gPagCheq->setDNumCheq($numeroCheque);
        $gPagCheq->setDBcoEmi($bancoEmisor);
        $gPaConEIni = new GPaConEIni();
        $gPaConEIni->setITiPago(PaConEIniTiPago::Cheque);
        $gPaConEIni->setDMonTiPag($monto);
        $gPaConEIni->setCMoneTiPag($moneda);
        if (strcmp($moneda, 'PYG') !== 0 && $tasaDeCambio === null) {
            throw new \Exception('[Autofactura] La tasa de cambio es obligatoria para pagos en moneda extranjera.');
        }
        if ($tasaDeCambio !== null) {
            $gPaConEIni->setDTiCamTiPag($tasaDeCambio);
        }
        $gPaConEIni->setGPagCheq($gPagCheq);
        $this->gCamCond->addGPaConEIni($gPaConEIni);
        return $this;
    }

    public function addPagoPYGPorCheque(
        string $monto,
        string $numeroCheque,
        string $bancoEmisor
    ): self {
        $gPagCheq = new GPagCheq();
        $gPagCheq->setDNumCheq($numeroCheque);
        $gPagCheq->setDBcoEmi($bancoEmisor);
        $gPaConEIni = new GPaConEIni();
        $gPaConEIni->setITiPago(PaConEIniTiPago::Cheque);
        $gPaConEIni->setDMonTiPag($monto);
        $gPaConEIni->setCMoneTiPag('PYG');
        $gPaConEIni->setGPagCheq($gPagCheq);
        $this->gCamCond->addGPaConEIni($gPaConEIni);
        return $this;
    }

    public function addPagoUSDPorCheque(
        string $monto,
        string $tipoCambio,
        string $numeroCheque,
        string $bancoEmisor
    ): self {
        $gPagCheq = new GPagCheq();
        $gPagCheq->setDNumCheq($numeroCheque);
        $gPagCheq->setDBcoEmi($bancoEmisor);
        $gPaConEIni = new GPaConEIni();
        $gPaConEIni->setITiPago(PaConEIniTiPago::Cheque);
        $gPaConEIni->setDMonTiPag($monto);
        $gPaConEIni->setCMoneTiPag('USD');
        $gPaConEIni->setDTiCamTiPag($tipoCambio);
        $gPaConEIni->setGPagCheq($gPagCheq);
        $this->gCamCond->addGPaConEIni($gPaConEIni);
        return $this;
    }

    public function setOperacionCreditoAPlazo(string $descripcionPlazo, ?string $montoEntregaInicial = null): self
    {
        $gPagCred = new GPagCred();
        $gPagCred->setICondCred(PagCredCondCred::Plazo);
        $gPagCred->setDPlazoCre($descripcionPlazo);
        if ($montoEntregaInicial !== null) {
            $gPagCred->setDMonEnt($montoEntregaInicial);
        }
        $this->gCamCond->setGPagCred($gPagCred);
        return $this;
    }

    public function setOperacionCreditoEnCuotas(
        array $montoCuotas,
        array $vencimientos,
        ?string $montoEntregaInicial = null,
        ?string $monedaCuotas = null
    ): self {
        if (count($montoCuotas) !== count($vencimientos)) {
            throw new \Exception('[Autofactura] La cantidad de montos de cuotas y vencimientos no coincide.');
        }
        if ($montoEntregaInicial !== null && ValueValidations::isValidStringDecimal($montoEntregaInicial, 15, 0, 4) === false) {
            throw new \Exception('[Autofactura] Monto de entrega inicial inválido: ' . $montoEntregaInicial);
        }
        $gCuotas = [];
        foreach ($montoCuotas as $i => $monto) {
            if (ValueValidations::isValidStringDecimal($monto, 15, 0, 4) === false) {
                throw new \Exception('[Autofactura] Monto de cuota ' . ($i + 1) . ' inválido: ' . $monto);
            }
            if (!($vencimientos[$i] instanceof DateTime)) {
                throw new \Exception('[Autofactura] Vencimiento de cuota ' . ($i + 1) . ' debe ser DateTime.');
            }
            $gCuota = new GCuotas();
            $gCuota->setCMoneCuo($monedaCuotas ?? 'PYG');
            $gCuota->setDMonCuota($monto);
            $gCuota->setDVencCuo($vencimientos[$i]);
            $gCuotas[] = $gCuota;
        }
        $gPagCred = new GPagCred();
        $gPagCred->setICondCred(PagCredCondCred::Cuota);
        $gPagCred->setDCuotas(count($gCuotas));
        $gPagCred->setGCuotas($gCuotas);
        if ($montoEntregaInicial !== null) {
            $gPagCred->setDMonEnt($montoEntregaInicial);
        }
        $this->gCamCond->setGPagCred($gPagCred);
        return $this;
    }

    //////////////////////////////////////////
    // Ensamblado RDE
    //////////////////////////////////////////

    /**
     * Construye el RDE con gCamAE, gCamCond, ítems y totales.
     * Debe invocarse después de definir emisor, receptor, fecha de emisión y timbrado en la clase base.
     */
    public function autofacturaToRDE(): RDE
    {
        $this->gDtipDE->gCamAE = $this->gCamAE;
        $this->gDtipDE->gCamCond = $this->gCamCond;
        $this->gDtipDE->gCamItem = $this->items;
        $rde = $this->documentoElectronicoComercialToRDE();
        $rde->DE->gTotSub = $this->gTotSub;
        return $rde;
    }
}
