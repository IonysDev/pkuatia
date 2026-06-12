<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use IonysDev\Pkuatia\Helpers\CDCHelper;
use IonysDev\Pkuatia\Tests\Support\MinimalRdeFactory;
use IonysDev\Pkuatia\Utils\RucUtils;
use PHPUnit\Framework\TestCase;

final class CDCHelperTest extends TestCase
{
  public function testGenerateProducesFortyFourDigitCdcWithConsistentDv(): void
  {
    $rde = MinimalRdeFactory::createRde(7);
    $cdc = CDCHelper::Generate($rde->getDE());

    $this->assertSame(44, strlen($cdc));
    $this->assertMatchesRegularExpression('/^[0-9]{44}$/', $cdc);

    $body = substr($cdc, 0, 43);
    $expectedDv = (string) RucUtils::calcDV($body);
    $this->assertSame($expectedDv, $cdc[43]);
    $this->assertSame((int) $cdc[43], $rde->getDE()->getDDVId());
  }
}
