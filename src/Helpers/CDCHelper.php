<?php

namespace Abiliomp\Pkuatia\Helpers;

use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Utils\RNGMaker;
use Abiliomp\Pkuatia\Utils\RucUtils;

class CDCHelper
{
  private function __construct(){}

  public static function CDCMaker(DE $dE): String
  {
    $cDC = "";
    ///Tipo de documento electrónico
    $iTide = strval($dE->getGTimb()->getITiDE());
    //validation
    if (strlen($iTide) < 2) {
      $iTide = str_pad($iTide, 2, "0", STR_PAD_LEFT);
    }
    //Ruc del emisor
    $dRucEm = $dE->getGDatGralOpe()->getGEmis()->getDRucEm();
    //validation
    if (strlen($dRucEm) < 8) {
      $dRucEm = str_pad($dRucEm, 8, "0", STR_PAD_LEFT);
    }
    //DV del RUC del emisor
    $dDvRucEm = strval($dE->getGDatGralOpe()->getGEmis()->getDDVEmi());
    //Establecimiento
    $dEst = strval($dE->getGTimb()->getDEst());
    //validation
    if (strlen($dEst) < 3) {
      $dEst = str_pad($dEst, 3, "0", STR_PAD_LEFT);
    }
    //Punto de expedición
    $dPunExp = $dE->getGTimb()->getDPunExp();
    //validation
    if (strlen($dPunExp) < 3) {
      $dPunExp = str_pad($dPunExp, 3, "0", STR_PAD_LEFT);
    }
    //Número del documento
    $dNumDoc = $dE->getGTimb()->getDNumDoc();
    //validation
    if (strlen($dNumDoc) < 7) {
      $dNumDoc = str_pad($dNumDoc, 7, "0", STR_PAD_LEFT);
    }
    //Tipo de contribuyente
    $iTipCont =  strval($dE->getGDatGralOpe()->getGEmis()->getITipCont());
    //Fecha de Emisión
    $dFeEmiDE = date_format($dE->getGDatGralOpe()->getDFeEmiDE(), "Ymd");
    //tipo de emision
    $iTipEmi = strval($dE->getGOpeDe()->getITipEmi());
    //codigo de seguridad
    $dCodSeg = strval(str_pad(($dE->getGOpeDe()->getDCodSeg() % 1000000000), 9, "0", STR_PAD_LEFT));
    //digito verificador
    $cDC = $iTide . $dRucEm . $dDvRucEm . $dEst . $dPunExp . $dNumDoc . $iTipCont . $dFeEmiDE . $iTipEmi . $dCodSeg;
    $dDVid =  strval(RucUtils::calcDV($cDC));
    //armado del codigo de control
    $cDC = $cDC . $dDVid;
    //validacion
    if (strlen($cDC) < 44) {
      return "ERROR: El codigo de control no tiene 44 caracteres";
    } else {
      return $cDC;
    }
  }
}
