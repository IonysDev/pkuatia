<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;

use Abiliomp\Pkuatia\Core\Constants\EmisRecTipCont;
use Abiliomp\Pkuatia\Core\Constants\RecTiOpe;
use Abiliomp\Pkuatia\Core\Constants\TipIDRec;
use Abiliomp\Pkuatia\Core\Constants\TipIDRespDE;
use Abiliomp\Pkuatia\Core\Constants\TipoDeRegimen;
use Abiliomp\Pkuatia\Core\Fields\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatRec;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GEmis;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GRespDE;
use Abiliomp\Pkuatia\Utils\RucUtils;
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
  public GEmis $gEmis; // D100 - Campos que describen al emisor del documento electrónico
  public GDatRec $gDatRec; // D200 - Campos que describen al receptor del documento electrónico

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
    $this->gEmis = new GEmis();
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

  /////////////////////////////////////////////////////////////////
  // START - Datos del emisor
  /////////////////////////////////////////////////////////////////

  /**
   * Establece el RUC, junto con su digito verificador, del contribuyente emisor del documento electrónico.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param String $rucEmisor RUC del contribuyente emisor
   * @param int $dv dígito verificador del RUC del contribuyente emisor
   * 
   * @return self
   */
  public function setEmisorRUC(String $rucEmisor, int $dv): self
  {
    if(!RucUtils::ValidarRUCconDV($rucEmisor . '-' . $dv))
      throw new Exception("[DocumentoElectronico::setEmisorRUC] El RUC del emisor no es válido. Valor recibido: $rucEmisor-$dv");
    $this->gEmis->setDRucEm($rucEmisor);
    $this->gEmis->setDDVEmi($dv);
    return $this;
  }

  /**
   * Establece el tipo de contribuyente emisor del documento electrónico.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param EmisRecTipCont $tipoContribuyente tipo de contribuyente emisor
   * 
   * @return self
   */
  public function setEmisorTipoContribuyente(EmisRecTipCont $tipoContribuyente): self
  {
    $this->gEmis->setITipCont($tipoContribuyente);
    return $this;
  }

  /**
   * Establece el tipo de régimen tributario del contribuyente emisor del documento electrónico.
   * Valor OPCIONAL.
   * 
   * @param TipoDeRegimen $tipoRegimen tipo de régimen tributario del contribuyente emisor
   * 
   * @return self
   */
  public function setEmisorTipoRegimen(TipoDeRegimen $tipoRegimen): self
  {
    $this->gEmis->setCTipReg($tipoRegimen);
    return $this;
  }

  /**
   * Establece el nombre o razón social del contribuyente emisor del documento electrónico.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param String $nombreEmisor nombre o razón social del contribuyente emisor
   * 
   * @return self
   */
  public function setEmisorNombre(String $nombreEmisor): self
  {
    $this->gEmis->setDNomEmi($nombreEmisor);
    return $this;
  }

  /**
   * Establece el nombre de fantasía del contribuyente emisor del documento electrónico.
   * El valor debe corresponder a lo declarado en el RUC.
   * Valor opcional.
   * 
   * @param String $nombreFantasia nombre de fantasía del contribuyente emisor
   * 
   * @return self
   */
  public function setEmisorNombreFantasia(String $nombreFantasia): self
  {
    $this->gEmis->setDNomFanEmi($nombreFantasia);
    return $this;
  }

  /**
   * Establece el nombre de la calle principal de la dirección del local emisor del documento electrónico.
   * El valor debe corresponder a lo declarado en el RUC.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param String $callePrincipal calle principal de la dirección del local emisor
   * 
   * @return self
   */
  public function setEmisorDireccionLocal(String $callePrincipal): self
  {
    $this->gEmis->setDDirEmi($callePrincipal);
    return $this;
  }

  /**
   * Establece el número de casa de la dirección del local emisor del documento electrónico. Si no tiene se completa con 0.
   * El valor debe corresponder a lo declarado en el RUC.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param String $casaNro numero de casa de la dirección del local emisor
   * 
   * @return self
   */
  public function setEmisorNumCasa(String $casaNro): self
  {
    $this->gEmis->setDNumCas($casaNro);
    return $this;
  }

  /**
   * Establece el nombre de la calle secundaria de la dirección del local emisor del documento electrónico.
   * Valor opcional.
   * 
   * @param String $calleSecundaria nombre de la calle secundaria de la dirección del local emisor
   * 
   * @return self
   */
  public function setEmisorCalleSecundaria(String $calleSecundaria): self
  {
    $this->gEmis->setDCompDir1($calleSecundaria);
    return $this;
  }

  /**
   * Establece el numero de departamento, piso, local, edificio o alguna otra referencia de la dirección del local de emisión.
   * Valor opcional.
   * 
   * @param String $complementoDir nombre de la calle terciaria de la dirección del local emisor
   * 
   * @return self
   */
  public function setEmisorComplementoDireccion(String $complementoDir): self
  {
    $this->gEmis->setDCompDir2($complementoDir);
    return $this;
  }

  /**
   * Establece el código del departamento nacional donde se encuentra el local emisor del documento electrónico.
   * Su valor debe coincidir con lo declarado en el RUC.
   * Su valor debe corresponderse con el código de la tabla de códigos de departamentos del SIFEN.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param int $codDep código del departamento nacional donde se encuentra el local emisor.
   * 
   * @return self
   */
  public function setEmisorCodigoDepartamento(int $codDep): self
  {
    $this->gEmis->setCDepEmi($codDep);
    return $this;
  }

  /**
   * Establece el código del distrito y su descripción, donde se encuentra el local emisor del documento electrónico. 
   * Su valor debe coincidir con lo declarado en el RUC.
   * El distrito debe ubicarse en el departamento indicado en el campo cDepEmi.
   * Su valor debe corresponderse con el código de la tabla de códigos de distritos del SIFEN
   * Valor opcional.
   * 
   * @param int $codDist código del distrito donde se encuentra el local emisor
   * 
   * @return self
   */
  public function setEmisorCodigoDistrito(int $codDist): self
  {
    $this->gEmis->setCDisEmi($codDist);
    return $this;
  }

  /**
   * Establece el código de la ciudad y su descripción, donde se encuentra el local emisor del documento electrónico.
   * Su valor debe coincidir con lo declarado en el RUC.
   * La ciudad debe ubicarse en el departamento indicado en el campo cDepEmi.
   * Su valor debe corresponderse con el código de la tabla de códigos de ciudades del SIFEN.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param int $codCiud código de la ciudad donde se encuentra el local emisor
   * 
   * @return self
   */
  public function setEmisorCodigoCiudad(int $codCiud): self
  {
    $this->gEmis->setCCiuEmi($codCiud);
    return $this;
  }

  /**
   * Establece el número de teléfono del local emisor del documento electrónico.
   * Debe incluir el prefijo de ciudad y corresponderse con lo declarado en el RUC.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param String $telefono número de teléfono del local emisor
   * 
   * @return self
   */
  public function setEmisorTelefono(String $telefono): self
  {
    $this->gEmis->setDTelEmi($telefono);
    return $this;
  }

  /**
   * Establece la dirección de correo electrónico del emisor del documento electrónico.
   * Debe corresponderse con lo declarado en el RUC.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param String $email dirección de correo electrónico del emisor
   * 
   * @return self
   */
  public function setEmisorEmail(String $email): self
  {
    $this->gEmis->setDEmailE($email);
    return $this;
  }

  /**
   * Establece la denominación interna que le da el emisor al local donde se emite el documento electrónico.
   * Valor opcional.
   */
  public function setEmisorDenominacionSucursal(String $denominacion): self
  {
    $this->gEmis->setDDenSuc($denominacion);
    return $this;
  }

  /**
   * Agrega una actividad económica al emisor del documento electrónico.
   * Tanto el código como la descripción deben corresponderse con lo declarado en el RUC.
   * 
   * @param int $codigo código de la actividad económica
   * @param String $descripcion descripción de la actividad económica
   * 
   * @return self
   */
  public function addEmisorActividadEconomica(int $codigo, String $descripcion): self
  {
    $this->gEmis->addActEco($codigo, $descripcion);
    return $this;
  }

  /**
   * Establece la persona responsable de la generación del documento electrónico dentro de la organización del emisor.
   * Valor opcional.
   * 
   * @param TipIDRespDE $tipoID tipo de documento de identidad del responsable de la generación del DE
   * @param String $nroID número de documento de identidad del responsable de la generación del DE
   * @param String $nombre nombre o razón social del responsable de la generación del DE
   * @param String $cargo cargo del responsable de la generación del DE
   * 
   * @return self
   */
  public function setEmisorResponsableDelDE(TipIDRespDE $tipoID, String $nroID, String $nombre, String $cargo) : self
  {
    $gRespDE = new GRespDE();
    $gRespDE->setITipIDRespDE($tipoID);
    $gRespDE->setDNumIDRespDE($nroID);
    $gRespDE->setDNomRespDE($nombre);
    $gRespDE->setDCarRespDE($cargo);
    $this->gEmis->setGRespDE($gRespDE);
    return $this;
  }

  /////////////////////////////////////////////////////////////////
  // END - Datos del emisor
  /////////////////////////////////////////////////////////////////

  /**
   * Establece los datos del receptor del documento electrónico.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param String $nombre nombre o razón social del receptor (obligatorio)
   * @param bool $esContribuyente si el receptor es contribuyente (obligatorio)
   * @param RecTiOpe $tipoOperacion tipo de operación (obligatorio)
   * @param String $codPais código del país del receptor (obligatorio)
   * @param EmisRecTipCont $tipoContribuyente tipo de contribuyente del receptor (obligatorio si es contribuyente)
   * @param String $ruc RUC del receptor (obligatorio si es contribuyente)
   * @param int $dv dígito verificador del RUC del receptor (obligatorio si es contribuyente)
   * @param TipIDRec $tipoIdentificacion tipo de documento de identidad del receptor (obligatorio si no es contribuyente y no es extranjero)
   * @param String $nroIdentificacion número de documento de identidad del receptor (obligatorio si no es contribuyente y no es extranjero)
   * @param String $nombreFantasia nombre de fantasía del receptor (opcional)
   * @param String $callePrincipal calle principal de la dirección del receptor (obligatorio si el DE es una Nota de Remisión o si es extranjero B2F, opcional para los demas)
   * @param int $numeroCasa número de casa de la dirección del receptor (obligatorio si el DE es una Nota de Remisión o si es extranjero B2F, opcional para los demas)
   * @param int $codigoDepartamento código del departamento nacional donde se encuentra el receptor (obligatorio si el DE es una Nota de Remisión o si es extranjero B2F, opcional para los demas)
   * @param int $codigoDistrito código del distrito donde se encuentra el receptor (opcional)
   * @param int $codigoCiudad código de la ciudad donde se encuentra el receptor (obligatorio si el DE es una Nota de Remisión o si es extranjero B2F, opcional para los demas)
   * @param String $telefono número de teléfono del receptor (opcional)
   * @param String $email dirección de correo electrónico del receptor (opcional)
   * @param String $codigoDeCliente código de cliente del receptor (opcional)
   * 
   * @return self
   */
  public function setReceptor(
    String $nombre,
    bool $esContribuyente,
    RecTiOpe $tipoOperacion, 
    String $codPais,
    ?EmisRecTipCont $tipoContribuyente,
    ?String $ruc,
    ?int $dv,
    ?TipIDRec $tipoIdentificacion,
    ?String $nroIdentificacion,
    ?String $nombreFantasia,
    ?String $callePrincipal,
    ?int $numeroCasa,
    ?int $codigoDepartamento,
    ?int $codigoDistrito,
    ?int $codigoCiudad,
    ?String $telefono,
    ?String $email,
    ?String $codigoDeCliente
    ) : self
  {
    $gDatRec = new GDatRec();
    $gDatRec->setDNomRec($nombre);
    $gDatRec->setINatRec($esContribuyente ? 1 : 0);
    $gDatRec->setITiOpe($tipoOperacion);
    $gDatRec->setCPaisRec($codPais);
    if($esContribuyente) {
      $gDatRec->setITiContRec($tipoContribuyente);
      $gDatRec->setDRucRec($ruc);
      $gDatRec->setDDVRec($dv);
    } else {
      $gDatRec->setITipIDRec($tipoIdentificacion);
      $gDatRec->setDNumIDRec($nroIdentificacion);
    }
    if(isset($nombreFantasia))
      $gDatRec->setDNomFanRec($nombreFantasia);
    if(isset($callePrincipal))
      $gDatRec->setDDirRec($callePrincipal);
    if(isset($numeroCasa))
      $gDatRec->setDNumCasRec($numeroCasa);
    if(isset($codigoDepartamento))
      $gDatRec->setCDepRec($codigoDepartamento);
    if(isset($codigoDistrito))
      $gDatRec->setCDisRec($codigoDistrito);
    if(isset($codigoCiudad))  
      $gDatRec->setCCiuRec($codigoCiudad);
    if(isset($telefono))
      $gDatRec->setDTelRec($telefono);
    if(isset($email))
      $gDatRec->setDEmailRec($email);
    if(isset($codigoDeCliente))
      $gDatRec->setDCodCliente($codigoDeCliente);
    $this->gDatRec = $gDatRec;
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
