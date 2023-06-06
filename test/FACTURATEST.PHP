<?php
require '../vendor/autoload.php'; // Include the Composer autoloader
use Abiliomp\Pkuatia\Core\Factura;
use Abiliomp\Pkuatia\Helpers\CDCHelper;

error_reporting(E_ALL);
ini_set('display_errors', 1);
$data = array(
    'dRucEm' => '80057292',
    'dEst' => 1,
    'dPunExp' => '1',
    'dNumDoc' => '7650',
    'dFeEmiDE' =>  DateTime::createFromFormat('Y-m-d\TH:i:s', '2021-08-31T00:00:00'),
    'dNumTim' => 11232,
    'dFeIniT' => DateTime::createFromFormat('Y-m-d', '2021-08-31'),
    'dFeEmiDE' => new DateTime('America/Asuncion'),
    'dNomEmi' => 'Networkers S.R.L',
    'dDirEmi' => 'Teniente Félix Cañete MiñO',
    'dNumCas' => '1622',
    'dDepEmi' => '1',
    'dCiuEmi' => '1',
    'dTelEmi' => '021 328 0000',
    'dEmailE' => 'Nw@new.com.py',
);
$factura = new Factura($data);
var_dump($factura);

// echo $data['dFeEmiDE']->format('Y-m-d\TH:i:s');

// echo CDCHelper::decryptCDC('01800160967029015003289222023052912371717760');