# Política de seguridad

## Versiones con soporte

PKuatia está en la serie 0.x. Recibe correcciones de seguridad la última versión publicada en
[Packagist](https://packagist.org/packages/ionysdev/pkuatia) (hoy la rama 0.3.x). Las versiones anteriores no se
corrigen: actualizar a la última es la vía de solución.

## Cómo reportar una vulnerabilidad

**No abras un issue público** para una vulnerabilidad. Usá una de estas dos vías privadas:

1. **GitHub Security Advisories:** pestaña *Security* del repositorio → *Report a vulnerability*
   (https://github.com/IonysDev/pkuatia/security/advisories/new).
2. **Correo** al mantenedor que figura en `composer.json` (`authors`), con el asunto "PKuatia seguridad".

Incluí la versión afectada, los pasos para reproducir y el impacto que ves. Respondemos en un plazo razonable
(objetivo: 7 días) y coordinamos la publicación de la corrección y el aviso.

## Qué nunca va en un reporte ni en un issue

- Certificados (`.p12`, `.pfx`, `.pem`), claves privadas o sus contraseñas.
- El CSC (código secreto del contribuyente) o el `idCsc` de producción.
- Documentos electrónicos reales con datos de personas (RUC, cédulas, nombres): anonimizalos antes de adjuntarlos.

## Alcance

La librería firma documentos con el certificado del contribuyente y habla con los servicios web del SIFEN. Son de
interés especial: manejo de la clave privada y de los archivos temporales del PKCS#12, verificación TLS, parseo de XML
recibido del SIFEN (entidades externas, esquemas) y cualquier forma de que un dato del documento altere la firma o el
XML emitido.
