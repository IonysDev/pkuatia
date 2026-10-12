<?php

namespace IonysDev\Pkuatia\Validacion;

use DateTime;
use DOMDocument;
use DOMElement;
use DOMXPath;
use IonysDev\Pkuatia\Helpers\FechaHelper;
use RobRichards\XMLSecLibs\XMLSecEnc;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use Throwable;

/**
 * Verifica las firmas de un rDE o de un sobre de eventos (gGroupGesEve / rGesEve) recibido (Fase C, paso C8;
 * evaluación §6.2). Por cada Signature: digest de la referencia, valor de la firma contra el certificado de KeyInfo,
 * algoritmos del estándar y vigencia del certificado en dFecFirma. Sin red: no verifica la cadena de certificación ni
 * la revocación (el 0141 del MT las incluye; aquí quedan fuera).
 *
 * Fuentes: MT §12.2.4 (0120, 0121) y §12.2.5 (0140, 0141), §12.4 I002 (2450); NT-016 y ekuat-ia
 * reglas-de-validacion.md FIRMA-001..007 (RSA-SHA256/384/512, SHA-256, C14N exclusiva o inclusiva, enveloped).
 * Receta de xmlseclibs probada en la evaluación: locateSignature → canonicalizeSignedInfo → validateReference →
 * locateKey → staticLocateKeyInfo → verify, con preserveWhiteSpace. validateReference() desprende la Signature del
 * árbol (transform enveloped), por eso cada firma se verifica sobre un documento recién leído.
 */
final class VerificadorFirma
{
  private const ALGORITMOS_FIRMA = [
    'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
    'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384',
    'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512',
  ];
  private const ALGORITMOS_DIGEST = ['http://www.w3.org/2001/04/xmlenc#sha256'];
  private const ALGORITMOS_C14N = [
    'http://www.w3.org/2001/10/xml-exc-c14n#',
    'http://www.w3.org/2001/10/xml-exc-c14n#WithComments',
    'http://www.w3.org/TR/2001/REC-xml-c14n-20010315',
    'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments',
  ];
  private const ENVELOPED = 'http://www.w3.org/2000/09/xmldsig#enveloped-signature';
  private const TIPOS = ['rDE', 'gGroupGesEve', 'rGesEve'];

  public static function verificar(string $xml): ResultadoFirma
  {
    $errores = [];
    $doc = self::cargar($xml, $errores);
    if ($doc === null)
      return new ResultadoFirma([], $errores, 'desconocido');
    $raiz = $doc->documentElement->localName;
    $tipo = in_array($raiz, self::TIPOS, true) ? $raiz : 'desconocido';
    $cantidad = self::xpath($doc)->query('//ds:Signature')->length;
    if ($cantidad === 0) {
      $errores[] = new ErrorValidacion(OrigenError::Firma, 'El documento no tiene firma digital (Signature).', '0140', null, 'Signature',
        sugerencia: 'Firmar con Sifen::FirmarDE() o Sifen::RegistrarEvento().');
      return new ResultadoFirma([], $errores, $tipo);
    }
    $firmas = [];
    for ($i = 0; $i < $cantidad; $i++) {
      $descartados = [];
      $docFirma = self::cargar($xml, $descartados);
      $firmas[] = self::verificarFirma($docFirma, $i, $tipo, $errores);
    }
    return new ResultadoFirma($firmas, $errores, $tipo);
  }

  /** @param list<ErrorValidacion> $errores */
  private static function verificarFirma(DOMDocument $doc, int $pos, string $tipo, array &$errores): InfoFirma
  {
    $xp = self::xpath($doc);
    $dsig = new XMLSecurityDSig();
    $sig = $dsig->locateSignature($doc, $pos);
    $referencia = $xp->query('./ds:SignedInfo/ds:Reference', $sig)->item(0);
    $uri = $referencia instanceof DOMElement ? $referencia->getAttribute('URI') : '';
    $algoritmos = [
      'canonicalizacion' => self::atributo($xp, './ds:SignedInfo/ds:CanonicalizationMethod', $sig),
      'firma' => self::atributo($xp, './ds:SignedInfo/ds:SignatureMethod', $sig),
      'digest' => self::atributo($xp, './ds:SignedInfo/ds:Reference/ds:DigestMethod', $sig),
      'transforms' => [],
    ];
    foreach ($xp->query('./ds:SignedInfo/ds:Reference/ds:Transforms/ds:Transform', $sig) as $t) {
      /** @var DOMElement $t */
      $algoritmos['transforms'][] = $t->getAttribute('Algorithm');
    }
    $x509 = $xp->query('./ds:KeyInfo/ds:X509Data/ds:X509Certificate', $sig)->item(0)?->textContent;
    $etiqueta = $pos + 1;
    $observaciones = [];

    $cumple = in_array($algoritmos['firma'], self::ALGORITMOS_FIRMA, true)
      && in_array($algoritmos['digest'], self::ALGORITMOS_DIGEST, true)
      && in_array($algoritmos['canonicalizacion'], self::ALGORITMOS_C14N, true)
      && in_array(self::ENVELOPED, $algoritmos['transforms'], true)
      && str_starts_with($uri, '#') && strlen($uri) > 1;
    if (!$cumple) {
      $errores[] = new ErrorValidacion(OrigenError::Firma,
        "La firma $etiqueta no cumple el estándar del SIFEN (referencia '$uri', firma {$algoritmos['firma']}, digest {$algoritmos['digest']}, canonicalización {$algoritmos['canonicalizacion']}, transforms " . implode(', ', $algoritmos['transforms']) . ').',
        '0140', null, 'Signature', sugerencia: 'RSA-SHA256 (o 384/512), SHA-256, C14N exclusiva y transform enveloped, con la referencia al Id del DE o del rEve (NT-016).');
    }

    $digestValido = false;
    try {
      $dsig->canonicalizeSignedInfo();
      $digestValido = (bool) $dsig->validateReference();
    } catch (Throwable $e) {
      $observaciones[] = 'Referencia: ' . $e->getMessage();
    }
    if (!$digestValido) {
      $errores[] = new ErrorValidacion(OrigenError::Firma,
        "El digest de la referencia '$uri' de la firma $etiqueta no coincide: el contenido firmado fue alterado o la firma no corresponde a este documento.",
        '0141', null, 'DigestValue', sugerencia: 'Verificar que el XML sea exactamente el firmado (sin reformatear ni reserializar).');
    }

    // El certificado se lee antes de verificar: con uno ilegible, xmlseclibs emite avisos de openssl y no puede verificar.
    $certificado = null;
    if ($x509 === null || trim($x509) === '') {
      $errores[] = new ErrorValidacion(OrigenError::Firma, "La firma $etiqueta no incluye el certificado en KeyInfo/X509Data/X509Certificate.", '0120', null, 'X509Certificate');
    } else {
      try {
        $certificado = CertificadoFirma::desdeBase64($x509);
      } catch (Throwable $e) {
        $errores[] = new ErrorValidacion(OrigenError::Firma, "El certificado de la firma $etiqueta no se pudo leer: " . $e->getMessage(), '0120', null, 'X509Certificate');
      }
    }

    $firmaValida = false;
    if ($certificado !== null) {
      try {
        $clave = $dsig->locateKey();
        if ($clave === null)
          throw new \RuntimeException('SignatureMethod no reconocido');
        XMLSecEnc::staticLocateKeyInfo($clave, $sig);
        $firmaValida = $dsig->verify($clave) === 1;
      } catch (Throwable $e) {
        $observaciones[] = 'Verificación: ' . $e->getMessage();
      }
    }
    if (!$firmaValida) {
      $errores[] = new ErrorValidacion(OrigenError::Firma,
        "El valor de la firma (SignatureValue) de la firma $etiqueta no verifica con el certificado de KeyInfo.",
        '0141', null, 'SignatureValue');
    }

    $fechaFirma = self::fechaFirma($xp, $tipo, $pos);
    $vigente = ($certificado !== null && $fechaFirma !== null) ? $certificado->vigenteEn($fechaFirma) : null;
    if ($vigente === false) {
      $errores[] = new ErrorValidacion(OrigenError::Firma,
        sprintf("El certificado de la firma %d no estaba vigente al firmar (dFecFirma %s; válido del %s al %s).", $etiqueta,
          $fechaFirma->format('Y-m-d\TH:i:s'), $certificado->validoDesde->format('Y-m-d'), $certificado->validoHasta->format('Y-m-d')),
        $tipo === 'rDE' ? '2450' : '0121', $tipo === 'rDE' ? 'I002' : null, 'dFecFirma', valor: $fechaFirma->format('Y-m-d\TH:i:s'));
    }

    return new InfoFirma($uri, $digestValido, $firmaValida, $cumple, $certificado, $fechaFirma, $vigente, $algoritmos, $observaciones);
  }

  /** dFecFirma del DE (rDE) o del rEve correspondiente a la firma (eventos), interpretada en la zona del SIFEN. */
  private static function fechaFirma(DOMXPath $xp, string $tipo, int $pos): ?DateTime
  {
    $consulta = $tipo === 'rDE'
      ? '//*[local-name()="DE"]/*[local-name()="dFecFirma"]'
      : '(//*[local-name()="rEve"])[' . ($pos + 1) . ']/*[local-name()="dFecFirma"]';
    $nodo = $xp->query($consulta)->item(0);
    if ($nodo === null)
      return null;
    try {
      return FechaHelper::FromSifen(trim($nodo->textContent), 'dFecFirma');
    } catch (Throwable) {
      return null;
    }
  }

  /** @param list<ErrorValidacion> $errores */
  private static function cargar(string $xml, array &$errores): ?DOMDocument
  {
    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = true;
    $previo = libxml_use_internal_errors(true);
    libxml_clear_errors();
    $ok = trim($xml) !== '' && $doc->loadXML($xml, LIBXML_NONET);
    if (!$ok) {
      $detalle = array_map(static fn ($e) => trim($e->message), libxml_get_errors());
      $errores[] = new ErrorValidacion(OrigenError::Firma, 'XML mal formado: ' . (implode('; ', $detalle) ?: 'documento vacío'));
    }
    libxml_clear_errors();
    libxml_use_internal_errors($previo);
    return $ok ? $doc : null;
  }

  private static function xpath(DOMDocument $doc): DOMXPath
  {
    $xp = new DOMXPath($doc);
    $xp->registerNamespace('ds', XMLSecurityDSig::XMLDSIGNS);
    return $xp;
  }

  private static function atributo(DOMXPath $xp, string $consulta, DOMElement|\DOMNode $contexto): string
  {
    $nodo = $xp->query($consulta, $contexto)->item(0);
    return $nodo instanceof DOMElement ? $nodo->getAttribute('Algorithm') : '';
  }
}
