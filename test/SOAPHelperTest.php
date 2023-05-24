<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

/// Obtener el xml
$xmlFile = $argv[1];

$url = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';

$soapUser = '80121930-2';  //  username
$soapPassword = '171222'; // password

///xml to string
$xml_post_string = file_get_contents($xmlFile);

   $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl", 
                "Content-length: ".strlen($xml_post_string),

            ); //SOAPAction: your op URL

 

    // PHP cURL  for https connection with auth
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // converting
    $response = curl_exec($ch); 
    curl_close($ch);


    // converting
    $response1 = str_replace("<soap:Body>","",$response);
    $response2 = str_replace("</soap:Body>","",$response1);

    // convertingc to XML
    $parser = simplexml_load_string($response2);
    // user $parser to get your data out of XML response and to display it.
?>
