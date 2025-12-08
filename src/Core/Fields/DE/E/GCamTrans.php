<?php

namespace IonysDev\Pkuatia\Core\Fields\DE\E;

use IonysDev\Pkuatia\DataMappings\CountryMapping;
use DOMElement;

/**
 * ID:E980 gCamTrans Campos que identifican al transportista PADRE:E900
 * 
 */
class GCamTrans
{
   public int $iNatTrans; // E981 - Naturaleza del transportista
   public String $dNomTrans; // E982 - Nombre o razón social del transportista 
   public String $dRucTrans; // E983 - RUC del transportista 
   public int $dDVTrans; //E984 - Dígito verificador del RUC del transportista 
   public int $iTipIDTrans; // E985 - Tipo de documento de identidad del transportista
   public String $dNumIDTrans; // E987 - Número de documento de identidad del transportista
   public String $cNacTrans; // E988 - Nacionalidad del transportista 
   public String $dNumIDChof; // E990 - Número de documento de identidad del chofer
   public String $dNomChof; // E991 - Nombre y apellido del chofer
   public String $dDomFisc; // E992 - Domicilio fiscal del transportista
   public String $dDirChof; // E993 - Dirección del chofer
   public String $dNombAg; // E994 - Nombre o razón social del agente 
   public String $dRucAg; // E995 - RUC del agente
   public String $dDVAg; // E996 - Dígito verificador del  RUC del agente
   public String $dDirAge; // E997 - Dirección del agente

   ///////////////////////////////////////////////////////////////////////
   ////SETTERS
   ///////////////////////////////////////////////////////////////////////

   /**
    * Establece el valor de iNatTrans
    *
    * @param int $iNatTrans
    *
    * @return self
    */
   public function setINatTrans(int $iNatTrans): self
   {
      $this->iNatTrans = $iNatTrans;

      return $this;
   }


   /**
    * Establece el valor de dNomTrans
    *
    * @param String $dNomTrans
    *
    * @return self
    */
   public function setDNomTrans(String $dNomTrans): self
   {
      $this->dNomTrans = $dNomTrans;

      return $this;
   }


   /**
    * Establece el valor de dRucTrans
    *
    * @param String $dRucTrans
    *
    * @return self
    */
   public function setDRucTrans(String $dRucTrans): self
   {
      $this->dRucTrans = $dRucTrans;

      return $this;
   }


   /**
    * Establece el valor de dDVTrans
    *
    * @param int $dDVTrans
    *
    * @return self
    */
   public function setDDVTrans(int $dDVTrans): self
   {
      $this->dDVTrans = $dDVTrans;

      return $this;
   }


   /**
    * Establece el valor de iTipIDTrans
    *
    * @param int $iTipIDTrans
    *
    * @return self
    */
   public function setITipIDTrans(int $iTipIDTrans): self
   {
      $this->iTipIDTrans = $iTipIDTrans;

      return $this;
   }


   /**
    * Establece el valor de dNumIDTrans
    *
    * @param String $dNumIDTrans
    *
    * @return self
    */
   public function setDNumIDTrans(String $dNumIDTrans): self
   {
      $this->dNumIDTrans = $dNumIDTrans;

      return $this;
   }


   /**
    * Establece el valor de cNacTrans
    *
    * @param String $cNacTrans
    *
    * @return self
    */
   public function setCNacTrans(String $cNacTrans): self
   {
      $this->cNacTrans = $cNacTrans;

      return $this;
   }


   /**
    * Establece el valor de dNumIDChof
    *
    * @param String $dNumIDChof
    *
    * @return self
    */
   public function setDNumIDChof(String $dNumIDChof): self
   {
      $this->dNumIDChof = $dNumIDChof;

      return $this;
   }


   /**
    * Establece el valor de dNomChof
    *
    * @param String $dNomChof
    *
    * @return self
    */
   public function setDNomChof(String $dNomChof): self
   {
      $this->dNomChof = $dNomChof;

      return $this;
   }


   /**
    * Establece el valor de dDomFisc
    *
    * @param String $dDomFisc
    *
    * @return self
    */
   public function setDDomFisc(String $dDomFisc): self
   {
      $this->dDomFisc = $dDomFisc;

      return $this;
   }


   /**
    * Establece el valor de dDirChof
    *
    * @param String $dDirChof
    *
    * @return self
    */
   public function setDDirChof(String $dDirChof): self
   {
      $this->dDirChof = $dDirChof;

      return $this;
   }


   /**
    * Establece el valor de dNombAg
    *
    * @param String $dNombAg
    *
    * @return self
    */
   public function setDNombAg(String $dNombAg): self
   {
      $this->dNombAg = $dNombAg;

      return $this;
   }


   /**
    * Establece el valor de dRucAg
    *
    * @param String $dRucAg
    *
    * @return self
    */
   public function setDRucAg(String $dRucAg): self
   {
      $this->dRucAg = $dRucAg;

      return $this;
   }


   /**
    * Establece el valor de dDVAg
    *
    * @param String $dDVAg
    *
    * @return self
    */
   public function setDDVAg(String $dDVAg): self
   {
      $this->dDVAg = $dDVAg;

      return $this;
   }

   /**
    * Establece el valor de dDirAge
    *
    * @param String $dDirAge
    *
    * @return self
    */
   public function setDDirAge(String $dDirAge): self
   {
      $this->dDirAge = $dDirAge;

      return $this;
   }

   ///////////////////////////////////////////////////////////////////////
   ///GETTERS
   ///////////////////////////////////////////////////////////////////////

   /**
    * Obtiene el valor de iNatTrans
    *
    * @return int
    */
   public function getINatTrans(): int
   {
      return $this->iNatTrans;
   }

   /**
    * Obtiene el valor de dNomTrans
    *
    * @return String
    */
   public function getDNomTrans(): String
   {
      return $this->dNomTrans;
   }

   /**
    * Obtiene el valor de dRucTrans
    *
    * @return String
    */
   public function getDRucTrans(): String
   {
      return $this->dRucTrans;
   }

   /**
    * Obtiene el valor de dDVTrans
    *
    * @return int
    */
   public function getDDVTrans(): int
   {
      return $this->dDVTrans;
   }

   /**
    * Obtiene el valor de iTipIDTrans
    *
    * @return int
    */
   public function getITipIDTrans(): int
   {
      return $this->iTipIDTrans;
   }

   /**
    * E986 Descripción del tipo de documento de identidad del transportista
    *
    * @return String
    */
   public function getDDTipIDTrans(): String
   {
      switch ($this->iTipIDTrans) {
         case 1:
            return "Cédula paraguaya";
            break;
         case 2:
            return "Pasaporte";
            break;
         case 3:
            return "Cédula extranjera";
            break;
         case 4:
            return "Carnet de residencia";
            break;

         default:
            return null;
            break;
      }
   }



   /**
    * Obtiene el valor de dNumIDTrans
    *
    * @return String
    */
   public function getDNumIDTrans(): String
   {
      return $this->dNumIDTrans;
   }

   /**
    * Obtiene el valor de cNacTrans
    *
    * @return String
    */
   public function getCNacTrans(): String
   {
      return $this->cNacTrans;
   }

   /**
    * E989 Descripción de la nacionalidad del transportista
    *
    * @return String
    */
   public function getDDesNacTrans(): String
   {
      return CountryMapping::getCountryDesc($this->cNacTrans);
   }

   /**
    * Obtiene el valor de dNumIDChof
    *
    * @return String
    */
   public function getDNumIDChof(): String
   {
      return $this->dNumIDChof;
   }

   /**
    * Obtiene el valor de dNomChof
    *
    * @return String
    */
   public function getDNomChof(): String
   {
      return $this->dNomChof;
   }

   /**
    * Obtiene el valor de dDomFisc
    *
    * @return String
    */
   public function getDDomFisc(): String
   {
      return $this->dDomFisc;
   }

   /**
    * Obtiene el valor de dDirChof
    *
    * @return String
    */
   public function getDDirChof(): String
   {
      return $this->dDirChof;
   }

   /**
    * Obtiene el valor de dNombAg
    *
    * @return String
    */
   public function getDNombAg(): String
   {
      return $this->dNombAg;
   }

   /**
    * Obtiene el valor de dRucAg
    *
    * @return String
    */
   public function getDRucAg(): String
   {
      return $this->dRucAg;
   }

   /**
    * Obtiene el valor de dDVAg
    *
    * @return String
    */
   public function getDDVAg(): String
   {
      return $this->dDVAg;
   }

   /**
    * Obtiene el valor de dDirAge
    *
    * @return String
    */
   public function getDDirAge(): String
   {
      return $this->dDirAge;
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
      $res = new DOMElement('gCamTrans');

      $res->appendChild(new DOMElement('iNatTrans', $this->getINatTrans()));
      $res->appendChild(new DOMElement('dNomTrans', $this->getDNomTrans()));

      if ($this->iNatTrans == 1) {
         $res->appendChild(new DOMElement('dRucTrans', $this->getDRucTrans()));
      }

      if (isset($this->dRucTrans)) {
         $res->appendChild(new DOMElement('dDVTrans', $this->getDDVTrans()));
      }

      if ($this->iNatTrans == 2) {
         $res->appendChild(new DOMElement('iTipIDTrans', $this->getITipIDTrans()));
      }

      if (isset($this->iTipIDTrans)) {
         $res->appendChild(new DOMElement('dDTipIDTrans', $this->getDDTipIDTrans()));
         $res->appendChild(new DOMElement('dNumIDTrans', $this->getDNumIDTrans()));
      }

      $res->appendChild(new DOMElement('cNacTrans', $this->getCNacTrans()));

      if (isset($this->cNacTrans)) {
         $res->appendChild(new DOMElement('dDesNacTrans', $this->getDDesNacTrans()));
      }

      $res->appendChild(new DOMElement('dNumIDChof', $this->getDNumIDChof()));
      $res->appendChild(new DOMElement('dNomChof', $this->getDNomChof()));
      $res->appendChild(new DOMElement('dDomFisc', $this->getDDomFisc()));
      $res->appendChild(new DOMElement('dDirChof', $this->getDDirChof()));
      $res->appendChild(new DOMElement('dNombAg', $this->getDNombAg()));
      $res->appendChild(new DOMElement('dRucAg', $this->getDRucAg()));
      $res->appendChild(new DOMElement('dDVAg', $this->getDDVAg()));
      $res->appendChild(new DOMElement('dDirAge', $this->getDDirAge()));
      return $res;
   }

   // /**
   //  * fromDOMElement
   //  *
   //  * @param  mixed $xml
   //  * @return GCamTrans
   //  */
   // public static function fromDOMElement(DOMElement $xml): GCamTrans
   // {
   //    if (strcmp($xml->tagName, 'gCamTrans') === 0 && $xml->childElementCount >= 11) {
   //       $res = new GCamTrans();
   //       $res->setINatTrans(intval($xml->getElementsByTagName('iNatTrans')->item(0)->nodeValue));
   //       $res->setDNomTrans($xml->getElementsByTagName('dNomTrans')->item(0)->nodeValue);
   //       $res->setDRucTrans($xml->getElementsByTagName('dRucTrans')->item(0)->nodeValue);
   //       $res->setDDVTrans(intval($xml->getElementsByTagName('dDVTrans')->item(0)->nodeValue));
   //       $res->setITipIDTrans(intval($xml->getElementsByTagName('iTipIDTrans')->item(0)->nodeValue));
   //       $res->setDNumIDTrans($xml->getElementsByTagName('dDNumIDTrans')->item(0)->nodeValue);
   //       $res->setCNacTrans($xml->getElementsByTagName('cNacTrans')->item(0)->nodeValue);
   //       $res->setDNumIDChof($xml->getElementsByTagName('dNumIDChof')->item(0)->nodeValue);
   //       $res->setDNomChof($xml->getElementsByTagName('dNomChof')->item(0)->nodeValue);
   //       $res->setDDomFisc($xml->getElementsByTagName('dDomFisc')->item(0)->nodeValue);
   //       $res->setDDirChof($xml->getElementsByTagName('dDirChof')->item(0)->nodeValue);
   //       $res->setDNombAg($xml->getElementsByTagName('dNombAg')->item(0)->nodeValue);
   //       $res->setDRucAg($xml->getElementsByTagName('dRucAg')->item(0)->nodeValue);
   //       $res->setDDVAg(intval($xml->getElementsByTagName('dDVAg')->item(0)->nodeValue));
   //       $res->setDDirAge($xml->getElementsByTagName('dDirAge')->item(0)->nodeValue);

   //       return $res;

   //    } else {
   //       throw new \Exception("Invalid XML Element: $xml->tagName");
   //       return null;

   //    }
  // }

  /**
   * Instancia un objeto GCamTrans a partir de un DOMElement que representa el nodo XML del objeto.
   * 
   * @param DOMElement $node Nodo XML que representa el objeto.
   * 
   * @return self Objeto instanciado.
   */
  public static function FromDOMElement(DOMElement $node): self
  {
    if(strcmp($node->nodeName, 'gCamTrans') != 0)
      throw new \Exception('[GCamTrans] El nombre del nodo no corresponde a gCamTrans: ' . $node->nodeName);
    $res = new GCamTrans();
    
    if($node->getElementsByTagName('iNatTrans')->length > 0)
      $res->setINatTrans(intval($node->getElementsByTagName('iNatTrans')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('dNomTrans')->length > 0)
      $res->setDNomTrans($node->getElementsByTagName('dNomTrans')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dRucTrans')->length > 0)
      $res->setDRucTrans($node->getElementsByTagName('dRucTrans')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dDVTrans')->length > 0)
      $res->setDDVTrans(intval($node->getElementsByTagName('dDVTrans')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('iTipIDTrans')->length > 0)
      $res->setITipIDTrans(intval($node->getElementsByTagName('iTipIDTrans')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('dNumIDTrans')->length > 0)
      $res->setDNumIDTrans($node->getElementsByTagName('dNumIDTrans')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('cNacTrans')->length > 0)
      $res->setCNacTrans($node->getElementsByTagName('cNacTrans')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dNumIDChof')->length > 0)
      $res->setDNumIDChof($node->getElementsByTagName('dNumIDChof')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dNomChof')->length > 0)
      $res->setDNomChof($node->getElementsByTagName('dNomChof')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dDomFisc')->length > 0)
      $res->setDDomFisc($node->getElementsByTagName('dDomFisc')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dDirChof')->length > 0)
      $res->setDDirChof($node->getElementsByTagName('dDirChof')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dNombAg')->length > 0)
      $res->setDNombAg($node->getElementsByTagName('dNombAg')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dRucAg')->length > 0)
      $res->setDRucAg($node->getElementsByTagName('dRucAg')->item(0)->nodeValue);
    
    if($node->getElementsByTagName('dDVAg')->length > 0)
      $res->setDDVAg(intval($node->getElementsByTagName('dDVAg')->item(0)->nodeValue));
    
    if($node->getElementsByTagName('dDirAge')->length > 0)
      $res->setDDirAge($node->getElementsByTagName('dDirAge')->item(0)->nodeValue);
    
    return $res;
  }
    
  /**
   * FromSifenResponseObject
   *
   * @param  mixed $object
   * @return self
   */
  public static function FromSifenResponseObject($object):self
   {
      $res = new GCamTrans();
      if(isset($object->iNatTrans)){
         $res->setINatTrans(intval($object->iNatTrans));
      }
      if(isset($object->dNomTrans)){
         $res->setDNomTrans($object->dNomTrans);
      }
      if(isset($object->dRucTrans)){
         $res->setDRucTrans($object->dRucTrans);
      }
      if(isset($object->dDVTrans)){
         $res->setDDVTrans(intval($object->dDVTrans));
      }
      if(isset($object->iTipIDTrans)){
         $res->setITipIDTrans(intval($object->iTipIDTrans));
      }
      if(isset($object->dNumIDTrans)){
         $res->setDNumIDTrans($object->dNumIDTrans);
      }
      if(isset($object->cNacTrans)){
         $res->setCNacTrans($object->cNacTrans);
      }
      if(isset($object->dNumIDChof)){
         $res->setDNumIDChof($object->dNumIDChof);
      }
      if(isset($object->dNomChof)){
         $res->setDNomChof($object->dNomChof);
      }
      if(isset($object->dDomFisc)){
         $res->setDDomFisc($object->dDomFisc);
      }
      if(isset($object->dDirChof)){
         $res->setDDirChof($object->dDirChof);
      }
      if(isset($object->dNombAg)){
         $res->setDNombAg($object->dNombAg);
      }
      if(isset($object->dRucAg)){
         $res->setDRucAg($object->dRucAg);
      }
      if(isset($object->dDVAg)){
         $res->setDDVAg(intval($object->dDVAg));
      }
      if(isset($object->dDirAge)){
         $res->setDDirAge($object->dDirAge);
      }
      

      return $res;
   }
}
