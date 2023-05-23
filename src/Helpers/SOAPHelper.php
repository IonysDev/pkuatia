<?php

namespace Abiliomp\Pkuatia\Helpers;

use DOMDocument;
use DOMElement;
use Exception;
use SoapClient;
use stdClass;

/**
 * SOAPHelper
 */
class SOAPHelper
{

  /**
   * Send a SOAP request to the server and return the response as a XML string
   *
   * @param  mixed $xml
   * @param  mixed $wsdl
   * @param  mixed $action
   * @param  mixed $options
   * @return string
   */
  public static function soapEnvelop($xml)
  {
    $XMLDoc = new DOMDocument('1.0', 'UTF-8');
    $XMLDoc->preserveWhiteSpace = false;
    $XMLDoc->formatOutput = true;

    // SOAP ENVELOPE ELEMENT AND ATTRIBUTES
    $soap = $XMLDoc->createElementNS('http://www.w3.org/2003/05/soap-envelope', 'soap:Envelope');
    $XMLDoc->appendChild($soap);

    // SOAP HEADER ELEMENT
    $soapHeader = $XMLDoc->createElement('soap:Header');
    $soap->appendChild($soapHeader);

    // SOAP BODY ELEMENT
    $soapBody = $XMLDoc->createElement('soap:body');
    $soap->appendChild($soapBody);

    // SOAP BODY CONTENT
    ///cargar el xml en un domdocument
    $source = new DOMDocument();
    $source->load($xml);

    //obtener el nodo root del xml
    $node = $source->getElementsByTagName('root')->item(0);
    //obtener los hijos del root
    $children = $node->childNodes;

    //agregar los hijos del root al body
    foreach ($children as $child) {
      $soapBody->appendChild($XMLDoc->importNode($child, true));
    }

    // RETURN THE XML
    return $XMLDoc->saveXML();
  }

  public static function makeRequest($xml, $wsdl)
  {
    try {
      $opts = array(
        'http' => array(
          'user_agent' => 'PHPSoapClient'
        )
      );
      $context = stream_context_create($opts);

      $soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE
      );

      $client = new SoapClient($wsdl, $soapClientOptions);
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
}
