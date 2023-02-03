<?php

namespace Abiliomp\Pkuatia\Helpers;

use DOMElement;

/**
 * Enum con los tipos de certificados disponibles para la conexión segura y la firma digital.
 */

enum TipoCertificadoCliente
{
  case PFX;
}

/**
 * Enum con los tipos de ambientes disponibles en Sifen.
 */
enum TipoAmbiente
{
  case DEV;
  case PROD;
}

/**
 * Clase que genera y valida la firma digital de los documentos XML para el SIFEN.
 */
class SignatureHelper
{
  //Atributos
  const SIFEN_AMBIENTE_KEY ="sifen.ambiente";
  ///tema del ambiente

  const SIFEN_URL_BASE_KEY = "sifen.url_base";
  private string $urlBase;

  private string $urlBaseLocal;
  private string $urlConsultaQr;

  
}
