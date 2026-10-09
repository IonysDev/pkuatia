<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use DOMDocument;
use IonysDev\Pkuatia\Helpers\XmlHelper;
use PHPUnit\Framework\TestCase;

final class XmlHelperTest extends TestCase
{
  /**
   * @return array<string, array{mixed, string}>
   */
  public static function valores(): array
  {
    return [
      'ampersand'          => ['Pérez & Hijos S.A.', '<dNomEmi>Pérez &amp; Hijos S.A.</dNomEmi>'],
      'menor y mayor'      => ['Tornillos <3mm> y >5mm', '<dNomEmi>Tornillos &lt;3mm&gt; y &gt;5mm</dNomEmi>'],
      'comillas'           => ['Casa "La Esquina" d\'Or', '<dNomEmi>Casa "La Esquina" d\'Or</dNomEmi>'],
      'entidad ya escrita' => ['Pérez &amp; Hijos', '<dNomEmi>Pérez &amp;amp; Hijos</dNomEmi>'],
      'acentos'            => ['Ñandutí & Cía.', '<dNomEmi>Ñandutí &amp; Cía.</dNomEmi>'],
      'entero'             => [150, '<dNomEmi>150</dNomEmi>'],
      'decimal string'     => ['1500.50000000', '<dNomEmi>1500.50000000</dNomEmi>'],
      'true'               => [true, '<dNomEmi>1</dNomEmi>'],
      'false'              => [false, '<dNomEmi/>'],
      'vacio'              => ['', '<dNomEmi/>'],
      'null'               => [null, '<dNomEmi/>'],
    ];
  }

  /**
   * @dataProvider valores
   */
  public function testElementoEscapaElValorComoTexto(mixed $valor, string $xmlEsperado): void
  {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $el = XmlHelper::elemento($doc, 'dNomEmi', $valor);
    $this->assertSame($xmlEsperado, $doc->saveXML($el));
  }

  public function testElValorSeRecuperaIntactoAlLeerElNodo(): void
  {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $original = 'Pérez & Hijos <S.A.> "2026"';
    $el = XmlHelper::elemento($doc, 'dNomEmi', $original);
    $doc->appendChild($el);

    $releido = new DOMDocument();
    $releido->loadXML($doc->saveXML());
    $this->assertSame($original, $releido->documentElement->nodeValue);
  }

  public function testElementoSueltoProduceElMismoTextoAlAdoptarloEnUnDocumento(): void
  {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $padre = $doc->createElement('rContRUC');
    $padre->appendChild(XmlHelper::elementoSuelto('dRazCons', 'Pérez & Hijos <S.A.> "2026"'));
    $padre->appendChild(XmlHelper::elementoSuelto('dRUCFactElec', ''));
    $doc->appendChild($padre);
    $this->assertSame('<rContRUC><dRazCons>Pérez &amp; Hijos &lt;S.A.&gt; "2026"</dRazCons><dRUCFactElec/></rContRUC>', $doc->saveXML($padre));
    $this->assertSame('Pérez & Hijos <S.A.> "2026"', $padre->firstChild->nodeValue);
  }

  public function testElNodoPerteneceAlDocumentoYSePuedeAnidar(): void
  {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $padre = $doc->createElement('gEmis');
    $padre->appendChild(XmlHelper::elemento($doc, 'dRucEm', '80000000'));
    $padre->appendChild(XmlHelper::elemento($doc, 'dNomEmi', 'A & B'));
    $this->assertSame('<gEmis><dRucEm>80000000</dRucEm><dNomEmi>A &amp; B</dNomEmi></gEmis>', $doc->saveXML($padre));
  }
}
