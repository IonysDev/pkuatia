<?php

namespace IonysDev\Pkuatia\Tests\Support;

use IonysDev\Pkuatia\Sifen;
use SoapClient;
use stdClass;

/**
 * SoapClient de prueba: no toca la red, registra cada operación invocada (con su request) y
 * devuelve la respuesta preparada para esa operación. Se instala con instalar() vía
 * Sifen::SetSoapClientFactory; SifenTestEnvironment::init() lo desinstala en su cleanup.
 */
final class StubSoapClient extends SoapClient
{
  /** @var list<array{op: string, request: mixed}> */
  public static array $llamadas = [];

  /** @var array<string, callable(mixed): mixed> operación (en minúsculas) => callable que devuelve la respuesta */
  private array $respuestas;

  /** @param array<string, callable(mixed): mixed> $respuestas */
  public function __construct(array $respuestas)
  {
    // Sin parent::__construct: no se descarga ningún WSDL.
    $this->respuestas = array_change_key_case($respuestas, CASE_LOWER);
  }

  /** @param array<string, callable(mixed): mixed> $respuestas */
  public static function instalar(array $respuestas): void
  {
    self::$llamadas = [];
    Sifen::SetSoapClientFactory(static fn (): SoapClient => new self($respuestas));
  }

  public function __call(string $name, array $args): mixed
  {
    $request = $args[0] ?? null;
    self::$llamadas[] = ['op' => $name, 'request' => $request];
    $clave = strtolower($name);
    if (!isset($this->respuestas[$clave])) {
      throw new \RuntimeException("StubSoapClient: sin respuesta preparada para la operación $name");
    }
    return ($this->respuestas[$clave])($request);
  }

  public static function ultimoRequest(): mixed
  {
    $ultima = end(self::$llamadas);
    return $ultima === false ? null : $ultima['request'];
  }

  /** Respuesta rRetEnviEventoDe con un evento aprobado (0600), con la forma que parsea la librería. */
  public static function respuestaEventoAprobado(int $id = 1): stdClass
  {
    $proc = new stdClass();
    $proc->dCodRes = '0600';
    $proc->dMsgRes = 'Evento registrado correctamente';
    $ev = new stdClass();
    $ev->dEstRes = 'Aprobado';
    $ev->dProtAut = '1234567890';
    $ev->id = (string) $id;
    $ev->gResProc = $proc;
    $r = new stdClass();
    $r->dFecProc = '2026-01-16T09:00:05-03:00';
    $r->gResProcEVe = $ev;
    return $r;
  }
}
