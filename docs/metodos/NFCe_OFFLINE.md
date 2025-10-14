# Como gerar uma NFCe em Contingência OFFLINE

## 1 - Crie a NFCe usando a classe Make

```php
    $make = new Make();

    $std = new \stdClass();
    $std->Id = '';
    $std->versao = '4.00';
    $infNFe = $make->taginfNFe($std);

//ide OBRIGATÓRIA
    $std = new \stdClass();
    $std->cUF = 21;
    $std->cNF = null;
    $std->natOp = 'VENDA AO CONSUMIDOR';
    $std->mod = 65; //NFCe
    $std->serie = 1;
    $std->nNF = 100;
    $std->dhEmi = '2025-07-08T10:03:33-03:00';
    $std->dhSaiEnt = null;
    $std->tpNF = 1;
    $std->idDest = 3;
    $std->cMunFG = 2111300;
    $std->tpImp = 1;
    $std->tpEmis = 9; //EMISÃO OFFLINE
    $std->cDV = null;
    $std->tpAmb = 2;
    $std->finNFe = 1;
    $std->indFinal = 1;
    $std->indPres = 1;
    $std->indIntermed = 0;
    $std->procEmi = 3;
    $std->verProc = '4.13';
    $std->dhCont = '2025-07-08T10:03:33-03:00';
    $std->xJust = 'Entrada em contingência automática por falha na internet local';
    $ide = $make->tagIde($std);

    $std = new \stdClass();
    $std->xNome = 'FULANO LTDA';
    $std->xFant = 'FULANO';
    $std->IE = '11233335555';
    $std->IEST = null;
//$std->IM = '95095870';
    $std->CNAE = '4755502';
    $std->CRT = 1;
    $std->CNPJ = '20221324000167';
//$std->CPF = '12345678901'; //NÃO PASSE TAGS QUE NÃO EXISTEM NO CASO
    $emit = $make->tagemit($std);

//enderEmit OBRIGATÓRIA
    $std = new \stdClass();
    $std->xLgr = 'RUA 10';
    $std->nro = '897';
    $std->xCpl = 'LJ 01';
    $std->xBairro = 'Sto Antonio';
    $std->cMun = 2111300;
    $std->xMun = 'São Luis';
    $std->UF = 'MA';
    $std->CEP = '65091514';
    $std->cPais = 1058;
    $std->xPais = 'Brasil';
    $std->fone = '9820677300';
    $ret = $make->tagenderemit($std);

//prod OBRIGATÓRIA
    $std = new \stdClass();
    $std->item = 1;
    $std->cProd = '23qq';
    $std->cEAN = "SEM GTIN";//'6361425485451';
    $std->xProd = 'Fita de seda azul';
    $std->NCM = '500790';
//$std->cBenef = 'ab222222';
    $std->EXTIPI = null;
    $std->CFOP = 5102;
    $std->uCom = 'MT';
    $std->qCom = 10;
    $std->vUnCom = 10;
    $std->vProd = 100;
    $std->cEANTrib = "SEM GTIN";//'6361425485451';
    $std->uTrib = 'MT';
    $std->qTrib = 10;
    $std->vUnTrib = 10;
//$std->vFrete = 100.00;
//$std->vSeg = 0.00;
//$std->vDesc = 0.00;
//$std->vOutro = 0.00;
    $std->indTot = 1;
//$std->xPed = '12345';
//$std->nItemPed = 1;
//$std->nFCI = '12345678-1234-1234-1234-123456789012';
    $prod = $make->tagprod($std);

    $tag = new \stdClass();
    $tag->item = 1;
    $tag->infAdProd = 'SEDA CHINESA - 10mm x 1mm';
    $make->taginfAdProd($tag);

//Imposto
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->vTotTrib = 34.28;
    $make->tagimposto($std);

//ICMS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->orig = 2;
    $std->CSOSN = '102';
    $icms = $make->tagICMSSN($std);

//PIS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->CST = '99';
    $std->vBC = 0;
    $std->pPIS = 0;
    $pis = $make->tagPIS($std);

//COFINS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->CST = '99';
    $std->vBC = 0;
    $std->pCOFINS = 0;
    $std->vCOFINS = 0;
    $cof = $make->tagCOFINS($std);

//Totalizador
    $std = new stdClass();
    $make->tagICMSTot($std);

//Transporte
    $std = new stdClass();
    $std->modFrete = 9;
    $make->tagtransp($std);

//Volumes
    $std = new stdClass();
    $std->item = 1; //indicativo do numero do volume
    $std->qVol = 1;
    $std->esp = 'rolo';
    $std->marca = null;
    $std->nVol = null;
    $std->pesoL = 0.23;
    $std->pesoB = 0.233;
    $make->tagvol($std);

//Pagamento
    $std = new stdClass();
    $std->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)
    $make->tagpag($std);

//Detalhe do Pagamento
    $std = new stdClass();
    $std->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo
    $std->tPag = '17';
    $std->vPag = 100.00; //Obs: deve ser informado o valor pago pelo cliente
    $std->CNPJ = '01027058000191';
    $std->tBand = null;
    $std->cAut = null;
    $std->tpIntegra = 1; //incluso na NT 2015/002
    $std->CNPJPag = null; //NT 2023.004 v1.00
    $std->UFPag = null; //NT 2023.004 v1.00
    $std->CNPJReceb = null; //NT 2023.004 v1.00
    $std->idTermPag = null; //NT 2023.004 v1.00
    $make->tagdetPag($std);

//Informações Adicionais
    $std = new stdClass();
    $std->infAdFisco = null;
    $std->infCpl = 'Cliente não deseja seu CNPJ na NFCe';
    $make->taginfAdic($std);

//Responsável técnico
    $std = new stdClass();
    $std->CNPJ = '99999999999999'; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
    $std->xContato= 'Fulano de Tal'; //Nome da pessoa a ser contatada
    $std->email = 'fulano@soft.com.br'; //E-mail da pessoa jurídica a ser contatada
    $std->fone = '1155551122'; //Telefone da pessoa jurídica/física a ser contatada
    //$std->CSRT = 'G8063VRTNDMO886SFNK5LDUDEI24XJ22YIPO'; //Código de Segurança do Responsável Técnico
    //$std->idCSRT = '01'; //Identificador do CSRT
    $make->taginfRespTec($std);

    $xml = $make->monta();

```

## 2 - Use a classe Signer para assinar esse XML

```php
$config = [
    "atualizacao" => "2025-06-08 09:29:21",
    "tpAmb"       => 2,
    "razaosocial" => "Fulano Ltda",
    "siglaUF"     => "MA",
    "cnpj"        => "20221324000167",
    "schemes"     => "PL_009_V4",
    "versao"      => "4.00",
    "tokenIBPT"   => "",
    "CSC"         => "",
    "CSCid"       => "",
    "aProxyConf"  => [
        "proxyIp"   => "",
        "proxyPort" => "",
        "proxyUser" => "",
        "proxyPass" => ""
    ]
];

$cert = Certificate::readPfx(file_get_contents('certificado.pfx'), 'senha');
$tools = new Tools($configJson, $cert);
$tools->model('65');
$tools->forceQRCodeVersion('300');

//nota: $xml é a variável com o xml criado pela classe Make 
$signed = $tools->signNFe($xml);
//ao assinar será inserido o QRCode de acordo com o ambiente e o modo de emissão
```

## Final

Esse ($signed) é o xml da NFCe gerado em contingência OFFLINE já com o QRCode na versão estabelecida. Esse xml deve ser arquivado e enviado para a SEFAZ autorizadora tão logo a conexão com a SEFAZ seja reestabelecida.
O tempo máximo de espera para enviar esse xml para comprir as exigências legais e de atá 7 dias, após esse tempo existe risco de não ser aceito e ainda por cima gerar multas e outras sanções por parte do Fisco.

Para enviar este xml à SEFAZ autorizadora use o método
```php
$idLote = '1234';
$resp = $this->tools->sefazEnviaLote([$signed], $idLote, 1);
```
