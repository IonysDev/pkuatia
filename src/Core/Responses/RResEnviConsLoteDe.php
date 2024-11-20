<?php

namespace IonysDev\Pkuatia\Core\Responses;

use IonysDev\Pkuatia\Core\Fields\Response\DE\GResProcLote;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;
use DateTime;

// Id: CRSch01, resultado del procesamiento de la consulta de un lote de DEs

class RResEnviConsLoteDe
{
                              ///ID - DESC - LONG - OCURRENCIA
  public DateTime $dFecProc;  ///CRSch02 - Fecha y hora del procesamiento del lote - 19 - 1-1
  public int $dCodResLot;     ///CRSch03 - Código de resultado del procesamiento del lote - 4 - 1-1
  public string $dMsgResLot;  ///CRSch04 - Comentario del resultado del procesamiento del lote - 1-255 - 1-1
  public array $gResProcLote; ///CRSch05 - Grupo Resultado del procesamiento del lote - Sin longitud - 0-50

  /**
   * Establece el valor de dFecProc
   *
   * @param DateTime $dFecProc
   *
   * @return self
   */
  public function setDFecProc(DateTime $dFecProc): self
  {
    $this->dFecProc = $dFecProc;

    return $this;
  }


  /**
   * Establece el valor de dCodResLot
   *
   * @param int $dCodResLot
   *
   * @return self
   */
  public function setDCodResLot(int $dCodResLot): self
  {
    $this->dCodResLot = $dCodResLot;

    return $this;
  }


  /**
   * Establece el valor de dMsgResLot
   *
   * @param string $dMsgResLot
   *
   * @return self
   */
  public function setDMsgResLot(string $dMsgResLot): self
  {
    $this->dMsgResLot = $dMsgResLot;

    return $this;
  }


  /**
   * Establece el valor de gResProcLote
   *
   * @param array $gResProcLote
   *
   * @return self
   */
  public function setGResProcLote(array $gResProcLote): self
  {
    $this->gResProcLote = $gResProcLote;

    return $this;
  }

  /**
   * Obtiene el valor de dFecProc
   *
   * @return DateTime
   */
  public function getDFecProc(): DateTime
  {
    return $this->dFecProc;
  }

  /**
   * Obtiene el valor de dCodResLot
   *
   * @return int
   */
  public function getDCodResLot(): int
  {
    return $this->dCodResLot;
  }

  /**
   * Obtiene el valor de dMsgResLot
   *
   * @return string
   */
  public function getDMsgResLot(): string
  {
    return $this->dMsgResLot;
  }

  /**
   * Obtiene el valor de gResProcLote
   *
   * @return array
   */
  public function getGResProcLote(): array
  {
    return $this->gResProcLote;
  }

  public static function FromSifenResponseObject($object)
  {

    if (is_null($object)) {
      throw new \Exception("Error Processing Request: null", 1);
      return null;
    }

    $res = new RResEnviConsLoteDe();
    $res->setDFecProc(DateTime::createFromFormat(DateTime::ATOM, $object->dFecProc));
    $res->setDCodResLot($object->dCodResLot);
    $res->setDMsgResLot($object->dMsgResLot);

    ///array for gResProcLote
    $gResProcLote = array();

    if(isset($object->gResProcLote)){
      if(is_array($object->gResProcLote)){
        foreach ($object->gResProcLote as $item) {
          $aux = new GResProcLote();
          //ID
          $aux->setId($item->id);
          //ESTADO
          $aux->setDEstRes($item->dEstRes);
          //OPCIONAL
          if (isset($item->dProtAut)) {
            $aux->setDProtAut($item->dProtAut);
          }
          ///array for gResProc
          $gResProc = array();
    
          ///check if is an array or an object
          if (is_array($item->gResProc)) {
            echo "TODO CUANTICO";
            echo "is array";
          } else {
            $aux2 = new GResProc();
            $aux2->setDCodRes($item->gResProc->dCodRes);
            $aux2->setDMsgRes($item->gResProc->dMsgRes);
          }
          ///push aux2 into gResProc array
          array_push($gResProc, $aux2);
          ///set gResProc to aux
          $aux->setGResProc($gResProc);
          //push aux into gResProcLote array
          array_push($gResProcLote, $aux);
        }
      }
      else {
        $item = $object->gResProcLote;
        $aux = new GResProcLote();
        //ID
        $aux->setId($item->id);
        //ESTADO
        $aux->setDEstRes($item->dEstRes);
        //OPCIONAL
        if (isset($item->dProtAut)) {
          $aux->setDProtAut($item->dProtAut);
        }
        ///array for gResProc
        $gResProc = array();
  
        ///check if is an array or an object
        if (is_array($item->gResProc)) {
          echo "TODO CUANTICO";
          echo "is array";
        } else {
          $aux2 = new GResProc();
          $aux2->setDCodRes($item->gResProc->dCodRes);
          $aux2->setDMsgRes($item->gResProc->dMsgRes);
        }
        ///push aux2 into gResProc array
        array_push($gResProc, $aux2);
        ///set gResProc to aux
        $aux->setGResProc($gResProc);
        //push aux into gResProcLote array
        array_push($gResProcLote, $aux);
      }
  
      ///set gResProcLote to res
      $res->setGResProcLote($gResProcLote);
    }
    return $res;
  }
}
