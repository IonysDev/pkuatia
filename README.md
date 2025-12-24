# 📄 PKuatia

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.1.3%20%7C%7C%20%5E8.0-blue.svg)](https://www.php.net/)

**PKuatia** es una biblioteca PHP para interactuar con el **Sistema Integrado de Facturación Electrónica Nacional (SIFEN)** de Paraguay, implementando la especificación técnica del sistema **EKuatia**.

Esta biblioteca permite generar, firmar, enviar y consultar Documentos Tributarios Electrónicos (DTE) según el Manual Técnico Versión 150 del SIFEN.

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso Básico](#-uso-básico)
- [Funcionalidades](#-funcionalidades)
- [Tipos de Documentos Soportados](#-tipos-de-documentos-soportados)
- [Ejemplos](#-ejemplos)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Contribución](#-contribución)
- [Licencia](#-licencia)
- [Autores](#-autores)

## ✨ Características

- 🔐 **Firma digital de documentos** usando certificados PEM o P12
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

- PHP >= 7.1.3 o PHP >= 8.0
- Composer
- Certificado digital emitido por la SET (Subsecretaría de Estado de Tributación)
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

// Formato del certificado (pem o p12)
$config->certificateFormat = "pem"; // o "p12"

// Rutas de los archivos de certificado y clave privada
$config->certificateFilePath = "/ruta/a/tu/certificado.crt";
$config->privateKeyFilePath = "/ruta/a/tu/clave_privada.key";
$config->privateKeyPassphrase = "tu_contraseña";

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
    "certificateFilePath": "/ruta/a/certificado.crt",
    "privateKeyFilePath": "/ruta/a/clave_privada.key",
    "privateKeyPassphrase": "contraseña",
    "idCsc": "0001",
    "csc": "ABCD0000000000000000000000000000",
    "dIdFilePath": "PKuatiaDId.dat.json"
}
```

## 📖 Uso Básico

### Consultar un RUC

```php
use IonysDev\Pkuatia\Sifen;

// Consultar información de un contribuyente por su RUC
$respuesta = Sifen::ConsultarRUC("80012345-7");

if ($respuesta->getCodRes() == 0100) {
    echo "RUC encontrado: " . $respuesta->getDRucEm();
} else {
    echo "Error: " . $respuesta->getDsRes();
}
```

### Consultar un Documento Electrónico

```php
// Consultar un DE por su CDC (Código de Control)
$cdc = "01800123445001123456701234567890123456789012345678";
$respuesta = Sifen::ConsultarDE($cdc);

if ($respuesta->getCodRes() == 0100) {
    echo "Documento encontrado";
    $respuesta->showData(); // Mostrar información del documento
}
```

## 🎯 Funcionalidades

### 1. Crear y Firmar un Documento Electrónico

```php
use IonysDev\Pkuatia\Core\Fields\DE\AA\RDE;
use IonysDev\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use IonysDev\Pkuatia\Sifen;
use DateTime;

// Crear un nuevo documento electrónico (RDE)
$rde = new RDE();

// Configurar el documento electrónico según tus necesidades
$de = new DocumentoElectronico();
// ... configurar campos del DE ...

$rde->setDE($de);

// Firmar el documento
$fechaFirma = new DateTime('now', new DateTimeZone('America/Asuncion'));
$xmlFirmado = Sifen::FirmarDE($rde, $fechaFirma);

// El XML está listo para ser enviado al SIFEN
```

### 2. Enviar un Documento Electrónico

```php
// Enviar el documento firmado al SIFEN
$respuesta = Sifen::EnviarDE($xmlFirmado);

if ($respuesta->getCodRes() == 0100) {
    $cdc = $respuesta->getCDC();
    echo "Documento enviado exitosamente. CDC: " . $cdc;
} else {
    echo "Error al enviar: " . $respuesta->getDsRes();
}
```

### 3. Enviar un Lote de Documentos

```php
// Preparar el lote de documentos (máximo 50 documentos)
$lote = [
    $xmlFirmado1,
    $xmlFirmado2,
    // ... más documentos
];

// Enviar el lote
$respuesta = Sifen::EnviarLoteDE($lote);

if ($respuesta->getCodRes() == 0100) {
    $nroLote = $respuesta->getNroLote();
    echo "Lote enviado. Número de lote: " . $nroLote;
}
```

### 4. Consultar un Lote

```php
// Consultar el estado de un lote por su número
$nroLote = 123456;
$respuesta = Sifen::ConsultaLote($nroLote);
```

### 5. Cancelar un Documento Electrónico

```php
// Cancelar un documento por su CDC
$cdc = "01800123445001123456701234567890123456789012345678";
$motivo = "Error en la información del documento";

$respuesta = Sifen::CancelarDE($cdc, $motivo);

if ($respuesta->getCodRes() == 0100) {
    echo "Documento cancelado exitosamente";
}
```

### 6. Inutilizar Números de Documentos

```php
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;

// Inutilizar un rango de números de documentos
$respuesta = Sifen::InutilizarNumeros(
    timbrado: 123456,
    nroEstablecimiento: 1,
    nroPuntoEmision: 1,
    nroDocumentoInicial: 1,
    nroDocumentoFinal: 100,
    tipoDE: TimbTiDE::Factura,
    motivo: "Documentos dañados o perdidos"
);
```

## 📄 Tipos de Documentos Soportados

La biblioteca soporta los siguientes tipos de Documentos Tributarios Electrónicos según el Manual Técnico v150:

| Código | Tipo de Documento |
|--------|-------------------|
| 1 | Factura Electrónica |
| 2 | Factura Electrónica de Exportación |
| 3 | Factura Electrónica de Importación |
| 4 | Autofactura Electrónica |
| 5 | Nota de Crédito Electrónica |
| 6 | Nota de Débito Electrónica |
| 7 | Nota de Remisión Electrónica |
| 8 | Comprobante de Retención Electrónico |

Puedes usar la enumeración `TimbTiDE` para referenciar estos tipos:

```php
use IonysDev\Pkuatia\Core\Constants\TimbTiDE;

TimbTiDE::Factura->value; // 1
TimbTiDE::NotaDeCredito->value; // 5
```

## 📁 Estructura del Proyecto

```
pkuatia/
├── src/
│   ├── Core/                  # Clases principales
│   │   ├── Config.php        # Configuración del sistema
│   │   ├── Constants/        # Constantes y enumeraciones
│   │   ├── DocumentosElectronicos/  # Clases de documentos
│   │   ├── Fields/           # Campos del DE
│   │   ├── Requests/         # Peticiones al SIFEN
│   │   └── Responses/        # Respuestas del SIFEN
│   ├── DataMappings/         # Mapeos de datos (países, monedas, etc.)
│   ├── Helpers/              # Utilidades auxiliares
│   │   ├── QRHelper.php     # Generación de códigos QR
│   │   ├── SignHelper.php   # Firma digital
│   │   └── ...
│   ├── Utils/                # Utilidades generales
│   └── Sifen.php            # Clase principal
├── test/                     # Ejemplos y pruebas
├── documentation/            # Documentación técnica
└── composer.json
```

## 🔧 Dependencias

- **robrichards/xmlseclibs** (^3.1): Para la firma digital XML
- **krowinski/bcmath-extended** (^7.0): Para operaciones matemáticas de precisión extendida

## 📚 Ejemplos

Puedes encontrar ejemplos de uso en el directorio `test/`:

- `ConsultaDE.php` - Consulta de documentos electrónicos
- `ConsultaLote.php` - Consulta de lotes
- `ConsultaRUC.php` - Consulta de RUC

## ⚠️ Notas Importantes

1. **Certificados Digitales**: Debes contar con un certificado digital válido emitido por la SET de Paraguay.

2. **Ambiente de Pruebas**: Utiliza `Config::ENV_DEV` para desarrollo y pruebas. Los documentos generados en este ambiente llevarán el texto "DE generado en ambiente de prueba - sin valor comercial ni fiscal".

3. **Credenciales del SIFEN**: El ID CSC y CSC te serán proporcionados por el SIFEN durante el proceso de habilitación.

4. **Límites de Lotes**: Cada lote puede contener un máximo de 50 documentos electrónicos.

5. **Firma Digital**: La biblioteca requiere que el certificado y la clave privada estén disponibles localmente.

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## 👥 Autores

- **Abilio Mancuello Petters** - [abiliomp@ionys.com.py](mailto:abiliomp@ionys.com.py)
- **Gabriel Gauto** - [ggauto@ionys.com.py](mailto:ggauto@ionys.com.py)

---

## 🔗 Enlaces Útiles

- [Manual Técnico SIFEN v150](https://www.set.gov.py/)
- [Portal del Contribuyente SET](https://www.set.gov.py/)
- [Documentación del SIFEN](https://ekuatia.set.gov.py/)

---

**Desarrollado especialmente para la comunidad de desarrolladores paraguayos**

