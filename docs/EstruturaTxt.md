# Estrutura do TXT da NFe

Para montar esse txt algumas regras básicas devem ser obedecidas:

1. Todas as linhas devem terminar com "|" (pipe) e em seguida um "LF"  (Line Feed ou "\n").
2. Nos campos separados por "|" (pipe) não podem apenas ter espaços em branco, ou existe dado ou fica sem nada.
3. Não são permitidos quaisquer caracteres especiais, exceto o "LF" ("\n") ao linal da linha.
4. Recomenda-se **não usar acentuação**, por exemplo "Ç" substitua por "C"
5. Não são permitidas aspas (simples ou duplas)
6. Caso alguma variável não exista, ou não seja necessária, seu campo deve ser deixado "VAZIO". ex. A|versao|Id||, nesse caso não temos o último valor "pk_nItem"
7. Não devem ser inclusos campos que não serão usadas. ex. BA02|refNFe| se não existir uma referencia a NFe, ignore o campo, ele não existe, mas **não faça "BA02||"**

## Como testar o TXT ?

O TXT que foi criado pode ser validado, com relação a sua estrutura básica usando a classe ValidTXT::class.

```php

use NFePHP\NFe\Common\ValidTXT;

$txt = file_get_contents('nfe.txt');
$errors = ValidTXT::isValid($txt);

print_r($errors);

```

O métod estatico isValid(), irá retornar um ARRAY contendo os erros encontrados ou um array VAZIO caso nenhum erro seja localizado.

> NOTA: Esta analise é apenas feita sobre a estrutura do TXT e não sobre o conteúdo dos campos, portanto isso não irá impedir que **surjam erros** tentar converter ou ainda após a analise do XML pelo autorizador (SEFAZ).

> IMPORTANTE: A estrutura tanto do XML como do TXT depende da versão do layout da SEFAZ, neste caso estamos indicando a estrutura da **versão 3.10 do layout**.

O arquivo TXT sempre inicia com **NOTAFISCAL|numero de notas|**, onde o numero de notas indica o total de NFes contidas nessa string. Esse campo ocorre apenas uma vez. 

Cada nova NFe inicia com **A|versao|Id|pk_nItem|**, onde versão é a versão do layout usado (3.10 ou 4.00) e Id é a chave da NFe, ex. NFe35170349607369000156550010000022260003815585, pk_nItem não é usado normalmente.

## [Estrutura, **layout 3.10**](txtlayout310.md)

## [Estrutura, **layout 4.00**](txtlayout400.md)

