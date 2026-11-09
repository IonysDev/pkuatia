<?php

namespace IonysDev\Pkuatia\Tests\Unit\Tools;

use IonysDev\Pkuatia\Utils\RucUtils;
use PHPUnit\Framework\TestCase;

/**
 * Fase D, D13 (deuda D-A8, decisión Q-D5 = A): tools/AnonimizadorCapturas.php, la lógica del anonimizador del harness
 * privado con el mapa real → ficticio afuera del repositorio. Los "reales" de este test son inventados.
 */
final class AnonimizadorCapturasTest extends TestCase
{
    private const HERRAMIENTA = __DIR__ . '/../../../tools/AnonimizadorCapturas.php';
    private const MAPA_EJEMPLO = __DIR__ . '/../../../tools/anonimizar-capturas.mapa.ejemplo.json';
    private const CAPTURA_ANONIMIZADA = __DIR__ . '/../../../tests/Resources/sifen/respuestas-ws/2026-10-09/03-FE-firmada-anonimizada.xml';

    /** @var array<string, mixed> */
    private const MAPA = [
        'emisor' => ['ruc' => '80099999', 'dv' => '4', 'rucFicticio' => '80000000'],
        'receptor' => ['ruc' => '80088888', 'dv' => '8', 'rucFicticio' => '80012345'],
        'literales' => ['RAZON SOCIAL REAL S.A.' => 'EMPRESA DE PRUEBA S.A.', 'Cañada Real 12' => 'Avda. Ficticia 100', 'real@example.com' => 'emisor@example.com'],
        'numerosDeCasa' => ['1234' => '100'],
        'sensibles' => ['RAZON SOCIAL REAL'],
    ];

    public static function setUpBeforeClass(): void
    {
        require_once self::HERRAMIENTA;
    }

    private static function cdcReal(): string
    {
        // 44 dígitos: tipo 01, RUC+DV del emisor "real", establecimiento 001, punto 001, número 0000123, resto, DV final
        $base = '01' . '80099999' . '4' . '001' . '001' . '0000123' . '1' . '20261108' . '1' . '123456789';
        return $base . RucUtils::CalcDV($base);
    }

    public function testAnonimizaUnRdeConLosValoresDelMapa(): void
    {
        $cdc = self::cdcReal();
        $xml = '<rDE><DE Id="' . $cdc . '"><gTimb><dNumTim>80099999</dNumTim></gTimb>'
            . '<gEmis><dRucEm>80099999</dRucEm><dDVEmi>4</dDVEmi><dNomEmi>RAZON SOCIAL REAL S.A.</dNomEmi><dDirEmi>Cañada Real 12</dDirEmi><dNumCas>1234</dNumCas><dEmailE>real@example.com</dEmailE></gEmis>'
            . '<gDatRec><dRucRec>80088888</dRucRec><dDVRec>8</dDVRec><dCodCliente>80088888</dCodCliente><dNumCasRec>1234</dNumCasRec></gDatRec>'
            . '<gCamDEAsoc><dCdCDERef>' . $cdc . '</dCdCDERef></gCamDEAsoc></DE>'
            . '<Signature><SignedInfo><Reference URI="#' . $cdc . '"><DigestValue>abc=</DigestValue></Reference></SignedInfo><SignatureValue>firma==</SignatureValue><KeyInfo><X509Data><X509Certificate>MIIcert</X509Certificate></X509Data></KeyInfo></Signature>'
            . '<gCamFuFD><dCarQR>https://ekuatia.set.gov.py/consultas-test/qr?nVersion=150&amp;Id=' . $cdc . '&amp;dRucRec=80088888&amp;DigestValue=0a1b2c&amp;cHashQR=ffee00</dCarQR></gCamFuFD></rDE>';

        $a = new \AnonimizadorCapturas(self::MAPA);
        $anon = $a->anonimizar($xml);

        $cdcFake = $a->getMapaCdc()[$cdc];
        $this->assertSame(44, strlen($cdcFake));
        $this->assertSame('01' . '80000000' . RucUtils::CalcDV('80000000'), substr($cdcFake, 0, 11), 'RUC y DV ficticios del emisor');
        $this->assertSame(substr($cdc, 11, 32), substr($cdcFake, 11, 32), 'el resto del CDC se conserva');
        $this->assertSame((string) RucUtils::CalcDV(substr($cdcFake, 0, 43)), substr($cdcFake, 43), 'DV final recalculado');
        $this->assertSame(4, substr_count($anon, $cdcFake), 'Id, dCdCDERef, URI y el Id del QR con el mismo CDC ficticio');
        $this->assertStringNotContainsString($cdc, $anon);

        $this->assertStringContainsString('<dNumTim>12345678</dNumTim>', $anon);
        $this->assertStringContainsString('<dRucEm>80000000</dRucEm><dDVEmi>' . RucUtils::CalcDV('80000000') . '</dDVEmi>', $anon);
        $this->assertStringContainsString('<dRucRec>80012345</dRucRec><dDVRec>' . RucUtils::CalcDV('80012345') . '</dDVRec><dCodCliente>CLI-0001</dCodCliente>', $anon);
        $this->assertStringContainsString('<dNumCas>100</dNumCas>', $anon);
        $this->assertStringContainsString('<dNumCasRec>100</dNumCasRec>', $anon);
        $this->assertStringContainsString('<dNomEmi>EMPRESA DE PRUEBA S.A.</dNomEmi>', $anon);
        $this->assertStringContainsString('<dDirEmi>Avda. Ficticia 100</dDirEmi>', $anon);
        $this->assertStringContainsString('<dEmailE>emisor@example.com</dEmailE>', $anon);
        $this->assertStringContainsString('<X509Certificate>' . \AnonimizadorCapturas::MARCADOR_X509 . '</X509Certificate>', $anon);
        $this->assertStringContainsString('<SignatureValue>' . \AnonimizadorCapturas::MARCADOR_SIGNATURE . '</SignatureValue>', $anon);
        $this->assertStringContainsString('<DigestValue>' . \AnonimizadorCapturas::MARCADOR_DIGEST . '</DigestValue>', $anon);
        $this->assertStringContainsString('dRucRec=80012345&amp;DigestValue=[DIGEST_HEX]&amp;cHashQR=[HASH_SHA256_HEX]', $anon);
        $this->assertSame([], $a->sensiblesPresentes($anon));
        $this->assertNotSame([], $a->sensiblesPresentes($xml), 'el control detecta el original');
    }

    public function testElRdeEscapadoDentroDeXContenDEYLasReferenciasNumericas(): void
    {
        $cdc = self::cdcReal();
        $interno = '<rDE><DE Id="' . $cdc . '"><dRucEm>80099999</dRucEm><dDirEmi>Ca&#241;ada Real 12</dDirEmi></DE></rDE>';
        $xml = '<ns2:rResEnviConsDe><ns2:dCodRes>0422</ns2:dCodRes><ns2:xContenDE>' . str_replace('<', '&lt;', $interno) . '</ns2:xContenDE></ns2:rResEnviConsDe>';
        $a = new \AnonimizadorCapturas(self::MAPA);
        $anon = $a->anonimizar($xml);
        $this->assertStringContainsString('&lt;dRucEm>80000000&lt;/dRucEm>', $anon, 'anonimizado dentro del texto escapado, que sigue escapado');
        $this->assertStringContainsString('&lt;dDirEmi>Avda. Ficticia 100&lt;/dDirEmi>', $anon, 'el literal con referencia numérica también se reemplaza');
        $this->assertStringContainsString('Id="' . $a->getMapaCdc()[$cdc] . '"', $anon);
        $this->assertStringNotContainsString('80099999', $anon);
    }

    public function testElMapaExigeEmisorYReceptorYSeLeeDesdeJson(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new \AnonimizadorCapturas(['emisor' => ['ruc' => '1']]);
    }

    public function testUnaCapturaYaAnonimizadaQuedaIdenticaConElMapaDeEjemplo(): void
    {
        $a = \AnonimizadorCapturas::desdeJson(self::MAPA_EJEMPLO);
        $original = (string) file_get_contents(self::CAPTURA_ANONIMIZADA);
        $this->assertSame($original, $a->anonimizar($original), 'sin valores "reales" presentes, los marcadores vuelven a ser los mismos');
        $this->assertSame([], $a->sensiblesPresentes($original));
    }

    public function testProcesaUnaCarpetaYRenombraElArchivoConElCdc(): void
    {
        $cdc = self::cdcReal();
        $dir = sys_get_temp_dir() . '/pkuatia-anon-' . bin2hex(random_bytes(4));
        mkdir("$dir/in", 0777, true);
        file_put_contents("$dir/in/FE-80099999-$cdc.xml", '<rDE><DE Id="' . $cdc . '"><dRucEm>80099999</dRucEm></DE></rDE>');
        file_put_contents("$dir/in/meta.json", json_encode(['cdc' => $cdc, 'ruc' => '80099999']));
        try {
            $a = new \AnonimizadorCapturas(self::MAPA);
            $resultado = $a->procesarCarpeta("$dir/in", "$dir/out");
            $cdcFake = $a->getMapaCdc()[$cdc];
            $this->assertSame(['FE-80000000-' . $cdcFake . '.xml' => [], 'meta.json' => []], $resultado);
            $this->assertFileExists("$dir/out/FE-80000000-$cdcFake.xml");
            $this->assertStringContainsString('"cdc":"' . $cdcFake . '"', (string) file_get_contents("$dir/out/meta.json"));
        } finally {
            foreach (glob("$dir/*/*") ?: [] as $f) {
                unlink($f);
            }
            @rmdir("$dir/in");
            @rmdir("$dir/out");
            @rmdir($dir);
        }
    }
}
