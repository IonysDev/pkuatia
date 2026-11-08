<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use DateTime;
use DOMDocument;
use IonysDev\Pkuatia\Core\Constants\PagCredCondCred;
use IonysDev\Pkuatia\Core\Exceptions\PkuatiaException;
use IonysDev\Pkuatia\Core\Fields\DE\E\GGrupAdi;
use IonysDev\Pkuatia\Core\Fields\DE\E\GPagCred;
use IonysDev\Pkuatia\Core\Fields\Response\DE\RContEv;
use IonysDev\Pkuatia\Core\Fields\Response\DE\TxContenEv;
use IonysDev\Pkuatia\Core\Requests\REnviDe;
use IonysDev\Pkuatia\Core\Requests\REnviEventoDe;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use PHPUnit\Framework\TestCase;
use SoapVar;
use stdClass;

/**
 * Fase D, D1: errores de runtime que PHPStan en nivel 2 y 3 destapaba y que la baseline de nivel 1 escondía
 * (`docs/evaluacion-2026-10-02/evidencia-fase-d/phpstan/l3-inicial.txt`, 08/11/2026). Cada test reproduce el
 * comportamiento anterior (TypeError, Error o pérdida de datos) y fija el corregido, dentro de las reglas de la fase:
 * ninguna firma pública cambia salvo por ampliación de tipos.
 */
final class CorreccionesPhpstanTest extends TestCase
{
  /**
   * E645 (dMonEnt) es tMontoBase4: admite hasta cuatro decimales. `GPagCred::setDMonEnt(int)` convertía "1500.50"
   * a 1500 al entrar, `toDOMElement()` escribía el entero de `getDMonEnt(): ?int` y los tres lectores aplicaban
   * `intval()`: la entrega inicial perdía los decimales en las cuatro vías (PHPStan L3: `assign.propertyType` y
   * `return.type` en GPagCred.php:114 y :185).
   */
  public function testLaEntregaInicialConservaLosDecimales(): void
  {
    $g = (new GPagCred())->setICondCred(PagCredCondCred::Cuota)->setDCuotas(2)->setDMonEnt('1500.50');
    $this->assertSame('1500.50', $g->dMonEnt);
    $this->assertSame('1500.50', $g->getDMonEntDecimal());

    $doc = new DOMDocument();
    $nodo = $g->toDOMElement($doc);
    $doc->appendChild($nodo);
    $xml = $doc->saveXML($nodo);
    $this->assertStringContainsString('<dMonEnt>1500.50</dMonEnt>', $xml);

    $this->assertSame('1500.50', GPagCred::FromDOMElement($nodo)->dMonEnt, 'lector DOM');
    $this->assertSame('1500.50', GPagCred::FromSimpleXMLElement(simplexml_load_string($xml))->dMonEnt, 'lector SimpleXML');
    $objeto = new stdClass();
    $objeto->iCondCred = 2;
    $objeto->dDCondCred = 'Cuota';
    $objeto->dCuotas = 2;
    $objeto->dMonEnt = '1500.50';
    $this->assertSame('1500.50', GPagCred::FromSifenResponseObject($objeto)->dMonEnt, 'lector SOAP');
  }

  public function testLaEntregaInicialEnteraSeComportaComoAntes(): void
  {
    $g = (new GPagCred())->setICondCred(PagCredCondCred::Plazo)->setDPlazoCre('30 días')->setDMonEnt(1500);
    $this->assertSame('1500', $g->dMonEnt);
    $this->assertSame(1500, $g->getDMonEnt());
    $this->assertSame('1500', $g->getDMonEntDecimal());
    $this->assertNull((new GPagCred())->getDMonEntDecimal());
    $doc = new DOMDocument();
    $this->assertStringContainsString('<dMonEnt>1500</dMonEnt>', $doc->saveXML($g->toDOMElement($doc)));
  }

  public function testLaFacturaEnCuotasConservaLaEntregaDecimal(): void
  {
    $fe = F::facturaCreditoCuotas(2, '1500.50');
    $xml = F::rde($fe)->toDOMDocument()->saveXML();
    $this->assertStringContainsString('<dMonEnt>1500.50</dMonEnt>', $xml);
  }

  /**
   * `TxContenEv::toDOMElement()` llamaba a `RContEv::toDOMElement()`, que está comentado desde 0.2.1 (PK-43), así que
   * terminaba en `Error: Call to undefined method` (PHPStan L2: `method.notFound` en TxContenEv.php:57 y :78). Nunca
   * funcionó (el XSD no tiene un elemento TxContenEv); ahora avisa con una excepción de la librería.
   */
  public function testTxContenEvAvisaQueNoEstaImplementado(): void
  {
    $t = (new TxContenEv())->setRContEv(new RContEv());
    try {
      $t->toDOMElement();
      $this->fail('toDOMElement() debía lanzar');
    } catch (PkuatiaException $e) {
      $this->assertInstanceOf(\Exception::class, $e);
      $this->assertStringContainsString('FromXContenDE', $e->getMessage());
    }
    $doc = new DOMDocument();
    $contentEv = $doc->createElement('contentEv');
    $contentEv->appendChild($doc->createElement('rContEv'));
    try {
      TxContenEv::fromDOMElement($contentEv);
      $this->fail('fromDOMElement() debía lanzar');
    } catch (PkuatiaException $e) {
      $this->assertStringContainsString('FromXContenDE', $e->getMessage());
    }
  }

  /**
   * `REnviDe::setXDe(String)` y `REnviEventoDe::setDEvReg(String)` asignaban un string a una propiedad `SoapVar`:
   * TypeError en toda llamada (PHPStan L3: `assign.propertyType` en REnviDe.php:52 y REnviEventoDe.php:50). Ahora
   * aceptan el XML como texto, envuelto en un SoapVar XSD_ANYXML como hace el facade, o un SoapVar ya armado.
   */
  public function testLasSolicitudesAceptanElXmlComoTexto(): void
  {
    $r = new REnviDe(1, new SoapVar('<ns1:xDE/>', XSD_ANYXML));
    $r->setXDe('<ns1:xDE><rDE/></ns1:xDE>');
    $this->assertInstanceOf(SoapVar::class, $r->xDE);
    $this->assertSame(XSD_ANYXML, $r->xDE->enc_type);
    $this->assertSame('<ns1:xDE><rDE/></ns1:xDE>', $r->xDE->enc_value);
    $var = new SoapVar('<ns1:xDE><rDE/></ns1:xDE>', XSD_ANYXML);
    $this->assertSame($var, $r->setXDe($var)->getXDE());

    $e = new REnviEventoDe(1, new SoapVar('<ns1:dEvReg/>', XSD_ANYXML));
    $e->setDEvReg('<ns1:dEvReg><gGroupGesEve/></ns1:dEvReg>');
    $this->assertInstanceOf(SoapVar::class, $e->dEvReg);
    $this->assertSame(XSD_ANYXML, $e->dEvReg->enc_type);
    $this->assertSame('<ns1:dEvReg><gGroupGesEve/></ns1:dEvReg>', $e->dEvReg->enc_value);
  }

  /**
   * E826 (dSalAnt) se guarda como cadena decimal BCMath y `getDSalAnt(): ?float` la convierte a float (PHPStan L3:
   * `return.type` en GGrupAdi.php:231): para leerla sin pérdida existe ahora `getDSalAntDecimal()`.
   */
  public function testElSaldoAnteriorSeLeeComoDecimal(): void
  {
    $g = (new GGrupAdi())->setDSalAnt('1234567890123.1234');
    $this->assertSame('1234567890123.1234', $g->getDSalAntDecimal());
    $this->assertSame(1234567890123.1234, $g->getDSalAnt());
    $this->assertNull((new GGrupAdi())->getDSalAntDecimal());
  }
}
