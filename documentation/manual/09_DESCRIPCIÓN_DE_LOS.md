# 09 DESCRIPCIÓN DE LOS

9. DESCRIPCIÓN DE LOS 
SERVICIOS WEB DEL SIFEN  * Se eliminó el ambiente y la versión del formato de los Web Services.  
* Se modifica la versión d e los Sc hemas de 100 a 140.  
* El proceso síncrono ahora devue lve un número de transacción . 
El proceso asíncrono en su respuesta contiene un número de lote  
(denominado Número del protocolo de autorización anteriormente)  
* Se agrega el Web service de consult a de RUC  siConsRUC y el Web 
service consulta DE destinadas si ConsDEST  
10.1. Estructura del código 
de control (CDC) de los DE  Se modifica la estructura del CDC, ahora se diferencian el RUC del 
emisor y su Dígito verificador.  
TABLA DE FORMATO DE 
CAMPOS DE UN 
DOCU MENTO 
ELECTRONICO (DE)  Se introdujeron varios cambios  en los grupos, no entramos a detallarlos 
en esta sección para contribuir a la legibilidad, sin embargo, esos 
cambios se reflejan en esta versión del Manual Técnico mediante los 
siguient es colores.  
Amar illo = modificaciones  
Verde  = adición de campos  
11 Gestión de eventos  Se agrega una tabla resumen de tipo de evento según el actor.  
Se agrega las estructuras correspondientes a los eventos de 
Cancelación e Inutilización.  
Se agregan las v alidaciones a rea lizarse sobre los eventos de 
Cancelación e Inutilizac ión 
13.7 Código bidimensional 
(QR)  
 Se elimina el ambiente de generación  
 
 
 
 
 
 
 
 
 
septiembre  de 2019                12 
Versión: 141  
Fecha de modificación: 21/09/2018  
Ubicación - capítulo  Descripción de las modificaciones  
6.2.1 Plazos SIFEN  Se introducen cambios en la tabla de plazos  
7.2 Está ndar del formato 
XML  7.2.2 Declaración namespace , se cambia la url del namespace  
 7.2.2.1 Particularidad de la firma digital , cambio del ejemplo  
 7.2.2.2 Particularidad del envío de lote,  cambio del ej emplo  
 7.2.3 Convenciones referenciadas en tablas,  mejor especificación del 
tipo de dato fecha y se agregó el tipo de dato Binario  
7.4 Estándar de 
comunicación  Se modificaron el Request y el Response de ejemplo  
7.6 Estándar de firma digital  Modificacion es en el Schema XML 1.  
7.10 Resumen de las 
Direcci ones Electrónicas de 
los Servicios Web para 
Ambientes de Pruebas y 
Producción  Se agregó la tabla resumen con las urls.  
8 ASPECTOS 
TECNOLÓGICOS DE LOS 
SERVICIOS WEB DEL SIFEN  Se elimina la sección 8.4 Info rmación de control y área de datos de los 
mensajes  
9 DESCRIPCIÓN de los 
Servicios Web del SIFEN  * Modificaciones en los siguientes schemas: Schema XML 4, Schema 
XML 5, Schema XML 6, Schema XML 7, Schema XML 8, Schema XML 16, 
Schema XML 17  
 * Se agregó el Schema XML 5A  
TABLA DE FORMATO DE 
CAMPOS DE UN 
DOC UMENTO 
ELECTRONICO (DE)  Se introdujeron varios cambios en los grupos, no entramos a detallarlos 
en esta sección para contribuir a la legibilidad, sin embargo, esos 
cambios se reflejan en esta versión del M anual Técnico mediante los 
siguientes colores.  
Amari llo = modificaciones  
Verde  = adición de campos  
11 Gestión de eventos  Modificaciones en las validaciones a realizarse sobre los eventos de 
Cancelación e Inutilización  
13.8 Código bidimensional 
(QR)  Se modifica el Código de Seguridad (CSC) a 32 dígit os al fanuméricos.  
 
Versión: 1 50 
Fecha de modificación: 10/09/2019  
Ubicación - capítulo  Descripción de las modificaciones  
Se realizó la actualización de la numeración de los capítulos , estilos y formatos par a mejor 
organización de los índices.  
4.1. Estructura  y 
subsistemas SIFEN  Actualización de la gráfica Nº 2  
4.2. Fundamento Legal  Se agregó la resolución general reglamentaria  
6.2.1 Plazos SIFEN  Se introducen plazos para eventos en la tabla  
 
 
 
septiembre  de 2019                13 
7.10 Resumen de las 
Direcciones Electrónicas de 
los Servicios Web para 
Ambientes de Pruebas y 
Producción  Se actualizan la s URLs para los ambientes de Producción y Test  
7.4. Estándar de 
comunicación  Se corrige el campo  donde se incluye el mensaje XML a cualquiera de 
los Servicios Web del SIFEN.  El campo actualizado es  soap:Body  
9 DESCRIPCIÓN de los 
Servicios Web del SIFEN  * Modificaciones en los siguientes schemas: Schema XML 4, Schema 
XML 6, Schema XML 8, Schema XML 1 4, Schema XML 17  
TABLA DE FORMATO DE 
CAMPOS DE UN  
DOCUMENTO 
ELECTRONICO (DE)  Se introdujeron varios ca mbios, ya que desde esta versión del sistema 
se puede recibir y gestionar los siguientes DEs: Autofactura electrónica 
y Nota de Remisión electrónica. Los  cambios se reflejan en esta versión 
del Manual Té cnico mediante los siguientes colores.  
Amarillo = mod ificaciones  
Verde = adición de campos  
Rojo = eliminación  
Además,  se eliminaron las citas que se hacían hacia los tipos de 
documentos: Factura electrónic a de exportación, Factura electrónica 
de importaci ón y Comprobante de retención electrónico .  
Se elimin ó la estructura relacionada a ISC  
10.5 Manejo del timbrado y 
Numeración  Explicación del uso de serie  
11 Gestión de eventos  El evento de anulación ahora se denomina Devolución y Ajuste de 
precios  
 Se introdujeron eventos que realizarán los receptores: Conformidad y 
Disconformidad con el DTE, Desconocimiento con el DE o DTE y 
Notificación de recepción de un DE o DTE  
 Cambios en la Tabla J:  Resumen de los eventos de SIFEN según los 
actores  
 Se agrega la Tabla K: Correcciones de los eventos del Receptor en el 
SIFEN  
 Se agregan las estructuras que se utilizarán para los servicios de 
eventos del receptor  
 Se agregan los esquemas para los nuevos eventos automáticos  y para 
el evento de actualización de d atos del transporte  
12.2.2. Validación de la 
estruct ura XML de los WS  La versión del DE se informa en el campo de versión dentro del grupo 
rDE 
 Se elimina el ejemplo del elemento soap12:Header  
12.2.3 Validación de forma 
del área de datos del 
Request  Se eliminan los mensajes con códi go desde 0100 hasta el 0107  
12.2.4 Validación del 
certificado de firma  Se eliminan los mensajes con código desde el 0123 hasta el 0126  
12.2.5 Validación de la 
firma  La validación con código 0141 se encarga de controlar los c asos que se 
contemplaban en las validaciones con códi go 0123 al 0126  
12.4 Validaciones del 
formato  Se introdujeron cambios en las validac iones sobre el formato, puesto 
que se han agregado los siguientes DE: Autofactura electrónica y 
Notificación de recepc ión electrónica . 
Se eliminaron las validaciones corre spondientes al ISC, así como las 
validaciones que se estimaban se realizarían  en el futuro.  