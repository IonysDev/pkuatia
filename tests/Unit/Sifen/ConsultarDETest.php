<?php

namespace IonysDev\Pkuatia\Tests\Unit\Sifen;

use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\EmisRecTipCont;
use IonysDev\Pkuatia\Core\Constants\OpeComTipImp;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Core\Responses\RResEnviConsDe;
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Tests\Support\TestCertFactory;
use DateTime;
use DOMDocument;
use PHPUnit\Framework\TestCase;
use SoapClient;
use stdClass;

/**
 * La consulta de un DE por CDC debe conservar la cadena XML original devuelta por el SIFEN.
 * El objeto parseado no sirve para persistir el documento: RDE::toDOMElement() no serializa
 * Signature ni gCamFuFD.
 */
final class ConsultarDETest extends TestCase
{
  private $certCleanup;

  protected function setUp(): void
  {
    $cert = TestCertFactory::createSelfSignedPem();
    $this->certCleanup = $cert['cleanup'];

    $config = new Config();
    $config->certificateFormat = Config::CERT_FORMAT_PEM;
    $config->privateKeyFilePath = $cert['pemPath'];
    $config->privateKeyPassphrase = $cert['passphrase'];
    $config->dIdFilePath = sys_get_temp_dir() . '/pkuatia_did_phpunit_' . uniqid('', true) . '.json';

    Sifen::Init($config);
  }

  protected function tearDown(): void
  {
    Sifen::SetSoapClientFactory(null);
    if ($this->certCleanup) {
      ($this->certCleanup)();
    }
  }

  public function testConsultarDEPreservaElXmlFirmadoOriginal(): void
  {
    $xContenDE = self::signedDeXml();
    $this->stubConsultaResponse('0422', 'CDC encontrado', $xContenDE);

    $result = Sifen::ConsultarDE('01800695631001001000000612021112410777777771');

    $this->assertInstanceOf(RResEnviConsDe::class, $result);
    $this->assertSame(422, $result->getDCodRes());
    // La cadena debe volver byte a byte: cualquier normalización rompería la firma.
    $this->assertSame($xContenDE, $result->getXContenDE());
    $this->assertStringContainsString('<Signature', $result->getXContenDE());
    $this->assertStringContainsString('<gCamFuFD>', $result->getXContenDE());
  }

  public function testElObjetoParseadoSigueDisponible(): void
  {
    $this->stubConsultaResponse('0422', 'CDC encontrado', self::signedDeXml());

    $result = Sifen::ConsultarDE('01800695631001001000000612021112410777777771');

    $this->assertNotNull($result->getRContDe());
    $this->assertNotNull($result->getRContDe()->getRDe());
    $this->assertSame(150, $result->getRContDe()->getRDe()->getDVerFor());
  }

  /**
   * El SIFEN devuelve el rDE junto a elementos hermanos (dProtAut, xContEv), por lo que
   * xContenDE tiene múltiples raíces y no se puede cargar en un parser tal cual.
   * getRDEXml() debe entregar sólo el rDE, bien formado y byte a byte.
   */
  public function testGetRDEXmlRecortaLosElementosHermanosDelSifen(): void
  {
    $rde = self::signedDeXml();
    // Forma real de la respuesta del SIFEN (ver DE consultado en producción).
    $xContenDE = $rde . '<dProtAut>3409990272</dProtAut><xContEv></xContEv>';
    $this->stubConsultaResponse('0422', 'CDC encontrado', $xContenDE);

    $result = Sifen::ConsultarDE('01800695631001001000000612021112410777777771');

    // La cadena cruda no es cargable: es exactamente el fallo que rompía el KUDE.
    $previous = libxml_use_internal_errors(true);
    $invalid = new DOMDocument();
    $this->assertFalse($invalid->loadXML($result->getXContenDE()));
    libxml_clear_errors();
    libxml_use_internal_errors($previous);

    // El recorte sí es un documento válido de una sola raíz.
    $rdeXml = $result->getRDEXml();
    $valid = new DOMDocument();
    $this->assertTrue($valid->loadXML($rdeXml));
    $this->assertSame('rDE', $valid->documentElement->tagName);
    $this->assertStringNotContainsString('dProtAut', $rdeXml);
    $this->assertStringNotContainsString('xContEv', $rdeXml);

    // Y conserva la firma intacta.
    $this->assertStringContainsString('<Signature', $rdeXml);
    $this->assertStringContainsString('<gCamFuFD>', $rdeXml);
    $this->assertSame(1, $valid->getElementsByTagName('SignatureValue')->length);
  }

  public function testGetRDEXmlEsNuloSinContenido(): void
  {
    $this->stubConsultaResponse('0420', 'CDC inexistente', null);

    $result = Sifen::ConsultarDE('01800695631001001000000612021112410777777771');

    $this->assertNull($result->getRDEXml());
  }

  public function testSinContenidoElXmlCrudoEsNulo(): void
  {
    // 0420 - CDC inexistente: el SIFEN no devuelve xContenDE.
    $this->stubConsultaResponse('0420', 'CDC inexistente', null);

    $result = Sifen::ConsultarDE('01800695631001001000000612021112410777777771');

    $this->assertSame(420, $result->getDCodRes());
    $this->assertNull($result->getXContenDE());
    $this->assertNull($result->getRContDe());
  }

  private function stubConsultaResponse(string $codRes, string $msgRes, ?string $xContenDE): void
  {
    Sifen::SetSoapClientFactory(function (string $wsdl, array $options) use ($codRes, $msgRes, $xContenDE): SoapClient {
      return new class($wsdl, $codRes, $msgRes, $xContenDE) extends SoapClient {
        private string $codRes;
        private string $msgRes;
        private ?string $xContenDE;

        public function __construct(string $wsdl, string $codRes, string $msgRes, ?string $xContenDE)
        {
          // Sin llamada de red: el stub no usa el WSDL real.
          $this->codRes = $codRes;
          $this->msgRes = $msgRes;
          $this->xContenDE = $xContenDE;
        }

        public function REnviConsDe($request): stdClass
        {
          $response = new stdClass();
          $response->dFecProc = '2026-07-26T10:15:30-04:00';
          $response->dCodRes = $this->codRes;
          $response->dMsgRes = $this->msgRes;
          if ($this->xContenDE !== null) {
            $response->xContenDE = $this->xContenDE;
          }
          return $response;
        }
      };
    });
  }

  /**
   * Factura realmente firmada, con Signature y gCamFuFD: justamente lo que una
   * re-serialización desde el objeto parseado perdería.
   */
  private static function signedDeXml(): string
  {
    return Sifen::FirmarDE(self::buildFactura()->facturaToRDE(), new DateTime('2026-07-26T10:00:00'));
  }

  /**
   * DE::FromSimpleXMLElement exige gOpeDE, gTimb, gDatGralOpe, gDtipDE y gTotSub,
   * así que el DE de prueba tiene que estar completo (con ítems y totales).
   */
  private static function buildFactura(): Factura
  {
    $factura = new Factura(CamCondOpe::Contado);
    $factura->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
    $factura->setTipoDeImpuestoAfectado(OpeComTipImp::IVA);
    $factura->setMoneda('PYG');
    $factura->setIndicadorPresencia(CamFEIndPres::Presencial);

    $factura->setTimbrado(12345678, new DateTime('2024-01-01'), '001', '001', '0000001', null);
    $factura->setFechaEmision(new DateTime('2026-01-15T10:00:00'));

    $factura->setEmisor(
      '80000000', 5, EmisRecTipCont::PersonaJuridica, null,
      'Empresa de Prueba SA', null,
      'Av. Principal', '100', null, null,
      1, null, 1,
      '021000000', 'test@example.com', null
    );
    $factura->addEmisorActividadEconomica('62010', 'Programación informática');

    $factura->setReceptor(
      'Cliente Prueba', false, RecTiOpe::B2C, 'PRY', null,
      null, null,
      TipIDRec::CedulaParaguaya, '1234567',
      null, null, null, null, null, null, null, null, null, null
    );

    $factura->addItem(
        'ITEM-01', 'Servicio de prueba', 77, '1',
        0, '100000', '100000',
        CamIVAAfecIVA::Gravado, '100', CamIVATasaIVA::IVA10
    );
    $factura->calcTotSub(0, false);

    return $factura;
  }
}
