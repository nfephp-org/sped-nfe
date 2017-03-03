#Make

NOTAS PARA USO DA CLASSE MAKE:

1 - Os parametros para cada método (TAG's) são passados na forma de 
stdClass e não de simples variáveis.

2 - As stdClass devem possuir propriedades com os mesmos nomes dos campos a elas destinados no xml (vide manual da SEFAZ), e não há distinção entre maiusculas ou minusculas, mas apenas o nome deve estar correto.

3 - Campos não obrigatórios não necessitam ser passados para a stdClass, eles serão desconsiderados. Já os campos obrigatórios serão usados mesmo que vazios.

4 - Todas as variáveis de "data" devem receber uma classe \DateTime e não uma string

5 - No caso especifico da TAG &lt;ide&gt;, designada pelo método tagide() os dados relativos a contingência (tpEmis, dhCont e xJust) estarão contidos na classe Contingency::class

6 - Os campos numericos devem ser passados como numeros e os campos string como strings.

7 - Caso algum campo não seja passado o mesmo será considerado como VAZIO e será tratado como tal, se for obrigatório será inserido no xml mesmo assim, caso contrario será apenas desconsiderado.

8 - Use apenas os métodos (TAG's) que deseja inserir no xml, a classe não possui qualquer preocupação com validações.

9 - Não existe ordem obrigatória para a criação das TAG's, elas podem em princípio serem criadas em qualquer ordem. 


##Instanciando a classe
```php

use NFePHP\NFe\Make;
use NFePHP\NFe\Factories\Contingency;
use stdClass;

$nfe = new Make();
```


##Métodos

###TAG &lt;ide&gt;
```php
$ide = new stdClass();
$ide->cUF = 23;
$ide->cNF = 10;
$ide->natOp = 'Venda de Produto';
$ide->indPag = 1;
$ide->mod = 55;
$ide->serie = 1;
$ide->nNF = 10;
$ide->dhEmi = new \DateTime();
$ide->dhSaiEnt = new \DateTime();
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
$ide->cDV = 0;

$contingency = new Contingency();
$ide->contingency = $contingency;

$resp = $nfe->tagide($ide);
```
