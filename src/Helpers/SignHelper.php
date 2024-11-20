<?php

namespace Abiliomp\Pkuatia\Helpers;

use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Fields\DE\AA\RDE;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\GGroupGesEve;
use Abiliomp\Pkuatia\Core\Fields\Request\Event\GDE\RGesEve;
use DateTime;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use DOMDocument;
use RobRichards\XMLSecLibs\XMLSecurityKey;

/**
 * Clase que contiene los métodos para firmar los documentos XML según MT Sifen.
 */
class SignHelper
{
  public static XMLSecurityDSig $xmlSigner;
  public static XMLSecurityKey $xmlKey;

  /**
   * Inicializa el firmador de XML.
   * 
   * @param String $keyFilePath Ruta del archivo de llave privada. 
   * @param String $passphrase Contraseña de la llave privada.
   * 
   * @return void
   */
  public static function Init(String $keyFilePath, String $passphrase, String $certFilePath)
  {
    if (!file_exists($keyFilePath))
      throw new \Exception("[SignHelper] No se encontró el archivo de llave privada en la ruta especificada.");
    if (!file_exists($certFilePath))
      throw new \Exception("[SignHelper] No se encontró el archivo de certificado en la ruta especificada.");
    self::$xmlSigner = new XMLSecurityDSig('');
    self::$xmlSigner->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
    self::$xmlSigner->add509Cert(file_get_contents($certFilePath));
    self::$xmlKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
    self::$xmlKey->passphrase = $passphrase;
    self::$xmlKey->loadKey($keyFilePath, true);
  }

  /**
   * Firma un documento DE contenido en un objeto RDE
   * 
   * @param RDE $rde Contenedor RDE del documento DE.
   * 
   * @return DOMDocument  Documento XML firmado.
   */
  public static function SignRDE(RDE $rde, DateTime $fechaFirma = new DateTime('now')): DOMDocument
  {
    if (!isset(self::$xmlSigner))
      throw new \Exception("[SignHelper] No se ha inicializado el firmador de XML.");

    $rde->DE->setDFecFirma($fechaFirma);

    $xmlDocument = new DOMDocument('1.0', 'UTF-8');
    $xmlDocument->formatOutput = false;
    $xmlDocument->preserveWhiteSpace = false;
    $xmlDocument->loadXML($rde->toXMLString());
    $deNode = $xmlDocument->getElementsByTagName("DE")->item(0);

    $rdeNode = $xmlDocument->getElementsByTagName("rDE")->item(0);
    $cdc = $rde->getDE()->getId();
    self::$xmlSigner->addReference(
      $deNode,
      XMLSecurityDSig::SHA256,
      ['http://www.w3.org/2000/09/xmldsig#enveloped-signature', 'http://www.w3.org/2001/10/xml-exc-c14n#'],
      ['id_name' => 'Id', 'overwrite' => false],
    );
    self::$xmlSigner->sign(self::$xmlKey, $xmlDocument->documentElement);
    self::$xmlSigner->appendSignature($rdeNode);
    return $xmlDocument;
  }

  public static function SingEvents(GGroupGesEve $raiz, $config)
  {
    if (!isset(self::$xmlSigner))
      throw new \Exception("[SignHelper] No se ha inicializado el firmador de XML.");


    $xmlDocument = new DOMDocument('1.0', 'UTF-8');
    $xmlDocument->formatOutput = false;
    $xmlDocument->preserveWhiteSpace = false;
    $xmlDocument->loadXML($raiz->toXMLString());

    //foreach loop for each event
    $eventNodes = $xmlDocument->getElementsByTagName("rGesEve");
    foreach ($eventNodes as $eventNode) {
      //init signer, para evitar el bug del sobrefirmado
      self::Init($config->privateKeyFilePath, $config->privateKeyPassphrase, $config->certificateFilePath);
      ///show child node
      $rEve = $eventNode->getElementsByTagName("rEve")->item(0);
      //get id atribute
      $id = $rEve->getAttribute("Id");
      //add reference
      self::$xmlSigner->addReference(
        $rEve,
        XMLSecurityDSig::SHA256,
        ['http://www.w3.org/2000/09/xmldsig#enveloped-signature', 'http://www.w3.org/2001/10/xml-exc-c14n#'],
        ['id_name' => $id, 'overwrite' => true],
      );
      //sign
      self::$xmlSigner->sign(self::$xmlKey, $xmlDocument->documentElement);
      //append signature
      self::$xmlSigner->appendSignature($eventNode);
    }

    return $xmlDocument;
  }
}
