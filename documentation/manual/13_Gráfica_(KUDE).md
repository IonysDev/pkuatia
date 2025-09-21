# 13 Gráfica (KUDE)

13. Gráfica (KUDE)  
Este capítulo contempla los requis itos mínimos que deben observar y cumplir los facturadores 
electrónicos para estructurar las representaciones gráficas.  
 
13.1. Definición y alcance del KuDE:  
 
Se entiende por representación g ráfica al contenido de un DE (KuDE), la cual puede ser entregada 
al rec eptor no electrónico o consumidor final en formato físico o digitalizado. Es un documento 
tributario auxiliar que expresa de manera simplificada una transacción que ha sido respaldada p or 
un DE. Cabe señalar que su naturaleza simplificada obedece a que el KuDE cont iene sólo algunos 
campos representativos del DE.  
El KuDE tiene como propósitos, los siguientes:  
• Constituirse en el documento tributario físico de una transacción respaldada por  un DE 
emitido por facturador electrónico, a un receptor no electrónico  o consum idor final.  
• Amparar el traslado de las mercaderías entre los locales del emisor o entre las instalaciones 
de este y el receptor comprador.  
• Constituirse en el documento tributa rio físico que respalda o soporta los créditos fiscales 
del receptor qu e no es f acturador electrónico de SIFEN. Cabe señalar que el receptor se 
obliga a consultar y/o comprobar la existencia del DTE en SIFEN, tomando en consideración 
algunos campos present es en el cuerpo del KuDE como criterios de consulta.  
 
13.2. Características y  funciona lidades  
 
Entre las características y funcionalidades del KuDE, se encuentran las siguientes:  
• KuDE posibilita la consulta pública del DTE en la página web de SIFEN con el llenad o de la 
información impresa del CDC o con la lectura del QR Code impres o. 
• La gen eración del KuDE cuando se trata del facturador electrónico debe ser realizada 
directamente en los sistemas de facturación, y en la base de datos oficial del SIFEN. 
Igualmente puede ser consultada mediante la solución gratuita provista por este si stema.  
• No puede existir información en el KuDE que no forme parte del formato del DE firmado  
(XML) , salvo las que se mencionen en el presente capítulo.  
• La duración del papel del KuDE as í como su impresión y legibilidad debe ser de un plazo no 
menor a seis (6) meses .  
 
13.3. Denominación de los KuDE  
 
Cada documento electrónico deberá tener la denominación según corresponda a su tipo , conforme 
a los enunciados citados a continuación:  
 
 
 
septiembre  de 2019                194 
• KuDE de Fac tura Electrónica   
• KuDE de Factura de Exportación Electrónica  
• KuDE de F actura de  Importación Electrónica  
• KuDE de Autofactura Electrónica  
• KuDE de Nota de Débito Electrónica  
• KuDE de Nota de Crédito Electrónica  
• KuDE de Nota de Remisión Electrónica  
 
La repr esentación gráfica de cada documento electrónico puede contar con una o  varias páginas 
enumeradas. Debiendo indicar para el caso de varias páginas el número de la página en relación con 
el total. Ejemplo: 2/5 . Para el caso de los subtotales o totales debe indicarlos en la última página  y 
el código QR debe ser impreso, al meno s, en la primera página.  
 
13.4. Estructura del KuDE  
 
Independiente del formato, el KuDE estará compuesto por la siguiente estructura:  
• Campos del encabezado.  
• Campos que describen los ítems de  la operación, los precios, descuentos y valor total por 
ítem e impuest os. 
• Campos subtotales y totales de la transacción documentada, totales de liquidación de IVA , 
total en guaraníes . 
• Campos de información propia de la consulta en SIFEN de la SET.  
• Código QR.  
  
 
 
 
septiembre  de 2019                195 
13.4.1.  Campos del encabezado del KuDE  
 
En esta sección de la estructura  del KuDE se encuentran los siguientes campos:  
Espacio reservado para 
el logo del emisor 
(opcional)  Datos del emisor : 
Nombre o razón social del emisor: D105  
Nombre fantasía: D106  
Descr ipción de actividad: D131 
Dirección: D107  
Descripción ciudad: D116  Dato s de timbrado : 
RUC del emisor: D101  
Timbrado Nº: C004  
Fecha de inicio de vigencia: C008  
Fecha de fin de vigencia: C009  
Número de documento: C007  
Datos generales : 
Fecha y hora de emisión : D002  
Descripción de condic ión de la oper ación: E602  
Número de cuotas:  E644 (Para operaciones a crédito)  
Descripción de moneda de la operación: D016  
Tipo de cambio: D018  
Datos del receptor : 
RUC del contribuyente: D20 6 (si D201=1)  
Nº de Doc de Identidad: D210 (si D201=2)  
Nombre/razón social: D211  
Dirección: D213  
Teléfono: D2 14 
Correo electrónico: D216  
Descripción del tipo de transacción: D012  
 
Ejemplo de encabezado de KuDE de FE : 
 
 
 
 
 
Fecha y hora de Emisión : 
AAAA -MM-DDThh:mm:ss  Condición de Vent a:   Contado             Crédito             
Cuotas:  Moneda:  PYG  Tipo de Cambio:  
RUC/Documento de Identidad Nº : 1131421 -4 
Nombre o Razón Social : Belén Bosco   
Dirección: Mcal. López y Yegros  
Teléfono : 021 123 456  Correo Electrónico:  belbosco @gmail.com  
Tipo de Operación: Venta de Mercadería   
 
  Marta Anahi Bordon Vidal  
Soluciones Inform áticas  
Reparaci ón de Equipos Inform áticos  
Avenida Gonz ález Vidal #1434  
Ciudad: Asunci ón 
 LOGO  KuDE  DE FACTURA ELECTRÓNICA  
X 
Encabezado  RUC: 2365438 -8 
Timbrado N º 1000332  
Fecha de  Inicio de Vigencia: 01/07/2018  
Fecha de Fin de Vigencia: 31/07/2019  
Factura Electr ónica N º 001-001-0000001  
 
Ciudad : Asunci ón 
 
 
 
 
septiembre  de 2019                196 
13.4.2.  Campos que describen los í tems de la operación del KuDE  
 
En esta sección de la estructura del KuDE se encuentran los siguientes campos:  
Código 
del 
ítem Descrip ción 
del producto 
y/o servicio  Descripción 
de la 
unidad de 
medida   Cantidad  Precio 
unitario  Descuent
o del 
producto 
por íte m  Descripción 
de la forma 
de 
afectación 
tributaria 
del IVA  Descripción 
de la forma 
de 
afectación 
tributaria 
del IVA  Descripción 
de la forma 
de 
afectación 
tributaria 
del IVA  
Campo  
E701 -
E707  Campo E708  Campo 
E710  Campo 
E711  Campo 
E721  Campo 
EA002  Campo 
E732 (0%)  Campo 
E732 (5%)  Campo 
E732 (10%)  
 
Ejemplo de ítems operación de KuDE (FE)  
Art 
Cod Descripción  Unidad de 
medida  Cantidad  Precio 
Unitario  Descuento  Valor de Venta  
Exentas  5% 10% 
INF012  Disco duro  UNI 1 110.000   0 0 110.000  
         
         
 
13.4.3.  Campos que describen los subtotales y totales de la transacción documentada y 
liquidación de IVA  
 
En esta sección de la estructura del KuDE se encuentran los siguientes campos:  
 Exentas  5% 10% 
Subtotal  Campo F002  Campo F004  Campo F005  
Total de la o peración:  Campo F007  
Total en Guaraníes  Campo F022  
Liquidación IVA:  
(5%): Campo F014  
(10%): Campo F015  
Total de IVA: Campo F016  
 
 Ejemplo de subtotales y totales de KuDE (FE) 
 
13.4.4.  Campos de información propia de la consulta en SIFEN de la SET  
 
Los campos de Información propios de la consulta en  SIFEN  
• En el portal ingresar en Servicios y consultas  SUBTOTAL :   110.000  
TOTAL A PAGAR : 110.000  
TOTAL EN  GUARANIES  110.000  
LIQUIDACIÓN IVA : (5%)                   (10%)  10.00 0 TOTAL IVA : 10.000  Datos  
Operación  
Subtotales  
Y totales  
 
 
 
septiembre  de 2019                197 
o Producción: https://ekuatia.set.gov.py/consultas/   
o Test: https://ekuatia.set.gov.py/consul tas-test/  
• CDC en once grupos de 4 posiciones.  
En esta sección de l a estructura del KuDE se encuentran los siguientes campos:  
 
Información de consulta en SIFEN  
 
  
Ver información del QR,  
delineamientos, conformación 
y validación del QR  
 
13.4.5.  Información ad icional de interés para el emisor  
 
Este es un espacio libre de utilizac ión del emisor facturador electrónico con referencia a información 
de los demás campos del DE, información comercial promocional o mensajes personalizados al 
receptor: Campo J003.  Esta información no debe ser enviada en  el archivo XML a SIFEN . 
No puede existir información propia de la operación que haya sido generada en el archivo 
electrónico firmado digitalmente.  
 
13.5. KuDE   
 
Los contribuyentes podrán util izar para la representación gráfica en e l KuDE cualquier formato y 
tamaño de p apel estándar  que se ajuste a sus necesidades . Las gráficas siguientes muestran 
modelos referenciales de KuDE para cada tipo de documento electrónico , sin embargo, cada 
contribuy ente puede incluir otros c ampos presentes en el formato XML . Los campos  obligatorios ,  
que se d eben mostrar , son l os que están especificados por la s reglamentaci ones emitida s por la 
Administración Tributaria ,  
• Factura Electrónica  (FE): Gráfica N° 09 
• Nota de Crédito Electrónica  (NCE) : Grafica N° 10  
• Nota de Débito Electrónica  (NDE) : Gráfica N° 11  
• Auto factura Electrónica  (AFE) : Gráfica N° 12  
• Nota de Remisión Electrónica  (NRE) : Gráfica N° 13  
 
 
 
septiembre  de 2019                198 
 
Gráfica Nº 09 – KuDE  FE Formato 1 convencional  
 
 
 
septiembre  de 2019                199 
 
Gráfica Nº 10 – KuDE NC E Formato 1 convencional  
 
 
 
septiembre  de 2019                200 
 
Gráfica Nº 11 – KuDE ND E Formato 1 convencional  
 
 
 
septiembre  de 2019                201 
 
Gráfica Nº 12 – KuDE AF E Formato 1 convencional  
 
 
 
septiembre  de 2019                202 
 
Gráfica Nº 13 – KuDE NR E Formato 1 convencional  
 
 
 
septiembre  de 2019                203 
13.6. KuDE (cinta de papel)  
El formato de cinta de papel se constituye en el más adecuado para ventas al consumidor final 
(como supermercados, farmacias, restaurantes, estaciones  de servicio, etc.)  
 
Gráfica  Nº 14 – KuDE  FE Formato 2 (cinta de papel)  
 
 
 
septiembre  de 2019                204 
13.7. Cinta papel resumen del KuDE  
 
Si el consumidor pide se permite la impresión de un KuDE resumen que no trae el de talle de los 
ítems de las mercaderías y el detalle del impuesto, solo c on la información de la cantidad Total de 
ítems y monto total. En la consulta pública del portal e -Kuatia por el CDC o en la consulta pública 
por QR Code, el consumidor podrá impri mir e l KuDE completo con los detalles de ítems y el 
impuesto.  
 
Gráfica Nº 15 – Cinta papel resumen del KuDE  
 
 
 
 
 
 
septiembre  de 2019                205 
13.8. Código bidimensional (QR)  
 
13.8.1.  Delineamientos del QR Code  
   
La imagen impresa del QR debe tener mínimamente 25 mm (veinticinco milímetros) de ancho, de  
los cuales, 22 mm son para el contenido y 3 mm de margen seguro (quiet  zone).  Queda a criterio 
del emisor si desea un tamaño mayor, en tal caso, el margen seguro debe ser el 10% del ancho total.  
El contenido de este código es carg ado en el campo J002  del archivo de DE correspondiente.  
El código QR que será impreso en el KUD E, obedece al estándar internacional ISO/IEC 18004.  
Para la generación del QR Code es necesario que previamente el contribuyente sea un facturador 
electrónico au torizado por la SET y qu e haya obtenido de la Administración Tributaria, el Código de 
Seguridad  (CSC).  
Este código estará compuesto de 32 dígitos alfanuméricos , es generado por el SIFEN  y entregado al 
facturador electrónico al momento de su ingreso. S irve para garantizar la segu ridad y autoría del 
QR. Este código es de conocimiento exclusivo de la Administración Tri butaria y del  contribuyente, 
permitiéndose  hasta dos códigos de seguridad en estado  activ o.  
 
13.8.2.  Conformación del Código QR  
 
Este código está form ado por un conjunto de i nformación adicional a fin de asegurar la autoría de 
un documento elect rónico, que puede no haber sido transmitido al SIFEN.  
 
Esta imagen contendrá:  