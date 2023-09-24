<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamEnt;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamNRE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamSal;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamTrans;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GTransp;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GVehTras;
use Abiliomp\Pkuatia\Core\Fields\DE\G\GCamCarg;
use Abiliomp\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use Abiliomp\Pkuatia\Utils\RNGMaker;
use Abiliomp\Pkuatia\Utils\RucUtils;
use Abiliomp\Pkuatia\Helpers\CDCHelper;

/**
 * TIPO NR 7
 */
class NotaRemision extends DocumentoElectronico
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
    //Obligatorio si C002 = 7 No informar si C002 ≠ 7
    $this->rDE->dE->gDtipDe->gCamNRE = new GCamNRE();
    //Obligatorio si C002 = 7 opcional si C002 = 1 No informar si C002= 4, 5, 6
    $this->rDE->dE->gDtipDe->gTransp = new GTransp();
    //Obligatorio si C002 = 7 Opcional si C002 = 1 No informar si C002 = 4, 5, 6
    $this->rDE->dE->gDtipDe->gTransp->gCamSal = new GCamSal();
    //Obligatorio si C002 = 7 No informar si C002 = 4, 5, 6
    $this->rDE->dE->gDtipDe->gTransp->gCamEnt = new GCamEnt();
    //Obligatorio si C002 = 7 No informar si C002 = 4, 5, 6
    $this->rDE->dE->gDtipDe->gTransp->gVehTras = new GVehTras();
    //Obligatorio si C002 = 7 No informar si C002 = 4, 5, 6 Opcional cuando E903=1 y  E967=1
    $this->rDE->dE->gDtipDe->gTransp->gCamTrans = new GCamTrans();
    //Opcional cuando C002=1 o C002=7 No informar para C002 ≠ 1 y  C002≠7
    $this->rDE->dE->gCamGen->gCamCarg = new GCamCarg();
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
    $this->rDE->dE->gTimb->iTiDE = Constants::TIPO_DOCUMENTO_COMPROBANTE_RETENCION;
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
  }
}
