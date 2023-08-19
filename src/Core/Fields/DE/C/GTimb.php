<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\C;

use DateTime;
use DOMElement;

/**
 * ID:C001 Datos del timbrado PADRE:A001
 */
class GTimb
{

    public int $iTiDE;        // C002 - Tipo de documento electrónico
    public int $dNumTim;      // C004 - Número del timbrado
    public String $dEst;      // C005 - Establecimiento
    public String $dPunExp;   // C006 - Punto de expedición
    public String $dNumDoc;   // C007 - Número del documento
    public String $dSerieNum; // C010 - Serie del número de timbrado
    public DateTime $dFeIniT; // C008 - Fecha inicio de vigencia del timbrado AAAA-MM-DD

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setITiDE(int $iTiDE): self
    {
        $this->iTiDE = $iTiDE;
        return $this;
    }

    public function setDNumTim(int $dNumTim): self
    {
        $this->dNumTim = $dNumTim;
        return $this;
    }

    public function setDEst(String $dEst): self
    {
        $this->dEst = $dEst;
        return $this;
    }

    public function setDPunExp(String $dPunExp): self
    {
        $this->dPunExp = $dPunExp;
        return $this;
    }

    public function setDNumDoc(String $dNumDoc): self
    {
        $this->dNumDoc = $dNumDoc;
        return $this;
    }

    public function setDSerieNum(String $dSerieNum): self
    {
        $this->dSerieNum = $dSerieNum;
        return $this;
    }

    public function setDFeIniT(DateTime $dFeIniT): self
    {
        $this->dFeIniT = $dFeIniT;
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
     * @return String
     */
    public function getDDesTiDE(): String
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

    public function getDEst(): String
    {
        return $this->dEst;
    }

    public function getDPunExp(): String
    {
        return $this->dPunExp;
    }

    public function getDNumDoc(): String
    {
        return $this->dNumDoc;
    }

    public function getDSerieNum(): String
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

    public static function FromSimpleXMLElement(\SimpleXMLElement $xml) 
    {
        if(strcmp($xml->getName(), 'gTimb') != 0) {
            throw new \Exception('El nombre del elemento no es gTimb');
        }
        $res = new GTimb();
        $res->setITiDE(intval($xml->iTiDE));
        $res->setDNumTim(intval($xml->dNumTim));
        $res->setDEst($xml->dEst);
        $res->setDPunExp($xml->dPunExp);
        $res->setDNumDoc($xml->dNumDoc);
        $res->setDSerieNum($xml->dSerieNum);
        $res->setDFeIniT(DateTime::createFromFormat('Y-m-d', $xml->dFeIniT));
        return $res;
    }

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

    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return GTimb
    //  */
    // public static function fromDOMElement(DOMElement $xml): GTimb
    // {
    //     if (strcmp($xml->tagName, 'gTimb') == 0 && $xml->childElementCount == 8) {
    //         $res = new GTimb();
    //         $res->setITiDE(intval($xml->getElementsByTagName('iTiDE')->item(0)->nodeValue));
    //         $res->setDNumTim(intval($xml->getElementsByTagName('dNumTim')->item(0)->nodeValue));
    //         $res->setDEst($xml->getElementsByTagName('dEst')->item(0)->nodeValue);
    //         $res->setDPunExp($xml->getElementsByTagName('dPunExp')->item(0)->nodeValue);
    //         $res->setDNumDoc($xml->getElementsByTagName('dNumDoc')->item(0)->nodeValue);
    //         $res->setDSerieNum($xml->getElementsByTagName('dSerieNum')->item(0)->nodeValue);
    //         $res->setDFeIniT(DateTime::createFromFormat('Y-m-d', $xml->getElementsByTagName('dFeIniT')->item(0)->nodeValue));
    //         return $res;
    //     } else {
    //         throw new \Exception("Invalid XML Element: $xml->tagName");
    //         return null;
    //     }
    // }
    
    /**
     * fromResponse
     *
     * @param  mixed $response
     * @return self
     */
    public static function fromResponse($response): self
    {
        $res = new GTimb();
        if(isset($response->iTiDE))
        {
            $res->setITiDE(intval($response->iTiDE));
        }
        if(isset($response->dNumTim))
        {
            $res->setDNumTim(intval($response->dNumTim));
        }
        if(isset($response->dEst))
        {
            $res->setDEst($response->dEst);
        }
        if(isset($response->dPunExp))
        {
            $res->setDPunExp($response->dPunExp);
        }
        if(isset($response->dNumDoc))
        {
            $res->setDNumDoc($response->dNumDoc);
        }
        if(isset($response->dSerieNum))
        {
            $res->setDSerieNum($response->dSerieNum);
        }
        if(isset($response->dFeIniT))
        {
            $res->setDFeIniT(DateTime::createFromFormat('Y-m-d', $response->dFeIniT));
        }
        
        return $res;
    }
}
