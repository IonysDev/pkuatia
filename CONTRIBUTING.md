# Contribuir a PKuatia

Gracias por interesar en mejorar la librería. Este documento resume el flujo de trabajo,
cómo ejecutar las verificaciones locales y las convenciones del proyecto.

## Antes de abrir un PR

1. **Rama:** creá una rama desde `dev` (o `main` si `dev` ya fue mergeada).
2. **Alcance:** un PR por tema lógico (bugfix, feature, docs, tests).
3. **Sin secretos:** nunca commitear certificados (`.p12`, `.pem`, `.pfx`), passphrases,
   CSC reales ni rutas personales (OneDrive, etc.).
4. **API pública:** no eliminar ni cambiar firmas públicas sin justificación. Las
   ampliaciones compatibles (`int` → `int|Enum`, métodos nuevos) están bien.
5. **Verificaciones locales** (ver sección [Pruebas](#pruebas)) — deben quedar en verde.

## Flujo de Pull Request

1. Fork del repositorio (o rama en el repo si tenés permisos).
2. `git checkout -b tipo/descripcion-corta` (ej. `fix/signhelper-mensaje`, `docs/ejemplo-nc`).
3. Implementá el cambio con el menor diff razonable.
4. Actualizá `CHANGELOG.md` bajo `[No publicado]` si el cambio es notable para consumidores.
5. Push y abrí el PR hacia `dev` (o `main` según acuerde el mantenedor).
6. El CI debe pasar (lint, smoke test, PHPUnit, PHPStan en PHP 8.1–8.3).

## Estilo de código

- Seguí el estilo del archivo que tocás (nombres, indentación, nivel de comentarios).
- Comentarios solo para lógica de negocio o detalles no obvios (SIFEN, OpenSSL legacy, etc.).
- Literales del SIFEN: respetar mayúsculas, acentos y guiones **exactamente** como exige el
  XSD de producción (un carácter distinto → rechazo del WS).
- Setters duales `int|Enum`: la descripción string debe obtenerse con
  `->getDescription()` / `::getDescriptionFromValue()`, nunca asignar el enum a una propiedad `string`.

## Commits

Convención acordada en el proyecto: **Conventional Commits en español**, con cuerpo en bullets
cuando el cambio lo amerite. Ejemplos:

- `feat(Sifen): agregar SetSoapClientFactory para pruebas`
- `fix(RRetEnviEventoDe): parsear múltiples gResProcEVe en XML`
- `test: regresión del sobrefirmado en SignHelperTest`
- `docs: ejemplo de FE contado en README`

## Pruebas

Requisitos: PHP ≥ 8.1, extensiones `soap`, `dom`, `openssl`, `zip`, `bcmath`, dependencias
instaladas con `composer install`.

```bash
# Lint rápido de sintaxis (todos los PHP de src/ y test/)
find src test -name '*.php' -print0 | xargs -0 -n1 php -l   # Linux/macOS
# En Windows, ejecutar php -l archivo por archivo o confiar en el CI.

# Smoke test offline (no requiere certificado ni red)
php test/SmokeTest.php

# Suite PHPUnit
composer test
# equivalente: vendor/bin/phpunit

# Análisis estático (nivel 1 + baseline)
composer phpstan
```

Tras cambios en `src/`, conviene auditar que no se haya removido API pública:

```bash
git diff main -- src/ | grep "^-.*public "
```

Cada remoción de método/propiedad pública debe estar justificada en el PR.

### Qué no va en el repo

- Pruebas que dependan del harness privado, certificados reales o la red (las integraciones
  online van en un proyecto aparte).
- Datos de timbrado/RUC de producción en tests o documentación versionada.

## Publicar releases

Los pasos de Packagist y etiquetado SemVer son manuales del mantenedor: ver
[docs/PUBLICAR.md](docs/PUBLICAR.md).

## Dudas

Para cambios de contrato SOAP o literales SIFEN, verificar contra el XSD de producción antes
de modificar `Constants` o rutas WSDL. Ante duda, abrí un issue describiendo el caso de uso.
