<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DOMDocument;
use PHPUnit\Framework\Assert;

/**
 * Oráculo de deserialización (Fase B): serializar con toDOMElement, leer con FromDOMElement o con
 * FromSimpleXMLElement y volver a serializar debe dar el mismo XML byte a byte. Si la vuelta difiere,
 * la lectura perdió, agregó o alteró datos (p. ej. un cero inicial de dCodSeg que cambia el CDC).
 */
final class RoundTrip
{
  public const VIA_DOM = 'FromDOMElement';
  public const VIA_SIMPLEXML = 'FromSimpleXMLElement';
  /** FromSifenResponseObject sobre el objeto que entregaría SoapClient (ver objetoSoap); solo grupos sin atributos. */
  public const VIA_SOAP = 'FromSifenResponseObject';

  /** XML del elemento que produce toDOMElement() en un documento nuevo. */
  public static function serializar(object $grupo): string
  {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $elemento = $grupo->toDOMElement($doc);
    $doc->appendChild($elemento);
    return $doc->saveXML($elemento);
  }

  /**
   * Lee el XML con la vía indicada.
   *
   * @param class-string $clase Clase con los métodos estáticos FromDOMElement / FromSimpleXMLElement.
   */
  public static function leer(string $xml, string $clase, string $via): object
  {
    if ($via === self::VIA_DOM) {
      $doc = new DOMDocument();
      if (!$doc->loadXML($xml)) {
        throw new \RuntimeException('RoundTrip: XML mal formado.');
      }
      return $clase::FromDOMElement($doc->documentElement);
    }
    if ($via === self::VIA_SIMPLEXML) {
      return $clase::FromSimpleXMLElement(simplexml_load_string($xml));
    }
    if ($via === self::VIA_SOAP) {
      return $clase::FromSifenResponseObject(self::objetoSoap($xml));
    }
    throw new \InvalidArgumentException("RoundTrip: vía desconocida $via");
  }

  /**
   * Objeto que entregaría SoapClient si el elemento llegara dentro de una respuesta del SIFEN: el XML se
   * envuelve en un sobre SOAP 1.2 y lo decodifica ext/soap (ver CapturaSoapClient). Los atributos se pierden.
   */
  public static function objetoSoap(string $xmlElemento): \stdClass
  {
    $sobre = '<?xml version="1.0" encoding="UTF-8"?>'
      . '<env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope"><env:Body>'
      . '<ns2:r xmlns:ns2="http://ekuatia.set.gov.py/sifen/xsd">' . $xmlElemento . '</ns2:r>'
      . '</env:Body></env:Envelope>';
    $doc = new DOMDocument();
    $doc->loadXML($xmlElemento);
    return (new CapturaSoapClient($sobre))->r()->{$doc->documentElement->localName};
  }

  /**
   * @param class-string|null $clase Por defecto, la clase del objeto.
   * @return array{0: string, 1: string} [XML de ida, XML de vuelta]
   */
  public static function idaYVuelta(object $grupo, string $via, ?string $clase = null): array
  {
    $ida = self::serializar($grupo);
    $vuelta = self::serializar(self::leer($ida, $clase ?? get_class($grupo), $via));
    return [$ida, $vuelta];
  }

  /** @param class-string|null $clase */
  public static function assertIdaYVueltaIdentica(object $grupo, string $via, ?string $clase = null, string $mensaje = ''): void
  {
    [$ida, $vuelta] = self::idaYVuelta($grupo, $via, $clase);
    Assert::assertSame($ida, $vuelta, trim("$mensaje Ida y vuelta por $via no idéntica"));
  }
}
