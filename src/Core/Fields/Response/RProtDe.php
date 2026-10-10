<?php

namespace IonysDev\Pkuatia\Core\Fields\Response;

use DateTime;
use DOMElement;
use IonysDev\Pkuatia\Helpers\FechaHelper;
use SimpleXMLElement;
use stdClass;

/**
 * ID PP01: Protocolo  de procesamiento del DE
 */
class RProtDe
{
  // id - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $id;         // PP02 - CDC del DE Procesado - 44 - 1-1
  public DateTime $dFecProc; // PP03 - Fecha y hora del procesamiento - 19 - 1-1
  public String $dDigVal;    // PP04 - DigestValue del DE procesado - 28 - 1-1
  public String $dEstRes;    // PP050 - Estado del resultado - 8-30 - 1-1
  public String $dProtAut;   // PP051 - Número de Transacción - 10 - 1-1
  public array  $gResProc;   // PP05 - Grupo Resultado de Procesamiento - x - 1-100

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de id
   *
   * @param String $id
   *
   * @return self
   */
  public function setId(String $id): self
  {
    $this->id = $id;

    return $this;
  }


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
   * Establece el valor de dDigVal
   *
   * @param String $dDigVal
   *
   * @return self
   */
  public function setDDigVal(String $dDigVal): self
  {
    $this->dDigVal = $dDigVal;

    return $this;
  }


  /**
   * Establece el valor de dEstRes
   *
   * @param String $dEstRes
   *
   * @return self
   */
  public function setDEstRes(String $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Establece el valor de dProtAut
   *
   * @param String $dProtAut
   *
   * @return self
   */
  public function setDProtAut(String $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }


  /**
   * Establece el valor de gResProc
   *
   * @param TgResProc $gResProc
   *
   * @return self
   */
  public function setGResProc(array|GResProc $gResProc): self
  {
    // gResProc es 1-100 y la propiedad es array: hasta 0.2.0 se asignaba el objeto suelto (TypeError, PK-29).
    $this->gResProc = is_array($gResProc) ? $gResProc : [$gResProc];
    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Obtiene el CDC del DE procesado (PP02, elemento Id), o null si la respuesta no lo trae: el rechazo
   * genérico no incluye Id, dDigVal ni dProtAut (respuestas-ws/2026-10-06/02-rEnviDe-response-0160.xml).
   * Hasta 0.2.0 terminaba en Error en esos casos.
   *
   * @return String|null
   */
  public function getId(): ?String
  {
    return $this->id ?? null;
  }

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
   * Obtiene el valor de dDigVal, o null si la respuesta no lo trae (rechazo genérico).
   *
   * @return String|null
   */
  public function getDDigVal(): ?String
  {
    return $this->dDigVal ?? null;
  }

  /**
   * Obtiene el valor de dEstRes
   *
   * @return String
   */
  public function getDEstRes(): String
  {
    return $this->dEstRes;
  }

  /**
   * Obtiene el número de transacción (PP051), o null si la respuesta no lo trae: solo existe cuando el DE fue aprobado.
   *
   * @return String|null
   */
  public function getDProtAut(): ?String
  {
    return $this->dProtAut ?? null;
  }

  /**
   * Obtiene el valor de gResProc
   *
   * @return GResProc
   */
  public function getGResProc(): array
  {
    return $this->gResProc;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT
  ///////////////////////////////////////////////////////////////////////

  // /**
  //  * toDOMElement
  //  *
  //  * @return DOMElement
  //  */
  // public function toDOMElement(): DOMElement
  // {
  //   $res = new DOMElement('txProtDe');

  //   $res->appendChild(new DOMElement('dFecProc', $this->dFecProc->format('Y-m-d H:i:s')));
  //   $res->appendChild(new DOMElement('dDigVal', $this->dDigVal));
  //   $res->appendChild(new DOMElement('dEstRes', $this->dEstRes));
  //   $res->appendChild(new DOMElement('dProtAut', $this->dProtAut));
  //   $res->appendChild($this->gResProc->toDOMElement());
  //   return $res;
  // }

  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return RProtDe
  //  */
  // public static function FromDOMElement(DOMElement $xml): RProtDe
  // {
  //   if (strcmp($xml->tagName, 'rProtDe') == 0 && $xml->childElementCount == 6) {
  //     $res = new RProtDe();
  //     $res->setDFecProc(DateTime::createFromFormat('Y-m-d H:i:s', $xml->getElementsByTagName('dFecProc')->item(0)->nodeValue));
  //     $res->setDDigVal($xml->getElementsByTagName('dDigVal')->item(0)->nodeValue);
  //     $res->setDEstRes($xml->getElementsByTagName('dEstRes')->item(0)->nodeValue);
  //     $res->setDProtAut($xml->getElementsByTagName('dProtAut')->item(0)->nodeValue);

  //     $aux = new GResProc();
  //     $aux->fromDOMElement($xml->getElementsByTagName('gResProc')->item(0)->nodeValue);
  //     $res->setGResProc($aux);
  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  /**
   * Converts XML String representation to object
   * 
   * @param String $xml
   * @return RProtDe
   */
  public static function FromXMLString(String $xmlString): RProtDe
  {
    $xml = simplexml_load_string($xmlString);
    $res = self::fromSimpleXMLElement($xml);
    return $res;
  }

  /**
   * Converts SimpleXMLElement to object
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return RProtDe
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $xml): RProtDe
  {
    if (strcmp($xml->getName(), 'rProtDe') != 0) {
      throw new \Exception("Invalid XML Element: $xml->getName()");
    }
    $res = new RProtDe();
    // Hasta 0.2.0: se leía "id" (el SIFEN manda Id), la fecha con un formato que nunca coincide ("Y-m-d H:i:s")
    // y los campos ausentes en un rechazo quedaban como cadenas vacías (PK-29).
    if (isset($xml->Id))
      $res->setId((string) $xml->Id);
    elseif (isset($xml->id))
      $res->setId((string) $xml->id);
    if (isset($xml->dFecProc))
      $res->setDFecProc(FechaHelper::FromSifen($xml->dFecProc, 'dFecProc'));
    if (isset($xml->dDigVal))
      $res->setDDigVal((string) $xml->dDigVal);
    $res->setDEstRes((string) $xml->dEstRes);
    if (isset($xml->dProtAut))
      $res->setDProtAut((string) $xml->dProtAut);
    $res->gResProc = [];
    foreach ($xml->gResProc as $gResProc) {
      $res->gResProc[] = GResProc::FromSimpleXMLElement($gResProc);
    }
    return $res;
  }

  /**
   * Converts SimpleXMLElement to object
   * 
   * @param stdClass $node
   * 
   * @return RProtDe
   */
  public static function FromSifenResponseObject($node): RProtDe
  {
    $res = new RProtDe();
    // El CDC llega como "Id" con mayúscula (respuestas-ws/2026-10-09/03-rEnviDe-response.xml, observación 1);
    // hasta 0.2.0 se leía "id" y se perdía (PK-29). Se acepta también "id".
    if (isset($node->Id))
      $res->setId((string) $node->Id);
    elseif (isset($node->id))
      $res->setId((string) $node->id);
    if (isset($node->dFecProc))
      $res->setDFecProc(FechaHelper::FromSifen($node->dFecProc, 'dFecProc'));
    if (isset($node->dDigVal))
      $res->setDDigVal($node->dDigVal);
    $res->setDEstRes($node->dEstRes);
    if (isset($node->dProtAut))
      $res->setDProtAut($node->dProtAut);
    $res->gResProc = [];
    if (isset($node->gResProc)) {
      if (is_array($node->gResProc)) {
        foreach ($node->gResProc as $gResProc) {
          $res->gResProc[] = GResProc::FromSifenResponseObject($gResProc);
        }
      } else {
        $res->gResProc[] = GResProc::FromSifenResponseObject($node->gResProc);
      }
    }
    return $res;
  }
}
