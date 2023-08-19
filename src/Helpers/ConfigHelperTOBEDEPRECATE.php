<?php

namespace Abiliomp\Pkuatia\Helpers;

use Abiliomp\Pkuatia\Core\Constants;

/**
 * Enum con los tipos de certificados disponibles para la conexión segura y la firma digital.
 */

enum TipoCertificadoCliente
{
  case PFX; //Un archivo con la extensión PFX indica un certificado en el formato PKCS#12;
}

/**
 * Enum con los tipos de ambientes disponibles en Sifen.
 * 
 */
enum TipoAmbiente
{
  case DEV; ///DESAROLLO
  case PROD; ///PRODUCCION
}

/**
 * Clase que genera y valida la firma digital de los documentos XML para el SIFEN.
 */
class SignatureHelper
{
  //Constantes
  const SIFEN_AMBIENTE_KEY = "sifen.ambiente";
  const SIFEN_URL_BASE_KEY = "sifen.url_base";
  const SIFEN_USAR_CERTIFICADO_CLIENTE_KEY = "sifen.certificado_cliente.usar";
  const SIFEN_TIPO_CERTIFICADO_CLIENTE_KEY = "sifen.certificado_cliente.tipo";
  const SIFEN_ARCHIVO_CERTIFICADO_CLIENTE_KEY = "sifen.certificado_cliente.archivo";
  const SIFEN_PASSWORD_CERTIFICADO_CLIENTE_KEY = "sifen.certificado_cliente.contrasena";
  const SIFEN_ID_CSC_KEY = "sifen.csc.id";
  const SIFEN_CSC_KEY = "sifen.csc";

  /* ambiente (TipoAmbiente): Tipo de ambiente a utilizar (desarrollo o producción).
   * Dependiendo de esto se definen las urls a utilizar*/
  private TipoAmbiente $ambiente;

  /*  $urlBase (String): URL a la que se hará la petición.
   *  Hay una para cada tipo de ambiente. Se puede sobreescribir.
   */
  private String $urlBase;
  private String $urlBaseLocal;
  private String $urlConsultaQr;

  /* pathRecibe, pathRecibeLote, pathEvento, 
   * pathConsultaLote, pathConsultaRUC, patchConsulta (String):
   * path para las peticiones específicas. 
   * Tienen valores por defecto (obtenidos del MT), pero pueden ser sobreescritas.
   */
  private String $pathRecibe;
  private String $pathRecibeLote;
  private String $pathEvento;
  private String $pathConsultaLote;
  private String $pathConsultaRUC;
  private String $pathConsulta;

  /* usarCertificadoCliente (bool): 
   * Define si se utiliza o no el certificado proporcionado para la
   * autenticación y firma de las peticiones.
   * Se recomienda utilizar el valor por defecto (true), pero es posible sobreescribirlo en caso de estar
   * realizando a otro nivel la autenticación por certificado (Ej.: Forward Proxy).</li>
   */
  private bool $usarCertidicadoCliente;

  /*tipoCertificadoCliente (TipoCertificadoCliente): Tipo de archivo del certificado. 
  Solo PFX es soportado actualmente */
  private TipoCertificadoCliente $tipoCertificadoCliente;

  /* certificadoCliente, contrasenaCertificadoCliente (String): Certificado a utilizar (ruta del archivo o
   *  archivo codificado en Base64), junto a la contraseña. */
  private String $certificadoCliente;
  private String $contrasenaCertificadoCliente;

  private String $idCSC;
  private String $CSC;

  private int $httpConnectTimeout;
  private int $httpReadTimeout;
  private String $userAgent;

  //////////////////////////////////////////////////////////////////
  ///Constructores
  //////////////////////////////////////////////////////////////////
  public function __construct()
  {
    $this->ambiente = TipoAmbiente::DEV;
    $this->urlBaseLocal = Constants::SIFEN_URL_BASE_DEV;
    $this->urlConsultaQr = Constants::SIFEN_URL_CONSULTA_QR_DEV;

    $this->pathRecibe = Constants::SIFEN_PATH_RECIBE;
    $this->pathRecibeLote = Constants::SIFEN_PATH_RECIBE_LOTE;
    $this->pathEvento = Constants::SIFEN_PATH_EVENTO;
    $this->pathConsultaLote = Constants::SIFEN_PATH_CONSULTA_LOTE;
    $this->pathConsultaRUC = Constants::SIFEN_PATH_CONSULTA_RUC;
    $this->pathConsulta = Constants::SIFEN_PATH_CONSULTA;
    $this->usarCertidicadoCliente = true;

    $this->idCSC = "0002";
    $this->CSC = "EFGH0000000000000000000000000000";

    $this->httpConnectTimeout = 15 * 1000; //15 segundos
    $this->httpReadTimeout = 45 * 100; //45 segundos

    $this->userAgent = "pkuatia" + "/" + Constants::PKUATIA_VERSION + " (LVEA)";
  }

  public function __construct2(
    TipoAmbiente $tipoAmbiente,
    TipoCertificadoCliente $tipoCertificadoCliente,
    String $certificadoCliente,
    String $contraseñaCliente
  ) {
    $this->__construct();
    $this->setAmbiente($tipoAmbiente);

    $this->setUsarCertidicadoCliente(true);
    $this->setCertificadoCliente($certificadoCliente);
    $this->setContrasenaCertificadoCliente($contraseñaCliente);
    $this->setTipoCertificadoCliente($tipoCertificadoCliente);
  }

  public function __construct3(
    TipoAmbiente $tipoAmbiente,
    String $idCSC,
    String $CSC,
    TipoCertificadoCliente $tipoCertificadoCliente,
    String $certificadoCliente,
    String $contraseCertificadoCliente
  ) {
    $this->__construct2($tipoAmbiente, $tipoCertificadoCliente, $certificadoCliente, $contraseCertificadoCliente);
    $this->setIdCSC($idCSC);
    $this->setCSC($CSC);
  }


  //////////////////////////////////////////////////////////////////
  ///SETTERS
  //////////////////////////////////////////////////////////////////
  /**
   * Set the value of ambiente
   *
   * @param TipoAmbiente $ambiente
   *
   * @return self
   */
  public function setAmbiente(TipoAmbiente $ambiente): self
  {
    $this->ambiente = $ambiente;

    if ($this->ambiente == TipoAmbiente::DEV) {
      $this->urlBaseLocal =  Constants::SIFEN_URL_BASE_DEV;
      $this->urlConsultaQr = Constants::SIFEN_URL_CONSULTA_QR_DEV;
    } else if ($this->ambiente == TipoAmbiente::PROD) {
      $this->urlBaseLocal =  Constants::SIFEN_URL_BASE_PROD;
      $this->urlConsultaQr = Constants::SIFEN_URL_CONSULTA_QR_PROD;
    }

    return $this;
  }


  /**
   * Set the value of urlBase
   *
   * @param String $urlBase
   *
   * @return self
   */
  public function setUrlBase(String $urlBase): self
  {
    $this->urlBase = $urlBase;

    return $this;
  }


  /**
   * Set the value of urlBaseLocal
   *
   * @param String $urlBaseLocal
   *
   * @return self
   */
  public function setUrlBaseLocal(String $urlBaseLocal): self
  {
    $this->urlBaseLocal = $urlBaseLocal;

    return $this;
  }


  /**
   * Set the value of urlConsultaQr
   *
   * @param String $urlConsultaQr
   *
   * @return self
   */
  public function setUrlConsultaQr(String $urlConsultaQr): self
  {
    $this->urlConsultaQr = $urlConsultaQr;

    return $this;
  }


  /**
   * Set the value of pathRecibe
   *
   * @param String $pathRecibe
   *
   * @return self
   */
  public function setPathRecibe(String $pathRecibe): self
  {
    $this->pathRecibe = $pathRecibe;

    return $this;
  }


  /**
   * Set the value of pathRecibeLote
   *
   * @param String $pathRecibeLote
   *
   * @return self
   */
  public function setPathRecibeLote(String $pathRecibeLote): self
  {
    $this->pathRecibeLote = $pathRecibeLote;

    return $this;
  }


  /**
   * Set the value of pathEvento
   *
   * @param String $pathEvento
   *
   * @return self
   */
  public function setPathEvento(String $pathEvento): self
  {
    $this->pathEvento = $pathEvento;

    return $this;
  }


  /**
   * Set the value of pathConsultaLote
   *
   * @param String $pathConsultaLote
   *
   * @return self
   */
  public function setPathConsultaLote(String $pathConsultaLote): self
  {
    $this->pathConsultaLote = $pathConsultaLote;

    return $this;
  }


  /**
   * Set the value of pathConsultaRUC
   *
   * @param String $pathConsultaRUC
   *
   * @return self
   */
  public function setPathConsultaRUC(String $pathConsultaRUC): self
  {
    $this->pathConsultaRUC = $pathConsultaRUC;

    return $this;
  }


  /**
   * Set the value of pathConsulta
   *
   * @param String $pathConsulta
   *
   * @return self
   */
  public function setPathConsulta(String $pathConsulta): self
  {
    $this->pathConsulta = $pathConsulta;

    return $this;
  }


  /**
   * Set the value of usarCertidicadoCliente
   *
   * @param bool $usarCertidicadoCliente
   *
   * @return self
   */
  public function setUsarCertidicadoCliente(bool $usarCertidicadoCliente): self
  {
    $this->usarCertidicadoCliente = $usarCertidicadoCliente;

    return $this;
  }


  /**
   * Set the value of tipoCertificadoCliente
   *
   * @param TipoCertificadoCliente $tipoCertificadoCliente
   *
   * @return self
   */
  public function setTipoCertificadoCliente(TipoCertificadoCliente $tipoCertificadoCliente): self
  {
    $this->tipoCertificadoCliente = $tipoCertificadoCliente;

    return $this;
  }


  /**
   * Set the value of contrasenaCertificadoCliente
   *
   * @param String $contrasenaCertificadoCliente
   *
   * @return self
   */
  public function setContrasenaCertificadoCliente(String $contrasenaCertificadoCliente): self
  {
    $this->contrasenaCertificadoCliente = $contrasenaCertificadoCliente;

    return $this;
  }


  /**
   * Set the value of idCSC
   *
   * @param String $idCSC
   *
   * @return self
   */
  public function setIdCSC(String $idCSC): self
  {
    $this->idCSC = str_pad($idCSC, '0', 4, STR_PAD_LEFT);

    return $this;
  }


  /**
   * Set the value of CSC
   *
   * @param String $CSC
   *
   * @return self
   */
  public function setCSC(String $CSC): self
  {
    $this->CSC = $CSC;

    return $this;
  }


  /**
   * Set the value of httpConnectTimeout
   *
   * @param int $httpConnectTimeout
   *
   * @return self
   */
  public function setHttpConnectTimeout(int $httpConnectTimeout): self
  {
    $this->httpConnectTimeout = $httpConnectTimeout;

    return $this;
  }


  /**
   * Set the value of httpReadTimeout
   *
   * @param int $httpReadTimeout
   *
   * @return self
   */
  public function setHttpReadTimeout(int $httpReadTimeout): self
  {
    $this->httpReadTimeout = $httpReadTimeout;

    return $this;
  }


  /**
   * Set the value of userAgent
   *
   * @param String $userAgent
   *
   * @return self
   */
  public function setUserAgent(String $userAgent): self
  {
    $this->userAgent = $userAgent;

    return $this;
  }


  /**
   * Set the value of certificadoCliente
   *
   * @param String $certificadoCliente
   *
   * @return self
   */
  public function setCertificadoCliente(String $certificadoCliente): self
  {
    $this->certificadoCliente = $certificadoCliente;

    return $this;
  }

  //////////////////////////////////////////////////////////////////
  ///GETTERS
  //////////////////////////////////////////////////////////////////

  /**
   * Get the value of ambiente
   *
   * @return TipoAmbiente
   */
  public function getAmbiente(): TipoAmbiente
  {
    return $this->ambiente;
  }

  /**
   * Get the value of urlBase
   *
   * @return String
   */
  public function getUrlBase(): String
  {
    return $this->urlBase;
  }

  /**
   * Get the value of urlBaseLocal
   *
   * @return String
   */
  public function getUrlBaseLocal(): String
  {
    return $this->urlBaseLocal;
  }

  /**
   * Get the value of urlConsultaQr
   *
   * @return String
   */
  public function getUrlConsultaQr(): String
  {
    return $this->urlConsultaQr;
  }

  /**
   * Get the value of pathRecibe
   *
   * @return String
   */
  public function getPathRecibe(): String
  {
    return $this->pathRecibe;
  }

  /**
   * Get the value of pathRecibeLote
   *
   * @return String
   */
  public function getPathRecibeLote(): String
  {
    return $this->pathRecibeLote;
  }

  /**
   * Get the value of pathEvento
   *
   * @return String
   */
  public function getPathEvento(): String
  {
    return $this->pathEvento;
  }

  /**
   * Get the value of pathConsultaLote
   *
   * @return String
   */
  public function getPathConsultaLote(): String
  {
    return $this->pathConsultaLote;
  }

  /**
   * Get the value of pathConsultaRUC
   *
   * @return String
   */
  public function getPathConsultaRUC(): String
  {
    return $this->pathConsultaRUC;
  }

  /**
   * Get the value of pathConsulta
   *
   * @return String
   */
  public function getPathConsulta(): String
  {
    return $this->pathConsulta;
  }

  /**
   * Get the value of usarCertidicadoCliente
   *
   * @return bool
   */
  public function getUsarCertidicadoCliente(): bool
  {
    return $this->usarCertidicadoCliente;
  }

  /**
   * Get the value of tipoCertificadoCliente
   *
   * @return TipoCertificadoCliente
   */
  public function getTipoCertificadoCliente(): TipoCertificadoCliente
  {
    return $this->tipoCertificadoCliente;
  }

  /**
   * Get the value of contrasenaCertificadoCliente
   *
   * @return String
   */
  public function getContrasenaCertificadoCliente(): String
  {
    return $this->contrasenaCertificadoCliente;
  }

  /**
   * Get the value of idCSC
   *
   * @return String
   */
  public function getIdCSC(): String
  {
    return $this->idCSC;
  }

  /**
   * Get the value of CSC
   *
   * @return String
   */
  public function getCSC(): String
  {
    return $this->CSC;
  }

  /**
   * Get the value of httpConnectTimeout
   *
   * @return int
   */
  public function getHttpConnectTimeout(): int
  {
    return $this->httpConnectTimeout;
  }

  /**
   * Get the value of httpReadTimeout
   *
   * @return int
   */
  public function getHttpReadTimeout(): int
  {
    return $this->httpReadTimeout;
  }

  /**
   * Get the value of userAgent
   *
   * @return String
   */
  public function getUserAgent(): String
  {
    return $this->userAgent;
  }

  /**
   * Get the value of certificadoCliente
   *
   * @return String
   */
  public function getCertificadoCliente(): String
  {
    return $this->certificadoCliente;
  }

  //////////////////////////////////////////////////////////////////
  ///SIGNATURE
  //////////////////////////////////////////////////////////////////  
  /**
   * La función de esto es obtener un archivo de una ruta y así pasar las propiedades
   * de este a la clase SignatureHelper
   *
   * @param  mixed $ruta
   * @return SignatureHelper
   */
  public static function cargarConf(String $ruta): SignatureHelper
  {
    $ruta = realpath($ruta);

    if (!file_exists($ruta)) {
      throw new \Exception("Ruta no existe: " . $ruta);
    } else {
      $archive = basename($ruta);
      $ini_array = parse_ini_file($archive);

      $signature = new SignatureHelper();
      if (isset($ini_array[SignatureHelper::SIFEN_AMBIENTE_KEY])) {
        $signature->setAmbiente($ini_array[SignatureHelper::SIFEN_AMBIENTE_KEY]);
      } else {
        throw new \Exception("El tipo de ambiente especificado no existe.");
      }

      if (isset($ini_array[SignatureHelper::SIFEN_URL_BASE_KEY])) {
        $signature->setUrlBase($ini_array[SignatureHelper::SIFEN_URL_BASE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_USAR_CERTIFICADO_CLIENTE_KEY])) {

        $signature->setUsarCertidicadoCliente((bool) json_decode(strtolower($ini_array[SignatureHelper::SIFEN_USAR_CERTIFICADO_CLIENTE_KEY])));
      }

      if (isset($ini_array[SignatureHelper::SIFEN_TIPO_CERTIFICADO_CLIENTE_KEY])) {
        $signature->setTipoCertificadoCliente($ini_array[SignatureHelper::SIFEN_TIPO_CERTIFICADO_CLIENTE_KEY]);
      } else {
        throw new \Exception("El tipo de certificado especificado no existe.");
      }

      if (isset($ini_array[SignatureHelper::SIFEN_ARCHIVO_CERTIFICADO_CLIENTE_KEY])) {
        $signature->setCertificadoCliente($ini_array[SignatureHelper::SIFEN_ARCHIVO_CERTIFICADO_CLIENTE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_PASSWORD_CERTIFICADO_CLIENTE_KEY])) {

        $signature->setContrasenaCertificadoCliente($ini_array[SignatureHelper::SIFEN_PASSWORD_CERTIFICADO_CLIENTE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_CSC_KEY]))
        $signature->setCSC($ini_array[SignatureHelper::SIFEN_CSC_KEY]); {
      }

      if (isset($ini_array[SignatureHelper::SIFEN_ID_CSC_KEY])) {
        $signature->setIdCSC($ini_array[SignatureHelper::SIFEN_ID_CSC_KEY]);
      }
      return $signature;
    }
  }

  /**
   * toString
   *
   * @return String
   */
  public function toString(): String
  {
    return "SignatureHelper{" .
      "ambiente=" . $this->ambiente .
      ", urlBase='" . $this->urlBase . '\'' .
      ", urlBaseLocal='" . $this->urlBaseLocal . '\'' .
      ", urlConsultaQr='" . $this->urlConsultaQr . '\'' .
      ", pathRecibe='" . $this->pathRecibe . '\'' .
      ", pathRecibeLote='" . $this->pathRecibeLote . '\'' .
      ", pathEvento='" . $this->pathEvento . '\'' .
      ", pathConsultaLote='" . $this->pathConsultaLote . '\'' .
      ", pathConsultaRUC='" . $this->pathConsultaRUC . '\'' .
      ", pathConsulta='" . $this->pathConsulta . '\'' .
      ", usarCertificadoCliente=" . $this->usarCertidicadoCliente .
      ", tipoCertificadoCliente=" . $this->tipoCertificadoCliente .
      ", certificadoCliente='" . $this->certificadoCliente . '\'' .
      ", contrasenaCertificadoCliente='" . $this->contrasenaCertificadoCliente . '\'' .
      ", idCSC='" . $this->idCSC . '\'' .
      ", CSC='" . $this->CSC . '\'' .
      ", httpConnectTimeout=" . $this->httpConnectTimeout .
      ", httpReadTimeout=" . $this->httpReadTimeout .
      ", userAgent='" . $this->userAgent . '\'' .
      ", URL_BASE_DEV='" . Constants::SIFEN_URL_BASE_DEV . '\'' .
      ", URL_BASE_PROD='" . Constants::SIFEN_URL_BASE_PROD . '\'' .
      ", URL_CONSULTA_QR_DEV='" . Constants::SIFEN_URL_CONSULTA_QR_DEV . '\'' .
      ", URL_CONSULTA_QR_PROD='" . Constants::SIFEN_URL_CONSULTA_QR_PROD . '\'' .
      '}';
  }
}
