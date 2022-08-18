# CONSULTA DE STATUS

Verifica a condição de operação dos serviços em uma autorizadora ou ambiente de contingência.

**Função:** serviço destinado à consulta do status do serviço prestado pelo Portal da Secretaria de Fazenda Estadual.

**Processo:** síncrono.

**Método:** nfeStatusServico

## Descrição

É importante salientar que muitas vezes esta consulta retorna como serviço em operação normal, quando na verdade a autorizadora está passando por alguma dificuldade operacional.

Quando ocorrem os [TimeOuts](../TimeOut.md) é recomendável que seja consultada a pagina da Receita [Consulta de Disponibilidade - produção](http://www.nfe.fazenda.gov.br/portal/disponibilidade.aspx?versao=0.00&tipoConteudo=Skeuqr8PQBY=), e mesmo essa pagina nem sempre está atualizada com os problemas da rede.

> NOTA: Somente faça essa consulta no máximo com intervalos de 3 minutos, sob pena de ser BLOQUEADO, por excesso de consumo.

## Dependências

[NFePHP\Common\Certificate::class](https://github.com/nfephp-org/sped-common/blob/master/docs/Certificate.md)

[NFePHP\NFe\Tools::class](../Tools.md)

[NFePHP\NFe\Common\Standardize::class](../Standardize.md)


## Exemplo de Uso

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {

    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);
    $tools->model('55');
    $uf = 'SP';
    $tpAmb = 2;
    $response = $tools->sefazStatus($uf, $tpAmb);
    //este método não requer parametros, são opcionais, se nenhum parametro for 
    //passado serão usados os contidos no $configJson
    //$response = $tools->sefazStatus();

    //você pode padronizar os dados de retorno atraves da classe abaixo
    //de forma a facilitar a extração dos dados do XML
    //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
    //      quando houver a necessidade de protocolos
    $stdCl = new Standardize($response);
    //nesse caso $std irá conter uma representação em stdClass do XML
    $std = $stdCl->toStd();
    //nesse caso o $arr irá conter uma representação em array do XML
    $arr = $stdCl->toArray();
    //nesse caso o $json irá conter uma representação em JSON do XML
    $json = $stdCl->toJson();
    
} catch (\Exception $e) {
    echo $e->getMessage();
}

```

## Parametros

| Variável | Detalhamento  |
| :---:  | :--- |
| $configJson | String Json com os dados de configuração (OBRIGATÓRIO) |
| $content | String com o conteúdo do certificado PFX (OBRIGATÓRIO) |
| $certificado | Classe Certificate::class contendo o certificado digital(OBRIGATÓRIO)  |
| $uf | Sigla da UF que se deseja saber o status (OPCIONAL) |
| $tpAmb | Ambiente do serviço (OPCIONAL) |


## Mensagens

### ENVIO

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
  <soap:Header>
    <nfeCabecMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NfeStatusServico2">
      <cUF>35</cUF>
      <versaoDados>3.10</versaoDados>
    </nfeCabecMsg>
  </soap:Header>
  <soap:Body>
    <nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NfeStatusServico2">
      <consStatServ xmlns="http://www.portalfiscal.inf.br/nfe" versao="3.10">
        <tpAmb>2</tpAmb>
        <cUF>35</cUF>
        <xServ>STATUS</xServ>
      </consStatServ>
    </nfeDadosMsg>
  </soap:Body>
</soap:Envelope>
```
### RETORNO

A variavel $response no exemplo conterá esse XML, ou algo semelhante.

```xml
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Header>
        <nfeCabecMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NfeStatusServico2">
            <cUF>35</cUF>
            <versaoDados>3.10</versaoDados>
        </nfeCabecMsg>
    </soap:Header>
    <soap:Body>
        <nfeStatusServicoNF2Result xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NfeStatusServico2">
            <retConsStatServ versao="3.10" xmlns="http://www.portalfiscal.inf.br/nfe">
                <tpAmb>2</tpAmb>
                <verAplic>SP_NFE_PL_008i2</verAplic>
                <cStat>107</cStat>
                <xMotivo>Serviço em Operação</xMotivo>
                <cUF>35</cUF>
                <dhRecbto>2017-05-24T10:12:47-03:00</dhRecbto>
                <tMed>1</tMed>
            </retConsStatServ>
        </nfeStatusServicoNF2Result>
    </soap:Body>
</soap:Envelope>
```

## Standardize

Estruturas retornadas pela classe Standardize, para facilitar a extração de dados do XML.


### ARRAY

```
Array
(
    [attributes] => Array
        (
            [versao] => 3.10
        )

    [tpAmb] => 2
    [verAplic] => SP_NFE_PL_008i2
    [cStat] => 107
    [xMotivo] => Serviço em Operação
    [cUF] => 35
    [dhRecbto] => 2017-05-24T10:12:47-03:00
    [tMed] => 1
)
``` 

### JSON STRING

```json
{
    "attributes": {
        "versao": "3.10"
    },
    "tpAmb": "2",
    "verAplic": "SP_NFE_PL_008i2",
    "cStat": "107",
    "xMotivo": "Servi\u00e7o em Opera\u00e7\u00e3o",
    "cUF": "35",
    "dhRecbto": "2017-05-24T10:12:47-03:00",
    "tMed": "1"
}
```

### STDCLASS

```
stdClass Object
(
    [attributes] => stdClass Object
        (
            [versao] => 3.10
        )

    [tpAmb] => 2
    [verAplic] => SP_NFE_PL_008i2
    [cStat] => 107
    [xMotivo] => Serviço em Operação
    [cUF] => 35
    [dhRecbto] => 2017-05-24T10:12:47-03:00
    [tMed] => 1
)
```

## SUCESSO

A consulta com sucesso poderá resultar:

| cStat | xMotivo |
| :---: | :--- | 
| 107 | Serviço em Operação |
| 108 | Serviço Paralisado Temporariamente |
| 109 | Serviço Paralisado sem Previsão |

## Mensagens de ERRO (Exceptions)

Caso não passe em alguma validação ou sejam encontrados problemas na comunicação, será SEMPRE retornado um EXCEPTION que deve ser capturado.

Mas os erros não se restringem a esse tipo de falha. Além de falhas na fase de montagem da mensagem e na comunicação podem ser retornados erros relativos a analise pelas regras de negócios da SEFAZ nesse caso os erros deverão ser analisados no xml de retorno.

### Verificação do Certificado de Transmissão

| cStat | xMotivo |
| :---: | :--- | 
| 280 | Rejeição: Certificado Transmissor inválido |
| 281 | Rejeição: Certificado Transmissor Data Validade |
| 282 | Rejeição: Certificado Transmissor sem CNPJ |
| 283 | Rejeição: Certificado Transmissor - erro Cadeia de Certificação |
| 284 | Rejeição: Certificado Transmissor revogado |
| 285 | Rejeição: Certificado Transmissor difere ICP-Brasil |
| 286 | Rejeição: Certificado Transmissor erro no acesso a LCR |

