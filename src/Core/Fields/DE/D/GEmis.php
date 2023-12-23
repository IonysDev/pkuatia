<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\D;

use Abiliomp\Pkuatia\Config;
use Abiliomp\Pkuatia\Core\Constants\EmisRecTipCont;
use Abiliomp\Pkuatia\Core\Constants\TipoDeRegimen;
use Abiliomp\Pkuatia\Core\Fields\BaseSifenField;
use Abiliomp\Pkuatia\Utils\RucUtils;
use Abiliomp\Pkuatia\DataMappings\DepartamentoMapping;
use Abiliomp\Pkuatia\DataMappings\PyGeoCodesMapping;
use DOMDocument;
use DOMElement;
use InvalidArgumentException;
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

    public function setITipCont(int|EmisRecTipCont $iTipCont): self
    {
        $this->iTipCont = $iTipCont instanceof EmisRecTipCont ? $iTipCont->value : $iTipCont;
        return $this;
    }

    public function setCTipReg(int|TipoDeRegimen $cTipReg): self
    {
        $this->cTipReg = $cTipReg instanceof TipoDeRegimen ? $cTipReg->value : $cTipReg;
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

    /**
     * Establece el código de departamento de emisión (D111) y su descripción (D112).
     * Valida que el código de departamento exista en la lista de departamentos del SIFEN.
     * 
     * @param int $cDepEmi Código de departamento de emisión.
     * 
     * @return self
     */
    public function setCDepEmi(int $cDepEmi): self
    {
        $this->dDesDepEmi = DepartamentoMapping::getDepName(strval($this->cDepEmi));
        if(is_null($this->dDesDepEmi))
            throw new InvalidArgumentException("[GEmis::setCDepEmi] El código de departamento $cDepEmi no existe.");
        $this->cDepEmi = $cDepEmi;
        return $this;
    }

    /**
     * Establece la descripción del departamento de emisión (D114).
     * Este método solo debería utilizarse al deserializar un objeto GEmis de un XML.
     * 
     * @param String $dDesDepEmi Descripción del departamento de emisión.
     * 
     * @return self
     */
    public function setDDesDepEmi(String $dDesDepEmi): self
    {
        $this->dDesDepEmi = $dDesDepEmi;
        return $this;
    }

    /**
     * Establece el código del distrito de emisión (D113) y su descripción (D114).
     * Valida que el código de distrito exista en la lista de distritos del SIFEN.
     * 
     * @param int $cDisEmi Código del distrito de emisión (D113).
     * 
     * @return self
     */
    public function setCDisEmi(int $cDisEmi): self
    {
        $this->cDisEmi = PyGeoCodesMapping::getDistName(strval($this->cDisEmi));
        if(is_null($this->cDisEmi))
            throw new InvalidArgumentException("[GEmis::setCDisEmi] El código de distrito $cDisEmi no existe.");
        $this->cDisEmi = $cDisEmi;
        return $this;
    }

    /**
     * Establece la descripción del distrito de emisión (D114).
     * Este método solo debería utilizarse al deserializar un objeto GEmis de un XML.
     * 
     * @param String $dDesDisEmi Descripción del distrito de emisión.
     * 
     * @return self
     */
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
        // return PyGeoCodesMapping::getCiudName(strval($this->cCiuEmi));
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
    // Instanciadores
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

    /**
     * Instancia un objeto GEmis a partir de un DOMElement que lo representa.
     * 
     * @param DOMElement $node El DOMElement que representa al GEmis.
     * 
     * @return GEmis El GEmis representado por el DOMElement dado.
     */
    public static function FromDOMElement(DOMElement $node) : self
    {
        if(strcmp($node->nodeName, 'gEmis') != 0)
            throw new \Exception('[GEmis] Nodo con nombre inválido: ' . $node->nodeName);
        $res = new self();
        $res->dRucEm = trim($node->getElementsByTagName('dRucEm')->item(0)->nodeValue);
        $res->dDVEmi = intval(trim($node->getElementsByTagName('dDVEmi')->item(0)->nodeValue));
        $res->iTipCont = intval(trim($node->getElementsByTagName('iTipCont')->item(0)->nodeValue));
        if($node->getElementsByTagName('cTipReg')->length > 0)
            $res->cTipReg = intval(trim($node->getElementsByTagName('cTipReg')->item(0)->nodeValue));
        $res->dNomEmi = trim($node->getElementsByTagName('dNomEmi')->item(0)->nodeValue);
        if($node->getElementsByTagName('dNomFanEmi')->length > 0)
            $res->dNomFanEmi = trim($node->getElementsByTagName('dNomFanEmi')->item(0)->nodeValue);
        $res->dDirEmi = trim($node->getElementsByTagName('dDirEmi')->item(0)->nodeValue);
        $res->dNumCas = intval(trim($node->getElementsByTagName('dNumCas')->item(0)->nodeValue));
        if($node->getElementsByTagName('dCompDir1')->length > 0)
            $res->dCompDir1 = trim($node->getElementsByTagName('dCompDir1')->item(0)->nodeValue);
        if($node->getElementsByTagName('dCompDir2')->length > 0)
            $res->dCompDir2 = trim($node->getElementsByTagName('dCompDir2')->item(0)->nodeValue);
        $res->cDepEmi = intval(trim($node->getElementsByTagName('cDepEmi')->item(0)->nodeValue));
        $res->dDesDepEmi = trim($node->getElementsByTagName('dDesDepEmi')->item(0)->nodeValue);
        if($node->getElementsByTagName('cDisEmi')->length > 0)
            $res->cDisEmi = intval(trim($node->getElementsByTagName('cDisEmi')->item(0)->nodeValue));
        if($node->getElementsByTagName('dDesDisEmi')->length > 0)
            $res->dDesDisEmi = trim($node->getElementsByTagName('dDesDisEmi')->item(0)->nodeValue);
        $res->cCiuEmi = intval(trim($node->getElementsByTagName('cCiuEmi')->item(0)->nodeValue));
        $res->dDesCiuEmi = trim($node->getElementsByTagName('dDesCiuEmi')->item(0)->nodeValue);
        $res->dTelEmi = trim($node->getElementsByTagName('dTelEmi')->item(0)->nodeValue);
        $res->dEmailE = trim($node->getElementsByTagName('dEmailE')->item(0)->nodeValue);
        if($node->getElementsByTagName('dDenSuc')->length > 0)
            $res->dDenSuc = trim($node->getElementsByTagName('dDenSuc')->item(0)->nodeValue);
        if($node->getElementsByTagName('gActEco')->length > 0)
        {
            foreach($node->getElementsByTagName('gActEco') as $g)
            {
                $res->gActEco[] = GActEco::FromDOMElement($g);
            }
        }
        if($node->getElementsByTagName('gRespDE')->length > 0)
            $res->gRespDE = GRespDE::FromDOMElement($node->getElementsByTagName('gRespDE')->item(0));
        return $res;
    }

    /**
     * Instancia un objeto GEmis a partir de un objeto stdClass producido por una respuesta del SIFEN
     *
     * @param stdClass $object Objeto stdClass que contiene los datos de la respuesta del SIFEN.
     * 
     * @return self Objeto GEmis instanciado.
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

    ///////////////////////////////////////////////////////////////////////
    // Conversores
    ///////////////////////////////////////////////////////////////////////

    /**
     * Convierte este GEmis en un DOMElement que puede ser insertado en un DOMDocument.
     * 
     * @param DOMDocument $doc Documento DOM donde se creará el DOMElement sin insertarse.
     * 
     * @return DOMElement El DOMElement que representa a este GEmis.
     */
    public function toDOMElement(DOMDocument $doc): DOMElement
    {
        $res = $doc->createElement('gEmis');
        $res->appendChild(new DOMElement('dRucEm', $this->dRucEm));
        $res->appendChild(new DOMElement('dDVEmi', $this->dDVEmi));
        $res->appendChild(new DOMElement('iTipCont', $this->iTipCont));
        if(isset($this->cTipReg))
            $res->appendChild(new DOMElement('cTipReg', $this->cTipReg));
        $res->appendChild(new DOMElement('dNomEmi', $this->dNomEmi));
        if(isset($this->dNomFanEmi))
            $res->appendChild(new DOMElement('dNomFanEmi', $this->dNomFanEmi));
        $res->appendChild(new DOMElement('dDirEmi', $this->dDirEmi));
        $res->appendChild(new DOMElement('dNumCas', $this->dNumCas));
        if(isset($this->dCompDir1))
            $res->appendChild(new DOMElement('dCompDir1', $this->dCompDir1));
        if(isset($this->dCompDir2))
            $res->appendChild(new DOMElement('dCompDir2', $this->dCompDir2));
        $res->appendChild(new DOMElement('cDepEmi', $this->cDepEmi));
        $res->appendChild(new DOMElement('dDesDepEmi', $this->getDDesDepEmi()));
        if(isset($this->cDisEmi))
            $res->appendChild(new DOMElement('cDisEmi', $this->cDisEmi));
        if(isset($this->dDesDisEmi))
            $res->appendChild(new DOMElement('dDesDisEmi', $this->getDDesDisEmi()));
        $res->appendChild(new DOMElement('cCiuEmi', $this->cCiuEmi));
        $res->appendChild(new DOMElement('dDesCiuEmi', $this->getDDesCiuEmi()));
        $res->appendChild(new DOMElement('dTelEmi', $this->dTelEmi));
        $res->appendChild(new DOMElement('dEmailE', $this->dEmailE));
        if(isset($this->dDenSuc))
            $res->appendChild(new DOMElement('dDenSuc', $this->dDenSuc));
        if(isset($this->gActEco)) {
            foreach ($this->gActEco as $g)
                $res->appendChild($g->toDOMElement($doc));
        }
        if (isset($this->gRespDE))
            $res->appendChild($this->gRespDE->toDOMElement($doc));
        return $res;
    }

    ///////////////////////////////////////////////////////////////////////
    // Otros
    ///////////////////////////////////////////////////////////////////////

    /**
     * Agrega una actividad económica (objeto GActEco) a este emisor.
     * El código y la descripción deben corresponder a lo declarado en el RUC.
     * 
     * @param int $cod Código de la actividad económica.
     * @param String $desc Descripción de la actividad económica.
     * 
     * @return self
     */
    public function addActEco(int $cod, String $desc): self
    {
        $this->gActEco[] = new GActEco($cod, $desc);
        return $this;
    }
}
