<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use DOMElement;

/**
 * ID:E960 Campos que identifican al vehículo del traslado de mercaderías
 * PADRE:E900
 */
class GVehTras
{
    public ?string $dTiVehTras = null; //E961Tipo de vehículo
    public ?string $dMarVeh = null; //E962 Marca
    public ?int $dTipIdenVeh = null; ///E967 Tipo de identificación del vehículo 
    public ?string $dNroIDVeh = null; /// E963 Número de identificación del vehículo
    public ?string $dAdicVeh = null; ///E964 Datos adicionales del vehículo
    public ?string $dNroMatVeh = null; // E965 Número de matrícula del vehículo
    public ?string $dNroVuelo = null; //E966 Número de vuelo

    ///////////////////////////////////////////////////////////////////////
    ///Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Set the value of dTiVehTras
     *
     * @param string $dTiVehTras
     *
     * @return self
     */
    public function setDTiVehTras(string $dTiVehTras): self
    {
        $this->dTiVehTras = $dTiVehTras;

        return $this;
    }

    /**
     * Set the value of dMarVeh
     *
     * @param string $dMarVeh
     *
     * @return self
     */
    public function setDMarVeh(string $dMarVeh): self
    {
        $this->dMarVeh = $dMarVeh;

        return $this;
    }


    /**
     * Set the value of dTipIdenVeh
     *
     * @param int $dTipIdenVeh
     *
     * @return self
     */
    public function setDTipIdenVeh(int $dTipIdenVeh): self
    {
        $this->dTipIdenVeh = $dTipIdenVeh;

        return $this;
    }


    /**
     * Set the value of dNroIDVeh
     *
     * @param string $dNroIDVeh
     *
     * @return self
     */
    public function setDNroIDVeh(string $dNroIDVeh): self
    {
        $this->dNroIDVeh = $dNroIDVeh;

        return $this;
    }


    /**
     * Set the value of dNroMatVeh
     *
     * @param string $dNroMatVeh
     *
     * @return self
     */
    public function setDNroMatVeh(string $dNroMatVeh): self
    {
        $this->dNroMatVeh = $dNroMatVeh;

        return $this;
    }


    /**
     * Set the value of dNroVuelo
     *
     * @param string $dNroVuelo
     *
     * @return self
     */
    public function setDNroVuelo(string $dNroVuelo): self
    {
        $this->dNroVuelo = $dNroVuelo;

        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    ///GETTERS
    ///////////////////////////////////////////////////////////////////////


    /**
     * Get the value of dTiVehTras
     *
     * @return string
     */
    public function getDTiVehTras(): string | null
    {
        return $this->dTiVehTras;
    }

    /**
     * Get the value of dMarVeh
     *
     * @return string
     */
    public function getDMarVeh(): string | null
    {
        return $this->dMarVeh;
    }

    /**
     * Get the value of dTipIdenVeh
     *
     * @return int
     */
    public function getDTipIdenVeh(): int | null
    {
        return $this->dTipIdenVeh;
    }

    /**
     * Get the value of dNroIDVeh
     *
     * @return string
     */
    public function getDNroIDVeh(): string | null
    {
        return $this->dNroIDVeh;
    }

    /**
     * Get the value of dAdicVeh
     *
     * @return string
     */
    public function getDAdicVeh(): string | null
    {
        return $this->dAdicVeh;
    }

    /**
     * Get the value of dNroMatVeh
     *
     * @return string
     */
    public function getDNroMatVeh(): string | null
    {
        return $this->dNroMatVeh;
    }

    /**
     * Get the value of dNroVuelo
     *
     * @return string
     */
    public function getDNroVuelo(): string | null
    {
        return $this->dNroVuelo;
    }

    ///////////////////////////////////////////////////////////////////////
    //XML Element  
    ///////////////////////////////////////////////////////////////////////

    /**
     * toDOMElement
     *
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gVehTras');

        $res->appendChild(new DOMElement('dTiVehTras', $this->getDTiVehTras()));
        $res->appendChild(new DOMElement('dMarVeh', $this->getDMarVeh()));
        $res->appendChild(new DOMElement('dTipIdenVeh', $this->getDTipIdenVeh()));

        if ($this->dTipIdenVeh == 1) {
            $res->appendChild(new DOMElement('dNroIDVeh', $this->getDNroIDVeh()));
        }

        $res->appendChild(new DOMElement('dAdicVeh', $this->getDAdicVeh()));

        if ($this->dTipIdenVeh == 2) {
            $res->appendChild(new DOMElement('dNroMatVeh', $this->getDNroMatVeh()));
        }

        $res->appendChild(new DOMElement('dNroVuelo', $this->getDNroVuelo()));

        return $res;
    }

    // /**
    //  * fromDOMElement
    //  *
    //  * @param  mixed $xml
    //  * @return GVehTras
    //  */
    // public static function fromDOMElement(DOMElement $xml): GVehTras
    // {
    //     if (strcmp($xml->tagName, 'gVehTras') == 0 && $xml->childElementCount >= 5) {
    //         $res = new GVehTras();
    //         $res->setDTiVehTras($xml->getElementsByTagName('dTiVehTras')->item(0)->nodeValue);
    //         $res->setDMarVeh($xml->getElementsByTagName('dMarVeh')->item(0)->nodeValue);
    //         $res->setDTipIdenVeh(intval($xml->getElementsByTagName('dTipIdenVeh')->item(0)->nodeValue));
    //         $res->setDNroIDVeh($xml->getElementsByTagName('dNroIDVeh')->item(0)->nodeValue);
    //         $res->setDAdicVeh($xml->getElementsByTagName('dAdicVeh')->item(0)->nodeValue); 
    //         $res->setDNroMatVeh($xml->getElementsByTagName('dNroMatVeh')->item(0)->nodeValue);
    //         $res->setDNroVuelo($xml->getElementsByTagName('dNroVuelo')->item(0)->nodeValue);

    //         return $res;

    //     }
    //     else {
    //         throw new \Exception("Invalid XML Element: $xml->tagName");
    //         return null;
    //       }
    // }


    /**
     * Set the value of dAdicVeh
     *
     * @param string $dAdicVeh
     *
     * @return self
     */
    public function setDAdicVeh(string $dAdicVeh): self
    {
        $this->dAdicVeh = $dAdicVeh;

        return $this;
    }

    /**
     * FromSifenResponseObject
     *
     * @param  mixed $object
     * @return self
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
}
