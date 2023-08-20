<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\B;

use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\Utils\RNG;
use DOMElement;

/**
 * Nodo Id: B001        
 * Nombre: gOpeDE       
 * Descripción: Campos inherentes a la operación de DE      
 * Nodo Padre: A001     
 */

class GOpeDE extends BaseSifenField
{
    public int    $iTipEmi;    // B002 - 1      - 1-1 - Tipo de emisión: 1 - Normal, 2 - Contingencia
    public int    $dDesTipEmi; // B003 - 6-12   - 1-1 - Descripción del tipo de emisión
    public String $dCodSeg;    // B004 - 9      - 1-1 - Código de seguridad: número que debe formatearse al exportar con 9 caracteres con 0s a la izquierda
    public String $dInfoEmi;   // B005 - 1-3000 - 0-1 - Información de interés del emisor respecto al DE
    public String $dInfoFisc;  // B006 - 1-3000 - 0-1 - Información de interés del fisco respecto al DE

    /**
     * Constructor
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
     * @param int $iTipEmi
     * 
     * @return self
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
     * 
     * @param String $dDesTipEmi
     * 
     * @return self
     */
    public function setDDesTipEmi(String $dDesTipEmi): self
    {
        $this->dDesTipEmi = $dDesTipEmi;
        return $this;
    }


    /**
     * Establece el valor de dCodSeg que representa el código de seguridad del documento.
     * 
     * @param String $dCodSeg
     * 
     * @return self
     */
    public function setDCodSeg(String $dCodSeg): self
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
        return $this->dDesTipEmi;
    }

    public function getDCodSeg(): String
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
    // Instanciadores
    ///////////////////////////////////////////////////////////////////////

    public static function FromSimpleXMLElement(\SimpleXMLElement $node): self
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

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte el objeto en un DOMElement
     * 
     * @return DOMElement
     */
    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gOpeDE');
        $res->appendChild(new DOMElement('iTipEmi', $this->iTipEmi));
        $res->appendChild(new DOMElement('dDesTipEmi', $this->dDesTipEmi));
        $res->appendChild(new DOMElement('dCodSeg', $this->dCodSeg));
        if(isset($this->dInfoEmi))
            $res->appendChild(new DOMElement('dInfoEmi', $this->dInfoEmi));
        if(isset($this->dInfoFisc))
            $res->appendChild(new DOMElement('dInfoFisc', $this->dInfoFisc));
        return $res;
    }

    
}
