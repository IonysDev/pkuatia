<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants\TipoFallaTransporte;
use IonysDev\Pkuatia\Core\Exceptions\TransporteException;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\SifenTestEnvironment;
use PHPUnit\Framework\TestCase;
use SoapClient;

/**
 * Fase D, D7 (deuda D-B5): Config::$soapReadTimeout limita cuánto se espera la respuesta del SIFEN una vez
 * conectado. La extensión SOAP ignora http.timeout del contexto de flujo y toma el tiempo de lectura de
 * default_socket_timeout (verificado el 08/11/2026), así que el facade fija ese ini solo durante la llamada y lo
 * restaura. El servidor de prueba acepta la conexión (backlog del kernel) y nunca responde.
 */
final class TimeoutLecturaSoapTest extends TestCase
{
    private array $entorno;
    /** @var resource */
    private $servidor;
    private string $direccion;
    private string $iniOriginal;

    protected function setUp(): void
    {
        $this->entorno = SifenTestEnvironment::init();
        $this->servidor = stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
        $this->assertNotFalse($this->servidor, "no se pudo abrir el servidor local: $errstr");
        $this->direccion = stream_socket_get_name($this->servidor, false);
        $this->iniOriginal = (string) ini_get('default_socket_timeout');
    }

    protected function tearDown(): void
    {
        ini_set('default_socket_timeout', $this->iniOriginal);
        fclose($this->servidor);
        ($this->entorno['cleanup'])();
    }

    /** Cliente SOAP real, sin WSDL, apuntado al servidor local mudo; recibe las opciones que arma Sifen::Init(). */
    private function instalarClienteLocal(): void
    {
        $direccion = $this->direccion;
        Sifen::SetSoapClientFactory(function (string $wsdl, array $opciones) use ($direccion): SoapClient {
            unset($opciones['cache_wsdl']);
            return new SoapClient(null, ['location' => "http://$direccion/ws", 'uri' => 'urn:prueba', 'connection_timeout' => 2] + $opciones);
        });
    }

    public function testConElTimeoutConfiguradoLaLecturaSeCortaYElIniSeRestaura(): void
    {
        ini_set('default_socket_timeout', '30');
        /** @var Config $config */
        $config = $this->entorno['config'];
        $config->setSoapReadTimeout(1);
        Sifen::Init($config);
        $this->instalarClienteLocal();

        $inicio = microtime(true);
        try {
            Sifen::ConsultarRUC('80000000');
            $this->fail('debía agotarse el tiempo de lectura');
        } catch (TransporteException $e) {
            $this->assertSame(TipoFallaTransporte::TiempoAgotado, $e->getTipo(), $e->getMessage());
        }
        $this->assertLessThan(4, microtime(true) - $inicio, 'con soapReadTimeout = 1 no debe esperar los 30 s del ini');
        $this->assertSame('30', ini_get('default_socket_timeout'), 'el ini vuelve a su valor aunque la llamada lance');
    }

    public function testSinConfigurarRigeElIniDePhp(): void
    {
        ini_set('default_socket_timeout', '2');
        /** @var Config $config */
        $config = $this->entorno['config'];
        $this->assertNull($config->soapReadTimeout);
        Sifen::Init($config);
        $this->instalarClienteLocal();

        $inicio = microtime(true);
        try {
            Sifen::ConsultarRUC('80000000');
            $this->fail('debía agotarse el tiempo de lectura');
        } catch (TransporteException $e) {
            $this->assertSame(TipoFallaTransporte::TiempoAgotado, $e->getTipo());
        }
        $transcurrido = microtime(true) - $inicio;
        $this->assertGreaterThanOrEqual(1.5, $transcurrido, 'sin configurar, espera lo que diga default_socket_timeout');
        $this->assertSame('2', ini_get('default_socket_timeout'));
    }

    public function testConfigDesdeJsonYSetter(): void
    {
        $config = Config::ParseObject((object) ['privateKeyFilePath' => 'x.pem', 'privateKeyPassphrase' => 'x', 'soapReadTimeout' => '45']);
        $this->assertSame(45, $config->soapReadTimeout);
        $this->assertNull((new Config())->soapReadTimeout);
        $this->assertSame(12, (new Config())->setSoapReadTimeout(12)->soapReadTimeout);
    }
}
