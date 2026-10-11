<?php

namespace IonysDev\Pkuatia\Tests\Unit\Responses;

use DOMDocument;
use IonysDev\Pkuatia\Tests\Support\CapturaSoapClient;
use IonysDev\Pkuatia\Tests\Support\RespuestasSifenFactory as R;
use PHPUnit\Framework\TestCase;

/**
 * Fija, como lo entrega SoapClient, el formato real de las respuestas del SIFEN capturadas el 06 y el
 * 09/10/2026 (ekuat-ia/06-ejemplos/respuestas-ws/README.md, observaciones 1 a 9). Estos objetos son
 * la entrada de las clases de respuesta de la librería en los pasos B3 y B4.
 */
final class CapturasRealesTest extends TestCase
{
  /** Observación 1: Id con mayúscula, dFecProc con zona, acentos como referencias numéricas. */
  public function testEnvioAprobado0260(): void
  {
    $prot = R::objetoSoap(R::ENVIO_DE_0260)->rProtDe;
    $this->assertSame('01800000005001001000011322026100915495718099', $prot->Id);
    $this->assertSame('2026-10-09T17:07:15-03:00', $prot->dFecProc);
    $this->assertSame('Aprobado', $prot->dEstRes);
    $this->assertSame('50219661', $prot->dProtAut);
    $this->assertSame('0260', $prot->gResProc->dCodRes);
    $this->assertSame('Autorización del DE satisfactoria', $prot->gResProc->dMsgRes);
  }

  /** Observación 2 del 06/10: el rechazo genérico no trae Id, dDigVal ni dProtAut, también en una consulta de RUC. */
  public function testRechazoGenerico0160(): void
  {
    foreach ([R::ENVIO_DE_0160, R::RUC_0160] as $captura) {
      $prot = R::objetoSoap($captura)->rProtDe;
      $this->assertSame(['dFecProc', 'dEstRes', 'gResProc'], array_keys(get_object_vars($prot)), $captura);
      $this->assertSame('0160', $prot->gResProc->dCodRes);
      $this->assertSame('XML Mal Formado.', $prot->gResProc->dMsgRes);
    }
  }

  /** Observación 2: id en minúscula, después de dEstRes y de dProtAut. */
  public function testEventoAprobado0600(): void
  {
    $r = R::objetoSoap(R::EVENTO_0600);
    $this->assertSame('2026-10-09T17:16:57-03:00', $r->dFecProc);
    $this->assertSame(['dEstRes', 'dProtAut', 'id', 'gResProc'], array_keys(get_object_vars($r->gResProcEVe)));
    $this->assertSame('1167531', $r->gResProcEVe->dProtAut);
    $this->assertSame('1', $r->gResProcEVe->id);
    $this->assertSame('Evento registrado correctamente', $r->gResProcEVe->gResProc->dMsgRes);
  }

  /** Observaciones 3 y 8: 0420 sin xContenDE; en 0422 dFecProc es la fecha de aprobación del DE. */
  public function testConsultaDE0420Y0422(): void
  {
    $this->assertNull(R::xContenDE(R::CONSULTA_DE_0420));
    $this->assertSame('Documento No Existe en SIFEN o ha sido Rechazado', R::objetoSoap(R::CONSULTA_DE_0420)->dMsgRes);
    $this->assertSame('2026-10-09T17:07:15-03:00', R::objetoSoap(R::CONSULTA_DE_0422_CANCELADO)->dFecProc);
  }

  /**
   * Observaciones 4 y 5: xContenDE es texto con declaración XML, rDE, "\n<dProtAut>", "\n<xContEv>" y un
   * espacio final; con eventos, cada xEvento trae su propia declaración. No es un documento XML válido.
   */
  public function testXContenDEEsTextoConVariasRaices(): void
  {
    $sinEventos = R::xContenDE(R::CONSULTA_DE_0422);
    $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?><rDE xmlns="http://ekuatia.set.gov.py/sifen/xsd"', $sinEventos);
    $this->assertStringEndsWith("</rDE>\n<dProtAut>50219661</dProtAut>\n<xContEv></xContEv> ", $sinEventos);

    $cancelado = R::xContenDE(R::CONSULTA_DE_0422_CANCELADO);
    $this->assertSame(2, substr_count($cancelado, '<?xml version="1.0" encoding="UTF-8"?>'));
    $this->assertSame(1, substr_count($cancelado, '<rContEv>'));
    $this->assertStringContainsString("\n<dProtAut>50219661</dProtAut>\n<xContEv>\n\t<rContEv>\n\t\t<xEvento>", $cancelado);
    $this->assertStringContainsString("<dFecProc>2026-10-09T17:16:57</dFecProc>", $cancelado);
    $this->assertStringContainsString('<dMsgRes>Se encontro el evento</dMsgRes>', $cancelado);
    $this->assertStringEndsWith("</xContEv> ", $cancelado);
    // Lo mismo que decodifica libxml en el DOM, y no cargable como un único documento.
    $this->assertSame(R::elementoRespuesta(R::CONSULTA_DE_0422_CANCELADO)->getElementsByTagName('xContenDE')->item(0)->textContent, $cancelado);
    $previo = libxml_use_internal_errors(true);
    $this->assertFalse((new DOMDocument())->loadXML($cancelado));
    libxml_clear_errors();
    libxml_use_internal_errors($previo);
  }

  public function testElClienteDeCapturaConservaLaRespuestaCruda(): void
  {
    $cliente = new CapturaSoapClient(R::crudo(R::EVENTO_4009));
    $r = $cliente->rEnviEventoDe(new \stdClass());
    $this->assertSame(['rEnviEventoDe'], $cliente->operaciones);
    $this->assertSame(R::crudo(R::EVENTO_4009), $cliente->__getLastResponse());
    $this->assertSame('TEST - Plazo de solicitud de cancelación de una FE extemporáneo', $r->gResProcEVe->gResProc->dMsgRes);
  }
}
