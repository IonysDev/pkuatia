<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\Utils\RucUtils;
use Abiliomp\Pkuatia\Helpers\DepartamentoHelper;
use Abiliomp\Pkuatia\Helpers\GeoRefCodesHelper;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id:     D100        
 * Nombre:      gEmis       
 * Descripción: Grupo de campos que identifican al emisor gEmis     
 * Nodo Padre:  D001 - gDatGralOpe - Campos generales del DE    
 */

class GEmis extends BaseSifenField
{
                                // Id - Longitud - Ocurrencia - Descripción
    public String  $dRucEm;     // D101 - 3-8   - 1-1 - RUC del contribuyente emisor
    public int     $dDVEmi;     // D102 - 1     - 1-1 - Dígito verificador del RUC del contribuyente emisor
    public int     $iTipCont;   // D103 - 1     - 1-1 - Tipo de contribuyente: 1 = Persona Física | 2 = Persona Jurídica
    public int     $cTipReg;    // D104 - 1-2   - 0-1 - Tipo de régimen: 1 = Régimen de Turismo | 2 = Importador | 3 = Exportador | 4 = Maquila | 5 = Ley N° 60/90 | 6 = Régimen del Pequeño Productor | 7 = Régimen del Mediano Productor | 8 = Régimen Contable
    public String  $dNomEmi;    // D105 - 4-255 - 1-1 - Nombre o razón social del emisor del DE
    public String  $dNomFanEmi; // D106 - 4-255 - 0-1 - Nombre de fantasía
    public String  $dDirEmi;    // D107 - 1-255 - 1-1 - Dirección del local donde se emite el DE
    public int     $dNumCas;    // D108 - 1-6   - 1-1 - Número de casa
    public String  $dCompDir1;  // D109 - 1-255 - 0-1 - Complemento de dirección 1
    public String  $dCompDir2;  // D110 - 1-255 - 0-1 - Complemento de dirección 2
    public int     $cDepEmi;    // D111 - 1-2   - 1-1 - Código del departamento de emisión
    public String  $dDesDepEmi; // D112 - 6-16  - 1-1 - Descripción del departamento de emisión
    public int     $cDisEmi;    // D113 - 1-4   - 0-1 - Código de la distrito de emisión
    public String  $dDesDisEmi; // D114 - 1-30  - 0-1 - Descripción de la distrito de emisión
    public int     $cCiuEmi;    // D115 - 1-5   - 1-1 - Código de la ciudad de emisión
    public String  $dDesCiuEmi; // D116 - 1-30  - 1-1 - Descripción de la ciudad de emisión
    public String  $dTelEmi;    // D117 - 6-15  - 1-1 - Teléfono local de emisión de DE 
    public String  $dEmailE;    // D118 - 3-80  - 1-1 - Correo electrónico del emisor
    public String  $dDenSuc;    // D119 - 1-30  - 0-1 - Denominación comercial de la sucursal
    public array   $gActEco;    // D130 -       - 1-9 - Grupo de campos que describen la actividad económica del emisor del tipo GActEco (D130)
    public GRespDE $gRespDE;    // D140 -       - 0-1 - Grupo de campos que identifican al responsable de la generación del DE
    
    ///////////////////////////////////////////////////////////////////////
    ///Constructor
    ///////////////////////////////////////////////////////////////////////
    public function __construct()
    {
        $this->gActEco = [];
    }

    ///////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////

    public function setDRucEm(String $dRucEm): self
    {
        $this->dRucEm = $dRucEm;
        return $this;
    }

    public function setDDVEmi(int $dDVEmi): self
    {
        $this->dDVEmi = $dDVEmi;
        return $this;
    }

    public function setITipCont(int $iTipCont): self
    {
        $this->iTipCont = $iTipCont;
        return $this;
    }

    public function setCTipReg(int $cTipReg): self
    {
        $this->cTipReg = $cTipReg;
        return $this;
    }

    public function setDNomEmi(String $dNomEmi): self
    {
        $this->dNomEmi = $dNomEmi;
        return $this;
    }

    public function setDNomFanEmi(String $dNomFanEmi): self
    {
        $this->dNomFanEmi = $dNomFanEmi;
        return $this;
    }

    public function setDDirEmi(String $dDirEmi): self
    {
        $this->dDirEmi = $dDirEmi;
        return $this;
    }

    public function setDNumCas(int $dNumCas): self
    {
        $this->dNumCas = $dNumCas;
        return $this;
    }

    public function setDCompDir1(String $dCompDir1): self
    {
        $this->dCompDir1 = $dCompDir1;
        return $this;
    }

    public function setDCompDir2(String $dCompDir2): self
    {
        $this->dCompDir2 = $dCompDir2;
        return $this;
    }

    public function setCDepEmi(int $cDepEmi): self
    {
        $this->cDepEmi = $cDepEmi;
        return $this;
    }

    public function setDDesDepEmi(String $dDesDepEmi): self
    {
        $this->dDesDepEmi = $dDesDepEmi;
        return $this;
    }

    public function setCDisEmi(int $cDisEmi): self
    {
        $this->cDisEmi = $cDisEmi;
        return $this;
    }

    public function setDDesDisEmi(String $dDesDisEmi): self
    {
        $this->dDesDisEmi = $dDesDisEmi;
        return $this;
    }

    public function setCCiuEmi(int $cCiuEmi): self
    {
        $this->cCiuEmi = $cCiuEmi;
        return $this;
    }

    public function setDDesCiuEmi(String $dDesCiuEmi): self
    {
        $this->dDesCiuEmi = $dDesCiuEmi;
        return $this;
    }

    public function setDTelEmi(String $dTelEmi): self
    {
        $this->dTelEmi = $dTelEmi;
        return $this;
    }

    public function setDEmailE(String $dEmailE): self
    {
        $this->dEmailE = $dEmailE;
        return $this;
    }

    public function setDDenSuc(String $dDenSuc): self
    {
        $this->dDenSuc = $dDenSuc;
        return $this;
    }

    public function setGActEco(array $gActEco): self
    {
        $this->gActEco = $gActEco;
        return $this;
    }

    public function setGRespDE(GRespDE $gRespDE): self
    {
        $this->gRespDE = $gRespDE;
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////

    public function getDRucEm(): String
    {
        return $this->dRucEm;
    }

    public function getDDVEmi(): int
    {
        return $this->dDVEmi;
    }

    public function getITipCont(): int
    {
        return $this->iTipCont;
    }

    public function getCTipReg(): int
    {
        return $this->cTipReg;
    }

    public function getDNomEmi(): String
    {
        return $this->dNomEmi;
    }

    public function getDNomFanEmi(): String 
    {
        return $this->dNomFanEmi;
    }

    public function getDDirEmi(): String
    {
        return $this->dDirEmi;
    }

    public function getDNumCas(): int
    {
        return $this->dNumCas;
    }

    public function getDCompDir1(): String
    {
        return $this->dCompDir1;
    }

    public function getDCompDir2(): String
    {
        return $this->dCompDir2;
    }

    public function getCDepEmi(): int
    {
        return $this->cDepEmi;
    }

    /**
     * D112 Descripción del departamento de emisión
     * 
     * @return String
     */
    public function getDDesDepEmi(): String
    {
        // return DepartamentoHelper::getDepName(strval($this->cDepEmi));
        return $this->dDesDepEmi;
    }

    public function getCDisEmi(): int
    {
        return $this->cDisEmi;
    }

    /**
     * D114 Descripción del distrito de emisión
     *
     * @return String
     */
    public function getDDesDisEmi(): String
    {
        // return GeoRefCodesHelper::getDistName(strval($this->cDisEmi));
        return $this->dDesDisEmi;
    }

    public function getCCiuEmi(): int
    {
        return $this->cCiuEmi;
    }

    /**
     *  D116 dDesCiuEmi Descripción de la ciudad de emisión
     *
     * @return String
     */
    public function getDDesCiuEmi(): String
    {
        // return GeoRefCodesHelper::getCiudName(strval($this->cCiuEmi));
        return $this->dDesCiuEmi;
    }

    public function getDTelEmi(): String
    {
        return $this->dTelEmi;
    }

    public function getDEmailE(): String
    {
        return $this->dEmailE;
    }

    public function getDDenSuc(): String
    {
        return $this->dDenSuc;
    }

    public function getGActEco(): array
    {
        return $this->gActEco;
    }

    public function getGRespDE(): GRespDE
    {
        return $this->gRespDE;
    }

    ///////////////////////////////////////////////////////////////////////
    // XML Element
    ///////////////////////////////////////////////////////////////////////

    /**
     * Instancia la clase a partir de un SimpleXMLElement
     * 
     * @param SimpleXMLElement $node
     * 
     * @return GEmis
     */
    public static function FromSimpleXMLElement(SimpleXMLElement $node) : self
    {
        if(strcmp($node->getName(), 'gEmis') != 0){
            throw new \InvalidArgumentException('El nombre del elemento no es gEmis');
        }
        $res = new GEmis();
        $res->dRucEm = strval($node->dRucEm);
        $res->dDVEmi = intval($node->dDVEmi);
        $res->iTipCont = intval($node->iTipCont);
        if(isset($node->cTipReg))
            $res->cTipReg = intval($node->cTipReg);
        $res->dNomEmi = strval($node->dNomEmi);
        if(isset($node->dNomFanEmi))
            $res->dNomFanEmi = strval($node->dNomFanEmi);
        $res->dDirEmi = strval($node->dDirEmi);
        $res->dNumCas = intval($node->dNumCas);
        if(isset($node->dCompDir1))
            $res->dCompDir1 = strval($node->dCompDir1);
        if(isset($node->dCompDir2))
            $res->dCompDir2 = strval($node->dCompDir2);
        $res->cDepEmi = intval($node->cDepEmi);
        $res->dDesDepEmi = strval($node->dDesDepEmi);
        if(isset($node->cDisEmi))
            $res->cDisEmi = intval($node->cDisEmi);
        if(isset($node->dDesDisEmi))
            $res->dDesDisEmi = strval($node->dDesDisEmi);
        $res->cCiuEmi = intval($node->cCiuEmi);
        $res->dDesCiuEmi = strval($node->dDesCiuEmi);
        $res->dTelEmi = strval($node->dTelEmi);
        $res->dEmailE = strval($node->dEmailE);
        if(isset($node->dDenSuc))
            $res->dDenSuc = strval($node->dDenSuc);
        if(isset($node->gActEco) && count($node->gActEco) > 0)
        {
            foreach($node->gActEco as $g)
            {
                $res->gActEco[] = GActEco::FromSimpleXMLElement($g);
            }
        }
        if(isset($node->gRespDE))
            $res->gRespDE = GRespDE::FromSimpleXMLElement($node->gRespDE);
        return $res;
    } 


    public function toDOMElement(): DOMElement
    {
        $res = new DOMElement('gEmis');
        $res->appendChild(new DOMElement('dRucEm', $this->dRucEm));
        $res->appendChild(new DOMElement('dDVEmi', $this->dDVEmi));
        $res->appendChild(new DOMElement('iTipCont', $this->iTipCont));
        $res->appendChild(new DOMElement('cTipReg', $this->cTipReg));
        $res->appendChild(new DOMElement('dNomEmi', $this->dNomEmi));
        $res->appendChild(new DOMElement('dNomFanEmi', $this->dNomFanEmi));
        $res->appendChild(new DOMElement('dDirEmi', $this->dDirEmi));
        $res->appendChild(new DOMElement('dNumCas', $this->dNumCas));
        $res->appendChild(new DOMElement('dCompDir1', $this->dCompDir1));
        $res->appendChild(new DOMElement('dCompDir2', $this->dCompDir2));
        $res->appendChild(new DOMElement('cDepEmi', $this->cDepEmi));
        $res->appendChild(new DOMElement('dDesDepEmi', $this->getDDesDepEmi()));
        $res->appendChild(new DOMElement('cDisEmi', $this->cDisEmi));
        $res->appendChild(new DOMElement('dDesDisEmi', $this->getDDesDisEmi()));
        $res->appendChild(new DOMElement('cCiuEmi', $this->cCiuEmi));
        $res->appendChild(new DOMElement('dDesCiuEmi', $this->getDDesCiuEmi()));
        $res->appendChild(new DOMElement('dTelEmi', $this->dTelEmi));
        $res->appendChild(new DOMElement('dEmailE', $this->dEmailE));
        $res->appendChild(new DOMElement('dDenSuc', $this->dDenSuc));
        ///Children
        if(isset($this->gActEco))
        {
            foreach ($this->gActEco as $g) {
                $res->appendChild($g->toDOMElement());
            }
        }
        if (isset($this->gRespDE)) {
            $res->appendChild($this->gRespDE->toDOMElement());
        }
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
        $gEmis = new GEmis();
        if (isset($object->dRucEm)) {
            $gEmis->setDRucEm($object->dRucEm);
        }
        if (isset($object->dDVEmi)) {
            $gEmis->setDDVEmi($object->dDVEmi);
        }
        if (isset($object->iTipCont)) {
            $gEmis->setITipCont($object->iTipCont);
        }
        if (isset($object->cTipReg)) {
            $gEmis->setCTipReg($object->cTipReg);
        }
        if (isset($object->dNomEmi)) {
            $gEmis->setDNomEmi($object->dNomEmi);
        }
        if (isset($object->dNomFanEmi)) {
            $gEmis->setDNomFanEmi($object->dNomFanEmi);
        }
        if (isset($object->dDirEmi)) {
            $gEmis->setDDirEmi($object->dDirEmi);
        }
        if (isset($object->dNumCas)) {
            $gEmis->setDNumCas($object->dNumCas);
        }

        if (isset($object->dCompDir1)) {
            $gEmis->setDCompDir1($object->dCompDir1);
        }
        if (isset($object->dCompDir2)) {
            $gEmis->setDCompDir2($object->dCompDir2);
        }
        if (isset($object->cDepEmi)) {
            $gEmis->setCDepEmi($object->cDepEmi);
        }
        if (isset($object->cDisEmi)) {
            $gEmis->setCDisEmi($object->cDisEmi);
        }
        if (isset($object->cCiuEmi)) {
            $gEmis->setCCiuEmi($object->cCiuEmi);
        }

        if (isset($object->dTelEmi)) {
            $gEmis->setDTelEmi($object->dTelEmi);
        }
        if (isset($object->dEmailE)) {
            $gEmis->setDEmailE($object->dEmailE);
        }
        if (isset($object->dDenSuc)) {
            $gEmis->setDDenSuc($object->dDenSuc);
        }
        //Children
        if (isset($object->gActEco)) {
            if(is_array($object->gActEco)) {
                foreach($object->gActEco as $g) {
                    $gEmis->gActEco[] = GActEco::FromSifenResponseObject($g);
                }
            }
            else {
                $gEmis->gActEco[] = GActEco::FromSifenResponseObject($object->gActEco);
            }
        }
        if (isset($object->gRespDE)) {
            $gEmis->setGRespDE(GRespDE::FromSifenResponseObject($object->gRespDE));
        }
        return $gEmis;
    }
}
