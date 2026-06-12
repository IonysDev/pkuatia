<?php

namespace IonysDev\Pkuatia\Tests\Unit;

use DateTime;
use DOMDocument;
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
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Port de test/SmokeTest.php a PHPUnit (el script original se mantiene intacto).
 */
final class SmokeTestPortedTest extends TestCase
{
  public function testCOblAfeLiteralLengths(): void
  {
    foreach (COblAfe::cases() as $case) {
      $len = mb_strlen($case->getDescription());
      $this->assertGreaterThanOrEqual(21, $len, "COblAfe {$case->value}");
      $this->assertLessThanOrEqual(65, $len, "COblAfe {$case->value}");
    }
  }

  public function testOpeComTipImpIvaRentaLiteral(): void
  {
    $this->assertSame('IVA - Renta', OpeComTipImp::IVARenta->getDescription());
  }

  public function testGOblAfeSettersAndValidation(): void
  {
    $o1 = new GOblAfe();
    $o1->setCOblAfe(COblAfe::ImpuestoALaRentaEmpresarialSimple);
    $this->assertSame(701, $o1->getCOblAfe());
    $this->assertIsString($o1->getDDesOblAfe());

    $this->expectException(\InvalidArgumentException::class);
    (new GOblAfe())->setCOblAfe(999);
  }

  public function testGOpeComGOblAfeSerializationAndRoundTrip(): void
  {
    $gOpeCom = new GOpeCom();
    $gOpeCom->setITImp(OpeComTipImp::IVA);
    $gOpeCom->addGOblAfe(COblAfe::ImpuestoALaRentaEmpresarialRegimenGeneral);
    $gOpeCom->addGOblAfe(211);

    $doc = new DOMDocument('1.0', 'UTF-8');
    $node = $gOpeCom->toDOMElement($doc);
    $doc->appendChild($node);
    $xml = $doc->saveXML($node);

    $this->assertSame(2, substr_count($xml, '<gOblAfe>'));
    $this->assertNotFalse(strrpos($xml, '</gOblAfe></gOpeCom>'));

    $parsed = GOpeCom::FromDOMElement($node);
    $this->assertCount(2, $parsed->getGOblAfe());
    $this->assertSame(211, $parsed->getGOblAfe()[1]->getCOblAfe());
  }

  public function testGOpeComMaxTwelveGOblAfe(): void
  {
    $g = new GOpeCom();
    $this->expectException(\InvalidArgumentException::class);
    foreach ([113, 143, 211, 311, 321, 700, 701, 702, 703, 715, 716, 113, 143] as $c) {
      $g->addGOblAfe($c);
    }
  }

  public function testDESetDSisFact(): void
  {
    $de = new DE();
    $de->setDSisFact(1);
    $this->assertSame(1, $de->getDSisFact());

    $this->expectException(\Exception::class);
    $de->setDSisFact(2);
  }

  public function testRGEveNomDescriptionAndFieldOrder(): void
  {
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

    $doc = new DOMDocument('1.0', 'UTF-8');
    $node = $nom->toDOMElement($doc);
    $doc->appendChild($node);
    $xml = $doc->saveXML($node);

    $this->assertSame('Cédula paraguaya', $nom->getDDTipIDRec());
    $this->assertStringContainsString('<Id>', $xml);
    $this->assertStringNotContainsString('<id>', $xml);

    $posTip = strpos($xml, '<iTipIDRec>');
    $posDes = strpos($xml, '<dDTipIDRec>');
    $posNum = strpos($xml, '<dNumIDRec>');
    $this->assertTrue($posTip < $posDes && $posDes < $posNum);
  }

  public function testNT024InnominadoThreshold(): void
  {
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
      $this->fail('NT-024: innominado con 7M debe lanzar excepción');
    } catch (\Exception $e) {
      $this->assertStringContainsString('NT-024', $e->getMessage());
    }

    $tot->dTotGralOpe = '6999999.99';
    $validador->invoke(null, $deNT);
    $this->addToAssertionCount(1);
  }

  public function testGetDIdCorrelativityWithFlock(): void
  {
    $cfg = new Config();
    $cfg->dIdFilePath = sys_get_temp_dir() . '/pkuatia_did_phpunit_' . uniqid('', true) . '.json';

    $propConfig = new ReflectionProperty(Sifen::class, 'config');
    $propConfig->setAccessible(true);
    $propConfig->setValue(null, $cfg);

    $getDId = new ReflectionMethod(Sifen::class, 'GetDId');
    $getDId->setAccessible(true);

    $a = $getDId->invoke(null);
    $b = $getDId->invoke(null);
    $this->assertSame(1, $a);
    $this->assertSame(2, $b);

    @unlink($cfg->dIdFilePath);
  }

  public function testReceptorEventEnvelopes(): void
  {
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

    $this->assertStringContainsString('<rGeVeConf>', $xmlEvento);
    $this->assertStringContainsString('rEve Id="1"', $xmlEvento);

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
    $this->assertStringContainsString('<dRucRec>80012345</dRucRec>', $xN);
    $this->assertStringContainsString('<dTotalGs>1500000</dTotalGs>', $xN);

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
    $this->assertStringContainsString('<dNumID>1234567</dNumID>', $xD);
    $this->assertStringContainsString('<mOtEve>', $xD);
  }
}
