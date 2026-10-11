<?php

namespace IonysDev\Pkuatia\Tests\Support;

use DOMDocument;
use DOMElement;
use SoapClient;
use stdClass;

/**
 * SoapClient sin red que responde cada llamada con una respuesta cruda del SIFEN (por ejemplo, una
 * captura real de tests/Resources/sifen/respuestas-ws/). La decodificación la hace ext/soap, igual que
 * en producción: entidades (&lt;, &#243;), objetos anidados y elementos repetidos como arreglo.
 *
 * Como no hay copia local de los WSDL del SIFEN, el cliente trabaja en modo sin WSDL y el resultado se
 * reenvuelve con la forma del modo WSDL document/literal que usa la librería: un stdClass con un
 * atributo por cada hijo del elemento de respuesta (p. ej. rRetEnviDe -> {rProtDe}). Diferencia
 * conocida: sin WSDL todas las hojas llegan como string; con el WSDL real algunas podrían llegar como
 * int según su tipo [PENDIENTE DE VERIFICACIÓN]. Las clases de respuesta deben aceptar ambas formas.
 *
 * Como con el WSDL real, si el elemento de respuesta no es el que declara la operación (p. ej. el rechazo
 * genérico rRetEnviDe > rProtDe, 0160, que el SIFEN manda también a la consulta de RUC, de DE, de lote y a los
 * eventos), la llamada devuelve null: ext/soap no encuentra la parte de salida. Lo registran las capturas reales
 * del 06/10/2026 (respuestas-ws/2026-10-06/meta-0704.json y meta-0740.json: "Error Processing Request: null"
 * en la consulta de RUC) y del 11/10/2026. Hasta B13 este cliente devolvía igual el objeto y lo ocultaba.
 *
 * Con trace activado, __getLastRequest() y __getLastResponse() funcionan como en el cliente real.
 */
final class CapturaSoapClient extends SoapClient
{
  /**
   * Elemento de respuesta que declara cada operación del WSDL del SIFEN (en minúsculas, como las resuelve ext/soap).
   * Fuentes: capturas reales de respuestas-ws y la guía de mejores prácticas de la DNIT (§6-§8). El de
   * rEnviConsArchivoRUC no está verificado: el WS no respondió en ningún ambiente.
   */
  public const RESPUESTA_POR_OPERACION = [
    'renvide' => 'rRetEnviDe',
    'renviolote' => 'rResEnviLoteDe',
    'renviconslotede' => 'rResEnviConsLoteDe',
    'renviconsde' => 'rEnviConsDeResponse',
    'renviconsruc' => 'rResEnviConsRUC',
    'renvieventode' => 'rRetEnviEventoDe',
    'renviconsarchivoruc' => 'rResEnviConsArchivoRUC',
  ];

  /** @var list<string> Operaciones invocadas, en orden. */
  public array $operaciones = [];

  private string $respuestaCruda;

  public function __construct(string $respuestaCruda)
  {
    parent::__construct(null, [
      'location' => 'https://sifen-test.invalid/de/ws',
      'uri' => 'http://ekuatia.set.gov.py/sifen/xsd',
      'soap_version' => SOAP_1_2,
      'trace' => true,
      'exceptions' => true,
    ]);
    $this->respuestaCruda = $respuestaCruda;
  }

  /** Instala este cliente en el facade: toda operación recibe la misma respuesta cruda. */
  public static function instalar(string $respuestaCruda): void
  {
    \IonysDev\Pkuatia\Sifen::SetSoapClientFactory(static fn (): SoapClient => new self($respuestaCruda));
  }

  public function __doRequest($request, $location, $action, $version, $oneWay = false): ?string
  {
    return $this->respuestaCruda;
  }

  public function __call($name, $args): mixed
  {
    $this->operaciones[] = $name;
    $valor = $this->__soapCall($name, $args); // también deja __getLastRequest() y __getLastResponse() como el cliente real
    $esperado = self::RESPUESTA_POR_OPERACION[strtolower($name)] ?? null;
    if ($esperado !== null && self::elementoRespuesta($this->respuestaCruda)->localName !== $esperado) {
      return null;
    }
    return self::comoModoWsdl($valor, $this->respuestaCruda);
  }

  /**
   * Reenvuelve el valor decodificado sin WSDL con la forma del modo WSDL document/literal. Sin WSDL,
   * ext/soap devuelve directamente el valor del único hijo del elemento de respuesta, o un arreglo
   * asociativo cuando hay varios; con WSDL devuelve el elemento de respuesta como objeto.
   */
  public static function comoModoWsdl(mixed $valor, string $respuestaCruda): stdClass
  {
    $nombres = [];
    foreach (self::elementoRespuesta($respuestaCruda)->childNodes as $hijo) {
      if ($hijo instanceof DOMElement) {
        $nombres[$hijo->localName] = true;
      }
    }
    if (count($nombres) === 1) {
      $res = new stdClass();
      $res->{array_key_first($nombres)} = $valor;
      return $res;
    }
    return (object) $valor;
  }

  /** Primer elemento hijo de env:Body (el elemento de respuesta: rRetEnviDe, rEnviConsDeResponse, ...). */
  public static function elementoRespuesta(string $respuestaCruda): DOMElement
  {
    $doc = new DOMDocument();
    if (!$doc->loadXML($respuestaCruda)) {
      throw new \RuntimeException('CapturaSoapClient: la respuesta no es XML bien formado.');
    }
    foreach ($doc->documentElement->childNodes as $hijo) {
      if ($hijo instanceof DOMElement && $hijo->localName === 'Body') {
        foreach ($hijo->childNodes as $respuesta) {
          if ($respuesta instanceof DOMElement) {
            return $respuesta;
          }
        }
      }
    }
    throw new \RuntimeException('CapturaSoapClient: la respuesta no tiene elemento en el Body.');
  }
}
