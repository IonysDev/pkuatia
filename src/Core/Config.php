<?php

namespace Abiliomp\Pkuatia\Core;


/**
 * Clase que contiene los parámetros de la instancia del SIFEN utilizada.
 */
class Config
{  
    public const ENV_DEV = "dev";
    public const ENV_PROD = "prod";

    public String $env = self::ENV_DEV; // Solo se aceptan valores "dev" para entorno en desarrollo y "prod" para entorno en producción.

    // Parámetros de Firma Digital
    public String $certificateFormat = "pem";   // Solo se aceptan valores "pfx", "pem" o "der".
    public String $certificateFilePath;         // Ruta del archivo del certificado.
    public String $privateKeyFilePath;          // Ruta del archivo de la clave privada.
    public String $privateKeyPassphrase;        // Contraseña de la clave privada.

    // Parámetros de autenticación ante el SIFEN
    public String $idCsc = '0001'; // Identificador de la CSC entregado por el SIFEN.
    public String $csc = 'ABCD0000000000000000000000000000';   // Código de seguridad de 32 dígitos alfanúmericos entregado por el SIFEN.

    // Lugar donde se almacena el archivo JSON que contiene el registro del último valor del dId utilizado.
    public String $dIdFilePath = "PKuatiaDId.dat.json";

    public static function ParseObject($config): Config {
        $res = new Config();
        
        if(is_null($config)) {
            throw new \Exception("Objeto de configuración no puede ser nulo.");
        }
        
        if(isset($config->env)) {
            $res->env = $config->env;
        }        
        
        if(isset($config->certificateFormat)) {
            $res->certificateFormat = $config->certificateFormat;
        }

        if(!isset($config->certificateFilePath)) {
            throw new \Exception("Ruta del archivo del certificado debe ser especificada.");
        }
        $res->certificateFilePath = $config->certificateFilePath;

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
        $this->certificateFormat = $certificateFormat;

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
