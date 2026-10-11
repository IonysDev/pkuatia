<?php

namespace IonysDev\Pkuatia\Helpers;

use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Utils\RNGMaker;
use IonysDev\Pkuatia\Utils\RucUtils;
use Stringable;

class CDCHelper
{
  private function __construct(){}

  /**
   * Genera el CDC (A002) del DE: tipo de documento, RUC y DV del emisor, establecimiento, punto de expedición, número
   * del documento, tipo de contribuyente, fecha y tipo de emisión, código de seguridad y dígito verificador.
   *
   * @throws \InvalidArgumentException si el resultado no cumple tCDC del XSD (desde 0.2.1; antes devolvía "ERROR: ...").
   */
  public static function Generate(DE $dE): String
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
    // Validación contra tCDC (DE_Types_v150.xsd:23-32): 44 caracteres; el RUC puede terminar en una letra de la A a la D.
    // Hasta 0.2.0 un CDC corto se devolvía como el texto "ERROR: ..." y uno largo o con letras fuera de lugar se devolvía
    // tal cual: los dos terminaban en el atributo Id del DE (PK-38).
    if (!preg_match('/^[0-9]{2}[0-9]{7}[0-9A-D][0-9]{34}$/', $cDC)) {
      throw new \InvalidArgumentException("[CDCHelper] El CDC debe tener 44 caracteres con el formato tCDC del XSD y se obtuvo '$cDC' ("
        . strlen($cDC) . " caracteres): revisar el RUC del emisor (3 a 8 caracteres), el establecimiento, el punto de expedición y el número del documento.");
    }
    return $cDC;
  }
}
