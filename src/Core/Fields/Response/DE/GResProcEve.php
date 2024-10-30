<?php

namespace Abiliomp\Pkuatia\Core\Fields\Response\DE;

use Abiliomp\Pkuatia\Core\Fields\Response\GResProc;
use SimpleXMLElement;

//ID: CRSch05, Grupo resultado del procesamiento del lote

class GResProcEve
{
  ///ID - DESC - LONG - OCURRENCIA
  public string $dEstRes;   ///GRSch030 - Estado del resultado  - 8-30 - 1-1
  public string $dProtAut;  ///GRSch031 - Número de transacción - 10 - 0-1
  public string $id;        ///GRSch032 - Identificador del evento - 44 - 1-1
  public array $gResProc;   ///GRSch033 - Grupo Mensaje de resultado - no tiene - 0-100


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
}
