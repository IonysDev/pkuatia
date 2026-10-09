<?php

namespace IonysDev\Pkuatia\DataMappings;

use DOMDocument;

/**
 * Clase que dispone de métodos para obtener información de las monedas
 * a partir del archivo XML de monedas del https://ekuatia.set.gov.py/sifen/xsd
 */

class MonedaMapping
{
  /**
   * Longitud máxima de la descripción de la moneda en el XSD: tdDMoneTiPag (DE_Types_v150.xsd:884-895),
   * tipo de D016 dDesMoneOpe, E609 dDMoneTiPag y E651 dDMoneCuo.
   */
  public const MAX_LONGITUD_DESCRIPCION = 20;

  /** @var array<int, array<string, mixed>>|null Caché del catálogo. */
  private static ?array $catalogo = null;

  /**
   * Devuelve un array con la lista de monedas.
   *
   * @return array
   */
  public static function GetArray()
  {
    if (self::$catalogo === null) {
      $xml = new DOMDocument();
      $xml->load(__DIR__ . '/Sources/Monedas_v150.xsd');
      $xml->preserveWhiteSpace = true;
      $parseObj = str_replace($xml->lastChild->prefix . ':', "", $xml->saveXML($xml->lastChild));
      $array = json_decode(json_encode(simplexml_load_string($parseObj)), true);
      self::$catalogo = $array['simpleType']['restriction']['enumeration'];
    }
    return self::$catalogo;
  }

  /**
   * Devuelve la descripción de la moneda a partir del código ISO 4217, recortada a los 20 caracteres
   * que admite el XSD (tdDMoneTiPag). 15 monedas del catálogo tienen un CodeName más largo (ANG, BMD,
   * FKP, KYD, MXV, SBD, TMT, TTD, UYI, XCD, XBA, XBB, XBC, XTS, XXX) y producían rechazo de esquema
   * (PK-23). El nombre completo se obtiene con GetCodeName().
   *
   * @param  mixed $code
   *
   * @return String|null null si el código no existe en Monedas_v150.xsd.
   */
  public static function GetDescription($code): ?String
  {
    $nombre = self::GetCodeName($code);
    if ($nombre === null) {
      return null;
    }
    return mb_strlen($nombre) > self::MAX_LONGITUD_DESCRIPCION ? rtrim(mb_substr($nombre, 0, self::MAX_LONGITUD_DESCRIPCION)) : $nombre;
  }

  /**
   * Devuelve el CodeName completo de la moneda tal como figura en Monedas_v150.xsd (sin recortar).
   *
   * @param  mixed $code
   *
   * @return String|null
   */
  public static function GetCodeName($code): ?String
  {
    $buscado = strtoupper((string) $code);
    foreach (self::GetArray() as $value) {
      if (isset($value["@attributes"]['value']) && $value["@attributes"]['value'] == $buscado) {
        return (string) $value['annotation']['documentation']['CodeName'];
      }
    }
    return null;
  }
}
