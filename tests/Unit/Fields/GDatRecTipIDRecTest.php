<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use DOMDocument;
use InvalidArgumentException;
use IonysDev\Pkuatia\Core\Constants\RecNat;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\Fields\DE\D\GDatRec;
use PHPUnit\Framework\TestCase;

/**
 * Regresión de la regla del campo D209 (dDTipIDRec) cuando D208 (iTipIDRec) es 9 (Otro):
 * la descripción es de texto libre, obligatoria y de 9 a 41 caracteres.
 */
final class GDatRecTipIDRecTest extends TestCase
{
  private function nuevoReceptorNoContribuyente(): GDatRec
  {
    $g = new GDatRec();
    $g->setINatRec(RecNat::NoContribuyente);
    $g->setCPaisRec('PRY');
    $g->setDNomRec('Cliente Prueba');
    return $g;
  }

  private function toXml(GDatRec $g): string
  {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $node = $g->toDOMElement($doc);
    $doc->appendChild($node);
    return $doc->saveXML($node);
  }

  public function testOtroSinDescripcionLanzaExcepcionAlConformar(): void
  {
    $g = $this->nuevoReceptorNoContribuyente();
    $g->setITipIDRec(TipIDRec::Otro);
    $g->setDNumIDRec('123456');

    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessageMatches('/dDTipIDRec.*D209.*obligatori/i');
    $this->toXml($g);
  }

  public function testOtroConDescripcionDemasiadoCortaLanzaExcepcion(): void
  {
    $g = $this->nuevoReceptorNoContribuyente();
    $g->setITipIDRec(TipIDRec::Otro);
    $g->setDDTipIDRec('12345678'); // 8 caracteres
    $g->setDNumIDRec('123456');

    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessageMatches('/entre 9 y 41 caracteres/i');
    $this->toXml($g);
  }

  public function testOtroConDescripcionDemasiadoLargaLanzaExcepcion(): void
  {
    $g = $this->nuevoReceptorNoContribuyente();
    $g->setITipIDRec(TipIDRec::Otro);
    $g->setDDTipIDRec(str_repeat('A', 42)); // 42 caracteres
    $g->setDNumIDRec('123456');

    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessageMatches('/entre 9 y 41 caracteres/i');
    $this->toXml($g);
  }

  public function testOtroConDescripcionValidaEmiteElValorLibre(): void
  {
    $g = $this->nuevoReceptorNoContribuyente();
    $g->setITipIDRec(TipIDRec::Otro);
    $g->setDDTipIDRec('Licencia de conducir'); // 20 caracteres
    $g->setDNumIDRec('123456');

    $xml = $this->toXml($g);
    $this->assertStringContainsString('<dDTipIDRec>Licencia de conducir</dDTipIDRec>', $xml);
    $this->assertSame('Licencia de conducir', $g->getDDTipIDRec());
  }

  public function testOtroCuentaCaracteresMultibyteNoBytes(): void
  {
    $g = $this->nuevoReceptorNoContribuyente();
    $g->setITipIDRec(TipIDRec::Otro);
    $g->setDDTipIDRec('Cédula ñá'); // 9 caracteres (con tildes/ñ) — válido aunque ocupe más bytes
    $g->setDNumIDRec('123456');

    $xml = $this->toXml($g);
    $this->assertStringContainsString('<dDTipIDRec>Cédula ñá</dDTipIDRec>', $xml);
  }

  public function testSetDDTipIDRecAntesDeSetITipIDRecNoSePierde(): void
  {
    $g = $this->nuevoReceptorNoContribuyente();
    $g->setDDTipIDRec('Documento militar PY'); // descripción establecida primero
    $g->setITipIDRec(TipIDRec::Otro);          // no debe sobreescribir la descripción
    $g->setDNumIDRec('123456');

    $this->assertSame('Documento militar PY', $g->getDDTipIDRec());
    $xml = $this->toXml($g);
    $this->assertStringContainsString('<dDTipIDRec>Documento militar PY</dDTipIDRec>', $xml);
  }

  public function testTipoEstandarConservaDescripcionAutomatica(): void
  {
    $g = $this->nuevoReceptorNoContribuyente();
    $g->setITipIDRec(TipIDRec::CedulaParaguaya);
    $g->setDNumIDRec('1234567');

    $xml = $this->toXml($g);
    $this->assertSame('Cédula paraguaya', $g->getDDTipIDRec());
    $this->assertStringContainsString('<dDTipIDRec>Cédula paraguaya</dDTipIDRec>', $xml);
  }
}
