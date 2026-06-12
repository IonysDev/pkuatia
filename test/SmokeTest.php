<?php

/**
 * Script de verificación rápida (smoke test) de PKuatia. No requiere certificado ni conexión al SIFEN.
 * Ejecutar con: php test/SmokeTest.php
 *
 * Verifica:
 *  - Literales oficiales (Tabla 12 NT-018, dDesTImp "IVA - Renta")
 *  - GOblAfe / gOblAfe en GOpeCom (NT-018): setters, serialización y round-trip
 *  - DE::setDSisFact (NT-010)
 *  - RGEveNom (NT-014/NT-027): descripciones y orden de campos según Evento_v150.xsd
 *  - Regla NT-024 (receptor innominado >= 7.000.000 PYG)
 *  - Correlatividad del dId
 *  - Sobres de eventos del receptor (notificación, conformidad, desconocimiento)
 */

require __DIR__ . '/../vendor/autoload.php';

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants\COblAfe;
use IonysDev\Pkuatia\Core\Constants\OpeComTipImp;
use IonysDev\Pkuatia\Core\Constants\RecNat;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\Fields\DE\A\DE;
use IonysDev\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use IonysDev\Pkuatia\Core\Fields\DE\D\GDatRec;
use IonysDev\Pkuatia\Core\Fields\DE\D\GOblAfe;
use IonysDev\Pkuatia\Core\Fields\DE\D\GOpeCom;
use IonysDev\Pkuatia\Core\Fields\DE\F\GTotSub;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\GGroupTiEvt;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\REve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GDE\RGEveNom;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeConf;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeDescon;
use IonysDev\Pkuatia\Core\Fields\Request\Event\GER\RGeVeNotRec;
use IonysDev\Pkuatia\Sifen;

$fails = 0;
function check($cond, $msg)
{
  global $fails;
  if ($cond) {
    echo "OK   $msg\n";
  } else {
    echo "FAIL $msg\n";
    $fails++;
  }
}

// 1. Literales COblAfe: longitud 21-65 (tdDesOblAfe del XSD de producción)
foreach (COblAfe::cases() as $case) {
  $len = mb_strlen($case->getDescription());
  check($len >= 21 && $len <= 65, "COblAfe {$case->value} longitud $len en [21,65]");
}

// 2. dDesTImp con guion ASCII según XSD de producción
check(OpeComTipImp::IVARenta->getDescription() === 'IVA - Renta', "OpeComTipImp::IVARenta = 'IVA - Renta' (guion ASCII)");

// 3. GOblAfe: asignación por enum y por código
$o1 = new GOblAfe();
$o1->setCOblAfe(COblAfe::ImpuestoALaRentaEmpresarialSimple);
check($o1->getCOblAfe() === 701 && is_string($o1->getDDesOblAfe()), "GOblAfe::setCOblAfe(enum) asigna código y descripción");
try {
  (new GOblAfe())->setCOblAfe(999);
  check(false, "GOblAfe con código inválido debe lanzar excepción");
} catch (\InvalidArgumentException $e) {
  check(true, "GOblAfe con código inválido lanza InvalidArgumentException");
}

// 4. gOblAfe en GOpeCom: serialización, posición y round-trip
$gOpeCom = new GOpeCom();
$gOpeCom->setITImp(OpeComTipImp::IVA);
$gOpeCom->addGOblAfe(COblAfe::ImpuestoALaRentaEmpresarialRegimenGeneral);
$gOpeCom->addGOblAfe(211);
$doc = new DOMDocument('1.0', 'UTF-8');
$node = $gOpeCom->toDOMElement($doc);
$doc->appendChild($node);
$xml = $doc->saveXML($node);
check(substr_count($xml, '<gOblAfe>') === 2, "GOpeCom serializa 2 nodos gOblAfe");
check(strrpos($xml, '</gOblAfe></gOpeCom>') !== false, "gOblAfe es el último hijo de gOpeCom");
$parsed = GOpeCom::FromDOMElement($node);
check(count($parsed->getGOblAfe()) === 2 && $parsed->getGOblAfe()[1]->getCOblAfe() === 211, "GOpeCom::FromDOMElement round-trip de gOblAfe");
try {
  $g = new GOpeCom();
  foreach ([113, 143, 211, 311, 321, 700, 701, 702, 703, 715, 716, 113, 143] as $c) {
    $g->addGOblAfe($c);
  }
  check(false, "addGOblAfe nro 13 debe lanzar excepción");
} catch (\InvalidArgumentException $e) {
  check(true, "addGOblAfe respeta el máximo de 12 ocurrencias");
}

// 5. DE::setDSisFact (NT-010: único valor 1)
$de = new DE();
$de->setDSisFact(1);
check($de->getDSisFact() === 1, "DE::setDSisFact(1) acepta el valor");
try {
  $de->setDSisFact(2);
  check(false, "DE::setDSisFact(2) debe lanzar excepción");
} catch (\Exception $e) {
  check(true, "DE::setDSisFact(2) lanza excepción controlada");
}

// 6. RGEveNom: descripción del tipo de documento y orden de campos según Evento_v150.xsd
$nom = new RGEveNom();
$nom->setId(str_repeat('0', 44));
$nom->setMOtEve('Nominación de factura innominada');
$nom->setINatRec(RGEveNom::NATURALEZA_NO_CONTRIBUYENTE);
$nom->setITiOpe(RGEveNom::TIPO_OPERACION_B2C);
$nom->setCPaisRec('PRY');
$nom->setDDesPaisRe('Paraguay');
$nom->setITipIDRec(TipIDRec::CedulaParaguaya);
$nom->setDNumIDRec('1234567');
$nom->setDNomRec('Juan Pérez');
$doc2 = new DOMDocument('1.0', 'UTF-8');
$node2 = $nom->toDOMElement($doc2);
$doc2->appendChild($node2);
$xml2 = $doc2->saveXML($node2);
check($nom->getDDTipIDRec() === 'Cédula paraguaya', "RGEveNom::setITipIDRec asigna la descripción");
check(strpos($xml2, '<Id>') !== false && strpos($xml2, '<id>') === false, "RGEveNom serializa 'Id' con mayúscula");
$posTip = strpos($xml2, '<iTipIDRec>');
$posDes = strpos($xml2, '<dDTipIDRec>');
$posNum = strpos($xml2, '<dNumIDRec>');
check($posTip < $posDes && $posDes < $posNum, "RGEveNom respeta el orden del XSD: iTipIDRec < dDTipIDRec < dNumIDRec");

// 7. NT-024: receptor innominado con total >= 7.000.000 PYG
$deNT = new DE();
$gdgo = new GDatGralOpe();
$gdr = new GDatRec();
$gdr->setINatRec(RecNat::NoContribuyente);
$gdr->setITipIDRec(TipIDRec::Innominado);
$gdgo->setGDatRec($gdr);
$deNT->setGDatGralOpe($gdgo);
$tot = new GTotSub();
$tot->dTotGralOpe = '7000000';
$deNT->gTotSub = $tot;
$validador = new ReflectionMethod(Sifen::class, 'ValidarUmbralInnominadoNT024');
$validador->setAccessible(true);
try {
  $validador->invoke(null, $deNT);
  check(false, "NT-024: innominado con 7M debe lanzar excepción");
} catch (\Exception $e) {
  check(str_contains($e->getMessage(), 'NT-024'), "NT-024: innominado con 7M lanza excepción");
}
$tot->dTotGralOpe = '6999999.99';
try {
  $validador->invoke(null, $deNT);
  check(true, "NT-024: innominado con 6.999.999,99 pasa");
} catch (\Exception $e) {
  check(false, "NT-024: innominado con 6.999.999,99 no debe lanzar: " . $e->getMessage());
}

// 8. Correlatividad del dId (con bloqueo de archivo)
$cfg = new Config();
$cfg->dIdFilePath = sys_get_temp_dir() . '/pkuatia_did_smoketest.json';
@unlink($cfg->dIdFilePath);
$propConfig = new ReflectionProperty(Sifen::class, 'config');
$propConfig->setAccessible(true);
$propConfig->setValue(null, $cfg);
$getDId = new ReflectionMethod(Sifen::class, 'GetDId');
$getDId->setAccessible(true);
$a = $getDId->invoke(null);
$b = $getDId->invoke(null);
check($a === 1 && $b === 2, "GetDId genera valores correlativos");
@unlink($cfg->dIdFilePath);

// 9. Sobre completo de un evento (misma estructura que arma Sifen::RegistrarEventoUnico)
$conf = new RGeVeConf();
$conf->setId(str_repeat('1', 44));
$conf->setITipConf(1);
$gti = new GGroupTiEvt();
$gti->setRGeVeConf($conf);
$rEve = new REve();
$rEve->setId(1);
$rEve->setDFecFirma(new DateTime());
$rEve->setDVerFor(150);
$rEve->setGGroupTiEvt($gti);
$rGesEve = new RGesEve();
$rGesEve->setREve($rEve);
$raiz = new GGroupGesEve();
$raiz->setRGesEve([$rGesEve]);
$xmlEvento = $raiz->toXMLString();
check(strpos($xmlEvento, '<rGeVeConf>') !== false, "El sobre del evento de conformidad serializa rGeVeConf");
check(strpos($xmlEvento, 'rEve Id="1"') !== false, "rEve lleva Id como atributo");

// 10. Eventos del receptor: notificación de recepción y desconocimiento
$not = new RGeVeNotRec();
$not->setId(str_repeat('1', 44));
$not->setDFecEmi(new DateTime());
$not->setDFecRecep(new DateTime());
$not->setITipRec(1);
$not->setDNomRec('Empresa SA');
$not->setDRucRec('80012345');
$not->setDDVRec(5);
$not->setDTotalGs(1500000);
$docN = new DOMDocument('1.0', 'UTF-8');
$nN = $not->toDOMElement($docN);
$docN->appendChild($nN);
$xN = $docN->saveXML($nN);
check(strpos($xN, '<dRucRec>80012345</dRucRec>') !== false && strpos($xN, '<dTotalGs>1500000</dTotalGs>') !== false, "RGeVeNotRec serializa RUC y total");

$des = new RGeVeDescon();
$des->setId(str_repeat('1', 44));
$des->setDFecEmi(new DateTime());
$des->setDFecRecep(new DateTime());
$des->setITipRec(2);
$des->setDNomRec('Juan Pérez');
$des->setDTipIDRec(1);
$des->setDNumID('1234567');
$des->setMOtEve('No corresponde la operación facturada');
$docD = new DOMDocument('1.0', 'UTF-8');
$nD = $des->toDOMElement($docD);
$docD->appendChild($nD);
$xD = $docD->saveXML($nD);
check(strpos($xD, '<dNumID>1234567</dNumID>') !== false && strpos($xD, '<mOtEve>') !== false, "RGeVeDescon serializa documento y motivo");

echo $fails === 0 ? "\nTODO OK\n" : "\n$fails FALLOS\n";
exit($fails === 0 ? 0 : 1);
