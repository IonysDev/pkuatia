# Publicar PKuatia en Packagist

Guía de pasos **manuales** para el mantenedor del paquete. El agente o CI no pueden
sustituir esta checklist: requiere cuenta en Packagist, acceso al repositorio en GitHub y
decisión de cuándo etiquetar una versión.

Paquete Composer: **`ionysdev/pkuatia`**  
Repositorio: **https://github.com/ionysdev/pkuatia**

---

## Antes de publicar

Completar en local o en GitHub (rama `main`):

1. **CI en verde** — workflow `.github/workflows/ci.yml` (lint, smoke test, PHPUnit, PHPStan).
2. **CHANGELOG** — mover el encabezado `[No publicado]` a una versión concreta, p. ej.
   `## [0.1.0] — 2026-06-XX`, con fecha real del release.
3. **`Constants::PKUATIA_VERSION`** — debe coincidir con la versión del tag (hoy `0.1.0` en `dev`).
4. **`composer.json`** — revisar `name`, `description`, `license`, `require` (PHP ^8.1 y extensiones)
   y que no haya secretos ni rutas locales.
5. **Merge `dev` → `main`** — solo cuando el release esté acordado (no publicar desde `dev`).

Este repositorio **no versiona `composer.lock`** (es una librería): Packagist y cada consumidor
resuelven dependencias al instalar.

---

## 1. Cuenta en Packagist

1. Ir a [packagist.org](https://packagist.org/) y registrarse (o iniciar sesión).
2. Opcional pero recomendado: vincular la cuenta de GitHub en el perfil de Packagist para
   simplificar el webhook del paso 3.

---

## 2. Registrar el paquete

1. En Packagist: **Submit** / **Add package**.
2. URL del repositorio: `https://github.com/ionysdev/pkuatia`
3. Confirmar el envío. Packagist leerá `composer.json` y creará la ficha `ionysdev/pkuatia`.

Si el repo es privado, Packagist no podrá indexarlo hasta que sea público (o se use un plan
que soporte paquetes privados).

**Comprobación:** en la ficha del paquete debe aparecer el nombre `ionysdev/pkuatia`, licencia
MIT y la rama por defecto (`main`).

---

## 3. Auto-actualización (webhook GitHub ↔ Packagist)

Sin esto, cada release nuevo hay que refrescar a mano en Packagist.

### Opción A — Integración oficial (recomendada)

1. En la ficha del paquete en Packagist: **Setup GitHub Hook** / conectar repositorio.
2. Autorizar a Packagist en GitHub si lo pide.
3. Tras un push a `main` (o al crear un tag), Packagist debería actualizar el índice en
   unos segundos.

### Opción B — Webhook manual

1. En Packagist, en el paquete: copiar la **URL del webhook** y el **token** (API).
2. En GitHub: repo → **Settings** → **Webhooks** → **Add webhook**.
3. Payload URL: la URL de Packagist; content type `application/json`.
4. Eventos: **Just the push event** (suele bastar).

**Prueba:** un push vacío o un commit de documentación en `main` y ver en Packagist que la
fecha de “Last update” cambia.

---

## 4. Publicar una versión (release SemVer)

Packagist toma las versiones de los **tags de Git** (y a veces de ramas; para librerías
públicas usar **solo tags** en producción).

1. Asegurarse de que `main` tiene el CHANGELOG y `PKUATIA_VERSION` de la versión a publicar.
2. Crear el tag anotado (ejemplo `0.1.0`):

   ```bash
   git checkout main
   git pull
   git tag -a v0.1.0 -m "Release 0.1.0"
   git push origin v0.1.0
   ```

   Convención del proyecto: prefijo `v` en el tag (`v0.1.0`) es habitual en GitHub; Packagist
   acepta `v0.1.0` y normalmente expone `0.1.0` a Composer.

3. Alternativa con **GitHub Releases**: repo → **Releases** → **Draft a new release** →
   elegir el tag `v0.1.0`, pegar notas desde el CHANGELOG, publicar.

4. Esperar a que Packagist indexe (webhook o **Update** manual en la ficha del paquete).

**Comprobación de instalación** (máquina limpia o contenedor):

```bash
composer require ionysdev/pkuatia:^0.1
```

Debe resolverse la versión publicada sin usar `minimum-stability: dev` salvo que solo existan
tags de pre-release.

---

## 5. Releases siguientes

Para cada versión SemVer nueva (`0.1.1`, `0.2.0`, …):

1. Cambios en `dev` → PR → merge a `main`.
2. Actualizar `CHANGELOG.md` y `Constants::PKUATIA_VERSION`.
3. Tag `vX.Y.Z` en `main` y push (o GitHub Release).
4. Verificar en Packagist que aparece la versión y que `composer require` la encuentra.

Versiones **pre-release** (`1.0.0-beta1`): Packagist las indexa; los consumidores necesitan
`minimum-stability: beta` o un constraint explícito según [documentación de Composer](https://getcomposer.org/doc/articles/versions.md).

---

## 6. Problemas frecuentes

| Síntoma | Qué revisar |
|--------|-------------|
| Packagist no ve el repo | Repo público; URL exacta; permisos de la cuenta |
| No aparece versión nueva | ¿Tag pusheado a `origin`? ¿Webhook activo? Botón **Update** en Packagist |
| `composer require` solo encuentra `dev-main` | Falta tag en `main`; o rama por defecto sin tags estables |
| Error de autoload PSR-4 en Linux | Nombres de archivo/clase con distinto casing (case-sensitive) |

---

## Referencias

- [Packagist — About](https://packagist.org/about)
- [Composer — Publicar paquetes](https://getcomposer.org/doc/02-libraries.md# publishing-to-packagist)
- [Semantic Versioning](https://semver.org/lang/es/)
