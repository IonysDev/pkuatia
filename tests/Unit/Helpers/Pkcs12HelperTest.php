<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use IonysDev\Pkuatia\Helpers\Pkcs12Helper;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use PHPUnit\Framework\TestCase;

final class Pkcs12HelperTest extends TestCase
{
  private $cleanup;

  protected function tearDown(): void
  {
    if ($this->cleanup) {
      ($this->cleanup)();
    }
  }

  public function testWrongPassphraseOnModernPkcs12ThrowsActionableMessage(): void
  {
    $p12 = TestCertFactory::createModernPkcs12('correct-pass');
    $this->cleanup = $p12['cleanup'];

    $this->expectException(\Exception::class);
    $this->expectExceptionMessageMatches('/contraseña.*incorrecta/i');

    Pkcs12Helper::read(file_get_contents($p12['p12Path']), 'wrong-pass');
  }
}
