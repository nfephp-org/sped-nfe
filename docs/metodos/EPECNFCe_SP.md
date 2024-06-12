# CONTINGENCIA EPEC Evento Prévio de Emissão em Contingência 
# NFCe exclusivo para SP - Leia com muita atenção

## Considerações Importantes

- No ambiente de homologação a operação com EPEC para NFCe na SEFAZ-SP, está sempre em operação.
- No ambiente de produção o serviço de EPEC para NFCe somente estará ativo caso a SEFAZ-SP o ative. Como consequência é necessário que seja consultado o status do serviço EPEC antes do envio do evento.
- A contingência EPEC exige o processo de vinculação do Evento a NFCe, se essa vinculação não for realizada dentro do prazo de 24 horas, o emitente ficará bloqueado para emissão de novas EPEC.
- Em caso de ERRO na NFCe, a mesma deverá ser corrigida para poder ser autorizada, e alguns dados da NFCe não poderão ser modificados de forma alguma, como:
  - chave da NFCe
  - dhEmis (data de emissão da NFCe)
  - cNF (codigo de controle da NFCe de 8 digitos, que compõe a chave)
  - vNF (valor da NFCe)
  - VICMS (valor do ICMS)
  - todos os dados do destinatário (se existirem, não pode mudar uma virgula sequer)

Nesses casos em que a NFCe é rejeitada, somente os motivos dessa rejeição poderão ser alterados e a rejeição corrigida, mas a NFCe ainda pode estar incorreta apesar de ter sido autorizada, neste caso a mesma deverá ser cancelada ou substituída por outra NFCe com os dados corretos no ambiente normal apenas.

**Por exemplo:**

Uma NFCe foi criada em contingência EPEC e o evento foi transmitido com sucesso.

Uma hora depois a SEFAZ-SP retornou o serviço normal e desabilitou o serviço de EPEC, e o seu sistema fez o envio da NFCe que foi autorizada em contignencia EPEC, para ser validada e autorizada pelo sistema normal e **vincular o EPEC à NFCe, finalizando o processo**.

Mas se a NFCe foi rejeitada devido ao **CFOP utilizado estar incorreto para esse tipo documento**, mas ocorre que por erro do operador a NFCe também foi gerada para um destinatário incorreto.

Nesse caso devemos apenas corrigir o **CFOP incorreto** e todos os outros dados da NFCe deverão permanecer exatamente os mesmos, a NFCe deverá ser novamente assinda e enviada pelo ambiente de autorização (normal) para ser **vinculada ao EPEC previamente emitido**.

Caso se autorizada, o evento também foi vinculado, então podemos proceder o **cancelamento (se ainda estiver no prazo, 30 min da hora de emissão)** ou a **substituição por outra NFCe (que pode ser feita em até 7 dias)**

**Outro exemplo com o vNF incorreto**

Uma NFCe foi criada em contingência EPEC e o evento foi transmitido com sucesso.

Ao olhar o documento fiscal impresso foi verificado que o valor da NFCe está incorreto, e se for transmitido dessa forma será rejeitado pois o somatório dos itens diverge do total da NFCe.

Para corrigir a NFCe tem que ser editada, alterando os itens, para que o valor dos itens resulte no valor total declarado no EPEC.

*DADOS VERDADEIROS, que deveriam constar da NFCe*

|item|Quantidade|Denominação|Valor Unitário|Valor Total|
|:---:|:---:|:---|---:|---:|
|item 1|1|5 kg Arroz Agulhinha Camil|R$ 34,49|R$ 34,49| 
|item 2|2|1 kg feijáo Carioca Camil|R$ 8.99|R$ 17,98|
|item 2|10|1 kg refinado União valor|R$ 5,59|R$ 55,90|

**Total Real vNF = 108,37**

**Total declarado no EPEC = R$ 99,36**

Então temos que alterar esses itens de forma que o total calculado pela SEFAZ seja exatamente esse de declarado na EPEC.

*DADOS NA NFCe, ajustados para autorizar e vincular o EPEC*

|item| Quantidade |Denominação|Valor Unitário| Valor Total |                              Ajuste                               |
|:---:|:----------:|:---|---:|------------:|:-----------------------------------------------------------------:|
|item 1|     1      |5 kg Arroz Agulhinha Camil|R$ 34,49|    R$ 34,49 |                                --                                 | 
|item 2|     1     |1 kg feijáo Carioca Camil|R$ 8.99|    R$ 8,97 | reduzida a quantidade de 2 para 1 e reduzido o valor para R$ 8,97 |
|item 2|     10     |1 kg refinado União valor|R$ 5,59|    R$ 55,90 |                                --                                 |

**Total vNF para validar com o EPEC = 99,36**

Agora o xml da NFCe pode ser gerado e assinado novemente com apenas estas alterações (lembrando que existem outras tags que não podem ser alteradas de forma alguma).

Esse xml ajustado pode ser então enviado para autorização na SEFAZ. encerrando a pendência de vinculo com o EPEC. E uma vez que a mesma foi autorizada pode ser imediatamente **cancelada** ou **substituida** pela NFCe emitida corretamente com outro numero.

### OS EPEC sempre tem que ser encerrados com uma NFCe válida e com os dados fornecidos na EPEC, portanto:
>## Todos os EPEC devem ser obrigatoriamente vinculados a uma NFCe autorizada.
# NUNCA ERRE NAS NFCe EMITIDAS COM EPEC !!!


## Consulta do Status do serviço EPEC

```php
try {
    $config = [
        "atualizacao" => "2024-06-08 09:29:21",
        "tpAmb" => 2,
        "razaosocial" => "FULANO DE TAL LTDA",
        "fantasia" => "FULANO LTDA",
        "siglaUF" => "SP",
        "cnpj" => "12345678901234",
        "ie" => "1234567890",
        "schemes" => "PL_009_V4",
        "versao" => "4.00",
        "tokenIBPT" => "",
        "CSC" => "33fe411e-ab44-2331-c320-c43ac568afe52",
        "CSCid" => "1",
        "aProxyConf" => [
            "proxyIp" => "",
            "proxyPort" => "",
            "proxyUser" => "",
            "proxyPass" => ""
        ]
    ];
    $configJson = json_encode($config);
    $config = json_decode($configJson);

    $cert = Certificate::readPfx(file_get_contents('certificado.pfx'), 'senha');

    $tools = new Tools($configJson, $cert);
    $tools->model(65); //OBRIGATÓRIO

    $resp = $tools->sefazStatusEpecNfce(); //caso o cStat = 107 então o serviço está disponivel, qualquer outro resultado não ! 

    header('Content-Type: application/xml');
    echo $resp;
    
} catch(\Exception $e) {
    echo $e->getMessage();
}
```

## Criação da NFCe em contingência EPEC

Após a consulta do status do serviço EPEC em SP, e se o mesmo estiver ativo, então:

- é o mesmo processo de criação de qualquer outra NFCe, exceto que tem que informar dados da contingência EPEC.
- criar a NFCe, a mesma já deverá ser registrada como em **contingência EPEC (tpEmis = 4)**, com **dhCont** e **xJust** também.
- assinar a NFCe com $tools->sigNFe($xml), e **gravar a NFCe criada**. (IMPORTANTISSIMO)

## Envio do Evento EPEC para NFCe em SP

Com a NFCe em contigência EPEC assinada, a mesma pode ser passada ao processo que fará o envio do evento EPEC dessa NFCe.

```php
try {
    $config = [
        "atualizacao" => "2024-06-08 09:29:21",
        "tpAmb" => 2,
        "razaosocial" => "FULANO DE TAL LTDA",
        "fantasia" => "FULANO LTDA",
        "siglaUF" => "SP",
        "cnpj" => "12345678901234",
        "ie" => "1234567890",
        "schemes" => "PL_009_V4",
        "versao" => "4.00",
        "tokenIBPT" => "",
        "CSC" => "33fe411e-ab44-2331-c320-c43ac568afe52",
        "CSCid" => "1",
        "aProxyConf" => [
            "proxyIp" => "",
            "proxyPort" => "",
            "proxyUser" => "",
            "proxyPass" => ""
        ]
    ];
    $configJson = json_encode($config);
    
    $cert = Certificate::readPfx(file_get_contents('certificado.pfx'), 'senha');

    $tools = new Tools($configJson, $cert);
    $tools->model(65); //OBRIGATÓRIO
    
    $xml = 'nfce_criada_em_contingência_epec_assinada_e_gravada_para_uso_posterior'; //obrigatório
    $veraplic = 'versão_do_aplicativo'; //opcional, caso não exista será usado o <verProc> da NFCe

    $resp = $tools->sefazEpecNfce($xml, $veraplic);
    
    file_put_contents('evento_eped_nfce.xml', $tools->lastRequest); //o evento enviado deve ser gravado sempre
    file_put_contents('resposta_eped_nfce.xml', $tools->lastResponse); //a resposta deve ser gravada sempre

    //a resposta deve ser verificada para checar o cStat da mesma, para saber se o evento foi ou não autorizado
    $st = new Standardize();
    $std = $st->toStd($resp);
    //como o envio de eventos é sincrono não é esperado codigo diferente de 128, se ocorrer foi algum erro
    if ($std->cStat == 128) {
        //o lote foi processado, nesse caso podemos verificar o resultado do processamento
        if ($std->retEvento->infEvento->cStat == 136) {
            //como o resultado do processamento do evento foi 136 Evento registrado, mas não vinculado a NF-e
            //temos o evento EPEC autorizado
            //devemos também protocolar o evento com sua respectiva autorização
            $evento = file_get_contents(__DIR__."/envio_epec_nfce_{$numero}.xml");
            $resposta = file_get_contents(__DIR__."/resposta_epec_nfce_{$numero}.xml");
            $evento_autorizado = Complements::toAuthorize($evento, $resposta);
            file_put_contents(__DIR__."/evento_epec_nfce_autorizado.xml", $evento_autorizado); //gravar
            //nesse caso podemos imprimir o DANFCE com os dados do EPEC
                //$danfce = new Danfce(file_get_contents($file);
                //$danfce->epec(dados epec);
                //$pdf = $danfce->render($logo);
        } else {
            $ret = $std->retEvento->infEvento;
            //não é 136 então algum erro ocorreu na montagem do evento
            //terá de ser analizado o motivo e feita a correção apropriada
            throw new \Exception("Algum erro ocorreu cStat {$ret->cStat} {$ret->xMotivo}");     
        }
    } else {
        throw new \Exception("Algum erro ocorreu cStat {$std->cStat} {$std->xMotivo}");
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Envio da NFCe criada em contingência EPEC

Uma vez que a SEFAZ-SP NFCe voltou a operar, podemos enviar as NFCe emitidas por evento EPEC:

```php
try {
    $config = [
        "atualizacao" => "2024-06-08 09:29:21",
        "tpAmb" => 2,
        "razaosocial" => "FULANO DE TAL LTDA",
        "fantasia" => "FULANO LTDA",
        "siglaUF" => "SP",
        "cnpj" => "12345678901234",
        "ie" => "1234567890",
        "schemes" => "PL_009_V4",
        "versao" => "4.00",
        "tokenIBPT" => "",
        "CSC" => "33fe411e-ab44-2331-c320-c43ac568afe52",
        "CSCid" => "1",
        "aProxyConf" => [
            "proxyIp" => "",
            "proxyPort" => "",
            "proxyUser" => "",
            "proxyPass" => ""
        ]
    ];
    $configJson = json_encode($config);
    
    $cert = Certificate::readPfx(file_get_contents('certificado.pfx'), 'senha');

    $tools = new Tools($configJson, $cert);
    $tools->model(65); //OBRIGATÓRIO
    
    $xml = 'nfce_criada_em_contingência_epec_assinada_e_gravada_para_uso_posterior'; //obrigatório
    $lote = 123456;
    $envio_sincrono = 1;
    $resp = $tools->sefazEnviaLote([$xml], $lote, $envio_sincrono);
    
    $st = new Standardize();
    $std = $st->toStd($resp);
    if ($std->cStat == 128) {
        if (in_array($std->protNFe->infProt->cStat, [100, 110, 150, 205, 301, 302, 303])) 
            try {
                //em todos esses casos a NFCe foi autorizada ou denegada
                //então a nfce deve ser protocolada e já está vinculada ao EPEC
                $prot = Complements::toAuthorize($xml, $resp);
                file_put_contents('nfce_protocolo_de_autorizacao.xml', $resp); //deve ser gravado
                file_put_contents('nfce_criada_em_contingência_epec_assinada_e_protocolada.xml', $prot); //obrigatório, manter por 5 anos
            } catch (\Exception $e) {
                //nesse ponto as falhas geralmente ocorrem devvido erros da propria SEFAZ
                //como retornar dados de autorização de OUTRO documento e não o seu 
                //se isto ocorrer deverá ser feita a cunsulta pela chave do NFCe e se a mesma não estiver
                //na base de dados da SEFAZ, deverá ser enviada novamente
                throw new \Exception('FALHA AO PROTOCOLAR NFCE ' . $e->getMessage());
            } 
        } else {
            $infProt = $std->protNFe->infProt;
            throw new \Exception("Algum erro ocorreu cStat {$infProt->cStat} {$infProt->xMotivo}");
            //revisar o erro e enviar novamente até obter sucesso e a NFCe poder ser protocolada, você tem 24 horas para fazer isso !!!
        }
    } else {
        throw new \Exception("Algum erro ocorreu cStat {$std->cStat} {$std->xMotivo}");
    }
} catch (\Exception $e) {
    //as falhas devem ser tratadas, você tem 24 horas para fazer isso !!!
    //nesse ponto os erros normalmente são referentes ao timeout estabelecido pela aplicação
    //ou por falhas de acesso ao webservice como os SOAPExceptions
    echo $e->getMessage();
}
```
