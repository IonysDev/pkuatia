<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

/**
 * Error de configuración o de entorno: Config incompleta o inválida, Init() sin los archivos esperados, factoría de
 * SoapClient incorrecta, archivos temporales o del dId que no se pueden crear. No depende del SIFEN ni del documento.
 */
class ConfiguracionException extends PkuatiaException
{
}
