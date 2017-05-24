# CONSTRUÇÃO DO XML

Para construir o XML da NFe (ou da NFCe) deve ser usada a classe Make::class

## Métodos

Os métodos públicos desta classe são praticamente os mesmos da versão anterior da API, com algumas poucas diferenças.


### function taginfNFe():DOMElement (OPCIONAL)
Informações iniciais da NF-e 

> NOTA: Se esta tag não for criada pelo aplicativo, ela será criada em tempo de execução, e se for criada com uma chave incorreta a mesma será remontada e inserida antes da montagem do XML.

tag **NFe/infNFe**

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $chave | string | Chave de 44 digitos (OPCIONAL) |

### function tagide():DOMElement (OBRIGATÓRIO)
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
| $dhSaiEnt | Data e hora de Saída ou da Entrada da Mercadoria/Produto (OBRIGATÓRIO, mas caso não existe passe uma string vazia, caso das notas modelo 65)|
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

### function tagrefNFe():DOMElement (OPCIONAL)

### function tagrefNF():DOMElement (OPCIONAL)

### function tagrefNFP():DOMElement (OPCIONAL)

### function tagrefCTe():DOMElement (OPCIONAL)

### function tagrefECF():DOMElement (OPCIONAL)

### function tagemit():DOMElement (OBRIGATÓRIO)

### function tagenderEmit():DOMElement (OBRIGATÓRIO)

### function tagdest():DOMElement (OBRIGATÓRIO)

### function tagenderDest():DOMElement (OBRIGATÓRIO)

### function tagretirada():DOMElement (OPCIONAL)

### function tagentrega():DOMElement (OPCIONAL)

### function tagautXML():DOMElement (OPCIONAL)

### function tagprod():DOMElement (OBRIGATÓRIO)

### function tagNVE():DOMElement (OPCIONAL)

### function tagCEST():DOMElement (OPCIONAL)

Código Especificador da Substituição Tributária – CEST, que identifica a mercadoria sujeita aos regimes de substituição tributária e de antecipação do recolhimento do imposto.

tag **NFe/infNFe/det[item]/prod/CEST**

*Vide [NT2015.003](https://www.nfe.fazenda.gov.br/portal/exibirArquivo.aspx?conteudo=phxUuPH/Dxk=) e [CONVÊNIO ICMS 52, DE 7 DE ABRIL DE 2017](https://www.confaz.fazenda.gov.br/legislacao/convenios/2017/cv052_17)*

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $nItem   | int | Numero do item da nota fiscal (OBRIGATÓRIO)|
| $codigo  | string | Codigo do CEST ex. 01.099.00 (OBRIGATÓRIO)|

### function tagRECOPI():DOMElement (OPCIONAL)

A informação do número do RECOPI será obrigatória na operação com papel imune (NCM conforme Anexo II.01 - NCM Tipos de Papel (Vinculado ao RECOPI, #128 NCM) da NT2013/005) e a NF-e poderá ser autorizada em até 5 dias após a data contida no identificador gerado no RECOPI.

tag **NFe/infNFe/det[item]/prod/nRECOPI**

Vide: Anexo XII.02 - Identificador RECOPI

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $nItem   | int | Numero do item da nota fiscal (OBRIGATÓRIO)|
| $codigo  | string | Número do RECOPI (OBRIGATÓRIO)|

### function taginfAdProd():DOMElement (OPCIONAL)

Informações adicionais do produto

Este campo de destina ao lançamento de informações adicionais de interesse do emitente ou do destinatário referentes ao item do produto, como normas, e outros dados complementares no limite de 500 digitos.

> NOTA: a string será truncada acima de 500 digitos e será limpa que qualquer caracter especial ou acento.

tag **NFe/infNFe/det[item]/infAdProd**

| Paramêtros | Tipo   | Descrição |
| :----    | :----: | :----     | 
| $nItem   | int | Numero do item da nota fiscal (OBRIGATÓRIO)|
| $texto  | string | Texto adicional ao item da NFe (OBRIGATÓRIO)|

### function tagDI():DOMElement  (OPCIONAL)

### function tagadi():DOMElement (OPCIONAL)

### function tagdetExport():DOMElement (OPCIONAL)

### function tagveicProd():DOMElement (OPCIONAL)

### function tagmed():DOMElement (OPCIONAL)

### function tagarma():DOMElement (OPCIONAL)

### function tagcomb():DOMElement (OPCIONAL)

### function tagencerrante():DOMElement (OPCIONAL)

### function tagimposto():DOMElement (OPCIONAL)

### function tagICMS():DOMElement (OPCIONAL)

### function tagICMSPart():DOMElement (OPCIONAL)

### function tagICMSST():DOMElement (OPCIONAL)

### function tagICMSSN():DOMElement (OPCIONAL)

### function tagICMSUFDest():DOMElement (OPCIONAL)

### function tagIPI():DOMElement (OPCIONAL)

### function tagII():DOMElement (OPCIONAL)

### function tagPIS():DOMElement (OPCIONAL)

### function tagPISST():DOMElement (OPCIONAL)

### function tagCOFINS():DOMElement (OPCIONAL)

### function tagCOFINSST():DOMElement (OPCIONAL)

### function tagISSQN():DOMElement  (OPCIONAL)

### function tagimpostoDevol():DOMElement  (OPCIONAL)

### function tagICMSTot():DOMElement

### function tagISSQNTot():DOMElement (OPCIONAL)

### function tagretTrib():DOMElement (OPCIONAL)

### function tagtransp():DOMElement (OPCIONAL)

### function tagtransporta():DOMElement (OPCIONAL)

### function tagveicTransp():DOMElement (OPCIONAL)

### function tagreboque():DOMElement (OPCIONAL)

### function tagretTransp():DOMElement (OPCIONAL)

### function tagvol():DOMElement (OPCIONAL)

### function tagfat():DOMElement (OPCIONAL)

### function tagdup():DOMElement (OPCIONAL)

### function tagpag():DOMElement (OPCIONAL)

### function tagcard():DOMElement (OPCIONAL)

### function taginfAdic():DOMElement (OPCIONAL)

### function tagobsCont():DOMElement (OPCIONAL)

### function tagobsFisco():DOMElement (OPCIONAL)

### function tagprocRef():DOMElement (OPCIONAL)

### function tagexporta():DOMElement (OPCIONAL)

### function tagcompra():DOMElement (OPCIONAL)

### function tagcana():DOMElement (OPCIONAL)

### function tagforDia():DOMElement (OPCIONAL)

### function tagdeduc():DOMElement (OPCIONAL)

### function getXMl():string
Este método retorna a string com o XML já criado

### function getChave():string
Este método retorna a chave CORRETA montada a partir dos dados fornecidos

### function getModelo():int
Este método retorna o modelo usado na construção da NFe (55 ou 65)

### function montaNFe():boolean

Este método faz a montagem do XML, não é necessário usa-lo pois quando for solicitado o XML pelo método getXML() essa monstagem será realizada, caso ainda não tenha sido.

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


