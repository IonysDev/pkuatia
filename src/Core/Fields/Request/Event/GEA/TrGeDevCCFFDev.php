<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\events\GEA;

use DateTime;
use DOMElement;

/**
 * ID:GEDD001 Raíz Gestión de Eventos de devolución de créditos fiscales -Devuelto PADRE:GDE007
 */
class TrGeDevCCFFDev
{
  public string $Id; // GEDD002 CDC del DE/DTE
  public string $dNumDevSol; // GEDD003 Número DIR
  public string $dNumDevInf; // GEDD004 Número de informe
  public string $dNumDevRes; // GEDD005 Número de resolución de la devolución
  public DateTime $dFeEmiSol; ///GEDD006 Fecha de emisión de DIR
  public DateTime $dFeEmiInf; // GEDD007 Fecha de emisión del informe
  public DateTime $dFeEmiRes; // GEDD008  Fecha de emisión de la resolución

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of Id
   *
   * @param string $Id
   *
   * @return self
   */
  public function setId(string $Id): self
  {
    $this->Id = $Id;

    return $this;
  }


  /**
   * Set the value of dNumDevSol
   *
   * @param string $dNumDevSol
   *
   * @return self
   */
  public function setDNumDevSol(string $dNumDevSol): self
  {
    $this->dNumDevSol = $dNumDevSol;

    return $this;
  }


  /**
   * Set the value of dNumDevInf
   *
   * @param string $dNumDevInf
   *
   * @return self
   */
  public function setDNumDevInf(string $dNumDevInf): self
  {
    $this->dNumDevInf = $dNumDevInf;

    return $this;
  }


  /**
   * Set the value of dNumDevRes
   *
   * @param string $dNumDevRes
   *
   * @return self
   */
  public function setDNumDevRes(string $dNumDevRes): self
  {
    $this->dNumDevRes = $dNumDevRes;

    return $this;
  }


  /**
   * Set the value of dFeEmiSol
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
   * Set the value of dFeEmiInf
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
   * Set the value of dFeEmiRes
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

  //====================================================//
  ///GETTERS
  //====================================================//



  /**
   * Get the value of Id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->Id;
  }

  /**
   * Get the value of dNumDevSol
   *
   * @return string
   */
  public function getDNumDevSol(): string
  {
    return $this->dNumDevSol;
  }

  /**
   * Get the value of dNumDevInf
   *
   * @return string
   */
  public function getDNumDevInf(): string
  {
    return $this->dNumDevInf;
  }

  /**
   * Get the value of dNumDevRes
   *
   * @return string
   */
  public function getDNumDevRes(): string
  {
    return $this->dNumDevRes;
  }

  /**
   * Get the value of dFeEmiSol
   *
   * @return DateTime
   */
  public function getDFeEmiSol(): DateTime
  {
    return $this->dFeEmiSol;
  }

  /**
   * Get the value of dFeEmiInf
   *
   * @return DateTime
   */
  public function getDFeEmiInf(): DateTime
  {
    return $this->dFeEmiInf;
  }

  /**
   * Get the value of dFeEmiRes
   *
   * @return DateTime
   */
  public function getDFeEmiRes(): DateTime
  {
    return $this->dFeEmiRes;
  }

  //====================================================//
  ///XML Element
  //====================================================//


  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('trGeDevCCFFDev');

    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumDevSol', $this->getDNumDevSol()));
    $res->appendChild(new DOMElement('dNumDevInf', $this->getDNumDevInf()));
    $res->appendChild(new DOMElement('dNumDevRes', $this->getDNumDevRes()));
    $res->appendChild(new DOMElement('dFeEmiSol', $this->getDFeEmiSol()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFeEmiInf', $this->getDFeEmiInf()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dFeEmiRes', $this->getDFeEmiRes()->format('Y-m-d')));

    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return TrGeVeRetAce
   */
  public static function fromDOMElement(DOMElement $xml): TrGeDevCCFFDev
  {
    if (strcmp($xml->tagName, "trGeDevCCFFDev") == 0 && $xml->childElementCount == 7) {
      $res = new TrGeDevCCFFDev();
      $res->setId($xml->getElementsByTagName('Id')->item(0)->nodeValue);
      $res->setDNumDevSol($xml->getElementsByTagName('dNumDevSol')->item(0)->nodeValue);
      $res->setDNumDevInf($xml->getElementsByTagName('dNumDevInf')->item(0)->nodeValue);
      $res->setDNumDevRes($xml->getElementsByTagName('dNumDevRes')->item(0)->nodeValue);
      $res->setDFeEmiSol(DateTime::createFromFormat('Y-m-d',$xml->getElementsByTagName('dFeEmiSol')->item(0)->nodeValue));
      $res->setDFeEmiInf(DateTime::createFromFormat('Y-m-d',$xml->getElementsByTagName('dFeEmiInf')->item(0)->nodeValue));
      $res->setDFeEmiRes(DateTime::createFromFormat('Y-m-d',$xml->getElementsByTagName('dFeEmiRes')->item(0)->nodeValue));

      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}