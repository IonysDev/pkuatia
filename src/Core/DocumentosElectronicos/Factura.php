<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;

use Abiliomp\Pkuatia\Core\Constants\CamCondOpe;
use Abiliomp\Pkuatia\Core\Constants\CamFEIndPres;
use Abiliomp\Pkuatia\Core\Constants\TimbTiDE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamCond;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamFE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCompPub;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPaConEIni;
use DateTime;

/**
 * Tipo de Documento Electrónico Sifen: 1 - Factura
 */
class Factura extends DocumentoElectronicoComercial
{
  
  //////////////////////////////////////////
  // Atributos
  //////////////////////////////////////////
  
  public GCamFE $gCamFE; // E010 - Campos que componen la factura electrónica (FE)
  public GCompPub $gCompPub; // E020 - Campos que describen las informaciones de compras públicas
  public GCamCond $gCamCond; // E600 - Campos que describen las condiciones de pago de la factura electrónica
  public GPaConEIni $gPaConEIni; // E605 - Campos que describen las condiciones de pago al contado o de la entrega inicial.
  

  //////////////////////////////////////////
  // Constructor
  //////////////////////////////////////////
  
  /**
   * Constructor de la clase.
   * 
   * @param CamCondOpe $condicion Condición de operación de la factura electrónica.
   * 
   * @return void
   */
  public function __construct(CamCondOpe $condicion)
  {
    parent::__construct();
    $this->gTimb->setITiDE(TimbTiDE::Factura);
    $this->gCamFE = new GCamFE();
    $this->gCamCond = new GCamCond();
    $this->gCamCond->setICondOpe($condicion);
  }  

  //////////////////////////////////////////
  // Setters
  //////////////////////////////////////////

  /**
   * Establece el indicador de presencia para la emisión de la factura electrónica.
   * Valor OBLIGATORIO.
   * 
   * @param CamFEIndPres $indPres Indicador de presencia.
   * 
   * @return self
   */
  public function setIndicadorPresencia(CamFEIndPres $indPres) : self
  {
    $this->gCamFE->setIIndPres($indPres);
    return $this;
  }

  /**
   * Establece la fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica cuando corresponda.
   * 
   * @param DateTime $fecha Fecha estimada para el traslado de la mercadería y emisión de la nota de remisión electrónica cuando corresponda.
   * 
   * @return self
   */
  public function setFechaDeRemision(DateTime $fecha) : self
  {
    $this->gCamFE->setDFecEmNR($fecha);
    return $this;
  }

  /**
   * Establece los datos adicionales necesarios para facturas electrónicas emitidas a entidades públicas (B2G).
   * Estos valores son obligatorios solo en caso de que el receptor sea una entidad pública.
   * 
   * @param String $codigoDNCPModalidad Código de modalidad emitido por la DNCP.
   * @param String $codigoDNCPEntidad Código de entidad pública emitido por la DNCP.
   * @param int $anho Año de contratación según registros de la DNCP.
   * @param int $nroDNCPSecuencia Número de secuencia del registro de la DNCP.
   */
  public function setDatosComprasPublicas(String $codigoDNCPModalidad, String $codigoDNCPEntidad, int $anho, int $nroDNCPSecuencia) : self
  {
    $this->gCompPub = new GCompPub();
    $this->gCompPub->setDModCont($codigoDNCPModalidad);
    $this->gCompPub->setDEntCont($codigoDNCPEntidad);
    $this->gCompPub->setDAnoCont($anho);
    $this->gCompPub->setDSecCont($nroDNCPSecuencia);
    return $this;
  }

  //////////////////////////////////////////
  // Getters
  //////////////////////////////////////////

  //////////////////////////////////////////
  // Otros Métodos
  //////////////////////////////////////////
}
