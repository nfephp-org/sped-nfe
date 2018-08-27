# CARTA DE CORREÇÃO

Enviar uma Carta de Correção eletrônica referente a uma NFe autorizada previamente.

**Função:**  Serviço destinado à recepção de mensagem de Evento da NF-e

A Carta de Correção é um evento para corrigir as informações da NF-e, prevista na cláusula décima quarta-A do Ajuste SINIEF 07/05.

O autor do evento é o emissor da NF-e. A mensagem XML do evento será assinada com o certificado digital que tenha o CNPJ base do Emissor da NF-e.

O evento será utilizado pelo contribuinte e o alcance das alterações permitidas é definido no § 1o do art. 7o do Convênio SINIEF s/n de 1970:

> *“Art. 7o Os documentos fiscais referidos nos incisos I a V do artigo anterior deverão ser extraídos por decalque a carbono ou em papel carbonado, devendo ser preenchidos a máquina ou manuscritos a tinta ou a lápis-tinta, devendo ainda os seus dizeres e indicações estar bem legíveis, em todas as vias.(...)*

> *§ 1o-A Fica permitida a utilização de carta de correção, para regularização de erro ocorrido na emissão de documento fiscal, desde que o erro não esteja relacionado com:*

> *I - as variáveis que determinam o valor do imposto tais como: base de cálculo, alíquota, diferença de preço, quantidade, valor da operação ou da prestação;*

> *II - a correção de dados cadastrais que implique mudança do remetente ou do destinatário;*

> *III - a data de emissão ou de saída.”*

O registro de *uma nova Carta de Correção* **substitui a Carta de Correção anterior**, assim a nova Carta de Correção deve conter **todas as correções** a serem consideradas.

**Processo:** síncrono.

**Método:** nfeRecepcaoEvento

## Descrição

**A carta de correção, não tem formato de impressão.** Mas como alguns ainda estão com um pé no passado, foi criado uma classe em sped-da para gerar essas CCe em PDF. 

A CCe, se for aceita, deve ser protocolada com a resposta da SEFAZ, e ser armazenada para garantir o atendimento a legislação.

Esse documento protocolado também DEVE ser enviado aos destinatários (comprador, transportador, etc.)

Podem existir várias CCe para uma unica NFe, então o "nSeqEvento" deve ser incrementado, a cada nova CCe, para uma mesma NFe.

> ATENÇÃO: Os erros reportados na Carta de Correção, são incrementais também, ou seja a segunda CCe deve também incluir os erros reportados na primeira CCe e assim por diante.

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
    $xCorrecao = 'Informações complementares. Onde está X leia-se Y';
    $nSeqEvento = 1;
    $response = $tools->sefazCCe($chave, $xCorrecao, $nSeqEvento);

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
        if ($cStat == '135' || $cStat == '136') {
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
| $xCorrecao |  (OBRIGATÓRIO) |
| $nSeqEvento | Número sequencial do evento (OBRIGATÓRIO) |


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
        <idLote>201705171838471</idLote>
        <evento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
          <infEvento Id="ID11011035170449607777700015655001000992346109923465601">
            <cOrgao>35</cOrgao>
            <tpAmb>2</tpAmb>
            <CNPJ>49607777000156</CNPJ>
            <chNFe>351704496077777000156550010000022511003873504</chNFe>
            <dhEvento>2017-05-17T18:38:47-03:00</dhEvento>
            <tpEvento>110110</tpEvento>
            <nSeqEvento>1</nSeqEvento>
            <verEvento>1.00</verEvento>
            <detEvento versao="1.00">
              <descEvento>Carta de Correcao</descEvento>
              <xCorrecao>Apenas um teste para ver como e montada a mensagem</xCorrecao>
              <xCondUso>A Carta de Correcao e disciplinada pelo paragrafo 1o-A do art. 7o do Convenio S/N, de 15 de dezembro de 1970 e pode ser utilizada para regularizacao de erro ocorrido na emissao de documento fiscal, desde que o erro nao esteja relacionado com: I - as variaveis que determinam o valor do imposto tais como: base de calculo, aliquota, diferenca de preco, quantidade, valor da operacao ou da prestacao; II - a correcao de dados cadastrais que implique mudanca do remetente ou do destinatario; III - a data de emissao ou de saida.</xCondUso>
            </detEvento>
          </infEvento>
          <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
            <SignedInfo>
              <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
              <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
              <Reference URI="#ID1101103515030082260200012455001000992346109923465601">
                <Transforms>
                  <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
                  <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                </Transforms>
                <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
                <DigestValue>kSKDdWojBxy1IIc40skM2B7xm2s=</DigestValue>
              </Reference>
            </SignedInfo>
            <SignatureValue>J6MMNCfoODgL5moBhPfmR...xtrocBTX/LoWKUdKyQnjMU9LlO5muf+B3w==</SignatureValue>
            <KeyInfo>
              <X509Data>
                <X509Certificate>MIIINTCCBh2gA...Q8kCqBbhmfLofh87czMj4Er4=</X509Certificate>
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
                <idLote>201705171838471</idLote>
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
                        <cStat>135</cStat>
                        <xMotivo>Evento registrado e vinculado a NF-e</xMotivo>
                        <chNFe>35170449607777000156550010000022511003873504</chNFe>
                        <tpEvento>110110</tpEvento>
                        <xEvento>Carta de Correção registrada</xEvento>
                        <nSeqEvento>1</nSeqEvento>
                        <CNPJDest>00423888000159</CNPJDest>
                        <emailDest>dest@mail.com.br</emailDest>
                        <dhRegEvento>2017-05-17T11:45:33-03:00</dhRegEvento>
                        <nProt>135170002269169</nProt>
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

    [idLote] => 201705171838471
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
                    [cStat] => 135
                    [xMotivo] => Evento registrado e vinculado a NF-e
                    [chNFe] => 35170449607777000156550010000022511003873504
                    [tpEvento] => 110110
                    [xEvento] => Carta de Correção registrada
                    [nSeqEvento] => 1
                    [CNPJDest] => 00423888000159
                    [emailDest] => dest@mail.com.br
                    [dhRegEvento] => 2017-05-17T11:45:33-03:00
                    [nProt] => 135170002269169
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
    "idLote": "201705171838471",
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
            "cStat": "135",
            "xMotivo": "Evento registrado e vinculado a NF-e",
            "chNFe": "35170449607777000156550010000022511003873504",
            "tpEvento": "110110",
            "xEvento": "Carta de Corre\u00e7\u00e3o registrada",
            "nSeqEvento": "1",
            "CNPJDest": "00423888000159",
            "emailDest": "dest@mail.com.br",
            "dhRegEvento": "2017-05-17T11:45:33-03:00",
            "nProt": "135170002269169"
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

    [idLote] => 201705171838471
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
                    [cStat] => 135
                    [xMotivo] => Evento registrado e vinculado a NF-e
                    [chNFe] => 35170449607777000156550010000022511003873504
                    [tpEvento] => 110110
                    [xEvento] => Carta de Correção registrada
                    [nSeqEvento] => 1
                    [CNPJDest] => 00423888000159
                    [emailDest] => dest@mail.com.br
                    [dhRegEvento] => 2017-05-17T11:45:33-03:00
                    [nProt] => 135170002269169
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
| 135 | Evento registrado e vinculado a NF-e |
| 136 | Evento registrado, mas não vinculado a NF-e |

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


### Regras de validação específicas do evento Carta de Correção

| cStat | xMotivo |
| :---: | :--- | 
| 203 | Rejeição: Emissor não habilitado para emissão da NF-e |
| 240 | Rejeição: Situação Fiscal irregular do Emitente |
| 580 | Rejeição: O evento exige uma NF-e autorizada (pode estar cancelada ou denegada) |
| 594 | Rejeição: O número de sequencia do evento informado é maior que o permitido |
| 784 | Rejeição: NFC-e não permite o evento de Carta de Correção |
