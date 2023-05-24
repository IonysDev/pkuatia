<?php

use Abiliomp\Pkuatia\Helpers\SOAPHelper;

require '../vendor/autoload.php'; // Include the Composer autoloader

/// Obtener el xml
$xmlFile = $argv[1];

$url = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl';


////////////////////////////////////////////////////CURL//////////////////////////////////////
// $xml_envelope = SOAPHelper::soapEnvelop($xmlFile);

// $headers = array(
//   "Content-type: text/xml;charset=\"utf-8\"",
//   "Accept: text/xml",
//   "Cache-Control: no-cache",
//   "Pragma: no-cache",
//   "SOAPAction: https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl?wsdl",
//   "Content-length: " . strlen($xml_envelope),
// ); //SOAPAction: your op URL;

// // PHP cURL  for https connection with auth
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
// curl_setopt($ch, CURLOPT_TIMEOUT, 10);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_envelope); // the SOAP request
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// // converting
// $response = curl_exec($ch);

// curl_close($ch);

// var_dump($response);
////////////////////////////////////////////////////CURL//////////////////////////////////////

//////////////////////////////////////////////////SOAPCLIENT//////////////////////////////////////
// try {

//   $client = new SoapClient($url, array('soap_version' => SOAP_1_2, 'exceptions' => true, 'trace' => 1));  // The trace param will show you errors

//   $params = new stdClass();
//   $params->xml = $xmlFile->asXML(); // OJO: La propiedad xml es particular de este WebService, debes reemplazarla por el nombre del parámetro que espera recibir el servicio al que buscas conectarte
//   $result = $client->siConsRUC($params);
//   print_r($result);

// } catch (Exception $e) {
//   echo nl2br("Error del estado XD \n");
//   echo $e->getMessage();
// }
//////////////////////////////////////////////////SOAPCLIENT//////////////////////////////////////
