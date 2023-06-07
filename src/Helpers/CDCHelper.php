<?php

namespace Abiliomp\Pkuatia\Helpers;

use Abiliomp\Pkuatia\Core\Fields\Request\DE\A\DE;
use Abiliomp\Pkuatia\Core\Utils\RNGMaker;
use Abiliomp\Pkuatia\Core\Utils\SETPyTools;

class CDCHelper
{
  public function __construct()
  {
  }

  public static function CDCMaker(DE $dE): string
  {
    $cDC = "";
    ///Tipo de documento electrónico
    $iTide = strval($dE->getGTimb()->getITiDE());
    //validation
    if (strlen($iTide) < 2) {
      $iTide = str_pad($iTide, 2, "0", STR_PAD_LEFT);
    }
    //Ruc del emisor
    $dRucEm = $dE->getDDatGralOpe()->getGEmis()->getDRucEm();
    //validation
    if (strlen($dRucEm) < 8) {
      $dRucEm = str_pad($dRucEm, 8, "0", STR_PAD_LEFT);
    }
    //DV del RUC del emisor
    $dDvRucEm = strval($dE->getDDatGralOpe()->getGEmis()->getDDVEmi());
    //Establecimiento
    $dEst = strval($dE->getGTimb()->getDEst());
    //validation
    if (strlen($dEst) < 3) {
      $dEst = str_pad($dEst, 3, "0", STR_PAD_LEFT);
    }
    //Punto de expedición
    $dPunExp = strval($dE->getGTimb()->getDPunExp());
    //validation
    if (strlen($dPunExp) < 3) {
      $dPunExp = str_pad($dPunExp, 3, "0", STR_PAD_LEFT);
    }
    //Número del documento
    $dNumDoc = strval($dE->getGTimb()->getDNumDoc());
    //validation
    if (strlen($dNumDoc) < 7) {
      $dNumDoc = str_pad($dNumDoc, 7, "0", STR_PAD_LEFT);
    }
    //Tipo de contribuyente
    $iTipCont =  strval($dE->getDDatGralOpe()->getGEmis()->getITipCont());
    //Fecha de Emisión
    $dFeEmiDE = date_format($dE->getDDatGralOpe()->getDFeEmiDE(), "Ymd");
    //tipo de emision
    $iTipEmi = strval($dE->getGOpeDe()->getITipEmi());
    //codigo de seguridad
    $dCodSeg = strval(str_pad(($dE->getGOpeDe()->getDCodSeg() % 1000000000), 9, "0", STR_PAD_LEFT));
    //digito verificador
    $cDC = $iTide . $dRucEm . $dDvRucEm . $dEst . $dPunExp . $dNumDoc . $iTipCont . $dFeEmiDE . $iTipEmi . $dCodSeg;
    $dDVid =  strval(SETPyTools::calcDV($cDC));
    //armado del codigo de control
    $cDC = $cDC . $dDVid;
    //validacion
    if (strlen($cDC) < 44) {
      return "ERROR: El codigo de control no tiene 44 caracteres";
    } else {
      return $cDC;
    }
  }

  public static function decryptCDC($cdc)
  {
    $Test = "TIPO DE DOCUMENTO ELECTRONICO: " . substr($cdc, 0, 2) . PHP_EOL.
    "RUC DEL EMISOR: " . substr($cdc, 2, 8) . PHP_EOL.
    "DV DEL RUC DEL EMISOR: " . substr($cdc, 10, 1) . PHP_EOL.
    "ESTABLECIMIENTO: " . substr($cdc, 11, 3) . PHP_EOL.
    "PUNTO DE EXPEDICION: " . substr($cdc, 14, 3) . PHP_EOL.
    "NUMERO DEL DOCUMENTO: " . substr($cdc, 17, 7) . PHP_EOL.
    "TIPO DE CONTRIBUYENTE: " . substr($cdc, 24, 1) . PHP_EOL.
    "FECHA DE EMISION: " . substr($cdc, 25, 8) . PHP_EOL.
    "TIPO DE EMISION: " . substr($cdc, 33, 1) . PHP_EOL.
    "CODIGO DE SEGURIDAD: " . substr($cdc, 34, 9) . PHP_EOL.
    "DIGITO VERIFICADOR: " . substr($cdc, 43, 1) . PHP_EOL;
    return $Test;
  }
}
