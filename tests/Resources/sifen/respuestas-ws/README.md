# Respuestas SOAP reales de los WS del SIFEN (ambiente `sifen-test`)

> **Fuente:** capturas crudas de `SoapClient::__doRequest` (request y response sin parsear) tomadas con PKuatia
> contra `https://sifen-test.set.gov.py`, anonimizadas con `pkuatia-test/AnonimizarCapturas.php`.
> Propósito: cerrar los `[PENDIENTE DE VERIFICACIÓN]` sobre el formato real de las respuestas
> (ver `SESION-CONTEXT.md`, "Prueba a ejecutar al inicio de la Fase A de PKuatia"). **Al 09/10/2026 la tabla de
> esa sección queda cerrada por completo** (ver "Pendientes que cierra"). La corrida del 11/10/2026 (Fase B) cubre
> los demás tipos de documento, el lote y los eventos del receptor.

## Qué se conserva y qué se reemplaza en la anonimización

Se conservan **byte a byte** la estructura, el orden de los elementos, los namespaces y prefijos, los códigos,
los literales de `dMsgRes`, los formatos de fecha, los espacios y el estilo de escape del SIFEN. Se reemplazan:
RUC y DV del emisor (→ `80000000-5`) y del receptor (→ `80012345` con DV recalculado), razón social y datos de
contacto, el timbrado de prueba (→ `12345678`), los CDC (mismo RUC ficticio, DV final recalculado, mapa
consistente entre archivos) y el material criptográfico (`X509Certificate`, `SignatureValue`, `DigestValue`,
`dDigVal`, hash del QR), que pasa a marcadores en base64 válido que decodifican a su propio nombre
(`CERTIFICADO_X509_ANONIMIZADO`, etc.), de modo que la FE anonimizada **sigue validando** contra
`siRecepDE_v150.xsd` aunque su firma ya no sea verificable. Los `dId` (correlativo del cliente) y los
`dProtAut` no se anonimizan. El contenido escapado de `xContenDE` se anonimiza con las mismas reglas y se vuelve
a escapar igual que lo hace el SIFEN.

## Índice

| Carpeta | Contenido | Pendientes que cierra |
|---|---|---|
| [`2026-10-13/`](./2026-10-13/) | **Fase C, homologación del validador**: doce envíos con una sola violación o característica cada uno. Rechazos **1309**, **2365**, **1550**, **1300** (innominado en B2B: D202 antes que D208), **2400**, **1004**, **2503** (`dInfAdic`) y **0160** (`dCilin` numérico, el SIFEN aplica el patrón `/d` del XSD); aprobados **0260** con base gravada 0,01 mayor, B2G con `dEntCont` (PK-44), USD con tipo de cambio por ítem y fracción (Q-C8) y redondeo de EA008 a la unidad; un canario con el 0160 genérico. | Qué responde el SIFEN a cada regla que el validador predice; 2503 (rechaza); PK-44 (acepta); `dCilin` (rechaza siempre); tolerancia 0,01 en E735 y redondeo a la unidad en EA008; EA009 redondeado |
| [`2026-10-11/`](./2026-10-11/) | **Fase B**: FE a crédito en cuotas **0260**; NR **0260**; AF **rechazada 2562** (cédula del vendedor registrada como RUC) y **aprobada 0260** con constancia de no contribuyente; consulta de la AF **0422**; FE en ANG **rechazada 1206**; FE con los cuatro grupos de `gCamEsp` **0260**; FE con vehículo **0260** y su consulta **0422**; lote de dos FE **0300** y consulta del lote **0362**; sobre con **cinco eventos del receptor** firmados por el emisor, **0143 × 5**; consulta de RUC con **0160** genérico. README propio con cronología y observaciones | Texto de **0143**; `rRetEnviEventoDe` con **varios `gResProcEVe`** (`id` 1 a 5, en el orden del sobre); `dProtConsLote` de 17 dígitos y `rResEnviConsLoteDe` real (`dFecProc` = recepción del lote, `dMsgRes` = "Aprobado" por DE); `rRetEnviDe` de rechazo de negocio (2562, 1206) con `Id` y `dDigVal`; respuesta de consulta para AF y para `gVehNuevo` |
| [`2026-10-09/`](./2026-10-09/) | **Flujo completo**: consulta de RUC **0502**; consulta de un CDC nunca registrado **0420**; FE **aprobada 0260**; cancelación **rechazada 4009** 11 s después de aprobar; consulta del CDC aprobado **0422** (`xContenDE` sin eventos); cancelación **rechazada 0100 "Error Inesperado"** (transitorio); cancelación **aprobada 0600**; consulta del CDC cancelado **0422** con `xContEv` | `rRetEnviDe` aprobado (orden y literal 0260); `rRetEnviEventoDe` aprobado y rechazado (`dFecProc`, orden de `gResProcEVe`, literal 0600); forma de `xContenDE` y de `xContEv` (`rContEv` > `xEvento` + `rResEnviEventoDe`); `dProtAut` sigue tras la cancelación; literal 0420 |
| [`2026-10-06/`](./2026-10-06/) | Consulta de RUC **0502**; FE válida rechazada con **0160** y dos consultas de RUC rechazadas con **0160** en un ambiente degradado/bloqueado | Formato del `rRetEnviDe` de rechazo genérico |

**Queda abierto** (no requiere más capturas de este flujo): si el desfase de reloj que produce el 4009 (ver
observación 6 del 09/10) ocurre también en producción, cómo se ve `xContEv` con **más de un** `rContEv` (el 11/10 los
cinco eventos fueron rechazados, así que no quedaron registrados), y qué literal acepta la validación 1206 para las
monedas con `CodeName` de más de 20 caracteres (el 11/10 el truncado a 20 fue rechazado).

## 2026-10-11 — resumen

Cronología, tabla de archivos y observaciones completas en [`2026-10-11/README.md`](./2026-10-11/README.md).
Lo que cambia respecto de lo documentado hasta el 09/10:

1. **0143 tiene texto:** "La firma digital del evento debe corresponder al receptor del DE/DTE" (archivo `15`). Sigue
   sin estar en el MT v150.
2. **Varios eventos por sobre:** cinco `rEve` con `Id` 1 a 5 (dos `rGeVeConf`, `rGeVeDisconf`, `rGeVeDescon`,
   `rGeVeNotRec`) devolvieron cinco `gResProcEVe` en el mismo orden, cada uno con `dEstRes`, `id` y `gResProc`. El
   `id` repite el `Id` del `rEve`, así que el `@Id` correlativo funciona como clave de correlación.
3. **`rResEnviLoteDe` y `rResEnviConsLoteDe` reales** (archivos `13` y `14`): `dProtConsLote` de 17 dígitos,
   `dTpoProces` = 0, `dMsgResLot` "Procesamiento de lote {N} concluido", y por cada DE `gResProcLote { id, dEstRes,
   dProtAut, gResProc }` con `id` en minúscula y `dMsgRes` = "Aprobado" (no el literal de la recepción individual).
   El `dFecProc` de la consulta es la hora de recepción del lote.
4. **Rechazos de negocio en `rRetEnviDe`** (2562 y 1206, archivos `05` y `09`): a diferencia del 0160 genérico,
   traen `Id`, `dFecProc` y `dDigVal`; falta solo `dProtAut`. Los `dMsgRes` llevan el prefijo "TEST - ".
5. **El desfase de reloj del 09/10 se repite:** los `dFecProc` de los rechazos 2562 y 1206 van unos 2,5 minutos
   adelantados respecto de la hora de la llamada (11:44:48 frente a 11:42:18; 11:50:35 frente a 11:48:05).
6. **0160 genérico también con el ambiente "sano":** entre llamadas aprobadas, una consulta de RUC idéntica a otra
   que acababa de responder 0502 devolvió 0160 (archivo `06`). Confirma el canario de solo lectura del 06/10.

## 2026-10-09 — cronología (hora de Asunción, `-03:00`)

| Hora | Archivo | Llamada | Respuesta | Duración |
|---|---|---|---|---|
| 17:04:23 | `01-rEnviConsRUC-*.xml` | `rEnviConsRUC` | `rResEnviConsRUC` **0502 "RUC encontrado"** | 272 ms |
| 17:04:34 | `02-rEnviConsDe-previo-*.xml` | `rEnviConsDe` de un CDC cuyo envío había quedado sin respuesta (conexión TLS cortada por el servidor a los 249 ms, 16:51) | `rEnviConsDeResponse` **0420 "Documento No Existe en SIFEN o ha sido Rechazado"** | 271 ms |
| 17:04:44 | `03-rEnviDe-*.xml`, `03-FE-firmada-anonimizada.xml` | `rEnviDe` con la FE firmada (válida contra el XSD) | `rRetEnviDe` **0260 "Autorización del DE satisfactoria"**, `dEstRes` = `Aprobado`, `dProtAut` = `50219661` | 633 ms |
| 17:04:56 | `04-rEnviEventoDe-*.xml` | `rEnviEventoDe` con `rGeVeCan` del CDC recién aprobado (`dFecFirma` 17:04:55) | `rRetEnviEventoDe` `Rechazado`, **4009 "TEST - Plazo de solicitud de cancelación de una FE extemporáneo"** | 463 ms |
| 17:05:06 | `05-rEnviConsDe-*.xml` | `rEnviConsDe` del CDC aprobado | `rEnviConsDeResponse` **0422 "CDC encontrado"**, `xContenDE` con rDE + `dProtAut` + `xContEv` vacío | 293 ms |
| 17:16:20 | `06-rEnviEventoDe-*.xml` | `rEnviEventoDe` con `rGeVeCan` del mismo CDC (`dFecFirma` 17:16:20) | `rRetEnviEventoDe` `Rechazado`, **0100 "Error Inesperado"**, `id` = `0` | 632 ms |
| 17:16:45 | `07-rEnviConsDe-previo-response-0422-sin-eventos.xml` | `rEnviConsDe` del CDC (antes de reintentar) | **0422**, `xContEv` vacío: el 0100 no registró nada | 308 ms |
| 17:16:56 | `08-rEnviEventoDe-*.xml` | `rEnviEventoDe`, mismo evento firmado de nuevo (`dFecFirma` 17:16:56) | `rRetEnviEventoDe` `Aprobado`, **0600 "Evento registrado correctamente"**, `dProtAut` = `1167531` | 471 ms |
| 17:17:06 | `09-rEnviConsDe-*.xml` | `rEnviConsDe` del CDC cancelado | **0422**, `xContenDE` con el rDE, `dProtAut` y `xContEv` con un `rContEv` | 440 ms |

Los `meta-*.json` guardan la cronología exacta de cada corrida con milisegundos y longitudes.

## Observaciones documentales (09/10)

1. **`rRetEnviDe` aprobado** (`03-rEnviDe-response.xml`): `rProtDe { Id, dFecProc, dDigVal, dEstRes, dProtAut, gResProc { dCodRes, dMsgRes } }`.
   El elemento del CDC se llama **`Id` con mayúscula** (`<ns2:Id>`), no `id` como dice `05-api-sifen/recepcion-de.md`
   (PP02); en el rechazo genérico (06/10) `Id`, `dDigVal` y `dProtAut` no aparecen. `dMsgRes` escapa los acentos
   como referencias numéricas (`Autorizaci&#243;n`). `dFecProc` lleva zona `-03:00`.
2. **`rRetEnviEventoDe`**: `dFecProc` (con zona) y `gResProcEVe { dEstRes, dProtAut, id, gResProc { dCodRes, dMsgRes } }`.
   El identificador es **`id` en minúscula**, va **después** de `dEstRes` (y de `dProtAut` cuando hay aprobación) y
   repite el `Id` del `rEve` enviado. En el 0100 "Error Inesperado" vino `id` = `0`: el SIFEN no llegó a asociar la
   respuesta al evento. Literal de 0600: "Evento registrado correctamente".
3. **`rEnviConsDeResponse`**: `dFecProc`, `dCodRes`, `dMsgRes`, `xContenDE`. Para un CDC existente **`dFecProc`
   es la fecha de aprobación del DE** (17:07:15 en las tres consultas del CDC 113, hechas a las 17:05, 17:16 y
   17:17), no la hora de la consulta; con 0420 sí es la hora de la consulta.
4. **`xContenDE` no es XML anidado: es texto**, con los `<` escapados como `&lt;` (los `>` no se escapan) y los
   caracteres no ASCII como referencias numéricas. Decodificado contiene, en este orden:
   `<?xml version="1.0" encoding="UTF-8"?>` + el `rDE` tal como se envió (byte a byte salvo los `&#NNN;`, firma
   incluida) + `\n<dProtAut>…</dProtAut>\n<xContEv>…</xContEv> ` (espacio final). **`dProtAut` del DE sigue
   presente después de la cancelación.** Como el `rDE` y cada evento traen su propia declaración XML, el texto
   decodificado **no es un documento XML bien formado**: hay que recortar el `rDE`, el `dProtAut` y el `xContEv` por
   separado antes de parsear. Archivos `05` (sin eventos) y `09` (con la cancelación).
5. **`xContEv`** (archivo `09`), indentado con tabulaciones y saltos de línea:
   ```
   <xContEv>
     <rContEv>
       <xEvento><?xml version="1.0" encoding="UTF-8"?><rGesEve xmlns="…"><rEve Id="1">…</rEve><Signature …>…</Signature></rGesEve></xEvento>
       <rResEnviEventoDe>
         <rRetEnviEventoDe>
           <dFecProc>2026-10-09T17:16:57</dFecProc>
           <gResProcEVe><dEstRes>Aprobado</dEstRes><dProtAut>1167531</dProtAut><gResProc><dCodRes>0600</dCodRes><dMsgRes>Se encontro el evento</dMsgRes></gResProc></gResProcEVe>
         </rRetEnviEventoDe>
       </rResEnviEventoDe>
     </rContEv>
   </xContEv>
   ```
   Un `rContEv` por evento, con el `rGesEve` **firmado tal como se envió** (`xEvento`) y la respuesta del evento
   (`rResEnviEventoDe` > `rRetEnviEventoDe`). Dentro de `xContEv` el `dFecProc` **no lleva zona horaria**, no hay
   `id` y el literal del 0600 es otro: **"Se encontro el evento"** (sin tilde). El evento rechazado con 0100 **no**
   aparece.
6. **4009 segundos después de aprobar.** La regla GDE004a exige que la firma del evento no supere las 48 h desde la
   aprobación. La FE fue aprobada con `dFecProc` = **17:07:15**, pero la hora real era 17:04:44 y el evento se firmó a
   las 17:04:55 (su `dFecProc` fue 17:04:57): el servicio de recepción de DE tiene el reloj **unos 2,5 minutos
   adelantado** respecto del de eventos, así que la cancelación quedó "antes" de la aprobación y el SIFEN la trató
   como extemporánea. A las 17:16 el mismo evento fue aceptado. Consecuencia práctica: en `sifen-test`, cancelar
   **al menos 3 minutos después** de la aprobación (o comparar el `dFecProc` recibido con el reloj propio).
   Verificar si ocurre también en producción: `[PENDIENTE DE VERIFICACIÓN]`.
7. **0100 "Error Inesperado"** en un evento (archivo `06`): respuesta transitoria del servidor; el mismo evento,
   firmado de nuevo 36 s después, fue aprobado. Tratarlo como error del servidor y reintentar, igual que el 0100
   transitorio de junio en recepción de DE (`05-api-sifen/recepcion-de.md`).
8. **0420** se devuelve con `dFecProc` y sin `xContenDE`. Literal exacto: "Documento No Existe en SIFEN o ha sido Rechazado".
9. El prefijo **"TEST - "** en `dMsgRes` es del ambiente de pruebas (solo apareció en el 4009).

## 2026-10-06 — cronología (hora de Asunción, `-03:00`)

| Hora | Archivo | Llamada | Respuesta | Duración |
|---|---|---|---|---|
| 07:02:31 | `01-rEnviConsRUC-request.xml`, `01-rEnviConsRUC-response-0502.xml` | `rEnviConsRUC` (consulta-ruc) | `rResEnviConsRUC` **0502 "RUC encontrado"** con `xContRUC` | 219 ms |
| 07:02:52 | `02-rEnviDe-request.xml`, `02-rEnviDe-response-0160.xml`, `02-FE-firmada-anonimizada.xml` | `rEnviDe` (recibe) con una FE **válida** contra el XSD de producción | `rRetEnviDe` **0160 "XML Mal Formado."**, `dEstRes` = `Rechazado` | 10 203 ms |
| 07:04:09 | `03-rEnviConsRUC-response-0160-0704.xml` | `rEnviConsRUC`, request idéntico al de las 07:02:31 salvo `dId` | `rRetEnviDe` **0160 "XML Mal Formado."** | 194 ms |
| 07:40:22 | `04-rEnviConsRUC-response-0160-0740.xml` | `rEnviConsRUC`, ídem, 36 minutos de enfriamiento | `rRetEnviDe` **0160 "XML Mal Formado."** | 256 ms |

## Observaciones documentales (06/10)

1. **El 0160 no prueba que el XML esté mal formado.** La FE de `02-FE-firmada-anonimizada.xml` valida contra
   `siRecepDE_v150.xsd` y es idéntica en estructura y valores a una FE aprobada el 12/06/2026 (y la misma FE fue
   aprobada el 09/10). Dos minutos después, una consulta de RUC byte a byte igual a una que acababa de responder 0502
   también recibió 0160. Es el mismo patrón que el 0100 transitorio de junio de 2026
   (`05-api-sifen/recepcion-de.md`): tratar como estado degradado o bloqueo temporal del ambiente y reintentar más
   tarde, con un canario de solo lectura antes de gastar numeración.
2. **El sobre de rechazo genérico es siempre `rRetEnviDe`**, incluso para `rEnviConsRUC`, con `rProtDe { dFecProc, dEstRes, gResProc }`.
3. **Duración del bloqueo:** persistió al menos 38 minutos. La guía de la DNIT (`10-guias/mejores-practicas-envio-de.md` §5)
   habla de 10 a 60 minutos "según la cantidad de reincidencias"; conviene un único reintento tras una hora.
4. Un corte de la conexión TLS por el servidor durante `rEnviDe` (09/10 16:51, 249 ms, sin respuesta) **no registró**
   el DE: la consulta posterior de ese CDC devolvió 0420.

## Cómo repetir y completar

```
pkuatia-test> ./Run.ps1 CapturaRespuestas.php [--consultar=<CDC>] [--sin-canario] [--inexistente]
pkuatia-test> ./Run.ps1 CapturaFaseB.php          # corrida del 11/10: cuotas, NR, AF, ANG, sectores, vehículo, lote, eventos del receptor
pkuatia-test> php AnonimizarCapturas.php --dir=captures/<fecha> --out=06-ejemplos/respuestas-ws/<fecha>
```

Con `--consultar` de un CDC ya aprobado (0422) el script omite el envío de una FE nueva y pasa directamente a la
cancelación y a la consulta; con el CDC de un envío que quedó sin respuesta (0420) sigue el flujo normal con un
número nuevo.
