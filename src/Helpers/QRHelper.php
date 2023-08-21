<?php

namespace Abiliomp\Pkuatia\Helpers;

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\DE\I\Signature;

class QRHelper
{
    private function __construct(){}

    /**
     * Genera el contenido del QR para la consulta de un documento electrónico.
     * 
     * @param Config $config Configuración del entorno del Pkuatia
     * @param DE $de Documento electrónico
     * @param Signature $signature Firma del documento electrónico
     * 
     * @return String
     */
    public static function GenerateQRContent(Config $config, DE $de, Signature $signature)
    {
        $nVersion = Constants::SIFEN_VERSION;
        $id       = $de->getId();
        $dFeEmiDE = bin2hex($de->getGDatGralOpe()->getDFeEmiDE()->format("Y-m-d\TH:i:s"));
        
        $dRucRec  = '0';
        if($de->getGDatGralOpe()->getGDatRec()->getDRucRec() !== null)
            $dRucRec = $de->getGDatGralOpe()->getGDatRec()->getDRucRec();
        else if($de->getGDatGralOpe()->getGDatRec()->getDNumIDRec() !== null)
            $dRucRec = $de->getGDatGralOpe()->getGDatRec()->getDNumIDRec();

        $dTotGralOpe = '0';
        if($de->getGTotSub() != null)
            $dTotGralOpe = $de->getGTotSub()->getDTotGralOpe();
        
        $dTotIVA = '0';
        if($de->getGTotSub() != null)
            $dTotIVA = $de->getGTotSub()->getDTotIVA();

        $cItems = '0';
        if($de->getGDtipDe() != null)
            $cItems = $de->getGDtipDe()->getGCamItem() != null ? count($de->getGDtipDe()->getGCamItem()) : 0;
        
        $DigestValue = bin2hex($signature->getSignedInfo()->getReference()->getDigestValue());

        $IdCSC = $config->getIdCsc();

        $step1 = 'nVersion=' . $nVersion . '&' . 'Id=' . $id . '&' . 'dFeEmiDE=' . $dFeEmiDE . '&' . 'dRucRec=' . $dRucRec . '&' . 'dTotGralOpe=' . $dTotGralOpe . '&' . 'dTotIVA=' . $dTotIVA . '&' . 'cItems=' . $cItems . '&' . 'DigestValue=' . $DigestValue;

        $step2 = $step1 . $config->getCsc();

        $hash = hash('sha256', $step2);

        $qrUrl = '';
        if(strcmp(strtolower($config->getEnv()), 'prod') == 0)
            $qrUrl = Constants::SIFEN_URL_CONSULTA_QR_PROD;
        else
            $qrUrl = Constants::SIFEN_URL_CONSULTA_QR_DEV;
        $qrUrl = $qrUrl . $step1 . '&cHashQR=' . $hash;

        return $qrUrl;
    }
}

?>