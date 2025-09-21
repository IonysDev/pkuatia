<?php

namespace IonysDev\Pkuatia\Core\DocumentosElectronicos;

use IonysDev\Pkuatia\Core\Constants\OpeComCondAnt;
use IonysDev\Pkuatia\Core\Constants\OpeComCondTipCam;
use IonysDev\Pkuatia\Core\Constants\OpeComTipImp;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\Fields\DE\D\GOpeCom;

/**
 * Clase que extiende a DocumentoElectronico y contiene la estructura básica de un Documento Electrónico Comercial.
 */
class DocumentoElectronicoComercial extends DocumentoElectronico
{
  
  //////////////////////////////////////////
  // Atributos
  //////////////////////////////////////////
  
  public GOpeCom $gOpeCom; // D010 -Campos inherentes a la operación comercial

  //////////////////////////////////////////
  // Constructor
  //////////////////////////////////////////
  
  public function __construct()
  {
    parent::__construct();
    $this->gOpeCom = new GOpeCom();
  }  

  //////////////////////////////////////////
  // Setters
  //////////////////////////////////////////

  /**
   * Establece el tipo de transacción de la operación comercial.
   * Valor obligatorio para los documentos electrónicos comerciales.
   * 
   * @param OpeComTipTrans $tipTra Tipo de transacción de la operación comercial
   * 
   * @return self
   * 
   */
  public function setTipoDeTransaccion(int|OpeComTipTrans $tipTra): self
  {
    $this->gOpeCom->setITipTra($tipTra);
    return $this;
  }

  /**
   * Establece el tipo de impuesto afectado por la operación comercial.
   * 
   * @param OpeComTipImp $tipImp Tipo de impuesto afectado por la operación comercial
   * 
   * @return self
   */
  public function setTipoDeImpuestoAfectado(int|OpeComTipImp $tipImp): self
  {
    $this->gOpeCom->setITImp($tipImp);
    return $this;
  }

  /**
   * Establece la moneda de la operación comercial. Se debe expresar en código de moneda ISO 4217.
   * Valor por defecto: PYG
   * 
   * @param String $moneda Código de moneda ISO 4217
   * 
   * @return self
   */
  public function setMoneda(String $moneda): self
  {
    $this->gOpeCom->setCMoneOpe($moneda);
    return $this;
  }

  /**
   * Establece la condición de aplicación de tipo de cambio. Valor obligatorio para los documentos electrónicos comerciales con moneda diferente a PYG.
   * 
   * @param OpeComCondTipCam $condTipCam Condición de tipo de cambio
   * 
   * @return self
   */
  public function setCondicionTipoDeCambio(int|OpeComCondTipCam $condTipCam): self
  {
    $this->gOpeCom->setDCondTiCam($condTipCam);
    return $this;
  }

  /**
   * Establece la tasa de cambio. Valor obligatorio para los documentos electrónicos comerciales con moneda diferente a PYG.
   * 
   * @param string $tasaDeCambio Tasa de cambio expresada en cadena decimal para procesarse con BCMath.
   * 
   * @return self
   */
  public function setTipoDeCambio(String $tasaDeCambio): self
  {
    $this->gOpeCom->setDTiCam($tasaDeCambio);
    return $this;
  }

  /**
   * Establece la condición de aplicación de anticipo. Valor obligatorio para los documentos electrónicos comerciales que contengan anticipos.
   * 
   * @param OpeComCondAnt $condAnt Condición de anticipo
   * 
   * @return self
   */
  public function setCondicionDeAnticipo(int|OpeComCondAnt $condAnt): self
  {
    $this->gOpeCom->setICondAnt($condAnt);
    return $this;
  }

  //////////////////////////////////////////
  // Getters
  //////////////////////////////////////////

  

  

  //////////////////////////////////////////
  // Otros Métodos
  //////////////////////////////////////////

  /**
   * Genera y devuelve un objeto RDE que contiene todos los campos de este documento electrónico.
   */
  public function documentoElectronicoComercialToRDE(): RDE
  {
    $rde = $this->documentoElectronicoToRDE();
    if($this->getTipoDocumentoElectronico() != TimbTiDE::Factura && $this->getTipoDocumentoElectronico() != TimbTiDE::Autofactura) {
      $this->gOpeCom->setITipTra(null);
    }
    $rde->DE->gDatGralOpe->gOpeCom = $this->gOpeCom;
    return $rde;
  }
}
