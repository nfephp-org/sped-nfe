<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '/var/www/sped/sped-nfe/bootstrap.php';

use NFePHP\Common\Certificate;

$certs = [
    'cert_cnpj_06157250000116_senha_minhasenha.pfx' => 'minhasenha',
    'cert_cpf_90483926086_minhasenha.pfx' => 'minhasenha',
    'expired_certificate.pfx' => 'associacao',
    'test_certificate.pfx' => 'nfephp',
];
foreach ($certs as $file => $pass) {
    echo "\n\n";
    echo "Convertendo {$file} \n";
    try {
        $content = file_get_contents(__DIR__ . '/' . $file);;
        $cert = Certificate::readPfx($content, $pass);
        $pfx = $cert->writePfx($pass);
        file_put_contents(__DIR__ . "/novo_{$file}", $pfx);
    } catch (\Exception $e) {
        echo $e->getMessage();
        echo "\n";
    }
}

