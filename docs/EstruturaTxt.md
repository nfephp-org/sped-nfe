# Estrutura do TXT da NFe

Para montar esse txt algumas regras básicas devem ser obedecidas:

1. Todas as linhas devem terminar com "|" (pipe) e em seguida um "LF"  (Line Feed ou "\n").
2. Nos campos separados por "|" (pipe) não podem apenas ter espaços em branco, ou existe dado ou fica sem nada.
3. Não são permitidos quaisquer caracteres especiais, exceto o "LF" ("\n") ao linal da linha.
4. Recomenda-se **não usar acentuação**, por exemplo "Ç" substitua por "C"
5. Não são permitidas aspas (simples ou duplas)
6. Caso alguma variável não exista, ou não seja necessária, seu campo deve ser deixado "VAZIO". ex. A|versao|Id||, nesse caso não temos o último valor "pk_nItem"
7. Não devem ser inclusos campos que não serão usadas. ex. BA02|refNFe| se não existir uma referencia a NFe, ignore o campo, ele não existe, mas **não faça "BA02||"**

## Regras de preenchimento dos campos da Nota Fiscal Eletrônica
*(texto extraído diretamente do Manual da SEFAZ)*

- Campos que representam códigos (CNPJ, CPF, CEP, CST, NCM, EAN, etc.) devem ser informados com o tamanho fixo previsto, sem formatação e com o preenchimento dos zeros não significativos;
- Campos numéricos que representam valores e quantidades são de tamanho variável, respeitando o tamanho máximo previsto para o campo e a quantidade de casas decimais. O preenchimento de zeros não significativos causa erro de validação do Schema XML. Os campos numéricos devem ser informados sem o separador de milhar, com uso do ponto decimal para indicar a parte fracionária se existente respeitando-se a quantidade de dígitos prevista no leiaute;
- O uso de **caracteres acentuados e símbolos especiais** para o preenchimento dos campos alfanuméricos devem ser evitados.
- Os espaços informados no início e no final do campo alfanumérico também devem ser evitados;
- As datas devem ser informadas no formato “AAAA-MM-DD”;
- A forma e a obrigatoriedade de preenchimento dos campos da Nota Fiscal Eletrônica estão previstas na legislação aplicável para a operação que se pretende realizar;
- Inexistindo conteúdo (valor zero ou vazio) para um campo não obrigatório, a TAG deste campo não deverá ser informada no arquivo da NF-e;
- Tratando-se de operações com o exterior, uma vez que o campo CNPJ é obrigatório não informar o conteúdo deste campo;
- No caso das pessoas desobrigadas de inscrição no CNPJ/MF, deverá ser informado o CPF da pessoa, exceto nas operações com o exterior.

## Como testar o TXT ? [Vide ValidTXT](ValidTXT.md)

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

## [Estrutura, **layout 4.00 SEBRAE**](txtlayout400_sebrae.md) *Em desenvolvimento*

# Mudanças do layout 3.10 para 4.00 (Nota Técnica 2016.002)

## LINHA B *(removido o elemento indPag)*
v3.10

B|cUF|cNF|natOp|~~indPag~~|mod|serie|nNF|dhEmi|dhSaiEnt|tpNF|idDest|cMunFG|tpImp|tpEmis|cDV|tp Amb|finNFe|indFinal|indPres|procEmi|verProc|dhCont|xJust|

v4.00

B|cUF|cNF|natOp|mod|serie|nNF|dhEmi|dhSaiEnt|tpNF|idDest|cMunFG|tpImp|tpEmis|cDV|tpAmb|finNFe|indFinal|indPres|procEmi|verProc|dhCont|xJust|

## LINHA I *(incluido o elemento cBenef)*

I|cProd|cEAN|xProd|NCM|**cBenef**|EXTIPI|CFOP|uCom|qCom|vUnCom|vProd|cEANTrib|uTrib|qTrib|vUnTrib|vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI|

## LINHA I05C *(incluido os elementos indEscala e CNPJFab)*

I05C|CEST|**indEscala**|**CNPJFab**|

## LINHA I80 *(criada a linha I80)*

**I80|nLote|qLote|dFab|dVal|cAgreg|**


## LINHA K *(removidos os elementos nLote,qLote,dFab,dVal e incluso cProdANVISA)*

v3.10
K|~~nLote~~|~~qLote~~|~~dFab~~|~~dVal~~|vPMC|

v4.00

K|**cProdANVISA**|vPMC|

## LINHA LA *(removido o elemento pMixGN, inclusos descANP,pGLP,pGNn,pGNi,vPart)*
v3.10

LA|cProdANP|~~pMixGN~~|CODIF|qTemp|UFCons|

v4.00

LA|cProdANP|**descANP**|**pGLP**|**pGNn**|**pGNi**|**vPart**|CODIF|qTemp|UFCons|

## LINHA N02 *(inclusos os elementos pFCP e vFCP)*

N02|orig|CST|modBC|vBC|pICMS|vICMS|**pFCP**|**vFCP**|


## LINHA N03 *(inclusos os elementos vBCFCP,pFCP,vFCP,vBCFCPST,pFCPST,vFCPST)*

N03|orig|CST|modBC|vBC|pICMS|vICMS|**vBCFCP**|**pFCP**|**vFCP**|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|**vBCFCPST**|**pFCPST**|**vFCPST**|

## LINHA N04 *(inclusos vBCFCP,pFCP,vFCP)*

N04|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|**BCFCP**|**pFCP**|**vFCP**|vICMSDeson|motDesICMS|


## LINHA N05 *(inclusos os elementos vBCFCPST,pFCPST,vFCPST)*

N05|orig|CST|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|**vBCFCPST**|**pFCPST**|**vFCPST**|vICMSDeson|motDesICMS|

## LINHA N07 *(inclusos vBCFCP,pFCP,vFCP)*  

N07|orig|CST|modBC|pRedBC|vBC|pICMS|vICMSOp|pDif|vICMSDif|vICMS|**vBCFCP**|**pFCP**|**vFCP**|


## LINHA N08 *(inclusos os elementos pST,vBCFCPSTRet,pFCPSTRet,vFCPSTRet)*

N08|orig|CST|vBCSTRet|**pST**|vICMSSTRet|**vBCFCPSTRet**|**pFCPSTRet**|**vFCPSTRet**|


## LINHA N09 *(inclusos os elementos vBCFCP,pFCP,vFCP,vBCFCPST,pFCPST,vFCPST)*

N09|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|**vBCFCP**|**pFCP**|**vFCP**|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|**vBCFCPST**|**pFCPST**|**vFCPST**|vICMSDeson|motDesICMS|

## LINHA N10 *(inclusos os elementos vBCFCP,pFCP,vFCP,vBCFCPST,pFCPST,vFCPST)*

N10|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|**vBCFCP**|**pFCP**|**vFCP**|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|**vBCFCPST**|**pFCPST**|**vFCPST**|vICMSDeson|motDesICMS|

## LINHA N10e *(inclusos os elementos vBCFCPST,pFCPST,vFCPST)*

N10e|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|**vBCFCPST**|**pFCPST**|**vFCPST**|pCredSN|vCredICMSSN|pCredSN|vCredICMSSN|

## LINHA N10f *(inclusos os elementos vBCFCPST,pFCPST,vFCPST)*

N10f|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|**vBCFCPST**|**pFCPST**|**vFCPST**|

## LINHA N10g *(inclusos os elementos vBCFCPSTRet,pFCPSTRet,vFCPSTRet)*

N10g|orig|CSOSN|vBCSTRet|pST|vICMSSTRet|**vBCFCPSTRet**|**pFCPSTRet**|**vFCPSTRet**|

## LINHA N10h *(inclusos os elementos vBCFCPST,pFCPST,vFCPST)*

N10h|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|**vBCFCPST**|**pFCPST**|**vFCPST**|pCredSN|vCredICMSSN|

## LINHA NA *(incluso o elemento vBCFCPUFDest)*

NA|vBCUFDest|**vBCFCPUFDest**|pFCPUFDest|pICMSUFDest|pICMSInter|pICMSInterPart|vFCPUFDest|vICMSUFDest|vICMSFRemet|

## LINHA W02 *(inclusos os elementos vFCP,vFCPST,vFCPSTRet)*

W02|vBC|vICMS|vICMSDeson|**vFCP**|vBCST|vST|**vFCPST**|**vFCPSTRet**|vProd|vFrete|vSeg|vDesc|vII|vIPI|vIPIDevol|vPIS|vCOFINS|vOutro|vNF|vTotTrib|

## LINHA O *(removido o campo clEnq)*

O|~~clEnq~~|CNPJProd|cSelo|qSelo|cEnq|

## LINHA Y *(adicionado o elemento vTroco)*

Y|**vTroco**|

## LINHA YA *(adicionado o elemento indPag)*

YA|**indPag**|tPag|vPag|CNPJ|tBand|cAut|tpIntegra|

## LINHA ZX01 *(adicionado o elemento urlChave)*

ZX01|qrcode|**urlChave**|
