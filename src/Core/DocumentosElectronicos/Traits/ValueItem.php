<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos\Traits;

use Abiliomp\Pkuatia\Core\Constants\CamItemRelMerc;
use Abiliomp\Pkuatia\Core\Constants\CamIVAAfecIVA;
use Abiliomp\Pkuatia\Core\Constants\CamIVATasaIVA;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamItem;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GRasMerc;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GValorItem;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GValorRestaItem;
use DateTime;

trait ValueItem {

    /**
     * Agrega un ítem sin valor al documento electrónico. Este método es utilizado en la conformación notas de remisión.
     * 
     * @param String $codigo Código interno del ítem.
     * @param String $descripcion Descripción del ítem.
     * @param int $codUnidadMedida Código de unidad de medida del ítem.
     * @param String $cantidad Cantidad del ítem en la unidad de medida especificada, expresado en cadena de texto decimal BCMath.
     * @param String|null $infoEmisor Información adicional del ítem de interés del emisor (opcional).
     * @param String|null $cdcFacturaAnticipo Código de la factura de anticipo, solo cuando la factura asociada sea de tipo de operación anticipo (opcional).
     * @param int|null $partidaArancelaria Código de la partida arancelaria aduanera del ítem (4 dígitos, opcional).
     * @param int|null $ncmMercosur Código del Nomenclador Común del Mercosur del ítem (6 a 8 dígitos, opcional).
     * @param String|null $codPaisOrigen Código ISO3166 del país de origen del ítem (opcional).
     * @param String|null $dncpCodigoGeneral Código general del ítem según el Catálogo de Bienes y Servicios de la DNCP (obligatorio solo cuando receptor es B2G).
     * @param String|null $dncpCodigoEspecifico Código específico del ítem según el Catálogo de Bienes y Servicios de la DNCP (obligatorio solo cuando receptor es B2G).
     * @param String|null $dncpCodigoGTINProducto Código GTIN (código comercial global) de producto registrado en DNCP (opcional cuando receptor es B2G).
     * @param String|null $dncpCodigoGTINPaquete Código GTIN del paquete registrado en DNCP (opcional cuando receptor es B2G).
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
    ) : self {

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

        $gValorItem = new GValorItem();
        $gValorItem->setDPUniProSer($pu);
        if($esTipoCambioPorItem)
            $gValorItem->setDTiCamIt($tipoDeCambio);
        $gValorItem->setDTotBruOpeItem($totalB);

        $gValorRestaItem = new GValorRestaItem();
        if($descuentoUnitarioParticular)
            $gValorRestaItem->setDDescItem($descuentoUnitarioParticular);
        
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
        $this->items[] = $gCamItem;
        return $this;
    }

}

?>

