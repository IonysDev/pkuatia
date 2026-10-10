<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\DE;;

use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use SimpleXMLElement;
use stdClass;

/**
 * ContDE01 - Contenedor de la respuesta del DE consultado
 */
class RContDe
{
                           // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public RDE $rDe;         // ContDE02 - Archivo XML del DE ContDE01 - X - 1-1
  public String $dProtAut; // ContDE03 - Número De Transacción - X - 1-1
  public RContEv $rContEv; // ContDE04 - Contenedor de Evento - X - 0-n (primer evento; ver getRContEvs())

  /** @var list<RContEv> Todos los eventos de xContEv, en orden (ContDE04 es 0-n; hasta 0.2.0 solo se guardaba uno, PK-29). */
  private array $rContEvs = [];

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de rDe
   *
   * @param RDE $rDe
   *
   * @return self
   */
  public function setRDe(RDE $rDe): self
  {
    $this->rDe = $rDe;

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
   * Establece el valor de rContEv
   *
   * @param RContEv $rContEv
   *
   * @return self
   */
  public function setRContEv(RContEv $rContEv): self
  {
    $this->rContEv = $rContEv;
    $this->rContEvs = [$rContEv]; // set reemplaza la lista, como hasta 0.2.0
    return $this;
  }

  /**
   * Agrega un evento al contenedor (ContDE04 es 0-n). Si no hay ninguno, equivale a setRContEv(). Nuevo en 0.2.1 (PK-29).
   *
   * @param RContEv $rContEv
   *
   * @return self
   */
  public function addRContEv(RContEv $rContEv): self
  {
    if (!isset($this->rContEv))
      return $this->setRContEv($rContEv);
    $this->rContEvs[] = $rContEv;
    return $this;
  }


  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Obtiene el valor de rDe
   *
   * @return RDE
   */
  public function getRDe(): RDE | null
  {
    return isset($this->rDe) ? $this->rDe : null;
  }

  /**
   * Obtiene el valor de dProtAut
   *
   * @return String
   */
  public function getDProtAut(): String
  {
    return $this->dProtAut;
  }

  /**
   * Obtiene el valor de rContEv
   *
   * @return RContEv
   */
  public function getRContEv(): RContEv | null
  {
    return isset($this->rContEv) ? $this->rContEv : null;
  }

  /**
   * Todos los eventos registrados del DE, en el orden en que los devuelve el SIFEN (el primero es el de
   * getRContEv()). Vacío si no hay eventos. Nuevo en 0.2.1 (PK-29).
   *
   * @return list<RContEv>
   */
  public function getRContEvs(): array
  {
    if (!empty($this->rContEvs))
      return $this->rContEvs;
    return isset($this->rContEv) ? [$this->rContEv] : [];
  }

  /**
   * Crea una nueva instancia de RContDe a partir de un objeto SimpleXMLElement.
   * 
   * @param SimpleXMLElement $xml
   * 
   * @return self
   */
  public static function FromSimpleXMLElement(SimpleXMLElement $xml): self
  {

    if(strcmp($xml->getName(),'rContDe') != 0) {
      throw new \Exception("Invalid XML Element:". $xml->getName());
    }
    
    $res = new self();
    if (isset($xml->dProtAut)) {
      $res->setDProtAut((String) $xml->dProtAut);
    }
    if (isset($xml->rDE)) {
      $res->setRDe(RDE::FromSimpleXMLElement($xml->rDE));
    }
    ///el nodo xcontEv  siempre viene, pero puede estar vacio, asi que no se valida
    //se valida su hijo que es rContEv
    if (isset($xml->xContEv->rContEv)) {
      foreach ($xml->xContEv->rContEv as $rContEv) // ContDE04 es 0-n: hasta 0.2.0 se leía solo el primero (PK-29)
        $res->addRContEv(RContEv::FromSimpleXMLElement($rContEv));
    }
    return $res;
  }

  /**
   * Crea una nueva instancia de RContDe a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   *
   * @param stdClass $object
   * 
   * @return self
   */
  public static function FromSifenResponseObject($object) : self
  {
    $res = new self();
    if (isset($object->dProtAut)) {
      $res->setDProtAut($object->dProtAut);
    }
    return $res;
  }

  /**
   * Interpreta el contenido de xContenDE tal como lo devuelve la consulta de DE. No es un documento XML: es
   * texto con una declaración XML, el rDE firmado, "\n<dProtAut>", "\n<xContEv>" con un rContEv por evento
   * (cada xEvento trae su propia declaración) y un espacio final. Formato verificado con las capturas reales
   * del 09/10/2026 (ekuat-ia/06-ejemplos/respuestas-ws/2026-10-09/05 y 09, observaciones 4 y 5).
   * Nuevo en 0.2.1 (PK-29): reemplaza el envoltorio artificial que exigía un espacio después de "<rDE" y que
   * guardaba solo el primer evento.
   *
   * @param String $xContenDE Texto de xContenDE, ya decodificado (como lo entrega SoapClient).
   *
   * @throws \InvalidArgumentException Si no contiene un rDE o alguna de sus partes no es XML bien formado.
   *
   * @return self
   */
  public static function FromXContenDE(String $xContenDE): self
  {
    if (!preg_match('/<rDE[\s>]/', $xContenDE, $m, PREG_OFFSET_CAPTURE))
      throw new \InvalidArgumentException('[RContDe] xContenDE no contiene el elemento rDE.');
    $inicio = $m[0][1];
    $fin = strrpos($xContenDE, '</rDE>');
    if ($fin === false || $fin < $inicio)
      throw new \InvalidArgumentException('[RContDe] xContenDE no contiene el cierre del elemento rDE.');
    $fin += strlen('</rDE>');

    $res = new self();
    $res->setRDe(RDE::FromSimpleXMLElement(self::cargar(substr($xContenDE, $inicio, $fin - $inicio))));
    $resto = substr($xContenDE, $fin);
    $posEventos = strpos($resto, '<xContEv>');
    // El dProtAut del DE va antes de xContEv; dentro de xContEv cada evento trae el suyo.
    $antesDeEventos = $posEventos === false ? $resto : substr($resto, 0, $posEventos);
    if (preg_match('#<dProtAut>(.*?)</dProtAut>#s', $antesDeEventos, $p))
      $res->setDProtAut(trim($p[1]));
    if ($posEventos !== false && preg_match('#<xContEv>(.*)</xContEv>#s', $resto, $e) && trim($e[1]) !== '') {
      // Cada xEvento empieza con su propia declaración XML: se quita para cargar el contenedor como un documento.
      $contenedor = self::cargar('<xContEv>' . preg_replace('/<\?xml[^>]*\?>/', '', $e[1]) . '</xContEv>');
      foreach ($contenedor->rContEv as $rContEv)
        $res->addRContEv(RContEv::FromSimpleXMLElement($rContEv));
    }
    return $res;
  }

  private static function cargar(String $xml): SimpleXMLElement
  {
    $previo = libxml_use_internal_errors(true);
    try {
      $sx = simplexml_load_string($xml);
      if ($sx === false) {
        $error = libxml_get_last_error();
        throw new \InvalidArgumentException('[RContDe] Parte de xContenDE que no es XML bien formado: ' . ($error ? trim($error->message) : 'error desconocido'));
      }
      return $sx;
    } finally {
      libxml_clear_errors();
      libxml_use_internal_errors($previo);
    }
  }
}
