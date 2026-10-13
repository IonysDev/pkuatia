# Changelog

Todos los cambios notables de PKuatia se documentan en este archivo.

El formato sigue [Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/)
y el proyecto se adhiere (en lo posible) a [Versionado Semántico](https://semver.org/lang/es/).

## [0.3.0] — No publicado

Fase C del roadmap de la evaluación del 02/10/2026 (`docs/evaluacion-2026-10-02/`): validación de documentos y
firmas, errores tipados y catálogo de códigos del SIFEN. **Compatible hacia atrás**: no se elimina ni cambia ninguna
firma pública; las excepciones nuevas extienden las que se lanzaban hasta 0.2.1, de modo que todo `catch` existente
sigue funcionando, y los rechazos del SIFEN siguen devolviéndose como objetos, no como excepciones. Toda validación
previa al envío es opcional (opt-in): `EnviarDE` no cambia de comportamiento. Dos cambios de comportamiento
deliberados, decididos durante la fase y detallados abajo: `Init()` se niega a arrancar en producción con el CSC de
prueba (Q-C6, solo afectaba a documentos que el SIFEN ya rechazaba) y el total del ítem en guaraníes se redondea en
vez de truncarse (Q-C8, cambia la serialización de documentos con tipo de cambio por ítem y fracción).

### Agregado

- Capturas de `sifen-test` del 11/10/2026, de la homologación de la 0.2.1, en
  `tests/Resources/sifen/respuestas-ws/2026-10-11/`: 46 archivos copiados byte a byte de ekuat-ia (`cf55702`).
  `tests/Unit/Responses/CapturasHomologacionFaseBTest` las lee a través del facade: los siete envíos (0260, 2562 y
  1206), la consulta de la autofactura con su constancia y la de la FE con vehículo nuevo, la consulta 0420 de un
  envío cortado, el rechazo genérico de la consulta de RUC, la recepción y la consulta del lote (0300 y 0362) y la
  respuesta con cinco eventos. Los nueve rDE enviados validan contra el XSD y hacen ida y vuelta byte a byte. Solo
  cambian las pruebas: la librería no cambia.
- Advertencia sobre las 15 monedas cuyo nombre supera los 20 caracteres que admite el XSD (deuda D-A3, sin
  solución conocida): el SIFEN rechaza la descripción recortada con 1206 y no hay una descripción conocida que
  acepte, así que esas monedas no se pueden usar en un DE. Está en el README (Notas importantes, punto 6) y en el
  docblock de `MonedaMapping::GetDescription()`.
- `Utils\DecimalXsd`: validación y normalización de montos y medidas contra los tipos decimales del XSD
  (`xs:decimal` con `totalDigits` y `fractionDigits`, como `tMontoBase4` y `tMontoBase6`,
  `DE_Types_v150.xsd:1290-1314`): `normalizar()`, `exacto()` y `esValido()`. Reúne, sin cambiarlo, el criterio que
  `GGrupSup` (0.2.1, Q-B10) y `GVehNuevo` (0.2.1, Q-B12) aplicaban por separado; los dos grupos delegan en él y
  conservan sus mensajes. Lo usará el validador de reglas de esta misma versión.
- **Excepciones tipadas** (`IonysDev\Pkuatia\Core\Exceptions`, evaluación §7.2 con las decisiones Q-C2 y Q-C3). Cada
  clase extiende la que se lanzaba hasta 0.2.1 en ese lugar, así que ningún `catch` existente deja de funcionar, y
  todas implementan `PkuatiaExceptionInterface` (con `getContexto()`, sin secretos) para atraparlas de una vez:
  - `PkuatiaException` (base, extiende `\Exception`) → `ConfiguracionException` (Config incompleta, `Init()` sin
    archivos, factoría de SoapClient inválida, archivos temporales o del dId) → `CertificadoException` con
    `getMotivo()` (`MotivoCertificado`: NoEncontrado, PassphraseIncorrecta, CifradoHeredado, PemInvalido,
    NoSoportado); `FirmaException` (firmador sin inicializar); `RespuestaException` (respuesta del SIFEN que no se
    pudo interpretar: `getOperacion()`, `getCampoFaltante()`, `getRespuestaCruda()`).
  - `ValidacionException` (extiende `\InvalidArgumentException`) → `CampoInvalidoException` con `getCampoMT()`,
    `getElemento()`, `getValorRecibido()`, `getReglaEsperada()` y `getCodigoSifen()`.
  - `TransporteException` (extiende `\SoapFault`, que ya es una `\Exception`) para toda falla de comunicación en las
    siete operaciones del facade, con `getOperacion()`, `getTipo()` (`TipoFallaTransporte`: Wsdl,
    RespuestaVaciaONoXml, Conexion, TiempoAgotado, Tls, SoapFault, Desconocida, deducido de lo observado contra
    `sifen-test`), el `faultcode` original y el `SoapFault` original en `getPrevious()`; `SifenNoDisponibleException`
    cuando el patrón es el de saturación o bloqueo temporal (WSDL o cuerpo vacío).
- El facade lanza las excepciones tipadas: `Init()` y `Config` (`CertificadoException`/`ConfiguracionException`),
  las validaciones previas a la red (`ValidacionException`; el CDC y el motivo de los eventos y la NT-024 como
  `CampoInvalidoException`, esta última con el código 1321 y el campo D208), los errores de parseo
  (`RespuestaException` con la respuesta cruda) y las fallas de comunicación (`TransporteException`). Los mensajes
  conservan el prefijo `[Sifen] …` de cada operación. `SignHelper`, `Pkcs12Helper` y `PemHelper` lanzan
  `CertificadoException` o `FirmaException`.
- Todo el modelo lanza las excepciones tipadas (352 `throw` en 92 archivos, sin cambiar ningún mensaje): las
  validaciones de los setters, de los builders de documentos, de los eventos, de los helpers y de las utilidades
  lanzan `ValidacionException`; las clases de respuesta lanzan `RespuestaException` cuando la respuesta del SIFEN
  es nula, no tiene la forma esperada o le falta un campo (`getCampoFaltante()` con el nombre del campo, y el
  facade le agrega la operación y la respuesta cruda); una falla al serializar a XML lanza `PkuatiaException`.
  Lo que era `\InvalidArgumentException` sigue siéndolo y lo que era `\Exception` sigue siéndolo. En `src/` no
  queda ningún `throw` genérico, y un test lo vigila.
- `Constants\CodigoResultadoWS`: enum con los 57 códigos de resultado de los web services como texto de cuatro
  dígitos con cero inicial, tal como llegan en `dCodRes`: los 40 vigentes del MT v150 (§12.2 y §12.3, con 0420
  inexistente, 0421 RUC sin permiso y 0422 CDC encontrado), 0364 (consulta de lote extemporánea, guía de la DNIT),
  0520-0523 (archivo de RUC, NT-011), los 10 eliminados en v150 (con `vigente()` falso) y dos que no figuran en las
  tablas pero el SIFEN responde: 0100 "Error Inesperado" y 0143 "La firma digital del evento debe corresponder al
  receptor del DE/DTE" (capturas del 09 y 11/10/2026). `fromAny()` acepta `260`, `"260"` y `"0260"`;
  `descripcion()`, `idMT()`, `esAprobacion()`, `esTransitorio()`, `esObservado()`, `categoria()`
  (`CategoriaCodigoWS`, por rangos del §12.1.1) y `fuente()`. Las constantes enteras `COD_RES_*` siguen valiendo.
- `Constants\EstadoResultado` (`dEstRes`: Aprobado, Aprobado con observación, Rechazado) con `fromTexto()`
  tolerante a espacios, mayúsculas y tildes, `esAprobado()` (verdadero también con observaciones) y `letra()`; y
  `Constants\EstadoRuc` (`dCodEstCons`: ACT, SUS, SAD, BLQ, CAN, CDE) con `descripcion()` y `esActivo()`.
- **Catálogo de validaciones del SIFEN** (`Validacion\CatalogoValidaciones`), generado desde ekuat-ia con
  `tools/generar-catalogos.php` a `src/Resources/codigos/` (README en la carpeta): las 282 validaciones vigentes
  del DE y las 18 eliminadas en v150 (MT §12.4), las 95 de los eventos (MT §11.6, con los códigos repetidos
  4313-4323 conservados) y los códigos de los web services (MT §12.2-12.3), más los elementos del XSD del DE con
  su ID del MT, sus ocurrencias y su línea citable. `describir('1321')` devuelve una `InfoValidacion` con el
  código, el ID del campo (D208c), el mensaje, el estado (A/AO/R), el grupo, la observación (la regla), la
  vigencia, la fuente y el método de PKuatia que carga el campo (`campos-metodos.php`, mantenido a mano);
  `describirTodos()`, `porCampo('D208')`, `todas()`, `elemento('dNumTim')` (`InfoElemento`: campo C004, obligatorio,
  padre `tgDTim`, línea del XSD), `hijosDe('gTimb')`, `campoMT()` y `metodoPkuatia()`. Es lo que permite pasar de
  un `dCodRes` a "qué tocar en el código". `tests/Unit/Resources/CatalogosSincroniaTest` regenera los catálogos en
  memoria desde `docs/sifen-ai` y los compara con los versionados (se omite sin esa carpeta).
- El lint de CI incluye `tools/`.
- **Lectura directa de las respuestas** (evaluación §7.2). Interfaz `Core\Responses\RespuestaSifen`, implementada por
  las siete respuestas del facade, con nombres nuevos para no tocar los getters históricos (`getDCodRes()` sigue
  devolviendo `int` o `String` según la clase): `getCodigo()` (texto de cuatro dígitos con cero inicial, "0260"),
  `getMensaje()`, `esExitosa()`, `getCodigoResultado()` (`CodigoResultadoWS`), `getInfoValidacion()` (catálogo:
  campo del MT, regla y método de PKuatia), `getFechaProceso()` y `toArray()`. Por operación: `RRetEnviDe`
  `esAprobado()`, `esRechazado()`, `getEstado()`, `getProtocolo()`, `getCdc()`, `getMotivos()`; `RResEnviLoteDe`
  `fueEncolado()`, `getNumeroLote()`, `getTiempoMedioProcesamiento()`; `RResEnviConsLoteDe` `estaEnProcesamiento()`,
  `estaConcluido()`, `esExtemporaneo()`, `esResultadoDefinitivo()`, `getDocumentos()`, `todosAprobados()`,
  `getRechazados()`, `getResultadoDe($cdc)`; `RResEnviConsDe` `fueEncontrado()`, `getProtocolo()`;
  `RResEnviConsRUC` `fueEncontrado()`, `getEstadoRuc()`, `esFacturadorElectronico()`, `getRazonSocial()`;
  `RRetEnviEventoDe` `getResultados()`, `todosAprobados()`, `getRechazados()`, `getResultadoDelEvento($id)`;
  `RResEnviConsArchivoRUC` `fueEncontrado()`. En los grupos de resultado: `GResProc` `getCodigo()`, `getMensaje()`,
  `getCodigoResultado()`, `esAprobacion()`, `esValidacionDE()`, `esValidacionEvento()`, `getInfoValidacion()`;
  `RProtDe`, `GResProcLote` y `GResProcEVe` `getEstado()`, `esAprobado()`, `esRechazado()`, `getMotivos()`,
  `getCodigo()`, `getMensaje()`, `getProtocolo()` (más `getCdc()` en el lote, `getIdEvento()` en los eventos y
  `toArray()` en ambos). Todo probado sobre las capturas reales del 06, 09 y 11/10/2026.
- **`Sifen::VerificarFirma(string $xml): ResultadoFirma`** (evaluación §6.2): verifica la firma de un rDE o de un
  sobre de eventos recibido, sin `Init()` ni red. Por cada `Signature`, una `InfoFirma` con la referencia, si el
  digest coincide (el contenido no fue alterado), si el `SignatureValue` verifica con el certificado de `KeyInfo`,
  si los algoritmos son los del estándar (RSA-SHA256/384/512, SHA-256, C14N exclusiva o inclusiva y transform
  enveloped, NT-016), el certificado (`CertificadoFirma`: sujeto, emisor, RUC si figura en el `serialNumber` o en
  el SAN, vigencia) y si estaba vigente en `dFecFirma`. Los errores llevan el código del MT: 0140 (estándar),
  0141 (digest o firma), 0120 (certificado ilegible), 2450/0121 (vigencia al firmar). No verifica la cadena de
  certificación ni la revocación. Control positivo con un certificado autofirmado; control negativo con las once
  capturas anonimizadas de `sifen-test`, cuya firma ya no verifica.
- `Validacion\ErrorValidacion` y `OrigenError`: el tipo común de error de la validación XSD, de completitud, de
  reglas y de firma (origen, mensaje, código del SIFEN, campo del MT, elemento, ruta, valor, sugerencia, línea y
  si es solo una advertencia), con `getInfoValidacion()` y `__toString()`.
- **Validador de reglas offline** (evaluación §6.3, decisión Q-C1): `DocumentoElectronico::validarReglas()` en los
  cinco tipos de documento y `Validacion\ValidadorDE::validar()` para un `DE` o `RDE` ya armado o leído de un XML.
  Devuelve un `ResultadoValidacion` (se cuenta, se recorre, `esValido()`, `getErrores()`, `getAdvertencias()`,
  `porCodigo()`, `porCampo()`, `porOrigen()`, `lanzarSiInvalido()` que lanza `DocumentoInvalidoException` con el
  resultado adjunto) con un `ErrorValidacion` por problema. No serializa, no firma y no modifica el documento; lee
  las propiedades con `isset`, nunca getters, así que un documento a medio armar lista lo que le falta en vez de
  terminar en `Error` (cierra la deuda Q-B3 de la 0.2.1). En esta entrega: la completitud según el XSD (campos con
  `minOccurs = 1` de cada grupo informado, con el campo del MT, la línea del XSD y el método de PKuatia que lo carga;
  código 0160) y la presencia de los grupos que cada tipo de documento exige o prohíbe (1200/1201, 1350/1351,
  2550/2551, 1450/1451, 2600/2601, 1500/1501, 2350/2351, 2100/2101, 2150/2151, 2200/2201, 2250/2251, 2300/2301,
  2400, 1850/1851, 1900/1901/1902 y 2390, con el mensaje del MT). Control de falsos positivos: los documentos de la
  fábrica de pruebas y los once rDE reales de `sifen-test` dan cero errores.
- Reglas de negocio del validador (`Validacion\Reglas\*`, errores-validacion.md del MT §12.4; cada error con el
  mensaje del MT, el campo, el elemento, la ruta y el método de PKuatia): **descripciones que no corresponden al
  código** en 37 pares código/descripción de todos los grupos (1051, 1100, 1203, 1205, 1206, 1211, 1254, 1257,
  1260, 1301, 1313, 1325, 1326, 1329, 1352, 1452, 1502, 1554, 1555, 1602, 1702, 1802, 1804, 1806, 1903, 2103, 2104,
  2401, 2410, 2429, 2552, 2555, 2556, 2558, 2559, 2561, 2602, 2603; los códigos de texto libre no se comparan y las
  15 monedas de nombre largo se avisan como advertencia, D-A3); **generales**: 1003 dígito verificador del CDC, 1000
  CDC coherente con el contenido, 1004 firma adelantada, 1005 transmisión a más de 72 h (advertencia), 1103 timbrado
  con vigencia posterior a la emisión, 1110 serie, 1150/1151/1156 ventanas de la fecha de emisión, 1202 tipo de
  transacción, 1207/1208/1209/1210 condición y valor del tipo de cambio, 1253 dígito verificador del emisor y
  1255/1328/2553/2557/2153/2203 departamento, distrito y ciudad relacionados (`PyGeoCodesMapping::estanRelacionados()`,
  nuevo); **receptor**: 1315, 1300, 1316, 1320, 1302/1303, 1304/1305, 1317, 1309, 1310/1311, 1319, 1321 (NT-024),
  1314/1323, 1318, 1330, 1324, 1327; **pagos**: 1503, 1550/1551/1552, 1553, 1556/1557, 1600/1601, 1650/1651,
  1700/1701, 1703/1704, 1705/1706, 1751. Un test por código, con un documento válido al que se le introduce una sola
  violación; las fechas se evalúan contra un momento de referencia (`$ahora`, por defecto ahora en Asunción).
- Reglas de negocio del validador, ítems y totales (`Validacion\Reglas\ReglasDeItems` y `ReglasDeTotales`; MT §12.4
  E8 y F, `campos-obligatorios.md` y NT-013): **ítems**: 1800/1801 códigos DNCP, 1807/1808 relevancia de las
  mercaderías, 1854/1855/1856 tipo de cambio por ítem, 1859 total bruto, 1852/1861 descuento particular y su
  porcentaje (variación admitida 0,8, como dice el MT), 1853 total de la operación por ítem, 1857/1858 total en
  guaraníes; **IVA por ítem**: 1904/1905/1906 proporción, 1907/1908 tasa, 1909/1910/1911 base gravada,
  1912/1913 liquidación y 1921 base exenta del gravado parcial (NT-013 §2.1, todavía sin fila en
  `errores-validacion.md`); **totales**: 2352–2359 subtotales por afectación, 2362 total de la operación (suma de los
  subtotales; en la autofactura, de los ítems), 2363/2364 descuentos, 2365 total general, 2366–2371 liquidación del
  IVA, 2372–2377 bases gravadas y 2382/2385/2386 total en guaraníes. Los importes se recalculan con BCMath desde los
  ítems informados con las fórmulas que `addItem()` y `calcTotSub()` aplican y el SIFEN aprobó: `F014 = F008 − F013 +
  F025` y `F017 = F015 + F016 − F036 − F037 + F026` (`campos-obligatorios.md`; la fila 2365 del MT dice otra cosa,
  devolución a ekuat-ia). Como el DE no dice con cuántos decimales redondea el emisor, se admite menos de una unidad
  del último decimal informado. 2503 (J003 `dInfAdic` fuera de la firma, que PKuatia emite a pedido) se informa como
  advertencia hasta comprobarlo en `sifen-test`.
- Reglas de negocio del validador, transporte, documentos asociados y campos específicos
  (`Validacion\Reglas\ReglasDeTransporte`, `ReglasDeDocumentosAsociados` y `ReglasEspecificas`; MT §12.4 E1, E6, E9,
  E10 y H): **transporte**: 2102 tipo de transporte, 2107/2109 fechas de traslado obligatorias en la NR, 2108 inicio
  anterior a la puesta en producción del SIFEN, 2110 fin anterior al inicio, 2252/2253 número de vuelo solo en el
  aéreo, 2254/2255 matrícula o identificación según E967, 2302/2305 RUC del transportista según su naturaleza, 2306
  dígito verificador, 2307/2308 tipo de documento según la naturaleza, 2311 número de documento; **documentos
  asociados**: 2415 un solo asociado en AF, NC y ND, 2416/2434 constancia solo en la AF, 2402/2418 CDC solo en el
  electrónico, 2405–2409 y 2411 campos del impreso obligatorios con H002 = 2 y 2419–2423 y 2425 prohibidos sin él,
  2424/2435 descripción del tipo de impreso, 2436 retención con pago por retención, 2413 resolución de crédito fiscal
  con D011 = 12, 2426/2427 tipo de constancia, 2430–2433 número y control de la constancia; **específicas**:
  1400/1401 compras públicas solo y siempre en B2G, 1402 fecha del código de contratación, 2604/2605 fecha futura de
  la factura en la NR, 2606 traslado entre locales con el emisor como receptor, 2050–2055 ciclos de `gGrupAdi`.
  Fuera de alcance porque dependen de datos del SIFEN: 2403, 2404, 2414, 2417, 2437, 2438 y 2440; 2309 y 2312 no
  pueden fallar porque el modelo deriva esas descripciones. Con esto el validador cubre 233 códigos del MT, más 1921 de la NT-013. La FE
  con todos los opcionales de la fábrica de pruebas pasa a B2G con códigos DNCP (1401 y 1800 la rechazaban).
- `Sifen::Shutdown()`: libera lo que `Init()` dejó en disco y en memoria (borra los temporales del PKCS#12, descarta
  el cliente SOAP y olvida las opciones). Se puede llamar varias veces; `Init()` vuelve a dejar todo listo. La
  librería la ejecuta sola al terminar el script.
- `Config::$soapTrace` (con `setSoapTrace()` y clave `soapTrace` del JSON; por defecto `true`, como hasta 0.2.1):
  con `false` el `SoapClient` no guarda la última solicitud ni la última respuesta y `GetLastRequest()` y
  `GetLastResponse()` devuelven `null`.
- `Config::__debugInfo()`: `var_dump()` y `print_r()` muestran la passphrase de la clave y el CSC como `'[redactado]'`;
  las propiedades y los getters conservan los valores (evaluación §4, PK-39).
- `SignHelper::Shutdown()`: olvida la clave privada y el certificado cargados por `Init()`; una firma posterior
  lanza `FirmaException` hasta el próximo `Init()`. `Sifen::Shutdown()` la invoca. La firma usa desde ahora una
  copia privada de la clave, independiente de la propiedad pública (decisión Q-C4).
- `Config::CSC_DE_PRUEBA` y `Config::usaCscDePrueba()`: el CSC de fábrica es el del ambiente de pruebas. `Sifen::Init()`
  lanza `ConfiguracionException` cuando `env = prod` y el CSC sigue siendo ese (decisión Q-C6): en producción el
  SIFEN rechazaba cada DE con 2501 (J002a) sin que la librería avisara, así que nadie que hoy funcione en producción
  puede verse afectado. En desarrollo no cambia nada.
- **Validación contra los XSD de producción** (evaluación §6.3): `Sifen::ValidarXSD($rdeXml)` y
  `Sifen::ValidarEventoXSD($sobreXml)` validan contra los esquemas incluidos en `src/Resources/xsd/`
  (`siRecepDE_v150.xsd` y `siRecepEvento_v150.xsd` con su cadena de includes), sin red (`LIBXML_NONET`) y sin
  `Init()`, y devuelven un `ResultadoValidacion` con un `ErrorValidacion` por error de libxml: origen XSD, código
  0160 (AE01, lo que el SIFEN responde ante un XML que no cumple el esquema), elemento, campo del MT (catálogo de
  elementos), línea y una sugerencia con lo que falta y el método de PKuatia que lo informa; un XML mal formado o
  vacío da un solo error sin elemento. `Validacion\ValidadorXsd::validar($xml, $xsd)` acepta cualquier esquema
  local. `Config::$validarXsdAntesDeEnviar` (con `setValidarXsdAntesDeEnviar()` y clave JSON; por defecto `false`):
  con `true`, `EnviarDE`, `EnviarLoteDE` (cada documento) y `RegistrarEvento` (el sobre ya firmado) validan antes de
  tocar la red y lanzan `DocumentoInvalidoException` con el resultado adjunto. Por defecto nada cambia. Los nueve
  rDE aprobados por `sifen-test` el 11/10 y los dos del 09/10 validan; la FE B2G con compras públicas valida gracias
  al arreglo local de `dEntCont`.
- El validador rechaza `dCilin` (E786) con 0160 sea cual sea el valor: el XSD de producción declara el patrón `/d` y
  `sifen-test` lo aplicó tal cual el 13/10/2026 ("XML malformado [El valor 1600 del elemento: dCilin es invalido]").
- **Homologación del validador en `sifen-test`** (13/10/2026, capturas en `tests/Resources/sifen/respuestas-ws/2026-10-13/`
  copiadas de ekuat-ia): doce envíos con una sola violación o característica cada uno. El SIFEN respondió el código
  que el validador predecía en 1309, 2365, 1550, 1300 (innominado en B2B: informa D202 antes que D208), 2400, 1004,
  2503 y 0160 (`dCilin`), y aprobó con 0260 la base gravada 0,01 mayor, la FE B2G con `dEntCont` (PK-44 cerrada), la
  FE en USD con tipo de cambio por ítem y fracción (Q-C8) y el redondeo de EA008 a la unidad. Un canario recibió el
  0160 genérico y un minuto después el ambiente respondió normalmente. `CapturasHomologacionFaseCTest` lee cada
  respuesta a través del facade y comprueba que el validador predice lo mismo sobre el documento anonimizado.

### Obsoleto

- `SignHelper::$xmlKey` y `SignHelper::$xmlSigner` (decisión Q-C4): siguen públicas y `Init()` las sigue poblando,
  así que nadie que las lea se rompe, pero la firma ya no las usa (una copia privada firma; modificarlas no cambia
  nada) y leerlas expone la clave y la passphrase. `Shutdown()` las deja vacías. Se retiran en la 1.0.

### Corregido

- `GCamItem::FromSifenResponseObject()` leía los códigos DNCP del ítem como `dDDncpG` y `dDDncpE`, propiedades que
  el objeto SOAP no tiene, así que E704 y E705 se perdían al leer un DE desde la respuesta de `ConsultarDE`. Lo
  detectó la ida y vuelta de la FE B2G de la fábrica de pruebas (`IdaYVueltaGruposTest`). Solo cambia la lectura: la
  serialización es idéntica.
- Una nota de crédito o de débito sin documento asociado terminaba en `Error` ("`$gCamDEAsoc` must not be accessed
  before initialization") al pasarla a RDE; la propiedad arranca ahora como lista vacía, el documento se serializa
  (sin `gCamDEAsoc`) y el validador lo rechaza con 2400, que es lo que el SIFEN responde. Hallazgo del ensayo en
  seco de la homologación (C14).
- El validador de reglas comparaba las fechas de un rDE leído de un XML con la zona por defecto de PHP (UTC en
  muchos servidores): como el XML no lleva zona y es hora de Asunción por convención del MT, una firma 30 minutos
  adelantada parecía 2,5 horas atrasada y no se predecía 1004, y las ventanas de 1150/1151 corrían desplazadas. Las
  fechas del documento se toman ahora como hora de pared en Asunción (`VistaDocumento::enZonaSifen()`), que es lo
  que ve el SIFEN. Hallazgo del ensayo en seco de la homologación (C14).
- Los cálculos del IVA por ítem (1910, 1911, 1913 y 1921) admiten 0,01 de diferencia: `sifen-test` aprobó el
  13/10/2026 una base gravada 0,01 mayor que la exacta con su liquidación coherente, que el validador rechazaba.
  Una diferencia mayor sigue sin verificar y se informa.
- **PK-39** (evaluación §4): con un certificado PKCS#12, `Init()` dejaba el certificado y la clave privada **en
  claro** en `sys_get_temp_dir()` con nombres predecibles (`cert_*`, `key_*`) hasta que terminara el script. Ahora
  van a una carpeta propia de nombre impredecible (`pkuatia-<16 hex>/`, 0700 donde el sistema lo respeta; en Windows
  la protección es el nombre y el borrado garantizado), la clave se exporta **cifrada** con la misma passphrase
  (`openssl_pkey_export`; el contexto SSL ya la recibe), una falla intermedia no deja restos y los archivos se borran
  en `Shutdown()`, en el siguiente `Init()` y al terminar el script.

### Cambiado

- 2503 (J003 `dInfAdic`) pasa de advertencia a error del validador: `sifen-test` rechazó el 13/10/2026 una FE con
  `dInfAdic`, así que el tercer parámetro de `FirmarDE()` no tiene un uso que el SIFEN acepte (sigue existiendo por
  compatibilidad; su docblock lo dice).
- El total del ítem en guaraníes (EA009 `dTotOpeGs`, tipo de cambio por ítem) se redondea al guaraní entero
  (decisión Q-C8). Hasta 0.2.1 `addItem()` lo calculaba con `bcmul()` sin escala, es decir truncado: con precios o
  tipos de cambio con fracción cada ítem quedaba hasta 1 Gs por debajo del valor exacto (EA009 = EA008 × E725,
  validación 1858) y F023 (suma de EA009) arrastraba la diferencia. **Cambia la serialización** solo de los
  documentos con tipo de cambio por ítem cuyo producto tiene fracción (p. ej. 301,00 USD × 7300,5 = 2 197 450,5 →
  2 197 451; antes 2 197 450). Los documentos de la línea base de pruebas no cambian.
- El XML que viene del SIFEN se parsea con `LIBXML_NONET` (evaluación §9): la respuesta cruda de las siete
  operaciones, `RProtDe::FromXMLString()`, `RContDe::FromXContenDE()` y la firma de un `RDE` leído. Una DTD o una
  entidad externa en una respuesta no provoca ninguna lectura de red; las entidades tampoco se sustituyen, como
  hasta ahora.
- `ConsultarRUC` y `ConsultarDE` envuelven también el `SoapFault` y las demás fallas (decisión Q-C3, que cierra la
  parte 2 de Q-B4): la excepción es `TransporteException`, que sigue siendo un `\SoapFault` con el mismo
  `faultcode`, así que `catch (\SoapFault)` la atrapa igual que hasta 0.2.1; cambia solo el mensaje, que ahora lleva
  el prefijo `[Sifen] Error al consultar …:` como en las demás operaciones.

## [0.2.1] — 2026-10-11

Fase B del roadmap de la evaluación del 02/10/2026 (`docs/evaluacion-2026-10-02/`): deserialización,
respuestas del SIFEN y robustez (PK-25 a PK-43). **Compatible hacia atrás para el uso habitual**: no se
elimina ningún método público; se agregan métodos, parámetros opcionales al final, propiedades y
pruebas; algunos setters amplían el tipo que aceptan (`int` → `int|String`) y los retornos que ya podían
devolver `null` se declaran anulables. Se corrige comportamiento que producía `Error`, `TypeError`,
pérdida de datos o XML inválido. Algunas correcciones cambian el XML emitido (grupos sectoriales
combinados, constancia de no ser contribuyente, vehículo nuevo) o lanzan una excepción con mensaje donde
antes se seguía en silencio: están detalladas en "Corregido" y en "Cambiado". El formato de las
respuestas se fija contra capturas reales de `sifen-test` (06 y 09/10/2026), que mandan sobre el Manual
Técnico.

### Agregado

- **Capturas reales de las respuestas del SIFEN en `tests/Resources/sifen/respuestas-ws/`** (32
  archivos de `sifen-test`, 06 y 09/10/2026, anonimizados): envío aprobado 0260 y rechazo genérico
  0160, eventos 0600, 4009 y 0100, consultas de DE 0420 y 0422 (con y sin eventos) y consultas de RUC
  0502 y 0160. Son copias byte a byte de `ekuat-ia/06-ejemplos/respuestas-ws/` (`16070af`),
  versionadas sin conversión de fin de línea (`.gitattributes`). No forman parte de la API.
- Soporte de pruebas: `tests/Support/CapturaSoapClient` (cliente SOAP sin red que responde con una
  captura y la decodifica con `ext/soap`, como en producción; `__getLastResponse()` devuelve los
  bytes exactos), `tests/Support/RespuestasSifenFactory` (cada captura por nombre) y
  `tests/Support/RoundTrip` (ida y vuelta byte a byte: `toDOMElement` → `FromDOMElement` o
  `FromSimpleXMLElement` → `toDOMElement`).
- Tests: `tests/Unit/Resources/RespuestasWsSincroniaTest` (las copias siguen iguales a ekuat-ia; se
  omite sin `docs/sifen-ai`), `tests/Unit/Responses/CapturasRealesTest` (formato real: `Id` con
  mayúscula en `rRetEnviDe`, `id` en minúscula en `rRetEnviEventoDe`, `xContenDE` como texto con
  varias raíces) y `tests/Unit/Deserializacion/IdaYVueltaDocumentosTest` (ida y vuelta por DOM
  idéntica en FE, NC, ND y NR).
- `GCamEsp::getGGrupSeg()`, el getter con el nombre correcto de `gGrupSeg`.
- **Ocurrencias múltiples que el XSD permite** (decisión Q-B9): hasta 9 grupos de energía eléctrica, uno
  por medidor (`gGrupEner`, `DE_v150.xsd:802`, NT-023), y hasta 3 vencimientos de pago en los datos
  adicionales (`dVencPag`, `DE_v150.xsd:829`). Métodos nuevos: `GCamEsp::addGGrupEner()` y
  `getGGrupEners()`, `GGrupAdi::addDVencPag()` y `getDVencPags()`, y en los documentos
  `addDatosComplementariosSectorEnergia()` y `addVencimientoDePagoDeUsoComercial()`. Las propiedades y
  los getters existentes siguen devolviendo la primera ocurrencia, y los `set…` siguen reemplazando todas.
  Superar el máximo lanza `InvalidArgumentException`. Test: `tests/Unit/Conformidad/OcurrenciasMultiplesTest`.
- `GGrupSup::getDEfectivoDecimal()`, `getDVueltoDecimal()` y `getDDonacDecimal()` (decisión Q-B10): el
  monto exacto como texto, con sus decimales.
- `GVehNuevo::getDPNetDecimal()`, `getDPBrutoDecimal()` y `getDCapTraccDecimal()` (decisión Q-B12): el peso neto,
  el peso bruto y la capacidad máxima de tracción exactos, como texto con sus decimales.
- Eventos (PK-42): `GGroupTiEvt::getRGeDevCCFFCue()` y `getRGeDevCCFFDev()`; en `RGeVeRetAce` y
  `RGeVeRetAnu`, `dRuc` y `dMonRet` con sus setters y getters; `Sifen::InutilizarNumeros()` con el parámetro
  opcional final `?String $serie = null` (`dSerieNum`). Test: `tests/Unit/Deserializacion/EventosIdaYVueltaTest`,
  con los 15 tipos de evento por SimpleXML y la cancelación real de la captura del 09/10/2026.
- Respuestas (PK-29): `RContDe::FromXContenDE()` interpreta el contenido de una consulta de DE según su
  formato real; `RContDe::getRContEvs()` y `addRContEv()` manejan todos los eventos del DE consultado (ContDE04
  es 0-n); `Helpers\FechaHelper::FromSifen()` lee las fechas del SIFEN con o sin zona horaria. Test:
  `tests/Unit/Responses/RespuestasRealesTest`, con las capturas reales llamadas a través del facade.
- `Sifen::GetLastRequest()` y `Sifen::GetLastResponse()` (PK-31): el XML de la última solicitud y de la última
  respuesta, también cuando el parseo falla, para auditar o guardar la respuesta cruda. Si la llamada falla al
  crear el cliente, por ejemplo porque el WSDL no responde, devuelven `null` y no los datos de la llamada anterior.
- `GRasMerc::getDNumLoteString()`: el número de lote (E751, texto de 1 a 80 caracteres) tal como se informó.
- `tests/Support/SignatureAssertions::assertFirmaVerifica()`: verificación criptográfica de la firma con
  xmlseclibs (digest del DE y firma de `SignedInfo`), usada por `tests/Unit/Deserializacion/IdaYVueltaFirmadoTest`.
- `Config::$soapConnectionTimeout` y `Config::$soapUserAgent` (PK-31), con sus setters y sus claves en
  `ParseObject()`/JSON: las opciones `connection_timeout` y `user_agent` de `SoapClient`. Sin configurar, no
  se agregan y el comportamiento no cambia. Test: `tests/Unit/Sifen/ErroresDelFacadeTest`.
- `tests/Unit/Deserializacion/CamposEspecificosIdaYVueltaTest`: ida y vuelta por DOM, SimpleXML y
  objeto SOAP de `gCamEsp` (con sus cuatro grupos), `gCamAE` y `gCamNRE`, y de documentos completos
  (FE de cada sector con `gRasMerc`, autofacturas y nota de remisión). `RoundTrip` suma la vía de
  objeto SOAP y `DocumentoFactory::rde()` arma RDE deterministas.
- `tests/Unit/Deserializacion/CadenasYRellenosTest` (código de seguridad con cero inicial, documento
  alfanumérico del receptor, serie del timbrado, código DNCP y subtotales exactos) e
  `IdaYVueltaDocumentosTest` ampliado: 15 documentos (FE, NC, ND, NR, AF y FE de cada sector) hacen ida y
  vuelta idéntica por DOM y por SimpleXML, la vía que usa `Sifen::ConsultarDE`.
- **`Sifen::EsperarResultadoLote()`** (PK-41). Espera el resultado de un lote con la política de la guía de
  mejores prácticas de envío de la DNIT (§3.4 y §7): la primera consulta pasados al menos 10 minutos y las
  siguientes cada 10 minutos o más, mientras el lote siga en procesamiento (0361). Devuelve la primera
  respuesta distinta de 0361, o la última tras `$maxIntentos` consultas. Una espera menor a 600 segundos
  lanza `InvalidArgumentException` sin consultar. Bloquea el proceso mientras espera; el parámetro opcional
  `$esperar` permite reemplazar `sleep()` (un planificador, una cola o un test) y `$onIntento` recibe cada
  respuesta. Firma: `EsperarResultadoLote(string|int $nroLote, int $esperaInicialSeg = 600,
  int $intervaloSeg = 600, int $maxIntentos = 6, ?callable $onIntento = null, ?callable $esperar = null)`.
- `RResEnviLoteDe::getDProtConsLoteString()` (PK-41): el número de lote tal como lo devolvió el SIFEN (17
  dígitos en la práctica, hasta 20), o null si el lote no fue aceptado. `getdProtConsLote()` lo convierte a
  `int` y falla con más de 19 dígitos.
- `RResEnviConsLoteDe::COD_RES_CONSULTA_EXTEMPORANEA` (0364): consulta de un lote enviado hace más de 48
  horas; hay que consultar cada CDC con `ConsultarDE()` (guía, §7; no figura en el MT v150).
- `Constants::MAX_BYTES_MENSAJE_LOTE` (1 000 000) y `Constants::ESPERA_MINIMA_CONSULTA_LOTE_SEG` (600).
  Test: `tests/Unit/Sifen/LoteTest`.
- `phpunit.xml.dist` hace fallar la corrida si un test imprime algo (`beStrictAboutOutputDuringTests` y
  `failOnRisky`), y `tests/Unit/Core/LimpiezaTest` comprueba que cada archivo de `src/` declara el tipo de su
  nombre y que no queda código inalcanzable después de un `throw` (PK-43).
- `tests/Unit/Deserializacion/IdaYVueltaGruposTest`: los 46 grupos del DE (cada clase de `src/Core/Fields/DE`)
  hacen ida y vuelta idéntica por DOM, por SimpleXML y por objeto SOAP, con instancias tomadas de todos los
  documentos de prueba y de una FE firmada; un test aparte exige que los 46 tengan instancias. Quedan fuera rDE y
  DE por la vía SOAP (tienen atributos, que `ext/soap` descarta) y `Signature` como grupo suelto: sus
  serializadores tipados no funcionan y un `rDE` leído la reemite desde el XML original (PK-32).
  `DocumentoFactory::facturaConTodosLosOpcionales()` cubre gRespDE, gOblAfe, gCompPub,
  gVehNuevo, gPagTarCD, gPagCheq, gCamGen y gCamCarg, y valida contra el XSD. `EventosIdaYVueltaTest` suma la ida y
  vuelta del `rGesEve` completo de los 18 casos de evento.

### Corregido

- **Autofactura, nota de remisión y documentos con campos sectoriales (`gCamEsp`) no se podían
  deserializar** (PK-25). Se implementaron los lectores que el código ya invocaba:
  `GGrupEner::FromDOMElement`, `GGrupSup::FromDOMElement` y `FromSimpleXMLElement`,
  `GGrupAdi::FromDOMElement` y `FromSimpleXMLElement`, `GCamAE::FromSimpleXMLElement`,
  `GCamNRE::FromSimpleXMLElement` y `FromSifenResponseObject` y `GResProc::FromSimpleXMLElement`.
  También `GTransp::FromSimpleXMLElement`, que lanzaba "Not implemented", y `FromSimpleXMLElement` de
  `GCamSal`, `GCamEnt`, `GVehTras` y `GCamTrans`, que delegan en su lector DOM. Antes terminaban en
  `Error: Call to undefined method` o en "Not implemented", también al consultar con
  `Sifen::ConsultarDE` una NR o una AF. Se quitaron las 9 entradas de `phpstan-baseline.neon` que lo
  silenciaban (94 → 85).
- Lectores existentes que perdían datos o terminaban en `Error` (PK-25): `GCamAE::FromDOMElement`
  pasaba el nodo, no su valor, a `intval()` y `strval()`; `GCamEsp` llamaba a `setGGrupoSeg()`
  (inexistente), su lector DOM le pasaba el nodo de supermercados al lector de seguros y su lector de
  objetos SOAP buscaba `gGrupoSup`; `GGrupSeg` buscaba `gGrupoPolSeg` y perdía las pólizas;
  `GGrupEner::FromSimpleXMLElement` le pasaba un objeto a `setDActiv(int)`;
  `GGrupAdi::FromSifenResponseObject` buscaba `ciclo` y pasaba las fechas como texto;
  `GRasMerc::FromDOMElement` convertía `dNumLote` (texto de 1 a 80, `DE_v150.xsd:437`) en `0` y su
  lector de objetos SOAP lanzaba "Not implemented" (con un lote alfanumérico, `getDNumLote()` sigue devolviendo la
  parte numérica, o 0, como antes; el lote exacto está en `getDNumLoteString()`); `DE::FromSimpleXMLElement` exigía `gTotSub`, que la
  NR no lleva (`DE_v150.xsd:1678`). Los lectores nuevos o reescritos lanzan `InvalidArgumentException`
  (subclase de `Exception`) cuando falta un campo obligatorio.
- **Autofactura sin distrito.** `Autofactura::setLugarTransaccion()` declara el distrito opcional pero
  terminaba en `TypeError`, y `GCamAE::toDOMElement()` emitía siempre `cDisVen` y `cDisProv`, que son
  0-1 (`tgCamAE`, `DE_v150.xsd:1351`), con `Error` si no estaban. `GCamAE::setCDisProv()` acepta `null`
  (como `setCDisVen()`) y los distritos se emiten solo si existen. Las AF con distrito no cambian.
- **Ceros iniciales y letras que se perdían al leer** (PK-26). Los tres lectores de `GOpeDE` aplicaban
  `intval()` a `dCodSeg`: un código de seguridad que empieza con cero (aleatorio, uno de cada diez
  documentos) volvía con 8 dígitos y el documento ya no coincidía con su CDC. `GDatRec::FromSimpleXMLElement`
  hacía lo mismo con `dNumIDRec`, que es alfanumérico (`tdNumDocId`): un pasaporte quedaba en `0`. Esa es
  la vía que usa `Sifen::ConsultarDE`. El lector de objetos SOAP de `GOpeDE` completa `dCodSeg` a 9 dígitos
  por si el SOAP lo entrega como número (`tiCodSe` deriva de `xs:integer`).
- **Datos agregados o alterados** (PK-36). `GTimb::FromSimpleXMLElement` agregaba `<dSerieNum>00</dSerieNum>`
  a todo documento sin serie (inválido contra `[A-Z]{2}`, `DE_v150.xsd:46`) y `GTimb::toDOMElement`
  rellenaba la serie con ceros. `GDatRec::FromSimpleXMLElement` copiaba el número de documento en el nombre
  de fantasía, no leía `dNumCasRec` y condicionaba `dDesDepRec` a la ciudad; ahora delega en el lector DOM.
  `GCamItem` completaba `dDncpG` con ceros a la derecha (`1234567` pasaba a `12345670`, otro código); el
  Manual Técnico (E704) manda completar a la izquierda y así se emite ahora (`01234567`). Los códigos de 8
  dígitos no cambian.
- **Subtotales por tasa exactos** (PK-37). `GCamItem::calcSubt05()` y `calcSubt10()` sumaban dos montos
  BCMath con `+` y perdían decimales por encima de 14 cifras significativas. Ahora usan `bcadd` y devuelven
  texto numérico sin ceros decimales finales: `getFormattedSubt05()` y `getFormattedSubt10()` muestran lo
  mismo que antes para montos normales.
- **Grupos sectoriales combinados** (decisión Q-B8). `DocumentoElectronico::documentoElectronicoToRDE()`
  emitía un solo grupo de `gCamEsp` aunque se informaran varios (prioridad energía, seguros, supermercados,
  datos adicionales) y descartaba el resto sin aviso. Ahora emite todos los informados, en el orden de
  `tgCamEsp` (`DE_v150.xsd:794-806`). **Cambia el XML** de quien combina grupos: incluye datos que ya
  cargaba y que antes se perdían. Una FE con los cuatro grupos valida contra el XSD de producción; el
  Manual Técnico no tiene reglas que limiten la combinación.
- **Ocurrencias que se perdían al leer** (Q-B9). Al leer un DE con varios `gGrupEner` o varias `dVencPag`
  se conservaba solo una. Ahora las tres vías de lectura (DOM, SimpleXML y objeto SOAP) conservan todas y
  la emisión las escribe todas, en orden.
- **Montos del sector supermercados con centavos** (decisión Q-B10). `GGrupSup` guardaba `dEfectivo`,
  `dVuelto` y `dDonac` como enteros, aunque el XSD admite 4 decimales (`tMontoBase4` y `tMontoBase6`,
  `DE_Types_v150.xsd`): `150.75` se emitía como `150` y PHP mostraba un aviso de conversión con pérdida.
  Los setters aceptan texto (`int|String`, ampliación) y validan contra el XSD: más de 4 decimales o más
  dígitos que los del tipo lanzan `InvalidArgumentException`, igual que un texto no numérico, que antes
  daba `TypeError`. El XML lleva el monto exacto, también al leer. Los montos enteros no cambian. Los textos
  numéricos que hasta 0.2.0 entraban convertidos a entero se aceptan y se normalizan: `"+5"` y `"5."` como `5`,
  `".5"` como `0.5` y la notación exponencial (`"1e3"`) como decimal.
- **Medidas del vehículo nuevo con decimales** (decisión Q-B12). `GVehNuevo` guardaba `dPNet`, `dPBruto` y
  `dCapTracc` como enteros, aunque el XSD admite 4 decimales (`tMontoBase6`, `DE_Types_v150.xsd:1308-1314`): un
  peso con decimales no se podía informar y al leerlo se truncaba. Los setters aceptan texto (`int|String`,
  ampliación) y validan contra el XSD: más de 4 decimales, más de 10 dígitos o un texto no numérico lanzan
  `InvalidArgumentException`. El XML lleva el valor exacto, también al leer por las tres vías. Los valores
  enteros no cambian, y los textos numéricos que antes entraban convertidos a entero se normalizan como en
  `GGrupSup`.
- **La nominación nunca se leía** (PK-27). `GGroupTiEvt` buscaba el nodo `rGeVeNom`, pero el XSD lo llama
  `rGEveNom` (`Evento_v150.xsd:379`), y declaraba la clase como `RGeVeNom`, cuando la real es `RGEveNom`:
  en Linux, con la clase sin cargar, el autoload no encontraba el archivo. Se quitó la entrada
  `class.nameCase` de `phpstan-baseline.neon` (85 → 84).
- **Eventos que terminaban en `TypeError` al leerlos** (PK-28). Conformidad: `iTipConf` recibía el nodo y
  `dFecRecep` se leía sin hora, aunque es `fecHhmmss` y se emite con hora desde 0.2.0. Desconocimiento:
  `iTipRec`, `dDVRec` y `dTipIDRec` recibían el nodo. Los afectaba `Sifen::ConsultarDE` de cualquier DE con
  esos eventos.
- **Retenciones sin RUC ni monto** (PK-42). `dRuc` y `dMonRet` son obligatorios en `trGeVeRetAce` y
  `trGeVeRetAnu` (`Evento_v150.xsd:120-147`) aunque el Manual Técnico no los lista; se perdían al leer.
- **Inutilización** (PK-42). `InutilizarNumeros()` acepta la serie (dos letras, `tserieNum`) y rechaza,
  antes de llamar al SIFEN, un tipo de documento fuera de 1 a 9 (`tiTiDEEv`), como el 10 de `TimbTiDE`.
- Los 18 setters que devuelven `void` documentan que no se pueden encadenar (decisión Q-B2); los tres de
  `RGEveNom` decían `@return self`.
- **Respuestas reales del SIFEN** (PK-29), verificadas contra las capturas de `sifen-test` del 06 y 09/10/2026:
  - El CDC del DE aprobado se perdía: el SIFEN envía `Id` con mayúscula y `RProtDe` leía `id`, así que
    `getId()` terminaba en `Error`.
  - `Sifen::ConsultarDE` guardaba solo el primer evento de `xContEv`. Ahora `getRContEvs()` los devuelve
    todos y `getRContEv()` sigue devolviendo el primero. `xContenDE` es texto, no XML anidado: se interpreta
    con `RContDe::FromXContenDE()`, que ya no exige un espacio después de `<rDE`. `getRDEXml()` no cambia.
  - Fechas: `dFecProc` llega con zona en las respuestas directas y sin zona dentro de `xContEv`. Las clases
    aceptaban un solo formato y terminaban en `TypeError` con el otro; `RProtDe::FromSimpleXMLElement` usaba
    uno que nunca coincidía. Una fecha inválida ahora lanza `InvalidArgumentException` con el valor recibido.
  - Rechazo genérico: con el ambiente degradado, la consulta de RUC responde 0160 con un sobre `rRetEnviDe`
    y terminaba en `TypeError`; ahora devuelve el código y el mensaje. Las consultas de DE y de lote y los
    eventos aceptan ese sobre del mismo modo; para ellos no hay captura (pendiente de verificación).
  - Los getters de campos que una respuesta real puede no traer devuelven `null` en vez de terminar en
    `Error`: `RProtDe::getId()`, `getDDigVal()` y `getDProtAut()` (el rechazo genérico no los trae) y
    `GResProcEVe::getId()` y `getDProtAut()` (un evento rechazado no tiene protocolo y la copia en `xContEv`
    no tiene `id`).
  - `RContRUC` descartaba `dDesEstCons`, y su lector SimpleXML lo guardaba en `dRUCFactElec`. La propiedad
    pública conserva el literal del SIFEN (`ACTIVO`); `getDDesEstCons()` sigue derivándolo del código.
  - `RProtDe::setGResProc()` acepta un `GResProc` o un arreglo; antes daba `TypeError`.
- **Getters que terminaban en `TypeError` o `Error` cuando no había dato** (PK-30, decisión Q-B3). 37 getters
  declaraban un tipo no anulable y podían devolver `null` o leer una propiedad opcional sin cargar. Ahora
  declaran el tipo anulable (`?String`, `?int`, `?array`…) y devuelven `null`: los catálogos
  `CountryMapping::getCountryDesc()`, `DepartamentoMapping::getDepName()` y `PyGeoCodesMapping::getDistName()`,
  `getCiudName()` y `getBarrName()` ante un código inexistente, y getters de `GCamEnt` y `GCamSal` (4 cada
  uno), `GGrupAdi` (2), `GTransp` (4), `GVehNuevo` (13), `RGeVeTr` (2), `RContRUC` (2) y `TxContenEv` (1).
  Con dato no cambia nada. Los ~460 getters del modelo de emisión que leen propiedades sin cargar quedan
  para la validación previa a serializar de la Fase C, según la misma decisión.
- **Setters de catálogo con mensaje** (PK-30, decisión Q-B3). Ante un código de país, departamento, distrito
  o ciudad inexistente lanzan `InvalidArgumentException` con el código y el catálogo, en lugar de `TypeError`:
  `GDatRec::setCPaisRec()`, `setCDepRec()`, `setCDisRec()` y `setCCiuRec()`; `GEmis::setCDepEmi()`,
  `setCDisEmi()` y `setCCiuEmi()` (los dos primeros ya tenían el chequeo, pero nunca llegaba a ejecutarse);
  los seis de `GCamAE` (vendedor y lugar de la transacción); `GCamItem::setCPaisOrig()`; y
  `RGEveNom::setCPaisRec()`, `setCDepRec()`, `setCDisRec()` y `setCCiuRec()`. Validan antes de asignar, así
  que un código inválido no deja el objeto a medias, y consultan el catálogo una sola vez.
- **Documento firmado que perdía la firma al volver a serializarse** (PK-32). `RDE::toDOMElement()` emitía
  solo `dVerFor` y `DE`. Un `rDE` leído de un XML firmado (`FromSimpleXMLElement` o `FromDOMElement`) reemite
  ahora su `Signature` tal como vino y su `gCamFuFD`, en el orden de `DE_v150.xsd:1939-1960`: la ida y vuelta
  es byte a byte y la firma sigue verificando, también con la FE real de la captura del 09/10/2026. Un `rDE`
  armado a mano se serializa como antes (es lo que firma `FirmarDE()`), y volver a firmar un `rDE` leído
  reemplaza la firma anterior en lugar de agregar una segunda.
- **Actividad económica leída del objeto SOAP** (PK-33). `GActEco::FromSifenResponseObject()` declaraba el
  tipo `stdClass` sin importarlo: PHP lo resolvía como una clase inexistente del propio espacio de nombres y
  la llamada terminaba en `TypeError`. La alcanza `RDE::FromSifenResponseObject()` a través de `GEmis`. Los
  24 archivos que nombraban `stdClass` en sus docblocks sin importarlo ahora lo importan, para que el IDE y
  el análisis estático resuelvan el tipo correcto.
- **Aviso de propiedad dinámica en los setters de ítem** (PK-34, decisión Q-B5). Los 16 setters del trait
  `ItemValorado` (`setNroLote()`, `setNroSerie()`, `setDncpCodigoGeneral()`, `setDetalleVehiculoNuevo()`,
  etc.) asignaban propiedades no declaradas: cada llamada emitía `Creation of dynamic property` en PHP 8.2+,
  que será un error en PHP 9. Las propiedades ahora están declaradas. Ver "Obsoleto".
- **Salida de depuración en producción** (PK-43). `RespuestaConsultaLoteDE::FromSifenResponseObject()`
  imprimía su nombre con `echo` en cada llamada. `GResProcEve` (espacio `Fields\Response\DE`) tenía una rama con
  `echo "TODO CUANTICO"` y leía solo el primer `gResProc`: ahora lee todos los mensajes. Se quitaron además 21
  `return null;` inalcanzables después de un `throw` (sin efecto en el comportamiento).
- **Constancia de no ser contribuyente sin número** (PK-35, decisión Q-B11). `addConstanciaDeNoSerContribuyente()`
  recibe el número y el número de control de la constancia, pero `GCamDEAsoc::toDOMElement()` solo los emitía con la
  constancia de microproductores: con la de no ser contribuyente se descartaban sin aviso. Ahora van en `dNumCons` y
  `dNumControl` cuando se informan; son los dos números del formulario de la DNIT. El número se completa con ceros a
  la izquierda hasta 11 dígitos (patrón `[0-9]{11}`), también con microproductores, donde un número corto hacía
  inválido el documento. Cambia el XML de toda autofactura con constancia de no ser contribuyente.
- **Vehículo nuevo (`gVehNuevo`) inválido contra el XSD.** `GVehNuevo::toDOMElement()` escribía en `iTipOpVN` la
  descripción ("Venta a representante", etc.) en lugar del código (`tiTipOpVN`, del 1 al 4,
  `DE_Types_v150.xsd:1470-1487`), así que toda FE con vehículo nuevo y tipo de operación salía inválida. Además
  el código 2 se describía "Venta al consumidor final" y el XSD exige "Venta al Consumidor final", con C
  mayúscula (`DE_Types_v150.xsd:1500`). Este cambio modifica el XML de esos documentos, que antes el SIFEN
  rechazaba.
- **Lectores del objeto SOAP.** `GCamCond::FromSifenResponseObject()` terminaba en `TypeError` con un único pago
  (`ext/soap` entrega un objeto y no un arreglo); `GTotSub::FromSifenResponseObject()` buscaba `dSubEx`, `dDesc` y
  `dTBaseGraIVA`, que no existen, y perdía el subtotal exonerado (F003), el total de descuentos (F011) y la base
  gravada total (F035); `GVehNuevo::FromSifenResponseObject()` lanzaba "Not implemented".
- La documentación de `Factura::setDatosComprasPublicas()` aclara que el año de contratación va con dos dígitos
  (`tdAnoCont`): con cuatro, el XML no valida.
- **Rechazo genérico con el WSDL real.** Con el WSDL del SIFEN, `SoapClient` devuelve `null` cuando la respuesta no
  es la que declara la operación, y así llega el rechazo genérico (`rRetEnviDe > rProtDe`, por ejemplo 0160 "XML
  Mal Formado.") en la consulta de RUC, en la consulta masiva de RUC, en la consulta de DE y de lote, en la
  recepción de lote y en los eventos: la librería
  terminaba en `Exception: Error Processing Request: null`. Ahora el facade decodifica ese rechazo de la respuesta
  cruda y devuelve la respuesta con su código, como ya describía la entrada de PK-29. Quien capturaba esa
  excepción recibe ahora la respuesta con `getDCodRes()` (o `getDCodResLot()`) en 160. Lo destaparon las capturas
  de `sifen-test` del 11/10/2026; las del 06/10 ya lo mostraban, pero el cliente de captura de los tests no
  reproducía el `null` y ahora sí.
- **Código de seguridad predecible** (PK-38). `RNG::GenerateAsString()`, con el que `GOpeDE` genera `dCodSeg`
  (B004, que entra en el CDC y en el QR), usaba `rand()`: desde PHP 7.1 es `mt_rand()` y con la misma semilla
  de `mt_srand()` repetía los códigos. Ahora usa `random_int()`, del generador criptográfico del sistema. Como
  `rand()`, sigue aceptando un máximo menor que el mínimo.

### Cambiado

- **Errores del facade con su causa** (PK-31, decisión Q-B4). `EnviarDE()`, `EnviarLoteDE()`,
  `ConsultaLote()`, `RegistrarEvento()` (y con él todos los métodos de eventos) y `ConsultarArchivoRUC()`
  conservan la excepción original en `getPrevious()`; antes se perdía el `SoapFault` (código, detalle y
  traza). Además capturan `\Throwable`: un `TypeError` del parseo llega como la excepción del facade en vez
  de como `Error`, con la respuesta cruda disponible en `GetLastResponse()`. Quien hoy capture `\Error` o
  `TypeError` alrededor de esos métodos debe capturar `\Exception` y revisar `getPrevious()`. En
  `EnviarLoteDE()` el parseo de la respuesta quedó dentro del `try`. `ConsultarRUC()` y `ConsultarDE()`
  siguen dejando pasar el `SoapFault` tal cual y solo envuelven los `\Error` del parseo.
- **CDC inválido con excepción** (PK-38). `CDCHelper::Generate()` devolvía el texto
  `"ERROR: El codigo de control no tiene 44 caracteres"` cuando el CDC salía corto, y uno largo o con letras
  fuera de lugar tal cual: los dos terminaban en el atributo `Id` del DE y el SIFEN lo rechazaba. Ahora lanza
  `InvalidArgumentException` con el CDC obtenido cuando no cumple el tipo `tCDC` del XSD (44 caracteres; el
  RUC puede terminar en una letra de la A a la D). La conversión del documento (`facturaToRDE()` y las
  demás) propaga la excepción. Quien comparaba el resultado con `"ERROR"` debe capturar la excepción.
- **Validaciones del lote antes de la red** (PK-41). Además del lote vacío, de más de 50 documentos o con
  tipos distintos, `EnviarLoteDE()` lanza una excepción, sin llamar al SIFEN, cuando los documentos son de
  RUC emisores distintos (rechazo 0301), cuando un CDC se repite (el SIFEN bloquea la recepción del RUC
  emisor de 10 a 60 minutos), cuando un documento no tiene CDC, tipo de documento o RUC emisor (contenido
  inválido, que también bloquea), y cuando el mensaje supera 1000 KB (ZIP en Base64 más el sobre; rechazo
  0301). Fuente: guía de mejores prácticas de envío de la DNIT, §4 y §5. Hasta 0.2.0 un documento sin
  `iTiDE` se enviaba sin control de tipo.
- `Sifen::ConsultaLote()` declara el tipo del parámetro: `string|int $nroLote` (antes sin tipo).
- **Fechas del SIFEN sin zona horaria** (PK-29). Las que llegan sin zona, como el `dFecProc` de los eventos dentro
  de `xContEv` en `ConsultarDE()`, se interpretan en `America/Asuncion`, la hora del SIFEN. Hasta 0.2.0 tomaban la
  zona por defecto de PHP, así que con otra zona configurada el instante quedaba corrido unas horas.
- `Constants::PKUATIA_VERSION` actualizado a `0.2.1`. README: consulta y deserialización de un DE, lote con
  `EsperarResultadoLote`, diagnóstico con `GetLastResponse` y la espera de 3 minutos antes de cancelar en
  `sifen-test`.
- **Formato de la constancia validado al cargarlo** (PK-35, decisión Q-B11). `GCamDEAsoc::setDNumCons()` exige un
  entero positivo de hasta 11 dígitos y `setDNumControl()` 8 caracteres entre letras, números y guion (`tgCamDEAsoc`,
  `DE_v150.xsd:1688`); si no se cumple lanzan `InvalidArgumentException`, y con ellos
  `addConstanciaDeNoSerContribuyente()`. Quien pase valores fuera de formato recibe la excepción donde antes el
  documento salía sin esos datos.

### Obsoleto

- `GCamEsp::getGGrupoSeg()`: nombre con errata; usar `getGGrupSeg()`. Sigue funcionando.
- `GGrupSup::getDEfectivo()`, `getDVuelto()`, `getDDonac()` y sus propiedades públicas `int`: devuelven la
  parte entera del monto; usar `getDEfectivoDecimal()`, `getDVueltoDecimal()` y `getDDonacDecimal()`.
- `GVehNuevo::getDPNet()`, `getDPBruto()`, `getDCapTracc()` y sus propiedades públicas `int`: devuelven la parte
  entera de la medida; usar `getDPNetDecimal()`, `getDPBrutoDecimal()` y `getDCapTraccDecimal()`.
- `GRasMerc::getDNumLote()`: el lote es texto y el getter devuelve su parte numérica; usar `getDNumLoteString()`.
- `GGroupTiEvt::getGeDevCCFFCue()`: pese a su nombre devuelve el grupo "devuelto"; se conserva por
  compatibilidad. Usar `getRGeDevCCFFCue()` o `getRGeDevCCFFDev()`.
- Los 16 setters de ítem de `Factura`, `Autofactura`, `NotaDeCredito` y `NotaDeDebito` (trait
  `ItemValorado`): `setEsTipoCambioPorItem()`, `setTipoDeCambioItem()`, `setNroLote()`,
  `setFechaVencimiento()`, `setNroSerie()`, `setNroPedido()`, `setInfoEmisor()`, `setCDCFacturaAnticipo()`,
  `setPartidaArancelaria()`, `setNcmMercosur()`, `setCodPaisOrigen()`, `setDncpCodigoGeneral()`,
  `setDncpCodigoEspecifico()`, `setDncpCodigoGTINProducto()`, `setDncpCodigoGTINPaquete()` y
  `setDetalleVehiculoNuevo()`. Nunca tuvieron efecto en el documento: el dato se informa con el parámetro del
  mismo nombre de `addItem()`, que lo asigna al ítem. Siguen guardando el valor en su propiedad, ahora
  declarada y también obsoleta, y avisan con `E_USER_DEPRECATED` qué parámetro usar. El XML no cambia.
- Código sin uso en la librería (PK-43): `Core\Fields\Response\DE\GResProcEve` (duplicado de
  `Core\Fields\Response\Event\GResProcEVe`, que es el que usan las respuestas de eventos),
  `Core\Responses\RespuestaConsultaLoteDE` (usar `RResEnviConsLoteDe`, que devuelve `Sifen::ConsultaLote()`),
  `Helpers\RequestXMLHelper` y `Utils\NumberFunctions`. Siguen funcionando.
- `RResEnviConsDe::showData()`: imprime con `echo`. Usar los getters de la respuesta.
- `TxContenEv::fromDOMElement()`: nunca funcionó (busca un elemento `contentEv` que no existe y llama a un
  método comentado). Para los eventos de una consulta de DE usar `RContDe::FromXContenDE()` y `getRContEvs()`.

### Eliminado

- `src/Core/Responses/RespuestaRecepcionEvento.php` y `RespuestaRecepcionLoteDE.php` (decisión Q-B6): archivos
  de 0 bytes desde 09/2023, sin ninguna clase, así que ningún código podía usarlos.

### Homologación en `sifen-test` (11/10/2026)

- ✅ **FE a crédito en cuotas sin entrega inicial** y **NR asociada a esa FE**: aprobadas (0260).
- ✅ **AF con constancia de no ser contribuyente con número y número de control** (PK-35): aprobada (0260), y la
  consulta del CDC devuelve los dos datos tal como se emitieron. Si la cédula del vendedor es un RUC registrado, el
  SIFEN la rechaza con 2562 "El vendedor no debe ser contribuyente".
- ✅ **FE con los cuatro grupos sectoriales combinados** (decisión Q-B8): aprobada.
- ✅ **FE con vehículo nuevo**, con el código de operación y medidas con decimales (decisión Q-B12): aprobada, y la
  consulta devuelve las medidas exactas.
- ✅ **Lote de 2 FE**: 0300 con un número de lote de 17 dígitos; `EsperarResultadoLote` consultó a los 10 minutos y
  obtuvo 0362 con las dos FE aprobadas.
- ✅ **Cinco eventos del receptor en un sobre** (conformidad total y parcial, disconformidad, desconocimiento y
  notificación de recepción): cada uno respondió 0143, "la firma digital del evento debe corresponder al receptor",
  lo esperado al firmarlos con el certificado del emisor. Los cinco pasan el esquema y la respuesta con varios
  eventos se lee completa.
- ❌ **FE en ANG**: 1206 con la descripción de la moneda recortada a 20 caracteres. Para las 15 monedas cuyo nombre
  supera los 20 caracteres que admite el XSD, sigue sin verificarse qué descripción acepta el SIFEN.
- El ambiente alternó respuestas correctas con el rechazo genérico 0160, que ahora la librería devuelve como
  respuesta (ver "Corregido"). Las capturas anonimizadas quedan en ekuat-ia, `06-ejemplos/respuestas-ws/2026-10-11/`.

## [0.2.0] — 2026-10-09

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

### Cambiado

- **README**: el ejemplo de FE al contado ahora llama a `calcTotSub(0)` antes del pago (sin esa
  llamada el snippet terminaba en `Error` al serializar, PK-40); la recomendación de consulta del
  lote sigue la guía de la DNIT (empezar a los 10 minutos, intervalos no menores a 10 minutos; antes
  decía ~1 minuto); nueva subsección "Zona horaria y fecha de firma"; `ActualizarDatosTransporte` y
  `RegistrarEvento` en la tabla de métodos; la tabla de tipos distingue lo homologado (FE) de lo
  validado contra el XSD de producción con homologación pendiente (AF, NC, ND, NR); la sección de
  pruebas describe la suite de conformidad contra los XSD.
- `Constants::PKUATIA_VERSION` pasa a `0.2.0`.
- `GVehTras::getDAdicVeh()`, `getDNroMatVeh()` y `getDNroVuelo()` declaran `?String` (ya devolvían
  `null`); `UnidadMedidaMapping::GetDesc()` y `MonedaMapping::GetDescription()` declaran `?String`.

### Obsoleto

- `GPaConEIni::getDMonTiPag(): int` (trunca el monto; usar `getDMonTiPagDecimal()`).
- `TipoDocImpresoAso::ComprobanteRetencion` (5): no existe en el XSD de producción; se conserva por
  compatibilidad y `GCamDEAsoc::toDOMElement()` lo rechaza con mensaje.

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
