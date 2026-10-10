<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DOMDocument;
use DOMElement;
use IonysDev\Pkuatia\Helpers\XmlHelper;
use SimpleXMLElement;

/**
 * ID:E810 gGrupSup Grupo del sector supermercados
 * PAFRE:E790
 */
class GGrupSup
{
  public String $dNomCaj; ///E811 Nombre del cajero
  /** @deprecated 0.2.1 Parte entera del monto (E812 admite 4 decimales): usar getDEfectivoDecimal(). */
  public int $dEfectivo; /// E812 Efectivo
  /** @deprecated 0.2.1 Parte entera del monto (E813 admite 4 decimales): usar getDVueltoDecimal(). */
  public int $dVuelto; //E813 Vuelto
  /** @deprecated 0.2.1 Parte entera del monto (E814 admite 4 decimales): usar getDDonacDecimal(). */
  public int $dDonac; ///E814 Monto de la donación
  public String $dDesDonac; ///E815 Descripción de la donación

  // Montos exactos (dEfectivo tMontoBase4; dVuelto y dDonac tMontoBase6; hasta 4 decimales, DE_Types_v150.xsd).
  // Hasta 0.2.0 solo existían las propiedades int y los centavos se truncaban (Q-B10).
  private ?String $dEfectivoDecimal = null;
  private ?String $dVueltoDecimal = null;
  private ?String $dDonacDecimal = null;

  ///////////////////////////////////////////////////////////////////////
  ////Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de dNomCaj
   *
   * @param String $dNomCaj
   *
   * @return self
   */
  public function setDNomCaj(String $dNomCaj): self
  {
    $this->dNomCaj = $dNomCaj;

    return $this;
  }


  /**
   * Establece el valor de dEfectivo (E812, tMontoBase4: hasta 19 dígitos, 4 de ellos decimales).
   * Desde 0.2.1 acepta texto con decimales y lo emite exacto; hasta 0.2.0 se truncaba a entero (Q-B10).
   *
   * @param int|String $dEfectivo
   *
   * @throws \InvalidArgumentException Si no es un número válido para el XSD.
   *
   * @return self
   */
  public function setDEfectivo(int|String $dEfectivo): self
  {
    $this->dEfectivoDecimal = self::monto($dEfectivo, 'dEfectivo', 19);
    $this->dEfectivo = intval($this->dEfectivoDecimal);

    return $this;
  }


  /**
   * Establece el valor de dVuelto (E813, tMontoBase6: hasta 10 dígitos, 4 de ellos decimales).
   * Desde 0.2.1 acepta texto con decimales y lo emite exacto; hasta 0.2.0 se truncaba a entero (Q-B10).
   *
   * @param int|String $dVuelto
   *
   * @throws \InvalidArgumentException Si no es un número válido para el XSD.
   *
   * @return self
   */
  public function setDVuelto(int|String $dVuelto): self
  {
    $this->dVueltoDecimal = self::monto($dVuelto, 'dVuelto', 10);
    $this->dVuelto = intval($this->dVueltoDecimal);

    return $this;
  }


  /**
   * Establece el valor de dDonac (E814, tMontoBase6: hasta 10 dígitos, 4 de ellos decimales).
   * Desde 0.2.1 acepta texto con decimales y lo emite exacto; hasta 0.2.0 se truncaba a entero (Q-B10).
   *
   * @param int|String $dDonac
   *
   * @throws \InvalidArgumentException Si no es un número válido para el XSD.
   *
   * @return self
   */
  public function setDDonac(int|String $dDonac): self
  {
    $this->dDonacDecimal = self::monto($dDonac, 'dDonac', 10);
    $this->dDonac = intval($this->dDonacDecimal);

    return $this;
  }


  /**
   * Establece el valor de dDesDonac
   *
   * @param String $dDesDonac
   *
   * @return self
   */
  public function setDDesDonac(String $dDesDonac): self
  {
    $this->dDesDonac = $dDesDonac;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de dNomCaj
   *
   * @return String
   */
  public function getDNomCaj(): String
  {
    return $this->dNomCaj;
  }

  /**
   * Obtiene el valor de dEfectivo
   *
   * @deprecated 0.2.1 Trunca el monto (E812 admite 4 decimales): usar getDEfectivoDecimal().
   *
   * @return int
   */
  public function getDEfectivo(): int
  {
    return $this->dEfectivo;
  }

  /**
   * Obtiene el valor de dVuelto
   *
   * @deprecated 0.2.1 Trunca el monto (E813 admite 4 decimales): usar getDVueltoDecimal().
   *
   * @return int
   */
  public function getDVuelto(): int
  {
    return $this->dVuelto;
  }

  /**
   * Obtiene el valor de dDonac
   *
   * @deprecated 0.2.1 Trunca el monto (E814 admite 4 decimales): usar getDDonacDecimal().
   *
   * @return int
   */
  public function getDDonac(): int
  {
    return $this->dDonac;
  }

  /**
   * Monto exacto de dEfectivo (E812) como texto, o null si no se informó. Nuevo en 0.2.1 (Q-B10).
   *
   * @return String|null
   */
  public function getDEfectivoDecimal(): ?String
  {
    return isset($this->dEfectivo) ? self::exacto($this->dEfectivoDecimal, $this->dEfectivo) : null;
  }

  /**
   * Monto exacto de dVuelto (E813) como texto, o null si no se informó. Nuevo en 0.2.1 (Q-B10).
   *
   * @return String|null
   */
  public function getDVueltoDecimal(): ?String
  {
    return isset($this->dVuelto) ? self::exacto($this->dVueltoDecimal, $this->dVuelto) : null;
  }

  /**
   * Monto exacto de dDonac (E814) como texto, o null si no se informó. Nuevo en 0.2.1 (Q-B10).
   *
   * @return String|null
   */
  public function getDDonacDecimal(): ?String
  {
    return isset($this->dDonac) ? self::exacto($this->dDonacDecimal, $this->dDonac) : null;
  }

  /**
   * Obtiene el valor de dDesDonac
   *
   * @return String
   */
  public function getDDesDonac(): String
  {
    return $this->dDesDonac;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML Element
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gGrupSup');
    // Todos los campos de tgGrupSup son opcionales (DE_v150.xsd:663-690); hasta v0.1.5 se emitían sin guardas (PK-08).
    if (isset($this->dNomCaj))
      $res->appendChild(XmlHelper::elemento($doc, 'dNomCaj', $this->getDNomCaj()));
    if (isset($this->dEfectivo))
      $res->appendChild(XmlHelper::elemento($doc, 'dEfectivo', $this->getDEfectivoDecimal()));
    if (isset($this->dVuelto))
      $res->appendChild(XmlHelper::elemento($doc, 'dVuelto', $this->getDVueltoDecimal()));
    if (isset($this->dDonac))
      $res->appendChild(XmlHelper::elemento($doc, 'dDonac', $this->getDDonacDecimal()));
    if (isset($this->dDesDonac))
      $res->appendChild(XmlHelper::elemento($doc, 'dDesDonac', $this->getDDesDonac()));
    return $res;
  }

  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object): self
  {
    $res = new GGrupSup();
    if (isset($object->dNomCaj)) {
      $res->setDNomCaj($object->dNomCaj);
    }
    if (isset($object->dEfectivo)) {
      $res->setDEfectivo($object->dEfectivo);
    }
    if (isset($object->dVuelto)) {
      $res->setDVuelto($object->dVuelto);
    }
    if (isset($object->dDonac)) {
      $res->setDDonac($object->dDonac);
    }
    if (isset($object->dDesDonac)) {
      $res->setDDesDonac($object->dDesDonac);
    }
    return $res;
  }

  /**
   * Instancia un objeto GGrupSup a partir de un DOMElement (E810, tgGrupSup, DE_v150.xsd:663-690; todos los
   * campos son opcionales). No existía hasta 0.2.0 y GCamEsp::FromDOMElement fallaba con Error (PK-25).
   * Los montos se guardan como int, igual que en los setters: si el XML trae decimales, se truncan.
   *
   * @param DOMElement $node Nodo gGrupSup.
   *
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if (strcmp($node->localName, 'gGrupSup') != 0)
      throw new \InvalidArgumentException('[GGrupSup] El nombre del nodo no corresponde a gGrupSup: ' . $node->localName);
    $res = new GGrupSup();
    foreach ($node->childNodes as $hijo) {
      if ($hijo instanceof DOMElement)
        self::asignar($res, $hijo->localName, $hijo->nodeValue);
    }
    return $res;
  }

  /**
   * Instancia un objeto GGrupSup a partir de un SimpleXMLElement. No existía hasta 0.2.0 y
   * GCamEsp::FromSimpleXMLElement fallaba con Error (PK-25).
   *
   * @param SimpleXMLElement $node Nodo gGrupSup.
   *
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if (strcmp($node->getName(), 'gGrupSup') != 0)
      throw new \InvalidArgumentException('[GGrupSup] El nombre del nodo no corresponde a gGrupSup: ' . $node->getName());
    $res = new GGrupSup();
    foreach ($node->children() as $hijo)
      self::asignar($res, $hijo->getName(), (string) $hijo);
    return $res;
  }

  private static function asignar(GGrupSup $res, string $campo, string $valor): void
  {
    match ($campo) {
      'dNomCaj' => $res->setDNomCaj($valor),
      'dEfectivo' => $res->setDEfectivo($valor),
      'dVuelto' => $res->setDVuelto($valor),
      'dDonac' => $res->setDDonac($valor),
      'dDesDonac' => $res->setDDesDonac($valor),
      default => null,
    };
  }

  /**
   * Valida un monto contra tMontoBase4/tMontoBase6 (xs:decimal con fractionDigits 4 y totalDigits 19 o 10,
   * DE_Types_v150.xsd) y lo devuelve como texto, sin redondear. Como en xs:decimal, los ceros a la izquierda
   * y los decimales finales en cero no cuentan.
   */
  private static function monto(int|String $valor, String $campo, int $totalDigitos): String
  {
    $texto = trim((string) $valor);
    if (!preg_match('/^-?(\d+)(?:\.(\d+))?$/', $texto, $m))
      throw new \InvalidArgumentException("[GGrupSup] $campo debe ser un número decimal: '$texto'");
    $enteros = ltrim($m[1], '0');
    $decimales = rtrim($m[2] ?? '', '0');
    if (strlen($decimales) > 4 || strlen($enteros) + strlen($decimales) > $totalDigitos)
      throw new \InvalidArgumentException("[GGrupSup] $campo admite hasta $totalDigitos dígitos, de los cuales hasta 4 decimales (DE_Types_v150.xsd): '$texto'");
    return $texto;
  }

  /** Monto exacto, salvo que la propiedad pública entera se haya asignado directamente con otro valor. */
  private static function exacto(?String $decimal, int $entero): String
  {
    return ($decimal !== null && intval($decimal) === $entero) ? $decimal : (string) $entero;
  }
}
