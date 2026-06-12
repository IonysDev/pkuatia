<?php

namespace IonysDev\Pkuatia\Core;

use IonysDev\Pkuatia\Helpers\PemHelper;

/**
 * Clase que contiene los parámetros de la instancia del SIFEN utilizada.
 */
class Config
{  
    public const ENV_DEV = "dev";
    public const ENV_PROD = "prod";

    public const CERT_FORMAT_PEM = "pem";
    public const CERT_FORMAT_PKCS12 = "pkcs12";

    public String $env = self::ENV_DEV; // Solo se aceptan valores "dev" para entorno en desarrollo y "prod" para entorno en producción.

    // Parámetros de Firma Digital
    public String $certificateFormat;    // Valores de entrada: "pem", "p12" o "pfx". Se normaliza internamente a "pem" o "pkcs12".
    public ?String $certificateFilePath = null; // Ruta del certificado PEM. Opcional si cert y clave están en privateKeyFilePath.
    public String $privateKeyFilePath;         // Ruta de la clave privada, o del archivo PEM/P12/PFX combinado.
    public String $privateKeyPassphrase; // Contraseña de la clave privada.

    // Parámetros de autenticación ante el SIFEN
    public String $idCsc = '0001'; // Identificador de la CSC entregado por el SIFEN.
    public String $csc   = 'ABCD0000000000000000000000000000';   // Código de seguridad de 32 dígitos alfanúmericos entregado por el SIFEN.

    // Lugar donde se almacena el archivo JSON que contiene el registro del último valor del dId utilizado.
    public String $dIdFilePath = "PKuatiaDId.dat.json";

    // Habilita la caché en disco de los WSDL del SIFEN (WSDL_CACHE_DISK de la extensión SOAP).
    // Recomendado en producción: el SIFEN limita la tasa de solicitudes y descargar el WSDL en cada
    // operación puede provocar bloqueos temporales. Por defecto deshabilitado (comportamiento histórico).
    public bool $wsdlCacheEnabled = false;

    /**
     * Normaliza el formato de certificado a un valor interno soportado.
     * Acepta "pem", "p12" y "pfx" (P12 y PFX son PKCS#12). Es idempotente: admite también los
     * valores internos ya normalizados ("pem", "pkcs12"), de modo que normalizar dos veces no falle.
     *
     * @throws \Exception
     */
    public static function normalizeCertificateFormat(string $format): string
    {
        $format = strtolower($format);
        if ($format === self::CERT_FORMAT_PEM) {
            return self::CERT_FORMAT_PEM;
        }
        if (in_array($format, ['p12', 'pfx', self::CERT_FORMAT_PKCS12], true)) {
            return self::CERT_FORMAT_PKCS12;
        }
        throw new \Exception(
            "[Config] Formato de certificado no soportado: $format. Valores aceptados: pem, p12, pfx."
        );
    }

    public function isPem(): bool
    {
        return self::normalizeCertificateFormat($this->certificateFormat) === self::CERT_FORMAT_PEM;
    }

    public function isPkcs12(): bool
    {
        return self::normalizeCertificateFormat($this->certificateFormat) === self::CERT_FORMAT_PKCS12;
    }

    /**
     * Certificado y clave en un solo archivo (PEM combinado o PKCS#12).
     */
    public function usesCombinedCertificateFile(): bool
    {
        if ($this->isPkcs12()) {
            return true;
        }

        return PemHelper::usesCombinedFile(
            $this->certificateFilePath,
            $this->privateKeyFilePath
        );
    }

    public static function ParseObject($config): Config {
        $res = new Config();
        
        if(is_null($config)) {
            throw new \Exception("Objeto de configuración no puede ser nulo.");
        }
        
        if(isset($config->env)) {
            $res->env = $config->env;
        }        
        
        if(isset($config->certificateFormat)) {
            $res->setCertificateFormat($config->certificateFormat);
        }

        if(isset($config->certificateFilePath)) {
            $res->certificateFilePath = $config->certificateFilePath;
        }

        if(!isset($config->privateKeyFilePath)) {
            throw new \Exception("Ruta del archivo de la clave privada debe ser especificada.");
        }
        $res->privateKeyFilePath = $config->privateKeyFilePath;

        if(!isset($config->privateKeyPassphrase)) {
            throw new \Exception("Contraseña de la clave privada debe ser especificada.");
        }
        $res->privateKeyPassphrase = $config->privateKeyPassphrase;

        if(isset($config->idCsc)) {
            $res->idCsc = $config->idCsc;
        }
        
        if(isset($config->csc)) {
            $res->csc = $config->csc;
        }

        if(isset($config->dIdFilePath)) {
            $res->dIdFilePath = $config->dIdFilePath;
        }

        if(isset($config->wsdlCacheEnabled)) {
            $res->wsdlCacheEnabled = boolval($config->wsdlCacheEnabled);
        }

        return $res;
    }

    public static function ParseJsonFile(String $jsonConfigFilePath) {
        $config = json_decode(file_get_contents($jsonConfigFilePath));
        return self::ParseObject($config);
    }

    public static function ParseJson(String $jsonConfig) {
        $obj = json_decode($jsonConfig);
        return self::ParseObject($obj);
    }

    // Setters

    /**
     * Establece el valor de env
     *
     * @param String $env
     *
     * @return self
     */
    public function setEnv(String $env): self
    {
        $this->env = $env;

        return $this;
    }

    /**
     * Establece el valor de certificateFormat
     *
     * @param String $certificateFormat
     *
     * @return self
     */
    public function setCertificateFormat(String $certificateFormat): self
    {
        $this->certificateFormat = self::normalizeCertificateFormat($certificateFormat);

        return $this;
    }

    /**
     * Establece el valor de certificateFilePath
     *
     * @param String $certificateFilePath
     *
     * @return self
     */
    public function setCertificateFilePath(String $certificateFilePath): self
    {
        $this->certificateFilePath = $certificateFilePath;

        return $this;
    }

    /**
     * Establece el valor de privateKeyFilePath
     *
     * @param String $privateKeyFilePath
     *
     * @return self
     */
    public function setPrivateKeyFilePath(String $privateKeyFilePath): self
    {
        $this->privateKeyFilePath = $privateKeyFilePath;

        return $this;
    }

    /**
     * Establece el valor de privateKeyPassphrase
     *
     * @param String $privateKeyPassphrase
     *
     * @return self
     */
    public function setPrivateKeyPassphrase(String $privateKeyPassphrase): self
    {
        $this->privateKeyPassphrase = $privateKeyPassphrase;

        return $this;
    }

    /**
     * Establece el valor de idCsc
     *
     * @param String $idCsc
     *
     * @return self
     */
    public function setIdCsc(String $idCsc): self
    {
        $this->idCsc = $idCsc;

        return $this;
    }

    /**
     * Establece el valor de csc
     *
     * @param String $csc
     *
     * @return self
     */
    public function setCsc(String $csc): self
    {
        $this->csc = $csc;

        return $this;
    }

    /**
     * Establece el valor de dIdFilePath
     *
     * @param String $dIdFilePath
     *
     * @return self
     */
    public function setDIdFilePath(String $dIdFilePath): self
    {
        $this->dIdFilePath = $dIdFilePath;

        return $this;
    }

    /**
     * Habilita o deshabilita la caché en disco de los WSDL del SIFEN.
     * Recomendado en producción para evitar bloqueos por saturación del WS.
     *
     * @param bool $wsdlCacheEnabled
     *
     * @return self
     */
    public function setWsdlCacheEnabled(bool $wsdlCacheEnabled): self
    {
        $this->wsdlCacheEnabled = $wsdlCacheEnabled;

        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve el valor de IdCDC
     * 
     * @return String
     */
    public function getIdCsc(): String
    {
        return $this->idCsc;
    }

    /**
     * Devuelve el valor de env (entorno)
     * 
     * @return String
     */
    public function getEnv(): String
    {
        return $this->env;
    }

    /**
     * Devuelve el valor del CSC (clave secreta de comunicación)
     * 
     * @return String
     */
    public function getCsc(): String
    {
        return $this->csc;
    }
    

}
