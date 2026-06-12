<?php

namespace IonysDev\Pkuatia\Core\Responses;

use DateTime;

/**
 * Clase que representa la respuesta del SIFEN a la consulta masiva de RUC (WS siConsArchivoRUC, NT-011).
 */
class RResEnviConsArchivoRUC
{
  // Códigos de resultado del WS según Tabla L de la NT-011
  public const COD_RES_ARCHIVO_ENCONTRADO = 520;    // Archivo encontrado
  public const COD_RES_ARCHIVO_NO_ENCONTRADO = 521; // No se encontró el archivo generado en el día
  public const COD_RES_LIMITE_DESCARGAS = 522;      // Se ha superado el límite de descargas del día (máximo una diaria)
  public const COD_RES_RUC_NO_COINCIDE = 523;       // El RUC del certificado no coincide con el RUC de consulta

                                  // ID - DESCRIPCION - LONGITUD - OCURRENCIA
  public DateTime $dFecProc;      // FSch02 - Fecha y hora del procesamiento - 19 - 1-1
  public DateTime $dFecArchivo;   // FSch03 - Fecha del archivo - 10 - 0-1
  public int      $dCodRes;       // FSch04 - Código del resultado de la consulta - 1-4 - 1-1
  public String   $dMsgRes;       // FSch05 - Mensaje del resultado de la consulta - 1-255 - 1-1
  public String   $rConsDte;      // FSch06 - Archivo de RUC comprimido (ZIP) codificado en Base64 - 0-1

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dFecProc - Fecha y hora del procesamiento.
   *
   * @param DateTime $dFecProc
   *
   * @return self
   */
  public function setDFecProc(DateTime $dFecProc): self
  {
    $this->dFecProc = $dFecProc;
    return $this;
  }

  /**
   * Establece el valor de dFecArchivo - Fecha del archivo.
   *
   * @param DateTime $dFecArchivo
   *
   * @return self
   */
  public function setDFecArchivo(DateTime $dFecArchivo): self
  {
    $this->dFecArchivo = $dFecArchivo;
    return $this;
  }

  /**
   * Establece el valor de dCodRes - Código del resultado de la consulta.
   *
   * @param int $dCodRes
   *
   * @return self
   */
  public function setDCodRes(int $dCodRes): self
  {
    $this->dCodRes = $dCodRes;
    return $this;
  }

  /**
   * Establece el valor de dMsgRes - Mensaje del resultado de la consulta.
   *
   * @param String $dMsgRes
   *
   * @return self
   */
  public function setDMsgRes(String $dMsgRes): self
  {
    $this->dMsgRes = $dMsgRes;
    return $this;
  }

  /**
   * Establece el valor de rConsDte - Archivo de RUC comprimido (ZIP) codificado en Base64.
   *
   * @param String $rConsDte
   *
   * @return self
   */
  public function setRConsDte(String $rConsDte): self
  {
    $this->rConsDte = $rConsDte;
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dFecProc - Fecha y hora del procesamiento.
   *
   * @return DateTime|null
   */
  public function getDFecProc(): ?DateTime
  {
    return isset($this->dFecProc) ? $this->dFecProc : null;
  }

  /**
   * Obtiene el valor de dFecArchivo - Fecha del archivo.
   *
   * @return DateTime|null
   */
  public function getDFecArchivo(): ?DateTime
  {
    return isset($this->dFecArchivo) ? $this->dFecArchivo : null;
  }

  /**
   * Obtiene el valor de dCodRes - Código del resultado de la consulta.
   *
   * @return int|null
   */
  public function getDCodRes(): ?int
  {
    return isset($this->dCodRes) ? $this->dCodRes : null;
  }

  /**
   * Obtiene el valor de dMsgRes - Mensaje del resultado de la consulta.
   *
   * @return String|null
   */
  public function getDMsgRes(): ?String
  {
    return isset($this->dMsgRes) ? $this->dMsgRes : null;
  }

  /**
   * Obtiene el valor de rConsDte - Archivo de RUC comprimido (ZIP) codificado en Base64.
   *
   * @return String|null
   */
  public function getRConsDte(): ?String
  {
    return isset($this->rConsDte) ? $this->rConsDte : null;
  }

  /**
   * Devuelve el contenido binario del archivo ZIP de RUC (decodifica el Base64 recibido).
   *
   * @return String|null Contenido binario del ZIP o null si el SIFEN no devolvió el archivo.
   */
  public function getArchivoZip(): ?String
  {
    if (!isset($this->rConsDte))
      return null;
    $contenido = base64_decode($this->rConsDte, true);
    return $contenido === false ? null : $contenido;
  }

  ///////////////////////////////////////////////////////////////////////
  // Métodos especiales de instanciación
  ///////////////////////////////////////////////////////////////////////

  /**
   * Crea una nueva instancia de RResEnviConsArchivoRUC a partir de un objeto stdClass.
   * Pensado para castear la respuesta de una llamada SOAP.
   *
   * @param mixed $object Objeto de respuesta del SIFEN.
   *
   * @return RResEnviConsArchivoRUC
   */
  public static function FromSifenResponseObject($object): self
  {
    if (is_null($object)) {
      throw new \Exception("[RResEnviConsArchivoRUC] La respuesta del SIFEN es nula.");
    }
    $res = new RResEnviConsArchivoRUC();
    if (isset($object->dFecProc)) {
      $res->setDFecProc(new DateTime($object->dFecProc));
    }
    if (isset($object->dFecArchivo)) {
      $res->setDFecArchivo(new DateTime($object->dFecArchivo));
    }
    if (isset($object->dCodRes)) {
      $res->setDCodRes(intval($object->dCodRes));
    }
    if (isset($object->dMsgRes)) {
      $res->setDMsgRes(strval($object->dMsgRes));
    }
    if (isset($object->rConsDte)) {
      $res->setRConsDte(strval($object->rConsDte));
    }
    return $res;
  }
}
