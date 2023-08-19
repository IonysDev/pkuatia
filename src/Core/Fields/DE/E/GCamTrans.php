<?php

namespace Abiliomp\Pkuatia\Core\Fields\DE\E;

use Abiliomp\Pkuatia\Helpers\CountryHelper;
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
    * Set the value of iNatTrans
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
    * Set the value of dNomTrans
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
    * Set the value of dRucTrans
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
    * Set the value of dDVTrans
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
    * Set the value of iTipIDTrans
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
    * Set the value of dNumIDTrans
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
    * Set the value of cNacTrans
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
    * Set the value of dNumIDChof
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
    * Set the value of dNomChof
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
    * Set the value of dDomFisc
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
    * Set the value of dDirChof
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
    * Set the value of dNombAg
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
    * Set the value of dRucAg
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
    * Set the value of dDVAg
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
    * Set the value of dDirAge
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
    * Get the value of iNatTrans
    *
    * @return int
    */
   public function getINatTrans(): int
   {
      return $this->iNatTrans;
   }

   /**
    * Get the value of dNomTrans
    *
    * @return String
    */
   public function getDNomTrans(): String
   {
      return $this->dNomTrans;
   }

   /**
    * Get the value of dRucTrans
    *
    * @return String
    */
   public function getDRucTrans(): String
   {
      return $this->dRucTrans;
   }

   /**
    * Get the value of dDVTrans
    *
    * @return int
    */
   public function getDDVTrans(): int
   {
      return $this->dDVTrans;
   }

   /**
    * Get the value of iTipIDTrans
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
    * Get the value of dNumIDTrans
    *
    * @return String
    */
   public function getDNumIDTrans(): String
   {
      return $this->dNumIDTrans;
   }

   /**
    * Get the value of cNacTrans
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
      return CountryHelper::getCountryDesc($this->cNacTrans);
   }

   /**
    * Get the value of dNumIDChof
    *
    * @return String
    */
   public function getDNumIDChof(): String
   {
      return $this->dNumIDChof;
   }

   /**
    * Get the value of dNomChof
    *
    * @return String
    */
   public function getDNomChof(): String
   {
      return $this->dNomChof;
   }

   /**
    * Get the value of dDomFisc
    *
    * @return String
    */
   public function getDDomFisc(): String
   {
      return $this->dDomFisc;
   }

   /**
    * Get the value of dDirChof
    *
    * @return String
    */
   public function getDDirChof(): String
   {
      return $this->dDirChof;
   }

   /**
    * Get the value of dNombAg
    *
    * @return String
    */
   public function getDNombAg(): String
   {
      return $this->dNombAg;
   }

   /**
    * Get the value of dRucAg
    *
    * @return String
    */
   public function getDRucAg(): String
   {
      return $this->dRucAg;
   }

   /**
    * Get the value of dDVAg
    *
    * @return String
    */
   public function getDDVAg(): String
   {
      return $this->dDVAg;
   }

   /**
    * Get the value of dDirAge
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
