<?php

namespace IonysDev\Pkuatia\Validacion;

/**
 * De qué control sale un ErrorValidacion (Fase C).
 */
enum OrigenError: string
{
  case Xsd = 'xsd';                  // El XML no cumple el esquema (Sifen::ValidarXSD)
  case Completitud = 'completitud';  // Falta un campo obligatorio en el objeto (validador de reglas)
  case Regla = 'regla';              // Una regla de negocio del MT (validador de reglas)
  case Firma = 'firma';              // La firma digital o el certificado (Sifen::VerificarFirma)

  public function descripcion(): string
  {
    return match ($this) {
      self::Xsd => 'Esquema XSD',
      self::Completitud => 'Campo obligatorio ausente',
      self::Regla => 'Regla de validación del SIFEN',
      self::Firma => 'Firma digital',
    };
  }
}
