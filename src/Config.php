<?php

namespace Abiliomp\Pkuatia;


/**
 * Clase que contiene los parámetros de la instancia del SIFEN utilizada.
 */
class Config
{  
    public string $ambiente = "dev"; // Solo se aceptan valores "dev" para entorno en desarrollo y "prod" para entorno en producción.
    
    public static bool $usarCertificado;
    public static string $tipoCertificado; // Solo se aceptan valores "pfx", "pem" o "der".
    public static string $certificado;
    public static string $contraseñaCertificado;

    public String $idCsc;
    public String $csc; // Código de seguridad de 32 dígitos alfanúmericos entregado por el SIFEN.

    public static function InitFromJsonFile(string $path) {
        $config = json_decode(file_get_contents($path));
        self::$ambiente = $config->ambiente;
        self::$usarCertificado = $config->usarCertificado;
        self::$tipoCertificado = $config->tipoCertificado;
        self::$certificado = $config->certificado;
        self::$contraseñaCertificado = $config->contraseñaCertificado;
        self::$idCsc = $config->idCsc;
        self::$csc = $config->csc;
    }

    public static function GetSifenUrlBase() : string {
        if (strtolower(self::$ambiente) == "prod") {
            return Constants::SIFEN_URL_BASE_PROD;
        } else {
            return Constants::SIFEN_URL_BASE_DEV;
        }
    }
    

}
