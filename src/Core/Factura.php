<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Core\DocumentoElectronico;
use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Utils\RNGMaker;
use Abiliomp\Pkuatia\Core\Utils\SETPyTools;
use Abiliomp\Pkuatia\Helpers\CDCHelper;
use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GOpeCom;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamCond;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamFE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCompPub;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCuotas;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPaConEIni;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagCheq;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagCred;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagTarCD;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\G\GCamCarg;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\H\GCamDEAsoc;

/**
 * TIPO SIFEN NRO 1
 */
class Factura extends DocumentoElectronico
{
  //////////////////////////////////////////
  //CONSTRUCTOR
  //////////////////////////////////////////
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
    //Obligatorio si C002 = 1 No informar si C002 ≠ 1
    $this->rDE->dE->gDtipDe->gCamFE = new GCamFE();
    //Obligatorio si D202 = 3 (Tipo de operación B2G)
    if(Config::getInstance()->tipoOperacionComercial == Constants::TIPO_OPERACION_B2G)
    {
      $this->rDE->dE->gDtipDe->gCamFE->gComPub = new GCompPub();
    }
    //Obligatorio si C002 = 1 o 4 No informar si C002 ≠ 1 o 4
    $this->rDE->dE->gDtipDe->gCamCond = new GCamCond();
    //Obligatorio si E601 = 1 Obligatorio si existe el campo  E642
    if(Config::getInstance()->condicionOperacionComercial == Constants::CONDICION_OPERACION_CONTADO || isset(Config::getInstance()->montoEntregaInicial))
    {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni = new GPaConEIni();
    }
    //Se activa si E606 = 3 o 4
    if(Config::getInstance()->tipoPagoOPeracionComercial == Constants::PAGO_TARJETA_DEBITO || Config::getInstance()->tipoPagoOPeracionComercial == Constants::PAGO_TARJETA_CREDITO)
    {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni->gPagTarCD = new GPagTarCD();
    }
    //Se activa si E606 = 2
    if(Config::getInstance()->tipoPagoOPeracionComercial == Constants::PAGO_CHEQUE)
    {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni->gPagCheq = new GPagCheq();
    }
    //Obligatorio si E601 = 2 No informar si E601 ≠ 2
    if(Config::getInstance()->condicionOperacionComercial == Constants::CONDICION_OPERACION_CREDITO)
    {
      $this->rDE->dE->gDtipDe->gCamCond->gPagCred = new GPagCred();
    }
    $this->rDE->dE->gDtipDe->gCamCond->gPagCred->gCuotas = new GCuotas();
    //F
    $this->rDE->dE->gTotSub = new GTotSub();
    //G
    //Opcional cuando C002=1 o C002=7 No informar si C002 ≠ 1 o 7
    $this->rDE->dE->gCamGen->gCamCarg = new GCamCarg();
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
    $this->rDE->dE->gTimb->iTiDE = Constants::TIPO_DOCUMENTO_FACTURA;
    //ruc del emisor
    $this->rDE->dE->gDatGralOpe->gEmis->dRucEm = Config::getInstance()->ruc;
    //DV del RUC del emisor
    $this->rDE->dE->gDatGralOpe->gEmis->dDVEmi = SETPyTools::calcDV(Config::getInstance()->ruc);
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
  }
}
