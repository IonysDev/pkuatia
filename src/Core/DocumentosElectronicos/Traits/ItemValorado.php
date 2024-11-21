<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits;

use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\OpeComCondTipCam;
use IonysDev\Pkuatia\Core\Constants\OpeComTipImp;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\Fields\DE\C\GTimb;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamItem;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamIVA;
use IonysDev\Pkuatia\Core\Fields\DE\E\GRasMerc;
use IonysDev\Pkuatia\Core\Fields\DE\E\GValorItem;
use IonysDev\Pkuatia\Core\Fields\DE\E\GValorRestaItem;
use IonysDev\Pkuatia\Core\Fields\DE\E\GVehNuevo;
use IonysDev\Pkuatia\Core\Fields\DE\F\GTotSub;
use IonysDev\Pkuatia\Utils\NumberFunctions;
use DateTime;

trait ItemValorado {

    /**
     * E700 - Lista de ítems con valor del documento electrónico.
     */
    public $items = [];

    /**
     * F001 - Campos de subtotales y totales
     */
    public GTotSub $gTotSub;

    /**
     * Agrega un ítem sin valor al documento electrónico. Este método es utilizado en la conformación notas de remisión.
     * 
     * @param String $codigo Código interno del ítem.
     * @param String $descripcion Descripción del ítem.
     * @param int $codUnidadMedida Código de unidad de medida del ítem.
     * @param String|null $cantidad Cantidad del ítem en la unidad de medida especificada, expresado en cadena de texto decimal BCMath. Si no se especifica es obligatorio informar el precio unitario y el total bruto.
     * @param String|null $precioUnit Precio unitario del ítem, expresado en cadena de texto decimal BCMath. Si no se especifica es obligatorio informar la cantidad y el total bruto.
     * @param String|null $totalBruto Total bruto del ítem, expresado en cadena de texto decimal BCMath. Si no se especifica es obligatorio informar la cantidad y el precio unitario.
     * @param CamIVAAfecIVA|null $afectacionIVA Afectación de IVA del ítem. Si no se especifica se asume que el ítem no es afectado por el IVA.
     * @param String|null $proporcionGravadaIVA Proporción gravada de IVA del ítem, expresado en cadena de texto decimal BCMath. Si no se especifica se asume que el ítem no es afectado por el IVA.
     * @param CamIVATasaIVA|null $tasaIVA Tasa de IVA del ítem. Si no se especifica se asume que el ítem no es afectado por el IVA.
     * @param bool|null $esTipoCambioPorItem Indica si el tipo de cambio es por ítem. Si no se especifica se asume que el tipo de cambio es por documento.
     * @param String|null $tipoDeCambio Tipo de cambio del ítem, expresado en cadena de texto decimal BCMath. Si no se especifica se asume que el tipo de cambio es por documento.
     * @param String|null $descuentoUnitarioParticular Descuento unitario particular del ítem, expresado en cadena de texto decimal BCMath. Si no se especifica se asume que el ítem no tiene descuento particular.
     * @param String|null $descuentoUnitarioGlobal Descuento unitario global del ítem, expresado en cadena de texto decimal BCMath. Si no se especifica se asume que el ítem no tiene descuento global.
     * @param String|null $anticipoUnitarioParticular Anticipo unitario particular del ítem, expresado en cadena de texto decimal BCMath. Si no se especifica se asume que el ítem no tiene anticipo particular.
     * @param String|null $anticipoUnitarioGlobal Anticipo unitario global del ítem, expresado en cadena de texto decimal BCMath. Si no se especifica se asume que el ítem no tiene anticipo global.
     * @param String|null $nroLote Número de lote del ítem (opcional).
     * @param DateTime|null $fechaVencimiento Fecha de vencimiento del ítem (opcional).
     * @param String|null $nroSerie Número de serie del ítem (opcional).
     * @param String|null $nroPedido Número de pedido del ítem (opcional).
     * @param String|null $infoEmisor Información adicional del ítem de interés del emisor (opcional).
     * @param String|null $cdcFacturaAnticipo Código de la factura de anticipo. Es obligatorio cuando exista anticipo particular o global, o cuando el tipo de pago de la factura sea anticipo.
     * @param int|null $partidaArancelaria Código de la partida arancelaria aduanera del ítem (4 dígitos, opcional).
     * @param int|null $ncmMercosur Código del Nomenclador Común del Mercosur del ítem (6 a 8 dígitos, opcional).
     * @param String|null $codPaisOrigen Código ISO3166 del país de origen del ítem (opcional).
     * @param String|null $dncpCodigoGeneral Código general del ítem según el Catálogo de Bienes y Servicios de la DNCP (obligatorio solo cuando receptor es B2G).
     * @param String|null $dncpCodigoEspecifico Código específico del ítem según el Catálogo de Bienes y Servicios de la DNCP (obligatorio solo cuando receptor es B2G).
     * @param String|null $dncpCodigoGTINProducto Código GTIN (código comercial global) de producto registrado en DNCP (opcional cuando receptor es B2G).
     * @param String|null $dncpCodigoGTINPaquete Código GTIN del paquete registrado en DNCP (opcional cuando receptor es B2G).
     * @param GVehNuevo|null $detalleVehiculoNuevo Detalle del vehículo nuevo. Se informa solo en caso de venta de vehiculo automor nuevo.
     * 
     * @return self
     */
    public function addItem(
        String $codigo,
        String $descripcion,
        int $codUnidadMedida,
        ?String $cantidad,

        ?String $precioUnit,
        ?String $totalBruto,
        ?CamIVAAfecIVA $afectacionIVA,
        ?String $proporcionGravadaIVA,
        ?CamIVATasaIVA $tasaIVA,

        ?String $descuentoUnitarioParticular = null,
        ?String $descuentoUnitarioGlobal = null,
        ?String $anticipoUnitarioParticular = null,
        ?String $anticipoUnitarioGlobal = null,        

        ?bool $esTipoCambioPorItem = null,
        ?String $tipoDeCambio = null,
        
        ?String $nroLote = null,
        ?DateTime $fechaVencimiento = null,
        ?String $nroSerie = null,
        ?String $nroPedido = null,

        ?String $infoEmisor = null,
        ?String $cdcFacturaAnticipo = null,
        ?int $partidaArancelaria = null,
        ?int $ncmMercosur = null,
        ?String $codPaisOrigen = null,
        ?String $dncpCodigoGeneral = null,
        ?String $dncpCodigoEspecifico = null,
        ?String $dncpCodigoGTINProducto = null,
        ?String $dncpCodigoGTINPaquete = null,
        ?GVehNuevo $detalleVehiculoNuevo = null,
    ) : GCamItem {

        ////////////////////////////////////////////////////////////////////////////
        // START - GValorItem
        // Calculo de cantidad, precio unitario y total del item según caso
        $cant = '0';
        $pu = '0';
        $totalB = '0';
        // 1. Si se informa cantidad, precio unitario, se calcula el total bruto.
        if($cantidad && $precioUnit){
            $cant = $cantidad;
            $pu = $precioUnit;
            $totalB = bcmul($cantidad, $precioUnit, 8);
        }
        // 2. Si se informa cantidad y total bruto, se calcula el precio unitario.
        else if($cantidad && $totalBruto){
            $cant = $cantidad;
            $totalB = $totalBruto;
            $pu = bcdiv($totalBruto, $cantidad, 8);
        }
        // 3. Si se informa precio unitario y total bruto, se calcula la cantidad.
        else if($precioUnit && $totalBruto){
            $pu = $precioUnit;
            $totalB = $totalBruto;
            $cant = bcdiv($totalBruto, $precioUnit, 4);
        }
        $gValorItem = new GValorItem();
        $gValorItem->setDPUniProSer($pu);
        if($esTipoCambioPorItem)
            $gValorItem->setDTiCamIt($tipoDeCambio);
        $gValorItem->setDTotBruOpeItem($totalB);
        // END - GValorItem
        ////////////////////////////////////////////////////////////////////////////        

        ////////////////////////////////////////////////////////////////////////////
        // START - GCamItem
        $gCamItem = new GCamItem();
        $gCamItem->setDCodInt($codigo);
        if($partidaArancelaria)
            $gCamItem->setDParAranc($partidaArancelaria);
        if($ncmMercosur)
            $gCamItem->setDNCM($ncmMercosur);
        if($dncpCodigoGeneral)
            $gCamItem->setDDncpG($dncpCodigoGeneral);
        if($dncpCodigoEspecifico)
            $gCamItem->setDDncpE($dncpCodigoEspecifico);
        if($dncpCodigoGTINProducto)
            $gCamItem->setDGtin($dncpCodigoGTINProducto);
        if($dncpCodigoGTINPaquete)
            $gCamItem->setDGtinPq($dncpCodigoGTINPaquete);
        $gCamItem->setDDesProSer($descripcion);
        $gCamItem->setCUniMed($codUnidadMedida);
        $gCamItem->setDCantProSer($cant);
        if($codPaisOrigen)
            $gCamItem->setCPaisOrig($codPaisOrigen);
        if($infoEmisor)
            $gCamItem->setDInfItem($infoEmisor);
        if($cdcFacturaAnticipo)
            $gCamItem->setDCDCAnticipo($cdcFacturaAnticipo);
        // END - GCamItem
        ////////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////////////////////
        // START - GValorRestaItem
        $totOpeItem = '0';
        $gValorRestaItem = new GValorRestaItem();
        if($this->gOpeCom->getITImp() != OpeComTipImp::ISC->value && $this->gTimb->getITiDE() != TimbTiDE::Autofactura->value) {
            $puFinal = $pu;
            if($descuentoUnitarioParticular) {
                $gValorRestaItem->setDDescItem($descuentoUnitarioParticular);
                $gValorRestaItem->setDPorcDesIt(bcdiv(bcmul($descuentoUnitarioParticular, '100', 8), $pu, 8));
                $puFinal = bcsub($puFinal, $descuentoUnitarioParticular, 8);
            }
            if($descuentoUnitarioGlobal) {
                $gValorRestaItem->setDDescGloItem($descuentoUnitarioGlobal);
                $puFinal = bcsub($puFinal, $descuentoUnitarioGlobal, 8);
            }
            if($anticipoUnitarioParticular) {
                $gValorRestaItem->setDAntPreUniIt($anticipoUnitarioParticular);
                $puFinal = bcsub($puFinal, $anticipoUnitarioParticular, 8);
            }
            if($anticipoUnitarioGlobal) {
                $gValorRestaItem->setDAntGloPreUniIt($anticipoUnitarioGlobal);
                $puFinal = bcsub($puFinal, $anticipoUnitarioGlobal, 8);
            }
            $totOpeItem = bcmul($puFinal, $cant, 8);
        }
        else if($this->gTimb->getITiDE() == TimbTiDE::Autofactura->value) {
            $totOpeItem = bcmul($pu, $cant, 8);
        }
        $gValorRestaItem->setDTotOpeItem($totOpeItem);
        if($esTipoCambioPorItem)
            $gValorRestaItem->setDTotOpeGs(bcmul($totOpeItem, $tipoDeCambio));
        $gValorItem->setGValorRestaItem($gValorRestaItem);
        $gCamItem->setGValorItem($gValorItem);
        // END - GValorRestaItem
        ////////////////////////////////////////////////////////////////////////////
        
        ////////////////////////////////////////////////////////////////////////////
        // START - GCamIVA
        if($this->gOpeCom->getITImp() != OpeComTipImp::ISC->value && $this->gTimb->getITiDE() != TimbTiDE::Autofactura->value && $this->gTimb->getITiDE() != TimbTiDE::NotaRemision->value) {
            $gCamIVA = new GCamIVA();
            $gCamIVA->setIAfecIVA($afectacionIVA);
            $gCamIVA->setDPropIVA($proporcionGravadaIVA);
            $gCamIVA->setDTasaIVA($tasaIVA);
            // E735 y E736
            if($afectacionIVA == CamIVAAfecIVA::Exento || $afectacionIVA == CamIVAAfecIVA::Exonerado) {
                $gCamIVA->setDBasGravIVA('0');
                $gCamIVA->setDLiqIVAItem('0');
            }
            else {
                $baseGravada = bcdiv(bcmul($totOpeItem, bcdiv($proporcionGravadaIVA, '100', 10), 10), bcadd('1', bcdiv(strval($tasaIVA->value), 100, 10), 10), 10);                
                $gCamIVA->setDBasGravIVA(NumberFunctions::bcround($baseGravada, 8));
                $gCamIVA->setDLiqIVAItem(NumberFunctions::bcround(bcmul($baseGravada, bcdiv(strval($tasaIVA->value), 100, 10), 10), 8));
            }
            // E737 (ver NT13)
            if($afectacionIVA == CamIVAAfecIVA::GravadoParcial) {
                $dBasExe = bcmul(bcmul(100, $totOpeItem, 10), bcsub(100, $proporcionGravadaIVA, 10), 10);
                $dBasExe = bcdiv($dBasExe, bcadd(10000, bcmul($tasaIVA->value, $proporcionGravadaIVA, 10), 10), 10);
                $gCamIVA->setDBasExe(NumberFunctions::bcround($dBasExe, 8));
            }
            else {
                $gCamIVA->setDBasExe('0');
            }
            $gCamItem->setGCamIVA($gCamIVA);
        }
        // END - GCamIVA
        ////////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////////////////////
        // START - GRasMerc
        if($nroLote || $fechaVencimiento || $nroSerie || $nroPedido){
            $gRasMerc = new GRasMerc();
            if($nroLote)
                $gRasMerc->setDNumLote($nroLote);
            if($fechaVencimiento)
                $gRasMerc->setDVencMerc($fechaVencimiento);
            if($nroSerie)
                $gRasMerc->setDNSerie($nroSerie);
            if($nroPedido)
                $gRasMerc->setDNumPedi($nroPedido);
            $gCamItem->setGRasMerc($gRasMerc);
        }
        // END - GRasMerc
        ////////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////////////////////
        // START - GVehNuevo
        if($detalleVehiculoNuevo){
            $gCamItem->setGVehNuevo($detalleVehiculoNuevo);
        }
        // END - GVehNuevo

        $this->items[] = $gCamItem;
        return $this->items[count($this->items) - 1];
    }

    /**
     * Calcula los subtotales y totales del documento electrónico.
     * 
     * @param bool $redondeoSedeco Indica si se debe redondear el total de operación según las reglas de redondeo de la SEDECO (opcional, por defecto FALSO).
     * @param String $comision Comisión (IVA 10% incluido) de la operación comercial, expresado en cadena de texto decimal BCMath (opcional, por defecto NULL).
     * 
     * @return void
     */
    public function calcTotSub(bool $redondeoSedeco = false, String $comision = null) : GTotSub {
        if(!isset($this->gTimb) || $this->gTimb->getITiDE() == TimbTiDE::NotaRemision->value)
        {
            $this->gTotSub = null;   
        }
        else{
            $this->gTotSub = new GTotSub();

            foreach($this->items as $item)
            {
                // F009
                $this->gTotSub->setDTotDesc(bcadd($this->gTotSub->getDTotDesc(), $item->getGValorItem()->getGValorRestaItem()->getDDescItem(), 8));
                // F033
                $this->gTotSub->setDTotDescGlotem(bcadd($this->gTotSub->getDTotDescGlotem(), $item->getGValorItem()->getGValorRestaItem()->getDDescGloItem(), 8));
                // F034
                $this->gTotSub->setDTotAntItem(bcadd($this->gTotSub->getDTotAntItem(), $item->getGValorItem()->getGValorRestaItem()->getDAntPreUniIt(), 8));
                // F035
                $this->gTotSub->setDTotAnt(bcadd($this->gTotSub->getDTotAnt(), $item->getGValorItem()->getGValorRestaItem()->getDAntGloPreUniIt(), 8));
            }
            // F010
            $this->gTotSub->setDDescTotal(bcadd($this->gTotSub->getDTotDesc(), $this->gTotSub->getDTotDescGlotem(), 8));
            
            // F012
            $this->gTotSub->setDAnticipo(bcadd($this->gTotSub->getDTotAntItem(), $this->gTotSub->getDTotAnt(), 8));

            if($this->gTimb->getITiDE() == TimbTiDE::Autofactura->value) {
                // F008
                $this->gTotSub->setDTotOpe(bcadd($this->gTotSub->getDTotOpe(), $item->getGValorItem()->getGValorRestaItem()->getDTotOpeItem(), 8));
            }
            else
            {
                $this->gTotSub->setDSubExe('0');
                $this->gTotSub->setDSubExo('0');
                foreach($this->items as $item)
                {
                    // F002
                    if($item->getGCamIVA()->getIAfecIVA() == CamIVAAfecIVA::Exento->value)
                        $this->gTotSub->setDSubExe(bcadd($this->gTotSub->getDSubExe(), $item->getGValorItem()->getGValorRestaItem()->getDTotOpeItem(), 8));
                    // F003
                    if($item->getGCamIVA()->getIAfecIVA() == CamIVAAfecIVA::Exonerado->value)
                        $this->gTotSub->setDSubExo(bcadd($this->gTotSub->getDSubExe(), $item->getGValorItem()->getGValorRestaItem()->getDTotOpeItem(), 8));
                }

                if($this->gOpeCom->getITImp() == OpeComTipImp::IVA->value || $this->gOpeCom->getITImp() == OpeComTipImp::IVARenta->value) {
                    $this->gTotSub->setDSub5('0');
                    $this->gTotSub->setDSub10('0');
                    $this->gTotSub->setDIVA5('0');
                    $this->gTotSub->setDIVA10('0');
                    $this->gTotSub->setDBaseGrav5('0');
                    $this->gTotSub->setDBaseGrav10('0');
                    foreach($this->items as $item)
                    {
                        if($item->getGCamIVA()->getIAfecIVA() == CamIVAAfecIVA::Gravado->value || $item->getGCamIVA()->getIAfecIVA() == CamIVAAfecIVA::GravadoParcial->value)
                        {
                            
                            if($item->getGCamIVA()->getDTasaIVA() == 5) {
                                // F004
                                $this->gTotSub->setDSub5(bcadd($this->gTotSub->getDSub5(), $item->getGValorItem()->getGValorRestaItem()->getDTotOpeItem(), 8));
                                // F015
                                $this->gTotSub->setDIVA5(bcadd($this->gTotSub->getDIVA5(), $item->getGCamIVA()->getDLiqIVAItem(), 8));
                                // F018
                                $this->gTotSub->setDBaseGrav5(bcadd($this->gTotSub->getDBaseGrav5(), $item->getGCamIVA()->getDBasGravIVA(), 8));
                            }
                            if($item->getGCamIVA()->getDTasaIVA() == 10) {
                                // F005
                                $this->gTotSub->setDSub10(bcadd($this->gTotSub->getDSub10(), $item->getGValorItem()->getGValorRestaItem()->getDTotOpeItem(), 8));
                                // F016
                                $this->gTotSub->setDIVA10(bcadd($this->gTotSub->getDIVA10(), $item->getGCamIVA()->getDLiqIVAItem(), 8));
                                // F019
                                $this->gTotSub->setDBaseGrav10(bcadd($this->gTotSub->getDBaseGrav10(), $item->getGCamIVA()->getDBasGravIVA(), 8));
                            }
                            // F002
                            $this->gTotSub->setDSubExe(bcadd($this->gTotSub->getDSubExe(), $item->getGCamIVA()->getDBasExe(), 8));
                        }
                    }

                    // F020
                    $this->gTotSub->setDTBasGraIVA(bcadd($this->gTotSub->getDBaseGrav5(), $this->gTotSub->getDBaseGrav10(), 8));

                    // F008
                    $this->gTotSub->setDTotOpe(
                        bcadd(
                            bcadd($this->gTotSub->getDSubExe(), $this->gTotSub->getDSubExo(), 8),
                            bcadd($this->gTotSub->getDSub5() ?? '0', $this->gTotSub->getDSub10() ?? '0', 8),
                            8
                        )
                    );

                    if($this->gTotSub->getDRedon() && bccomp($this->gTotSub->getDRedon(), '0', 8) != 0) {
                        // Para el IVA sobre el redondeo se hará un reparto proporcional del valor del redondeo
                        $base = bcsub($this->gTotSub->getDTotOpe(), bcadd($this->gTotSub->getDIVA5() ?? '0', $this->gTotSub->getDIVA10() ?? '0', 8), 8);
                        $prop5 = bcdiv($this->gTotSub->getDBaseGrav5(), $base, 10);
                        $prop10 = bcdiv($this->gTotSub->getDBaseGrav10(), $base, 10);
                        // F036
                        $this->gTotSub->setDLiqTotIVA5(bcdiv(bcmul($this->gTotSub->getDRedon(), $prop5, 10), '21', 8));
                        // F037
                        $this->gTotSub->setDLiqTotIVA10(bcdiv(bcmul($this->gTotSub->getDRedon(), $prop10, 10), '11', 8));
                    }

                    // F025
                    if($comision) {
                        $this->gTotSub->setDComi($comision);
                        // El iva de comisiones es 10%
                        $this->gTotSub->setDIVAComi(NumberFunctions::bcround(bcdiv($comision, '11', 10), 8));
                    }

                    // F017
                    $this->gTotSub->setDTotIVA(
                        bcadd(
                            bcsub(
                                bcadd($this->gTotSub->getDIVA5() ?? '0', $this->gTotSub->getDIVA10() ?? '0', 8),
                                bcadd($this->gTotSub->getDLiqTotIVA5() ?? '0', $this->gTotSub->getDLiqTotIVA10() ?? '0', 8),
                                8
                            ),
                            $this->gTotSub->getDIVAComi() ?? '0',
                            8
                        )
                    );
                }
            }
            
            // F011
            $this->gTotSub->setDPorcDescTotal(bcdiv(bcmul($this->gTotSub->getDDescTotal(), '100', 8), $this->gTotSub->getDTotOpe(), 8));

            // F013
            if($redondeoSedeco) {
                if(strcmp(strtoupper($this->gOpeCom->getCMoneOpe()), 'PYG') == 0) {
                    $this->gTotSub->setDRedon(bcmod($this->gTotSub->getDTotOpe(), '50', 4));
                }
                else {
                    $divVal = bcdiv($this->gTotSub->getDTotOpe(), '0.5', 1);
                    $roundedVal = bcmul($divVal, '0.5', 1);
                    $this->gTotSub->setDRedon(bcsub($this->gTotSub->getDTotOpe(), $roundedVal, 4));
                }
            }
            else{
                $this->gTotSub->setDRedon('0');
            }

            // F14
            $this->gTotSub->setDTotGralOpe(bcadd(bcsub($this->gTotSub->getDTotOpe(), $this->gTotSub->getDRedon(), 8), $this->gTotSub->getDComi() ?? '0', 8));
            

            // F23
            if(strcmp(strtoupper($this->gOpeCom->getCMoneOpe()), 'PYG') != 0) {
                if($this->gOpeCom->getDCondTiCam() == OpeComCondTipCam::Global)
                    $this->gTotSub->setDTotalGs(bcmul($this->gTotSub->getDTotGralOpe(), $this->gOpeCom->getDTiCam(), 8));
                else {
                    $this->gTotSub->setDTotalGs('0');
                    foreach($this->items as $item)
                    {
                        $this->gTotSub->setDTotalGs(bcadd($this->gTotSub->getDTotalGs(), $item->getGValorItem()->getGValorRestaItem()->getDTotOpeGs(), 8));
                    }
                }
            }
        }
        return $this->gTotSub;
    }

    

}

?>

