# PADRONIZAÇÃO DOS DADOS RETORNADOS

Esta classe (Standardize::class) foi criada para permitir algumas facilidades na hora de obter os dados dos retornos da SEFAZ.

## Descrição
Converte um XML em:

- stdClass do PHP;
- array
- json encoded string
- string xml com o node com as informações relevantes identificado 

## Exemplo de Uso

```php

use NFePHP\NFe\Common\Standardize;

$stdCl = new Standardize($response);

//$std irá conter uma representação em stdClass do XML
$std = $stdCl->toStd();

//$arr irá conter uma representação em array do XML
$arr = $stdCl->toArray();

//$json irá conter uma representação em JSON do XML
$json = $stdCl->toJson();
    
```

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
