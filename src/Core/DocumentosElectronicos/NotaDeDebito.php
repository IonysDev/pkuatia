<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos;

use IonysDev\Pkuatia\Core\Constants\OpeComTipImp;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Traits\ItemValorado;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\E\GCamNCDE;
use IonysDev\Pkuatia\Core\Constants\MotEmi;

/**
 * Tipo de Documento Electrónico Sifen: 6 - Nota de Débito Electrónica
 */
class NotaDeDebito extends DocumentoElectronicoComercial
{
    use ItemValorado;

    //////////////////////////////////////////
    // Atributos
    //////////////////////////////////////////
    
    public GCamNCDE $gCamNCDE; // E040 - Campos que componen la nota de débito electrónica
    
    //////////////////////////////////////////
    // Constructor
    //////////////////////////////////////////
    
    /**
     * Constructor de la clase. Establece el tipo de documento electrónico como Nota de Débito.
     * Adicionalmente inicializa el campo de impuesto afectado como IVA y la moneda como Guaraníes (PYG).
     * 
     * @param int|MotEmi $motivoEmision Motivo de emisión de la nota de débito.
     * 
     * @return void
     */
    public function __construct(int|MotEmi $motivoEmision)
    {
        parent::__construct();
        $this->gTimb->setITiDE(TimbTiDE::NotaDeDebito);
        $this->gCamNCDE = new GCamNCDE();
        $this->gCamNCDE->setIMotEmi($motivoEmision);
        $this->setTipoDeImpuestoAfectado(OpeComTipImp::IVA);
        $this->setMoneda('PYG');
    }

    //////////////////////////////////////////
    // Setters
    //////////////////////////////////////////

    /**
     * Establece el motivo de emisión de la nota de débito.
     * 
     * @param int|MotEmi $motivoEmision Motivo de emisión de la nota de débito.
     * 
     * @return self
     */
    public function setMotivoEmision(int|MotEmi $motivoEmision) : self
    {
        $this->gCamNCDE->setIMotEmi($motivoEmision);
        return $this;
    }

    //////////////////////////////////////////
    // Otros Métodos
    //////////////////////////////////////////

    /**
     * Genera y devuelve un objeto RDE que contiene todos los campos de este documento electrónico.
     */
    public function notaDeDebitoToRDE(): RDE
    {
        $this->gDtipDE->gCamNCDE = $this->gCamNCDE;
        $this->gDtipDE->gCamItem = $this->items;
        $rde = $this->documentoElectronicoComercialToRDE();
        $rde->DE->gCamDEAsoc = $this->gCamDEAsoc;
        $rde->DE->gTotSub = $this->gTotSub;
        return $rde;
    }
}
