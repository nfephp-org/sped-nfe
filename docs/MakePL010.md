# CONSTRUÇÃO DO XML com dados do schema PL_010v1

> **IMPORTANTE:** Houve modificações nos métodos e em alguns campos desses métodos para a criação do XML.
 
> A mesma classe é capaz de criar os XML com os schemas da versão PL_009, bem como com os schemas da versão PL_010.
> Isso com base nos dados de configuração informados na construção da classe ($confgiJson). 
 
> Portanto, não há necessidade de se preocupar em usa a classe durante o período de testes e de transição para o novo formato. Querendo gerar no formato atual é só passar o PL_009 correto ou no caso de testes com a nova versão o PL_010.  

Para construir o XML da NFe (ou da NFCe) deve ser usada a classe Make::class

- Todos os dados de entrada dos métodos dessa classe (Make:class) são objetos e pode ser criados diretamente objetos (stdClass) ou como matrizes simples e convertidas em objetos.
- Muitos campos não são obrigatórios. Caso não haja nenhum valor a ser informado, devem ser informados como "null" ou nem serem informados, campos informados como string "vazias" ou "Zero" serão considerados válidos e poderão causar erros se estiverem incorretos.
- Caso existam erros na passagem de parâmetros para a classe, **NÃO será disparada nenhuma Exception**, mas esses erros poderão ser recuperados pelo método getErrors().
- A nova classe "Make:class" foi redesenhada para permitir o uso dos métodos sem necessidade de observar qualquer sequência lógica. Ou seja, podem ser chamados os métodos de forma totalmente aleatória, sem prejuízo para a construção do XML.
- Porém, existem métodos OBRIGATÓRIOS que deverão ser implementados SEMPRE, caso contrario serão gerados erros e o XML não passará na validação com o schema.

> NOTA: como forma de diminuir o tamanho do código a classe foi dividida em traits para os principais blocos construtivos do XML, mas houve um aumento nas propriedades da Make:class e portanto deve gerar um leve aumento no uso de memória para a construção do XML.

# Métodos

> **ALTERAÇÃO na construção da Make:class**
## function __construct(string $configJson) *(ALTERADO !!!)*
Método construtor. Instancia a classe 

- Alteração no método: foi inclusa a inserção dos dados de configuração também na classe construtora Make::class, para melhor identificar a versão a ser utilizada para a construção do XML e evitar erros durante o período de transição.

```php

$config = [
    "atualizacao" => "2018-09-28 09:29:21",
    "tpAmb" => 2,
    "razaosocial" => "TinicoTinoco",
    "siglaUF" => "SP",
    "cnpj" => "12345678901234",
    "schemes" => "PL_010_V1", //PL_010_V1 para a versão NOVA ou PL_009_V4 para a versão anterior dos schemas
    "versao" => "4.00",
    "tokenIBPT" => "",
    "CSC" => "",
    "CSCid" => "",
    "aProxyConf" => [
        "proxyIp" => "",
        "proxyPort" => "",
        "proxyUser" => "",
        "proxyPass" => ""
    ]
];
$configJson = json_encode($config);

$nfe = new Make($configJson);
```


## function taginfNFe($std):DOMElement
Node principal

> NOTA: **se o parametro $std->Id não for passado a chave será criada e inclusa e poderá ser recuperada no parâmetro chNFe da classe,**
**De outra forma se a chave for passada no parâmetro $std->Id e estiver incorreta, um erro será inserido na proriedade errors.**

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->versao = '4.00'; //versão do layout (string)
$std->Id = 'NFe35150271780456000160550010000000021800700082'; //se o Id de 44 digitos não for passado será gerado automaticamente
$std->pk_nItem = null; //deixe essa variavel sempre como NULL

$nfe->taginfNFe($std);

```

