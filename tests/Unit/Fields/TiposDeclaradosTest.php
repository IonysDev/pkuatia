<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use IonysDev\Pkuatia\Core\Fields\DE\D\GActEco;
use IonysDev\Pkuatia\Core\Fields\DE\D\GEmis;
use IonysDev\Pkuatia\Tests\Support\DocumentoFactory as F;
use IonysDev\Pkuatia\Tests\Support\RoundTrip;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;

/**
 * Fase B/B8, PK-33. En un archivo con espacio de nombres, "stdClass" escrito sin barra inicial y sin "use stdClass;"
 * se resuelve como una clase del propio espacio de nombres, que no existe (reglas de resolución de nombres de PHP:
 * https://www.php.net/manual/en/language.namespaces.rules.php). En una firma es un TypeError al llamar el método:
 * GActEco::FromSifenResponseObject (GActEco.php:140) declaraba IonysDev\Pkuatia\Core\Fields\DE\D\stdClass, y lo
 * alcanza RDE::FromSifenResponseObject a través de GDatGralOpe y GEmis (GEmis.php:526-530); la baseline de PHPStan
 * lo registraba como "has invalid type". En un docblock el tipo queda mal resuelto para el IDE y el análisis estático.
 */
final class TiposDeclaradosTest extends TestCase
{
  public function testGActEcoSeLeeDesdeElObjetoSoap(): void
  {
    $gActEco = GActEco::FromSifenResponseObject((object) ['cActEco' => '62010', 'dDesActEco' => 'ACTIVIDADES DE PROGRAMACIÓN INFORMÁTICA']);

    $this->assertSame('62010', $gActEco->getCActEco());
    $this->assertSame('ACTIVIDADES DE PROGRAMACIÓN INFORMÁTICA', $gActEco->getDDesActEco());
  }

  public function testGEmisIdaYVueltaPorObjetoSoap(): void
  {
    $gEmis = F::rde(F::facturaContado())->getDE()->getGDatGralOpe()->getGEmis();

    RoundTrip::assertIdaYVueltaIdentica($gEmis, RoundTrip::VIA_SOAP, GEmis::class);
  }

  public function testNingunaFirmaNiPropiedadDeclaraUnaClaseInexistente(): void
  {
    $faltantes = [];
    foreach (self::tiposDeSrc() as $tipo) {
      $r = new ReflectionClass($tipo);
      foreach ($r->getMethods() as $metodo) {
        if ($metodo->getDeclaringClass()->getName() !== $tipo) {
          continue;
        }
        foreach ($metodo->getParameters() as $parametro) {
          foreach (self::clasesDelTipo($parametro->getType()) as $clase) {
            if (!self::existe($clase)) {
              $faltantes[] = "$tipo::{$metodo->getName()}(\${$parametro->getName()}): $clase";
            }
          }
        }
        foreach (self::clasesDelTipo($metodo->getReturnType()) as $clase) {
          if (!self::existe($clase)) {
            $faltantes[] = "$tipo::{$metodo->getName()}(): $clase";
          }
        }
      }
      foreach ($r->getProperties() as $propiedad) {
        if ($propiedad->getDeclaringClass()->getName() !== $tipo) {
          continue;
        }
        foreach (self::clasesDelTipo($propiedad->getType()) as $clase) {
          if (!self::existe($clase)) {
            $faltantes[] = "$tipo::\${$propiedad->getName()}: $clase";
          }
        }
      }
    }

    $this->assertSame([], $faltantes, 'Tipos declarados que no existen (¿falta "use" o la barra inicial?).');
  }

  public function testLosArchivosQueNombranStdClassEnUnDocblockLoImportan(): void
  {
    $sinImportar = [];
    foreach (self::archivosDeSrc() as $ruta) {
      $tokens = token_get_all((string) file_get_contents($ruta));
      $conEspacioDeNombres = false;
      $importa = false;
      $menciones = 0;
      foreach ($tokens as $i => $token) {
        if (!is_array($token)) {
          continue;
        }
        if ($token[0] === T_NAMESPACE) {
          $conEspacioDeNombres = true;
        }
        if ($token[0] === T_USE && self::siguiente($tokens, $i) === 'stdClass') {
          $importa = true;
        }
        if ($token[0] === T_DOC_COMMENT) {
          $menciones += preg_match_all('/(?<![\\\\\w])stdClass\b/', $token[1]);
        }
      }
      if ($conEspacioDeNombres && $menciones > 0 && !$importa) {
        $sinImportar[] = self::relativa($ruta) . " ($menciones)";
      }
    }

    $this->assertSame([], $sinImportar, 'Archivos con "stdClass" en docblocks sin "use stdClass;".');
  }

  /** @return list<class-string> Clases, interfaces, traits y enums declarados en src/ que se pueden cargar. */
  private static function tiposDeSrc(): array
  {
    $res = [];
    foreach (self::archivosDeSrc() as $ruta) {
      $tokens = token_get_all((string) file_get_contents($ruta));
      $espacio = '';
      foreach ($tokens as $i => $token) {
        if (!is_array($token)) {
          continue;
        }
        if ($token[0] === T_NAMESPACE) {
          $espacio = (string) self::siguiente($tokens, $i);
        }
        $anterior = self::anterior($tokens, $i);
        if (in_array($token[0], [T_CLASS, T_INTERFACE, T_TRAIT, T_ENUM], true) && $anterior !== '::' && $anterior !== 'new') {
          $nombre = self::siguiente($tokens, $i);
          if ($nombre === null) {
            continue;
          }
          $completo = $espacio === '' ? $nombre : "$espacio\\$nombre";
          if (class_exists($completo) || interface_exists($completo) || trait_exists($completo)) {
            $res[] = $completo;
          }
        }
      }
    }
    sort($res);
    return $res;
  }

  /** @return list<string> */
  private static function clasesDelTipo(?ReflectionType $tipo): array
  {
    if ($tipo instanceof ReflectionNamedType) {
      // self, static y parent no distinguen mayúsculas (hay retornos ": Self" en src/), igual que los nombres de clase.
      return $tipo->isBuiltin() || in_array(strtolower($tipo->getName()), ['self', 'static', 'parent'], true) ? [] : [$tipo->getName()];
    }
    if ($tipo instanceof ReflectionUnionType || $tipo instanceof ReflectionIntersectionType) {
      $res = [];
      foreach ($tipo->getTypes() as $parte) {
        $res = array_merge($res, self::clasesDelTipo($parte));
      }
      return $res;
    }
    return [];
  }

  private static function existe(string $clase): bool
  {
    return class_exists($clase) || interface_exists($clase) || trait_exists($clase);
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

  /** @param array<int, mixed> $tokens Texto del siguiente token que no es espacio ni comentario. */
  private static function siguiente(array $tokens, int $i): ?string
  {
    for ($j = $i + 1; $j < count($tokens); $j++) {
      $t = $tokens[$j];
      if (is_array($t) && in_array($t[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
        continue;
      }
      return is_array($t) ? $t[1] : $t;
    }
    return null;
  }

  /** @param array<int, mixed> $tokens Texto del token anterior que no es espacio ni comentario. */
  private static function anterior(array $tokens, int $i): ?string
  {
    for ($j = $i - 1; $j >= 0; $j--) {
      $t = $tokens[$j];
      if (is_array($t) && in_array($t[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
        continue;
      }
      return is_array($t) ? $t[1] : $t;
    }
    return null;
  }

  private static function relativa(string $ruta): string
  {
    return str_replace('\\', '/', substr($ruta, strlen(dirname(__DIR__, 3)) + 1));
  }
}
