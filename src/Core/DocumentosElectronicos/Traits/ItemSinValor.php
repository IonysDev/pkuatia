<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits;

use IonysDev\Pkuatia\Core\Constants\CamItemRelMerc;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamItem;
use IonysDev\Pkuatia\Core\Fields\DE\E\GRasMerc;
use DateTime;
use IonysDev\Pkuatia\Core\Fields\DE\E\GVehNuevo;

trait ItemSinValor {

    /**
     * E700 - Lista de ítems sin valor del documento electrónico.
     */
    public $items = [];

    /**
     * Agrega un ítem sin valor al documento electrónico. Este método es utilizado en la conformación notas de remisión.
     * 
     * @param String $codigo Código interno del ítem.
     * @param String $descripcion Descripción del ítem.
     * @param int $codUnidadMedida Código de unidad de medida del ítem.
     * @param String $cantidad Cantidad del ítem en la unidad de medida especificada, expresado en cadena de texto decimal BCMath.
     * @param String|null $nroLote Número de lote del ítem (opcional).
     * @param DateTime|null $fechaVencimiento Fecha de vencimiento del ítem (opcional).
     * @param String|null $nroSerie Número de serie del ítem (opcional).
     * @param String|null $nroPedido Número de pedido del ítem (opcional).
     * @param String|null $infoEmisor Información adicional del ítem de interés del emisor (opcional).
     * @param String|null $cdcFacturaAnticipo Código de la factura de anticipo, solo cuando la factura asociada sea de tipo de operación anticipo (opcional).
     * @param int|null $partidaArancelaria Código de la partida arancelaria aduanera del ítem (4 dígitos, opcional).
     * @param int|null $ncmMercosur Código del Nomenclador Común del Mercosur del ítem (6 a 8 dígitos, opcional).
     * @param String|null $codPaisOrigen Código ISO3166 del país de origen del ítem (opcional).
     * @param String|null $dncpCodigoGeneral Código general del ítem según el Catálogo de Bienes y Servicios de la DNCP (obligatorio solo cuando receptor es B2G).
     * @param String|null $dncpCodigoEspecifico Código específico del ítem según el Catálogo de Bienes y Servicios de la DNCP (obligatorio solo cuando receptor es B2G).
     * @param String|null $dncpCodigoGTINProducto Código GTIN (código comercial global) de producto registrado en DNCP (opcional cuando receptor es B2G).
     * @param String|null $dncpCodigoGTINPaquete Código GTIN del paquete registrado en DNCP (opcional cuando receptor es B2G).
     * @param CamItemRelMerc|null $tipoTolerancia código de datos de relevancia de las mercaderías (opcional solo cuando es nota de remisión, no informar para todo lo demás).
     * @param String|null $cantTolerancia Cantidad de tolerancia (solo si se informa $tipoTolerancia).
     * @param String|null $porcTolerancia Porcentaje de tolerancia (solo si se informa $tipoTolerancia).
     * 
     * @return self
     */
    public function addItem(
        String $codigo,
        String $descripcion,
        int $codUnidadMedida,
        String $cantidad,
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
        ?CamItemRelMerc $tipoTolerancia = null,
        ?String $cantTolerancia = null,
        ?String $porcTolerancia = null,
        ?GVehNuevo $detalleVehiculoNuevo = null,
    ) : self {
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
        $gCamItem->setDCantProSer($cantidad);
        if($codPaisOrigen)
            $gCamItem->setCPaisOrig($codPaisOrigen);
        if($infoEmisor)
            $gCamItem->setDInfItem($infoEmisor);
        if($tipoTolerancia){
            $gCamItem->setCRelMerc($tipoTolerancia->value);
            $gCamItem->setDCanQuiMer($cantTolerancia);
            $gCamItem->setDPorQuiMer($porcTolerancia);
        }
        if($cdcFacturaAnticipo)
            $gCamItem->setDCDCAnticipo($cdcFacturaAnticipo);
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

        ////////////////////////////////////////////////////////////////////////////
        // START - GVehNuevo
        if($detalleVehiculoNuevo){
            $gCamItem->setGVehNuevo($detalleVehiculoNuevo);
        }
        // END - GVehNuevo
        ////////////////////////////////////////////////////////////////////////////

        if(!isset($this->items))
            $this->items = [];
        $this->items[] = $gCamItem;
        return $this;
    }

}
