# Changelog

Todos los cambios notables de PKuatia se documentan en este archivo.

El formato sigue [Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/)
y el proyecto se adhiere (en lo posible) a [Versionado Semántico](https://semver.org/lang/es/).

## [No publicado] — rama `dev`

Ronda de correcciones de conformidad SIFEN v150 y ampliación de la API. **Para el uso
habitual de la librería no se requiere ningún cambio en los sistemas consumidores**: todas
las firmas públicas se mantienen o se ampliaron de forma compatible. Ver
[Compatibilidad](#compatibilidad-con-versiones-en-main) para los detalles a tener en cuenta.

### Agregado

- **WS de consulta masiva de RUC (siConsArchivoRUC, NT-011).** Nuevo método de facade
  `Sifen::ConsultarArchivoRUC(string $rucFacturador): RResEnviConsArchivoRUC`, con sus
  clases `REnviConsArchivoRUC` (request) y `RResEnviConsArchivoRUC` (response, con helper
  `getArchivoZip()` que decodifica el Base64). _Nota: la ruta del WS devuelve vacío en el
  ambiente de pruebas; pendiente de confirmación contra producción._
- **Wrappers de eventos del receptor y de nominación/transporte** en el facade `Sifen`:
  - `NotificarRecepcionDE(...)` — evento de notificación de recepción (GEN001).
  - `ConformarDE(string $cdc, int $tipoConformidad = 1, ?DateTime $fechaRecepcion = null)` — conformidad (GCO001).
  - `DisconformarDE(string $cdc, string $motivo)` — disconformidad (GDI001).
  - `DesconocerDE(...)` — desconocimiento (GED001).
  - `NominarFE(RGEveNom $datosNominacion)` — nominación de FE innominada (GENFE001, NT-014).
  - `ActualizarDatosTransporte(RGeVeTr $datosTransporte)` — actualización de transporte de NRE (GET001).
- **Obligaciones afectadas (gOblAfe, D030, NT-018).** Integración del grupo en
  `GOpeCom` (`setGOblAfe`, `addGOblAfe`, `getGOblAfe`, máximo 12 ocurrencias) y nuevo método
  de builder `DocumentoElectronicoComercial::addObligacionAfectada(int|COblAfe|GOblAfe)` para
  la imputación automática al módulo RG90 (Marangatu).
- **Validación de la NT-024** en `Sifen::FirmarDE`: rechaza receptores innominados (D208 = 5)
  cuando el total general de la operación en guaraníes es ≥ 7.000.000 (excepto muestras médicas),
  evitando un rechazo seguro del SIFEN (validación 1321).
- **Caché de WSDL configurable.** `Config::$wsdlCacheEnabled` (y `setWsdlCacheEnabled()`),
  por defecto `false`. Al activarla se usa `WSDL_CACHE_DISK` para mitigar bloqueos por
  saturación del WS.
- Soporte de certificados **PKCS#12 (`p12`/`pfx`)** y de **PEM combinado** (certificado y
  clave en un mismo archivo), con los helpers `Config::isPem()`, `Config::isPkcs12()`,
  `Config::usesCombinedCertificateFile()` y la clase `PemHelper`.
- **Mensaje accionable ante certificados PKCS#12 con cifrado heredado.** Nueva clase
  `Pkcs12Helper`: cuando el `.p12`/`.pfx` usa algoritmos legacy (RC2-40/3DES) que OpenSSL 3
  deshabilita —caso habitual en las CA de Paraguay—, la librería ya no falla con el críptico
  `digital envelope routines::unsupported`, sino con una excepción que explica la causa y las
  soluciones (habilitar el proveedor `legacy`, reexportar el `.p12`, o convertir a PEM). También
  distingue el caso de contraseña incorrecta (`mac verify failure`).
- **Sección "Recomendaciones para producción" en el README**: caché de WSDL, manejo del rate
  limiting del SIFEN y el problema de los `.p12` con cifrado heredado.

### Corregido

- **Patrón de bug enum → string.** Varios setters duales `int|Enum` asignaban el objeto enum
  a la propiedad de descripción (de tipo `string`), lo que provocaba un `TypeError` fatal al
  llamarlos con un enum. Corregido en `GCamFE::setIIndPres`, `GDatRec::setITipIDRec`,
  `GRespDE::setITipIDRespDE` y `RGEveNom::setITipIDRec` (ahora asignan `->getDescription()`).
  _Las llamadas con `int` no cambian su salida._
- **`DE::setDSisFact`** ya no referencia una constante inexistente
  (`Constants::SISTEMA_FACTURACION_CONTRIBUYENTE`) que producía un error fatal; ahora valida
  contra el enum `DESisFact` (único valor admitido: 1, según NT-010).
- **`GOblAfe`**: `setCOblAfe` ya no asignaba el enum a la descripción; `FromSifenResponseObject`
  ya no invertía los campos `cOblAfe`/`dDesOblAfe`. Las descripciones de `COblAfe` ahora son
  los literales oficiales de la Tabla 12 (NT-018), requeridos por la validación 1221.
- **`RGEveNom::toDOMElement`**: emite el atributo `Id` (mayúscula) y respeta el orden de campos
  del XSD `Evento_v150` (`iTipIDRec` → `dDTipIDRec` → `dNumIDRec`), con guardas `isset` para los
  campos opcionales. Se corrigió además el parseo de `cDisRec` (antes se mapeaba a `cCiuRec`).
- **Envío de lote (`Sifen::EnviarLoteDE`)**: el ZIP se genera en un archivo temporal del sistema
  (antes `rLoteDE.zip` en el directorio de trabajo, con riesgo de concurrencia/permisos) y se
  valida que el lote no esté vacío y que todos los DE sean del mismo tipo (C002).
- **`Sifen::GetDId`** usa bloqueo de archivo (`flock`) para evitar identificadores duplicados
  ante accesos concurrentes. El formato del archivo JSON no cambia.
- Eliminada la escritura de depuración `rEnviEventoDe.xml` en `Sifen::RegistrarEvento`.
- **`OpeComTipImp::IVARenta`** corrige el literal `dDesTImp` (D014) de `'IVA – Renta'` (guion
  largo Unicode, rechazado por el XSD) a `'IVA - Renta'` (guion ASCII).

### Cambiado

- **Rutas WSDL**: verificadas empíricamente contra `sifen-test` (jun/2026). Se mantienen las
  rutas históricas (`recibe.wsdl`, `recibe-lote.wsdl`, `evento.wsdl`, `consulta-lote.wsdl`),
  ya que las "nuevas" publicadas en el MT (`recepcion.wsdl`, etc.) **no existen** en el servidor.
- `Config::certificateFormat` ahora se **normaliza** internamente: los valores de entrada
  `"p12"` y `"pfx"` se almacenan como `"pkcs12"` (ver [Compatibilidad](#compatibilidad-con-versiones-en-main)).
- `Config::$certificateFilePath` es opcional (`null` por defecto) cuando el certificado está
  embebido (PKCS#12 o PEM combinado).
- Nuevas validaciones que lanzan excepción **antes** de transmitir, en casos que el SIFEN ya
  rechazaba: innominado ≥ 7M (NT-024), lote con tipos C002 mixtos o vacío, y más de 15 eventos
  por transmisión.
- **Requisito de PHP elevado a `^8.1`** en `composer.json` (la librería usa enumeraciones y
  `new` en inicializadores, propios de PHP 8.1; se excluye PHP 9 hasta auditar compatibilidad).
  Se declaran explícitamente las extensiones requeridas: `ext-soap`, `ext-dom`, `ext-openssl`,
  `ext-zip`, `ext-bcmath`.
- **Seguridad: piso de `robrichards/xmlseclibs` elevado a `^3.1.5`**, que corrige
  [GHSA-4v26-v6cg-g6f9](https://github.com/robrichards/xmlseclibs/security/advisories/GHSA-4v26-v6cg-g6f9)
  (severidad alta: falta de validación del authentication tag AES-GCM en el descifrado, `< 3.1.5`).
  PKuatia solo usa la firma (no el descifrado AES-GCM), por lo que el impacto directo era bajo,
  pero el piso garantiza la versión parcheada a todos los consumidores. Firmas verificadas
  sin cambios con 3.1.5.
- `Constants::PKUATIA_VERSION` actualizado a `0.1.0`.

### Eliminado

- **Archivos de builder vacíos** `FacturaDeExportacion.php`, `FacturaDeImportacion.php` y
  `ComprobanteDeRetencion.php` (0 líneas, no definían ninguna clase: imposible que algún código
  los usara). Los tipos 2, 3 y 8 figuran en el MT pero el XSD de producción del SIFEN los rechaza.
  La enumeración `TimbTiDE` los conserva para deserialización. El README ahora documenta con
  precisión qué tipos se soportan (1, 4, 5, 6, 7), cuáles están en el roadmap (boletas 9 y 10) y
  cuáles no están habilitados por la DNIT (2, 3, 8).

### Compatibilidad con versiones en `main`

Esta entrega es **compatible hacia atrás para el uso habitual**. No se removió ni se cambió la
firma de ningún método público del facade ni de las clases de campos. Puntos a tener en cuenta:

1. **`Config::certificateFormat` se normaliza a `"pkcs12"`.** Si algún sistema **lee** esa
   propiedad y la compara con `'p12'`/`'pfx'` en su propio código, debe contemplar también el
   valor `'pkcs12'` (o usar los helpers `Config::isPkcs12()` / `Config::isPem()`). Configurar
   `"p12"` o `"pfx"` como entrada sigue funcionando igual.
2. **Literal `'IVA - Renta'`.** Los DE con impuesto afectado tipo 5 ahora generan el guion ASCII.
   Es un fix de conformidad (el valor anterior era rechazado por el XSD); solo impacta a pruebas
   que asserten el string anterior.
3. **Setters con argumento enum.** Si se los invocaba con un objeto enum, antes fallaban con
   `TypeError`; ahora funcionan. Las llamadas con `int` producen exactamente la misma salida.
4. **Validaciones tempranas.** `FirmarDE` (NT-024), `EnviarLoteDE` (tipo C002/lote vacío) y
   `RegistrarEvento` (>15 eventos) pueden lanzar una excepción en escenarios que el SIFEN ya
   rechazaba; conviene capturarla como cualquier otra excepción de la librería.
5. **`SignHelper::$xmlSigner` ya no participa en la firma.** La propiedad pública se conserva y se
   sigue poblando en `Init`, pero cada firma usa una instancia fresca interna (fix del sobrefirmado).
   El camino documentado (`Sifen::Init` + `FirmarDE`/`RegistrarEvento`) no cambia en absoluto; solo
   un hipotético código que poblara `SignHelper::$xmlSigner`/`$xmlKey` a mano sin llamar a `Init`
   debe pasar a llamar a `SignHelper::Init`.

### Homologación (jun/2026)

- ✅ **`ConsultarRUC`** verificado contra **producción** y contra `sifen-test`.
- ✅ **Emisión de Factura Electrónica (`EnviarDE`) end-to-end contra `sifen-test`: APROBADA**
  (con número de protocolo de autorización). El DE incluía el grupo `gOblAfe` (NT-018), que el
  SIFEN **aceptó** (validación 1221), confirmando la integración y los literales de la Tabla 12.
- ✅ **`ConsultarDE`** del DE emitido: devuelve el documento completo y autorizado.
- ✅ **`CancelarDE`** (evento del emisor): **APROBADO** (`dCodRes 0600`, evento registrado). El
  `0100` observado en la primera prueba fue transitorio (ambiente degradado); el XML del evento es
  conforme (comparado con la implementación de referencia Java).
- ✅ **Envío en lote (`EnviarLoteDE` + `ConsultaLote`) end-to-end: AMBOS DE APROBADOS.** Valida que
  el `xDE` se transmite como binario crudo (SoapClient aplica el Base64). Destapó y corrigió el bug
  de sobrefirmado (ver más abajo).
- ✅ **Evento del receptor (`ConformarDE`)**: pipeline validado end-to-end; el SIFEN lo procesa y
  responde con `dCodRes 0143` (la firma debe corresponder al receptor), esperado porque el harness
  firma con el certificado del emisor. Funcional con el certificado del receptor.
- ⏳ **`siConsArchivoRUC`**: no se pudo homologar. El WSDL no carga ni en `sifen-test` (cuerpo vacío)
  ni en **producción** (`failed to load external entity`, consistente). Probablemente requiere un RUC
  habilitado como facturador electrónico (el de prueba tiene `dRUCFactElec = N`) y/o una ruta no
  confirmada públicamente. El método queda implementado según NT-011 (`rEnviConsArchivoRUC`),
  pendiente de verificación con un certificado de facturador electrónico habilitado.

### Corregido (post-homologación)

- **Sobrefirmado al firmar varios documentos en un mismo proceso.** `SignHelper` reutilizaba la
  instancia estática `XMLSecurityDSig`, que acumula referencias y estado: la firma del segundo DE
  (o evento) en adelante salía malformada y el SIFEN la rechazaba con `0160` ("XML malformado: El
  elemento esperado es KeyInfo en lugar de SignatureValue"). **Esto rompía todo envío en lote de 2+
  DE.** Ahora cada firma usa un firmador fresco. Verificado con un lote de 2 FE aprobado.
- **`GPaConEIni::setDDesTiPag` / `setDDMoneTiPag`**: usaban variable-variable (`$this->$prop`)
  por un `$` de más, creando propiedades dinámicas basura en vez de asignar `dDesTiPag` /
  `dDMoneTiPag` (deprecación en PHP 8.2, error en PHP 9). Detectado al deserializar un DE.
- **`GResProcEVe::FromSimpleXMLElement`**: eliminado un `echo` de depuración y completado el
  manejo del caso en que `gResProc` es un arreglo.
