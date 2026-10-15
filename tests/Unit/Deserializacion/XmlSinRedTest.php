<?php

namespace IonysDev\Pkuatia\Tests\Unit\Deserializacion;

use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;
use IonysDev\Pkuatia\Core\Fields\Response\DE\RContDe;
use IonysDev\Pkuatia\Core\Fields\Response\RProtDe;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use PHPUnit\Framework\TestCase;

/**
 * Fase C, C12 (evaluación §9): el XML que viene del SIFEN se parsea con LIBXML_NONET y sin sustituir entidades, así
 * que una DTD o una entidad externa en una respuesta no provoca ninguna lectura de archivos ni de red. Lo observable
 * sin red es que el contenido referido nunca aparece en lo leído.
 */
final class XmlSinRedTest extends TestCase
{
  private string $archivoSecreto;

  protected function setUp(): void
  {
    $this->archivoSecreto = tempnam(sys_get_temp_dir(), 'pkuatia_secreto_');
    file_put_contents($this->archivoSecreto, 'CONTENIDO-QUE-NO-DEBE-LEERSE');
  }

  protected function tearDown(): void
  {
    @unlink($this->archivoSecreto);
  }

  private function doctype(string $raiz): string
  {
    $uri = 'file:///' . str_replace('\\', '/', $this->archivoSecreto);
    return "<!DOCTYPE $raiz SYSTEM \"http://127.0.0.1:9/no-existe.dtd\" [<!ENTITY secreto SYSTEM \"$uri\">]>";
  }

  public function testRProtDeNoExpandeEntidadesExternas(): void
  {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . $this->doctype('rProtDe')
      . '<rProtDe><dId>1</dId><dFecProc>2026-10-11T10:00:00</dFecProc><dEstRes>Rechazado</dEstRes><dProtAut>0</dProtAut>'
      . '<gResProc><dCodRes>0160</dCodRes><dMsgRes>XML &secreto; mal formado</dMsgRes></gResProc></rProtDe>';
    $r = RProtDe::FromXMLString($xml);
    $this->assertSame('0160', $r->getGResProc()[0]->getDCodRes());
    $this->assertStringNotContainsString('CONTENIDO-QUE-NO-DEBE-LEERSE', $r->getGResProc()[0]->getDMsgRes());
  }

  /** FromXContenDE recorta desde <rDE>, así que una DOCTYPE previa nunca llega al parser y la entidad queda sin definir. */
  public function testXContenDENoExpandeEntidadesExternas(): void
  {
    $rde = F::rde(F::facturaContado())->toXMLString();
    $conEntidad = str_replace('<dDesProSer>Producto de ejemplo</dDesProSer>', '<dDesProSer>Producto &secreto;</dDesProSer>', $rde);
    $this->assertStringContainsString('&secreto;', $conEntidad);
    $xContenDE = '<?xml version="1.0" encoding="UTF-8"?>' . $this->doctype('rContDe') . '<rContDe>' . preg_replace('/^<\?xml[^>]*\?>\s*/', '', $conEntidad) . '</rContDe>';
    try {
      $leido = RContDe::FromXContenDE($xContenDE);
      $this->assertStringNotContainsString('CONTENIDO-QUE-NO-DEBE-LEERSE', $leido->getRDe()?->toXMLString() ?? '');
    } catch (ValidacionException $e) {
      $this->assertStringNotContainsString('CONTENIDO-QUE-NO-DEBE-LEERSE', $e->getMessage());
      $this->assertStringContainsString('bien formado', $e->getMessage());
    }
  }
}
