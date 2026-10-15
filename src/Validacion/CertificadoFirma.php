<?php

namespace IonysDev\Pkuatia\Validacion;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Constants;
use IonysDev\Pkuatia\Core\Exceptions\ValidacionException;

/**
 * Datos del certificado X.509 con el que se firmó un documento (Fase C, paso C8), leídos con openssl_x509_parse().
 *
 * El RUC: según el MT (AA07 y AC03, ekuat-ia respuestas-ws.md §12.2.1 y §12.2.4) va en el campo serialNumber del
 * sujeto para una persona jurídica y en el SubjectAlternativeName para una persona física. El formato exacto que usan
 * las CA paraguayas no está verificado `[PENDIENTE DE VERIFICACIÓN]`: se reconoce "RUC" seguido del número y el
 * dígito verificador, con o sin guion; si no aparece, ruc es null.
 */
final class CertificadoFirma
{
  private function __construct(
    public readonly string $sujeto,
    public readonly string $emisor,
    public readonly ?string $serialNumber,
    public readonly string $numeroSerie,
    public readonly ?string $ruc,
    public readonly DateTime $validoDesde,
    public readonly DateTime $validoHasta,
    public readonly string $pem,
  ) {
  }

  /** Desde un PEM (si trae varios bloques o una clave, toma el primer certificado). */
  public static function desdePem(string $pem): self
  {
    if (!preg_match('/-----BEGIN CERTIFICATE-----.*?-----END CERTIFICATE-----/s', $pem, $m))
      throw new ValidacionException('[CertificadoFirma] El texto no contiene un certificado PEM.');
    $certificado = $m[0];
    $info = @openssl_x509_parse($certificado);
    if ($info === false)
      throw new ValidacionException('[CertificadoFirma] No se pudo leer el certificado X.509.');
    $serial = $info['subject']['serialNumber'] ?? null;
    if (is_array($serial))
      $serial = implode(', ', $serial);
    $san = $info['extensions']['subjectAltName'] ?? '';
    $zona = new DateTimeZone(Constants::SIFEN_TIMEZONE);
    return new self(
      self::nombre($info['subject'] ?? []),
      self::nombre($info['issuer'] ?? []),
      $serial === null ? null : (string) $serial,
      (string) ($info['serialNumberHex'] ?? $info['serialNumber'] ?? ''),
      self::extraerRuc(($serial ?? '') . ' ' . $san),
      (new DateTime('@' . ($info['validFrom_time_t'] ?? 0)))->setTimezone($zona),
      (new DateTime('@' . ($info['validTo_time_t'] ?? 0)))->setTimezone($zona),
      $certificado,
    );
  }

  /** Desde el contenido de ds:X509Certificate (base64 sin cabeceras). */
  public static function desdeBase64(string $base64): self
  {
    $limpio = preg_replace('/\s+/', '', $base64);
    return self::desdePem("-----BEGIN CERTIFICATE-----\n" . chunk_split($limpio, 64, "\n") . "-----END CERTIFICATE-----\n");
  }

  public function vigenteEn(DateTimeInterface $momento): bool
  {
    $t = $momento->getTimestamp();
    return $t >= $this->validoDesde->getTimestamp() && $t <= $this->validoHasta->getTimestamp();
  }

  /** RUC con dígito verificador ("80000000-5") a partir de un texto del certificado, o null. */
  public static function extraerRuc(string $texto): ?string
  {
    if (preg_match('/RUC\s*[:=\-]?\s*([0-9]{3,8})\s*-?\s*([0-9A-D])\b/i', $texto, $m))
      return $m[1] . '-' . strtoupper($m[2]);
    return null;
  }

  /** @param array<string, string|array<string>> $dn */
  private static function nombre(array $dn): string
  {
    $partes = [];
    foreach ($dn as $clave => $valor)
      $partes[] = $clave . '=' . (is_array($valor) ? implode('+', $valor) : $valor);
    return implode(', ', $partes);
  }
}
