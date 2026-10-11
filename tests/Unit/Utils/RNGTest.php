<?php

namespace IonysDev\Pkuatia\Tests\Unit\Utils;

use IonysDev\Pkuatia\Core\Fields\DE\B\GOpeDE;
use IonysDev\Pkuatia\Utils\RNG;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B9, PK-38. B004 (dCodSeg) es un "código generado por el emisor de manera aleatoria para asegurar la
 * confidencialidad de la consulta pública del DE" (MT v150, B004; ekuat-ia 03-estructura-xml/campos-obligatorios.md:39)
 * y forma parte del CDC y del QR. GOpeDE lo genera con RNG::GenerateAsString(0, 999999999, 9), que usaba rand():
 * desde PHP 7.1 rand() es mt_rand(), cuya secuencia se repite con la misma semilla de mt_srand(). Con random_int()
 * el código sale del generador criptográfico del sistema.
 */
final class RNGTest extends TestCase
{
  protected function tearDown(): void
  {
    mt_srand(); // la semilla de mt_rand vuelve a ser aleatoria para el resto de la suite
  }

  public function testLaMismaSemillaDeMtSrandNoRepiteLosCodigos(): void
  {
    mt_srand(20261010);
    $primera = [RNG::GenerateAsString(0, 999999999, 9), RNG::GenerateAsString(0, 999999999, 9), RNG::GenerateAsString(0, 999999999, 9)];
    mt_srand(20261010);
    $segunda = [RNG::GenerateAsString(0, 999999999, 9), RNG::GenerateAsString(0, 999999999, 9), RNG::GenerateAsString(0, 999999999, 9)];

    $this->assertNotSame($primera, $segunda);
  }

  public function testElCodigoDeSeguridadDeGOpeDENoDependeDeMtSrand(): void
  {
    mt_srand(7);
    $primero = (new GOpeDE())->getDCodSeg();
    mt_srand(7);
    $segundo = (new GOpeDE())->getDCodSeg();

    $this->assertNotSame($primero, $segundo);
  }

  public function testDiezMilCodigosDeNueveDigitosSinRepeticionPractica(): void
  {
    $codigos = [];
    for ($i = 0; $i < 10000; $i++) {
      $codigos[] = RNG::GenerateAsString(0, 999999999, 9);
    }

    $this->assertCount(10000, preg_grep('/^[0-9]{9}$/', $codigos));
    // Con 10 000 extracciones entre 10^9 valores se espera 0,05 repeticiones; 5 o más tienen probabilidad < 3·10^-9.
    $this->assertGreaterThanOrEqual(9996, count(array_unique($codigos)));
  }

  public function testConservaElRangoInvertidoQueAceptabaRand(): void
  {
    // rand() aceptaba $max < $min (random_int() lanza ValueError): se conserva ese comportamiento.
    $valores = [];
    for ($i = 0; $i < 300; $i++) {
      $valores[] = RNG::GenerateAsString(10, 1, 2);
    }

    $this->assertCount(300, preg_grep('/^(0[1-9]|10)$/', $valores));
    $this->assertContains('01', $valores);
    $this->assertContains('10', $valores);
  }
}
