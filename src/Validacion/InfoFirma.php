<?php

namespace IonysDev\Pkuatia\Validacion;

use DateTime;

/**
 * Resultado de verificar una firma (Fase C, paso C8). Un rDE tiene una; un sobre de eventos, una por rGesEve.
 */
final class InfoFirma
{
  /**
   * @param string                $referenciaUri              URI de la referencia firmada ("#CDC" en un DE, "#1" en un evento).
   * @param bool                  $digestValido               El contenido referenciado coincide con el DigestValue.
   * @param bool                  $firmaValida                El SignatureValue verifica con la clave pública del certificado de KeyInfo.
   * @param bool                  $cumpleEstandar             Algoritmos y transforms del estándar del SIFEN (MT, NT-016).
   * @param CertificadoFirma|null $certificado                Certificado de KeyInfo, o null si no se pudo leer.
   * @param DateTime|null         $fechaFirma                 dFecFirma del DE o del rEve, o null si no se encontró.
   * @param bool|null             $certificadoVigenteAlFirmar Null si falta el certificado o la fecha.
   * @param array<string, mixed>  $algoritmos                 firma, digest, canonicalizacion y transforms (lista).
   * @param list<string>          $observaciones              Detalle técnico de lo que falló (mensajes de xmlseclibs).
   */
  public function __construct(
    public readonly string $referenciaUri,
    public readonly bool $digestValido,
    public readonly bool $firmaValida,
    public readonly bool $cumpleEstandar,
    public readonly ?CertificadoFirma $certificado,
    public readonly ?DateTime $fechaFirma,
    public readonly ?bool $certificadoVigenteAlFirmar,
    public readonly array $algoritmos,
    public readonly array $observaciones = [],
  ) {
  }

  public function esValida(): bool
  {
    return $this->digestValido && $this->firmaValida && $this->cumpleEstandar && $this->certificado !== null
      && $this->certificadoVigenteAlFirmar !== false;
  }
}
