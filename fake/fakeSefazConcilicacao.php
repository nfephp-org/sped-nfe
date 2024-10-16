<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;
use NFePHP\NFe\Common\FakePretty;

try {
    $arr = [
        "atualizacao" => "2016-11-03 18:01:21",
        "tpAmb"       => 2,
        "razaosocial" => "SUA RAZAO SOCIAL LTDA",
        "cnpj"        => "99999999999999",
        "siglaUF"     => "MG",
        "schemes"     => "PL_009_V4",
        "versao"      => '4.00',
        "tokenIBPT"   => "AAAAAAA",
        "CSC"         => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
        "CSCid"       => "000001",
        "proxyConf"   => [
            "proxyIp"   => "",
            "proxyPort" => "",
            "proxyUser" => "",
            "proxyPass" => ""
        ]
    ];
    $configJson = json_encode($arr);
    $soap = new SoapFake();
    $soap->disableCertValidation(true);

    $content = file_get_contents('expired_certificate.pfx');
    $tools = new Tools($configJson, Certificate::readPfx($content, 'associacao'));
    $tools->model('55');
    $tools->setVerAplic('5.1.34');
    $tools->loadSoapClass($soap);

    $std = new \stdClass();
    //$std->verAplic = '1.2.3'; //opcional se declarado anteriormente - versão da aplicação que está gerando o evento
    $std->nSeqEvento = 1;
    $std->chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $std->detPag[0] = new \stdClass();
    $std->detPag[0]->indPag = null; //opcional 0-Pagamento à Vista;  1-Pagamento à Prazo
    $std->detPag[0]->tPag = '04'; //Obrigatório forma de pagamento
        //            '01' => 'Dinheiro',
        //                '02' => 'Cheque',
        //                '03' => 'Cartão de Crédito',
        //                '04' => 'Cartão de Débito',
        //                '05' => 'Cartão da Loja',
        //                '10' => 'Vale Alimentação',
        //                '11' => 'Vale Refeição',
        //                '12' => 'Vale Presente',
        //                '13' => 'Vale Combustível',
        //                '14' => 'Duplicata Mercantil',
        //                '15' => 'Boleto',
        //                '16' => 'Depósito Bancário',
        //                '17' => 'PIX Dinâmico',
        //                '18' => 'Transferência bancária, Carteira Digital',
        //                '19' => 'Programa fidelidade, Cashback, Créd Virt',
        //                '20' => 'PIX Estático',
        //                '21' => 'Crédito em Loja',
        //                '22' => 'Pagamento Eletrônico não Informado - Falha de hardware',
        //                '90' => 'Sem pagamento',
        //                '99' => 'Outros'
    $std->detPag[0]->xPag = null; //opcional de 2 a 50 caracteres, usar quando tPag == 99
    $std->detPag[0]->vPag = 102.34; //Obrigatório valor pago
    $std->detPag[0]->dPag = '2024-07-30'; //Obrigatório data do pagamento

    //grupo OPCIONAL de informações sobre envolvidos no pagamento

    $std->detPag[0]->CNPJPag = '12345678901234'; //opcional, caso seja informado a UFPag também deverá ser informada
    // CNPJ transacional do pagamento - Preencher informando o CNPJ do estabelecimento onde o pagamento foi
    // processado/transacionado/recebido quando a emissão do documento fiscal ocorrer em estabelecimento distinto

    $std->detPag[0]->UFPag = 'SP'; //opcional, caso seja informado a CNPJPag também deverá ser informada
    // UF do CNPJ do estabelecimento onde o pagamento foi processado/transacionado/recebido

    $std->detPag[0]->CNPJIF = '11111111111111'; //opcinal
    //CNPJ da instituição financeira, de pagamento, adquirente ou subadquirente.

    $std->detPag[0]->tBand = '20'; //opcional Bandeira da operadora de cartão
    //01    Visa
    //02    Mastercard
    //03    American Express
    //04    Sorocred
    //05    Diners Club
    //06    Elo
    //07    Hipercard
    //08    Aura
    //09    Cabal
    //10    Alelo
    //11    Banes Card
    //12    CalCard
    //13    Credz
    //14    Discover
    //15    GoodCard
    //16    GreenCard
    //17    Hiper
    //18    JcB
    //19    Mais
    //20    MaxVan
    //21    Policard
    //22    RedeCompras
    //23    Sodexo
    //24    ValeCard
    //25    Verocheque
    //26    VR
    //27    Ticket
    //99    Outros
    $std->detPag[0]->cAut = 'a23232-49329fed'; //opcional Número de autorização da operação com cartões, PIX, boletos e outros
    // pagamentos eletrônicos

    //grupo OPCIONAL de informações sobre o
    $std->detPag[0]->CNPJReceb = '09876543210987';//opcional CNPJ do estab. benefic. do pag., se informado informar também a UFReceb
    $std->detPag[0]->UFReceb = 'CE'; //opcional se informado informar também a CNPJReceb

    $std->cancelar = false; //permite cancelar um registro de conciliação financeira anterior

    //para cancelar
    //$std->cancela = true;
    //$std->protocolo = '750123456789012';

    $response = $tools->sefazConciliacao($std);

    echo FakePretty::prettyPrint($response);
} catch (\Exception $e) {
    echo $e->getMessage();
}
