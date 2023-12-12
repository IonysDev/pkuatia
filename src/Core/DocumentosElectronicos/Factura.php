<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;

use Abiliomp\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Utils\RNGMaker;
use Abiliomp\Pkuatia\Utils\RucUtils;
use Abiliomp\Pkuatia\Helpers\CDCHelper;
use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GOpeCom;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamCond;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamFE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamSal;;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamTrans;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCompPub;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCuotas;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPaConEIni;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPagCheq;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPagCred;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GPagTarCD;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GTransp;
use Abiliomp\Pkuatia\Core\Fields\DE\F\GTotSub;
use Abiliomp\Pkuatia\Core\Fields\DE\G\GCamCarg;
use Abiliomp\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;

/**
 * Tipo de Documento Electrónico Sifen: 1 - Factura
 */
class Factura extends DocumentoElectronico
{
  
  //////////////////////////////////////////
  // Atributos
  //////////////////////////////////////////
  public GOpeCom $gOpeCom; // D010 -Campos inherentes a la operación comercial

  public GCamFE $gCamFE; // E010 - Campos que componen la factura electrónica (FE)
  //////////////////////////////////////////
  // Constructor
  //////////////////////////////////////////
  
  public function __construct()
  {
    parent::__construct();
    $this->gOpeCom = new GOpeCom();
    $this->gCamFE = new GCamFE();
  }  

  //////////////////////////////////////////
  // Getters
  //////////////////////////////////////////

  

  //////////////////////////////////////////
  // Setters
  //////////////////////////////////////////

  //////////////////////////////////////////
  // Otros Métodos
  //////////////////////////////////////////
}
