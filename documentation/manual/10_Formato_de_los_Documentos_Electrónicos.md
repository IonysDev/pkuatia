# 10 Formato de los Documentos Electrónicos

10. Formato de los Documentos Electrónicos  
 
10.1. Estructura del código de control (CDC) de los DE 
   
A fin de mantener una úni ca identificación para cada documento electrónico, im plementamos el código de 
control o CDC14.  
Este CDC  debe ser generado por el  sistema de facturación del emisor  conforme a los delineamientos 
contenidos en el presente  Manual Técni co. 
  
Conformación del CD C 
 
 
 
Para lograr una mayor comprensión se describe a continuación un ejemplo de cómo generar un CDC:  
Consideraremos:  
 
 
Por lo tanto,  el CDC estará conformado como sigue:  
 
 
14 CDC Código de Control, único en cada  DE, se referencia de forma u nívoca en el SIFEN  
 
 
 
septiembre  de 2019                57 
 
 
Cabe destacar que este código de control es incluido dentro del Schema XML, en  el campo A002 como atributo  
para la firma del DE.  
En la representación gráfica  (KuDE) deberá ser visible, por lo tanto,  debe ser expuesto en grupos de cuatro 
caracteres, tal com o sigue:  
 
 
 
 
10.2. Dígito verificador del CDC  
 
Para el cálculo del dígito verificad or del código de control  se debe utilizar  el módulo  11, con el cual se 
determina  su validez.  
La documentación acerca de cómo generar este d ígito, la cual se basa en la conformación antes descripta, se 
encuentra en la siguiente dirección:  
https://www.set.gov.py/portal/PARAGUAY -SET/detail?content -id=/repository/collaboration/sit es/PARAGUAY -SET/d ocuments/herramientas/digito -
verificador.pdf  
 
10.3. Generación  del código de seguridad  
 
El código de seguridad de los documentos electrónicos (campo dCodSeg ) tiene como objetivo asegurar la 
privacidad de los documentos emitidos, debe s er generado por el contribuyente emisor, conforme a l as 
siguientes condiciones:  
• Debe ser un número positivo de 9 dígitos.  
• Aleatorio . 
• Debe ser distinto para cada DE y generado por un algoritmo de complejidad suficiente para evitar  la 
reproducción del valor . 
• Rango NO SECUENCIAL entre 000000001 y 999999999.  
• No tener relación con ninguna información específica o directa del DE o del emisor de manera a 
garantizar su seguridad.  
• No debe ser igua l al número de documento campo dNumDoc . 
• En caso de ser un nú mero de me nos de 9 dígitos completar con 0  a la izquierda.  
 
 
 
Representación Gráfica
0144   4444   0170   0100   1001   4528   2201   7012   5158   7326   0988 
 
 
 
septiembre  de 2019                58 
10.4. Datos que se deben informar en los documentos electrónicos (DE)  
 
A fin de facilitar la compre nsión de la estructura de información de los documentos electrónicos , a 
continuación,  se referencian los campos  contenidos en los mismos,  los cuales se han organiza do, definido y 
agrupado conforme a la Tabla I: 
 
Tabla I – Grupos de campos del Archivo XML  
AA. Campos que identifican el formato electrónico XML (AA001 -AA009)  
A. Campos firmados del Documento Electrónic o (A001 -A099)  
B. Campos inherentes a la operación de  Documentos Electrónicos (B001 -B099)  
C. Campos de datos del Timbrado (C001 -C099)  
D. Campos Generales del Documento Electrónico DE  (D001 -D299)  
 D1. Campos inherentes a la operación comercial (D010 -D099 ) 
 D2. Campos que identifican al emisor del Do cument o Electrónico DE (D100 -D129) 
  D2.1  Campos que describen la actividad económica del emisor (D130 -D139)  
 D3. Campos que identifican al receptor del Documento Electrónico DE (D200 al D299)  
E. Campos esp ecíficos por tipo de Documento Electrónico (E001 -E009 ) 
 E1. Campos que componen la Factura Electrónica FE (E010 -E099)  
  E1.1.  Campos de informaciones de Compras Públicas (E020 -E029)  
 E2. Campos que componen la Factura Electrónica de Exportación FEE (E10 0-E199)  
 E3. Campos que componen la Factura Electrón ica de Importación FEI (E200 -E299)  
 E4. Campos que componen la Autofactura Electrónica AFE (E300 -E399)  
 E5. Campos que componen la Nota de Crédito/Débito Electrónica NCE -NDE (E400 -E499)  
 E6. Campos qu e componen la Nota de Remisión Elec trónica (E500 -E599) 
 E7. Campos que describen la condición de la operación (E600 -E699)  
  E7.1.  Campos que describen la forma de pago de la operación al contado o del 
monto de la entrega inicial (E605 -E619)  
   E7.1.1.  Campos que describen el pago o entrega inicial de la o peración con 
tarjeta de crédito/débito (E620 -E629)  
   E7.1.2.  Campos que describen el pago o entrega inicial de la operación con 
cheque (E630 -E639)  
  E7.2.  Campos que describen la operación a crédito ( E640 -E649)  
   E7.2.1.  Campos que describen las cuota s (E650 -E659)  
 E8. Campos que describen los ítems de la operación (E700 -E899)  
  E8.1.  Campos que describen el precio, tipo de cambio y valor total de la operación 
por ítem (E720 -E729)   
   E8.1.1  Campo s que describen los descuentos, anticipos y valor tot al por 
ítem (EA001 -EA050)  
  E8.2.  Campos que describen el IVA de la operación por ítem (E730 -E739)  
  E8.3.  Campos que describen el ISC de la operación por ítem (futuro)  
  E8.4.  Grupo de rastreo de la mercadería (E750 -E760)  
  E8.5. Sector de automotores  nuevos y usados (E770 -E789)  
 E9. Campos complementarios comerciales de uso específico (E790 -E899)  
  E9.2.  Sector Energía Eléctrica (E791 -E799)  
  E9.3.  Sector de Seguros (E800 -E809)  
   E9.3.1.  Póliza  de seguros (E A790-EA799) 
  E9.4.  Sector de Supermer cados (E810 -E819)  
  E9.5.  Grupo de datos adicionales de uso comercial (E820 -E829)  
 E10.  Campos que describen el transporte de las mercaderías (E900 -E999)  
 
 
 
septiembre  de 2019                59 
  E10.1.  Campos que identifican el local de sa lida de las mercaderías (E920 -E939)  
  E10.2.  Campos que identifican el local de entrega de las mercaderías (E940 -E959)  
  E10.3.  Campos que identifican el vehículo de traslado de mercaderías (E960 -E979)  
  E10.4.  Campos que identifican al transportista  (persona física o jurídica) (E9 80-E999)  
F. Campos que describen los subtotales y totales de la transacción documentada (F001 -F099)  
G. Campos complementarios come rciales de uso general (G001 -G049)  
 G1. Campos generales de la carga (G050 - G099)  
H. Campos que identifican al documento asociado (H001 -H049)  
I. Información de la Firma Digital del DTE (I001 -I049)  
J. Campos fuera de la Firma Digital (J001 -J049)  
 
 
10.5. Manejo del timbrado y Numeración  
 
Se maneja la siguiente secuencia de campos que identifican a cad a DE:  
• Número de timbrado  
• Establecimiento  
• Punto de exp edición  
• Tipo de documento  
• Número de documento  
• Serie  
Se ha incluido el uso de la serie (todas las combinaciones de a dos que se puedan realizar entre 2 letras 
mayúsculas, excepto la Ñ) ya que el timbrado no manejará  una fecha de fin de vigencia.  
Ejemplo de uso:  
Situación inicial  
• Número de timbrado: 12345678  
• Establecimiento: 001  
• Punto de expedición: 001  
• Tipo de documento: 01  
• Número de documento: 0000001 al 9999999  
Inicio de la  serie  
• Número de timbrado: 1234 5678  
• Establecimiento: 001  
• Punto de expedición: 001  
• Tipo de documento: 01  
• Número de documento: 0000001 al 9999999  
• Serie: AA  
Uso de la siguiente serie  
• Número de timbrado: 12345678  
 
 
 
septiembre  de 2019                60 
• Establecimiento: 001  
• Punto de expedición: 001  
• Tipo de documento: 01  
• Número de documento: 0000001 al 9999999  
• Serie: AB  
Inicialmente no se utilizará serie hasta consumir toda la numeración que va desde 0000001 al 9999999 para 
cada tipo de documento, luego la se tendrá que hacer uso de la serie según el siguiente orden.  
• Orden de S erie:  AA, AB, AC, … , AZ …BA, BB, …., BZ, … ZA, ZB, … , ZZ  
 
 
El sistema validará la secuencialidad del uso de la serie. Esta secuencialidad se dará según el orden mencionado 
en el ejemplo anterior.  
Una vez que el SIFEN reciba un DE con serie, se tomará la fecha  y hora de firma digital del DE como fecha inicial 
de inicio de la serie.  
El sistema aprobará solo aquellos DE en las siguientes condiciones:  
(*) Serie inmediatamente anterior:  DE con serie anterior  a la mayor  serie enviada al SIFEN,  cuya fecha y hora 
de firma digital es an terior a la fecha de inicio de vige ncia de la serie actual en el sistema.  
(*) Serie igual : DE con serie igual a la mayor serie enviada al SIFEN   
(*) Serie inmediatamente po sterior:  DE con serie posterior  a la mayor serie enviada al SIFEN,  cuya fecha y 
hora de firma digital es posterior  a la fecha de inicio de vigencia de la serie actual en el sistema.  
Ejemplo:  
Serie actual:  AC 
Fecha de inicio de vigencia de la serie:  07/06/2019 08:30:00  
Ejemplo de DE con Series aprobadas :  
AB con fecha de firma anterior a 07/06/2019 08:30:00  
Todos los DE co n serie AC  
AD con fecha de firma posterior a 07/06/2019 08:30:00  
 
 
 
TABLA DE FORMATO DE CAMPOS DE UN DOCUMENTO ELECTRÓNICO (DE)  
 
Schema XML 18: DE_v150 .xsd (Documento Electrónico)  
 
AA. Campos que identifican e l formato electrónico XML (AA001 -AA009)  
 
Grupo  ID Cam po Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
AA AA001  rDE Documento Electrónico 
elemento raíz  Raíz G  1-1  
AA AA002  dVerFor  Versión del formato  AA001  N 3 1-1 Control de version es  
Este campo debe cont ener la 
versión 150  
 
A. Campos firmados del Documento Electrónico (A001 -A099)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
A A001  DE Campos firmados del 
DE AA001  G  1-1  
A A002  Id Identificador del DE  A001  A 44  Atributo del Tag <DE>  
NOTA: Con car ácter excepcional 
cuando un RUC contenga letras para 
efectos del cálculo del Dígito verificador 
y la generación del CDC se realizará la 
conversión de dicha letra por su valor en 
código ASCII  
A A003  dDVI d Dígito verificador del 
identificador del DE  A001  N  1  1-1  Según algoritmo módulo 11  
 
 
 
septiembre  de 2019                62 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
A A004  dFecFirma  Fecha de la firma  A001  F 19 1-1 La fecha y hora de la firma digital debe 
ser anterior a la fecha y hora de 
transmisión al SIFEN  
El certificado digi tal debe estar vigente 
al momento de la firma digital  del DE  
Fecha y hora en el formato  
AAAA -MM-DDThh:mm:ss  
El plazo límite de transmisión del DE al 
SIFEN para la aprobación normal es 
de 72 h  contadas a partir de la fecha y 
hora de la firma digital . 
A A005 dSisFact  Sistema de facturación  A001  N 1 1-1 1=Sis tema de facturación del 
contribuyente  
2=SIFEN solución gratuita  
 
B. Campos inherentes a la operación de Documentos Electrónicos (B001 -B099)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurren cia Observaciones  
B B001  gOpeDE  Campos inherentes a 
la operación de DE  A001  G  1-1  
B B002  iTipEmi  Tipo de emisión  B001  N 1 1-1 1= Normal  
2= Contingencia  
B B003  dDesTipEmi  Descripción del tipo de 
emisión  B001  A 6-12 1-1 Referente al campo B002  
1= “Norm al” 
2= “Contingencia”  
B B004  dCodSeg  Código de segur idad B001  N 9 1-1 Código generado por el emisor de 
manera aleatoria  para asegurar la 
confidencialidad de la consulta 
pública del DE  
B B005  dInfoEmi  Información de interés 
del emisor respecto al 
DE B001  A 1-3000  0-1  
 
 
 
septiembre  de 2019                63 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurren cia Observaciones  
B B006  dInfoFisc  Información de interé s 
del Fisco respecto al 
DE B001  A 1-3000  0-1 Esta información debe ser impresa 
en el KuDE . 
 Cuando el tipo de documento es 
Nota de remisión (C002=7) es 
obligatorio informar el mensaje 
según el Art. 3 Inc . 7 de la Resolución 
general Nro. 41/2014  
 
C. Campos de  datos del Timbrado (C001 -C099)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
C C001  gTimb  Datos del timbrado  A001  G  1-1  
C C002  iTiDE  Tipo de Documento 
Electrónic o C001  N 1-2 1-1 1= Factura electrónica  
2= Factura el ectrónica de exportación 
(Futuro)  
3= Factura electrónica de importación 
(Futuro)  
4= Autofactura electrónica  
5= Nota de crédito electrónica  
6= Nota de débito electrónica  
7= Nota de remisión electrónica  
8= Comprobante de retención 
electrónico (Futuro)  
C C003 dDesTiDE  Descripción del tipo de 
documento electrónico  C001  A 15-40 1-1 Referente al campo C002  
1= “Factura electrónica”  
2= “Factura electrónica de 
exportación”  
3= “Factura electrónica de 
importación”  
4= “Autofactura electrónica”  
5= “Nota de crédito elec trónica”  
6= “Nota de débito electrónica”  
7= “Nota de remisión electrónica”  
8= “Comprobante de retención 
electrónico”  
C C004  dNumTim  Número del timbrado  C001  N 8 1-1 Debe coincidir con la estructura de 
timbrado  
 
 
 
septiembre  de 2019                64 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
C C005  dEst Establecimiento  C001  A 3 1-1 Com pletar con 0 (cero) a la izquierda  
Debe coincidir con la estructura de 
timbrado  
C C006  dPunExp  Punto de expedición  C001  A 3 1-1 Completar con 0 (cero) a la izquierda  
Debe coincidir con la estructura de 
timbrado  
C C007  dNumDoc  Número del documento  C001  A 7 1-1 Debe empezar con 1  (uno) para un 
nuevo timbrado.  
Completar con 0 (cero) a la izquierda 
hasta alcanzar 7 (siete) cifras  
Debe coincidir con la estructura de 
timbrado  
Una vez que se haya agotado la 
numeración permitida por el sistema 
(9999999), la nume ración de los 
comprobant es electrónicos se 
reinicia con la utilización de la serie, 
para evitar rechazos por duplicidad  
C C010  dSerieNum  Serie del número de 
timbrado  C001  A 2 0-1 Campo obligatorio cuand o ya se ha 
consumido la totalidad de la 
numeración pe rmitida por el sistema 
(9999999) . 
Referirse a la sección Manejo del 
timbrado y Numeración . 
C C008  dFeIniT  Fecha inicio de vigencia 
del timbrado  C001  F 10 1-1 Formato AAAA -MM-DD 
Para el KuDE el formato d e la fecha 
de inicio de vigencia debe contener 
los gu iones separadores. Ejemplo:  
2018 -05-31  
C C009  dFeFinT  Fecha fin de vigencia del 
timbrado  C001  F 10 1-1 Formato AAAA -MM-DD 
Para el KuDE el formato de la fecha 
de inicio de vigencia debe contener 
los gu iones separadores. Ejemplo:  
2018 -05-31 
 
 
 
 
 
 
 
 
 
 
septiembre  de 2019                65 
D. Campo s Generales del Documento Electrónico DE (D001 -D299)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
D D001  gDatGralOpe  Campos generales del 
DE A001  G  1-1  
D D002  dFeEmiDE  Fecha y hora de 
emisión del DE  D001  F 19 1-1 Fecha y hora en el formato  
AAAA -MM-DDThh:mm:ss  
Para el KuDE el formato de la fecha 
de emisión debe contener los 
guiones separadores. Ejemplo: 
2018 -05-31T12:00:00  
Se aceptará como límites técnicos 
del sis tema, que la fecha de emisión 
del DE sea atrasada has ta 720 
horas (30 días) y adelantada hasta 
120 h oras (5 días) en relación a la 
fecha y hora de transmisión al 
SIFEN  
 
D1. Campos inherentes a la operación comercial (D010 -D099)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observacion es 
D1 D010  gOpeCom  Campos inherentes a 
la operación comercial  D001  G  0-1 Obligatorio si C002 ≠ 7  
No informar si C002 = 7  
 
 
 
septiembre  de 2019                66 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observacion es 
D1 D011  iTipTra  Tipo de transacción  D010  N 1-2 0-1 Obligatorio si C002 = 1  o 4 
No informar si C002 ≠ 1  o 4 
Tipo de transacción para el emisor  
1= Venta de mercadería  
2= Prestación de servicios  
3= Mixto (Ven ta de mercadería y 
servicios)  
4= Venta de activo fijo  
5= Venta de divisas  
6= Compra de divisas  
7= Promoción o entrega de 
muestras  
8= Donación  
9= Anticipo  
10= Compra de productos  
11= Compra de servicios  
12= Venta de crédito fiscal  
13=Muestras médicas (Art.  3 RG 
24/2014)  
D1 D012  dDesTipTra  Descripción del tipo 
de transacción  D010  A 5-36 0-1 Obligatorio si existe el campo D011  
1= “Venta de mercadería”  
2= “Prestación de servicios”  
3= “Mixto” (Venta de mercadería y 
servicios)  
4= “Venta de activo fijo”  
5= “Ve nta de divisas”  
6= “Compra de divisas”  
7= “Promoción o entrega de 
muestras”  
8= “Donación”  
9= “Anticipo”  
10= “Compra de productos”  
11= “C ompra de servicios”  
12= “Venta de crédito fiscal”  
13= ”Muestras médicas (Art. 3 RG 
24/2014)”  
D1 D013  iTImp  Tipo de impu esto 
afectado  D010  N 1 1-1 1= IVA  
2= ISC   
3=Renta  
4=Ninguno  
5=IVA - Renta  
 
 
 
septiembre  de 2019                67 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observacion es 
D1 D014  dDesTImp  Descripción del tipo 
de impuesto afectado  D010  A 3-11 1-1 1= “IVA”  
2= “ISC”   
3= “Renta”  
4= “Ninguno”  
5= “IVA – Renta”  
D1 D015  cMoneOpe  Moneda de la 
operación  D010  A 3 1-1 Según tabla de códigos para 
monedas de acuerdo con la norma 
ISO 4217  
Se requiere la misma moneda para 
todos los ítems del DE  
D1 D016  dDesMoneOpe  Descripción de la 
moneda de la 
operación  D010  A 3-20 1-1 Referente al campo D015  
D1 D017  dCondTiCam  Condición del tipo de 
cambio  D010  N 1 0-1 Obligatorio si D015 ≠ PYG  
No informar si D015 = PYG  
1= Global (un solo tipo de cambio 
para todo el DE)  
2= Por ítem (tipo de cambio distinto 
por ítem)  
D1 D018  dTiCam  Tipo de cambio de la 
operación  D010  N 1-5p(0-4) 0-1 Obligatorio si D017 = 1  
No informar si  D017 = 2  
No informar si D015=PYG  
D1 D019  iCondAnt  Condición del Anticipo  D010  N 1 0-1 1= Anticipo Global (un solo tipo de 
anticipo para todo el DE)  
2= Anticipo por ítem (corresponde a 
la distribución de Anticipos 
facturados por ítem)  
D1 D020  dDesCondAnt  Descripción de la 
condición del Anticipo  D010  A 15-17 0-1 1= “Anticipo Global”  
2= “Anticipo por Ítem”  
 
D2. Campos que identifican al emisor del Documento Electrónico DE (D100 -D129)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Obse rvaciones  
D2 D100  gEmis  Grupo de campos que 
identifican al emisor  D001  G  1-1   
 
 
 
septiembre  de 2019                68 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Obse rvaciones  
D2 D101  dRucEm  RUC del contribuyente 
emisor  D100  A 3-8 1-1 Debe corresponder al RUC del 
certificado digital utilizado para 
firmar el DE  
D2 D102  dDVEmi  Dígito verificador del  
RUC del contribuyente 
emisor  D100  N 1 1-1 Según algoritmo módulo 11  
D2 D103  iTipCont  Tipo de contribuyente  D100  N 1 1-1 1= Persona Física  
2= Persona Jurídica  
D2 D104  cTipReg  Tipo de régimen  D100  N 1-2 0-1 Según Tabla 1 – Tipo de Régimen  
D2 D105  dNomEmi  Nombre o razón social 
del emisor del DE  D100  A 4-255 1-1 En caso de ambiente de prueba, 
debe contener obligatoriamente el 
literal "DE generado en ambiente 
de prueba - sin valor comercial ni 
fiscal"  
D2 D106  dNomFanEmi  Nombre de fantasía  D100  A 4-255 0-1 Debe corresponder a lo declarado 
en el RUC  
D2 D107  dDirEmi  Dirección del local 
donde se emite el DE  D100  A 1-255 1-1 Nombre de la calle principal. Debe 
corresponder a lo declarado en el 
RUC  
D2 D108  dNumCas  Número de casa  D100  N 1-6 1-1 Si no tiene numerac ión, colocar 0 
(cero)  
Debe corresponder a lo declarado 
en el RUC  
D2 D109  dCompDir1  Complemento de 
dirección 1  D100  A 1-255 0-1 Nombre de la calle secundaria  
D2 D110  dCompDir2  Complemento de 
dirección 2  D100  A 1-255 0-1 Número de departamento/ piso/ 
local/ edificio/ depósito  
D2 D111  cDepEmi  Código del 
departamento de 
emisión  D100  N 1-2 1-1 Según XSD de Departamentos  
Debe corresponder a lo declarado 
en el RUC  
D2 D112  dDesDepEmi  Descripción del 
departamento de 
emisión  D100  A 6-16 1-1 Referente al campo D1 11 
Debe corresponder a lo declarado 
en el RUC  
D2 D113  cDisEmi  Código del distrito de 
emisión  D100  N 1-4 0-1 Según Tabla 2.1 – Distritos  
Debe corresponder a lo declarado 
en el RUC  
D2 D114  dDesDisEmi  Descripción del distrito 
de emisión  D100  A 1-30 0-1 Obligatorio si existe el campo D113  
Debe corresponder a lo declarado 
en el RUC  
 
 
 
septiembre  de 2019                69 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Obse rvaciones  
D2 D115  cCiuEmi  Código de la ciudad 
de emisión  D100  N 1-5 1-1 Según Tabla 2.2 – Ciudades  
Debe corresponder a lo declarado 
en el RUC  
D2 D116  dDesCiuEmi  Descripción de la 
ciudad de emisión  D100  A 1-30 1-1 Referente al campo D115  
Debe corresponder a lo declarado 
en el RUC  
D2 D117  dTelEmi  Teléfono local de 
emisión de DE  D100  A 6-15 1-1 Debe incluir el prefijo de la ciudad  
Debe corresponder a lo declarado 
en el RUC  
D2 D118  dEmailE  Correo electrónico del 
emisor  D100  A 3-80 1-1 Debe corresponder a lo declarado 
en el RUC  
D2 D119  dDenSuc  Denominación 
comercial de la 
sucursal  D100  A 1-30 0-1 Denominación interna del emisor  
 
 
D2.1 Campos que describen la actividad económica del emisor (D1 30-D139)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
D2.1 D130 gActEco  Grupo de campos que 
describen la actividad 
económica del emisor  D100 G - 1-9   
D2.1 D131 cActEco  Código de la actividad 
económica del emisor  D130 A 1-8 1-1 Según Tabla 3 – Actividades 
Económicas  
Debe corresponder a lo declarado en 
el RUC  
D2.1 D132 dDesActEco  Descripción de la 
actividad económica 
del emisor  D130 A 1-300 1-1 Referente al campo D120  
Según Tabla 3 – Actividades 
Económicas  
Debe corres ponder a lo declarado en 
el RUC  
 
 
 
 
 
 
 
 
septiembre  de 2019                70 
D2.2 Campos que identifican al responsable de la generación del DE (D140 -D160)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
D2.2 D140 gRespDE  Grupo de campos que 
identifican al 
responsable de la 
generación del DE  D100 G - 0-1  
D2.2  D141  iTipIDRespDE  
 Tipo de documento de 
identidad del 
responsable de la 
generación del DE  
 D140  N 1 1-1 1= Cédula paraguaya  
2= Pasaporte  
3= Cédula extranjera  
4= Carnet de residencia  
9= Otro  
D2.2  D142  dDTipIDRespDE  Descripción del tipo de 
documento de 
identidad del 
responsable de la 
generación del DE  D140  A 9-41 1-1 1= “Cédula paraguaya”  
2= “Pasaporte”  
3= “Cédula extranjera”  
4= “Carnet de residencia”  
Si D141 = 9 informar el tipo de 
documento de identidad  del 
responsable de la generación del DE  
D2.2  D143  dNumIDRespDE  Número de documento 
de identidad del 
responsable de la 
generación del DE  D140  A 1-20 1-1  
D2.2 D144 dNomRespDE  Nombre o razón social 
del responsable de la 
generación del DE  D140 A 4-255 1-1  
D2.2 D145  dCarRespDE  Cargo del responsable 
de la generación del 
DE D140 A 4-100 1-1  
 
 
D3. Campos que identifican al receptor del Documento Electrónico DE (D200 -D299)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
D3 D200  gDatRec  Grupo de campos que 
identifican al receptor  D001  G  1-1   
 
 
 
septiembre  de 2019                71 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
D3 D201  iNatRec  Naturaleza del receptor  D200  N 1 1-1 1= contribuyente  
2= no contribuyente  
D3 D202  iTiOpe  Tipo de operación  D200  N 1 1-1 1= B2B  
2= B2C  
3= B2G  
4= B2F  
(Esta última opción debe utilizarse 
solo en caso de servicios para 
empresas o personas físicas del 
exterior)  
D3 D203  cPaisRec  Código de país del 
receptor  D200  A 3 1-1 Según XSD de Codificación de 
Países  
D3 D204  dDesPaisRe  Descripción del país 
receptor  D200  A 4-30 1-1 Referente al campo D203  
D3 D205  iTiContRec  Tipo de contribuyente 
receptor  D200  N 1 0-1 Obligatorio si D201 = 1  
No informar si D201 = 2  
1= Persona Física  
2= Persona Jurídica  
D3 D206  dRucRec  RUC del receptor  D200  A 3-8 0-1 Obligatorio si D201 = 1  
No informar  si D201 = 2  
D3 D207  dDVRec  Dígito verificador del 
RUC del receptor  D200  N 1 0-1 Obligatorio si existe el campo D206  
Según algoritmo módulo 11  
D3 D208  iTipIDRec  
 Tipo de documento de 
identidad del receptor  
 D200  N 1 0-1 Obligatorio si D201 = 2  y D202 ≠ 4  
No informar si D201 = 1  o D202=4  
1= Cédula paraguaya  
2= Pasaporte  
3= Cédula extranjera  
4= Carnet de residencia  
5= Innominado  
6=Tarjeta Diplomática de 
exoneración fiscal  
9= Otro  
 
 
 
septiembre  de 2019                72 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
D3 D209  dDTipIDRec  Descripción del tipo de 
documento de identidad  D200  A 9-41 0-1 Obligatorio si existe el campo D208  
1= “Cédula paraguaya”  
2= “Pasaporte”  
3= “Cédula extranjera”  
4= “Carnet de residencia”  
5 = “Innominado”  
6= “Tarjeta Diplomática de 
exoneración fiscal”  
Si D208 = 9 informar el tipo de 
documento de identidad del 
recept or 
D3 D210  dNumIDRec  Número de documento 
de identidad  D200  A 1-20 0-1 Obligatorio si D201 = 2  y D202 ≠ 4  
No informar si D201 = 1  o D202=4  
En caso de DE innominado, 
completar con 0 (cero)  
D3 D211  dNomRec  Nombre o razón social 
del receptor del DE  D200  A 4-255 1-1 En caso de DE innominado, 
completar con “Sin Nombre”  
D3 D212  dNomFanRec  Nombre de fantasía  D200  A 4-255 0-1  
D3 D213  dDirRec  Dirección del receptor  D200  A 1-255 0-1 Campo obligatorio cuando C002=7 
o cuando D202=4  
D3 D218  dNumCasRec  Número de cas a del 
receptor  D200 N 1-6 0-1 Campo obligatorio si se informa el 
campo D213  
Cuando D201 = 1, debe 
corresponder a lo declarado en el 
RUC  
D3 D219  cDepRec  Código del 
departamento del 
receptor  D200  N 1-2 0-1 Campo obligatorio si se informa el 
campo D213 y D20 2≠4, no se debe 
informar cuando D202 = 4.  
Según XSD de Departamentos  
D3 D220  dDesDepRec  Descripción del 
departamento del 
receptor  D200  A 6-16 0-1 Referente al campo D21 9 
D3 D221  cDisRec  Código del distrito del 
receptor  D200  N 1-4 0-1 Según Tabla 2.1 – Distritos  
D3 D222  dDesDisRec  Descripción del distrito 
del receptor  D200  A 1-30 0-1 Obligatorio si existe el campo D22 1 
 
 
 
septiembre  de 2019                73 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
D3 D223  cCiuRec  Código de la ciudad del 
receptor  D200  N 1-5 0-1 Campo obligatorio si se informa el 
campo D213 y D202≠4, no se debe 
inform ar cuando D202 = 4.  
Según Tabla 2.2 – Ciudades  
D3 D224  dDesCiuRec  Descripción de la ciudad 
del receptor  D200  A 1-30 0-1 Referente al campo D22 3 
D3 D214  dTelRec  Número de teléfono del 
receptor  D200  A 6-15 0-1 Debe incluir el prefijo de la ciudad si 
D203 =  PRY 
D3 D215  dCelRec  Número de celular del 
receptor  D200  A 10-20 0-1  
D3 D216  dEmailRec  Correo electrónico del 
receptor  D200  A 3-80 0-1  
D3 D217  dCodCliente  Código del cliente  D200  A 3-15 0-1  
 
 
E. Campos específicos por tipo de Documento Electrónico (E00 1-E009)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E E001  gDtipDE  Campos específicos 
por tipo de 
Documento 
Electrónico  A001  G  1-1   
 
E1. Campos que componen la Factura Electrónica FE (E002 -E099)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E1 E010  gCamFE  Campos que 
componen la FE  E001  G  0-1 Obligatorio si C002 = 1  
No informar si C002 ≠ 1  
 
 
 
septiembre  de 2019                74 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E1 E011  iIndPres  Indicador de presencia  E010  N 1 1-1 1= Operación presencial  
2= Operación electrónica  
3= Operación telemarketing  
4= Venta a domicilio  
5= Operación bancaria  
6= Operación cíclica  
9= Otro  
E1 E012  dDesIndPres  Descripción  del 
indicador de presencia  E010  A 10-30 1-1 Referente al campo E011  
1= “Operación presencial”  
2= “Operación electrónica”  
3= “Operación telemarketing”  
4= “Venta a domicilio”  
5= “Operación bancaria”  
6=” Operación cíclica”  
Si E011 = 9 informar el indicador d e 
presencia  
E1 E013  dFecEmNR  Fecha futura del 
traslado de mercadería  E010  F 10 0-1 Fecha en el formato: AAAA -MM-DD  
Fecha estimada para el traslado de 
la mercadería y emisión de la nota 
de remisión electrónica cuando 
corresponda.  RG 41/14  
 
 
E1.1.  Campos de informaciones de Compras Públicas (E020 -E029)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longit
ud Ocurrencia  Observaciones  
E1.1 E020  gCompPub  Campos que describen 
las informaciones de 
compras públicas  E010  G  0-1 Obligatorio si D202 = 3 (Tipo de 
operación B2G)  
E1.1 E021  dModCont  Modalidad - Código 
emitido por la DNCP  E020  A 2 1-1   
E1.1 E022  dEntCont  Entidad - Código emitido 
por la DNCP  E020  N 5 1-1  
E1.1 E023  dAnoCont  Año - Código emitido por 
la DNCP  E020  N 2 1-1  
E1.1 E024  dSecCont  Secuenci a - emitido por 
la DNCP  E020  N 7 1-1  
 
 
 
septiembre  de 2019                75 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longit
ud Ocurrencia  Observaciones  
E1.1 E025  dFeCodCont  Fecha de emisión del 
código de contratación 
por la DNCP  E020  F 10 1-1 Fecha en el formato: AAAA -MM-DD. 
Esta fecha debe ser anterior a la fecha 
de emisión de la FE  
 
E4. Campos que componen la Auto factura Electrónica AFE (E300 -E399)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longit
ud Ocurrencia  Observaciones  
E4 E300  gCamAE  Campos que componen 
la Autofactura Electrónica  E001  G  0-1 Obligatorio si C002 = 4  
No informar si C002 ≠ 4  
E4 E301  iNatVen  Naturaleza del vendedor  E300  N 1 1-1 1= No contribuyente  
2= Extranjero  
E4 E302  dDesNatVen  Descripción de la 
naturaleza del vendedor  E300  A 10-16 1-1 Referente al campo E301.  
1= “No contribuyente”  
2= “Extranjero”  
E4 E304  iTipIDVen  
 Tipo de documento de 
identidad del vendedor  E300  N 1 1-1 1= Cédula  paraguaya  
2= Pasaporte  
3= Cédula extranjera  
4= Carnet de residencia  
E4 E305  dDTipIDVen  Descripción del tipo de 
documento de identidad 
del vendedor  E300  A 9-20 1-1 Refe rente al campo E304  
1= “Cédula  paraguaya”  
2= “Pasaporte”  
3= “Cédula extranjera”  
4= “Carnet de residencia”  
E4 E306  dNumIDVen  Número de documento 
de identidad del 
vendedor  E300  A 1-20 1-1  
E4 E307  dNomVen  Nombre y apellido del 
vendedor  E300  A 4-60 1-1  
E4 E308  dDirVen  Dirección del vendedor  E300  A 1-255 1-1 En caso de extranjeros, colocar la 
dirección en donde se realizó la 
transacción.  
Nombre de la calle principal  
E4 E309  dNumCasVen  Número de casa del 
vendedor  E300  N 1-6 1-1 Si no tiene numeración coloc ar 0 (cero)  
 
 
 
septiembre  de 2019                76 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longit
ud Ocurrencia  Observaciones  
E4 E310  cDepVen  Código del departamento 
del vendedor  E300  N 1-2 1-1 En caso de extranjeros, colocar el 
departamento en donde se realizó la 
transacción.  
Según XSD de Departamentos  
E4 E311  dDesDepVen  Descripción del 
departamento del 
vendedor  E300 A 6-16 1-1 Referente al campo E310  
E4 E312  cDisVen  Código del distrito del 
vendedor  E300  N 1-4 0-1 En caso de extranjeros, colocar el 
distrito en donde se realizó la 
transacción.  
Según Tabla 2.1 - Distritos  
E4 E313  dDesDisVen  Descripción del distrito 
del vendedor  E300  A 1-30 0-1 Obligatorio si existe el campo E312  
E4 E314  cCiuVen  Código de la ciudad del 
vendedor  E300  N 1-5 1-1 En caso de extranjeros, colocar la 
ciudad en donde se realizó la 
transacción.  
Según Tabla 2.2 - Ciudades  
E4 E315  dDesCiuVen  Descripción de la ciudad 
del vendedor   E300  A 1-30 1-1 Referente al campo E314  
E4 E316  dDirProv  Lugar de la transacción  E300  A 1-255 1-1 Nombre de la calle principal (Dirección 
donde se provee el servicio o producto)  
E4 E317  cDepProv  Código del departam ento 
donde se realiza la 
transacción  E300  N 1-2 1-1 Según XSD de Departamentos  
E4 E318  dDesDepProv  Descripción del 
departamento donde se 
realiza la transacción  E300  A 6-16 1-1 Referente al campo E317  
E4 E319  cDisProv  Código del distrito donde 
se realiza la transacción  E300  N 1-4 0-1 Según Tabla 2.1 - Distritos  
E4 E320  dDesDisProv  Descripción del distrito 
donde se realiza la 
transacción  E300  A 1-30 0-1 Obligatorio si existe el campo E319  
E4 E321  cCiuProv  Código de la ciudad 
donde se realiza la 
transacció n E300  N 1-5 1-1 Según Tabla 2.2 - Ciudades  
E4 E322  dDesCiuProv  Descripción de la ciudad 
donde se realiza la 
transacción  E300  A 1-30 1-1 Referente al campo E321  
 
 
 
 
septiembre  de 2019                77 
E5. Campos que componen la Nota de Crédito/Débito Electrónica NCE -NDE (E400 -E499)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E5 E400  gCamNCDE  Campos de la Nota de 
Crédito/Débito 
Electrónica  E001  G  0-1 Obligatorio si C002 = 5 o 6 (NCE y 
NDE)  
No informar si C002 ≠ 5 o 6  
E5 E401  iMotEmi  Motivo de emisión  E400 N 1-2 1-1 1= Devolución y Ajuste de precios  
2= Devolución  
3= Descuento  
4= Bonificación  
5= Crédito incobrable  
6= Recupero de costo  
7= Recupero de gasto  
8= Ajuste de precio  
E5 E402  dDesMotEmi  Descripción del motivo 
de emisión  E400  A 6-30 1-1 Referente al  campo E401  
1= “Devolución y Ajuste de precios ” 
2= “Devolución”  
3= “Descuento”  
4= “Bonificación”  
5= “Crédito incobrable”  
6= “Recupero de costo”  
7= “Recupero de gasto”  
8= “Ajuste de precio”  
 
E6. Campos que componen la Nota de Remisión Electrónica (E500 -E599) 
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E6 E500  gCamNRE  Campos que 
componen la Nota de 
Remisión Electrónica  E001  G  0-1 Obligatorio si C002 = 7  
No informar si C002 ≠ 7  
 
 
 
septiembre  de 2019                78 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E6 E501  iMotEmiNR  Motivo de emisión  E500  N 1-2 1-1 1= Traslado por venta  
2= Traslado por consignación  
3= Exportación  
4= Traslado por compra  
5= Importación  
6= Traslado por devolución  
7= Traslado entre locales de la 
empresa  
8= Traslado de bienes por 
transformación  
9= Traslado de bienes por 
repara ción 
10= Tr aslado por emisor móvil  
11= Exhibición o demostración  
12= Participación en ferias  
13= Traslado de encomienda  
14= Decomiso  
99=Otro ( deberá consignarse 
expresamente el  o los motivos 
diferentes a los mencionados 
anteriormente)  
Obs.:  Cuando el motiv o sea por 
operaciones internas de la empresa , 
el RUC del receptor debe ser igual al 
RUC del emisor.  
 
 
 
septiembre  de 2019                79 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E6 E502  dDesMotEmiNR  Descripción del motivo 
de emisión  E500  A 5-60 1-1 Referente al campo E501  
1= “Traslado por ventas”  
2= “Traslado por consignación”  
3= “Exportación”  
4= “Traslado por compra”  
5= “Importación”  
6= “Traslado por devolución”  
7= “Traslado entre locales de la 
empresa”  
8= “Traslado de bienes por 
transformación”  
9= “Traslado de bienes por 
reparación”  
10= “Traslado por emisor móvil”  
11= “Exhibició n o Demostración”  
12= “Participación en ferias”  
13= “Traslado de encomienda”  
14= “Decomiso”  
Si E501= 99 describir el motivo de la 
emisión  
E6 E503  iRespEmiNR  Responsable de la 
emisión de la Nota 
Remisión Electrónica  E500  N 1 1-1 1= Emisor de la factura  
2= Po seedor de la factura y bienes   
3= Empresa transportista  
4=Despachante de Aduanas  
5= Agente de transporte o 
intermediario  
E6 E504  dDesRespEmiNR  Descripción del 
responsable de la 
emisión de la Nota de 
Remisión Electrónica  E500  A 20-36 1-1 1= “Emisor de la f actura”  
2= “Poseedor de la factura y 
bienes”  
3= “Empresa transportista”  
4= “Despachante de Aduanas”  
5= “Agente de transporte o 
intermediario”  
E6 E505  dKmR  Kilómetros estimados 
de recorrido  E500  N 1-5 0-1  
E6 E506  dFecEm  Fecha futura de 
emisión de la fac tura E500  F 10 0-1 Fecha en el formato AAAA -MM-
DD 
Obs.: Informar cuando no se ha 
emitido aún la factura electrónica , 
en caso que corresponda  
 
 
 
septiembre  de 2019                80 
 
E7. Campos que describen la condición de la operación (E600 -E699)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato Longitud  Ocurrencia  Observaciones  
E7 E600  gCamCond  Campos que describen 
la condición de la 
operación  E001  G  0-1 Obligatorio si C002 = 1 o 4  
No informar si C002 ≠ 1 o 4  
E7 E601  iCondOpe  Condición de la 
operación  E600  N 1 1-1 1= Contado  
2= Crédito  
E7 E602 dDCondOpe  Descripción de la 
condición de operación  E600  A 7 1-1 Referente al campo E601  
1= “Contado”  
2= “Crédito”  
 
E7.1.  Campos que describen la forma de pago de la operación al contado o del monto de la entrega inicial (E605 -
E619)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E7.1 E605  gPaConEIni  Campos que 
describen la forma de 
pago al contado o del 
monto de la entrega 
inicial  E600  G  0-999 Obligatorio si E601 = 1  
Obligatorio si existe el campo 
E645  
 
 
 
septiembre  de 2019                81 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E7.1 E606  iTiPago  Tipo de pago  E605  N 1-2 1-1 1= Efectivo  
2= Cheque  
3= Tarjeta de crédito  
4= Tarjeta de débito  
5= Transferencia  
6= Giro  
7= Billetera electrónica  
8= Tarjeta empresarial  
9= Vale  
10= Retención  
11= Pago por anticipo  
12= Valor fiscal  
13= Valor comercial  
14= Compensación  
15= Permuta  
16= Pago bancario (Informar solo 
si E011=5)  
17 = Pago Móvil  
18 = Donación  
19 = Promoción  
20 = Consumo Interno  
21 = Pago Electrónico  
99 = Otro 
 
 
 
septiembre  de 2019                82 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E7.1 E607  dDesTiPag  Descripción del tipo de 
pago  E605  A 4-30 1-1 Referente al campo E6 06 
1= “Efectivo”  
2= “Cheque”  
3= “Tarjeta de crédito”  
4= “Tarjeta de débito”  
5= “Transferencia”  
6= “Giro”  
7= “Billetera electrónica”  
8= “Tarjeta empresarial”  
9= “Vale”  
10= “Retención”  
11= “Pago por anticipo”  
12= “Valor fiscal”  
13= “Valor comercial”  
14= “Com pensación”  
15= “Permuta” . 
16= “Pago bancario”  
7= “Pago Móvil”  
18 = “Donación”  
19 = “Promoción”  
20 = “Consumo Interno”  
21 = “Pago Electrónico”  
Si E606 = 99, informar el tipo de 
pago  
E7.1 E608  dMonTiPag  Monto por tipo de pago  E605  N 1-15p(0 -4) 1-1  
E7.1 E609 cMoneTiPag  Moneda por tipo de 
pago  E605  A 3 1-1 Según tabla de códigos para 
monedas de acuerdo con la 
norma ISO 4217  
Se requiere la misma moneda para 
todos los ítems del DE  
E7.1 E610  dDMoneTiPag  Descripción de la 
moneda por tipo de 
pago  E605  A 3-20 1-1 Referente al campo E609  
E7.1 E611  dTiCamTiPag  Tipo de cambio por tipo 
de pago  E605  N 1-5p(0-4) 0-1 Obligatorio si E609 ≠ PYG  
 
 
 
 
 
 
 
 
septiembre  de 2019                83 
E7.1.1.  Campos que describen el pago o entrega inicial de la operación con tarjeta de crédito/débito  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E7.1.1  E620  gPagTarCD  Campos que descri ben 
el pago o entrega inicial 
de la operación con 
tarjeta de crédito/débito  E605  G  0-1 Se activa si E606 = 3 o 4  
E7.1.1  E621  iDenTarj  Denominación de la 
tarjeta  E620  N 1-2 1-1 1= Visa  
2= Mastercard  
3= American Express  
4= Maestro  
5= Panal  
6= Cabal  
99= Otr o 
E7.1.1  E622  dDesDenTarj  Descripción de 
denominación de la 
tarjeta  E620  A 4-20 1-1 Referente al campo E621  
1= “Visa”  
2= “Mastercard”  
3= “American Express”  
4= “Maestro”  
5= “Panal”  
6= “Cabal”  
Si E621 = 99  informar la 
descripción de la denominación 
de la ta rjeta 
E7.1.1  E623  dRSProTar  Razón social de la 
procesadora de tarjeta  E620  A 4-60 0-1  
E7.1.1  E624  dRUCProTar  RUC de la procesadora 
de tarjeta  E620  A 3-8 0-1  
E7.1.1  E625  dDVProTar  Dígito verificador del 
RUC de la procesadora 
de tarjeta  E620  N 1 0-1 Según algoritmo módulo 11  
E7.1.1  E626  iForProPa  Forma de 
procesamiento de pago  E620  N 1 1-1 1= POS  
2= Pago Electrónico (Ejemplo: 
compras por Internet)  
9= Otro  
E7.1.1  E627  dCodAuOpe  Código de autorización 
de la operación  E620  N 6-10 0-1  
E7.1.1  E628  dNomTit  Nombre del titular de la 
tarjeta  E620  A 4-30 0-1  
 
 
 
septiembre  de 2019                84 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E7.1.1  E629  dNumTarj  Número de la tarjeta  E620  N 4 0-1 Cuatro últimos dígitos de la tarjeta  
 
E7.1.2.  Campos que describen el pago o entrega inicial de la operación con cheque (E630 -E639)  
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E7.1.2  E630  gPagCheq  Campos que describen 
el pago o entrega inicial 
de la operación con 
cheque  E605  G  0-1 Se activa si E606 = 2  
E7.1.2  E631  dNumCheq  Número de cheque  E630  A 8 1-1 Completa r con 0 (cero) a la 
izquierda hasta alcanzar 8 (ocho) 
cifras  
E7.1.2  E632  dBcoEmi  Banco emisor  E630  A 4-20 1-1  
 
E7.2. Campos que describen la operación a crédito (E640 -E649)  
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observacione s 
E7.2 E640  gPagCred  Campos que describen 
la operación a crédito  E600  G  0-1 Obligatorio si E601 = 2  
No informar si E601 ≠ 2  
E7.2 E641  iCondCred  Condición de la 
operación a crédito  E640  N 1 1-1 1= Plazo  
2= Cuota  
E7.2 E642  dDCondCred  Descripción de la 
condición de la 
operación a crédito  E640  A 5-6 1-1 1= “Plazo”  
2= “Cuota”  
E7.2 E643  dPlazoCre  Plazo de l crédito  E640  A 2-15 0-1 Obligatorio si E641 = 1  
Ejemplo: 30 días, 12 meses  
E7.2 E644  dCuotas  Cantidad de cuotas  E640  N 1-3 0-1 Obligatorio si E641 = 2  
Ejemplo: 12, 24, 36  
E7.2 E645  dMonEnt  Monto de la entrega 
inicial  E640  N 1-15p(0 -
4) 0-1  
 
 
 
 
 
septiembre  de 2019                85 
E7.2.1.  Campos que describen las cuotas (E650 -E659)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E7.2.1  E650  gCuotas  Campos que describen 
las cuotas  E640  G  0-999 Se activa si E641 = 2  
E7.2.1  E653  cMoneCuo  Moneda de las cuota s E650  A 3 1-1 Según tabla de códigos para 
monedas de acuerdo con la 
norma ISO 4217  
Se requiere la misma moneda 
para todos los ítems del DE  
E7.2.1  E654  dDMoneCuo  Descripción de la 
moneda de las cuotas  E650  A 3-20 1-1 Referente al campo E653  
E7.2.1  E651  dMonCuota  Monto de cada cuota  E650  N 1-15p(0 -
4) 1-1  
E7.2.1  E652  dVencCuo  Fecha de vencimiento 
de cada cuota  E650  F 10 0-1 Fecha en el formato: AAAA -MM-
DD 
 
E8. Campos que describen los ítems de la operación (E700 -E899)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8 E700  gCamItem  Campos que describen 
los ítems de la 
operación  E001  G  1-999  
E8 E701  dCodInt  Código interno  E700  A 1-20 1-1 Código interno de identificación de 
la mercadería o servicio de 
responsabilidad d el emisor. No se 
pueden tener ítems distintos de 
mercadería o servicio con el mismo 
código interno en su catastro de 
productos o servicios. Este código 
se puede repetir en el DE siempre 
que el producto o servicio sea el 
mismo.  
E8 E702  dParAranc  Partida ar ancelaria  E700  N 4 0-1  
E8 E703  dNCM  Nomenclatura común 
del Mercosur (NCM)  E700  N 6-8 0-1  
 
 
 
septiembre  de 2019                86 
Grupo  ID Campo  Descripción  Nodo 
Padre Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8 E704  dDncpG  Código DNCP – Nivel 
General  E700  A 8 0-1 Obligatorio si D202 = 3  
Informar se existe el código de la 
DNCP  
Colocar 0 (cero) a la izquierda 
para comple tar los espacios 
vacíos  
E8 E705  dDncpE  Código DNCP – Nivel 
Especifico  E700  A 3-4 0-1 Obligatorio si existe el campo 
E704 ) 
E8 E706  dGtin  Código GTIN por 
producto  E700  N 8,12,13,14  0-1 Informar si la mercadería tiene 
GTIN  
E8 E707  dGtinPq  Código GTIN por 
paquete  E700  N 8,12,13,14  0-1 Informar si el paquete tiene GTIN  
E8 E708  dDesProSer  Descripción del producto 
y/o servicio  E700  A 1-120 1-1 Equivalente a nombre del 
producto establecido en la RG 
24/201 9 
E8 E709  cUniMed  Unidad de medida  E700  N 1-5 1-1 Según Tabla 5 – Unidad de 
Medida  
Si D202 = 3 utilizar los datos del 
WS del link de la DNCP  
Utilizar el atributo “ID”  
E8 E710  dDesUniMed  Descripción de la unidad 
de medida  E700  A 1-10 1-1 Referente al campo E709  
Utilizar el atributo “Código”  
Ejemplo: UNI  
E8 E711 dCantProSer  Cantidad del producto 
y/o servicio  E700  N 1-10p(0 -4) 1-1  
E8 E712  cPaisOrig  Código del país de 
origen del producto  E700  A 3 0-1 Según XSD de Codificación de 
Países  
E8 E713  dDesPaisOrig  Descripción del país de 
origen del producto  E700  A 4-30 0-1 Obligatorio si existe el campo 
E712  
E8 E714  dInfItem  Información de interés 
del emisor con respecto 
al ítem  E700  A 1-500 0-1  
E8 E715  cRelMerc  Código de datos de 
relevancia de las 
mercaderías  E700  N 1 0-1 Opcional si C002 = 7  
1=Tolerancia de quiebr a 
2= Tolerancia de merma  
Según RG 41/14  
E8 E716  dDesRelMerc  Descripción del código 
de datos de relevancia 
de las mercaderías  E700  A 19-21 0-1 1=“Tolerancia de quiebra”  
2=“Tolerancia de merma”  
 
 
 
septiembre  de 2019                87 
Grupo  ID Campo  Descripción  Nodo 
Padre Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8 E717  dCanQuiMer  Cantidad de quiebra o 
merma  E700  N 1-10(0-4) 0-1 Obligatorio si se informa E715  
Lo informado en este campo se 
encuentra en la unidad de medida 
elegida en E709  
Según RG 41/14  
E8 E718  dPorQuiMer  Porcentaje de quiebra o 
merma  E700  N 1-3(0-8) 0-1 Obligatorio si se informa E715  
Según RG 41/14  
E8 E719  dCDCAnticipo  CDC del anticipo  E700  A 44 0-1 Obligatorio cuando se utilice una 
factura asociada con el tipo de 
transacción igual a Anticipo 
(D011 de la factura asociada 
igual a 9)  
 
E8.1.  Campos que desc riben el precio , tipo de cambio y valor total de la o peración por ítem (E720 -E729)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.1 E720  gValorItem  Campos que describen 
los precios, descuentos 
y valor total por ítem  E700  G  0-1 Obligatorio si C002 ≠ 7  
No informar si C002 = 7  
E8.1 E721  dPUniProSer  Precio unitario del 
producto y/o servicio 
(incluidos impuestos)  E720  N 1-15p(0 -
8) 1-1  
E8.1 E725  dTiCamIt  Tipo de cambio por ítem  E720  N 1-5p(0-4) 0-1 Obligatorio si D015 ≠ PYG  
Obligat orio si D017 = 2  
No informar si D017 = 1  
E8.1 E727  dTotBruOpeItem  Total bruto de la 
operación por ítem  E720  N 1-15p(0 -
8) 1-1 Corresponde a la multiplicación 
del precio por ítem (E721) y la 
cantidad por ítem (E711)  
 
E8.1.1 Campos que describen los descuen tos, anticipos y valor total por ítem (EA001 -EA050)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.1.1 EA001  gValorRestaItem  Campos que describen 
los descuentos , 
anticipos  valor total por 
ítem E720 G  1-1  
 
 
 
septiembre  de 2019                88 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.1.1  EA002 dDescItem  Descuento particular 
sobre el precio unitario 
por ítem (incluidos 
impuestos)  EA001  N 1-15p(0 -
8) 0-1 Si no hay descuento por ítem 
completar con 0 (cero)  
E8.1.1  EA00 3 dPorcDesIt  Porcentaje de 
descuento particular 
por ítem  EA001  N 1-3p(0-8) 0-1 Debe existir si EA00 2 es mayor a 
0 (cero)  
[EA002 * 100 / E721]  
E8.1.1  EA004  dDescGloItem  Descuento global sobre 
el precio unitario por 
ítem (incluidos 
impuestos)  EA001  N 1-15p(0 -
8) 0-1 Si se cuenta con un descuento 
global, debe ser aplicado (no es 
prorra teo) a cada uno de los 
ítems, independientemente que un 
ítem cuente con un descuento 
particular.  
E8.1.1  EA006  dAntPreUniIt  Anticipo particular 
sobre el precio unitario 
por ítem (incluidos 
impuestos)  EA001  N 1-15p(0 -
8) 0-1 Se debe informar en la misma 
deno minación monetaria en la que 
se informó en la FE de anticipo 
asociada (D015 de la FE 
asociada)  
Si no hay anticipo por ítem 
completar con 0 (cero)  
E8.1.1  EA007  dAntGloPreUniIt  Anticipo global sobre el 
precio unitario por ítem 
(incluidos impuestos)   
 
EA001  N 1-15p(0 -
8) 0-1 Si se cuenta con un anticipo 
global, debe ser aplicado a cada 
uno de los ítems, 
independientemente de que un 
ítem cuente con un anticipo 
particular.  
Si no hay anticipo global por ítem, 
completar con 0 (cero)  
 
 
 
septiembre  de 2019                89 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.1.1 EA00 8 dTotOpeItem  Valor  total de la 
operación por ítem  EA001  N 1-15p(0 -
8) 1-1  
Cálculo para IVA, Renta, 
ninguno, IVA - Renta  
 
Si D013 = 1, 3, 4 o 5 (afectado al 
IVA, Renta, ninguno, IVA - Renta ), 
entonces EA008  corresponde al 
cálculo aritmético: (E721 (Precio 
unitario) – EA002 ( Descuento 
particular) – EA004 (Descuento 
global) – EA006 (Anticipo 
particular) – EA007 (Anticipo 
global)) * E711(cantidad)  
 
Cálculo para Autofactura  
(C002=4):  
 
E721*E711   
E8.1.1 EA009 dTotOpeGs  Valor total de la 
operación por ítem en 
guaraníes  EA001  N 1-15p(0 -
8) 0-1 Obligatorio si existe el campo 
E725  
Corresponde al cálculo aritmético  
EA00 8* E725  
 
E8.2.  Campos que describen el IVA de la operación por ítem (E730 -E739)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.2 E730  gCamIVA  Campos que describen 
el IVA de la operación  E700  G  0-1 Obligatorio si D013=1, 3 , 4 o 5  y 
C002 ≠ 4 o 7  
No informar si D013=2 y C002= 4 
o 7  
E8.2 E731  iAfecIVA  Forma de afectación 
tributaria del IVA  E730  N 1 1-1 1= Gravado IVA  
2= Exonerado (A rt. 83 - Ley 
125/91)  
3= Exento  
4= Gravado parcial (Grav -Exento)  
 
 
 
septiembre  de 2019                90 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.2 E732  dDesAfecIVA  Descripción de la forma 
de afectación tributaria 
del IVA  E730  A 6-15 1-1 Referente al campo E731  
1= “Gravado IVA”  
2= “Exonerado (Art. 83 - Ley 
125/91)”  
3= “Exento”  
4= “G ravado parcial (Grav - 
Exento)”  
E8.2 E733  dPropIVA  Proporción gravada de 
IVA E730  N 1-3p(0-8) 1-1 Corresponde al porcentaje (%) 
gravado  
Ejemplo:100, 50, 30, 0  
E8.2 E734  dTasaIVA  Tasa del IVA  E730  N 1-2 1-1 Corresponde al porcentaje (%) de 
la tasa expresa do en números 
enteros  
0 (para E731 = 2 o 3)  
5 (para E731 = 1 o 4)  
10 (para E731 = 1 o 4)  
E8.2 E735  dBasGravIVA  Base gravada del IVA 
por ítem  E730  N 1-15p(0 -8) 1-1 Si E731 = 1 o 4 este campo es 
igual al resultado del cálculo  
[EA008* (E733/100) ] / 1,1 si l a 
tasa es del 10%  
[EA008* (E733/100) ] / 1,05 si la 
tasa es del 5%  
Si E731 = 2 o 3 este campo es 
igual 0  
E8.2 E736  dLiqIVAItem  Liquidación del IVA por 
ítem E730  N 1-15p(0 -8) 1-1 Corresponde al cálculo aritmético:  
E735 * (E734/100)  
Si E731 = 2 o 3 este camp o es 
igual 0  
E8.4.  Grupo de rastreo de la mercadería (E750 -E760)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.4 E750  gRasMerc  Grupo de rastreo de la 
mercadería  E700  G  0-1  
E8.4 E751  dNumLote  Número de lote  E750  A 1-80 0-1 Obligados por la RG N° 24/2019 
– Agroquímicos  
 
 
 
septiembre  de 2019                91 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.4 E752  dVencMerc  Fecha de vencimiento 
de la mercadería  E750  F 10 0-1 Formato AAAA -MM-DD 
E8.4 E753  dNSerie  Número de serie  E750  A 1-10 0-1  
E8.4 E754  dNumPedi  Número de pedido  E750  A 1-20 0-1  
E8.4 E755  dNumSegui  Número de 
seguimiento del envío  E750  A 1-20 0-1  
E8.4 E756  dNomImp  Nombre del Importador  E750  A 4-60 0-1 Obligados por la RG N° 16/2019 
– Agroquímicos  
E8.4 E757  dDirImp  Dirección de 
Importador  E750  A 1-255 0-1 Obligados por la RG N° 16/2019 
– Agroquímicos  
E8.4 E758  dNumFir  Número de registro de 
la firma del importador  E750  A 20 0-1 Obligados por la RG N° 16/2019 
– Agroquímicos  
E8.4 E759  dNumReg  Número de registro del 
producto  otorgado por 
el SENAVE  E750  A 20 0-1 Obligados por la RG N° 16/2019 
y la RG N° 24/2019  – 
Agroquímicos  
E8.4 E760  dNumRegEntCom  Número de registro de 
entidad comercial 
otorgado por el 
SENAVE  E750  A 20 0-1 Obligados por la RG N° 24/2019 
– Agroquímicos  
 
E8.5.  Sector de automotores nuevos y usados (E770 -E789)  
 
Grup o ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.5 E770  gVehNuevo  Grupo de detalle de 
vehículos nuevos  E700  G  0-1  
E8.5 E771  iTipOpVN  Tipo de ope ración de 
venta de vehículos  E770  N 1 0-1 1= Venta a representante  
2= Venta al consumidor final  
3= Venta a gobierno  
4= Venta a flota de vehículos  
 
 
 
septiembre  de 2019                92 
Grup o ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.5 E772  dDesTipOpVN  Descripción del tipo de 
operación de venta de 
vehículos  E770  A 16-30 0-1 Obligatorio si  existe el campo 
E762  
1= “Venta a representante”  
2= “Venta al consumidor fin al” 
3= “Venta a gobierno”  
4= “Venta a flota de vehículos”  
E8.5 E773  dChasis  Chasis del vehículo  E770  A 17 0-1  
E8.5 E774  dColor  Color del vehículo  E770  A 1-10 0-1  
E8.5 E775  dPotencia  Potencia del motor 
(CV) E770  N 1-4 0-1  
E8.5 E776  dCapMot  Capacidad del motor  E770  N 1-4 0-1 Expresa en centímetros cúbicos 
(cc) 
E8.5 E777  dPNet  Peso Neto  E770  N 1-6p(0-4) 0-1 Toneladas  
E8.5 E778  dPBruto  Peso Bruto  E770  N 1-6p(0-4) 0-1 Toneladas  
E8.5 E779  iTipCom  Tipo de combustible  E770  N 1 0-1 1= Gasolina  
2= Diésel  
3= Etanol  
4= GNV  
5= Flex  
9= Otro  
E8.5 E780  dDesTipCom  Descripción del tipo de 
combustible  E770  A 3-20 0-1 Obligatorio si existe el campo 
E770  
1= “Gasolina”  
2= “Diésel”  
3= “Etanol”  
4= “GNV”  
5= “Flex”  
Si E769= 9 describir el tipo de 
combustible  
E8.5 E781  dNroMotor  Número del motor  E770  A 1-21 0-1  
E8.5 E782  dCapTracc  Capacidad máxima de 
tracción  E770  N 1-6p(0-4) 0-1 Toneladas  
E8.5 E783  dAnoFab  Año de fabricación  E770  N 4 0-1  
E8.5 E784  cTipVeh  Tipo de vehículo  E770  A 4-10 0-1  
 
 
 
septiembre  de 2019                93 
Grup o ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E8.5 E785  dCapac  Capacidad m áxima de 
pasajeros  E770  N 1-3 0-1 Capacidad máxima de pasajeros 
sentados  
E8.5 E786  dCilin  Cilindradas del motor  E770  A 4 0-1  
 
 
E9. Campos complementarios comerciales de uso espe cífico (E790 -E899)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E9 E790  gCamEsp  Campos 
complementarios 
comerciales de uso 
específico  E001  G  0-1  
 
 
E9.2.  Sector Energía Eléctrica (E791 -E799)  
 
Grupo  ID Campo  Descripci ón Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E9.2 E791  gGrupEn er Grupo del sector de 
energía eléctrica  E790  G  0-1  
E9.2 E792  dNroMed  Número de medidor  E791  A 1-50 0-1  
E9.2 E793  dActiv  Código de actividad  E791  N 2 0-1  
E9.2 E794  dCateg  Código de categoría  E791  A 3 0-1  
E9.2 E795  dLecAnt  Lectura anterior  E791  N 1-11p2  0-1  
E9.2 E796  dLecAct  Lectura actual  E791  N 1-11p2  0-1  
E9.2 E797  dConKwh  Consumo  E791  N 1-11p2  0-1 Corresponde a la diferencia entre 
E785 -E784  
 
 
 
 
 
 
 
 
septiembre  de 2019                94 
E9.3.  Sector de Segur os (E800 -E809)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E9.3 E800  gGrupSeg  Grupo del sector de 
seguros  E790  G  0-1  
E9.3 E801  dCodEmpSeg  Código de la empresa de 
seguros en la 
Superintendencia de 
Seguros  E800  A 20 0-1  
 
E9.3.1.   Póliza de seguros ( EA790 -EA799) 
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E9.3.1 EA790  gGrup PolSeg Grupo de póliza de 
seguros  E800  G  1-999  
E9.3.1  EA791  dPoliza  Código de la póliza  EA790  A 1-20 1-1  
E9.3.1  EA792  dUnidVig  Descripción de la 
unidad de tiempo de 
vigencia  EA790 A 3-15 1-1 Ejemplo: hora, día, mes, año  
E9.3.1  EA793  dVigencia  Vigencia de la póliza  EA790  N 1-5p1 1-1  
E9.3.1  EA794  dNumPoliza  Número de la póliza  EA790  A 1-25 1-1  
E9.3.1  EA795  dFecIniVig  Fecha de inicio de 
vigencia  EA790  F 19 0-1 Según el formato  
AAAA -MM-DDThh:mm:ss  
E9.3.1  EA796  dFecFinVig  Fecha de fin de 
vigencia  EA790  F 19 0-1 Según el formato  
AAAA -MM-DDThh:mm:ss  
E9.3.1  EA797  dCodInt  Código interno del ítem  EA790  A 1-20 0-1 Como referencia al campo E701, 
si desea asociar la póliza al ítem  
 
 
 
 
 
 
 
 
 
 
septiembre  de 2019                95 
E9.4.  Sector de Supermercados (E810 -E819)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E9.4 E810  gGrupSup  Grupo del sector 
supermercados  E790  G  0-1  
E9.4 E811  dNomCaj  Nombre del cajero  E810  A 1-20 0-1  
E9.4 E812 dEfectivo  Efectivo  E810  N 1-15p(0 -4) 0-1  
E9.4 E813  dVuelto  Vuelto  E810  N 1-6p(0-4) 0-1  
E9.4 E814  dDonac  Monto de la donación  E810  N 1-6p(0-4) 0-1  
E9.4 E815  dDesDonac  Descri pción de la 
donación  E810  A 1-20 0-1  
 
 
E9.5.  Grupo de datos adicionales de  uso comercial (E820 -E829)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E9.5 E820  gGrupAdi  Grupo de datos 
adicionales de uso 
comercial  E790  G  0-1  
E9.5 E821  dCiclo  Ciclo  E820  A 1-15 0-1  
E9.5 E822  dFecIniC  Fecha de  inicio de ciclo  E820  F 10 0-1 Obligatorio si se informa el campo 
E811  
No completar si no se informa el 
campo E811  
Formato AAAA -MM-DD 
E9.5 E823  dFecFinC  Fecha de fin de ciclo  E820  F 10 0-1 Obligatorio si se informa el campo 
E812  
No completar si no se info rma el 
campo E812  
Formato AAAA -MM-DD 
E9.5 E824  dVencPag  Fecha de vencimiento 
para el pago  E820  F 10 0-3 Formato AAAA -MM-DD 
 
 
 
septiembre  de 2019                96 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E9.5 E825  dContrato  Número de contrato  E820  A 1-30 0-1  
E9.5 E826  dSalAnt  Saldo anterior  E820  N 1-15p(0 -4) 0-1 Monto del saldo ant erior 
 
E10. Campos que describen el transporte de las mercaderías (E900 -E999)  
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E10 E900  gTransp  Campos que describen 
el transporte de 
mercaderías  E001  G  0-1 Obligatorio si C002 = 7  
Opcional si C002 = 1  
No informar si C002= 4, 5, 6  
E10 E901  iTipTrans  Tipo de transporte  E900  N 1 0-1 Obligatorio si C002 = 7  
1= Propio  
2= Tercero  
E10 E902  dDesTipTrans  Descripción del tipo de 
transporte  E900  A 6-7 0-1 Obligatorio si existe el ca mpo 
E901  
E10 E903  iModTrans  Modalidad del 
transporte  E900  N 1 1-1 1=Terrestre  
2= Fluvial  
3= Aéreo  
4= Multimodal  
E10 E904  dDes ModTrans  Descripción de la 
modalidad del 
transporte  E900  A 5-10 1-1 Referente al campo E903  
1= “Terrestre”  
2= “Fluvial”  
3= “Aére o” 
4= “Multimodal”  
E10 E905  iRespFlete  Responsable  del costo 
del flete  E900  N 1 1-1 1= Emisor de la Factura 
Electrónica  
2= Receptor de la Factura 
Electrónica  
3= Tercero  
4= Agente intermediario del 
transporte (cuando intervenga)  
5= Transporte propio  
E10 E906 cCondNeg  Condición de la 
negociación  E900  A 3 0-1 Según Tabla 10 - Incoterms  
 
 
 
septiembre  de 2019                97 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E10 E907  dNuManif  Número de manifiesto o 
conocimiento de carga/  
declaración de tránsito 
aduanero/ Carta de 
porte internacional  E900  A 1-15 0-1 Campo abierto para informar la  
numeración de cualquiera de las 
opciones descriptas  
E10 E908  dNuDespImp  Número de despacho 
de importación  E900  A 16 0-1 Obligatorio si E501 = 5  
E10 E909  dIniTras  Fecha estimada de 
inicio de traslado  E900  F 10 0-1 Obligatorio si C002 = 7  
Opcional si C002  = 1 
Fecha en el formato: AAAA -MM-
DD 
E10 E910  dFinTras  Fecha estimada de fin 
de traslado  E900  F 10 0-1 Obligatorio si existe el campo 
E909  
Fecha en el formato: AAAA -MM-
DD 
E10 E911 cPaisDest  Código del país de 
destino  E900  A 3 0-1 Según XSD de Codificaci ón de 
Países  
E10 E912  dDesPaisDest  Descripción del país de 
destino  E900  A 4-30 0-1 Obligatorio si existe el campo 
E911  
 
E10.1.  Campos que identifican el local de salida de las me rcaderías (E920 -E939)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longi tud Ocurrencia  Observaciones  
E10.1  E920  gCamSal  Campos que identifican 
el local de salida de las 
mercaderías   E900  G  0-1 Obligatorio si C002 = 7 
Opcional si C002 = 1  
No informa r si C002 = 4, 5, 6  
E10.1  E921  dDirLocSal  Dirección del local de 
salida  E920 A 1-255 1-1 Nombre de la calle principal  
E10.1  E922  dNumCasSal  Número de casa de 
salida  E920  N 1-6 1-1 Si no tiene numeración, colocar 0 
(cero)  
E10.1  E923  dComp1Sal  Compleme nto de 
dirección 1 salida  E920  A 1-255 0-1 Nombre de la calle secundaria  
 
 
 
septiembre  de 2019                98 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longi tud Ocurrencia  Observaciones  
E10.1  E924  dComp2Sal  Complemento de 
dirección 2 salida  E920  A 1-255 0-1 Número de departamento/ piso/ 
local/ edificio/ deposito del local 
de salida de la mercadería  
E10.1  E925  cDepSal Código del 
departamento del local 
de salida  E920  N 1-2 1-1 Según XSD de  Departamentos  
E10.1  E926  dDesDepSal  Descripción del 
departamento del local 
de salida  E920  A 6-16 1-1 Referente al campo E925  
E10.1  E927  cDisSal  Código del distrito del 
local d e salida  E920  N 1-4 0-1 Según Tabla 2.1 - Distritos  
E10.1  E928  dDesDisSal  Descripción de distrito 
del local de salida  E920  A 1-30 0-1 Obligatorio si existe el campo 
E927  
E10.1  E929  cCiuSal  Código de la ciudad del 
local de salida  E920  N 1-5 1-1 Según Ta bla 2.2 – Ciudades  
E10.1  E930  dDesCiuSal  Descripción de ciudad 
del local d e salida  E920  A 1-30 1-1 Referente al campo E929  
E10.1  E931  dTelSal  Teléfono de contacto 
del local de salida  E920  A 6-15 0-1  
 
E10.2.  Campos que identifican el local de entrega de las mercaderías (E940 -E959)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato Longitud  Ocurrencia  Observaciones  
E10.2  E940  gCamEnt  Campos que identifican 
el local de la entrega de 
las mercaderías  E900  G  0-99 Obligatorio si C002 = 7  
No informar si C002 = 4, 5, 6  
E10.2  E941  dDirLocEnt  Dirección del local de la 
entrega  E940  A 1-255 1-1 Nombre de la calle principal  
E10.2  E942  dNumCasEnt  Número de casa de la 
entrega  E940  N 1-6 1-1 Si no tiene numeración, colocar 0 
(cero)  
 
 
 
septiembre  de 2019                99 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato Longitud  Ocurrencia  Observaciones  
E10.2  E943  dComp1Ent  Complemento de 
dirección 1 entrega  E940  A 1-255 0-1 Nombre de la calle secundaria  
E10.2  E944  dComp2Ent  Complemento de 
dirección 2 entrega  E940  A 1-255 0-1 Número de departamento/ piso/ 
local/ edificio/ deposito del local 
de entrega de la mercadería  
E10.2  E945  cDepEn t Código del 
departamento del local 
de la entrega  E940  N 1-2 1-1 Según XSD d e Departamentos  
E10.2  E946  dDesDepEnt  Descripción del 
departamento del local 
de la entrega  E940  A 6-16 1-1 Referente al campo E945  
E10.2  E947  cDisEnt  Código del distrito del 
local de la entrega  E940  N 1-4 0-1 Según Tabla 2.1 - Distritos  
E10.2  E948  dDesD isEnt  Descripción de distrito 
del local de la entrega  E940  A 1-30 0-1 Obligatorio si existe el campo 
E947  
E10.2  E949  cCiuEnt  Código de la ciudad del 
local de la entrega  E940  N 1-5 1-1 Según Tabla 2.2 – Ciudades  
E10.2  E950  dDesCiuEnt  Descripción de ciudad  
del local de la entrega  E940  A 1-30 1-1 Referente al campo E949  
E10.2  E951  dTelEnt  Teléfono de contacto 
del local de la entrega  E940  A 6-15 0-1  
 
E10.3.  Campos que identifican e l vehículo de traslado de mercaderías (E960 -E979)  
 
Grupo  ID Campo  Descripció n Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E10.3  E960  gVehTras  Campos que identifican 
al vehículo del traslado 
de mercaderías  E900  G  0-4 Obligatorio si C002 = 7  
No informar si C002 = 4, 5, 6  
 
 
 
septiembre  de 2019                100 
Grupo  ID Campo  Descripció n Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E10.3  E961  dTiVehTras            Tipo de vehícul o E960  A 4-10 1-1 Debe ser acorde al campo E903  
E10.3  E962  dMarVeh  Marca  E960  A 1-10 1-1  
E10.3  E967  dTipIdenVeh  Tipo de identificación 
del vehículo  E960  N 1 1-1 1=Número de iden tificación del 
vehículo  
2=Número de matrícula del 
vehículo  
E10.3  E963  dNroI DVeh  Número de 
identificación del 
vehículo  E960  A 1-20 0-1 Debe informarse cuando el 
E967=1  
E10.3  E964  dAdicVeh  Datos adicionales del 
vehículo  E960  A 1-20 0-1  
E10.3  E965  dNroMat Veh Número de matrícula 
del vehículo  E960  A 6 0-1 Debe informarse cuando el 
E967=2  
E10.3  E966  dNroVuelo  Número de vuelo  E960  A 6 0-1 Obligatorio si E903 = 3  
No informar si E903 ≠ 3  
 
 
E10.4.  Campos que identifican al transportista (persona física o jurídica) (E980 -E999)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E10.4  E980  gCamTrans  Campos que identifican 
al transportis ta  E900  G  0-1 Obligatorio si C002 = 7  
No informar si C002 = 4, 5, 6  
Opcional cuando E903=1 y 
E967=1  
E10.4  E981  iNatTrans  Naturaleza del 
transportista  E980  N 1 1-1 1= Contribuyente  
2= No contribuyente  
E10.4  E982  dNomTrans  Nombre o razón social 
del tran sportista  E980  A 4-60 1-1  
E10.4  E983  dRucTrans  RUC del transportista  E980  A 3-8 0-1 Obligatorio si E981 = 1  
No informar si E981 ≠ 1  
 
 
 
septiembre  de 2019                101 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E10.4  E984  dDVTrans  Dígito verificador del 
RUC del transportista  E980  N 1 0-1 Obligatorio si existe el campo 
E983  
Según algoritmo módulo 11  
E10.4  E985  iTipIDTrans  Tipo de documento de 
identidad del 
transportista  E980  N 1 0-1 Oblig atorio si E981 = 2  
No informar si E981 = 1  
1= Cédula paraguaya  
2= Pasaporte  
3= Cédula extranjera  
4= Carnet de residencia  
E10.4  E986  dDTipIDTrans  Descripción del tipo de 
documento de identidad 
del transportista  E980  A 9-20 0-1 Obligatorio si existe el camp o 
E985  
1= “Cédula paraguaya”  
2= “Pasaporte”  
3= “Cédula extranjera”  
4= “Carnet de residencia”  
E10.4  E987  dNumIDTrans  Número de documento 
de identidad del 
transportista  E980  A 1-20 0-1 Obligatorio si existe el campo 
E985  
E10.4  E988  cNacTrans  Nacionalidad d el 
transportista  E980  A 3 0-1 Según XSD de Codificación de 
Países  
E10.4  E989  dDesNacTrans  Descripción de la 
nacionalidad del 
transportista  E980  A 4-30 0-1 Obligatorio si existe el campo 
E988  
E10.4  E990  dNumIDChof  Número de documento 
de identidad del chof er E980  A 1-20 1-1  
E10.4  E991  dNomChof  Nombre y apellido del 
chofer  E980  A 4-60 1-1  
E10.4  E992  dDomFisc  Domicilio fiscal del 
transportista  E980  A 1-150 0-1  
E10.4  E993  dDirChof  Dirección del chofer  E980  A 1-255 0-1  
E10.4  E994  dNombAg  Nombre o razón social 
del agente  E980  A 4-60 0-1 Casos particulares según RG N° 
41/14  
E10.4  E995  dRucAg  RUC del agente  E980  A 3-8 0-1 Casos particulares según RG N° 
41/14  
 
 
 
septiembre  de 2019                102 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
E10.4  E996  dDVAg  Dígito verificador del 
RUC del agente  E980  N 1 0-1 Casos particulares según RG N°  
41/14  
Según algoritmo módulo 11  
E10.4  E997  dDirAge  Dirección del agente  E980  A 1-255 0-1 Casos particulares según RG N° 
41/14  
 
 
 
F. Campos que describen los subtotales y totales de la transacción documentada (F001 -F099)  
 
En consideración a la Resolución 34 7 del 2014 (Secretaría de Defensa del Consumidor -SEDECO). Las reglas de redondeo 
aplican a múltiplos de 50 guaraníes de la siguiente manera:  
Ejemplos:  
 
Guaraníes  Redondeo  Monto 
Redondeado  
107.437  37 107.400  
47.789  39 47.750  
 
Observación:  Para monedas e xtranjeras o cualquier otro cálculo que contenga decimales, las reglas de validación 
aceptarán redondeos de 50 céntimos (por encima o por debajo)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
F F001  gTotSub  Campos de s ubtotales 
y totales  A001  G  0-1 Obligatorio si C002 ≠ 7  
No informar si C002 = 7  
Cuando C002= 4, no informar 
F002, F003, F004, F005, F015, 
F016, F017, F018, F019, F020, 
F023, F025 y F026  
 
 
 
septiembre  de 2019                103 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
F F002  dSubExe  Subtotal de la 
operación exenta  F001  N 1-15p(0 -8) 0-1 Si E731 = 3: Suma de todas las 
ocurrencias de EA00 8 (Valor 
total de la operación por ítem) 
cuando la operación sea exenta  
F F003  dSubExo  Subtotal de la 
operación exonerada  F001  N 1-15p(0 -8) 0-1 Si E731 = 2: Suma de todas las 
ocurrencias de EA00 8 (Valor 
total de la operación por ítem) 
cuando la operación sea 
exonerada  
F F004  dSub5  Subtotal de la 
operación con IVA 
incluido a la tasa 5%  F001  N 1-15p(0 -8) 0-1 Si E731 = 1 o 4: Suma de todas 
las ocurrencias de EA00 8 (Valor 
total de la operación por ítem) 
cuan do la operación sea a la 
tasa del 5% (E734=5)  
No debe existir el campo si D013 
≠ 1 
F F005  dSub10  Subtotal de la 
operación con IVA 
incluido a la tasa 10%  F001  N 1-15p(0 -8) 0-1 Si E731 = 1 o 4: Suma de todas 
las ocurrencias de EA00 8 (Valor 
total de la opera ción por ítem) 
cuando la operación sea a la 
tasa del 10% (E734=10)  
No debe existir el campo si D013 
≠ 1 
F F008  dTotOpe  Total Bruto  de la 
operación  F001  N 1-15p(0 -8) 1-1 Cuando D013 = 1, 3, 4 o 5  
corresponde a la suma de los 
subtotales de la operación 
(F002, F003, F004 y F005)  
Cuando D013 = 2 corresponde a 
F006  
Cuando C002=4 corresponde a 
la suma de todas las ocurrencias 
de EA008 (Valor total de la 
operación por ítem)  
F F009  dTotDesc  Total descuento 
particular por ítem  F001  N 1-15p(0 -8) 1-1 Suma de todos l os descuentos 
particulares  por ítem ( EA002 ) 
F F033  dTotDescGlotem  Total descuento global 
por ítem  F001  N 1-15p(0 -8) 1-1 Sumatoria de todas las 
ocurrencias de descuentos 
globales por ítem (EA004)  
 
 
 
septiembre  de 2019                104 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
F F034  dTotAntItem  Total Anticipo por ítem  F001  N 1-15p(0 -8) 1-1 Sumatoria de todas las 
ocurrencias de anticipos por ítem 
(EA006)  
F F035  dTotAnt  Total Anticipo global 
por ítem F001  N 1-15p(0 -8) 1-1 Sumatoria de todas las 
ocurrencias de anticipos global 
por ítem (EA007)  
F F010  dPorcDescTotal  Porcentaje de 
descue nto global sobre 
total de la operación  F001  N 1-3p(0-8) 1-1 Informativo, si no existe %, 
completar con cero  
F F011  dDescTotal  Total Descuentos de la 
operación  F001  N 1-15p(0 -8) 1-1 Sumatoria de todos los 
descuentos (Global por Ítem y 
particular por ítem)  de cada ítem  
F F012  dAnticipo  Total Anticipos de la 
operación  F001  N 1-15p(0 -8) 1-1 Sumatoria de todos los Anticipos 
(Global por Ítem y particular por 
ítem)  
F F013  dRedon  Redondeo de la 
operación  F001  N 1-3p(0-4) 1-1 Se realiza sobre el campo F008 
y conf orme a la explicación 
inicial en el grupo F  
Si no cuenta con redondeo 
completar con cero  
F F025  dComi  Comisión de la 
operación  F001  N 1-15p(0 -8) 0-1  
F F014  dTotGralOpe  Total Neto de la 
operación  F001  N 1-15p(0 -8) 1-1 Corresponde al cálculo 
aritmético  
F008 - F013 + F025  
F F015  dIVA5  Liquidación del IVA a 
la tasa del 5%  F001  N 1-15p(0 -8) 0-1 Suma de todas las ocurrencias 
de E736 (Liquidación del IVA por 
ítem) cuando la operación sea a 
la tasa del 5% (E734=5)  
No debe existir el campo si D013 
≠ 1 o D013 ≠5 
F F016  dIVA10  Liquidación del IVA a 
la tasa del 10%  F001  N 1-15p(0 -8) 0-1 Suma de todas las ocurrencias 
de E736 (Liquidación del IVA por 
ítem) cuando la operación sea a 
la tasa del 10% (E734=10)  
No debe existir el campo si D013 
≠ 1 o D013 ≠5 
 
 
 
septiembre  de 2019                105 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
F F036  dLiqTotIVA5  Liquidación total del 
IVA por redondeo a la 
tasa del 5%  F001  N 1-15p(0 -8) 0-1 Corresponde al cálculo del 
impuesto al IVA a la tasa del 5% 
sobre el valor del redondeo 
(Valor del redondeo/1,05), 
cuando la operación sea a la 
tasa del 5% (E734=5)  
No de be existir el campo si D013 
≠ 1 o D013 ≠5 
F F037  dLiqTotIVA10  Liquidación total del 
IVA por redondeo a la 
tasa del 10%  F001  N 1-15p(0 -8) 0-1 Corresponde al cálculo del 
impuesto al IVA a la tasa del 
10% sobre el valor del redondeo 
(Valor del redondeo/1,1), cuando 
la operación sea a la  tasa del 
10% (E734=1 0) 
No debe existir el campo si D013 
≠ 1 o D013 ≠5 
F F026  dIVAComi  Liquidación total del 
IVA de la comisión   F001  N 1-15p(0 -8) 0-1 Se aplica la tasa del 10% para 
comisiones  
F F017  dTotIVA  Liquidación total del 
IVA  F001  N 1-15p(0 -8) 0-1 Corresponde al cálculo 
aritmético F015 (Liquidación del 
IVA al 10%)  + F016(Liquidación 
del IVA al 5 %) – F036 (redondeo 
al 5%) – F037 (redondeo al 10%) 
+ F026  (Liquidación total del IVA 
de la comisión)  
No debe existir el campo si D013 
≠ 1 o D013 ≠5 
F F018 dBaseGrav5  Total base gravada al 
5% F001  N 1-15p(0 -8) 0-1 Suma de todas las ocurrencias 
de E735 (base gravada del IVA 
por ítem) cuando la operación 
sea a la tasa del 5% (E734=5).  
No debe existir el campo si D013 
≠ 1 o D013 ≠5 
 
 
 
septiembre  de 2019                106 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
F F019  dBaseGrav10  Total bas e gravada al 
10% F001  N 1-15p(0 -8) 0-1 Suma de todas las ocurrencias 
de E735 (base gravada del IVA 
por ítem) cuando la operación 
sea a la tasa del 10% 
(E734=10).  
No debe existir el campo si D013 
≠ 1 o D013 ≠5 
F F020  dTBasGraIVA  Total de la base 
gravada de  IVA F001  N 1-15p(0 -8) 0-1 Corresponde al cálculo 
aritmético  
F018 +F019  
No debe existir el campo si D013 
≠ 1 o D013 ≠5 
F F023  dTotalGs  Total general de la 
operación en 
Guaraníes  F001  N 1-15p(0 -8) 0-1 Si D015 ≠ PYG y D017 = 1, 
corresponde al cálculo 
aritméti co: 
F014  * D018  
Si D015 ≠ PYG y D017 = 2, 
corresponde a la suma de todas 
las ocurrencias de EA009 
Este campo no debe existir si 
D015=PYG  
No informar si D015 = PYG  
Cuando C002=4 corresponde a 
F014  
F F024  dTotCom  Total + comisión  F001  N 1-15p(0 -8) 0-1  
 
G. Campos complementarios comerciales de uso general (G001 -G049) 
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
G G001  gCamGen  Campos de uso general  A001  G  0-1  
G G002  dOrdCompra  Número de orden de 
compra  G001  A 1-15 0-1  
G G003  dOrdVta  Número de orden de 
venta  G001  A 1-15 0-1  
 
 
 
septiembre  de 2019                107 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
G G004  dAsiento  Número de asiento 
contable  G001  A 1-10 0-1  
 
G1. Campos generales de la carga (G050 - G099)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
G1 G050 gCamCarg  Campos generales de la 
carga  G001  G  0-1 Opcional cuando C002=1 o 
C002=7  
No informar para C002 ≠ 1 y 
C002≠7  
G1 G051 cUniMedTotVol  Unidad de medida del 
total de volumen de la 
mercadería  G050  N 1-5 0-1 Según Tabla 5 – Unidad de 
Medida  
Si D202 =  3 utilizar los datos del 
WS del link de la DNCP  
Utilizar el atributo “ID”  
G1 G052 dDesUniMedTotVol  Descripción de la 
unidad de medida del 
total de volumen de la 
mercadería  G050  A 1-10 0-1 Referente al campo F027  
Utilizar el atributo “Código”  
Ejemplo: UNI  
G1 G053 dTotVolMerc  Total volumen de la 
mercadería  G050  N 1-20 0-1 Corresponde al volumen total de 
ítems que se han informado  
G1 G054 cUniMedTotPes  Unidad de medida del 
peso total de la 
mercadería  G050  N 1-5 0-1 Según Tabla 5 – Unidad de 
Medida  
Si D202 = 3 utilizar los datos del 
WS del link de la DNCP  
Utilizar el atributo “ID”  
G1 G055 dDesUniMedTotPes  Descripción de la 
unidad de medida del 
peso total de la 
mercadería  G050  A 1-10 0-1 Referente al campo F030  
Utilizar el atributo “Código”  
Ejemplo: UNI  
G1 G056 dTotPesMerc  Total peso de la 
mercadería  G050  N 1-20 0-1 Corresponde al peso total de 
ítems que se han informado  
 
 
 
septiembre  de 2019                108 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
G1 G057 iCarCarga  Características de la 
Carga  G050  N 1-1 0-1 1 – Mercaderías con cadena de 
frío 
2 – Carga peligrosa  
3 – Otro de caracterís ticas 
similares (especificar)  
Obligatorio cuando lo exige la 
RG 41/14  
G1 G058 dDesCarCarga  Descripción de las 
características de la 
carga  G050  A 1-50 0-1 1 – “Mercaderías con cadena de 
frío” 
2 – “Carga peligrosa”  
Si G057 = 3, informar la 
característica de  la carga  
Obligatorio cuando lo exige la 
RG 41/14 – Obligatorio para 
KUDE  
 
H. Campos que identifican al documento asociado (H001 -H049)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
H H001  gCamDEAsoc  Campos que identifica n 
al DE asociado  A001  G  0-99 Obligatorio si C002 = 4, 5, 6  
Opcional si C002=1 o 7  
H H002  iTipDocAso  Tipo de documento 
asociado  H001  N 1 1-1 1= Electrónico  
2= Impreso  
3= Constancia Electrónica  
H H003  dDesTipDocAso  Descripción del tipo de 
documento asoci ado H001  A 7-11 1-1 Referente al campo H002  
1= “Electrónico”  
2= “Impreso”  
3= “Constancia Electrónica”  
H H004  dCdCDERef  CDC del DTE 
referenciado  H001  A 44 0-1 Obligatorio si H002=1  
No informar si H002 = 2 o 3  
H H005  dNTimDI  Nro. timbrado 
documento impreso  de 
referencia  H001  N 8 0-1 Obligatorio si H002=2  
No informar si H002 = 1 o 3 
H H006  dEstDocAso  Establecimiento  H001  A 3 0-1 Obligatorio si H002=2  
Completar con 0 (cero) a la 
izquierda  
No informar si H002 = 1 o 3  
 
 
 
septiembre  de 2019                109 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
H H007  dPExpDocAso  Punto de expedición  H001 A 3 0-1 Obligatorio si H002=2  
Completar con 0 (cero) a la 
izquierda  
No informar si H002 = 1 o 3  
H H008  dNumDocAso  Número del documento  H001  A 7 0-1 Obligatorio si H002=2  
Completar con 0 (cero) a la 
izquierda hasta alcanzar 7 (siete) 
cifras  
No informa r si H002 = 1 o 3  
H H009  iTipoDocAso  Tipo de documento 
impreso  H001  N 1 0-1 Obligatorio si H002=2  
No informar si H002 = 1 o 3  
1= Factura  
2= Nota de crédito  
3= Nota de débito  
4= Nota de remisión  
5= Comprobante de retención  
H H010  dDTipoDocAso  Descripción del tipo de 
documento impreso  H001  A 7-16 0-1 Obligatorio si existe el campo 
H009  
1= “Factura”  
2= “Nota de crédito”  
3= “Nota de débito”  
4= “Nota de remisión”  
5= “Comprobante de retención”  
H H011  dFecEmiDI  Fecha de emisión del 
documento impreso de 
referenc ia H001  F 10 0-1 Obligatorio si existe el campo 
H005  
Formato AAAA -MM-DD 
No Informar si campo H005 no 
existe  
H H012  dNumComRet  Número de comprobante 
de retención  H001  A 15 0-1 Si E606 = 10, es opcional informar 
número de comprobante de 
retención (Cambio te mporal).  
No informar si E606 ≠ 10  
H H013  dNumResCF  Número de resolución de 
crédito fiscal  H001  A 15 0-1 Si D011 = 12 obligatorio informar 
número de resolución de crédito 
fiscal  
No informar si D011 ≠ 12  
 
 
 
septiembre  de 2019                110 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
H H014  iTipCons  Tipo de constancia  H001  N 1 0-1 Obligatorio c uando H002 = 3  
No informar cuando H002 ≠ 3  
1= Constancia de no ser 
contribuyente  
2= Constancia de 
microproductores  
H H015  dDesTipCons  Descripción del tipo de 
constancia  H001  A 30-34 0-1 Obligatorio si se informa H014  
Referente al campo H014  
1= “Constancia  de no ser 
contribuyente”  
2=“Constancia de 
microproductores”  
H H016  dNumCons  Número de constancia  H001  N 11 0-1 Obligatorio cuando H002 = 3 y 
H014 = 2  
No informar cuando H002 ≠ 3  
H H017  dNumControl  Número de control de la 
constancia  H001  A 8 0-1 Obliga torio cuando H002 = 3 y 
H014 = 2  
No informar cuando H002 ≠ 3  
 
I. Información de la Firma Digital del DTE (I001 -I049)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
I I001 Signature  Firma Digital del DTE  AA001  G  1-1 Segú n el estándar XML signature  
Debe ser firmado el grupo A (campo 
A001) que contiene los grupos de 
información del A hasta H  
 
J. Campos fuera de la Firma Digital (J001 -J049)  
 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
J J001 gCamFuFD  Campos fuera de la firma 
digital  AA001  G  1-1  
J J002  dCarQR  Caracteres 
correspondientes al código 
QR J001  A 100-600 1-1 Debe ser validado contra la información 
incluida en el XML del DE, de acuerdo 
con lo especificado en el capítulo del 
QR d el MT  
 
 
 
septiembre  de 2019                111 
Grupo  ID Campo  Descripción  Nodo 
Padre  Tipo 
Dato  Longitud  Ocurrencia  Observaciones  
J J003  dInfAdic  Información adicional de 
interés para el emisor  J001  A 1-5000  0-1 Campo de información de interés 
exclusivo del emisor para aclaraciones 
a sus clientes.  
Este campo NO debe ser enviado para 
al SIFEN. Puede formar parte del DE o 
KuDE e nviado al receptor, pero NO 
formará parte del DTE  
 
 
 
 
 