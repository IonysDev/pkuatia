<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use DateTime;
use DOMDocument;
use DOMElement;
use IonysDev\Pkuatia\Helpers\XmlHelper;
use SimpleXMLElement;

/**
 * E820 Grupo de datos adicionales de uso comercial PADRE E790
 */
class GGrupAdi
{
  public ?String $dCiclo;     //E821 Ciclo 
  public ?DateTime $dFecIniC; //E822 Fecha de inicio de ciclo
  public ?DateTime $dFecFinC; //E823 Fecha de fin de ciclo
  public ?DateTime $dVencPag; //E824 Fecha de vencimiento de pago
  public ?String $dContrato; //E825 Número de contrato
  public ?String $dSalAnt;   //E826 Saldo anterior
  public ?String $dCodConDncp; //E827 Código de contratación de la DNCP

  /** @var list<DateTime> Ocurrencias de dVencPag después de la primera: hasta 3 en total (tgGrupAdi, DE_v150.xsd:829; Q-B9). */
  private array $dVencPagAdicionales = [];

  /////////////////////////////////////////////
  //setters
  /////////////////////////////////////////////


  /**
   * Establece el valor de ciclo
   *
   * @param String $dCiclo
   *
   * @return self
   */
  public function setDCiclo(String $dCiclo): self
  {
    $this->dCiclo = $dCiclo;

    return $this;
  }


  /**
   * Establece el valor de dFecIniC
   *
   * @param ?DateTime $dFecIniC
   *
   * @return self
   */
  public function setDFecIniC(?DateTime $dFecIniC): self
  {
    $this->dFecIniC = $dFecIniC;

    return $this;
  }


  /**
   * Establece el valor de dFecFinC
   *
   * @param ?DateTime $dFecFinC
   *
   * @return self
   */
  public function setDFecFinC(?DateTime $dFecFinC): self
  {
    $this->dFecFinC = $dFecFinC;

    return $this;
  }


  /**
   * Establece el valor de dVencPag
   *
   * @param ?DateTime $dVencPag
   *
   * @return self
   */
  public function setDVencPag(?DateTime $dVencPag): self
  {
    $this->dVencPag = $dVencPag;
    $this->dVencPagAdicionales = []; // set reemplaza todas las ocurrencias, como hasta 0.2.0 (Q-B9)

    return $this;
  }


  /**
   * Establece el valor de dContrato
   *
   * @param String $dContrato
   *
   * @return self
   */
  public function setDContrato(String $dContrato): self
  {
    $this->dContrato = $dContrato;

    return $this;
  }


  /**
   * Establece el valor de dSalAnt
   *
   * @param ?String $dSalAnt (decimal BCMAth)
   *
   * @return self
   */
  public function setDSalAnt(?String $dSalAnt): self
  {
    $this->dSalAnt = $dSalAnt;

    return $this;
  }

  /**
   * Establece el valor de dCodConDncp
   *
   * @param ?String $dCodConDncp
   *
   * @return self
   */
  public function setdCodConDncp(?String $dCodConDncp): self
  {
    $this->dCodConDncp = $dCodConDncp;

    return $this;
  }

  /////////////////////////////////////////////
  //GETTERS
  /////////////////////////////////////////////
  

  /**
   * Obtiene el valor de ciclo
   *
   * @return String
   */
  public function getDCiclo(): String
  {
    return $this->dCiclo;
  }

  /**
   * Obtiene el valor de dFecIniC
   *
   * @return ?DateTime
   */
  public function getDFecIniC(): ?DateTime
  {
    return $this->dFecIniC;
  }

  /**
   * Obtiene el valor de dFecFinC
   *
   * @return ?DateTime
   */
  public function getDFecFinC(): ?DateTime
  {
    return $this->dFecFinC;
  }

  /**
   * Obtiene el valor de dVencPag
   *
   * @return ?DateTime
   */
  public function getDVencPag(): ?DateTime
  {
    return $this->dVencPag;
  }

  /**
   * Agrega una fecha de vencimiento de pago: dVencPag admite hasta 3 ocurrencias (tgGrupAdi,
   * DE_v150.xsd:829). Si no hay ninguna, equivale a setDVencPag(). Nuevo en 0.2.1 (Q-B9).
   *
   * @param DateTime $dVencPag
   *
   * @throws \InvalidArgumentException Si ya hay 3 fechas.
   *
   * @return self
   */
  public function addDVencPag(DateTime $dVencPag): self
  {
    if (!isset($this->dVencPag)) {
      $this->dVencPag = $dVencPag;
      return $this;
    }
    if (1 + count($this->dVencPagAdicionales) >= 3)
      throw new \InvalidArgumentException('[GGrupAdi] dVencPag admite como máximo 3 ocurrencias (tgGrupAdi, DE_v150.xsd:829).');
    $this->dVencPagAdicionales[] = $dVencPag;
    return $this;
  }

  /**
   * Todas las fechas de vencimiento de pago, en orden (la primera es la de getDVencPag()). Nuevo en 0.2.1 (Q-B9).
   *
   * @return list<DateTime>
   */
  public function getDVencPags(): array
  {
    return array_merge(isset($this->dVencPag) ? [$this->dVencPag] : [], $this->dVencPagAdicionales);
  }

  /**
   * Obtiene el valor de dContrato
   *
   * @return String
   */
  public function getDContrato(): String
  {
    return $this->dContrato;
  }

  /**
   * Obtiene el valor de dSalAnt
   *
   * @return ?float
   */
  public function getDSalAnt(): ?float
  {
    return $this->dSalAnt;
  }


  /**
   * Obtiene el valor de dCodConDncp
   *
   * @return ?String
   */
  public function getdCodConDncp(): ?String
  {
    return $this->dCodConDncp;
  }

  /////////////////////////////////////////////
  //FUNCTIONS
  /////////////////////////////////////////////
  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('gGrupAdi');
    // Todos los campos de tgGrupAdi son opcionales (DE_v150.xsd:811-846) y las fechas son tFecAAAAMMDDguion (AAAA-MM-DD).
    // Hasta v0.1.5 se emitían sin guardas (Error en propiedades sin inicializar) y con el formato 'yyyy-mm-dd' (PK-07).
    if (isset($this->dCiclo))
      $res->appendChild(XmlHelper::elemento($doc, 'dCiclo', $this->dCiclo));
    if (isset($this->dFecIniC))
      $res->appendChild(XmlHelper::elemento($doc, 'dFecIniC', $this->dFecIniC->format('Y-m-d')));
    if (isset($this->dFecFinC))
      $res->appendChild(XmlHelper::elemento($doc, 'dFecFinC', $this->dFecFinC->format('Y-m-d')));
    foreach ($this->getDVencPags() as $vencimiento) // hasta 3 ocurrencias (DE_v150.xsd:829; Q-B9)
      $res->appendChild(XmlHelper::elemento($doc, 'dVencPag', $vencimiento->format('Y-m-d')));
    if (isset($this->dContrato))
      $res->appendChild(XmlHelper::elemento($doc, 'dContrato', $this->dContrato));
    if (isset($this->dSalAnt))
      $res->appendChild(XmlHelper::elemento($doc, 'dSalAnt', $this->dSalAnt));
    if (isset($this->dCodConDncp))
      $res->appendChild(XmlHelper::elemento($doc, 'dCodConDncp', $this->dCodConDncp));
    return $res;
  }
  
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
  {
    // Hasta 0.2.0 se buscaba "ciclo" (el elemento es dCiclo) y las fechas llegaban como texto a setters
    // DateTime: TypeError en cuanto había una fecha (PK-25).
    $res = new GGrupAdi();
    foreach(get_object_vars($object) as $campo => $valor)
    {
      // Los elementos repetidos (dVencPag, hasta 3) llegan como arreglo (Q-B9).
      foreach((is_array($valor) ? $valor : [$valor]) as $unValor)
      {
        if(is_scalar($unValor))
          self::asignar($res, $campo, (string) $unValor);
      }
    }
    return $res;
  }

  /**
   * Instancia un objeto GGrupAdi a partir de un DOMElement (E820, tgGrupAdi, DE_v150.xsd:811-846; todos los
   * campos son opcionales). No existía hasta 0.2.0 y GCamEsp::FromDOMElement fallaba con Error (PK-25).
   *
   * @param DOMElement $node Nodo gGrupAdi.
   *
   * @return self
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if (strcmp($node->localName, 'gGrupAdi') != 0)
      throw new \InvalidArgumentException('[GGrupAdi] El nombre del nodo no corresponde a gGrupAdi: ' . $node->localName);
    $res = new GGrupAdi();
    foreach ($node->childNodes as $hijo) {
      if ($hijo instanceof DOMElement)
        self::asignar($res, $hijo->localName, $hijo->nodeValue);
    }
    return $res;
  }

  /**
   * Instancia un objeto GGrupAdi a partir de un SimpleXMLElement. No existía hasta 0.2.0 y
   * GCamEsp::FromSimpleXMLElement fallaba con Error (PK-25).
   *
   * @param SimpleXMLElement $node Nodo gGrupAdi.
   *
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $node): self
  {
    if (strcmp($node->getName(), 'gGrupAdi') != 0)
      throw new \InvalidArgumentException('[GGrupAdi] El nombre del nodo no corresponde a gGrupAdi: ' . $node->getName());
    $res = new GGrupAdi();
    foreach ($node->children() as $hijo)
      self::asignar($res, $hijo->getName(), (string) $hijo);
    return $res;
  }

  private static function asignar(GGrupAdi $res, string $campo, string $valor): void
  {
    match ($campo) {
      'dCiclo' => $res->setDCiclo($valor),
      'dFecIniC' => $res->setDFecIniC(self::fecha($valor, $campo)),
      'dFecFinC' => $res->setDFecFinC(self::fecha($valor, $campo)),
      'dVencPag' => $res->addDVencPag(self::fecha($valor, $campo)),
      'dContrato' => $res->setDContrato($valor),
      'dSalAnt' => $res->setDSalAnt($valor),
      'dCodConDncp' => $res->setdCodConDncp($valor),
      default => null,
    };
  }

  /** tFecAAAAMMDDguion (AAAA-MM-DD), con la hora en cero para que la ida y vuelta sea exacta. */
  private static function fecha(string $valor, string $campo): DateTime
  {
    $fecha = DateTime::createFromFormat('!Y-m-d', trim($valor));
    if ($fecha === false)
      throw new \InvalidArgumentException("[GGrupAdi] $campo debe tener el formato AAAA-MM-DD (tFecAAAAMMDDguion): '$valor'");
    return $fecha;
  }
}
