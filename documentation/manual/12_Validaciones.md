# 12 Validaciones

12. Validaciones  
 
El SIFEN  realizará  validaciones  en varios niveles, desde la conexión vía W eb Services hasta  el 
contenido de los mensajes de respuesta , especialmente  de los campos informados en los 
documento s electrónicos (DE) . 
Validaciones : Es el proceso de confirmar que los valores que se especifican en los objetos de datos , 
en este caso en el archivo XML de un DE, son  compatibles con las restricciones dentro de un 
esquema del conjunto de datos, al igual que las reglas establecida s para su aplicación.  
Las reglas de validación  verifican que los datos que un usuario ingresa en un registro o en un 
documento electrónico cumplen con las normas específicas  y establecidas a ntes de que el usuario 
guarde el registro. Una regla de validación  puede contener una fórmula o expresión que evalúa los 
datos en uno o más campos y ofrece un valor Verdadero  o Falso . 
Web Services : Es un conjunto de pr otocolos y estándares que sirve  para intercambiar datos entre 
aplicaciones.  
DE: Documento Electrónico  (Factura Electrónica, Factura Electrónica de Exportación, Factura 
Electrónica de Importación, Nota de Crédito Electrónica, Nota de Debito Electrónica, Autofactura 
Electrónica , Nota de R emisión Electrónica ) generados por el sistema de facturación de un emisor  
electrónico autorizado o desde el programa gratuito proveído por la Administración Tributaria.  
DTE:  Corresponde a la conversión de un DE que ha superado satisfactoriamente o exitosam ente 
todas las validaciones  establecidas para efect o, que se encuentra al macenado en el SIFEN y por ende 
puede ser utilizado como respaldo documental  para fines tributarios, comerciales, contables y 
jurídicos.  
Las validaciones  pueden tener uno de tres resu ltados:  
• (DTE) APROBADO (A): Mensaje por el cual se comunica que un docum ento electrónico (DE) 
ha superado satisfactoriamente o con éxito todas las validaciones establecidas, se 
mencionará el primer error detectado.  
• (DTE) APROBADO CON OBSERVACIONES (AO):  Mensaje por el cual se comunica que un 
documento electrónico (DE) ha super ado satisfactoriamente o con éxito todas las 
validaciones establecidas, consiguiendo así la aprobación para convertirse en un 
Documento Tributario Electrónico (DTE);  sin embargo, pos ee observaciones (Ejemplo: 
extemporaneidad)  
• (DE) RECHAZADO (R):  Mensaje p or el cual se comunica que el DE transmitido no cumple 
con las validaciones establecidas, mencionándose el primer error  identificado que impide 
su procesamiento para convertirse en u n DTE.  
 
 
 
 
 
septiembre  de 2019                146 
GUIA DE  REGLAS DE VALIDACIÓN  
N° VAL  Corresponde a la cantidad de  reglas de validación  
ID Corresponde a la identificación de los campos de los DE  
Mensaje de 
Validación  Corresponde a las respuestas de la verificación de los campos de 
los DE  
Código  Correspondiente al número de respuesta de la validación  
Observación  Corresponde a la descripción de las reglas de validación  
E Estado de la validación  
V Versión del XML 
REFERENCIA ESTADO DE VALIDACIÓN  
CÓDIGO  DESCRIPCIÓN  
A APROBADO   
AO APROBADO CON OBSERVACIONES  
R RECHAZADO  
 
Los resultados de rechazo y notificación  se detallan en los correspondientes mensajes de respuesta 
descriptos en cada Servicio W eb. 
 
12.1. Estructura de los códigos de validación  
 
Los có digos de incumplimiento de las v alidaciones están compuestos de 4 dígitos numéricos, que 
corresponden a los campos de  los Schemas XML, siguiendo el orden dispuesto en las tablas y 
secciones siguientes.  
Las tablas de valida ción presentan en las columnas Estado  el re sultado correspondiente al error: 
Aprobado (A), Rechazo (R ), Aprobado con observaciones  (AO). 
  
 
 
 
septiembre  de 2019                147 
12.1.1.  Códigos de r espuestas de las validaciones de los Servicios Web  
 
Inicio 
ID Inicio 
código de 
respuesta  Fin ID  Fin código 
de 
respuesta  Tipo de Regla de Validación  Apartado  
AA01  0000  0099  AA100  Certificado de Transmisión (Protocolo TLS)   
AB01  0100  AB20  0119  Forma del ár ea de datos de los mensajes de 
entrada de los WS   
AC01  0120  AC20  0139  Certificado digital utilizado por el contribuyente 
para firmar   
AD01  0140 AD20  0159  Firma digital   
AE01  0160  AE20  0179  Validaciones genéricas sobre los mensajes de 
entrada de los WS   
AF01  0180  AR20  0199  Validaciones genéricas sobre los mensajes de 
control de llamada de los WS   
BA01  0200  BA20  0219  Mensaje de entrada del WS SiRecepDE   
BB01  0220  BB20  0239  Información de control de la llamada al WS 
SiRecepDE   
BC01  0260 BC20  0259  Área d e datos del WS SiRecepDE   
BD01  0270 BD20  0279  Mensaje de entrada del WS SiRecepLoteDE   
BE01  0280  BE20  0299  Información de control de la llamada al WS 
SiRecepLoteDE   
BF01  0300  BF20  0319  Área de datos del WS SiRecepLoteDE   
BG01  0320  BG20  0339  Mensaje de entrada del WS SiResultLoteDE   
BH01  0340  BH20  0359  Información de control de la llamada al WS 
SiResultLoteDE   
BI01 0360  BI20 0379  Área de datos del WS SiResultLoteDE   
BJ01  0380  BJ20  0399  Mensaje de entrada del WS SiConsDE   
BK01  0400  BK20  0419  Informaci ón de control de la llamada al WS 
SiConsDE   
BL01  0420  BL20  0439  Área de datos del WS SiConsDE   
BM01  0460  BM20  0479  Mensaje de entrada del WS  siConsRUC   
BN01  0480  BN20  0499  Información de control de la llamada al WS 
siConsRUC   
BO01  0500  BO20  0559  Área d e datos del WS siConsRUC   
BS01  0560  BS20  0579  Mensaje de entrada del WS SiRecepEvento   
BT01  0580  BT20  0599  Información de control de la llamada al WS 
SiRecepEvento   
BU01  0600  BU20  0619  Área de datos del WS SiRecepEvento   
 
  
 
 
 
septiembre  de 2019                148 
12.1.2.  Código s de respuestas de las  validaciones de los DE 
 
Inicio 
ID Inicio 
código de 
respuesta  Fin ID  Fin código 
de 
respuesta  Tipo de Regla de Validación  Grupo de 
campos  
A002  1000  A004b  1049  Campos firmados del Documento Electrónico  
 (A001 -
A099)  
B002  1050  B003  1099  Campos inherentes a l a operación comercial de 
los Documentos Electrónicos  
 (B001 -
B099)  
C003  1100  C009  1149  Campos de datos del Timbrado  
 (C001 - 
C099)  
D002  1150  D002e  1199  Campos generales del Documento Electrónico  
 (D001 – 
D299)  
D010  1200  D020  1249  Campos inherentes a la operación comercial  
 (D010 -
D099)  
D101  1250  D116 1299  Campos que identifican al emisor del 
Documento Electrónico  (D100 -
D129 ) 
D130  1261  D132  1262  Campos que describen la actividad económica 
del emisor  (D130 -
D139)  
D201  1300  D224  1349  Datos que identifica n al receptor del Documento 
Electrónico DE  (D200 - 
D299)  
E010  1350  E012  1399  Campos que componen la Factura Electrónica 
FE (E010 -
E099)  
 
E020  1400  E025  1449  Campos de informaciones de Compras Públicas  (E020 -
E029)  
E300  2550  E322  2561  Campos que componen l a Autofactura 
Electrónica A FE  (E300 -
E399)  
E400  1450  E402  1499  Campos que componen la Nota Crédito/Débito 
Electrónica NCE - NDE  (E400 -
E499)  
E500  2600  E506  2650 Campos que componen la Nota de Remisión 
Electrónica  (E500-
E599) 
E600  1500  E602  1549  Campos qu e describen la condición de la 
operación  (E600 –
E699)  
E605  1550  E611a  1599  Campos que describan la forma de pago de la 
operación al contado o del monto de la entrega 
inicial  (E605 -
E619)  
 
E620  1600  E624  1649  Campos que describen el pago de la operación 
con tarjeta de crédito/ débito 
 (E620 -
E629  
E630  1650  E630a  1699  Campos que describen el pago o entrega inicial 
de la operación en cheque  
 (E630 - 
E639)  
E640  1700  E644a  1749  Campos que describen la operación a crédito  (E640 -
E649)  
 
 
 
septiembre  de 2019                149 
Inicio 
ID Inicio 
código de 
respuesta  Fin ID  Fin código 
de 
respuesta  Tipo de Regla de Validación  Grupo de 
campos  
E650  1750  E650a  1799  Campos q ue describen las cuotas  (E650 -
E659)  
E704  1800  E717 1849  Campos que describen los ítems de la operación  (E700 -
E899)  
E720  1850  E727  1899  Campos que describen el precio, tipo de cambio 
y valor total de la operación por ítem  (E720 -
E729)  
EA003  1852  EA050  1862 Campos que describen los descuentos, 
anticipos y valor total por ítem  (EA001 -
EA050)  
E730  1900  E736a  1999  Campos que describen el IVA de la operación  (E730 -
E739 ) 
E740  2000  E745  2049  Campos que describen el ISC de la operación  
 (E740 -
E749)  
E822 2050  E824 2099  Campos de datos adicionales de uso comercial  
 (E820 -
E829 ) 
E900  2100  E912a  2149  Campos que describen el transporte de las 
mercaderías  
 (E900 -
E999)  
E920  2150  E930  2199  Campos que identifican el local de salida de las 
mercaderías  (E920 -
E939)  
E940  2200 E950  2249  Campos que identifican el local de entrega de las 
mercaderías  
 (E940 -
E959)  
E960  2250  E966 a 2299  Campos que identifican el vehículo de traslado 
de mercaderías  (E960 -
E979)  
E980  2300  E989a  2349  Campos que identifican al transportista (persona 
física o jurídica)  (E980 -
E999)  
F001  2350  F023 b 2399  Campos que describen los subtotales y totales 
de la transacción documentada  (F001 -
F099)  
G050  2390 G050  2399  Campos generales de la carga  
 (G050 - 
G099)  
H001  2400 H017a  2449  Campos que identifican al d ocumento asociado  (H001 -
H049)  
 
I002 2450  I002 2459  
Información de la Firma Digital del DTE  
 (I001 -
I049)  
J002  2500 J003  2599  Campos fuera de la Fir ma Digital  (J001 -
J049)  
 
 
 
 
 
 
 
 
septiembre  de 2019                150 
12.1.3.  Códigos de respuestas de las validaciones de los eventos  
 
Inicio 
ID Inicio 
código de 
respuesta  Fin ID  Fin código 
de 
respuesta  Tipo de Regla de Validación  Apartado  
GEC0
02 
 
GDE0
04 4000  GEC00
2c 
 
GDE00
8a 4049  Registro del evento cancelación  de factura   
GEI00
2 4050  GEI00
6a 4099  Registro del evento Inutilización   
GEN0
01 4100  GEN01
0a 4113 Registro del evento de Notificación – Recepción 
DE/DTE   
GCO0
01 4150  GCO0
04 4156  Registro del evento de Conformidad   
GDI00
1 4200  GDI00
2e 4205  Registro del evento de Disconformidad   
GED0
02b 4250  GED10
a 4262  Registro del evento de Desconocimiento   
GET0 0
4 4300  GET03
0 4323  Reglas de validación para el evento por 
actualización de datos: datos del transporte   
 
 
12.2. Codificación de respuestas de los Servic ios WEB del SIFEN  
 
Los códigos de respuesta devueltos por los WS están conformados de la siguiente forma:  
Campo ID en las tablas de reglas de validación identifica a un código de validación de dos letras, 
conforme la secuencia AA, AB, AC,...las cuales a su  vez corresponde n a un tipo de validación 
especí fico.  
También existen validaciones genéricas aplicadas a má s de un documento electrónico, así como a 
un WS o a todos los documentos o WS.  
12.2.1.  Validaciones  del certificado de transmisión.  Protocolo TLS  
 
ID Resulta do de validación  Código  Observación  E 
AA01 Certificado de Transmisor 
Inválido  0001 Certificado de Transmis or inexistente en el 
mensaje   
R Versión incorrecta  
No se aceptan certificados de la AC  
ExtendKeyUsage no define “ClientAuth“   
AA02 Plazo de validez del Certificado 
digital  0002    R 
 
 
 
septiembre  de 2019                151 
ID Resulta do de validación  Código  Observación  E 
AA03 Cadena de Certificación  0003  Certificado del emisor n o corresponde a un PSC 
habilitado en el país   
R Certificado del PSC revocado  
Certificado no firmado por el PSC emisor del 
Certificado  
AA04  LCR del Certificado Transmisor  0004 No existe la dirección de la LCR ( CRL 
DistributionPoint )  
R LCR in disponible  
LCR invalida  
AA05  Certificado del transmisor 
revocado  0005   R 
AA06  Certificado Raíz no pertenece al 
MIC 0006   R 
AA07  No existe la extensión del RUC 
del emisor en el certificado  0007 Si el Certificado es de persona jurídica, el RUC 
debe estar informado en el campo SerialNumber 
en caso de ser del tipo de Persona Física el RUC, 
estará informado en el campo: 
SubjectAlternativeName   R 
 
Aclaramos que las validaciones AA01 a AA05 son realizadas por el propio protocolo TLS  
 
12.2.2.  Validación  de la estructura XML de los WS  
 
La información es enviada y recibida por medio de los WS, utilizando mensajes en formato XML 
definido para cada uno de los s ervicios.  
Las actual izaciones de formato,  así como estructura en los XML  son controla dos por medio del 
vers ionado  del archivo.  
La validación d e la estructura del archivo XML  es realizada por medio de un a nalizador sintáctico  
que verifica si el mensaje está  estructurado de acuerdo a las definiciones y reglas de su Schema 
XML. La primera validación realizada es l a correspondencia entre el mensaje y su Schema.  
El emisor debe generar los mensajes XML en el formato correspondiente a la versión vigente, 
informand o ésta en el campo de versión  dentro del grupo  rDE 
 
 
 
 
septiembre  de 2019                152 
El emisor debe validar los archivos XML contra el Sche ma XSD correspondiente, con el fin de 
garantizar  la integridad y el formato de e stos, antes de su trasmisión al SIFEN.  
 
12.2.3.  Validación de forma del área de datos del Request  
 
El área de datos correspondiente al mensaje de entrada de los WS  tiene las siguientes  validaciones.  
 
ID Resultado de validación  Código  Obs.  E V 
AB01  Fallo de schema XML del área de datos  0100    R 150 
AB02  Fallo de schema: no existe el campo raíz esperado para el mensaje  0101    R 150 
AB03  Fallo de schema: no existe el atributo versión pa ra el campo raíz 
esperado para el mensaje  0102    R 150 
AB05  Existe algún namespace  diferente del namespace  estándar del DE  0104    R 150 
AB06  Existe (n) carácter(es) de edición en el inicio o en el final del mensaje, o 
entre los campos XML  0105    R 150 
AB07 Utilizado prefijo en el namespace  0106    R 150 
AB08  Utilizada codificación diferente de UTF -8 0107    R 150 
 
12.2.4.  Validación del certificado de firma  
 
ID Resultado de validación  Código  Observación  E 
AC01  Certificado inválido  0120  • No existe certificado de  firma en el 
mensaje  
R • No se aceptan certificados del PSC  
• KeyUsage  no define firma digital  y no 
Repudio  
AC02  Alguna o todas las fechas  del certificado 
(inicio o final de validez del certificado) 
inválidas  0121    R 
AC03  No existe la extensió n del RUC en el 
certificado  0122  De Persona Física: en el OID, 
correspondiente al 
SubjectAlternativeName  
De Persona Jurídica: en el OID 
correspondien te al SerialNumber  R 
AC04  Cadena de certificación inválida  0123  • Certificado del PSC no habilitado por el  
MIC 
R • Certificado del PSC revocado  
• Certificado no está firmado por el PSC  
AC05  0124  • Dirección de la LCR no informada  
(CRLDistributionPoint )  R 
 
 
 
septiembre  de 2019                153 
ID Resultado de validación  Código  Observación  E 
Problema en la LCR del certificado de 
firma  • Error en el acceso a la LCR  
• LCR inexi stente  
AC06  Certificado de firma revocado  0125   R 
AC07  Certificado raíz no corresponde al MIC  0126   R 
 
12.2.5.  Validación de la firma digital  
 
ID Resulta do de validación  Código  Observación  E 
AD01  Firma difiere del estándar  0140  • No fue firmado el documento c ompleto 
(falta Reference URI  en la firma)  
R • Transform Algorithm  previsto en la 
firma (“C14N” y Enveloped) no 
informado  
AD02  Valor de la firma  (SignatureValue ) 
diferente del calculado por el PKI  0141  • Certificado del PSC no habilitado por el 
MIC 
R • Certificado del PSC revocado  
• Certificado no está firmado por el PSC  
• Dirección de la LCR no informada  
(CRLDistributionPoint )  
• Error en el acceso a la LCR  
• LCR inexistente  
• Certificado de firma revocado  
• Certific ado raíz no corresponde al MIC  
AD03  RUC del certificado utilizado para firmar 
no pertenece al Contribuyente emisor  0142    R 
 
 
12.2.6.  Validaciones genéric as a los mensajes de entrada de los WS  
 
Las presentes validaciones son aplicadas a los mensajes de entrada de cualquiera de los Web 
Service s dispuestos por la SET  
ID Resultado de Validación  Código  Obs E 
AE01  XML malformado  0160    R 
AE02  Servidor de proce samiento momentáneamente sin 
respuesta  0161    R 
AE03  Servidor de procesamiento paralizado, sin tiempo de 
regreso  0162    R 
AE04  Versión del formato del WS no soportada  0163    R 
 
 
 
 
septiembre  de 2019                154 
12.2.7.  Validaciones genéricas a los mensajes de control de llamada de los WS  
 
ID Resultado de Validación  Código  Obs E 
AF01  Elemento de HeaderMsg  inexistente en el SOAP 
Header  0180    R 
AF04  RUC del certificado utilizado en la conexión no 
pertenece a un contribuyente activo en la base 
de datos de RUC.  0183    R 
 
 
12.3. Validaciones de cada Web Service  
 
12.3.1.  WS recepción documento electrónico – siRecepDE  
 
12.3.1.1.  Mensaje de entrada del WS  
 
La primera validación corresponde al tamaño máximo permitido para el mensaje, este no debe 
superar los ( 1000 KB ). Su verificación es:  
• En el presente WS  se devuelve el mens aje con código 0200.  
• En la configuración de red ( firewall ), en el caso que la conexión sea interrumpida sin  la 
generación del mensaje de error con el código 0200.  
 
ID Resultado de la Validación  Código  Obs E 
BA01  Mensaje de datos de entrada del WS 
siRecepD E superior a 1000 KB  0200    R 
 
12.3.1.2.  Información de control de la llamada al WS  
 
No se realizan validaciones esp ecíficas para este  método en la versión inicial 1 00, sin embargo,  
reservamos los códigos desde el 02 20 al 02 39 y las correspondientes identificacione s BB01 a BB20. 
 
12.3.1.3.  Área de d atos del WS  
 
ID Resultado de la Validación  Código  Obs E 
BC01  Autorización del DE satisfactoria  0260    N 
 
 
 
 
septiembre  de 2019                155 
12.3.2.  WS recepción lote DE – siRecepLoteDE  
 
12.3.2.1.  Mensaje de entrada del WS  
 
La primera validación corresponde al tamaño máximo permiti do para el mensaje de Web Service de 
lote, es te no debe superar los (10.000 K B). Su verificación es:  
• En el presente WS  se devuelve el mensaje con código 0270.  
• En la configuración de red ( firewall ), en el caso que la conexión sea interrumpida sin la 
generac ión del mensaje de error con el código 0270.  
ID Resultado de la Validación  Código  Obs E 
BD01  Mensaje de da tos de entrada del WS 
siRecepLoteDE superior a 10. 000 KB. 0270    R 
 
12.3.2.2.  Información de control de la llamada al WS  
 
No se realizan validaciones específi cas para este  método en la versión inicial 1 00, sin embargo,  
reservamos los códigos desde el 02 80 al 0299 y  las correspondientes identificaciones B E01 a BE20. 
 
12.3.2.3.  Área de datos del WS  
 
ID Resultado de la Validación  Código  Obs E 
BF01  Lote recibido con éxito  0300   A 
BF02  Lote no encolado para procesamiento  0301   R 
 
12.3.3.  WS consulta resultado de lote DE – siResultLote DE 
 
12.3.3.1.  Mensaje de e ntrada del WS  
 
La primera validación corresponde al tamaño máximo permitido para el mensaje de Web Serv ice, 
este no debe superar los  (1000 KB ). Su verificación es:  
• En el presente WS  se devuelve el mensaje con código 0320.  
• En la configuraci ón de red ( firewall ), en el caso que la conexión sea interrumpida sin la 
generación del mensaje de error con el código 0320.  
ID Resultado de la Valid ación  Código  Obs E 
 
 
 
septiembre  de 2019                156 
BG01  Mensaje de datos de entrada del WS 
siResultLoteDE superior a 1000 KB.  0320    R 
 
12.3.3.2.  Información de control de la llamada al WS  
 
ID Resultado de la Validación  Código  Obs E 
BH01  RUC del certificado de conexión no autorizado 
a consultar  el lote  0340   El resultado del 
procesamiento del lote 
solo puede ser 
consultado por el RUC 
que realizó la 
transmisión del mismo.  R 
 
12.3.3.3.  Área de datos del WS  
 
ID Resultado de Validación  Código  Obs E 
BI01 Lote inexistente  0360    R 
BI02 Lote en procesamiento  0361    R 
BI03 Procesamiento de lote concluido  0362    A 
B104  Lotes con tipos distintos de DE  0363   R 
 
 
12.3.4.  WS consulta de DE – siConsDE  
 
12.3.4.1.  Mensaje de entrada del WS  
 
La primera validación corresponde al tamaño máximo permitido para el mensaje de Web Service, 
este no debe superar los ( 1000 KB ). Su verificación es:  
• En el presente WS  se devuelve el mensaje con código  0380.  
• En la configuración de red ( firewall ), en el caso que la conexión sea interrumpida sin la 
generación del mensaje de error con el código 0380.  
 
ID Resultado de la Validación  Código  Obs E 
BJ01  Mensaje de datos de entrada del WS 
siConsDE superior a 10 00 KB.  0380    R 
 
 
 
 
septiembre  de 2019                157 
12.3.4.2.  Información de control de la llamada al WS  
 
No se realizan validaciones específicas para este método en la versión inicia l 100, sin  embargo,  
reservamos los códigos desde el 0400  al 0419 y las correspondientes identificaciones B K00 a BK19. 
 
12.3.4.3.  Área de datos del WS  
 
ID Resultado de Validación  Código  Obs E 
BL01  CDC inexistente  0420     
BL02  CDC Encontrado  0421    
 
12.3.5.  WS consulta de RUC – siCo nsRUC  
 
12.3.5.1.  Mensaje de entrada del WS  
 
La primera validación corresponde al tamaño máximo permitido para el men saje de Web Service, 
este no debe superar los ( 1000 KB ). Su verificación es:  
• En el presente WS se devuelve el mensaje con código 0460.  
• En la configur ación de red ( firewall ), en el caso que la conexión sea interrumpida sin la 
generación del mensaje de error  con el código 0380.  
 
ID Resultado de la Validación  Código  Obs E 
BM01  Mensaje de datos de entrada del WS 
siConsRUC superior a 1000 KB.  0460    R 
 
12.3.5.2.  Información de control de la llamada al WS  
 
No se realizan validaciones específicas para este método en la ve rsión inicial 100, sin embargo, 
reservamos los códigos desde el 0480 al 0499 y las correspondientes identificaciones BN01 a BN20.  
 
12.3.5.3.  Área de datos del WS 
 
ID Resultado de Validación  Código  Obs E 
BO01  RUC inexistente  0500     
BO02  RUC no tiene permiso para u tilizar el WS  0501     
 
 
 
septiembre  de 2019                158 
BO03  Éxito en la consulta  0502    
 
12.3.6.  WS recepción de evento – siRecepEvento  
 
12.3.6.1.  Mensaje de entrada del WS  
 
La primera validación c orresponde al tamaño máximo permitido para el mensaje de Web Service, 
este no debe superar los ( 1000 KB ). Su verificación es:  
• En el presente WS  se devuelve el mensaje con código 0560.  
• En la configuración de red ( firewall ), en el caso que la conexión sea in terrumpida sin la 
generación del mensaje de error con el código 0560.  
 
ID Resultado de la Validación  Código  Obs E 
BS01  Mensaje de datos de entrada del WS 
siRecepEvento superior a 1000 KB.  0560    R 
 
12.3.6.2.  Información de control de la llamada al WS  
 
No se realiz an validaciones específicas para este  método en la versión inicial 1 00, sin embargo,  
reservamos los códigos  desde el 0580 al 0599 y las correspondientes identificaciones BT01 a BT20.  
 
12.3.6.3.  Área de datos del WS  
ID Resultado de Validación  Código  Obs E 
BU01  Event o registrado correctamente  0600    A 
 
 
 
12.4. Validaciones  del formato  
 
A. Campos firmados del Documento Electrónico ( A001 -A099)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
1 A002  CDC no correspondiente con las informaciones 
del XML  1000  El CDC no es com patible con las informaciones de los campos del 
XML (C002, D101, D102, C005, C006, C007, D103, D002, B002, 
B004, A003)  R 
2 A002a  CDC duplicado  1001  Ya fue autorizado otro documento con coincidencia simultánea de 
contenido de los campos del CDC  R 
3 A002b  Documento electrónico duplicado  1002  Ya fue autorizado otro documento con coincidencia simultánea de 
conte nido de los campos del Timbrado:                                                                                                         
1) Tipo de d ocumento (C002)  
2) Número de Timbrado (C004)  
3) Número de documento (C007)                         
4) Tipo d e emisión (B002)  
5) Establecimiento (C005)  
6) Punto de Expedición (C006)  
7) Serie (C010) Si se informa  R 
4 A003  DV del CDC inválido  1003  Valor incor recto del dígito verificador informado según algoritmo 
módulo 11  R 
5 A004a  La fecha y hora de la firma dig ital es adelantada  1004  La fecha y hora de la firma digital no debe ser posterior a la fecha y 
hora de SIFEN  R 
6 A004b  Transmisión extemporánea del DE  1005  La transmisión del DE no debe exceder el tiempo de validación 
posterior parametrizado para el cont ribuyente, tomando como 
referencia la fecha y hora de la Firma Digital  (A004)  
La SET podrá aplicar la sanción conforme a lo dispuesto en la 
reglament ación.  
Aprobado con observaciones (Extemporaneidad)  AO 
 
 
 
 
 
septiembre  de 2019                160 
B. Campos inherentes a la operación comercial de  los Documentos Electrónicos (B001 -B099)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
7 B002  Tipo de emisión invá lido en esta etapa  1050  El tipo de emisión en contingencia (B002=2) no permitida en esta 
etapa  R 
8 B003  Descripción del tipo de e misión no corresponde 
al código  1051  Descripción del tipo de emisión no coincidente a lo informado en el 
campo B002  R 
 
C. Campos de datos del Timbra do (C001 - C099)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
9 C003  Descripción del tipo de do cumento electrónico no 
corresponde al código  1100  Descripción del tipo de documento electrónico no coincidente a lo 
informado en el campo C002  R 
10 C004  Número de timbrado inválido  1101  Número de timbrado no corresponde al RUC ni al Tipo de 
Documento elec trónico  del contribuyente emisor  R 
11 C004a  Número de timbrado no corresponde al medio de 
generación para facturación electrónica  1102  Medio de gene ración incorrecto en el sistema de Timbrado de 
Marangatu  R 
12 C004b  El número de timbrado no se encuentra vigente a 
la fecha de emisión del comprobante  1103  Número de timbrado no vigente (D002 no se encuentre dentro del 
rango de las fechas de inicio y fin  de vigencia del timbrado (C008 - 
C009)  R 
13 C004c  El número de timbrado informado no se encuentra 
en esta do ACTIVO  1104  El número de timbrado informado no se encuentra activo en la base 
de datos de timbrado en la fecha de emisión del DE (D002)  R 
14 C005  Código de establecimiento incorrecto  1105  El código de establecimiento no corresponde al timbrado autoriz ado 
para el contribuyente   R 
15 C006  Código de punto de expedición incorrecto  1106  El código de punto de expedición no corresponde al timbrado 
autorizado para el contribuyente   R 
 
 
 
septiembre  de 2019                161 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
16 C007  Número de documento ha sido inutilizado 
anteriormente  1109  El núme ro de documento que pertenece al número de Timbrado, 
establecimiento y punto de expedición, se encuentra inutilizado  R 
17 C008  Fecha de inicio de vi gencia del timbrado 
incorrecta  1107  Fecha de inicio de vigencia del timbrado no corresponde a la fecha 
de inicio de vigencia del timbrado autorizado para el contribuyente  R 
18 C009  Fecha fin de vigencia del timbrado incorrecta  1108  Fecha fin de vigencia  del timbrado no corresponde al timbrado 
autorizado para el contribuyente   R 
18 C010  Serie informada incor recta  1110  Se debe respetar la secuencialidad en el uso de la serie.  
Ej: AA, AB, AC… AZ…. ZA, …., ZZ), la primera serie a utilizar es la 
serie AA.  
  
Los siguientes casos no son permitidos:  
(*) Primera serie distinta a AA  
 
(*) Serie no es vecina:  la serie i nformada no es veci na a la mayor 
serie informada al SIFEN (serie actual)  
 
(*) Serie inmediatamente anterior:  DE con serie anterior a la mayor 
serie e nviada al SIFEN, cuya fecha y hora de firma digital es 
posterior a la fecha de inicio de vigencia de la ser ie actual en el 
sistema.  
(*) Serie inmediatamente posterior:  DE con serie posterior a la 
mayor serie enviada  al SIFEN, cuya fecha y hora de firma dig ital es 
anterior a la fecha de inicio de vigencia de la serie actual en el 
sistema.  
Referirse a la sección Manejo del timbrado y Numeración para 
mayor información  R 
 
 
 
 
 
septiembre  de 2019                162 
D. Datos generales del Documento Electrónico (D001 – D299)  
N° Val  ID Mensaje de la Valid ación  Código  Observación  E 
19 D002  La fecha y hora de emisión del DE informada es 
inválida por retraso  1150 Cuando la fecha y hora de emisión es anterior a la fecha y hora de 
transmisión al SIFEN, la  diferencia no debe ser mayor a 720 horas 
(30 días)  R 
20 D002f  La fecha y hora de emisión del DE informada es 
inválida por envío adelantado  1151  Cuando la fecha y  hora de emisión del DE es posterior a la fecha y 
hora de transmisión al SIFEN, la diferencia no debe ser mayor a 
120 horas (5 días)  R 
21 D002a  Fech a y hora de emisión del DE es anterior a la 
fecha de lanzamiento del sistema  1156  La fecha y hora de emisi ón del DE debe ser posterior al 22 de 
noviembre del 2018  R 
 
D1. Campos inherentes a la operación comercial (D010 -D099)  
N° Val  ID Mensaje de la Valid ación  Código  Observación  E 
22 D010  Grupo de informaciones inherentes a la operación 
comercial es obligator io informar para el tipo de 
documento  1200  El grupo de informaciones inherentes a la operación comercial 
(D010) es obligatorio informar para todos lo s tipos de documentos 
electrónicos excepto Nota de Remisión Electrónica (C002=7)  R 
23 D010a  Grupo de infor maciones inherentes a la operación 
comercial no es permitido para el tipo de 
documento  1201  El grupo de informaciones inherentes a la operación comer cial 
(D010) no es permitido para Nota de Remisión Electrónica (C002=7)  R 
24 D011  Tipo de transacción no in formado para el 
documento electrónico seleccionado  1202  Es obligatorio informar el tipo de transacción  para Factura 
Electrónica, Factura electrónica de Exportación, Factura Electrónica 
de Importación y Autofactura Electrónica.  
Obligatorio si C002 = 1, 2, 3 o 4  R 
25 D012  Descripción del tipo de transacción no 
corresponde al código  1203  Descripción del tipo de transacción no coincidente con lo informad o 
en el campo D011  R 
28 D013  Tipo de impuesto afectado no informado  1204  Es obligatorio informar el tipo de impuesto afectado para Factura 
Electrónica y Autofactura Electrónica. Obligatorio si C002=1 o 4  R 
26 D014  La descripción del tipo de impuesto afe ctado no 
corresponde al código  1205  Descripción del tipo de impuesto afectado no coincidente con lo 
informa do en el campo D013  R 
 
 
 
septiembre  de 2019                163 
N° Val  ID Mensaje de la Valid ación  Código  Observación  E 
27 D016  Descripción de la moneda de la operación no 
corresponde al código  1206  Descripción de la moneda de la operación no coi ncidente con lo 
informado en el campo D015  R 
28 D017  Condición del tipo de cambio no informada  1207  Si la moneda de la operación es distinta a PYG (D015≠PYG), es 
obligatorio informar la condición del tipo de cambio (D017)  R 
29 D017a  Condición del tipo de  cambio no requerida  1208  Si la moneda de la operación es igual a PYG (D015=PYG), la 
condición del tipo de cambio (D017) no debe ser informada  R 
30 D018  Tipo de cambio de la operación no informado  1209  Si la condición del tipo de cambio es global (D017=1 ), es obligatorio 
informar el tipo de cambio de la operación (D018)  R 
31 D018a  Tipo de cambio de la operac ión no requerido  1210  Si la condición del tipo de cambio es por ítem (D017=2) o la moneda 
de la operación es PYG (D015=PYG) , el tipo de  
cambio de la operación (D018) no debe ser informado  
 R 
32 D020  Descripción de la condición del anticipo no 
corresponde al código  1211  Descripción del tipo de la condición del anticipo no coincidente con 
lo informado en el campo D019  R 
 
D2. Datos que identifican al em isor del Documento Electrónico (D100 -D129)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
33 D101 RUC del emisor inexistente  1250  El RUC informado no existe en la base de datos  R 
34 D101a  RUC del Emisor inhabilitado para facturación 
electrónic a 1251  RUC no se encuentra habilitado para facturación electrónica  en 
Marangatu  R 
35 D101b  El RUC del emis or se encuentra inactivo  1252  El RUC del contribuyente debe contar con un estado distinto a 
CANCELADO, CANCELADO DEFINITIVO o SUSPENSIÓN 
TEMPORAL en Marangatu al momento de la emisión del DE  R 
36 D101c  RUC del emisor no está habilitado para utilizar 
este tipo de servicio  1264  RUC del emisor no está habilitado para utilizar el servicio síncrono  R 
37 D102  Dígito Verificador del RUC del emisor incorrect o  1253  El Dígito Verificador ingresado no corresponde al módulo 11 del 
RUC   R 
 
 
 
septiembre  de 2019                164 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
38 D105  Nombre o razón soci al del emisor del DE inválido  1263  Se debe utilizar el siguiente texto para el ambiente de pruebas: "DE 
generado en ambiente de prueba - sin valor co mercial ni fiscal".  
No se debe utilizar el texto "DE generado en ambiente de prueba - 
sin valor comercial ni fiscal" para el ambiente de producción.  R 
39 D111  El Departamento, el Distrito y la Ciudad de 
emisión no están relacionados  1255  Debe haber rela ción entre el departamento (D111 ), el d istrito (D113) 
y la ciudad (D115 ) R 
40 D112  Descripción del departam ento de emisión no 
corresponde al código  1254  Descripción del departamento de emisión no coincidente con lo 
informado en el campo D111  R 
44 D114  Es obligatorio indicar la descripción del código de 
distrito de emisión  1256  Si se informa el código del dis trito de emisión (D113), es obligatorio 
informar la descripción del mismo (D114)  R 
41 D114a  Descripción del distrito de emisión no 
corresponde al có digo 1257  Descripción del distrito de emisión no coincidente con lo informado 
en el campo D113  R 
43 D115  La ciudad de emisión no corresponde al 
departamento seleccionado  1258  El código de la ciudad de emisión (D115) debe corresponder al 
departamento selec cionado (D111)  R 
44 D115a  La ciudad de emisión no corresponde al distrito 
seleccionado  1259  El código de l a ciudad de emisión (D115) debe corresponder al 
distrito seleccionado (D113)  
No se aplica esta regla si no ha sido informado el distrito  R 
42 D116  Descripción de la ciudad de emisión no 
corresponde al código  1260  Descripción de la ciudad de emisión no co incidente con lo informado 
en el campo D115  R 
 
D2.1 Campos que describen la actividad económica del emisor (D130 -D139)  
 
N° Val  ID Mensaje de la Vali dación  Código  Observación  E 
43 D131  Código de actividad económica incorrecto  1261  La actividad económica seleccionada no corresponde a lo declarado 
en el RUC  R 
44 D132  Descripción de la actividad económica no 
corresponde al código  1262  Descripción de la  actividad económica no coincidente con lo 
informado en el campo D120  R 
 
 
 
 
septiembre  de 2019                165 
 
D3. Datos que identifican al rec eptor del Documento Electrónico DE (D200 - D299)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
45 D201  Naturaleza del Receptor inválida pa ra el tipo 
documento electrónico  1315  Si el tipo de documento es Autofactura (C002 =4), la naturaleza del 
Receptor debe ser Contribuyente (D201=1)  R 
46 D202  El tipo de operación no compatible con la 
naturaleza del receptor  1300  Si el tipo de documento no e s autofactura (C002 ≠ 4) y si la 
naturaleza del receptor es No contribuyente (D201=2), el tipo de 
operación debe ser B2C (D202= 2). 
Si el tipo de operación es B2F (D202=4), la naturaleza del receptor 
debe ser No contribuyente (D201=2)  R 
47 D202a  El tipo de  operación no compat ible con el tipo 
documento electrónico  1316  Si la transacción se documenta con Autofactura (C002 =4), e l tipo de 
operación debe ser B2C (D202=2)  R 
48 D203  Código de país del receptor inválido para el tipo 
de operación informado  1320  Si el tipo de operación  es B2F (D202=4), el país informado debe 
ser diferente a PRY (D203 ≠PRY ).  
Si el tipo de operación es diferente de B2F (D202 ≠4) el país 
informado debe ser igual a PRY (D203= PRY) R 
49 D204  Descripción del país receptor no corresponde al 
código  1301  La descripción del país del receptor no coincidente con lo informado 
en el  campo D203  R 
50 D205  Es obligatorio informar el tipo de contribuyente 
receptor  1302  Si la naturaleza del receptor es contribuyente (D201=1) el tipo de 
contribuyente receptor debe ser informado  R 
51 D205a  Tipo de contribuyente receptor inválido  1303  Si la naturaleza del receptor es NO contribuyente (D201=2), el tipo 
de contribuyente receptor (D205) no debe ser informado  R 
52 D206  Es obligatorio informar el RUC del receptor 
contribuyente  1304  Si la naturaleza del receptor es contribuyente (D201=1), el RUC  del 
receptor debe ser informado  R 
53 D206a  RUC del receptor no requerido  1305  Si la naturaleza del receptor es NO contribuyente (D201=2), el RUC 
del receptor (D206) no debe ser informado  R 
54 D206b  RUC del receptor inexistente en la base de datos 
de Mar angatu  1306  El RUC informado no existe en la base de datos de Marangatu  R 
 
 
 
septiembre  de 2019                166 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
55 D206c  El RUC se encuentra inactivo para el tipo de 
contribuyente receptor  1307  Si el tipo de contribuyente receptor es persona jurídica (D205=2), 
el RUC del receptor en Marangatu  debe contar con un estado 
distinto a CANCELADO, CANCELADO DEFINITIVO o 
SUSPENSIÓN TEMPORAL  R 
56 D206d  El RUC del receptor se encuentra inactivo para el 
tipo de operación  1308  Si el tipo de operación es B2B o B2G (D202 =1 o 3), el RUC del 
receptor en Mara ngatu debe contar con un estado distinto a 
CANCELADO, CANCELADO DEFINITIVO o SUSPENSIÓN 
TEMPORAL  R 
57 D206e  RUC del Receptor inválido para el tipo de 
documento electrónico  1317  Si el tipo de documento es Autofactura (C002 =4), el RUC del 
Receptor deber ser  el mismo que el RUC del Emisor (D206= D101)  R 
58 D207  Dígito Verificador del RUC del receptor incorrecto  1309  El Dígito Verificador ingresado no corresponde al módulo 11 del 
RUC   R 
59 D208  Es obligatorio informar el tipo de documento de 
identidad del r eceptor  1310  Si la naturaleza del receptor es NO contribuyente (D201=2) y el tipo 
de operación es diferente a B2F ( D202≠4),  el tipo de documento de 
identidad debe ser informado  R 
60 D208a  Tipo de documento de identidad del receptor 
inválido  1311  Si la naturaleza del receptor es contribuyente (D201=1), el tipo de 
documento de identidad del receptor (D208) no debe ser i nformado  R 
61 D208b  Tipo de documento de identidad del receptor 
incorrecto para el tipo de operación  1319  El Tipo de documento de identidad del receptor no puede ser 
innominado (D208=5), cuando el tipo de operación es distinto a 
B2C (D202 ≠ 2) R 
62 D208c  Tipo de documento de identidad del receptor 
incorrecto para el total general de la operación en 
guaraníes  1321  Si el Tipo de transacción es distinto a Muestras médicas (D011≠13), 
el Tipo de documento de identidad del receptor no puede ser 
Innominado (D208 ≠5) cuando el total general de la operación en 
guaraníes (cuando la moneda es extranjera) o el total genera l de la 
operación (cuando la moneda es PYG) es mayor o igual a 
60.000.000 (F023 >= 60000000 o F014 >= 60000000)  R 
63 D208d  El tipo de documento de i dentidad del receptor no 
es requerido  1322  Si la naturaleza del receptor es Contribuyente (D201=1) o el tipo de 
operación es igual a B2F (D202=4), el tipo de documento de 
identidad no debe ser informado  R 
60 D209  Descripción del tipo de documento de ident idad 
del receptor no informada  1312  Si se informa el código de tipo de documento de identidad (D208), 
es obligatorio indicar la descripción correspondiente   R 
 
 
 
septiembre  de 2019                167 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
64 D209a  Descripción del tipo de documento de identidad 
del receptor no corresponde al código  1313 La descripción del tipo de documento de identidad del receptor no 
coincidente con lo informado en el campo D208  R 
65 D210  Es obligatorio informar el número de documento 
de identidad del receptor  1314  Si la naturaleza del receptor es NO contribuyente (D201=2)  y el tipo 
de operación es diferente a B2F (D202≠4),  el número de documento 
de identidad debe ser informado  R 
66 D210a  El número de documento de identidad del 
receptor no es requerido  1323  Si la naturaleza del receptor es contribuyente (D201=1) o el tipo d e 
operación es igual a B2F (D202=4), el número de documento de 
identidad no debe ser informado  R 
67 D213  Dirección del receptor no informado para el tipo 
de documento electrónico  1318  Si el tipo de documento electrónico informado es Nota de remisión 
elect rónica (C002=7) o cuando el tipo de operación es B2F 
(D202=4), es obligatorio informar la dirección del receptor (D213)  R 
68 D218  Es obligatorio informar el número de casa del 
receptor  1330  Si se informa la dirección del receptor (D213) es obligatorio inf ormar 
el número de casa (D218)  R 
69 D219  Es obligatorio informar el departamento del 
receptor  1324  Cuando se informa la dirección del receptor (D213) y el tipo de 
operación es distinto a B2F (D202 ≠4), es obligatorio informar el 
departamento (D219)  R 
70 D220 Descripción del departamento de emisión no 
corresponde al código  1325  Descripción del departamento de emisión no coincidente con lo 
informado en el campo D219  R 
71 D222  Descripción del distrito de emisión no 
corresponde al código  1326  Descripción del  distrito de emisión no coincidente con lo informado 
en el campo D221  R 
72 D223  Es obligatorio informar la ciudad del receptor  1327  Cuando se informa la dirección del receptor (D213) y el tipo de 
operación es distinto a B2F (D202 ≠4), es obligatorio informar la 
ciudad (D223)   R 
73 D223a  El Departamento, el Distrito y la Ciudad del 
receptor no están relacionados  1328  Debe haber relación entre el departamento (D219), el distrito 
(D221) y la ciudad (D223)  R 
74 D224  Descripción de l a ciudad de emisión no 
corresponde al código  1329  Descripción de la ciudad de emisión no coincidente con lo 
informado en el campo D223  R 
 
 
 
 
 
 
septiembre  de 2019                168 
E1. Campos que componen la Factura Electrónica FE (E010 -E099)  
N° Val  ID Mensaje de la Validación  Código  Observació n E 
75 E010  Grupo de campos que componen la FE es 
obligatorio para tipo de documento electrónico 
seleccionado  1350  Si el tipo de documento electrónico informado es FE (C002=1), el 
grupo de campos que componen la FE (E010) es obligatorio  R 
76 E010a  Grupo de campos que componen la FE no 
requerido  1351  Si el tipo de documento electrónico informado es distinto a FE 
(C002 ≠1), el grupo de campos que componen la FE (E010) no debe 
ser informado  R 
77 E012  Descripción del indicador de presencia no 
corresponde al c ódigo  1352  La descripción del indicador de presencia no coincidente con lo 
informado en el campo E011   R 
 
E1.1. Grupo de informaciones de Compras Públicas (E020 -E029)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
78 E020  Grupo de informaciones de Compras Públicas 
es obligatorio  1400  El grupo de informaciones de Compras Públicas es obligatorio para 
tipo de operación B2G (D202=3)  R 
79 E020a  Grupo de informaciones de Compras Públicas 
no requerido para el tipo de operación  1401  El grupo de informac iones de Compras Públicas solo es permitido 
para tipo de operación B2G (D202=3)  R 
80 E025  Fecha de emisión del código de contratación 
inválida  1402  La fecha de emisión del código de contratación (E025) no puede ser 
superior a la fecha de emisión (D202) de  la Factura Electrónica  R 
 
E4. Campos que componen la Autofactura Electrónica A FE (E300 -E399)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
81 E300  Para el tipo de documento electrónico 
seleccionado, es obligatorio informar el grupo de 
campos q ue componen la AFE  2550  Si el tipo de documento electrónico informado es AFE (C002 = 4), el 
grupo de campos que componen la AFE (E300) es obligatorio.  R 
 
 
 
septiembre  de 2019                169 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
82 E300a  Para el tipo de documento electrónico 
seleccionado, no se debe informar el grupo de 
campos qu e componen la AFE  2551  Para el tipo de documento electrónico informado (C002 ≠ 4), el grupo 
de campos que componen la AFE (E300) no debe informarse  R 
83 E304  El vendedor no debe ser contribuyente  2562  Cuando el Tipo de documento de identidad del vendedor es Cédula 
de identidad o Pasaporte (E304=1 o E304=2), el vendedor no debe 
ser contribuyente (E306 no debe tener RUC o el estado del RUC 
debe ser CANCELADO o CANCELADO DEFINITIVO)  R 
84 E310  El Departamento, el Distrito y la Ciudad del 
vendedor no están relacionados  2553  Debe hab er relación entre el departamento (E310), el distrito (E312) 
y la ciudad (E314)  R 
85 E311  Descripción del departamento del vendedor no 
corresponde al código  2552  Descripción del departamento no coincidente con lo informado en el 
campo E310  R 
86 E313b  Descripción del código del distrito del vendedor no  
 corresponde al código  2561  Descripción del código del distrito no coincidente con lo informado 
en el campo E312  R 
87 E315  Descripción de la ciudad del vendedor no 
corresponde al código  2555  Descripción de  la ciudad no coincidente con lo informado en el 
campo E314  R 
88 E317  El Departamento, el Distrito y la Ciudad donde se 
realiza la transacción no están relacionados  2557  Debe haber relación entre el departamento (E317), el distrito (E319) 
y la ciudad (E32 1) R 
89 E318  Descripción del departamento no corresponde al 
código donde se realiza la transacción  2556  Descripción del departamento no coincidente con lo informado en el 
campo E317  R 
90 E320  Descripción del distrito donde se realiza la 
transacción no co rresponde al  
código  2558  Descripción del distrito donde se realiza la transacción no 
coincidente con lo informado en el campo E319  R 
91 E322  Descripción de la ciudad no corresponde al código 
donde se realiza la transacción  2559  Descripción de la ciudad do nde se realiza la transacción no 
coincidente con lo informado en el campo E321  R 
 
 
 
 
 
 
 
 
septiembre  de 2019                170 
E5. Campos que componen la Nota Crédito/Débito Electrónica NCE - NDE (E400 -E499)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
92 E400  Para el tipo de documen to electrónico 
seleccionado es obligatorio informar el grupo de 
campos que componen la Nota Crédito/Débito 
Electrónica NCE – NDE  1450  Si el tipo de documento electrónico seleccionado es Nota de 
Crédito/Débito Electrónica (C002=5 o 6), es obligatorio inform ar el 
grupo de campos que componen la Nota de Crédito/Débito 
Electrónica (E400)  R 
93 E400a  Para el tipo de documento electrónico 
seleccionado no se requiere informar el grupo de 
campos que componen la Nota Crédito/Débito 
Electrónica NCE – NDE  1451  Si el t ipo de documento electrónico seleccionado es distinto a Nota 
de Crédito/Débito Electró nica (C002 ≠5 o 6), el grupo de campos que 
componen la Nota de Crédito/Débito Electrónica (E400) no debe ser 
informado  R 
94 E402  Descripción del motivo de emisión no 
corresponde al código  1452  Descripción del motivo de emisión de la Nota de Crédito/Débito 
Electróni ca no coincidente con lo informado en el campo E401  R 
 
E6. Campos que componen la Nota de Remisión Electrónica (E500 -E599) 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
95 E500  Para el tipo de documento electrónico 
seleccionado, es obligatorio informar el grupo de 
campos que componen la NRE  2600  Si el tipo de documento es Nota de remisión (C002=7), es obligatorio 
informar el grupo de campos que componen la Nota de Remisión 
(E500)  R 
96 E500a  Para el tipo de documento electrónico 
seleccionado, no  se debe informar el grupo de 
campos que componen la NRE  2601  Para el tipo de documento electrónico informado (C002 ≠ 7), el grupo 
de campos que componen la NRE (E500) no debe informarse  R 
97 E501  RUC del receptor no coincidente con el RUC del 
emisor  2606  Cuando el motivo de emisión es Traslado entre los locales de la 
empresa (E501=7), el RUC del emisor debe coincidir con el RUC del 
receptor (D101=D206)  R 
98 E502  Descripción del motivo de emisión no 
corresponde al código  2602  La descripción del motivo de emisión no coincidente con lo 
informado en el campo E501  R 
99 E504  Descripción del responsable de la emisión de la 
NRE, no corresponde al código  2603  La descripción del responsable por la emisión de la NRE, no 
coincide con lo informado en el campo E503  R 
100 E506  Fecha futura de emisión de la factura excede el 
límite permitido  2604  El mes de la fecha estimada de emisión de la factura, no puede ser 
posterior al mes de la fecha de emisión de la Nota de Remisión  R 
 
 
 
septiembre  de 2019                171 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
101 E506a  Fecha futura de emisión de la fac tura no 
informada para el tipo de documento electrónico  2605  Si el motivo de emisión es Traslado por venta (E501=1) y no se 
informan documentos asociados ( H001), es obligatorio el campo 
E506.  R 
 
E7. Campos que describen la condición de la operación (E600 –E699)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
102 E600  Para el tipo de documento electrónico 
seleccionado es obligatorio informar la condición 
de la operación  1500  Si el tipo de documento electrónico seleccionado es Factura 
Electrónica o A utofactura Electrónica (C002=1 o C002=4), es 
obligatorio informar la condición de la operación (E600)  R 
103 E600a  Para el tipo de documento electrónico 
seleccionado no se requiere informar la condición 
de la operación  1501  Si el tipo de documento electrón ico seleccionado es distinto a 
Factura Electrónica y  Autofactura Electrónica (C002 ≠1 y C002 ≠4), la 
condición de la operación no debe ser info rmada (E600)  R 
104 E601  Condición de la operación inválida para el tipo de 
documento electrónico  1503  Si el tipo d e documento es Autofactura Electrónica (C002=4) es 
obligatorio que la condición de la operación sea al contado (E601=1)  R 
105 E602  Descripción de la condición de la operación no 
corresponde al código  1502  Descripción de la condición de la operación no coi ncidente con lo 
informado en el campo E601  R 
 
E7.1. Campos que describan la forma de pago de la operación al contado o del monto de la entrega inicial (E605 -E619)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
106 E605  El grupo de campos que des criben la forma de 
pago de la operación al contado o del monto de la 
entrega inicial es obligatorio  1550  Si la condición de la operación seleccionada es contada (E601=1), 
es obligatorio informar el grupo de los campos que describen la 
forma de pago de la o peración al contado o del monto de la entrega 
inicial (E605)  R 
107 E605a  El grupo de campos que describen la forma de 
pago de la operación al contado o del monto de la 
entrega inicial ( crédito con cuota inicial ) es 
obligatorio  1551  Si la condición de la o peración seleccionada es crédito (E601=2), y 
existe monto de entrega inicial (E645), e s obligatorio informar el 
grupo de los campos que describen la forma de pago de la operación 
al contado o del monto de la entrega inicial (E605)  R 
 
 
 
septiembre  de 2019                172 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
108 E605b  El grupo de campos que describen la forma de 
pago de la operación al contado o del monto de la 
entrega inicial no requerida  1552  Si la condición de la operación seleccionada es crédito (E601=2), y 
NO existe monto de entrega inicial (E645), el grupo de los campos 
que d escriben la forma de pago de la operación al contado o del 
monto de la entrega inicial (E605) no debe ser informado  R 
109 E606  Tipo de pago inválido  1553  Si el tipo de pago informado es Pago bancario (E606=16), indicador 
de presencia seleccionado debe ser  Operación bancaria (E011=5)  
Esta validación se aplica solo al DE Factura electrónica  R 
110 E607  Descripción del tipo de pago no corresponde al 
código  1554  Descripción del tipo de pago no coincidente con lo informado en el 
campo E606  R 
111 E610  Descripc ión de la moneda no corresponde al 
código  1555  Descripción de la moneda por tipo de pago no coincidente con lo 
informado en el campo E609  R 
112 E611  Tipo de cambio no informado para la moneda por 
tipo de pago seleccionada  1556  Si la moneda por tipo de p ago es distinta a guaraníes (E609≠PYG), 
es obligatorio informar el tipo de cambio por tipo de pago (E611)  R 
113 E611a  Tipo de cambio informado es inválido para la 
moneda por tipo de pago seleccionada  1557  Si la moneda por tipo de pago es igual a guaraníes (E609=PYG), el 
tipo de cambio por tipo de pago (E611) no debe existir  R 
 
E7.1.1. Campos que describen el pago de la operación con tarjeta de crédito/ débito  (E620 -E629)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
114 E620  Grupo de campos que describen el pago o  
entrega inicial de la operación con tarjeta de 
crédito/debito es obligatorio  1600  Si el tipo de pago seleccionado es igual a Tarjeta de Crédito/Débito 
(E606=3 o 4), es obligatorio informar el grupo de los campos que 
describen el pago o entrega inicial de la operación con tarjeta de 
crédito/debito (E620)  R 
115 E620a  Grupo de los campos que describen el pago de la 
operación con tarjeta de crédito/ débito  no 
requerido  1601  Si el tipo de pago seleccionado es distinto a Tarjeta de 
Crédito/Débito (E606 ≠3 o 4), e l grupo de los campos que describen 
el pago o entrega inicial de la operación con tarjeta de crédito/debito 
(E620) no debe ser informado  R 
116 E622  Descripción de la denominación de la tarjeta no 
corresponde al código  1602  Descripción de la denominación de la tarjeta (E622) no coincidente 
con lo informado en el campo (E621)  R 
117 E623  RUC de la procesadora de tarjeta inexistente  1603  RUC de la procesadora de tarjeta (E623) inexistente en la base de 
datos de Marangatu  R 
 
 
 
septiembre  de 2019                173 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
118 E624  Digito verificador del RU C de la procesadora de 
tarjeta es inexistente  1604  El Dígito verificador ingresado (E624) no corresponde al módulo 11 
del RUC   R 
 
E7.1.2. Campos que describen el pago de la operación en cheque (E630 - E639)  
N° Val  ID Mensaje de la Validación  Código  Observa ción E 
119 E630  Grupo de los campos que describen el pago o 
entrega inicial de la operación en cheque es 
obligatorio  1650  Si el tipo de pago seleccionado es igual a Cheque (E606=2), es 
obligatorio informar el grupo de los campos que describen el pago o 
entrega inicial de la operación con cheque (E630)  R 
120 E630a  Grupo de los campos que describen el pago o 
entrega inicial de la operación en cheque no 
requerido  1651  Si el tipo de pago seleccionado es distinto a Cheque (E606 ≠2), el 
grupo de los campos que d escriben el pago o entrega inicial de la 
operación con cheque (E630) no debe ser informado  R 
 
E7.2. Campos que describen la forma de pago a crédito (E640 -E649)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
121 E640  Grupo de los campos que descr iben la forma de 
pago a crédito es obligatorio  1700  Si la condición de la operación seleccionada es igual a Crédito 
(E601=2), es obligatorio informar el grupo de los campos que 
describen la operación a crédito (E640)  R 
122 E640a  Grupo de los campos que de scriben la forma de 
pago a crédito no requerido  1701  Si la condición de la operación seleccionada es distinta a Crédito 
(E601 ≠2), el grupo de los campos que describen la operación a 
crédito (E640) no debe ser informado  R 
123 E642  Descripción de la condici ón de la operación a 
crédito no corresponde al código  1702  Descripción de la condición de la operación a crédito no coincidente 
con lo informado en el campo E641  R 
124 E643  Plazo del crédito es obligatorio  1703  Si la condición de la operación a crédito seleccionada es igual a 
Plazo (E641=1), es obligatorio informar el plazo del crédito (E643)  R 
125 E643a  Plazo del crédito no requerido  1704  Si la condición de la operación a crédito seleccionada es distinta a 
Plazo (E641 ≠1), el plazo del crédito (E643) no debe ser informado  R 
126 E644  Cantidad de cuotas es obligatorio  1705  Si la condición de la operación a crédito seleccionada es igual a 
Cuota (E641=2), es obligatorio informar la cantidad de cuotas (E644)  R 
 
 
 
septiembre  de 2019                174 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
127 E644a  Cantidad de cuotas no requerida  1706  Si la condición de la operación a crédito seleccionada es distinta a 
Cuota (E641≠2), la cantidad de cuotas (E644) no debe ser informada  R 
 
E7.2.1 Campos que describen las cuotas (E650 -E659)  
N° Val  ID Mensaje de la Valida ción Código  Observación  E 
117 E650  Grupo de los campos que describen las cuotas es 
obligatorio  1750  Si la condición de la operación a crédito seleccionada es igual a 
Cuota (E641=2), es obligatorio informar el grupo de los campos que 
describen las cuotas ( E650)  R 
128 E650a  Grupo de los campos que describen las cuotas no 
requerido  1751  Si la condición de la operación a crédito seleccionada es distinta a 
Cuota (E641≠2), el grupo de los campos que describen las cuotas 
(E650) no debe ser informado  R 
 
E8. Campos que describen los ítems de la operación (E700 -E899)  
N° Val  ID Mensaje de la Validació n Código  Observación  E 
129 E704  Código de DNCP - Nivel General es obligatorio 
para el tipo de operación B2G  1800  Si el tipo de operación seleccionado es igual a B2G (D202=3), es 
obligatorio informar el Código DNCP – Nivel General (E704)  R 
130 E705  Código  de DNCP – Nivel Específico es obligatorio  1801  Si se informa el Código de DNCP – Nivel General (E704) es 
obligatorio informar el código de DNCP – Nivel Específico (E705)  R 
131 E710  Descripción de la unidad de medida no 
corresponde al código  1802  Descripc ión de la unidad de medida no coincidente con lo informado 
en el campo E709   R 
132 E713  Descripción del país de origen del producto no 
corresponde al código   1804  Descripción del país de origen del producto no coincidente con lo 
informado en el campo E712  R 
132 E715  Código de datos de relevancia de las mercaderías 
no informado para el tipo de documento 
electrónico  1805  Si el tipo de documento es Nota de remisión electrónica (C002=7), 
es obligatorio informar E715  R 
133 E715  Código de datos de relevancia d e las mercaderías 
no requerido para el tipo de documento 
electrónico  1807  No se debe informar el código de datos de relevancia de las 
mercaderías cuando el tipo de documento electrónico es distinto a 
Nota de remisión (C002≠7)  R 
 
 
 
septiembre  de 2019                175 
N° Val  ID Mensaje de la Validació n Código  Observación  E 
134 E716  Descripción del có digo de datos de relevancia de 
las mercaderías no corresponde al código  1806  La descripción del código de datos de relevancia de las mercaderías 
no coincidente con lo informado en el campo E715  R 
135 E717  Se debe informar la cantidad o el porcentaje de 
quiebra o merma  1808  Cuando se informa el Código de datos de relevancia de mercaderías 
(E715) es obligatorio informar uno de los siguientes datos: la 
cantidad de quiebra o merma (E717) o el porcentaje de quiebra o 
merma (E718)  R 
 
E8.1.  Campos que desc riben el precio , tipo de cambio y valor total de la operación por ítem (E720 -E729)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
136 E720  Grupo de los campos que describen los precios, 
descuentos y valor total por ítem es obligatorio  1850  El grupo de los campos que describen los precios, descuentos y 
valor total por ítem (E720) es obligatorio para todos los tipos de 
documentos electrónicos excepto para Nota Remisión Electrónica 
(C002=7)  R 
137 E720a  Grupo de los campos que describen los precios, 
descue ntos y valor total por ítem no requerido  1851  Si el tipo de documento electrónico seleccionado es igual a Nota de 
Remisión Electrónica (C002=7), e l grupo de los campos que 
describen los precios, descuent os y valor total por ítem (E720) no 
debe ser informad o R 
138 E725  Tipo de cambio por ítem no informado  1854  Si la condición del tipo de cambio es Por ítem (D017=2) es 
obligatorio informar el tipo de cambio  R 
139 E725a  Tipo de cambio por ítem no requerido  1855  Si la condición del tipo de cambio es Global ( D017=1), el tipo de 
cambio por ítem no debe ser informado  R 
140 E725b  La moneda de la operación seleccionada no 
requiere tipo de cambio por ítem  1856  Si la moneda de la operación (D015) es igual a PYG, el tipo de 
cambio por ítem (E725) no debe existir  R 
141 E727  Error en el cálculo del valor total bruto de la 
operación por ítem  1859  Cálculo del valor total bruto de la operación por ítem incorrecto  
E727 debe corresponder al cálculo aritmético E721 * E711  
 R 
 
 
 
 
 
 
septiembre  de 2019                176 
E8.1.1  Campos que describen los descuentos, anticipos y valor total por ítem (EA001 -EA050)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
142 EA003  Porcentaje de descuento particular por ítem no 
informado  1852  Si se informa el campo de descuento por ítem ( EA002 ) con un monto 
superior a 0 (cero), es obligatorio indicar el porcentaje respectivo  R 
143 EA003a  Error en el cálculo del porcentaje de descuento 
particular por ítem  1861  EA003 representa el porcentaje de descuento de EA002 con 
respecto al precio unitario del producto y/o servicios ( E721)  
Según la siguiente fórmula:  
[EA002 * 100 / E721]  
 
Puede haber una variación de 0.8  R 
144 EA004  El descuento global sobre el precio unitario por 
ítem no coincidente con lo informado  
 1862  El descuento global sobre el precio unitario por ítem no coin cide con 
lo informado en el porcentaje de descuento global sobre total de la 
operación (F010)  
Según la siguiente fórmula: [EA004 * 100 / E721]  
 
Puede haber una variación de 0.8   R 
145 EA008  Error en el cálculo del valor total de la operación 
por ítem  1853  Cálculo del valor total de la operación por ítem incorrecto  
EA00 8 debe corresponder al cálculo aritmético:  
 
IVA: (E721 - EA002 – EA004 – EA006 – EA007) * E711  R 
146 EA009  Valor total de la operación por ítem en guaraníes 
no informado  1857  Si se informa e l tipo de cambio por ítem (E725), el valor total de la 
operación por ítem en guaraníes es obligatorio  R 
147 EA009a  Error en el cálculo del valor total de la operación 
por ítem en guaraníes  1858  Cálculo del valor total de la operación por ítem en guaraníes  
incorrecto  
EA00 9 debe corresponder al cálculo aritmético EA00 8 * E725  R 
 
 
 
 
 
 
 
 
 
 
septiembre  de 2019                177 
E8.2.  Campos que describen el IVA de la operación (E730 -E739)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
148 E730  Grupo de los campos que describen el IVA de la 
operación es obligatorio  1900  Si el tipo de impuesto al consumo afectado es IVA o Renta o 
Ninguno o IVA - Renta  (D013=1 o 3 o 4  o 5), el grupo de los campos 
que describen el IVA de la operación (E730) es obligatorio para 
todos los tipos de documentos elect rónicos excepto Factura 
Electrónica de Importación, Autofactura Electrónica o Nota de 
Remisión Electrónica (C002=3, 4 o 7)  R 
149 E730a  Grupo de los campos que describen el IVA de la 
operación no requerido para el tipo de documento 
electrónico seleccionado  1901  Si el tipo de documento electrónico seleccionado es igual a Factura 
Electrónica de Importación, Autofactura Electrónica o Nota de 
Remisión Electrónica (C002=3, 4 o 7), el grupo de los campos que 
describen el IVA d e la operación (E730) no debe ser inf ormado  R 
150 E730b  Grupo de los campos que describen el IVA de la 
operación no requerido para el tipo de impuesto 
al consumo afectado seleccionado  1902  Si el tipo de impuesto al consumo afectado es igual a ISC (D013=2), 
el grupo de los campos que describe n el IVA de la operación (E730) 
no debe ser informado  R 
151 E732  Descripción de la forma de afectación tributaria 
del IVA no corresponde al código  1903  Descripción de la forma de afectación tributaria del IVA coincidente 
con lo informado en el campo E73 1 R 
152 E733  Proporción gravada del IVA incorrecta para forma 
de afectación Gravado IVA  1904  Si la forma de afectación tributaria del IVA informada es Gravado 
IVA (E731=1), la proporción gravada del IVA debe ser igual a 100 
(cien)   R 
153 E733a  Proporción  gravada del IVA incorrecta para forma 
de afectación Exonerado o E xento  1905  Si la forma de afectación tributaria del IVA informada es Exonerado 
o Exento (E731=2 o 3), la proporción gravada del IVA debe ser igual 
a 0 (cero)  R 
154 E733b  Proporción gravada del IVA incorrecta para forma 
de afectación Gravado Parcial  1906  Si la forma de afectación tributaria del IVA informada es Gravado 
parcial (E731=4), la proporción gravada del IVA debe ser inferior a 
100 (cien) y superior a 0 (cero)  R 
155 E734  Tasa del IVA  es incorrecta para forma de 
afectación Exonerado o Exento  1907  Para la forma de afectación tributaria Exonerado  o Exento (E731=2 
o 3), la tasa del IVA informada (E734) debe ser igual a 0 (cero)  R 
156 E734a  Tasa del IVA es incorrecta para la forma de 
afectación Gravado IVA o Gravado parcial  1908  Para la forma de afectación tributaria Gravado IVA  o Gravado 
parcial  (E731=1 o 4), la tasa del IVA informada (E734) debe ser 
igual a 5 (cinco) o 10 (diez)  R 
157 E735  Error en el cálculo de la base gravada del IVA  por 
ítem para forma de afectación Exonerado o 
Exento  1909  Si la forma de afectación tributaria del IVA informada es Exonerado  
o Exento (E731=2 o 3) , la base gravada del IVA por ítem (E735) 
debe ser igual a 0 (cero)  R 
 
 
 
septiembre  de 2019                178 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
158 E735a  Error en el cálculo de la b ase gravada del IVA por 
ítem para tasa del 5%  1910  Cálculo de la base gravada del IVA por ítem incorrecto  
Si E734 = 5 este campo es igual al resultado del cálculo  
 [EA008* (E733/100)] / 1,05  R 
159 E735b  Error en el cálculo de la base gravada del IVA por  
ítem para tasa del 10%  1911  Cálculo de la base gravada del IVA por ítem incorrecto  
Si E734 = 10 este campo es igual al resultado del cálculo  
[EA00 8 * (E733/100)] / 1,1  R 
160 E736  Error en el cálculo de la liquidación del IVA por 
ítem para forma de afec tación Exonerado o 
Exento  1912  Si la forma de afectación tributaria del IVA informada es Exonerado  
o Exento (E731=2 o 3), la liquidación del IVA por ítem (E736) debe 
ser igual a 0 (cero)  R 
161 E736a  Error en el cálculo de la liquidación del IVA por 
ítem p ara forma de afectación Gravado IVA o 
Gravado Parcial  1913  Cálculo de la liquidación del IVA por ítem incorrecto  
Corresponde al cálculo aritmético:  
E735 * (E734/100) para la forma de afectación tributaria Gravado 
IVA o Gravado parcial  (E731=1 o 4)  R 
 
E9.5  Grupo de datos adicionales de uso comercial (E820 -E829)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
162 E822  Fecha de inicio de ciclo es obligatorio  2050  La fecha de inicio del ciclo (E812) es obligatoria si se informa el 
campo E811  R 
163 E822a Fecha de inicio de ciclo no requerida  2051  Si NO se informa el campo E811, la fecha de inicio de ciclo no debe 
ser informada  R 
164 E823  Fecha de fin de ciclo es obligatoria  2052  La fecha de fin de ciclo (E813) es obligatoria si se informa la fecha 
de inicio de ciclo (E812)  R 
165 E823a  Fecha de fin de ciclo no requerida  2053  Si NO se informa el campo E812, la fecha de fin de ciclo no debe 
ser informada  R 
166 E823b  Fecha de fin de ciclo inválida  2054  La fecha de fin de ciclo (E813) debe ser mayor o igu al a la fecha de 
inicio de ciclo (E812)  R 
167 E824  Fecha de vencimiento del pago es retrasada  2055  La fecha de vencimiento para el pago no debe ser anterior a la fecha 
de emisión del DE (D002)  R 
 
 
 
 
 
 
 
septiembre  de 2019                179 
E10. Campos que describen el transporte de las mercader ías (E900 -E999)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
168 E900  Grupo de los campos que describen el transporte 
de las mercaderías es obligatorio  2100  Si el tipo de documento electrónico seleccionado es igual Nota de 
Remisión Electrónica (C002=7), es obligatorio informar el grupo de 
campos que describen el transporte de las mercaderías  R 
169 E900a  Grupo de los campos que describen el transporte 
de las mercaderías no es permitido para el tipo de 
DE seleccionado  2101  El grupo de los campos que describen el transporte de las 
mercaderías no es permitido para Autofactura Electrónica, Nota de 
Crédito Electrónica, Nota de Débito Electrónica o Comprobante de 
Retención Electrónico (C002=4, 5, 6 o 8)  R 
170 E901  Tipo de transporte no informado  2102  Es obligatorio informar el tipo de transporte (E901) para operaciones 
con Nota de Remisión Electrónica (C002 = 7)  R 
171 E902  Descripción del tipo de transporte no corresponde 
al código  2103  Descripción del tipo de transporte (E902) no coincidente con lo 
informado en el campo E901  R 
172 E904  Descripción de la modalidad de transporte no 
corresponde al código  2104  Descripción de la modalidad de transporte (E904) no corresponde a 
lo informado en el campo E903  R 
173 E909  Fecha estimada de inicio de traslado no 
informada  2107  Es obligatorio informar la fecha estimada de inicio de traslado (E909) 
para el tipo de documento electrónico seleccionado  
(C002=7)  R 
174 E909a  Fecha estimada de inicio de traslado es antigua  2108  Si se informa la fecha estimada de inic io de traslado (E909), ésta 
debe ser posterior a fecha en producción de SIFEN  R 
175 E910  Fecha estimada de fin de traslado no informada  2109  Es obligatorio informar la fecha estimada de fin de traslado (E910) 
para el tipo de documento electrónico seleccio nado (C002= 7)  R 
176 E910a  Fecha estimada de fin de traslado es inválida  2110  Si se informa la fecha estimada de fin de traslado (E910), ésta debe 
ser igual o mayor a la fecha estimada de inicio de traslado (E908)  R 
186 E912  Descripción del país de desti no no informada  2112  Si se informa el código  de país de destino (E911), es obligatorio 
indicar la descripción del país de destino (E912)  R 
177 E912a  Descripción del país de destino no corresponde 
al código  2113  Descripción del país de destino (E912) no co incidente con lo 
informado en el campo E911  R 
 
 
 
 
 
 
 
 
 
septiembre  de 2019                180 
E10.1.  Campos que identifican el local de salida de las mercaderías (E920 -E939)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
178 E920  Grupo de los campos que identifican el local de 
salida de  las mercaderías es obligatorio  2150  Si el tipo de documento electrónico seleccionado es igual a Factura 
Electrónica de Exportación o Nota de Remisión Electrónica (C002=2 
o 7), es obligatorio informar el grup o de los campos que identifican 
el local de sali da de las mercaderías  R 
179 E920a  Grupo de los campos que identifican el local de 
salida de las mercaderías no es permitido para el 
tipo de documento electrónico seleccionado  2151  El grupo de los campos que identifican el local de salida de las 
mercadería s no es permitido para Autofactura Electrónica, Nota de 
Crédito Electrónica, Nota de Débito Electrónica o Comprobante de 
Retención Electrónica (C002=3, 4, 5, 6 o 8)  R 
180 E925  El Departamento, el Distrito y Ciudad del local de 
Salida no están relacionados  2153  Debe haber relación entre el departamento (E925), el distrito (E927) 
y la ciudad (E929)  R 
181 E926  Descripción del departamento del local de salida 
no corresponde al código  2152  Descripción del departamento del local de salida no coincidente con 
lo informado en el campo E925  R 
193 E928  Descripción del código de distrito del local de 
salida no informada  2154  Si se informa el código del distrito del local de salida (E927), la 
descripción del mismo es obligatoria  R 
182 E928a  Descripción del distrito del local de salida no 
corresponde al código  2155  Descripción del distrito del local de salida no coincidente con lo 
informado en el campo E927  R 
159 E929  La ciudad del local de salida no corresponde al 
departamento seleccionado  2156  El código de la ciuda d del local de salida (E929) debe corresponder 
al departamento seleccionado (E925)  R 
160 E929a  La ciudad del local de salida no corresponde al 
distrito seleccionado  2157  El código de la ciudad del local de salida (E929) debe corresponder 
al distrito selec cionado (E927)  
No se aplica esta regla si no ha sido informado el distrito  R 
183 E930  Descripción de la ciudad del local de salida no 
corresponde al código  2158  Descripción de la ciudad del local de salida no coincidente con lo 
informado en el campo E929  R 
 
 
 
 
 
 
 
 
 
septiembre  de 2019                181 
E10.2.  Campos que identifican el local de entrega de las mercaderías (E940 -E959)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
184 E940  Grupo de los campos que identifican el local de 
entrega de las mercaderías es obligatorio  2200  Si el tipo de documento electrónico seleccionado es Nota de 
Remisión Electrónica (C002=7), es obligatorio informar el grupo de 
los campos que identifican el local de entrega de las mercaderías  R 
185 E940a  Grupo de los campos que identifican el local de 
entreg a de las mercaderías no es permitido para 
el tipo de documento electrónico seleccionado  2201  El grupo de campos que identifican el local de entrega de las 
mercaderías no es permitido para el tipo de documento Autofactura 
Electrónica, Nota de Débito Electró nica, Nota de Crédito Electrónica 
o Comprobante de Re tención Electrónico (C002=4, 5, 6 o 8)  R 
186 E945  El Departamento, el Distrito y la Ciudad del local 
de entrega no están relacionados  2203  Debe haber relación entre el departamento (E945), el distrito ( E947) 
y la ciudad (E949)  R 
187 E946  Descripción del departamento del local de entrega 
no corresponde al código  2202  Descripción del departamento del local de entrega no coincidente 
con lo informado en el campo E945  R 
201 E948  Descripción del código del distrito del local de la 
entrega no informada  2204  Si se informa el código del distrito del local de entrega (E947), la 
descripción del mismo es obligatoria  R 
188 E948a  Descripción del distrito del local de entrega no 
corresponde al código  2205  Descripció n del distrito del local de entrega no coincidente con lo 
informado en el campo E947  R 
168 E949  La ciudad del local de entrega no corresponde al 
departamento seleccionado  2206  El código de la ciudad del local de entrega (E949) debe 
corresponder al departa mento seleccionado (E945)  R 
169 E949a  La ciudad del local de entrega no corresponde al 
distrito seleccionado  2207  El código de la ciudad del local de entrega (E949) debe 
corresponder al distrito seleccionado (E947)  
No se aplica esta regla si no ha sido informado el distrito  R 
189 E950  Descripción de la ciudad del local de entrega no 
corresponde al código  2208  Descripción de la ciudad del local de entrega no coincidente con lo 
informado en el campo E949  R 
 
E10.3.  Campos que identifican el vehículo de tra slado de mercaderías (E960 -E979)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
190 E960  Grupo de los campos que identifican el vehículo 
de traslado de las mercaderías es obligatorio  2250  Si el tipo de documento electrónico seleccionado es Nota d e 
Remisión Electrónica (C002=7), es obligatorio informar el grupo de 
los campos que identifican el vehículo de traslado de las 
mercaderías  R 
 
 
 
septiembre  de 2019                182 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
191 E960a  Grupo de los campos que identifican el vehículo 
de traslado de las mercaderías no es permitido 
para el t ipo de documento electrónico 
seleccionado  2251  El grupo de campos que identifican el vehículo de traslado de las 
mercaderías no es permitido para el tipo de documento Autofactura 
Electrónica, Nota de Débito Electrónica,  Nota de Crédito Electrónica 
o Compro bante de Retención Electrónico (C002=4, 5, 6 o 8)  R 
192 E963  Tipo de identificación del vehículo no informado  2255  Se requiere el número de identificación del vehículo cuando el tipo 
de identificación del vehículo es 1 (E967=1)  R 
193 E965  Número de matrí cula del vehículo no informado  2254  Se requiere número de matrícula del vehículo cuando el tipo de 
identificación del vehículo es 2 (E967=2)  R 
194 E966  Número de vuelo no informado  2252  Se requiere número de vuelo para la modalidad de transporte 
seleccion ada (E903 = 3)  R 
195 E966a  Número de vuelo no requerido  2253  Si la modalidad de transporte seleccionada  es distinta a Aéreo 
(E903 ≠ 3) el número de vuelo (E965) no debe ser informado  R 
 
E10.4.  Campos que identifican al transportista (persona física o jur ídica) (E980 -E999)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
196 E980  Grupo de los campos que identifican al 
transportista (persona física o jurídica) es 
obligatorio  2300  Si el tipo de documento electrónico seleccionado es Nota de 
Remisión E lectrónica (C002=7), es obligatorio informar el grupo de 
los campos que identifican al transportista (persona física o jurídica)  R 
197 E980a  Grupo de los campos que identifican al 
transportista (persona física o jurídica) no es 
permitido para el tipo de d ocumento electrónico 
seleccionado  2301  El grupo de campos que identifican al transportista (persona física o 
jurídica) no es permitido para el tipo de documento Autofactura 
Electrónica, Nota de Débito Electrónica, Nota de Crédito Electrónica 
o Comprobante de Retención Electrónico (C002=4, 5, 6 o 8)  R 
198 E983  RUC del transportista no informado  2302  Se requiere informar el número de RUC si la naturaleza del 
transportista es igual a contribuyente (E981 = 1)  R 
199 E983a  RUC del transportista inexistente  2303 El RUC del transportista informado no existe en la base de datos de 
Marangatu  R 
200 E983b  El RUC del transportista se encuentra inactivo  2304  El RUC del transportista debe contar con un estado distinto a 
CANCELADO, CANCELADO DEFINITIVO o SUSPENSIÓN 
TEMP ORAL en Marangatu al momento de la emisión del DE  R 
201 E983c  RUC del transportista no requerido  2305  Si la naturaleza del transportista es distinta a contribuyente (E981 ≠1) 
el RUC del transportista (E983) no debe ser informado  R 
202 E984  Dígito Verificador del RUC del transportista 
incorrecto  2306  El Dígito Verificador ingresado (E984) no corresponde al módulo 11 
del RUC  R 
 
 
 
septiembre  de 2019                183 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
203 E985  Tipo de documento de identidad del tra nsportista 
no informado  2307  Se requiere informar el tipo de documento de identidad si la 
naturaleza del transportista es igual a NO contribuyente  (E981=2)  R 
204 E985a  Tipo de documento de identidad del transportista 
no requerido  2308  Si la naturaleza del  transportista es igual a contribuyente (E981 =1) 
el tipo de documento de identidad del transportista (E985) no debe 
ser informado  R 
205 E986  Descripción del tipo de documento de identidad 
del transportista no informada  2309  Si se informa el código de tip o de documento de identidad del 
transportista (E985), es obligatorio indicar la descripción del mismo 
(E986)  R 
206 E986a  Descripción del tipo de documento de identidad 
del transportista no corresponde al código  2310  Descripción del tipo de documento de id entidad del transportista 
(E986) no coincidente con lo informado en el campo E985  R 
207 E987  Número de documento de identidad del 
transportista no informado  2311  Si se informa el código de tipo de documento de identidad del 
transportista (E985), el número  de dicho documento es requerido   R 
208 E989  Descripción de la nacionalidad del transportista no 
informada  2312  Si se informa el código de nacionalidad del transportista (E988), es 
obligatorio indicar la descripción (E989) del mismo  R 
209 E989a  Descripc ión de la nacionalidad del transportista no 
corresponde al código  2313  Descripción de la nacionalidad del transportista (E989) no 
coincidente con lo informado en el campo E988  R 
 
F. Campos que describen los subtotales y totales de la transacción documenta da (F001 -F099)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
210 F001  Grupo de los campos que describen los 
subtotales y totales de la transacción 
documentada es obligatorio para el tipo de 
documento electrónico seleccionado  2350  Si el tipo de d ocumento electrónico seleccionado es distinto a Nota 
de Remisión Electrónica (C002≠7), es obligatorio informar el grupo 
de campos que describen los subtotales y totales de la transacción 
documentada  R 
211 F001a  Grupo de los campos que describen los 
subtotales y to tales de la transacción 
documentada no es permitido para el tipo de 
documento electrónico seleccionado  2351  El grupo de los campos que describen los subtotales y totales de la 
transacción documentada no es permitido para el tipo de documento 
electrónico No ta de Remisión Electrónica (C002=7)  R 
212 F002  Subtotal de operaciones exentas de IVA no 
informado  2352  Si se informan operaciones exentas, es obligatorio reportar el 
subtotal de dichas operaciones  
Si el campo E731=3 debe existir F002  R 
213 F002a  Cálcu lo del subtotal de la operación exenta 
incorrecto  2353  Error en el cálculo del subtotal de la operación exenta.  
Calculo debe ser igual a la suma de todas las ocurrencias de EA00 8 
cuando E731=3  R 
 
 
 
septiembre  de 2019                184 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
214 F003  Subtotal de operaciones exoneradas de IVA no 
informado  2354  Si se informan operaciones exoneradas, es obligatorio reportar el 
subtotal de dichas operaciones  
Si el campo E731=2 debe existir F003  R 
215 F003a  Cálculo del subtotal de la operación exonerada 
incorrecto  2355  Error en el cálculo del subtotal  de la operación exonerada.  
Calculo debe ser igual a la suma de todas las ocurrencias de EA00 8 
cuando E731=2  R 
216 F004  Subtotal de operaciones gravadas al 5% de IVA 
no informado  2356  Si se informan operaciones gravadas al 5%, es obligatorio reportar 
el subtotal de dichas operaciones.  
Si el campo E731=1 o 4 y E734=5 debe existir F004  
Corresponde al porcentaje (%) de la tasa expresado en números 
enteros  R 
217 F004a  Cálculo del subtotal de la operación gravada al 
5% incorrecto  2357  Error en el cálculo d el subtotal de la operación gravada al 5%. 
Calculo debe ser igual a la suma de todas las ocurrencias de EA00 8 
cuando E734=5  R 
218 F005  Subtotal de operaciones gravadas al 10% de IVA 
no informado  2358  Si se informan operaciones gravadas al 10%, es obligat orio reportar 
el subtotal de dichas operaciones.  
Si el campo E731=1 o 4 y E734=10 debe existir F005  
Corresponde al porcentaje (%) de la tasa expresado en números 
enteros  R 
219 F005a  Cálculo del subtotal de la operación gravada al 
10% incorrecto  2359  Error en el cálculo del subtotal de la operación gravada al 10%. 
Calculo debe ser igual a la suma de todas las ocurrencias de EA00 8 
cuando E734=10  R 
220 F008  Cálculo del total de la operación incorrecto  2362  Error en el cálculo del total de la operación.  
Si la operación es grabada con IVA, Renta o Ninguno (D013=1 , 3, 4 
o 5) el cálculo debe ser igual a la suma F002+F003+F004+F005  
Cuando C002=4 corresponde a la suma de todas las ocurrencias de 
EA008 (Valor total de la operación por ítem)  R 
221 F009  Cálculo del total descuento por ítem incorrecto.  2363  Error en el cálculo del total de descuento por ítem  
Calculo debe ser igual la suma de todas las ocurrencias de EA002  
multiplicado por la cantidad EA002 *E711  R 
222 F011  Cálculo del descuento sobre el total de  la 
operación incorrecto  2364  Error en el cálculo del descuento sobre el total de la operación  
Es la sumatoria de EA002 y EA004 de cada ítem  R 
223 F014  Cálculo del total general de la operación 
incorrecto.  2365  Error en el cálculo del total general de la  operación  
Cuando C002=1, 5 o 6 el cálculo debe ser igual a F008 –F011 –F012 -
F013  R 
 
 
 
septiembre  de 2019                185 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
224 F015  Si se informan operaciones gravadas al 5%, es 
obligatorio reportar la liquidación del IVA de 
dichas operaciones  2366  Liquidación del IVA a la tasa del 5% no inform ada.   
Si se informa la liquidación del IVA por ítem (E736) y E734=5, el 
campo F015  debe existir  R 
225 F015a  Cálculo de la liquidación del IVA a la tasa del 5% 
incorrecto  2367  Error en el cálculo de la liquidación del IVA a la tasa del 5%.  
Calculo debe s er igual a la suma de todas las ocurrencias de E736 
cuando E734=5  R 
226 F016  Si se informan operaciones gravadas al 10%, es 
obligatorio reportar la liquidación del IVA de 
dichas operaciones  2368  Liquidación del IVA a la tasa del 10% no informada.   
Si se informa la liquidación del IVA por ítem (E736) y E734=10, el 
campo F016  debe existir  R 
227 F016a  Cálculo de la liquidación del IVA a la tasa del 10% 
incorrecto  2369  Error en el cálculo de la liquidación del IVA a la tasa del 10%.  
Calculo debe ser igual a  la suma de todas las ocurrencias de E736 
cuando E734=10  R 
228 F017  Es obligatorio informar la liquidación total del IVA  2370  Liquidación total del IVA no informada.  
Si existe campo F015  y/o F016  es obligatorio informar F017  R 
229 F017a  Cálculo de la li quidación total del IVA incorrecto  2371  Error en el cálculo de la liquidación total del IVA  
Calculo debe ser igual a la suma F015 +F016  R 
230 F018  Si se informan operaciones gravadas al 5%, es 
obligatorio reportar el total de la base gravada de 
dichas op eraciones  2372  Total base gravada al 5% no informado   
Si se informa la base gravada del IVA por ítem (E735) y E734=5, el 
campo F018  debe existir  R 
231 F018a  Cálculo total base gravada al 5% incorrecto  2373  Error en el cálculo del total base gravada al 5 % 
Calculo debe ser igual a la suma de todas las ocurrencias de E735 
cuando E734=5  R 
232 F019  Si se informan operaciones gravadas al 10%, es 
obligatorio reportar el total de la base gravada de 
dichas operaciones  2374  Total base gravada al 10% no informado   
Si se informa la base gravada del IVA por ítem (E735) y E734=10, 
el campo F019  debe existir  R 
233 F019a  Cálculo total base gravada al 10% incorrecto  2375  Error en el cálculo del total base gravada al 10%  
Calculo debe ser igual a la suma de todas las ocu rrencias de E735 
cuando E734=10  R 
234 F020  Es obligatorio informar el total de la base gravada 
de IVA  2376  Total de la base gravada del IVA no informada.  
Si existe campo F018  y/o F019  es obligatorio informar F020  R 
235 F020a  Cálculo del total de la base  gravada del IVA 
incorrecto  2377  Error en el cálculo del total de la base gravada del IVA  
Calculo debe ser igual a la suma F018 +F019  R 
236 F023  Si se informan operaciones con moneda 
extranjera, es obligatorio reportar el total general 
de la operación en guaraníes  2382  Si moneda de la operación es diferente de guaraníes (D015≠PYG) 
es obligatorio informar total general de la operación en guaraníes 
(F023 ) R 
 
 
 
septiembre  de 2019                186 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
237 F023a  Cálculo del total general de la operación en 
guaraníes incorrecto para la condición del tipo de 
cambio glo bal  2385  Error en el cálculo del total general de la operación en guaraníes  
Si moneda de la operación es diferente de guaraníes (D015≠PYG) 
y la condición del tipo de cambio es global (D017=1) el cálculo debe 
ser F014 *D018  R 
238 F023b  Cálculo del total g eneral de la operación en 
guaraníes incorrecto para la condición del tipo de 
cambio por ítem  2386  Error en el cálculo del total general de la operación en guaraníes  
Si moneda de la operación es diferente de guaraníes (D015≠PYG) 
y la condición del tipo de cambio es por ítem (D017=2) el cálculo 
debe ser igual a la suma de los totales en guaraníes por ítem 
(EA00 9) R 
 
G1. Campos generales de la carga (G050 - G099)  
 
N° Val  ID Mensaje de la Validación  Código  Observación  E 
239 G050  Grupo generales de la carga n o es permitido para 
el tipo de documento electrónico seleccionado  2390  El grupo de los campos generales de la carga no es permitido para 
tipos de documento distintos a factura electrónica o Nota de 
Remisión Electrónica (C002≠1 y C002≠7)  R 
 
H. Campos que identifican  al documento asociado (H001 -H049)  
N° Val  ID Mensaje de la Va lidación  Código  Observación  E 
240 H001  Documento asociado es obligatorio para el tipo de 
documento electrónico seleccionado  2400  Si el tipo de documento electrónico seleccionado es igu al a 
Autofactura , Nota de Crédito Electrónica, Nota de Débito Electróni ca 
o Comprobante de Retención (C002= 4, 5, 6 o 8), es obligatorio 
informar el grupo de campos que identifican al documento asociado  R 
 
 
 
septiembre  de 2019                187 
N° Val  ID Mensaje de la Va lidación  Código  Observación  E 
241 H001a  No informar el grupo de documento asociad o 2414  Cuando el tipo de DE es Factura electrónica (C002=1), SIFEN 
perm ite su asociación con los siguientes documentos:  
 
Con Nota de remisión:  Si este tipo de documento asociado es 
electrónico H002=1, el CDC del DTE referenciado debe pertenecer 
a una Nota de remisión. Si este tipo de documento asociado es 
impreso H002=2, el t ipo de documento impreso debe ser Nota de 
remisión H009=4  
 
 Con Factura : cuando el tipo de transacción del documento asociado 
es Anticipo (D011 del documento asociado = 9). Si este tipo  de 
documento asociado es electrónico H002=1, el CDC del DTE 
referencia do debe pertenecer a una FE. Si este tipo de documento 
asociado es impr eso H002=2, el tipo de documento impreso debe 
ser Factura H009=1  
  
Cuando el tipo de DE es Nota de crédito o Nota de débito (C002=5 
o 6), no se debe informar un grupo de documento asoci ado distinto 
a Factura electrónica (Si el tipo de documento asociado es  
electrónico H002=1, el CDC del DTE referenciado debe pertenecer 
a una Factura electrónica. Si el tipo de document o asociado es 
impreso H002=2, el tipo de documento impreso debe ser Fac tura 
H009=1)  
 
Cuando el tipo de DE es Nota de remisión (C002=7) y se informa 
uno o más documentos asociados distintos a Factura electrónica (Si 
el tipo de documento asociado es electrón ico H002=1, el CDC del 
DTE referenciado debe pertenecer a una Factura e lectrónica. Si el 
tipo de documento asociado es impreso H002=2, el ti po de 
documento impreso debe ser Factura H009=1)  
 R 
242 H001b  Cantidad incorrecta de documento(s) asociado(s)  2415  Cuando el tipo de documento electrónico es Autofactura, Nota de 
crédito  o nota de débito (C002=4, C002=5 o C002=6), el grupo de 
documento asociado informado puede aparecer una sola vez.  
  R 
 
 
 
septiembre  de 2019                188 
N° Val  ID Mensaje de la Va lidación  Código  Observación  E 
243 H002  Tipo de documento asociado obligatorio para el 
tipo de documento electrónico  2416  Si el tipo de documento electrónico recibido  es Autofactura 
(C002=4), el tipo de documento asociado debe ser constancia 
electrónica (H002=3)  R 
244 H002a  Tipo de documento asociado no requerido para el 
tipo de documento electróni co 2434  Si el tipo de documento electrónico recibido es Factura electró nica, 
Nota de crédito, Nota de débito o Nota de remisión (C002=1,5,6 o 
7), el tipo de documento asociado no puede ser constancia 
electrónica (H002 ≠ 3)  R 
247 H002c  CDC no requerido par a el tipo de documento 
asociado  2419  Cuando el tipo de documento asoci ado es impreso no se debe 
informar el CDC del DTE (H004)  R 
250 H002  CDC no informado  2416  Cuando el tipo de documento asociado es electrónico es obligatorio 
informar el CDC del DTE  R 
245 H003  Descripción del tipo de documento asociado no 
corresponde al  código  2401  Descripción del tipo de documento asociado no coincidente con lo 
informado en el campo H002  R 
246 H004  Número de CDC del DTE referenciado no 
informado  2402  Si el tipo de documento asociado seleccionado es igual a 
Electrónico (H002=1), es obl igatorio informar el número de CDC del 
DTE referenciado  R 
247 H004a  Número de CDC del DTE referenciado inexistente  2403  El CDC del documento asociado informado es inexistente  R 
248 H004b  El CDC informado corresponde a un DTE 
cancelado  2404  El DTE refe renciado se encuentra cancelado en SIFEN  R 
249 H004c  Número de CDC no requerido para el tipo de 
documento asociado  2418  Si el tipo de documento asociado es impreso o Constancia 
electró nica (H002=2 o H002=3), no se debe informar el CDC (H004)  R 
250 H004d  Sumatoria de los documentos asociados supera el 
monto total del documento electrónico 
referenciado  2417  La sumatoria de cada Total general de la operación (F014) de la (s) 
Nota(s) de Cr édito(s) (actual o pre -existentes) no puede(n) superar 
al Total general  de la operación de la Factura electrónica asociada  R 
251 H004e  Tipo de transacción de la FE asociada, es 
incorrecto   
2437  Cuando el tipo de documento electrónico es Factura electrónic a 
(C002=1) y el documento asociado es otra Factura electrónica 
(H004 in icia con 01) necesariamente el tipo de transacción de la FE 
asociada debe ser Anticipo (D011=9)  R 
 
 
 
septiembre  de 2019                189 
N° Val  ID Mensaje de la Va lidación  Código  Observación  E 
252 H004f  Moneda de la operación informada no coincidente 
con la moneda del para el do cumento asociado . 2438  Cuando el documento asociado es una FE (CDC inic ia con 01), en 
donde el tipo de transacción en este documento asociado es 
Anticipo (D011=9) y el tipo de documento recibido es otra FE 
(C002=1), el DTE y el DE deben tener la misma mone da de la 
operación (D015 del documento asociado igual al D015 del 
docum ento recibido)  
 
Cuando el tipo de documento es Nota de crédito o Nota de d ébito 
Electrónica (C002=5 o C002=6) y el documento asociado es Factura 
electrónica (CDC inicia con 01), el DTE y el DE deben tener la misma 
moneda de la operación (D015 del documento  asociado igual al 
D015 del documento recibido)  R 
253 H005  Número de timbrado del documento impreso de 
referencia no informado  2405  Si el tipo de documento asociado seleccionado es ig ual a Impreso 
(H002=2), es obligatorio informar el número de timbrado d el 
documento impreso de referencia  R 
254 H005a  Número de timbrado no requerido para el tipo de 
documento asociado  2419  Si el tipo de documento asociado es electrónico o es constancia 
electrónica (H002=1 o H002=3), no se debe informar el número de 
timbrado  R 
255 H005b  Número de timbrado no corresponde al tipo de 
documento asociado  2440  Si el tipo de documento asociado seleccionado es igual a impreso 
(H002=2), no se debe informar un timb rado electrónico  R 
256 H006  Código de establecimiento del documento im preso 
de referencia no informado  2406  Si el tipo de documento asociado seleccionado es igual a Impreso 
(H002=2), es obligatorio informar el código de establecimiento del 
documento impr eso de referencia   R 
257 H006a  Código de establecimiento no requerido  para el 
tipo de documento asociado  2420  Si el tipo de documento asociado es electrónico o es constancia 
electrónica (H002=1 o H002=3), no se debe informar el código de 
establecimiento  R 
258 H007  Código de punto de expedición del documento 
impreso de refe rencia no informado  2407  Si el tipo de documento asociado seleccionado es igual a Impreso 
(H002=2), es obligatorio informar el código de punto de expedición 
del documento impreso de re ferencia   R 
259 H007a  Código de punto de expedición no requerido para 
el tipo de documento asociado  2421  Si el tipo de documento asociado es electrónico o es constancia 
electrónica (H002=1 o H002=3), no se debe informar el código de 
punto de expedición  R 
260 H008  Número del documento impreso no informado  2408  Si el tipo de  documento asociado seleccionado es igual a Impreso 
(H002=2), es obligatorio informar el número del documento impreso 
de referencia   R 
 
 
 
septiembre  de 2019                190 
N° Val  ID Mensaje de la Va lidación  Código  Observación  E 
261 H008a  Número del documento no requerido para el tipo 
de documento asociado  2422  Si el tipo de documento asociado es electrónico o es constancia 
electrónica (H002=1 o H002=3), no se debe informar el número de 
documento  R 
262 H009  Tipo de documento impreso no informado  2409  Si el tipo de documento as ociado seleccionado es igual a Impreso 
(H002=2), es obligatorio informa r el tipo de documento impreso  R 
263 H009a  Tipo de documento impreso no requerido para el 
tipo de documento asociado  2423  Si el tipo de documento asociado es electrónico o es constanc ia 
electrónica (H002=1 o H002=3), no se debe informar el tipo de 
docume nto impreso  R 
264 H010  Descripción del tipo de documento impreso no 
corresponde al código  2410  Descripción del tipo de documento impreso no coincidente con lo 
informado en el campo H0 09 R 
265 H010a  Descripción del tipo de documento impreso no 
informada  2424  Si se informa el tipo de documento impreso (H009), es obligatorio 
indicar la descripción del mismo (H010)  R 
266 H010b  Descripción del tipo de documento impreso no 
requerida  2435  Si no se informa el tipo de documento impreso (H009), no se debe 
inform ar la descripción del mismo (H010)  R 
267 H011  Fecha de emisión del documento impreso de 
referencia no informada  2411  Si el tipo de documento asociado seleccionado es igual a Impreso 
(H002=2), es obligatorio informar la fecha de emisión del documento 
impreso de referencia   R 
268 H011a  Fecha de emisión del documento impreso de 
referencia no requerida para el tipo de documento 
asociado  2425  Si el tipo de documento asociado es electrónico  o es constancia 
electrónica (H002=1 o H002=3), no se debe informar la fecha de 
emisión del documento impreso  R 
236  H012  Número de comprobante de retención no 
informado  2412  Si el tipo de pago informado es igual a Retenciones (E606=10), es 
obligatorio r eportar número de comprobante de retención  R 
269 H012a  Forma de pago incorrecto para el Número de 
comprobante de retención  2436  Si se informa el Número de comprobante de retención (H012),  es 
necesario que la forma de pago sea igual a Retención (E606=10)  R 
270 H013  Número de resolución de crédito fiscal no 
informado  2413  Si el tipo de transacción informado es igual a Venta de crédito fiscal 
(D011=12), es obligatorio reportar número de resolución de crédito 
fiscal  R 
271 H014  Tipo de constancia no informa do 2426  Si el tipo de documento asociado seleccionado es igual a 
Consta ncia electrónica (H002=3), es obligatorio informar el tipo de 
constancia  R 
272 H014a  Tipo de constancia no requerido para el tipo de 
documento asociado  2427  Si el tipo de documento aso ciado es Electrónico o Impreso (H002=1 
o H002=2), no se debe informar e l tipo de constancia  R 
273 H015a  Descripción del tipo de constancia no corresponde 
al código  2429  Descripción del tipo de constancia no coincidente con lo informado 
en el campo H014  R 
 
 
 
septiembre  de 2019                191 
N° Val  ID Mensaje de la Va lidación  Código  Observación  E 
274 H016  Número de constancia no informado  2430  Si el tipo de documen to asociado seleccionado es igual a 
Constancia electrónica (H002=3)  y el tipo de constancia es 
Constancia de no ser contribuyente (H014=2), es obligatorio 
informar el número de constanc ia R 
275 H016a  Número de constancia no requerido para el tipo de 
docum ento asociado  2431  Si el tipo de documento asociado es electrónico o impreso (H002=1 
o H002=2), no se debe informar el número de constancia  R 
276 H017  Número de control de la constanci a no informado  2432  Si el tipo de documento asociado seleccionado es ig ual a 
Constancia electrónica (H002= 3) y el tipo de constancia es 
Constancia de no ser contribuyente (H014=2), es obligatorio 
informar el número de control de la constancia  R 
277 H017a  Número de control de la constancia no requerido 
para el tipo de documen to asociado  2433  Si el tipo de documento asociado es electrónico o impreso (H002=1 
o H002=2), no se debe informar el número de control de la 
constancia  R 
 
I. Información de la Firma Di gital del DTE (I001 -I049)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
278 I002 Certificado digital no vigente al momento de firma 
del DE  2450  El certificado digital (I002) debe estar vigente (no revocado) al 
momento de la firma digital (A004)  R 
 
J. Campos fuera de la Firma Digital (J001 -J049)  
N° Val  ID Mensaje de la Validación  Código  Observación  E 
279 J002  Cadena de caracteres correspondiente al código 
QR no es coincidente con el archivo XML  2500  Las informaciones de la cadena de caracteres correspondiente al 
código QR (J002) no son coincidentes con las informa ciones de los 
respectivos campos del archivo XML  R 
280 J002a  El hash del código QR incluido el de la cadena de 
caracteres es inválido  2501  El hash del código QR incluido en la cadena d e caracteres 
correspondiente al código QR impreso no corresponde al cál culo 
obtenido del hash con la cadena informada y el CSC existente en la 
base de datos de SIFEN  R 
 
 
 
septiembre  de 2019                192 
281 J002b  URL de consulta de código QR es inválida  2502  La URL de consulta del código Q R informada en la cadena de 
caracteres (J002) no es correcta  R 
282 J003 Información adicional de interés para el emisor fue 
incluida en el DE  2503  La información adicional de interés para el emisor no debe ser 
enviada a SIFEN.  
El campo J003 fue incluido e n el XML del DE  R 
  
 
 
 