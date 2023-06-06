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
    'iNatRec' => '2',
    'iTiOpe' => '2',
    'cPaisRec' => 'PRY',
    'iTipIDRec' => '5',
    'dNumIDRec' => '0',
    'dNomRec' => 'Sin Nombre',
    'iIndPres' => '1',
    'iCondOpe' => '1',
    'gCamItem' => array(
        0 => array(
            'dCodInt' => '1235678',
            'dDesProSer' => 'Producto 1',
            'cUniMed' => 77,
            'dCantProSer' => 0.5060,
            'gValorItem' => array(
                'dPuniProSer' => 1000.00000000,
                'dTotBruOpeItem' => 506.40000000,
                'gValorRestaItem' => array(
                    'dDescItem' => 0,
                    'dTotOpeItem' => 506.40000000,
                ),
            ),
        ),
        1 => array(
            'dCodInt' => '40040440',
            'dDesProSer' => 'Producto 2',
            'cUniMed' => 77,
            'dCantProSer' => 1,
            'gValorItem' => array(
                'dPuniProSer' => 1000.00000000,
                'dTotBruOpeItem' => 1000.00000000,
                'gValorRestaItem' => array(
                    'dDescItem' => 0,
                    'dTotOpeItem' => 1000.00000000,
                ),
            ),
        ),
    ),
    // 'gCamItem' => array(
    //     0 => array(
    //         'dCodInt' => '1235678',
    //         'dDesProSer' => 'Producto 1',
    //     )
    // ),

);
$factura = new Factura($data);
var_dump($factura);

// echo $data['dFeEmiDE']->format('Y-m-d\TH:i:s');

// echo CDCHelper::decryptCDC('01800160967029015003289222023052912371717760');