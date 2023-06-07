<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GDatRec;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GOpeCom;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamAE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamCond;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCompPub;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCuotas;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPaConEIni;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagCheq;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagCred;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagTarCD;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\H\GCamDEAsoc;
use Abiliomp\Pkuatia\Core\Utils\RNGMaker;
use Abiliomp\Pkuatia\Core\Utils\SETPyTools;
use Abiliomp\Pkuatia\Helpers\CDCHelper;

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
    $this->rDE->dE->dDatGralOpe->gOpeCom = new GOpeCom();
    //E
    $this->rDE->dE->gDtipDe->gCamAE = new GCamAE();
    $this->rDE->dE->gDtipDe->gCamCond = new GCamCond();
    ///Obligatorio si E601 = 1 Obligatorio si existe el campo E645
    if (Config::getInstance()->condicionOperacion == 1 || isset(Config::getInstance()->montoEntregaInicial)) {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni = new GPaConEIni();
    }
    //Se activa si E606 = 3 o 4
    if (Config::getInstance()->tipoDePagoOperacion == 3 || Config::getInstance()->tipoDePagoOperacion == 4) {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni->gPagTarCD = new GPagTarCD();
    } else if (Config::getInstance()->tipoDePagoOperacion == 2) ///si es dos
    {
      $this->rDE->dE->gDtipDe->gCamCond->gPaConEIni->gPagCheq = new GPagCheq();
    }
    //Obligatorio si E601 = 2 No informar si E601 ≠ 2
    if (Config::getInstance()->condicionOperacion == 2) {
      $this->rDE->dE->gDtipDe->gCamCond->gPagCred = new GPagCred();
    }
    $this->rDE->dE->gDtipDe->gCamCond->gPagCred->gCuotas = new GCuotas();
    $this->rDE->dE->gDtipDe->gCamItem = [];
    //F 
    $this->rDE->dE->gTotSub = new GTotSub();
    //H
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
    $this->rDE->dE->dDatGralOpe->gEmis->dRucEm = Config::getInstance()->ruc;
    //DV del RUC del emisor
    $this->rDE->dE->dDatGralOpe->gEmis->dDVEmi = SETPyTools::calcDV(Config::getInstance()->ruc);
    //Tipo de contribuyente
    $this->rDE->dE->dDatGralOpe->gEmis->iTipCont = Config::getInstance()->tipoContribuyente;
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
