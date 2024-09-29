<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\C;

use Abiliomp\Pkuatia\Core\Constants\TimbTiDE;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DateTime;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     C001        
 * Nombre:      gTimb       
 * Descripción: Datos del timbrado      
 * Nodo Padre:  A001 - DE - Campos firmados del DE 
 */
class GTimb extends BaseSifenField
{
    public const MAX_NUMDOC = 9999999;
    public const MAX_SERIE = 'ZZ';
    
                              // Id - Longirud - Ocurrencia - Descripción
    public int    $iTiDE;     // C002 - 1-2   - 1-1 - Tipo de documento electrónico
    public String $dDesTiDE;  // C003 - 15-40 - 1-1 - Descripción del tipo de documento electrónico
    public int    $dNumTim;   // C004 - 8     - 1-1 - Número del timbrado
    public String $dEst;      // C005 - 3     - 1-1 - Establecimiento
    public String $dPunExp;   // C006 - 3     - 1-1 - Punto de expedición
    public String $dNumDoc;   // C007 - 7     - 1-1 - Número del documento
    public String $dSerieNum; // C010 - 2     - 0-1 - Serie del número de timbrado
    public DateTime $dFeIniT; // C008 - 10    - 1-1 - Fecha inicio de vigencia del timbrado AAAA-MM-DD

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de iTiDE (C002) que representa el tipo de documento electrónico, así como su descripción en dDesTiDE (C003).
     * 
     * @param int $iTiDE Valor del tipo de documento electrónico.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setITiDE(int | TimbTiDE $iTiDE): self
    {
        $this->dDesTiDE = $iTiDE instanceof TimbTiDE ? $iTiDE : TimbTiDE::getDescripcion($iTiDE);
        $this->iTiDE = $iTiDE instanceof TimbTiDE ? $iTiDE->value : $iTiDE;
        return $this;
    }

    /**
     * Establece el valor de dDesTiDE que representa la descripción del tipo de documento electrónico.
     * Este valor se establece automáticamente al establecer el valor de iTiDE.
     * No debería usarse en la conformación de un DE nuevo. Se usa para la deserialización de un DE existente.
     * 
     * @param String $dDesTiDE Descripción del tipo de documento electrónico.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDDesTiDE(String $dDesTiDE): self
    {
        $this->dDesTiDE = $dDesTiDE;
        return $this;
    }

    /**
     * Establece el valor de dNumTim que representa el número del timbrado.
     * 
     * @param int $dNumTim Número del timbrado.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDNumTim(int $dNumTim): self
    {
        if($dNumTim < 0 || $dNumTim > 99999999) 
            throw new \Exception('[GTimb] El valor de dNumTim no es válido: ' . $dNumTim);
        $this->dNumTim = $dNumTim;
        return $this;
    }

    /**
     * Establece el valor de dEst que representa el númnero de establecimiento en formato de 3 dígitos.
     * Para valores por debajo de 100, se debe anteponer ceros.
     * 
     * @param String $dEst Número de establecimiento.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDEst(String $dEst): self
    {
        if(strlen($dEst) != 3) 
            throw new \Exception('[GTimb] El valor de dEst no es válido: ' . $dEst);
        $this->dEst = $dEst;
        return $this;
    }

    /**
     * Establece el valor de dPunExp que representa el punto de expedición en formato de 3 dígitos.
     * Para valores por debajo de 100, se debe anteponer ceros.
     * 
     * @param String $dPunExp Número de punto de expedición.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDPunExp(String $dPunExp): self
    {
        if(strlen($dPunExp) != 3) 
            throw new \Exception('[GTimb] El valor de dPunExp no es válido: ' . $dPunExp);
        $this->dPunExp = $dPunExp;
        return $this;
    }

    /**
     * Establece el valor de dNumDoc que representa el número del documento en formato de 7 dígitos.
     * Para valores por debajo de 1000000, se debe anteponer ceros.
     * 
     * @param String $dNumDoc Número del documento.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
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
     * @param String $dSerieNum Serie del número de timbrado.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDSerieNum(String $dSerieNum): self
    {
        $this->dSerieNum = $dSerieNum;
        return $this;
    }

    /**
     * Establece el valor de dFeIniT que representa la fecha inicio de vigencia del timbrado.
     * 
     * @param DateTime $dFeIniT Fecha inicio de vigencia del timbrado.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
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
     * Obtiene el tipo de documento electrónico del timbrado
     * 
     * @return int Tipo de documento electrónico
     */
    public function getITiDE(): int
    {
        return $this->iTiDE;
    }

    /**
     * Obtiene la descripción del tipo de documento electrónico.
     * 
     * @return String Descripción del tipo de documento electrónico.
     */
    public function getDDesTiDE(): String
    {
        return $this->dDesTiDE;
    }

    /**
     * Obtiene el número del timbrado.
     * 
     * @return int Número del timbrado.
     */
    public function getDNumTim(): int
    {
        return $this->dNumTim;
    }

    /**
     * Obtiene el número de establecimiento.
     * 
     * @return String Número de establecimiento.
     */
    public function getDEst(): String
    {
        return $this->dEst;
    }

    /**
     * Obtiene el número de punto de expedición.
     * 
     * @return String Número de punto de expedición.
     */
    public function getDPunExp(): String
    {
        return $this->dPunExp;
    }

    /**
     * Obtiene el número del documento.
     * 
     * @return String Número del documento.
     */
    public function getDNumDoc(): String
    {
        return $this->dNumDoc;
    }

    /**
     * Obtiene la serie del número de timbrado.
     * 
     * @return String Serie del número de timbrado.
     */
    public function getDSerieNum(): String
    {
        return $this->dSerieNum;
    }

    /**
     * Obtiene la fecha inicio de vigencia del timbrado.
     * 
     * @return DateTime Fecha inicio de vigencia del timbrado.
     */
    public function getDFeIniT(): DateTime
    {
        return $this->dFeIniT;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto GTimb a partir de un SimpleXMLElement.
     * 
     * @return self Objeto GTimb instanciado.
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
     * @param  stdClass $object Objeto stdClass que representa la respuesta del SIFEN.
     * 
     * @return self Objeto GTimb instanciado.
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
     * Convierte el objeto en un DOMElement para ser usado en el DOMDocument especificado.
     *
     * @return DOMElement Objeto convertido en DOMElement.
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
