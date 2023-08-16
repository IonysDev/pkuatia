<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\D;

use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Utils\RucUtils;
use Abiliomp\Pkuatia\Helpers\DepartamentoHelper;
use Abiliomp\Pkuatia\Helpers\GeoRefCodesHelper;
use DOMElement;
use SimpleXMLElement;

/**
 * Nodo Id: D100
 * Descripción: Grupo de campos que identifican al emisor gEmis
 * Nodo Padre: gDatGralOpe (D001)
 */

class GEmis
{

    public String  $dRucEm;     // RUC del contribuyente emisor (D101)
    public int     $dDVEmi;     // Dígito verificador del RUC del contribuyente emisor (D102)
    public int     $iTipCont;   // Tipo de contribuyente (D103): 1 = Persona Física | 2 = Persona Jurídica
    public int     $cTipReg;    // Tipo de régimen (D104): 1 = Régimen de Turismo | 2 = Importador | 3 = Exportador | 4 = Maquila | 5 = Ley N° 60/90 | 6 = Régimen del Pequeño Productor | 7 = Régimen del Mediano Productor | 8 = Régimen Contable
    public String  $dNomEmi;    // Nombre o razón social del emisor del DE (D105)
    public String  $dNomFanEmi; // Nombre de fantasía (D106)
    public String  $dDirEmi;    // Dirección del local donde se emite el DE (D107)
    public int     $dNumCas;    // Número de casa (D108)
    public String  $dCompDir1;  // Complemento de dirección 1 (D109)
    public String  $dCompDir2;  // Complemento de dirección 2 (D110)
    public int     $cDepEmi;    // Código del departamento de emisión (D111)
    public String  $dDesDepEmi; // Descripción del departamento de emisión (D112)
    public int     $cDisEmi;    // Código de la distrito de emisión (D113)
    public String  $dDesDisEmi; // Descripción de la distrito de emisión (D114)
    public int     $cCiuEmi;    // Código de la ciudad de emisión (D115)
    public String  $dDesCiuEmi; // Descripción de la ciudad de emisión (D116)
    public String  $dTelEmi;    // Teléfono local de emisión de DE (D117)
    public String  $dEmailE;    // Correo electrónico del emisor (D118)
    public String  $dDenSuc;    // Denominación comercial de la sucursal (D119)
    public array   $gActEco;    // Grupo de campos que describen la actividad económica del emisor del tipo GActEco (D130)
    public GRespDE $gRespDE;    // Grupo de campos que identifican al responsable de la generación del DE
    
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
     * fromResponse
     *
     * @param  mixed $response
     * @return self
     */
    public static function fromResponse($response): self
    {
        $gEmis = new GEmis();
        if (isset($response->dRucEm)) {
            $gEmis->setDRucEm($response->dRucEm);
        }
        if (isset($response->dDVEmi)) {
            $gEmis->setDDVEmi($response->dDVEmi);
        }
        if (isset($response->iTipCont)) {
            $gEmis->setITipCont($response->iTipCont);
        }
        if (isset($response->cTipReg)) {
            $gEmis->setCTipReg($response->cTipReg);
        }
        if (isset($response->dNomEmi)) {
            $gEmis->setDNomEmi($response->dNomEmi);
        }
        if (isset($response->dNomFanEmi)) {
            $gEmis->setDNomFanEmi($response->dNomFanEmi);
        }
        if (isset($response->dDirEmi)) {
            $gEmis->setDDirEmi($response->dDirEmi);
        }
        if (isset($response->dNumCas)) {
            $gEmis->setDNumCas($response->dNumCas);
        }

        if (isset($response->dCompDir1)) {
            $gEmis->setDCompDir1($response->dCompDir1);
        }
        if (isset($response->dCompDir2)) {
            $gEmis->setDCompDir2($response->dCompDir2);
        }
        if (isset($response->cDepEmi)) {
            $gEmis->setCDepEmi($response->cDepEmi);
        }
        if (isset($response->cDisEmi)) {
            $gEmis->setCDisEmi($response->cDisEmi);
        }
        if (isset($response->cCiuEmi)) {
            $gEmis->setCCiuEmi($response->cCiuEmi);
        }

        if (isset($response->dTelEmi)) {
            $gEmis->setDTelEmi($response->dTelEmi);
        }
        if (isset($response->dEmailE)) {
            $gEmis->setDEmailE($response->dEmailE);
        }
        if (isset($response->dDenSuc)) {
            $gEmis->setDDenSuc($response->dDenSuc);
        }
        //Children
        if (isset($response->gActEco)) {
            if(is_array($response->gActEco)) {
                foreach($response->gActEco as $g) {
                    $gEmis->gActEco[] = GActEco::fromResponse($g);
                }
            }
            else {
                $gEmis->gActEco[] = GActEco::fromResponse($response->gActEco);
            }
        }
        if (isset($response->gRespDE)) {
            $gEmis->setGRespDE(GRespDE::fromResponse($response->gRespDE));
        }
        return $gEmis;
    }
}
