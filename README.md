# 📄 PKuatia

[![CI](https://github.com/ionysdev/pkuatia/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/ionysdev/pkuatia/actions/workflows/ci.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.1-blue.svg)](https://www.php.net/)

**PKuatia** es una biblioteca PHP para interactuar con el **Sistema Integrado de Facturación Electrónica Nacional (SIFEN)** de Paraguay, implementando la especificación técnica del sistema **EKuatia**.

Esta biblioteca permite generar, firmar, enviar y consultar Documentos Tributarios Electrónicos (DTE) según el Manual Técnico Versión 150 del SIFEN.

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Recomendaciones para Producción](#-recomendaciones-para-producción)
- [Uso Básico](#-uso-básico)
- [Validar, verificar y leer errores](#-validar-verificar-y-leer-errores)
- [Funcionalidades](#-funcionalidades)
- [Tipos de Documentos Soportados](#-tipos-de-documentos-soportados)
- [Ejemplos](#-ejemplos)
- [Pruebas](#-pruebas)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Contribución](#-contribución)
- [Licencia](#-licencia)
- [Autores](#-autores)

## ✨ Características

- 🔐 **Firma digital de documentos** usando certificados PEM, P12 o PFX
- 📤 **Envío de documentos electrónicos** individuales o en lotes (hasta 50 documentos)
- 🔍 **Consultas al SIFEN**:
  - Consulta de RUC (Registro Único del Contribuyente)
  - Consulta de documentos electrónicos por CDC
  - Consulta de lotes de documentos
- 🎫 **Gestión de eventos**:
  - Cancelación de documentos electrónicos
  - Inutilización de números de documentos
  - Actualización de los datos del transporte de una Nota de Remisión
  - Nominación de facturas emitidas como innominadas
  - Eventos del receptor: conformidad, disconformidad, desconocimiento y notificación de recepción
- 📱 **Generación automática de códigos QR** para validación de documentos
- 🏗️ **Arquitectura orientada a objetos** con clases tipadas
- ✅ **Validaciones** según especificaciones del Manual Técnico
- 🔄 **Soporte para ambientes** de desarrollo y producción
- 📊 **Mapeos de datos** predefinidos (países, departamentos, monedas, unidades de medida)

## 📦 Requisitos

- PHP >= 8.1
- Extensiones PHP: `soap`, `dom`, `openssl`, `zip`, `bcmath`
- Composer
- Certificado digital emitido por una ente prestador de servicios de confianza de Paraguay
- Clave privada correspondiente al certificado
- Credenciales de acceso al SIFEN (ID CSC y CSC)

## 🚀 Instalación

### Instalación mediante Composer

```bash
composer require ionysdev/pkuatia
```

### Instalación desde el repositorio

```bash
git clone https://github.com/ionysdev/pkuatia.git
cd pkuatia
composer install
```

## ⚙️ Configuración

Antes de utilizar la biblioteca, es necesario configurar los parámetros de conexión y autenticación:

```php
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Sifen;

$config = new Config();

// Ambiente (dev o prod)
$config->env = Config::ENV_DEV; // o Config::ENV_PROD para producción

// Formato del certificado (pem, p12 o pfx)
$config->certificateFormat = "pem"; // o "p12" / "pfx"
$config->privateKeyPassphrase = "tu_contraseña";

// PEM en un solo archivo (certificado + clave privada):
$config->privateKeyFilePath = "/ruta/a/tu/certificado.pem";

// PEM en dos archivos separados:
// $config->certificateFilePath = "/ruta/a/tu/certificado.crt";
// $config->privateKeyFilePath = "/ruta/a/tu/clave_privada.key";

// P12/PFX (certificado y clave en un solo archivo):
// $config->certificateFormat = "pfx";
// $config->privateKeyFilePath = "/ruta/a/tu/certificado.pfx";

// Credenciales del SIFEN
$config->idCsc = "0001"; // ID CSC proporcionado por el SIFEN
$config->csc = "ABCD0000000000000000000000000000"; // CSC de 32 caracteres (este es el de pruebas: en producción Init() exige el real)

// Ruta para almacenar el archivo de control del dId (opcional)
$config->dIdFilePath = "PKuatiaDId.dat.json";

// Opcionales (0.3.0)
// $config->validarXsdAntesDeEnviar = true; // EnviarDE, EnviarLoteDE y RegistrarEvento validan contra el XSD antes de tocar la red
// $config->soapTrace = false;              // no guardar la última solicitud/respuesta (GetLastRequest/GetLastResponse devuelven null)

// Inicializar Sifen
Sifen::Init($config);

// Al terminar (opcional): borra los temporales del PKCS#12, descarta el cliente SOAP y olvida la clave privada
Sifen::Shutdown();
```

### Configuración desde archivo JSON

También puedes cargar la configuración desde un archivo JSON:

```php
$config = Config::ParseJsonFile("config.json");
Sifen::Init($config);
```

Ejemplo de `config.json`:

```json
{
    "env": "dev",
    "certificateFormat": "pem",
    "privateKeyFilePath": "/ruta/a/certificado.pem",
    "privateKeyPassphrase": "contraseña",
    "idCsc": "0001",
    "csc": "ABCD0000000000000000000000000000",
    "dIdFilePath": "PKuatiaDId.dat.json",
    "wsdlCacheEnabled": true,
    "soapTrace": true,
    "validarXsdAntesDeEnviar": false
}
```

## 🏭 Recomendaciones para Producción

### Caché de WSDL

El SIFEN limita la tasa de solicitudes. Descargar el WSDL en cada operación puede provocar
bloqueos temporales. Se recomienda activar la caché de WSDL en disco:

```php
$config->wsdlCacheEnabled = true; // usa WSDL_CACHE_DISK
```

En **Windows**, además, conviene asegurar un directorio de caché válido antes de iniciar Sifen,
porque el valor por defecto (`/tmp`) no existe:

```php
ini_set('soap.wsdl_cache_dir', sys_get_temp_dir());
```

### Tasa de solicitudes (rate limiting)

El ambiente de pruebas (`sifen-test`) es especialmente sensible a la saturación: ante un exceso
de solicitudes deja de responder por varios minutos. Buenas prácticas:

- Mantener `wsdlCacheEnabled = true`.
- Espaciar los reintentos (no reintentar en bucle inmediato).
- Para la consulta de resultado de lote (`ConsultaLote`), seguir la guía de la DNIT: **empezar a
  consultar 10 minutos después** de recibir el código 0300 y repetir **a intervalos no menores a
  10 minutos** mientras la respuesta sea 0361 (lote en procesamiento). Consultar antes dispara el
  bloqueo por saturación. Fuente: "Mejores prácticas para el envío de DE" de la DNIT, §3.

### Zona horaria y fecha de firma

El SIFEN compara las fechas del documento y de la firma con la hora de Asunción: una firma con
fecha **posterior** a la hora del SIFEN se rechaza (validación 1004) y la transmisión tardía
respecto de la fecha de firma se aprueba con observación (1005). Recomendaciones:

- Sincronizar el reloj del servidor por NTP (MT §7.11).
- Generar `dFeEmiDE` y la fecha de firma con `new DateTime('now', new DateTimeZone('America/Asuncion'))`,
  sobre todo en servidores configurados en UTC. La librería **respeta tal cual** las fechas que recibe
  (`setFechaEmision`, `FirmarDE`), sin convertirlas.
- Las fechas que la librería genera por su cuenta (la `dFecFirma` de los eventos registrados con
  `CancelarDE`, `ConformarDE`, etc., y el "hoy" de las validaciones internas) se calculan en
  `Constants::SIFEN_TIMEZONE` (`America/Asuncion`), cualquiera sea la zona horaria por defecto de PHP.
  Todos los wrappers de eventos aceptan un último parámetro opcional `?DateTime $fechaFirma` para fijarla.
### Certificados `.p12` / `.pfx` con cifrado heredado (OpenSSL 3)

Los certificados emitidos por las CA de Paraguay suelen venir en un PKCS#12 cifrado con
algoritmos heredados (RC2-40 / 3DES) que **OpenSSL 3 —incluido en PHP 8— deshabilita por
omisión**. Si al inicializar obtenés un error del tipo
`digital envelope routines::unsupported`, tenés tres opciones:

1. **Habilitar el proveedor `legacy` de OpenSSL** antes de iniciar PHP, mediante las variables
   de entorno `OPENSSL_CONF` (apuntando a un `openssl.cnf` que active los proveedores `default`
   y `legacy`) y `OPENSSL_MODULES` (apuntando al directorio que contiene `legacy.dll` /
   `legacy.so`). No alcanza con `putenv()` en tiempo de ejecución: el proveedor se inicializa
   en el primer uso de OpenSSL.
2. **Reexportar el certificado** a un PKCS#12 con cifrado moderno:
   ```bash
   openssl pkcs12 -in viejo.p12 -legacy -nodes -out tmp.pem
   openssl pkcs12 -export -in tmp.pem -out nuevo.p12
   # luego eliminar tmp.pem, que queda sin cifrar
   ```
3. **Convertir el `.p12` a PEM** y usar `certificateFormat = "pem"`.

La librería detecta este caso y arroja una excepción con estas mismas instrucciones.

### Secretos, archivos temporales y CSC

- Con un certificado `.p12`/`.pfx`, `Init()` extrae el certificado y la clave a una carpeta propia de nombre
  impredecible dentro de la carpeta temporal del sistema; la clave queda **cifrada** con la misma passphrase y los
  archivos se borran en `Sifen::Shutdown()`, en el siguiente `Init()` y al terminar el script.
- `var_dump($config)` y `print_r($config)` muestran la passphrase y el CSC como `[redactado]`. No registres `Config`
  en logs igual: las propiedades siguen teniendo el valor real.
- `SignHelper::$xmlKey` y `SignHelper::$xmlSigner` siguen existiendo por compatibilidad, pero están obsoletas: la
  firma usa una copia privada de la clave y se retiran en la 1.0.
- El CSC de fábrica (`ABCD0000…`) es el del ambiente de pruebas. Con `env = prod` y ese CSC, `Init()` lanza
  `ConfiguracionException`: en producción el SIFEN rechaza cada DE con 2501.

## 📖 Uso Básico

### Consultar un RUC

```php
use IonysDev\Pkuatia\Core\Responses\RResEnviConsRUC;
use IonysDev\Pkuatia\Sifen;

// RUC sin dígito verificador (5 a 8 dígitos)
$respuesta = Sifen::ConsultarRUC('80012345');

if ((int) $respuesta->getDCodRes() === RResEnviConsRUC::COD_RES_RUC_FOUND) {
    $ruc = $respuesta->getRContRuc();
    echo $ruc->dRazCons . ' — facturador electrónico: ' . $ruc->dRUCFactElec;
} else {
    echo 'Error: ' . $respuesta->getDMsgRes();
}
```

### Consultar y deserializar un Documento Electrónico

`ConsultarDE` devuelve el DE aprobado, su protocolo de autorización y los eventos que tenga registrados,
ya convertidos a objetos:

```php
use IonysDev\Pkuatia\Sifen;

// CDC de 44 dígitos del DE ya autorizado
$cdc = '01800000005001001000000122026010100000000000001'; // placeholder
$respuesta = Sifen::ConsultarDE($cdc);

if ($respuesta->getDCodRes() === 422) { // 0422: existe y está aprobado; 0420: no existe o no está aprobado
    $contenido = $respuesta->getRContDe();
    $de = $contenido->getRDe()->getDE(); // el DE completo, como objetos
    echo $de->getGDatGralOpe()->getGEmis()->getDNomEmi() . ', protocolo ' . $contenido->getDProtAut() . "\n";

    // Cancelación, conformidad y demás eventos registrados sobre el DE, con la respuesta del SIFEN a cada uno
    foreach ($contenido->getRContEvs() as $evento) {
        echo $evento->getRResEnviEventoDe()->getGResProcEVe()[0]->getDEstRes() . "\n";
    }
} else {
    echo $respuesta->getDCodRes() . ': ' . $respuesta->getDMsgRes() . "\n";
}

// La respuesta tal como llegó, para guardarla o auditarla, también cuando el parseo falla
$xmlCrudo = Sifen::GetLastResponse();
```

Un `rDE` firmado y guardado como XML se puede leer y volver a escribir sin perder la firma:

```php
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;

$rde = RDE::FromSimpleXMLElement(simplexml_load_string($xmlFirmado));
$xml = $rde->toXMLString(); // el mismo rDE, con Signature y gCamFuFD; la firma sigue verificando
```

## 🛡️ Validar, verificar y leer errores

Desde 0.3.0 la biblioteca puede decir, **antes de tocar la red**, qué rechazaría el SIFEN, verificar la firma de un
XML recibido y explicar cada código de respuesta. Nada de esto cambia el comportamiento de `EnviarDE`: todo es
opcional.

### Validar antes de enviar

Un documento en construcción (`Factura`, `NotaDeCredito`, `NotaDeDebito`, `NotaDeRemision`, `Autofactura`) o un
`DE`/`RDE` ya armado o leído de un XML se valida contra las reglas del Manual Técnico sin serializar ni firmar:

```php
use IonysDev\Pkuatia\Validacion\OrigenError;
use IonysDev\Pkuatia\Validacion\ValidadorDE;

$resultado = $factura->validarReglas(); // o ValidadorDE::validar($rde) para un DE o RDE ya armado
if (!$resultado->esValido()) {
    foreach ($resultado->getErrores() as $error) {
        // "1309 [D207 dDVRec] Dígito Verificador del RUC del receptor incorrecto ... Ver setReceptor()."
        echo $error . "\n";
        // o por partes: $error->codigoSifen, $error->campoMT, $error->elemento, $error->ruta, $error->valor, $error->sugerencia
    }
}
foreach ($resultado->getAdvertencias() as $aviso) { // lo que el SIFEN aprobaría con observación
    echo 'Aviso: ' . $aviso->mensaje . "\n";
}
$soloReglas = $resultado->porOrigen(OrigenError::Regla); // también porCodigo('1309') y porCampo('D207')
$resultado->lanzarSiInvalido(); // DocumentoInvalidoException, con el resultado en getResultado()
```

Cada error lleva el código con el que el SIFEN rechazaría el documento (el mismo `dCodRes` que devolvería), el campo
del MT, el elemento XML, la ruta dentro del DE, el valor recibido y una sugerencia con el método de PKuatia que carga
ese campo. Las reglas de fechas (1004, 1005, 1103, 1150, 1151, 2055, 2108...) se evalúan contra el momento actual en
Asunción, o contra el `DateTime` que se pase como `$ahora`.

El validador comprueba la completitud según el XSD (lo que falta en cada grupo informado, código 0160) y las
validaciones del MT listadas al final de esta sección. No cubre lo que solo el SIFEN sabe: existencia del RUC, del
timbrado o del CDC asociado, duplicados y estado del receptor.

Para validar el XML ya firmado contra los **XSD de producción** (lo primero que hace el SIFEN, código 0160):

```php
use IonysDev\Pkuatia\Sifen;

$xml = Sifen::FirmarDE($rde, new DateTime('now', new DateTimeZone('America/Asuncion')));
$resultado = Sifen::ValidarXSD($xml); // Sifen::ValidarEventoXSD($sobre) para un sobre de eventos; sin Init() ni red
foreach ($resultado as $error) {
    echo "línea {$error->linea}: {$error->mensaje} ({$error->campoMT}) {$error->sugerencia}\n";
}
```

Y para que `EnviarDE`, `EnviarLoteDE` y `RegistrarEvento` lo hagan solos y lancen `DocumentoInvalidoException` en
vez de enviar un XML que el SIFEN va a rechazar: `$config->validarXsdAntesDeEnviar = true;` (por defecto `false`).

### Verificar una firma

```php
use IonysDev\Pkuatia\Sifen;

$verificacion = Sifen::VerificarFirma($xmlRecibido); // un rDE o un sobre de eventos; sin Init() ni red
if ($verificacion->esValida()) {
    $firma = $verificacion->getFirmas()[0];
    echo $firma->certificado?->sujeto . ' (RUC ' . $firma->certificado?->ruc . '), firmado el ' . $firma->fechaFirma?->format('c') . "\n";
} else {
    foreach ($verificacion->getErrores() as $error) {
        echo $error . "\n"; // 0140 estándar, 0141 digest o firma, 0120 certificado, 0121/2450 vigencia
    }
}
```

Se verifica el digest, el valor de la firma contra el certificado incluido, los algoritmos del estándar y la vigencia
del certificado en la fecha de firma. No se verifica la cadena de certificación ni la revocación.

### Leer una respuesta

Las siete respuestas del facade implementan `RespuestaSifen`: `getCodigo()` (`"0260"`), `getMensaje()`,
`esExitosa()`, `getCodigoResultado()` (enum `CodigoResultadoWS`), `getInfoValidacion()` y `toArray()`. Cada una
agrega lo suyo (`esAprobado()`, `getProtocolo()`, `getMotivos()`, `fueEncolado()`, `getRechazados()`...):

```php
use IonysDev\Pkuatia\Sifen;
use IonysDev\Pkuatia\Validacion\CatalogoValidaciones;

$respuesta = Sifen::EnviarDE($xml);
if ($respuesta->esAprobado()) {
    echo 'Aprobado, protocolo ' . $respuesta->getProtocolo() . "\n";
} else {
    foreach ($respuesta->getMotivos() as $motivo) {
        $info = $motivo->getInfoValidacion(); // catálogo del MT: campo, regla y método de PKuatia que lo carga
        echo $motivo->getCodigo() . ' ' . $motivo->getMensaje() . ($info !== null ? " [{$info->id}] {$info->observacion} → {$info->metodoPkuatia}" : '') . "\n";
    }
}

// El catálogo también se consulta solo: qué significa un código y qué tocar
echo CatalogoValidaciones::describir('1321'); // "1321 (D208c): Receptor innominado ..."; como objeto: ->observacion (la regla) y ->metodoPkuatia
```

### Errores: qué excepción capturar

Los rechazos del SIFEN **no son excepciones**: llegan en el objeto de respuesta. Las excepciones son para lo que
impide enviar o leer. Cada clase extiende la que se lanzaba en ese lugar hasta 0.2.1, así que un `catch` existente
sigue funcionando, y todas implementan `PkuatiaExceptionInterface`.

| Excepción | Extiende | Cuándo |
|-----------|----------|--------|
| `ConfiguracionException` | `PkuatiaException` (`\Exception`) | `Config` incompleta, archivos que no existen, CSC de prueba en producción, temporales |
| `CertificadoException` | `ConfiguracionException` | certificado o clave ilegibles o con passphrase incorrecta; `getMotivo()` |
| `FirmaException` | `PkuatiaException` | firmar sin `Init()` o después de `Shutdown()` |
| `RespuestaException` | `PkuatiaException` | respuesta del SIFEN que no se pudo interpretar; `getRespuestaCruda()`, `getCampoFaltante()` |
| `ValidacionException` | `\InvalidArgumentException` | datos inválidos en setters, builders y validaciones previas al envío |
| `CampoInvalidoException` | `ValidacionException` | lo mismo, con el campo del MT y el código del SIFEN (p. ej. 1321) |
| `DocumentoInvalidoException` | `ValidacionException` | `lanzarSiInvalido()` y `validarXsdAntesDeEnviar`; `getResultado()` |
| `TransporteException` | `\SoapFault` | falla de comunicación; `getTipo()` (`TipoFallaTransporte`) y `getOperacion()` |
| `SifenNoDisponibleException` | `TransporteException` | saturación o bloqueo temporal del SIFEN: reintentar más tarde |

```php
use IonysDev\Pkuatia\Core\Exceptions\PkuatiaExceptionInterface;
use IonysDev\Pkuatia\Core\Exceptions\SifenNoDisponibleException;
use IonysDev\Pkuatia\Core\Exceptions\TransporteException;
use IonysDev\Pkuatia\Sifen;

try {
    $respuesta = Sifen::EnviarDE($xml);
} catch (SifenNoDisponibleException $e) {
    // esperar y reintentar: el SIFEN no respondió (WSDL o cuerpo vacío)
} catch (TransporteException $e) {
    echo $e->getTipo()->value . ' en ' . $e->getOperacion() . ': ' . $e->getMessage();
} catch (PkuatiaExceptionInterface $e) {
    echo get_class($e) . ': ' . $e->getMessage(); // configuración, certificado, validación o respuesta ilegible
}
```

### Validaciones del MT que cubre el validador

Completitud según el XSD (0160) y estas 234 validaciones del MT §12.4 (1921 es de la NT-013). Lo que falta depende
de datos que solo el SIFEN tiene (existencia y estado de RUC, timbrados y CDC, duplicados, sumas contra la factura
asociada).

```text
1000 1003 1004 1005 1051 1100 1103 1110 1150 1151 1156 1200 1201 1202 1203 1205 1206 1207 1208 1209 1210 1211
1253 1254 1255 1257 1260 1300 1301 1302 1303 1304 1305 1309 1310 1311 1313 1314 1315 1316 1317 1318 1319 1320
1321 1323 1324 1325 1326 1327 1328 1329 1330 1350 1351 1352 1400 1401 1402 1450 1451 1452 1500 1501 1502 1503
1550 1551 1552 1553 1554 1555 1556 1557 1600 1601 1602 1650 1651 1700 1701 1702 1703 1704 1705 1706 1751 1800
1801 1802 1804 1806 1807 1808 1850 1851 1852 1853 1854 1855 1856 1857 1858 1859 1861 1900 1901 1902 1903 1904
1905 1906 1907 1908 1909 1910 1911 1912 1913 1921 2050 2051 2052 2053 2054 2055 2100 2101 2102 2103 2104 2107
2108 2109 2110 2150 2151 2153 2200 2201 2203 2250 2251 2252 2253 2254 2255 2300 2301 2302 2305 2306 2307 2308
2311 2350 2351 2352 2353 2354 2355 2356 2357 2358 2359 2362 2363 2364 2365 2366 2367 2368 2369 2370 2371 2372
2373 2374 2375 2376 2377 2382 2385 2386 2390 2400 2401 2402 2405 2406 2407 2408 2409 2410 2411 2413 2415 2416
2418 2419 2420 2421 2422 2423 2424 2425 2426 2427 2429 2430 2431 2432 2433 2434 2435 2436 2503 2550 2551 2552
2553 2555 2556 2557 2558 2559 2561 2600 2601 2602 2603 2604 2605 2606
```

## 🎯 Funcionalidades

| Área | Métodos principales |
|------|---------------------|
| Consultas | `ConsultarRUC`, `ConsultarDE`, `ConsultaLote`, `EsperarResultadoLote`, `ConsultarArchivoRUC` |
| Emisión | `FirmarDE`, `EnviarDE`, `EnviarLoteDE` |
| Eventos emisor | `CancelarDE`, `InutilizarNumeros`, `ActualizarDatosTransporte` (NR) |
| Eventos (varios por sobre) | `RegistrarEvento` (hasta 15 eventos firmados por transmisión) |
| Eventos receptor | `ConformarDE`, `DisconformarDE`, `DesconocerDE`, `NotificarRecepcionDE`, `NominarFE` |
| Builders | `Factura`, `NotaDeCredito`, `NotaDeDebito`, `NotaDeRemision`, `Autofactura` |
| Diagnóstico | `GetLastRequest`, `GetLastResponse` (el XML de la última solicitud y de la última respuesta) |
| Validación sin red | `validarReglas` (builders) y `ValidadorDE::validar`, `ValidarXSD`, `ValidarEventoXSD`, `VerificarFirma` |
| Lectura de respuestas | `esAprobado`, `getCodigo`, `getMensaje`, `getMotivos`, `getInfoValidacion`; `CatalogoValidaciones::describir` |
| Ciclo de vida | `Init`, `Shutdown` |

Los ejemplos completos de **FE contado**, **cancelación** y **lote** están en [Ejemplos](#-ejemplos). Otros
tipos de documento y eventos se documentarán en una siguiente iteración.

## 📄 Tipos de Documentos Soportados

La biblioteca soporta los siguientes tipos de Documentos Tributarios Electrónicos, que son los que
el XSD de producción del SIFEN acepta actualmente (`iTiDE`):

| Código | Tipo de Documento | Builder | Estado |
|--------|-------------------|---------|--------|
| 1 | Factura Electrónica | `Factura` | ✅ Soportado (homologado contra SIFEN) |
| 4 | Autofactura Electrónica | `Autofactura` | ✅ Soportado (válido contra el XSD de producción; homologación en `sifen-test` pendiente) |
| 5 | Nota de Crédito Electrónica | `NotaDeCredito` | ✅ Soportado (válido contra el XSD de producción; homologación en `sifen-test` pendiente) |
| 6 | Nota de Débito Electrónica | `NotaDeDebito` | ✅ Soportado (válido contra el XSD de producción; homologación en `sifen-test` pendiente) |
| 7 | Nota de Remisión Electrónica | `NotaDeRemision` | ✅ Soportado (válido contra el XSD de producción; homologación en `sifen-test` pendiente) |
| 9 | Boleta de venta electrónica | — | 🗺️ En el roadmap |
| 10 | Boleta RESIMPLE | — | 🗺️ En el roadmap |

> **Nota sobre los tipos 2, 3 y 8** (Factura de Exportación, Factura de Importación y Comprobante
> de Retención): figuran en el Manual Técnico, pero el **XSD de producción del SIFEN los rechaza**
> (no están habilitados por la DNIT), por lo que ninguna librería del ecosistema puede emitirlos
> actualmente. La enumeración `TimbTiDE` los conserva para poder identificarlos al deserializar.

Puedes usar la enumeración `TimbTiDE` para referenciar estos tipos:

```php
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;

TimbTiDE::Factura->value; // 1
TimbTiDE::NotaDeCredito->value; // 5
```

## 📁 Estructura del Proyecto

```
pkuatia/
├── src/                      # Código de la librería (PSR-4)
├── tests/Unit/               # Suite PHPUnit (offline, sin certificado)
├── test/                     # Smoke test y scripts de consulta de ejemplo
├── .github/workflows/        # CI (PHP 8.1–8.3)
├── docs/PUBLICAR.md          # Guía Packagist (mantenedores)
├── phpunit.xml.dist
├── phpstan.neon.dist
└── composer.json
```

## 🔧 Dependencias

- **robrichards/xmlseclibs** (^3.1): Para la firma digital XML
- **krowinski/bcmath-extended** (^7.0): Para operaciones matemáticas de precisión extendida

## 📚 Ejemplos

Los fragmentos usan **datos genéricos** (RUC `80000000-5`, timbrado `12345678`). Reemplazalos por
tu timbrado habilitado, certificado y CSC antes de enviar al SIFEN. En ambiente `dev` el nombre del
emisor se ajusta automáticamente al texto de prueba reglamentario.

### Factura electrónica al contado (emitir y enviar)

```php
use DateTime;
use DateTimeZone;
use IonysDev\Pkuatia\Core\Config;
use IonysDev\Pkuatia\Core\Constants\CamCondOpe;
use IonysDev\Pkuatia\Core\Constants\CamFEIndPres;
use IonysDev\Pkuatia\Core\Constants\CamIVAAfecIVA;
use IonysDev\Pkuatia\Core\Constants\CamIVATasaIVA;
use IonysDev\Pkuatia\Core\Constants\EmisRecTipCont;
use IonysDev\Pkuatia\Core\Constants\OpeComTipTrans;
use IonysDev\Pkuatia\Core\Constants\PaConEIniTiPago;
use IonysDev\Pkuatia\Core\Constants\RecTiOpe;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\Factura;
use IonysDev\Pkuatia\Sifen;

// 1. Configuración e inicialización (ver sección Configuración)
$config = new Config();
$config->env = Config::ENV_DEV;
$config->certificateFormat = 'pem';
$config->privateKeyFilePath = '/ruta/a/certificado.pem';
$config->privateKeyPassphrase = 'tu_contraseña';
$config->idCsc = '0001';
$config->csc = 'ABCD0000000000000000000000000000';
$config->wsdlCacheEnabled = true;
Sifen::Init($config);

// 2. Conformar la factura
$factura = new Factura(CamCondOpe::Contado);
$factura->setTimbrado(
    numTimb: 12345678,
    fechaInicio: new DateTime('2024-01-01'),
    numEst: 1,
    numExp: 1,
    numDoc: 1
);
$factura->setFechaEmision(new DateTime('now', new DateTimeZone('America/Asuncion')));
$factura->setEmisor(
    rucEmisor: '80000000',
    dv: 5,
    tipoContribuyente: EmisRecTipCont::PersonaJuridica,
    tipoRegimen: null,
    nombreEmisor: 'Empresa Emisora de Ejemplo SA',
    nombreFantasia: null,
    callePrincipal: 'Av. Principal',
    casaNro: '100',
    calleSecundaria: null,
    complementoDir: null,
    codDep: 1,
    codDistrito: null,
    codCiud: 1,
    telefono: '021000000',
    email: 'emisor@example.com',
    nombreSucursal: null
);
$factura->addEmisorActividadEconomica(47190, 'Comercio al por menor');
$factura->setReceptor(
    nombre: 'Cliente Receptor SA',
    esContribuyente: true,
    tipoOperacion: RecTiOpe::B2B,
    codPais: 'PRY',
    tipoContribuyente: EmisRecTipCont::PersonaJuridica,
    ruc: '80012345',
    dv: 0,
    tipoIdentificacion: null,
    nroIdentificacion: null,
    nombreFantasia: null,
    callePrincipal: null,
    numeroCasa: null,
    codigoDepartamento: null,
    codigoDistrito: null,
    codigoCiudad: null,
    telefono: null,
    celular: null,
    email: null,
    codigoDeCliente: null
);
$factura->setTipoDeTransaccion(OpeComTipTrans::VentaMercaderia);
$factura->setIndicadorPresencia(CamFEIndPres::Presencial);
$factura->addItem(
    codigo: 'PROD001',
    descripcion: 'Producto de ejemplo',
    codUnidadMedida: 77,           // UNI
    cantidad: '1',
    precisionMoneda: 0,
    precioUnit: '100000',
    totalBruto: null,
    afectIVA: CamIVAAfecIVA::Gravado,
    proporcionGravadaIVA: '100',
    tasaDeIVA: CamIVATasaIVA::IVA10
);
// Totales (gTotSub): obligatorio antes de serializar. El argumento es la precisión de la moneda (0 para PYG).
$factura->calcTotSub(0);
$factura->addPago(PaConEIniTiPago::Efectivo, '100000', 'PYG');

// 3. Firmar y enviar
$rde = $factura->facturaToRDE();
$fechaFirma = new DateTime('now', new DateTimeZone('America/Asuncion'));
$xmlFirmado = Sifen::FirmarDE($rde, $fechaFirma);
$respuesta = Sifen::EnviarDE($xmlFirmado);

$prot = $respuesta->getRProtDe();
$cdc = $prot->getId();
$resultado = $prot->getGResProc()[0];
echo "CDC: $cdc — {$resultado->dCodRes}: {$resultado->dMsgRes}\n";
// Aprobación habitual: dCodRes en familia 026x (p. ej. 0260)
```

### Cancelar un DE aprobado

Solo podés cancelar un CDC que el SIFEN haya **autorizado** previamente. El motivo debe tener
entre 5 y 500 caracteres.

> En `sifen-test`, esperá **al menos 3 minutos** entre la aprobación del DE y la cancelación. El reloj del
> servicio de recepción del ambiente de pruebas va adelantado, y una cancelación inmediata se rechaza con
> 4009 ("plazo de solicitud de cancelación extemporáneo"). En producción no está verificado.

```php
use IonysDev\Pkuatia\Sifen;

// $cdc obtenido del envío anterior (44 dígitos)
$cdc = '01800000005001001000000122026010100000000000001'; // placeholder

$respuesta = Sifen::CancelarDE(
    $cdc,
    'Anulación por error en los datos del comprobante'
);

foreach ($respuesta->getGResProcEVe() as $evento) {
    foreach ($evento->getGResProc() as $proc) {
        echo "{$proc->dCodRes}: {$proc->dMsgRes}\n";
        // Éxito habitual del evento de cancelación: 0600
    }
}
```

### Enviar un lote y esperar el resultado

```php
use IonysDev\Pkuatia\Core\Responses\RResEnviLoteDe;
use IonysDev\Pkuatia\Sifen;

// Hasta 50 rDE firmados con FirmarDE, del mismo tipo y del mismo RUC emisor, sin CDC repetidos.
// EnviarLoteDE lo valida antes de enviar: el SIFEN rechaza esos lotes o bloquea temporalmente al RUC.
$recepcion = Sifen::EnviarLoteDE([$xmlFirmado1, $xmlFirmado2]);

if ($recepcion->getDCodRes() === RResEnviLoteDe::COD_RES_ACEPTADO) { // 0300
    $nroLote = $recepcion->getDProtConsLoteString(); // guardarlo como texto: tiene 17 dígitos o más

    // Bloquea el proceso: primera consulta a los 10 minutos y después cada 10, mientras siga en 0361
    $resultado = Sifen::EsperarResultadoLote($nroLote);
    foreach ($resultado->getGResProcLote() as $documento) {
        echo $documento->getId() . ': ' . $documento->getDEstRes() . "\n"; // Aprobado, Aprobado con observación o Rechazado
    }
}
```

`EsperarResultadoLote` nunca consulta antes de los 10 minutos que pide la DNIT. Para no bloquear el proceso,
acepta en `$esperar` una función propia en lugar de `sleep()`, por ejemplo para reprogramar la consulta en una
cola, y `$onIntento` recibe cada respuesta.

### Otros scripts de referencia

En `test/` hay scripts de consulta que requieren certificado y red:

- `ConsultaRUC.php`, `ConsultaDE.php`, `ConsultaLote.php`
- `SmokeTest.php` — verificación offline rápida (`php test/SmokeTest.php`)

> **Próximamente en esta sección:** FE crédito en cuotas, NC, ND, NR con transporte, autofactura,
> inutilización y eventos del receptor (`ConformarDE`, etc.).

## ⚠️ Notas Importantes

1. **Certificados Digitales**: Debes contar con un certificado digital válido emitido por algún ente prestador de servicios de confianza habilitado por el Ministerio de Industria y Comercio del Paraguay.

2. **Ambiente de Pruebas**: Utiliza `Config::ENV_DEV` para desarrollo y pruebas. Los documentos generados en este ambiente llevarán el texto "DE generado en ambiente de prueba - sin valor comercial ni fiscal".

3. **Credenciales del SIFEN**: El ID CSC y CSC te serán proporcionados por la DNIT durante el proceso de habilitación.

4. **Límites de Lotes**: Cada lote puede contener un máximo de 50 documentos electrónicos, todos del mismo tipo y del mismo RUC emisor y sin CDC repetidos. `EnviarLoteDE` lo valida antes de enviar.

5. **Firma Digital**: La biblioteca requiere que el certificado y la clave privada estén disponibles localmente.

6. **Monedas con nombre largo**: 15 monedas del catálogo ISO 4217 (ANG, BMD, FKP, KYD, MXV, SBD, TMT, TTD, UYI, XCD, XBA, XBB, XBC, XTS y XXX) tienen un nombre de más de 20 caracteres, el máximo que admite el XSD para la descripción de la moneda. La librería la recorta a 20, pero el SIFEN rechaza esa descripción con el código 1206 (verificado en `sifen-test` con ANG el 11/10/2026). No hay una descripción conocida que el SIFEN acepte para estas monedas: por ahora no se pueden usar en un DE.

7. **Información adicional del emisor (`dInfAdic`, J003)**: aunque el XSD la admite, el SIFEN rechaza el DE con 2503
   si va informada (verificado en `sifen-test` el 13/10/2026). No pasar el tercer parámetro de `FirmarDE()`; el
   validador de reglas lo marca como error.

8. **Cilindrada del vehículo nuevo (`dCilin`, E786)**: el XSD de producción declara el patrón `/d` y el SIFEN lo aplica
   tal cual, así que rechaza cualquier valor numérico con 0160 (verificado el 13/10/2026). No usar `setDCilin()`; el
   validador de reglas y `ValidarXSD()` lo señalan.

## 🧪 Pruebas

Verificaciones offline (no requieren certificado ni conexión al SIFEN):

```bash
composer install
php test/SmokeTest.php      # smoke test rápido
composer test               # PHPUnit (tests/Unit/)
composer phpstan            # análisis estático nivel 1
```

Los tests de `tests/Unit/Conformidad/` construyen documentos y eventos con los builders, los firman con un
certificado autofirmado y los validan contra los **XSD de producción del SIFEN** incluidos en
`src/Resources/xsd/` (sin red). Es la referencia más fiel disponible sin homologar.

El CI en GitHub ejecuta lint (`php -l`), smoke test, PHPUnit y PHPStan en PHP 8.1, 8.2 y 8.3.

Detalle del flujo de contribución, estilo y convención de commits: [CONTRIBUTING.md](CONTRIBUTING.md).

## 🤝 Contribución

Las contribuciones son bienvenidas. Leé [CONTRIBUTING.md](CONTRIBUTING.md) antes de abrir un PR.

Mantenedores: publicación en Packagist → [docs/PUBLICAR.md](docs/PUBLICAR.md).

## 📝 Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## 👥 Autores

- **Abilio Mancuello Petters** - [abiliomp@ionys.com.py](mailto:abiliomp@ionys.com.py)
- **Gabriel Gauto** - [ggauto@ionys.com.py](mailto:ggauto@ionys.com.py)

---

## 🔗 Enlaces Útiles

- [Documentos técnicos para desarrollo del software](https://www.dnit.gov.py/web/e-kuatia/documentacion-tecnica)
- [Portal del Contribuyente DNIT - Marangatu](https://marangatu.set.gov.py/)
- [Documentación del SIFEN](https://www.dnit.gov.py/web/e-kuatia)

---

**Desarrollado especialmente para la comunidad de desarrolladores paraguayos**

