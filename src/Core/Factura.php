<?php

namespace Abiliomp\Pkuatia\Core;

use Abiliomp\Pkuatia\Constants;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\AA\RDE;
use Abiliomp\Pkuatia\Core\Fields\Request\DE\E\GCamItem;
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
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDDVEmi(SETPyTools::calcDV($this->rDE->getDE()->getDDatGralOpe()->getGEmis()->getDRucEm()));
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
    $this->rDE->getDE()->getGOpeDe()->setITipEmi(Constants::TIPO_EMISION_CONTINGENCIA);
    //Código de Seguridad
    $this->rDE->getDE()->getGOpeDe()->setDCodSeg(RNGMaker::MakeSegurityCode($this->rDE->getDE()->gTimb->getDNumDoc()));
    //digito verificado
    $this->rDE->getDE()->setDDVId(SETPyTools::calcDV(strval($this->rDE->getDE()->getGOpeDe()->getDCodSeg())));
    /////////////////////////////////////////////////////////////////////////////
    ///CDC
    /////////////////////////////////////////////////////////////////////////////
    $this->rDE->getDE()->setID(CDCHelper::CDCMaker($this->rDE->getDE()));
    //Firma digital
    /////////////////////////////////////////////////////////////////////////////
    //TODO: Firma digital
    /////////////////////////////////////////////////////////////////////////////
    //Fecha de firma
    $this->rDE->getDE()->setDFecFirma(new \DateTime('America/Asuncion'));
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
    ////nombre emisor
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDNomEmi($array["dNomEmi"]);
    ///direccion emisor
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDDirEmi($array["dDirEmi"]);
    //nro casa
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDNumCas($array["dNumCas"]);
    //departamento
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDDepEmi($array["dDepEmi"]);
    //ciudad
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setCCiuEmi($array["dCiuEmi"]);
    //telefono
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDTelEmi($array["dTelEmi"]);
    //correo
    $this->rDE->getDE()->getDDatGralOpe()->getGEmis()->setDEmailE($array["dEmailE"]);
    ///DATOS RECEPTOR
    $this->rDE->getDE()->getDDatGralOpe()->getGDatRec()->setINatRec($array["iNatRec"]);
    ///tipo de operacion
    $this->rDE->getDE()->getDDatGralOpe()->getGDatRec()->setITiOpe($array["iTiOpe"]);
    ///pais receptor
    $this->rDE->getDE()->getDDatGralOpe()->getGDatRec()->setCPaisRec($array["cPaisRec"]);
    ///tipo id
    $this->rDE->getDE()->getDDatGralOpe()->getGDatRec()->setITipIdRec($array["iTipIDRec"]);
    ///numero id
    $this->rDE->getDE()->getDDatGralOpe()->getGDatRec()->setDNumIdRec($array["dNumIDRec"]);
    ///nombre receptor
    $this->rDE->getDE()->getDDatGralOpe()->getGDatRec()->setDNomRec($array["dNomRec"]);
    ///campos especificos del documento electronico
    $this->rDE->getDE()->getGDtipDe()->getGCamFE()->setIIndPres($array["iIndPres"]);
    // Campos que describen la condición de la operación
    //condicion
    $this->rDE->getDE()->getGDtipDe()->getGCamCond()->setICondOpe($array["iCondOpe"]);
    ///items de la facura
    $items = $array["gCamItem"];
    if (count($items) > 1) {
      for ($i = 0; $i < count($items); $i++) {
        $gCamItem = new GCamItem();
        $gCamItem->setDCodInt($items[$i]["dCodInt"]);
        $gCamItem->setDDesProSer($items[$i]["dDesProSer"]);
        $gCamItem->setCUniMed($items[$i]["cUniMed"]);
        $gCamItem->setDCantProSer($items[$i]["dCantProSer"]);
        $this->rDE->getDE()->getGDtipDe()->pushIntoGCamItem($gCamItem);
      }
    } else {
      $gCamItem = new GCamItem();
      $gCamItem->setDCodInt($items[0]["dCodInt"]);
      $gCamItem->setDDesProSer($items[0]["dDesProSer"]);
      $gCamItem->setCUniMed($items[0]["cUniMed"]);
      $gCamItem->setDCantProSer($items[0]["dCantProSer"]);
      $this->rDE->getDE()->getGDtipDe()->pushIntoGCamItem($gCamItem);
    }
  }
}
