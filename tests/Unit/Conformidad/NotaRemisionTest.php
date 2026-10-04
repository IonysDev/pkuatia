<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use DOMDocument;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamTrans;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * PK-11: en el XSD de producción `dDomFisc` (DE_v150.xsd:973) y `dDirChof` (:986) son obligatorios
 * en gCamTrans (NT-010, RG 41/2014); la librería los trataba como opcionales y `validar()` no los
 * exigía. Además `GVehTras` impedía identificar el vehículo por matrícula (E967 = 2) y emitía el
 * número de identificación en `dNroMatVeh`.
 */
final class NotaRemisionTest extends TestCase
{
  /** @var callable */
  private $cleanup;

  protected function setUp(): void
  {
    $this->cleanup = SifenTestEnvironment::init()['cleanup'];
  }

  protected function tearDown(): void
  {
    ($this->cleanup)();
  }

  public function testNotaDeRemisionCompletaValida(): void
  {
    $nr = DocumentoFactory::notaDeRemision(20, true);
    $nr->validar();
    $xml = DocumentoFactory::firmar($nr->notaDeRemisionToRDE());
    XsdAssertions::assertRdeValido($xml, 'NR completa');
    $this->assertStringContainsString('<dDomFisc>Domicilio fiscal del transportista 123</dDomFisc>', $xml);
    $this->assertStringContainsString('<dDirChof>Direccion del chofer 456</dDirChof>', $xml);
  }

  public function testSinDomicilioFiscalNiDireccionDelChoferValidarLoRechazaConMensajeClaro(): void
  {
    $nr = DocumentoFactory::notaDeRemision(21, false);
    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/dDomFisc[\s\S]*dDirChof/');
    $nr->validar();
  }

  public function testVehiculoIdentificadoPorMatriculaValida(): void
  {
    $nr = DocumentoFactory::notaDeRemision(22, true, true);
    $xml = DocumentoFactory::firmar($nr->notaDeRemisionToRDE());
    XsdAssertions::assertRdeValido($xml, 'NR con vehículo por matrícula');
    $this->assertStringContainsString('<dTipIdenVeh>2</dTipIdenVeh>', $xml);
    $this->assertStringContainsString('<dNroMatVeh>ABC123</dNroMatVeh>', $xml);
    $this->assertStringNotContainsString('<dNroIDVeh>', $xml);
  }
  public function testTransportistaSinDomicilioFiscalNoSeSerializaYElMensajeIndicaElCampo(): void
  {
    $t = new GCamTrans();
    $t->setINatTrans(2);
    $t->setDNomTrans('Transportista Juan');
    $t->setITipIDTrans(1);
    $t->setDNumIDTrans('4123456');
    $t->setDNumIDChof('4123456');
    $t->setDNomChof('Chofer Pedro Gomez');
    $t->setDDirChof('Direccion del chofer 456');
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessageMatches('/dDomFisc \(E992/');
    $t->toDOMElement(new DOMDocument());
  }

  public function testNotaDeRemisionSinNacionalidadDelTransportistaValida(): void
  {
    $nr = DocumentoFactory::notaDeRemision(23, true);
    unset($nr->gTransp->gCamTrans->cNacTrans); // E988 es opcional (DE_v150.xsd:968); antes se emitía sin guarda
    $nr->validar();
    $xml = DocumentoFactory::firmar($nr->notaDeRemisionToRDE());
    XsdAssertions::assertRdeValido($xml, 'NR sin nacionalidad del transportista');
    $this->assertStringNotContainsString('<cNacTrans>', $xml);
  }
}
