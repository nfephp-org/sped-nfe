# Complements::class

Esta classe possibilita a inclusão dos protocolos de autorização, denegação ou cancelamento aos documentos eletrônicos.

Devem ser protocolados os seguintes documentos, para terem validade juridica:

- Nota Fiscal (NFe ou NFCe)
- Solicitação de Inutilização de faixa de numeros de notas que foram "pulados"
- Eventos (cancelamentos, cartas de correção, EPP, ECPP, etc.)

Adicionalmente, esta classe também permite a inclusão de TAGs especiais referentes a requisitos de montadoras como o da ANFAVEA.

E também permite a *"marcação"* de NFe como cancelada, **este não é um requisito oficial**, mas eu mesmo utilizo para garantir que ao cancelar o próprio XML da NFe (ou NFCe) contenha essa informação ao ser guardada para efeitos legais, evitando enganos na visualização ou uso posteiror desse documento.

## Métodos

### toAuthorize($request, $response):string

Este método realiza a junção do protocolo de autorização com a requeiição original, criando um documentos VÁLIDO.

Escopo: Publico

Modo: Estático

Retorna: String

| Parametro | Tipo | Descrição |
| :---  | :---: | :--- |
| $request | string | XML correspondente a solicitação ex. NFe assinada, pedido de Inutilização, etc. |
| $response | string | XML de resposta da SEFAZ retornado pelos metodos chamadores |

**Exception**

- $request não é um XML válido
- $response não é um XML válido
- um dos XML não faz parte do projeto NFe (pode ser de outro como o CTe por exemplo)
- $response não pertence ao $request (e vice-versa)
- $response contêm anuncio de ERRO 
- $response não comtêm a TAG necessária
- 

**Exemplo de USO**

```php

use NFePHP\NFe\Complements;

$req = "<XML conteudo original do documento que quer protocolar>";
$res = "<XML conteudo do retorno com a resposta da SEFAZ>";

try {
    $xml = Complements::toAuthorize($req, $res);
    header('Content-type: text/xml; charset=UTF-8');
    echo $xml;
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
```

### b2bTag($nfe, $b2b, $tagB2B = 'NFeB2BFin')

Este médodo adiciona um conjunto de informações auxiliares estabelecidos por entidades de classe para facilitar o reconhecimento do documento pelos sistemas ERP dessas empresas.

Escopo: Publico
Modo: Estático
Retorna: String

| Parametro | Tipo | Descrição |
| :---  | :---: | :--- |


**Exception**


**Exemplo de USO**

```php

use NFePHP\NFe\Complements;

$req = "<XML conteudo original do documento que quer protocolar>";
$res = "<XML conteudo do retorno com a resposta da SEFAZ>";

try {
    $xml = Complements::toAuthorize($req, $res);
    header('Content-type: text/xml; charset=UTF-8');
    echo $xml;
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
```


### cancelRegister($nfe, $cancelamento)

Este método apenas marca a NFe como cancelada. Isso não é um item obrigatório é apenas uma função que permite que os XML das NFe sejam facilmente reconhecidos como canceladas. E tem como finalidade evitar o registro indevido por parte de alguns sistemas, o envio ou a impressão de um documentos cancelado que poderia ter consequências legais.

> NOTA: essa operação não é de forma alguma estabelecida pela legislação, mas trata-se apenas de uma questão puramente operacional. 

Escopo: Publico
Modo: Estático
Retorna: String

| Parametro | Tipo | Descrição |
| :---  | :---: | :--- |


**Exception**


**Exemplo de USO**

```php

use NFePHP\NFe\Complements;

$nfe = "<XML da NFe protocolada e autorizada>";
$cancelamento = "<XML conteudo do retorno com a resposta de cancelamento autorizado da SEFAZ>";

try {
    $xml = Complements::cancelRegister($nfe, $cancelamento);
    header('Content-type: text/xml; charset=UTF-8');
    echo $xml;
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
```
