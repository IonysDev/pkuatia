<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits;

use DateTime;
use IonysDev\Pkuatia\Core\Constants\GTranspModTrans;
use IonysDev\Pkuatia\Core\Constants\GTranspRespFlete;
use IonysDev\Pkuatia\Core\Constants\GTranspTipTrans;
use IonysDev\Pkuatia\Core\Constants\Incoterm;
use IonysDev\Pkuatia\Core\Fields\DE\E\GTransp;

trait CamposDeTransporte {
    
    /**
     * Establece los campos que describen el transporte de mercaderías
     * 
     * @param int|null $iTipTrans Tipo de transporte (E901)
     * @param int $iModTrans Modalidad de transporte (E903)
     * @param int $iRespFlete Responsable del costo del flete (E905)
     * @param string|null $cCondNeg Condición de la negociación (E906)
     * @param string|null $dNuManif Número de manifiesto (E907)
     * @param string|null $dNuDespImp Número de despacho de importación (E908)
     * @param DateTime|null $dIniTras Fecha estimada de inicio de traslado (E909)
     * @param DateTime|null $dFinTras Fecha estimada de fin de traslado (E910)
     * @param string|null $cPaisDest Código del país de destino (E911)
     * @return self
     */
    public function setGTransp(
        int|GTranspTipTrans $iTipTrans = null,
        int|GTranspModTrans $iModTrans,
        int|GTranspRespFlete $iRespFlete,
        String|Incoterm|null $cCondNeg = null,
        ?String $dNuManif = null,
        ?String $dNuDespImp = null,
        ?DateTime $dIniTras = null,
        ?DateTime $dFinTras = null,
        ?String $cPaisDest = null
    ): self {
        $this->gTransp = new GTransp();
        
        if ($iTipTrans !== null) {
            $this->gTransp->setITipTrans($iTipTrans);
        }
        $this->gTransp->setIModTrans($iModTrans);
        $this->gTransp->setIRespFlete($iRespFlete);
        
        if ($cCondNeg !== null) {
            $this->gTransp->setCCondNeg($cCondNeg);
        }
        if ($dNuManif !== null) {
            $this->gTransp->setDNuManif($dNuManif);
        }
        if ($dNuDespImp !== null) {
            $this->gTransp->setDNuDespImp($dNuDespImp);
        }
        if ($dIniTras !== null) {
            $this->gTransp->setDIniTras($dIniTras);
        }
        if ($dFinTras !== null) {
            $this->gTransp->setDFinTras($dFinTras);
        }
        if ($cPaisDest !== null) {
            $this->gTransp->setCPaisDest($cPaisDest);
        }

        return $this;
    }

}