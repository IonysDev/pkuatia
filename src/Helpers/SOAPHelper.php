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
    $XMLDoc->formatOutput = false;

    // SOAP ENVELOPE ELEMENT AND ATTRIBUTES
    $soap = $XMLDoc->createElementNS('http://www.w3.org/2003/05/soap-envelope', 'soap:Envelope');
    $XMLDoc->appendChild($soap);

    // SOAP HEADER ELEMENT
    $soapHeader = $XMLDoc->createElement('soap:Header');
    $soap->appendChild($soapHeader);

    // SOAP BODY ELEMENT
    $soapBody = $XMLDoc->createElement('soap:Body');
    $soap->appendChild($soapBody);

    // Load the XML content into a new DOMDocument
    $xmlContent = new DOMDocument();
    $xmlContent->loadXML($xml);

    // Import the root element of the XML content without preserving the original namespace
    $importedContent = $XMLDoc->importNode($xmlContent->documentElement, true);
    $soapBody->appendChild($importedContent);

    return $XMLDoc->saveXML();
  }
}
