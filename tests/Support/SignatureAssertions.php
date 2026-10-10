<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\Assert;
use RobRichards\XMLSecLibs\XMLSecEnc;
use RobRichards\XMLSecLibs\XMLSecurityDSig;

final class SignatureAssertions
{
  public static function assertEachSignatureWellFormed(DOMDocument $doc, string $context = ''): void
  {
    $signatures = $doc->getElementsByTagName('Signature');
    Assert::assertGreaterThan(0, $signatures->length, $context);

    for ($i = 0; $i < $signatures->length; $i++) {
      /** @var DOMElement $sig */
      $sig = $signatures->item($i);
      $label = trim($context . ' Signature#' . ($i + 1));

      Assert::assertEquals(
        1,
        $sig->getElementsByTagName('Reference')->length,
        "$label debe tener exactamente 1 Reference"
      );

      $expectedOrder = ['SignedInfo', 'SignatureValue', 'KeyInfo'];
      $actualOrder = [];
      foreach ($sig->childNodes as $child) {
        if ($child->nodeType === XML_ELEMENT_NODE) {
          $actualOrder[] = $child->nodeName;
        }
      }
      Assert::assertEquals($expectedOrder, $actualOrder, "$label orden de hijos");
    }
  }

  /**
   * Verificación criptográfica de la primera firma del XML con xmlseclibs: el digest de la referencia (el DE
   * por su Id) y la firma de SignedInfo con el certificado de KeyInfo.
   */
  public static function assertFirmaVerifica(string $xml, string $contexto = ''): void
  {
    $doc = new DOMDocument();
    Assert::assertTrue($doc->loadXML($xml), trim("$contexto XML mal formado"));
    $dsig = new XMLSecurityDSig();
    $firma = $dsig->locateSignature($doc);
    Assert::assertNotNull($firma, trim("$contexto sin Signature"));
    $dsig->canonicalizeSignedInfo();
    Assert::assertTrue($dsig->validateReference(), trim("$contexto el digest del DE no coincide"));
    $clave = $dsig->locateKey();
    XMLSecEnc::staticLocateKeyInfo($clave, $firma);
    Assert::assertSame(1, $dsig->verify($clave), trim("$contexto la firma de SignedInfo no verifica"));
  }

  public static function assertReferenceUri(DOMElement $signature, string $expectedUri): void
  {
    /** @var DOMElement $reference */
    $reference = $signature->getElementsByTagName('Reference')->item(0);
    Assert::assertNotNull($reference);
    Assert::assertEquals($expectedUri, $reference->getAttribute('URI'));
  }
}
