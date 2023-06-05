<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

use Abiliomp\Pkuatia\Helpers\CurrencyHelper;
use DOMElement;

/**
 * ID:D010  Campos inherentes a la operación comercial PADRE:D001 
 */
class GOpeCom
{

    public ?int $iTipTra = null;     // D011 - Tipo de transacción
    public ?int $iTImp = null;       // D013 - Tipo de impuesto afectado
    public ?string $cMoneOpe = null; // D015 - Moneda de la operación
    public ?int $dCondTiCam = null;  // D017 - Condición del tipo de cambio
    public ?int $dTiCam = null;      // D018 - Tipo de cambio de la operación
    public ?int $iCondAnt = null;    // D019 - Condición del Anticipo

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setITipTra(int $iTipTra): void
    {
        $this->iTipTra = $iTipTra;
    }

    public function setITImp(int $iTImp): void
    {
        $this->iTImp = $iTImp;
    }

    public function setCMoneOpe(string $cMoneOpe): void
    {
        $this->cMoneOpe = $cMoneOpe;
    }

    public function setDCondTiCam(int $dCondTiCam): void
    {
        $this->dCondTiCam = $dCondTiCam;
    }

    public function setDTiCam(int $dTiCam): void
    {
        $this->dTiCam = $dTiCam;
    }

    public function setICondAnt(int $iCondAnt): void
    {
        $this->iCondAnt = $iCondAnt;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getITipTra(): int | null
    {
        return $this->iTipTra;
    }

    /**
     * Devuelve la descripción del tipo de transacción
     * 
     * @return string
     */
    public function getDDesTipTra(): string | null
    {
        switch ($this->iTipTra) {
            case 1:
                return 'Venta de mercadería';
                break;
            case 2:
                return 'Prestación de servicios';
                break;
            case 3:
                return 'Mixto'; // Venta de mercadería y servicios
                break;
            case 4:
                return 'Venta de activo fijo';
                break;
            case 5:
                return 'Venta de divisas';
                break;
            case 6:
                return 'Compra de divisas';
                break;
            case 7:
                return 'Promoción o entrega de muestras';
                break;
            case 8:
                return 'Donación';
                break;
            case 9:
                return 'Anticipo';
                break;
            case 10:
                return 'Compra de productos';
                break;
            case 11:
                return 'Compra de servicios';
                break;
            case 12:
                return 'Venta de crédito fiscal';
                break;
            case 13:
                return 'Muestras médicas (Art. 3 RG 24/2014)';
                break;
            default:
                return null;
        }
    }

    public function getITImp(): int | null
    {
        return $this->iTImp;
    }

    /**
     * Devuelve la descripción del tipo de impuesto afectado
     * 
     * @return string
     */
    public function getDDesTImp(): string | null
    {
        switch ($this->iTImp) {
            case 1:
                return 'IVA';
                break;
            case 2:
                return 'ISC';
                break;
            case 3:
                return 'Renta';
                break;
            case 4:
                return 'Ninguno';
                break;
            case 5:
                return 'IVA - Renta';
                break;
            default:
                return null;
        }
    }

    public function getCMoneOpe(): string | null
    {
        return $this->cMoneOpe;
    }

    /**
     *  D016 Descripción de la moneda de la operación

     *
     * @return string
     */
    public function getDDesMoneOpe() : string | null
    {
        return CurrencyHelper::getCurrDesc($this->cMoneOpe);
    }

    public function getDCondTiCam(): string | null
    {
        return $this->dCondTiCam;
    }

    public function getDTiCam(): string | null
    {
        return $this->dTiCam;
    }

    public function getICondAnt(): int | null
    {
        return $this->iCondAnt;
    }

    /**
     * D020 - Devuelve la descripción de la condición del anticipo
     * 
     * @return string
     */
    public function getDDesCondAnt(): string | null
    {
        switch ($this->iCondAnt) {
            case 1:
                return 'Anticipo Global';
                break;
            case 2:
                return 'Anticipo por Ítem';
                break;
            default:
                return null;
        }
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
        $res = new DOMElement('gOpeCom');

        if (isset($this->iTipTra)) {
            $res->appendChild(new DOMElement('iTipTra', $this->getITipTra()));
            $res->appendChild(new DOMElement('dDesTipTra', $this->getDDesTipTra()));
        }

        $res->appendChild(new DOMElement('iTImp', $this->getITImp()));
        $res->appendChild(new DOMElement('dDesTImp', $this->getDDesTImp()));
        $res->appendChild(new DOMElement('cMoneOpe', $this->getCMoneOpe()));
        $res->appendChild(new DOMElement('dDesMoneOpe', $this->getDDesMoneOpe()));

        if (strcmp($this->cMoneOpe, "PYG") != 0) {
            $res->appendChild(new DOMElement('dCondTiCam', $this->getDCondTiCam()));
        }

        if ($this->dCondTiCam != 2 && strcmp($this->cMoneOpe, "PYG") != 0) {
            $res->appendChild(new DOMElement('dTiCam', $this->getDTiCam()));
        }

        if ($this->iTipTra == 9) {
            // Anticipo
            $res->appendChild(new DOMElement('iCondAnt', $this->getICondAnt()));
            $res->appendChild(new DOMElement('dDesCondAnt', $this->getDDesCondAnt()));
        }

        return $res;
    }

    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return GOpeCom
    //  */
    // public static function fromDOMElement(DOMElement $xml): GOpeCom
    // {
    //     if (strcmp($xml->tagName, 'gOpeCom') == 0 && $xml->childElementCount >= 4) {
    //         $res = new GOpeCom();
    //         $res->setITipTra(intval($xml->getElementsByTagName('iTipTra')->item(0)->nodeValue));
    //         $res->setITImp(intval($xml->getElementsByTagName('iTImp')->item(0)->nodeValue));
    //         $res->setCMoneOpe($xml->getElementsByTagName('cMoneOpe')->item(0)->nodeValue);
    //         $res->setDCondTiCam(intval($xml->getElementsByTagName('dCondTiCam')->item(0)->nodeValue));
    //         $res->setDTiCam(intval($xml->getElementsByTagName('dTiCam')->item(0)->nodeValue));
    //         $res->setICondAnt(intval($xml->getElementsByTagName('iCondAnt')->item(0)->nodeValue));
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
        $res = new GOpeCom();
        if (isset($response->iTipTra)) {
            $res->setITipTra(intval($response->iTipTra));
        }

        if (isset($response->iTImp)) {
            $res->setITImp(intval($response->iTImp));
        }

        if (isset($response->cMoneOpe)) {
            $res->setCMoneOpe($response->cMoneOpe);
        }

        echo "cMoneOpe: " . $res->getCMoneOpe() . "\n";
        echo "dDESMODEPE" . $res->getDDesMoneOpe() . "\n";

        if (isset($response->dCondTiCam)) {
            $res->setDCondTiCam(intval($response->dCondTiCam));
        }

        if (isset($response->dTiCam)) {
            $res->setDTiCam(intval($response->dTiCam));
        }

        if (isset($response->iCondAnt)) {
            $res->setICondAnt(intval($response->iCondAnt));
        }

        return $res;
    }
}
