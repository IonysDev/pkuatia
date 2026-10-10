<?php

namespace IonysDev\Pkuatia\Tests\Unit\Core;

use IonysDev\Pkuatia\Core\Fields\Response\DE\GResProcEve;
use IonysDev\Pkuatia\Core\Responses\RespuestaConsultaLoteDE;
use PHPUnit\Framework\TestCase;

/**
 * Fase B/B11, PK-43 con la decisión Q-B6: código muerto y salida de depuración en producción. Dos archivos de 0 bytes
 * en src/Core/Responses (vacíos desde c8e13d8, 09/2023), un echo en RespuestaConsultaLoteDE::FromSifenResponseObject,
 * una rama con echo en GResProcEve (DE) que además leía un solo gResProc, y "return null;" inalcanzable después de un
 * throw. Desde B11, phpunit.xml.dist marca como fallido cualquier test que imprima algo
 * (beStrictAboutOutputDuringTests + failOnRisky).
 */
final class LimpiezaTest extends TestCase
{
  public function testCadaArchivoDeSrcDeclaraUnTipoConSuNombre(): void
  {
    $sinTipo = [];
    foreach (self::archivosDeSrc() as $ruta) {
      if (!in_array(basename($ruta, '.php'), self::tiposDeclarados(self::significativos($ruta)), true)) {
        $sinTipo[] = self::relativa($ruta);
      }
    }

    $this->assertSame([], $sinTipo, 'Archivos sin el tipo de su nombre (¿vacíos?).');
  }

  public function testNoQuedanReturnInalcanzablesDespuesDeUnThrow(): void
  {
    $encontrados = [];
    foreach (self::archivosDeSrc() as $ruta) {
      $sig = self::significativos($ruta);
      for ($k = 0; $k + 2 < count($sig); $k++) {
        if ($sig[$k][0] !== T_RETURN || strtolower($sig[$k + 1][1]) !== 'null' || $sig[$k + 2][1] !== ';' || ($sig[$k - 1][1] ?? '') !== ';') {
          continue;
        }
        // Inicio de la sentencia anterior: el ; { o } previo fuera de paréntesis.
        $profundidad = 0;
        for ($m = $k - 2; $m >= 0; $m--) {
          $txt = $sig[$m][1];
          if ($txt === ')' || $txt === ']') {
            $profundidad++;
          } elseif ($txt === '(' || $txt === '[') {
            $profundidad--;
          } elseif ($profundidad === 0 && in_array($txt, [';', '{', '}'], true)) {
            break;
          }
        }
        if ($sig[$m + 1][0] === T_THROW) {
          $encontrados[] = self::relativa($ruta) . ':' . $sig[$k][2];
        }
      }
    }

    $this->assertSame([], $encontrados, '"return null;" inalcanzable después de un throw.');
  }

  public function testLaConsultaDeLoteHeredadaNoImprime(): void
  {
    $this->expectOutputString('');

    $res = RespuestaConsultaLoteDE::FromSifenResponseObject((object) [
      'dFecProc' => '2026-10-10T10:10:00-03:00', 'dCodResLot' => '0361', 'dMsgResLot' => 'Lote en procesamiento',
    ]);

    $this->assertSame('0361', $res->dCodResLot);
  }

  public function testGResProcEveHeredadoLeeTodosLosMensajesSinImprimir(): void
  {
    $this->expectOutputString('');
    $xml = simplexml_load_string('<gResProcEVe><dEstRes>Rechazado</dEstRes><id>7</id>'
      . '<gResProc><dCodRes>4001</dCodRes><dMsgRes>Primer motivo</dMsgRes></gResProc>'
      . '<gResProc><dCodRes>4002</dCodRes><dMsgRes>Segundo motivo</dMsgRes></gResProc></gResProcEVe>');

    $res = GResProcEve::FromSimpleXMLElement($xml);

    $this->assertSame('Rechazado', $res->getDEstRes());
    $this->assertSame(['4001', '4002'], array_map(fn ($g) => $g->getDCodRes(), $res->getGResProc()));
    $this->assertSame(['Primer motivo', 'Segundo motivo'], array_map(fn ($g) => $g->getDMsgRes(), $res->getGResProc()));
  }

  /** @return list<string> */
  private static function archivosDeSrc(): array
  {
    $res = [];
    $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(dirname(__DIR__, 3) . '/src', \FilesystemIterator::SKIP_DOTS));
    foreach ($it as $archivo) {
      if ($archivo->isFile() && $archivo->getExtension() === 'php') {
        $res[] = $archivo->getPathname();
      }
    }
    sort($res);
    return $res;
  }

  /** @return list<array{0: int|null, 1: string, 2: int|null}> Tokens sin espacios ni comentarios: [id, texto, línea]. */
  private static function significativos(string $ruta): array
  {
    $res = [];
    foreach (token_get_all((string) file_get_contents($ruta)) as $t) {
      if (is_array($t) && in_array($t[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
        continue;
      }
      $res[] = is_array($t) ? [$t[0], $t[1], $t[2]] : [null, $t, null];
    }
    return $res;
  }

  /**
   * @param list<array{0: int|null, 1: string, 2: int|null}> $sig
   * @return list<string>
   */
  private static function tiposDeclarados(array $sig): array
  {
    $res = [];
    foreach ($sig as $k => $t) {
      if (in_array($t[0], [T_CLASS, T_INTERFACE, T_TRAIT, T_ENUM], true) && !in_array($sig[$k - 1][1] ?? '', ['::', 'new'], true) && isset($sig[$k + 1])) {
        $res[] = $sig[$k + 1][1];
      }
    }
    return $res;
  }

  private static function relativa(string $ruta): string
  {
    return str_replace('\\', '/', substr($ruta, strlen(dirname(__DIR__, 3)) + 1));
  }
}
