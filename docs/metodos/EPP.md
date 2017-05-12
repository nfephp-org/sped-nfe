# Evento Pedido de Prorrogação

Pedido de prorrogação da suspensão do ICMS na remessa para industrialização após decorridos 180 dias.

> O Evento de pedido de prorrogação substitui uma petição em papel do contribuinte, frente à administração pública, com um arquivo xml assinado. O evento será utilizado pelo contribuinte e o alcance das alterações permitidas é definido no CONVÊNIO AE-15/74

> A saída com a suspensão de ICMS (nos casos previstos em legislação) independe da emissão de eventos na NFe. Na necessidade de prorrogação deste prazo, o pedido de prorrogação se dá por eventos vinculados à NFe indicando o item e a quantidade que se pretende prorrogar. A suspensão do ICMS é prorrogável por mais 180 dias após o primeiro período de prorrogação. Neste caso, a empresa solicita uma nova prorrogação com o evento de 2o prazo de prorrogação.

**Função:** Serviço destinado à recepção de mensagem de Evento da NF-e

O Pedido de Prorrogação é um evento para prorrogar o prazo de retorno de produtos de uma NF-e de remessa para industrialização por encomenda com suspensão do ICMS.

O registro de um novo Pedido de Prorrogação não substitui o Pedido de Prorrogação anterior, ou seja, serão eventos cumulativos. Recomenda-se agrupar a maior quantidade de itens em cada Pedido de Prorrogação.

**Processo:** síncrono.

**Método:** nfeRecepcaoEvento

## Descrição

## Exemplo de Uso

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Common\Complements;

$configJson = file_get_contents('config.json');
$content = file_get_contents('bob.pfx');

try {
    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);
    $tools->model('55');
    
    $chNFe = '35150300822602000124550010009923461099234656';
    $nProt = '135150001686732';
    $itens = [
        [1, 111],
        [2, 222],
        [3, 333]
    ];
    $tipo = 1; //1-primero prazo para os itens, 2-segundo prazo para os itens
    $nSeqEvento = 1;
    $response = $tools->sefazEPP($chNFe,$nProt,$itens,$tipo,$nSeqEvento);

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

    //verifique se o evento foi processado
    if ($std->cStat != 128) {
        //houve alguma falha e o evento não foi processado
        //TRATAR
    } else {
        $cStat = $std->retEvento->infEvento->cStat;
        if ($cStat == '101' || $cStat == '155') {
            //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
            $xml = Complements::toAuthorize($tools->lastRequest, $response);

            //grave o XML protocolado 

        } else {
            //houve alguma falha no evento 
            //TRATAR
        }
    }    
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
| $chNFe | Chave de 44 dígitos da NFe que se quer prorrogar (OBRIGATÓRIO) |
| $nProt | Número do protocolo de autorização de uso (OBRIGATÓRIO) |
| $itens | Array com os numeros do itens e a suas quantidades, os quais se deseja prorrogar o prazo de retorno de industrialização (OBRIGATÓRIO) |
| $tipo  | 1-prorrogação do 1o prazo ou 2-prorrogação do 2o prazo (OBRIGATÓRIO) |
| $nSeqEvento | [Numero sequencial do evento](Seqeventos.md) (OBRIGATÓRIO) |

## Mensagens

### ENVIO

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
  <soap:Header>
    <nfeCabecMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/RecepcaoEvento">
      <cUF>35</cUF>
      <versaoDados>1.00</versaoDados>
    </nfeCabecMsg>
  </soap:Header>
  <soap:Body>
    <nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/RecepcaoEvento">
      <envEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
        <idLote>201705121045241</idLote>
        <evento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
          <infEvento Id="ID1115003515030082260200012455001000992346109923465601">
            <cOrgao>35</cOrgao>
            <tpAmb>2</tpAmb>
            <CNPJ>58716523000119</CNPJ>
            <chNFe>35150300822602000124550010009923461099234656</chNFe>
            <dhEvento>2017-05-12T10:45:24-03:00</dhEvento>
            <tpEvento>111500</tpEvento>
            <nSeqEvento>1</nSeqEvento>
            <verEvento>1.00</verEvento>
            <detEvento versao="1.00">
              <descEvento>Pedido de Prorrogacao</descEvento>
              <nProt>135150001686732</nProt>
              <itemPedido numItem="1">
                <qtdeItem>111</qtdeItem>
              </itemPedido>
              <itemPedido numItem="2">
                <qtdeItem>222</qtdeItem>
              </itemPedido>
              <itemPedido numItem="3">
                <qtdeItem>333</qtdeItem>
              </itemPedido>
            </detEvento>
          </infEvento>
          <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
            <SignedInfo>
              <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
              <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
              <Reference URI="#ID1115003515030082260200012455001000992346109923465601">
                <Transforms>
                  <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
                  <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                </Transforms>
                <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
                <DigestValue>yCUxgGMRg+s9sQs3IlOnPDrQCEQ=</DigestValue>
              </Reference>
            </SignedInfo>
            <SignatureValue>vjj891o09YGiqWI/AX1OBllKAHhvfNlFErAgy59Ka1m983gSThk0wuaKSXmFhXcdZr1lR9XcpPIjq7doI/EQAdXOezI0YTlCcccWJdgaMtx++SAyrGMT5mdyphm3mu1rdJIlQxd5tgTkLFissuuFAkzP5SMVfBUDE6ArWpDKngM8WESdD8zD5jj2v5V9IQx2WHetJP2sXyfy4WCtvXjprziY0EkLcpQm/wsenetlObffyLMBuZQTgdqZRwJY+7Gk9sVXEOyk0S/MI+uFicA2bIdoTYZoAIe2Zzipc1DJzNlNnQvkzZsFtdmaTV6xQzdQbS77Y+aPD/CBSQS+t3QHWg==</SignatureValue>
            <KeyInfo>
              <X509Data>
                <X509Certificate>MIIINTCCBh2gAwIBAgIQEABoI3FQdSnFVyEEKSwjtzANBgkqhkiG9w0BAQsFADB0MQswCQYDVQQGEwJCUjETMBEGA1UEChMKSUNQLUJyYXNpbDEtMCsGA1UECxMkQ2VydGlzaWduIENlcnRpZmljYWRvcmEgRGlnaXRhbCBTLkEuMSEwHwYDVQQDExhBQyBDZXJ0aXNpZ24gTXVsdGlwbGEgRzUwHhcNMTYwNDI1MDAwMDAwWhcNMTcwNDI0MjM1OTU5WjCBwzELMAkGA1UEBhMCQlIxEzARBgNVBAoUCklDUC1CcmFzaWwxIjAgBgNVBAsUGUF1dGVudGljYWRvIHBvciBBUiBEYXNjaGkxGzAZBgNVBAsUEkFzc2luYXR1cmEgVGlwbyBBMTEWMBQGA1UECxQNSUQgLSAxMDI4MzQzNjEcMBoGA1UEAxMTRklNQVRFQyBURVhUSUwgTFREQTEoMCYGCSqGSIb3DQEJARYZZmluYW5jZWlyb0BmaW1hdGVjLmNvbS5icjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBANheJGu0qkiNGFY36IXp2Qokkzc9qViSEp55QXnKv0QKXvKgY+YDede5DDT9oOm7fI6GwVAt16nuZS5f9x3wufCcM5Kf4YPHkiqwDSQ02v4S7qDJIn9DqCl2R8EiKxBTmY4b8bKwqGupb1ZGs8Nq9D5seZahNAMEsKb5FYEEhavIi6sVEDzsTQyQfcMZMOuXcqgbSbdIGHrKqECfq7c6SaOi/UQcPAbTOmVFL6duxPmjCs+R9Uxu++8F/LKzUZg0zmyxDGQcGj9ev4ebBKMPJRLvQg/lujq/bDK5+VTkuHykV+Fjra4yrqf2EXh1846gcN9Vx3yiZb0I07xx5wF+yesCAwEAAaOCA3EwggNtMIG3BgNVHREEga8wgaygOAYFYEwBAwSgLwQtMjAxMDE5NTkwNTIyNTUzNzg4MDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwoCEGBWBMAQMCoBgEFkZFUk5BTkRPIEpPU0UgS0FJUkFMTEGgGQYFYEwBAwOgEAQONTg3MTY1MjMwMDAxMTmgFwYFYEwBAwegDgQMMDAwMDAwMDAwMDAwgRlmaW5hbmNlaXJvQGZpbWF0ZWMuY29tLmJyMAkGA1UdEwQCMAAwHwYDVR0jBBgwFoAUnVDPvf8kyq+xM+sX4kJ6jmkqjlMwDgYDVR0PAQH/BAQDAgXgMIGJBgNVHSAEgYEwfzB9BgZgTAECAQswczBxBggrBgEFBQcCARZlaHR0cDovL2ljcC1icmFzaWwuY2VydGlzaWduLmNvbS5ici9yZXBvc2l0b3Jpby9kcGMvQUNfQ2VydGlzaWduX011bHRpcGxhL0RQQ19BQ19DZXJ0aVNpZ25NdWx0aXBsYS5wZGYwggElBgNVHR8EggEcMIIBGDBcoFqgWIZWaHR0cDovL2ljcC1icmFzaWwuY2VydGlzaWduLmNvbS5ici9yZXBvc2l0b3Jpby9sY3IvQUNDZXJ0aXNpZ25NdWx0aXBsYUc1L0xhdGVzdENSTC5jcmwwW6BZoFeGVWh0dHA6Ly9pY3AtYnJhc2lsLm91dHJhbGNyLmNvbS5ici9yZXBvc2l0b3Jpby9sY3IvQUNDZXJ0aXNpZ25NdWx0aXBsYUc1L0xhdGVzdENSTC5jcmwwW6BZoFeGVWh0dHA6Ly9yZXBvc2l0b3Jpby5pY3BicmFzaWwuZ292LmJyL2xjci9DZXJ0aXNpZ24vQUNDZXJ0aXNpZ25NdWx0aXBsYUc1L0xhdGVzdENSTC5jcmwwHQYDVR0lBBYwFAYIKwYBBQUHAwIGCCsGAQUFBwMEMIGgBggrBgEFBQcBAQSBkzCBkDBkBggrBgEFBQcwAoZYaHR0cDovL2ljcC1icmFzaWwuY2VydGlzaWduLmNvbS5ici9yZXBvc2l0b3Jpby9jZXJ0aWZpY2Fkb3MvQUNfQ2VydGlzaWduX011bHRpcGxhX0c1LnA3YzAoBggrBgEFBQcwAYYcaHR0cDovL29jc3AuY2VydGlzaWduLmNvbS5icjANBgkqhkiG9w0BAQsFAAOCAgEAoKKStBShY9SJbz1kK/5QzqnVSFaPP2TrBBfJQG8IYVQXwghke/OqHmW4fr3LDMDMg/8I31xfYr20Kqu/o7myGV+ZnTLQckWUuODTVB7d/d22DNQaS4KLV9YB9R6l1csMr+KWl0dprechWlo7f90I62cZso/dLXW9Od/JXvbFPYiJrThwaIbY8LBFjYmHNodu1ILALBS8PhgfquOq3TEy2ZI8adfwEqPaGycVIqE5TdCMLKuhoXNf1EuuLPiXB7z6OjKHcJKsUXLrvdzHS4hGqVaGfRjBYkiSnA7m88/H9ab1H0SaxjZHC55ymVBYuQ/JHgNbjMKpGDGNSqyKD9difi4wjLV9H9RlS46FA0l8jUKgUomBzgBZJ4BVM2W2VhPqUUkupxturCJgeXV4nQaGraLLNpsmx6uK+DX+gHc21JDWmm57rguyLyZZC7iJSPioQomeJhA+ro/ReBAYp/8LVRlvFqSDgYqeB9ejFWKJep8Oh/EbHcVbkrqyJ0ZGGJgwCCYF8L55NuvocJVYJpPSJ2+dTDYjKrm062mlMI+w9amIHNy7ygIE15X/sWe+HOZCL9NNbUBb8gpe5xpdjNiym3Rx0YNX5vOa+pniNLjHFtoDIskgvWJYOB3QzygzcMD85zAzVzDX29jkqR22idGQ8kCqBbhmfLofh87czMj4Er4=</X509Certificate>
              </X509Data>
            </KeyInfo>
          </Signature>
        </evento>
      </envEvento>
    </nfeDadosMsg>
  </soap:Body>
</soap:Envelope>
```

### RETORNO

A variavel $response no exemplo conterá esse XML, ou algo semelhante.

```xml

```

## Standardize

Estruturas retornadas pela classe Standardize, para facilitar a extração de dados do XML.

### ARRAY 

```

```

### JSON STRING

```json

```

### STDCLASS

```

```

## SUCESSO

A consulta com sucesso poderá resultar:

| cStat | xMotivo |
| :---: | :--- | 
| 0 |  |
| 0 |   |

## Mensagens de ERRO (Exceptions)

Caso não passe em alguma validação ou sejam encontrados problemas na comunicação, será SEMPRE retornado um EXCEPTION que deve ser capturado.

Mas os erros não se restringem a esse tipo de falha. Além de falhas na fase de montagem da mensagem e na comunicação podem ser retornados erros relativos a analise pelas regras de negócios da SEFAZ nesse caso os erros deverão ser analisados no xml de retorno.

### Verificação do Certificado de Transmissão

Validação do Certificado de Transmissão
| cStat | xMotivo |
| :---: | :--- | 
| 280 | Rejeição: Certificado Transmissor inválido |
| 281 | Rejeição: Certificado Transmissor Data Validade |
| 283 | Rejeição: Certificado Transmissor - erro Cadeia de Certificação |
| 286 | Rejeição: Certificado Transmissor erro no acesso a LCR |
| 284 | Rejeição: Certificado Transmissor revogado |
| 285 | Rejeição: Certificado Transmissor difere ICP-Brasil |
| 282 | Rejeição: Certificado Transmissor sem CNPJ |


### Validação Inicial da Mensagem no Web Service
| cStat | xMotivo |
| :---: | :--- | 
| 214 | Rejeição: Tamanho da mensagem excedeu o limite estabelecido |
| 108 | Serviço Paralisado Momentaneamente (curto prazo) |
| 109 | Serviço Paralisado sem Previsão |

### Validação das informações de controle da chamada ao Web Service

| cStat | xMotivo |
| :---: | :--- | 
| 242 | Rejeição: Elemento nfeCabecMsg inexistente no SOAP Header |
| 409 | Rejeição: Campo cUF inexistente no elemento nfeCabecMsg do SOAP Header |
| 410 | Rejeição: UF informada no campo cUF não é atendida pelo WebService |
| 411 | Rejeição: Campo versaoDados inexistente no elemento nfeCabecMsg do SOAP Header |
| 238 | Rejeição: Cabeçalho - Versão do arquivo XML superior a Versão vigente |
| 239 | Rejeição: Cabeçalho - Versão do arquivo XML não suportada |

### Validação da área de Dados

| cStat | xMotivo |
| :---: | :--- | 
| 516 | Rejeição: Falha Schema XML, inexiste a tag raiz esperada para a mensagem |
| 517 | Rejeição: Falha Schema XML, inexiste atributo versão na tag raiz da mensagem |
| 545 | Rejeição: Falha no schema XML – versão informada na versaoDados do SOAP Header diverge da versão da mensagem |
| 215 | Rejeição: Falha Schema XML |
| 587 | Rejeição: Usar somente o namespace padrão da NF-e |
| 588 | Rejeição: Não é permitida a presença de caracteres de edição no início/fim da mensagem ou entre as tags da mensagem |
| 404 | Rejeição: Uso de prefixo de namespace não permitido |
| 402 | Rejeição: XML da área de dados com codificação diferente de UTF-8 |
| 491 | Rejeição: O tpEvento informado invalido |
| 492 | Rejeição: O verEvento informado invalido |
| 493 | Rejeição: Evento não atende o Schema XML específico |
| 290 | Rejeição: Certificado Assinatura inválido |
| 291 | Rejeição: Certificado Assinatura Data Validade |
| 292 | Rejeição: Certificado Assinatura sem CNPJ |
| 293 | Rejeição: Certificado Assinatura - erro Cadeia de Certificação |
| 296 | Rejeição: Certificado Assinatura erro no acesso a LCR |
| 294 | Rejeição: Certificado Assinatura revogado |
| 295 | Rejeição: Certificado Assinatura difere ICP-Brasil |
| 298 | Rejeição: Assinatura difere do padrão do Projeto |
| 297 | Rejeição: Assinatura difere do calculado |
| 213 | Rejeição: CNPJ-Base do Autor difere do CNPJ-Base do Certificado Digital |

### Validação das regras de negócio do evento Pedido de Prorrogação
