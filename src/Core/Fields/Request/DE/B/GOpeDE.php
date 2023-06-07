<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\B;

use DOMElement;

/**
 * ID:B001 Campos inherentes a la operación de DE PADRE:A001
 */
class GOpeDE
{
    public ?int $iTipEmi = null;       // B002 - Tipo de emision: 1 = Normal | 2 = Contingencia
    public ?int $dCodSeg = null;       // B004 - Código de seguridad: número que debe formatearse al exportar con 9 caracteres con 0s a la izquierda
    public ?string $dInfoEmi = null;   // B005 - Información de interés del emisor respecto al DE
    public ?string $dInfoFisc = null;  // B006 - Información de interés del fisco respecto al DE

    ///////////////////////////////////////////////////////////////////////
    // Constructors
    ///////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setITipEmi(int $iTipEmi): void
    {
        $this->iTipEmi = $iTipEmi;
    }

    public function setDCodSeg(int $dCodSeg): void
    {
        $this->dCodSeg = $dCodSeg;
    }

    public function setDInfoEmi(string $dInfoEmi): void
    {
        $this->dInfoEmi = $dInfoEmi;
    }

    /**
     * Set the value of dInfoFisc
     *
     * @param string $dInfoFisc
     *
     * @return self
     */
    public function setDInfoFisc(string $dInfoFisc): self
    {
        $this->dInfoFisc = $dInfoFisc;

        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getITipEmi(): int | null
    {
        return $this->iTipEmi;
    }

    public function getDDesTipEmi(): string | null
    {
        switch ($this->iTipEmi) {
            case 1:
                return 'Normal';
                break;
            case 2:
                return 'Contingencia';
                break;
            default:
                return null;
        }
    }

    public function getDCodSeg(): int | null
    {
        return $this->dCodSeg;
    }

    public function getDInfoEmi(): string | null
    {
        return $this->dInfoEmi;
    }

    /**
     * Get the value of dInfoFisc
     *
     * @return string
     */
    public function getDInfoFisc(): string | null
    {
        return $this->dInfoFisc;
    }
    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gOpeDE');
        $res->appendChild(new DOMElement('iTipEmi', $this->iTipEmi));
        $res->appendChild(new DOMElement('dDesTipEmi', $this->getDDesTipEmi()));
        $res->appendChild(new DOMElement('dCodSeg', str_pad(($this->dCodSeg % 1000000000), 9, "0", STR_PAD_LEFT)));
        $res->appendChild(new DOMElement('dInfoEmi', $this->dInfoEmi));
        $res->appendChild(new DOMElement('dInfoFisc', $this->dInfoFisc));
        return $res;
    }

    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return GOpeDE
    //  */
    // public static function fromDOMElement(DOMElement $xml): GOpeDE
    // {
    //     if (strcmp($xml->tagName, 'gOpeDE') == 0 && $xml->childElementCount == 5) {
    //         $res = new GOpeDE();
    //         $res->setITipEmi(intval($xml->getElementsByTagName('iTipEmi')->item(0)->nodeValue));
    //         $res->setDCodSeg(intval($xml->getElementsByTagName('dCodSeg')->item(0)->nodeValue));
    //         $res->setDInfoEmi($xml->getElementsByTagName('dInfoEmi')->item(0)->nodeValue);
    //         $res->setDInfoFisc($xml->getElementsByTagName('dInfoFisc')->item(0)->nodeValue);

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
        $res = new GOpeDE();
        if(isset($response->iTipEmi))
        {
            $res->setITipEmi(intval($response->iTipEmi));
        }
        if(isset($response->dCodSeg))
        {
            $res->setDCodSeg(intval($response->dCodSeg));
        }
        if(isset($response->dInfoEmi))
        {
            $res->setDInfoEmi($response->dInfoEmi);
        }
        if(isset($response->dInfoFisc))
        {
            $res->setDInfoFisc($response->dInfoFisc);
        }
        

        return $res;
    }
}
