<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\AA\RDE;
use Abiliomp\Pkuatia\Core\Utils\RNGMaker;
use Abiliomp\Pkuatia\Core\Utils\SETPyTools;
use Abiliomp\Pkuatia\Helpers\CDCHelper;
class Factura
{
  ///rde
  public $rDE;

  public function __construct($array)
  {
    $this->rDE = new RDE();
    $this->rDE->setDVerFor(Constants::SIFEN_VERSION);
    $this->rDE->setDE(new DE());
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///antes se debe generator todos los campos que se necesitan para el CDC
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///tipo de documento
    $this->rDE->getDE()->getGTimb()->setITiDE(Constants::TIPO_DOCUMENTO_FACTURA);
    //ruc del emisor
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDRucEm($array["dRucEm"]);
    //DV del RUC del emisor
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDDVEmi(SETPyTools::calcDV( $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->getDRucEm()));
    //Establecimiento
    $this->rDE->getDE()->getGTimb()->setDEst($array["dEst"]);
    //Punto de expedición
    $this->rDE->getDE()->getGTimb()->setDPunExp($array["dPunExp"]);
    //Número del documento
    $this->rDE->getDE()->getGTimb()->setDNumDoc($array["dNumDoc"]);
    //Tipo de contribuyente
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setITipCont(Constants::TIPO_CONTRIBUYENTE_PERSONA_FISICA);
    //Fecha de Emisión
    $this->rDE->getDE()->getDDatGralOpe()->setDFeEmiDE($array["dFeEmiDE"]);
    //tipo de emision
    $this->rDE->getDE()->getGOpeDe()->setITipEmi(Constants::TIPO_EMISION_NORMAL);
    //Código de Seguridad
    $this->rDE->getDE()->getGOpeDe()->setDCodSeg(RNGMaker::MakeSegurityCode( $this->rDE->getDE()->gTimb->getDNumDoc()));
    //digito verificado
    $this->rDE->getDE()->setDDVId(SETPyTools::calcDV(strval( $this->rDE->getDE()->getGOpeDe()->getDCodSeg())));
    /////////////////////////////////////////////////////////////////////////////
    ///CDC
    /////////////////////////////////////////////////////////////////////////////
    $this->rDE->getDE()->setID(CDCHelper::CDCMaker( $this->rDE->getDE()));
    //Firma digital
    /////////////////////////////////////////////////////////////////////////////
    //TODO: Firma digital
    /////////////////////////////////////////////////////////////////////////////
    //Fecha de firma
    $this->rDE->getDE()->setDFecFirma( new \DateTime('America/Asuncion'));
    //Sistema de facturación
    $this->rDE->getDE()->setDSisFact(Constants::SISTEMA_FACTURACION_CONTRIBUYENTE);
    //NUMERO TIMBRADO
    $this->rDE->getDE()->getGTimb()->setDNumTim($array["dNumTim"]);
    //Fecha de inicio de timbrado
    $this->rDE->getDE()->getGTimb()->setDFeIniT($array["dFeIniT"]);
    //TIPO DE TRANSACCION
    $this->rDE->getDE()->getDDatGralOpe()->getGOpeCom()->setITipTra(Constants::TIPO_TRANSACCION_VENTA_MERCADERIA);
    //TIPO DE IMPUESTO
    $this->rDE->getDE()->getDDatGralOpe()->getGOpeCom()->setITImp(Constants::TIPO_IMPUESTO_IVA);
    //TIPO DE MONEDA
    $this->rDE->getDE()->getDDatGralOpe()->getGOpeCom()->setCMoneOpe(Constants::MONEDA_BASE);
    

  }

}
