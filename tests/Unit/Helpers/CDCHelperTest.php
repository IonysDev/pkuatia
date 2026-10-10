<?php

namespace IonysDev\Pkuatia\Tests\Unit\Helpers;

use IonysDev\Pkuatia\Helpers\CDCHelper;
use IonysDev\Pkuatia\Tests\Support\MinimalRdeFactory;
use IonysDev\Pkuatia\Utils\RucUtils;
use PHPUnit\Framework\Attributes\DataProvider;
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

  /**
   * Fase B/B9, PK-38: un CDC que no cumple tCDC (DE_Types_v150.xsd:23-32: 44 caracteres con el patrón
   * [0-9]{2}([0-9]{7}[0-9A-D])[0-9]{34}) lanza InvalidArgumentException. Hasta 0.2.0 uno más corto se devolvía como
   * el texto "ERROR: ..." y uno más largo o con letras fuera de lugar se devolvía tal cual: los dos terminaban en el
   * atributo Id del DE.
   *
   * @return array<string, array{0: callable(\IonysDev\Pkuatia\Core\Fields\DE\A\DE): mixed}>
   */
  public static function datosQueInvalidanElCdc(): array
  {
    return [
      'RUC del emisor de 9 dígitos (45 caracteres)' => [fn ($de) => $de->getGDatGralOpe()->getGEmis()->setDRucEm('123456789')],
      'establecimiento con una letra' => [fn ($de) => $de->getGTimb()->setDEst('0A1')],
    ];
  }

  #[DataProvider('datosQueInvalidanElCdc')]
  public function testUnCdcInvalidoLanzaExcepcion(callable $alterar): void
  {
    $de = MinimalRdeFactory::createRde(7)->getDE();
    $alterar($de);

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('El CDC debe tener 44 caracteres');
    CDCHelper::Generate($de);
  }

  public function testElRucConLetraFinalQueAdmiteElXsdSigueSiendoValido(): void
  {
    // tRuc (DE_Types_v150.xsd:420-423) admite una letra de la A a la D al final del RUC, y tCDC la conserva.
    $de = MinimalRdeFactory::createRde(7)->getDE();
    $de->getGDatGralOpe()->getGEmis()->setDRucEm('1234567A');

    $cdc = CDCHelper::Generate($de);

    $this->assertMatchesRegularExpression('/^[0-9]{2}[0-9]{7}[0-9A-D][0-9]{34}$/', $cdc);
    $this->assertSame('1234567A', substr($cdc, 2, 8));
  }
}
