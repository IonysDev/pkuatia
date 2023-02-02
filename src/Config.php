<?php

namespace Abiliomp\Pkuatia;

use DOMElement;

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

    public String $idCsc;
    public String $csc; // Código de seguridad de 32 dígitos alfanúmericos entregado por el SIFEN.
}