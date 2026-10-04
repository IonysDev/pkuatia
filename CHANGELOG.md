# Changelog

Todos los cambios notables de PKuatia se documentan en este archivo.

El formato sigue [Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/)
y el proyecto se adhiere (en lo posible) a [Versionado Semántico](https://semver.org/lang/es/).

## [0.2.0] — No publicado (rama `fase-a/p0-emision`)

Fase A del roadmap de la evaluación del 02/10/2026 (`docs/evaluacion-2026-10-02/`): correcciones
P0 de emisión (PK-01 a PK-24). **Compatible hacia atrás**: ninguna firma pública se elimina ni
cambia; solo se agregan métodos, parámetros opcionales al final, recursos y pruebas, y se corrige
comportamiento que producía XML inválido o datos erróneos.

### Agregado

- **XSD de producción del SIFEN empaquetados en `src/Resources/xsd/`** (11 archivos, 366 KB):
  copias de `ekuat-ia/04-schemas-xsd/validacion-local/` con `schemaLocation` relativos (validan
  sin red) y el único fix `dEntCont ` → `dEntCont` (error del XSD oficial, `DE_v150.xsd:327`).
  Ver `src/Resources/xsd/README.md`. Base de la validación XSD en las pruebas y de la futura
  `Sifen::ValidarXSD` (Fase C).
- Soporte de pruebas: `tests/Support/SifenTestEnvironment` (certificado autofirmado, ambiente
  `dev`, CSC genérico, `dId` temporal, factoría SOAP que impide llegar a la red),
  `tests/Support/XsdAssertions` (`assertRdeValido`, `assertEventoValido`, `assertRdeInvalidoPor`,
  errores de libxml legibles) y `tests/Support/DocumentoFactory` (documentos completos con datos
  ficticios RUC 80000000-5, timbrado 12345678).
- `tests/Unit/Resources/XsdResourcesTest`: los 11 XSD existen y están bien formados, los includes
  son relativos y el fix está aplicado, las copias coinciden con ekuat-ia (normalizando fin de
  línea; se omite si `docs/sifen-ai` no está disponible, p. ej. en CI), la cadena de includes
  compila y una FE firmada de referencia valida.

### Corregido

- **PK-01 — Escape de caracteres especiales en los textos del XML.** Las 485 construcciones de nodo
  con valor (`new DOMElement($nombre, $valor)` y `createElement($nombre, $valor)`) no escapaban el
  contenido: un `&` en la razón social, la dirección, la información adicional, el motivo de un
  evento, etc. producía el warning `unterminated entity reference` y el elemento salía **vacío**
  (`<dNomEmi/>`), con rechazo del SIFEN en los campos obligatorios y pérdida silenciosa de datos en
  los opcionales. Solo `dNomRec`, `dDTipIDRec` y `dDesProSer` estaban protegidos. Ahora todos los
  textos se emiten como nodos de texto mediante el nuevo helper `Helpers\XmlHelper::elemento()`
  (`&` → `&amp;`, `<` → `&lt;`), que al leerse devuelven exactamente el valor original. La salida
  para valores sin caracteres especiales es byte a byte idéntica a la anterior (verificado con
  FE, FE en cuotas, NC, sobre de eventos y rDE mínimo con semilla fija).
  Tests: `tests/Unit/Helpers/XmlHelperTest`, `tests/Unit/Conformidad/EscapeXmlTest` (FE y evento
  con `&` y `<` válidos contra el XSD y round-trip íntegro).
- **PK-16 — Validador de cadenas decimales (`Utils\ValueValidations::isValidStringDecimal`).** La
  expresión regular `(\.{min,max})` contaba puntos en lugar de decimales: aceptaba `'1000'` con
  parte entera de 3 dígitos y `'12345678901'` con 15, y rechazaba `'100.50'` cuando se exigían 2
  decimales. Además devolvía el entero de `preg_match`, por lo que las comparaciones `=== false`
  de `Factura::setOperacionCreditoEnCuotas` y `Autofactura::setOperacionCreditoEnCuotas` nunca se
  cumplían. Ahora valida la parte entera y los decimales como las facetas del XSD y devuelve
  `bool`. Los 21 setters que lo usan sin máximo de decimales pasan a los límites de su tipo XSD
  (`DE_Types_v150.xsd`): `tMontoBase` 15/8 (`gValorItem`, `gValorRestaItem`, `gCamIVA`),
  `tMontoBase4` 15/4 (`dMonCuota`), `tdCRed` 4/4 (`dRedon`, antes 3 enteros sin tope de
  decimales), `tPorcDesc8` 3/8 (`dPorcDesIt`, `dPorQuiMer`), `tTipoCambioBase` 5/4 (`dTiCam`,
  `dTiCamIt`), `tdCantProSer` 10/8 (`dCantProSer`), `dCanQuiMer` 10/4 y `tLectura` 11/2
  (sector energía). _Solo cambia el resultado para valores que el XSD ya rechazaba_ (más decimales
  o más enteros de los permitidos); los montos que genera `calcTotSub` (escala 8) siguen válidos.
  Tests: `tests/Unit/Utils/ValueValidationsTest` (23 casos de borde).
- **PK-02 — Autofactura con varios ítems: total de la operación (F008) incorrecto.** `calcTotSub`
  calculaba `dTotOpe` fuera del bucle de ítems y tomaba solo el último (100.000 + 50.000 daba
  50.000). Ahora suma `dTotOpeItem` de todos los ítems (validaciones 2362/2365). Test:
  `tests/Unit/Conformidad/AutofacturaTest`.
- **PK-03 — Literal de la constancia de no contribuyente.** `TipDocAso::ConstanciaElectronica`
  describía `Constancia electrónica`; el XSD de producción exige **`Constancia Electrónica`**
  (`DE_Types_v150.xsd:1831-1842`, `tdDesTipDocAso`). Como la constancia (H002 = 3) es obligatoria en
  la Autofactura, **toda AF era rechazada por esquema**; también afectaba a las FE que referencian
  una constancia. Fix de conformidad (mismo criterio que `'IVA - Renta'`).
- **PK-10 — QR de documentos sin IVA.** `QRHelper` concatenaba `dTotIVA=` vacío cuando el DE no
  tiene IVA (Autofactura); la NT-010 exige `0`. Ahora el parámetro se informa como `dTotIVA=0`.
- **PK-04 — Factura o Autofactura a crédito en cuotas sin entrega inicial.** `GPagCred::getDCuotas()`
  devolvía `null` cuando no estaba informado `dMonEnt`, y el XML salía con `<dCuotas/>` vacío
  (rechazo de esquema, E643). Ahora devuelve la cantidad de cuotas siempre que esté establecida.
  Test: `tests/Unit/Conformidad/FacturaCreditoCuotasTest`.
- **PK-05 — Unidades de medida de la NT-023 (códigos 111 a 140).** La copia empaquetada de
  `Unidades_Medida_v141.xsd` era anterior a la NT-023 y `UnidadMedidaMapping::GetDesc` recortaba la
  documentación en el último guion, produciendo literales inválidos (`'vinas'`, `'rrie'`, `'llar'`).
  Ahora la copia es la de producción (idéntica a `src/Resources/xsd/`, verificado por test) y el
  literal de E710 es la abreviatura que exige `tdDesUniMed` (`4A`, `Ci`, `DOC`, …). `GetDesc()` pasa
  a devolver `?String` y `GCamItem::setCUniMed()` lanza `InvalidArgumentException` con un mensaje
  claro ante un código inexistente (antes `TypeError`). El catálogo se parsea una sola vez por
  proceso (caché estática). Test: `tests/Unit/Conformidad/CatalogosYEnumsTest`.
- **PK-23 — Monedas con nombre de más de 20 caracteres.** `tdDMoneTiPag` (D016, E609, E651) admite
  3 a 20 caracteres y 15 monedas del catálogo (ANG, BMD, FKP, KYD, MXV, SBD, TMT, TTD, UYI, XCD,
  XBA, XBB, XBC, XTS, XXX) tienen un `CodeName` más largo: `MonedaMapping::GetDescription()`
  recorta a 20 (`MAX_LONGITUD_DESCRIPCION`) y el nombre completo queda en el nuevo
  `GetCodeName()`. Qué literal acepta la validación de fondo 1206 para esas monedas:
  `[PENDIENTE DE VERIFICACIÓN]`. También devuelve `?String` y usa caché estática.
- **PK-18 — Enumeraciones frente al XSD.** `MotEmiNR` 9 = `Traslado de bienes para reparación` y
  11 = `Exhibición o Demostración` (`DE_Types_v150.xsd:1953,1955`). `TimbTiDE` incorpora
  `BoletaDeVenta` (9) y `BoletaResimple` (10), que el XSD acepta (`tiTiDE` `1|[4-7]|9|10`); los
  builders de boletas quedan para una fase posterior. `TipoDocImpresoAso::ComprobanteRetencion` (5)
  no existe en el XSD (`tiTIpoDoc` 1-4): se conserva marcado `@deprecated` y
  `GCamDEAsoc::toDOMElement()` lo rechaza con un mensaje que indica las cuatro opciones válidas.
  Los códigos "Otro" exigen ahora el texto libre que pide el XSD y ya no se sobreescribe al fijar el
  código: `GCamFE` (E012, 10-30), `GRespDE` (D142, 9-41) y `GCamNRE` (E502, 5-60) lanzan
  `InvalidArgumentException` al serializar si falta o no cumple la longitud (antes emitían `Otro` y
  el SIFEN rechazaba por esquema).
- **PK-06 — Sector seguros.** `GCamEsp::toDOMElement` emitía `gGrupSup` donde correspondía `gGrupSeg`
  (typo) y en el orden incorrecto: toda FE del sector seguros fallaba con `Error: Typed property
  … $gGrupSup must not be accessed before initialization`. Ahora respeta la secuencia de `tgCamEsp`
  (`DE_v150.xsd:794-800`): `gGrupEner`, `gGrupSeg`, `gGrupSup`, `gGrupAdi`.
- **PK-07 — Datos adicionales de uso comercial (`gGrupAdi`).** Las fechas se formateaban con
  `'yyyy-mm-dd'` (producía `26262626-0202-1515`) y los siete campos opcionales se emitían sin
  comprobar si estaban informados. Ahora usa `Y-m-d` (`tFecAAAAMMDDguion`) y solo emite lo informado.
- **PK-08 — Opcionales emitidos sin guarda.** `gRasMerc` (trazabilidad: cualquier ítem con lote,
  serie o pedido abortaba con `Error`), `gGrupSup` (supermercados) y `gCamCarg` (carga) emitían
  campos `minOccurs="0"` sin verificar su presencia. `GRasMerc::$dNumLote` pasa de `int` a `String`
  (E751 es texto de 1 a 80: `'LOTE-2026-A'` era rechazado con `TypeError`) y `setDNumLote` acepta
  `int|String`.
- **PK-19 — Sector energía.** `GGrupEner::getDConKwh()` devolvía `dLecAct − dLecAct` (siempre 0) e
  ignoraba el consumo establecido.
  Test de los cuatro: `tests/Unit/Conformidad/GruposSectorialesTest` (energía, seguros,
  supermercados, adicionales y trazabilidad válidos contra el XSD).
- **PK-09 — Monto del pago (E608) truncado.** `GPaConEIni::toDOMElement` emitía `getDMonTiPag(): int`,
  que convertía `'1500.50'` en `1500` con una deprecación de PHP. Ahora emite el decimal tal como
  se estableció; nuevo `getDMonTiPagDecimal(): String` y `getDMonTiPag()` queda `@deprecated`.
  `dTiCamTiPag` (E611) solo se emite si fue informado (antes `Error` con moneda extranjera sin tasa
  en el objeto; la obligatoriedad la sigue exigiendo `Factura::addPago`). Test:
  `tests/Unit/Conformidad/PagosTest`.
- **PK-11 — Nota de Remisión: transportista y vehículo.** En el XSD de producción `dDomFisc` (E992,
  `DE_v150.xsd:973`), `dDirChof` (E993, `:986`) y `dNumIDChof` (E990, `:971`) son obligatorios en
  `gCamTrans`, aunque el MT v150 los listaba como opcionales: la librería los emitía solo si estaban
  informados y el SIFEN rechazaba la NR por esquema. Ahora `NotaDeRemision::validar()` los exige
  (junto con E981, E982, E991 y los condicionales E983-E984 / E985-E987 según la naturaleza del
  transportista) y `GCamTrans::toDOMElement()` lanza `InvalidArgumentException` con la lista de
  faltantes en lugar de emitir un XML inválido o un `Error` de propiedad sin inicializar.
  `cNacTrans`/`dDesNacTrans` (E988-E989, `minOccurs="0"`) se emiten solo si fueron informados.
  La firma de `setTransporteTransportista()` no cambia: `$domicilioFiscal` y `$direccionChofer`
  conservan su posición y su valor por defecto, y el docblock documenta la obligatoriedad real.
  `GVehTras`: no se podía identificar el vehículo por matrícula (E967 = 2) porque `dTiVehTras`
  (E961) se emitía solo si existía `dNroIDVeh`, y `dNroMatVeh` (E965) emitía el número de
  identificación en lugar de la matrícula. `getDAdicVeh()`, `getDNroMatVeh()` y `getDNroVuelo()`
  pasan a `?String` (ya devolvían `null`, lo que producía `TypeError`). `validar()` también revisa
  cada vehículo (E961, E962, E967 y el identificador que corresponda). Test:
  `tests/Unit/Conformidad/NotaRemisionTest`.
- **PK-17 — Receptor innominado con el builder.** `setReceptor()` rechazaba `'0'`, que es el valor
  que el MT exige en `dNumIDRec` (D210) para el receptor innominado (D208 = 5), porque la comprobación
  usaba la falsedad de PHP (`!'0'`). Ahora solo rechaza `null` y `''`, y el mensaje indica que para el
  innominado se informa `'0'`.
- **PK-20 — Totales y moneda extranjera.** `calcTotSub()` dividía por la suma de E721 al calcular
  F010 (`dPorcDescTotal`): con todos los ítems en 0 (donaciones, muestras sin cargo) terminaba en
  `DivisionByZeroError`; ahora F010 es 0 cuando no hay base. Con moneda distinta de PYG sin condición
  de tipo de cambio (D017) o sin tipo de cambio global (D018), `calcTotSub()` y
  `GOpeCom::toDOMElement()` terminaban en un `Error` de propiedad tipada sin inicializar; ahora
  `GOpeCom::validarTipoDeCambio()` (nuevo, público) lanza `InvalidArgumentException` con el campo
  faltante y el builder que lo informa (validaciones 1207 y 1209 del MT v150 §12.4; en el XSD ambos son
  `minOccurs="0"`, `DE_v150.xsd:210-213`, por lo que el esquema no lo detecta). Test:
  `tests/Unit/Conformidad/BuildersTest`.
- **PK-21 — `Sifen::FirmarDE()` ignoraba la información adicional del emisor.** El parámetro
  `$infoAdicionalEmisor` se asignaba a `gCamFuFD` después de serializarlo, así que J003 `dInfAdic`
  (1 a 5000 caracteres, `DE_v150.xsd:1922-1931`) nunca llegaba al XML. Ahora se establece antes y se
  emite, escapado, a continuación de `dCarQR`. Test: `tests/Unit/Sifen/FirmarDeTest`.
- **PK-22 — Fechas internas en la zona horaria del servidor.** La fecha de firma de los eventos
  (`dFecFirma`) y el "hoy" de `NotaDeRemision::setFechaFuturaEmisionFactura()` se generaban con la
  zona horaria por defecto de PHP; con el servidor en UTC la hora quedaba corrida respecto de la que
  compara el SIFEN. Nueva constante `Constants::SIFEN_TIMEZONE` (`America/Asuncion`): las fechas que la
  librería genera por su cuenta se calculan en ella y las que recibe del consumidor se respetan tal
  cual. Los wrappers de eventos (`CancelarDE`, `InutilizarNumeros`, `NotificarRecepcionDE`,
  `ConformarDE`, `DisconformarDE`, `DesconocerDE`, `NominarFE`, `ActualizarDatosTransporte`) aceptan
  un último parámetro opcional `?DateTime $fechaFirma = null` para fijar la fecha de firma. La
  comparación de la fecha futura de emisión (E506) pasa a hacerse por día calendario. Test:
  `tests/Unit/Sifen/EventosFacadeTest` (con un stub del cliente SOAP, sin red).
- **PK-12 — Desconocimiento (GED009).** `RGeVeDescon::toDOMElement` emitía el tipo de receptor
  (`iTipRec`) dentro de `dTipIDRec`; ahora emite el tipo de documento establecido.
- **PK-13 — Conformidad (GCO004).** `dFecRecep` se emitía como fecha (`Y-m-d`) y el XSD exige fecha y
  hora (`fecHhmmss`, `Evento_v150.xsd:76`).
- **PK-14 — Actualización de datos del transporte (`RGeVeTr`).** Las descripciones geográficas del
  local de entrega (GET005/007/009) se buscaban en el catálogo de países; ahora usan los mapeos de
  departamentos, distritos y ciudades, como el DE. La serialización accedía a propiedades sin
  inicializar según el motivo (`cDisEnt`, `iNatTrans`, `dTipIdenVeh`) y abortaba con `Error`; ahora
  emite cada campo solo si fue informado, en el orden de `trGeVeTr` (`Evento_v150.xsd:271-299`), y el
  nuevo `validar()` (público) exige los campos de cada motivo con un mensaje claro (incluida la
  matrícula de 6 caracteres exactos, `tdNroMatVeh`, `Evento_Types_v150.xsd:524-533`).
- **PK-15 — Enumeraciones de eventos.** `RGeVeDescon::setDTipIDRec` y `RGeVeNotRec::setDTipIDRec`
  aceptan solo 1 a 4 (`tiTipDoc`, `DE_Types_v150.xsd:645-653`): el innominado (5) y "Otro" (9) no
  existen en los eventos del receptor. `RGEveNom::setITiOpe` rechaza 3 (B2G): `tiTiOpeEv` admite 1, 2
  y 4 (`Evento_Types_v150.xsd:57-66`). Además `RGEveNom::setCPaisRec` deriva `dDesPaisRe` del
  catálogo (antes salía vacío y el XSD lo exige, `Evento_v150.xsd:394`) y `setITipIDRec` ya no pisa
  el texto libre de "Otro" (`tdDtipDocRec`, 9 a 41 caracteres).
- **PK-24 — Sobres con varios eventos.** `Sifen::RegistrarEvento` rechaza Ids de `rEve` repetidos
  (cada Id es la URI de su firma, `Evento_v150.xsd:487`) y `GGroupTiEvt::toDOMElement` exige
  exactamente un evento por `rEve` (`xs:choice`, `Evento_v150.xsd:363-380`).
- **PK-42 — Validaciones previas a la red en el facade.** `CancelarDE`, `DisconformarDE` y
  `DesconocerDE` verifican el motivo (5 a 500 caracteres, `tmotEve`, `Evento_Types_v150.xsd:86-95`) y,
  junto con `ConformarDE` y `NotificarRecepcionDE`, el formato del CDC (`tId`, 44 caracteres,
  `Evento_Types_v150.xsd:71-80`); `InutilizarNumeros` verifica el motivo. Antes el error llegaba del
  SIFEN como rechazo por esquema. Tests: `tests/Unit/Conformidad/EventosTest` (12 casos contra
  `siRecepEvento_v150.xsd`) y `tests/Unit/Sifen/EventosFacadeTest`.

## [0.1.5] — 2026-09-17

Redondeo explícito del total de la operación. **Compatible hacia atrás**: la firma de
`calcTotSub` solo se amplía con un parámetro opcional al final y las llamadas existentes producen
exactamente la misma salida.

### Agregado

- **`ItemValorado::calcTotSub()` acepta un redondeo explícito (F013).** Nuevo parámetro
  **opcional al final** `?String $redondeo = null`:
  `calcTotSub(int $precisionMoneda = 0, bool $redondeoSedeco = false, ?String $comision = null, ?String $redondeo = null)`.
  Cuando se informa:
  - se usa tal cual como `dRedon` (F013);
  - **no** se informan `dLiqTotIVA5`/`dLiqTotIVA10` (F036/F037): `dTotIVA` (F017) = F015 + F016
    (+ F026), como exige la validación 2371;
  - `dTotGralOpe` (F014) = F008 − F013 (+ comisión), redondeado a `$precisionMoneda`;
  - informarlo junto con `$redondeoSedeco = true` lanza `InvalidArgumentException` (son excluyentes).

  Pensado para consumidores que calculan el redondeo por su cuenta y conservan los decimales de
  las líneas (`addItem(..., precisionMoneda: 8, ...)` + `calcTotSub(8, false, null, $redondeo)`):
  los totales por ítem no se redondean a la moneda, de modo que un descuento global repartido
  como `EA004 = E721 × F010 / 100` (con decimales) produce un `dPorcDescTotal` (F010) derivado
  consistente con cada `dDescGloItem` (validación 1862: `|EA004 − F010 × E721 / 100| ≤ 0,8`).
- Test `tests/Unit/Core/ItemValoradoCalcTotSubRedondeoTest.php`: FE de un ítem con descuento
  global del 10 % y redondeo 0,5; FE de seis ítems con descuento global por monto y redondeo
  0,0012 (validación 1862 por ítem); exclusión con el modo SEDECO; y la salida sin redondeo
  explícito, que no cambia.

### Cambiado

- En `calcTotSub`, `$comision` se declara `?String` de forma explícita (el tipo no cambia: ya era
  implícitamente anulable, forma que PHP 8.4 depreca).
- `Constants::PKUATIA_VERSION` actualizado a `0.1.5`.

## [No publicado] — rama `dev`

Ronda de correcciones de conformidad SIFEN v150 y ampliación de la API. **Para el uso
habitual de la librería no se requiere ningún cambio en los sistemas consumidores**: todas
las firmas públicas se mantienen o se ampliaron de forma compatible. Ver
[Compatibilidad](#compatibilidad-con-versiones-en-main) para los detalles a tener en cuenta.

### Agregado

- **Suite PHPUnit (Fase 3.1).** `phpunit/phpunit` ^10.5, `phpunit.xml.dist`, script
  `composer test` y tests offline en `tests/Unit/` (sin red, sin certificado real ni harness).
  Incluye regresión del sobrefirmado en `SignHelperTest`, port del smoke test, mocks SOAP vía
  `Sifen::SetSoapClientFactory()` y tests de CDCHelper, QRHelper, Pkcs12Helper, PemHelper,
  GPaConEIni y GResProcEVe.
- `Sifen::SetSoapClientFactory(?callable $factory)` — inyección de SoapClient para pruebas
  unitarias (null restaura el comportamiento por defecto).
- **GitHub Actions (Fase 3.2).** Workflow `.github/workflows/ci.yml`: matrix PHP 8.1–8.3,
  lint (`php -l`), smoke test y PHPUnit en cada push/PR a `main` o `dev`.
- **PHPStan (Fase 3.3).** Análisis estático nivel 1 en `src/`, `phpstan.neon.dist`,
  baseline (`phpstan-baseline.neon`) y script `composer phpstan`. Correcciones QA:
  alias `getGResProcEVe`/`setGResProcEVe` en `RRetEnviEventoDe` (typo legacy deprecado),
  `FromSimpleXMLElement` con foreach para 1–15 `gResProcEVe`, referencias `RContRUC` con casing
  correcto, `GGrupSeg::FromDOMElement` y `RGeVeTr::getdDTipIDTrans` con return en default.
- **Guía de publicación en Packagist (Fase 3.4).** `docs/PUBLICAR.md` con los pasos manuales
  (cuenta Packagist, submit del repo, webhook de auto-update y release/tag SemVer).
- **Documentación open-source (Fase 3.5).** `CONTRIBUTING.md`, badge de CI, sección Pruebas,
  ejemplos completos de FE contado y cancelación en README (otros tipos/eventos: iteración siguiente).
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
- **`DocumentoElectronico::setReceptor()` acepta la descripción de D209 (tipo "Otro").** Nuevo
  parámetro **opcional al final** `?String $descTipoIdentificacion = null`: cuando el tipo de
  identificación es 9 (`TipIDRec::Otro`) traslada el texto libre a `dDTipIDRec`, validándolo de
  inmediato (obligatorio, 9–41 caracteres). Es retrocompatible: los llamadores existentes (19
  argumentos) no requieren cambios y, para los demás tipos de identificación, el parámetro se
  ignora.
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
- **`GDatRec` — descripción del tipo de documento de identidad del receptor (D209 / `dDTipIDRec`).**
  `getDDTipIDRec()` descartaba el valor almacenado y siempre re-derivaba la descripción a partir
  del código `iTipIDRec` (D208), por lo que el texto libre requerido para `iTipIDRec = 9` (Otro)
  nunca llegaba al XML (se emitía `'Otro'`). Además, `setITipIDRec(9)` autocompletaba `'Otro'`,
  pisando un valor previamente establecido por el usuario. Ahora el getter respeta el valor libre
  almacenado (con fallback a la descripción estándar) y `setITipIDRec` no sobreescribe la
  descripción de texto libre para el tipo 9.
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
- **`GDatRec` valida D209 (`dDTipIDRec`) al conformar el documento.** Cuando `iTipIDRec` (D208)
  es 9 (Otro), la descripción del tipo de documento de identidad es de texto libre, obligatoria y
  de **9 a 41 caracteres** (`mb_strlen`); si falta o no cumple la longitud, `toDOMElement()` lanza
  `InvalidArgumentException` al conformar/firmar. Para los demás tipos el comportamiento no cambia.
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
