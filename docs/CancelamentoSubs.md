# CANCELAMENTO POR SUBSTITUIÇÃO

## NFCe DUPLICADA

Como o prazo de cancelamento das NFCe é curto (minutos) e devido a natureza da operação com NFCe ser um processo ASSINCRONO e depender de um terceiro (SEFAZ), foi estabelecido um novo evento o "CANCELAMENTO POR SUBSTITUIÇÃO".

No dia 21 de Dezembro foi divulgada a Nota Técnica 2018.004 que cria uma nova forma de cancelamento: o Cancelamento por Substituição. Esse evento deve ser utilizado apenas quando existir outra NFCe em duplicidade, que tenha sido emitida e autorizada em contingência anteriormente e acoberte a mesma operação. O prazo da autorização não pode ser superior a 168 horas (7 dias).

O novo cancelamento tem previsão para implantação em ambiente de teste até dia 25 de Fevereiro de 2019 e sua Produção iniciará a partir do dia 29 de Abril de 2019.

Por enquanto, esse evento só é implementado para NFCe, porém é previsto que no futuro seja utilizada também para NFe.

### Como funciona o Cancelamento por Substituição?

Quando existem 2 NFCes representando a mesma venda (uma em emissão normal e outra em contingência) indicando duplicidade, o contribuinte deve cancelar a anterior indicando que foi feita uma nova emissão.

Normalmente acontece assim:

- A empresa envia para a Sefaz uma NFCe com tipo de emissão Normal (NFCe 1).
- Devido a algum problema ou indisponibilidade, não é possível obter o retorno se aquela NFCe foi ou não autorizada (deu timeout, caiu a conexão, SEFAZ fora do ar, internet indisponível).
- Sendo necessária realizar a venda, a empresa envia outra NFCe representando a mesma operação, porém agora em contingência Offline (NFCe 2).
- Quando o problema é resolvido, é verificado que a NFCe 1 havia sido autorizada pela a Sefaz. Porém a NFCe 2 também foi emitida (em contingência) e tem valor legal. Portanto existem 2 notas (NFCe 1 e NFCe 2) acobertando a mesma venda
- Mas se já se passaram muitos minutos, pode ser que o cancelamento normal da NFCe 1, não seja mais possivel (que é o que acontece em regra geral).
- Neste caso, a empresa deve emitir um Cancelamento por Substituição cancelando a NFCe 1 e referenciando que a NFCe 2 foi emitida em seu lugar e é o documento de posse do consumidor.

### Prazos para os Cancelamentos

O Cancelamento comum continua com os seguintes prazos (exceto exceções em legislações estaduais):

- 24 horas (1 dia) para NFe
- 30 minutos para NFCe
- e até menos tempo, como 15 minutos para NFCe (dependendo da SEFAZ)
 

Já o Cancelamento por Substituição pode ser realizado em até 168 horas (7 dias). **Esse prazo também pode ser alterado por uma legislação estadual.**

O Cancelamento por Substituição possui um novo código de tipo de evento (tpEvento): 110112.

Para o cancelamento comum, é necessário informar, além dos dados gerais do evento, o Número de Protocolo da NFe/NFCe autorizada e a Justificativa do cancelamento.


Agora para o cancelamento por substituição, é necessário preencher isso tudo e também:

- Código do Órgão Autor do evento: preencher com código da UF;
- Tipo de Autor: deve ser preenchido com 1=Empresa Emitente;
- Versão do Aplicativo do autor: preencher com o nome do software emissor e;
- Chave de Acesso da NFCe vinculada;


```xml
<?xml version="1.0" encoding="UTF-8"?>
<envEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
    <idLote>201903121806186</idLote>
    <evento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
        <infEvento Id="ID1101123518091234567890123465001000000002100000266701">
            <cOrgao>35</cOrgao>
            <tpAmb>2</tpAmb>
            <CNPJ>12345678901234</CNPJ>
            <chNFe>35180912345678901234650010000000021000002667</chNFe>
            <dhEvento>2019-03-12T18:06:18-03:00</dhEvento>
            <tpEvento>110112</tpEvento>
            <nSeqEvento>1</nSeqEvento>
            <verEvento>1.00</verEvento>
            <detEvento versao="1.00">
                <descEvento>Cancelamento por substituicao</descEvento>
                <cOrgaoAutor>35</cOrgaoAutor>
                <tpAutor>1</tpAutor>
                <verAplic>1234</verAplic>
                <nProt>135180140924930</nProt>
                <xJust>Falha na conexao internet</xJust>
                <chNFeRef>35180912345678901234650010000000011000002667</chNFeRef>
            </detEvento>
        </infEvento>
        <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
            <SignedInfo>
                <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
                <Reference URI="#ID1101123518091234567890123465001000000002100000266701">
                    <Transforms>
                        <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
                        <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                    </Transforms>
                    <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
                    <DigestValue>KiPG1GVwg4rkGm4yXdzHInHtPC8=</DigestValue>
                </Reference>
            </SignedInfo>
            <SignatureValue>PhaUavnuMe6zp8Kz+5eOjxl6m8pUnhcCER9CklPkeQFlXx3IaEyfXr1M9Tn7D2J8JD+XXgBfjKW9+mAGyeS7SgZv+2jO0GaOtT9FRJ6RclAoafnXRkuXQF7xnhllV0s6U5htz4O6uZeGy70A1P2pxeoTUP+fmraBtu8+ek6lgJbzlXvdBWPDvAMTE4x7iO2Nr/tA2VIsPEmzQLCmRUm6jQNx7ItaDjlgadi74K7i6UHVjfzGJlwnzAV/+oLu/xcEhkg6fqWCgpvAnotUL28svCYEKdhG2YhvH6/UdVhJaFVwtkUSA07cO+fZHgxSRh2g145dEA3uVKDhSeafZMhjGA==</SignatureValue>
            <KeyInfo>
                <X509Data>
                    <X509Certificate>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</X509Certificate>
                </X509Data>
            </KeyInfo>
        </Signature>
    </evento>
</envEvento>
```

### Novas Regras de Validação

Com o novo evento, foram adicionados algumas novas rejeições. Segue a lista completa:

- Rejeição 910: Chave de Acesso NF-e Substituta inválida
- Rejeição 911: Chave de Acesso NF-e Substituta incorreta
- Rejeição 912: NF-e Substituta inexistente
- Rejeição 913: NF-e Substituta Denegada ou Cancelada
- Rejeição 914: Data de emissão da NF-e Substituta maior que 2 horas da data de emissão da NFe a ser cancelada
- Rejeição 915: Valor total da NF-e Substituta difere do valor da NF-e a ser cancelada
- Rejeição 916: Valor total do ICMS da NF-e Substituta difere do valor da NF-e a ser cancelada
- Rejeição 917: Identificação do destinatário da NF-e Substituta difere da identificação do destinatário da NF-e a ser cancelada
- Rejeição 918: Quantidade de itens da NF-e Substituta difere da quantidade de itens da NF-e a ser cancelada
- Rejeição 919: Item da NF-e Substituta difere do mesmo item da NF-e a ser cancelada
- Rejeição 920: Tipo de Emissão inválido no Cancelamento por Substituição


### Exemplo de Cancelamento por Substituição

```php
use NFePHP\Common\Certificate;
use NFePHP\NFe\Tools;
use NFePHP\NFe\Common\Standardize;

$config = [
    "atualizacao" => "2018-09-28 09:29:21",
    "tpAmb"       => 1,
    "razaosocial" => "Empresa SA",
    "siglaUF"     => "SP",
    "cnpj"        => "12345678901234",
    "schemes"     => "PL_009_V4",
    "versao"      => "4.00",
    "tokenIBPT"   => "",
    "CSC"         => "19191919",
    "CSCid"       => "00001",
    "aProxyConf"  => [
        "proxyIp"   => "",
        "proxyPort" => "",
        "proxyUser" => "",
        "proxyPass" => ""
    ]
];
$configJson = json_encode($config);

try {
    $cert = Certificate::readPfx(file_get_contents('certificado.pfx'), 'senha');
    $tools = new Tools($configJson, $cert);
    $tools->model('65');
    
    $chave = '35180912345678901234650010000000021000002667';
    $xJust = 'Falha na conexao internet';
    $nProt = '135180140924930';
    $chNFeRef = '35180912345678901234650010000000011000002667';
    $verAplic = '1234';
    $response = $tools->sefazCancelaPorSubstituicao($chave, $xJust, $nProt, $chNFeRef, $verAplic);
    
    header('Content-Type: application/xml; charset=utf-8');
    echo $response;
} catch (\Exception $e) {
    echo $e->getMessage();
}
```