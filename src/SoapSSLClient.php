<?php

namespace Abiliomp\Pkuatia;

use SoapClient;

class SoapSSLClient
{

    public static SoapClient $client;    

    public static function init(string $wsdl, string $pemCertificateFilePath, string $pemPrivateKeyFilePath, string $passphrase)
    {
        $options = [
            'soap_version' => SOAP_1_2,
            'trace' => true,
            'exceptions' => true,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'stream_context' => stream_context_create([
                'ssl' => [
                    'local_cert' => $pemCertificateFilePath,
                    'local_pk' => $pemPrivateKeyFilePath,
                    'passphrase' => $passphrase,
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                  
                ]
            ])
        ];
        self::$client = new SoapClient($wsdl, $options);
    }
}

?>