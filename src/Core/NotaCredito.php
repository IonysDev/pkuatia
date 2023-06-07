<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GOpeCom;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamNCDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Utils\RNGMaker;
use Abiliomp\Pkuatia\Core\Utils\SETPyTools;
use Abiliomp\Pkuatia\Helpers\CDCHelper;

/**
 * TIPO NRO 5
 */
class NotaCredito extends DocumentoElectronico
{
  /////////////////////////////////////////////////////////////////////////////
  //constructor
  /////////////////////////////////////////////////////////////////////////////
  public function __construct()
  {
    parent::__construct();
    /////////////////////////////////////////////////////////////////////////////
    ///Inicializar las clases correspondiete a su tipo de documento
    /////////////////////////////////////////////////////////////////////////////
    //D
    $this->rDE->dE->dDatGralOpe->gOpeCom = new GOpeCom();
    //E
    $this->rDE->dE->gDtipDe->gCamNCDE = new GCamNCDE();
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
    $this->rDE->dE->gTimb->iTiDE = Constants::TIPO_DOCUMENTO_NOTA_CREDITO;
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
