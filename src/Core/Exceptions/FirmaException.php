<?php

namespace IonysDev\Pkuatia\Core\Exceptions;

/**
 * Error al firmar un documento o un evento: firmador sin inicializar (falta Sifen::Init()) o falla de xmlseclibs.
 * La verificación de una firma recibida no lanza esta excepción: devuelve un ResultadoFirma (Sifen::VerificarFirma()).
 */
class FirmaException extends PkuatiaException
{
}
