<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;

use Abiliomp\Pkuatia\Core\Constants\CamCondOpe;
use Abiliomp\Pkuatia\Core\Constants\CamFEIndPres;
use Abiliomp\Pkuatia\Core\Constants\PaConEIniTiPago;
use Abiliomp\Pkuatia\Core\Constants\PagCredCondCred;
use Abiliomp\Pkuatia\Core\Constants\PagTarCDDenTarj;
use Abiliomp\Pkuatia\Core\Constants\PagTarCDForProPa;
use Abiliomp\Pkuatia\Core\Constants\TimbTiDE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamCond;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamFE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCompPub;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCuotas;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPaConEIni;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPagCheq;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPagCred;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPagTarCD;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DateTime;

/**
 * Tipo de Documento Electrónico Sifen: 1 - Factura
 */
class Factura extends DocumentoElectronicoComercial
{
  
  //////////////////////////////////////////
  // Atributos
  //////////////////////////////////////////
  
  public GCamFE $gCamFE; // E010 - Campos que componen la factura electrónica (FE)
  public GCompPub $gCompPub; // E020 - Campos que describen las informaciones de compras públicas
  public GCamCond $gCamCond; // E600 - Campos que describen las condiciones de pago de la factura electrónica
  public GPaConEIni $gPaConEIni; // E605 - Campos que describen las condiciones de pago al contado o de la entrega inicial.


  //////////////////////////////////////////
  // Constructor
  //////////////////////////////////////////
  
  /**
   * Constructor de la clase.
   * 
   * @param CamCondOpe $condicion Condición de operación de la factura electrónica.
   * 
   * @return void
   */
  public function __construct(CamCondOpe $condicion)
  {
    parent::__construct();
    $this->gTimb->setITiDE(TimbTiDE::Factura);
    $this->gCamFE = new GCamFE();
    $this->gCamCond = new GCamCond();
    $this->gCamCond->setICondOpe($condicion);
  }  

  //////////////////////////////////////////
  // Setters
  //////////////////////////////////////////

  /**
   * Establece el indicador de presencia para la emisión de la factura electrónica.
   * Valor OBLIGATORIO.
   * 
   * @param CamFEIndPres $indPres Indicador de presencia.
   * 
   * @return self
   */
  public function setIndicadorPresencia(CamFEIndPres $indPres) : self
  {
    $this->gCamFE->setIIndPres($indPres);
    return $this;
  }

  /**
   * Establece la fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica cuando corresponda.
   * 
   * @param DateTime $fecha Fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica cuando corresponda.
   * 
   * @return self
   */
  public function setFechaDeRemision(DateTime $fecha) : self
  {
    $this->gCamFE->setDFecEmNR($fecha);
    return $this;
  }

  /**
   * Establece los datos adicionales necesarios para facturas electrónicas emitidas a entidades públicas (B2G).
   * Estos valores son obligatorios solo en caso de que el receptor sea una entidad pública.
   * 
   * @param String $codigoDNCPModalidad Código de modalidad emitido por la DNCP.
   * @param String $codigoDNCPEntidad Código de entidad pública emitido por la DNCP.
   * @param int $anho Año de contratación según registros de la DNCP.
   * @param int $nroDNCPSecuencia Número de secuencia del registro de la DNCP.
   */
  public function setDatosComprasPublicas(String $codigoDNCPModalidad, String $codigoDNCPEntidad, int $anho, int $nroDNCPSecuencia) : self
  {
    $this->gCompPub = new GCompPub();
    $this->gCompPub->setDModCont($codigoDNCPModalidad);
    $this->gCompPub->setDEntCont($codigoDNCPEntidad);
    $this->gCompPub->setDAnoCont($anho);
    $this->gCompPub->setDSecCont($nroDNCPSecuencia);
    return $this;
  }

  

  //////////////////////////////////////////
  // Getters
  //////////////////////////////////////////

  //////////////////////////////////////////
  // Otros Métodos
  //////////////////////////////////////////

  /**
   * Agrega un pago en Guaraníes por tarjeta de crédito o débito a la factura electrónica.
   * 
   * @param bool $esTarjetaCredito Indica si el pago es por tarjeta de crédito (true) o débito (false).
   * @param String $monto Monto del pago para uso como decimal tipo BCMath.
   * @param PagTarCDDenTarj $denomTarjeta Denominación de la tarjeta.
   * @param PagTarCDForProPa $formaProc Forma de procesamiento del pago.
   * @param String|null $codAutorizacion Código de autorización de la transacción (opcional).
   * @param String|null $nombreTitular Nombre del titular de la tarjeta (opcional).
   * @param String|null $ult4NroTarjeta Últimos 4 números de la tarjeta (opcional).
   */
  public function addPagoPYGPorTarjeta(
    bool $esTarjetaCredito, 
    String $monto, 
    String|PagTarCDDenTarj $denomTarjeta, 
    PagTarCDForProPa $formaProc, 
    ?String $codAutorizacion, 
    ?String $nombreTitular, 
    ?String $ult4NroTarjeta) : self
  {
    $gPagTarCD = new GPagTarCD();

    if($denomTarjeta instanceof PagTarCDDenTarj) {
      $gPagTarCD->setIDenTarj($denomTarjeta);
    } else {
      $gPagTarCD->setIDenTarj(PagTarCDDenTarj::Otro);
      $gPagTarCD->setDDesDenTarj($denomTarjeta);
    }
    $gPagTarCD->setIForProPa($formaProc);
    $gPagTarCD->setDCodAuOpe($codAutorizacion);
    $gPagTarCD->setDNomTit($nombreTitular);
    $gPagTarCD->setDNumTarj($ult4NroTarjeta);

    $gPaConEIni = new GPaConEIni();
    $gPaConEIni->setITiPago($esTarjetaCredito ? PaConEIniTiPago::TarjetaCredito : PaConEIniTiPago::TarjetaDebito);
    $gPaConEIni->setDMonTiPag($monto);
    $gPaConEIni->setCMoneTiPag('PYG');
    $gPaConEIni->setGPagTarCD($gPagTarCD);
    $this->gCamCond->addGPaConEIni($gPaConEIni);

    return $this;
  }

  /**
   * Agrega un pago en Guaraníes por cheque a la factura electrónica.
   * 
   * @param String $monto Monto del pago para uso como decimal tipo BCMath.
   * @param String $numeroCheque Número de cheque (hasta 8 caracteres)
   * @param String $bancoEmisor Banco emisor del cheque.
   * 
   * @return self
   */
  public function addPagoPYGPorCheque(
    String $monto, 
    String $numeroCheque, 
    String $bancoEmisor) : self
  {
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

  /**
   * Agrega un pago en Dólares por cheque a la factura electrónica.
   * 
   * @param String $monto Monto del pago para uso como decimal tipo BCMath.
   * @param String $tipoCambio Tipo de cambio para la conversión a Guaraníes del monto del pago.
   * @param String $numeroCheque Número de cheque (hasta 8 caracteres)
   * @param String $bancoEmisor Banco emisor del cheque.
   * 
   * @return self
   */
  public function addPagoUSDPorCheque(
    String $monto,
    String $tipoCambio,
    String $numeroCheque, 
    String $bancoEmisor) : self
  {
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

  /**
   * Establece la condicion de crédito a plazo para la factura electrónica.
   * 
   * @param String $descripcionPlazo Descripción del plazo de crédito (Ej.: 30 días)
   * @param String|null $montoEntregaInicial Monto de la entrega inicial expresando en cadena decimal BCMath (opcional).
   * 
   * @return self
   */
  public function setOperacionCreditoAPlazo(String $descripcionPlazo, ?String $montoEntregaInicial) : self
  {
    $gPagCred = new GPagCred();
    $gPagCred->setICondCred(PagCredCondCred::Plazo);
    $gPagCred->setDPlazoCre($descripcionPlazo);
    if($montoEntregaInicial) {
      $gPagCred->setDMonEnt($montoEntregaInicial);
    }
    $this->gCamCond->setGPagCred($gPagCred);
    return $this;
  }

  /**
   * Establece la condicion de crédito en cuotas para la factura electrónica.
   * 
   * @param array $montoCuotas Montos de las cuotas expresados en cadena decimal BCMath.
   * @param array $vencimientos Fechas de vencimiento de las cuotas.
   * @param String|null $monedaCuotas Moneda de las cuotas (opcional, valor por defecto PYG).
   * @param String|null $montoEntregaInicial Monto de la entrega inicial expresando en cadena decimal BCMath (opcional).
   * 
   * @return self
   */
  public function setOperacionCreditoEnCuotas(array $montoCuotas, array $vencimientos, ?String $monedaCuotas, ?String $montoEntregaInicial) : self
  {
    if(count($montoCuotas) != count($vencimientos)) {
      throw new \Exception('[Factura] La cantidad de montos de cuotas y vencimientos no coinciden.');
    }
    if(isset($montoEntregaInicial) && ValueValidations::isValidStringDecimal($montoEntregaInicial, 15, 0, 4) === false) {
      throw new \Exception('[Factura] El monto de la entrega inicial no es una cadena decimal válida para este campo: ' . $montoEntregaInicial);
    }
    $gCuotas = [];
    foreach($montoCuotas as $i => $monto) {
      if(ValueValidations::isValidStringDecimal($monto, 15, 0, 4) === false) {
        throw new \Exception('[Factura] El monto de la cuota ' . ($i + 1) . ' no es un decimal válido: ' . $monto);
      }
      if(!($vencimientos[$i] instanceof DateTime)) {
        throw new \Exception('[Factura] El vencimiento de la cuota ' . ($i + 1) . ' no es una instancia de DateTime.');
      }
      $gCuota = new GCuotas();
      $gCuota->setCMoneCuo(isset($monedaCuotas) ? $monedaCuotas : 'PYG');
      $gCuota->setDMonCuota($monto);
      $gCuota->setDVencCuo($vencimientos[$i]);
      $gCuotas[] = $gCuota;
    }
    $gPagCred = new GPagCred();
    $gPagCred->setICondCred(PagCredCondCred::Cuota);
    $gPagCred->setDCuotas(count($gCuotas));
    $gPagCred->setGCuotas($gCuotas);
    if(isset($montoEntregaInicial)) {
      $gPagCred->setDMonEnt($montoEntregaInicial);
    }
    $this->gCamCond->setGPagCred($gPagCred);
    return $this;
  }
}

?>
