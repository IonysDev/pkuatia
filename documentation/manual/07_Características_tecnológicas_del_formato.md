# 07 Características tecnológicas del formato

7. Características tecnológicas del formato  
 
En este capítulo  se aborda n las características tecnológicas  de la facturación electrónica, qu e involucran la 
utiliz ación de c ertificados digitales, el lenguaje utilizad o para  el intercambio de información, XML o lenguaje 
de marcado o extensible1, juntamente con  los Servicios Web, esenciales para el intercambio seguro de los DE.  
Tambi én se identifican los Servicios Web contemplados en  el modelo conceptual de comunicación , se 
establecen  las definiciones acerca de la utilización del XML, así como los estándares de comunicación entre el 
SIFEN y los sistemas de los contribuyentes.   
 
7.1. Model o conceptual de comunicación  
 
El SIF EN, disponibilizará los siguientes S ervicios Web:  
• Recepción de DE  
• Recepción lotes de DE 
• Consulta resultado lote 
• Recepción evento  
• Consulta DE 
• Consulta RUC  (por demanda)  
• Consulta DE a entidades u organismos externos autorizados (a f uturo)  
Cada s ervicio se en cuentra respaldado por un Servicio Web específico. El modelo de comunicación e 
interoperabilidad  siempre iniciar á en el s istema del contribuyente  (sea de manera directa o prestado por un 
tercero) , por medi o del consumo del servicio correspondiente.  Ver grá fica N º 05 
 
 
Gráfica  Nº 05: Flujo de comunicación  
 
 
1 https://es.wikipedia.org/wi ki/Extensible_Markup_Language  
FLUJO DE COMUNICACIÓN
Cliente Sistema de FE
Sistema de FE
Facturas
Servicios 
Sincrónicos
Facturas
Electrónicas
SIFEN
Servicios 
AsincrónicosTransacciones
https
Flujo de la 
ComunicaciónSET Contribuyente 
 
 
 
septiembre  de 2019                29 
Existen dos tipos de procesamiento de Servicios Web:  
Síncronos : Se consideran a aquellos en los cuales el procesamiento y respuesta del s ervicio se realizan en la 
misma conexión de consumo. Ver gráfica Nº  06. 
 
 
 
 
 
 
 
 
 
 
 
Gráfica  Nº 06: WS Sincrónico  
 
Asíncr onos:  Son aquellos en los cuales  el resultado del procesamiento del s ervicio requerido no es entregado 
en la misma conexión de la solicitud de consumo  (Ver gráfica Nº 07) . Consta  de un mensaje  y un númer o de 
lote descriptos a continuación:  
• Un mensaje con u n recibo (ticket)  que confirma que el archivo remi tido ha superado las primeras 
validaciones  y se ha recepcionado  el lote , y  
• El número de lote, incluido en esta respuesta, con el cual el c liente (sistem a del contribuyente) podrá 
consultar el resultado del  procesamiento, consumiendo el Web Service correspondiente, en otra 
conexión .  
 
Gráfica  Nº 07: WS Asincrónico  
 
Web Service
1 a 1
Sistema de 
Información FE
Contribuyente
Sincrónico
SIFEN
Sistema de Recepción y 
Procesamiento
5Recibe mensaje desolicitud
Direcciona alsistema de
recepción yprocesamiento
2
Realiza procesamiento
Devuelve msjresultado al WS 
3
4Recibe mensaje conresultado
Direcciona alSistema del
Contribuyente
1Establece conexión
Envía mensaje de
solicitud
Recibe Respuesta
Termina conexión
 
 
 
septiembre  de 2019                30 
7.2. Estándar del formato XML  
 
El formato de documentos y protocolos de servicios, utilizan el l enguaje de marcas expansible (XML – 
Expansible Markup  Language). La definición de cada archivo X ML sigue un estándar denominado “Schema 
XML”, o lenguaje de esquema, utilizado para describir la estructura y restricciones de los documentos XML2 . 
Esta estruc tura reside en un archivo con extensión “.xsd” (XML S chema Definition), el que establece qué 
elementos contendrá el documento, como están organizados, cuáles son los atributos y de qué tipo deben ser 
estos elementos.  
 
7.2.1.  Estándar de codificación  
 
La especificación de los d ocumentos XML  es el estándar 150, con la codificación de caracteres UTF -8, por lo 
cual todos los documentos se inician con la declaración:  
<?xml  versi on="150" encoding="UTF -8"?> (*)  
Para mejor comprensión, se p uede utilizar el sigui ente enlace : 
http://www.w3.org/TR/REC -xml 
Cada archiv o XML, debe poseer solo una declaración (*), para el caso de los envíos de lotes, la estructura 
completa del archivo debe contener solo una declaración.   
 
7.2.2.  Declaración namespace  
 
El comúnmente denominado  “Espacio de Nombres”3 en XML, es utilizado para prop orcionar elementos y 
atributos con nombre único en un documento XML.  
Este espacio de nombres se declara utilizando el atributo xmlns, el cual estará incluido en el elemento raíz del 
documento  como,  por ejemplo:  
 
<rDE  
     xmlns=”http://ekuatia.set.gov.py/sifen/xsd”  
     xmlns:xsi ="http://www.w3.org/2001/XMLSchema -instance"  
     xsi:schemaLocation ="http://ekuatia.set.gov.py/sifen/xsd siRecepDE_v150.xsd" >    
Namesp ace utilizado en Eventos:  
 
2  https://es.wikipedia.org/wiki/XML_Schema  
(*) <?xml  versio n="100" encoding="UTF -8" ?> 
3 https://es. wikipedia.org/wiki/Espacio_de_nombres_XML  
www.w3.org/TR/REC -xml 
 
 
 
 
septiembre  de 2019                31 
<rEnviEventoDe   
xmlns="http://ekuatia.set.gov.py/sifen/xsd"  
 xmlns:xsi ="http://www.w3.org/2001/XMLSchema -instance" > 
 <dEvReg> 
  <gGroupGesEve > 
   <rGesEve  
    xsi:schemaLocation ="http://ekuatia.set.gov.py/sifen/xsd  
 siRecepEvento_v150.xsd"  
    xmlns:xsi ="http://www.w3.org/2001/XMLSchema -instance" > 
    <rEve Id="123"> 
       
    </rEve> 
   </rGesEve> 
  </gGroupGesEve > 
 </dEvReg> 
</rEnviEventoDe >  
Cabe aclarar que no se podrá utilizar:  
• Namespace distintos a los definidos en el presente documento  
• Prefijos  de namespace  
Cada documento XM L tendrá su  namespace individual en su correspondient e elemento raíz.  
 
7.2.2.1.  Particularidad de la firma digital  
 
La declaración namespace de la firma digital debe realizarse en la etiqueta <Signature>, conforme con el 
siguiente ejemplo:  
<rDE 
 xmlns="http://ekuatia.set.gov.py/sifen/xsd"   
 xmlns:xsi ="http://www.w3.org/2001/XMLSchema -instance"  
 xsi:schemaLocation ="http://ekuatia.set.gov.py/sifen/xsd/siRecepDE_v150.xsd" > 
 <dVerFor>150</dVerFor> 
 <DE Id="0144444401700100100145282201170125158732260988" > 
 </DE> 
 <Signature  xmlns="http://www.w3.org/2000/09/xmldsig#" > 
 </Signature >   
</rDE> 
  
 
7.2.2.2.  Particularidad del envío de lote 
 
En el c aso de envío de lote , cada DE debe contener  la declaración de su namespace individual, conforme el 
ejemplo:  
 
 
 
septiembre  de 2019                32 
<rDE  
xmlns="http://ekuatia.set.gov.py/sifen/xsd"  
xmlns:xsi =http://www.w3.org/2001/XMLSchema -instance  
xsi:schemaLocation ="http://ekuatia.set.gov.py/sifen/xsd/siRecepDE_v150.xsd" > 
 <dVerFor>150</dVerFor> 
 <DE Id="0144444401700100100145282201170125158732260988" > 
   ... 
 </DE> 
 <Signature  xmlns="http://www.w3.org/2000/09/xmldsig#" > 
   ... 
 </Signature > 
  
</rDE> 
<rDE  
xmlns="http://ekuatia.set.gov.py/sifen/xsd"  
xmlns:xsi =http://www.w3.org/2001/XMLSchema -instance  
xsi:schemaLocation ="http://ekuatia.set.gov.py/sifen/xsd/siRecepDE_v150.xsd" > 
 <dVerFor>150</dVerFor> 
 <DE Id="0144444401700100100145282201170125158732260988" > 
   ... 
 </DE> 
 <Signature  xmlns="http://www.w3.org/2000/09/xmldsig#" > 
   ... 
 </Signature >  
</rDE>  
7.2.3.  Convenciones referenciadas en tablas  
 
La Gráfica Nº  08 mue stra la relación entre los elementos del archivo XML  
 
 
Gráfica N° 08: Relación elementos XML  
 
La definición de las columnas de las tablas, conforme los esquemas relacionados a los archivos XML , se expone  
a continuación  en la Tabla A : 
Tabla A – Convencione s Utilizadas en la Tablas de Definición de los Format os XML  
Título Descripción  
Grupo  Conjunto de campos  
ID Identifica ción del campo  para fines de referencia  
Campo  Nombre del campo. La primera letra indica:  
c: código integrante de una tabla existente en el Capítulo 16 
 
 
 
septiembre  de 2019                33 
Tabla A – Convencione s Utilizadas en la Tablas de Definición de los Format os XML  
Título Descripción  
i: código integrante de una tabla  que se encuentra en la columna “ Observaciones ” 
d:  nombre de un campo común  
g:  nombre de un grupo  
r: raíz de XML  
Descripción  Descripción  del campo y su significado  
Nodo Padre  Referencia al ID d el campo de grupo que contien e este campo específico (campo 
padre ) 
Tipo de Dato  Tipo de dato (ver Tabla B) 
Longitud  Tamaño del campo (ver Tabla C) 
Ocurrencia  Ocurrencias, en el formato m -n, en el cual  
m: número mínimo de veces que el campo debe aparecer  en el grupo  
n: número máximo de veces que el campo p uede aparecer en el grupo  
Observaciones  Observaciones  importantes sobre el campo, incluyendo listas de valores posibles, 
validaciones  relevantes entre otras.  
Versión  Versión que el campo fue introducid o en el formato, o versión en la cual ha sido 
modific ado por la última vez  
 
Los tipos de campos de los archivos XML tienen su contenido descrito en la Tabla B . 
 
Tabla B – Tipos de Datos en los Archivos XML  
Tipo  Descripción  
XML  Documento XML, descripto en  un schema contenido en esta ficha técnica  
G Grupo d e elementos y/o grupos de elementos  
CG “Choice Group”, elemento que excluye la ocurrencia de otro C hoice Group, con el 
mismo padre  
CE “Choice Element”, elemento que excluye la ocurrencia de otro Choice  Element c on 
el mismo padre  
• Por ejemplo  los varios tipos de RUC  
El tipo de elemento aparece luego al lado  
• Por ejemplo, “CEA” indica un Choice Element alfanumérico  
A Alfanumérico  
N Numérico: Vea los diversos formatos en la Tabla C 
F Fecha: Los campos  de fecha, según corresponda, deberán contener fecha y hora en 
el formato: AAAA -MM-DDThh:mm:ss  o AAAA -MM-DD 
•   Por ejemplo, para expresar 2:23 PM de 01 de febrero de 2018: 2018 -02-01-
14:23:00  
Por ejemplo, para expresar 01  de febrero de 20 18: 2018 -02-01 
B Binario en Base 64 para envío de lote  
 
 
 
 
septiembre  de 2019                34 
Los tamaños d e campo utilizados en los archivos XML tienen su contenido descripto en la Tabla C. En el caso 
de campos con tamaño exacto los espacios no utilizados deben ser llenados con ceros no significativos (a la 
izquierda del campo).  
 
Tabla C : Tamaños de campos  
Título Descripción  
X Tamaño exacto del campo  
• ej.: 2  
x-y Tamaño mínimo x, máximo y 
• ej.: 0 -10 (es posible expresar ningún valor, porque se permite el tamaño 0)  
Xpn Tamaño exacto del campo x, con n cifras decimales exactamente  
• ej.: 22p4  
xp(n -m) Tamaño exacto del campo x, con cifras decimales entre n y m  
• ej.: 22p(0 -7) 
(x-y)p(n -m) Tamaño mínimo x, máximo y, con cifras decimales entre n y m 
• ej.: 1-11p(0 -6) (es obligatorio expresar algún valor, porq ue no se permite el tamaño 
0, pero la parte decimal e s opcional)  
Valores 
separados 
por comas  El campo deberá ser informado con tamaño exacto de una de las opciones listadas  
• ej.: 1, 3, 5, 8. Significa que se debe informar el campo con uno de estos cuatr o 
tamaños fijos  
 
En la Tabla D  se ejemplifica la man era de informar los formatos numéricos . 
 
Tabla D: Formatos numéricos  
Formato  Para Informar  Llenar campo con  
0-11p0 -6 1.105,13  1105 .13 
1.105,137  1105.137  
1.105  1105  
0 0 
para no informar cantidad  No incluir  
0-11 1.105  1105  
0 0 
para no informar  cantidad  No incluir  
1-11 1.105  1105  
0 0 
para no informar cantidad  no es posible  
 
NOTA: De manera a simplificar y utilizar toda la potencia del lenguaje, el punto (.) se utilizará  como separador de  decimales, tal y como lo muestra la 
Tabla  D 
 
7.2.4.  Recomen daciones mejores prácticas de generación del archivo  
 
Como buenas prácticas al momento d e la generación de los DE, tener precaución de NO incorporar:  
• Espacios en blanco  en el inicio o en el final de camp os numéricos y alfanuméricos.  
• Comentarios, anotacione s y docume ntaciones, léase las etiquetas annotation  y documentation . 
 
 
 
septiembre  de 2019                35 
• Caracter es de forma to de archivo, como line-feed , carriage return , tab, espacios entre etiquetas.  
• Prefijos en el namespace de las etiq uetas.  
• No incluir etiquetas de campos que no contenga n valor, sean estas numéricas, que contienen ceros, 
vacíos o blancos para campos del tipo alfanumérico. Están excluidos de esta regla todos aquellos 
campos identificados como obligatorios en los distinto s formatos de archivo XML, la obligatoriedad 
de los m ismos será plenamente detallada.  
• No utilizar valores negativos  
• El nombre de los campos es sensible a minúsculas y mayúsculas , por lo que deben ser comunicados 
de la misma forma en la que se visualiza en  el presente manual técnico.  
• Ej: el grupo gOpeDE , es diferente a Gope DE, a gopede  y a cualquier otra combinación distinta a la 
inicial.  
 
7.3. Contenedor  de documento electrónico  
 
Un contenedor del DE es un archivo XML  que contiene el DE, con su validación  de re cepción, por parte del 
SIFEN, así como cualquier even to, registrado que lo involucre.  
La estructura está definida en la sección  9.4, correspondiente al S W “SiConsDE”. 
 
7.4. Estándar  de comunicación  
 
La comunicación entre los contribuyentes y la SET  está b asada en los Servicios Web  disponibles por el SIFEN.  
El med io para establecer esta comunicación es la Internet, apoyado en la utilización del protocolo de seguridad 
TLS versión 1.2, con autenticación mutua. Esto garantiza una comunicación segura, cons idera ndo la  
identificación del cliente consumidor del servicio p or medio de c ertificados digitales.  
El modelo de comunicación sigue el estándar de Servicios Web definido por el WS-I4 BasicProfile5.  
El intercambio de d ocumentos o mensajes entr e el SIFEN y el sistema de los c ontribuyentes, utiliza el estándar 
SOAP, vers ión 1.26, con intercambio de mensajes XML basados en Style/Encoding: Document/Literal.  
La llamada o Request a cualquiera de los Servicios Web del SIFEN, es realizada con el envío de un mensaje XM L 
inclui do en el campo soap:Body .  
 
Request de ejemplo utiliz ando SOAP:  
 
4Web Services Interoperability Organization (WS -I, http://www.ws -i.org/about/Default.aspx ) 
5http://www.ws -i.org/Profiles/BasicProfile -1.0-2004 -04-16.html  
6Web Services Interope rability Organizat ion (WS -I, http://ww w.ws -i.org/about/Default.aspx ) 
6http://www.ws -i.org/Profiles/BasicProfile -1.0-2004 -04-16.html  
6https://www.w3.org/TR/soap12/  
 
 
 
septiembre  de 2019                36 
 
<soap:Envelope  
xmlns:soap ="http://www.w3.org/2003/05/soap -envelope" > 
<soap:Header /> 
 <soap:body > 
  <rEnviDe xmlns="http://ekuatia.set.gov.py/sifen/xsd" > 
   <dId>10000011111111 </dId> 
   <xDE> 
    <rDE  
xmlns="http://ekuatia.set.gov.py/sifen/xsd"  
xmlns:xsi =http://www.w3.org/2001/XMLSchema -instance  
xsi:schemaLocation ="http://ekuatia.set.gov.py/sifen/xsd/siR
ecepDE_v150.xsd" > 
    ... 
    </rDE> 
   </xDE>      
  </rEnviDe> 
 </soap:body > 
</soap:Envelope >  
 
Response de ejemplo utilizando SOAP:  
<env:Envelope  
xmlns:soap ="http://www.w3.org/2003/05/soap -envelope" > 
 <env:Header /> 
 <env:body > 
  <ns2:rRetEnviDe  xmlns:ns2 ="http://ekuatia.set.gov.py/sifen/xsd" > 
   <ns2:rProtDe > 
<ns2:dId>00000000000000000000000000000000000000000000 </ns2:dId>  
   <ns2:dFecProc >2019-06-03T12:00:00 </ns2:dFecProc > 
<ns2:dDigVal >0000000000000000000000000000 </ns2:dDigVal > 
   <ns2:gResProc > 
    <ns2:dEstRes >Rechazado </ns2:dEstRes > 
    <ns2:dProtAut >0000000000 </ns2:dProtAut > 
    <ns2:dCodRes >0160</ns2:dCodRes > 
<ns2:dMsgRes >XML malformado </ns2:dMsgRes >   
    </ns2:gResProc >       
   </ns2:rProtDe > 
  </ns2:rRetEnviDe > 
 </env:body > 
</soap:Envelope > 
 
 
7.5. Estándar  de certificado digital  
 
El SIFEN utiliza un certificado digital, emiti do por cualquiera de los PSC7, habilitados por el Min isterio de 
Industria y Comercio8 en su carácter de Administrador de la Autoridad Certificadora Raíz del Paraguay9 y ente 
regulador. El certificado será utilizado para firmar dig italmente y para  autentica rse en los servicios del SIFEN . 
Puede ser del TIPO F110 o F211 de persona física o jurídica. En el caso de optar por el certificado de persona 
jurídica, el RUC del contribuyente estará contenido en el campo SerialNumber . En el caso de optar por el 
certificad o de persona física, éste debe ser de un personal dep endiente del contribuyente y el certificado debe 
 
7 (PSC ) Prestador de Servicios de Certificación https://www.acraiz.gov.py/html/Certif_1PrestaServ.html  
8 www.acraiz.gov.py  
9 (AA) Según la Ley N°4017   de Firma Digital es el Ministerio de Industria y Comercio  
10 Tipo F1: corresponde a Certificado de Firma Digital por Software 
11 Tipo F2: corresponde a Certificado de Firma Digital por Hardware  
 
 
 
septiembre  de 2019                37 
contar obligatoriamente con el nombre y el RUC de la entidad en el que presta servicio el titular del certificado. 
En este últim o caso el RUC del contribu yente estará contenido en el campo SubjectAlternative Name . 
Estos certificados digitales serán exigidos por la SET en los siguientes momentos:  
 
• Para firma de mensajes de datos:  Se refiere al archivo de documento electrónico, regist ro de evento y/o 
cualquier  otro archivo XML admisible por el SIFEN , que requier a ser firmado digitalmente. El certificado 
digital debe contener el RUC del contribuyente emisor y la clave prevista para la función de firma digital.  
• Para establecimiento de conexiones  y autenticaciones  mutuas : (Comunicación entre el servidor del 
contribu yente y el servidor del SIFEN). Para este efecto, el certificado digital debe contener el RUC del 
contribuyente emisor y propietario responsable por la trasmisión del mensaje, con la extensión Extended 
Key Usage con el permiso clientAuth . 
 
Acla ración:  
• Certificado de persona jurídica:  el RUC del contribuyente debe estar informado en el:  
o Campo X509 V3:  Subject  
o Nombre:  “Serial Number ” OID: 2.5.4.5  
• Certificado de persona física:  el RUC del contribuyente emis or debe estar informado en el:  
o Campo X509  V3: Subject AlternativeName  
o Nombre:  “SerialNumber ” OID : 2.5.4.5  
Para ambos casos, la información del RUC debe informarse de la siguiente manera:  
RUCXXXXXXXXX -X -> es decir, se escribe la palabra RUC con mayúsculas, seguido del número de RUC 
correspondiente  con guion y  el dígito verificador, sin ningún espacio en toda la cadena.  
7.6. Estándar de firma digital  
 
Los archivos enviados al SIFEN  son documentos electrónicos construidos en lenguaje XML y deben estar 
firmados con la firma digital  amparada  con el c ertificado  correspo ndiente al RUC del contribuyente emisor del 
documento.  
Existen elementos que se encuentran presentes en el certificado digital del emisor de forma natural, lo que 
implica innecesaria su exposición en la estructura XML. En este contexto los DE firmados digi talmente no 
deben contener los siguientes elementos:  
<X509SubjectName>  
<X509IssuerSerial>  
<X509IssuerName>  
<X509SKI>  
De igual manera se debe evitar el uso de los siguientes elementos, ya que esta inform ación será obtenida a 
partir del c ertificado digital del emisor.  
 
 
 
septiembre  de 2019                38 
<KeyValue>  
<RSAKeyValue>  
<Modulus>  
<Exponent>  
Los DE utilizan el subconjunto del estándar de firma digital definido según W3C, 
http://www.w3. org/TR/xmldsig -core/ , conforme a lo expuesto en el S chema XML 1. 
Cada Documento Electrónico deberá ser firmado por el contribuyente emisor abarcando el grupo de 
información  A001 , con sus respectivos subgrupos, identificado por el Atributo “Id” cuyo valor s erá el CDC 
(Código de Control).  
Véase la Tabla de Fo rmato de Campos d e un Documento Electrónico (DE) .  El mismo literal ú nico (CDC) 
precedido por el caracter “#” deberá  ser in formado en el atributo URI del t ag Reference.  
Schema XML 1: xmldsig -core-schema - v150.xsd (Estándar de la  Firma Digital)  
ID Campo  Descrip
ción Nodo 
Padre  Ocurren
cia Observaciones  
XS01  Signature   - - Raíz 
XS02  SinnedInfo  G XS01  1-1 Grupo de información de la firma  
XS03  CanonicalizationMetho
d G XS02  1-1 Grupo del método canónico  
XS04  Algorithm  A XS03  1-1 Atributo Algorithm de Canonical izationMethod  
https://www.w3.org/TR/2001/REC -xml-c14n -
20010315  
XS05  SignatureMethod  G XS02  1-1 Grupo del método de firma  
XS06 Algorithm  A XS05  1-1 Atributo Algorithm de Signatur eMethod: 
Sha256RSA  
http://www.w3.org/2001/04/xmldsig -more#rsa -
sha256  
XS07  Reference  G XS02  1-1 Grupo Reference  
XS08  URI A XS07  1-1 Atributo del Tag Reference que identific a los datos 
que se están firmandos  
XS10  Transforms  G XS07  1-1 Grupo Algorithm Transforms  
XS12  Transforms  G XS10  2-2 Grupo del Transform  
XS13  Algorithm  A XS12  2-2 Atributos válidos Algorithm de Transfo rm: 
https://www.w3.org/TR/xmldsig -core1/#sec -
EnvelopedSignature  
 
http://www.w3.org/2001/10/xml -exc-c14n# 
XS14  XPath  E XS12  0-n XPath  
XS15  DigestMet hod G XS07  1-1 Grupo del método del DigestMethod  
XS16  Algortihm  A XS15  1-1 Atributo del algoritmo utilizado para el 
DigestMethod:  
https://www.w3.org/T R/2002/REC -xmlenc -core-
20021210/Overview.html#sha256  
XS17  DigestValue  E XS07  1 Digest Value (HASH SHA256)  
XS18  SignatureValue  G XS01  1-1 Grupo del Signature Value  
XS19  KeyInfo  G XS01  1-1 Grupo del Ke yInfo  
XS20  X509Data  G XS19  1-1 Grupo X509  
XS21  X509 Certificate  E XS20  1-1 Certificado Digital X509.v3  
 
 
 
 
septiembre  de 2019                39 
Significado de la columna Descripción del Schema XML 1:  
• G: Grupo  
• A: Algoritmo  
• RC: Regla  
• E: Elemento  
 
Esta estructura se debe utilizar para todos l os archivos firmados, utilizando el CDC, para el atributo  Id 
 
<rDE xmlns=http://ekuatia.set.gov.py/sifen/xsd   
xmlns:xsi =http://www.w3.org/2001/XMLSchema -instance  
xsi:schemaLocation ="http://ekuatia.set.gov.py/sifen/xsd/siRecepDE_v150.xsd" > 
    <dVerFor>150</dVerFor> 
    <DE Id="0144444401700100100145282201170125158732260988" > 
   ... 
    </DE> 
    <Signature  xmlns="http://www.w3.org/2000/09/xmldsig#" > 
    <SignedInfo > 
    <CanonicalizationMethod  
 Algorithm ="http://www.w3.org/TR/2001/REC -xml-c14n-20010315" /> 
 <SignatureMethod  Algorithm ="http://www.w3.org/2001/04/xmldsig -more#rsa -sha256"/> 
     <Reference  URI="#0144444401700100100145282201170125158732260988" > 
        <Transforms > 
    <Transform  Algorithm ="http://www.w3.org/2000/09/xmldsig#enveloped - 
signature" /> 
      <Transform  Algorithm ="http://www.w3.org/2001/10/xml -exc-c14n#"/> 
        </Transforms > 
        <DigestMethod Algorithm ="http://www.w3.org/2001/04/xmlenc#sha256" />  
  <DigestValue >Nt2UmpjUHuu2DT6CJc2mtKhhqbq94LHSak1IsEOtuWk=  
        </DigestValue > 
     </Reference > 
    </SignedInfo > 
    <SignatureValue >DWN1my9sH4FI7ygPT3KF1ce... </SignatureValue > 
 <KeyInfo> 
     <X509Data > 
       <X509Certificate >MIIIxzCCBq+gAwIBAgITXAA...  
</X509Certificate > 
     </X509Data > 
 </KeyInfo> 
     </Signature>   
</rDE> 
 
 
En el proceso de verificación de los certificados, el SIFEN se encargará de consultar la lista de certificados 
revocados (LCR) al momento de la validación co rrespondiente, de manera que el contribuyente no nece sitará 
anexar esta lista al firmar el documento.  
 
7.7. Especificaciones técnicas del estándar de certificado y firma digital  
 
• Estándar de Firma:  XML Digital Signature , se utiliza el formato Enveloped  
http://w ww.w3.org/TR/xmldsig -core/  
• Certificado Digital:  Exped ido por una de l os PSC habilitad os en la República del Paraguay, estándar   
http://www.w3.org/2000/09/xmldsig#X509Data  
https:/ /www.acraiz.gov.py/html/Certif_1PrestaServ.html  
 
 
 
septiembre  de 2019                40 
• Tamaño de la Clave Criptográ fica: RSA 2048, para cifrado por software, para cifrado por hardware 
pueden ser de RSA 2048 o RSA 4096.  
• Función Criptográfica  Asimétrica:  RSA conforme a  (https://www.w3.org/TR/2002/REC -xmlenc -core-
20021210/Overview.html#rsa -1_5 ). 
• Función de “message digest”: SHA-2 
https://www.w3.org/TR/2002/REC -xmlenc -core-20021210/Overview.html#sha256  
• Codificación:  Base64  
https://www.w3.org/TR/xmldsig -core1/ #sec -Base -64 
• Transformaciones exigidas:  Útil para canonizar el XML enviado, con el propósito de realizar la 
validación correcta de la firma digital:  
Enveloped , https://www.w3.org/TR/xmldsig -core1/#sec -EnvelopedSignature  
C14N, http://www.w3.org/2001/10/xml -exc-c14n#  
7.8. Procedimiento para la validación  de la firma digital:  
 
a) Extraer la clave pública del c ertificado digital,  
b) Verificar el plazo d e validez del certificado digital del emisor  
c) Validar la cadena de confianza, identificando a l PSC, así como la lista de certificados revocados de la 
cadena  
d) Verific ar que el certificado digital utilizado es del contri buyente y no de una autoridad certificad ora 
e) Validar la integridad de las LCR utilizadas  
f) Verificar el Plazo de validez de cada LCR (Effective Date y NextUpdate) en relación al momento de la 
firma (campo f echa de la firma).  
7.9. Síntesis de definiciones tecnológi cas 
 
La Tabla  E resume los principales estándares de tec nología utilizados . 
Tabla E: Estándares de tecnología  utilizado s 
Característica  Descripción  
Web Services  Estándar definido por WS -I Basic Profile 1.1  
Medio lógico de comunicación  Web Services disponibilizados por la SET  
Medio físico de comunicación  Internet 
Protocolo de Internet  TLS versión 1.2, con autenticación mutua utilizando los Certificados 
Digitales.  
Estándar de intercambio de datos  SOAP versión 1.2  
Estándar de Mensaje  XML en el Estándar Style/Encoding: Document/Literal.  
Estándar de Certificad o Digital  ITU-T X.509 V.3 Information Technology Open  Systems 
Interconnection. The Directory: Public -key and attribute certificate 
frameworks. Emitido por un PSC habilitado por el MIC.  
https://www.acraiz.gov.py/html/Certif_1PrestaServ.html  
Estándar de la Firma Digital  XML Digital Signature, Enveloped, con Certificado Digital X.509 
versión 3, con clave privada de 2048 y  estándares de criptografía 
asimétrica RSA, RFC5639 y algoritmo SHA -256 
Validación de la Firma Digital  Se validarán la in tegridad y la autoría, además la cadena de 
confianza, por medio de las LCR  en relación al momento de la firma 
(campo fecha de la firma ). 
Estándares de utilización XML  Definidos según las mejores práctic as a la hora de armar un archivo 
XML 
 
 
 
septiembre  de 2019                41 
7.10. Resumen de las Direcciones Electrónicas de los Servicios Web para Ambientes de Pruebas y 
Producción  
 
URL Ambiente  
https://sifen.se t.gov.py/de/ws/sync/recibe.wsdl ?wsdl  Producción  
https://sifen.set.gov.py/de/ws/async/ recibe -lote.wsdl ?wsdl  Producción  
https://sifen.set.g ov.py/de/ws/eventos/evento.wsdl ?wsdl   Producción  
https://sifen.set.gov.py/de/ws/consultas/consulta -lote.wsdl?wsdl  Producción  
https://sifen.set.gov.py/de/ws/consultas/consulta -ruc.wsdl?wsdl  Producción  
https://sifen.set.gov.py/de/ws/consultas/consulta.wsd l?wsdl  Producción  
https://sifen -test.s et.gov.py/de/ws/sync/recibe.wsd ?wsdl   Test  
https://sifen -test.set.gov.py/de/ws/async/recibe -lote.wsdl ?wsdl  Test  
https://sifen -test.set.gov.py/de/ws/eventos/evento .wsdl ?wsdl   Test  
https://sifen -test.set.gov.py/de/ws /consultas/consulta.wsdl ?wsdl  Test  
https://sifen -test.set.gov.py/de/ws/consultas/consulta -lote.wsdl?wsdl  Test  
https://sifen -test.set.gov.py/de/ws/consu ltas/consulta -ruc.wsdl?wsdl  Test  
 
 
7.11. Servidor para sincronización externa de horario  
 
Las direcciones p ara acceder a los servidores NTP para sincronización de horario son:  
• aravo1.set.gov.py    
• aravo2.set.gov.py  
 
El acceso a los servicios , citados en los puntos 7.10  y 7.11 , dependerá de la política de segur idad  establecida 
por la SET.  Por lo que, podrá limita r y/o restringir la utilización de los servicios por contribuyente, por 
direcciones IP u otros, de tal forma a asegurar la disponibil idad de los recursos según cada  etapa del plan 
general del SIFEN.  
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
septiembre  de 2019                42 