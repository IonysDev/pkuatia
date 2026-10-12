<?php

namespace IonysDev\Pkuatia\Core\Constants;

/**
 * Motivo de una CertificadoException (Fase C, paso C2).
 */
enum MotivoCertificado: string
{
  case NoEncontrado = 'no_encontrado';
  case PassphraseIncorrecta = 'passphrase_incorrecta';
  case CifradoHeredado = 'cifrado_heredado';
  case PemInvalido = 'pem_invalido';
  case NoSoportado = 'no_soportado';

  public function descripcion(): string
  {
    return match ($this) {
      self::NoEncontrado => 'No se encontró el archivo del certificado o de la clave privada',
      self::PassphraseIncorrecta => 'La contraseña de la clave privada es incorrecta',
      self::CifradoHeredado => 'El PKCS#12 usa un cifrado heredado que OpenSSL 3 deshabilita por omisión',
      self::PemInvalido => 'El archivo PEM no contiene lo esperado (certificado o clave privada)',
      self::NoSoportado => 'Formato de certificado no soportado (se aceptan pem, p12 y pfx)',
    };
  }
}
