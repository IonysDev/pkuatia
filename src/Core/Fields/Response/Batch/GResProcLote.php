<?php

namespace IonysDev\Pkuatia\Core\Fields\Response\Batch;


use DOMElement;
use IonysDev\Pkuatia\Core\Fields\Response\GResProc;

/**
 * Nodo Id:     CRSch05        
 * Nombre:      gResProcLote       
 * Descripción: Grupo Resultado de Procesamiento del Lote   
 * Nodo Padre:  CRSch01 - rResEnviConsLoteDe - Respuesta del WS Consulta Resultado Lote
 */
class GResProcLote
{
                              // Id - Longirud - Ocurrencia - Descripción
  public String    $id;       // CRSch050 - 44   - 1-1   - CDC del DE
  public String    $dEstRes;  // CRSch051 - 8-30 - 1-1   - Estado del resultado (Aprobado, Aprobado con Obs. o Rechazado)
  public int       $dProtAut; // CRSch052 - 10   - 0-1   - Número de transacción (se genera solo si el estado es Aprobado)
  public GResProc  $gResProc; // CRSch053 - G    - 1-100 - Grupo Mensaje de Resultado

  ///////////////////////////////////////////////////////////////////////
  // Setters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Establece el valor de id
   *
   * @param String $id
   *
   * @return self
   */
  public function setId(String $id): self
  {
    $this->id = $id;

    return $this;
  }


  /**
   * Establece el valor de dEstRes
   *
   * @param String $dEstRes
   *
   * @return self
   */
  public function setDEstRes(String $dEstRes): self
  {
    $this->dEstRes = $dEstRes;

    return $this;
  }


  /**
   * Establece el valor de dProtAut
   *
   * @param String $dProtAut
   *
   * @return self
   */
  public function setDProtAut(String $dProtAut): self
  {
    $this->dProtAut = $dProtAut;

    return $this;
  }


  /**
   * Establece el valor de gResProc
   *
   * @param TgResProc $gResProc
   *
   * @return self
   */
  public function setGResProc(GResProc $gResProc): self
  {
    $this->gResProc = $gResProc;

    return $this;
  }

  ///////////////////////////////////////////////////////////////////////
  // Getters
  ///////////////////////////////////////////////////////////////////////

  /**
   * Obtiene el valor de id
   *
   * @return String
   */
  public function getId(): String
  {
    return $this->id;
  }

  /**
   * Obtiene el valor de dEstRes
   *
   * @return String
   */
  public function getDEstRes(): String
  {
    return $this->dEstRes;
  }

  /**
   * Obtiene el valor de dProtAut
   *
   * @return String
   */
  public function getDProtAut(): String
  {
    return $this->dProtAut;
  }

  /**
   * Obtiene el valor de gResProc
   *
   * @return GResProc
   */
  public function getGResProc(): GResProc
  {
    return $this->gResProc;
  }

  ///////////////////////////////////////////////////////////////////////
  // Instanciadores
  ///////////////////////////////////////////////////////////////////////  

  /**
   * Instancia un GResProcLote a partir de un objeto stdClass recibido como respuesta a una llamada SOAP al SIFEN.
   * 
   * @param stdClass $object
   * 
   * @return GResProcLote
   */
  public static function FromSifenResponseObject($object): GResProcLote
  {
    $res = new GResProcLote();
    
    if(isset($object->id)) $res->setId($object->id);
    else throw new \Exception("[GResProcLote] Error al instanciar respuesta, falta parametro: id", 1);

    if(isset($object->dEstRes)) $res->setDEstRes($object->dEstRes);
    else throw new \Exception("[GResProcLote] Error al instanciar respuesta, falta parametro: dEstRes", 1);

    if(isset($object->dProtAut)) $res->setDProtAut($object->dProtAut);
    
    if(isset($object->gResProc)) {
      if(is_array($object->gResProc)){
        foreach ($object->gResProc as $item) {
          $res->setGResProc(GResProc::FromSifenResponseObject($item));
        }
      }
      else $res->setGResProc(GResProc::FromSifenResponseObject($object->gResProc));
    }
    else throw new \Exception("[GResProcLote] Error al instanciar respuesta, falta parametro: gResProc", 1);

    return $res;
  }
}
