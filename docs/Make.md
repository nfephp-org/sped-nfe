# CONSTRUÇÃO DO XML

Para construir o XML da NFe (ou da NFCe) deve ser usada a classe Make::class

## NOTA: Esta classe agora recebe os parâmetros dos métodos em forma de stdClass e não mais com variáveis individuais. É importante salientar que os campos do stdClass devem ser nomeados com a EXATA nomenclatura contida no manual ou conforme a nomenclatura das estruturas do TXT, observando as letras maiuscula se minusculas. 

## Métodos

### function __construct()
Método construtor

```php
$nfe = new Make();
```

### function getXMl():string
Este método retorna o XML em uma string

```php
$xml = $nfe->getXML();
```

### function getChave():string
Este método retorna o numero da chave da NFe

```php
$chave = $nfe->geChave();
```

### function getModelo():int
Este método retorna o modelo de NFe 55 ou 65

```php
$modelo = $nfe->getModelo();
```

### function montaNFe():boolean
Este método chama o metodo monta(), mantido apenas para compatibilidade.

```php
$result = $nfe->montaNFe();
```

### function monta()
Este método executa a montagem do XML

```php
$result = $nfe->montaNFe();
```

### function taginfNFe($std):DOMElement
Node principal
 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$std->versao = '3.10'; //versão do layout
$std->Id = 'NFe35150271780456000160550010000000021800700082';//se o Id de 44 digitos não for passado será gerado automaticamente
$std->pk_nItem = null; //deixe essa variavel sempre como NULL

$elem = $nfe->taginfNFe($std);
 
```

### function tagide($std):DOMElement
Node de identificação da NFe

| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$std->cUF = 35;
$std->cNF = '80070008';
$std->natOp = 'VENDA';

$std->indPag = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00 

$std->mod = 55;
$std->serie = 1;
$std->nNF = 2;
$std->dhEmi = '2015-02-19T13:48:00-02:00';
$std->dhSaiEnt = null;
$std->tpNF = 1,
$std->idDest = 1;
$std->cMunFG = 3518800;
$std->tpImp = 1;
$std->tpEmis = 1;
$std->cDV = 2;
$std->tpAmb = 2;
$std->finNFe = 1;
$std->indFinal = 0; 
$std->indPres = 0;
$std->procEmi = '3.10.31';
$std->verProc = null;
$std->dhCont = null;
$std->xJust = null;

$elem = $nfe->tagide($std);
```

### function tagrefNFe($std):DOMElement
Node referente a NFe referenciada

| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$std->refNFe = '35150271780456000160550010000253101000253101';

$elem = $nfe->tagrefNFe($std);
```

### function tagrefNF($std):DOMElement
Node referente a Nota Fiscal referenciada modelo 1 ou 2

| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$std->cUF = 35;
$std->AAMM = 1412;
$std->CNPJ = '52297850000105';
$std->mod = '01';
$std->serie = 3;
$std->nNF = 587878;

$elem = $nfe->tagrefNF($std);
```

### function tagrefNFP($std):DOMElement
Node referente a Nota Fiscal referenciada de produtor rural

| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$std->cUF = 35;
$std->AAMM = 1502;
$std->IE = 'ISENTO';
$std->mod = '04';
$std->serie = 0;
$std->nNF = 5578;

$elem = $nfe->tagrefNFP($std);
```
### function tagrefCTe($std):DOMElement
Node referente aos CTe referenciados

| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |
```php
$std = new StdClass();
$std->refCTe = '35150268252816000146570010000016161002008472';

$elem = $nfe->tagrefCTe($std);
```

### function tagrefECF($std):DOMElement
Node referente aos ECF referenciados

| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |
```php
$std = new StdClass();
$std->mod = '2C';
$std->nECF = 788;
$std->nCOO = 114;

$elem = $nfe->tagrefECF($std);
```

### function tagemit($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$elem = $nfe->tagemit($std);
```

### function tagenderEmit($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$elem = $nfe->tagenderEmit($std);
```

### function tagdest($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$elem = $nfe->tagdest($std);
```

### function tagenderDest($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$elem = $nfe->tagenderDest($std);
```

### function tagretirada($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$elem = $nfe->tagretirada($std);
```


### function tagentrega($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new StdClass();
$elem = $nfe->tagentrega($std);
```

### function tagautXML($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |
```php
$std = new StdClass();
$elem = $nfe->tagautXML($std);
```

### function tagprod($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |
```php
$std = new StdClass();
$elem = $nfe->tagprod($std);
```

### function taginfAdProd($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |
```php
$std = new StdClass();
$elem = $nfe->taginfAdProd($std);
```

### function tagNVE($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagCEST($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagRECOPI($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagDI($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagadi($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagdetExport($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagRastro($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagveicProd($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagmed($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagarma($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagcomb($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagencerrante($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagimposto($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagICMS($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagICMSPart($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagICMSST($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagICMSSN($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagICMSUFDest($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagIPI($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagII($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagPIS($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagPISST($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagCOFINS($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagCOFINSST($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagISSQN($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagimpostoDevol($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagICMSTot($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagISSQNTot($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagretTrib($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagtransp($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagtransporta($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagretTransp($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagveicTransp($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagreboque($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagvol($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function taglacres($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagpag($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagdetPag($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagfat($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagdup($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function taginfAdic($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagobsCont($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagobsFisco($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagprocRef($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagexporta($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagcompra($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagcana($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagforDia($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function tagdeduc($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

### function taginfNFeSupl($std):DOMElement


| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

