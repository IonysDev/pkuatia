<?php

namespace IonysDev\Pkuatia\Helpers;

/**
 * Utilidades para archivos PKCS#12 (.p12 / .pfx) que contienen el certificado y la clave privada.
 */
class Pkcs12Helper
{
  /**
   * Lee un archivo PKCS#12 en memoria y devuelve sus componentes (clave privada, certificado, etc.).
   *
   * A diferencia de openssl_pkcs12_read() a secas, ante un fallo arroja una excepción con un mensaje
   * accionable. El caso más común en Paraguay es que el .p12 use un algoritmo de cifrado heredado
   * (legacy, p.ej. RC2-40 o 3DES) que OpenSSL 3 —incluido en PHP 8— deshabilita por omisión.
   *
   * @param string $pkcs12Content Contenido binario del archivo PKCS#12.
   * @param string $passphrase    Contraseña del archivo PKCS#12.
   *
   * @return array Componentes devueltos por openssl_pkcs12_read (claves 'pkey', 'cert', 'extracerts').
   *
   * @throws \Exception Con un mensaje que distingue contraseña incorrecta, cifrado legacy u otros errores.
   */
  public static function read(string $pkcs12Content, string $passphrase): array
  {
    $certs = [];
    if (openssl_pkcs12_read($pkcs12Content, $certs, $passphrase)) {
      return $certs;
    }

    // Drena la cola de errores de OpenSSL para diagnosticar la causa real.
    $errors = [];
    while (($e = openssl_error_string()) !== false) {
      $errors[] = $e;
    }
    $errorStr = implode(' | ', $errors);

    // "mac verify failure" indica que la contraseña no corresponde al archivo.
    if (stripos($errorStr, 'mac verify failure') !== false) {
      throw new \Exception(
        "[Pkcs12Helper] No se pudo leer el archivo PKCS#12: la contraseña de la clave privada es incorrecta. " .
        "Detalle de OpenSSL: " . $errorStr
      );
    }

    // "unsupported" / "digital envelope routines" indican un algoritmo de cifrado legacy.
    if (stripos($errorStr, 'unsupported') !== false || stripos($errorStr, 'digital envelope') !== false) {
      throw new \Exception(
        "[Pkcs12Helper] No se pudo leer el archivo PKCS#12 porque usa un algoritmo de cifrado heredado " .
        "(legacy, p.ej. RC2-40 o 3DES) que OpenSSL 3 —incluido en PHP 8— deshabilita por omisión. " .
        "Los certificados emitidos por las CA de Paraguay suelen tener este formato. Soluciones posibles:\n" .
        "  A) Habilitar el proveedor 'legacy' de OpenSSL ANTES de iniciar PHP, mediante las variables de\n" .
        "     entorno OPENSSL_CONF (apuntando a un openssl.cnf que active los proveedores 'default' y\n" .
        "     'legacy') y OPENSSL_MODULES (apuntando al directorio que contiene legacy.dll / legacy.so).\n" .
        "     No alcanza con putenv() en tiempo de ejecución: el proveedor se inicializa al primer uso.\n" .
        "  B) Reexportar el certificado a un PKCS#12 con cifrado moderno:\n" .
        "       openssl pkcs12 -in viejo.p12 -legacy -nodes -out tmp.pem\n" .
        "       openssl pkcs12 -export -in tmp.pem -out nuevo.p12\n" .
        "     (luego eliminar tmp.pem, que queda sin cifrar).\n" .
        "  C) Convertir el .p12 a PEM y usar certificateFormat = 'pem'.\n" .
        "Detalle de OpenSSL: " . $errorStr
      );
    }

    throw new \Exception(
      "[Pkcs12Helper] Error al leer el archivo PKCS#12: " . ($errorStr !== '' ? $errorStr : 'causa desconocida') . "."
    );
  }
}
