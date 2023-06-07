<?php

namespace Abiliomp\Pkuatia;


/**
 * Clase que contiene los parámetros de la instancia del SIFEN utilizada.
 */
class Config
{
    public string $ambiente; // Solo se aceptan valores "dev" para entorno en desarrollo y "prod" para entorno en producción.

    public bool $usarCertificado;
    public string $tipoCertificado; // Solo se aceptan valores "pfx", "pem" o "der".
    public string $certificado;
    public string $contraseñaCertificado;

    public string $idCsc; // Identificador de la clave de seguridad entregado por el SIFEN.
    public string $csc; // Código de seguridad de 32 dígitos alfanúmericos entregado por el SIFEN.
    public string $ruc; // RUC del contribuyente emisor sin DV.
    public int $tipoContribuyente; // Solo se aceptan valores 1 para persona física y 2 para persona jurídica.
    public string $razonSocial; // Razón social del contribuyente emisor.
    public string $direccion; // Dirección del contribuyente emisor.
    public string $numeroCasa; // Número de casa del contribuyente emisor.
    public string $telefono; // Teléfono del contribuyente emisor.
    public string $correo; // Correo electrónico del contribuyente emisor.
    public int $departamento; // Departamento del contribuyente emisor.
    public int $ciudad; // Ciudad del contribuyente emisor.
    public static Config $instance; // Instancia de la clase Config.
    public string $actEco; // Actividad económica del contribuyente emisor.
    public string $descActEco; // Descripción de la actividad económica del contribuyente emisor.

    public function __construct()
    {
    }

    public static function getInstance(): Config
    {
        if (self::$instance == null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    public static function setInstance(Config $config): void
    {
        self::$instance = $config;
    }
}
