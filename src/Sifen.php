<?php

namespace Abiliomp\Pkuatia;

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Requests\REnviConsRUC;
use Abiliomp\Pkuatia\Core\Requests\REnviConsDe;
use Abiliomp\Pkuatia\Core\Responses\RespuestaConsultaRUC;
use Abiliomp\Pkuatia\Core\Responses\RespuestaConsultaDE;
use SoapClient;

class Sifen
{
    private static SoapClient $client;
    private static Config $config;
    private static $options;

    public static function Init(Config $config) {    
        if(!file_exists($config->certificateFilePath)) {
            throw new \Exception("Certificate file not found in path: " . $config->certificateFilePath . ".");
        }
        if(!file_exists($config->privateKeyFilePath)) {
            throw new \Exception("Private key file not found in path: " . $config->privateKeyFilePath . ".");
        }
        self::$config = $config;
        self::$options = [
            'soap_version' => SOAP_1_2,
            'trace' => true,
            'exceptions' => true,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'stream_context' => stream_context_create([
                'ssl' => [
                    'local_cert' => $config->certificateFilePath,
                    'local_pk' => $config->privateKeyFilePath,
                    'passphrase' => $config->privateKeyPassphrase,
                    'verify_peer' => true,
                    'verify_peer_name' => true,                  
                ]
            ])
        ];
    }
    
    public static function ConsultarRUC(String $ruc): RespuestaConsultaRUC {
        self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_RUC . "?wsdl", self::$options);
        $response = self::$client->rEnviConsRUC(new REnviConsRUC(self::GetDId(), $ruc));
        return RespuestaConsultaRUC::fromResponse($response);
    }

    public static function ConsultarDE(String $cdc): RespuestaConsultaDE {
        self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA . "?wsdl", self::$options);
        $response = self::$client->REnviConsDe(new REnviConsDe(self::GetDId(), $cdc));
        return RespuestaConsultaDE::fromResponse($response);
    }

    private static function GetSifenUrlBase() : string {
        if (strtolower(self::$config->env) == "prod") {
            return Constants::SIFEN_URL_BASE_PROD;
        } else {
            return Constants::SIFEN_URL_BASE_DEV;
        }
    }

    private static function GetDId() : int {
        $dId = 1;
        if(file_exists(self::$config->dIdFilePath)) {
            $json = file_get_contents(self::$config->dIdFilePath);
            $data = json_decode($json);
            $dId = $data->dId;
            if($dId == Constants::MAX_DID)
                $dId = 1;
            else
                $dId++;
        } 
        $data = array(
            'dId' => $dId
        );
        $json = json_encode($data);
        file_put_contents(self::$config->dIdFilePath, $json);        
        return $dId;
    }
}

?>