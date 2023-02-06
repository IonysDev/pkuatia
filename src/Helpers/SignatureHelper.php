<?php

namespace Abiliomp\Pkuatia\Helpers;

use Abiliomp\Pkuatia\Constants;

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

  /*  $urlBase (string): URL a la que se hará la petición.
   *  Hay una para cada tipo de ambiente. Se puede sobreescribir.
  */
  private string $urlBase;
  private string $urlBaseLocal;
  private string $urlConsultaQr;

  /* pathRecibe, pathRecibeLote, pathEvento, 
  * pathConsultaLote, pathConsultaRUC, patchConsulta (String):
  * path para las peticiones específicas. 
  * Tienen valores por defecto (obtenidos del MT), pero pueden ser sobreescritas.
  */
  private string $pathRecibe;
  private string $pathRecibeLote;
  private string $pathEvento;
  private string $pathConsultaLote;
  private string $pathConsultaRUC;
  private string $pathConsulta;

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
  private string $contrasenaCertificadoCliente;

  private string $idCSC;
  private string $CSC;

  private int $httpConnectTimeout;
  private int $httpReadTimeout;
  private string $userAgent;

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

    $this->idCSC = "002";
    $this->CSC = "EFGH0000000000000000000000000000";

    $this->httpConnectTimeout = 15 * 1000; //15 segundos
    $this->httpReadTimeout = 45 * 100; //45 segundos

    $this->userAgent = "No sé";
  }

  public function __construct2(
    TipoAmbiente $tipoAmbiente,
    TipoCertificadoCliente $tipoCertificadoCliente,
    string $certificadoCliente,
    string $contraseñaCliente
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
    string $idCSC,
    string $CSC,
    TipoCertificadoCliente $tipoCertificadoCliente,
    string $certificadoCliente,
    string $contraseCertificadoCliente
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

    return $this;
  }


  /**
   * Set the value of urlBase
   *
   * @param string $urlBase
   *
   * @return self
   */
  public function setUrlBase(string $urlBase): self
  {
    $this->urlBase = $urlBase;

    return $this;
  }


  /**
   * Set the value of urlBaseLocal
   *
   * @param string $urlBaseLocal
   *
   * @return self
   */
  public function setUrlBaseLocal(string $urlBaseLocal): self
  {
    $this->urlBaseLocal = $urlBaseLocal;

    return $this;
  }


  /**
   * Set the value of urlConsultaQr
   *
   * @param string $urlConsultaQr
   *
   * @return self
   */
  public function setUrlConsultaQr(string $urlConsultaQr): self
  {
    $this->urlConsultaQr = $urlConsultaQr;

    return $this;
  }


  /**
   * Set the value of pathRecibe
   *
   * @param string $pathRecibe
   *
   * @return self
   */
  public function setPathRecibe(string $pathRecibe): self
  {
    $this->pathRecibe = $pathRecibe;

    return $this;
  }


  /**
   * Set the value of pathRecibeLote
   *
   * @param string $pathRecibeLote
   *
   * @return self
   */
  public function setPathRecibeLote(string $pathRecibeLote): self
  {
    $this->pathRecibeLote = $pathRecibeLote;

    return $this;
  }


  /**
   * Set the value of pathEvento
   *
   * @param string $pathEvento
   *
   * @return self
   */
  public function setPathEvento(string $pathEvento): self
  {
    $this->pathEvento = $pathEvento;

    return $this;
  }


  /**
   * Set the value of pathConsultaLote
   *
   * @param string $pathConsultaLote
   *
   * @return self
   */
  public function setPathConsultaLote(string $pathConsultaLote): self
  {
    $this->pathConsultaLote = $pathConsultaLote;

    return $this;
  }


  /**
   * Set the value of pathConsultaRUC
   *
   * @param string $pathConsultaRUC
   *
   * @return self
   */
  public function setPathConsultaRUC(string $pathConsultaRUC): self
  {
    $this->pathConsultaRUC = $pathConsultaRUC;

    return $this;
  }


  /**
   * Set the value of pathConsulta
   *
   * @param string $pathConsulta
   *
   * @return self
   */
  public function setPathConsulta(string $pathConsulta): self
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
   * @param string $contrasenaCertificadoCliente
   *
   * @return self
   */
  public function setContrasenaCertificadoCliente(string $contrasenaCertificadoCliente): self
  {
    $this->contrasenaCertificadoCliente = $contrasenaCertificadoCliente;

    return $this;
  }


  /**
   * Set the value of idCSC
   *
   * @param string $idCSC
   *
   * @return self
   */
  public function setIdCSC(string $idCSC): self
  {
    $this->idCSC = $idCSC;

    return $this;
  }


  /**
   * Set the value of CSC
   *
   * @param string $CSC
   *
   * @return self
   */
  public function setCSC(string $CSC): self
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
   * @param string $userAgent
   *
   * @return self
   */
  public function setUserAgent(string $userAgent): self
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
   * @return string
   */
  public function getUrlBase(): string
  {
    return $this->urlBase;
  }

  /**
   * Get the value of urlBaseLocal
   *
   * @return string
   */
  public function getUrlBaseLocal(): string
  {
    return $this->urlBaseLocal;
  }

  /**
   * Get the value of urlConsultaQr
   *
   * @return string
   */
  public function getUrlConsultaQr(): string
  {
    return $this->urlConsultaQr;
  }

  /**
   * Get the value of pathRecibe
   *
   * @return string
   */
  public function getPathRecibe(): string
  {
    return $this->pathRecibe;
  }

  /**
   * Get the value of pathRecibeLote
   *
   * @return string
   */
  public function getPathRecibeLote(): string
  {
    return $this->pathRecibeLote;
  }

  /**
   * Get the value of pathEvento
   *
   * @return string
   */
  public function getPathEvento(): string
  {
    return $this->pathEvento;
  }

  /**
   * Get the value of pathConsultaLote
   *
   * @return string
   */
  public function getPathConsultaLote(): string
  {
    return $this->pathConsultaLote;
  }

  /**
   * Get the value of pathConsultaRUC
   *
   * @return string
   */
  public function getPathConsultaRUC(): string
  {
    return $this->pathConsultaRUC;
  }

  /**
   * Get the value of pathConsulta
   *
   * @return string
   */
  public function getPathConsulta(): string
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
   * @return string
   */
  public function getContrasenaCertificadoCliente(): string
  {
    return $this->contrasenaCertificadoCliente;
  }

  /**
   * Get the value of idCSC
   *
   * @return string
   */
  public function getIdCSC(): string
  {
    return $this->idCSC;
  }

  /**
   * Get the value of CSC
   *
   * @return string
   */
  public function getCSC(): string
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
   * @return string
   */
  public function getUserAgent(): string
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
   * cargarConf, carga los datos desde una ruta y los pasa a al signatureHelper
   *
   * @param  mixed $ruta
   * @return SignatureHelper
   */
  public static function cargarConf(string $ruta): SignatureHelper
  {
    $ruta = realpath($ruta);

    if (!file_exists($ruta)) {
      throw new \Exception("Ruta no existe:" . $ruta);
    } else {
      $archive = basename($ruta);
      $ini_array = parse_ini_file($archive);

      $signature = new SignatureHelper();
      if (isset($ini_array[SignatureHelper::SIFEN_AMBIENTE_KEY])) {
        $signature->setAmbiente($ini_array[SignatureHelper::SIFEN_AMBIENTE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_URL_BASE_KEY])) {
        $signature->setUrlBase($ini_array[SignatureHelper::SIFEN_URL_BASE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_USAR_CERTIFICADO_CLIENTE_KEY])) {
        $signature->setCertificadoCliente($ini_array[SignatureHelper::SIFEN_USAR_CERTIFICADO_CLIENTE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_TIPO_CERTIFICADO_CLIENTE_KEY])) {
        $signature->setTipoCertificadoCliente($ini_array[SignatureHelper::SIFEN_TIPO_CERTIFICADO_CLIENTE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_ARCHIVO_CERTIFICADO_CLIENTE_KEY])) {
        $signature->setCertificadoCliente($ini_array[SignatureHelper::SIFEN_ARCHIVO_CERTIFICADO_CLIENTE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_PASSWORD_CERTIFICADO_CLIENTE_KEY])) {

        $signature->setContrasenaCertificadoCliente($ini_array[SignatureHelper::SIFEN_PASSWORD_CERTIFICADO_CLIENTE_KEY]);
      }

      if (isset($ini_array[SignatureHelper::SIFEN_CSC_KEY]))
        $signature->setCSC($ini_array[SignatureHelper::SIFEN_CSC_KEY]); {

        if (isset($ini_array[SignatureHelper::SIFEN_ID_CSC_KEY])) {
          $signature->setIdCSC($ini_array[SignatureHelper::SIFEN_ID_CSC_KEY]);
        }
        return $signature;
      }
    }
  }

  /**
   * toString
   *
   * @return string
   */
  public function toString(): string
  {
    return "SifenConfig{" .
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
