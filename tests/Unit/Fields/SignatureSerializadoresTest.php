<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use DOMDocument;
use IonysDev\Pkuatia\Core\Fields\DE\I\Signature;
use IonysDev\Pkuatia\Core\Fields\Signature\DigestMethod;
use IonysDev\Pkuatia\Core\Fields\Signature\KeyInfo;
use IonysDev\Pkuatia\Core\Fields\Signature\Reference;
use IonysDev\Pkuatia\Core\Fields\Signature\X509Data;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use IonysDev\Pkuatia\Tests\Support\SignatureAssertions;
use IonysDev\Pkuatia\Tests\Support\XsdAssertions;
use PHPUnit\Framework\TestCase;

/**
 * Fase D, D8 (PK-32, parte pendiente; decisión Q-D3 = A). Hasta 0.3.0 los serializadores tipados de la firma no podían
 * funcionar: KeyInfo, X509Data, Reference y DigestMethod creaban sus nodos en un DOMDocument propio (al colgarlos del
 * documento del rDE PHP lanzaba "Wrong Document Error"), toHeaderOnlyDOMElement() ignoraba el $doc recibido, KeyInfo
 * agregaba un xmlns:ds espurio y SignedInfo llamaba a Reference::toDOMElement($doc) sin parámetro declarado. Además
 * Reference::FromDOMElement() recorría los contenedores Transforms en vez de los Transform (perdía los algoritmos).
 *
 * Límite documentado: el modelo tipado no conserva los nodos de texto del original (los espacios del SignedInfo de
 * xmlseclibs forman parte de lo firmado), así que una firma reemitida desde los objetos es estructuralmente
 * equivalente pero no verifica; la reemisión que verifica sigue siendo la copia del XML original (RDE::copiarFirma,
 * IdaYVueltaFirmadoTest).
 */
final class SignatureSerializadoresTest extends TestCase
{
    private const XSD_XMLDSIG = __DIR__ . '/../../../src/Resources/xsd/xmldsig-core-schema.xsd';

    /** @var callable */
    private $cleanup;
    private string $firmado;

    protected function setUp(): void
    {
        $this->cleanup = SifenTestEnvironment::init()['cleanup'];
        $this->firmado = F::firmar(F::rde(F::facturaContado()));
        SignatureAssertions::assertFirmaVerifica($this->firmado, 'original');
    }

    protected function tearDown(): void
    {
        ($this->cleanup)();
    }

    private function firmaOriginal(): \DOMElement
    {
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = true;
        $doc->loadXML($this->firmado);
        return $doc->getElementsByTagName('Signature')->item(0);
    }

    /** C14N de un fragmento sin sus nodos de texto en blanco: equivalencia estructural. */
    private static function canonicoSinBlancos(string $xml): string
    {
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->loadXML($xml);
        return $doc->documentElement->C14N();
    }

    public function testLaFirmaTipadaSeReemiteEnElDocumentoDestinoYEsEstructuralmenteEquivalente(): void
    {
        $original = $this->firmaOriginal();
        $firma = Signature::FromDOMElement($original);

        $destino = new DOMDocument('1.0', 'UTF-8');
        $rde = $destino->createElement('rDE');
        $destino->appendChild($rde);
        $rde->appendChild($firma->toDOMElement($destino)); // hasta 0.3.0: DOMException "Wrong Document Error"

        $nodo = $destino->getElementsByTagName('Signature')->item(0);
        $xml = $destino->saveXML($nodo);
        XsdAssertions::assertValido($xml, self::XSD_XMLDSIG, 'firma reemitida desde los objetos');
        $this->assertStringNotContainsString('xmlns:ds', $xml);
        $this->assertSame(['SignedInfo', 'SignatureValue', 'KeyInfo'], array_map(fn ($n) => $n->nodeName, iterator_to_array($nodo->childNodes)));
        $this->assertSame(self::canonicoSinBlancos($original->ownerDocument->saveXML($original)), self::canonicoSinBlancos($xml),
            'mismos elementos, atributos y valores que el original; solo difieren los nodos de texto en blanco');
    }

    public function testElLectorDomConservaLosDosTransforms(): void
    {
        $firma = Signature::FromDOMElement($this->firmaOriginal());
        $transforms = $firma->getSignedInfo()->getReference()->getTransforms();
        $this->assertCount(2, $transforms, 'hasta 0.3.0 recorría los contenedores Transforms y no los Transform');
        $this->assertSame(
            ['http://www.w3.org/2000/09/xmldsig#enveloped-signature', 'http://www.w3.org/2001/10/xml-exc-c14n#'],
            array_map(fn ($t) => $t->getAlgorithm(), $transforms)
        );
        $original = $this->firmaOriginal();
        $porSimpleXml = Signature::FromSimpleXMLElement(simplexml_load_string($original->ownerDocument->saveXML($original)));
        $this->assertCount(2, $porSimpleXml->getSignedInfo()->getReference()->getTransforms());
    }

    public function testLosSerializadoresSueltosSiguenFuncionandoSinDocumento(): void
    {
        $x509 = (new X509Data())->setX509Certificate('MIIB')->toDOMElement();
        $this->assertSame('X509Data', $x509->nodeName);
        $this->assertSame('MIIB', $x509->textContent);

        $keyInfo = (new KeyInfo())->setX509Data((new X509Data())->setX509Certificate('MIIB'))->toDOMElement();
        $this->assertSame('KeyInfo', $keyInfo->nodeName);
        $this->assertFalse($keyInfo->hasAttribute('xmlns:ds'), 'sin el prefijo espurio');
        $this->assertSame('X509Data', $keyInfo->firstChild->nodeName);

        $digest = (new DigestMethod())->setAlgorithm('http://www.w3.org/2001/04/xmlenc#sha256')->toDOMElement();
        $this->assertSame('http://www.w3.org/2001/04/xmlenc#sha256', $digest->getAttribute('Algorithm'));

        $doc = new DOMDocument();
        $ref = (new Reference())->setURI('#X')->setDigestMethod(new DigestMethod())->setDigestValue('abc');
        $ref->getDigestMethod()->setAlgorithm('http://www.w3.org/2001/04/xmlenc#sha256');
        $nodo = $ref->toDOMElement($doc);
        $this->assertSame($doc, $nodo->ownerDocument, 'con $doc, los nodos nacen en ese documento');
        $this->assertSame('#X', $nodo->getAttribute('URI'));
    }

    public function testLaIdaYVueltaQueVerificaSigueSiendoLaCopiaDelXmlOriginal(): void
    {
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = true;
        $doc->loadXML($this->firmado);
        $rde = \IonysDev\Pkuatia\Core\Fields\DE\AA\RDE::FromDOMElement($doc->documentElement);
        $docVuelta = $rde->toDOMDocument();
        $vuelta = $docVuelta->saveXML($docVuelta->documentElement);
        SignatureAssertions::assertFirmaVerifica($vuelta, 'vuelta por copiarFirma');
    }
}
