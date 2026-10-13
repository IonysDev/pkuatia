<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\DE;

use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use SimpleXMLElement;
use IonysDev\Pkuatia\Core\Exceptions\RespuestaException;

//ID: CRSch05, Grupo resultado del procesamiento del lote

/**
 * @deprecated 0.2.1 Duplicado de IonysDev\Pkuatia\Core\Fields\Response\Event\GResProcEVe, que es el que usan las
 *             respuestas de eventos (RRetEnviEventoDe). Ninguna clase de la librería usa esta copia (PK-43).
 */
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
        throw new RespuestaException("Invalid XML Element: $node->getName()");
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
      // Un gResProc por mensaje (0-100). Hasta 0.2.0 había una rama con "echo" de depuración (inalcanzable: un
      // SimpleXMLElement nunca es un array) y se leía solo el primer mensaje (PK-43).
      foreach ($node->gResProc as $g) {
        $aux = new GResProc();
        $aux->setDCodRes((string) $g->dCodRes);
        $aux->setDMsgRes((string) $g->dMsgRes);
        $gResProc[] = $aux;
      }
      ///set gResProc to res
      $res->setGResProc($gResProc);

      return $res;
  }
}
