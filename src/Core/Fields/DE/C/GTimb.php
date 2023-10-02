<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\C;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;

use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * ID:C001 Datos del timbrado PADRE:A001
 */
class GTimb extends BaseSifenField
{

    public int $iTiDE;        // C002 - 1-2   - 1-1 - Tipo de documento electrónico
    public String $dDesTiDE;  // C003 - 15-40 - 1-1 - Descripción del tipo de documento electrónico
    public int $dNumTim;      // C004 - 8     - 1-1 - Número del timbrado
    public String $dEst;      // C005 - 3     - 1-1 - Establecimiento
    public String $dPunExp;   // C006 - 3     - 1-1 - Punto de expedición
    public String $dNumDoc;   // C007 - 7     - 1-1 - Número del documento
    public String $dSerieNum; // C010 - 2     - 0-1 - Serie del número de timbrado
    public DateTime $dFeIniT; // C008 - 10    - 1-1 - Fecha inicio de vigencia del timbrado AAAA-MM-DD

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de iTiDE que representa el tipo de documento electrónico.
     * 
     * @param int $iTiDE
     * 
     * @return self
     */
    public function setITiDE(int $iTiDE): self
    {
        $this->iTiDE = $iTiDE;
        switch ($this->iTiDE) {
            case 1:
                $this->dDesTiDE = 'Factura electrónica';
                break;
            case 2:
                $this->dDesTiDE = 'Factura electrónica de exportación';
                break;
            case 3:
                $this->dDesTiDE = 'Factura electrónica de importación';
                break;
            case 4:
                $this->dDesTiDE = 'Autofactura electrónica';
                break;
            case 5:
                $this->dDesTiDE = 'Nota de crédito electrónica';
                break;
            case 6:
                $this->dDesTiDE = 'Nota de débito electrónica';
                break;
            case 7:
                $this->dDesTiDE = 'Nota de remisión electrónica';
                break;
            case 8:
                $this->dDesTiDE = 'Comprobante de retención electrónico';
                break;
            default:
                unset($this->dDesTiDE);
                unset($this->iTiDE);
                throw new \Exception('[GTimb] El valor de iTiDE no es válido: ' . $this->iTiDE);
        }
        return $this;
    }

    /**
     * Establece el valor de dDesTiDE que representa la descripción del tipo de documento electrónico.
     * 
     * @param String $dDesTiDE
     * 
     * @return self
     */
    public function setDDesTiDE(String $dDesTiDE): self
    {
        $this->dDesTiDE = $dDesTiDE;
        return $this;
    }

    /**
     * Establece el valor de dNumTim que representa el número del timbrado.
     * 
     * @param int $dNumTim
     * 
     * @return self
     */
    public function setDNumTim(int $dNumTim): self
    {
        if($dNumTim < 0 || $dNumTim > 99999999) 
            throw new \Exception('[GTimb] El valor de dNumTim no es válido: ' . $dNumTim);
        $this->dNumTim = $dNumTim;
        return $this;
    }

    /**
     * Establece el valor de dEst que representa el establecimiento.
     * 
     * @param String $dEst
     * 
     * @return self
     */
    public function setDEst(String $dEst): self
    {
        if(strlen($dEst) != 3) 
            throw new \Exception('[GTimb] El valor de dEst no es válido: ' . $dEst);
        $this->dEst = $dEst;
        return $this;
    }

    /**
     * Establece el valor de dPunExp que representa el punto de expedición.
     * 
     * @param String $dPunExp
     * 
     * @return self
     */
    public function setDPunExp(String $dPunExp): self
    {
        if(strlen($dPunExp) != 3) 
            throw new \Exception('[GTimb] El valor de dPunExp no es válido: ' . $dPunExp);
        $this->dPunExp = $dPunExp;
        return $this;
    }

    /**
     * Establece el valor de dNumDoc que representa el número del documento.
     * 
     * @param String $dNumDoc
     * 
     * @return self
     */
    public function setDNumDoc(String $dNumDoc): self
    {
        if(strlen($dNumDoc) != 7) 
            throw new \Exception('[GTimb] El valor de dNumDoc no es válido: ' . $dNumDoc);
        $this->dNumDoc = $dNumDoc;
        return $this;
    }

    /**
     * Establece el valor de dSerieNum que representa la serie del número de timbrado.
     * 
     * @param String $dSerieNum
     * 
     * @return self
     */
    public function setDSerieNum(String $dSerieNum): self
    {
        $this->dSerieNum = $dSerieNum;
        return $this;
    }

    /**
     * Establece el valor de dFeIniT que representa la fecha inicio de vigencia del timbrado.
     * 
     * @param DateTime $dFeIniT
     * 
     * @return self
     */
    public function setDFeIniT(DateTime $dFeIniT): self
    {
        $this->dFeIniT = $dFeIniT;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve el tipo de documento electrónico
     * 
     * @return int
     */
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
        return $this->dDesTiDE;
    }

    /**
     * Devuelve el número del timbrado
     * 
     * @return int
     */
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
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto GTimb a partir de un SimpleXMLElement
     * 
     * @return self
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $xml) 
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
     * Instancia un objeto GTimb a partir de un objeto stdClass de respuesta del SIFEN a una solicitud SOAP.
     *
     * @param  mixed $object
     * @return self
     */
    public static function FromSifenResponseObject($object): self
    {
        $res = new GTimb();
        $res->setITiDE(intval($object->iTiDE));
        $res->setDNumTim(intval($object->dNumTim));
        $res->setDEst($object->dEst);
        $res->setDPunExp($object->dPunExp);
        $res->setDNumDoc($object->dNumDoc);
        if(isset($object->dSerieNum))
        {
            $res->setDSerieNum($object->dSerieNum);
        }
        $res->setDFeIniT(DateTime::createFromFormat('Y-m-d', $object->dFeIniT));
        return $res;
    }

    /**
     * Instancia un objeto GTimb a partir de un DOMElement que representa el nodo XML del objeto GTimb
     * 
     * @param DOMElement $node Nodo XML que representa el objeto GTimb
     * 
     * @return self Objeto GTimb instanciado
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if(strcmp($node->nodeName, 'gTimb') != 0)
            throw new \Exception('[GTimb] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new GTimb();
        $res->setITiDE(intval($node->getElementsByTagName('iTiDE')->item(0)->nodeValue));
        $res->setDNumTim(intval(trim($node->getElementsByTagName('dNumTim')->item(0)->nodeValue)));
        $res->setDEst(trim($node->getElementsByTagName('dEst')->item(0)->nodeValue));
        $res->setDPunExp(trim($node->getElementsByTagName('dPunExp')->item(0)->nodeValue));
        $res->setDNumDoc(trim($node->getElementsByTagName('dNumDoc')->item(0)->nodeValue));
        if($node->getElementsByTagName('dSerieNum')->length > 0)
            $res->setDSerieNum(trim($node->getElementsByTagName('dSerieNum')->item(0)->nodeValue));
        $res->setDFeIniT(DateTime::createFromFormat('Y-m-d', trim($node->getElementsByTagName('dFeIniT')->item(0)->nodeValue)));
        return $res;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte el objeto en un DOMElement
     *
     * @return DOMElement
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('gTimb');
        $res->appendChild(new DOMElement('iTiDE', $this->iTiDE));
        $res->appendChild(new DOMElement('dDesTiDE', $this->getDDesTiDE()));
        $res->appendChild(new DOMElement('dNumTim', str_pad(($this->dNumTim % 100000000), 8, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dEst', str_pad($this->dEst, 3, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dPunExp', str_pad($this->dPunExp, 3, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dNumDoc', str_pad($this->dNumDoc, 7, "0", STR_PAD_LEFT)));
        if(isset($this->dSerieNum))
            $res->appendChild(new DOMElement('dSerieNum', str_pad($this->dSerieNum, 2, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dFeIniT', $this->dFeIniT->format('Y-m-d')));
        return $res;
    }
    
    
}
