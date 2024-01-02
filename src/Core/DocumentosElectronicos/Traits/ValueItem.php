<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos\Traits;

use Abiliomp\Pkuatia\Core\Constants\CamIVAAfecIVA;
use Abiliomp\Pkuatia\Core\Constants\CamIVATasaIVA;
use Abiliomp\Pkuatia\Core\Constants\OpeComTipImp;
use Abiliomp\Pkuatia\Core\Constants\TimbTiDE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamItem;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamIVA;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GRasMerc;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GValorItem;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GValorRestaItem;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GVehNuevo;
use DateTime;

trait ValueItem {

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

        ?bool $esTipoCambioPorItem,
        ?String $tipoDeCambio,

        ?String $descuentoUnitarioParticular,
        ?String $descuentoUnitarioGlobal,
        ?String $anticipoUnitarioParticular,
        ?String $anticipoUnitarioGlobal,
        
        ?String $nroLote,
        ?DateTime $fechaVencimiento,
        ?String $nroSerie,
        ?String $nroPedido,

        ?String $infoEmisor,
        ?String $cdcFacturaAnticipo,
        ?int $partidaArancelaria,
        ?int $ncmMercosur,
        ?String $codPaisOrigen,
        ?String $dncpCodigoGeneral,
        ?String $dncpCodigoEspecifico,
        ?String $dncpCodigoGTINProducto,
        ?String $dncpCodigoGTINPaquete,
        ?GVehNuevo $detalleVehiculoNuevo,
    ) : self {

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
            if($afectacionIVA == CamIVAAfecIVA::Exento || $afectacionIVA == CamIVAAfecIVA::Exonerado) {
                $gCamIVA->setDBasGravIVA('0');
                $gCamIVA->setDLiqIVAItem('0');
            }
            else {
                $baseGravada = bcdiv(bcmul($totOpeItem, bcdiv($proporcionGravadaIVA, '100', 8), 8),bcadd('1', bcdiv(strval($tasaIVA->value), 100), 8), 8);
                $gCamIVA->setDBasGravIVA($baseGravada);
                $gCamIVA->setDLiqIVAItem(bcmul($baseGravada, bcdiv(strval($tasaIVA->value), 100, 8), 8));
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
        return $this;
    }

}

?>

