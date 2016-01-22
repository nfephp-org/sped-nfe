<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
include 'vendor/autoload.php';

$nfe = new NFePHP\NFe\Make();

$param = [
    'chave' => '35160271805063000163550010000203101013350023',
    'versao' => '3.10'
];
$return = $nfe->infNFe($param);

$dadosDaNFe = [
    'cUF' => '35',
    'cNF' => '01335002',
    'natOp' => 'VENDA DE PRODUTO',
    'indPag' => '1',
    'mod' => '55',
    'serie' => '1',
    'nNF' => '20310',
    'dhEmi' => '2016-01-20T12:01:00-2.00',
    'dhSaiEnt' => '2016-01-20T12:01:00-2.00',
    'tpNF' => '1',
    'idDest' => '1',
    'cMunFG' => '3550308',
    'tpImp' => '1',
    'tpEmis' => '1',
    'cDV' => '3',
    'tpAmb' => '2',
    'finNFe' => '1',
    'indFinal' => '0',
    'indPres' => '9',
    'procEmi' => '0',
    'verProc' => 'PL_008h2'
];
$return = $nfe->ide($dadosDaNFe);

$emitente = [
    'CNPJ' => '58716523000119',
    'CPF' => '',
    'xNome' => 'FIMATEC TEXTIL LTDA',
    'xFant' => 'FIMATEC',
    'IE' => '112006603110',
    'IEST' => '',
    'IM' => '95095870',
    'CNAE' => '0131380',
    'CRT' => '3'
];
$return = $nfe->emit($emitente);

$refNFe = [
  'refNFe' => '35150300822602000124550010009923461099234656'  
];
$nfe->refNFe($refNFe);

$param = [
    'infAdFisco'=>'Teste infAdFisco',
    'infCpl'=>'Teste infCpl'
];
$return = $nfe->infAdic($param);


//var_dump($nfe);
echo "<BR><BR><BR>";
echo $nfe->infNFe->chave;

