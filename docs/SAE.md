# SAE - Serviços de Apoio à Escrituração da NFC-e

Webservice estadual para consulta e download de XMLs de NFC-e autorizadas pela SEFAZ.

---

## Descrição

O SAE (Serviços de Apoio à Escrituração) disponibiliza webservices que permitem ao contribuinte consultar e baixar os XMLs das NFC-es autorizadas pela SEFAZ para o CNPJ presente no certificado digital utilizado na chamada.

Os endpoints são configurados por estado no arquivo `storage/wsae_nfce.json`, permitindo que novos estados sejam adicionados sem alteração de código.

### Serviços disponíveis

| Serviço | Descrição |
|---------|-----------|
| `NFCeListagemChaves` | Retorna as chaves de acesso das NFC-es do CNPJ em um período |
| `NFCeDownloadXML` | Baixa o XML completo de uma NFC-e pela chave de acesso |

### Regras gerais

- O CNPJ do certificado digital e-CNPJ é o filtro das consultas — não é possível consultar NFC-es de outro CNPJ.
- O período máximo de consulta retroativa é de **100 dias**.
- A listagem retorna no máximo **2000 chaves** por requisição. Quando há mais resultados, `cStat=101` é retornado com `dhEmisUltNfce` para uso na paginação.
- Existe limite de requisições por IP por minuto. Quando excedido, `cStat=656` é retornado.

---

## Dependências

[NFePHP\Common\Certificate::class](Config.md)

[NFePHP\Common\Soap\SoapCurl::class](Tools.md) *(carregada automaticamente)*

---

## Ambientes

| Constante | Valor | Descrição |
|-----------|-------|-----------|
| `SAE::TPAMB_PRODUCAO` | `1` | Ambiente de produção |
| `SAE::TPAMB_HOMOLOGACAO` | `2` | Ambiente de homologação (padrão) |

Os endpoints de cada ambiente por estado são definidos em `storage/wsae_nfce.json`.

---

## Métodos

### `__construct(Certificate $certificate, string $uf, int $tpAmb)`

Instancia a classe SAE.

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| `$certificate` | `Certificate` | Certificado e-CNPJ do contribuinte |
| `$uf` | `string` | Sigla do estado (ex.: `'SP'`) |
| `$tpAmb` | `int` | `1` = Produção, `2` = Homologação (padrão) |

> Lança `InvalidArgumentException` se o ambiente for inválido ou se o estado não estiver configurado em `storage/wsae_nfce.json`.

---

### `loadSoapClass(SoapInterface $soap): void`

Injeta uma implementação SOAP alternativa. Útil para testes com `SoapFake`.

---

### `listagemChaves(string $dataHoraInicial, ?string $dataHoraFinal = null): string`

Retorna as chaves de acesso das NFC-es autorizadas para o CNPJ do certificado no período informado.

| Parâmetro | Tipo | Obrigatório | Formato | Descrição |
|-----------|------|-------------|---------|-----------|
| `$dataHoraInicial` | `string` | Sim | `AAAA-MM-DDThh:mm` | Início do período |
| `$dataHoraFinal` | `string\|null` | Não | `AAAA-MM-DDThh:mm` | Fim do período |

**Retorno:** XML de resposta da SEFAZ (`retNfceListagemChaves`).

**Códigos de retorno relevantes:**

| cStat | Descrição |
|-------|-----------|
| `100` | Consulta realizada com sucesso — lista completa |
| `101` | Lista incompleta (mais de 2000 NFC-es). Usar `dhEmisUltNfce` para paginar |
| `107` | Sem registros no período informado |
| `104` | `dataHoraInicial` anterior ao limite máximo de dias |
| `110` | `dataHoraFinal` anterior à `dataHoraInicial` |
| `656` | Consumo indevido — limite de requisições excedido |

> Lança `InvalidArgumentException` se as datas não estiverem no formato `AAAA-MM-DDThh:mm`.

---

### `downloadXML(string $chNFCe): string`

Baixa o XML completo de uma NFC-e (dados da nota e eventos associados, como cancelamento).

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| `$chNFCe` | `string` | Chave de acesso com 44 dígitos numéricos |

**Retorno:** XML de resposta da SEFAZ (`retNfceDownloadXML`). Quando bem-sucedido (`cStat=200`), o elemento `<proc>` contém:
- `<nfeProc>` — XML da NFC-e autorizada com protocolo
- `<procEventoNFe>` — Um ou mais eventos autorizados (ex.: cancelamento)

**Códigos de retorno relevantes:**

| cStat | Descrição |
|-------|-----------|
| `200` | Download realizado com sucesso |
| `203` | CNPJ na chave difere do CNPJ do certificado |
| `204` | Chave de acesso inválida |
| `205` | Chave não encontrada |
| `207` | Data de emissão anterior ao limite máximo de dias |
| `656` | Consumo indevido — limite de requisições excedido |

> Lança `InvalidArgumentException` se a chave não tiver exatamente 44 dígitos numéricos.

---

### Propriedades públicas

| Propriedade | Tipo | Descrição |
|-------------|------|-----------|
| `$lastRequest` | `string` | XML da última requisição enviada |
| `$lastResponse` | `string` | XML da última resposta recebida |

---

## Configuração de estados (`storage/wsae_nfce.json`)

Os endpoints por estado são configurados no arquivo `storage/wsae_nfce.json`. Para adicionar um novo estado, inclua um bloco com a sigla correspondente seguindo o mesmo padrão:

```json
{
    "UF": {
        "versao": "1.00",
        "namespace": "http://www.portalfiscal.inf.br/nfe",
        "NFCeListagemChaves": {
            "method": "nfceListagemChaves",
            "operation": "NFCeListagemChaves",
            "homologacao": "https://homologacao.exemplo.estado.gov.br/ws/NFCeListagemChaves.asmx",
            "producao": "https://exemplo.estado.gov.br/ws/NFCeListagemChaves.asmx"
        },
        "NFCeDownloadXML": {
            "method": "nfceDownloadXML",
            "operation": "NFCeDownloadXML",
            "homologacao": "https://homologacao.exemplo.estado.gov.br/ws/NFCeDownloadXML.asmx",
            "producao": "https://exemplo.estado.gov.br/ws/NFCeDownloadXML.asmx"
        }
    }
}
```

---

## Exemplos de uso

### Listagem de chaves (período simples)

```php
use NFePHP\NFe\SAE;
use NFePHP\Common\Certificate;

$certificate = Certificate::readPfx(
    file_get_contents('/path/to/certificado.pfx'),
    'senha_do_certificado'
);

$sae = new SAE($certificate, 'SP', SAE::TPAMB_PRODUCAO);

$response = $sae->listagemChaves('2024-01-01T00:00', '2024-01-31T23:59');

$dom = new DOMDocument();
$dom->loadXML($response);

$cStat   = $dom->getElementsByTagName('cStat')->item(0)->nodeValue;
$xMotivo = $dom->getElementsByTagName('xMotivo')->item(0)->nodeValue;

if ($cStat === '100') {
    $chaves = $dom->getElementsByTagName('chNFCe');
    foreach ($chaves as $chave) {
        echo $chave->nodeValue . PHP_EOL;
    }
}
```

### Paginação quando há mais de 2000 chaves

```php
$inicio = '2024-01-01T00:00';
$fim    = '2024-01-31T23:59';

do {
    $response = $sae->listagemChaves($inicio, $fim);

    $dom = new DOMDocument();
    $dom->loadXML($response);
    $cStat = $dom->getElementsByTagName('cStat')->item(0)->nodeValue;

    foreach ($dom->getElementsByTagName('chNFCe') as $chave) {
        // processar chave...
    }

    // cStat=101: lista incompleta, paginar usando dhEmisUltNfce como novo início
    if ($cStat === '101') {
        $dhEmis = $dom->getElementsByTagName('dhEmisUltNfce')->item(0)->nodeValue;
        // dhEmisUltNfce vem no formato AAAA-MM-DDThh:mm:ss, truncar para hh:mm
        $inicio = substr($dhEmis, 0, 16);
    }

} while ($cStat === '101');
```

### Download do XML de uma NFC-e

```php
use NFePHP\NFe\SAE;
use NFePHP\Common\Certificate;

$certificate = Certificate::readPfx(
    file_get_contents('/path/to/certificado.pfx'),
    'senha_do_certificado'
);

$sae = new SAE($certificate, 'SP', SAE::TPAMB_PRODUCAO);

$chave    = '35240193623057000128650010000002401717268120';
$response = $sae->downloadXML($chave);

$dom = new DOMDocument();
$dom->loadXML($response);

$cStat = $dom->getElementsByTagName('cStat')->item(0)->nodeValue;

if ($cStat === '200') {
    // Salvar o XML da NFC-e autorizada
    $nfeProcNode = $dom->getElementsByTagName('nfeProc')->item(0);
    if ($nfeProcNode) {
        $nfeProcXml = $dom->saveXML($nfeProcNode);
        file_put_contents("nfce_{$chave}.xml", $nfeProcXml);
    }

    // Verificar se há eventos (ex.: cancelamento)
    $eventos = $dom->getElementsByTagName('procEventoNFe');
    foreach ($eventos as $evento) {
        $nProt = $dom->getElementsByTagName('nProt')->item(0)->nodeValue;
        // processar evento...
    }
}
```

### Uso em desenvolvimento com SoapFake

```php
use NFePHP\NFe\SAE;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;

$certificate = Certificate::readPfx(
    file_get_contents('/path/to/certificado.pfx'),
    'senha_do_certificado'
);

$soap = new SoapFake();
$soap->disableCertValidation(true);

$sae = new SAE($certificate, 'SP', SAE::TPAMB_HOMOLOGACAO);
$sae->loadSoapClass($soap);

$response = $sae->listagemChaves('2024-01-01T00:00', '2024-01-31T23:59');

// Inspecionar o XML gerado sem realizar chamada real ao webservice
echo $sae->lastRequest;
```
