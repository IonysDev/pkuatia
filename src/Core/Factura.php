<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Core\DocumentoElectronico;
use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Utils\RNGMaker;
use Abiliomp\Pkuatia\Core\Utils\SETPyTools;
use Abiliomp\Pkuatia\Helpers\CDCHelper;
use Abiliomp\Pkuatia\Config;

class Factura extends DocumentoElectronico
{  

  public function __construct()
  {
    parent::__construct();
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///antes se debe generator todos los campos que se necesitan para el CDC
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///tipo de documento
    $this->rDE->getDE()->getGTimb()->setITiDE(Constants::TIPO_DOCUMENTO_FACTURA);
    //ruc del emisor
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDRucEm(Config::getInstance()->ruc);
    //DV del RUC del emisor
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDDVEmi(SETPyTools::calcDV(Config::getInstance()->ruc));
    //Tipo de contribuyente
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setITipCont(Config::getInstance()->tipoContribuyente);
    //tipo de emision
    $this->rDE->getDE()->getGOpeDe()->setITipEmi(Constants::TIPO_EMISION_CONTINGENCIA); // REVISAR !!!
    //Código de Seguridad
    $this->rDE->getDE()->getGOpeDe()->setDCodSeg(RNGMaker::MakeSegurityCode($this->rDE->getDE()->gTimb->getDNumDoc()));
    /////////////////////////////////////////////////////////////////////////////
    ///CDC
    /////////////////////////////////////////////////////////////////////////////
    $this->rDE->getDE()->setID(CDCHelper::CDCMaker($this->rDE->getDE()));
    //digito verificador
    $this->rDE->getDE()->setDDVId(intval(substr($this->rDE->getDE()->getID(), -1)));
    //Sistema de facturación
    $this->rDE->getDE()->setDSisFact(Constants::SISTEMA_FACTURACION_CONTRIBUYENTE);
    
  }
}
