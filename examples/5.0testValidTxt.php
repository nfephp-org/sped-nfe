<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Common\ValidTXT;

$txt = file_get_contents('fixtures/nfe_errado.txt');
$errors = ValidTXT::isValid($txt);

echo "<pre>";
print_r($errors);
echo "</pre>";