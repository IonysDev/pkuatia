<?php

// namespace IonysDev\Pkuatia\Helpers;
namespace IonysDev\Pkuatia\DataMappings;

use DOMDocument;

class DepartamentoMapping
{
    /**
     * getArray
     *
     * @return array
     */
    /** @var array<int, array<string, mixed>>|null Caché del catálogo (Fase D, D7). */
    private static ?array $catalogo = null;

    public static function getArray(): array
    {
        // Caché estática: hasta 0.3.0 se releía y reparseaba Departamentos_v141.xsd en cada llamada (Fase D, D7, D-B4).
        if (self::$catalogo === null) {
            $xml = new DOMDocument();
            $xml->load(__DIR__ . '/Sources/Departamentos_v141.xsd');
            $xml->preserveWhiteSpace = true;
            $parseObj = str_replace($xml->lastChild->prefix.':', "", $xml->saveXML($xml->lastChild));
            $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
            self::$catalogo = $array['simpleType'][0]['restriction']['enumeration'];
        }
        return self::$catalogo;
    }

    public static function getDepName($code): ?string
    {
        $depCode = strtoupper($code);
        $array = self::getArray();
        ///iterate the array
        foreach ($array as $key => $value) {
            if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $depCode) {
                $res = $value['annotation']['documentation'];
                return $res;
            }
        }
        return null;
    }
}
