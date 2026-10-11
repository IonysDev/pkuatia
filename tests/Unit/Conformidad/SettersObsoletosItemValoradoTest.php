<?php

namespace IonysDev\Pkuatia\Tests\Unit\Conformidad;

use DateTime;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Autofactura;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeCredito;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\NotaDeDebito;
use IonysDev\Pkuatia\Core\Fields\DE\E\GVehNuevo;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B8, PK-34 con la decisión Q-B5 (deprecar los 16). Los setters del trait ItemValorado
 * (ItemValorado.php:466-657 en 0.2.0) asignaban propiedades no declaradas que nadie lee: en PHP 8.2+ cada llamada
 * emite "Creation of dynamic property" (E_DEPRECATED, error en PHP 9) y el valor no llega al documento. Son las 64
 * entradas property.notFound de la baseline de PHPStan (16 setters × Factura, Autofactura, NotaDeCredito y
 * NotaDeDebito). addItem() ya recibe esos 16 datos como parámetros opcionales y los conecta al ítem
 * (ItemValorado.php:75-105). Desde 0.2.1 cada setter declara su propiedad, sigue guardando el valor y avisa con
 * E_USER_DEPRECATED cuál es el parámetro de addItem() equivalente; ninguno modifica el XML.
 */
final class SettersObsoletosItemValoradoTest extends TestCase
{
  /** @return array<string, array{0: string, 1: string, 2: mixed}> [setter, propiedad y parámetro de addItem(), valor] */
  public static function setters(): array
  {
    return [
      'setEsTipoCambioPorItem' => ['setEsTipoCambioPorItem', 'esTipoCambioPorItem', true],
      'setTipoDeCambioItem' => ['setTipoDeCambioItem', 'tipoDeCambioItem', '7350.5'],
      'setNroLote' => ['setNroLote', 'nroLote', 'L-2026-01'],
      'setFechaVencimiento' => ['setFechaVencimiento', 'fechaVencimiento', new DateTime('2027-01-31')],
      'setNroSerie' => ['setNroSerie', 'nroSerie', 'SN-0001'],
      'setNroPedido' => ['setNroPedido', 'nroPedido', 'P-77'],
      'setInfoEmisor' => ['setInfoEmisor', 'infoEmisor', 'Entrega en depósito'],
      'setCDCFacturaAnticipo' => ['setCDCFacturaAnticipo', 'cdcFacturaAnticipo', '01800000000001001000000122026011510123456789'],
      'setPartidaArancelaria' => ['setPartidaArancelaria', 'partidaArancelaria', 8471],
      'setNcmMercosur' => ['setNcmMercosur', 'ncmMercosur', 84713012],
      'setCodPaisOrigen' => ['setCodPaisOrigen', 'codPaisOrigen', 'PRY'],
      'setDncpCodigoGeneral' => ['setDncpCodigoGeneral', 'dncpCodigoGeneral', '12345678'],
      'setDncpCodigoEspecifico' => ['setDncpCodigoEspecifico', 'dncpCodigoEspecifico', '1234'],
      'setDncpCodigoGTINProducto' => ['setDncpCodigoGTINProducto', 'dncpCodigoGTINProducto', '7891234567895'],
      'setDncpCodigoGTINPaquete' => ['setDncpCodigoGTINPaquete', 'dncpCodigoGTINPaquete', '17891234567892'],
      'setDetalleVehiculoNuevo' => ['setDetalleVehiculoNuevo', 'detalleVehiculoNuevo', new GVehNuevo()],
    ];
  }

  #[DataProvider('setters')]
  public function testElSetterAvisaQueEstaObsoletoYGuardaElValorEnUnaPropiedadDeclarada(string $setter, string $propiedad, mixed $valor): void
  {
    $documentos = ['Factura' => new Factura(1), 'Autofactura' => new Autofactura(1), 'NotaDeCredito' => new NotaDeCredito(1), 'NotaDeDebito' => new NotaDeDebito(1)];
    foreach ($documentos as $nombre => $documento) {
      $devuelto = null;
      $avisos = self::capturarAvisos(function () use ($documento, $setter, $valor, &$devuelto): void {
        $devuelto = $documento->$setter($valor);
      });

      $this->assertTrue(property_exists(get_class($documento), $propiedad), "$nombre no declara \$$propiedad.");
      $this->assertCount(1, $avisos, "$nombre::$setter(): " . implode(' | ', array_column($avisos, 1)));
      $this->assertSame(E_USER_DEPRECATED, $avisos[0][0], "$nombre::$setter(): {$avisos[0][1]}");
      $this->assertStringContainsString("$nombre::$setter()", $avisos[0][1]);
      $this->assertStringContainsString("\$$propiedad de addItem()", $avisos[0][1]);
      $this->assertSame($documento, $devuelto);
      $this->assertSame($valor, $documento->$propiedad);
    }
  }

  public function testLosSettersObsoletosNoCambianElXml(): void
  {
    $esperado = F::rde(F::facturaContado())->toXMLString();
    $factura = F::facturaContado();
    $avisos = self::capturarAvisos(function () use ($factura): void {
      foreach (self::setters() as [$setter, , $valor]) {
        $factura->$setter($valor);
      }
    });

    $this->assertCount(16, $avisos);
    $this->assertSame($esperado, F::rde($factura)->toXMLString());
  }

  /** @return list<array{0: int, 1: string}> Avisos y errores emitidos por $accion, en orden. */
  private static function capturarAvisos(callable $accion): array
  {
    $avisos = [];
    set_error_handler(function (int $nivel, string $mensaje) use (&$avisos): bool {
      $avisos[] = [$nivel, $mensaje];
      return true;
    });
    try {
      $accion();
    } finally {
      restore_error_handler();
    }
    return $avisos;
  }
}
