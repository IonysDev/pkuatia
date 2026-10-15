# Capturas de sifen-test del 13/10/2026 (PKuatia, Fase C, homologación del validador)

> **Fuente:** respuestas SOAP crudas de `sifen-test`, tomadas el 13/10/2026 entre las 05:57 y las 06:12 (hora de
> Asunción) con el harness privado de PKuatia (`pkuatia-test/CapturaFaseC.php`, rama `fase-c/validacion-errores`,
> 0.3.0 en desarrollo). Se anonimizaron con `AnonimizarCapturas.php`: el emisor pasa a ser el RUC 80000000 y el receptor
> el 80012345 (con el dígito verificador que corresponda, o el equivocado cuando el caso lo pedía); direcciones,
> teléfonos y correos son ficticios; el certificado, las firmas y los hashes se reemplazan por marcadores. Los CDC
> conservan su estructura, con el RUC ficticio y el dígito verificador recalculado. Los `dProtAut` se conservan.

Cada documento se envió con **una sola** violación de una regla del Manual Técnico (o con una característica cuyo
tratamiento por el SIFEN había que confirmar). Antes de enviarlo, el validador de reglas de PKuatia (`validarReglas()`
sobre el rDE firmado) anotó lo que predecía; abajo, lo que respondió el SIFEN.

## Llamadas

| Hora (Asunción) | Operación | ms | Bytes de respuesta | Registro |
|---|---|---|---|---|
| 05:57:03 | `rEnviConsRUC` (canario) | 205 | 541 | `meta-0557.json` |
| 05:58:05 | `rEnviDe-1309` | 518 | 633 | `meta-0557.json` |
| 05:59:06 | `rEnviDe-2365` | 472 | 640 | `meta-0557.json` |
| 06:00:07 | `rEnviDe-1550` | 472 | 708 | `meta-0557.json` |
| 06:01:07 | `rEnviDe-1319` | 422 | 648 | `meta-0557.json` |
| 06:02:09 | `rEnviDe-2400` | 789 | 667 | `meta-0557.json` |
| 06:03:10 | `rEnviDe-1004` | 374 | 627 | `meta-0557.json` |
| 06:04:2x | `rEnviConsRUC` (canario, **0160 genérico**) | — | — | `meta-0604.json` |
| 06:05:56 | `rEnviConsRUC` (canario) | 206 | 541 | `meta-0606.json` |
| 06:06:57 | `rEnviDe-2503` | 465 | 657 | `meta-0606.json` |
| 06:07:58 | `rEnviDe-1911` | 482 | 645 | `meta-0606.json` |
| 06:08:59 | `rEnviDe-b2g` | 476 | 645 | `meta-0606.json` |
| 06:09:59 | `rEnviDe-cilin` | 217 | 634 | `meta-0606.json` |
| 06:11:00 | `rEnviDe-usd-item` | 488 | 645 | `meta-0606.json` |
| 06:12:01 | `rEnviDe-redondeo` | 453 | 645 | `meta-0606.json` |

## Archivos y resultados

| N° | Caso | Documento firmado | Validador de PKuatia | SIFEN | Lectura |
|---|---|---|---|---|---|
| 01 | Canario `rEnviConsRUC` | — | — | **0502** RUC encontrado | — |
| 02 | DV del RUC del receptor incorrecto (D207) | `02-1309-firmada-anonimizada.xml` | 1309 | **1309** | coincide |
| 03 | Total general (F014) 1 000 Gs mayor que F008 − F013 + F025 | `03-2365-…` | 2365 | **2365** | coincide; confirma la fórmula de `campos-obligatorios.md` |
| 04 | Contado sin `gPaConEIni` | `04-1550-…` | 1550 | **1550** | coincide |
| 05 | Receptor innominado (D208 = 5) en B2B | `05-1319-…` | 1300 y 1319 | **1300** | el SIFEN informa primero D202 (1300); 1319 queda detrás |
| 06 | NC sin documento asociado (H001) | `06-2400-…` | 2400 | **2400** | coincide |
| 07 | `dFecFirma` 30 min adelantada | `07-1004-…` | 1004 | **1004** | coincide |
| 08 | Canario `rEnviConsRUC` | — | — | **0160** "XML Mal Formado." (genérico) | ambiente degradado un minuto; el reintento siguiente dio 0502 |
| 09 | Canario `rEnviConsRUC` | — | — | **0502** | — |
| 10 | FE con `dInfAdic` (J003, fuera de la firma) | `10-2503-…` | 2503 (era advertencia) | **2503** | el SIFEN rechaza J003: desde 0.3.0 es un error del validador |
| 11 | Base gravada al 10 % con 0,01 de más y liquidación coherente | `11-1911-…` | 1911 (antes del ajuste) | **0260** aprobado | el SIFEN tolera 0,01 en E735; el validador admite ahora 0,01 en 1910/1911/1913/1921 |
| 12 | FE B2G con `gCompPub` y `dEntCont` (PK-44) y códigos DNCP | `12-b2g-…` | sin errores | **0260** aprobado | el SIFEN acepta `dEntCont` sin el espacio del XSD publicado: PK-44 cerrada |
| 13 | Vehículo nuevo con `dCilin` "1600" | `13-cilin-…` (no cumple el XSD) | sin errores de regla; XSD 0160 | **0160** "XML malformado [El valor 1600 del elemento: dCilin es invalido]" | el SIFEN aplica el patrón `/d` del XSD tal cual: `dCilin` no admite ningún valor numérico |
| 14 | FE en USD con tipo de cambio por ítem y fracción (EA009 redondeado a 2 197 451) | `14-usd-item-…` | sin errores | **0260** aprobado | el redondeo de EA009 al guaraní entero (Q-C8) se acepta |
| 15 | FE con 3 × 33 333,33 (EA008 exacto 99 999,99 informado como 100 000) | `15-redondeo-…` | sin errores | **0260** aprobado | el SIFEN tolera el redondeo de EA008 a la unidad de la moneda (1853) |

Los `rEnviDe-*-request.xml` llevan el rDE firmado dentro de `xDE`; los `*-firmada-anonimizada.xml` son los mismos
rDE sueltos. Todos validan contra `siRecepDE_v150.xsd` salvo el 13 (`dCilin`).

## Observaciones

1. **Los rechazos por regla traen `Id` y `dDigVal`** en `rProtDe` (y ningún `dProtAut`), a diferencia del 0160 genérico
   del ambiente degradado, que no trae `Id` ni `dDigVal` (09/10 y 11/10).
2. **"TEST - "**: el ambiente de pruebas antepone `TEST - ` al `dMsgRes` de las validaciones del MT (no al 0260 ni al
   0160 del XSD).
3. **Reloj de recepción adelantado**: `dFecProc` 06:00:35 para un envío hecho a las 05:58:05 (unos 2,5 minutos, como
   el 09/10). Una firma 30 minutos adelantada se rechaza con 1004.
4. **0160 genérico intermitente**: el canario de las 06:04 recibió "XML Mal Formado." a una consulta de RUC byte a byte
   igual a la de las 05:57; un minuto después el ambiente respondió normalmente y los seis envíos siguientes salieron
   bien. Reintentar enseguida es el protocolo correcto.
5. **Orden de las validaciones**: con dos reglas violadas (D202 y D208), el SIFEN informa solo la primera en el orden
   de los campos del MT.
6. **Tolerancias**: el SIFEN aprobó una base gravada 0,01 mayor que la exacta (con su liquidación coherente) y el
   redondeo del total del ítem a la unidad (99 999,99 → 100 000). No se probó una diferencia mayor.

## Pendientes que cierra

- 2503: incluir J003 `dInfAdic` en el DE **sí** se rechaza (el XSD lo admite, el SIFEN no). PKuatia lo emite solo si
  se pasa `$infoAdicionalEmisor` a `FirmarDE()`; el validador lo marca como error.
- PK-44: `dEntCont` (sin el espacio final del XSD publicado) se acepta.
- `dCilin` (E786): el patrón `/d` del XSD de producción no es un error de transcripción que el SIFEN corrija: lo
  aplica. No corregirlo en las copias locales; no hay valor numérico aceptable.
- Q-C8: EA009 redondeado al guaraní entero se acepta.
- 1853/2365: el redondeo de EA008 a la unidad de la moneda se acepta.
