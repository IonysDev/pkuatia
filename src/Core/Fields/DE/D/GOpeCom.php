<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\DataMappings\MonedaMapping;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     D010
 * Nombre:      gOpeCom
 * Descripción: Campos inherentes a la operación comercial.
 * Nodo Padre:  D001 - dDatGralOpe - Campos generales del DE
 */

class GOpeCom extends BaseSifenField
{
                                // Id - Longitud - Ocurrencia - Descripción
    public int    $iTipTra;     // D011 - 1-2       - 0-1 - Tipo de transacción
    public String $dDesTipTra;  // D012 - 5-36      - 0-1 - Descripción del tipo de transacción
    public int    $iTImp;       // D013 - 1         - 1-1 - Tipo de impuesto afectado
    public String $dDesTImp;    // D014 - 3-11      - 1-1 - Descripción del tipo de impuesto afectado
    public String $cMoneOpe;    // D015 - 3         - 1-1 - Moneda de la operación
    public String $dDesMoneOpe; // D016 - 3-20      - 1-1 - Descripción de la moneda de la operación
    public int    $dCondTiCam;  // D017 - 1         - 0-1 - Condición del tipo de cambio
    public String $dTiCam;      // D018 - 1-5p(0-4) - 0-1 - Tipo de cambio de la operación (decimal BCMath)
    public int    $iCondAnt;    // D019 - 1         - 0-1 - Condición del Anticipo
    public String $dDesCondAnt; // D020 - 15-17     - 0-1 - Descripción de la condición del anticipo

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setITipTra(int $iTipTra): void
    {
        $this->iTipTra = $iTipTra;
        switch ($iTipTra) {
            case 1:
                $this->dDesTipTra = 'Venta de mercadería';
                break;
            case 2:
                $this->dDesTipTra = 'Prestación de servicios';
                break;
            case 3:
                $this->dDesTipTra = 'Mixto (Venta de mercadería y servicios)';
                break;
            case 4:
                $this->dDesTipTra = 'Venta de activo fijo';
                break;
            case 5:
                $this->dDesTipTra = 'Venta de divisas';
                break;
            case 6:
                $this->dDesTipTra = 'Compra de divisas';
                break;
            case 7:
                $this->dDesTipTra = 'Promoción o entrega de muestras';
                break;
            case 8:
                $this->dDesTipTra = 'Donación';
                break;
            case 9:
                $this->dDesTipTra = 'Anticipo';
                break;
            case 10:
                $this->dDesTipTra = 'Compra de productos';
                break;
            case 11:
                $this->dDesTipTra = 'Compra de servicios';
                break;
            case 12:
                $this->dDesTipTra = 'Venta de crédito fiscal';
                break;
            case 13:
                $this->dDesTipTra = 'Muestras médicas (Art. 3 RG 24/2014)';
                break;
            default:
                unset($this->iTipTra);
                throw new \InvalidArgumentException("[GOpeCom] El valor del campo iTipTra no es válido: " . $iTipTra);
                break;
        }
    }

    public function setDDesTipTra(String $dDesTipTra): void
    {
        if(is_null($this->iTipTra) || strlen($dDesTipTra) == 0)
        {
            $this->dDesTipTra;
        }
        else 
        {
            $this->dDesTipTra = substr($dDesTipTra, 0, 36);
        }
    }

    public function setITImp(int $iTImp): void
    {
        $this->iTImp = $iTImp;
        switch ($iTImp) {
            case 1:
                $this->dDesTImp = 'IVA';
                break;
            case 2:
                $this->dDesTImp = 'ISC';
                break;
            case 3:
                $this->dDesTImp = 'Renta';
                break;
            case 4:
                $this->dDesTImp = 'Ninguno';
                break;
            case 5:
                $this->dDesTImp = 'IVA - Renta';
                break;
            default:
                unset($this->iTImp);
                throw new \InvalidArgumentException("[GOpenCom] El valor del campo iTImp no es válido: " . $iTImp);
                break;
        }
    }

    public function setDDesTImp(String $dDesTImp): void
    {
        if(is_null($this->iTImp) || strlen($dDesTImp) == 0)
        {
            $this->dDesTImp;
        }
        else 
        {
            $this->dDesTImp = substr($dDesTImp, 0, 11);
        }
    }

    public function setCMoneOpe(String $cMoneOpe): void
    {
        $this->cMoneOpe = $cMoneOpe;
        $this->dDesMoneOpe = MonedaMapping::GetDescription($this->cMoneOpe);
        if(is_null($this->dDesMoneOpe))
        {
            unset($this->cMoneOpe);
            throw new \InvalidArgumentException("[GOpeCom] El valor del campo cMoneOpe no es válido: " . $cMoneOpe);
        }
    }

    public function setDDesMoneOpe(String $dDesMoneOpe): void
    {
        if(is_null($this->cMoneOpe) || strlen($dDesMoneOpe) == 0)
        {
            $this->dDesMoneOpe;
        }
        else 
        {
            $this->dDesMoneOpe = substr($dDesMoneOpe, 0, 20);
        }
    }

    /**
     * Establece la condición del tipo de cambio
     * 
     * @param int $dCondTiCam Valores permitidos: 1 (Global), 2 (Por ítem)
     * 
     * @return void
     */
    public function setDCondTiCam(int $dCondTiCam): void
    {
        if($dCondTiCam != 1 && $dCondTiCam != 2)
        {
            unset($this->dCondTiCam);
            throw new \InvalidArgumentException("[GOpeCom] El valor del campo dCondTiCam no es válido: " . $dCondTiCam);
        }
        else
        {
            $this->dCondTiCam = $dCondTiCam;
        }
    }

    /**
     * Establece el tipo de cambio de la operación.
     * 
     * @param String $dTiCam Valor de la tasa de cambio expresada en cadena decimal.
     * 
     * @return void
     */
    public function setDTiCam(String $dTiCam): void
    {
        if(ValueValidations::isValidStringDecimal($dTiCam, 5, 0))
        {
            $this->dTiCam = $dTiCam;
        }
        else
        {
            unset($this->dTiCam);
            throw new \InvalidArgumentException("[GOpeCom] El valor del campo dTiCam no es válido: " . $dTiCam);
        }
    }

    /**
     * Establece la condición del anticipo.
     * 
     * @param int $iCondAnt Valores permitidos: 1 (Anticipo Global), 2 (Anticipo por Ítem)
     * 
     * @return void
     */
    public function setICondAnt(int $iCondAnt): void
    {
        $this->iCondAnt = $iCondAnt;
        switch ($this->iCondAnt) {
            case 1:
                $this->dDesCondAnt = 'Anticipo Global';
                break;
            case 2:
                $this->dDesCondAnt = 'Anticipo por Ítem';
                break;
            default:
                unset($this->iCondAnt);
                unset($this->dDesCondAnt);
                throw new \InvalidArgumentException("[GOpeCom] El valor del campo iCondAnt no es válido: " . $iCondAnt);
                break;
        }
    }

    /**
     * Establece la descripción de la condición del anticipo.
     * 
     * @param String $dDesCondAnt
     * 
     * @return void
     */
    public function setDDesCondAnt(String $dDesCondAnt): void
    {
        if(is_null($this->iCondAnt) || strlen($dDesCondAnt) == 0)
        {
            $this->dDesCondAnt;
        }
        else 
        {
            $this->dDesCondAnt = substr($dDesCondAnt, 0, 17);
        }
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Devuelve el tipo de transacción
     * 
     * @return int
     */
    public function getITipTra(): int
    {
        return $this->iTipTra;
    }

    /**
     * Devuelve la descripción del tipo de transacción
     * 
     * @return String
     */
    public function getDDesTipTra(): String
    {
       return $this->dDesTipTra;
    }

    /**
     * Devuelve el tipo de impuesto afectado
     * 
     * @return int
     */
    public function getITImp(): int
    {
        return $this->iTImp;
    }

    /**
     * Devuelve la descripción del tipo de impuesto afectado
     * 
     * @return String
     */
    public function getDDesTImp(): String
    {
        return $this->dDesTImp;
    }

    /**
     * Devuelve la moneda de la operación
     * 
     * @return String
     */
    public function getCMoneOpe(): String
    {
        return $this->cMoneOpe;
    }

    /**
     *  Devuelve la descripción de la moneda de la operación
     *
     * @return String
     */
    public function getDDesMoneOpe() : String
    {
        return $this->dDesMoneOpe;
    }

    /**
     * Devuelve la condición del tipo de cambio
     * 
     * @return int
     */
    public function getDCondTiCam(): String
    {
        return $this->dCondTiCam;
    }

    /**
     * Devuelve el tipo de cambio de la operación
     * 
     * @return String
     */
    public function getDTiCam(): String
    {
        return $this->dTiCam;
    }

    /**
     * Devuelve la condición del anticipo
     * 
     * @return int
     */
    public function getICondAnt(): int
    {
        return $this->iCondAnt;
    }

    /**
     * Devuelve la descripción de la condición del anticipo
     * 
     * @return String
     */
    public function getDDesCondAnt(): String
    {
        return $this->dDesCondAnt;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia la clase a partir de un SimpleXMLElement
     * 
     * @param SimpleXMLElement $node
     * 
     * @return GOpeCom
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node): GOpeCom
    {
        if(strcmp($node->getName(), 'gOpeCom') != 0){
            throw new \InvalidArgumentException("El nombre del elemento debe ser 'gOpeCom'.");
        }
        $res = new GOpeCom();
        if(isset($node->iTipTra))
            $res->setITipTra(intval($node->iTipTra));
        if(isset($node->dDesTipTra))
            $res->setDDesTipTra((String)$node->dDesTipTra);
        $res->setITImp(intval($node->iTImp));
        $res->setDDesTImp((String)$node->dDesTImp);
        $res->setCMoneOpe((String)$node->cMoneOpe);
        $res->setDDesMoneOpe((String)$node->dDesMoneOpe);
        if(isset($node->dCondTiCam))
            $res->setDCondTiCam(intval($node->dCondTiCam));
        if(isset($node->dTiCam))
            $res->setDTiCam((String)$node->dTiCam);
        if(isset($node->iCondAnt))
            $res->setICondAnt(intval($node->iCondAnt));
        if(isset($node->dDesCondAnt))
            $res->setDDesCondAnt((String)$node->dDesCondAnt);
        return $res;
    }

    /**
     * Convierte este GOpeCom a un DOM Element.
     * 
     * @param DOMDocument $doc Documento DOM donde se creará el nodo, pero NO será insertado.
     *
     * @return DOMElement Nodo DOM creado pero no insertado.
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('gOpeCom');
        if (isset($this->iTipTra)) {
            $res->appendChild(new DOMElement('iTipTra', $this->getITipTra()));
            $res->appendChild(new DOMElement('dDesTipTra', $this->getDDesTipTra()));
        }
        $res->appendChild(new DOMElement('iTImp', $this->getITImp()));
        $res->appendChild(new DOMElement('dDesTImp', $this->getDDesTImp()));
        $res->appendChild(new DOMElement('cMoneOpe', $this->getCMoneOpe()));
        $res->appendChild(new DOMElement('dDesMoneOpe', $this->getDDesMoneOpe()));
        if (strcmp($this->cMoneOpe, "PYG") != 0)
            $res->appendChild(new DOMElement('dCondTiCam', $this->getDCondTiCam()));
        if (strcmp($this->cMoneOpe, "PYG") != 0 && $this->dCondTiCam != 2)
            $res->appendChild(new DOMElement('dTiCam', $this->getDTiCam()));
        if ($this->iTipTra == 9) {
            $res->appendChild(new DOMElement('iCondAnt', $this->getICondAnt()));
            $res->appendChild(new DOMElement('dDesCondAnt', $this->getDDesCondAnt()));
        }
        return $res;
    }

    /**
     * Instancia un GOpeCom a partir de un DOMElement que lo representa.
     * 
     * @param DOMElement $node Nodo DOM que representa el objeto.
     * 
     * @return GOpeCom
     */
    public static function FromDOMElement(DOMElement $node): self
    {
        if(strcmp($node->nodeName, 'gOpeCom') != 0)
            throw new \Exception('[GOpeCom] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new GOpeCom();
        if($node->getElementsByTagName('iTipTra')->length > 0)
            $res->setITipTra(intval(trim($node->getElementsByTagName('iTipTra')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dDesTipTra')->length > 0)
            $res->setDDesTipTra(trim(strval($node->getElementsByTagName('dDesTipTra')->item(0)->nodeValue)));
        $res->setITImp(intval($node->getElementsByTagName('iTImp')->item(0)->nodeValue));
        $res->setDDesTImp(strval($node->getElementsByTagName('dDesTImp')->item(0)->nodeValue));
        $res->setCMoneOpe(trim(strval($node->getElementsByTagName('cMoneOpe')->item(0)->nodeValue)));
        $res->setDDesMoneOpe(trim(strval($node->getElementsByTagName('dDesMoneOpe')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dCondTiCam')->length > 0)
            $res->setDCondTiCam(intval(trim($node->getElementsByTagName('dCondTiCam')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dTiCam')->length > 0)
            $res->setDTiCam(trim(strval($node->getElementsByTagName('dTiCam')->item(0)->nodeValue)));
        if($node->getElementsByTagName('iCondAnt')->length > 0)
            $res->setICondAnt(intval(trim($node->getElementsByTagName('iCondAnt')->item(0)->nodeValue)));
        if($node->getElementsByTagName('dDesCondAnt')->length > 0)
            $res->setDDesCondAnt(trim(strval($node->getElementsByTagName('dDesCondAnt')->item(0)->nodeValue)));
        return $res;
    }


    /**
     * FromSifenResponseObject
     *
     * @param  mixed $object
     * @return self
     */
    public static function FromSifenResponseObject($object): self
    {
        $res = new GOpeCom();
        if (isset($object->iTipTra)) {
            $res->setITipTra(intval($object->iTipTra));
        }

        if (isset($object->iTImp)) {
            $res->setITImp(intval($object->iTImp));
        }

        if (isset($object->cMoneOpe)) {
            $res->setCMoneOpe($object->cMoneOpe);
        }

        if (isset($object->dCondTiCam)) {
            $res->setDCondTiCam(intval($object->dCondTiCam));
        }

        if (isset($object->dTiCam)) {
            $res->setDTiCam(intval($object->dTiCam));
        }

        if (isset($object->iCondAnt)) {
            $res->setICondAnt(intval($object->iCondAnt));
        }

        return $res;
    }
}
