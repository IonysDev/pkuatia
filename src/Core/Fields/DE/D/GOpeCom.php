<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Core\Constants\OpeComCondAnt;
use Abiliomp\Pkuatia\Core\Constants\OpeComCondTipCam;
use Abiliomp\Pkuatia\Core\Constants\OpeComTipImp;
use Abiliomp\Pkuatia\Core\Constants\OpeComTipTrans;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\DataMappings\MonedaMapping;
use Abiliomp\Pkuatia\Utils\ValueValidations;
use DOMDocument;
use DOMElement;
use InvalidArgumentException;
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
    public String $dDesTipTra;  // D012 - 5-39      - 0-1 - Descripción del tipo de transacción
    public int    $iTImp;       // D013 - 1         - 1-1 - Tipo de impuesto afectado
    public String $dDesTImp;    // D014 - 3-11      - 1-1 - Descripción del tipo de impuesto afectado
    public String $cMoneOpe;    // D015 - 3         - 1-1 - Moneda de la operación
    public String $dDesMoneOpe; // D016 - 3-20      - 1-1 - Descripción de la moneda de la operación
    public int    $dCondTiCam;  // D017 - 1         - 0-1 - Condición del tipo de cambio
    public String $dTiCam;      // D018 - 1-5p(0-4) - 0-1 - Tipo de cambio de la operación (decimal BCMath)
    public int    $iCondAnt;    // D019 - 1         - 0-1 - Condición del Anticipo
    public String $dDesCondAnt; // D020 - 15-17     - 0-1 - Descripción de la condición del anticipo

    ///////////////////////////////////////////////////////////////////////
    ///Constructor
    ///////////////////////////////////////////////////////////////////////


    public function __construct()
    {
        $this->setCMoneOpe("PYG");
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el tipo de transacción de la operación comercial. Así mismo establece la descripción del tipo de transacción.
     * 
     * @param int|OpeComTipTrans $iTipTra El tipo de transacción. Valores permitidos: 1 (Venta de mercadería), 2 (Prestación de servicios), 3 (Mixto), 4 (Venta de activo fijo), 5 (Venta de divisas), 6 (Compra de divisas), 7 (Promoción o entrega de muestras), 8 (Donación), 9 (Anticipo), 10 (Compra de productos), 11 (Compra de servicios), 12 (Venta de crédito fiscal), 13 (Muestras médicas)
     * 
     * @return self
     */
    public function setITipTra(int|OpeComTipTrans $iTipTra): self
    {
        $this->iTipTra = $iTipTra instanceof OpeComTipTrans ? $iTipTra->value : $iTipTra;
        $this->dDesTipTra = OpeComTipTrans::getDescripcion($this->iTipTra);
        return $this;
    }

    /**
     * Establece la descripción del tipo de transacción.
     * Este método no debería utilizarse para conformar un nuevo DE. Solo debe usarse para deserializar un DE existente.
     * 
     * @param String $dDesTipTra Descripción del tipo de transacción.
     * 
     * @return self
     */
    public function setDDesTipTra(String $dDesTipTra): self
    {
        $this->dDesTipTra = $dDesTipTra;
        return $this;
    }

    /**
     * Establece el tipo de impuesto afectado. Así mismo establece la descripción del tipo de impuesto afectado.
     * 
     * @param int|OpeComTipImp $iTImp El tipo de impuesto afectado. Valores permitidos: 1 (IVA), 2 (ISC), 3 (Renta), 4 (Ninguno), 5 (IVA - Renta)
     * 
     * @return self
     */
    public function setITImp(int|OpeComTipImp $iTImp): self
    {
        $this->iTImp = $iTImp instanceof OpeComTipImp ? $iTImp->value : $iTImp;
        $this->dDesTImp = OpeComTipImp::getDescripcion($this->iTImp);
        return $this;
    }

    /**
     * Establece la descripción del tipo de impuesto afectado. Este método no debería utilizarse para conformar un nuevo DE. Solo debe usarse para deserializar un DE existente.
     * 
     * @param String $dDesTImp Descripción del tipo de impuesto afectado.
     * 
     * @return self
     */
    public function setDDesTImp(String $dDesTImp): self
    {
        $this->dDesTImp = $dDesTImp;
        return $this;
    }

    public function setCMoneOpe(String $cMoneOpe): self
    {
        $this->cMoneOpe = $cMoneOpe;
        $this->dDesMoneOpe = MonedaMapping::GetDescription($this->cMoneOpe);
        if(is_null($this->dDesMoneOpe))
        {
            unset($this->cMoneOpe);
            throw new InvalidArgumentException("[GOpeCom] El valor del campo cMoneOpe no es válido: " . $cMoneOpe);
        }
        return $this;
    }


    public function setDDesMoneOpe(String $dDesMoneOpe): self
    {
        if(is_null($this->cMoneOpe) || strlen($dDesMoneOpe) == 0)
        {
            $this->dDesMoneOpe;
        }
        else 
        {
            $this->dDesMoneOpe = substr($dDesMoneOpe, 0, 20);
        }
        return $this;
    }

    /**
     * Establece la condición del tipo de cambio
     * 
     * @param int $dCondTiCam Valores permitidos: 1 (Global), 2 (Por ítem)
     * 
     * @return self
     */
    public function setDCondTiCam(int|OpeComCondTipCam $dCondTiCam): self
    {
        if($dCondTiCam instanceof int && $dCondTiCam != 1 && $dCondTiCam != 2)
        {
            unset($this->dCondTiCam);
            throw new InvalidArgumentException("[GOpeCom] El valor del campo dCondTiCam no es válido: " . $dCondTiCam);
        }
        else
        {
            $this->dCondTiCam = $dCondTiCam instanceof int ? $dCondTiCam : $dCondTiCam->value;
        }
        return $this;
    }

    /**
     * Establece el tipo de cambio de la operación.
     * 
     * @param String $dTiCam Valor de la tasa de cambio expresada en cadena decimal.
     * 
     * @return self
     */
    public function setDTiCam(String $dTiCam): self
    {
        if(ValueValidations::isValidStringDecimal($dTiCam, 5, 0))
        {
            $this->dTiCam = $dTiCam;
        }
        else
        {
            unset($this->dTiCam);
            throw new InvalidArgumentException("[GOpeCom] El valor del campo dTiCam no es válido: " . $dTiCam);
        }
        return $this;
    }

    /**
     * Establece la condición del anticipo y su descripción.
     * 
     * @param int $iCondAnt Valores permitidos: 1 (Anticipo Global), 2 (Anticipo por Ítem)
     * 
     * @return self
     */
    public function setICondAnt(int|OpeComCondAnt $iCondAnt): self
    {
        $this->iCondAnt = $iCondAnt instanceof OpeComCondAnt ? $iCondAnt->value : $iCondAnt;
        $this->dDesCondAnt = OpeComCondAnt::getDescripcion($this->iCondAnt );
        return $this;
    }

    /**
     * Establece la descripción de la condición del anticipo.
     * Este método no debería utilizarse para conformar un nuevo DE. Solo debe usarse para deserializar un DE existente.
     * 
     * @param String $dDesCondAnt
     * 
     * @return self
     */
    public function setDDesCondAnt(String $dDesCondAnt): self
    {
        $this->dDesCondAnt = $dDesCondAnt;
        return $this;
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
        if (isset($this->iTipTra) && $this->iTipTra == 9) {
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
