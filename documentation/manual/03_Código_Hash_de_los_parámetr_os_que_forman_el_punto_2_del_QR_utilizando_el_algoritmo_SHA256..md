# 03 Código Hash de los parámetr os que forman el punto 2 del QR utilizando el algoritmo SHA256.

3. Código Hash de los parámetr os que forman el punto 2 del QR utilizando el algoritmo SHA256.  
 
A continuación, se muestra un cuadro descriptivo  para mejor comprensió n. 
 
Parámetro  Descripción  Incluido 
en el DE  ID Cam po Longitud 
máxima  Incluir en 
el Hash 
del QR  Incluir en 
la URL 
del QR  
nVersion  Versión de la 
generación del 
QR Sí AA002  3 Sí Sí 
Id CDC del 
correspondiente 
DE Sí A002  44 Sí Sí 
dFeEmiDE  Fecha y hora de 
emisión del DE  Sí D002  19 Sí Sí 
dRucRec/dNumIDRec  Identificación del 
receptor o 
cliente  Sí D206 o 
D210  20 Sí (*) 
dTotGralO pe Total general de 
la operación  Sí F014  23 Sí (*) 
dTotIVA  Liquidación total 
del IVA  Sí F017  23 Sí (*) 
cItems  Cantidad de 
items en el DE  No Cuenta 
sobre el 
campo 
E701  3 Sí (*) 
Digest Value  Hash de la firma 
digital del DE  Sí XS17  - Sí Sí 
IdCSC  Identifica dor del 
código entregado 
por el SIFEN  No - 4 Sí Sí 
cHashQR  Código Hash de 
los parámetros  No - - No Sí 
 
(*) En caso de que estos campos no contengan valor completar con un “0”  
13.8.3.  Metodolo gía para la generación del Código QR  
 
• Los siguientes campos deben ser c onvertidos a su equivalente hexadecimal  
o Fecha de Emisión  
o DigestValue de la Firma Digital  
• El valor de todos los parámetros identificados en el cuadro precedente, deben ser 
concatenados y  aplicar el algoritmo SHA -256, para determinar el Código Hash  
 
 
 
septiembre  de 2019                207 
• El valor Hash del QR, debe estar en hexadecimal.  
Ejemplo:  
Parámetro  Contenido - Ejemplo  Equivalente Hexadecimal  
nVersion  150 No 
Id 0144444401700100100145282201701251587326
0988  No 
dFeEmiDE  2017-01-25T09:35:17  323031372d30312d32355430393a33353a3137  
dRucRec /dId
enRec 88899990  No 
dTotOpe  300000  No 
dTotIVA  27272  No 
cItems  2 No 
DigestValue  yzGYhUx1/XYYzksWB+fPR3Qc50c=  797a4759685578312f5859597a6b7357422b6650
523351633530633d  
IdcSC  0001  No 
CSC ABCD0000000000000000000000000000  No 
  
13.8.4.  Ejemplo de generación del Código QR 
 
13.8.4.1.  Paso 1 - Concatenar los datos:  
 
nVersion= 150&Id=0144444401700100100145282201701251587326098
8&dFeEmiDE= 323031372d30312d32355430393a33353a3137& dRucRec
=88899990& dTotGralOpe= 300000& dTot IVA= 27272& cItems= 2&DigestV
alue= 797a4759685578312f5859597a6b7357422b6650 523351633530633
d&IdCSC= 0001  
 
Si no se informa n cual quiera de los siguientes campos:  dTotGralOpe, dTotIVA  se debe completar 
con 0 (cero) . 
 
13.8.4.2.  Paso 2 – Concatenar al final de los datos, del  paso 1, el Código Secreto del 
Contribuyente:  
 
nVersion= 150&Id=01444444 01700100100145282201701251587326098
8&dFeEmiDE= 323031372d30312d32355430393a33353a3137& dRucRec
=88899990& dTotGralOpe= 300000& dTotIVA= 27272& cItems= 2&DigestV
alue= 797a4759685578312f5859597a6b7 357422b6650523351633530633
d&IdCSC= 0001 ABCD000000000000000000000 0000000  
 
 
 
 
septiembre  de 2019                208 
En este ejemplo el código secreto del contribuyente es el correspondiente al IdCSC = 0001. Si el 
contribuyente tiene más de un código secreto activo, deberá especificar el IdCSC corre spondiente 
al código que utilizará.  
El código de seguridad solo se util iza para generar el código hash que luego será concatenado a los 
datos del paso 1. Por ningún motivo el contribuyente debe compartir su código de seguridad, ni 
enviar concatenado como p arte de la URL del código QR.  
13.8.4.3.  Paso 3 – Generar el  Hash con los datos de l paso 2:  
 
Para la generación del código Hash se toman los datos generados en el Paso 2 y se le aplica 
el algoritmo SHA -256, el cual debe devolver un valor en codificación hexadecimal.  
 
97ddbb3c1e7d65af03a70ffe21f2b34846ab1c89e0566c35222086766b7374ed  
 
13.8.4.4.  Paso 4 – Generar la URL para la imagen QR:  
La URL final que será utilizada para generar la imagen QR es el resultado de la concatenación 
siguiente:  
URL QR  = URL Consulta QR + D atos del Pas o 1 + Hash generado en el paso 3  
Donde,  
URL Consulta QR:  
Ambiente de Pr oducción:     https://www.ekuatia.set.gov.py/consultas/qr ? 
Ambiente de Test :    https://www.ekuatia.set.gov.py/consultas -test/q r? 
 
Datos del Paso 1:  
nVersion= 142& Id=01444444017001001001452822017012515873260988& dFeEmiDE
=323031372d30312d32355430393a33353a3137& dRucRec= 88899990& dTotGralOpe=
300000& dTotIVA= 27272& cItems= 2&DigestValue= 797a4759685578312f5859597a6b7
357422b6650523351633530 633d& IdCSC= 0001  
 
Hash g enerado en el paso 3 (con su nombre de parámetro) : 
cHashQR= 97ddbb3c1e7d65af03a70ffe21f2b34846ab1c89e0566c35222086766b7374e
d 
 
URL QR:  
https://ekuatia.set.gov.py/ consultas/qr?nVersion=1 50&Id=014444440170010010014528
220170125158732609 88&dFeEmiDE=323031372d30312d32355430393a33353a3137&
 
 
 
septiembre  de 2019                209 
dRucRec=88899990&dTotGralOpe=300000&dTotIVA=27272&cItems=2&DigestValue=7
97a4759685578312f5859597a6b7357422b6650523351633530633d&IdCSC= 0001&cHa
shQR= 97ddbb3c1e7d 65af03a70ffe21f2b34846ab1c89e0566c35222086766b 7374ed  
 
 
Imagen QR:  
 
13.8.4.5.  Paso 5 – Insertar la URL del paso 4 en el XML:  
 
Antes de la inserción de la URL  en el XML , se deberá reemplazar los símbolos  “&” por su equivalente 
en código html , el cual es “ &amp; ”. 
De esta manera la URL que se debe insertar en el XML, como valor del elemento  <dCarQR> queda 
como sigue:  
 
https://ekuatia.set.gov.py/consultas/qr?nVersion=1 50&amp; Id=01444444017001001001
452822017012515873260988 &amp; dFeEmiDE=323031372d 30312d32355430393a333
53a3137 &amp; dRucRec=88899990 &amp; dTotGralOpe=30000 0&amp; dTotIVA=27272
&amp; cItems=2 &amp; DigestValue=797a4759685578312f5859597a6b7357422b66505
23351633530633d &amp; IdCSC=0001 &amp; cHashQR= 97ddbb3c1e7d65af03a70ffe21f
2b34846ab1c89e0566c352220 86766b7374ed  
 
 
13.8.5.  Mensajes desplegados en consulta del QR  
 
a) El DTE existe en el SIFEN con situación Aprobado o Aprobado con observaciones 
(Extemporáneo ) – se presenta el KuDE en Cinta (para B2C) o consulta por pestañas (B2B o 
B2G)  
 
b) El DE no existe en el SIFEN   
 
 
 
septiembre  de 2019                210 
CDC no existen te en el SIFEN , consulte  con el emisor del documento.  
• Número del DTE: 001 -001-00145282  
• Tipo: Factura Electrónica  
• Emisor: Empresa X – Emisor electrónico  
• RUC Emisor: 44444401 -7 
• Fecha de emisión: 25/ 01/201 8 09:35:30  
• Cantidad de ítems: 2  
• Monto Total: 300.000  
• Monto  Total IVA: 27272.00  
 
c) El QR no es vá lido 
Código QR inválido, consulte con el emisor del DE. 