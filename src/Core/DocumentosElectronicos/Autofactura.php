<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos;

use IonysDev\Pkuatia\Config;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Fields\DE\D\GOpeCom;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamAE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamCond;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCuotas;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPaConEIni;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagCheq;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagCred;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagTarCD;
use IonysDev\Pkuatia\Core\Fields\DE\F\GTotSub;
use IonysDev\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use IonysDev\Pkuatia\Utils\RNGMaker;
use IonysDev\Pkuatia\Utils\RucUtils;
use IonysDev\Pkuatia\Helpers\CDCHelper;

/**
 * TIPO SIFEN NRO 4
 */
class Autofactura extends DocumentoElectronico
{
  ////////////////////////////////////
  //Constructor
  ////////////////////////////////////
  public function __construct()
  {
    parent::__construct();
    /////////////////////////////////////////////////////////////////////////////
    ///Inicializar las clases correspondiete a su tipo de documento
    /////////////////////////////////////////////////////////////////////////////
    //D
    //Obligatorio si C002 ≠ 7 No informar si C002 = 7
    $this->rDE->dE->gDatGralOpe->gOpeCom = new GOpeCom();
    //E
    //Obligatorio si C002 = 4 No informar si C002 ≠ 4
    $this->rDE->dE->gDtipDe->gCamAE = new GCamAE();
    //Obligatorio si C002 = 1 o 4 No informar si C002 ≠ 1 o 4
    $this->rDE->dE->gDtipDe->gCamCond = new GCamCond();
    //Obligatorio si E601 = 1 Obligatorio si existe el campo  E642
    if (Config::getInstance()->condicionOperacionComercial == Constants::CONDICION_OPERACION_CONTADO || isset(Config::getInstance()->montoEntregaInicial)) {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni = new GPaConEIni();
    }
    //Se activa si E606 = 3 o 4
    if (Config::getInstance()->tipoPagoOPeracionComercial == Constants::PAGO_TARJETA_DEBITO || Config::getInstance()->tipoPagoOPeracionComercial == Constants::PAGO_TARJETA_CREDITO) {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni->gPagTarCD = new GPagTarCD();
    }
    //Se activa si E606 = 2
    if (Config::getInstance()->tipoPagoOPeracionComercial == Constants::PAGO_CHEQUE) {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni->gPagCheq = new GPagCheq();
    }
    //Obligatorio si E601 = 2 No informar si E601 ≠ 2
    if (Config::getInstance()->condicionOperacionComercial == Constants::CONDICION_OPERACION_CREDITO) {
      $this->rDE->dE->gDtipDe->gCamCond->gPagCred = new GPagCred();
      $this->rDE->dE->gDtipDe->gCamCond->gPagCred->gCuotas = new GCuotas();
    }
    //F Obligatorio si C002 ≠ 7 No informar si C002 = 7 Cuando C002= 4, no informar  F002, F003, F004, F005, F015, F01, F017, F018, F01
    $this->rDE->dE->gTotSub = new GTotSub();
    //H
    //Obligatorio si C002 = 4, 5, 6  Opcional si C002=1 o 7
    $this->rDE->dE->gCamDEAsoc = new GCamDEAsoc();
    /////////////////////////////////////////////////////////////////////////////
    ///antes se debe generator todos los campos que se necesitan para el CDC
    /////////////////////////////////////////////////////////////////////////////
    //Establecimiento
    $this->rDE->dE->gTimb->dEst = Config::getInstance()->establecimiento;
    //Punto de expedición
    $this->rDE->dE->gTimb->dPunExp = Config::getInstance()->puntoExpedicion;
    //Número de documento
    $this->rDE->dE->gTimb->dNumDoc = Config::getInstance()->numeroDocumento;
    //tipo de documento
    $this->rDE->dE->gTimb->iTiDE = Constants::TIPO_DOCUMENTO_AUTOFACTURA;
    //ruc del emisor
    $this->rDE->dE->gDatGralOpe->gEmis->dRucEm = Config::getInstance()->ruc;
    //DV del RUC del emisor
    $this->rDE->dE->gDatGralOpe->gEmis->dDVEmi = RucUtils::calcDV(Config::getInstance()->ruc);
    //Tipo de contribuyente
    $this->rDE->dE->gDatGralOpe->gEmis->iTipCont = Config::getInstance()->tipoContribuyente;
    //tipo de emision
    $this->rDE->dE->gOpeDe->iTipEmi = Constants::TIPO_EMISION_CONTINGENCIA; //REVISAR !!!!
    //Código de Seguridad
    $this->rDE->dE->gOpeDe->dCodSeg = RNGMaker::MakeSegurityCode($this->rDE->dE->gTimb->dNumDoc);
    /////////////////////////////////////////////////////////////////////////////
    ///CDC
    /////////////////////////////////////////////////////////////////////////////
    $this->rDE->dE->iD = CDCHelper::CDCMaker($this->rDE->dE);
    //digito verificador del CDC
    $this->rDE->dE->dDVId = intval(substr($this->rDE->dE->iD, -1));
    //Sistema de facturación
    $this->rDE->dE->dSisFact = Constants::SISTEMA_FACTURACION_CONTRIBUYENTE;
  }
}
