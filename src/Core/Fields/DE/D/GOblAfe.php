<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\D;
use IonysDev\Pkuatia\Core\Fields\BaseSifenField;
use IonysDev\Pkuatia\Core\Constants\COblAfe;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     D030
 * Nombre:      gOblAfe
 * Descripción: Grupo de campos que identifican las obligaciones afectadas
 * Nodo Padre:  D010 - GOpeCom - Campos inherentes a la operación comercial.
 */
class GOblAfe extends BaseSifenField
{
                                // Id - Longitud - Ocurrencia - Descripción
    public int $cOblAfe;        // D031 - 3      - 1-1 - Código de la obligación afectada
    public string $dDesOblAfe;  // D032 - 21-65  - 1-1 - Descripción de la obligación afectada

    ///////////////////////////////////////////////////////////////////////
    ///Constructor
    ///////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el código de la obligación afectada (D031) y su descripción (D032).
     *
     * @param int|COblAfe $cOblAfe Código de la obligación afectada o un caso del enum COblAfe (Tabla 12 - NT-018).
     *
     * @return self
     *
     * @throws \InvalidArgumentException Si el código no pertenece a la Tabla 12 de obligaciones.
     */
    public function setCOblAfe(int|COblAfe $cOblAfe): self
    {
        $codigo = $cOblAfe instanceof COblAfe ? $cOblAfe->value : $cOblAfe;
        $descripcion = COblAfe::getDescriptionFromValue($codigo);
        if(is_null($descripcion))
        {
            throw new \InvalidArgumentException("[GOblAfe] Código de obligación afectada inválido: " . $codigo . ". Debe pertenecer a la Tabla 12 - Tipo de obligaciones (NT-018).");
        }
        $this->cOblAfe = $codigo;
        $this->dDesOblAfe = $descripcion;
        return $this;
    }


    /**
     * Establece la descripción de la obligación afectada
     * Este método no debería utilizarse para conformar un nuevo DE. Solo debe usarse para deserializar un DE existente.
     * 
     * @param  string  $dDesOblAfe. La descripción de la obligación afectada.
     * 
     * @return  self
     */ 
    public function setDDesOblAfe($dDesOblAfe)
    {
        $this->dDesOblAfe = $dDesOblAfe;

        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Obtiene el tipo de obligación afectada
     *
     * @return  int
     */
    public function getCOblAfe(): int
    {
        return $this->cOblAfe;
    }

    /**
     * Obtiene la descripción de la obligación afectada
     *
     * @return  string
     */
    public function getDDesOblAfe(): string
    {
        return $this->dDesOblAfe;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

     /**
     * Instancia la clase a partir de un SimpleXMLElement
     * 
     * @param SimpleXMLElement $node
     * 
     * @return GOblAfe
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): GOblAfe
    {
        if(strcmp($node->getName(), 'gOblAfe') != 0)
        {
            throw new \InvalidArgumentException("El nombre del elemento debe ser 'gOblAfe'.");
        }

        $res = new GOblAfe();
        if(isset($node->cOblAfe))
        {
            $res->cOblAfe = intval($node->cOblAfe);
        }
        if(isset($node->dDesOblAfe))
        {
            $res->dDesOblAfe = strval($node->dDesOblAfe);
        }
        return $res;
    }

    /**
     * Convierte este GOblAfe a un DOM Element.
     * 
     * @param DOMDocument $doc Documento DOM donde se creará el nodo, pero NO será insertado.
     *
     * @return DOMElement Nodo DOM creado pero no insertado.
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('gOblAfe');
        if(isset($this->cOblAfe))
        {
           $res->appendChild($doc->createElement('cOblAfe', $this->getCOblAfe()));
           $res->appendChild($doc->createElement('dDesOblAfe', $this->getDDesOblAfe()));
        }

        return $res;
    }

    /**
     * Instancia un GOblAfe a partir de un DOMElement que lo representa.
     * Asigna los valores tal cual fueron recibidos, sin validarlos contra la Tabla 12 (deserialización).
     *
     * @param DOMElement $node Nodo DOM que representa el objeto.
     *
     * @return GOblAfe
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if(strcmp($node->nodeName, 'gOblAfe') != 0)
            throw new \Exception('[GOblAfe] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new GOblAfe();
        $res->cOblAfe = intval(trim($node->getElementsByTagName('cOblAfe')->item(0)->nodeValue));
        $res->setDDesOblAfe(trim(strval($node->getElementsByTagName('dDesOblAfe')->item(0)->nodeValue)));
        return $res;
    }

    /**
     * Instancia un GOblAfe a partir de un objeto stdClass proveniente de una respuesta SOAP del SIFEN.
     *
     * @param mixed $object Objeto de respuesta del SIFEN.
     *
     * @return self
     */
    public static function FromSifenResponseObject($object): self
    {
        $res = new GOblAfe();
        if (isset($object->cOblAfe)) {
            $res->cOblAfe = intval($object->cOblAfe);
        }
        if (isset($object->dDesOblAfe)) {
            $res->dDesOblAfe = strval($object->dDesOblAfe);
        }
        return $res;
    }
}
