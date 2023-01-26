<?php

namespace Abiliomp\Pkuatia\Fields\Request\events\GEA;

use DateTime;
use DOMElement;

/**
 *  ID:GER001 rGeVeRetAce Raíz Gestión de Eventos de retención PADRE:GDE007
 */
class RGeVeRetAce
{
  public string $Id; ///GER002 CDC del DE/DTE
  public int $dNumTimRet; /// GER003 Número de timbrado del documento de retención
  public string $dEstRet; //GER004 Establecimiento
  public string $dPunExpRet; ///GER005 Punto de expedición
  public string $dNumDocRet; ///GER006  Número del documento
  public string $dCodConRet; /// GER007 Identificador de la retención
  public DateTime $dFeEmiRet; ///GER008  Fecha de emisión de  la retención

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
   * Set the value of dNumTimRet
   *
   * @param int $dNumTimRet
   *
   * @return self
   */
  public function setDNumTimRet(int $dNumTimRet): self
  {
    $this->dNumTimRet = $dNumTimRet;

    return $this;
  }


  /**
   * Set the value of dEstRet
   *
   * @param string $dEstRet
   *
   * @return self
   */
  public function setDEstRet(string $dEstRet): self
  {
    $this->dEstRet = $dEstRet;

    return $this;
  }


  /**
   * Set the value of dPunExpRet
   *
   * @param string $dPunExpRet
   *
   * @return self
   */
  public function setDPunExpRet(string $dPunExpRet): self
  {
    $this->dPunExpRet = $dPunExpRet;

    return $this;
  }


  /**
   * Set the value of dNumDocRet
   *
   * @param string $dNumDocRet
   *
   * @return self
   */
  public function setDNumDocRet(string $dNumDocRet): self
  {
    $this->dNumDocRet = $dNumDocRet;

    return $this;
  }


  /**
   * Set the value of dCodConRet
   *
   * @param string $dCodConRet
   *
   * @return self
   */
  public function setDCodConRet(string $dCodConRet): self
  {
    $this->dCodConRet = $dCodConRet;

    return $this;
  }


  /**
   * Set the value of dFeEmiRet
   *
   * @param DateTime $dFeEmiRet
   *
   * @return self
   */
  public function setDFeEmiRet(DateTime $dFeEmiRet): self
  {
    $this->dFeEmiRet = $dFeEmiRet;

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
   * Get the value of dNumTimRet
   *
   * @return int
   */
  public function getDNumTimRet(): int
  {
    return $this->dNumTimRet;
  }

  /**
   * Get the value of dEstRet
   *
   * @return string
   */
  public function getDEstRet(): string
  {
    return $this->dEstRet;
  }

  /**
   * Get the value of dPunExpRet
   *
   * @return string
   */
  public function getDPunExpRet(): string
  {
    return $this->dPunExpRet;
  }

  /**
   * Get the value of dNumDocRet
   *
   * @return string
   */
  public function getDNumDocRet(): string
  {
    return $this->dNumDocRet;
  }

  /**
   * Get the value of dCodConRet
   *
   * @return string
   */
  public function getDCodConRet(): string
  {
    return $this->dCodConRet;
  }

  /**
   * Get the value of dFeEmiRet
   *
   * @return DateTime
   */
  public function getDFeEmiRet(): DateTime
  {
    return $this->dFeEmiRet;
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
    $res = new DOMElement('rGeVeRetAce');
    $res->appendChild(new DOMElement('Id', $this->getId()));
    $res->appendChild(new DOMElement('dNumTimRet', $this->getDNumTimRet()));
    $res->appendChild(new DOMElement('dEstRet', $this->getDEstRet()));
    $res->appendChild(new DOMElement('dPunExpRet', $this->getDPunExpRet()));
    $res->appendChild(new DOMElement('dNumDocRet', $this->getDNumDocRet()));
    $res->appendChild(new DOMElement('dCodConRet', $this->getDCodConRet()));
    $res->appendChild(new DOMElement('dFeEmiRet', $this->getDFeEmiRet()->format('Y-m-d')));
    return $res;
  }
}
