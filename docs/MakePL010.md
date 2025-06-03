# CONSTRUÇÃO DO XML com dados do schema PL_010v1

> **IMPORTANTE:** Houveram modificações nos métodos e em alguns campos desses métodos para a criação do XML.
 
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

> NOTA: como forma de diminuir o tamanho do código a classe foi dividida em traits para os principais blocos construtivos do XML, mas houve um aumento nas propriedades da Make:class e portanto deve gerar um leve aumento no uso de memória para a construção do XML.

# Métodos

> Abaixo estão TODOS os métodos da classe Make:class com seus respectivos parâmetros em ordem de entrada. 

> **ALTERAÇÃO na construção da Make:class**
## function __construct(string $schema)         (ALTERADO com PARÂMETRO de criação)
Método construtor. Instancia a classe 

- Alteração no método: foi inclusa a inserção da identificação do schema a ser usado na classe construtora Make::class, para melhor identificar a versão a ser utilizada para a construção do XML e evitar erros durante o período de transição.

```php
$schema = 'PL_010_V1';

$mk = new Make($schema); //se não informado o schema será usado o PL_009_V4, o conjunto de xsd atualmente em uso.
$mk->setOnlyAscii(false); //opções true remove todos a acentuação ou false (default) mantêm os acentos nos textos
$mk->setCheckGtin(true); //opções true ativa a verificação do numero GTIN ou false desativa esse validação  
```

## function taginfNFe($std):DOMElement    (SEM ALTERAÇÂO)
Node principal - OBRIGATÓRIO

> NOTA: **se o parâmetro $std->Id não for passado a chave será criada e inclusa e poderá ser recuperada no parâmetro chNFe da classe,**
**De outra forma se a chave for passada no parâmetro $std->Id e estiver incorreta, um erro será inserido na proriedade errors.**

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->versao = '4.00'; //versão do layout (string)
$std->Id = 'NFe35150271780456000160550010000000021800700082'; //se o Id de 44 digitos não for passado será gerado automaticamente
$std->pk_nItem = null; //deixe essa variavel sempre como NULL

$mk->taginfNFe($std);
```

## function tagide(object $ide):DOMElement   (ALTERAÇÂO nos PARÂMETROS)
Node ide - identificação da NFe - OBRIGATÓRIO

> Nota: os campos novos relativos a Reforma Tributária listados abaixo, serão ignorados se usar o schema PL_009_V4.
> - cMunFGIBS
> - tpNFDebito
> - tpNFCredito

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ide = [
    'cUF' => 12, //OBRIGATÒRIO numero da UF
    'cNF' => null, //opcional 8 digitos max, será preenchido automaticamente com zeros a esquerda
                   //se deixado com null, será inserido um valor aleatório de acordo com as regras da SEFAZ
                   //se forem informados mais de 8 digitos o valor será truncado para 8 digitos
    'natOp' => 'REMESSA P/ INDUSTRIALIZAÇÃO', //OBRIGATÒRIO max 60 caracteres
    'mod' => 55, //OBRIGATÒRIO modelo 55 ou 65
    'serie' => 1, //OBRIGATÒRIO série normal 0-889 SCAN 900-999
    'nNF' => 100, //OBRIGATÒRIO até 9 digitos
    'dhEmi' => null, //opcional se deixado com null, será inserida a data e hora atual para a UF
    'dhSaiEnt' => null, //opcional
                        //CUIDADO ao inserir deve corresponder a data e hora correta para a UF e deve ser maior ou igual a dhEmi
    'tpNF' => 1, //OBRIGATÒRIO 0-entrada; 1-saída
    'idDest' => 3, //OBRIGATÒRIO 1-Interna;2-Interestadual;3-Exterior
    'cMunFG' => 2111300, //OBRIGATÒRIO 7 digitos IBGE Código do Município de Ocorrência do Fato Gerador
    'cMunFGIBS' => 2111300, //opcional 7 digitos IBGE apenas PL_010 em diante
                            //cMunFGIBS somente deve ser preenchido quando indPres = 5 (Operação presencial, fora do estabelecimento),
                            //e não tiver endereço do destinatário (tag <enderDest>) ou local de entrega (tag <entrega>).
    'tpImp' => 1, //OBRIGATÒRIO
        //0-sem DANFE;
        //1-DANFe Retrato;
        //2-DANFe Paisagem;
        //3-DANFe Simplificado;
        //4-DANFe NFC-e;
        //5-DANFe NFC-e em mensagem eletrônica
    'tpEmis' => 1, //OBRIGATÒRIO
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
    'tpAmb' => 2, //OBRIGATÒRIO 1-produçao 2-homologação
    'finNFe' => 1, //OBRIGATÒRIO
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
    'indFinal' => 0, //OBRIGATÒRIO 0 Normal; 1 Consumidor final;
    'indPres' => 9, //OBRIGATÒRIO
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

## function tagEmit(object $emit):DOMElement    (SEM ALTERAÇÃO)
Node emit - Informações do Emitente - OBRIGATÓRIO

> NOTA: a partir de 2026 o CNPJ poderá ser ALFA NUMÉRICO !!

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagEnderemit(object $ender):DOMElement)   (SEM ALTERAÇÃO)
Node enderEmit - Endereço do Emitente da NFe - OBRIGATÓRIO

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

> Podem ocorrer até 999 referencias por NFe, entre NFe, NF, CTe e ECF.

## function tagrefNFe(object $ref):DOMElement   (SEM ALTERAÇÃO)
Node NFref/refNFe - NFe referenciada - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ref = [
    'refNFe' => '12345678901234567890123456789012345678901234' //OBRIGATÓRIO chave de 44 digitos
];
$mk->tagrefNFe((object)$ref);
```

## function tagrefNF(object $nf):DOMElement     (SEM ALTERAÇÃO)
Node NFref/refNF - NFe referenciada - OPCIONAL

> Esta tag está em desuso pois as NF de papel estão sendo substituídas pos documentos eletrônicos.

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagrefNFP(object $nfp):DOMElement    (SEM ALTERAÇÃO)
Node NFref/refNFP - NFe de Produtor Rural referenciada - OPCIONAL

> Esta tag está em desuso pois as NF de papel estão sendo substituídas pos documentos eletrônicos.

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagrefCTe(object $cte):DOMElement     (SEM ALTERAÇÃO)
Node NFref/refCTe - CTe Conhecimento de Transporte referenciada - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$cte = [
    'refCTe' => '11111111111111111111111111111111111111111111'
];
$mk->tagrefCTe((object)$cte);
```

## function tagrefECF(object $ecf):DOMElement  (SEM ALTERAÇÃO)
Node NFref/refECF - Cupom Fiscal vinculado à NF-e - OPCIONAL

> Esta tag está em desuso, pois os ECF estão sendo substituídos por NFCe

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function taggCompraGov(object $gcg): DOMElement       (NOVO MÉTODO)  
Node PL_010 - Reforma Tributária - Compra Governamental - OPCIONAL

> Esta tag somente será inserida quando schema usado for o PL_010

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$gcg = [
    'tpEnteGov' => 1, //OBRIGATÓRIO identificação do ente governamental
        //1 União
        //2 Estados
        //3 Distrito Federal
        //4 Municípios
    'pRedutor' => 10.0000 //OBRIGATÓRIO Percentual de redução de alíquota em compra governamental
];
$mk->taggCompraGov((object)$gcg);
```

## function tagdest(object $dest): DOMElement  (SEM ALTERAÇÃO)
Node dest - Identificação do Destinatário - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagenderdest(object $end): DOMElement   (SEM ALTERAÇÃO)
Node enderdest - Endereço do Destinatário - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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
