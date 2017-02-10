#Ide::class

Node de Identificação da NFe, contêm as informações básicas referentes a uma NFe, inclusive os dados necessários para a geração da chave de 44 digitos.
Essa é um NODE obrigatório e está presentente em toda e qualuqer NFe ou NFCe emitida.

>NOTA: Leia as informações sobre a classe [Contingency](Contingency.md)

>NOTA: Essas classes não irão realizar nenhum tipo especifico de validação sobre os dados inseridos, portanto cabe ao aplicativo que fará uso da classe garantir a correção das informações.

>NOTA: As propriedades da stdClass, devem ser obrigatóriamente as mesmas indicadas no Manual da SEFAZ, ou seja, são os mesmos nomes usados na identificação de cada elemento do layout do XML. Com uma vantagem não é necessário se preocupar em usar letras maiusculas ou minusculas, pois os dados são "case insensitive".

>NOTA: Caso alguma propriedade não seja definida, quer por esquecimento, quer por não ser necessária, ela será desconsiderada se não for obrigatória, e inserida vazia no XML caso seja obrigatória.

>NOTA: Estas classes não deverão NUNCA retornar ERRORS, WARNINGS, NOTICES ou EXCEPTIONS, simplesmente irão processar o XML com ou sem as informações devidas, pois o mesmo deverá ser validado a posteriori com base em seu respectivo XSD.

>NOTA: Este NODE não possue subnodes.

##Forma de USO

```php

use stdClass;
use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Tag;

//========================
//TAG <ide> [1 - 1] pai <infNFe>
//========================
$ide = new stdClass();
$ide->cUF = 23;
$ide->cNF = '10';//se não for passado será usado o numero da nota nNF
$ide->natOp = 'Venda de Produto';
$ide->indPag = 0;
$ide->mod = 55;
$ide->serie = 1;
$ide->nNF = 10;
$ide->dhEmi = new \DateTime();
$ide->dhSaiEnt = new \DateTime();//Não informar este campo para a NFC-e.
$ide->tpNF = 1;
$ide->idDest = 1;
$ide->cMunFG = 2304400;
$ide->tpImp = 1;
$ide->tpAmb = 2;
$ide->finNFe = 1;
$ide->indFinal = 0;
$ide->indPres = 9;
$ide->procEmi = 0;
$ide->verProc = '5.0.0';
$ide->cDV = 0;//não é importante será recalculado de qualquer forma
//se estiver em contingência setar os parametros
$contingency = new Contingency();
$ide->contingency = $contingency;
$ideClass = Tag::ide($ide);
```
Essa classe pode gerar uma string JSON, para finalidade de armazenamento.

Para adicionar essa classe a NFe::class poemos proceder das seguintes formas:


```php

use NFePHP\NFe\NFe;

//instanciar a classe NFe indicando a vero do layout a ser usado
//caso nada seja passado como parâmetro será usada a versão default
$nfe = new NFe('4.0');

$nfe->add($ideClass);
```

Ou alternativamente, essa classe pode ser carregada diretamente em sua respectiva propriedade publica:

```php

use NFePHP\NFe\NFe;

//instanciar a classe NFe indicando a verção do layout a ser usado
//caso nada seja passado como parâmetro será usada a versão default
$nfe = new NFe('4.0');

$nfe->ide = $ideClass;
```


