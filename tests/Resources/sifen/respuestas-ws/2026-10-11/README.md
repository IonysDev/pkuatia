# Capturas de sifen-test del 11/10/2026 (PKuatia, Fase B)

> **Fuente:** respuestas SOAP crudas de `sifen-test`, tomadas el 11/10/2026 con el harness privado de PKuatia
> (`pkuatia-test/CapturaFaseB.php`, rama `fase-b/p1-deserializacion`). Se anonimizaron con `AnonimizarCapturas.php`:
> el emisor pasa a ser el RUC 80000000 y el receptor el 80012345; las direcciones, los teléfonos y los correos son
> ficticios; el certificado, las firmas y los hashes se reemplazan por marcadores. El ZIP del lote, que es el `xDE` de
> `rEnvioLote`, también se reemplaza por un marcador, porque no se puede anonimizar por dentro; los dos rDE del lote
> están aparte. Los CDC conservan su estructura, con el RUC ficticio y el dígito verificador recalculado. Los números
> de protocolo (`dProtAut`) y de lote (`dProtConsLote`) se conservan. La constancia de la autofactura, la cédula del
> vendedor, el transportista y los datos del vehículo son inventados.

## Llamadas

El ambiente estuvo intermitente: entre las llamadas exitosas hubo canarios con el rechazo genérico 0160 y un envío
cortado por SSL, que no se guardaron aquí salvo el 0160 de la fila 06.

| Hora (Asunción) | Operación | ms | Bytes de respuesta | Registro |
|---|---|---|---|---|
| 11:40:54 | `rEnviConsRUC` | 210 | 541 | `meta-1140.json` |
| 11:41:15 | `rEnviConsDe-fe-cuotas-previa` | 223 | 413 | `meta-1140.json` |
| 11:41:36 | `rEnviDe-fe-cuotas` | 515 | 645 | `meta-1140.json` |
| 11:41:57 | `rEnviDe-nr` | 746 | 645 | `meta-1140.json` |
| 11:42:18 | `rEnviDe-af` | 442 | 615 | `meta-1140.json` |
| 11:45:34 | `rEnviConsRUC` | 206 | 541 | `meta-1145.json` |
| 11:45:54 | `rEnviConsRUC-vendedor` | 193 | 455 | `meta-1145.json` |
| 11:46:47 | `rEnviConsRUC` | 204 | 541 | `meta-1146.json` |
| 11:47:03 | `rEnviDe-af` | 463 | 645 | `meta-1146.json` |
| 11:47:18 | `rEnviConsDe-af` | 245 | 10065 | `meta-1146.json` |
| 11:47:49 | `rEnviConsRUC` | 200 | 541 | `meta-1147.json` |
| 11:48:05 | `rEnviDe-fe-ang` | 452 | 658 | `meta-1147.json` |
| 11:48:21 | `rEnviDe-fe-sectores` | 471 | 645 | `meta-1147.json` |
| 11:48:36 | `rEnviDe-fe-vehiculo` | 475 | 645 | `meta-1147.json` |
| 11:48:52 | `rEnviConsDe-fe-vehiculo` | 227 | 10167 | `meta-1147.json` |
| 11:49:42 | `rEnviConsRUC` | 209 | 541 | `meta-1149.json` |
| 11:49:59 | `rEnvioLote` | 252 | 473 | `meta-1149.json` |
| 11:51:05 | `rEnviConsRUC` | 215 | 541 | `meta-1151.json` |
| 11:51:23 | `rEnviEventoDe-receptor` | 1911 | 1521 | `meta-1151.json` |
| 11:59:59 | `rEnviConsLoteDe` | 216 | 956 | `meta-1149.json` |

## Archivos

| Prefijo | Documento o evento | Resultado |
|---|---|---|
| 01 | Consulta de RUC del emisor (canario) | 0502 |
| 02 | Consulta del CDC de un envío cortado por SSL | 0420: el SIFEN no lo registró, así que no hubo CDC repetido |
| 03 | FE a crédito en dos cuotas, sin entrega inicial | 0260 |
| 04 | NR asociada a la FE de la fila 03 | 0260 |
| 05 | AF con constancia de no ser contribuyente y vendedor con cédula 1234567 | 2562 "El vendedor no debe ser contribuyente" |
| 06 | Consulta de RUC con el ambiente degradado | 0160 genérico dentro de `rRetEnviDe > rProtDe` |
| 07 | La misma AF con otra cédula de vendedor | 0260 |
| 08 | Consulta de la AF de la fila 07 | 0422, con `dNumCons` y `dNumControl` tal como se emitieron |
| 09 | FE en ANG | 1206 "Descripción de la moneda de la operación no corresponde al código" |
| 10 | FE con los cuatro grupos de `gCamEsp` | 0260 |
| 11 | FE con vehículo nuevo, `iTipOpVN` = 2 y medidas con decimales | 0260 |
| 12 | Consulta de la FE de la fila 11 | 0422, con las medidas y sus decimales |
| 13 | Lote de dos FE | 0300, `dProtConsLote` de 17 dígitos |
| 14 | Consulta del lote a los 10 minutos | 0362, las dos FE aprobadas |
| 15 | Un sobre con cinco eventos del receptor sobre la FE de la fila 03 | 0143 en cada uno: los firmó el emisor |

## Observaciones

1. **Rechazo genérico en la consulta de RUC.** Con el ambiente degradado, la consulta de RUC alternó la respuesta
   correcta (0502) con el 0160 "XML Mal Formado." dentro de `rRetEnviDe > rProtDe` (fila 06), igual que el 06/10. Ese
   elemento no es el que declara la operación en el WSDL, así que un cliente SOAP en modo WSDL recibe `null` y tiene
   que leer el rechazo de la respuesta cruda.
2. **2562 en la AF.** El SIFEN cruza la cédula del vendedor (`dNumIDVen`) con el registro de RUC: la cédula inventada
   1234567 es un RUC registrado y la AF se rechazó con "El vendedor no debe ser contribuyente" (fila 05).
3. **Constancia de no ser contribuyente con número y control.** Con `iTipCons` = 1, `dNumCons` (11 dígitos) y
   `dNumControl` (8 caracteres) se aceptaron (0260) y la consulta los devuelve (filas 07 y 08). El ambiente de pruebas
   no cotejó los valores inventados con el registro de constancias.
4. **1206 con monedas de nombre largo.** La descripción de ANG recortada a 20 caracteres ("Netherlands Antillia") se
   rechaza con 1206 (fila 09). El XSD no admite el `CodeName` completo de 29 caracteres (`tdDMoneTiPag`, 3 a 20), así
   que sigue abierto qué literal acepta la validación para las 15 monedas de la sección 16 de
   `04-schemas-xsd/xsd-produccion-vs-manual.md`.
5. **Grupos sectoriales combinados.** Una FE con energía, seguros, supermercados y datos adicionales a la vez se
   aprobó (fila 10).
6. **Lote.** `dProtConsLote` llegó con 17 dígitos (fila 13). En la consulta del lote, `dFecProc` es la hora de
   recepción del lote, 11:49:59, y no la de la consulta, y cada documento trae `0260 Aprobado`, no el texto de la
   recepción individual (fila 14).
7. **Varios eventos en un sobre.** Los cinco eventos del receptor volvieron en cinco `gResProcEVe` con `id` del 1 al 5,
   cada uno con 0143 "La firma digital del evento debe corresponder al receptor del DE/DTE" (fila 15). El SIFEN llegó a
   esa regla, así que los cinco pasaron el esquema.
