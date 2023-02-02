<?php

namespace Abiliomp\Pkuatia\Fields\E;

use DateTime;
use DOMElement;

/**
 * ID:E750 Grupo de rastreo de la mercadería PADRE:E700
 */
class GRasMerc
{
  public int $dNumLote; //E751 Número de lote 
  public DateTime $dVencMerc; ///E752 Fecha de vencimiento  de la mercadería
  public string $dNSerie; //E753  Número de serie
  public string $dNumPedi; //E754 Número de pedido
  public string $dNumSegui; //E755 Número de  seguimiento del envío
  public string $dNomImp; //E756 Nombre del Importador
  public string $dDirImp; //E757 Dirección de Importador
  public string $dNumFir; //E758 Número de registro de la firma del importador
  public string $dNumReg; //E759 Número de registro del  producto otorgado por  el SENAVE
  public string $dNumRegEntCom; //E760  Número de registro de  entidad comercial otorgado por el SENAVE

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of dNumLote
   *
   * @param int $dNumLote
   *
   * @return self
   */
  public function setDNumLote(int $dNumLote): self
  {
    $this->dNumLote = $dNumLote;

    return $this;
  }


  /**
   * Set the value of dVencMerc
   *
   * @param DateTime $dVencMerc
   *
   * @return self
   */
  public function setDVencMerc(DateTime $dVencMerc): self
  {
    $this->dVencMerc = $dVencMerc;

    return $this;
  }


  /**
   * Set the value of dNSerie
   *
   * @param string $dNSerie
   *
   * @return self
   */
  public function setDNSerie(string $dNSerie): self
  {
    $this->dNSerie = $dNSerie;

    return $this;
  }


  /**
   * Set the value of dNumPedi
   *
   * @param string $dNumPedi
   *
   * @return self
   */
  public function setDNumPedi(string $dNumPedi): self
  {
    $this->dNumPedi = $dNumPedi;

    return $this;
  }


  /**
   * Set the value of dNumSegui
   *
   * @param string $dNumSegui
   *
   * @return self
   */
  public function setDNumSegui(string $dNumSegui): self
  {
    $this->dNumSegui = $dNumSegui;

    return $this;
  }


  /**
   * Set the value of dNomImp
   *
   * @param string $dNomImp
   *
   * @return self
   */
  public function setDNomImp(string $dNomImp): self
  {
    $this->dNomImp = $dNomImp;

    return $this;
  }


  /**
   * Set the value of dDirImp
   *
   * @param string $dDirImp
   *
   * @return self
   */
  public function setDDirImp(string $dDirImp): self
  {
    $this->dDirImp = $dDirImp;

    return $this;
  }


  /**
   * Set the value of dNumFir
   *
   * @param string $dNumFir
   *
   * @return self
   */
  public function setDNumFir(string $dNumFir): self
  {
    $this->dNumFir = $dNumFir;

    return $this;
  }


  /**
   * Set the value of dNumReg
   *
   * @param string $dNumReg
   *
   * @return self
   */
  public function setDNumReg(string $dNumReg): self
  {
    $this->dNumReg = $dNumReg;

    return $this;
  }


  /**
   * Set the value of dNumRegEntCom
   *
   * @param string $dNumRegEntCom
   *
   * @return self
   */
  public function setDNumRegEntCom(string $dNumRegEntCom): self
  {
    $this->dNumRegEntCom = $dNumRegEntCom;

    return $this;
  }

  //====================================================//
  ///GETTERS
  //====================================================//

  /**
   * Get the value of dNumLote
   *
   * @return int
   */
  public function getDNumLote(): int
  {
    return $this->dNumLote;
  }

  /**
   * Get the value of dVencMerc
   *
   * @return DateTime
   */
  public function getDVencMerc(): DateTime
  {
    return $this->dVencMerc;
  }

  /**
   * Get the value of dNSerie
   *
   * @return string
   */
  public function getDNSerie(): string
  {
    return $this->dNSerie;
  }

  /**
   * Get the value of dNumPedi
   *
   * @return string
   */
  public function getDNumPedi(): string
  {
    return $this->dNumPedi;
  }

  /**
   * Get the value of dNumSegui
   *
   * @return string
   */
  public function getDNumSegui(): string
  {
    return $this->dNumSegui;
  }

  /**
   * Get the value of dNomImp
   *
   * @return string
   */
  public function getDNomImp(): string
  {
    return $this->dNomImp;
  }

  /**
   * Get the value of dDirImp
   *
   * @return string
   */
  public function getDDirImp(): string
  {
    return $this->dDirImp;
  }

  /**
   * Get the value of dNumFir
   *
   * @return string
   */
  public function getDNumFir(): string
  {
    return $this->dNumFir;
  }

  /**
   * Get the value of dNumReg
   *
   * @return string
   */
  public function getDNumReg(): string
  {
    return $this->dNumReg;
  }

  /**
   * Get the value of dNumRegEntCom
   *
   * @return string
   */
  public function getDNumRegEntCom(): string
  {
    return $this->dNumRegEntCom;
  }

  //====================================================//
  //XML Element
  //====================================================//

  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('gRasMerc');

    $res->appendChild(new DOMElement('dNumLote', $this->getDNumLote()));
    $res->appendChild(new DOMElement('dVencMerc', $this->getDVencMerc()->format('Y-m-d')));
    $res->appendChild(new DOMElement('dNSerie', $this->getDNSerie()));
    $res->appendChild(new DOMElement('dNumPedi', $this->getDNumPedi()));
    $res->appendChild(new DOMElement('dNumSegui', $this->getDNumSegui()));
    $res->appendChild(new DOMElement('dNomImp', $this->getDNomImp()));
    $res->appendChild(new DOMElement('dDirImp', $this->getDDirImp()));
    $res->appendChild(new DOMElement('dNumFir', $this->getDNumFir()));
    $res->appendChild(new DOMElement('dNumReg', $this->getDNumReg()));
    $res->appendChild(new DOMElement('dNumRegEntCom', $this->getDNumRegEntCom()));
    return $res;
  }

  /**
   * fromDOMElement
   *
   * @param  mixed $xml
   * @return GRasMerc
   */
  public static function fromDOMElement(DOMElement $xml): GRasMerc
  {
    if (strcmp($xml->tagName, 'gRasMerc') === 0 && $xml->childElementCount == 10) {
      $res = new GRasMerc();
      $res->setDNumLote($xml->getElementsByTagName('dNumLote')->item(0)->nodeValue);
      $res->setDVencMerc(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dVencMerc')->item(0)->nodeValue));
      $res->setDNSerie($xml->getElementsByTagName('dNSerie')->item(0)->nodeValue);
      $res->setDNumPedi($xml->getElementsByTagName('dNumPedi')->item(0)->nodeValue);
      $res->setDNumSegui($xml->getElementsByTagName('dNumSegui')->item(0)->nodeValue);
      $res->setDNomImp($xml->getElementsByTagName('dNomImp')->item(0)->nodeValue);
      $res->setDDirImp($xml->getElementsByTagName('dDirImp')->item(0)->nodeValue);
      $res->setDNumFir($xml->getElementsByTagName('dNumFir')->item(0)->nodeValue);
      $res->setDNumReg($xml->getElementsByTagName('dNumReg')->item(0)->nodeValue);
      $res->setDNumRegEntCom($xml->getElementsByTagName('dNumRegEntCom')->item(0)->nodeValue);
      return $res;
    } else {
      throw new \Exception("Invalid XML Element: $xml->tagName");
      return null;
    }
  }
}
