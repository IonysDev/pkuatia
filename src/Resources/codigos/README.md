# Catálogos de códigos del SIFEN (generados desde ekuat-ia)

| Archivo | Contenido | Origen en ekuat-ia |
|---|---|---|
| `validaciones-de.php` | Validaciones del DE (MT §12.4): código, ID del MT, mensaje, estado (A/AO/R), grupo, observación (la regla), vigencia y línea de origen. Incluye las eliminadas en v150 con `vigente = false`. | `08-errores-y-respuestas/errores-validacion.md` |
| `validaciones-evento.php` | Validaciones de los eventos (MT §11.6). Los códigos repetidos del MT (4313-4323) se conservan todos. | `08-errores-y-respuestas/eventos-respuesta.md` |
| `respuestas-ws.php` | Códigos de resultado de los web services (MT §12.2 y §12.3), con la resolución 0420/0421/0422 del 03/10/2026. | `08-errores-y-respuestas/respuestas-ws.md` |
| `elementos-de.php` | Elementos y tipos complejos de `DE_v150.xsd` (copia fiel): ocurrencias, padre, línea citable e ID del MT. | `00-fuentes/xsd/DE_v150.xsd` + `03-estructura-xml/campos-obligatorios.md` |
| `campos-metodos.php` | **Mantenido a mano:** qué método de PKuatia informa cada campo del MT. | — |

Se consultan a través de `IonysDev\Pkuatia\Validacion\CatalogoValidaciones`. Los códigos que no están en las tablas
del MT pero el SIFEN responde (0100, 0143), los de la NT-011 (0520-0523) y el 0364 de la guía de la DNIT salen del
enum `CodigoResultadoWS`.

## Regenerar

Cuando cambie alguno de los archivos de origen en ekuat-ia:

```
php tools/generar-catalogos.php            # usa docs/sifen-ai; --docs=<ruta> para otro clon
vendor/bin/phpunit tests/Unit/Resources/CatalogosSincroniaTest.php
```

El test de sincronía regenera en memoria y compara con lo versionado (se omite sin `docs/sifen-ai`, p. ej. en CI).
No editar los archivos generados a mano.
