<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\B;

use DOMElement;

/**
 * Nodo Id: B001
 * Descripción: Campos inherentes a la operación de DE 
 * Nodo Padre: A001
 */
class GOpeDE
{
    public int    $iTipEmi;   // B002 - Tipo de emision: 1 = Normal | 2 = Contingencia
    public int    $dCodSeg;   // B004 - Código de seguridad: número que debe formatearse al exportar con 9 caracteres con 0s a la izquierda
    public String $dInfoEmi;  // B005 - Información de interés del emisor respecto al DE
    public String $dInfoFisc; // B006 - Información de interés del fisco respecto al DE

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    /**
     * Establece el valor de iTipEmi que representa el tipo de emisión del documento.
     * 
     * @param int $iTipEmi
     * 
     * @return self
     */
    public function setITipEmi(int $iTipEmi): self
    {
        $this->iTipEmi = $iTipEmi;
        return $this;
    }


    /**
     * Establece el valor de dCodSeg que representa el código de seguridad del documento.
     * 
     * @param int $dCodSeg
     * 
     * @return self
     */
    public function setDCodSeg(int $dCodSeg): self
    {
        $this->dCodSeg = $dCodSeg;
        return $this;
    }

    /**
     * Establece el valor de dInfoEmi que representa información de interés del emisor respecto al documento.
     * 
     * @param String $dInfoEmi
     * 
     * @return self
     */
    public function setDInfoEmi(String $dInfoEmi): self
    {
        $this->dInfoEmi = $dInfoEmi;
        return $this;
    }

    /**
     * Establece el valor de dInfoFisc que representa información de interés del fisco respecto al documento.
     *
     * @param String $dInfoFisc
     *
     * @return self
     */
    public function setDInfoFisc(String $dInfoFisc): self
    {
        $this->dInfoFisc = $dInfoFisc;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getITipEmi(): int
    {
        return $this->iTipEmi;
    }

    public function getDDesTipEmi(): String
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

    public function getDCodSeg(): int
    {
        return $this->dCodSeg;
    }

    public function getDInfoEmi(): String
    {
        return $this->dInfoEmi;
    }

    /**
     * Get the value of dInfoFisc
     *
     * @return String
     */
    public function getDInfoFisc(): String
    {
        return $this->dInfoFisc;
    }
    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    public static function FromSimpleXMLElement(\SimpleXMLElement $xml){
        if(strcmp($xml->getName(), 'gOpeDE') != 0){
            throw new \Exception('El nombre del nodo no corresponde a gOpeDE');
        }
        $res = new GOpeDE();
        $res->setITipEmi(intval($xml->iTipEmi));
        $res->setDCodSeg(intval($xml->dCodSeg));
        $res->setDInfoEmi($xml->dInfoEmi);
        $res->setDInfoFisc($xml->dInfoFisc);
        return $res;
    }
    
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
