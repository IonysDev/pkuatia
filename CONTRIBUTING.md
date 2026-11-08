# Contribuir a PKuatia

Gracias por interesarte en mejorar la librería. Este documento resume el flujo de trabajo, cómo ejecutar las
verificaciones locales y las convenciones del proyecto.

## Antes de abrir un PR

1. **Rama:** creá una rama desde `dev` (o `main` si `dev` ya fue mergeada).
2. **Alcance:** un PR por tema lógico (bugfix, feature, docs, tests).
3. **Sin secretos:** nunca commitear certificados (`.p12`, `.pem`, `.pfx`), passphrases, CSC reales ni rutas
   personales (OneDrive, etc.). Tampoco datos de personas reales: los RUC, cédulas y nombres de los tests y de la
   documentación son inventados.
4. **API pública:** no eliminar ni cambiar firmas públicas sin justificación. Las ampliaciones compatibles
   (`int` → `int|Enum`, parámetros opcionales al final, métodos nuevos) están bien. Un nombre con errata se corrige
   con un alias nuevo y el viejo queda `@deprecated`; si solo difiere en mayúsculas, se corrige la declaración (PHP no
   distingue mayúsculas en los nombres de método, así que la grafía vieja sigue funcionando).
5. **Verificaciones locales** (ver [Pruebas](#pruebas)): deben quedar en verde.

## Flujo de Pull Request

1. Fork del repositorio (o rama en el repo si tenés permisos).
2. `git checkout -b tipo/descripcion-corta` (ej. `fix/signhelper-mensaje`, `docs/ejemplo-nc`).
3. Implementá el cambio con el menor diff razonable.
4. Actualizá `CHANGELOG.md` bajo la versión en curso (`## [x.y.z] — No publicado`) si el cambio es notable para
   consumidores.
5. Push y abrí el PR hacia `dev` (o `main` según acuerde el mantenedor).
6. El CI debe pasar: lint, estilo, PHPUnit, PHPStan, `composer validate` y `composer audit` en PHP 8.1, 8.2, 8.3 y
   8.4; PHP 8.5 corre como experimental y no bloquea. La cobertura de líneas se mide en el job de 8.3 contra el
   umbral de `.github/workflows/ci.yml`.

## Estilo de código

- **PSR-12 con cuatro espacios**, aplicado por php-cs-fixer con `.php-cs-fixer.dist.php` (solo reglas sin cambio
  semántico) y `.editorconfig`. Antes de abrir el PR: `composer cs-check`; para corregir: `composer cs-fix`.
- **Finales de línea:** git los normaliza a LF en el repositorio (`.gitattributes`, `text=auto`). Ni el fixer ni
  `.editorconfig` los tocan. En Windows con `core.autocrlf=true` la copia de trabajo mezcla CRLF y LF y
  `composer cs-check` marca los archivos CRLF aunque estén bien formateados (el fixer fija un único final de línea
  por corrida): corré el fixer con `PKUATIA_CS_EOL=crlf` sobre los archivos CRLF y sin la variable sobre los LF, o
  trabajá con una copia en LF. En el CI (Linux) funciona tal cual.
- **`git blame`:** el commit de reindentación de 0.3.1 está en `.git-blame-ignore-revs`; GitHub lo aplica solo y en
  local basta una vez: `git config blame.ignoreRevsFile .git-blame-ignore-revs`.
- Comentarios solo para lógica de negocio o detalles no obvios (SIFEN, OpenSSL legacy, etc.). Los docblocks van en
  castellano y deben coincidir con la firma nativa (PHPStan los verifica).
- Literales del SIFEN: respetar mayúsculas, acentos y guiones **exactamente** como exige el XSD de producción (un
  carácter distinto → rechazo del WS).
- Setters duales `int|Enum`: la descripción string debe obtenerse con `->getDescription()` /
  `::getDescriptionFromValue()`, nunca asignar el enum a una propiedad `string`. Los enums de códigos del MT usan el
  trait `EnumDescripcion`.
- Montos y cantidades decimales viajan como cadenas BCMath (`"1500.50"`), nunca como `float`; los setters que los
  reciben aceptan `int|string`.

## Commits

Convención acordada en el proyecto: **Conventional Commits en español**, con cuerpo en bullets cuando el cambio lo
amerite. Ejemplos:

- `feat(Sifen): agregar SetSoapClientFactory para pruebas`
- `fix(RRetEnviEventoDe): parsear múltiples gResProcEVe en XML`
- `test: regresión del sobrefirmado en SignHelperTest`
- `docs: ejemplo de FE contado en README`

## Pruebas

Requisitos: PHP ≥ 8.1, extensiones `soap`, `dom`, `openssl`, `zip`, `bcmath`, `mbstring`; dependencias instaladas con
`composer install`. Para la cobertura, xdebug o pcov.

```bash
# Lint de sintaxis (Linux/macOS; en Windows, php -l archivo por archivo o confiar en el CI)
find src test tests tools -name '*.php' -print0 | xargs -0 -n1 php -l

# Suite PHPUnit (tests/Unit/)
composer test

# Análisis estático: nivel 3 + reglas de obsolescencia, con baseline
composer phpstan

# Estilo
composer cs-check        # informa
composer cs-fix          # corrige

# Cobertura de líneas (el CI exige el umbral de ci.yml en PHP 8.3)
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-clover build/clover.xml
php tools/cobertura-minima.php build/clover.xml 75

# Smoke test manual (no corre en el CI desde 0.3.1: PHPUnit cubre lo mismo)
php test/SmokeTest.php
```

### PHPStan y la baseline

`phpstan-baseline.neon` no es un cajón de errores ignorados: cada entrada tiene una justificación en el plan de la
fase que la agregó (hoy, `docs/evaluacion-2026-10-02/PLAN-FASE-D.md`, bitácora de D9 y D10) con una de tres
etiquetas: **sin runtime** (`isset`/`??` sobre una propiedad tipada no anulable, que la librería usa para distinguir
"no informado"), **API** (corregirlo exige cambiar una firma pública: queda para una versión mayor) o **deprecado a
propósito** (código propio que sigue poblando o leyendo miembros obsoletos por compatibilidad). Un PR no agrega
entradas a la baseline salvo que las justifique en su descripción, y nunca para esconder un error de runtime.

### Tests que dependen de `docs/sifen-ai`

Tres tests comparan lo versionado con el repositorio de documentación del SIFEN
[ekuat-ia](https://github.com/abiliomp/ekuat-ia): `XsdResourcesTest` (los XSD de `src/Resources/xsd/`),
`CatalogosSincroniaTest` (los catálogos de `src/Resources/codigos/`, generados con `tools/generar-catalogos.php`) y
`RespuestasWsSincroniaTest` (las capturas de `tests/Resources/sifen/respuestas-ws/`). Buscan el clon en
`docs/sifen-ai` (carpeta ignorada por git) y **se omiten si no existe**, así que en el CI no corren. Para correrlos:

```bash
git clone https://github.com/abiliomp/ekuat-ia docs/sifen-ai
composer test
```

Si `CatalogosSincroniaTest` falla porque ekuat-ia cambió, regenerá los catálogos con
`php tools/generar-catalogos.php` y revisá el diff antes de commitear.

### Capturas reales del SIFEN

Las respuestas reales de `tests/Resources/sifen/respuestas-ws/` salen del ambiente de pruebas del SIFEN
(`sifen-test`), se anonimizan (RUC, CDC, nombres, protocolos) y se indexan también en ekuat-ia
(`06-ejemplos/respuestas-ws/`). Grabarlas requiere un certificado habilitado por la DNIT, así que lo hace el
mantenedor con un harness privado; si tenés una captura que aporta un caso nuevo, abrí un issue describiéndolo y
coordinamos cómo incorporarla anonimizada.

### Auditoría de la API pública

Tras cambios en `src/`, conviene comprobar que no se haya removido API pública:

```bash
git diff main -- src/ | grep "^-.*public "
```

Cada remoción o cambio de una firma pública debe estar justificado en el PR (una grafía corregida solo en
mayúsculas o un parámetro opcional nuevo al final no cuentan como remoción).

### Qué no va en el repo

- Pruebas que dependan del harness privado, certificados reales o la red (las integraciones online van en un proyecto
  aparte).
- Datos de timbrado/RUC de producción en tests o documentación versionada.

## Publicar releases

Los pasos de Packagist y etiquetado SemVer son manuales del mantenedor: ver [docs/PUBLICAR.md](docs/PUBLICAR.md).

## Seguridad

Las vulnerabilidades se reportan en privado: ver [SECURITY.md](SECURITY.md).

## Dudas

Para cambios de contrato SOAP o literales SIFEN, verificar contra el XSD de producción antes de modificar `Constants`
o rutas WSDL. Ante duda, abrí un issue describiendo el caso de uso.
