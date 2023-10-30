<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\B;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\Utils\RNG;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: B001        
 * Nombre: gOpeDE
 * Descripción: Campos inherentes a la operación de DE      
 * Nodo Padre: A001 - DE - Campos firmados del DE   
 */

class GOpeDE extends BaseSifenField
{
                               // Id - Longitud - Ocurrencia - Descripción
    public int    $iTipEmi;    // B002 - 1      - 1-1 - Tipo de emisión: 1 - Normal, 2 - Contingencia
    public String $dDesTipEmi; // B003 - 6-12   - 1-1 - Descripción del tipo de emisión
    public String $dCodSeg;    // B004 - 9      - 1-1 - Código de seguridad: número que debe formatearse al exportar con 9 caracteres con 0s a la izquierda
    public String $dInfoEmi;   // B005 - 1-3000 - 0-1 - Información de interés del emisor respecto al DE
    public String $dInfoFisc;  // B006 - 1-3000 - 0-1 - Información de interés del fisco respecto al DE

    /**
     * Constructor
     * Establece valores por defecto:
     * - iTipEmi = 1
     * - dCodSeg = RNG::GenerateAsString(0, 999999999, 9)
     */
    public function __construct()
    {
        $this->setITipEmi(1);
        $this->setDCodSeg(RNG::GenerateAsString(0, 999999999, 9));
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de iTipEmi que representa el tipo de emisión del documento.
     * 
     * @param int $iTipEmi Tipo de emisión del documento: 1 - Normal, 2 - Contingencia
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setITipEmi(int $iTipEmi): self
    {
        $this->iTipEmi = $iTipEmi;
        switch ($this->iTipEmi) {
            case 1:
                $this->dDesTipEmi = 'Normal';
                break;
            case 2:
                $this->dDesTipEmi = 'Contingencia';
                break;
            default:
                unset($this->dDesTipEmi);
                unset($this->iTipEmi);
                throw new \Exception('[GOpeDE] El valor de iTipEmi no es válido: ' . $this->iTipEmi);
        }
        return $this;
    }

    /**
     * Establece el valor de dDesTipEmi que representa la descripción del tipo de emisión del documento.
     * Este valor se establece automáticamente al establecer el valor de iTipEmi.
     * No debería usarse en la conformación de un DE nuevo. Se usa para la deserialización de un DE existente.
     * 
     * @param String $dDesTipEmi Descripción del tipo de emisión del documento.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDDesTipEmi(String $dDesTipEmi): self
    {
        $this->dDesTipEmi = $dDesTipEmi;
        return $this;
    }

    /**
     * Establece el valor de dCodSeg que representa el código de seguridad del documento.
     * 
     * @param String $dCodSeg Código de seguridad del documento.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDCodSeg(String $dCodSeg): self
    {
        $this->dCodSeg = $dCodSeg;
        return $this;
    }

    /**
     * Establece el valor de dInfoEmi que representa información de interés del emisor respecto al documento.
     * 
     * @param String $dInfoEmi Información de interés del emisor respecto al documento.
     * 
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDInfoEmi(String $dInfoEmi): self
    {
        $this->dInfoEmi = $dInfoEmi;
        return $this;
    }

    /**
     * Establece el valor de dInfoFisc que representa información de interés del fisco respecto al documento.
     *
     * @param String $dInfoFisc Información de interés del fisco respecto al documento.
     *
     * @return self Retorna la instancia de esta clase para permitir el encadenamiento de métodos.
     */
    public function setDInfoFisc(String $dInfoFisc): self
    {
        $this->dInfoFisc = $dInfoFisc;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Obtiene el valor de iTipEmi que representa el tipo de emisión del documento.
     * 
     * @return int Tipo de emisión del documento: 1 - Normal, 2 - Contingencia
     */
    public function getITipEmi(): int
    {
        return $this->iTipEmi;
    }

    /**
     * Obtiene el valor de dDesTipEmi que representa la descripción del tipo de emisión del documento.
     * 
     * @return String Descripción del tipo de emisión del documento.
     */
    public function getDDesTipEmi(): String
    {
        return $this->dDesTipEmi;
    }

    /**
     * Obtiene el valor de dCodSeg que representa el código de seguridad del documento.
     * 
     * @return String Código de seguridad del documento.
     */
    public function getDCodSeg(): String
    {
        return $this->dCodSeg;
    }

    /**
     * Obtiene el valor de dInfoEmi que representa información de interés del emisor respecto al documento.
     * 
     * @return String Información de interés del emisor respecto al documento.
     */
    public function getDInfoEmi(): String
    {
        return $this->dInfoEmi;
    }

    /**
     * Obtiene el valor de dInfoFisc que representa información de interés del fisco respecto al documento.
     * 
     * @return String Información de interés del fisco respecto al documento.
     */
    public function getDInfoFisc(): String
    {
        return $this->dInfoFisc;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto GOpeDE a partir de un SimpleXMLElement que representa el nodo XML del objeto GOpeDE.
     * 
     * @param SimpleXMLElement $node Nodo XML que representa el objeto GOpeDE
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): self
    {
        if(strcmp($node->getName(), 'gOpeDE') != 0){
            throw new \Exception('[GOpeDE] El nombre del elemento no es gOpeDE: ' . $node->getName());
        }
        $res = new GOpeDE();
        $res->setITipEmi(intval($node->iTipEmi));
        $res->setDDesTipEmi($node->dDesTipEmi);
        $res->setDCodSeg(intval($node->dCodSeg));
        if(isset($node->dInfoEmi))
            $res->setDInfoEmi($node->dInfoEmi);
        if(isset($node->dInfoFisc))
            $res->setDInfoFisc($node->dInfoFisc);
        return $res;
    }

    /**
     * Instancia un objeto GOpeDE a partir de un objeto stdClass respuesta a una solicitud SOAP del SIFEN.
     * 
     * @param stdClass $object Objeto stdClass que representa la respuesta a una solicitud SOAP del SIFEN.
     * 
     * @return self Objeto GOpeDE instanciado
     */
    public static function FromSifenResponseObject($object): self
    {
        $res = new GOpeDE();
        $res->setITipEmi(intval($object->iTipEmi));
        $res->setDDesTipEmi($object->dDesTipEmi);
        $res->setDCodSeg(intval($object->dCodSeg));
        if(isset($object->dInfoEmi))
        {
            $res->setDInfoEmi($object->dInfoEmi);
        }
        if(isset($object->dInfoFisc))
        {
            $res->setDInfoFisc($object->dInfoFisc);
        }
        return $res;
    }

    /**
     * Instancia un objeto GOpeDE a partir de un DOMElement que representa el nodo XML del objeto GOpeDE
     * 
     * @param DOMElement $node Nodo XML que representa el objeto GOpeDE
     * 
     * @return self Objeto GOpeDE instanciado
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if(strcmp($node->nodeName, 'gOpeDE') != 0)
            throw new \Exception('[GOpeDE] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new GOpeDE();
        $res->setITipEmi(intval($node->getElementsByTagName('iTipEmi')->item(0)->nodeValue));
        $res->setDDesTipEmi($node->getElementsByTagName('dDesTipEmi')->item(0)->nodeValue);
        $res->setDCodSeg(intval($node->getElementsByTagName('dCodSeg')->item(0)->nodeValue));
        if($node->getElementsByTagName('dInfoEmi')->length > 0)
            $res->setDInfoEmi($node->getElementsByTagName('dInfoEmi')->item(0)->nodeValue);
        if($node->getElementsByTagName('dInfoFisc')->length > 0)
            $res->setDInfoFisc($node->getElementsByTagName('dInfoFisc')->item(0)->nodeValue);
        return $res;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte el objeto GOpeDE en un DOMElement generado a partir del DOMDocument especificado.
     * 
     * @param DOMDocument $doc Documento DOM donde se generará el nodo, pero NO será insertado.
     *  
     * @return DOMElement DOMElement generado.
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('gOpeDE');
        $res->appendChild(new DOMElement('iTipEmi', $this->getITipEmi()));
        $res->appendChild(new DOMElement('dDesTipEmi', $this->getDDesTipEmi()));
        $res->appendChild(new DOMElement('dCodSeg', $this->getDCodSeg()));
        if(isset($this->dInfoEmi))
            $res->appendChild(new DOMElement('dInfoEmi', $this->getDInfoEmi()));
        if(isset($this->dInfoFisc))
            $res->appendChild(new DOMElement('dInfoFisc', $this->getDInfoFisc()));
        return $res;
    }

    
}
