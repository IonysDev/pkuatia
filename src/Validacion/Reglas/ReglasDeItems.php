<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use IonysDev\Pkuatia\Validacion\ErrorValidacion;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * Reglas de los ítems (E700-E739; errores-validacion.md, MT §12.4 E8, y NT-013): códigos DNCP (1800/1801), relevancia
 * de las mercaderías (1807/1808), tipo de cambio por ítem (1854-1856), total bruto (1859), descuento particular
 * (1852/1861), total de la operación por ítem (1853) y en guaraníes (1857/1858), y el IVA por ítem: proporción
 * (1904-1906), tasa (1907/1908), base gravada (1909-1911), liquidación (1912/1913) y base exenta (1921, NT-013 §2.1;
 * todavía no figura en errores-validacion.md). Las fórmulas son las de la NT-013, que addItem() aplica y el SIFEN
 * aprobó en sifen-test; se comparan con la tolerancia de ConjuntoDeReglas::difiere() (0,8 para 1861, como dice el
 * MT). Los cálculos del IVA por ítem (1910, 1911, 1913, 1921) admiten 0,01 de diferencia: sifen-test aprobó el
 * 13/10/2026 una base gravada 0,01 mayor que la exacta con su liquidación coherente (homologación C14); una
 * diferencia mayor sigue sin verificar y se informa. 1862 (EA005) no se aplica: el XSD v150 no tiene porcentaje de
 * descuento global por ítem. dCilin (E786) se rechaza siempre: el SIFEN aplica el patrón "/d" del XSD de
 * producción tal como está publicado (0160 el 13/10/2026). Fase C, pasos C10b y C14.
 */
final class ReglasDeItems extends ConjuntoDeReglas
{
  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $tipo = $v->tipoDocumento();
    $opeCom = $v->gOpeCom();
    $moneda = strtoupper((string) self::texto($opeCom, 'cMoneOpe'));
    $condCambio = self::entero($opeCom, 'dCondTiCam');
    $tipoOperacionReceptor = self::entero($v->gDatRec(), 'iTiOpe');

    foreach ($v->items() as $i => $item) {
      $ruta = 'DE.gDtipDE.gCamItem[' . ($i + 1) . ']';
      $dncpGeneral = self::texto($item, 'dDncpG');
      self::regla($r, $tipoOperacionReceptor === 3 && $dncpGeneral === null, '1800', 'dDncpG', $ruta, null, 'La operación es B2G (D202 = 3).');
      self::regla($r, $dncpGeneral !== null && self::texto($item, 'dDncpE') === null, '1801', 'dDncpE', $ruta, null, 'Con el código DNCP general (E704) va el específico (E705).');
      $relevancia = self::entero($item, 'cRelMerc');
      self::regla($r, $relevancia !== null && $tipo !== null && $tipo !== 7, '1807', 'cRelMerc', $ruta, $relevancia, 'Solo la nota de remisión informa la relevancia de las mercaderías.');
      self::regla($r, $relevancia !== null && self::monto($item, 'dCanQuiMer') === null && self::monto($item, 'dPorQuiMer') === null, '1808', 'dCanQuiMer', $ruta, null, 'Informar la cantidad (E717) o el porcentaje (E718) de quiebra o merma.');
      // E786 dCilin: el XSD de producción declara el patrón "/d" (un error del XSD) y el SIFEN lo aplica tal cual, así que
      // cualquier valor responde 0160 "XML malformado [El valor N del elemento: dCilin es invalido]" (sifen-test, 13/10/2026).
      $cilindrada = self::texto(self::v($item, 'gVehNuevo'), 'dCilin');
      if ($cilindrada !== null)
        $r->agregar(new ErrorValidacion(OrigenError::Regla, 'XML malformado: el SIFEN rechaza dCilin con cualquier valor (el patrón del XSD de producción es "/d").', '0160', 'E786', 'dCilin',
          $ruta . '.gVehNuevo', $cilindrada, 'No informar dCilin: sifen-test lo rechazó con 0160 el 13/10/2026 (captura 05-rEnviDe-cilin del 2026-10-13); GVehNuevo::setDCilin() no tiene un valor que el SIFEN acepte.'));

      $cantidad = self::monto($item, 'dCantProSer');
      $total = null;
      $valor = self::v($item, 'gValorItem');
      if ($valor !== null) {
        $rutaValor = $ruta . '.gValorItem';
        $precio = self::monto($valor, 'dPUniProSer');
        $bruto = self::monto($valor, 'dTotBruOpeItem');
        $cambioItem = self::monto($valor, 'dTiCamIt');
        if ($precio !== null && $cantidad !== null && $bruto !== null) {
          $esperado = bcmul($precio, $cantidad, 10);
          self::regla($r, self::difiere($bruto, $esperado), '1859', 'dTotBruOpeItem', $rutaValor, $bruto, "E727 = E721 × E711 = $esperado.");
        }
        self::regla($r, $condCambio === 2 && $cambioItem === null, '1854', 'dTiCamIt', $rutaValor, null, 'La condición del tipo de cambio (D017) es por ítem.');
        self::regla($r, $condCambio === 1 && $cambioItem !== null, '1855', 'dTiCamIt', $rutaValor, $cambioItem, 'La condición del tipo de cambio (D017) es global.');
        self::regla($r, $moneda === 'PYG' && $cambioItem !== null, '1856', 'dTiCamIt', $rutaValor, $cambioItem);

        $resta = self::v($valor, 'gValorRestaItem');
        if ($resta !== null) {
          $rutaResta = $rutaValor . '.gValorRestaItem';
          $descuento = self::monto($resta, 'dDescItem');
          $porcentaje = self::monto($resta, 'dPorcDesIt');
          $total = self::monto($resta, 'dTotOpeItem');
          $totalGs = self::monto($resta, 'dTotOpeGs');
          self::regla($r, $descuento !== null && bccomp($descuento, '0', 8) > 0 && $porcentaje === null, '1852', 'dPorcDesIt', $rutaResta, null, 'Con descuento particular (EA002) va su porcentaje (EA003).');
          if ($descuento !== null && $porcentaje !== null && $precio !== null && bccomp($precio, '0', 8) > 0) {
            $esperado = bcdiv(bcmul($descuento, '100', 10), $precio, 10);
            self::regla($r, self::difiere($porcentaje, $esperado, '0.8'), '1861', 'dPorcDesIt', $rutaResta, $porcentaje, "EA003 = EA002 × 100 / E721 = $esperado (variación admitida: 0,8).");
          }
          if ($total !== null && $precio !== null && $cantidad !== null) {
            $unitario = $precio;
            foreach (['dDescItem', 'dDescGloItem', 'dAntPreUniIt', 'dAntGloPreUniIt'] as $campo)
              $unitario = bcsub($unitario, self::monto($resta, $campo) ?? '0', 10);
            $esperado = bcmul($unitario, $cantidad, 10);
            self::regla($r, self::difiere($total, $esperado), '1853', 'dTotOpeItem', $rutaResta, $total, "EA008 = (E721 − EA002 − EA004 − EA006 − EA007) × E711 = $esperado.");
          }
          self::regla($r, $cambioItem !== null && $totalGs === null, '1857', 'dTotOpeGs', $rutaResta, null, 'Con tipo de cambio por ítem (E725) va el total en guaraníes (EA009).');
          if ($cambioItem !== null && $totalGs !== null && $total !== null) {
            $esperado = bcmul($total, $cambioItem, 10);
            self::regla($r, self::difiere($totalGs, $esperado), '1858', 'dTotOpeGs', $rutaResta, $totalGs, "EA009 = EA008 × E725 = $esperado.");
          }
        }
      }

      $iva = self::v($item, 'gCamIVA');
      if ($iva === null)
        continue;
      $rutaIva = $ruta . '.gCamIVA';
      $afectacion = self::entero($iva, 'iAfecIVA');
      $proporcion = self::monto($iva, 'dPropIVA');
      $tasa = self::entero($iva, 'dTasaIVA');
      $base = self::monto($iva, 'dBasGravIVA');
      $liquidacion = self::monto($iva, 'dLiqIVAItem');
      $baseExenta = self::monto($iva, 'dBasExe');
      $sinIva = $afectacion === 2 || $afectacion === 3;
      $gravado = $afectacion === 1 || $afectacion === 4;
      self::regla($r, $afectacion === 1 && $proporcion !== null && bccomp($proporcion, '100', 8) !== 0, '1904', 'dPropIVA', $rutaIva, $proporcion, 'Gravado (E731 = 1) lleva proporción 100.');
      self::regla($r, $sinIva && $proporcion !== null && bccomp($proporcion, '0', 8) !== 0, '1905', 'dPropIVA', $rutaIva, $proporcion, 'Exonerado o exento (E731 = 2 o 3) lleva proporción 0.');
      self::regla($r, $afectacion === 4 && $proporcion !== null && (bccomp($proporcion, '0', 8) <= 0 || bccomp($proporcion, '100', 8) >= 0), '1906', 'dPropIVA', $rutaIva, $proporcion, 'Gravado parcial (E731 = 4) lleva una proporción mayor que 0 y menor que 100.');
      self::regla($r, $sinIva && $tasa !== null && $tasa !== 0, '1907', 'dTasaIVA', $rutaIva, $tasa, 'Exonerado o exento (E731 = 2 o 3) lleva tasa 0.');
      self::regla($r, $gravado && $tasa !== null && $tasa !== 5 && $tasa !== 10, '1908', 'dTasaIVA', $rutaIva, $tasa, 'Gravado o gravado parcial (E731 = 1 o 4) lleva tasa 5 o 10.');
      self::regla($r, $sinIva && $base !== null && bccomp($base, '0', 8) !== 0, '1909', 'dBasGravIVA', $rutaIva, $base, 'Exonerado o exento (E731 = 2 o 3) lleva base gravada 0.');
      self::regla($r, $sinIva && $liquidacion !== null && bccomp($liquidacion, '0', 8) !== 0, '1912', 'dLiqIVAItem', $rutaIva, $liquidacion, 'Exonerado o exento (E731 = 2 o 3) lleva liquidación 0.');

      $baseExentaEsperada = $sinIva || $afectacion === 1 ? '0' : null;
      if ($gravado && ($tasa === 5 || $tasa === 10) && $total !== null && $proporcion !== null) {
        // NT-013: E735 = 100 × EA008 × E733 / (10000 + E734 × E733); con E733 = 100 equivale a EA008 / 1,05 o EA008 / 1,1.
        $divisor = bcadd('10000', bcmul((string) $tasa, $proporcion, 10), 10);
        $baseEsperada = bcdiv(bcmul(bcmul('100', $total, 10), $proporcion, 10), $divisor, 10);
        if ($base !== null)
          self::regla($r, self::difiere($base, $baseEsperada, '0.01'), $tasa === 5 ? '1910' : '1911', 'dBasGravIVA', $rutaIva, $base, "E735 = 100 × EA008 × E733 / (10000 + E734 × E733) = $baseEsperada (NT-013; el SIFEN admite 0,01).");
        if ($afectacion === 4)
          $baseExentaEsperada = bcdiv(bcmul(bcmul('100', $total, 10), bcsub('100', $proporcion, 10), 10), $divisor, 10);
      }
      if ($gravado && $base !== null && $liquidacion !== null && $tasa !== null) {
        $esperado = bcdiv(bcmul($base, (string) $tasa, 10), '100', 10);
        self::regla($r, self::difiere($liquidacion, $esperado, '0.01'), '1913', 'dLiqIVAItem', $rutaIva, $liquidacion, "E736 = E735 × E734 / 100 = $esperado (el SIFEN admite 0,01).");
      }
      if ($baseExenta !== null && $baseExentaEsperada !== null)
        self::reglaConMensaje($r, self::difiere($baseExenta, $baseExentaEsperada, '0.01'), '1921', 'E737', 'Error en el cálculo de la base exenta por ítem', 'dBasExe', $rutaIva, $baseExenta,
          "NT-013 §2.1: E737 = 100 × EA008 × (100 − E733) / (10000 + E734 × E733) con E731 = 4, y 0 con E731 = 1, 2 o 3: $baseExentaEsperada.");
    }
  }
}
