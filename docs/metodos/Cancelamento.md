# CANCELAMENTO

Cancelamento de uma NFe já autorizada previamente.

**Função:** Serviço destinado à recepção de mensagem de Evento da NF-e

- O Cancelamento é um evento para cancelar a NF-e.
- O autor do evento é o emissor da NF-e e a NF-e deve existir no banco de dados da SEFAZ.
- A mensagem XML do evento será assinada com o certificado digital que tenha o CNPJ base do Emissor da NF-e.

**Processo:** síncrono.

**Método:** nfeRecepcaoEvento

## Descrição

**Condições para Cancelamento**

- NF-e autorizada, o usuário deve utilizar a inutilização de numeração se a NF-e não estiver autorizada;
- NF-e autorizada em até 24 horas, o prazo máximo é de até 2 horas em MT;
- Possuir o número do protocolo de autorização de uso;
- A mercadoria não pode ter circulado;
- A NF-e não pode ter registro de passagem na fiscalização de trânsito;
- A NF-e não pode ter a confirmação de recebimento;

**Prazo de cancelamento**

Em até 24 horas da autorização de uso da NF-e objeto do cancelamento, no MT o prazo de cancelamento é de 2 horas da autorização de uso. Algumas UF poderão aceitar o pedido de cancelamento após a expiração do prazo de 24 horas, mas o cancelamento vai constar como efetuado com atraso e estará sujeito a aplicação de multa. Algumas UF orientam o emissor para emitir uma NF-e de "estorno" para anular a operação, consulte o contador para obter a orientação adequado quando perder o prazo de cancelamento.

**No caso de NFCe esse prazo passa a ser de 15 MINUTOS entre a emissão e a solicitação de cancelamento.**

> NOTA: Quanto aos prazos podem haver variações desses limites e da condição de aceitação, por qualquer SEFAZ autorizadora, sem prévio aviso !!. 

> NOTA: Esse documento deverá ser protocolado e armazenado para atender a legislação.

> Para notas que não tenham sido canceladas dentro do prazo estabelecido, o correto é fazer uma nota de entrada desfazendo o processo fiscal original.

## Dependências

[NFePHP\Common\Certificate::class](Certificate.md)

[NFePHP\NFe\Tools::class](Tools.md)

[NFePHP\NFe\Common\Standardize::class](Standardize.md)

[NFePHP\NFe\Complements::class](Complements.md)


## Exemplo de Uso

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Complements;

try {

    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);
    $tools->model('55');

    $chave = '35150300822602000124550010009923461099234656';
    $xJust = 'Erro de digitação nos dados dos produtos';
    $nProt = '135150001686732';
    $response = $tools->sefazCancela($chave, $xJust, $nProt);

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
        if ($cStat == '101' || $cStat == '135' || $cStat == '155') {
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
| $chave | Chave de 44 dígitos da NFe que se quer cancelar (OBRIGATÓRIO) |
| $xJust | Justificativa para o cancelamento (OBRIGATÓRIO) |
| $nProt | Número do protocolo de autorização de uso (OBRIGATÓRIO) |


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
        <idLote>201705051652506</idLote>
        <evento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
          <infEvento Id="ID1101113515030082260200012455001000992346109923465601">
            <cOrgao>35</cOrgao>
            <tpAmb>2</tpAmb>
            <CNPJ>58716523000119</CNPJ>
            <chNFe>35150300822602000124550010009923461099234656</chNFe>
            <dhEvento>2017-05-05T16:52:50-03:00</dhEvento>
            <tpEvento>110111</tpEvento>
            <nSeqEvento>1</nSeqEvento>
            <verEvento>1.00</verEvento>
            <detEvento versao="1.00">
              <descEvento>Cancelamento</descEvento>
              <nProt>135150001686732</nProt>
              <xJust>Apenas um teste para ver como e montada a mensagem</xJust>
            </detEvento>
          </infEvento>
          <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
            <SignedInfo>
              <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
              <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
              <Reference URI="#ID1101113515030082260200012455001000992346109923465601">
                <Transforms>
                  <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
                  <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                </Transforms>
                <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
                <DigestValue>8X74XJQicPnCJ0jK2SVb8dv5XPw=</DigestValue>
              </Reference>
            </SignedInfo>
            <SignatureValue>IswR16L2gCZKMjbPeSpXkkwa8ry4uI4sn6dnmuMYjwf6DMKkST/0arrYvH5XzvALNyejuTkNJStycDdjZE3df2Dda5aYNdKwIGh+TD49BQFj61mclcjVwdOeaeWbGLCqFRMsBD9ZD7eSN+tdsCfPEu0KV8UK/JmetHYERYvi8gNL1mCYrP8x3krJ/lRTtjWd1sGZrubBLxHusnFjX6DsctsvrISlcWzE9+Jr+DO6MIj4wxhgyojkP7GGoNWCnA7TRNWnfnkZQBoQ8NpQT6JMvWpDNlLoH9ZWvjsditQJAoaO33xHUu+I8smOjkCvn26GZlHn6a0EyGRkiTrCBbBjxw==</SignatureValue>
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
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Header>
        <nfeCabecMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/RecepcaoEvento">
            <cUF>35</cUF>
            <versaoDados>1.00</versaoDados>
        </nfeCabecMsg>
    </soap:Header>
    <soap:Body>
        <nfeRecepcaoEventoResult xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/RecepcaoEvento">
            <retEnvEvento versao="1.00" xmlns="http://www.portalfiscal.inf.br/nfe">
                <idLote>201705051652506</idLote>
                <tpAmb>2</tpAmb>
                <verAplic>SP_EVENTOS_PL_100</verAplic>
                <cOrgao>35</cOrgao>
                <cStat>128</cStat>
                <xMotivo>Lote de Evento Processado</xMotivo>
                <retEvento versao="1.00">
                    <infEvento>
                        <tpAmb>2</tpAmb>
                        <verAplic>SP_EVENTOS_PL_100</verAplic>
                        <cOrgao>35</cOrgao>
                        <cStat>155</cStat>
                        <xMotivo>Cancelamento homologado fora de prazo</xMotivo>
                        <chNFe>35150300822602000124550010009923461099234656</chNFe>
                        <tpEvento>110111</tpEvento>
                        <xEvento>Cancelamento registrado</xEvento>
                        <nSeqEvento>1</nSeqEvento>
                        <CNPJDest>00423803000159</CNPJDest>
                        <emailDest>fulano@mail.com.br</emailDest>
                        <dhRegEvento>2017-05-05T16:52:52-03:00</dhRegEvento>
                        <nProt>135170002129076</nProt>
                    </infEvento>
                </retEvento>
            </retEnvEvento>
        </nfeRecepcaoEventoResult>
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
            [versao] => 1.00
        )

    [idLote] => 201705051652506
    [tpAmb] => 2
    [verAplic] => SP_EVENTOS_PL_100
    [cOrgao] => 35
    [cStat] => 128
    [xMotivo] => Lote de Evento Processado
    [retEvento] => Array
        (
            [attributes] => Array
                (
                    [versao] => 1.00
                )

            [infEvento] => Array
                (
                    [tpAmb] => 2
                    [verAplic] => SP_EVENTOS_PL_100
                    [cOrgao] => 35
                    [cStat] => 155
                    [xMotivo] => Cancelamento homologado fora de prazo
                    [chNFe] => 35150300822602000124550010009923461099234656
                    [tpEvento] => 110111
                    [xEvento] => Cancelamento registrado
                    [nSeqEvento] => 1
                    [CNPJDest] => 00423803000159
                    [emailDest] => fulano@mail.com.br
                    [dhRegEvento] => 2017-05-05T16:52:52-03:00
                    [nProt] => 135170002129076
                )

        )

)
```

### JSON STRING

```json
{
    "attributes": {
        "versao": "1.00"
    },
    "idLote": "201705051652506",
    "tpAmb": "2",
    "verAplic": "SP_EVENTOS_PL_100",
    "cOrgao": "35",
    "cStat": "128",
    "xMotivo": "Lote de Evento Processado",
    "retEvento": {
        "attributes": {
            "versao": "1.00"
        },
        "infEvento": {
            "tpAmb": "2",
            "verAplic": "SP_EVENTOS_PL_100",
            "cOrgao": "35",
            "cStat": "155",
            "xMotivo": "Cancelamento homologado fora de prazo",
            "chNFe": "35150300822602000124550010009923461099234656",
            "tpEvento": "110111",
            "xEvento": "Cancelamento registrado",
            "nSeqEvento": "1",
            "CNPJDest": "00423803000159",
            "emailDest": "fulano@mail.com.br",
            "dhRegEvento": "2017-05-05T16:52:52-03:00",
            "nProt": "135170002129076"
        }
    }
}
```

### STDCLASS

```
stdClass Object
(
    [attributes] => stdClass Object
        (
            [versao] => 1.00
        )

    [idLote] => 201705051652506
    [tpAmb] => 2
    [verAplic] => SP_EVENTOS_PL_100
    [cOrgao] => 35
    [cStat] => 128
    [xMotivo] => Lote de Evento Processado
    [retEvento] => stdClass Object
        (
            [attributes] => stdClass Object
                (
                    [versao] => 1.00
                )

            [infEvento] => stdClass Object
                (
                    [tpAmb] => 2
                    [verAplic] => SP_EVENTOS_PL_100
                    [cOrgao] => 35
                    [cStat] => 155
                    [xMotivo] => Cancelamento homologado fora de prazo
                    [chNFe] => 35150300822602000124550010009923461099234656
                    [tpEvento] => 110111
                    [xEvento] => Cancelamento registrado
                    [nSeqEvento] => 1
                    [CNPJDest] => 00423803000159
                    [emailDest] => fulano@mail.com.br
                    [dhRegEvento] => 2017-05-05T16:52:52-03:00
                    [nProt] => 135170002129076
                )

        )

)
```

## SUCESSO

A consulta com sucesso poderá resultar:

| cStat | xMotivo |
| :---: | :--- | 
| 128 | Lote de Evento Processado |

Já na seção do retorno do evento "\<retEvento\>" :

| cStat | xMotivo |
| :---: | :--- | 
| 101 | Cancelamento homologado. |
| 155 | Cancelamento homologado fora de prazo. |
| 135 | Evento registrado e vinculado a NF-e |

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

### Verificação Inicial da Mensagem no Web Service

| cStat | xMotivo |
| :---: | :--- | 
| 108 | Serviço Paralisado Momentaneamente (curto prazo) |
| 109 | Serviço Paralisado sem Previsão |
| 214 | Rejeição: Tamanho da mensagem excedeu o limite estabelecido |
| 243 | Rejeição: XML Mal Formado |

### Validação das informações de controle da chamada ao Web Service

| cStat | xMotivo |
| :---: | :--- | 
| 238 | Rejeição: Cabeçalho - Versão do arquivo XML superior a Versão vigente |
| 239 | Rejeição: Cabeçalho - Versão do arquivo XML não suportada |
| 242 | Rejeição: Cabeçalho - Falha no Schema XML |
| 409 | Rejeição: Campo cUF inexistente no elemento nfeCabecMsg do SOAP Header |
| 410 | Rejeição: UF informada no campo cUF não é atendida pelo Web Service |
| 411 | Rejeição: Campo versaoDados inexistente no elemento nfeCabecMsg do SOAP Header |

### Validação da Forma da Área de Dados

| cStat | xMotivo |
| :---: | :--- |
| 225 | Rejeição: Falha no Schema XML do lote de NFe |
| 402 | Rejeição: XML da área de dados com codificação diferente de UTF-8 |
| 404 | Rejeição: Uso de prefixo de namespace não permitido |
| 491 | Rejeição: O tpEvento informado inválido |
| 492 | Rejeição: O verEvento informado inválido |
| 493 | Rejeição: Evento não atende o Schema XML específico |
| 516 | Rejeição: Falha no schema XML – inexiste a tag raiz esperada para a mensagem |
| 517 | Rejeição: Falha no schema XML – inexiste atributo versao na tag raiz da mensagem |
| 545 | Rejeição: Falha no schema XML – versão informada na versaoDados do SOAPHeader diverge da versão da mensagem |
| 587 | Rejeição: Usar somente o namespace padrão da NF-e |
| 588 | Rejeição: Não é permitida a presença de caracteres de edição no início/fim da mensagem ou entre as tags da mensagem |

### Validação do Certificado Digital de Assinatura

| cStat | xMotivo |
| :---: | :--- |
| 213 | Rejeição: CNPJ-Base do Emitente difere do CNPJ-Base do Certificado Digital |
| 290 | Rejeição: Certificado Assinatura inválido |
| 291 | Rejeição: Certificado Assinatura Data Validade |
| 292 | Rejeição: Certificado Assinatura sem CNPJ |
| 293 | Rejeição: Certificado Assinatura - erro Cadeia de Certificação |
| 294 | Rejeição: Certificado Assinatura revogado |
| 295 | Rejeição: Certificado Assinatura difere ICP-Brasil |
| 296 | Rejeição: Certificado Assinatura erro no acesso a LCR |
| 297 | Rejeição: Assinatura difere do calculado |
| 298 | Rejeição: Assinatura difere do padrão do Sistema |


### Validação de regras de negócios do Registro de Evento - parte Geral

| cStat | xMotivo |
| :---: | :--- |
| 236 | Rejeição: Chave de Acesso com dígito verificador inválido |
| 249 | Rejeição: UF da Chave de Acesso diverge da UF autorizadora |
| 250 | Rejeição: UF diverge da UF autorizadora |
| 252 | Rejeição: Ambiente informado diverge do Ambiente de recebimento |
| 489 | Rejeição: CNPJ informado inválido (DV ou zeros) |
| 490 | Rejeição: CPF informado inválido (DV ou zeros) |
| 494 | Rejeição: Chave de Acesso inexistente |
| 573 | Rejeição: Duplicidade de Evento |
| 574 | Rejeição: O autor do evento diverge do emissor da NF-e |
| 577 | Rejeição: A data do evento não pode ser menor que a data de emissão da NF-e |
| 578 | Rejeição: A data do evento não pode ser maior que a data do processamento |
| 579 | Rejeição: A data do evento não pode ser menor que a data de autorização para NF-e não emitida em contingência |
| 614 | Rejeição: Chave de Acesso inválida (Código UF inválido) |
| 615 | Rejeição: Chave de Acesso inválida (Ano menor que 06 ou Ano maior que Ano corrente) |
| 616 | Rejeição: Chave de Acesso inválida (Mês menor que 1 ou Mês maior que 12) |
| 617 | Rejeição: Chave de Acesso inválida (CNPJ zerado ou dígito inválido) |
| 618 | Rejeição: Chave de Acesso inválida (modelo diferente de 55 e 65) |
| 619 | Rejeição: Chave de Acesso inválida (número NF = 0) |


### Regras de validação específica do evento Cancelamento de NF-e

| cStat | xMotivo |
| :---: | :--- |
| 203 | Rejeição: Emissor não habilitado para emissão de NF-e |
| 219 | Rejeição: Circulação da NF-e verificada |
| 220 | Rejeição: Prazo de Cancelamento superior ao previsto na Legislação |
| 221 | Rejeição: Confirmado o recebimento da NF-e pelo destinatário |
| 222 | Rejeição: Protocolo de Autorização de Uso difere do cadastrado |
| 240 | Rejeição: Cancelamento/Inutilização - Irregularidade Fiscal do Emitente |
| 304 | Rejeição: Pedido de Cancelamento para NF-e com evento da Suframa |
| 501 | Rejeição: Pedido de Cancelamento intempestivo (NF-e autorizada a mais de 7 dias) |
| 503 | Rejeição: Série utilizada fora da faixa permitida no SCAN (900-999) | 
| 580 | Rejeição: O evento exige uma NF-e autorizada |
| 594 | Rejeição: O número de sequencia do evento informado é maior que o permitido |
| 690 | Rejeição: Pedido de Cancelamento para NF-e com CT-e |
| 770 | Rejeição: NFC-e autorizada há mais de 24 horas. |
