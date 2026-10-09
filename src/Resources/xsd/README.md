# XSD del SIFEN para validación local (copias de trabajo, no fieles)

Origen: `ekuat-ia/04-schemas-xsd/validacion-local/` (generadas por `generar.py` a partir de las
copias fieles de producción `ekuat-ia/00-fuentes/xsd/`, re-verificadas contra
`https://ekuatia.set.gov.py/sifen/xsd/` el 03/10/2026, md5 en `00-fuentes/xsd/CHECKSUMS.md5`).
Incorporadas a la librería el 04/10/2026 (Fase A, decisión Q-A1).

## Qué cambia respecto de las copias fieles

| Cambio | Archivos | Motivo |
|---|---|---|
| `schemaLocation` absolutos (`https://ekuatia.set.gov.py/sifen/xsd/X.xsd`) → relativos (`X.xsd`) | `siRecepDE_v150.xsd`, `DE_v150.xsd`, `siRecepEvento_v150.xsd`, `Evento_v150.xsd` | libxml2 resuelve los `xs:include` sin red |
| `name="dEntCont "` (espacio final) → `name="dEntCont"` | `DE_v150.xsd` (línea 327 del original) | Error del XSD oficial: un nombre con espacio es imposible en XML y libxml2 rechaza el `dEntCont` correcto de toda FE B2G con `gCompPub`. Qué hace el validador del SIFEN con ese grupo: `[PENDIENTE DE VERIFICACIÓN]` |
| Sin cambios | los 7 restantes | — |

**No citar números de línea de estas copias** en docblocks ni commits: las citas (`DE_v150.xsd:973`, etc.)
se hacen sobre las copias fieles de `ekuat-ia/00-fuentes/xsd/`.

## Uso

```php
$doc = new DOMDocument();
$doc->loadXML($rdeXml);                       // rDE firmado
$ok = $doc->schemaValidate(__DIR__ . '/siRecepDE_v150.xsd');   // o siRecepEvento_v150.xsd para gGroupGesEve
```

En las pruebas: `IonysDev\Pkuatia\Tests\Support\XsdAssertions::assertRdeValido($xml)`.

## Mantenimiento

Cuando cambie `ekuat-ia/00-fuentes/xsd/` (procedimiento en `ekuat-ia/AGENTS.md` §4):

1. En ekuat-ia: `python 04-schemas-xsd/validacion-local/generar.py`.
2. Copiar los 11 `.xsd` de `validacion-local/` a esta carpeta.
3. Correr `vendor/bin/phpunit tests/Unit/Resources/XsdResourcesTest.php`: compara estas copias con las de
   `docs/sifen-ai/04-schemas-xsd/validacion-local/` (normalizando fin de línea) cuando esa carpeta existe.
