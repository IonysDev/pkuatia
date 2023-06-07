<?php

namespace Abiliomp\Pkuatia;


/**
 * Clase que contiene los parámetros de la instancia del SIFEN utilizada.
 */
class Config
{

    public static Config $instance; // Instancia de la clase Config.

    public string $ambiente; // Solo se aceptan valores "dev" para entorno en desarrollo y "prod" para entorno en producción.

    //Datos del archivo key de la siden
    public bool $usarCertificado;
    public string $tipoCertificado; // Solo se aceptan valores "pfx", "pem" o "der".
    public string $certificado;
    public string $contraseñaCertificado;

    //Datos del SIFEN?
    public string $idCsc; // Identificador de la clave de seguridad entregado por el SIFEN.
    public string $csc; // Código de seguridad de 32 dígitos alfanúmericos entregado por el SIFEN.
    
    //Datos del emisor
    public string $ruc; // RUC del contribuyente emisor sin DV.
    public int $tipoContribuyente; // Solo se aceptan valores 1 para persona física y 2 para persona jurídica.
    public string $razonSocial; // Razón social del contribuyente emisor.
    public string $direccion; // Dirección del contribuyente emisor.
    public string $numeroCasa; // Número de casa del contribuyente emisor.
    public string $telefono; // Teléfono del contribuyente emisor.
    public string $correo; // Correo electrónico del contribuyente emisor.
    public int $departamento; // Departamento del contribuyente emisor.
    public int $ciudad; // Ciudad del contribuyente emisor.
    public string $actEco; // Actividad económica del contribuyente emisor.
    public string $descActEco; // Descripción de la actividad económica del contribuyente emisor.
    
    //para facturas
    public string $numeroDocumento; // Número de documento del contribuyente emisor.
    public string $establecimiento; // Establecimiento del contribuyente emisor.
    public string $puntoExpedicion; // Punto de expedición del contribuyente emisor.
    public int $tipoOperacionComercial;
    public int $condicionOperacionComercial;
    public int $montoEntregaInicial;
    public int $tipoPagoOPeracionComercial;
    public int $modalidadTransporte;

    ///instancia de config
    public static function getInstance(): Config
    {
        
        if (!isset(self::$instance)) {
            self::$instance = new Config();
            ///initialize values
            self::$instance->ambiente = "dev";
            self::$instance->usarCertificado = false;
            self::$instance->tipoCertificado = "pfx";
            self::$instance->certificado = "";
            self::$instance->contraseñaCertificado = "";
            self::$instance->idCsc = "";
            self::$instance->csc = "";
            self::$instance->ruc = "";
            self::$instance->tipoContribuyente = 2;
            self::$instance->razonSocial = "";
            self::$instance->direccion = "";
            self::$instance->numeroCasa = "";
            self::$instance->telefono = "";
            self::$instance->correo = "";
            self::$instance->departamento = 0;
            self::$instance->ciudad = 0;
            self::$instance->actEco = "";
            self::$instance->descActEco = "";
            self::$instance->numeroDocumento = "";
            self::$instance->establecimiento = "";
            self::$instance->puntoExpedicion = "";
            self::$instance->tipoOperacionComercial = 1;
            self::$instance->condicionOperacionComercial = 1;
            self::$instance->montoEntregaInicial = 0;
            self::$instance->tipoPagoOPeracionComercial = 1;
            self::$instance->modalidadTransporte = 1;
        }
        return self::$instance;
    }


}
