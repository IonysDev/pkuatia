<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos;

use IonysDev\Pkuatia\Core\Constants\MotEmiNR;
use IonysDev\Pkuatia\Core\Constants\RespEmiNR;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits\ItemSinValor;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamNRE;

/**
 * Tipo de Documento Electrónico Sifen: 7 - Nota de Remisión Electrónica
 */
class NotaDeRemision extends DocumentoElectronico
{
    use ItemSinValor;

    //////////////////////////////////////////
    // Atributos
    //////////////////////////////////////////

    public GCamNRE $gCamNRE; // E500 - E599 - Campos que componen la nota de remisión electrónica

    //////////////////////////////////////////
    // Constructor
    //////////////////////////////////////////

    public function __construct(int|MotEmiNR $motivoEmision, int|RespEmiNR $responsableEmision)
    {
        parent::__construct();
        $this->gTimb->setITiDE(TimbTiDE::NotaDeRemision);
        $this->gCamNRE = new GCamNRE();
        $this->gCamNRE->setIMotEmiNR($motivoEmision);
        $this->gCamNRE->setIResEmiNR($responsableEmision);
    }
    
}