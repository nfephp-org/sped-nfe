# Configuração em execução

Para passar os dados básicos para Tools::class, é usada uma string JSON. Isso porque é mais simples para construir sempre que necessário e pode inclusive ser salva (já construída) em base de dados ou mesmo em arquivo, se assim o desenvolvedor desejar.

## Construindo o config.json

O config.json pode ser construído extraindo dados do usuário de uma base de dados, montando um array e convertendo esse array em uma string JSON, como demonstrado abaixo:

```php

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

$json = json_encode($config);
```


```json
{
    "atualizacao":"2015-10-02 06:01:21",
    "tpAmb":2,
    "razaosocial":"Fake Materiais de construção Ltda",
    "siglaUF":"SP",
    "cnpj":"00716345000119",
    "schemes":"PL_008i2",
    "versao":"3.10",
    "tokenIBPT":"AAAAAAA",
    "CSC":"GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
    "CSCid":"000002",
    "aProxyConf":{
        "proxyIp":"",
        "proxyPort":"",
        "proxyUser":"",
        "proxyPass":""
    }
}
```

| Campo | Descrição | Uso |
| :---- | :---- | :---- |
| atualizacao | Datetime da última atualização dos dados | Apenas uma referência. Não tem utilidade real |
| tpAmb | Tipo de Ambiente 1-Produção ou 2-Homologação | Estabelece o ambiente base com o qual a API irá operar |
| razaosocial | Nome completo do usuário | Será usado em algumas classes. (Pouca relevância em Tools::class) |
| siglaUF | Sigla da unidade da Federação do usuário | Fundamental para direcionar todas a chamadas aos webservices |
| cnpj | Numero do CNPJ do usuário | Fundamental para várias operações e validações |
| schemes | Nome da pasta onde estão os schemas | Fundamental para as validações das mensagens com a versão correta do layout |
| versao | Numero de versão do layout | Fundamental para a localização correta dos arquivos XSD |
| tokenIBPT | Token de segurança fornecido pelo IBPT | Necessário se desejar buscar os impostos no IBPT |
| CSC | Token de segurança fornecido pela SEFAZ para NFCe | Necessário para TODAS as operações com NFCe |
| CSCid | Id do Token de segurança fornecido pela SEFAZ para NFCe | Necessário para TODAS as operações com NFCe |
| aProxyConf | Array contendo os dados abaixo | Necessário para atravessar um PROXY (se existir) |
| proxyIp | Número IP do proxy da rede interna | Se houver um proxy, aqui deve ser indicado o número do seu IP |
| proxyPort | Número da porta do proxy da rede interna | Se houver um proxy esse campo deve conter o número da porta |
| proxyUser | Nome do usuário do proxy da rede interna | Indicar apenas se a autenticação for obrigatória |
| proxyPass | Password do usuário do proxy da rede interna | Indicar apenas se a autenticação for obrigatória |


> NOTA: Para saber mais sobre o IBPT consulte o repositório [sped-ibpt](https://github.com/nfephp-org/sped-ibpt)