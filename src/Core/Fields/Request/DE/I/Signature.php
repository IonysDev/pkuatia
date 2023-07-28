<?php

namespace Abiliomp\Pkuatia\Core\Fields\Request\DE\I;

use Abiliomp\Pkuatia\Helpers\SignHelper;

/**
 *  ID:I001  Firma Digital del DTE  PADRE:AA001
 */
class Signature
{
  public ?string $dSig = null; // I002 - Firma Digital del DTE

  
  /**
   * Get the value of dSig
   *
   * @return ?string
   */
  public function getDSig(): string | null
  {
    return $this->dSig;
  }

  /**
   * Set the value of dSig
   *
   * @param ?string $dSig
   *
   * @return self
   */
  public function setDSig(string $dSig): self
  {
    $this->dSig = $dSig;

    return $this;
  }
}
