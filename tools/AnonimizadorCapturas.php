<?php

use IonysDev\Pkuatia\Utils\RucUtils;

/**
 * Anonimiza capturas SOAP reales del SIFEN (solicitudes y respuestas crudas) para archivarlas en un repositorio
 * público: tests/Resources/sifen/respuestas-ws/ y ekuat-ia/06-ejemplos/respuestas-ws/. Conserva la estructura, el
 * orden de los elementos, los espacios de nombres, los códigos y los formatos de fecha; reemplaza los datos
 * identificatorios y el material criptográfico. Versionado en la Fase D (0.3.1, deuda D-A8, decisión Q-D5); la
 * lógica vivía en el harness privado del mantenedor.
 *
 * Los valores reales y sus reemplazos NO están en este archivo: se leen de un mapa JSON que vive fuera del
 * repositorio (ver anonimizar-capturas.mapa.ejemplo.json, con valores inventados):
 *   - emisor / receptor: RUC y DV reales y el RUC ficticio (su DV se calcula);
 *   - literales: textos reales → ficticios (razón social, direcciones, teléfonos, correos), también en la forma con
 *     referencias numéricas (&#241;) que el SIFEN usa dentro de xContenDE;
 *   - numerosDeCasa: números de casa reales → ficticios (dNumCas, dNumCasRec, dNumCasSal, dNumCasEnt);
 *   - sensibles: cadenas que no pueden quedar en la salida (control final).
 *
 * Reemplazos fijos (solo valores ficticios, por eso van en el código): CDC de 44 dígitos → CDC con el RUC y DV
 * ficticios del emisor y el DV final recalculado (mapa consistente dentro de una corrida); timbrado igual al RUC del
 * emisor (el del ambiente de pruebas) → 12345678; dRazCons → "EMPRESA DE PRUEBA S.A."; dCodCliente igual al RUC del
 * receptor → CLI-0001; X509Certificate, SignatureValue, DigestValue, dDigVal, DigestValue= y cHashQR= del QR →
 * marcadores; xDE de rEnvioLote (ZIP en Base64) → marcador. El rDE escapado dentro de xContenDE (&lt;) se
 * decodifica, se anonimiza y se vuelve a escapar.
 */
final class AnonimizadorCapturas
{
    public const MARCADOR_X509 = 'Q0VSVElGSUNBRE9fWDUwOV9BTk9OSU1JWkFETw==';
    public const MARCADOR_SIGNATURE = 'U0lHTkFUVVJFX1ZBTFVFX0FOT05JTUlaQURP';
    public const MARCADOR_DIGEST = 'RElHRVNUX1ZBTFVFX0FOT05JTUlaQURP';
    public const MARCADOR_XDE = 'WklQX0RFTF9MT1RFX0FOT05JTUlaQURP';
    public const TIMBRADO_FICTICIO = '12345678';
    public const RAZON_SOCIAL_FICTICIA = 'EMPRESA DE PRUEBA S.A.';
    public const CODIGO_CLIENTE_FICTICIO = 'CLI-0001';

    private string $rucEmisorReal;
    private string $dvEmisorReal;
    private string $rucEmisorFake;
    private string $dvEmisorFake;
    private string $rucRecReal;
    private string $dvRecReal;
    private string $rucRecFake;
    private string $dvRecFake;
    /** @var array<string, string> */
    private array $literales;
    /** @var array<string, string> */
    private array $numerosDeCasa;
    /** @var list<string> */
    private array $sensibles;
    /** @var array<string, string> CDC real → ficticio, consistente dentro de la corrida */
    private array $mapaCdc = [];

    /**
     * @param array{emisor: array{ruc: string, dv: string, rucFicticio: string}, receptor: array{ruc: string, dv: string, rucFicticio: string}, literales?: array<string, string>, numerosDeCasa?: array<string, string>, sensibles?: list<string>} $mapa
     */
    public function __construct(array $mapa)
    {
        foreach (['emisor', 'receptor'] as $parte) {
            foreach (['ruc', 'dv', 'rucFicticio'] as $clave) {
                if (!isset($mapa[$parte][$clave]) || !is_string($mapa[$parte][$clave]) || $mapa[$parte][$clave] === '') {
                    throw new InvalidArgumentException("El mapa necesita $parte.$clave");
                }
            }
        }
        $this->rucEmisorReal = $mapa['emisor']['ruc'];
        $this->dvEmisorReal = $mapa['emisor']['dv'];
        $this->rucEmisorFake = $mapa['emisor']['rucFicticio'];
        $this->dvEmisorFake = (string) RucUtils::CalcDV($this->rucEmisorFake);
        $this->rucRecReal = $mapa['receptor']['ruc'];
        $this->dvRecReal = $mapa['receptor']['dv'];
        $this->rucRecFake = $mapa['receptor']['rucFicticio'];
        $this->dvRecFake = (string) RucUtils::CalcDV($this->rucRecFake);
        $this->literales = $mapa['literales'] ?? [];
        $this->numerosDeCasa = $mapa['numerosDeCasa'] ?? [];
        $this->sensibles = array_values(array_unique(array_merge(
            [$this->rucEmisorReal, $this->rucRecReal],
            array_keys($this->literales),
            $mapa['sensibles'] ?? []
        )));
    }

    public static function desdeJson(string $ruta): self
    {
        if (!is_file($ruta)) {
            throw new InvalidArgumentException("No existe el mapa $ruta");
        }
        $mapa = json_decode((string) file_get_contents($ruta), true);
        if (!is_array($mapa)) {
            throw new InvalidArgumentException("El mapa $ruta no es un JSON válido: " . json_last_error_msg());
        }
        return new self($mapa);
    }

    /** Anonimiza el XML de una captura (solicitud o respuesta SOAP, rDE suelto o sobre de eventos). */
    public function anonimizar(string $xml): string
    {
        // 0. xContenDE (consulta por CDC): el rDE viene como texto con '<' escapado (&lt;, no '>') y los caracteres no
        //    ASCII como referencias numéricas. Se decodifica solo &lt;, se anonimiza y se vuelve a escapar.
        if (str_contains($xml, '&lt;rDE')) {
            $xml = preg_replace_callback('#(<(?:ns\d+:)?xContenDE>)(.*?)(</(?:ns\d+:)?xContenDE>)#s', function (array $m): string {
                $dec = str_replace('&lt;', '<', $m[2]);
                return $m[1] . str_replace('<', '&lt;', $this->anonimizar($dec)) . $m[3];
            }, $xml);
        }

        // 1. CDC (44 dígitos) con mapa consistente: Id="", <Id>, <id>, URI="#", Id= del QR, dCDC, dCDCAnticipo…
        $xml = preg_replace_callback('/(?<![0-9])([0-9]{44})(?![0-9])/', fn (array $m): string => $this->cdcFicticio($m[1]), $xml);

        // 2. Emisor y receptor (elementos concretos para no tocar otros números)
        $xml = preg_replace('#<(dRucEm)>' . preg_quote($this->rucEmisorReal, '#') . '</dRucEm>#', '<$1>' . $this->rucEmisorFake . '</dRucEm>', $xml);
        $xml = preg_replace('#<(dDVEmi)>' . preg_quote($this->dvEmisorReal, '#') . '</dDVEmi>#', '<$1>' . $this->dvEmisorFake . '</dDVEmi>', $xml);
        $xml = preg_replace('#<(dRucRec)>' . preg_quote($this->rucRecReal, '#') . '</dRucRec>#', '<$1>' . $this->rucRecFake . '</dRucRec>', $xml);
        $xml = preg_replace('#<(dDVRec)>' . preg_quote($this->dvRecReal, '#') . '</dDVRec>#', '<$1>' . $this->dvRecFake . '</dDVRec>', $xml);
        $xml = preg_replace('#<(dCodCliente)>' . preg_quote($this->rucRecReal, '#') . '</dCodCliente>#', '<$1>' . self::CODIGO_CLIENTE_FICTICIO . '</dCodCliente>', $xml);
        // Autofactura: el receptor es el propio emisor (D206e)
        $xml = preg_replace('#<(dRucRec)>' . preg_quote($this->rucEmisorReal, '#') . '</dRucRec>#', '<$1>' . $this->rucEmisorFake . '</dRucRec>', $xml);
        $xml = str_replace('<dRucRec>' . $this->rucEmisorFake . '</dRucRec><dDVRec>' . $this->dvEmisorReal . '</dDVRec>',
            '<dRucRec>' . $this->rucEmisorFake . '</dRucRec><dDVRec>' . $this->dvEmisorFake . '</dDVRec>', $xml);
        // QR
        $xml = str_replace('dRucRec=' . $this->rucRecReal, 'dRucRec=' . $this->rucRecFake, $xml);
        $xml = str_replace('dRucRec=' . $this->rucEmisorReal, 'dRucRec=' . $this->rucEmisorFake, $xml);
        // Consulta de RUC
        $xml = preg_replace('#<((?:ns\d+:)?dRUCCons)>' . preg_quote($this->rucEmisorReal, '#') . '<#', '<$1>' . $this->rucEmisorFake . '<', $xml);
        $xml = preg_replace('#<((?:ns\d+:)?dRazCons)>[^<]*<#', '<$1>' . self::RAZON_SOCIAL_FICTICIA . '<', $xml);
        // El timbrado del ambiente de pruebas coincide con el RUC del emisor: pasa al timbrado genérico de los ejemplos.
        $xml = str_replace('<dNumTim>' . $this->rucEmisorReal . '</dNumTim>', '<dNumTim>' . self::TIMBRADO_FICTICIO . '</dNumTim>', $xml);
        // Números de casa (emisor, receptor y los locales de salida y entrega de la NR)
        foreach ($this->numerosDeCasa as $real => $fake) {
            foreach (['dNumCas', 'dNumCasRec', 'dNumCasSal', 'dNumCasEnt'] as $elemento) {
                $xml = str_replace("<$elemento>$real</$elemento>", "<$elemento>$fake</$elemento>", $xml);
            }
        }
        // El xDE de rEnvioLote es el ZIP de los rDE en Base64 y no se anonimiza por dentro: marcador. Los rDE del lote
        // se guardan aparte y se anonimizan como los demás.
        $xml = preg_replace('#(<(?:[\w-]+:)?xDE>)[A-Za-z0-9+/=\s]{100,}(</(?:[\w-]+:)?xDE>)#', '$1' . self::MARCADOR_XDE . '$2', $xml);

        // 3. Literales, también con referencias numéricas (&#241;) como los devuelve el SIFEN dentro de xContenDE
        foreach ($this->literales as $real => $fake) {
            $xml = str_replace($real, $fake, $xml);
            $xml = str_replace(mb_encode_numericentity($real, [0x80, 0x10FFFF, 0, 0x1FFFFF], 'UTF-8'), $fake, $xml);
        }

        // 4. Material criptográfico y hashes → marcadores (conservan la posición de los elementos)
        $xml = preg_replace('#(<(?:ds:)?X509Certificate>)[^<]+(</(?:ds:)?X509Certificate>)#', '$1' . self::MARCADOR_X509 . '$2', $xml);
        $xml = preg_replace('#(<(?:ds:)?SignatureValue>)[^<]+(</(?:ds:)?SignatureValue>)#', '$1' . self::MARCADOR_SIGNATURE . '$2', $xml);
        $xml = preg_replace('#(<(?:ds:)?DigestValue>)[^<]+(</(?:ds:)?DigestValue>)#', '$1' . self::MARCADOR_DIGEST . '$2', $xml);
        $xml = preg_replace('#(<(?:ns\d+:)?dDigVal>)[^<]+(<)#', '$1' . self::MARCADOR_DIGEST . '$2', $xml);
        $xml = preg_replace('#DigestValue=[0-9a-fA-F]+#', 'DigestValue=[DIGEST_HEX]', $xml);
        $xml = preg_replace('#cHashQR=[0-9a-fA-F]+#', 'cHashQR=[HASH_SHA256_HEX]', $xml);

        return $xml;
    }

    /** Reemplaza en un texto cualquiera (nombre de archivo, meta.json) los CDC ya mapeados y el RUC del emisor. */
    public function anonimizarTexto(string $texto): string
    {
        foreach ($this->mapaCdc as $real => $fake) {
            $texto = str_replace($real, $fake, $texto);
        }
        return str_replace($this->rucEmisorReal, $this->rucEmisorFake, $texto);
    }

    /** @return list<string> cadenas sensibles que siguen presentes (vacío si la anonimización fue completa). */
    public function sensiblesPresentes(string $texto): array
    {
        $presentes = [];
        foreach ($this->sensibles as $s) {
            if ($s !== '' && stripos($texto, $s) !== false) {
                $presentes[] = $s;
            }
        }
        return $presentes;
    }

    /** @return array<string, string> */
    public function getMapaCdc(): array
    {
        return $this->mapaCdc;
    }

    /**
     * Anonimiza todos los .xml de una carpeta (y su meta.json si existe) en la carpeta destino. Devuelve, por archivo
     * escrito, las cadenas sensibles que quedaron (vacío si ninguna).
     *
     * @return array<string, list<string>>
     */
    public function procesarCarpeta(string $dir, string $out): array
    {
        if (!is_dir($dir)) {
            throw new InvalidArgumentException("No existe $dir");
        }
        if (!is_dir($out) && !mkdir($out, 0755, true)) {
            throw new RuntimeException("No se pudo crear $out");
        }
        $resultado = [];
        foreach (glob("$dir/*.xml") ?: [] as $archivo) {
            $anon = $this->anonimizar((string) file_get_contents($archivo));
            $nombre = $this->anonimizarTexto(basename($archivo)); // el nombre de la FE firmada contiene el CDC
            file_put_contents("$out/$nombre", $anon);
            $resultado[$nombre] = $this->sensiblesPresentes($anon);
        }
        if (is_file("$dir/meta.json")) {
            $json = $this->anonimizarTexto((string) file_get_contents("$dir/meta.json"));
            file_put_contents("$out/meta.json", $json);
            $resultado['meta.json'] = $this->sensiblesPresentes($json);
        }
        return $resultado;
    }

    /** CDC real → ficticio consistente: RUC y DV del emisor reemplazados y DV final recalculado. */
    private function cdcFicticio(string $cdc): string
    {
        if (isset($this->mapaCdc[$cdc])) {
            return $this->mapaCdc[$cdc];
        }
        $nuevo = $cdc;
        if (substr($cdc, 2, 9) === $this->rucEmisorReal . $this->dvEmisorReal) {
            $base = substr($cdc, 0, 2) . $this->rucEmisorFake . $this->dvEmisorFake . substr($cdc, 11, 32);
            $nuevo = $base . RucUtils::CalcDV($base);
        }
        $this->mapaCdc[$cdc] = $nuevo;
        return $nuevo;
    }
}
