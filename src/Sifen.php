<?php

namespace Abiliomp\Pkuatia;

use Abiliomp\Pkuatia\Core\Config;
use Abiliomp\Pkuatia\Core\Constants;
use Abiliomp\Pkuatia\Core\Requests\REnviConsRUC;
use Abiliomp\Pkuatia\Core\Requests\REnviConsDe;
use Abiliomp\Pkuatia\Core\Responses\RResEnviConsRUC;
use Abiliomp\Pkuatia\Core\DocumentosElectronicos\DocumentoElectronico;
use Abiliomp\Pkuatia\Core\Fields\DE\A\DE;
use Abiliomp\Pkuatia\Core\Requests\REnviDe;
use Abiliomp\Pkuatia\Core\Responses\RResEnviConsDe;
use Abiliomp\Pkuatia\Core\Responses\RRetEnviDe;
use SimpleXMLElement;
use SoapClient;
use SoapVar;

class Sifen
{
    private static SoapClient $client;
    private static Config $config;
    private static $options;

    /**
     * Inicializa la clase Sifen con la configuración necesaria para realizar las peticiones.
     * Es obligatorio que se llame a este método antes de realizar cualquier petición.
     * 
     * @param Config $config
     * 
     * @return void
     */
    public static function Init(Config $config)
    {
        if (!file_exists($config->certificateFilePath)) {
            throw new \Exception("Certificate file not found in path: " . $config->certificateFilePath . ".");
        }
        if (!file_exists($config->privateKeyFilePath)) {
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

    /**
     * Realiza la consulta de un RUC en el SIFEN.
     * 
     * @param String $ruc RUC a consultar.
     * 
     * @return RResEnviConsRUC
     */
    public static function ConsultarRUC(String $ruc): RResEnviConsRUC
    {
        self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA_RUC . "?wsdl", self::$options);
        $object = self::$client->rEnviConsRUC(new REnviConsRUC(self::GetDId(), $ruc));
        return RResEnviConsRUC::fromStdClassObject($object);
    }

    /**
     * Realiza la consulta de un Documento Electrónico en el SIFEN.
     * 
     * @param String $cdc Código de Control del Documento Electrónico a consultar.
     * 
     * @return RResEnviConsDe
     */
    public static function ConsultarDE(String $cdc): RResEnviConsDe
    {
        self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_CONSULTA . "?wsdl", self::$options);
        $object = self::$client->REnviConsDe(new REnviConsDe(self::GetDId(), $cdc));
        return RResEnviConsDe::FromSifenResponseObject($object);
    }

    /**
     * Realiza el envío de un Documento Electrónico al SIFEN.
     * 
     * @param DocumentoElectronico $de Documento Electrónico a enviar.
     * 
     * @return RRetEnviDe
     */
    public static function EnviarDE(DocumentoElectronico $de)
    {
        self::$client = new SoapClient(self::GetSifenUrlBase() . Constants::SIFEN_PATH_RECIBE . "?wsdl", self::$options);
        $rEnviDe = new REnviDe(self::GetDId(), new SoapVar(
            '<ns1:xDE>' . $de->toXMLString() . '</ns1:xDE>',
            XSD_ANYXML
        ));
        $object = self::$client->rEnviDe($rEnviDe);
        file_put_contents("rEnviDe.xml", self::$client->__getLastRequest());
        return RRetEnviDe::FromSifenResponseObject($object);
    }

    private static function GetSifenUrlBase(): String
    {
        if (strtolower(self::$config->env) == "prod") {
            return Constants::SIFEN_URL_BASE_PROD;
        } else {
            return Constants::SIFEN_URL_BASE_DEV;
        }
    }

    private static function GetDId(): int
    {
        $dId = 1;
        if (file_exists(self::$config->dIdFilePath)) {
            $json = file_get_contents(self::$config->dIdFilePath);
            $data = json_decode($json);
            $dId = $data->dId;
            if ($dId == Constants::MAX_DID)
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
