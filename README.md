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
$config->csc = "ABCD0000000000000000000000000000"; // CSC de 32 caracteres

// Ruta para almacenar el archivo de control del dId (opcional)
$config->dIdFilePath = "PKuatiaDId.dat.json";

// Inicializar Sifen
Sifen::Init($config);
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
    "wsdlCacheEnabled": true
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
- Para la consulta de resultado de lote (`ConsultaLote`), implementar reintentos con espera
  progresiva (backoff): esperar ~1 minuto en el primer intento y aumentar gradualmente.

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

### Consultar un Documento Electrónico

```php
// CDC de 44 dígitos del DE ya autorizado
$cdc = '01800000005001001000000122026010100000000000001'; // placeholder
$respuesta = Sifen::ConsultarDE($cdc);

echo $respuesta->getDMsgRes();
```

## 🎯 Funcionalidades

| Área | Métodos principales |
|------|---------------------|
| Consultas | `ConsultarRUC`, `ConsultarDE`, `ConsultaLote`, `ConsultarArchivoRUC` |
| Emisión | `FirmarDE`, `EnviarDE`, `EnviarLoteDE` |
| Eventos emisor | `CancelarDE`, `InutilizarNumeros` |
| Eventos receptor | `ConformarDE`, `DisconformarDE`, `DesconocerDE`, `NotificarRecepcionDE`, `NominarFE` |
| Builders | `Factura`, `NotaDeCredito`, `NotaDeDebito`, `NotaDeRemision`, `Autofactura` |

Los ejemplos completos de **FE contado** y **cancelación** están en [Ejemplos](#-ejemplos). Otros
tipos de documento y eventos se documentarán en una siguiente iteración.

## 📄 Tipos de Documentos Soportados

La biblioteca soporta los siguientes tipos de Documentos Tributarios Electrónicos, que son los que
el XSD de producción del SIFEN acepta actualmente (`iTiDE`):

| Código | Tipo de Documento | Builder | Estado |
|--------|-------------------|---------|--------|
| 1 | Factura Electrónica | `Factura` | ✅ Soportado (homologado contra SIFEN) |
| 4 | Autofactura Electrónica | `Autofactura` | ✅ Soportado |
| 5 | Nota de Crédito Electrónica | `NotaDeCredito` | ✅ Soportado |
| 6 | Nota de Débito Electrónica | `NotaDeDebito` | ✅ Soportado |
| 7 | Nota de Remisión Electrónica | `NotaDeRemision` | ✅ Soportado |
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

4. **Límites de Lotes**: Cada lote puede contener un máximo de 50 documentos electrónicos.

5. **Firma Digital**: La biblioteca requiere que el certificado y la clave privada estén disponibles localmente.

## 🧪 Pruebas

Verificaciones offline (no requieren certificado ni conexión al SIFEN):

```bash
composer install
php test/SmokeTest.php      # smoke test rápido
composer test               # PHPUnit (tests/Unit/)
composer phpstan            # análisis estático nivel 1
```

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

