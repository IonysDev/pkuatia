<?php

namespace IonysDev\Pkuatia\Tests\Unit\Resources;

use DOMDocument;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * Los XSD empaquetados en src/Resources/xsd/ son los de producción del SIFEN (copias de
 * ekuat-ia/04-schemas-xsd/validacion-local/, con schemaLocation relativos y el fix de dEntCont).
 */
final class XsdResourcesTest extends TestCase
{
  private const XSD = [
    'siRecepDE_v150.xsd', 'DE_v150.xsd', 'DE_Types_v150.xsd', 'siRecepEvento_v150.xsd', 'Evento_v150.xsd',
    'Evento_Types_v150.xsd', 'Paises_v100.xsd', 'Departamentos_v141.xsd', 'Monedas_v150.xsd',
    'Unidades_Medida_v141.xsd', 'xmldsig-core-schema.xsd',
  ];

  private const ORIGEN_EKUATIA = __DIR__ . '/../../../docs/sifen-ai/04-schemas-xsd/validacion-local';

  public function testLosOnceXsdExistenYEstanBienFormados(): void
  {
    foreach (self::XSD as $nombre) {
      $ruta = XsdAssertions::XSD_DIR . '/' . $nombre;
      $this->assertFileExists($ruta);
      $doc = new DOMDocument();
      $this->assertTrue(@$doc->load($ruta), "$nombre no está bien formado");
    }
  }

  public function testLosIncludesSonRelativosYElFixDeDEntContEstaAplicado(): void
  {
    $de = file_get_contents(XsdAssertions::XSD_DIR . '/DE_v150.xsd');
    $this->assertStringNotContainsString('https://ekuatia.set.gov.py', $de, 'los schemaLocation deben ser relativos');
    $this->assertSame(1, substr_count($de, 'name="dEntCont"'), 'dEntCont debe declararse sin espacio final');
    $this->assertSame(0, substr_count($de, 'name="dEntCont "'));
    foreach (['siRecepDE_v150.xsd', 'siRecepEvento_v150.xsd', 'Evento_v150.xsd'] as $nombre) {
      $this->assertStringNotContainsString('https://ekuatia.set.gov.py', file_get_contents(XsdAssertions::XSD_DIR . '/' . $nombre), $nombre);
    }
  }

  /**
   * Las copias deben seguir a ekuat-ia (fuente de verdad). Se compara el contenido normalizando el
   * fin de línea (git puede convertir LF/CRLF según la plataforma). Si docs/sifen-ai no está
   * (p. ej. en CI), la prueba se omite: la carpeta es local y está excluida del repositorio.
   */
  public function testLasCopiasCoincidenConEkuatIa(): void
  {
    if (!is_dir(self::ORIGEN_EKUATIA)) {
      $this->markTestSkipped('docs/sifen-ai/04-schemas-xsd/validacion-local no está disponible en este entorno.');
    }
    foreach (self::XSD as $nombre) {
      $local = str_replace("\r\n", "\n", file_get_contents(XsdAssertions::XSD_DIR . '/' . $nombre));
      $origen = str_replace("\r\n", "\n", file_get_contents(self::ORIGEN_EKUATIA . '/' . $nombre));
      $this->assertSame(md5($origen), md5($local), "$nombre difiere de ekuat-ia: copiar de nuevo desde validacion-local/ (ver src/Resources/xsd/README.md)");
    }
  }

  public function testLaCadenaDeIncludesCompilaYUnaFacturaFirmadaValida(): void
  {
    $env = SifenTestEnvironment::init();
    try {
      $xml = DocumentoFactory::firmar(DocumentoFactory::facturaContado(1)->facturaToRDE());
      XsdAssertions::assertRdeValido($xml, 'FE contado de referencia');
    } finally {
      ($env['cleanup'])();
    }
  }

  public function testUnDocumentoInvalidoSeReportaConElCampo(): void
  {
    $xml = '<rDE xmlns="http://ekuatia.set.gov.py/sifen/xsd"><dVerFor>150</dVerFor></rDE>';
    XsdAssertions::assertRdeInvalidoPor($xml, 'DE');
  }
}
