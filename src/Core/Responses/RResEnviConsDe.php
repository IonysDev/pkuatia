<?php

namespace IonysDev\Pkuatia\Core\Responses;

use IonysDev\Pkuatia\Core\Fields\Response\DE\RContDe;
use DateTime;
use stdClass;

/**
 * Nodo Id:     DRSch01
 * Nombre:      rResEnviConsDe
 * Descripción: Clase que representa la respuesta a la consulta de un DE mediante su CDC.
 * Nodo Padre:  Es nodo raiz.
 */

class RResEnviConsDe
{
                             // Id - Longitud - Ocurrencia - Descripción
  public DateTime $dFecProc; // DRSch02  - 19    - 1-1 - fecha de proceso formato AAAA-MM-DD-hh:mm:ss
  public int      $dCodRes;  // DRSch03  - 4     - 1-1 - Código del resultado de procesamiento
  public String   $dMsgRes;  // DRSch04  - 1-255 - 1-1 - Mensaje del resultado de procesamiento
  public RContDe  $rContDe;  // ContDE01 - XML   - 0-1 - Objeto del DE consultado

  /**
   * Cadena XML original del DE tal como la devolvió el SIFEN, sin parsear.
   *
   * El objeto $rContDe no permite reconstruir este XML: RDE::toDOMElement() serializa
   * únicamente dVerFor y DE, dejando fuera Signature y gCamFuFD. Quien necesite persistir
   * o revalidar el documento firmado debe usar esta cadena y no una re-serialización.
   *
   * Sólo está disponible cuando el SIFEN responde xContenDE como cadena de texto.
   */
  private ?String $xContenDE = null;

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dFecProc
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
   * Establece el valor de dCodRes
   *
   * @param String $dCodRes
   *
   * @return self
   */
  public function setDCodRes(int $dCodRes): self
  {
    $this->dCodRes = $dCodRes;

    return $this;
  }


  /**
   * Establece el valor de dMsgRes
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
   * Establece el valor de rContDe
   *
   * @param RContDe $rContDe
   *
   * @return self
   */
  public function setRContDe(RContDe $rContDe): self
  {
    $this->rContDe = $rContDe;

    return $this;
  }


  /**
   * Establece la cadena XML original del DE devuelta por el SIFEN.
   *
   * @param String|null $xContenDE
   *
   * @return self
   */
  public function setXContenDE(?String $xContenDE): self
  {
    $this->xContenDE = $xContenDE;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  ///GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Obtiene el valor de dFecProc
   *
   * @return DateTime
   */
  public function getDFecProc(): DateTime
  {
    return $this->dFecProc;
  }

  /**
   * Obtiene el valor de dCodRes
   *
   * @return int
   */
  public function getDCodRes(): int
  {
    return $this->dCodRes;
  }

  /**
   * Obtiene el valor de dMsgRes
   *
   * @return String
   */
  public function getDMsgRes(): String
  {
    return $this->dMsgRes;
  }

  /**
   * Obtiene el valor de rContDe
   *
   * @return RContDe
   */
  public function getRContDe(): RContDe | null
  {
    return isset($this->rContDe) ? $this->rContDe : null;
  }

  /**
   * Obtiene la cadena XML original del DE tal como la devolvió el SIFEN.
   *
   * Es el único origen fiable del XML firmado: reconstruirlo desde getRContDe()->getRDe()
   * produciría un documento sin Signature ni gCamFuFD.
   *
   * @return String|null Null si el SIFEN no devolvió el contenido como cadena.
   */
  public function getXContenDE(): ?String
  {
    return $this->xContenDE;
  }

  /**
   * Obtiene únicamente el documento electrónico firmado (elemento rDE) del contenido
   * devuelto por el SIFEN.
   *
   * xContenDE NO es un documento XML bien formado: junto al rDE el SIFEN devuelve
   * elementos hermanos (dProtAut, xContEv), de modo que cargarlo tal cual en un parser
   * falla con "Extra content at the end of the document". Este método recorta el rDE
   * respetando los bytes originales, que es lo que exige la validez de la firma.
   *
   * Es lo que se debe persistir como XML del documento.
   *
   * @return String|null Null si no hay contenido o si no se encuentra el elemento rDE.
   */
  public function getRDEXml(): ?String
  {
    if ($this->xContenDE === null) {
      return null;
    }

    $start = strpos($this->xContenDE, '<rDE');
    if ($start === false) {
      return null;
    }

    // rDE no anida otro rDE, así que el último cierre es el suyo.
    $end = strrpos($this->xContenDE, '</rDE>');
    if ($end === false || $end < $start) {
      return null;
    }

    return substr($this->xContenDE, $start, $end - $start + strlen('</rDE>'));
  }

  ///////////////////////////////////////////////////////////////////////
  ///METHODS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Crea una nueva instancia de RResEnviConsDe a partir de un objeto stdClass.
   * Pensado para castear la respuesta de una llamada SOAP.
   * 
   * @param stdClass $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object)
  {
    if (is_null($object)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }
    $res = new RResEnviConsDe();
    $res->setDFecProc(DateTime::createFromFormat(DateTime::ATOM, $object->dFecProc));
    $res->setDCodRes(intval($object->dCodRes));
    $res->setDMsgRes($object->dMsgRes);
    if (isset($object->xContenDE)) {
      // Al 12/08/2023 el SIFEN responde con un valor que el WS no puede interpretar lo cual deriva en una cadena XML inválida con múltiples elementos raiz.
      // Por este motivo se agrega artificialmente ese elemento raiz.
      if (is_string($object->xContenDE)) {
        // Se conserva la cadena original intacta: es el XML firmado y no se puede
        // reconstruir a partir del objeto parseado.
        $res->setXContenDE($object->xContenDE);
        $xml = str_replace('<rDE ', '<rContDe><rDE ', $object->xContenDE);
        $xml = $xml . '</rContDe>';
        //remove the xml declaration, si no se rompe ahora!
        $xml = preg_replace('/<\?xml.*\?>/', '', $xml);
        $res->setRContDe(RContDe::FromSimpleXMLElement(simplexml_load_string($xml)));
      } else {
        // DRSch05 - rContDe se denomina xContenDE en la respuesta de consulta SOAP.
        $res->setRContDe(RContDe::FromSifenResponseObject($object->xContenDE));
      }
    } else if (isset($object->rContDe)) {
      $res->setRContDe(RContDe::FromSifenResponseObject($object->rContDe));
    }
    return $res;
  }
  
  /**
   * showData
   *
   * @return void
   */
  public function showData()
  {
    if ($this->getRContDe()) {
      if (($this->getRContDe()->getRDe())) {
        echo json_encode($this->getRContDe()->getRDe(), JSON_PRETTY_PRINT);
      }

      if (($this->getRContDe()->getRContEv())) {
        echo json_encode($this->getRContDe()->getRContEv(), JSON_PRETTY_PRINT);
      } else {
        echo "No hay eventos para este DE\n";
      }
    } else {
      echo json_encode($this, JSON_PRETTY_PRINT);
    }
  }
}
