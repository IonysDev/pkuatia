<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\DE;

use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use SimpleXMLElement;

//ID: CRSch05, Grupo resultado del procesamiento del lote

class GResProcEVe
{
                          // Id - Longitud - Ocurrencia - Descripción
  public String $dEstRes; // GRSch030 - 8-30 - 1-1   - Estado del resultado
  public int $dProtAut;   // GRSch031 - 10   - 0-1   - Número de transacción
  public int $id;         // GRSch032 - 10   - 1-1   - Identificador del evento
  public array $gResProc; // GRSch033 - G    - 1-100 - Grupo Resultado de Procesamiento 
                        

  /**
   * Establece el valor de id
   *
   * @param string $id
   *
   * @return self
   */
  public function setId(string $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Establece el valor de dEstRes
   *
   * @param string $dEstRes
   *
   * @return self
   */
  public function setDEstRes(string $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Establece el valor de dProtAut
   *
   * @param string $dProtAut
   *
   * @return self
   */
  public function setDProtAut(string $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }




  /**
   * Obtiene el valor de id
   *
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * Obtiene el valor de dEstRes
   *
   * @return string
   */
  public function getDEstRes(): string
  {
    return $this->dEstRes;
  }

  /**
   * Obtiene el valor de dProtAut
   *
   * @return string
   */
  public function getDProtAut(): string
  {
    return $this->dProtAut;
  }

  /**
   * Obtiene el valor de gResProc
   *
   * @return array
   */
  public function getGResProc(): array
  {
    return $this->gResProc;
  }


  /**
   * Establece el valor de gResProc
   *
   * @param array $gResProc
   *
   * @return self
   */
  public function setGResProc(array $gResProc): self
  {
    $this->gResProc = $gResProc;

    return $this;
  }

  public static function FromSimpleXMLElement(SimpleXMLElement $node):self
  {
      if(strcmp($node->getName(),'gResProcEVe') != 0) {
        throw new \Exception("Invalid XML Element: $node->getName()");
        return null;
      }

      $res = new GResProcEVe();
      $res->setDEstRes($node->dEstRes);
      if(isset($node->dProtAut)) {
        $res->setDProtAut($node->dProtAut);
      }
      if(isset($node->id)) {
        $res->setId($node->id);
      }
      ///array for gResProc
      $gResProc = array();
      ///check if is an array or an object
      if(is_array($node->gResProc)) {
        echo "TODO CUANTICO";
        echo "is array";
      } else {
        $aux = new GResProc();
        $aux->setDCodRes($node->gResProc->dCodRes);
        $aux->setDMsgRes($node->gResProc->dMsgRes);
        $gResProc[] = $aux;
      }
      ///set gResProc to res
      $res->setGResProc($gResProc);

      return $res;
  }

  /**
   * Creates a GResProcEVe instance from a Sifen Response Object
   * 
   * @param mixed $object The response object from Sifen
   * @return self
   * @throws \Exception If object is null or invalid
   */
  public static function FromSifenResponseObject($object): self
  {
    if (is_null($object)) {
      throw new \Exception("[GResProcEVe] Error Processing Request: null");
    }

    $res = new GResProcEVe();
    $res->setDEstRes($object->dEstRes);
    if (isset($object->dProtAut)) {
      $res->setDProtAut($object->dProtAut);
    }
    $res->setId($object->id);
    
    $gResProc = array();
    if (isset($object->gResProc)) {
      if (is_array($object->gResProc)) {
        foreach ($object->gResProc as $proc) {
          $aux = GResProc::FromSifenResponseObject($proc);
          $gResProc[] = $aux;
        }

      } else {
        $aux = GResProc::FromSifenResponseObject($object->gResProc);
        $gResProc[] = $aux;
      }
    }
    $res->setGResProc($gResProc);
    return $res;
  }
}
