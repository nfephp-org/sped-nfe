# CONSTRUÇÃO DO XML

Para construir o XML da NFe (ou da NFCe) deve ser usada a classe Make::class

## Métodos

Os métodos públicos desta classe são praticamente os mesmos da versão anterior da API, com algumas poucas diferenças.

### Considerações na passagem de parâmetros

**Em campos string, caso não haja informações a passar, passe uma string vazia ou null**

**Em campos float, caso não haja informações a passar, passe null e não ZERO**

### function taginfNFe($parametros):DOMElement (OPCIONAL)
Informações iniciais da NF-e 

> NOTA: Se esta tag não for criada pelo aplicativo, ela será criada em tempo de execução, e se for criada com uma chave incorreta a mesma será remontada e inserida antes da montagem do XML.

tag **NFe/infNFe**

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $chave | string | Chave de 44 digitos (OPCIONAL) |

### function tagide($parametros):DOMElement (OBRIGATÓRIO)
Informações de identificação da NF-e

tag **NFe/infNFe/ide**

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $cUF | int | Código da UF do emitente do Documento Fiscal (OBRIGATÓRIO) |
| $cNF | int | Código Numérico que compõe a Chave de Acesso (OBRIGATÓRIO) |
| $natOp | string | Descrição da Natureza da Operação (OBRIGATÓRIO) |
| $indPag | int | Indicador da forma de pagamento (OBRIGATÓRIO) |
| $mod | int | Código do Modelo do Documento Fiscal (OBRIGATÓRIO) |
| $serie | int | Série do Documento Fiscal (OBRIGATÓRIO)|
| $nNF | int | Número do Documento Fiscal  (OBRIGATÓRIO) |
| $dhEmi | string | Data e hora de emissão do Documento Fiscal (OBRIGATÓRIO)|
| $dhSaiEnt | string |Data e hora de Saída ou da Entrada da Mercadoria/Produto (OBRIGATÓRIO, mas caso não existe passe uma string vazia, caso das notas modelo 65) |
| $tpNF | int | Tipo de Operação (OBRIGATÓRIO)|
| $idDest | int | Identificador de local de destino da operação (OBRIGATÓRIO)|
| $cMunFG | string | Código do Município de Ocorrência do Fato Gerador (OBRIGATÓRIO)|
| $tpImp | int | Formato de Impressão do DANFE (OBRIGATÓRIO)|
| $tpEmis | int | Tipo de Emissão da NF-e (OBRIGATÓRIO)|
| $cDV | int | Dígito Verificador da Chave de Acesso da NF-e (OBRIGATÓRIO, se for colocado um digito incorreto o mesmo será corrigdo em tempo de execução)|
| $tpAmb | int | Identificação do Ambiente (OBRIGATÓRIO)|
| $finNFe | int | Finalidade de emissão da NF-e (OBRIGATÓRIO)|
| $indFinal | int | Indica operação com Consumidor final (OBRIGATÓRIO)|
| $indPres | int | Indicador de presença do comprador no estabelecimento comercial no momento da operação (OBRIGATÓRIO)|
| $procEmi | int | Processo de emissão da NF-e (OPCIONAL) 0 Emissão de NF-e com aplicativo do contribuinte;|
| $verProc | string | Versão do Processo de emissão da NF-e (OBRIGATÓRIO)|
| $dhCont | string | Data e Hora da entrada em contingência (OPCIONAL) Ao usar a Competency::class na classe Tools essa tag será ajusta de forma automática |
| $xJust | string | Justificativa da entrada em contingência (OPCIONAL) Ao usar a Competency::class na classe Tools essa tag será ajusta de forma automática |

### function tagrefNFe($parametros):DOMElement (OPCIONAL)
Chave de acesso da NF-e referenciada

tag **NFe/infNFe/ide/NFref[]/refNFe**

Cada chamada desse metodo irá criar um novo item em um array interno, usado posteriormente na montagem da NFe.

> NOTA: Inclua em sequência todas as NFe referenciadas, antes de referenciar outros documentos.
 
| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $chave   | string | Chave da NFe referenciada (OBRIGATÓRIO)|

### function tagrefNF($parametros):DOMElement (OPCIONAL)
Informação da NF modelo 1/1A referenciada 

tag **NFe/infNFe/ide/NFref[]/NF**

Cada chamada desse metodo irá criar um novo item em um array interno, usado posteriormente na montagem da NFe.

> NOTA: Inclua em sequência todas as NF (1/1A) referenciadas, antes de referenciar outros documentos.

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $cUF | int | Código da UF do emitente na NF (OBRIGATÓRIO)|
| $aamm | int | Ano e Mês de emissão da NF-e (OBRIGATÓRIO)|
| $cnpj | string | CNPJ do emitente (OBRIGATÓRIO)|
| $serie | int | Série do Documento Fiscal (ZERO se série unica) (OBRIGATÓRIO)|
| $nNF | int | Número do Documento Fiscal (OBRIGATÓRIO)|


### function tagrefNFP($parametros):DOMElement (OPCIONAL)
Informações da NF de produtor rural referenciada

tag **NFe/infNFe/ide/NFref[]/refNFP**

Cada chamada desse metodo irá criar um novo item em um array interno, usado posteriormente na montagem da NFe.

> NOTA: Inclua em sequência todas as NFP referenciadas, antes de referenciar outros documentos.

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $cUF | int | Código da UF do emitente na NF (OBRIGATÓRIO)|
| $aamm | int | Ano e Mês de emissão da NF-e (OBRIGATÓRIO)|
| $cnpj | string | CNPJ do emitente (OPCIONAL) string vazia se não houver|
| $cpf | string | CPF do emitente (OPCIONAL) string vazia se não houver|
| $ie | string | Inscrição Estadual do emitente (OBRIGATÓRIO)|
| $mod | int | Modelo do Documento Fiscal (2 ou 4) (OBRIGATÓRIO)|
| $serie | int | Série do Documento Fiscal (ZERO se sem série) (OBRIGATÓRIO)|
| $nNF | int | Número do Documento Fiscal (OBRIGATÓRIO)|

### function tagrefCTe($parametros):DOMElement (OPCIONAL)
Chave de acesso da CT-e referenciada

tag **NFe/infNFe/ide/NFref[]/refCTe**

Cada chamada desse metodo irá criar um novo item em um array interno, usado posteriormente na montagem da NFe.

> NOTA: Inclua em sequência todas as CTe referenciadas, antes de referenciar outros documentos.
 
| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $chave   | string | Chave da CTe referenciada (OBRIGATÓRIO)|

### function tagrefECF($parametros):DOMElement (OPCIONAL)
Informações do Cupom Fiscal referenciado

tag **NFe/infNFe/ide/NFref[]/refECF**

Cada chamada desse metodo irá criar um novo item em um array interno, usado posteriormente na montagem da NFe.

> NOTA: Inclua em sequência todas as ECF referenciadas, antes de referenciar outros documentos.

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $mod | string | Modelo do Documento Fiscal (OBRIGATÓRIO) |
| $nECF | int | Número de ordem sequencial do ECF (OBRIGATÓRIO) |
| $nCOO | int | Número do Contador de Ordem de Operação - COO (OBRIGATÓRIO) |

### function tagemit($parametros):DOMElement (OBRIGATÓRIO)
Identificação do emitente da NF-e

tag **NFe/infNFe/emit**

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $cnpj | string | CNPJ do emitente (OPCIONAL) passe uma string vazia se não houver|
| $cpf | string | CPF do emitente (OPCIONAL) passe uma string vazia se não houver|
| $xNome | string | Razão Social ou Nome do emitente  (OBRIGATÓRIO)|
| $xFant | string | Nome fantasia (OPCIONAL) passe uma string vazia se não houver|
| $ie | string | Inscrição Estadual do Emitente (OBRIGATÓRIO)|
| $iest | string | IE do Substituto Tributário (OPCIONAL)|
| $im | string | Inscrição Municipal do Prestador de Serviço (OPCIONAL) |
| $cnae | string | CNAE fiscal (OPCIONAL) passe uma string vazia se não houver|
| $crt | int | Código de Regime Tributário (OBRIGATÓRIO)|

### function tagenderEmit($parametros):DOMElement (OBRIGATÓRIO)

### function tagdest($parametros):DOMElement (OBRIGATÓRIO)

### function tagenderDest($parametros):DOMElement (OBRIGATÓRIO)

### function tagretirada($parametros):DOMElement (OPCIONAL)

### function tagentrega($parametros):DOMElement (OPCIONAL)

### function tagautXML($parametros):DOMElement (OPCIONAL)

### function tagprod($parametros):DOMElement (OBRIGATÓRIO)

### function tagNVE($parametros):DOMElement (OPCIONAL)

### function tagCEST($parametros):DOMElement (OPCIONAL)

Código Especificador da Substituição Tributária – CEST, que identifica a mercadoria sujeita aos regimes de substituição tributária e de antecipação do recolhimento do imposto.

tag **NFe/infNFe/det[item]/prod/CEST**

*Vide [NT2015.003](https://www.nfe.fazenda.gov.br/portal/exibirArquivo.aspx?conteudo=phxUuPH/Dxk=) e [CONVÊNIO ICMS 52, DE 7 DE ABRIL DE 2017](https://www.confaz.fazenda.gov.br/legislacao/convenios/2017/cv052_17)*

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $nItem   | int | Numero do item da nota fiscal (OBRIGATÓRIO)|
| $codigo  | string | Codigo do CEST ex. 01.099.00 (OBRIGATÓRIO)|

### function tagRECOPI($parametros):DOMElement (OPCIONAL)

A informação do número do RECOPI será obrigatória na operação com papel imune (NCM conforme Anexo II.01 - NCM Tipos de Papel (Vinculado ao RECOPI, #128 NCM) da NT2013/005) e a NF-e poderá ser autorizada em até 5 dias após a data contida no identificador gerado no RECOPI.

tag **NFe/infNFe/det[item]/prod/nRECOPI**

Vide: Anexo XII.02 - Identificador RECOPI

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $nItem   | int | Numero do item da nota fiscal (OBRIGATÓRIO)|
| $codigo  | string | Número do RECOPI (OBRIGATÓRIO)|

### function taginfAdProd($parametros):DOMElement (OPCIONAL)

Informações adicionais do produto

Este campo de destina ao lançamento de informações adicionais de interesse do emitente ou do destinatário referentes ao item do produto, como normas, e outros dados complementares no limite de 500 digitos.

> NOTA: a string será truncada acima de 500 digitos e será limpa que qualquer caracter especial ou acento.

tag **NFe/infNFe/det[item]/infAdProd**

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $nItem   | int | Numero do item da nota fiscal (OBRIGATÓRIO)|
| $texto  | string | Texto adicional ao item da NFe (OBRIGATÓRIO)|

### function tagDI($parametros):DOMElement  (OPCIONAL)

### function tagadi($parametros):DOMElement (OPCIONAL)

### function tagdetExport($parametros):DOMElement (OPCIONAL)

### function tagveicProd($parametros):DOMElement (OPCIONAL)

### function tagmed($parametros):DOMElement (OPCIONAL)

### function tagarma($parametros):DOMElement (OPCIONAL)

### function tagcomb($parametros):DOMElement (OPCIONAL)

### function tagencerrante($parametros):DOMElement (OPCIONAL)

### function tagimposto($parametros):DOMElement (OPCIONAL)

### function tagICMS($parametros):DOMElement (OPCIONAL)

### function tagICMSPart($parametros):DOMElement (OPCIONAL)

### function tagICMSST($parametros):DOMElement (OPCIONAL)

### function tagICMSSN($parametros):DOMElement (OPCIONAL)

### function tagICMSUFDest($parametros):DOMElement (OPCIONAL)

### function tagIPI($parametros):DOMElement (OPCIONAL)

### function tagII($parametros):DOMElement (OPCIONAL)

### function tagPIS($parametros):DOMElement (OPCIONAL)

### function tagPISST($parametros):DOMElement (OPCIONAL)

### function tagCOFINS($parametros):DOMElement (OPCIONAL)

### function tagCOFINSST($parametros):DOMElement (OPCIONAL)

### function tagISSQN($parametros):DOMElement  (OPCIONAL)

### function tagimpostoDevol($parametros):DOMElement  (OPCIONAL)

### function tagICMSTot($parametros):DOMElement

### function tagISSQNTot($parametros):DOMElement (OPCIONAL)

### function tagretTrib($parametros):DOMElement (OPCIONAL)

### function tagtransp($parametros):DOMElement (OPCIONAL)

### function tagtransporta($parametros):DOMElement (OPCIONAL)

### function tagveicTransp($parametros):DOMElement (OPCIONAL)

### function tagreboque($parametros):DOMElement (OPCIONAL)

### function tagretTransp($parametros):DOMElement (OPCIONAL)

### function tagvol($parametros):DOMElement (OPCIONAL)

### function tagfat($parametros):DOMElement (OPCIONAL)

### function tagdup($parametros):DOMElement (OPCIONAL)

### function tagpag($parametros):DOMElement (OPCIONAL)

### function tagcard($parametros):DOMElement (OPCIONAL)

### function taginfAdic($parametros):DOMElement (OPCIONAL)

### function tagobsCont($parametros):DOMElement (OPCIONAL)

### function tagobsFisco($parametros):DOMElement (OPCIONAL)

### function tagprocRef($parametros):DOMElement (OPCIONAL)

### function tagexporta($parametros):DOMElement (OPCIONAL)

### function tagcompra($parametros):DOMElement (OPCIONAL)

### function tagcana($parametros):DOMElement (OPCIONAL)

### function tagforDia($parametros):DOMElement (OPCIONAL)

### function tagdeduc($parametros):DOMElement (OPCIONAL)

### function getXMl():string
Este método retorna a string com o XML já criado

### function getChave():string
Este método retorna a chave CORRETA montada a partir dos dados fornecidos

### function getModelo():int
Este método retorna o modelo usado na construção da NFe (55 ou 65)

### function montaNFe():boolean

Este método faz a montagem do XML, não é necessário usa-lo pois quando for solicitado o XML pelo método getXML() essa montagem será realizada, caso ainda não tenha sido.

## Exemplo de uso

```php
use NFePHP\NFe\Make;

$nfe = Make::v310();

$nfe->tagide();

$xml = $nfe->getXML();
if (empty($xml)) {
    //existem falhas
    print_r($nfe->erros);
    die;
}

//se não houveram erros a nota pode ser processada
//outros erros podem ser identificados na fase de assinatura da 
//nota com a classe Tool::class pois será validada com relação ao
//seu respsctivo XSD

```


