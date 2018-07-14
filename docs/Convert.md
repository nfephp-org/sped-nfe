# CONVERSÃO DE TXT PARA XML DE NFe

Quando nos temos sistemas legados, a criação de XML com os mesmos pode ser mais complexa ou até inviável. Para esses casos podemos criar as nossas NFe em um formato TXT, seguindo as estruturas defindas pela SEFAZ e posteriormente converter esses TXT no XML corretamente formatado.

A estrutura do txt, está indicada no documento [EstruturaTxt](EstruturaTxt.md) e deve ser complementado com o Manual de Orientação e o Manual do Layout do TXT ambos emitidos pela SEFAZ.

> NOTA: O Manual do Layout do TXT contêm vários ERROS e OMISSÕES, consequentemente para a montagem desta classe foi necessário (e sempre será) fazer uma "engenharia reversa" usando como base o próprio emissor gratuito da SEFAZ.

## Métodos

public static function toXML($txt)

## Parametros

| Variável | Detalhamento  |
| :---:  | :--- |
| $txt | String com o conteúdo do arquivo TXT (OBRIGATÓRIO) |
| $axml | ARRAY contendo uma ou mais NFe em formato XML |

> NOTA: O TXT poderá conter uma ou mais notas, conforme a estrutura definida pela SEFAZ.

## Formas de Uso

### Chamada estática

```php

use NFePHP\NFe\Convert;

try {
    $axml = Convert::parse($txt);
    foreach($axml as $xml) {
        //aqui você processa o xml na operação que desejar
    }
} catch (\Exception $e) {
    //tratar exceptions
    echo str_replace("\n", "<br/>", $e->getMessage());
}
```

### Chamada normal

```php

use NFePHP\NFe\Convert;

try {
    $conv = new Convert($txt);
    $axml = $conv->toXML();
    foreach($axml as $xml) {
        //aqui você processa o xml na operação que desejar
    }
} catch (\Exception $e) {
    //tratar exceptions
    echo str_replace("\n", "<br/>", $e->getMessage());
}
```


## Exceptions e Erros

O TXT passado como parametro, será VALIDADO, com referência as [regras estabelecidas](EstruturaTxt.md), antes de sua conversão.

Se alguma falha for detectada será disparada uma Exception com o motivo.

> NOTA: não devem ser gerados ERROS, se forem, por favor nos informe.

Poderão ser retornados erros referentes a estrutura do TXT, como:

- Número de campos da linha não corresponder ao padrão estabelecido
- Denominação da chave de busca (primeiro conjunto de caracteres de cada linha) não corresponder ao padrão estabelecido.

> NOTA: Para ajudar os desavisados e aqueles que usam recurursos em windows, a classe já executa uma higeinização prévia do conteúdo do TXT,  removendo [Carriage Retruns], [TAB], espaços duplos, espaços antes e após as marcas separadoras de campos (pipe) "|" .