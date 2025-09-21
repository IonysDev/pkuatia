# 08 Aspectos Tecnológicos de los Servicios We b del SIFEN

8. Aspectos Tecnológicos de los Servicios We b del SIFEN  
 
Los contribuyentes con naturaleza de emisores electrónicos realizarán el envío de sus DE, utilizando los 
Servicios Web que el SIFEN pondrá a disposición de manera a operar máquina a máquina sin intervención del 
usuario . 
 
Para ello el sistema d e los contribuyentes afectados, en adelante, clientes del servicio, deberán tener las 
siguientes consideraciones:  
• Pose er conexión a Internet de banda ancha.  
• Para el envío de los DE deberán desarrollar el  software cliente según lo enmarcado en el presente 
documento, independientemente al lenguaje de programación utilizado.  
• El lenguaje de intercambio de información utilizad o será el XML.  
• Para garantizar la comunicación segura, el software cliente deberá aut enticarse ante el SIFEN 
utilizando su certificado y f irma digital.   
 
El SIFEN dispondrá los siguientes s ervicios a ser consumidos por los clientes:  
• Síncronos:  
o Recepción DE  
o Recepción evento  
o Consulta DE  
o Consulta RUC  
o Consulta DE  destinado s (Futuro)  
o Consulta D TE a entidades u organismos externos autorizados (a Futuro)  
 
• Asíncronos:  
o Recepción lote DE  
o Consulta resultado lote 
  
8.1. Servicio síncrono  
 
La llamada (Request) del servidor del cliente a los servicios síncronos es procesado de forma inmediata por el 
servidor del SIFEN y la respuesta (Response) se realiza en la misma conexión.  
 
8.1.1.  Flujo funcional:  
 
a) El software cliente realiza la conexión enviand o la solicitud (Request) al servicio del SIFEN.  
b) El WS SIFEN recibe el Request y llama al software encargado del procesam iento del DE.  
c) Éste, al culminar el proceso devuelve e l resultado al WS SIFEN.  
d) El WS SIFEN responde al cliente.  
e) El software cliente, al o btener la respuesta, cierra la conexión.   
 
 
 
septiembre  de 2019                43 
8.2. Servicio asíncrono  
 
La llamada (Request) del servidor del cliente es procesad a de la siguiente manera:  
 
8.2.1.  Secuencia del servicio asíncrono:  
 
a) El Cliente realiza la conexión realizando un Request al WS SIFEN.  
b) El WS SIFEN recibe la solicitud y responde con un mensaje de aprobación o rechazo, según las primeras 
validaciones.  Esta respues ta contiene:  
a. Identificador de respuesta. (IdResp)  
b. Situación (Aprobación o Rechazo).  
c. Fecha y hora de recepción del mensaje.  
d. Tiempo promedio de procesamiento, expresado en segundos.  
c) El software cliente, al obtener el Response, cierra la conexión.  
d) El procesam iento de los DE será realizado de manera posterior a esta conexión.  
 
8.2.2.  Tiempo promedio de procesamiento de un lote:  
 
El tiemp o de procesamiento en SIFEN para la validación de un DE es una información esencial del rendimiento 
del sistema. Esta información est á asociada directamente al procesamiento asincrónico de lotes de DE. En la 
respuesta de procesamiento de un lote, una de la s informaciones que se proporcionará será, justamente, el 
tiempo promedio de procesamiento de un DE en los últimos 5 minutos.  
Este t iempo promedio de procesamiento tendrá como unidad de  medida milisegundos .  
Para el cálculo del tiempo promedio de procesam iento se debe realizar la diferencia aritmética de tiempos de 
procesamiento de los DE en los últimos 5 minutos, calculado como difere ncia entre las fechas (considerando 
día, mes, año, ho ra, minuto y segundo) de recepción de los lotes en SIFEN y sus fechas de procesamiento de 
las respuestas de los lotes procesados (considerando día, mes, año, hora, minuto y segundo).  
Este mismo tiempo p romedio de procesamiento de DE estará disponible en e l Portal e -Kuatia en el servicio de 
semáforo de monitoreo de los WS.  
Siempre que el tiempo calculado sea inferior a un segundo , la aplicación contestará como valor un segundo 
de tiempo promedio.  
Para los  cálculos que arrojen cifras superiores a un segundo,  se presentará:  
• En los casos que los decimales sean inferiores a 500 m s, el valor entero se redondeará por debajo.  
• En caso de que los decimales sean superiores a 500 ms, el valor entero se redondeará por  encima.  
Los contribuyentes (clientes) deberán consi derar este promedio de tiempo, antes de consumir el servicio de 
consul ta de procesamiento  y para la decisión del inicio del uso de la contingencia.  
 
 
 
 
septiembre  de 2019                44 
8.3. Estándar de mensajes de los servicios del SIFEN  
 
La so licitud de consumo de los servicios dispuestos por el  SIFEN debe seguir el estándar:  
• Área de datos: Esquema XML definido para cada WS.  
 
8.4. Versión de los Schemas XML  
 
Las modificaciones de los Schemas correspondientes a los servicios del SIFEN, pueden origina rse como 
necesidades técnicas, cambios normativos o d e funcionalidad.  
Estos cambios no serán aplicados de forma frecuente, considerando siempre el tiempo necesario para la 
adecuación de los sistemas de los contribuyentes afectados.  
Los mensajes recepcionad os en una versión desactualizada serán rechazados esp ecificando el error de versión.  
Toda actualización de forma to de los WS del SIFEN será correctamente respaldada por la actualización de su 
correspondiente Schema.  
8.4.1.  Identificación de la versión de los Sche mas XML  
 
La versión del Schema de los DE es identific ada en el nombre del archivo correspondiente, con el número  
antecedido por los caracteres “_ v”. 
El nombre del Schema XML de la factura electrónica, versión 150 es: FE_v 150.xsd 
8.4.2.  Liberación de versiones  de los Schemas XML  
 
Los Schemas utilizados  por el SIFEN serán reglamentados y publicados en la dirección 
“http://ekuatia.set.gov.py/sifen/x sd”. 
Las actualizacio nes de Schemas estarán publicada s en forma comprimida y contendrá el conjunto de Schemas 
utilizados para la generación de los DE y consumo de WS, si correspondiera.  
Este Schema tend rá la misma versión que el DE equivalente. Los archiv os comprimidos serán nominados de la 
siguient e manera “ PS_FE_150.zip”, donde las primeras dos letras son constantes, las siguientes corresponden 
al tipo de DE, seguido de la versión a la cual corres ponde , en el ejemplo, versión 150.  
Los archivos correspon dientes a Schemas XML, se distinguen por la e xtensión .xsd 
Según lo descripto, el archivo correspondiente al Schem a XML de la r ecepción de l DE de la versión 150 es: 
SiRecepDE_v 150.xsd 
 
8.4.3.  Paquete inicial de  Schemas  
 
Al momento de la publicación de la versión oficial del presente Manual Técnico, también se disponibilizará el 
paquete de Schemas afectados inicialmente.  
 
 
 
 
septiembre  de 2019                45 