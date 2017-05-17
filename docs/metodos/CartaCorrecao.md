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

[NFePHP\NFe\Common\Complements::class](Complements.md)


## Exemplo de Uso

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Common\Complements;

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