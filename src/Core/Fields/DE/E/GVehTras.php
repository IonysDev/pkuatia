<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use DOMDocument;
use DOMElement;
use Exception;

/**
 * Nodo Id:     E960
 * Nombre:      gVehTras
 * Descripción: Campos que identifican al vehículo del traslado de mercaderías
 * Nodo Padre:  E900 - gTransp - Campos que describen el transporte de mercaderías 
 */

class GVehTras extends BaseSifenField
{
                                // Id - Longitud - Ocurrencia - Descripción
    public String $dTiVehTras;  // E961 - 4-10 - 1-1 - Tipo de vehículo
    public String $dMarVeh;     // E962 - 1-10 - 1-1 - Marca
    public int    $dTipIdenVeh; // E967 - 1    - 1-1 - Tipo de identificación del vehículo: 1 = Número de identificación del vehículo | 2 = Número de matrícula del vehículo
    public String $dNroIDVeh;   // E963 - 1-20 - 0-1 - Número de identificación del vehículo
    public String $dAdicVeh;    // E964 - 1-20 - 0-1 - Datos adicionales del vehículo
    public String $dNroMatVeh;  // E965 - 6-7    - 0-1 - Número de matrícula del vehículo
    public String $dNroVuelo;   // E966 - 6    - 0-1 - Número de vuelo

    ///////////////////////////////////////////////////////////////////////
    ///Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de dTiVehTras que corresponde al tipo de vehículo.
     *
     * @param String $dTiVehTras Tipo de vehículo (4-10 caracteres)
     *
     * @return self Este objeto para encadenamiento
     */
    public function setDTiVehTras(String $dTiVehTras): self
    {
        if(strlen($dTiVehTras) < 4 || strlen($dTiVehTras) > 10)
            throw new Exception('[GVehTras] Tipo de vehículo (dTiVehTras) inválido: ' . $dTiVehTras . '. Debe tener entre 4 y 10 caracteres.');
        $this->dTiVehTras = $dTiVehTras;
        return $this;
    }

    /**
     * Establece el valor de dMarVeh que corresponde a la marca del vehículo.
     *
     * @param String $dMarVeh Marca del vehículo (1-10 caracteres)
     *
     * @return self Este objeto para encadenamiento
     */
    public function setDMarVeh(String $dMarVeh): self
    {
        if(strlen($dMarVeh) < 1 || strlen($dMarVeh) > 10)
            throw new Exception('[GVehTras] Marca del vehículo (dMarVeh) inválida: ' . $dMarVeh . '. Debe tener entre 1 y 10 caracteres.');
        $this->dMarVeh = $dMarVeh;
        return $this;
    }

    /**
     * Establece el valor de dTipIdenVeh que corresponde al tipo de identificación del vehículo.
     *
     * @param int $dTipIdenVeh Tipo de identificación del vehículo: 1 - Número de identificación del vehículo | 2 - Número de matrícula del vehículo
     *
     * @return self Este objeto para encadenamiento
     */
    public function setDTipIdenVeh(int $dTipIdenVeh): self
    {
        if($dTipIdenVeh != 1 && $dTipIdenVeh != 2)
            throw new Exception('[GVehTras] Tipo de identificación del vehículo (dTipIdenVeh) inválido: ' . $dTipIdenVeh . '. Debe ser 1 o 2.');
        $this->dTipIdenVeh = $dTipIdenVeh;
        return $this;
    }

    /**
     * Establece el valor de dNroIDVeh que corresponde al número de identificación del vehículo.
     *
     * @param String $dNroIDVeh Número de identificación del vehículo (1-20 caracteres)
     *
     * @return self Este objeto para encadenamiento
     */
    public function setDNroIDVeh(String $dNroIDVeh): self
    {
        if(strlen($dNroIDVeh) < 1 || strlen($dNroIDVeh) > 20)
            throw new Exception('[GVehTras] Número de identificación del vehículo (dNroIDVeh) inválido: ' . $dNroIDVeh . '. Debe tener entre 1 y 20 caracteres.');
        $this->dNroIDVeh = $dNroIDVeh;
        return $this;
    }

    /**
     * Establece el valor de dAdicVeh que corresponde a los datos adicionales del vehículo.
     * 
     * @param String $dAdicVeh Datos adicionales del vehículo (1-20 caracteres)
     * 
     * @return self Este objeto para encadenamiento
     */
    public function setDAdicVeh(String $dAdicVeh): self
    {
        if(strlen($dAdicVeh) < 1 || strlen($dAdicVeh) > 20)
            throw new Exception('[GVehTras] Datos adicionales del vehículo (dAdicVeh) inválidos: ' . $dAdicVeh . '. Debe tener entre 1 y 20 caracteres.');
        $this->dAdicVeh = $dAdicVeh;
        return $this;
    }

    /**
     * Establece el valor de dNroMatVeh que corresponde al número de matrícula del vehículo.
     *
     * @param String $dNroMatVeh Número de matrícula del vehículo (6 caracteres)
     *
     * @return self Este objeto para encadenamiento
     */
    public function setDNroMatVeh(String $dNroMatVeh): self
    {
        if(strlen($dNroMatVeh) != 6)
            throw new Exception('[GVehTras] Número de matrícula del vehículo (dNroMatVeh) inválido: ' . $dNroMatVeh . '. Debe tener 6 caracteres.');
        $this->dNroMatVeh = $dNroMatVeh;
        return $this;
    }

    /**
     * Establece el valor de dNroVuelo que corresponde al número de vuelo.
     *
     * @param String $dNroVuelo Número de vuelo (6 caracteres)
     *
     * @return self Este objeto para encadenamiento
     */
    public function setDNroVuelo(String $dNroVuelo): self
    {
        if(strlen($dNroVuelo) != 6)
            throw new Exception('[GVehTras] Número de vuelo (dNroVuelo) inválido: ' . $dNroVuelo . '. Debe tener 6 caracteres.');
        $this->dNroVuelo = $dNroVuelo;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Obtiene el valor de dTiVehTras que corresponde al tipo de vehículo.
     *
     * @return String Tipo de vehículo.
     */
    public function getDTiVehTras(): String
    {
        return $this->dTiVehTras;
    }

    /**
     * Obtiene el valor de dMarVeh que corresponde a la marca del vehículo.
     *
     * @return String Marca del vehículo.
     */
    public function getDMarVeh(): String
    {
        return $this->dMarVeh;
    }

    /**
     * Obtiene el valor de dTipIdenVeh que corresponde al tipo de identificación del vehículo.
     *
     * @return int Tipo de identificación del vehículo.
     */
    public function getDTipIdenVeh(): int
    {
        return $this->dTipIdenVeh;
    }

    /**
     * Obtiene el valor de dNroIDVeh que corresponde al número de identificación del vehículo.
     *
     * @return String Número de identificación del vehículo o null si no ha sido establecido.
     */
    public function getDNroIDVeh(): ?String
    {
        if(isset($this->dNroIDVeh))
            return $this->dNroIDVeh;
        return null;
    }

    /**
     * Obtiene el valor de dAdicVeh que corresponde a los datos adicionales del vehículo.
     *
     * @return String Datos adicionales del vehículo o null si no ha sido establecido.
     */
    public function getDAdicVeh(): String
    {
        if(isset($this->dAdicVeh))
            return $this->dAdicVeh;
        return null;
    }

    /**
     * Obtiene el valor de dNroMatVeh que corresponde al número de matrícula del vehículo.
     *
     * @return String Número de matrícula del vehículo o null si no ha sido establecido.
     */
    public function getDNroMatVeh(): String
    {   if(isset($this->dNroMatVeh))
            return $this->dNroMatVeh;
        return null;
    }

    /**
     * Obtiene el valor de dNroVuelo que corresponde al número de vuelo.
     *
     * @return String Número de vuelo o null si no ha sido establecido.
     */
    public function getDNroVuelo(): String
    {
        if(isset($this->dNroVuelo))
            return $this->dNroVuelo;
        return null;
    }

    ///////////////////////////////////////////////////////////////////////
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia un objeto GVehTras a partir de un DOMElement que representa al objeto.
     * 
     * @param DOMElement $node Nodo XML que representa el objeto GVehTras
     * 
     * @return GVehTras Objeto GVehTras instanciado
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if(strcmp($node->nodeName, 'gVehTras') != 0)
            throw new Exception('[GVehTras] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new self();
        $res->setDTiVehTras(trim($node->getElementsByTagName('dTiVehTras')->item(0)->nodeValue));
        $res->setDMarVeh(trim($node->getElementsByTagName('dMarVeh')->item(0)->nodeValue));
        $res->setDTipIdenVeh(intval(trim($node->getElementsByTagName('dTipIdenVeh')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dNroIDVeh')->length > 0)
            $res->setDNroIDVeh(trim($node->getElementsByTagName('dNroIDVeh')->item(0)->nodeValue));
        if($node->getElementsByTagName('dAdicVeh')->length > 0)
            $res->setDAdicVeh(trim($node->getElementsByTagName('dAdicVeh')->item(0)->nodeValue));
        if($node->getElementsByTagName('dNroMatVeh')->length > 0)
            $res->setDNroMatVeh(trim($node->getElementsByTagName('dNroMatVeh')->item(0)->nodeValue));
        if($node->getElementsByTagName('dNroVuelo')->length > 0)
            $res->setDNroVuelo(trim($node->getElementsByTagName('dNroVuelo')->item(0)->nodeValue));
        return $res;
    }

    /**
     * Instancia un objeto GVehTras a partir de un objeto stdClass obtenido de una respuesta del SIFEN a una solicitud SOAP.
     *
     * @param  mixed $object Objeto stdClass obtenido de una respuesta del SIFEN a una solicitud SOAP
     * 
     * @return self Objeto GVehTras instanciado
     */
    public static function FromSifenResponseObject($object): self
    {
        $res = new GVehTras();
        if (isset($object->dTiVehTras)) {
            $res->setDTiVehTras($object->dTiVehTras);
        }
        if (isset($object->dMarVeh)) {
            $res->setDMarVeh($object->dMarVeh);
        }

        if (isset($object->dTipIdenVeh)) {

            $res->setDTipIdenVeh($object->dTipIdenVeh);
        }
        if (isset($object->dNroIDVeh)) {
            $res->setDNroIDVeh($object->dNroIDVeh);
        }
        if (isset($object->dAdicVeh)) {
            $res->setDAdicVeh($object->dAdicVeh);
        }
        if (isset($object->dNroMatVeh)) {
            $res->setDNroMatVeh($object->dNroMatVeh);
        }
        if (isset($object->dNroVuelo)) {
            $res->setDNroVuelo($object->dNroVuelo);
        }
        return $res;
    }

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte el objeto GVehTras en un nodo DOMElement para su uso en el DOMDocument especificado.
     * 
     * @param DOMDocument $doc DOMDocument donde se generará el nodo.
     *
     * @return DOMElement Nodo DOMElement que representa al objeto GVehTras.
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('gVehTras');
        if(isset($this->dNroIDVeh))
            $res->appendChild(new DOMElement('dTiVehTras', $this->getDTiVehTras()));
        else            
            throw new Exception('[GVehTras] El campo dNroIDVeh es obligatorio.');
        
        if(isset($this->dMarVeh))
            $res->appendChild(new DOMElement('dMarVeh', $this->getDMarVeh()));
        else
            throw new Exception('[GVehTras] El campo dMarVeh es obligatorio.');

        if(isset($this->dTipIdenVeh))
            $res->appendChild(new DOMElement('dTipIdenVeh', $this->getDTipIdenVeh()));
        else
            throw new Exception('[GVehTras] El campo dTipIdenVeh es obligatorio.');
        
        if (isset($this->dNroIDVeh))
            $res->appendChild(new DOMElement('dNroIDVeh', $this->getDNroIDVeh()));
        else if($this->dTipIdenVeh == 1)
            throw new Exception('[GVehTras] El campo dNroIDVeh es obligatorio.');
        
        if(isset($this->dAdicVeh))
            $res->appendChild(new DOMElement('dAdicVeh', $this->getDAdicVeh()));
        
        if (isset($this->dNroMatVeh))
            $res->appendChild(new DOMElement('dNroMatVeh', $this->getDNroIDVeh()));
        else if($this->dTipIdenVeh == 2)
            throw new Exception('[GVehTras] El campo dNroMatVeh es obligatorio.');
        
        if(isset($this->dNroVuelo))
            $res->appendChild(new DOMElement('dNroVuelo', $this->getDNroVuelo()));
        
        return $res;
    }    
}
