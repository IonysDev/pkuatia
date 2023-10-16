<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\Event\GEA;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * ID:GEDF001 rGeDevCCFFCue Raíz Gestión de Eventos de devolución de créditos fiscales - Cuestionado PADRE:GDE007
 */
class RGeDevCCFFCue
{
                              // ID - DESCRIPCION- LONGITUD - OCURRENCIA
  public String $Id;          //GEDF002 - CDC del DE/DTE - 40 - 1-1
  public String $dNumDevSol;  //GEDF003 - Número DIR - 10 - 1-1
  public String $dNumDevInf;  //GEDF004 - Número de informe - 10 - 1-1
  public String $dNumDevRes;  //GEDF005 - Número de resolución de la devolución - 10 - 1-1
  public DateTime $dFeEmiSol; //GEDF006 - Fecha de emisión de DIR - 19 - 1-1
  public DateTime $dFeEmiInf; //GEDF007 - Fecha de emisión del informe - 19 - 1-1
  public DateTime $dFeEmiRes; //GEDF008 - Fecha de emisión de la resolución - 19 - 1-1

  ///////////////////////////////////////////////////////////////////////
  ///SETTERS
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de Id
   *
   * @param String $Id
   *
   * @return self
   */
  public function setId(String $Id): self
  {
    $this->Id = $Id;

    return $this;
  }


  /**
   * Establece el valor de dNumDevSol
   *
   * @param String $dNumDevSol
   *
   * @return self
   */
  public function setDNumDevSol(String $dNumDevSol): self
  {
    $this->dNumDevSol = $dNumDevSol;

    return $this;
  }


  /**
   * Establece el valor de dNumDevInf
   *
   * @param String $dNumDevInf
   *
   * @return self
   */
  public function setDNumDevInf(String $dNumDevInf): self
  {
    $this->dNumDevInf = $dNumDevInf;

    return $this;
  }


  /**
   * Establece el valor de dNumDevRes
   *
   * @param String $dNumDevRes
   *
   * @return self
   */
  public function setDNumDevRes(String $dNumDevRes): self
  {
    $this->dNumDevRes = $dNumDevRes;

    return $this;
  }


  /**
   * Establece el valor de dFeEmiSol
   *
   * @param DateTime $dFeEmiSol
   *
   * @return self
   */
  public function setDFeEmiSol(DateTime $dFeEmiSol): self
  {
    $this->dFeEmiSol = $dFeEmiSol;

    return $this;
  }


  /**
   * Establece el valor de dFeEmiInf
   *
   * @param DateTime $dFeEmiInf
   *
   * @return self
   */
  public function setDFeEmiInf(DateTime $dFeEmiInf): self
  {
    $this->dFeEmiInf = $dFeEmiInf;

    return $this;
  }


  /**
   * Establece el valor de dFeEmiRes
   *
   * @param DateTime $dFeEmiRes
   *
   * @return self
   */
  public function setDFeEmiRes(DateTime $dFeEmiRes): self
  {
    $this->dFeEmiRes = $dFeEmiRes;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  //GETTERS
  ///////////////////////////////////////////////////////////////////////


  /**
   * Obtiene el valor de Id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->Id;
  }

  /**
   * Obtiene el valor de dNumDevSol
   *
   * @return String
   */
  public function getDNumDevSol(): String
  {
    return $this->dNumDevSol;
  }

  /**
   * Obtiene el valor de dNumDevInf
   *
   * @return String
   */
  public function getDNumDevInf(): String
  {
    return $this->dNumDevInf;
  }

  /**
   * Obtiene el valor de dNumDevRes
   *
   * @return String
   */
  public function getDNumDevRes(): String
  {
    return $this->dNumDevRes;
  }

  /**
   * Obtiene el valor de dFeEmiSol
   *
   * @return DateTime
   */
  public function getDFeEmiSol(): DateTime
  {
    return $this->dFeEmiSol;
  }

  /**
   * Obtiene el valor de dFeEmiInf
   *
   * @return DateTime
   */
  public function getDFeEmiInf(): DateTime
  {
    return $this->dFeEmiInf;
  }

  /**
   * Obtiene el valor de dFeEmiRes
   *
   * @return DateTime
   */
  public function getDFeEmiRes(): DateTime
  {
    return $this->dFeEmiRes;
  }

  ///////////////////////////////////////////////////////////////////////
  ///XML ELEMENT
  ///////////////////////////////////////////////////////////////////////

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(DOMDocument $doc): DOMElement
  {
    $res = $doc->createElement('rGeDevCCFFCue');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumDevSol', $this->getDNumDevSol()));
    $res->appendChild(new DOMElement('dNumDevInf', $this->getDNumDevInf()));
    $res->appendChild(new DOMElement('dNumDevRes', $this->getDNumDevRes()));
    $res->appendChild(new DOMElement('dFeEmiSol', $this->getDFeEmiSol()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFeEmiInf', $this->getDFeEmiInf()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFeEmiRes', $this->getDFeEmiRes()->format('Y-m-d')));

    return $res;
  }


  // /**
  //  * fromDOMElement
  //  *
  //  * @param  mixed $xml
  //  * @return TrGeVeRetAce
  //  */
  // public static function fromDOMElement(DOMElement $xml): RGeDevCCFFCue
  // {
  //   if (strcmp($xml->tagName, "rGeDevCCFFCue") == 0 && $xml->childElementCount == 7) {
  //     $res = new RGeDevCCFFCue();
  //     $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
  //     $res->setDNumDevSol($xml->getElementsByTagName('dNumDevSol')->item(0)->nodeValue);
  //     $res->setDNumDevInf($xml->getElementsByTagName('dNumDevInf')->item(0)->nodeValue);
  //     $res->setDNumDevRes($xml->getElementsByTagName('dNumDevRes')->item(0)->nodeValue);
  //     $res->setDFeEmiSol(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeEmiSol')->item(0)->nodeValue));
  //     $res->setDFeEmiInf(DateTime::createFromFormat('Y-m-d',$xml->getElementsByTagName('dFeEmiInf')->item(0)->nodeValue));
  //     $res->setDFeEmiRes(DateTime::createFromFormat('Y-m-d',$xml->getElementsByTagName('dFeEmiRes')->item(0)->nodeValue));

  //     return $res;
  //   } else {
  //     throw new \Exception("Invalid XML Element: $xml->tagName");
  //     return null;
  //   }
  // }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
    if($node->getName() != 'rGeDevCCFFCue')
      throw new \Exception("Invalid XML Element: $node->getName()");

    $res = new RGeDevCCFFCue();
    $res->setId($node->Id);
    $res->setDNumDevSol($node->dNumDevSol);
    $res->setDNumDevInf($node->dNumDevInf);
    $res->setDNumDevRes($node->dNumDevRes);
    $res->setDFeEmiSol(DateTime::createFromFormat('Y-m-d', $node->dFeEmiSol));
    $res->setDFeEmiInf(DateTime::createFromFormat('Y-m-d',$node->dFeEmiInf));
    $res->setDFeEmiRes(DateTime::createFromFormat('Y-m-d',$node->dFeEmiRes));

    return $res;
  }
}
