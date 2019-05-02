# ValidTXT::class

A classe [ValidTXT](../src/Common/ValidTXT.php) é responsável pela validação básica das entidades qe compõe a estrutura dos arquivos TXT.

Existem dois formatos diferentes (**devido a falta informação oriunda da SEFAZ e do SEBRAE**), um formato criado por nós (LOCAL) e um formato obtido por engenharia reversa com base no emissor gratuito do Sebrae (SEBRAE).

[FORMATO LOCAL 4.00](txtlayout400.md)

[FORMATO SEBRAE 4.00](txtlayout400_sebrae.md) Leia com atenção!! *Em desenvolvimento*

Esta classe valida os TXT com base nos seguintes parâmetros:

1. todas as entidades no TXT (cada linha) deve terminar com pipe "|".
2. não podem haver outros caracteres de controle além do Line Feed (LF ou \n) para terminar a linha (ex. CR ou TAB).
3. as entidades devem existir no layout basico (vide acima).
4. o número de campos de cada entidade deve ser exatamente o mesmo numero indicado na estrutura.
5. nos campos de dados não podem haver apenas espaços em branco.

> NOTA: essa validação é intrínseca ao processo normal de conversão (ou seja já é realizada pela classe Convert). E deve ser usada apenas para algum tipo de pré-validação, se desejável.

## Método de validação

### function isValid($txt, $formato): array

Onde

| Campo | Descrição |
| :---- | :---- |
| $txt  | (OBRIGATÓRIO) é o conteúdo do TXT que se quer validar (não um path)|
| $formato | (OPCIONAL) é uma constante da classe para o formato local use ValidTXT::LOCAL ou não declare, e para o formato da Sebrae use ValidTXT::SEBRAE|

O método irá retornar um array que 

Array **Vazio** = TXT válido 

Array **Não Vazio** = TXT INVÁLIDO e o array irá conter os erros encontrados na estrutura.

### Exemplo de uso (padrão SEBRAE)

```php
use NFePHP\NFe\Common\ValidTXT;

$txt = file_get_contents('nota_formato_sebrae.txt');
$resp = ValidTXT::isValid($txt, ValidTXT::SEBRAE);

if (!empty($resp)) {
    echo "<h2>Erros Encontrados</h2><pre>";
    print_r($resp);
    echo "</pre>";
} else {
    echo "<h2>Txt Válido</h2>";
}

```

### Exemplo de uso (padrão LOCAL)

```php
use NFePHP\NFe\Common\ValidTXT;

$txt = file_get_contents('nota_formato_local.txt');
$resp = ValidTXT::isValid($txt);

if (!empty($resp)) {
    echo "<h2>Erros Encontrados</h2><pre>";
    print_r($resp);
    echo "</pre>";
} else {
    echo "<h2>Txt Válido</h2>";
}

```