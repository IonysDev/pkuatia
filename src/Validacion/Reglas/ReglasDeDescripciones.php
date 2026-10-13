<?php

namespace IonysDev\Pkuatia\Validacion\Reglas;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamItemRelMerc;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\GTranspModTrans;
use IonysDev\Pkuatia\Core\Constants\GTranspTipTrans;
use IonysDev\Pkuatia\Core\Constants\MotEmi;
use IonysDev\Pkuatia\Core\Constants\MotEmiNR;
use IonysDev\Pkuatia\Core\Constants\OpeComCondAnt;
use IonysDev\Pkuatia\Core\Constants\OpeComTipImp;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\OpeDETipEmi;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\Constants\PagCredCondCred;
use IonysDev\Pkuatia\Core\Constants\PagTarCDDenTarj;
use IonysDev\Pkuatia\Core\Constants\RespEmiNR;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\Constants\TipDocAso;
use IonysDev\Pkuatia\Core\Constants\TipIDRec;
use IonysDev\Pkuatia\Core\Constants\TipoDocImpresoAso;
use IonysDev\Pkuatia\DataMappings\CountryMapping;
use IonysDev\Pkuatia\DataMappings\DepartamentoMapping;
use IonysDev\Pkuatia\DataMappings\MonedaMapping;
use IonysDev\Pkuatia\DataMappings\PyGeoCodesMapping;
use IonysDev\Pkuatia\DataMappings\UnidadMedidaMapping;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;
use IonysDev\Pkuatia\Validacion\ErrorValidacion;
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ResultadoValidacion;
use IonysDev\Pkuatia\Validacion\VistaDocumento;

/**
 * "Descripción no corresponde al código" (errores-validacion.md, MT §12.4): cada par código/descripción se compara
 * con la descripción de la tabla o del catálogo que la librería ya usa para emitir. Las propiedades son públicas y se
 * pueden pisar después del setter, por eso se revisan. Los códigos de texto libre (9 "Otro", 99 "Otros") no se
 * comparan. Las descripciones que el modelo deriva al serializar (salida, entrega, transportista, país de destino)
 * no se revisan porque no se pueden pisar. Fase C, paso C10.
 */
final class ReglasDeDescripciones extends ConjuntoDeReglas
{
  private const TIPO_CONSTANCIA = [1 => 'Constancia de no ser contribuyente', 2 => 'Constancia de microproductores'];

  public static function aplicar(VistaDocumento $v, ResultadoValidacion $r, DateTime $ahora): void
  {
    $enum = static fn (string $clase): callable => static fn ($c) => $clase::getDescriptionFromValue(is_numeric($c) ? (int) $c : $c);
    $departamento = [DepartamentoMapping::class, 'getDepName'];
    $distrito = [PyGeoCodesMapping::class, 'getDistName'];
    $ciudad = [PyGeoCodesMapping::class, 'getCiudName'];
    $pais = [CountryMapping::class, 'getCountryDesc'];

    self::par($r, $v->gOpeDE(), 'iTipEmi', 'dDesTipEmi', $enum(OpeDETipEmi::class), '1051', 'DE.gOpeDE');
    self::par($r, $v->gTimb(), 'iTiDE', 'dDesTiDE', $enum(TimbTiDE::class), '1100', 'DE.gTimb');

    $ope = $v->gOpeCom();
    $rutaOpe = 'DE.gDatGralOpe.gOpeCom';
    self::par($r, $ope, 'iTipTra', 'dDesTipTra', $enum(OpeComTipTrans::class), '1203', $rutaOpe);
    self::par($r, $ope, 'iTImp', 'dDesTImp', $enum(OpeComTipImp::class), '1205', $rutaOpe);
    self::moneda($r, $ope, 'cMoneOpe', 'dDesMoneOpe', '1206', $rutaOpe);
    self::par($r, $ope, 'iCondAnt', 'dDesCondAnt', $enum(OpeComCondAnt::class), '1211', $rutaOpe);

    $emis = $v->gEmis();
    $rutaEmis = 'DE.gDatGralOpe.gEmis';
    self::par($r, $emis, 'cDepEmi', 'dDesDepEmi', $departamento, '1254', $rutaEmis);
    self::par($r, $emis, 'cDisEmi', 'dDesDisEmi', $distrito, '1257', $rutaEmis);
    self::par($r, $emis, 'cCiuEmi', 'dDesCiuEmi', $ciudad, '1260', $rutaEmis);

    $rec = $v->gDatRec();
    $rutaRec = 'DE.gDatGralOpe.gDatRec';
    self::par($r, $rec, 'cPaisRec', 'dDesPaisRe', $pais, '1301', $rutaRec);
    self::par($r, $rec, 'iTipIDRec', 'dDTipIDRec', $enum(TipIDRec::class), '1313', $rutaRec, [9]);
    self::par($r, $rec, 'cDepRec', 'dDesDepRec', $departamento, '1325', $rutaRec);
    self::par($r, $rec, 'cDisRec', 'dDesDisRec', $distrito, '1326', $rutaRec);
    self::par($r, $rec, 'cCiuRec', 'dDesCiuRec', $ciudad, '1329', $rutaRec);

    self::par($r, $v->gCamFE(), 'iIndPres', 'dDesIndPres', $enum(CamFEIndPres::class), '1352', 'DE.gDtipDE.gCamFE', [9]);
    self::par($r, $v->gCamNCDE(), 'iMotEmi', 'dDesMotEmi', $enum(MotEmi::class), '1452', 'DE.gDtipDE.gCamNCDE');

    $cond = $v->gCamCond();
    self::par($r, $cond, 'iCondOpe', 'dDCondOpe', $enum(CamCondOpe::class), '1502', 'DE.gDtipDE.gCamCond');
    foreach (self::lista($cond, 'gPaConEIni') as $i => $pago) {
      $ruta = 'DE.gDtipDE.gCamCond.gPaConEIni[' . ($i + 1) . ']';
      self::par($r, $pago, 'iTiPago', 'dDesTiPag', $enum(PaConEIniTiPago::class), '1554', $ruta, [99]);
      self::moneda($r, $pago, 'cMoneTiPag', 'dDMoneTiPag', '1555', $ruta);
      self::par($r, self::v($pago, 'gPagTarCD'), 'iDenTarj', 'dDesDenTarj', $enum(PagTarCDDenTarj::class), '1602', $ruta . '.gPagTarCD', [99]);
    }
    self::par($r, self::v($cond, 'gPagCred'), 'iCondCred', 'dDCondCred', $enum(PagCredCondCred::class), '1702', 'DE.gDtipDE.gCamCond.gPagCred');

    foreach ($v->items() as $i => $item) {
      $ruta = 'DE.gDtipDE.gCamItem[' . ($i + 1) . ']';
      self::par($r, $item, 'cUniMed', 'dDesUniMed', static fn ($c) => UnidadMedidaMapping::GetDesc((string) $c), '1802', $ruta);
      self::par($r, $item, 'cPaisOrig', 'dDesPaisOrig', $pais, '1804', $ruta);
      self::par($r, $item, 'cRelMerc', 'dDesRelMerc', $enum(CamItemRelMerc::class), '1806', $ruta);
      self::par($r, self::v($item, 'gCamIVA'), 'iAfecIVA', 'dDesAfecIVA', $enum(CamIVAAfecIVA::class), '1903', $ruta . '.gCamIVA');
    }

    $transp = $v->gTransp();
    self::par($r, $transp, 'iTipTrans', 'dDesTipTrans', $enum(GTranspTipTrans::class), '2103', 'DE.gDtipDE.gTransp');
    self::par($r, $transp, 'iModTrans', 'dDesModTrans', $enum(GTranspModTrans::class), '2104', 'DE.gDtipDE.gTransp');

    foreach ($v->gCamDEAsoc() as $i => $asoc) {
      $ruta = 'DE.gCamDEAsoc[' . ($i + 1) . ']';
      self::par($r, $asoc, 'iTipDocAso', 'dDesTipDocAso', $enum(TipDocAso::class), '2401', $ruta);
      self::par($r, $asoc, 'iTipoDocAso', 'dDTipoDocAso', $enum(TipoDocImpresoAso::class), '2410', $ruta);
      self::par($r, $asoc, 'iTipCons', 'dDesTipCons', static fn ($c) => self::TIPO_CONSTANCIA[(int) $c] ?? null, '2429', $ruta);
    }

    $ae = $v->gCamAE();
    $rutaAE = 'DE.gDtipDE.gCamAE';
    self::par($r, $ae, 'cDepVen', 'dDesDepVen', $departamento, '2552', $rutaAE);
    self::par($r, $ae, 'cDisVen', 'dDesDisVen', $distrito, '2561', $rutaAE);
    self::par($r, $ae, 'cCiuVen', 'dDesCiuVen', $ciudad, '2555', $rutaAE);
    self::par($r, $ae, 'cDepProv', 'dDesDepProv', $departamento, '2556', $rutaAE);
    self::par($r, $ae, 'cDisProv', 'dDesDisProv', $distrito, '2558', $rutaAE);
    self::par($r, $ae, 'cCiuProv', 'dDesCiuProv', $ciudad, '2559', $rutaAE);

    $nre = $v->gCamNRE();
    self::par($r, $nre, 'iMotEmiNR', 'dDesMotEmiNR', $enum(MotEmiNR::class), '2602', 'DE.gDtipDE.gCamNRE', [99]);
    self::par($r, $nre, 'iRespEmiNR', 'dDesRespEmiNR', $enum(RespEmiNR::class), '2603', 'DE.gDtipDE.gCamNRE');
  }

  /**
   * Compara la descripción informada con la que corresponde al código. Si falta alguno de los dos no hace nada (la
   * completitud lo cubre); si el código no existe en el catálogo tampoco (lo rechaza el XSD).
   *
   * @param list<int> $libres códigos cuya descripción es texto libre
   */
  private static function par(ResultadoValidacion $r, ?object $g, string $codigoProp, string $descProp, callable $resolver, string $codigo, string $ruta, array $libres = []): void
  {
    if ($g === null)
      return;
    $c = self::v($g, $codigoProp);
    $d = self::texto($g, $descProp);
    if ($c === null || $c === '' || $d === null)
      return;
    if (in_array(is_numeric($c) ? (int) $c : $c, $libres, true))
      return;
    try {
      $esperada = $resolver($c);
    } catch (\Throwable) {
      $esperada = null;
    }
    if ($esperada === null || trim((string) $esperada) === '')
      return;
    $esperada = trim((string) $esperada);
    self::regla($r, $esperada !== $d, $codigo, $descProp, $ruta, $d, "Para el código $c la descripción es '$esperada'.");
  }

  /**
   * Monedas: la descripción debe ser el CodeName de Monedas_v150.xsd recortado a 20 caracteres (tdDMoneTiPag).
   * Las 15 monedas con nombre más largo se avisan como advertencia (D-A3): el SIFEN rechazó el recorte con 1206 y
   * no hay descripción conocida que acepte.
   */
  private static function moneda(ResultadoValidacion $r, ?object $g, string $codigoProp, string $descProp, string $codigo, string $ruta): void
  {
    self::par($r, $g, $codigoProp, $descProp, [MonedaMapping::class, 'GetDescription'], $codigo, $ruta);
    $c = self::texto($g, $codigoProp);
    if ($c === null)
      return;
    $nombre = MonedaMapping::GetCodeName($c);
    if ($nombre === null || mb_strlen($nombre) <= MonedaMapping::MAX_LONGITUD_DESCRIPCION)
      return;
    $info = CatalogoValidaciones::describir($codigo);
    $r->agregar(new ErrorValidacion(OrigenError::Regla,
      ($info?->mensaje ?? "Validación $codigo") . " (D-A3): el nombre de la moneda $c en Monedas_v150.xsd ('$nombre') supera los 20 caracteres que admite el XSD; el SIFEN rechazó la descripción recortada y no hay una descripción conocida que acepte.",
      $codigo, $info?->id !== null ? preg_replace('/[a-z]$/', '', $info->id) : null, $descProp, $ruta, $c, 'Usar otra moneda hasta que la DNIT aclare qué descripción acepta (README, nota 6).', null, true));
  }
}
