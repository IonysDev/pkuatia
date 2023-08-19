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
   public ?int $iNatTrans  = null; // E981 - Naturaleza del transportista
   public ?string $dNomTrans  = null; // E982 - Nombre o razón social del transportista 
   public ?string $dRucTrans  = null; // E983 - RUC del transportista 
   public ?int $dDVTrans  = null; //E984 - Dígito verificador del RUC del transportista 
   public ?int $iTipIDTrans  = null; // E985 - Tipo de documento de identidad del transportista
   public ?string $dNumIDTrans  = null; // E987 - Número de documento de identidad del transportista
   public ?string $cNacTrans  = null; // E988 - Nacionalidad del transportista 
   public ?string $dNumIDChof  = null; // E990 - Número de documento de identidad del chofer
   public ?string $dNomChof  = null; // E991 - Nombre y apellido del chofer
   public ?string $dDomFisc  = null; // E992 - Domicilio fiscal del transportista
   public ?string $dDirChof  = null; // E993 - Dirección del chofer
   public ?string $dNombAg  = null; // E994 - Nombre o razón social del agente 
   public ?string $dRucAg  = null; // E995 - RUC del agente
   public ?string $dDVAg  = null; // E996 - Dígito verificador del  RUC del agente
   public ?string $dDirAge  = null; // E997 - Dirección del agente

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
    * @param string $dNomTrans
    *
    * @return self
    */
   public function setDNomTrans(string $dNomTrans): self
   {
      $this->dNomTrans = $dNomTrans;

      return $this;
   }


   /**
    * Set the value of dRucTrans
    *
    * @param string $dRucTrans
    *
    * @return self
    */
   public function setDRucTrans(string $dRucTrans): self
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
    * @param string $dNumIDTrans
    *
    * @return self
    */
   public function setDNumIDTrans(string $dNumIDTrans): self
   {
      $this->dNumIDTrans = $dNumIDTrans;

      return $this;
   }


   /**
    * Set the value of cNacTrans
    *
    * @param string $cNacTrans
    *
    * @return self
    */
   public function setCNacTrans(string $cNacTrans): self
   {
      $this->cNacTrans = $cNacTrans;

      return $this;
   }


   /**
    * Set the value of dNumIDChof
    *
    * @param string $dNumIDChof
    *
    * @return self
    */
   public function setDNumIDChof(string $dNumIDChof): self
   {
      $this->dNumIDChof = $dNumIDChof;

      return $this;
   }


   /**
    * Set the value of dNomChof
    *
    * @param string $dNomChof
    *
    * @return self
    */
   public function setDNomChof(string $dNomChof): self
   {
      $this->dNomChof = $dNomChof;

      return $this;
   }


   /**
    * Set the value of dDomFisc
    *
    * @param string $dDomFisc
    *
    * @return self
    */
   public function setDDomFisc(string $dDomFisc): self
   {
      $this->dDomFisc = $dDomFisc;

      return $this;
   }


   /**
    * Set the value of dDirChof
    *
    * @param string $dDirChof
    *
    * @return self
    */
   public function setDDirChof(string $dDirChof): self
   {
      $this->dDirChof = $dDirChof;

      return $this;
   }


   /**
    * Set the value of dNombAg
    *
    * @param string $dNombAg
    *
    * @return self
    */
   public function setDNombAg(string $dNombAg): self
   {
      $this->dNombAg = $dNombAg;

      return $this;
   }


   /**
    * Set the value of dRucAg
    *
    * @param string $dRucAg
    *
    * @return self
    */
   public function setDRucAg(string $dRucAg): self
   {
      $this->dRucAg = $dRucAg;

      return $this;
   }


   /**
    * Set the value of dDVAg
    *
    * @param string $dDVAg
    *
    * @return self
    */
   public function setDDVAg(string $dDVAg): self
   {
      $this->dDVAg = $dDVAg;

      return $this;
   }

   /**
    * Set the value of dDirAge
    *
    * @param string $dDirAge
    *
    * @return self
    */
   public function setDDirAge(string $dDirAge): self
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
   public function getINatTrans(): int | null
   {
      return $this->iNatTrans;
   }

   /**
    * Get the value of dNomTrans
    *
    * @return string
    */
   public function getDNomTrans(): string | null
   {
      return $this->dNomTrans;
   }

   /**
    * Get the value of dRucTrans
    *
    * @return string
    */
   public function getDRucTrans(): string | null
   {
      return $this->dRucTrans;
   }

   /**
    * Get the value of dDVTrans
    *
    * @return int
    */
   public function getDDVTrans(): int | null
   {
      return $this->dDVTrans;
   }

   /**
    * Get the value of iTipIDTrans
    *
    * @return int
    */
   public function getITipIDTrans(): int | null
   {
      return $this->iTipIDTrans;
   }

   /**
    * E986 Descripción del tipo de documento de identidad del transportista
    *
    * @return string
    */
   public function getDDTipIDTrans(): string | null
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
    * @return string
    */
   public function getDNumIDTrans(): string | null
   {
      return $this->dNumIDTrans;
   }

   /**
    * Get the value of cNacTrans
    *
    * @return string
    */
   public function getCNacTrans(): string | null
   {
      return $this->cNacTrans;
   }

   /**
    * E989 Descripción de la nacionalidad del transportista
    *
    * @return string
    */
   public function getDDesNacTrans(): string | null
   {
      return CountryHelper::getCountryDesc($this->cNacTrans);
   }

   /**
    * Get the value of dNumIDChof
    *
    * @return string
    */
   public function getDNumIDChof(): string | null
   {
      return $this->dNumIDChof;
   }

   /**
    * Get the value of dNomChof
    *
    * @return string
    */
   public function getDNomChof(): string | null
   {
      return $this->dNomChof;
   }

   /**
    * Get the value of dDomFisc
    *
    * @return string
    */
   public function getDDomFisc(): string | null
   {
      return $this->dDomFisc;
   }

   /**
    * Get the value of dDirChof
    *
    * @return string
    */
   public function getDDirChof(): string | null
   {
      return $this->dDirChof;
   }

   /**
    * Get the value of dNombAg
    *
    * @return string
    */
   public function getDNombAg(): string | null
   {
      return $this->dNombAg;
   }

   /**
    * Get the value of dRucAg
    *
    * @return string
    */
   public function getDRucAg(): string | null
   {
      return $this->dRucAg;
   }

   /**
    * Get the value of dDVAg
    *
    * @return string
    */
   public function getDDVAg(): string | null
   {
      return $this->dDVAg;
   }

   /**
    * Get the value of dDirAge
    *
    * @return string
    */
   public function getDDirAge(): string | null
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
    * fromResponse
    *
    * @param  mixed $response
    * @return self
    */
   public static function fromResponse($response):self
   {
      $res = new GCamTrans();
      if(isset($response->iNatTrans)){
         $res->setINatTrans(intval($response->iNatTrans));
      }
      if(isset($response->dNomTrans)){
         $res->setDNomTrans($response->dNomTrans);
      }
      if(isset($response->dRucTrans)){
         $res->setDRucTrans($response->dRucTrans);
      }
      if(isset($response->dDVTrans)){
         $res->setDDVTrans(intval($response->dDVTrans));
      }
      if(isset($response->iTipIDTrans)){
         $res->setITipIDTrans(intval($response->iTipIDTrans));
      }
      if(isset($response->dNumIDTrans)){
         $res->setDNumIDTrans($response->dNumIDTrans);
      }
      if(isset($response->cNacTrans)){
         $res->setCNacTrans($response->cNacTrans);
      }
      if(isset($response->dNumIDChof)){
         $res->setDNumIDChof($response->dNumIDChof);
      }
      if(isset($response->dNomChof)){
         $res->setDNomChof($response->dNomChof);
      }
      if(isset($response->dDomFisc)){
         $res->setDDomFisc($response->dDomFisc);
      }
      if(isset($response->dDirChof)){
         $res->setDDirChof($response->dDirChof);
      }
      if(isset($response->dNombAg)){
         $res->setDNombAg($response->dNombAg);
      }
      if(isset($response->dRucAg)){
         $res->setDRucAg($response->dRucAg);
      }
      if(isset($response->dDVAg)){
         $res->setDDVAg(intval($response->dDVAg));
      }
      if(isset($response->dDirAge)){
         $res->setDDirAge($response->dDirAge);
      }
      

      return $res;
   }
}
