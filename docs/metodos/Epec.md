# CONTINGENCIA EPEC Evento Prévio de Emissão em Contingência

A emissão do EPEC poderá ser adotada por qualquer emissor que esteja impossibilitado de transmissão e/ou recepção das autorizações de uso de suas NF-e.

O evento EPEC não é uma contignência completa como SVCAN ou SVCRS, é apenas uma forma de antecipar o envio OFICIAL na NFe. Esse evento autoriza provisóriamente a circulação da mercadoria, mas não confima a autorização definitiva do documento fiscal.

Além disso existem outra implicações em emitir por EPEC, pois a emissão REAL (com o envio do XML da NFe) ficará dependente da sincronização entre a Receita e a Sefaz autorizadora, somente após essa sincronização é que a NFe será processada e aceita (ou rejeitada) pela autorizadora.


**Função:** serviço destinado à recepção de evento EPEC de NF-e.

**Processo:** síncrono.

**Método:** nfeRecepcaoEvento


```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Complements;

try {

// carrega os dados do emitente
    $config = [
        "atualizacao" => "2015-10-02 06:01:21",
        "tpAmb" => 2,
        "razaosocial" => "Fake Materiais de construção Ltda",
        "siglaUF" => "SP",
        "cnpj" => "00716345000119",
        "schemes" => "PL_008i2",
        "versao" => "3.10",
        "tokenIBPT" => "AAAAAAA",
        "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
        "CSCid" => "000002",
        "aProxyConf" => [
            "proxyIp" => "",
            "proxyPort" => "",
            "proxyUser" => "",
            "proxyPass" => ""
        ]
    ];

    $configJson = json_encode($config);

// habilita a contingência EPEC, isso tem finalidade de permitir que o 
// emitente controle a data e o motivo de entrada em contingência
    $contingency = new Contingency();
    $acronym = 'SP';
    $motive = 'Lentidão extrema na SEFAZ autorizadora';
    $type = 'EPEC';
//guarde o json retornado para uso futuro
    $contingency_status_json = $contingency->activate($acronym, $motive, $type);

//carregue a classe Tools com o certificado
    $content = file_get_contents('certificado.pfx');
    $tools = new Tools($configJson, Certificate::readPfx($content, 'senha'));
    $tools->model(55);
    $tools->setVerAplic('4.16.23'); //versão da aplicação que está emititindo o documento
    
//seta a contingência a classe tools
    $tools->contingency = $contingency;
    
// carregue o xml da NFe gerado normalmente e que deseja enviar como evento EPEC.
    $xml = "<Nfe>..."; //xml de nfe modelo 55 
    
//envia o xml para pedir autorização a Receita Federal
    $response = $this->tools->sefazEPEC($xml);

//transforma o xml de retorno em um stdClass
    $st = new Standardize();
    $std = $st->toStd($response);

    if ($std->cStat != 128) {
//erro registrar e voltar, pois a operação não pode ser realizada
        return "[$std->cStat] $std->xMotivo";
    }

    $cStat = $std->retEvento->infEvento->cStat;
    $xMotivo = $std->retEvento->infEvento->xMotivo;
    if ($cStat != 136) {
//erro registrar e voltar, pois a operação não pode ser realizada 
        return "[$cStat] $xMotivo";
    }

//sucesso!! o evento foi recebido e registrado


//obter a chave do documento (pode ter sdo alterada durante o processamento)
   $chave = $std->retEvento->infEvento->chNFe;

//protocolar a guardar o evento EPEC
    $envproc = Complements::toAuthorize($tools->lastRequest, $response);
    file_put_contents("110140-{$chave}-procEv.xml", $envproc); 

// é importante que o xml da NFe fique guardado para envio ao SEFAZ autorizadora
// essa operação epec irá modificar o xml original, inclusive a sua CHAVE
// e a assinatura digital.
    file_put_contents("{$chave}-nfe.xml", $xml);

// IMPORTANTE: esse documento ainda não está autorizado de forma definitiva !!!
// para encerrar o processo esse documento deverá ser enviado a SEFAZ 
// quando não estiver mais em contingência EPEC e sim com a operação NORMAL !!!

    header('Content-type: text/xml; charset=UTF-8');
    echo $response;

} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}

```