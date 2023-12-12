<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;

use Abiliomp\Pkuatia\Core\Fields\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Utils\TimbradoUtils;
use DateTime;
use Exception;

/**
 * Clase que contiene la estructura básica de un DE, en todos los casos posibles de éste; asi como las validaciones necesarias.
 */
class DocumentoElectronico {

  public GOpeDE $gOpeDE; // B001 - Campos que describen la operación del documento electrónico
  public GTimb  $gTimb; // C001 - Campos que describen el timbrado del documento electrónico
  public GDatGralOpe $gDatGralOpe; // D001 -Campos generales del documento electrónico
  /**
   * Constructor
   * 
   * @param GTimb $timbrado datos de timbrado del documento electrónico
   */
  public function __construct(GTimb $timbrado = null)
  {
    $this->gOpeDE = new GOpeDE();
    if($timbrado)
      $this->gTimb = $timbrado;
    else
      $this->gTimb = new GTimb();
    $this->gDatGralOpe = new GDatGralOpe();
  }

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece información y/o comentarios de interés del emisor.
   * ESTA INFORMACIÓN SE INCLUYE EN EL DOCUMENTO ELECTRÓNICO.
   * Valor OPCIONAL.
   * 
   * @param String $dInfEmi comentarios del emisor
   * 
   * @return self
   */
  public function setInformacionDeInteresEmisor(String $infoEmi): self
  {
    $this->gOpeDE->setDInfoEmi($infoEmi);
    return $this;
  }

  /**
   * Establece información y/o comentarios de interés para el fisco.
   * ESTA INFORMACIÓN SE INCLUYE EN EL DOCUMENTO ELECTRÓNICO.
   * Valor OPCIONAL salvo para notas de remisión s/ art. 3 inc. 7 de la resolución 41/2014 de la SET donde dice:
   * La indicación expresa de «Mercaderías con cadena de Frío»; «Carga Peligrosa», u otro dato de relevancia similar, cuando se transporten productos que cumplan algunas de estas características.
   * 
   * @param String $dInfFisc comentarios para fisco
   * 
   * @return self
   */
  public function setInfoDeInteresFiscal(String $infoFisc): self
  {
    $this->gOpeDE->setDInfoFisc($infoFisc);
    return $this;
  }

  /**
   * Establece el número de timbrado del documento electrónico.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param int $numTimb número de timbrado
   * 
   * @return self
   */
  public function setNumeroDeTimbrado(int $numTimb): self
  {
    $this->gTimb->setDNumTim($numTimb);
    return $this;
  }

  /**
   * Establece la fecha de inicio del timbrado del documento electrónico.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param DateTime $fechaInicio fecha de inicio del timbrado
   * 
   * @return self
   */
  public function setFechaInicioTimbrado(DateTime $fechaInicio): self
  {
    $this->gTimb->setDFeIniT($fechaInicio);
    return $this;
  }

  /**
   * Establece la serie del número de timbrado del documento electrónico. Se admite un valor entre AA, AB, AC... ZY y ZZ.
   * Valor OPCIONAL. Solo se utiliza cuando se han agotado los números de timbrado originales y se debe utilizar una nueva serie del mismo timbrado.
   *
   * @param String $serie serie del número de timbrado
   * 
   * @return self
   * 
   * @throws Exception si la serie no es válida 
   */
  public function setSerieNumeroTimbrado(String $serie): self
  {
    if(!TimbradoUtils::ValidarSerie($serie))
      throw new Exception("[DocumentoElectronico::setSerieNumeroTimbrado] Valor de serie inválido. Valor recibido: $serie");
    $this->gTimb->setDSerieNum($serie);
    return $this;
  }

  /**
   * Establece el número de establecimiento del documento electrónico. Se admite un valor entre 1 y 999.
   * EST-EXP-NÚMEROD
   *  ^
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param int $numEst número de establecimiento
   * 
   * @return self
   * 
   * @throws Exception si el número de establecimiento no es válido
   */
  public function setNumeroEstablecimiento(int $numEst): self
  {
    if($numEst < 1 || $numEst > 999)
      throw new Exception("[DocumentoElectronico::setNumeroEstablecimiento] El número de establecimiento debe ser un valor entre 1 y 999. Valor recibido: $numEst");
    $this->gTimb->setDEst(str_pad(strval($numEst), 3, "0", STR_PAD_LEFT));
    return $this;
  }

  /**
   * Establece el número de punto de expedición del documento electrónico. Se admite un valor entre 1 y 999.
   * EST-EXP-NÚMEROD
   *      ^
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param int $numExp número de punto de expedición
   * 
   * @return self
   * 
   * @throws Exception si el número de punto de expedición no es válido
   */
  public function setNumeroPuntoExpedicion(int $numExp): self
  {
    if($numExp < 1 || $numExp > 999)
      throw new Exception("[DocumentoElectronico::setNumeroPuntoExpedicion] El número de punto de expedición debe ser un valor entre 1 y 999. Valor recibido: $numExp");
    $this->gTimb->setDPunExp(str_pad(strval($numExp), 3, "0", STR_PAD_LEFT));
    return $this;
  }


  /**
   * Establece el número de documento electrónico. Se admite un valor entre 1 y 9999999.
   * EST-EXP-NÚMEROD
   *           ^
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param int $numDoc número de documento electrónico
   * 
   * @return self
   * 
   * @throws Exception si el número de documento electrónico no es válido.
   */
  public function setNumeroDocumento(int $numDoc): self
  {
    if($numDoc < 1 || $numDoc > 9999999)
      throw new Exception("[DocumentoElectronico::setNumeroDocumento] El número de documento debe ser un valor entre 1 y 9999999. Valor recibido: $numDoc");
    $this->gTimb->setDNumDoc($numDoc);
    return $this;
  }

  /**
   * Establece la fecha y hora de emisión del documento electrónico.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param DateTime $fechaEmision fecha y hora de emisión
   * 
   * @return self
   */
  public function setFechaEmision(DateTime $fechaEmision): self
  {
    $this->gDatGralOpe->setDFeEmiDE($fechaEmision);
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Devuelve el número completo del documento electrónico formateado.
   * 
   * @return String el número completo del documento electrónico formateado 000-000-0000000
   */
  public function getNumeroDocumentoCompleto(): String
  {
    return $this->gTimb->getDEst() . '-' . $this->gTimb->getDPunExp() . '-' . $this->gTimb->getDNumDoc();
  }
  
}
