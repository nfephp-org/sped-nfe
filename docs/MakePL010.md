# CONSTRUÇÃO DO XML com dados do schema PL_010v1

> **IMPORTANTE:** Alguns métodos foram alterados em alguns campos desses métodos para a criação do XML.
 
> A mesma classe é capaz de criar os XML com os schemas da versão PL_009, bem como com os schemas da versão PL_010.
> Isso com base nos dados de configuração informados na construção da classe ($schema). 
 
> Portanto, não há necessidade de se preocupar em usar a classe durante o período de testes e de transição para o novo formato. Querendo gerar no formato atual é só passar o PL_009 (atual) ou no caso de testes com a nova versão o PL_010.
> O PL_009 é default !

Para construir o XML da NFe (ou da NFCe) deve ser usada a classe Make::class

- Todos os dados de entrada dos métodos dessa classe (Make:class) são objetos e pode ser criados diretamente como objetos (stdClass) ou como matrizes simples e convertidas em objetos.
- Muitos campos não são obrigatórios. Caso não haja nenhum valor a ser informado para um determinado campo, estes devem ser informados como "null" ou nem serem informados, campos informados como strings "vazias" ou "Zero" serão considerados válidos e poderão causar erros se estiverem incorretos.
- Caso existam erros na passagem de parâmetros para a classe, **NÃO será disparada nenhuma Exception**, mas esses erros poderão ser recuperados pelo método getErrors().
- A nova classe "Make:class" foi redesenhada para permitir o uso dos métodos sem necessidade de observar qualquer sequência lógica. Ou seja, podem ser chamados os métodos de forma totalmente aleatória, sem prejuízo para a construção do XML.
- Porém, existem métodos OBRIGATÓRIOS que deverão ser implementados SEMPRE, caso contrario serão gerados erros e o XML não passará na validação com o schema.

> NOTA: como forma de diminuir o tamanho do código a classe foi dividida em traits para os principais blocos construtivos do XML, mas houve um aumento nas propriedades da Make:class, o que pode gerar um leve aumento no uso de memória para a construção do XML.

# Métodos

## Métodos Substituídos (não existem mais na MakeDev)

- tagCEST => incorporado pelo método [tagprod](#tag=prod)
- tagprodObsCont => substituida por [tagObsItem](#tag-ObsItem) 
- tagexportInd => vide no método [tagdetExport](#tag-detExport)
- tagCreditoPresumidoProd => substituido por [taggCred]($tag-gCred)


> Abaixo estão descritos TODOS os métodos da classe Make class com os seus respectívos parâmetros em ordem de entrada.
> ### Os valores dos parâmetros são apenas exemplos "CHUTADOS", e não correspondem a nenhum cálculo ou ponderação real.

[tag infNFe](#tag-infNFe) - Cria a tag infNFe, com as informações da NFe/NFCe $${\color{red}(OBRIGATÓRIA)}$$

[tag ide](#tag-ide) - Cria a tag ide, identificação da NFe/NFCe  $${\color{red}(OBRIGATÓRIA)}$$ $${\color{red}(RTC)}$$

[tag emit](#tag-emit) - Cria a tag emit, com os dados principais do emitente $${\color{red}(OBRIGATÓRIA)}$$

[tag enderEmit](#tag-enderEmit) - Cria a tag enderEmit, com o endereço do emitente $${\color{red}(OBRIGATÓRIA)}$$

**DOCUMENTOS REFERENCIADOS**

Choice entre refNFe ou refNFeSig ou refNF ou refNFP ou refCTe ou refECF

[tag refNFe](#tag-refNFe) - Cria a tag NFref/refNFe ou NFref/refNFeSig (opcional)

[tag refNF](#tag-refNF) - Cria a tag NFref/refNF (opcional)

[tag refNFP](#tag-refNFP) - Cria a tag NFref/refNFP (opcional)

[tag refCTe](#tag-refCTe) - Cria a tag NFref/refCTe (opcional)

[tag refECF](#tag-refECF) - Cria a tag NFref/refECF (opcional)



[tag gCompraGov](#tag-gCompraGov) - Cria a tag gCompraGov, grupo de compra Governamental $${\color{red}(RTC)}$$ (opcional)

[tag dest](#tag-dest) - Cria a tag dest, dados do destinatário (opcional)

[tag enderDest](#tag-dest) - Cria a tag enderDest, endereçõ do destinatário (opcional)
 
[tag retirada](#tag-retirada) - Cria a tag retirada, com os dados do local de retirada da mercadoria (opcional)

[tag entrega](#tag-entrega) - Cria a tag entrega, com os dados do local de entrega da mercadoria (opcional)

[tag autXML](#tag-autXML) - Cria as referencias de autorização de terceiros baixarem o documento fiscal (opcional)

**DADOS DOS ITENS DA NFe**

[tag prod](#tag-prod) - Cria a tag det/prod, com dados do produto/serviço $${\color{red}(OBRIGATÓRIA)}$$ $${\color{red}(RTC)}$$

[tag infAdProd](#tag-infadprod) - Cria a tag det/prod/infAdProd, com informações adicionais (opcional)

[tag ObsItem](#tag-ObsItem) - Cria as tags det/prod/obsItem/obsCont ou obsFisco, substitui  tagprodObsCont() (opcional)

[tag DFeReferenciado](#tag-DFeReferenciado) - Cria a tag det/prod/DFeReferenciado (opcional) $${\color{red}(RTC)}$$


[tag gCred](#tag-gCred) - Cria informações sobre o CréditoPresumido, podem ocorrer até 4 registros desse grupo por item da NFe (opcional)  

[tag NVE](#tag-NVE) - Cria as tgas de Nomenclatura de Valor aduaneiro e Estatístico, podem ocorrer até 8 registros desse grupo por item da NFe (opcional)

**GRUPO DE DADOS DE IMPORTAÇÃO DO ITEM**

[tag DI](#tag-DI) - Cria as tags de Declaração de Importação, podem ocorrer até 100 registros desse grupo por item da NFe (opcional)

[tag adi](#tag-adi) - Cria as Adições da DI, OBRIGATÓRIA se existir a DI, podem ocorrer até 999 registros para cada DI declarada por item da NFe (opcional)

[tag detExport](#tag-detExport) - Cria as tags de Detalhe da exportação, podem ocorrer até 500 registros por item (opcional)

[tag rastro](#tag-rastro) - Cria as tags de Rastreabilidade, podem ocorrer até 500 repetições por item da NFe (opcional)

[tag veicProd](#tag-veicProd) - Cria a tag de Veículos novos (opcional)

[tag med](#tag med) - Cria tag de Detalhamento de Medicamentos e de matérias-primas farmacêuticas (opcional)

[tag arma](#tag-arma) - Cria a tag de Detalhamento de Armamento (opcional)

**GRUPO DE ITEM DE VENDA COMBUSTIVEIS LIQUIDOS**

[tag comb](#tag-comb) - Cria a tag para operações com combustíveis líquidos (opcional)

[tag encerrante](#tag-encerrante) - Cria a tag de Informações do grupo de encerrante (Combustíveis) (opcional)

[tag origComb](#tag-origComb) - Cria as tags de origem do combustível, podem ocorrer até 30 registros por item da NFe (opcional) 

[tag RECOPI](#tag-RECOPI) - Cria a tag Reconhecimento e Controle de Papel Imune (opcional)

[tag imposto](#tag-imposto) - Cria a tag de Grupo de Impostos do item $${\color{red}(OBRIGATÓRIA)}$$

**Grupo de dados relativos ao ICMS**
> *Haverá um "choice" (escolha) (ICMSXX ou ICMSPart ou ICMSSN ou ICMSST)*

[tag ICMS](#tag-ICMS) - Cria a tag Grupo do ICMS do item (opcional) 

[tag ICMSPart](#tag-ICMSPart) - Cria Grupo de Partilha do ICMS entre a UF de origem e UF de destino ou a UF definida na legislação. (opcional)

[tag ICMSST](#tag-ICMSST) - Cria tag Grupo de informação do ICMSST (opcional) 

[tag ICMSSN](#tag-ICMSSN) - Cria tag Grupo de Tributação do ICMS pelo SIMPLES NACIONAL (opcional)  

[tag ICMSUFDest](#tag-ICMSUFDest) - Cria a tag Grupo a ser informado nas vendas interestarduais para consumidor final, não contribuinte de ICMS (opcional)

**Grupo de dados dos outros Impostos**

[tag IPI](#tag-IPI) - Cria tag do Grupo de informações sobre o IPI do item (opcional)

[tag II](#tag-II) - Cria tag Grupo de dados do Imposto de Importação do item (opcional)

[tag ISSQN](#tag-ISSQN) - Cria tag do Grupo de informações do ISSQN do item (opcional)


**Grupo de dados relativos ao PIS**
> *Haverá um "choice" (escolha) (PIS ou PISST)*
 
[tag PIS](#tag-PIS) - Cria a tag do Grupo de dados do PIS do item (opcional)

[tag PISST](#tag-PISST) - Cria tag com Grupo de informações sobre o PISST (opcional)


**Grupo de dados relativos ao COFINS**
> *Haverá um "choice" (escolha) (COFINS ou COFINSST)*

[tag COFINS](#tag-COFINS) - Cria tag com Grupo de informações sobre COFINS (opcional)

[tag COFINSST](#tag-COFINSST) - Cria tag com Grupo de informações sobre COFINSST (opcional)


**Grupo de dados relativos ao Imposto Seletivo (IS)**

[tag IS](#tag-IS) - Cria tag grupo referente ao "imposto do pecado" será aplicado a produtos específicos (opcional) $${\color{red}(RTC)}$$


**Grupo de dados relativos ao IBSCBS**
> *Haverá um "choice" (escolha)  (gIBSCBS ou gIBSCBSMono ou gTransfCred)*
 
[tag IBSCBS](#tag-IBSCBS) - Cria a tag Grupo CBS IBS Completo (opcional) $${\color{red}(RTC)}$$

[tag IBSCBSMono](#tag-IBSCBSMono) - Cria a tag Grupo de Informações do IBS e CBS em operações com imposto monofásico (opcional) $${\color{red}(RTC)}$$

[tag gTransfCred](#tag-gTransfCred) - Cria a tag Grupo de Informações de transferência de Crédito IBS/CBS (opcional) $${\color{red}(RTC)}$$

[tag gAjusteCompet](#tag-gAjusteCompet) - Cria a tag Grupo de Ajuste de Competência (opcional) $${\color{red}(PL_010_v1.30)}$$

[tag gEstornoCred](#tag-gEstornoCred) - Cria a tag Grupo de Estorno de Crédito (opcional) $${\color{red}(PL_010_v1.30)}$$

[tag gCredPresOper](#tag-gCredPresOper) - Cria a tag Grupo de Crédito Presumido da Operação (opcional) $${\color{red}(PL_010_v1.30)}$$

[tag gCredPresIBSZFM](#tag-gCredPresIBSZFM) - Cria tag Grupo de informações de Crédito Presumido em operações com a Zona Franca de Manaus  (opcional) $${\color{red}(RTC)}$$

[tag IBSCBSTribRegular](#tag-IBSCBSTribRegular) - Cria tag Grupo de informações da Tributação Regular (opcional) $${\color{red}(RTC)}$$

[tag IBSCredPres](#tag-IBSCredPres) - Cria tag Grupo de Informações do Crédito Presumido referente ao IBS (opcional) $${\color{red}(RTC)}$$

[tag CBSCredPres](#tag-CBSCredPres) - Cria tag Grupo de Informações do Crédito Presumido referente ao CBS (opcional) $${\color{red}(RTC)}$$

[tag gTribCompraGov](#tag-gTribCompraGov) - Cria tag Grupo de informações da composição do valor do IBS e da CBS em compras governamentais (opcional) $${\color{red}(RTC)}$$

[tag impostoDevol](#tag-impostoDevol) - Cria a tag Grupo de infomrções sobre IPI devolvido (opcional)

**Dados de Totais da NFe**

[tag total](#tag-total) - Cria vNFTot (opcional) $${\color{red}(RTC)}$$

[tag ICMSTot](#tag-ICMSTot) - Cria tag com totais de ICMS, IPI, PIS, COFINS (opcional)

[tag ISSQNTot](#tag-ISSQNTot) - Cria tag com totais de ISSQN (opcional)

[tag ISTot](#tag-ISTot) - Cria tag com totais do Imposto Seletivo IS (opcional) $${\color{red}(RTC)}$$

[tag IBSCBSTot](#tag-IBSCBSTot) - Cria tag com os totais do IBS e CBS (opcional) $${\color{red}(RTC)}$$

[tag retTrib](#tag retTrib) - Cria tag com as retenções de Tributos (opcional)


**Dados de Transporte**

[tag transp](#tag-transp) - Cria a tag de Dados dos transportes da NF-e $${\color{red}(OBRIGATÓRIA)}$$

[tag transporta](#tag-transporta) - Cria tag com Dados do transportador (opcional)

[tag rettransp](#tag-rettransp) - Cria tag com Dados da retenção  ICMS do Transporte (opcional) 

[tag veicTransp](#tag-veicTransp) - Cria tag com identificação do veiculo de tranporte (opcional)

[tag reboque](#tag-reboque) - Cria até 5 tags com os dados dos reboque, podem ocorrer até 5 registros (opcional)

[tag vagao](#tag-vagao) - Cria tag com identificação do vagão (opcional)

[tag balsa](#tag-balsa) - Cria tag com identificação da balsa (opcional)

[tag vol](#tag-vol) - Cria tag dados dos volumes, podem ocorrer até 5000 registros (opcional)  

[tag lacres](#tag-lacres) - Cria tag com os Lacres dos volumes, podem ocorrer até 5000 registros por volume (opcional)


**Dados de Pagamento/Cobrança**

[tag fat](#tag-fat) - Cria tag com dados de faturamento (opcional)

[tag dup](#tag-dup) - Cria tags com as duplicatas (opcional)

[tag pag](#tag-pag) - Cria tag de dados de pagamento $${\color{red}(OBRIGATÓRIA)}$$

[tag detpag](#tag-detpag) - Cria tag com detalhes dos pagamentos (opcional)


**Dados outras informações**

[tag intermed](#tag-intermed) - Cria tag com os dados do intermediador (opcional)

[tag infadic](#tag-infadic) - Cria a tag com as informações adicionais da NFe (opcional)

[tag obsCont](#tag-obsCont) - Cria as tags com observações do emitente (opcional)

[tag obsFisco](#tag-obsFisco) - Cria as tags com observações do fisco (opcional)

[tag procRef](#tag-procRef) - Cria a tag com dados do processo referenciado (opcional)

[tag exporta](#tag-exporta) - Cria tag com dados da Exportação (opcional)

[tag compra](#tag-compra) - Cria tag com dados da Compra (opcional)

[tag infRespTec](#tag-infRespTec) - Cria atag com dados do responsável técnico (opcional)


**Dados Colheita de Cana**

[tag cana](#tag-cana) - Cria tag com dados da Colheita de Cana (opcional)

[tag fordia](#tag-fordia) - Cria tag com dados diários da colheita de cana (opcional)

[tag deduc](#tag-deduc) - Cria tag com dados de deduções referentes a colheita de cana (opcional)


**Dados Agropecuario**

[tag AgropecuarioGuia](#$tag-AgropecuarioGuia) - Cria dados da Guia de transporte Agropecuario (opcional)

[tag AgropecuarioDefensivo](#$tag-AgropecuarioDefensivo) - Cria as tags com dados da receita do defensivo agricola (opcional)


```
tagTotal Observação: a tag vNFTot será exigida somente quando os novos
campos do IBS/CBS se tornarem obrigatórios (outubro/2025 em
homologação e janeiro/2026 em produção). Até essas datas, o não
preenchimento dessa tag não causará rejeição, mas será validada se for
informada. 
```

> **ALTERAÇÃO na construção da Make:class**
## function __construct(string $schema)         (ALTERADO com PARÂMETRO de criação)
Método construtor. Instancia a classe 

- Alteração no método: foi inclusa a inserção da identificação do schema a ser usado na classe construtora Make::class, para melhor identificar a versão a ser utilizada para a construção do XML e evitar erros durante o período de transição.

```php
$schema = 'PL_010_V1';

$mk = new Make($schema); //se não informado o schema será usado o PL_009_V4, o conjunto de xsd atualmente em uso.
$mk->setOnlyAscii(false); //opções true remove todos a acentuação ou false mantêm os acentos nos textos. DEFAULT false
$mk->setCheckGtin(false); //opções true ativa a verificação do número GTIN ou false desativa essa validação. DEFAULT false  
```
## tag infNFe
[Volta](#Métodos)

### function taginfNFe($std):DOMElement    (SEM ALTERAÇÃO)
Node principal - OBRIGATÓRIO

> NOTA: **se o parâmetro $std->Id não for passado a chave será criada e inclusa e poderá ser recuperada no parâmetro chNFe da classe,**
**De outra forma se a chave for passada no parâmetro $std->Id e estiver incorreta, um erro será inserido na proriedade errors.**

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->versao = '4.00'; //versão do layout (string)
$std->Id = 'NFe35150271780456000160550010000000021800700082'; //se o Id de 44 digitos não for passado será gerado automaticamente
$std->pk_nItem = null; //deixe essa variavel sempre como NULL

$mk->taginfNFe($std);
```

## tag ide
[Volta](#Métodos)

### function tagide(object $ide):DOMElement   (ALTERAÇÃO nos PARÂMETROS)
Node ide - identificação da NFe - OBRIGATÓRIO

> Nota: os campos novos relacionados à Reforma Tributária listados abaixo, serão ignorados se usar o schema PL_009_V4.
> - cMunFGIBS
> - tpNFDebito
> - tpNFCredito

> Nota: NT2025.002_v1.30 - PL_010_V1.30 - novo campo, deve ser informado apenas se usar o schema PL_010_V1.30
> - dPrevEntrega

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ide = [
    'cUF' => 12, // OBRIGATÓRIO numero da UF
    'cNF' => null, //opcional 8 digitos max, será preenchido automaticamente com zeros a esquerda
                   //se deixado com null, será inserido um valor aleatório de acordo com as regras da SEFAZ
                   //se forem informados mais de 8 digitos o valor será truncado para 8 digitos
    'natOp' => 'REMESSA P/ INDUSTRIALIZAÇÃO', // OBRIGATÓRIO max 60 caracteres
    'mod' => 55, // OBRIGATÓRIO modelo 55 ou 65
    'serie' => 1, // OBRIGATÓRIO série normal 0-889 SCAN 900-999
    'nNF' => 100, // OBRIGATÓRIO até 9 digitos
    'dhEmi' => null, //opcional se deixado com null, será inserida a data e hora atual para a UF
    'dhSaiEnt' => null, //opcional
                        //CUIDADO ao inserir deve corresponder a data e hora correta para a UF e deve ser maior ou igual a dhEmi
    'dPrevEntrega' => null, //opcional yyyy-mm-dd Data da previsão de entrega ou disponibilização do bem **[PL_010_V1.30]**                   
    'tpNF' => 1, // OBRIGATÓRIO 0-entrada; 1-saída
    'idDest' => 3, // OBRIGATÓRIO 1-Interna;2-Interestadual;3-Exterior
    'cMunFG' => 2111300, // OBRIGATÓRIO 7 digitos IBGE Código do Município de Ocorrência do Fato Gerador
    'cMunFGIBS' => 2111300, //opcional 7 digitos IBGE apenas PL_010 em diante
                            //cMunFGIBS somente deve ser preenchido quando indPres = 5 (Operação presencial, fora do estabelecimento),
                            //e não tiver endereço do destinatário (tag <enderDest>) ou local de entrega (tag <entrega>).
    'tpImp' => 1, // OBRIGATÓRIO
        //0-sem DANFE;
        //1-DANFe Retrato;
        //2-DANFe Paisagem;
        //3-DANFe Simplificado;
        //4-DANFe NFC-e;
        //5-DANFe NFC-e em mensagem eletrônica
    'tpEmis' => 1, // OBRIGATÓRIO
        //1 - Normal;
        //2 - Contingência FS
        //3 - Regime Especial NFF (NT 2021.002)
        //4 - Contingência DPEC
        //5 - Contingência FSDA
        //6 - Contingência SVC - AN
        //7 - Contingência SVC - RS
        //9 - Contingência off-line NFC-e
    'cDV' => null, //opcional 1 digito
        //será calculado e inserido automaticamente, substituindo o cDV incorreto informado
    'tpAmb' => 2, // OBRIGATÓRIO 1-produçao 2-homologação
    'finNFe' => 1, // OBRIGATÓRIO
        //1 - NFe normal
        //2 - NFe complementar
        //3 - NFe de ajuste
        //4 - Devolução/Retorno
        //5 - Nota de crédito
        //6 - Nota de débito
    'tpNFDebito' => '01', //opcional apenas PL_010 em diante
        //01=Transferência de créditos para Cooperativas;
        //02=Anulação de Crédito por Saídas Imunes/Isentas;
        //03=Débitos de notas fiscais não processadas na apuração;
        //04=Multa e juros;
        //05=Transferência de crédito de sucessão.
    'tpNFCredito' => '01', //opcional apenas PL_010 em diante
        //01 - a definir ?????????????????????????????????????????????
    'indFinal' => 0, // OBRIGATÓRIO 0 Normal; 1 Consumidor final;
    'indPres' => 9, // OBRIGATÓRIO
        //1 Operação presencial;
        //2 Operação não presencial, pela Internet;
        //3 Operação não presencial, Teleatendimento;
        //4 NFC-e em operação com entrega a domicílio;
        //5 Operação presencial, fora do estabelecimento; (incluído NT 2016/002)
        //9 Operação não presencial, outros
    'indIntermed' => 0, //opcional
        //0 Operação sem intermediador (em site ou plataforma própria)
        //1 Operação em site ou plataforma de terceiros
    'procEmi' => 3, //OBRIGATÓRIO
        //0 - emissão de NF-e com aplicativo do contribuinte;
        //1 - emissão de NF-e avulsa pelo Fisco;
        //2 - emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;
        //3- emissão de NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
    'verProc' => '4.13', //OBRIGATÓRIO de 1 a 20 caracteres
    'dhCont' => '2025-05-05T02:01:11-03:00', //opcional data e hora da entrada em contingência
    'xJust' => 'Justificativa contingência com pelo menos 15 caracteres', //opcional motivo da entrada em contingência entre 15 e 256 caracateres
];
$mk->tagide((object)$ide);
```

## tag emit
[Volta](#Métodos)

### function tagEmit(object $emit):DOMElement    (SEM ALTERAÇÃO)
Node emit - Informações do Emitente - OBRIGATÓRIO

> NOTA: a partir de 2026 o CNPJ poderá ser ALFA NUMÉRICO !!

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$emi = [
    'xNome' => 'TESTE LTDA', //OBRIGATÓRIO razão social com 2 até 60 caracteres
    'xFant' => 'TESTE', //opcional nome fantasia com 1 até 60 caracteres
    'IE' => '11233335555', //OBRIGATÓRIO [0-9]{2,14}|ISENTO
    'IEST' => null, //opcional [0-9]{2,14}
    'IM' => '95095870', //opcional de 1 a 15 caracteres
    'CNAE' => '0131380', //opcional [0-9]{7}
    'CRT' => 4, //OBRIGATóRIO
        //1 – Simples Nacional;
        //2 – Simples Nacional – excesso de sublimite de receita bruta;
        //3 – Regime Normal.
        //4 - Simples Nacional - Microempreendedor individual - MEI
    'CNPJ' => '12345678901234', //opcional [0-9]{14} ##### NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2} #####
    'CPF' => '12345678901', //opcional [0-9]{11} - se os dois campos forem inclusos o CNPJ tem prioridade
];
$mk->tagEmit((object)$emi);
```

# tag enderEmit
[Volta](#Métodos)

### function tagEnderemit(object $ender):DOMElement)   (SEM ALTERAÇÃO)
Node enderEmit - Endereço do Emitente da NFe - OBRIGATÓRIO

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$end = [
    'xLgr' => 'RUA 10', //OBRIGATÓRIO de 2 a 60 caracteres
    'nro' => '897', //OBRIGATÓRIO de 1 a 60 caracteres
    'xCpl' => 'LJ 01', //opcional de 1 a 60 caracteres
    'xBairro' => 'Sto Antonio', //OBRIGATÓRIO de 2 a 60 caracteres
    'cMun' => 2111300, //OBRIGATÓRIO codigo do IBGE 7 digitos
    'xMun' => 'São Luis', //OBRIGATÓRIO de 2 a 60 caracteres
    'UF' => 'MA', //OBRIGATÓRIO 2 caracteres
    'CEP' => '65091514', //OBRIGATÓRIO 8 digitos
    'cPais' => 1058, //opcional codigo do pais 4 digitos
    'xPais' => 'Brasil', //opcional Brasil ou BRASIL
    'fone' => '9820677300', //opcional DDD + número do telefone de 6 a 14 digitos
];
    $mk->tagenderEmit((object)$end);
```

# Bloco de Documentos Referenciados na NFe

> NOTA MULTIPLAS ENTRADAS - Podem ocorrer até 999 referencias por NFe, entre NFe, NF, CTe e ECF.

# tag refNFe
[Volta](#Métodos)

### function tagrefNFe(object $ref):DOMElement   (SEM ALTERAÇÃO)
Node NFref/refNFe - NFe referenciada - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ref = [
    'refNFe' => '12345678901234567890123456789012345678901234' //OBRIGATÓRIO chave de 44 digitos
];
$mk->tagrefNFe((object)$ref);
```

# tag refNF
[Volta](#Métodos)

### function tagrefNF(object $nf):DOMElement     (SEM ALTERAÇÃO)
Node NFref/refNF - NFe referenciada - OPCIONAL

> Esta tag está em desuso, pois as NF de papel, estão sendo substituídas pos documentos eletrônicos.

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$nf = [
    'cUF' => 35, //OBRIGATÓRIO codigo do estado
    'AAMM' => 1801, //OBRIGATÓRIO ano e mes da emissão da NF
    'CNPJ' => '12345678901234', //NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
    'mod' => '01', //OBRIGATÓRIO modelo da NF de 01 a 04
    'serie' => 0, //OBRIGATÓRIO série da NF 0|[1-9]{1}[0-9]{0,2}
    'nNF' => 123456789 //OBRIGATÓRIO número da NF [1-9]{1}[0-9]{0,8}
];
$mk->tagrefNF((object)$nf);
```

# tag refNFP
[Volta](#Métodos)

### function tagrefNFP(object $nfp):DOMElement    (SEM ALTERAÇÃO)
Node NFref/refNFP - NFe de Produtor Rural referenciada - OPCIONAL

> Esta tag está em desuso, pois as NF de papel estão sendo substituídas pos documentos eletrônicos.

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$nfp = [
    'cUF' => 35, //OBRIGATÓRIO codigo do estado
    'AAMM' => 1801, //OBRIGATÓRIO ano e mes da emissão da NF
    //'CNPJ' => '12345678901234', //opcional NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
    'CPF' => '12345678901', //opcional
    'IE' => '123456', //OBRIGATÓRIO Inscrição Estadual do Produtor rural
    'mod' => '04', //OBRIGATÓRIO usar modelo 04
    'serie' => 0, //OBRIGATÓRIO usar zero se não tiver serie (unica)  0|[1-9]{1}[0-9]{0,2}
    'nNF' => 9999 //OBRIGATÓRIO número da NF [1-9]{1}[0-9]{0,8}
];
$mk->tagrefNFP((object)$nfp);
```

# tag refCTe
[Volta](#Métodos)

### function tagrefCTe(object $cte):DOMElement     (SEM ALTERAÇÃO)
Node NFref/refCTe - CTe Conhecimento de Transporte referenciada - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$cte = [
    'refCTe' => '11111111111111111111111111111111111111111111'
];
$mk->tagrefCTe((object)$cte);
```

# tag refECF
[Volta](#Métodos)

### function tagrefECF(object $ecf):DOMElement  (SEM ALTERAÇÃO)
Node NFref/refECF - Cupom Fiscal vinculado à NF-e - OPCIONAL

> Esta tag está em desuso, pois os ECF estão sendo substituídos por NFCe

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ecf = [
    'mod' => '2D', //OBRIGATÓRIO Código do modelo do Documento Fiscal
                    //Preencher com 2B quando se tratar de Cupom Fiscal emitido por máquina registradora (não ECF),
                    //com 2C, quando se tratar de Cupom Fiscal PDV,
                    //ou 2D, quando se tratar de Cupom Fiscal (emitido por ECF)
    'nECF' => '012', //OBRIGATÓRIO Informar o número de ordem seqüencial do ECF de 1 a 3 digitos
    'nCOO' => 678901 //OBRIGATÓRIO úmero do Contador de Ordem de Operação - COO de 1 a 6 digitos 
];
$mk->tagrefECF((object)$ecf);
```

# Fim do Bloco de Documentos Referenciados na NFe

# tag gCompraGov
[Volta](#Métodos)

### function taggCompraGov(object $gcg): DOMElement       (NOVO MÉTODO)  
Node PL_010 - Reforma Tributária - Compra Governamental - OPCIONAL

> Esta tag somente será inserida quando schema usado for o PL_010

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$gcg = [
    'tpEnteGov' => 1, //OBRIGATÓRIO identificação do ente governamental
        //1 União
        //2 Estados
        //3 Distrito Federal
        //4 Municípios
    'pRedutor' => 10.0000, //OBRIGATÓRIO Percentual de redução de alíquota em compra governamental
    'tpOperGov' => 1 //OBRIGATÓRIO Tipo da operação com ente governamental
        //1 - Fornecimento
        //2 - Recebimento do Pagamento 
];
$mk->taggCompraGov((object)$gcg);
```

# tag dest
[Volta](#Métodos)

### function tagdest(object $dest): DOMElement  (SEM ALTERAÇÃO)
Node dest - Identificação do Destinatário - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$dest = [
    'xNome' => 'Eu Ltda', //opcional de 2 a 60 caracteres
    'CNPJ' => '12345678901234', //opcional NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
    'CPF' => '12345678901', //opcional
    'idEstrangeiro' => null, //opcional de 5 a 20 caracteres
    'indIEDest' => 9, //OBRIGATÓRIO Indicador da IE do destinatário 
        //1 – Contribuinte ICMSpagamento à vista;
        //2 – Contribuinte isento de inscrição;
        //9 – Não Contribuinte
    'IE' => null, //opcional de 2 a 14 digitos
    'ISUF' => '12345679', //opcional de 8 a 9 digitos
    'IM' => 'XYZ6543212', //opcional de 1 a 15 caracteres
    'email' => 'seila@seila.com.br' //opcional de 1 a 60 caracteres
];
$mk->tagdest((object)$dest);
```

# tag enderDest
[Volta](#Métodos)

### function tagenderdest(object $end): DOMElement   (SEM ALTERAÇÃO)
Node enderdest - Endereço do Destinatário - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$end = [
    'xLgr' => 'Estrada do Canguçu', //OBRIGATÓRIO de 2 a 60 caracteres
    'nro' => 'km 12', //OBRIGATÓRIO de 1 a 60 caracteres
    'xCpl' => null, //opcional de 2 a 60 caracteres
    'xBairro' => 'Vila Escondida', //OBRIGATÓRIO de 2 a 60 caracteres
    'cMun' => '9999999', //OBRIGATÓRIO codigo do IBGE ou 9999999 para estrangeiro
    'xMun' => 'Apratos', //OBRIGATÓRIO  de 2 a 60 caracteres
    'UF' => 'EX', //OBRIGATÓRIO Sigla da UF ou EX para estrangeiro
    'CEP' => '00999999', //opcional 8 digitos
    'cPais' => 1600, //opcional codigo BACEN 1 a 4 digitos
    'xPais' => 'China', //opcional  de 2 a 60 caracteres
    'fone' => '1111111111' //opcional de 6 a 14 digitos DDD + número do telefone ou 
     //nas operações com exterior é permtido informar o código do país + código da localidade + número do telefone
];
$mk->tagenderdest((object)$end);
```

# tag retirada
[Volta](#Métodos)

### function tagretirada(object $ret): DOMElement   (SEM ALTERAÇÃO)
Node retirada - Identificação do Local de Retirada (informar apenas quando for diferente do endereço do remetente) - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ret = [
    'xNome' => 'Eu Ltda', //OBRIGATÓRIO 2 a 60 caracteres
    'CNPJ' => '01234123456789', //opcional se informar o CPF NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
    'CPF' => '12345678901', //opcional se informar o CNPJ
    'IE' => '11111111111',
    'xLgr' => 'Rua D', //OBRIGATÓRIO 2 a 60 caracteres
    'nro' => 'sem numero', //OBRIGATÓRIO 1 a 60 caracteres
    'xCpl' => 'fundos', //opcional 1 a 60 caracteres
    'xBairro' => 'Fim do mundo', //OBRIGATÓRIO 2 a 60 caracteres
    'cMun' => 3512345, //OBRIGATÓRIO 7 digitos
    'xMun' => 'São Vito', //OBRIGATÓRIO 2 a 60 caracteres
    'UF' => 'SP', //OBRIGATÓRIO 2 caracteres
    'CEP' => '00000000', //opcional 8 digitos
    'cPais' => 1058, //opcional 1 à 4 digitos
    'xPais' => 'Brasil', //opcional 2 a 60 caracteres
    'fone' => '1111111111', //opcional de 6 a 14 digitos
    'email' => 'eu@mail.com' //opcional 1 a 60 caracteres
];
$mk->tagretirada((object)$ret);
```

# tag entrega
[Volta](#Métodos)

### function tagentrega(object $ent): DOMElement    (SEM ALTERAÇÃO)
Node entrega - Identificação do Local de Entrega (informar apenas quando for diferente do endereço do destinatário) - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ent = [
    'xNome' => 'Ele Ltda', //OBRIGATÓRIO 2 a 60 caracteres
    //'CNPJ' => '01234123456789', //opcional se informar o CPF NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
    'CPF' => '12345678901', //opcional se informar o CNPJ
    'IE' => '11111111111',
    'xLgr' => 'Rua A', //OBRIGATÓRIO 2 a 60 caracteres
    'nro' => '1', //OBRIGATÓRIO 1 a 60 caracteres
    'xCpl' => 'frente', //opcional 1 a 60 caracteres
    'xBairro' => 'Fim do mundo', //OBRIGATÓRIO 2 a 60 caracteres
    'cMun' => 3512345, //OBRIGATÓRIO 7 digitos
    'xMun' => 'São Vito', //OBRIGATÓRIO 2 a 60 caracteres
    'UF' => 'SP', //OBRIGATÓRIO 2 caracteres
    'CEP' => '00000000', //opcional 8 digitos
    'cPais' => 1058, //opcional 1 à 4 digitos
    'xPais' => 'Brasil', //opcional 2 a 60 caracteres
    'fone' => '222222', //opcional de 6 a 14 digitos
    'email' => 'ele@mail.com' //opcional 1 a 60 caracteres
];
$mk->tagentrega((object)$ent);
```

# tag autXML
[Volta](#Métodos)

### function tagautXML(object $aut): DOMElement   (SEM ALTERAÇÃO)
Node autXML - Pessoas autorizadas para o download do XML da NF-e - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - Podem haver até 10 registros de pessoas autorizadas. Então podem repetidos até 10 vezes essa tag.

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$aut = [
    'CNPJ' => '01234123456789', //este é o campo prioritário caso sejam informados os dois apenas o CNPJ será considerado
    'CPF' => null
];
$mk->tagautXML((object)$aut);
```

# tag prod
[Volta](#Métodos)

### funtion tagprod(object $prod): DOMElement    (ALTERAÇÃO nos PARÂMETROS)
Node det/prod - Produtos - OBRIGATÓRIO

> NOTA: o método tagCEST() foi substituído, com dados diretos nesta tag, 

> NOTA MÚLTIPLAS ENTRADAS - a tag dev/prod pode ocorrer até 990 vezes 

> Nota: campo novo relativo à Reforma Tributária
> - vItem - Valor total do Item, correspondente à sua participação no total da nota. A soma dos itens deverá corresponder ao total da nota.
 
> Nota: NT2025.002_v1.30 - PL_010_V1.30, novo campo usar apenas com PL_010_V1.30, deixar null nos demais casos
> - tpCredPresIBSZFM
 
| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe 1 a 990
$std->cProd = '23qq'; //OBRIGATÓRIO de 1 à 60 caracteres
$std->cEAN = "SEM GTIN";//OBRIGATÓRIO SEM GTIN|[0-9]{0}|[0-9]{8}|[0-9]{12,14}
$std->cBarra = "123";//opcional de 3 à 30 caracteres
$std->xProd = 'SERVICO'; //OBRIGATÓRIO 1 a 120 caracteres
$std->NCM = 99; //OBRIGATÓRIO [0-9]{2}|[0-9]{8}
$std->CEST = '1234567'; //opcional usado apenas para produtos com ST 7 digitos
$std->indEscala = 'S'; //opcional usado junto com CEST, S-escala relevante N-escala NÃO relevante
$std->CNPJFab = '12345678901234'; //opcional usado junto com CEST e qunado indEscala = N
$std->cBenef = 'ab222222'; //opcional codigo beneficio fiscal ([!-ÿ]{8}|[!-ÿ]{10}|SEM CBENEF)?
$std->tpCredPresIBSZFM = null; //opcional Classificação para subapuração do IBS na ZFM **[PL_010_V1.30]**
    // 0 - Sem Crédito Presumido
    // 1 - Bens de consumo final (55%)
    // 2 - Bens de capital (75%)
    // 3 - Bens intermediários (90,25%)
    // 4 - Bens de informática e outros definidos em legislação (100%)
$std->EXTIPI = '01';
$std->CFOP = 5933;
$std->uCom = 'UN';
$std->qCom = 10;
$std->vUnCom = 100.00;
$std->vProd = 1000.00;
$std->cEANTrib = "SEM GTIN";//'6361425485451';
$std->uTrib = 'UN';
$std->qTrib = 10;
$std->vUnTrib = 100.00;
$std->vFrete = 1000.00;
$std->vSeg = 20.00;
$std->vDesc = 10.00;
$std->vOutro = 15.00;
$std->indTot = 1;
$std->indBemMovelUsado = null; //opcional 1-Bem Móvel Usado ou null
$std->xPed = '12345';
$std->nItemPed = 1;
$std->nFCI = '12345678-1234-1234-1234-123456789012';
$std->CEST = null;
$std->indEscala = null;
$std->CNPJFab = null;
$std->vItem = null; //opcional Valor total do Item, correspondente à sua participação no total da nota.
    // A soma dos itens deverá corresponder ao total da nota. com duas decimais
$mk->tagprod($std);
```

# tag infAdProd
[Volta](#Métodos)

### funtion taginfAdProd(object $inf): DOMElement     (SEM ALTERAÇÃO)
Node dev/prod/infAdProd - Informações adicionais do produto (norma referenciada, informações complementares, etc) - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$inf = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe 1 a 990
    'infAdProd' => 'Informação especifica sobre o item do produto' //OBRIGATÓRIO de 1 a 500 caracteres
];
$mk->taginfAdProd((object) $inf);
```

# tag ObsItem
[Volta](#Métodos)

### function tagObsItem(object $obs): DOMElement   (NOVO MÉTODO)
Node prod/infAdProd/obsItem - Grupo de observações de uso livre (para o item da NF-e) - OPCIONAL

> NOTA este método substitui o anterior tagprodObsCont()

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$obs = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe 1 a 990
    'obsCont_xCampo' => 'nome', //opcional nome do campo de 1 a 20 caracteres
    'obsCont_xTexto' => 'informação', //opcional informação do campo de 1 a 60 caracteres
    'obsFisco_xCampo' => 'nome', //opcional nome do campo de 1 a 20 caracteres
    'obsFisco_xTexto' => 'informação', //opcional informação do campo de 1 a 60 caracteres
];
$mk->tagObsItem((object) $obs);
```

# tag DFeReferenciado
[Volta](#Métodos)

## function tagDFeReferenciado(object $ref): DOMElement   (NOVO MÉTODO Reforma Tributária)
Node det/DFeReferenciado - Referenciamento de item de outros DFe - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ref = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe 1 a 990
    'chaveAcesso' => '12345678901234567890123456789012345678901234', //OBRIGATÓRIO Chave de acesso do DF-e referenciado
    'nIem' => 2, //opcional Número do item do documento referenciado.
];
$mk->tagDFeReferenciado((object) $ref);
```

# tag gCred
[Volta](#Métodos)

## function taggCred(object $gc): DOMElement    (NOVO MÉTODO Reforma Tributária)
Node prod/gCred - Grupo de informações sobre o CréditoPresumido - OPCIONAL

> NOTA: substitui tagCreditoPresumidoProd

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 4 registros desse grupo por item da NFe

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$gc = [
    'item' => 1, //OBRIGATÓRIO
    'cCredPresumido' => '12AFCJE7', //OBRIGATÓRIO com 8 ou 10 caracteres
    'pCredPresumido' => 1.00, //OBRIGATÓRIO percentual com 2 ou 4 decimais
    'vCredPresumido' => 1.00 //OBRIGATÓRIO valor com 2 decimais
];
$mk->taggCred((object)$gc);
```

# tag NVE
[Volta](#Métodos)

## function tagnve(object $std): DOMElement      (SEM ALTERAÇÃO)
Node prod/NVE - Nomenclatura de Valor aduaneiro e Estatístico - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 8 registros desse grupo por item da NFe

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'NVE' => 'AZ3456' //OBRIGATÓRIO [A-Z]{2}[0-9]{4}
];
$mk->tagnve((object)$std);
```

# tag DI
[Volta](#Métodos)

## function tagDI(object $std): DOMElement   (SEM ALTERAÇÃO)
Node prod/DI - Declaração de Importação - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 100 registros desse grupo por item da NFe
> Obrigatório em NFe de Importação 

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->nDI = '123049'; //OBRIGATÓRIO Número do Documento de Importação (DI, DSI, DIRE, DUImp) de 1 à 15 caracteres
$std->dDI = '2018-04-22'; //OBRIGATÓRIO Data de registro da DI/DSI/DA (AAAA-MM-DD)
$std->xLocDesemb = 'SANTOS'; //OBRIGATÓRIO Local do desembaraço aduaneiro de 1 à 60 caracteres
$std->UFDesemb = 'SP'; //OBRIGATÓRIO UF onde ocorreu o desembaraço aduaneiro duas letras
$std->dDesemb = '2018-04-22'; //OBRIGATÓRIO Data do desembaraço aduaneiro (AAAA-MM-DD)
$std->tpViaTransp = 1; //OBRIGATÓRIO Via de transporte internacional informada na DI ou na Declaração Única de Importação (DUImp)
    //1-Maritima;
    //2-Fluvial;
    //3-Lacustre;
    //4-Aerea;
    //5-Postal;
    //6-Ferroviaria;
    //7-Rodoviaria;
    //8-Conduto;
    //9-Meios Proprios;
    //10-Entrada/Saida Ficta;
    //11-Courier;
    //12-Em maos;
    //13-Por reboque
$std->vAFRMM = 200.00; //opcional Valor Adicional ao frete para renovação de marinha mercante até 2 decimais
$std->tpIntermedio = 3; //OBRIGATÓRIO Forma de Importação quanto a intermediação
    //1-por conta propria;
    //2-por conta e ordem;
    //3-encomenda
$std->CNPJ = '12345678901234'; //opcional CNPJ do adquirente ou do encomendante
$std->CPF = '12345678901'; //opcional CPF do adquirente ou do encomendante
$std->UFTerceiro = 'MG'; //opcional Sigla da UF do adquirente ou do encomendante
$std->cExportador = 'exportador China1'; //OBRIGATÓRIO Código do exportador (usado nos sistemas internos
    // de informação do emitente da NF-e) de 1 à 60 caracteres
$mk->tagDI($std);
```

# tag adi
[Volta](#Métodos)

## function tagadi(object $std): DOMElement    (SEM ALTERAÇÃO)
Node prod/DI/adi - Adições da DI OBRIGATÓRIA se existir a DI - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 999 registros para cada DI declarada por item da NFe
> Obrigatório em NFe de Importação

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new \stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->nDI = '123049'; //OBRIGATÓRIO referencia à DI
$std->nAdicao = 1; //opcional Número da Adição [1-9]{1}[0-9]{0,2}
$std->nSeqAdic = 1; //OBRIGATÓRIO Número seqüencial do item [1-9]{1}[0-9]{0,4}
$std->cFabricante = 'ZZZZZZ'; //OBRIGATÓRIO Código do fabricante estrangeiro de 1 à 60 caracteres
$std->vDescDI = 10.00; //opcional Valor do desconto do item até duas decimais
$std->nDraw = null; //opcional Número do ato concessório de Drawback de 1 à 20 caracteres
$mk->tagadi($std);
```

# tag detExport
[Volta](#Métodos)

## function tagdetExport(objetc $std): DOMElement     (SEM ALTERAÇÃO)
Node prod/detExport - Detalhe da exportação - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 500 registros por item 
> Usado em NFe de Exportação apenas
 
| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new \stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->nDraw = '029309'; //opcional Número do ato concessório de Drawback de 1 à 20 caracteres
$std->nRE = '123456789012'; //opcional Registro de exportação [0-9]{0,12}
$std->chNFe = '12345678901234567890123456789012345678901234'; //opcional Chave de acesso da NF-e recebida
    // para exportação campo OBRIGATÓRIO se nRE for informado
$std->qExport = 12455.9000; //opcional Quantidade do item efetivamente exportado até 4 decimais
$mk->tagdetExport($std);
```

# tag rastro
[Volta](#Métodos)

## function tagrastro(object $std): DOMElement   (SEM ALTERAÇÃO)
Node prod/rastro - Rastreabilidade - OPCIONAL
> NOTA MULTIPLAS ENTRADAS - Dados de rastreabilidade uso em medicamentos, podem ocorrer até 500 repetições por item da NFe

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual | 
 
```php
$std = new \stdClass();
$std->item = 1;
$std->nLote = 'ACBDE17272'; //OBRIGATÓRIO Número do lote do produto de 1 à 20 caracteres
$std->qLote = 20; //OBRIGATÓRIO Quantidade de produto no lote.
$std->dFab = '2025-01-23'; //OBRIGATÓRIO data da fabricação AAAA-MM-DD
$std->dVal = '2026-01-23'; //OBRIGATÓRIO data de fim da validade AAAA-MM-DD
                           //Informar o último dia do mês caso a validade não especifique o dia
$std->cAgreg = '12345678901234'; //opcional Código de Agregação de 1 à 20 caracteres
$mk->tagrastro($std);
```

# Informações específicas de produtos e serviços

> **Haverá um "choice" (escolha) entre os registros desse grupo, portanto apenas um será inserido no item da NFe**
> **E essa escolha será feita na sequência de inserção no XML, sendo usado o primeiro grupo encontrado, dentre os possíveis, portanto tenha atenção a isso !!** 

# tag veicProd
[Volta](#Métodos)

## function tagveicProd(object $veic): DOMElement  (SEM ALTERAÇÃO)
Node prod/veicProd - Veículos novos - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$veic = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'tpOp' => 1, //OBRIGATÓRIO Tipo da operação
        //0 Outros
        // 1 Venda concessionária,
        // 2 Faturamento direto para consumidor final
        // 3 Venda direta para grandes consumidores (frotista, governo, ...
    'chassi' => 'AAA2kdkjskjkjjdjkjskjd', //OBRIGATÓRIO Chassi do veículo - VIN (código-identificação-veículo) [A-Z0-9]+
    'cCor' => 'Z123', //OBRIGATÓRIO Cor do veículo (código de cada montadora) de 1 a 4 caracteres
    'xCor' => 'Azul calcinha', //OBRIGATÓRIO descrição da cor de 1 a 40 caracteres
    'pot' => '450', //OBRIGATÓRIO Potência máxima do motor do veículo em cavalo vapor (CV). (potência-veículo) de 1 a 4 caracteres
    'cilin' => '2000', //OBRIGATÓRIO Capacidade voluntária do motor expressa em centímetros cúbicos (CC). (cilindradas) de 1 a 4 caracteres
    'pesoL' => '1800', //OBRIGATÓRIO Peso líquido de 1 a 9 caracteres
    'pesoB' => '2500', //OBRIGATÓRIO Peso bruto de 1 a 9 caracteres
    'nSerie' => '123456789', //OBRIGATÓRIO Serial (série) de 1 a 9 caracteres
    'tpComb' => '18', //OBRIGATÓRIO Tipo de combustível-Tabela RENAVAM:
        //01 - Álcool
        //02 - Gasolina
        //03 - Diesel
        //04 - Gasogênio
        //05 - Gás Metano
        //06 - Elétrico/Fonte Interna
        //07 - Elétrico/Fonte Externa
        //08 - Gasolina/Gás Natural Combustível
        //09 - Álcool/Gás Natural Combustível
        //10 - Diesel/Gás Natural Combustível
        //11 - Vide/Campo/Observação
        //12 - Álcool/Gás Natural Veicular
        //13 - Gasolina/Gás Natural Veicular
        //14 - Diesel/Gás Natural Veicular
        //15 - Gás Natural Veicular
        //16 - Álcool/Gasolina
        //17 - Gasolina/Álcool/Gás Natural Veicular
        //18 - Gasolina/elétrico
    'nMotor' => '123456789012345678901', //OBRIGATÓRIO Número do motor de 1 a 21 caracteres
    'CMT' => '21.0000', //OBRIGATÓRIO CMT-Capacidade Máxima de Tração - em Toneladas 4 casas decimais de 1 a 9 caracteres
    'dist' => '1.89', //OBRIGATÓRIO Distância entre eixos de 1 a 4 caracteres
    'anoMod' => '2025', //OBRIGATÓRIO Ano Modelo de Fabricação [0-9]{4}
    'anoFab' => '2025', //OBRIGATÓRIO Ano de Fabricação [0-9]{4}
    'tpPint' => 'B', //OBRIGATÓRIO Tipo de pintura 1 caracter ???
    'tpVeic' => '11', //OBRIGATÓRIO Tipo de veículo (utilizar tabela RENAVAM) [0-9]{1,2}
    'espVeic' => '1', //OBRIGATÓRIO Espécie de veículo (utilizar tabela RENAVAM)  [0-9]{1}
    'VIN' => 'N', //OBRIGATÓRIO Informa-se o veículo tem VIN (chassi) remarcado R-remarcado ou N-não remarcado
    'condVeic' => '1', //OBRIGATÓRIO Condição do veículo
        // 1 - acabado;
        // 2 - inacabado;
        // 3 - semi-acabado
    'cMod' => '001234', //OBRIGATÓRIO Código Marca Modelo (utilizar tabela RENAVAM) [0-9]{1,6}
    'cCorDENATRAN' => '02', //OBRIGATÓRIO Código da Cor Segundo as regras de pré-cadastro do DENATRAN: [0-9]{1,2}
        //01-AMARELO;
        //02-AZUL;
        //03-BEGE;
        //04-BRANCA;
        //05-CINZA;
        //06-DOURADA;
        //07-GRENA
        //08-LARANJA;
        //09-MARROM;
        //10-PRATA;
        //11-PRETA;
        //12-ROSA;
        //13-ROXA;
        //14-VERDE;
        //15-VERMELHA;
        //16-FANTASIA
    'lota' => '4', //OBRIGATÓRIO Capacidade máxima de lotação Quantidade máxima de permitida de passageiros sentados, inclusive motorista [0-9]{1,3}
    'tpRest' => '0' //OBRIGATÓRIO Restrição
        //0 Não há;
        //1 Alienação Fiduciária;
        //2 Arrendamento Mercantil;
        //3 Reserva de Domínio;
        //4 Penhor de Veículos;
        //9 Outras.
];
$mk->tagveicProd((object)$veic);
```

# tag med
[Volta](#Métodos)

## function tagmed(object $std): DOMElement   (SEM ALTERAÇÃO)
Node prod/med - Detalhamento de Medicamentos e de matérias-primas farmacêuticas - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->cProdANVISA = 'AAB0492321110'; //OBRIGATÓRIO Utilizar o número do registro ANVISA
                                     // ou preencher com o literal “ISENTO”
$std->xMotivoIsencao = ''; //opcional de 1 à 255 caracteres
    // Obs.: Para medicamento isento de registro na ANVISA, informar o número da decisão que o isenta,
    // como por exemplo o número da Resolução da Diretoria Colegiada da ANVISA (RDC).
$std->vPMC = 200.00; //OBRIGATÓRIO Preço máximo consumidor com até duas decimais
$mk->tagmed($std);
```

# tag arma
[Volta](#Métodos)

## function tagarma(object $arma): DOMElement   (SEM ALTERAÇÃO)
Node prod/arma - Detalhamento de Armamento - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$arma = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'tpArma' => 1, //OBRIGATÓRIO Indicador do tipo de arma de fogo (0 - Uso permitido; 1 - Uso restrito)
    'nSerie' => 'abc-2039', //OBRIGATÓRIO Número de série da arma de 1 à 15 caracteres
    'nCano' => 'abc-z1111', //OBRIGATÓRIO Número de série do cano de 1 à 15 caracteres
    'descr' => 'fuzilli de trigo sarraceno'//OBRIGATÓRIO Descrição completa da arma, compreendendo: calibre, marca, capacidade,
        // tipo de funcionamento, comprimento e demais elementos que permitam a sua
        // perfeita identificação de 1 à 256 caracteres
];
$mk->tagarma((object)$arma);
```

# tag comb
[Volta](#Métodos)

## functicon tagcomb(object $comb)   (SEM ALTERAÇÃO)
Node prod/comb - Informar apenas para operações com combustíveis líquidos - OPCIONAL

> Gás liquefeito é liquido, só para lembrar.

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$comb = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'cProdANP' => 123456789, //OBRIGATÓRIO Código de produto da ANP. codificação de produtos do SIMP
        // vide (http://www.anp.gov.br) [0-9]{9}
    'descANP' => 'jskjlskjljlksjlksjlksjlkjlkjsk', //OBRIGATÓRIO Descrição do Produto conforme ANP.
        // Utilizar a descrição de produtos do Sistema de Informações de Movimentação de Produtos
        // SIMP (http://www.anp.gov.br/simp/).
    'pGLP' => 23, //opcional Percentual do GLP derivado do petróleo no produto GLP (cProdANP=210203001).
        // Informar em número decimal o percentual do GLP derivado de petróleo no produto GLP. Valores 0 a 100.
    'pGNn' => 57, //opcional Percentual de gás natural nacional - GLGNn para o produto GLP (cProdANP=210203001).
        // Informar em número decimal o percentual do Gás Natural Nacional - GLGNn para o produto GLP. Valores de 0 a 100.
    'pGNi' => 20, //opcional Percentual de gás natural importado GLGNi para o produto GLP (cProdANP=210203001).
        // Informar em número decimal o percentual do Gás Natural Importado - GLGNi para o produto GLP. Valores de 0 a 100.
    'vPart' => 14.85, //opcional Valor de partida (cProdANP=210203001).
        // Deve ser informado neste campo o valor por quilograma sem ICMS. com duas casas decimais
    'CODIF' => 123, //opcional Código de autorização / registro do CODIF.
        // Informar apenas quando a UF utilizar o CODIF (Sistema de Controle do Diferimento do Imposto nas Operações
        // com AEAC - Álcool Etílico Anidro Combustível) [0-9]{1,21}
    'qTemp' => 27.3, //opcional Quantidade de combustível faturada à temperatura ambiente.
        // Informar quando a quantidade faturada informada no campo qCom (I10) tiver sido ajustada para
        // uma temperatura diferente da ambiente.
    'UFCons' => 'SP', //OBRIGATÓRIO Sigla da UF de Consumo
    'pBio' => 5, //opcional Percentual do índice de mistura do Biodiesel (B100) no Óleo Diesel B
        // instituído pelo órgão regulamentador
        //======== dados para CIDE opcional ===============
    'qBCProd' => 1000.33, //opcional BC do CIDE (Quantidade comercializada) até 4 decimais
    'vAliqProd' => 9.56, //opcional Alíquota do CIDE  (em reais) até 4 decimais
    'vCIDE' => 92.34, //opcional Valor do CIDE 2 decimais
];
$mk->tagcomb((object) $comb);
```

# tag encerrante
[Volta](#Métodos)

## function tagencerrante(object $enc): DOMElement    (SEM ALTERAÇÃO)
Node prod/comb/encerrante - Informações do grupo de encerrante - OPCIONAL

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$enc = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'nBico' => 12, //OBRIGATÓRIO Numero de identificação do Bico utilizado no abastecimento [0-9]{1,3}
    'nBomba' => 2, //opcional Numero de identificação da bomba ao qual o bico está interligado [0-9]{1,3}
    'nTanque' => 4, //OBRIGATÓRIO  Numero de identificação do tanque ao qual o bico está interligado [0-9]{1,3}
    'vEncIni' => '12123456', //OBRIGATÓRIO Valor do Encerrante no ínicio do abastecimento 0|0\.[0-9]{3}|[1-9]{1}[0-9]{0,11}(\.[0-9]{3})?
    'vEncFin' => '12345678', //OBRIGATÓRIO Valor do Encerrante no final do abastecimento  0|0\.[0-9]{3}|[1-9]{1}[0-9]{0,11}(\.[0-9]{3})?
];
$mk->tagencerrante((object) $enc);
```

# tag origComb
[Volta](#Métodos)

## function tagorigComb(object $orig): DOMElement    (SEM ALTERAÇÃO)
Node prod/comb/origComb - Grupo indicador da origem do combustível - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 30 registros por item da NFe

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$orig = [
    'item' => 1,  //OBRIGATÓRIO referencia ao item da NFe
    'indImport' => 0, //OBRIGATÓRIO Indicador de importação
            // 0 Nacional;
            // 1 Importado;
    'cUFOrig' => '35', //OBRIGATÓRIO UF de origem do produtor ou do importado
    'pOrig' => 100, //OBRIGATÓRIO Percentual originário para a UF
];
$mk->tagorigComb((object) $orig);
```

# tag RECOPI
[Volta](#Métodos)

## function tagRECOPI(object $rc): DOMElement    (SEM ALTERAÇÃO)
Node prod/nRECOPI - Reconhecimento e Controle de Papel Imune - OPCIONAL

> Sistema de Registro e Controle das Operações com Papel Imune provê o prévio reconhecimento da não incidência do imposto e o registro das operações realizadas com o papel destinado à impressão de livro, jornal ou periódico (papel imune)

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$rc = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'nRECOPI' => '01234567890123456789' //OBRIGATÓRIO Número do RECOPI [0-9]{20}
];
$mk->tagRECOPI((object) $rc);
```

# FIM das Informações específicas de produtos e serviços


# tag imposto
[Volta](#Métodos)

## function tagimposto(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto - Grupo de Impostos - OBRIGATÓRIO

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->vTotTrib = 0; //opcional Valor estimado total de impostos federais, estaduais e municipais 2 decimais
$mk->tagimposto($std);
```

## Grupo de dados relativos ao ICMS
> **Haverá um "choice" (escolha) entre os registros desse grupo, portanto apenas um será inserido no item da NFe**
> Choice (ICMSXX ou ICMSPart ou ICMSSN ou ICMSST)
> **E essa escolha será feita na sequência de inserção no XML, sendo usado o primeiro grupo encontrado, dentre os possíveis, portanto tenha atenção a isso !!** 


# tag ICMS
[Volta](#Métodos)

## function tagICMS(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/ICMS/ICMSxx - Grupo do ICMS - opcional

> NOTA: os campos serão usados conforme o CST indicado, e todos os campos que não pertencem ao CST indicado serão ignorados.

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO item da NFe 
$std->orig = 0; //OBRIGATÓRIO Origem da Mercadoria/Serviço
    //0 - Nacional, exceto as indicadas nos códigos 3 a 5;
    //1 - Estrangeira - Importação direta, exceto a indicada no código 6;
    //2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
    //3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%;
    //4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o Decreto-Lei n.º 288/1967 , e as Leis nºs 8.248/1991, 8.387/1991, 10.176/2001 e 11.484/2007;
    //5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
    //6 - Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução Camex e gás natural;
    //7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução Camex e gás natural.  
$std->CST = '00'; //OBRIGATÓRIO Código de Situação Tributária
    //00 - tributada integralmente.
    //02 - Tributação monofásica própria sobre combustíveis
    //10 - tributada e com cobrança do ICMS por substituição tributária.
    //15 - Tributação monofásica própria e com responsabilidade pela retenção sobre combustíveis
    //20 - tributada com redução de base de cálculo.
    //30 - isenta ou não tributada e com cobrança do ICMS por substituição tributária.
    //40 - isenta.
    //41 - não tributada.
    //50 - suspensão.
    //51 - diferimento (a exigência do preenchimento das informações do ICMS diferido fica a critério de cada UF).
    //53 - Tributação monofásica sobre combustíveis com recolhimento diferido
    //60 - cobrado anteriormente por substituição tributária.
    //61 - Tributação monofásica sobre combustíveis cobrada anteriormente
    //70 - tributada com redução de base de cálculo e com cobrança do ICMS por substituição tributária.
    //90 - outras (regime Normal).
$std->modBC = '3'; //OBRIGATÓRIO Modalidade de determinação da BC do ICMS
    //0 - Margem Valor Agregado (%).
    //1 - Pauta (Valor).
    //2 - Preço Tabelado Máx. (valor).
    //3 - Valor da operação
$std->vBC = '1200'; //OBRIGATÓRIO Valor da Base de Cálculo do ICMS
$std->pICMS = 10; //opcional Percentual de ICMS
$std->vICMS = 120; //opcional Valor do ICMS
$std->pFCP = null; //opcional Percentual do Fundo de Combate a Pobreza do ICMS
$std->vFCP = null; //opcional Valor do Fundo de Combate a Pobreza
$std->vBCFCP = null; //opcional Valor da Base de Cálculo do Fundo de Combate a Porbreza
$std->modBCST = null; //opcional Modalidade de determinação da base de cálculo do ICMS ST
    //0 - Preço tabelado ou máximo sugerido.
    //1 - Lista Negativa (valor).
    //2 - Lista Positiva (valor).
    //3 - Lista Neutra (valor).
    //4 - Margem Valor Agregado (%).
    //5 - Pauta (valor).
    //6 - Valor da Operação
$std->pMVAST = null; //opcional Percentual da margem de valor Adicionado do ICMS ST 
$std->pRedBCST = null; //opcional Percentual da Redução de Base de Cálculo do ICMS ST
$std->vBCST = null; //opcional Valor da Base de Calculo do ICMS ST
$std->pICMSST = null; //opcional Percentual do ICMS ST
$std->vICMSST = null; //opcional Valor do ICMS ST
$std->vBCFCPST = null; //opcional Valor da Base de Cálculo do Fundo de Combate a Pobreza do ICMS ST 
$std->pFCPST = null; //opcional Percentual do Fundo de Combate a Pobreza do ICMS ST
$std->vFCPST = null; //opcional Valor do Fundo de Combate a Pobreza do ICMS ST
$std->vICMSDeson = null; //opcional Valor do ICMS Desonerado
$std->motDesICMS = null; //opcional Motivo da Deseoneração do ICMS
    //3-Uso na agropecuária;
    //9-Outros;
    //12-Fomento agropecuário
$std->pRedBC = null; //opcional Percentual da Redução de Base de Cálculo do ICMS 
$std->vICMSOp = null; //opcional Valor do ICMS da Operação
$std->pDif = null; //opcional Percentual do diferemento
$std->vICMSDif = null; //opcional Valor do ICMS da diferido
$std->vBCSTRet = null; //opcional Valor da BC do ICMS ST retido anteriormente
$std->pST = null; //opcional Aliquota suportada pelo consumidor final
std->vICMSSTRet = null; //opcional Valor do ICMS ST retido anteriormente
$std->vBCFCPSTRet = null; //opcional Valor da Base de cálculo do FCP retido anteriormente por ST
$std->pFCPSTRet = null; //opcional Percentual de FCP retido anteriormente por substituição tributária
$std->vFCPSTRet = null; //opcional Valor do FCP retido por substituição tributária
$std->pRedBCEfet = null; //opcional Percentual de redução da base de cálculo efetiva
$std->vBCEfet = null; //opcional Valor da base de cálculo efetiva
$std->pICMSEfet = null; //opcional Alíquota do ICMS efetiva
$std->vICMSEfet = null; //opcional Valor do ICMS efetivo
$std->vICMSSubstituto = null; //opcional Valor do ICMS Próprio do Substituto cobrado em operação anterior
$std->vICMSSTDeson = null; //opcional 
$std->motDesICMSST = null; //opcional ,
$std->pFCPDif = null; //opcional 
$std->vFCPDif = null; //opcional 
$std->vFCPEfet = null; //opcional 
$std->pRedAdRem = null; //opcional 
$std->motRedAdRem = null; //opcional 
$std->qBCMono = null; //opcional 
$std->adRemICMS = null; //opcional 
$std->vICMSMono = null; //opcional 
$std->vICMSMonoOp = null; //opcional 
$std->adRemICMSReten = null; //opcional 
$std->qBCMonoReten = null; //opcional 
$std->vICMSMonoReten = null; //opcional 
$std->vICMSMonoDif = null; //opcional 
$std->qBCMonoRet = null; //opcional 
$std->vICMSMonoRet = null; //opcional 
$std->adRemICMSRet = null; //opcional 
$std->cBenefRBC = null; //opcional 
$std->indDeduzDeson = null; //opcional 
$mk->tagICMS($std);
```

# tag ICMSPart
[Volta](#Métodos)

## function tagICMSPart(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/ICMS/ICMSPart

> Partilha do ICMS entre a UF de origem e UF de destino ou a UF definida na legislação.
> Operação interestadual para consumidor final com partilha do ICMS  devido na operação entre a UF de origem e a UF do destinatário ou a UF definida na legislação. (Ex. UF da concessionária de entrega de veículos)

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$ic = [
    'item' => 1, //OBRIGATÓRIO item da NFe 
    'orig' => '0', //OBRIGATÓRIO Origem da Mercadoria/Serviço
        //0 - Nacional, exceto as indicadas nos códigos 3 a 5;
        //1 - Estrangeira - Importação direta, exceto a indicada no código 6;
        //2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
        //3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%;
        //4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o Decreto-Lei n.º 288/1967 , e as Leis nums 8.248/1991, 8.387/1991, 10.176/2001 e 11.484/2007;
        //5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
        //6 - Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução Camex e gás natural;
        //7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução Camex e gás natural. 
    'CST' => '10', //OBRIGATÓRIO Tributação do ICMS
        //10 - tributada e com cobrança do ICMS por substituição tributária.
        //90 - outras (regime Normal).
    'modBC' => 3, //OBRIGATÓRIO Modalidade de determinação da BC do ICMS
        //0 - Margem Valor Agregado (%);
        //1 - Pauta (valor);
        //2 - Preço Tabelado Máximo (valor);
        //3 - Valor da Operação.
    'vBC' => 100, //OBRIGATÓRIO Valor da Base de Cálculo do ICMSPart
    'pRedBC' => null, //opcional Percentual da Redução de Base de Cálculo
    'pICMS' => 18, //OBRIGATÓRIO Aliquota do ICMS
    'vICMS' => 18.00, //OBRIGATÓRIO Valor do ICMS
    'modBCST' => null,//opcional Modalidade de determinação da BC do ICMS ST
        //0 – Preço tabelado ou máximo sugerido;
        //1 - Lista Negativa (valor);
        //2 - Lista Positiva (valor);
        //3 - Lista Neutra (valor);
        //4 - Margem Valor Agregado (%);
        //5 - Pauta (valor).
        //6 - Valor da Operação
    'pMVAST' => null, //opcional Percentual da Margem de Valor Adicionado ICMS ST
    'pRedBCST' => null, //opcional Percentual de redução da BC ICMS ST
    'vBCST' => 0, //OBRIGATÓRIO Valor da BC do ICMS ST
    'pICMSST' => 0, //OBRIGATÓRIO Alíquota do ICMS ST
    'vICMSST' => 0, //OBRIGATÓRIO Valor do ICMS ST
    //subgrupo - os parámetros abaixo compõe um subgrupo se um for informado, os demais parametros também devem ser
    'vBCFCPST' => null, //opcional Valor da Base de cálculo do FCP retido por substituicao tributaria.
    'pFCPST' => null, //opcional Percentual de FCP retido por substituição tributária.
    'vFCPST' => null, //opcional Valor do FCP retido por substituição tributária.
    //fim subgrupo
    'pBCOp' => null, //OBRIGATÓRIO Percentual para determinação do valor  da Base de Cálculo da operação própria.
    'UFST' => null //OBRIGATÓRIO Sigla da UF para qual é devido o ICMS ST da operação.
];
$mk->tagICMSPart((object)$ic);
```

# tag ICMSST
[Volta](#Métodos)

## function tagICMSST(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/ICMS/ICMSST

> Grupo de informação do ICMSST devido para a UF de destino, nas operações interestaduais de produtos que tiveram retenção antecipada de ICMS por ST na UF do remetente. Repasse via Substituto Tributário.

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$ic = [
    'item' => 1, //OBRIGATÓRIO item da NFe 
    'orig' => '0', //OBRIGATÓRIO Origem da Mercadoria/Serviço
        //0 - Nacional, exceto as indicadas nos códigos 3 a 5;
        //1 - Estrangeira - Importação direta, exceto a indicada no código 6;
        //2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
        //3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%;
        //4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o Decreto-Lei nº 288/1967 , e as Leis nºs 8.248/1991, 8.387/1991, 10.176/2001 e 11.484/2007;
        //5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
        //6 - Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução Camex e gás natural;
        //7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução Camex e gás natural. 
    'CST' => '41', //OBRIGATÓRIO Tributação do ICMS
        //41 - Não Tributado.                                    
        //60 - Cobrado anteriormente por substituição tributária.
    'vBCSTRet' => 100, //OBRIGATÓRIO Informar o valor da BC do ICMS ST retido na UF remetente
    'vICMSSTRet' => 17, //OBRIGATÓRIO Informar o valor do ICMS ST retido na UF remetente (iv2.0))
    'vBCSTDest' => 100, //OBRIGATÓRIO Informar o valor da BC do ICMS ST da UF destino
    'vICMSSTDest' => 17, //OBRIGATÓRIO Informar o valor da BC do ICMS ST da UF destino (v2.0)
    //subgrupo
    'vBCFCPSTRet' => null, //opcional Informar o valor da Base de Cálculo do FCP retido anteriormente por ST.
    'pFCPSTRet' => null, //opcional Percentual relativo ao Fundo de Combate à Pobreza (FCP) retido por substituição tributária.
    'vFCPSTRet' => null, //opcional Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) retido por substituição tributária.
    //fim subgrupo
    'pST' => null, //opcional Aliquota suportada pelo consumidor final
    'vICMSSubstituto' => null, //opcional Valor do ICMS Próprio do Substituto cobrado em operação anterio
    //subgrupo
    'pRedBCEfet' => null, //opcional Percentual de redução da base de cálculo efetiva.
    'vBCEfet' => null, //opcional Valor da base de cálculo efetiva
    'pICMSEfet' => null, //opcional Alíquota do ICMS efetivo.
    'vICMSEfet' => null //opcional Valor do ICMS efetivo.
    //fim subgrupo
];
$mk->tagICMSST((object) $ic);
```

# tag ICMSSN
[Volta](#Métodos)

## function tagICMSSN(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/ICMS/ICMSSNXXX

> Tributação do ICMS pelo SIMPLES NACIONAL, usado apenas para empresas CRT 1 - Simples Nacional 
> NOTA: os parametros são opcionais ou obrigatórios dependendo do CSOSN selecionado vide documentação da NFe

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ic = [
    'item' => 1, //OBRIGATÓRIO item da NFe 
    'orig' => '0', //OBRIGATÓRIO Origem da Mercadoria/Serviço
        //0 - Nacional, exceto as indicadas nos códigos 3 a 5;
        //1 - Estrangeira - Importação direta, exceto a indicada no código 6;
        //2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
        //3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%;
        //4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o Decreto-Lei nº 288/1967 , e as Leis nºs 8.248/1991, 8.387/1991, 10.176/2001 e 11.484/2007;
        //5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
        //6 - Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução Camex e gás natural;
        //7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução Camex e gás natural. 
    'CSOSN' => '102', //OBRIGATÓRIO Código de Situação da Operação no Simples Nacional
        //101 - Tributação pelo Simples com Permissão de Crédito
        //102 - Tributação pelo Simples sem Permissão de Crédito
        //103 - Isenção do ICMS no Simples para receita bruta
        //201 - Simples Nacional com Permissão de Crédito e ICMS por Substituição Tributária
        //202 - Simples Nacional sem Permissão de crédito e com cobrança de ICMS por substituição tributária
        //203 - Isenção do ICMS no Simples para faixa da Receita Bruta e com cobrança de ICMS por substituição tributária
        //300 - Imunidade
        //400 - Não tributado pelo Simples
        //500 - ICMS cobrado anteriormente por substituição
        //900 - Outros. (neste código estão todas as operações que não se encaixam nos demais já citados).
    'pCredSN' => null, //opcional Alíquota aplicável de cálculo do crédito (Simples Nacional).
    'vCredICMSSN' => null, //opcional Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123 (Simples Nacional)
    'modBCST' => null, //opcional Modalidade de determinação da BC do ICMS ST
        //0 – Preço tabelado ou máximo sugerido;
        //1 - Lista Negativa (valor);
        //2 - Lista Positiva (valor);
        //3 - Lista Neutra (valor);
        //4 - Margem Valor Agregado (%);
        //5 - Pauta (valor). (v2.0)
        //6 - Valor da Operação
    'pMVAST' => null, //opcional Percentual da Margem de Valor Adicionado ICMS ST 
    'pRedBCST' => null, //opcional Percentual da Redução de BC do ICMS ST
    'vBCST' => null, //opcional Valor da BC do ICMS ST
    'pICMSST' => null, //opcional Alíquota do imposto do ICMS ST
    'vICMSST' => null, //opcional Valor do ICMS ST
    'vBCFCPST' => null, //opcional Valor da Base de Cálculo do FCP retido por Substituição Tributária
    'pFCPST' => null, //opcional Percentual do FCP retido por Substituição Tributária"
    'vFCPST' => null, //opcional Valor do FCP retido por Substituição Tributária
     'vBCSTRet' => null, //opcional Valor da BC do ICMS ST retido
     'pST' => null, //opcional Alíquota suportada pelo Consumidor Final
     'vICMSSTRet' => null, //opcional Valor do ICMS ST retido
     'vBCFCPSTRet' => null, //opcional Valor da Base de Cálculo do FCP retido anteriormente por Substituição Tributária
     'pFCPSTRet' => null, //opcional Percentual do FCP retido anteriormente por Substituição Tributária
     'vFCPSTRet' => null, //opcional Valor do FCP retido anteiormente por Substituição Tributária
     'modBC' => null, //opcional Modalidade de determinação da BC do ICMS
        //0 - Margem Valor Agregado (%);
        //1 - Pauta (valor);
        //2 - Preço Tabelado Máximo (valor);
        //3 - Valor da Operação
     'vBC' => null, //opcional Valor da BC do ICMS
     'pRedBC' => null, //opcional Percentual da Redução de BC
     'pICMS' => null, //opcional Alíquota do imposto
     'vICMS' => null, //opcional Valor do ICMS
     'pRedBCEfet' => null, //opcional Percentual de redução da base de cálculo efetiva
     'vBCEfet' => null, //opcional Valor da base de cálculo efetiva
     'pICMSEfet' => null, //opcional Alíquota do ICMS efetiva
     'vICMSEfet' => null, //opcional Valor do ICMS efetivo
     'vICMSSubstituto' => null //opcional Valor do ICMS próprio do Substituto
];
$mk->tagICMSSN((object)$ic);
```

# tag ICMSUFDest
[Volta](#Métodos)

## function tagICMSUFDest(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/ICMSUFDest

> Grupo a ser informado nas vendas interestarduais para consumidor final, não contribuinte de ICMS

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$ufd = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'vBCUFDest' => 200, //OBRIGATÓRIO Valor da Base de Cálculo do ICMS na UF do destinatário 2 decimais
    'vBCFCPUFDest' => 200, //opcional Valor da Base de Cálculo do FCP na UF do destinatário. 2 decimais
    'pFCPUFDest' => 2, //opcional Percentual adicional inserido na alíquota interna da UF de destino, relativo ao Fundo de Combate à Pobreza (FCP) naquela UF. até 4 decimais
    'pICMSUFDest' => 21.5, //OBRIGATÓRIO Alíquota adotada nas operações internas na UF do destinatário para o produto / mercadoria. até 4 decimais
    'pICMSInter' => 7, //OBRIGATÓRIO Alíquota interestadual das UF envolvidas 4.00 ou 7.00 ou 12.00
    //'pICMSInterPart' => 100, //DEFAULT 100 Percentual de partilha para a UF do destinatário
    'vFCPUFDest' => 3.45, //opcional Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF 2 decimais
    'vICMSUFDest' => 34.97, //OBRIGATÓRIO Valor do ICMS de partilha para a UF do destinatário 2 decimais
    //'vICMSUFRemet' => 0 //DEFAULT ZERO Valor do ICMS de partilha para a UF do remetente.
];
$mk->tagICMSUFDest((object)$ufd);
```

# tag IPI
[Volta](#Métodos)

## function tagIPI(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/IPI/IPITrib ou det/imposto/IPI/IPINT 

> Grupo de informações sobre o IPI

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$ipi = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'CNPJProd' => '12345678901234', //opcional CNPJ do produtor da mercadoria, quando diferente do emitente.
         // Somente para os casos de exportação direta ou indireta.
    'cSelo' => 'PICABOO', //opcional Código do selo de controle do IPI de 1 60 caracteres
    'qSelo' => 9999999999, //opcional Quantidade de selo de controle do IPI até 12 digitos
    'cEnq' => '108', //OBRIGATÓRIO Código de Enquadramento Legal do IPI (tabela a ser criada pela RFB) de 1 a 3 caracteres
    'CST' => '00', //OBRIGATÓRIO
    //IPITrib
        //00-Entrada com recuperação de crédito
        //49 - Outras entradas
        //50-Saída tributada
        //99-Outras saídas
    //IPINT
        //01-Entrada tributada com alíquota zero
        //02-Entrada isenta
        //03-Entrada não-tributada
        //04-Entrada imune
        //05-Entrada com suspensão
        //51-Saída tributada com alíquota zero
        //52-Saída isenta
        //53-Saída não-tributada
        //54-Saída imune
        //55-Saída com suspensão
    'vBC' => 200.00, //opcional Valor da BC do IPI 2 decimais
    'pIPI' => 5.00, //opcional Alíquota do IPI até 4 decimais
    'vIPI' => 10.00, //opcional Valor do IPI 2 decimais
    'qUnid' => 1000, //opcional Quantidade total na unidade padrão para tributação até 4 decimais
    'vUnid' => 0.2222 //opcional Valor por Unidade Tributável.
            // Informar o valor do imposto Pauta por unidade de medida até 4 decimais.
];
 $mk->tagIPI((object)$ipi);
```

# tag II
[Volta](#Métodos)

## function tagII(object $std): DOMElement    (SEM ALTERAÇÃO)
Note det/imposto/II

> Grupo de dados do Imposto de Importação
 
| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$ii = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'vBC' => 100.22, //OBRIGATÓRIO Base da BC do Imposto de Importação 2 decimais
    'vDespAdu' => 21.87, //OBRIGATÓRIO  Valor das despesas aduaneiras 2 decimais
    'vII' => 10.01, //OBRIGATÓRIO Valor do Imposto de Importação 2 decimais
    'vIOF' => 0.21 //OBRIGATÓRIO Valor do Imposto sobre Operações Financeiras 2 decimais
];
$mk->tagII((object) $ii);
```

# tag ISSQN
[Volta](#Métodos)

## function tagISSQN(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/ISSQN

> Grupo de informações do ISSQN

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |
 

```php
$iqn = [
        'item' => 1,  //OBRIGATÓRIO referencia ao item da NFe
        'vBC' => 200.00, //OBRIGATÓRIO Valor da BC do ISSQN 2 decimais
        'vAliq' => 5, //OBRIGATÓRIO Alíquota do ISSQN até 4 decimais
        'vISSQN' => 10, //OBRIGATÓRIO Valor da do ISSQN 2 decimais
        'cMunFG' => '12343567', //OBRIGATÓRIO Informar o município de ocorrência do fato gerador do ISSQN.
            // Utilizar a Tabela do IBGE (Anexo VII - Tabela de UF, Município e País).
            // “Atenção, não vincular com os campos B12, C10 ou E10” v2.0
        'cListServ' => '10.10', //OBRIGATÓRIO Informar o Item da lista de serviços da LC 116/03
            // em que se classifica o serviço.
        'vDeducao' => 2.00, //opcional Valor dedução para redução da base de cálculo 2 decimais
        'vOutro' => 1.00,  //opcional Valor outras retenções 2 decimais
        'vDescIncond' => 0,  //opcional Valor desconto incondicionado 2 decimais
        'vDescCond' => 0,  //opcional Valor desconto condicionado 2 decimais
        'vISSRet' => 0, //opcional Valor Retenção ISS 2 decimais
        'indISS' => 1, //OBRIGATÓRIO Exibilidade do ISS:
            //1-Exigível;
            //2-Não incidente;
            //3-Isenção;
            //4-Exportação;
            //5-Imunidade;
            //6-Exig.Susp. Judicial;
            //7-Exig.Susp. ADM
        'cServico' => '1ABRT82828', //opcional Código do serviço prestado dentro do município de 1 a 20 caracteres
        'cMun' => '1234567',  //opcional Código do Município de Incidência do Imposto
        'cPais' => '105',  //opcional Código de Pais de 1 a 4 digitos
        'nProcesso' => 'ABC10000001992981',  //opcional Número do Processo administrativo ou judicial
            // de suspenção do processo até 30 caracteres
        'indIncentivo' => 2 //OBRIGATÓRIO Indicador de Incentivo Fiscal. 1=Sim; 2=Não
    ];
    $mk->tagISSQN((object)$iqn);
```

# tag PIS
[Volta](#Métodos)

## function tagPIS(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/PIS/PISAliq ou det/imposto/PIS/PISQtde ou det/imposto/PIS/PISNT ou det/imposto/PIS/PISOutr

> Grupo de dados do PIS

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->CST = '03';  //OBRIGATÓRIO Código de Situação Tributária do PIS
        //PISAliq
            //01 – Operação Tributável - Base de Cálculo = Valor da Operação Alíquota Normal (Cumulativo/Não Cumulativo)
            //02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota Diferenciada)
        //PISQtde
            //03 - Operação Tributável - Base de Calculo = Quantidade Vendida x Alíquota por Unidade de Produto;
        //PISNT
            //04 - Operação Tributável - Tributação Monofásica - (Alíquota Zero);
            //06 - Operação Tributável - Alíquota Zero;
            //07 - Operação Isenta da contribuição;
            //08 - Operação Sem Incidência da contribuição;
            //09 - Operação com suspensão da contribuição;
        //PISOutr
            //49 - Outras Operações de Saída
            //50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno
            //51 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno
            //52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação
            //53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
            //54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
            //55 - Operação com Direito a Crédito - Vinculada a Receitas Não Tributadas no Mercado Interno e de Exportação
            //56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno e de Exportação
            //60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno
            //61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno
            //62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação
            //63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
            //64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
            //65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação
            //66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno e de Exportação
            //67 - Crédito Presumido - Outras Operações
            //70 - Operação de Aquisição sem Direito a Crédito
            //71 - Operação de Aquisição com Isenção
            //72 - Operação de Aquisição com Suspensão
            //73 - Operação de Aquisição a Alíquota Zero
            //74 - Operação de Aquisição sem Incidência da Contribuição
            //75 - Operação de Aquisição por Substituição Tributária
            //98 - Outras Operações de Entrada
            //99 - Outras Operações.
$std->vBC = 1200; //opcional Valor da BC do PIS 2 decimais
$std->pPIS = 6; //opcional Alíquota do PIS (em percentual) até 4 decimais
$std->vPIS = 12.00; //opcional Valor do PIS 2 decimais
$std->qBCProd = 12; //opcional Quantidade Vendida  (NT2011/004) até 4 decimais
$std->vAliqProd = 1; //opcionalAlíquota do PIS (em reais) (NT2011/004) até 4 decimais
$mk->tagPIS($std);
```

# tag PISST
[Volta](#Métodos)

## function tagPISST(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/PISST

> Grupo de informações sobre o PISST

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$pst = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'vBC' => 389.98, //opcional Valor da BC do PIS ST
    'pPIS' => 4.33, //opcional Alíquota do PIS ST (em percentual)
    'vPIS' => 20.22, //OBRIGATÓRIO Valor do PIS ST
    'qBCProd' => 2000, //opcional Quantidade Vendida
    'vAliqProd' => 12, //opcional Alíquota do PIS ST (em reais)
    'indSomaPISST' => 1, //opcional Indica se o valor do PISST compõe o valor total da NF-e
];
$mk->tagPISST((object) $pst);
```

# tag COFINS
[Volta](#Métodos)

## function tagCOFINS(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/COFINS/COFINSAliq 
ou det/imposto/COFINS/COFINSQtde 
ou det/imposto/COFINS/COFINSNT
ou det/imposto/COFINS/COFINSOutr

> Grupo de informações sobre COFINS
> Alguns parâmetros são opcionais, dependendo do CST 

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->CST = '99'; //OBRIGATÓRIO   //OBRIGATÓRIO Código de Situação Tributária do COFINS
        //COFINSAliq
            //01 – Operação Tributável - Base de Cálculo = Valor da Operação Alíquota Normal (Cumulativo/Não Cumulativo)
            //02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota Diferenciada)
        //COFINSQtde
            //03 - Operação Tributável - Base de Calculo = Quantidade Vendida x Alíquota por Unidade de Produto;
        //COFINSNT
            //04 - Operação Tributável - Tributação Monofásica - (Alíquota Zero);
            //06 - Operação Tributável - Alíquota Zero;
            //07 - Operação Isenta da contribuição;
            //08 - Operação Sem Incidência da contribuição;
            //09 - Operação com suspensão da contribuição;
        //COFINSOutr
            //49 - Outras Operações de Saída
            //50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno
            //51 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno
            //52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação
            //53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
            //54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
            //55 - Operação com Direito a Crédito - Vinculada a Receitas Não Tributadas no Mercado Interno e de Exportação
            //56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno e de Exportação
            //60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno
            //61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno
            //62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação
            //63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno
            //64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação
            //65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação
            //66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno e de Exportação
            //67 - Crédito Presumido - Outras Operações
            //70 - Operação de Aquisição sem Direito a Crédito
            //71 - Operação de Aquisição com Isenção
            //72 - Operação de Aquisição com Suspensão
            //73 - Operação de Aquisição a Alíquota Zero
            //74 - Operação de Aquisição sem Incidência da Contribuição
            //75 - Operação de Aquisição por Substituição Tributária
            //98 - Outras Operações de Entrada
            //99 - Outras Operações.
$std->vBC = 10000; //opcional Valor de Base de calculo do COFINS
$std->pCOFINS = 7; //opcional Aliquota do COFINS
$std->vCOFINS = 12.00; //opcional Valor do COFINS
$std->qBCProd = 12; //opcional Quantidade Vendida
$std->vAliqProd = 1; //opcional Alíquota do COFINS (em reais)
$mk->tagCOFINS($std);
```

# tag COFINSST
[Volta](#Métodos)

## function tagCOFINSST(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/COFINSST

> Grupo de informações do COFINSST

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$cst = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'vBC' => 2000.33, //OBRIGATÓRIO Valor da BC do COFINS ST 2 decimais
    'vCOFINS' => 14.22, //OBRIGATÓRIO Valore do COFINS ST
    'pCOFINS' => 7.1111, //opcional Alíquota do COFINS ST(em percentual) até 4 decimais
    'qBCProd' => 2039.3882, //opcional Quantidade Vendida até 4 decimais
    'vAliqProd' => 12.2342, //opcional Alíquota do COFINS ST(em reais)  até 4 decimais
    'indSomaCOFINSST' => 1 //opcional Indica se o valor da COFINS ST compõe o valor total da NFe
            //0-não
            //1-sim
];
$mk->tagCOFINSST((object) $cst);
```

# tag IS
[Volta](#Métodos)

## function tagIS(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
Node det/imposto/IS - Grupo de informações sobre o Imposto Seletivo - OPCIONAL

> Este é o grupo referente ao "imposto do pecado" será aplicado a produtos específicos
> IMPORTANTE: Esse imposto NÃO SUBSTITUI O IPI, o ipi permanecerá mesmo quanado a Reforma Tributaria do Consumo estiver concluída.
> Mas é importanta acompanhar as aliquotas do IPI na TIPI 

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |


```php
$is = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'CSTIS' => '123', //OBRIGATÓRIO Código Situação Tributária do Imposto Seletivo 3 digitos
    'cClassTribIS' => '111111', //OBRIGATÓRIO Código de Classificação Tributária do IBS e da CBS 6 digitos
    'vBCIS' => 200.00, //OBRIGATÓRIO Valor do BC 2 decimais
    'pIS' => 33.3333, //OBRIGATÓRIO Alíquota do Imposto Seletivo (percentual) até 4 decimais
    'pISEspec' => 45, //opcional Alíquota do Imposto Seletivo (por valor)  até 4 decimais
    'uTrib' => 'KG', //OBRIGATÓRIO Unidade de medida apropriada especificada em Lei Ordinaria para fins
          // de apuração do Imposto Seletivo de 1 a 6 caracteres
    'qTrib' => 100, //OBRIGATÓRIO Quantidade com base no campo uTrib informado até 4 decimais
    'vIS' => 200.00 //OBRIGATÓRIO Valor do Imposto Seletivo calculado 2 decimais
];
$mk->tagIS((object) $is);
```

# tag IBSCBS
[Volta](#Métodos)

## function tagIBSCBS(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
Node det/imposto/IBSCBS
Node det/imposto/IBSCBS/gIBSCBS/gIBSUF
Node det/imposto/IBSCBS/gIBSCBS/gIBSUF/gDif
Node det/imposto/IBSCBS/gIBSCBS/gIBSUF/gDevTrib
Node det/imposto/IBSCBS/gIBSCBS/gIBSUF/gRed
Node det/imposto/IBSCBS/gIBSCBS/gIBSMun
Node det/imposto/IBSCBS/gIBSCBS/gIBSMun/gDif
Node det/imposto/IBSCBS/gIBSCBS/gIBSMun/gDevTrib
Node det/imposto/IBSCBS/gIBSCBS/gIBSMun/gRed
Node det/imposto/IBSCBS/gIBSCBS/gCBS
Node det/imposto/IBSCBS/gIBSCBS/gCBS/gDif
Node det/imposto/IBSCBS/gIBSCBS/gCBS/gDevTrib
Node det/imposto/IBSCBS/gIBSCBS/gCBS/gRed

> Grupo CBS IBS Completo
> Nota: subgrupo gIBSCBS fará um "choice" (escolha) com gIBSCBSMono e gTransfCred
 
> Nota: NT2025.002v1.30 - PL_010_V1.30, novo campo, indicar apenas usando o PL_010_V1.30, null nos demais casos 
> - indDoacao

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ibscbs = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'CST' => '000', //OBRIGATÓRIO CST IBS/CBS 3 digitos
        // 000 - Tributação integral
        // 010 - Tributação com alíquotas uniformes - operações setor financeiro
        // 011 - Tributação com alíquotas uniformes reduzidas em 60% ou 30%
        // 200 - Alíquota zero, Alíquota zero apenas CBS e reduzida em 60% para IBS, reduzida em 80%, 70%, 60%, 50%, 40%, 30%
        // 210 - Alíquota reduzida em 50% com redutor de base de cálculo, reduzida em 70% com redutor de base de cálculo
        // 220 - Alíquota fixa
        // 221 - Alíquota fixa proporcional
        // 400 - Isenção
        // 410 - Imunidade e não incidência
    'cClassTrib' => '111111', //OBRIGATÓRIO
    'indDoacao' => null, //opcional Indica a natureza da operação de doação, orientando a apuração e a geração de débitos ou
                         //estornos conforme o cenário **[PL_010_V1.30]** somente aceita null ou 1
    //######### subgrupo gIBSCBS 
    'vBC' => 100, //opcional Base de cálculo do IBS e CBS 13v2. Se este campo for declarado, alguns outros parametros serão OBRIGATÓRIOS  
         //dados IBS Estadual
    'vIBS' => null, //opcional soma de vIBSUF e vIBSMun, se não informado será calculado pela classe     
    'gIBSUF_pIBSUF' => 10, //opcional Alíquota do IBS de competência das UF 3v2-4, OBRIGATÓRIO se vBC for informado
        //removido 'gIBSUF_vTribOp' => 2, //opcional Valor bruto do tributo na operação 13v2
    'gIBSUF_pDif' => 5, //opcional Percentual do diferimento 3v2-4
    'gIBSUF_vDif' => 30, //opcional Valor do Diferimento 13v2
    'gIBSUF_vDevTrib' => 10, //opcional Valor do tributo devolvido 13v2
    'gIBSUF_pRedAliq' => 10, //opcional Percentual da redução de alíquota 3v2-4
    'gIBSUF_pAliqEfet' => 20, //opcional Alíquota Efetiva do IBS de competência das UF que será aplicada a BC 3v2-4
    'gIBSUF_vIBSUF' => 10, //opcional Valor do IBS de competência da UF 13v2
        //dados IBS Municipal
    'gIBSMun_pIBSMun' => 2.3454, //opcional Alíquota do IBS de competência do município 3v2-4,OBRIGATÓRIO se vBC for informado
        //removido 'gIBSMun_vTribOp' => 2, //opcional Valor bruto do tributo na operação 13v2
    'gIBSMun_pDif' => 10, //opcional Percentual do diferimento 3v2-4
    'gIBSMun_vDif' => 22, //opcional Valor do Diferimento 13v2
    'gIBSMun_vDevTrib', //opcional Valor do tributo devolvido 13v2
    'gIBSMun_pRedAliq' => 3, //opcional Percentual da redução de alíquota 3v2-4
    'gIBSMun_pAliqEfet' => 12.34, //opcional Alíquota Efetiva do IBS de competência do Município que será aplicada a BC 3v2
    'gIBSMun_vIBSMun' => 40, //opcional Valor do IBS de competência do Município 13v2
        // dados CBS (imposto federal)
    'gCBS_pCBS' => 20, //opcional Alíquota da CBS 3v2-4, OBRIGATÓRIO se vBC for informado
    'gCBS_pDif' => 10, //opcional Percentual do diferimento 3v2-4
    'gCBS_vDif' => 20, //opcional Valor do Diferimento 13v2
    'gCBS_vDevTrib' => 10, //opcional Valor do tributo devolvido 13v2
    'gCBS_pRedAliq' => 20, //opcional Percentual da redução de alíquota 3v2-4
    'gCBS_pAliqEfet' => 3.54, //opcional Alíquota Efetiva da CBS que será aplicada a Base de Cálculo 3v2
    'gCBS_vCBS' => 21.83, //opcional Valor da CBS 13v2
];
$mk->tagIBSCBS((object) $ibscbs);
```

# tag IBSCBSTribRegular
[Volta](#Métodos)

## function tagIBSCBSTribRegular(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
Node det/imposto/IBSCBS/gIBSCBS/gTribRegular

> Grupo de informações da Tributação Regular. Informar como seria a tributação caso não cumprida a condição resolutória/suspensiva.
> Este subgrupo pertence a gIBSCBS e somente será incluso caso gIBSCBS exista
> Exemplo 1: Art. 442, §4. Operações com ZFM e ALC. Exemplo 2: Operações com suspensão do tributo.
> NOTA: quando o CST do IBSCBS for 550 é OBRIGATÓRIA essa tag

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$reg = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'CSTReg' => '123', //OBRIGATÓRIO Código de Situação Tributária do IBS e CBS 3 digitos
    'cClassTribReg' => '111111', //OBRIGATÓRIO Código de Classificação Tributária do IBS e CBS 6
    'pAliqEfetRegIBSUF' => 10.1234, //OBRIGATÓRIO Valor da alíquota do IBS da UF 3v2-4
    'vTribRegIBSUF' => 100, //OBRIGATÓRIO Valor do Tributo do IBS da UF 13v2
    'pAliqEfetRegIBSMun' => 5.1234, //OBRIGATÓRIO Valor da alíquota do IBS do Município 3v2-4
    'vTribRegIBSMun' => 50, //OBRIGATÓRIO Valor do Tributo do IBS do Município 13v2
    'pAliqEfetRegCBS' => 10.1234, //OBRIGATÓRIO Valor da alíquota da CBS 3v2-4
    'vTribRegCBS' => 100, //OBRIGATÓRIO Valor do Tributo da CBS 13v2
];
$mk->tagIBSCBSTribRegular((object) $reg);
```

# tag gTribCompraGov
[Volta](#Métodos)

## function taggTribCompraGov(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária))
Node det/imposto/IBSCBS/gIBSCBS/gTribCompraGov

> Grupo de informações da composição do valor do IBS e da CBS em compras governamental
> Este subgrupo pertence a gIBSCBS e somente será incluso caso gIBSCBS exista
> NOTA: esse grupo somente será informado em caso de compra governamental

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$cg = [
    'item' => 1,
    'pAliqIBSUF' => 10, //OBRIGATÓRIO Alíquota do IBS de competência do Estado
    'vTribIBSUF' => 20.12, //OBRIGATÓRIO Valor que seria devido a UF, sem aplicação do Art. 473. da LC 214/2025
    'pAliqIBSMun' => 1, //OBRIGATÓRIO Alíquota do IBS de competência do Município
    'vTribIBSMun' => 2.01, //OBRIGATÓRIO Valor que seria devido a CBS, sem aplicação do Art. 473. da LC 214/2025
    'pAliqCBS' => 10, //OBRIGATÓRIO Alíquota do CBS
    'vTribCBS' => 20.12, //OBRIGATÓRIO Valor que seria devido a CBS, sem aplicação do Art. 473. da LC 214/2025
];
$mk->taggCompraGov((object) $cg);
```


# tag IBSCBSMono
[Volta](#Métodos)

## function tagIBSCBSMono(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
Node det/imposto/IBSCBS/gIBSCBSMono

> Grupo de Informações do IBS e CBS em operações com imposto monofásico
> Este grupo é um "choice" (escolha) com gIBSCBS, caso exista gIBSCBS esse grupo não será incluso na NFe
> NOTA: caso seja declarado o parâmetro do subgrupo, todos os parâmetros do mesmo subgrupo serão obrigatórios

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$mono = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    
    //############# subgrupo monofasico
    'qBCMono' => 1.00, //opcional Quantidade tributada na monofasia  Se este parâmetro for declarado, todos do subgrupo serão OBRIGATÓRIOS
    'adRemIBS' => 10.00, //opcional Alíquota ad rem do IBS
    'vIBSMono' => 100.00, //opcional Valor do IBS monofásico
    'adRemCBS' => 2.00, //opcional Alíquota ad rem da CBS
    'vCBSMono' => 200.00, //opcional Valor do CBS monofásico
    //############# fim subgrupo monofasico
    
    //############# subgrupo monofasico sujeito a retenção
    'qBCMonoReten' => 1.00, //opcional Quantidade tributada na monofasia sujeita a retenção. Se este parâmetro for declarado, todos do subgrupo serão OBRIGATÓRIOS
    'adRemIBSReten' => 10.00, //opcional Alíquota ad rem do IBS sujeita a retenção
    'vIBSMonoReten' => 10.00, //opcional Valor do IBS monofásico sujeito a retenção
    'adRemCBSReten' => 1.00, //opcional Alíquota ad rem da CBS sujeita a retenção
    'vCBSMonoReten' => 10.00, //opcional Valor do CBS monofásico sujeito a retenção
    //############# fim subgrupo monofasico sujeito a retenção
    
    //############# subgrupo monofasico retido anteriormente
    'qBCMonoRet' => 1.00, //opcional  Se este parâmetro for declarado, todos do subgrupo serão OBRIGATÓRIOS
    'adRemIBSRet' => 1.00, //opcional Quantidade tributada na monofasia retida anteriormente
    'vIBSMonoRet' => 1.00, //opcional Valor do IBS monofásico retido anteriormente
    'adRemCBSRet' => 1.00, //opcional Alíquota ad rem da CBS retida anteriormente
    'vCBSMonoRet' => 1.00, //opcional Valor do CBS monofásico retido anteriormente
    //############# fim subgrupo monofasico retido
    
    //############# subgrupo monofasico diferimento
    'pDifIBS' => 2.00, //opcional Percentual do diferimento do imposto monofásico. 3v2-4. Se este parâmetro for declarado todos abaixo serão OBRIGATÓRIOS
    'vIBSMonoDif' => 2.00, //opcionalValor do IBS monofásico diferido 13v2
    'pDifCBS' => 1.00, //opcional Percentual do diferimento do imposto monofásico. 3v2-4
    // Se declarado todos abaixo serão OBRIGATÓRIOS
    'vCBSMonoDif' => 1.00, //opcional Valor do IBS monofásico diferido 13v2
    //############# subgrupo monofasico diferimento
    
    'vTotIBSMonoItem' => 111.00, //OBRIGATÓRIO Total de IBS Monofásico 13v2
    'vTotCBSMonoItem' => 212.00//OBRIGATÓRIO Total da CBS Monofásica 13v2
];
$mk->tagIBSCBSMono((object) $mono);
```

# tag gTransfCred
[Volta](#Métodos)

## function taggTranfCred(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
Node det/imposto/IBSCBS/gTranfCred

> Grupo de Informações de transferência de Crédito
> Este grupo é um "choice" (escolha) com gIBSCBS e gIBSCBSMono, caso exista gIBSCBS ou gIBSCBSMono esse grupo não será incluso na NFe

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$transf = [
    'item' => 1, //OBRIGATÓRIO
    'vIBS' => 200.00, //OBRIGATÓRIO Valor do IBS a ser transferido 13v2
    'vCBS' => 35.23, //OBRIGATÓRIO Valor do CBS a ser transferido 13v2
];
$mk->taggTranfCred((object) $transf);
```

# tag gAjusteCompet
[Volta](#Métodos)

## function taggAjusteCompet(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária NT2025.002_v1.30)
Node det/imposto/IBSCBS/gAjusteCompet

> Nota: Somente para PL_010_V1.30 ou superior, não informar caso não esteja validando com esse PL 

> Grupo de Ajuste de Competência


| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->competApur = '2025-09'; //OBRIGATÓRIO Ano e mês referência do período de apuração (AAAA-MM), informar período atual ou retroativo 
$std->vIBS = 100.34; //OBRIGATÓRIO Valor do IBS
$std->vCBS = 234.59; //OBRIGATÓRIO Valor da CBS

$mk->taggAjusteCompet($std);
``` 

# tag gEstornoCred
[Volta](#Métodos)
## function taggEstornoCred(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária NT2025.002_v1.30)
Node det/imposto/IBSCBS/gEstornoCred

> Obs: a obrigatoriedade ou vedação do preenchimento deste grupo está condicionada ao indicador “ind_gEstornoCred” da tabela de cClassTrib do IBS e da CBS.

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->vIBSEstCred = 34.22; //OBRIGATÓRIO Valor do IBS a ser estornado
$std->vCBSEstCred = 87.41; //OBRIGATÓRIO Valor da CBS a ser estornada

$mk->taggEstornoCred($std);
``` 

# tag gCredPresOper
[Volta](#Métodos)

## function taggCredPresOper(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária NT2025.002_v1.30)
Node det/imposto/IBSCBS/gCredPresOper

> Nota: Somente para PL_010_V1.30 ou superior, não informar caso não esteja validando com esse PL

> Grupo de Crédito Presumido da Operação
> - Obs_1: a permissão ou vedação do preenchimento deste grupo está condicionada ao indicador “ind_gCredPresOper” da tabela de cClassTrib do IBS e da CBS.
> - Obs_2: O valor "1" do indicador “ind_gCredPresOper” significa que o contribuinte pode utilizar o crédito presumido, sem obrigatoriedade (permite, mas não exige).


| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->vBCCredPres = 1234.99; //OBRIGATÓRIO
$std->cCredPres = '04'; //OBRIGATÓRIO
//subgrupo referente IBS, um dos campos for informado TODOS os outros devem ser também
$std->ibs_pCredPres = 50.00; //opcional
$std->ibs_vCredPres = 123.899; //opcional
$std->ibs_vCredPresCondSus = 12.3456; //opcional
//subgrupo referente CBS, um dos campos for informado TODOS outros devem ser também
$std->cbs_pCredPres = 50.00; //opcional
$std->cbs_vCredPres = 432.444; //opcional
$std->cbs_vCredPresCondSus = 32.983; //opcional
$mk->taggCredPresOper($std);
``` 


# tag gCredPresIBSZFM
[Volta](#Métodos)

## function taggCredPresIBSZFM(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
Node det/imposto/IBSCBS/gCredPresIBSZFM

> Grupo de informações de Crédito Presumido em operações com a Zona Franca de Manaus
> Classificação de acordo com o art. 450, § 1º, da LC 214/25 para o cálculo do crédito presumido na ZFM

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$zfm = [
    'item' => 1, //OBRIGATÓRIO
    'competApur' = '2025-09'; //opcional => OBRIGATÓRIO para PL_010_v1.30
    'tpCredPresIBSZFM' => 0, //OBRIGATÓRIO Tipo de classificação de acordo com o art. 450, § 1º, da LC 214/25 para o
                             // cálculo do crédito presumido na ZFM
            //0 - Sem Crédito Presumido
            //1 - Bens de consumo final (55%)
            //2 - Bens de capital (75%)
            //3 - Bens intermediários (90,25%)
            //4 - Bens de informática e outros definidos em legislação (100%)
    'vCredPresIBSZFM' => 0 //opcional Valor do crédito presumido calculado sobre o saldo devedor apurado 13v2
            //É obrigatório para nota de crédito com tpNFCredito = 02 - Apropriação de crédito presumido de IBS sobre
            // o saldo devedor na ZFM (art. 450, § 1º, LC 214/25)
            //Vedado para documentos que não sejam nota de crédito com tpNFCredito = 02 - Apropriação de crédito
            // presumido de IBS sobre o saldo devedor na ZFM (art. 450, § 1º, LC 214/25)
];
$mk->taggCredPresIBSZFM((object) $zfm);
```

# tag IBSCredPres
[Volta](#Métodos)

## function tagIBSCredPres(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
### REMOVIDO pela NT2025.002_v1.30 - PL_010_V1.30, não usar com essa PL  
Node det/imposto/IBSCBS/gIBSCBS/gIBSCredPres

> Grupo de Informações do Crédito Presumido referente ao IBS, quando aproveitado pelo emitente do documento.
> Este subgrupo pertence a gIBSCBS e somente será incluso caso gIBSCBS exista
> NOTA: é necessário usar a Tabela de Crédito Presumido fornecida pela Receita Federal, pois depende da operação sendo realizada 
> vide https://dfe-portal.svrs.rs.gov.br/DFE/TabelaCreditoPresumido 

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$cred = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'cCredPres' => '11', //OBRIGATÓRIO Código de Classificação do Crédito Presumido 2 caracteres
    'pCredPres' => 2.3234, //OBRIGATÓRIO Percentual do Crédito Presumido 3v2-4
    'vCredPres' => 22.30, //OBRIGATÓRIO Valor do Crédito Presumido 13v2
    'vCredPresCondSus' => 0, //OBRIGATÓRIO Valor do Crédito Presumido em condição suspensiva 13v2
];
$mk->tagIBSCredPres((object) $cred);
```

# tag CBSCredPres
[Volta](#Métodos)

## function tagCBSCredPres(object $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
### REMOVIDO pela NT2025.002_v1.30 - PL_010_V1.30, não usar com essa PL
Node det/imposto/IBSCBS/gIBSCBS/gCBSCredPres

> Grupo de Informações do Crédito Presumido referente ao CBS, quando aproveitado pelo emitente do documento.
> Este subgrupo pertence a gIBSCBS e somente será incluso caso gIBSCBS exista
> NOTA: é necessário usar a Tabela de Crédito Presumido fornecida pela Receita Federal, pois depende da operação sendo realizada
> vide https://dfe-portal.svrs.rs.gov.br/DFE/TabelaCreditoPresumido

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$cred = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'cCredPres' => '11', //OBRIGATÓRIO Código de Classificação do Crédito Presumido 2 caracteres
    'pCredPres' => 2.1111, //OBRIGATÓRIO Percentual do Crédito Presumido 3v2-4
    'vCredPres' => 12.34, //OBRIGATÓRIO Valor do Crédito Presumido 13v2
    'vCredPresCondSus' => 9.00, //OBRIGATÓRIO Valor do Crédito Presumido em condição suspensiva 13v2
];
$mk->tagCBSCredPres((object) $cred);
```

# tag impostoDevol
[Volta](#Métodos)

## function tagimpostoDevol(object $std): DOMElement    (SEM ALTERAÇÃO)
Node det/imposto/impostoDevol

> Grupo de infomrções sobre IPI devolvido
 
| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$idev = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'pDevol' => 85.00, //OBRIGATRÓRIO Percentual da mercadoria devolvida 2 devimais max = 100.00
    'vIPIDevol' => 0.00 ////OBRIGATRÓRIO Valor do IPI devolvido 2 decimais
];
$mk->tagimpostoDevol((object) $idev);
```

# tag total
[Volta](#Métodos)

## function tagTotal(stdClass $std): ?float   (NOVO MÉTODO Reforma Tributária)
Node infNFe/total

> NOTA: Caso não seja informada essa tag o valor de vNFTot, que represneta o valor Total da NF considerando os impostos 
> por fora IBS, CBS e IS, NÃO SERA INCLUIDO NA NF-e.

> NOTA: Por enquanto esse valor é opcional e não deve ser informado, porém em 2026 poderá ser necessário informar.
 
> NOTA: Esse valor NÃO SERÁ nem calculado, nem inserido automaticamente na NFe, enquanto for opcional. 
 
> Dados dos totais da NF-e

| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual | 

```php
$total = [
    'vNFtot' => 1000, //opcional, popula a tag total/vNFTot 
];
$mk->tagTotal((object) $idev);
```

# tag ICMSTot
[Volta](#Métodos)

## function tagICMSTot(stdClass $std): DOMElement    (SEM ALTERAÇÃO)
Node infNFe/total/ICMSTot

> Cria tag com totais de ICMS, IPI, PIS, COFINS (opcional)


| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual | 

```php
$std = new \stdClass();
$std->vBC = 2000;
$std->vICMS = 360;
$std->vICMSDeson = 20;
$std->vICMSUFDest = 3;
$std->vFCPUFDest = 2;
$std->vICMSUFRemet = 4;
$std->vFCP = 2;
$std->vBCST = 20;
$std->vST = 1.50;
$std->vFCPST = 2.22;
$std->vFCPSTRet = 0.23;
$std->qBCMono = null;
$std->vICMSMono = null;
$std->qBCMonoReten = null;
$std->vICMSMonoReten = null;
$std->qBCMonoRet = null;
$std->vICMSMonoRet = null;
$std->vProd = 2000;
$std->vFrete = 100;
$std->vSeg = 5;
$std->vDesc = 1;
$std->vII = 12;
$std->vIPI = 23;
$std->vIPIDevol = 9;
$std->vPIS = 6;
$std->vCOFINS = 25;
$std->vOutro = 11;
$std->vNF = 2345.83;
$std->vTotTrib = 798.12;

$mk->tagICMSTot($std);
```

# tag ISSQNTot
[Volta](#Métodos)

## function tagISSQNTot(stdClass $std): DOMElement    (SEM ALTERAÇÃO)

> Cria tag com totais de ISSQN (opcional)


| Parâmetro |   Tipo   | Descrição                                            |
|:----------|:--------:|:-----------------------------------------------------|
| $std      | stdClass | contêm os dados dos campos, nomeados conforme manual | 

```php
$std = new \stdClass();
$std->vServ = 123.33;
$std->vBC = 123.33;
$std->vISS = 0;
$std->vPIS = 0 ;
$std->vCOFINS = 0;
$std->dCompet = '2025-03-11';
$std->vDeducao = 0;
$std->vOutro = 0;
$std->vDescIncond = null;
$std->vDescCond = null;;
$std->vISSRet = 1.23;
$std->cRegTrib = 6;

$mk->tagISQNTot($std);
```
 

# tag ISTot
[Volta](#Métodos)

## function tagISTot(stdClass $std): DOMElement   (NOVO MÉTODO Reforma Tributária)

> Cria tag com totais do Imposto Seletivo IS (opcional) $${\color{red}(RTC)}$$

# tag IBSCBSTot
[Volta](#Métodos)

## function tagIBSCBSTot(stdClass $std): DOMElement    (NOVO MÉTODO Reforma Tributária)
> Cria tag com os totais do IBS e CBS (opcional) $${\color{red}(RTC)}$$

> Nota: os totais serão calculados automaticamente mas se desejar passar um ou mais valores, basta informar na stdClass

```php
$std = (object) [
    'vBCIBSCBS',
    'gIBS_vIBS',
    'gIBS_vCredPres',
    'gIBS_vCredPresCondSus',
    'gIBSUF_vDif',
    'gIBSUF_vDevTrib',
    'gIBSUF_vIBSUF',
    'gIBSMun_vDif',
    'gIBSMun_vDevTrib',
    'gIBSMun_vIBSMun',
    'gCBS_vDif',
    'gCBS_vDevTrib',
    'gCBS_vCBS',
    'gCBS_vCredPres',
    'gCBS_vCredPresCondSus',
    'gMono_vIBSMono',
    'gMono_vCBSMono',
    'gMono_vIBSMonoReten',
    'gMono_vCBSMonoReten',
    'gMono_vIBSMonoRet',
    'gMono_vCBSMonoRet',
    'gEstonoCred_vIBSEstCred',
    'gEstonoCred_vCBSEstCred',
];
$mk->tagIBSCBSTot($std);
```


# tag retTrib
[Volta](#Métodos)

## function tagretTribt(stdClass $std): DOMElement    (SEM ALTERAÇÃO)

> Cria tag com as retenções de Tributos (opcional)



# tag transp
[Volta](#Métodos)

## function tagtransp(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/transp

> Dados dos transportes da NF-e

```php
$tr = [
    'modFrete' => 0 //OBRIGATÓRIO
        //0 - Contratação do Frete por conta do Remetente (CIF);
        //1 - Contratação do Frete por conta do destinatário/remetente (FOB);
        //2 - Contratação do Frete por conta de terceiros;
        //3 - Transporte próprio por conta do remetente;
        //4 - Transporte próprio por conta do destinatário;
        //9 - Sem Ocorrência de transporte.
];
$mk->tagtransp((object) $tr);
```

# tag transporta
[Volta](#Métodos)

## function tagtransporta(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/transp/transporta

> Dados do transportador

```php
$std = [
    'CNPJ' => '01234123456789', //opcional
    'CPF' => '12345678901', //opcional
    'xNome' => 'Joãozinho', //opcional 2 a 60 caracteres
    'xEnder' => 'Rua Direita do Sul, 1245 - fundos',
    'IE' => '123456',
    'xMun' => 'São Vito',
    'UF' => 'SP'
];
$mk->tagtransporta((object)$std);
```

# tag rettransp
[Volta](#Métodos)

## function tagrettransp(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/transp/retTransp

> Dados da retenção  ICMS do Transporte

```php
$std = [
    'vServ' => 1500.00,
    'vBCRet' => 1500.00,
    'pICMSRet' => 10.0,
    'vICMSRet' => 150.00,
    'CFOP' => '1111',
    'cMunFG' => 3512345,
];
$mk->tagrettransp((object)$std);
```

# tag veictransp
[Volta](#Métodos)

## function tagveictransp(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/transp/veicTransp

> Dados do veículo (choice com VAGÃO ou BALSA)

```php
$std = [
    'placa' => 'XYZ9999',
    'UF' => 'SP',
    'RNTC' => '123-AZV-222',
];
$mk->tagveictransp((object)$std);
```

# tag reboque
[Volta](#Métodos)

## function tagreboque(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/transp/reboque

> Dados do reboque  (choice com VAGÃO ou BALSA)
> NOTA MULTIPLAS ENTRADAS - Podem ocorrer até 5 reboques por veículo

```php
$std = new \stdClass();
$std->placa = 'ABC0011';
$std->UF = 'RJ';
$std->RNTC = 'R0011';
$mk->tagreboque($std);
```

# tag vagao
[Volta](#Métodos)

## function tagvagao(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/transp/vagao

> Identificação do vagão (será inserido caso não exista nem veiculo e nem reboques)

```php
$std = new \stdClass();
$std->vagao = 'HTRE-20930';
$mk->tagvagao($std);
```

# tag balsa
[Volta](#Métodos)

## function tagbalsa(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/transp/balsa

> Identificação da balsa (será inserido caso não exista nem veiculo, nem reboques, e nem vagão)

```php
$std = new \stdClass();
$std->balsa = '111-ARR-STS';
$mk->tagbalsa($std);
```

# tag vol
[Volta](#Métodos)

## function tagvol(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/vol

> Dados dos volumes 
> NOTA MULTIPLAS ENTRADAS - Podem ocorrer até 5000 registros de volumes por NFe

```php
$std = [
    'item' => 1, //identificação do volume
    'qVol' => 12,
    'esp' => 'CAIXAS',
    'marca' => 'RR',
    'nVol' => '001,002,003,006.008,231,2990,392,42,788,9874,054',
    'pesoL' => 222.30,
    'pesoB' => 225.60,
];
$mk->tagvol((object)$std);
```

# tag lacres
[Volta](#Métodos)

## function taglacres(object $std) DOMElement    (SEM ALTERAÇÃO)
Node infNFe/vol/lacres

> Dados dos lacres dos volumes
> NOTA MULTIPLAS ENTRADAS - Podem ocorrer até 5000 registros de lacres por volume

```php
$std = new \stdClass();
$std->item = 1;
$std->nLacre = 'LCR9099',
$mk->taglacres($std);
```

# tag fat
[Volta](#Métodos)

## function tagfat(object $std) DOMElement    (SEM ALTERAÇÃO)
Node 
```php
```

# tag dup
[Volta](#Métodos)


## function tagdup(object $std) DOMElement    (SEM ALTERAÇÃO)

```php
```

# tag pag
[Volta](#Métodos)

## function tagpag(object $std) DOMElement    (SEM ALTERAÇÃO)

```php
```

# tag detpag
[Volta](#Métodos)

## function tagdetpag(object $std) DOMElement    (SEM ALTERAÇÃO)

```php
```

# tag intermed
[Volta](#Métodos)

## function tagintermed(object $std) DOMElement    (SEM ALTERAÇÃO)

```php
```


```php
```


```php
```

```php
```


```php
```

```php
```


```php
```

```php
```

```php
```

```php
```

```php
```



