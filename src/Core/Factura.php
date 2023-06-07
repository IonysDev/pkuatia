<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Core\DocumentoElectronico;
use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Utils\RNGMaker;
use Abiliomp\Pkuatia\Core\Utils\SETPyTools;
use Abiliomp\Pkuatia\Helpers\CDCHelper;
use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GDatRec;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GOpeCom;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamCond;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamFE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCompPub;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCuotas;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPaConEIni;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagCheq;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagCred;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GPagTarCD;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\F\GTotSub;

class Factura extends DocumentoElectronico
{

  public function __construct()
  {
    parent::__construct();
    /////////////////////////////////////////////////////////////////////////////
    ///Inicializar las clases correspondiete a su tipo de documento
    /////////////////////////////////////////////////////////////////////////////
    //B
    $this->rDE->dE->gOpeDe = new GOpeDE();
    //D
    $this->rDE->dE->dDatGralOpe->gOpeCom = new GOpeCom();
    $this->rDE->dE->dDatGralOpe->gDatRec = new GDatRec();
    //E
    $this->rDE->dE->gDtipDe = new GDtipDE();
    $this->rDE->dE->gDtipDe->gCamFE = new GCamFE();
    //Obligatorio si D202 = 3
    if (Config::getInstance()->tipoOperacionFactura == 3) {
      $this->rDE->dE->gDtipDe->gCamFE->gComPub = new GCompPub();
    }
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
