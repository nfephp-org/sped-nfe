<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Make;
use NFePHP\NFe\Tools;

$nfe = new Make();

$nfeTools = new Tools('../config/config.json');

//Dados da NFCe - infNFe
$cUF = '52';
$cNF = '00000200';
$natOp = 'Venda ao consumidor';
$indPag = '0';
$mod  = '65';
$serie = '1';
$nNF = '200';
$dhEmi = date("Y-m-d\TH:i:sP");//Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
$dhSaiEnt = '';//Não informar este campo para a NFC-e.
$tpNF = '1';
$idDest = '1';
$cMunFG = '5208707';
$tpImp = '4';
$tpEmis = '1'; //normal
$tpAmb = '2'; //homolocação
$finNFe = '1';
$indFinal = '1';
$indPres = '1';
$procEmi = '0';
$verProc = '4.0.43';
$dhCont = '';
$xJust = '';

$ano = date('y', strtotime($dhEmi));
$mes = date('m', strtotime($dhEmi));
$cnpj = $nfeTools->aConfig['cnpj'];
$chave = $nfe->montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $nNF, $tpEmis, $cNF);
$versao = '3.10';
$resp = $nfe->taginfNFe($chave, $versao);

//digito verificador
$cDV = substr($chave, -1);

//tag IDE
$resp = $nfe->tagide(
    $cUF,
    $cNF,
    $natOp,
    $indPag,
    $mod,
    $serie,
    $nNF,
    $dhEmi,
    $dhSaiEnt,
    $tpNF,
    $idDest,
    $cMunFG,
    $tpImp,
    $tpEmis,
    $cDV,
    $tpAmb,
    $finNFe,
    $indFinal,
    $indPres,
    $procEmi,
    $verProc,
    $dhCont,
    $xJust
);

//Dados do emitente
$CNPJ = $nfeTools->aConfig['cnpj'];
$CPF = ''; // Utilizado para CPF na nota
$xNome = $nfeTools->aConfig['razaosocial'];
$xFant = $nfeTools->aConfig['nomefantasia'];
$IE = $nfeTools->aConfig['ie'];
$IEST = ''; //NFC-e não deve informar IE de Substituto Tributário
$IM = $nfeTools->aConfig['im'];
$CNAE = $nfeTools->aConfig['cnae'];
$CRT = $nfeTools->aConfig['regime'];
$resp = $nfe->tagemit($CNPJ, $CPF, $xNome, $xFant, $IE, $IEST, $IM, $CNAE, $CRT);

//endereço do emitente
$xLgr = 'Rua 144';
$nro = '636';
$xCpl = 'Qd. 50 Lt. 23/24, Sala 6 Res. Mendonça';
$xBairro = 'Setor Marista';
$cMun = '5208707';
$xMun = 'Goiânia';
$UF = 'GO';
$CEP = '74170030';
$cPais = '1058';
$xPais = 'Brasil';
$fone = '6241010313';
$resp = $nfe->tagenderEmit($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

//destinatário
/*$CNPJ = '';
$CPF = '';
$idEstrangeiro = '';
$xNome = '';
$indIEDest = '9';
$IE = '';
$ISUF = '';
$IM = '';
$email = '';
$resp = $nfe->tagdest($CNPJ, $CPF, $idEstrangeiro, $xNome, $indIEDest, $IE, $ISUF, $IM, $email);*/

//Endereço do destinatário
/*$xLgr = '';
$nro = '';
$xCpl = '';
$xBairro = '';
$cMun = '';
$xMun = '';
$UF = '';
$CEP = '';
$cPais = '';
$xPais = '';
$fone = '';
$resp = $nfe->tagenderDest($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);*/

$nItem = 1;
$cProd = '142';
$cEAN = '97899072659522';
$xProd = 'Chopp Originale 330ml';
$NCM = '22030000';
$NVE = '';
$CEST = '0302300'; // Convênio ICMS 92/15
$EXTIPI = '';
$CFOP = '5405'; //CSOSN 500 = 5.405, 5.656 ou 5.667
$uCom = 'Un';
$qCom = '2';
$vUnCom = '6.00';
$vProd = '12.00';
$cEANTrib = '';
$uTrib = 'Un';
$qTrib = '2';
$vUnTrib = '6.00';
$vFrete = '';
$vSeg = '';
$vDesc = '';
$vOutro = '';
$indTot = '1';
$xPed = '506';
$nItemPed = '1';
$nFCI = '';
$resp = $nfe->tagprod($nItem, $cProd, $cEAN, $xProd, $NCM, $NVE, $CEST, $EXTIPI, $CFOP, $uCom, $qCom, $vUnCom, $vProd, $cEANTrib, $uTrib, $qTrib, $vUnTrib, $vFrete, $vSeg, $vDesc, $vOutro, $indTot, $xPed, $nItemPed, $nFCI);

//imposto
$nItem = 1;
$vTotTrib = '0.16';
$resp = $nfe->tagimposto($nItem, $vTotTrib);

//ICMS
/*$nItem = 1;
$orig = '0';
$cst = '60';//Simples nacional
$modBC = '3';
$pRedBC = '';
$vBC = '12.00'; // = $qTrib * $vUnTrib 
$pICMS = '19.00'; //17% Alíquota Interna + 2% FECP
$vICMS = '2.28'; // = $vBC * ( $pICMS / 100 )
$vICMSDeson = '';
$motDesICMS = '';
$modBCST = '';
$pMVAST = '';
$pRedBCST = '';
$vBCST = '';
$pICMSST = '';
$vICMSST = '';
$pDif = '';
$vICMSDif = '';
$vICMSOp = '';
$vBCSTRet = '';
$vICMSSTRet = '';
$resp = $nfe->tagICMS($nItem, $orig, $cst, $modBC, $pRedBC, $vBC, $pICMS, $vICMS, $vICMSDeson, $motDesICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pDif, $vICMSDif, $vICMSOp, $vBCSTRet, $vICMSSTRet);*/

//ICMSSN - Tributação ICMS pelo Simples Nacional - CSOSN 500
$nItem = 1;
$orig = '0';
$csosn = '500'; //ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação
$modBC = '1';
$pRedBC = '';
$vBC = ''; //12.00 = $qTrib * $vUnTrib 
$pICMS = ''; //19.00 = 17% Alíquota Interna + 2% FECP
$vICMS = ''; //2.28 = $vBC * ( $pICMS / 100 )
$pCredSN = '';
$vCredICMSSN = '';
$modBCST = '';
$pMVAST = '';
$pRedBCST = '';
$vBCST = '';
$pICMSST = ''; //27.00 = GO para GO
$vICMSST = '';
$vBCSTRet = '12.00'; // Pauta do Chope Claro 1000ml em GO R$ 8,59 x 0.660 Litros
$vICMSSTRet = '0.96'; // = (Valor da Pauta * Alíquota ICMS ST) - Valor ICMS Próprio
$resp = $nfe->tagICMSSN($nItem, $orig, $csosn, $modBC, $vBC, $pRedBC, $pICMS, $vICMS, $pCredSN, $vCredICMSSN, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $vBCSTRet, $vICMSSTRet);

//PIS
$nItem = 1;
$cst = '01'; //Operação Tributável (base de cálculo = (valor da operação * alíquota normal) / 100
$vBC = '4.62';
$pPIS = '0.65';
$vPIS = '0.03';
$qBCProd = '';
$vAliqProd = '';
$resp = $nfe->tagPIS($nItem, $cst, $vBC, $pPIS, $vPIS, $qBCProd, $vAliqProd);

//COFINS
$nItem = 1;
$cst = '01'; //Operação Tributável (base de cálculo = (valor da operação * alíquota normal) / 100
$vBC = '4.62';
$pCOFINS = '3.00';
$vCOFINS = '0.13';
$qBCProd = '';
$vAliqProd = '';
$resp = $nfe->tagCOFINS($nItem, $cst, $vBC, $pCOFINS, $vCOFINS, $qBCProd, $vAliqProd);

//Inicialização de váriaveis não declaradas...
$vII = isset($vII) ? $vII : 0;
$vIPI = isset($vIPI) ? $vIPI : 0;
$vIOF = isset($vIOF) ? $vIOF : 0;
$vPIS = isset($vPIS) ? $vPIS : 0;
$vCOFINS = isset($vCOFINS) ? $vCOFINS : 0;
$vICMS = isset($vICMS) ? $vICMS : 0;
$vBCST = isset($vBCST) ? $vBCST : 0;
$vST = isset($vST) ? $vST : 0;
$vISS = isset($vISS) ? $vISS : 0;

//total
$vBC = '0.00';
$vICMS = '0.00';
$vICMSDeson = '0.00';
$vBCST = '0.00';
$vST = '0.00';
$vProd = '12.00';
$vFrete = '0.00';
$vSeg = '0.00';
$vDesc = '0.00';
$vII = '0.00';
$vIPI = '0.00';
$vPIS = '0.03';
$vCOFINS = '0.13';
$vOutro = '0.00';
$vNF = number_format($vProd-$vDesc-$vICMSDeson+$vST+$vFrete+$vSeg+$vOutro+$vII+$vIPI, 2, '.', '');
$vTotTrib = number_format($vICMS+$vST+$vII+$vIPI+$vPIS+$vCOFINS+$vIOF+$vISS, 2, '.', '');
$resp = $nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);

//frete
$modFrete = '9'; //Sem frete
$resp = $nfe->tagtransp($modFrete);

//pagamento
$tPag = '01'; //Dinheiro
$vPag = '2.00';
$rest = $nfe->tagpag($tPag, $vPag);
$tPag = '02'; //Cheque
$vPag = '10.00';
$rest = $nfe->tagpag($tPag, $vPag);

// Calculo de carga tributária similar ao IBPT - Lei 12.741/12
$federal = number_format($vII+$vIPI+$vIOF+$vPIS+$vCOFINS, 2, ',', '.');
$estadual = number_format($vICMS+$vST, 2, ',', '.');
$municipal = number_format($vISS, 2, ',', '.');
$totalT = number_format($federal+$estadual+$municipal, 2, ',', '.');
$textoIBPT = "Valor Aprox. Tributos R$ {$totalT} - {$federal} Federal, {$estadual} Estadual e {$municipal} Municipal.";

//informações Adicionais
$infAdFisco = "";
$infCpl = "Pedido Nº506 - {$textoIBPT}";
$resp = $nfe->taginfAdic($infAdFisco, $infCpl);

//Monta a NFCe e retorna na tela
$resp = $nfe->montaNFe();
if ($resp) {
    $xml = $nfe->getXML();
    //$filename = "/var/www/nfe/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Linux
    $filename = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Windows
    file_put_contents($filename, $xml);
    chmod($filename, 0777);    
    //Assina (e gera o QR-Code...)
    $xml = $nfeTools->assina($xml);
    //$filename = "/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Linux
    $filename = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Windows
    file_put_contents($filename, $xml);
    chmod($filename, 0777);
    if (! $nfeTools->validarXml($xml) || sizeof($nfeTools->errors)) {
        echo "<h3>Eita !?! Tem bicho na linha .... </h3>";
        foreach ($nfeTools->errors as $erro) {
            if (is_array($erro)) { 
                foreach ($erro as $err) {
                    echo "$err <br>";
                }
            } else {
                echo "$erro <br>";
            }
        }
        exit;
    } else {
        header('Content-type: text/xml; charset=UTF-8');
        echo $xml;
    }
} else {
    header('Content-type: text/html; charset=UTF-8');
    foreach ($nfe->erros as $err) {
        echo 'tag: &lt;'.$err['tag'].'&gt; ---- '.$err['desc'].'<br>';
    }
}
