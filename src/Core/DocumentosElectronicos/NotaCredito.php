<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\D\GOpeCom;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamNCDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\H\GCamDEAsoc;
use Abiliomp\Pkuatia\Utils\RNGMaker;
use Abiliomp\Pkuatia\Utils\RucUtils;
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
    //Obligatorio si C002 ≠ 7 No informar si C002 = 7
    $this->rDE->dE->gDatGralOpe->gOpeCom = new GOpeCom();
    //E
    //Obligatorio si C002 = 5 o 6 (NCE y NDE)No informar si C002 ≠ 5 o 6
    $this->rDE->dE->gDtipDe->gCamNCDE = new GCamNCDE();
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
    $this->rDE->dE->gTimb->iTiDE = Constants::TIPO_DOCUMENTO_NOTA_CREDITO;
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
