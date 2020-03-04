## Introdução

Esse documento tem o objetivo de ser um passo a passo inicial para que você possa emitir as suas notas com SPED-NFE. Mas antes de começar vou dar uma breve explicação do que são as NF-e e como funciona o seu processo de emissão.

>*IMPORTANTE: Não deixe de estudar os manuais da SEFAZ e ver TODA a documentação desta pasta.*

## O que são NF-e/NFC-e?
Uma nota fiscal eletrônica nada mais é do que um arquivo XML que contém informações dos produtos vendidos ou serviços prestados por você com todas as informações tributárias necessárias exigidas pela receita. Esse arquivo é assinado com um certificado digital e enviado para a receita.

Segue um exemplo do XML gerado pelo framework ainda sem a assinatura do certificado e o protocolo.
```xml
<?xml version="1.0" encoding="UTF-8"?>
<NFe xmlns="http://www.portalfiscal.inf.br/nfe">
   <infNFe Id="NFe35180722633897000123550010000000101800700087" versao="4.00">
      <ide>
         <cUF>35</cUF>
         <cNF>80070008</cNF>
         <natOp>VENDA</natOp>
         <mod>55</mod>
         <serie>1</serie>
         <nNF>10</nNF>
         <dhEmi>2018-07-27T20:48:00-02:00</dhEmi>
         <dhSaiEnt>2018-07-27T20:48:00-02:00</dhSaiEnt>
         <tpNF>1</tpNF>
         <idDest>1</idDest>
         <cMunFG>3506003</cMunFG>
         <tpImp>1</tpImp>
         <tpEmis>1</tpEmis>
         <cDV>7</cDV>
         <tpAmb>2</tpAmb>
         <finNFe>1</finNFe>
         <indFinal>0</indFinal>
         <indPres>0</indPres>
         <procEmi>0</procEmi>
         <verProc>1</verProc>
      </ide>
      <emit>
         <CNPJ>99999999999999</CNPJ>
         <xNome>RAZÃO SOCIAL</xNome>
         <enderEmit>
            <xLgr>Rua Teste</xLgr>
            <nro>203</nro>
            <xBairro>Centro</xBairro>
            <cMun>3506003</cMun>
            <xMun>Bauru</xMun>
            <UF>SP</UF>
            <CEP>80045190</CEP>
            <cPais>1058</cPais>
            <xPais>BRASIL</xPais>
         </enderEmit>
         <IE>999999999999</IE>
         <CRT>3</CRT>
      </emit>
      <dest>
         <CNPJ>99999999999999</CNPJ>
         <xNome>NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL</xNome>
         <enderDest>
            <xLgr>Rua Teste</xLgr>
            <nro>203</nro>
            <xBairro>Centro</xBairro>
            <cMun>3506003</cMun>
            <xMun>Bauru</xMun>
            <UF>SP</UF>
            <CEP>80045190</CEP>
            <cPais>1058</cPais>
            <xPais>BRASIL</xPais>
         </enderDest>
         <indIEDest>2</indIEDest>
      </dest>
      <det nItem="1">
         <prod>
            <cProd>0001</cProd>
            <cEAN>SEM GTIN</cEAN>
            <xProd>Produto teste</xProd>
            <NCM>84669330</NCM>
            <CFOP>5102</CFOP>
            <uCom>PÇ</uCom>
            <qCom>1.0000</qCom>
            <vUnCom>10.99</vUnCom>
            <vProd>10.99</vProd>
            <cEANTrib>SEM GTIN</cEANTrib>
            <uTrib>PÇ</uTrib>
            <qTrib>1.0000</qTrib>
            <vUnTrib>10.99</vUnTrib>
            <indTot>1</indTot>
         </prod>
         <imposto>
            <vTotTrib>10.99</vTotTrib>
            <ICMS>
               <ICMS00>
                  <orig>0</orig>
                  <CST>00</CST>
                  <modBC>0</modBC>
                  <vBC>0.20</vBC>
                  <pICMS>18.0000</pICMS>
                  <vICMS>0.04</vICMS>
               </ICMS00>
            </ICMS>
            <IPI>
               <cEnq>999</cEnq>
               <IPITrib>
                  <CST>50</CST>
                  <vBC>0</vBC>
                  <pIPI>0</pIPI>
                  <vIPI>0</vIPI>
               </IPITrib>
            </IPI>
            <PIS>
               <PISNT>
                  <CST>07</CST>
               </PISNT>
            </PIS>
            <COFINS>
               <COFINSAliq>
                  <CST>01</CST>
                  <vBC>0</vBC>
                  <pCOFINS>0</pCOFINS>
                  <vCOFINS>0</vCOFINS>
               </COFINSAliq>
            </COFINS>
            <COFINSST>
               <vBC>0</vBC>
               <pCOFINS>0</pCOFINS>
               <vCOFINS>0</vCOFINS>
            </COFINSST>
         </imposto>
      </det>
      <total>
         <ICMSTot>
            <vBC>0.20</vBC>
            <vICMS>0.04</vICMS>
            <vICMSDeson>0.00</vICMSDeson>
            <vFCP>0.00</vFCP>
            <vBCST>0.00</vBCST>
            <vST>0.00</vST>
            <vFCPST>0.00</vFCPST>
            <vFCPSTRet>0.00</vFCPSTRet>
            <vProd>10.99</vProd>
            <vFrete>0.00</vFrete>
            <vSeg>0.00</vSeg>
            <vDesc>0.00</vDesc>
            <vII>0.00</vII>
            <vIPI>0.00</vIPI>
            <vIPIDevol>0.00</vIPIDevol>
            <vPIS>0.00</vPIS>
            <vCOFINS>0.00</vCOFINS>
            <vOutro>0.00</vOutro>
            <vNF>11.03</vNF>
            <vTotTrib>10.99</vTotTrib>
         </ICMSTot>
      </total>
      <transp>
         <modFrete>1</modFrete>
         <vol>
            <qVol>2</qVol>
            <esp>caixa</esp>
            <marca>OLX</marca>
            <nVol>11111</nVol>
            <pesoL>10</pesoL>
            <pesoB>11</pesoB>
         </vol>
      </transp>
      <pag>
         <detPag>
            <indPag>0</indPag>
            <tPag>01</tPag>
            <vPag>10.99</vPag>
         </detPag>
      </pag>
   </infNFe>
</NFe>
```
## Como vamos fazer isso?
Nesse passo a passo vamos passar por todas as etapas desse processo. 

- Primeiro: a montagem do XML, como no exemplo acima; 

- Segundo: a sua assinatura usando um certificado digital; 

- Terceiro: o envio para a receita. 

- Quarto: vamos consultar o nosso envio para ver se tudo ocorreu como nós esperamos;

- Por fim vamos pegar o protocolo que recebemos da consulta para armazenar no XML.

## Requisitos
Antes de falarmos de código, você precisa ter em mãos o seu certificado digital do tipo A1. Ele é um tipo de certificado que pode ser instalado no computador, normalmente um arquivo com a extensão *.pfx* que pode ser usado sem a necessidade de um token externo. Caso você não tenha o certificado você pode ir ao cartório da sua cidade que lá eles vão te auxiliar no processo para conseguir o seu.

Para a instalação do framework você precisa verificar se as seguintes extensões do PHP estão ativas no seu PHP:
* PHP 7+ (recomendável PHP 7.2 ou 7.3)
* ext-curl
* ext-dom
* ext-json
* ext-gd
* ext-mbstring
* ext-mcrypt
* ext-openssl
* ext-soap
* ext-xml
* ext-zip

Com as extensões devidamente instaladas, vá para a RAIZ do seu projeto e rodar o seguinte comando com o composer

*Para ambientes de testes e desenvolvimento:*
```bash
composer require nfephp-org/sped-nfe
```

*Para ambientes de Produção:*
```bash
composer require nfephp-org/sped-nfe --prefer-dist --update-no-dev --prefer-stable --optimize-autoloader
```

Dependendo do servidor, como um t2.micro (tier free da amazon), podem ocorrecer estouro de memoria ao rodar o composer. Para Esses casos pode-se fazer duas coisas:

1ª Alternativa) Rodar o comando acima precedido de:

```bash
php -d memory_limit=-1 'which composer' 
```

2ª Alternativa) Aumentar / Criar um swap no servidor. Swap é uma memoria auxiliar que em casos como estes, aonde o composer por exemplo da out of memory, ela ajuda o servidor dando, no exemplo abaixo, mais 500mb de memoria.

```bash
sudo su

swapon -s

dd if=/dev/zero of=/swapfile count=4096 bs=1MiB

chmod 600 /swapfile

mkswap /swapfile

swapon /swapfile

swapon -s

free -m


# AQUI VOCÊ IRA ABRIR O EDITOR NANO
nano /etc/fstab

# COLOQUE ESSE A LINHA ABAIXO DENTRO DO NANO
/swapfile   swap    swap    sw  0   0



# EDITE O ARQUIVO SYSCTL.CONF
nano /etc/sysctl.conf

# COLOQUE O COMANDO ABAIXO DENTRO DO ARQUIVO
vm.swappiness=10
vm.vfs_cache_pressure=50
```


Rodando esse comando vamos INCLUIR a última versão STABLE da API, como uma dependência do seu projeto, capaz de emitir NFe e NFCe na versão 4.0.

Se você não tem outras dependências, será criada uma pasta "vendor" na RAIZ de seu projeto, que conterá todas as dependências do seu projeto e as dos pacotes que você intalou com o composer. 

É de suma importância que entenda como funciona o [COMPOSER]() 

## Montar XML

Agora com a API devidamente instalada podemos partir para a montagem do XML. Vamos criar um arquivo *php* dentro do seu projeto e nele colocar o código abaixo.

**[Veja Make.md](Make.md)** Não se baseie somente nesse exemplo!


```php
<?php
require_once "vendor/autoload.php";

$nfe = new Make();
$std = new \stdClass();

$std->versao = '4.00';
$std->Id = null;
$std->pk_nItem = '';
$nfe->taginfNFe($std);

$std = new \stdClass();
$std->cUF = 35; //coloque um código real e válido
$std->cNF = '80070008';
$std->natOp = 'VENDA';
$std->mod = 55;
$std->serie = 1;
$std->nNF = 10;
$std->dhEmi = '2018-07-27T20:48:00-02:00';
$std->dhSaiEnt = '2018-07-27T20:48:00-02:00';
$std->tpNF = 1;
$std->idDest = 1;
$std->cMunFG = 3506003; //Código de município precisa ser válido
$std->tpImp = 1;
$std->tpEmis = 1;
$std->cDV = 2;
$std->tpAmb = 2; // Se deixar o tpAmb como 2 você emitirá a nota em ambiente de homologação(teste) e as notas fiscais aqui não tem valor fiscal
$std->finNFe = 1;
$std->indFinal = 0;
$std->indPres = 0;
$std->procEmi = '0';
$std->verProc = 1;
$nfe->tagide($std);

$std = new \stdClass();
$std->xNome = 'Razão social válida';
$std->IE = 'IE válido';
$std->CRT = 3;
$std->CNPJ = 'CNPJ válido';
$nfe->tagemit($std);

$std = new \stdClass();
$std->xLgr = "Rua Teste";
$std->nro = '203';
$std->xBairro = 'Centro';
$std->cMun = 3506003; //Código de município precisa ser válido e igual o  cMunFG
$std->xMun = 'Bauru';
$std->UF = 'SP';
$std->CEP = '80045190';
$std->cPais = '1058';
$std->xPais = 'BRASIL';
$nfe->tagenderEmit($std);

$std = new \stdClass();
$std->xNome = 'Empresa destinatário teste';
$std->indIEDest = 2;
$std->IE = 'IE válido';
$std->CNPJ = 'CNPJ válido';
$nfe->tagdest($std);

$std = new \stdClass();
$std->xLgr = "Rua Teste";
$std->nro = '203';
$std->xBairro = 'Centro';
$std->cMun = '3506003';
$std->xMun = 'Bauru';
$std->UF = 'SP';
$std->CEP = '80045190';
$std->cPais = '1058';
$std->xPais = 'BRASIL';
$nfe->tagenderDest($std);

$std = new \stdClass();
$std->item = 1;
$std->cEAN = 'SEM GTIN';
$std->cEANTrib = 'SEM GTIN';
$std->cProd = '0001';
$std->xProd = 'Produto teste';
$std->NCM = '84669330';
$std->CFOP = '5102';
$std->uCom = 'PÇ';
$std->qCom = '1.0000';
$std->vUnCom = '10.99';
$std->vProd = '10.99';
$std->uTrib = 'PÇ';
$std->qTrib = '1.0000';
$std->vUnTrib = '10.99';
$std->indTot = 1;
$nfe->tagprod($std);

$std = new \stdClass();
$std->item = 1;
$std->vTotTrib = 10.99;
$nfe->tagimposto($std);

$std = new \stdClass();
$std->item = 1;
$std->orig = 0;
$std->CST = '00';
$std->modBC = 0;
$std->vBC = '0.20';
$std->pICMS = '18.0000';
$std->vICMS = '0.04';
$nfe->tagICMS($std);

$std = new \stdClass();
$std->item = 1;
$std->cEnq = '999';
$std->CST = '50';
$std->vIPI = 0;
$std->vBC = 0;
$std->pIPI = 0;
$nfe->tagIPI($std);

$std = new \stdClass();
$std->item = 1;
$std->CST = '07';
$std->vBC = 0;
$std->pPIS = 0;
$std->vPIS = 0;
$nfe->tagPIS($std);

$std = new \stdClass();
$std->item = 1;
$std->vCOFINS = 0;
$std->vBC = 0;
$std->pCOFINS = 0;

$nfe->tagCOFINSST($std);

$std = new \stdClass();
$std->item = 1;
$std->CST = '01';
$std->vBC = 0;
$std->pCOFINS = 0;
$std->vCOFINS = 0;
$std->qBCProd = 0;
$std->vAliqProd = 0;
$nfe->tagCOFINS($std);

$std = new \stdClass();
$std->vBC = '0.20';
$std->vICMS = 0.04;
$std->vICMSDeson = 0.00;
$std->vBCST = 0.00;
$std->vST = 0.00;
$std->vProd = 10.99;
$std->vFrete = 0.00;
$std->vSeg = 0.00;
$std->vDesc = 0.00;
$std->vII = 0.00;
$std->vIPI = 0.00;
$std->vPIS = 0.00;
$std->vCOFINS = 0.00;
$std->vOutro = 0.00;
$std->vNF = 11.03;
$std->vTotTrib = 0.00;
$nfe->tagICMSTot($std);

$std = new \stdClass();
$std->modFrete = 1;
$nfe->tagtransp($std);

$std = new \stdClass();
$std->item = 1;
$std->qVol = 2;
$std->esp = 'caixa';
$std->marca = 'OLX';
$std->nVol = '11111';
$std->pesoL = 10.00;
$std->pesoB = 11.00;
$nfe->tagvol($std);

$std = new \stdClass();
$std->nFat = '002';
$std->vOrig = 100;
$std->vLiq = 100;
$nfe->tagfat($std);

$std = new \stdClass();
$std->nDup = '001';
$std->dVenc = date('Y-m-d');
$std->vDup = 11.03;
$nfe->tagdup($std);

$std = new \stdClass();
$std->vTroco = 0;
$nfe->tagpag($std);

$std = new \stdClass();
$std->indPag = 0;
$std->tPag = "01";
$std->vPag = 10.99;
$std->indPag=0;
$nfe->tagdetPag($std);

$xml = $nfe->getXML(); // O conteúdo do XML fica armazenado na variável $xml
```

>NOTA : a tag referente ao pagamento está descrita aqui [PAG](TagPag.md)

Esse exemplo são só alguns campos que podem ser preenchidos para emitir uma NF-e, mas existem muito mais. Abordar todos os campos seria bastante complicado, para cada situação a nota deve ser preenchida com um campo ou outro. Se você não tem um bom domínio sobre contabilidade o meu conselho é sempre perguntar para alguém que saiba como deve ser preenchida a nota na situação em questão.

> Para saber todos os campos suportados pelo framework acesse o link da documentação https://github.com/nfephp-org/sped-nfe/blob/master/docs/Make.md

## Assinar XML
Antes de assinarmos o XML precisamos criar um variável em *JSON* com os dados que o framework vai precisar para os próximos passos.

**[Veja Config](Config.md)**

```php

$config  = [
      "atualizacao"=>date('Y-m-d h:i:s'),
      "tpAmb"=> 2,
      "razaosocial" => "RAZAO SOCIAL DO EMISSOR",
      "cnpj" => "99999999999999", // PRECISA SER VÁLIDO
      "ie" => '999999999999', // PRECISA SER VÁLIDO
      "siglaUF" => "SP",
      "schemes" => "PL_009_V4",
      "versao" => '4.00',
      "tokenIBPT" => "AAAAAAA",
      "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
      "CSCid" => "000002",
      "aProxyConf" => [
          "proxyIp" => "",
          "proxyPort" => "",
          "proxyUser" => "",
          "proxyPass" => ""
      ]
  ]

$configJson = json_encode($config);
```
E vamos precisar do certificado digital mencionado anteriormente.
```php
$certificadoDigital = file_get_contents('certificado.pfx');
```

Agora que temos o nosso *$xml* gerado do passo anterior, a *$configJson* e o nosso $certificadoDigital* já estamos pronto para assiná-lo.

**[Veja documentação sobre o Certificado](https://github.com/nfephp-org/sped-common/blob/master/docs/Certificate.md)**

**[Classe Tools](Tools.md)**

Cole os seguinte código no seu arquivo *php*. Lembrando de substituir a *'senha do certificado'* pela senha correta.
```php
$tools = new NFePHP\NFe\Tools($configJson, NFePHP\Common\Certificate::readPfx($certificadoDigital, 'senha do certificado'));
try {
    $xmlAssinado = $tools->signNFe($xml); // O conteúdo do XML assinado fica armazenado na variável $xmlAssinado
} catch (\Exception $e) {
    //aqui você trata possíveis exceptions da assinatura
    exit($e->getMessage());
}
```
> Mais uma vez caso precise de mais detalhes sobre como funciona o método de assinatura você pode consultar a documentação acessando o link https://github.com/nfephp-org/sped-nfe/blob/master/docs/metodos/SignNFe.md

## Enviar Lote
Para o envio do lote vamos precisar da *$configJson*, *$certificadoDigital* e do nosso XML assinado que está na variável *$xmlAssinado*. Esse método recebe um array com os XMLs nos permitindo enviar mais de um XML por vez, mas nesse caso vamos enviar somente um.

>NOTA: o primeiro paramêtro do método $tools->sefazEnviaLote é um array pois podem ser envidas até 50 NFe por vez desde que não ultrapassem o limite de kBytes estabelecido (veja documentação SEFAZ)

```php
try {
    $idLote = str_pad(100, 15, '0', STR_PAD_LEFT); // Identificador do lote
    $resp = $tools->sefazEnviaLote([$xmlAssinado], $idLote);

    $st = new NFePHP\NFe\Common\Standardize();
    $std = $st->toStd($resp);
    if ($std->cStat != 103) {
        //erro registrar e voltar
        exit("[$std->cStat] $std->xMotivo");
    }
    $recibo = $std->infRec->nRec; // Vamos usar a variável $recibo para consultar o status da nota
} catch (\Exception $e) {
    //aqui você trata possiveis exceptions do envio
    exit($e->getMessage());
}
```

[TimeOUT e outros problemas](TimeOut.md)

[Quando e como usar Contingência](Contingency.md)

Usamos a classe *Standardize* para converter o XML retornado pela receita para o formato *StdClass* assim caso o atributo *$std->cStat* retorne algo diferente de 103 sabemos algo deu errado no envio do lote para a receita.

> Caso você precise de mais detalhes acesse o link da documentação https://github.com/nfephp-org/sped-nfe/blob/master/docs/metodos/EnviaLote.md

## Consultar Recibo
Com o recibo retornado pelo método *sefazEnviaLote* vamos ver se nota foi autorizada ou rejeitada pela receita. Vamos precisar da *$configJson*, *$certificadoDigital* e do número de recibo que temos na variável *$recibo*.
```php
try {
    $protocolo = $tools->sefazConsultaRecibo($recibo);
} catch (\Exception $e) {
    //aqui você trata possíveis exceptions da consulta
    exit($e->getMessage());
}
```
> Para detalhes acesse o link da documentação https://github.com/nfephp-org/sped-nfe/blob/master/docs/metodos/ConsultaRecibo.md

Agora com variável *$protocolo* temos o resultado se a nossa nota foi autorizada ou rejeitada.

## Finalizando o processo
Agora que enviamos a nota, consultamos o seu status, vamos trabalhar a com a situação a onde tudo deu certo e a nota foi autorizada. Precisamos guardar esse protocolo dentro do nosso XML, vamos pegar a nossa *$xmlAssinado* e a *$protocolo* e usar o código abaixo.
```php
use NFePHP\NFe\Complements;

$request = "<XML conteudo original do documento que quer protocolar>";
$response = "<XML conteudo do retorno com a resposta da SEFAZ>";

try {
    $xml = Complements::toAuthorize($request, $response);
    header('Content-type: text/xml; charset=UTF-8');
    echo $xml;
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
```
ATENÇÃO: Utilize o método correto da classe `Complements` para cada tipo de evento (Autorização, Cancelamento, e outros), veja abaixo um exemplo protocolando Cancelamento:

**[Veja como protocolar cada evento na NF-e](Complements.md)**

Por fim usamos o *file_put_contents* para criar um arquivo XML em disco para aguardar essa nota. A receita exige que você guarde os XMLs das suas notas pelo menos por 5 anos, então cuida bem delas.
```php
file_put_contents('nota.xml',$xmlProtocolado);
```

## Conclusão
A ideia com esse passo a passo é dar um ponta pé inicial para quem nunca emitiu uma Nf-e/Nfc-e, mostrando o passo a passo necessário para enviar um nota para receita.

# LEIAM E ESTUDEM A DOCUMENTAÇÃO TODA !!!!!
