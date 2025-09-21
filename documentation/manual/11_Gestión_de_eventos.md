# 11 Gestión de eventos

11. Gestión de eventos  
 
Entiéndase por evento toda ocurrencia o suceso registrado en SIFEN por el cual se asigna una marca , 
se modifica o afecta el estado de un Documento Electrónico  o Documento Tributario Electrónico y 
puede darse a lo largo del ciclo de vida de este. Puede darse de manera previa o posterior a la 
aprobación del DTE, dependiendo de su naturaleza.  
A manera de ejemp lo de eventos se tiene los siguientes:  
• Cancelación  
• Devolución y Ajuste  de preci os (evento automático por la emisión notas de crédito o débito 
electrónicas)  
• Disconformidad de un DE o DTE  por parte del receptor  
Los eventos pueden ser de dos tipos:  
• De registr o AUTOMÁTICO  generados por SIFEN: Ejemplo: evento de ajuste  de una FE por la 
aprobación de un a Nota de Crédito Electrónica asociada a la FE.  
• De registro REQUERIDO  por el consumo de los Servicios Web dispuestos por SIFEN para los 
actores intervinientes: Ejemplo: Manifestaciones del receptor (disconformidad y 
desconocimiento de la oper ación).  
Dependiendo de quién lo solicite, los eventos se clasifican de la siguiente manera:  
11.1. Eventos realizados por el emisor  
 
Son aquellos eventos originados por el emisor, cuan do surge alguna situación que modifica la 
secuencia numérica o el contenido del  DE. El emisor cuenta con la facultad para efectuar los eventos 
que se citan a continuación:  
 
11.1.1.  Inutilización  de número de DE  
 
Es un evento solicitado por el emisor electrónico. Pueden darse tres situaciones : 
• Saltos en la numeración : Por algún error en el si stema de facturación del emisor, se produce 
un salto en la numeración. Dicha situación debe ser comuni cada, reportando el tip o de DE 
y saltos en el rango de numeración , de manera a no alterar la correlatividad numérica . 
• Detección de errores técnicos (de ll enado)  en la emisión del DE . 
• Por rechazo del SIFEN:   Cuando un DE ha sido rechazado por el SIFEN y su ajuste implique 
la modi ficación del CDC, indefectiblemente esa numeración no utilizada debe ser inutilizada  
  
Sugerencia: Para poder inutilizar un documen to, se sugiere que dicho evento se realice 
antes de la entrega del comprobante, envío o salida de la mercadería y de la trans misión del 
DE al SIFEN.  
 
 
 
septiembre  de 2019                113 
El evento de inutilización de la numeración de un DE podrá realizarse siempre y cuando éste no haya 
sido ap robado por el SIFEN . El estado de los números de DE inutilizados quedará registrado en el 
SIFEN.  
Es posible el registro de la inutilización de un rango de hasta 1000 números secuenciales  de DE toda 
vez que no exista  ningún número utilizado en dicho rango.  
Se requiere la información del motivo de la inutilización del rango de numeración en un campo lib re 
de texto de hasta 150 caracteres.  
 
11.1.2.  Cancelación  
 
Es un evento solicitado por el emisor, ocurre cuando el comprobante es emitido sin errores y 
transmitido y aprobado por el SIFEN se convierte en un DTE, sin embargo, por algún motivo no se 
concreta la tran sacción.  
El emisor electrónico puede solicitar la CANCELACIÓN de cualquier tipo de DTE y tiene hasta 48 hs. 
posteriores a la aprobación de uso del DE para gen erar el evento. El estado de los DTE cancelados 
quedará registrado en el SIFEN y es obligatoria la  conservación por 5 años.  
 
11.1.3.  Devolución y Ajuste de precios  
 
Son eventos automáticos generados por la emisión de una NOTA DE CRÉDITO o DÉBITO 
ELECTR ÓNICA S. 
Es un evento exclusivo de la FACTURA ELECTRÓNICA, puesto que existen documentos para dicho s 
efecto s. Es imperativo que la Nota de Crédito o Débito Electrónica emitida se encuentre vinculada 
a una FE ya existente en la base de datos del SIFEN; o sea, se requier e la configuración del hecho 
imponible, que la factura haya sido entregada al cliente , transmitida  y aprobada por  SIFEN. Es 
importante comprender que las Notas de Crédito o Débito Electrónicas como tales, no son eventos, 
sino que la operación resultante de  su emisión y aprobación en SIFEN genera un evento automático  
del sistema .  
La coexistencia de documentos electrónicos y pre -impresos solo será  permitida  en las etapas de l 
Plan Piloto y Voluntariedad . Esto  permite que la Nota de Crédito o Débito Electrónic a emitida se 
encuentre vinculada a una factura pre-impresa. Igualmente,  el sistema genera el evento automático 
de AJUSTE pero no realiza validaciones sobre los montos  ajustados.  
Cuando hablamos de AJUSTE nos referimos a los casos en que se acepten devoluci ones en forma 
parcial o se concedan descuentos y bonificaciones.  
 
 
 
septiembre  de 2019                114 
Las FE con Notas de Crédito o Débito Electrónicas asociadas obligatoriamente deberán  ser 
conservadas por 5 años, en estos casos, el receptor no tendrá derecho al crédito del IVA contenido 
en la misma ya sea en forma total o parcial.  
El estado de las FE con devolucion es o ajustes de precios  quedará registrado en el SIFEN. En caso de 
devoluciones o ajustes de precios totales de  una FE, no será  posible retractarse. Para corregir esta 
situación, e l emisor deberá generar una nueva FE exactamente igual.  
 
11.1.4.  Endoso de FE  (evento futuro)   
 
Es un evento solicitado por el emisor, ocurre cuando la factura electrónica, cuya aprobación de uso 
ha sido otorgada por la Administración Tributaria, es seleccionada por éste para ser comercializada 
en el mercado financiero local.  Este evento se va detallar en versión futura del MT.  
 
11.2. Eventos r egistrados  por el receptor  
 
Son aquellos eventos generados por una persona física o jurídica, a cuyo nombre fue emitido un 
docum ento electrónico . El registro del evento de receptor se puede dar sobr e un DE o DTE.  
Los eventos del receptor no invalidarán el DE o DTE, sino que quedarán marcados en el SIFEN y el 
emisor electrónico podrá conocer dicha situación. El receptor cuenta con l a facultad de comunicar 
a la Administración Tributaria lo siguiente:  
 
11.2.1.  Conform idad con el DTE  
 
El receptor informa a la Administración Tributaria que conoce dicho documento y confirma que 
están correctos todas las informaciones del DTE, que no existen error es o inconsistencias en forma 
parcial o total y que ha recibido  la mer cadería o servicio.  
 
11.2.2.  Disconformidad con el DTE  
 
El receptor informa a la Administración Tributaria que conoce dicho documento, pero que en el 
comprobante existen errores o inconsistencia s en forma parcial o total.  
11.2.3.  Desconocimiento con el DE o DTE  
 
El receptor informa a la Administración Tributaria que desconoce el documento que fuera emitido 
a su nombre y la operación detallada en el mismo.  
 
 
 
septiembre  de 2019                115 
Para efecto de gestionar ambos eventos, el recep tor podrá utilizar los servi cios del SIFEN para 
descargar el detalle todos los DTE emitidos a su nombre o razón social  
 
11.2.4.  Notificación de recepción de un DE o DTE 
 
El receptor informa a la Administración Tributaria que conoce dicho documento , sin embargo, aú n 
no tiene condiciones para manifestarse de forma conclusiva (con Conformidad, Disconformidad o 
Desconocimiento). Es un evento opcional y no se registra este evento si ya existe otro evento 
registrado de manifestación del destinatario.  
Para efecto de gesti onar ambos eventos, en el fu turo, el receptor podrá utilizar los servicios del 
SIFEN o en el Portal e -kuatia para descargar el detalle todos los DTE emitidos a su nombre o razón 
social  según reglas que se van establecer por la SET.  
 
11.2.5.  Tipología de los evento s del receptor  
 
- Eventos conc lusivos (conformidad y disconformidad) :  corresponden a aquellos eventos 
del receptor que podrían generar una acción del emisor para modificar el estado de un DTE, 
como un ajuste por la emisión de notas de crédito o débito elect rónica o cancelar un DTE. 
Los eventos conclusivos solo son realizados sobre DTE.  
  
- Eventos informativos (desconocimiento y notificación de recepción):  corresponden a 
aquellos eventos del receptor que colocan una marca a un DTE o registran la recepción de 
un DE, a diferencia de los eventos conclusivos, los eventos informativos no generan una 
acción del emisor. Los eventos informativos pueden ser realizad os sobre DTE y DE.  
 
11.3. Eventos automáticos:  Esta transaccionalidad informática de SIFEN permite vincular 
dete rminados eventos y situaciones en los DTE  sin la intervención directa del emisor ni del 
receptor, por lo tanto, no son generados por los facturadores electrónicos , sino que se 
devuelve como parte de la consulta de un DTE y se encontrará en el contenedor de l evento.  
 
• Eventos automáticos por SIFEN  
o Ejemplo 1:  registro automático del evento -Vinculación de la nota de crédito o 
Débito automático a una Factur a Electrónica - que se activa cuando se aprueba en 
SIFEN la nota de crédito o Débito, según el caso.  
o Ejempl o 2: registro automático del evento -Vinculación automática de la nota de 
Remisión Electrónica a una Factura Electrónica - la cual se activa cuando se aprueba 
en SIFEN la nota Remisión Electrónica.  
 
 
 
septiembre  de 2019                116 
 
• Eventos automáticos por interoperabilidad  
o Ejemplo 3:  inter operabilidad con sistemas de la SET (Tesaka – retenciones y 
Marangatu – Créditos fiscales por transferencia o devolución)  
 
11.4. Eventos registr ados  por la SET  (evento futuro)   
 
La Administración Tributaria tiene la potestad para realizar el siguiente evento:  
 
11.4.1.  Impugnación  de DTE  
 
Cuando como consecuencia de un proceso de control se compruebe la falta de veracidad de la 
operación económica que respalda un DTE obrante en el SIFEN, la Administración Tributaria podrá 
impugnar la validez del mismo.  
Con excepción a los  eventos del Emisor de Cancelación de DTE e Inutilización de número de DE, y a 
los eventos automáticos de SIFEN de Anulación y Asociac ión, la descripción detallada y efectos de 
los demás eventos, se definirán en una versión posterior del prese nte MT y se p resentan acá como 
Eventos Futuros . 
 
 
 
 
 
 
Tabla  J: Resumen de los eventos de SIFEN según los actores  
N° Evento  Actor  Tipo  Transmisión  Plazo  Alcance 
DE Criterios  Condiciones  Acce
so 
1 Cancelación 
del DTE  Emisor  Registro 
Requerido  
 
Evento 
conclusivo  WS Sincróni co 
Eventos  Hasta 48 horas de la aprobación 
del DTE  cuando es igual a FE . 
 
Hasta 168 horas de la 
aprobación del DTE cuando los 
documentos electrónicos (NCE, 
NDE, NRE, AFE) son distintos a 
FE Todos los 
DTE • DTE en SIFEN  
• Situación Aprobado o Aprobado 
con obser vación (por 
extemporaneidad)  
• Se requiere informar la 
justificativa de la Cancelación 
(campo texto libre)  
• Para un DTE que tenga otros 
DTEs asociados, se debe 
realizar la cancelación del último 
DTE hasta llegar al inicial.  • Hubo errores en la emisión 
del DE  
• La mercadería no fue 
entregada al cliente  
• El servicio no ha sido 
realizado al cliente  WS 
2 Inutilización 
del número de 
DE Emisor  Registro 
Requerido  
 
Evento 
conclusivo  WS Sincrónico 
Eventos  Dentro de los 15 (quince) 
primeros días del mes siguiente 
al acaec imiento del hecho, 
deberá  comunicar la 
inutilización de la numeración 
del DE.   
 
Y hasta fecha límite de validez 
del timbrado (plazo del sistema)  Todos los 
DE • Número del DE en el rango de 
inutilización no existe en base de 
datos de SIFEN  
• Inutilización por r ango de hasta 
1000 (parámetro de SIFEN) 
números de DE no utilizados  
• Se requiere informar la 
justificativa de la Inutilización  
(campo texto libre)  • Saltos de Numeración  
• Decisión de la empresa de 
inutilización de un número 
de DE que puede haber 
sido rechazado  por errores 
técnicos (Errores de llenado 
de forma del DE) y no 
ocurrió el hecho generador 
del impuesto y no hubo el 
envío del DE al Receptor  WS 
10 Notificación 
de recepción 
DE o DTE  Receptor  Registro 
Requerido  
 
Evento 
informativo  WS Sincrónico 
Eventos o Portal 
SIFEN  Hasta 45 (cuarenta y cinco) días 
contados desde la fecha de 
emisión  Todos los 
DE o  DTE DTE o DE recepcionado   WS/P
ORTA
L 
11 Conformidad 
DTE  Receptor  Registro 
Requerido  
 
Evento 
conclusivo  WS Sincrónico 
Eventos o Portal 
SIFEN  Hasta 45 (cuarent a y cinco) días 
contados desde la fecha de 
emisión  Todos los 
DTE DTE  WS/P
ORTA
L 
12 Disconformid
ad DTE  Receptor  Registro 
Requerido  
 WS Sincrónico 
Eventos o Portal 
SIFEN  Hasta 45 (cuarenta y cinco) días 
contados desde la fecha de 
emisión  Todos los 
DTE DTE   WS/P
ORTA
L 
 
 
 
septiembre  de 2019                118 
Evento 
conclusivo  
13 Desconocimi
ento DE o 
DTE Receptor  Registro 
Requerido  
 
Evento 
informativo   WS Sincrónico 
Eventos o Portal 
SIFEN  Hasta 45 (cuarenta y cinco) días 
contados desde la fecha de 
emisión  Todos los 
DE o  DTE DTE o DE recepcionado    WS/P
ORTA
L 
14 Devolución y 
Ajuste de 
precios  SIFEN  Registro  
Automátic
o  • Plazo límite definido por la 
SET 
• Plazo de prescripción  
 FE • Emisión de una NCE o NDE 
(asociación) para una FE con 
situación Aprobada o Aprobado 
con observación (por 
extemporaneidad)  en SIFEN  
• La FE asociada se encuentra en 
SIFEN con situación de 
Aprobado o Aprobado 
Extemporáneo  
La NCE o NDE indica el tipo de 
asociación ( Devolución y Ajuste de 
precios ) • Ajustar una operación de 
una FE Aprobada  
Por devolución y Ajuste de 
precios de  una operac ión de 
una FE Aprobada  Autom
ático  
16 Asociación  SIFEN  Registro  
Automátic
o Emisión de un DE 
con otro DTE, 
pre-impreso , 
autoimpresor, 
comprobante 
virtual  u otros 
documentos  
asociados 
(Asociación)  Inmediato a la Aprobación en 
SIFEN de un DTE con indicación 
de otros documentos asociados 
o cuando existan informaciones 
provenientes de l Marangatu o 
Tesaka  Todos los 
DE, otros 
documento
s emitidos 
por otra 
modalidad 
de 
facturación 
e 
interoperabi
lidad con 
sistemas de 
la SET  • DTE asociado se encuentra en 
SIFEN con situ ación de 
Aprobado o Aprobado con 
observaciones o cuando el 
SIFEn reciba informaciones 
provenientes de los sistemas de 
la administración tributaria 
(Marangatu o Tesaka)   • Ajustar una operación  
• Anular una operación  Autom
ático  
 
IMPORTANTE:  Los eventos de Regi stro Requerido habilitados serán los que conciernen al emisor: de Cancelación de un DTE  y la Inutilización 
de un rango de DE, y el evento automático de devolución y Ajuste de precios  (disparados por la emisión de Notas de Créditos y Débitos 
Electrónicas ) y los eventos del receptor:  Notificación de recepción DE o DTE, Conformidad DTE,  Disconformidad DTE, Desconocimiento DE o 
DTE 
 
 
 
septiembre  de 2019                119 
Especificaciones sobre la Gestión de Eventos  por web Services para emisores y receptores electrónicos :  
• Los eventos deben ser estru cturados en un archivo XML por eventos  
• Cada evento deberá estar firmado digitalmente  
• Los eventos del emisor  y receptor  deberán ser transmitidos por los Web Services disponibles para dicha gestión  
• Los eventos deber án ser enviados en lotes de hasta 15 e vent os de cualquier tipo (emisor y/o receptor) . 
• La Inutilización de un número de DE debe  ser solicitada por rango secuencial o correlativo.   
 
Tabla  K: Correcciones de los eventos del Receptor en el SIFEN  
N° Correcciones  Actor  Tipo  Modalidad de 
Registro  Plazo  Alcance 
DE Criterios  Condiciones  
1 Conformidad – 
Disconformidad 
- 
Desconoci mient
o DE o DTE  Receptor  Registro 
Requerido  WS Sincrónico 
Eventos/Portal SIFEN  Hasta 15 (quince) 
días del registro 
del primer evento  Todos los DE 
o DTE • DTE en SIFEN  
• Situación Apro bado o 
Aprobado Extemporáneo  
• Se requiere informar la 
justificativa del evento de 
corrección (campo texto libre)  
• Solo se puede registrar un 
evento de correc ción sobre 
cada evento mencionado  • Selección del 
evento del 
receptor por 
equivocación  
 
A continuación , se presenta el cuadro que representa las relaciones que  pueden darse entre eventos d el receptor.  
Referencia:  
Gris = encabezado  
Verde  = puede realizarse luego del evento que se encuentra en el encabezado  
Rojo  = no puede realizarse luego del evento que se  encuentra en el encabezado  
 
 
 
septiembre  de 2019                120 
 
DE 
Notificación - 
Recepción  Desconocimiento  
Notificación - 
Recepción D E Notificación - 
Recepción D E 
Conformidad parcial  Conformidad parcial  
Conformidad total  Conformidad total  
Disconformidad  Disconformidad  
Desconocimiento 
DTE Desconocimiento DTE  
Inutilización de 
número  Inutilización de 
número  
 
11.5. Estructura de los Eventos  
Para estructurar los diferentes eventos que afectan el estado de un DTE se toma como elemento base al Código de control (CDC) , a 
excepción del evento de Inutilización  de número de DE . 
Schema XML 19: Evento_ v150 .xsd (Formato de evento emisor ) 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocu Observaciones  
GDE  GDE000  gGroupGesEve  Raíz del grupo deeventos  GSch03  G  1-1  
GDE  GDE001  rGesEve  Raíz de Gestión de 
Eventos  GDE000  G - 1-15 Elemento raíz  
GDE  GDE002  rEve Grupos de campos 
generales del evento  GDE001  G  1-1 Grupo de campos incluidos en la firma 
digital  DTE 
Notificación - 
Recepción  Conformidad 
parcial  Conformidad 
total  Disconformidad  Desconocimiento  
Notificación - 
Recepción DTE  Notificación - 
Recepción DTE  Notificación - 
Recepción DTE  Notificación - Recepción 
DTE Notificació n - 
Recepción DTE  
Conformidad parcial  Conformidad parcial  Conformidad parcial  Conformidad parcial  Conformidad parcial  
Conformidad total  Conformidad total  Conformidad total  Conformidad total  Conformidad total  
Disconformidad  Disconformidad  Disconformidad  Disconformidad  Disconformidad  
Desconocimiento 
DTE Desconocimiento DTE  Desconocimiento 
DTE Desconocimiento DTE  Desconocimiento 
DTE 
Inutilización de 
número  Inutilización de 
número  Inutilización de 
número  Inutilización de número  Inutilización de 
número  
 
 
 
septiembre  de 2019                121 
GDE  GDE003  Id Identificador del evento   N 1-10 1-1 Atributo  del campo GDE002  
GDE  GDE004  dFecFirma  Fecha y Hora del firmad o GDE002  F 19 1-1 Fecha y hora en el formato AAAA -MM-
DDThh:mm:ss   
GDE  GDE005  dVerFor  Versión del formato  GDE002  N 3 1-1 Control de versiones  
GDE  GDE006  dTiGDE  Tipo de Evento  GDE002  N 1-2 1-1 Eventos del Emisor  
1 = Cancelación  
2 = Inutilización  
3 = Endo so (futuro)  
Eventos del Comprador  
10 = Acuse del DE (futuro)  
11 = Conformidad del DE (futuro)  
12 = Disconformidad del DE (futuro)  
13 = Desconocimiento del DE (futuro)  
GDE  GDE007  gGroupTiEvt  Grupo de campos del tipo 
de evento  GDE002  G  1-1 Grupo correspond iente al evento según 
dTiGDE  
GDE  GDE008  Signature  Grupo de la Firma Digital  GDE001  G  1-1 Firma Digital del campo rEve (GDE001)  
 
11.5.1.  FORMATO DE EVENTOS EMISOR  
 
Grupo: Evento Cancelación (Formato del evento de cancelación)  
Grupo  ID Campo  Descripción  Nodo 
Padr e Tipo 
Dato  Longitud  Ocu Observaciones  
GDE  GEC001  rGeVeCan  Raíz Gestión de Eventos 
Cancelación  GDE007  G - - Elemento raíz  
Obligatorio si campo dTiGDE=1 
(Cancelación)  
GDE  GEC002  Id Identificador del DTE  GEC001  A 44 1-1 Se informa el código de control (CDC )  
GDE  GEC003  mOtEve  Motivo del Evento  GEC001  A 5 - 500 1-1 Campo abierto  
 
 
 
 
septiembre  de 2019                122 
Grupo: Evento Inutilización (Formato del evento de inutilización)  
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocu Observaciones  
GDE  GEI001  rGeVeInu  Raiz Gestión de 
Eventos Inutilización  GDE007  - - - Elemento raíz  
Obligatorio si campo dTiGDE=2 
(Inutilización)  
GDE  GEI002  dNumTim  Número del Timbrado  GEI001  N 8 1-1  
GDE  GEI003  dEst Establecimiento  GEI001  A 3 1-1 Completar con ceros a la izquierda  
GDE  GEI004  dPunExp  Punto de expedición  GEI001  A 3 1-1 Completar con ceros a la izquierda  
GDE  GEI005  dNumIn  Número Inicio del 
rango del documento  GEI001  A 7 1-1 La cantidad máxima para inutilización es 
un rango de hasta 1000 números del DE. 
Completar con ceros a la izquierda  
GDE GEI006  dNumFin  Número Final del 
rango del documento  GEI001  A 7 1-1 Completar con ceros a la izquierda  
GDE  GEI007  iTiDE  Tipo de Documento 
Electrónico  GEI001  N 1-2 1-1 1= Factura electrónica  
2= Factura electrónica de exportación  
3= Factura electrónica de  importación  
4= Autofactura electrónica  
5= Nota de crédito electrónica  
6= Nota de débito electrónica  
7= Nota de remisión electrónica  
8= Comprobante de retención 
electrónico  
GDE  GEI008  mOtEve  Motivo del Evento  GEI001  A 5-500 1-1 Campo libre  
 
 
 
 
 
 
septiembre  de 2019                123 
11.5.2.  FORMATO DE EVENTOS RECEPTOR  
Evento Notificación – Recepción DE/DTE (Formato del evento de Notificación – Recepción)  
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GER  GEN001  rGeVe NotRe
c Raíz Gestión de Eventos 
Notificación – Recepc ión 
DE o DTE  GDE007  G - - Elemento raíz  
GER  GEN002  Id Identificador del DE/DTE  GEN001  A 44 1-1 Se informa el código de control (CDC) de 
un DE/DTE  
GER  GEN003  dFecEmi  Fecha de emisión del 
DE/DTE  GEN001  F 19 1-1 Requerido para conteo de plazo de 
registro de l evento del receptor (hasta 45 
días desde la fecha de emisión)  
Fecha y hora en el formato AAAA -MM-
DDThh:mm:ss  
GER  GEN004  dFecRecep  Fecha Recepción DE  GEN001  F 19 1-1 Fecha en que el receptor recibió física o 
electrónicamente el documento 
electrónico. Fecha y hora en el formato 
AAAA -MM-DDThh:mm:ss  
GER  GEN005  iTipRec  Tipo de Receptor  GEN001  N 1 1-1 1=Contribuyente  
2=No Contribuyente  
GER  GEN006  dNomRec  Nombre o Razón Social 
del Receptor del DE/DTE  GEN001  A 4-60 1-1  
GER  GEN007  dRucRec  Ruc del Receptor  GEN001  A 3-8 0-1 Requerido solo cuando el tipo de receptor 
es contribuyente (GEN005=1)  
No Informar si GEN005=2  
GER  GEN008  dDVRec  Dígito verificador del RUC 
del contribuyente receptor  GEN001  N 1 0-1 Requerido solo cuando el tipo de receptor 
es contribuyent e (GEN005=1)  
No Informar si GEN005=2  
GER  GEN009  dTipIDRec  Tipo de documento de 
identidad del receptor  
 GEN001  N 1 0-1 No Informar si GEN005=1  
Requerido solo cuando el tipo de receptor 
es No Contribuyente (GEN005=2)  
1= Cédula paraguaya  
2= Pasaporte  
3= Cédu la extranjera  
4= Carnet de residencia  
GER  GEN010  dNumID  
 Número de documento de 
identidad  GEN001  A 1-20 0-1 No Informar si GEN005=1  
Requerido solo cuando el tipo de receptor 
es No Contribuyente (GEN005=2)  
 
 
 
septiembre  de 2019                124 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GER  GEN011  dTotalGs  Total general de la 
operació n en Guaraníes  GEN001  N 1-15p(0 -
8) 1-1  
 
Evento Conformidad (Formato del evento de conformidad)  
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GER  GCO001  rGeVeConf  Raiz Gestión de Eventos 
Conformidad  GDE007  - - - Elemen to raíz  
GER  GCO002  Id CDC del DTE  GCO001  A 44 1-1 Corresponde al CDC de un DTE  
GER  GCO003  iTipConf  Tipo de Conformidad  GCO001  N 1 1-1 1= Conformidad Total del DTE  
2= Conformidad Parcial del DTE, cuando  
la mercadería será entregada o servicio 
será presta do en una fecha posterior a la 
recepción del DE/DTE  
GER  GCO004  dFecRecep  Fecha Estimada de 
Recepción  GCO001  F 19 0-1 Obligatorio si el tipo de Conformidad es 
Conformi dad Parcial del DTE (GCO003= 
2) 
 
Evento Disconformidad (Formato del evento de Disconform idad)  
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GER  GDI001  rGeVeDisconf  Raiz Gestión de Eventos 
Disconformidad  GDE007  - - - Elemento raíz  
GER  GDI002  Id CDC del DTE  GDI001  N 44 1-1 Corresponde al CDC de un DTE  
GER  GDI004  mOtEve  Motivo del Evento  GDI001  A 5-500 1-1  
 
 
 
septiembre  de 2019                125 
 
Evento Desconocimiento DE/DTE (Formato del evento de Desconocimiento DE/DTE)  
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GER  GED001  rGeVeDescon  Raiz Gestión de 
Eventos 
Desconocimiento  GDE007  - - - Elemento raíz  
GER  GED002  Id CDC del DE/DTE  GED001  A 44 1-1 Corresponde al CDC de un Kude o CDC 
de un DTE  
GER  GED003  dFecEmi  Fecha de emisión del 
DE/DTE  GED001  F 19 1-1 Requerido para conteo de plazo de 
registro del event o del receptor (hasta 45 
días desde la fecha de emisión).  
Fecha y hora en el formato AAAA -MM-
DDThh:mm:ss . 
GER  GED004  dFecRecep  Fecha Recepción DE  GED001  F 19 1-1 Fecha y hora en el formato AAAA -MM-
DDThh:mm:ss . 
GER  GED005  iTipRec  Tipo de Receptor  GED001  N 1 1-1 1=Contribuyente  
2=No Contribuyente  
GER  GED006  dNomRec  Nombre o Razón 
Social del Receptor 
del DE/DTE  GED001  A 4-60 1-1  
GER  GED007  dRucRec  Ruc del Receptor  GED001  A 3-8 0-1 Requerido solo cuando el tipo de receptor 
es Contribuyente (GED005=1)  
No Informar si GED005=2  
GER  GED008  dDVRec  Dígito verificador del 
RUC del contribuyente 
receptor  GED001  N 1 0-1 Requerido solo cuando el tipo de receptor 
es Contribuyente (GED005=1)  
No Informar si GED005=2  
GER  GED009  dTipIDRec  Tipo de documento de 
identidad del receptor  
 GED001  N 1 0-1 No Informar si GED005=1  
Requerido solo cuando el tipo de receptor 
es No Contribuyente (GED005=2)  
1= Cédula paraguaya  
2= Pasaporte  
3= Cédula extranjera  
4= Carnet de residencia  
 
 
 
septiembre  de 2019                126 
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GER  GED010  dNumID  Número de documento 
de identidad  GED001  A 1-20 0-1 No Informar si GED005=1  
Requerido solo cuando el tipo de receptor 
es No Contribuyente (GED005=2)  
GER  GED011  mOtEve  Motivo del Evento  GED001  A 5-500 1-1  
 
Evento automático por interoperabilidad: Evento asociación Retención  
Grupo  ID Camp o Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GEA GER001 rGeVe RetAce  Raíz Gestión de 
Eventos de retención  GDE007  - - - Elemento raíz  
GEA  GER002 Id CDC del DE/DTE  GER001  A 44 1-1 Corresponde al CDC del DTE asociado  
GEA GER003 dNumT imRet  Número de timbrado 
del documento de 
retención  GER001  N 8 1-1  
GEA GER004 dEstRet  Establecimiento  GER001  A 3 1-1  
GEA GER005 dPunExpRet  Punto de expedición  GER001  A 3 1-1  
GEA GER006 dNumDocRet  Número del 
documento  GER001  A 7 1-1  
GEA GER007 dCodC onRet  Identificador de la 
retención  GER001  A 40 1-1  
GEA GER008 dFeEmiRet  Fecha de emisión de 
la retención  GER001  F 19 1-1  
 
 
 
 
 
septiembre  de 2019                127 
Evento automático por interoperabilidad: Evento asociación de anulación de la Retención   
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GEA GERA001 rGeVe RetAnu  Raíz Gestión de 
Eventos de retención 
anulación  GDE007  - - - Elemento raíz  
GEA  GERA002 Id CDC del DE/DTE  GERA001  A 44 1-1 Corresponde al CDC del DTE asociado  
GEA GERA003 dNumTimRet  Número  de timbrado 
del documento de 
retención  GERA001  N 8 1-1  
GEA GERA004 dEstRet  Establecimiento del 
document o de 
retención  GERA001  A 3 1-1  
GEA GERA005 dPunExpRet  Punto de expedición 
del document o de 
retención  GERA001  A 3 1-1  
GEA GERA006 dNumDocRet  Número  del 
document o de la 
retención  GERA001  A 7 1-1  
GEA GERA007 dCodConRet  Identificador de la 
retención  GERA001  A 40 1-1  
GEA GERA008 dFeEmiRet  Fecha de emisión de 
la retención  GERA001  F 19 1-1  
GEA GERA009 dFecAnRet  Fecha de anulación 
de la retención  GERA 001 F 19 1-1  
 
Evento automático por interoperabilidad: Evento transferencia de créditos fiscales  
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GEA GECF001 rGeVe CCFF  Raíz Gestión de 
Eventos de créditos 
fiscales  GDE007  - - - Elemento raíz  
 
 
 
septiembre  de 2019                128 
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GEA  GECF002 Id CDC del DE/DTE  GECF001 A 44 1-1 Corresponde al CDC del DTE asociado  
GEA  GECF003 dNumTraCCFF  Número de 
transferencia de 
créditos fiscales  GECF001 A 10 1-1  
GEA  GECF004 dFeAceTraCCFF  Fecha de aceptación 
del crédito fisca l GECF001 F 19 1-1  
 
Evento automático por interoperabilidad: Evento devolución de créditos fiscales  - Cuestionado  
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GEA GEDF001 rGeDevCCFFCu
e Raíz Gestión de 
Eventos de devo lución 
de créditos fiscales - 
Cuestionado  GDE007  - - - Elemento raíz  
GEA GEDF002 Id CDC del DE/DTE  GEDF001  A 44 1-1 Corresponde al CDC del DTE asociado  
GEA  GEDF003 dNumDevSol  Número DIR  GEDF001  A 10 1-1 Corresponde al número de solicitud de la 
DIR 
GEA  GEDF00 4 dNumDevInf  Número de informe  GEDF001  A 10 1-1  
GEA  GEDF00 5 dNumDevRes  Número de resolución 
de la devolución  GEDF001  A 10 1-1  
GEA  GEDF00 6 dFeEmiSol  Fecha de emisión de 
DIR GEDF001  F 19 1-1  
GEA  GEDF00 7 dFeEmiInf  Fecha de emisión del 
informe  GEDF0 01 F 19 1-1  
GEA  GEDF00 8 dFeEmiRes  Fecha de emisión de 
la resolución  GEDF001  F 19 1-1  
 
 
 
septiembre  de 2019                129 
 
Evento automático por interoperabilidad: Evento devolución de créditos fiscales  - Devuelto  
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observ aciones  
GEA GEDD001 rGeDevCCFFDe
v Raíz Gestión de 
Eventos de devolución 
de créditos fiscales - 
Devuelto  GDE007  - - - Elemento raíz  
GEA GEDD002 Id CDC del DE/DTE  GEDD001  A 44 1-1 Corresponde al CDC del DTE asociado  
GEA GEDD003 dNumDevSol  Número DIR  GEDD0 01 A 10 1-1 Corresponde al número de solicitud de la 
DIR 
GEA GEDD004 dNumDevInf  Número de informe  GEDD001  A 10 1-1  
GEA GEDD00 5 dNumDevRes  Número de resolución 
de la devolución  GEDD001  A 10 1-1  
GEA GEDD00 6 dFeEmiSol  Fecha de emisión de 
DIR GEDD001  F 19 1-1  
GEA GEDD00 7 dFeEmiInf  Fecha de emisión del 
informe  GEDD001  F 19 1-1  
GEA GEDD00 8 dFeEmiRes  Fecha de emisión de 
la resolución  GEDD001  F 19 1-1  
 
Evento automático por SIFEN: Evento anticipo  
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GEA  GEA001 rGeVe Ant Raíz Gestión de 
Eventos anticipo  GDE007  - - - Elemento raíz  
 
 
 
septiembre  de 2019                130 
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GEA  GEA002 Id CDC del DTE 
asociado  GEA001 A 44 1-1  
 
Evento automático por SIFEN: Evento remisión  
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GEA GERE001 rGeVeRem  Raíz Gestión de 
Eventos remisión  GDE007  - - - Elemento raíz  
GEA GERE002 Id CDC del DTE 
asociado  GERE001 A 44 1-1  
 
Evento por actualización de datos: Datos del transporte  
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GDE GET001 rGeVeTr  Raíz Gestión de 
Eventos por 
actualización de datos 
del transporte  GDE007  - - - Elemento raíz  
GDE GET002 Id CDC del DTE  GET001 A 44 1-1  
GDE GET003  dMotEv  Motivo del evento  GET001 N 1 1-1 1= Cambio del local de la entrega  
2= Cambio del chofer  
3= Cambio del transportista  
4= Cambio de vehículo  
GDE GET004  cDepEnt  Código del 
departamento del local 
de la entrega  GET001  N 1-2 0-1 Obligatorio si GET003=1  
Según XSD de Departamentos  
 
 
 
septiembre  de 2019                131 
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GDE  GET005 dDesDepEnt  Descripción del 
departamento del local 
de la entrega  GET001 A 6-16 0-1 Referente al campo GET004  
GDE  GET006  cDisEnt  Código del distrito del 
local de la entrega  GET001  N 1-4 0-1 Según Tabla 2.1 - Distritos  
GDE  GET007  dDesDisEnt  Descripción de distrito 
del local de la entrega  GET001 A 1-30 0-1 Obligatorio si existe el campo GET006  
GDE GET008  cCiuEnt  Código de la ciudad 
del local de la entrega  GET001  N 1-5 0-1 Obligatorio si GET003=1  
Según Tabla 2.2 – Ciudades  
GDE  GET009  dDesCiuEnt  Descripci ón de ciudad 
del local de la entrega  GET001  A 1-30 0-1 Referente al campo GET008  
GDE GET010  dDirEnt  Dirección del local de 
la entrega  GET001  A 1-255 0-1 Obligatorio si GET003=1  
GDE GET011  dNumCas  Número de casa  del 
local de la entrega  GET001  N 1-6 0-1 Obligatorio si GET003=1  
GDE GET012  dCompDir1  Complemento de 
dirección del local de 
la entrega  GET001  A 1-255 0-1 Opcional  si GET003=1  
GDE GET013  dNomChof  Nombre y apellido del 
chofer  GET001  A 4-60 1-1 Obligatorio si GET003= 2 
GDE GET014  dNumIDChof  Número d e documento 
de identidad del chofer  GET001  A 1-20 0-1 Obligatorio si GET003= 2 
GDE GET015  iNatTrans  Naturaleza del 
transportista  GET001  N 1 0-1 Obligatorio si GET003=3  
1= Contribuyente  
2= No contribuyente  
GDE GET016  dRucTrans  RUC del transportista  GET001  A 3-8 0-1 Obligatorio si GET015  = 1 
No informar si GET015  ≠ 1 
GDE GET017  dDVTrans  Dígito verificador del 
RUC del transportista  GET001  N 1 0-1 Obligatorio si GET015  = 1 
No informar si GET015  ≠ 1 
 
 
 
 
septiembre  de 2019                132 
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GDE GET018  dNomTrans  Nombre o razón social 
del transportis ta GET001  A 4-60 0-1 Obligatorio si GET003=3  
GDE GET019  iTipIDTrans  Tipo de documento de 
identidad del 
transportista  GET001  N 1 0-1 Obligatorio si GET015  = 2 
No informar si GET015  = 1 
1= Cédula paraguaya  
2= Pasaporte  
3= Cédula extranjera  
4= Carnet de resi dencia  
GDE  GET020  dDTipIDTrans  Descripción del tipo de 
documento de 
identidad del 
transportista  GET001  A 9-20 0-1 Obligatorio si existe el campo GET019  
1= “Cédula paraguaya”  
2= “Pasaporte”  
3= “Cédula extranjera”  
4= “Carnet de residencia”  
GDE GET021  dNumI DTrans  Número de documento 
de identidad del 
transportista  GET001  A 1-20 0-1 Obligatorio si existe el campo GET019  
GDE GET022  iTipTrans  Tipo de transporte  GET001  N 1 0-1 Obligatorio si GET003= 4 
1= Propio  
2= Tercero  
GDE  GET023  dDesTipTrans  Descripción del tipo de 
transporte  GET001  A 6-7 0-1 Obligatorio si existe el campo GET022  
GDE GET024  iModTrans  Modalidad del 
transporte  GET001  N 1 0-1 Obligatorio si GET003= 4 
1=Terrestre  
2= Fluvial  
3= Aéreo  
4= Multimodal  
GDE  GET025  dDes ModTrans  Descripción de la 
modali dad del 
transporte  GET001  A 5-10 1-1 Referente al campo GET024  
1= “Terrestre”  
2= “Fluvial”  
3= “Aéreo”  
4= “Multimodal”  
GDE GET026  dTiVehTras            Tipo de vehículo  GET001  A 4-10 0-1 Obligatorio si GET003= 4 
Descripción debe  ser acorde con el  campo  
GET0 24 
 
 
 
septiembre  de 2019                133 
Grupo  ID Campo  Descripción  Nodo Padre  Tipo 
Dato  Longitud  Ocurren
cia Observaciones  
GDE GET027  dMarVeh  Marca  del vehículo  GET001  A 1-10 0-1 Obligatorio si GET003= 4 
 
GDE GET028  dTipIdenVeh  Tipo de identificación 
del vehículo  GET001  N 1 0-1 Obligatorio si GET003=4  
 
1=Número de identificación del vehículo  
2=Número de matrícula del vehíc ulo 
GDE GET029  dNroIDVeh  Número de 
identificación del 
vehículo  GET001  A 1-20 0-1 Debe informarse cuando el GET028 =1 
GDE GET030  dNroMatVeh  Número de matrícula 
del vehículo  GET001  A 6 0-1 Debe informarse cuando el GET028 =2 
 
11.6. REGLAS DE V ALIDACIÓN DE GESTIÓ N DE EVENTOS  
 
REFERENCIA ESTADO DE VALIDACIÓN  
CÓDIGO  DESCRIPCIÓN  
A APROBADO  
AO APROBADO CON OBSERVACI ÓN 
R RECHAZADO  
 
Los resultados de rechazo y notificación se detallan en los correspondientes códigos y mensajes de respuesta descriptos en ca da Servici o 
Web.  Las validaciones de firma digital se realizan conforme a lo establecido en las siguientes secciones : Validación del certificado de firma  
y Validación de la firma digital . 
 
 
 
 
 
 
septiembre  de 2019                134 
11.6.1.  REGLAS DE VALIDACIÓ N PARA CANCELACIÓN  
 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
1 GDE005  La versión no corresponde  4000  Versión del formato del evento ( GDE005 ) no corresponde  a la 
versión vigente  R 
2 GEC002  CDC inválido  4001  Debe validar que el CDC (GEC002) cuente con los 44 caracteres 
según las reglas de estr ucturación del CDC (longitud,  orden de los 
campos del CDC, formato de la fecha invalida  y/o dígito verificador ) R 
3 GEC002a  CDC no existente en el SIFEN  4002  El identificador del CDC (GEC002) no se encuentra aprobado como 
DTE SIFEN  R 
4 GEC002b  CDC ya se encuentra con el mismo evento 
solicitado  4003  El DTE (GEC002) ya se encuentra con un evento que se está 
requiriendo nuevamente (Duplicidad)  R 
5 GEC002c  CDC ya se ha confirmado por el receptor  4004  Cuando el último evento del receptor sobre un CDC (GEC002)  es 
una confirmación parcial o total, no se permite realizar la 
cancelación por parte del emisor  R 
7 GDE008  Firmador no autorizado para realizar evento  4006  El RUC del certificado utilizado para firmar los eventos sobre DE y 
DTE, no corresponde al emisor/ electrónico  R 
8 GDE008a  Firma Digital inválida por certificado digital 
revocado  4007  El certificado digital que se utilizó para firmar el evento está 
revocado en la fecha de firma digital ( GDE004 ) R 
9 GDE004  Fecha de firma digital del evento inválida  4008 La fecha y hora de firma digital del evento no puede ser posterior a 
la Fecha y hora de aprobación en el SIFEN  R 
6 GDE004a  Plazo de solicitud de cancelación  de una FE  
extemporáneo  4009  Cuando el tipo de documento es Factura electrónica (GEC002 
inicia en  01), la fecha y hora de firma digital del evento (GDE004) 
de cancelación no puede superar al plazo límite de 48 hs contadas 
desde la fecha y hora de aprobación en el SIFEN  R 
7 GDE004b  Plazo de solicitud de cancelación distinto a una 
FE es extemporáneo  4010 Cuando el tipo de documento es Autofactura electrónica o Nota de 
crédito o Nota de débito o Nota de remisión (GEC002 inicia en 04 
o 05 o 06 o 07), la fecha y hora de firma digital del evento (GDE004) 
de cancelación no puede superar al plazo límite de 16 8 hs contadas 
desde la fecha y hora de aprobación en el SIFEN  R 
 
 
 
 
 
septiembre  de 2019                135 
11.6.2.  REGLAS DE VALIDACIÓN PARA INUTILIZACIÓN  
 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
9 GEI002  Número de timbrado inválido para el ambiente de 
pruebas.  4051  Cuando en ambiente d e prueba es obligatorio el uso del timbrado 
de pruebas.  R 
8 GEI002a  Número de timbrado no corresponde al 
contribuyente  4052  El número de timbrado no corresponde al RUC del contribuyente 
facturador electrónico  R 
9 GEI002b  Número de timbrado no corresponde  al medio de 
generación  4053  El número del timbrado no corresponde al medio de generación 
para factura electrónica  R 
10 GEI003  Código de establecimiento inválido para el 
timbrado informado  4054  El código del establecimiento no corresponde a un timbrado d el 
medio de generación para facturación electrónica  R 
11 GEI004  El código del punto de expedición es inválido 
para el timbrado informado  4055  El código del punto de expedición no corresponde a un timbrado 
autorizado para el contribuyente  R 
12 GEI007  Tipo de Documento no corresponde al Número 
de Timbrado  4060  El tipo de Documento no corresponde a un número de timbrado 
autorizado  R 
13 GEI005  Existe DTE en el rango informado  4065  Para el rango solicitado existe DTE en SIFEN  R 
14 GEI005a  Existe número inu tilizado en el rango solicitado  4066  Dentro del rango solicitado para inutilización existen número de DE 
ya inutilizados en SIFEN  R 
15 GEI006  Cantidad de números en el rango es inválida  4067  La cantidad máxima de números en el rango debe ser menor o igua l 
a 1000 (GEI006 – GEI005 menor o igual a 1000)  R 
16 GEI006a  Número final de rango es inválido  4068  El número del final de rango (GEI006) debe ser mayor que el 
número de inicio del rango (GEI005)  R 
19 GDE008  Firmador no autorizado para realizar evento  4069 El RUC del certificado utilizado para firmar los eventos no 
corresponde al emisor/electrónico  R 
20 GDE008a  Firma Digital inválida por certificado digital 
revocado  4070  El certificado digital que se utilizó para firmar el evento está 
revocado en la fech a de firma digital ( GDE004 ) R 
21 GDE004  Fecha de firma digital del evento inválida  4071  La fecha de firma digital del evento no puede ser posterior a la 
Fecha de SIFEN  R 
 
 
 
 
 
septiembre  de 2019                136 
11.6.3.  REGLAS DE VALIDACIÓN PARA NOTIFICACIÓN – RECEPCIÓN DE/DTE  
 
N° Val  ID Mensaje de la  Validación  Código  Observación  E 
1 GEN001  Incongruencia en el registro de eventos del 
receptor (hay un evento previo de conformidad 
o disconformidad o desconocimiento)  4113  No se puede realizar una notificación – recepción de DE luego de 
un evento de desc onocimiento.  
No se puede realizar una notificación – recepción de DTE luego de 
un evento de Conformidad parcial o total, Disconformidad o 
Desconocimiento  R 
2 GEN002b  CDC del DTE ya cuenta con un evento de esta 
naturaleza  4101  Sobre el CDC de un DE/DTE se puede realizar hasta un evento de 
notificación - recepción  R 
3 GEN002c  CDC del DTE inválido  4102  La estructura del CDC informado no corresponde  (Longitud y/o 
dígito verificador)  R 
4 GEN003  Fecha de emisión del DE/DTE ha superado el 
plazo para registro de l evento  4103  El plazo del registro del evento ha superado los 45 días contados a 
partir de la fecha de emisión  AO 
5 GEN004  Fecha de Recepción debe ser mayor o igual a la 
fecha de emisión del DE/DTE  4104  La fecha de emisión no puede ser mayor que la fecha  de recepción 
del DE/DTE  R 
6 GEN007  Ruc del Receptor requerido  4105  Es obligatorio informar Ruc del receptor cuando el tipo de receptor 
es Contribuyente (GEN005=1)  R 
7 GEN007a  Ruc del Receptor no se debe informar  4106  Cuando el tipo de receptor es No Con tribuyente (GEN005=2 ) no se 
debe informar el campo Ruc del Receptor (GEN007)  R 
8 GEN008  Dígito verificador del RUC del contribuyente 
receptor requerido  4107  Es obligatorio informar DV del receptor cuando el tipo de receptor 
es Contribuyente (GEN005=1)  R 
9 GEN008a  Dígito verificador del RUC del contribuyente 
receptor no se debe informar  4108  Cuando el tipo de receptor es No Contribuyente (GEN005=2 ) no se 
debe informar el campo Dígito verificador del RUC del contribuyente 
receptor (GEN008)  R 
10 GEN009  Tipo de documento de identidad del receptor 
requerido  4109 Es obligatorio informar Tipo de documento de identidad del receptor 
cuando el tipo de receptor es No contribuyente (GEN005=2)  R 
 
 
 
septiembre  de 2019                137 
N° Val  ID Mensaje de la  Validación  Código  Observación  E 
11 GEN009 a Tipo de documento de identidad del receptor no 
se debe inform ar 4110  Cuando el Tipo de documento de identidad del receptor 
Contribuyente (GEN005=1) no se debe informar el tipo de 
documento de identidad del receptor (GEN009a)  R 
12 GEN010  Número de documento de identidad requerido  4111  Es obligatorio informar Número de documento de identidad cuando 
el tipo de receptor es No contribuyente (GEN005=2)  R 
13 GEN010a  Número de documento de identidad no se debe 
informar  4112  Cuando el Tipo de documento de identidad del receptor 
Contribuyente (GEN005=1) no se debe informar e l documento de 
identidad del receptor (GEN010)  R 
 
11.6.4.  REGLAS DE VALIDACIÓN PARA EL EVENTO CONFORMIDAD  
 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
14 GCO001  Incongruencia en el registro de eventos del 
receptor (hay un evento previo de 
desconocimi ento)  4156  No se puede realizar una conformidad de DE/DTE luego de un 
evento de desconocimiento  R 
15 GCO002 CDC del DTE ya cuenta con dos eventos de la 
misma naturaleza  4150  Sobre el CDC de un DE/DTE se puede realizar hasta dos eventos 
de conformidad (con formidad parcial luego una conformidad total, 
en ese orden)  R 
16 GCO002b  CDC del DTE inválido  4151 La estructura del CDC informado no corresponde  (longitud y/o 
dígito verificador)  R 
 
 
 
septiembre  de 2019                138 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
17 GCO002c  CDC del DTE es inexistente o ha superado el 
plazo para regist ro del evento  4152  Cuando el CDC no se encuentra en la base de datos del SIFEN o 
el plazo del registro del evento es inválido:  
 
Regla para plazo inválido:  
*Si el primer evento del receptor que se pretende registrar es 
conformidad, este no se puede realiza r después de 45 días 
contados a partir de la fecha de emisión del DTE  
*Si no es el primer evento del receptor y el último evento realizado 
por el receptor no es una disconformidad, la conformidad no puede 
superar los 45 días contados a partir de la fecha d e emisión del 
DTE.  
*Si no es el primer evento del receptor y el último evento reali zado 
por el receptor es una disconformidad, entonces la conformidad 
(evento correctivo) no puede superar los 15 días contados a partir 
de la fecha de realización del evento de disconformidad  R 
18 GCO002e  No se puede registrar la confirmación por CDC 
del DTE cancelado o ajustado en su totalidad 
por nota de crédito  4155  El CDC del DTE ya ha sido cancelado con anterioridad  R 
19 GCO004  Fecha estimada de Recepción requerida  4154  Cuando el Tipo de Conformidad es parcial (GCO003=2) es 
obligatorio informar el campo fecha estimada de recepción de la 
mercadería (GCO004)  R 
 
 
11.6.5.  REGLAS DE VALIDACIÓN PARA EL EVENTO DISCONFORMIDAD  
 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
20 GDI001  Incongruencia en el registro de eventos del 
receptor (hay un evento previo de 
desconocimiento)  4205  No se puede realizar una conformidad de DE/DTE luego de un 
evento de desconocimiento  R 
21 GDI002  CDC del DTE ya cuenta con un evento de esta 
natura leza 4200  Sobre el CDC de un DTE se puede realizar hasta un evento de 
disconformidad  R 
 
 
 
septiembre  de 2019                139 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
22 GDI002b  CDC del DTE inválido  4201 La estructura del CDC informado no corresponde  (longitud y/o 
dígito verificador)  R 
23 GDI002c  CDC inexistente o ha superado el pla zo para 
registro del evento  4202 Cuando el CDC no se encuentra en la base de datos del SIFEN o 
el plazo del registro del evento es inválido:  
 
Regla para plazo inválido:  
*Si el primer evento del receptor que se pretende registrar es 
disconformidad, este no  se puede realizar después de 45 días 
contados a part ir de la fecha de emisión del DTE  
*Si no es el primer evento del receptor y el último evento realizado 
por el receptor no es una conformidad, la disconformidad no puede 
superar los 45 días contados a par tir de la fecha de emisión del 
DTE.  
*Si no es el prim er evento del receptor y el último evento realizado 
por el receptor es una conformidad, entonces la disconformidad 
(evento correctivo) no puede superar los 15 días contados a partir 
de la fecha de realiz ación del evento de conformidad  R 
24 GDI002e  No se puede registrar la disconformidad por CDC 
del DTE cancelado  4204  El CDC del DTE ya ha sido cancelado con anterioridad  R 
 
11.6.6.  REGLAS DE VALIDACIÓN PARA EL EVENTO DESCONOCIMIENTO DE/DTE  
 
N° Val  ID Resultado d e la Validación  Código  Observación  E 
25 GED002b  CDC del DTE ya cuenta con un evento de esta 
naturaleza  4251  Sobre el CDC de un DTE se puede realizar hasta un evento de 
desconocimiento  R 
26 GED002c  CDC del DTE inválido  4252  La estructura del CDC informado  no corresponde  (longitud y/o dígito 
verificador)  R 
 
 
 
septiembre  de 2019                140 
N° Val  ID Resultado d e la Validación  Código  Observación  E 
27 GED003  Fecha de emisión del DE/DTE ha superado el 
plazo para registro del evento  4253  El plazo del registro del evento ha superado los 45 días contados a 
partir de la fecha de emisión  AO 
28 GED004  Fecha de Recepción debe ser mayor a la fecha 
de emisión del DE/DTE  4254  La fecha de emisión no puede ser mayor que la fecha de recepción 
del DE/DTE  R 
29 GED007  Ruc del Receptor requerido  4255  Es obligatorio informar Ruc del receptor cuando el receptor es 
contribuyente (GED005=1)  R 
30 GEN007a  Ruc del Receptor no se debe informar  4256  Cuando el tipo de receptor es No Contribuyente (GED005=2 ) no se 
debe informar el campo Ruc del Receptor (GED007)  R 
31 GED008  Dígito verificador del RUC del contribuyente 
recept or requerido  4257  Es obligatorio informar DV del receptor cuando el receptor es 
contribuyente (GED005=1)  R 
32 GEN008a  Dígito verificador del RUC del contribuyente 
receptor no se debe informar  4258  Cuando el tipo de receptor es No Contribuyente (GED005=2 ) no se 
debe informar el campo Dígito verificador del RUC del contribuyente 
receptor (GED008)  R 
33 GED009  Tipo de documento de identidad del receptor  
requerido  4259  Es obligatorio informar el tipo de documento de identidad del 
receptor cuando el tipo de rec eptor es No contribuyente 
(GED005=2)  R 
34 GED009a  Tipo de documento de identidad del receptor 
no se debe informar  4260  Cuando el Tipo de Receptor es Contribuyente (GED005=1) no es 
necesario informar el tipo de documento de identidad del receptor 
(GED009)  R 
35 GED010  Número de documento de identidad requerido  4261  Es obligatorio informar el número de documento de identidad del 
receptor cuando el tipo de receptor es No contribuyente 
(GED005=2)  R 
36 GED10a  Número de documento de identidad no se debe 
informa r 4262  Cuando el Tipo de Receptor es Contribuyente (GED005=1) no es 
necesario informar el número de documento de identidad del 
receptor (GED010a)  R 
 
 
 
 
 
septiembre  de 2019                141 
11.6.7.  REGLAS DE VALIDACIÓN PARA EL EVENTO POR ACTUALIZACIÓN DE DATOS: DATOS DEL TRANSPORTE  
 
N° Val  ID Mensaje d e la Validación  Código  Observación  E 
1 GET004  El Departamento, el Distrito y la Ciudad del local 
de entrega no están relacionados  4300  Debe haber relación entre el departamento (GET004), el distrito 
(GET006) y la ciudad (GET008)  R 
2 GET004a  Código del de partamento del local de la entrega 
requerido para el motivo Cambio del local de la 
entrega  4301  Cuando el motivo del evento es Cambio del local de la entrega 
(GET003=1), es obligatorio informar el código del departamento del 
local de la entrega (GET004)  R 
3 GET005  Descripción del departamento del local de la 
entrega es requerida  4302  Cuando se informa el código del departamento del local de la 
entrega (GET004), es obligatorio informar la descripción del 
departamento del local de la entrega (GET005)  R 
4 GET005a  Descripción del departamento del local de la 
entrega no corresponde al código  4303  Descripción del departamento del local de la entrega no coincidente 
con lo informado en el campo GET004  R 
5 GET007  Descripción del distrito del local de la entrega e s 
requerida  4304  Cuando se informa el código del distrito del local de la entrega 
(GET006), es obligatorio informar la descripción del distrito del local 
de la entrega (GET007)  R 
6 GET007a  Descripción del distrito del local de la entrega no 
corresponde al  código  4305  Descripción del distrito del local de entrega no coincidente con lo 
informado en el campo GET006  R 
7 GET008  Código de la ciudad del local de la entrega 
requerido para el motivo Cambio del local de la 
entrega  4306  Cuando el motivo del evento e s Cambio del local de la entrega 
(GET003=1), es obligatorio informar el código de la ciudad del local 
de la entrega (GET004)  R 
8 GET009  Descripción de la ciudad del local de la entrega 
es requerida  4307  Cuando se informa el código de la ciudad del local d e la entrega 
(GET008), es obligatorio informar la descripción de la ciudad del 
local de la entrega (GET009)  R 
9 GET009a  Descripción de la ciudad del local de la entrega 
no corresponde al código  4308  Descripción de la ciudad del local de la entrega no coi ncidente con 
lo informado en el campo GET008  R 
10 GET010  Dirección del local de la entrega requerida para 
el motivo Cambio del local de la entrega  4309  Cuando el motivo del evento es Cambio del local de la entrega 
(GET003=1), es obligatorio informar la di rección del local de la 
entrega (GET010)  R 
 
 
 
septiembre  de 2019                142 
N° Val  ID Mensaje d e la Validación  Código  Observación  E 
11 GET011  Número de casa del local de la entrega 
requerido para el motivo Cambio del local de la 
entrega  4310  Cuando el motivo del evento es Cambio del local de la entrega 
(GET003=1), es obligatorio informar el n úmero de casa del local de 
la entrega (GET011)  R 
12 GET013  Nombre y apellido del chofer requerido para el 
motivo Cambio del chofer  4311  Cuando el motivo del evento es Cambio del chofer (GET003=2), es 
obligatorio informar el nombre y apellido del chofer (G ET013)  
 R 
13 GET014  Número de documento de identidad del chofer 
requerido para el motivo Cambio del chofer  4312  Cuando el motivo del evento es Cambio del chofer (GET003=2), es 
obligatorio informar el número de documento de identidad del 
chofer (GET014)  R 
14 GET015  Naturaleza del transportista requerida para el 
motivo Cambio del transportista  4313  Cuando el motivo del evento es Cambio del transportista 
(GET003=3), es obligatorio informar la naturaleza del transportista 
(GET015)  R 
15 GET016  RUC del transpo rtista no informado  4314  Se requiere informar el número de RUC si la naturaleza del 
transportista es igual a contribuyente (GET015 = 1)  R 
16 GET016a  RUC del transportista inexistente  4315  El RUC del transportista informado no existe en la base de datos 
de Marangatu  R 
17 GET016b  El RUC del transportista se encuentra inactivo  4316  El RUC del transportista debe contar con un estado distinto a 
CANCELADO, CANCELADO DEFINITIVO o SUSPENSIÓN 
TEMPORAL en Marangatu al momento de la emisión del DE  R 
18 GET016c  RUC  del transportista no requerido  4317  Si la naturaleza del transportista es distinta a contribuyente 
(GET015 ≠ 1) el RUC del transportista (GET016) no debe ser 
informado  R 
19 GET017  Dígito Verificador del RUC del transportista 
incorrecto  4318  El Dígito Ver ificador ingresado (GET017) no corresponde al módulo 
11 del RUC (GET016)  R 
20 GET018  Nombre o razón social del transportista es 
requerido para el motivo del evento  4319  Cuando el motivo del evento es cambio del transportista 
(GET003=3), es obligatorio informar el nombre o razón social del 
transportista (GET018)  R 
21 GET019  Tipo de documento de identidad del 
transportista no informado  4320  Se requiere informar el tipo de documento de identidad si la 
naturaleza del transportista es igual a NO contribuyente  (GET015 
=2) R 
 
 
 
septiembre  de 2019                143 
N° Val  ID Mensaje d e la Validación  Código  Observación  E 
22 GET019a  Tipo de documento de identidad del 
transportista no requerido  4321  Si la naturaleza del transportista es igual a contribuyente (GET015 
=1) el tipo de documento de identidad del transportista (GET019) 
no debe ser informado  R 
23 GET020  Descripción del tipo de documento de identidad 
del transportista no informada  4322  Si se informa el código de tipo de documento de identidad del 
transportista (GET019), es obligatorio indicar la descripción del 
mismo (GET020)  R 
24 GET020a  Descripció n del tipo de documento de identidad 
del transportista no corresponde al código  4323  Descripción del tipo de documento de identidad del transportista 
(GET020) no coincidente con lo informado en el campo GET019  R 
25 GET021  Número de documento de identidad del 
transportista no informado  4324  Si se informa el código de tipo de documento de identidad del 
transportista (GET019), el número de dicho documento es 
requerido  (GET020)  R 
26 GET022  Tipo de transporte requerido para el motivo 
Cambio de vehículo  4313  Cuando el motivo del evento es cambio de vehículo (GET003=4), 
es obligatorio informar el tipo de transporte (GET022)  R 
27 GET023  Descripción del tipo de transporte es requerida  4314  Cuando se informa el código de tipo de transporte (GET022), es 
obligatorio informar la descripción del tipo de transporte (GET023)  R 
28 GET023a  Descripción del tipo de transporte no 
corresponde al código  4315  Descripción del tipo de transporte no coincidente con lo informado 
en el campo GET022  R 
29 GET024  Modalidad del transpo rte requerido para el 
motivo Cambio de vehículo  4316  Cuando el motivo del evento es cambio de vehículo (GET003=4), 
es obligatorio informar la modalidad del transporte (GET024)  R 
30 GET025  Descripción de la modalidad del transporte es 
requerida  4317  Cuando  se informa el código de la modalidad del transporte 
(GET024), es obligatorio informar la descripción de la modalidad del 
transporte (GET025)  R 
31 GET025a  Descripción de la modalidad del transporte no 
corresponde al código  4318  Descripción de la modalida d del transporte no coincidente con lo 
informado en el campo GET024  R 
32 GET026  Tipo de vehículo requerido para el motivo 
Cambio de vehículo  4319  Cuando el motivo del evento es cambio de vehículo (GET003=4), 
es obligatorio informar el tipo de vehículo (GE T026)  R 
33 GET027  Marca del vehículo  requerida para el motivo 
Cambio de vehículo  4320  Cuando el motivo del evento es cambio de vehículo (GET003=4), 
es obligatorio informar la marca del vehículo (GET027 ) R 
 
 
 
septiembre  de 2019                144 
N° Val  ID Mensaje d e la Validación  Código  Observación  E 
34 GET028  Tipo de identificación del vehículo req uerido 
para el motivo Cambio de vehículo  4321  Cuando el motivo del evento es cambio de vehículo (GET003=4), 
es obligatorio informar el tipo de identificación del vehículo 
(GET028 ) R 
35 GET029  Tipo de identificación del vehículo no informado  4322  Se requie re el número de identificación del vehículo cuando el tipo 
de identificación del vehículo es 1 (GET028=1)  R 
36 GET030  Número de matrícula del vehículo no informado  4323  Se requiere número de matrícula del vehículo cuando el tipo de 
identificación del vehí culo es 2 (GET028=2)  R 
 
 
 
 
 
 