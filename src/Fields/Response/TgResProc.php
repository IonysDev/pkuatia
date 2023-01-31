<?php

namespace Abiliomp\Pkuatia\Fields\Response;

use DOMElement;

/**
 * ID:PP05 Grupo Resultado de Procesamiento PADRE:PP01 
 */
class TgResProc
{
  public int $dCodRes;   // PP052 - Código del resultado de procesamiento 
  public string $dMsgRes; // PP053 - Mensaje del resultado de procesamiento

  //====================================================//
  ///SETTERS
  //====================================================//

  /**
   * Set the value of dCodRes
   *
   * @param int $dCodRes
   *
   * @return self
   */
  public function setDCodRes(int $dCodRes): self
  {
    $this->dCodRes = $dCodRes;

    return $this;
  }


  /**
   * Set the value of dMsgRes
   *
   * @param string $dMsgRes
   *
   * @return self
   */
  public function setDMsgRes(string $dMsgRes): self
  {
    $this->dMsgRes = $dMsgRes;

    return $this;
  }

  //====================================================//
  //GETTERS
  //====================================================//

  /**
   * Get the value of dCodRes
   *
   * @return int
   */
  public function getDCodRes(): int
  {
    return $this->dCodRes;
  }

  /**
   * Get the value of dMsgRes
   *
   * @return string
   */
  public function getDMsgRes(): string
  {
    return $this->dMsgRes;
  }

  //====================================================//
  ///XML ELEMENT
  //====================================================//  
  /**
   * toDOMElement
   *
   * @return DOMElement
   */
  public function toDOMElement(): DOMElement
  {
    $res = new DOMElement('tgResProc');
    if (isset($this->dCodRes)) {
      $res->appendChild(new DOMElement('dCodRes', $this->dCodRes));
    } else if (isset($this->dMsgRes)) {
      $res->appendChild(new DOMElement('dMsgRes', $this->dMsgRes));
    }

    return $res;
  }
}
