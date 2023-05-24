<?php

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

require '../vendor/autoload.php'; // Include the Composer autoloader

/// Obtener el xml
$xmlFile = $argv[1];

$url = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';


$xml_envelope = SOAPHelper::soapEnvelop($xmlFile);


$headers = array(
  "Content-type: text/xml;charset=\"utf-8\"",
  "Accept: text/xml",
  "Cache-Control: no-cache",
  "Pragma: no-cache",
  "SOAPAction: https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl",
  "Content-length: " . strlen($xml_envelope),
); //SOAPAction: your op URL;

// PHP cURL  for https connection with auth
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_envelope); // the SOAP request
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// converting
$response = curl_exec($ch);

curl_close($ch);

var_dump($response);
