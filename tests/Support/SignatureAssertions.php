<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\Assert;

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

  public static function assertReferenceUri(DOMElement $signature, string $expectedUri): void
  {
    /** @var DOMElement $reference */
    $reference = $signature->getElementsByTagName('Reference')->item(0);
    Assert::assertNotNull($reference);
    Assert::assertEquals($expectedUri, $reference->getAttribute('URI'));
  }
}
