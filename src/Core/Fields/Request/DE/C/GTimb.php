<?php

namespace Abiliomp\Pkuatia\Core\Fields\C;

use DateTime;
use DOMElement;

/**
 * ID:C001 Datos del timbrado PADRE:A001
 */
class GTimb
{

    public int $iTiDE;        // C002 - Tipo de documento electrónico
    public string $dDesTiDE;  // C003 - Descripción del tipo de documento electrónico
    public int $dNumTim;      // C004 - Número del timbrado
    public string $dEst;      // C005 - Establecimiento
    public string $dPunExp;   // C006 - Punto de expedición
    public string $dNumDoc;   // C007 - Número del documento
    public string $dSerieNum; // C010 - Serie del número de timbrado
    public DateTime $dFeIniT; // C008 - Fecha inicio de vigencia del timbrado

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setITiDE(int $iTiDE): void
    {
        $this->iTiDE = $iTiDE;
    }

    public function setDNumTim(int $dNumTim): void
    {
        $this->dNumTim = $dNumTim;
    }

    public function setDEst(string $dEst): void
    {
        $this->dEst = $dEst;
    }

    public function setDPunExp(string $dPunExp): void
    {
        $this->dPunExp = $dPunExp;
    }

    public function setDNumDoc(string $dNumDoc): void
    {
        $this->dNumDoc = $dNumDoc;
    }

    public function setDSerieNum(string $dSerieNum): void
    {
        $this->dSerieNum = $dSerieNum;
    }

    public function setDFeIniT(string $dFeIniT): void
    {
        $this->dFeIniT = $dFeIniT;
    }

    /**
     * Set the value of dDesTiDE
     *
     * @param string $dDesTiDE
     *
     * @return self
     */
    public function setDDesTiDE(string $dDesTiDE): self
    {
        $this->dDesTiDE = $dDesTiDE;

        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getITiDE(): int
    {
        return $this->iTiDE;
    }

    /**
     * Devuelve la descripción del tipo de documento electrónico
     * 
     * @return string
     */
    public function getDDesTiDE(): string
    {
        switch ($this->iTiDE) {
            case 1:
                return 'Factura electrónica';
                break;
            case 2:
                return 'Factura electrónica de exportación';
                break;
            case 3:
                return 'Factura electrónica de importación';
                break;
            case 4:
                return 'Autofactura electrónica';
                break;
            case 5:
                return 'Nota de crédito electrónica';
                break;
            case 6:
                return 'Nota de débito electrónica';
                break;
            case 7:
                return 'Nota de remisión electrónica';
                break;
            case 8:
                return 'Comprobante de retención electrónico';
                break;
            default:
                return null;
        }
    }

    public function getDNumTim(): int
    {
        return $this->dNumTim;
    }

    public function getDEst(): string
    {
        return $this->dEst;
    }

    public function getDPunExp(): string
    {
        return $this->dPunExp;
    }

    public function getDNumDoc(): string
    {
        return $this->dNumDoc;
    }

    public function getDSerieNum(): string
    {
        return $this->dSerieNum;
    }

    public function getDFeIniT(): DateTime
    {
        return $this->dFeIniT;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    /**
     * toDOMElement
     *
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gTimb');
        $res->appendChild(new DOMElement('iTiDE', $this->iTiDE));
        $res->appendChild(new DOMElement('dDesTiDE', $this->getDDesTiDE()));
        $res->appendChild(new DOMElement('dNumTim', str_pad(($this->dNumTim % 100000000), 8, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dEst', str_pad($this->dEst, 3, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dPunExp', str_pad($this->dPunExp, 3, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dNumDoc', str_pad($this->dNumDoc, 7, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dSerieNum', str_pad($this->dSerieNum, 2, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dFeIniT', $this->dFeIniT->format('Y-m-d')));
        return $res;
    }

    /**
     * fromDOMElement
     *
     * @param  mixed $xml
     * @return GTimb
     */
    public static function fromDOMElement(DOMElement $xml): GTimb
    {
        if (strcmp($xml->tagName, 'gTimb') == 0 && $xml->childElementCount == 8) {
            $res = new GTimb();
            $res->setITiDE(intval($xml->getElementsByTagName('iTiDE')->item(0)->nodeValue));
            $res->setITiDE($xml->getElementsByTagName('dDesTiDE')->item(0)->nodeValue);
            $res->setITiDE(intval($xml->getElementsByTagName('dNumTim')->item(0)->nodeValue));
            $res->setITiDE($xml->getElementsByTagName('dEst')->item(0)->nodeValue);
            $res->setITiDE($xml->getElementsByTagName('dPunExp')->item(0)->nodeValue);
            $res->setITiDE($xml->getElementsByTagName('dNumDoc')->item(0)->nodeValue);
            $res->setITiDE($xml->getElementsByTagName('dSerieNum')->item(0)->nodeValue);
            $res->setITiDE(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeIniT')->item(0)->nodeValue));
            return $res;
        } else {
            throw new \Exception("Invalid XML Element: $xml->tagName");
            return null;
        }
    }
}
