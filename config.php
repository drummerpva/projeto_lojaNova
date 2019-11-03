<?php

require './environment.php';
global $db;
global $config;
if (ENVIRONMENT == "development") {
    define("BASE_URL", "http://localhost/projeto_lojaNova/");
    $config['dbname'] = "projeto_lojaNova";
    $config['host'] = "localhost";
    $config['dbuser'] = "root";
    $config['dbpass'] = "";
} else {
    define("BASE_URL", "http://meusite.com.br/");
    $config['dbname'] = "estrutura_mvc";
    $config['host'] = "localhost";
    $config['dbuser'] = "root";
    $config['dbpass'] = "";
}
$config['default_lang'] = 'pt-br';
$config['cepOrigin'] = "89370000";
try {
    $db = new PDO("mysql:dbname=" . $config['dbname'] . ";host=" . $config['host'] . ";charset=utf8", $config['dbuser'], $config['dbpass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
    die("Erro BD: " . $ex->getMessage());
}
//Mercado Pago
$config['mpAppId'] = "8024304316171755";
$config['mpKey'] = "k13VwBnihDxWUB5O3HMs91xWdsV85lRX";
//Paypal
$config['paypalClienteId'] = "AZylEF1WK2k2HSwejx5gYjogzM4GxN9CcXEkGYSIwKWLyzBb75X4OjWun6kqgy5LAcOhh7ZBXK2NlcNQ";
$config['paypalSecret'] = "EHqSwKLXY4sh2Jxy6TJnwPHTnowt2LZpgnANUb1qRFcJPXbjhKWb6vqlRVdiRqmGCq34bjz8FrF99QWZ";
//Gerencianet
$config['gerencianetClientId'] = "Client_Id_d691925e4df1be5f36630db54b8f0bb2bfc9a841";
$config['gerencianetSecret'] = "Client_Secret_5e9c49aa292cd5bf7684831d406f214337d27657";
$config['gerencianetSandbox'] = true;
//PagSeguro
$config['pagseguroSeller'] = "pia_da_lan@yahoo.com.br";
\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("NovaLojaTeste de PVA")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("NovaLojaTeste de PVA")->setRelease("1.0.0");

\PagSeguro\Configuration\Configure::setEnvironMent('sandbox');
\PagSeguro\Configuration\Configure::setAccountCredentials($config['pagseguroSeller'], "C94D50122E9447AABB81CEFF605C905F");
\PagSeguro\Configuration\Configure::setCharset("UTF-8");
\PagSeguro\Configuration\Configure::setLog(true, "pagseguro.log");
