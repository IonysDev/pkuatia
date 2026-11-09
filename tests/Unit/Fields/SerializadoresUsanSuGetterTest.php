<?php

namespace IonysDev\Pkuatia\Tests\Unit\Fields;

use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * QA final de la Fase D (Q-D6). GCamSal::toDOMElement() escribía cDepSal con getCDisSal() (corregido por Gabriel Gauto
 * en 1f479ba) y ningún test lo veía, porque los fixtures usan el mismo código para departamento, distrito y ciudad.
 * Este test revisa en todo src/ que cada XmlHelper::elemento($doc, 'nombre', $this->...) tome el valor del miembro que
 * lleva el nombre del elemento, sin distinguir mayúsculas: el getter getNombre() (o getFormattedNombre(), o
 * getNombreDecimal() para los decimales BCMath) o la propiedad $nombre. Un getter intercambiado entre dos elementos
 * hermanos deja el XML bien formado y pasa con cualquier fixture que repita valores, así que solo así se detecta.
 */
final class SerializadoresUsanSuGetterTest extends TestCase
{
    public function testCadaElementoSeEscribeConElMiembroDeSuMismoNombre(): void
    {
        $raiz = dirname(__DIR__, 3) . '/src';
        $pares = 0;
        $discordantes = [];
        $archivos = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($raiz, FilesystemIterator::SKIP_DOTS));
        foreach ($archivos as $archivo) {
            if ($archivo->getExtension() !== 'php') {
                continue;
            }
            $codigo = (string) file_get_contents($archivo->getPathname());
            preg_match_all('/elemento\(\s*\$\w+,\s*\'(\w+)\',\s*\$this->(\w+)(\(\))?/', $codigo, $usos, PREG_SET_ORDER);
            foreach ($usos as $uso) {
                $pares++;
                [, $elemento, $miembro] = $uso;
                if (isset($uso[3])) {
                    $coincide = preg_match('/^get(?:Formatted)?(\w+?)(?:Decimal)?$/i', $miembro, $partes) === 1
                        && strcasecmp($partes[1], $elemento) === 0;
                    $miembro .= '()';
                } else {
                    $coincide = strcasecmp($miembro, $elemento) === 0;
                }
                if (!$coincide) {
                    $discordantes[] = substr($archivo->getPathname(), strlen($raiz) + 1) . ": $elemento <- \$this->$miembro";
                }
            }
        }

        $this->assertGreaterThan(400, $pares, 'El patrón dejó de reconocer las llamadas a XmlHelper::elemento().');
        $this->assertSame([], $discordantes);
    }
}
