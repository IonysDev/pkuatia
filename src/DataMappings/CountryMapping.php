<?php

namespace IonysDev\Pkuatia\DataMappings;

use DOMDocument;

/**
 * Read the iso3166.xml file and return an array
 */
class CountryMapping
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
        // Caché estática: hasta 0.3.0 se releía y reparseaba ISO3166.xml en cada llamada (Fase D, D7, deuda D-B4).
        // El arreglo se devuelve por valor, así que quien lo recibe no puede alterar la caché.
        if (self::$catalogo === null) {
            $xml = new DOMDocument();
            $xml->load(__DIR__ . '/Sources/ISO3166.xml');
            $xml->preserveWhiteSpace = true;
            $parseObj = str_replace($xml->lastChild->prefix.':', "", $xml->saveXML($xml->lastChild));
            $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
            self::$catalogo = $array['simpleType']['restriction']['enumeration'];
        }
        return self::$catalogo;
    }

    /**
     * getCountryDesc
     *
     * @param  mixed $country
     * @return String
     */
    public static function getCountryDesc($code): ?string
    {
        $country = strtoupper($code);
        $array = self::getArray();
        ///search the country name in the array, using the aplha-3 element
        foreach ($array as $key => $value) {
            ///if the country code is found, return the name
            if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $country) {
                return $value['annotation']['documentation'];///THE NAME OF THE COUNTRY
            }
        }
        return null;
    }
}
