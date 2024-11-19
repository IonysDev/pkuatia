<?php

namespace Abiliomp\Pkuatia\Core\DocumentosElectronicos;

use Abiliomp\Pkuatia\Core\Constants\EmisRecTipCont;
use Abiliomp\Pkuatia\Core\Constants\RecTiOpe;
use Abiliomp\Pkuatia\Core\Constants\TipDocAso;
use Abiliomp\Pkuatia\Core\Constants\TipIDRec;
use Abiliomp\Pkuatia\Core\Constants\TipIDRespDE;
use Abiliomp\Pkuatia\Core\Constants\TipoDeRegimen;
use Abiliomp\Pkuatia\Core\Constants\TipoDocImpresoAso;
use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;
use Abiliomp\Pkuatia\Core\Fields\DE\B\GOpeDE;
use Abiliomp\Pkuatia\Core\Fields\DE\C\GTimb;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatGralOpe;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GDatRec;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GEmis;
use Abiliomp\Pkuatia\Core\Fields\DE\D\GRespDE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GCamEsp;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GDtipDE;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GGrupAdi;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GGrupEner;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GGrupPolSeg;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GGrupSeg;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GGrupSup;
use Abiliomp\Pkuatia\Core\Fields\DE\E\GTransp;
use Abiliomp\Pkuatia\Core\Fields\DE\G\GCamGen;
use Abiliomp\Pkuatia\Core\Fields\DE\H\GCamDEAsoc;
use Abiliomp\Pkuatia\Utils\RucUtils;
use Abiliomp\Pkuatia\Utils\TimbradoUtils;
use DateTime;
use Exception;

/**
 * Clase que contiene la estructura básica de un DE, en todos los casos posibles de éste; asi como las validaciones necesarias.
 */
class DocumentoElectronico
{

  public GOpeDE $gOpeDE; // B001 - Campos que describen la operación del documento electrónico
  public GTimb  $gTimb; // C001 - Campos que describen el timbrado del documento electrónico

  public GDatGralOpe $gDatGralOpe; // D001 -Campos generales del documento electrónico
  public GEmis $gEmis; // D100 - Campos que describen al emisor del documento electrónico
  public GDatRec $gDatRec; // D200 - Campos que describen al receptor del documento electrónico

  public GDtipDE $gDtipDE; // E001 - Campos específicos por tipo de Documento Electrónico
  public GGrupEner $gGrupEner; // E791 - Campos que describen datos específicos para el sector energía eléctrica
  public GGrupSeg $gGrupSeg; // E800 - Campos que describen datos específicos para el sector seguros
  public GGrupSup $gGrupSup; // E810 - Campos que describen datos específicos para el sector supermercados
  public GGrupAdi $gGrupAdi; // E820 - Campos que describen datos adicionales de uso comercial en general
  public GTransp $gTransp; // E900 - Campos que describen el transporte de las mercaderías

  public GCamGen $gCamGen; // G001 - Campos de uso general

  public array $gCamDEAsoc; // H001 - Campos que identifican a los DE asociados a este DE.

  /**
   * Constructor
   * 
   * @param GTimb $timbrado datos de timbrado del documento electrónico
   */
  public function __construct(GTimb $timbrado = null)
  {
    $this->gOpeDE = new GOpeDE();
    if ($timbrado)
      $this->gTimb = $timbrado;
    else
      $this->gTimb = new GTimb();
    $this->gDatGralOpe = new GDatGralOpe();
    $this->gEmis = new GEmis();
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Genera y devuelve un objeto RDE que contiene todos los campos de este documento electrónico.
   */
  public function documentoElectronicoToRDE(): RDE
  {
    $de = new DE();

    // B. Campos inherentes a la operación de Documentos Electrónicos (B001-B099)
    $de->setGOpeDE($this->gOpeDE);

    // C. Campos de datos del Timbrado (C001-C099)
    $de->setGTimb($this->gTimb);

    // D. Campos Generales del Documento Electrónico DE (D001-D299)
    $this->gDatGralOpe->setGEmis($this->gEmis);
    $this->gDatGralOpe->setGDatRec($this->gDatRec);
    $de->setGDatGralOpe($this->gDatGralOpe);

    // E. Campos específicos por tipo de Documento Electrónico (E001-E009) 
    $de->setGDtipDE($this->gDtipDE);
    if(isset($this->gGrupEner)){
      $de->gDtipDe->setGCamEsp(new GCamEsp());
      $de->gDtipDe->gCamEsp->setGGrupEner($this->gGrupEner);
    }
    else if(isset($this->gGrupSeg)){
      $de->gDtipDe->setGCamEsp(new GCamEsp());
      $de->gDtipDe->gCamEsp->setGGrupSeg($this->gGrupSeg);
    }
    else if(isset($this->gGrupSup)){
      $de->gDtipDe->setGCamEsp(new GCamEsp());
      $de->gDtipDe->gCamEsp->setGGrupSup($this->gGrupSup);
    }
    else if(isset($this->gGrupAdi)){
      $de->gDtipDe->setGCamEsp(new GCamEsp());
      $de->gDtipDe->gCamEsp->setGGrupAdi($this->gGrupAdi);
    }    
    if(isset($this->gTransp)){
      $de->gDtipDe->setGTransp($this->gTransp);
    }

    // G. Campos de uso general (G001-G049)
    if(isset($this->gCamGen))
      $de->setGCamGen($this->gCamGen);

    // H. Campos que identifican al documento asociado (H001-H049)
    if(isset($this->gCamDEAsoc) && count($this->gCamDEAsoc) > 0)
      $de->setGCamDEAsoc($this->gCamDEAsoc);

    // Por último se encapsulan los campos en un RDE
    $rde = new RDE();
    $rde->setDE($de);
    return $rde;
  }

  /**
   * Devuelve el número completo del documento electrónico formateado.
   * 
   * @return String el número completo del documento electrónico formateado 000-000-0000000
   */
  public function getNumeroDocumentoCompleto(): String
  {
    return $this->gTimb->getDEst() . '-' . $this->gTimb->getDPunExp() . '-' . $this->gTimb->getDNumDoc();
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
   * Establece los datos del timbrado, la serie y el número de documento.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param int $numTimb número de timbrado
   * @param DateTime $fechaInicio fecha de inicio del timbrado
   * @param int $numEst número de establecimiento
   * @param int $numExp número de punto de expedición
   * @param int $numDoc número de documento electrónico
   * @param String $serie serie del número de timbrado (opcional)
   * 
   * @return self
   */
  public function setTimbrado(int $numTimb, DateTime $fechaInicio, int $numEst, int $numExp, int $numDoc, ?String $serie = null): self
  {
    $this->setNumeroDeTimbrado($numTimb);
    $this->setFechaInicioTimbrado($fechaInicio);
    $this->setNumeroEstablecimiento($numEst);
    $this->setNumeroPuntoExpedicion($numExp);
    $this->setNumeroDocumento($numDoc);
    if ($serie)
      $this->setSerieNumeroTimbrado($serie);	
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
    if (!TimbradoUtils::ValidarSerie($serie))
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
    if ($numEst < 1 || $numEst > 999)
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
    if ($numExp < 1 || $numExp > 999)
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
    if ($numDoc < 1 || $numDoc > 9999999)
      throw new Exception("[DocumentoElectronico::setNumeroDocumento] El número de documento debe ser un valor entre 1 y 9999999. Valor recibido: $numDoc");
    $this->gTimb->setDNumDoc(str_pad($numDoc, 7, '0', STR_PAD_LEFT));
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
   * Establece los datos del Emisor del documento electrónico.
   * Valor OBLIGATORIO para todos los documentos electrónicos.
   * 
   * @param String $rucEmisor RUC del emisor (obligatorio)
   * @param int $dv dígito verificador del RUC del emisor (obligatorio)
   * @param EmisRecTipCont $tipoContribuyente tipo de contribuyente del emisor (obligatorio)
   * @param TipoDeRegimen $tipoRegimen tipo de régimen tributario del emisor (opcional)
   * @param String $nombreEmisor nombre o razón social del emisor (obligatorio)
   * @param String $nombreFantasia nombre de fantasía del emisor (opcional)
   * @param String $callePrincipal calle principal de la dirección del emisor (obligatorio)
   * @param String $casaNro número de casa de la dirección del emisor (obligatorio)
   * @param String $calleSecundaria calle secundaria de la dirección del emisor (opcional)
   * @param String $complementoDir complemento de la dirección del emisor (opcional)
   * @param int $codDep código del departamento nacional donde se encuentra el emisor (obligatorio)
   * @param int $codDistrito código del distrito donde se encuentra el emisor (opcional)
   * @param int $codCiud código de la ciudad donde se encuentra el emisor (obligatorio)
   * @param String $telefono número de teléfono del emisor (obligatorio)
   * @param String $email dirección de correo electrónico del emisor (obligatorio)
   * @param String $nombreSucursal denominación de la sucursal del emisor (opcional)
   * 
   * @return self Instancia de la clase DocumentoElectronico con los datos del emisor establecidos para poder encadenar métodos.
   */
  public function setEmisor(
    String $rucEmisor,
    int $dv,
    int|EmisRecTipCont $tipoContribuyente,
    int|TipoDeRegimen|null $tipoRegimen,
    String $nombreEmisor,
    ?String $nombreFantasia,
    String $callePrincipal,
    String $casaNro,
    ?String $calleSecundaria,
    ?String $complementoDir,
    int $codDep,
    ?int $codDistrito,
    int $codCiud,
    String $telefono,
    String $email,
    ?String $nombreSucursal
  ): self {
    $this->setEmisorRUC($rucEmisor, $dv);
    $this->setEmisorTipoContribuyente($tipoContribuyente);

    if ($tipoRegimen)
      $this->setEmisorTipoRegimen($tipoRegimen);

    $this->setEmisorNombre($nombreEmisor);

    if ($nombreFantasia)
      $this->setEmisorNombreFantasia($nombreFantasia);

    $this->setEmisorDireccionLocal($callePrincipal);
    $this->setEmisorNumCasa($casaNro);
    if ($calleSecundaria)
      $this->setEmisorCalleSecundaria($calleSecundaria);
    if ($complementoDir)
      $this->setEmisorComplementoDireccion($complementoDir);

    $this->setEmisorCodigoDepartamento($codDep);
    if ($codDistrito)
      $this->setEmisorCodigoDistrito($codDistrito);
    $this->setEmisorCodigoCiudad($codCiud);

    $this->setEmisorTelefono($telefono);
    $this->setEmisorEmail($email);

    if ($nombreSucursal)
      $this->setEmisorDenominacionSucursal($nombreSucursal);
    return $this;
  }

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
    if (!RucUtils::ValidarRUCconDV($rucEmisor . '-' . $dv))
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
  public function setEmisorTipoContribuyente(int|EmisRecTipCont $tipoContribuyente): self
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
  public function setEmisorTipoRegimen(int|TipoDeRegimen $tipoRegimen): self
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
  public function setEmisorResponsableDelDE(TipIDRespDE $tipoID, String $nroID, String $nombre, String $cargo): self
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

  /////////////////////////////////////////////////////////////////
  // START - Datos del receptor
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
    int|RecTiOpe $tipoOperacion,
    String $codPais,
    int|EmisRecTipCont|null $tipoContribuyente,
    ?String $ruc,
    ?int $dv,
    int|TipIDRec|null $tipoIdentificacion,
    ?String $nroIdentificacion,
    ?String $nombreFantasia,
    ?String $callePrincipal,
    ?int $numeroCasa,
    ?int $codigoDepartamento,
    ?int $codigoDistrito,
    ?int $codigoCiudad,
    ?String $telefono,
    ?String $celular,
    ?String $email,
    ?String $codigoDeCliente
  ): self {
    // Validación de tipo de operación y país
    $tipoOpInt = $tipoOperacion instanceof RecTiOpe ? $tipoOperacion->value : $tipoOperacion;
    if ($tipoOpInt == RecTiOpe::B2F && strcmp($codPais, 'PRY') == 0) {
      throw new Exception("[DocumentoElectronico::setReceptor] No se puede emitir un DE de tipo B2F para un receptor en Paraguay.");
    }
    // Validación de tipo de identidad y estado de contribuyente
    if ($esContribuyente) {
      if (!$tipoContribuyente)
        throw new Exception("[DocumentoElectronico::setReceptor] El tipo de contribuyente es obligatorio si el receptor es contribuyente.");
      if (is_null($ruc))
        throw new Exception("[DocumentoElectronico::setReceptor] El RUC del receptor es obligatorio si el receptor es contribuyente.");
      if (is_null($dv))
        throw new Exception("[DocumentoElectronico::setReceptor] El dígito verificador del RUC del receptor es obligatorio si el receptor es contribuyente.");
    } else {
      if (!$tipoIdentificacion)
        throw new Exception("[DocumentoElectronico::setReceptor] El tipo de identificación es obligatorio si el receptor no es contribuyente.");
      if (!$nroIdentificacion)
        throw new Exception("[DocumentoElectronico::setReceptor] El número de identificación es obligatorio si el receptor no es contribuyente.");
    }

    $this->gDatRec = new GDatRec();
    $this->gDatRec->setINatRec($esContribuyente ? 1 : 0);
    $this->gDatRec->setITiOpe($tipoOperacion);
    $this->gDatRec->setCPaisRec($codPais);

    if ($esContribuyente) {
      $this->gDatRec->setITiContRec($tipoContribuyente);
      $this->gDatRec->setDRucRec($ruc);
      $this->gDatRec->setDDVRec($dv);
    }

    if (!$esContribuyente && $tipoOperacion != RecTiOpe::B2F) {
      $this->gDatRec->setITipIDRec($tipoIdentificacion);
      $this->gDatRec->setDNumIDRec($nroIdentificacion);
    }

    if ($tipoIdentificacion == TipIDRec::Innominado) {
      $this->gDatRec->setDNomRec('Sin Nombre');
    } else {
      $this->gDatRec->setDNomRec($nombre);
    }

    if (isset($nombreFantasia))
      $this->gDatRec->setDNomFanRec($nombreFantasia);

    if ($tipoOperacion == RecTiOpe::B2F && $callePrincipal == null) {
      throw new Exception("[DocumentoElectronico::setReceptor] La calle principal es obligatoria para un receptor extranjero.");
    }

    if (isset($callePrincipal)) {
      $this->gDatRec->setDDirRec($callePrincipal);
      if (!isset($numeroCasa))
        throw new Exception("[DocumentoElectronico::setReceptor] El número de casa es obligatorio si se establece la calle principal.");
      $this->gDatRec->setDNumCasRec($numeroCasa);
      if ($tipoOperacion != RecTiOpe::B2F) {
        if (!isset($codigoDepartamento))
          throw new Exception("[DocumentoElectronico::setReceptor] El código de departamento es obligatorio si se establece la calle principal.");
        $this->gDatRec->setCDepRec($codigoDepartamento);
        if (isset($codigoDistrito))
          $this->gDatRec->setCDisRec($codigoDistrito);
        if (!isset($codigoCiudad))
          throw new Exception("[DocumentoElectronico::setReceptor] El código de ciudad es obligatorio si se establece la calle principal.");
        $this->gDatRec->setCCiuRec($codigoCiudad);
        if (isset($telefono))
          $this->gDatRec->setDTelRec($telefono);
        if (isset($celular))
          $this->gDatRec->setDCelRec($celular);
        if (isset($email))
          $this->gDatRec->setDEmailRec($email);
        if (isset($codigoDeCliente))
          $this->gDatRec->setDCodCliente($codigoDeCliente);
      }
    }
    return $this;
  }

  /////////////////////////////////////////////////////////////////
  // END - Datos del receptor
  /////////////////////////////////////////////////////////////////



  /**
   * Establece los datos complementarios de uso específico para el sector de energía eléctrica.
   * 
   * @param String $nroMedidor número de medidor
   * @param int $codActividad código de actividad
   * @param String $codCategoria código de categoría
   * @param String $lecturaAnterior lectura anterior
   * @param String $lecturaActual lectura actual
   * @param String $consumoKwh consumo en Kwh
   * 
   * @return self
   */
  public function setDatosComplementariosSectorEnergia(
    String $nroMedidor,
    int $codActividad,
    String $codCategoria,
    String $lecturaAnterior,
    String $lecturaActual,
    String $consumoKwh
  ): self {
    $this->gGrupEner = new GGrupEner();
    $this->gGrupEner->setDNroMed($nroMedidor);
    $this->gGrupEner->setDActiv($codActividad);
    $this->gGrupEner->setDCateg($codCategoria);
    $this->gGrupEner->setDLecAnt($lecturaAnterior);
    $this->gGrupEner->setDLecAct($lecturaActual);
    $this->gGrupEner->setDConKwh($consumoKwh);
    return $this;
  }

  /**
   * Establece los datos complementarios de uso específico para el sector de supermercados.
   * 
   * @param String $nombreCajero nombre del cajero
   * @param String $montoPagoEfectivo monto de pago en efectivo (decimal BCMath)
   * @param String $montoVuelto monto de vuelto (decimal BCMath)
   * @param String $montoDonacion monto de donación (decimal BCMath)
   * @param String $descripcionDonacion descripción de la donación
   */
  public function setDatosComplementariosSectorSupermercados(
    ?String $nombreCajero,
    ?String $montoPagoEfectivo,
    ?String $montoVuelto,
    ?String $montoDonacion,
    ?String $descripcionDonacion
  ): self {
    $this->gGrupSup = new GGrupSup();
    if (isset($nombreCajero))
      $this->gGrupSup->setDNomCaj($nombreCajero);
    if (isset($montoPagoEfectivo))
      $this->gGrupSup->setDEfectivo($montoPagoEfectivo);
    if (isset($montoVuelto))
      $this->gGrupSup->setDVuelto($montoVuelto);
    if (isset($montoDonacion))
      $this->gGrupSup->setDDonac($montoDonacion);
    if (isset($descripcionDonacion))
      $this->gGrupSup->setDDesDonac($descripcionDonacion);
    return $this;
  }

  /**
   * Establece los datos adicionales de uso comercial que hacen relación a las operaciones de carácter cíclico como ser suscripciones o contratos de facturacion periódica.
   * 
   * @param String $cicloDeFacturacion descripción del ciclo de facturación al se refiere el documento electrónico.
   * @param DateTime $fechaInicioCiclo fecha de inicio del ciclo de facturación.
   * @param DateTime $fechaFinCiclo fecha de fin del ciclo de facturación.
   * @param DateTime $fechaVencimiento fecha de vencimiento para el pago de la factura.
   * @param String $numeroContrato número de contrato.
   * @param String $saldoAnteriorAdeudado saldo anterior adeudado.
   */
  public function setDatosAdicionalesDeUsoComercial(
    ?String $cicloDeFacturacion,
    ?DateTime $fechaInicioCiclo,
    ?DateTime $fechaFinCiclo,
    ?DateTime $fechaVencimiento,
    ?String $numeroContrato,
    ?String $saldoAnteriorAdeudado
  ): self {
    $this->gGrupAdi = new GGrupAdi();
    if (isset($cicloDeFacturacion))
      $this->gGrupAdi->setDCiclo($cicloDeFacturacion);
    if (isset($fechaInicioCiclo))
      $this->gGrupAdi->setDFecIniC($fechaInicioCiclo);
    if (isset($fechaFinCiclo))
      $this->gGrupAdi->setDFecFinC($fechaFinCiclo);
    if (isset($fechaVencimiento))
      $this->gGrupAdi->setDVencPag($fechaVencimiento);
    if (isset($numeroContrato))
      $this->gGrupAdi->setDContrato($numeroContrato);
    if (isset($saldoAnteriorAdeudado))
      $this->gGrupAdi->setDSalAnt($saldoAnteriorAdeudado);
    return $this;
  }

  /**
   * Establece el número de orden de compra del documento electrónico (G002).
   * 
   * @param String $nroOrdenCompra número de orden de compra
   * 
   * @return self
   */
  public function setNroDeOrdenDeCompra(String $nroOrdenCompra): self
  {
    if(!isset($this->gCamGen))
      $this->gCamGen = new GCamGen();
    $this->gCamGen->setDOrdCompra($nroOrdenCompra);
    return $this;
  }

  /**
   * Establece el número de orden de venta del documento electrónico (G003).
   * 
   * @param String $nroOrdenVenta número de orden de venta
   * 
   * @return self
   */
  public function setNroDeOrdenDeVenta(String $nroOrdenVenta): self
  {
    if(!isset($this->gCamGen))
      $this->gCamGen = new GCamGen();
    $this->gCamGen->setDOrdVta($nroOrdenVenta);
    return $this;
  }

  /**
   * Establece el número de asiento contable del documento electrónico (G004).
   * 
   * @param String $nroAsiento número de asiento contable
   * 
   * @return self
   */
  public function setNroDeAsientoContable(String $nroAsiento): self
  {
    if(!isset($this->gCamGen))
      $this->gCamGen = new GCamGen();
    $this->gCamGen->setDAsiento($nroAsiento);
    return $this;
  }



  ///////////////////////////////////////////////////////////////////////
  // Otros
  ///////////////////////////////////////////////////////////////////////

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

  public function addDatosComplementariosSectorSegurosPoliza(
    String $codigoEmpresaSeguros,
    String $codigoPoliza,
    String $unidadTiempoVigencia,
    String $cantTiempoVigencia,
    String $numeroPoliza,
    ?DateTime $fechaInicioVigencia,
    ?DateTime $fechaFinVigencia,
    ?String $codigoInternoItem
  ): self {
    if (!isset($this->gGrupSeg)) {
      $this->gGrupSeg = new GGrupSeg();
      $this->gGrupSeg->setDCodEmpSeg($codigoEmpresaSeguros);
    } else {
      if (strcmp($this->gGrupSeg->getDCodEmpSeg(), $codigoEmpresaSeguros) != 0)
        throw new Exception("[DocumentoElectronico::addDatosComplementariosSectorSegurosPoliza] No se puede agregar una póliza de una empresa de seguros diferente a la ya agregada. Valor recibido: $codigoEmpresaSeguros");
    }
    $poliza = new GGrupPolSeg();
    $poliza->setDPoliza($codigoPoliza);
    $poliza->setDUnidVig($unidadTiempoVigencia);
    $poliza->setDVigencia($cantTiempoVigencia);
    $poliza->setDNumPoliza($numeroPoliza);
    if (isset($fechaInicioVigencia))
      $poliza->setDFecIniVig($fechaInicioVigencia);
    if (isset($fechaFinVigencia))
      $poliza->setDFecFinVig($fechaFinVigencia);
    if (isset($codigoInternoItem))
      $poliza->setDCodInt($codigoInternoItem);
    $this->gGrupSeg->addGrupPolSeg($poliza);
    return $this;
  }

  /**
   * Agrega un documento electrónico asociado a este documento electrónico.
   * 
   * @param String $cdc código de documento electrónico asociado
   * 
   * @return self
   */
  public function addDocumentoElectronicoAsociado(String $cdc): self
  {
    $gCamDEAsoc = new GCamDEAsoc();
    $gCamDEAsoc->setITipDocAso(TipDocAso::Electronico);
    $gCamDEAsoc->setDCdCDERef($cdc);
    $this->gCamDEAsoc[] = $gCamDEAsoc;
    return $this;
  }

  /**
   * Agrega un documento impreso asociado a este documento electrónico.
   * 
   * @param int $numTimbrado número de timbrado del documento impreso asociado
   * @param int $numEstablecimiento número de establecimiento del documento impreso asociado
   * @param int $numPuntoExpedicion número de punto de expedición del documento impreso asociado
   * @param int $numDocumento número de documento impreso asociado
   * @param int|TipoDocImpresoAso $tipoDocumentoImpreso tipo de documento impreso asociado
   * @param DateTime $fechaEmisionDocImpreso fecha de emisión del documento impreso asociado
   * @param String|null $numComprobanteRetencion número de comprobante de retención asociado (opcional, solo para tipo de documento impreso asociado "Comprobante de Retención")
   * @param String|null $numResolucionCreditoFiscal número de resolución de crédito fiscal asociado (opcional, solo se informa cuando D011 vale 12 - tipo de operación venta de credito fiscal)
   * 
   * @return self
   */
  public function addDocumentoImpresoAsociado(
    int $numTimbrado,
    int $numEstablecimiento,
    int $numPuntoExpedicion,
    int $numDocumento,
    int|TipoDocImpresoAso $tipoDocumentoImpreso,
    DateTime $fechaEmisionDocImpreso,
    ?String $numComprobanteRetencion = null,
    ?String $numResolucionCreditoFiscal = null
  ): self 
  {
    $gCamDIAsoc = new GCamDEAsoc();
    $gCamDIAsoc->setITipDocAso(TipDocAso::Impreso);
    $gCamDIAsoc->setDNTimDI($numTimbrado);
    $gCamDIAsoc->setDEstDocAso($numEstablecimiento);
    $gCamDIAsoc->setDPExpDocAso($numPuntoExpedicion);
    $gCamDIAsoc->setDNumDocAso($numDocumento);
    $gCamDIAsoc->setITipoDocAso($tipoDocumentoImpreso);
    $gCamDIAsoc->setDFecEmiDI($fechaEmisionDocImpreso);
    if ($numComprobanteRetencion)
      $gCamDIAsoc->setDNumComRet($numComprobanteRetencion);
    if ($numResolucionCreditoFiscal)
      $gCamDIAsoc->setDNumResCF($numResolucionCreditoFiscal);
    $this->gCamDEAsoc[] = $gCamDIAsoc;
    return $this;
  }

  public function addConstanciaDeNoSerContribuyente(
    int $numero,
    String $numControl
  ) {
    $gCamDEAsoc = new GCamDEAsoc();
    $gCamDEAsoc->setITipDocAso(TipDocAso::ConstanciaElectronica);
    $gCamDEAsoc->setITipCons(1);
    $gCamDEAsoc->setDNumCons($numero);
    $gCamDEAsoc->setDNumControl($numControl);
    $this->gCamDEAsoc[] = $gCamDEAsoc;
    return $this;
  }
}
