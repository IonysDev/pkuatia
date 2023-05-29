<?php
// Create SoapClient instance
$wsdl = 'https://sifen-test.set.gov.py/de/ws/consultas/consulta-ruc.wsdl';
$client = new SoapClient($wsdl);

// Prepare the parameters
$parameters = array(
  'dId' => '2332132',
  'dRUCCons' => '80057292'
);

// Call the rEnviConsRUC operation
try {
  $response = $client->rEnviConsRUC($parameters);
  // Handle the response
  echo "Response:\n";
  var_dump($response);
} catch (SoapFault $e) {
  // Handle SOAP fault
  echo 'SOAP Error: ' . $e->getMessage();
} catch (Exception $e) {
  // Handle general exception
  echo 'Error: ' . $e->getMessage();
}

?>