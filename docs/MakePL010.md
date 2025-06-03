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

> NOTA MULTIPLAS ENTRADAS - Podem ocorrer até 999 referencias por NFe, entre NFe, NF, CTe e ECF.

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

## function tagretirada(object $ret): DOMElement   (SEM ALTERAÇÃO)
Node retirada - Identificação do Local de Retirada (informar apenas quando for diferente do endereço do remetente) - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagentrega(object $ent): DOMElement    (SEM ALTERAÇÂO)
Node entrega - Identificação do Local de Entrega (informar apenas quando for diferente do endereço do destinatário) - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagautxml(object $aut): DOMElement   (SEM ALTERAÇÃO)
Node autXML - Pessoas autorizadas para o download do XML da NF-e - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - Podem haver até 10 registros de pessoas autorizadas. Então podem repetidos até 10 vezes essa tag.

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$aut = [
    'CNPJ' => '01234123456789', //este é o campo prioritário caso sejam informados os dois apenas o CNPJ será considerado
    'CPF' => null
];
$mk->tagautxml((object)$aut);
```

## funtion tagprod(object $prod): DOMElement    (ALTERAÇÂO nos PARÂMETROS)
Node det/prod - Produtos - OBRIGATÓRIO

>  NOTA MULTIPLAS ENTRADAS - a tag dev/prod pode ocorrer até 990 vezes 

> Nota: campo novo relativo a Reforma Tributária
> - vItem - Valor total do Item, correspondente à sua participação no total da nota. A soma dos itens deverá corresponder ao total da nota.
 
| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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
$std->xPed = '12345';
$std->nItemPed = 1;
$std->nFCI = '12345678-1234-1234-1234-123456789012';
$std->vItem = null; //opcional Valor total do Item, correspondente à sua participação no total da nota.
    // A soma dos itens deverá corresponder ao total da nota. com duas decimais
$mk->tagprod($std);
```

## funtion taginfAdProd(object $inf): DOMElement     (SEM ALTERAÇÃO)
Node dev/prod/infAdProd - Informações adicionais do produto (norma referenciada, informações complementares, etc) - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$inf = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe 1 a 990
    'infAdProd' => 'Informação especifica sobre o item do produto' //OBRIGATÓRIO de 1 a 500 caracteres
];
$mk->taginfAdProd((object) $inf);
```

## function tagObsItem(object $obs): DOMElement   (NOVO MÉTODO)
Node prod/infAdProd/obsItem - Grupo de observações de uso livre (para o item da NF-e) - OPCIONAL

> NOTA este método substitui o anterior tagprodObsCont()

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagDFeReferenciado(object $ref): DOMElement   (NOVO MÉTODO Reforma Tributária)
Node det/DFeReferenciado - Referenciamento de item de outros DFe - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$ref = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe 1 a 990
    'chaveAcesso' => '12345678901234567890123456789012345678901234', //OBRIGATÓRIO Chave de acesso do DF-e referenciado
    'nIem' => 2, //opcional Número do item do documento referenciado.
];
$mk->tagDFeReferenciado((object) $ref);
```

## function taggCred(object $gc): DOMElement    (NOVO MÉTODO Reforma Tributária)
Node prod/gCred - Grupo de informações sobre o CréditoPresumido - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 4 registros desse grupo por item da NFe

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$gc = [
    'item' => 1, //OBRIGATÓRIO
    'cCredPresumido' => '12AFCJE7', //OBRIGATÓRIO com 8 ou 10 caracteres
    'pCredPresumido' => 1.00, //OBRIGATÓRIO percentual com 2 ou 4 decimais
    'vCredPresumido' => 1.00 //OBRIGATÓRIO valor com 2 decimais
];
$mk->taggCred((object)$gc);
```

## function tagnve(object $std): DOMElement      (SEM ALTERAÇÃO)
Node prod/NVE - Nomenclatura de Valor aduaneiro e Estatístico - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 8 registros desse grupo por item da NFe

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'NVE' => 'AZ3456' //OBRIGATÓRIO [A-Z]{2}[0-9]{4}
];
$mk->tagnve((object)$std);
```

## function tagDI(object $std): DOMElement   (SEM ALTERAÇÃO)
Node prod/DI - Delcaração de Importação - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 100 registros desse grupo por item da NFe
> Obrigatório em NFe de Importação 

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->nDI = '123049'; //OBRIGATÓRIO  Número do Documento de Importação (DI, DSI, DIRE, DUImp) de 1 à 15 caracteres
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

## function tagadi(object $std): DOMElement    (SEM ALTERAÇÃO)
Node prod/DI/adi - Adições da DI OBRIGATÓRIA se existir a DI - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 999 registros para cada DI declarada por item da NFe
> Obrigatório em NFe de Importação

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagdetExport(objetc $std): DOMElement     (SEM ALTERAÇÃO)
Node prod/detExport - etalhe da exportação - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 500 registros por item 
> Usado em NFe de Exportação apenas
 
| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagrastro(object $std): DOMElement   (SEM ALTERAÇÃO)
Node prod/rastro - Rastreabilidade - OPCIONAL
> NOTA MULTIPLAS ENTRADAS - Dados de rastreabilidade uso em medicamentos, podem ocorrer até 500 repetições por item da NFe

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual | 
 
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

> **Haverá um "choice" (escolha) entre os registros desse grupo portanto apenas um será inserido no item da NFe**
> **E essa escolha será feita ne sequencia de inserção no XML, portanto tenha atenção a isso !!** 

## function tagveicProd(object $veic): DOMElement  (SEM ALTERAÇÃO)
Node prod/veicProd - Veículos novos - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagmed(object $std): DOMElement   (SEM ALTERAÇÃO)
Node prod/med - Detalhamento de Medicamentos e de matérias-primas farmacêuticas - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagarma(object $arma): DOMElement   (SEM ALTERAÇÃO)
Node prod/arma - Detalhamento de Armamento - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## functicon tagcomb(object $comb)   (SEM ALTERAÇÃO)
Node prod/comb - Informar apenas para operações com combustíveis líquidos - OPCIONAL

> Gás liquefeito é liquido, só para lembrar.

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagencerrante(object $enc): DOMElement    (SEM ALTERAÇÂO)
Node prod/comb/encerrante - Informações do grupo de encerrante - OPCIONAL

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagorigComb(object $orig): DOMElement    (SEM ALTERAÇÂO)
Node prod/comb/origComb - Grupo indicador da origem do combustível - OPCIONAL

> NOTA MULTIPLAS ENTRADAS - podem ocorrer até 30 registros por item da NFe

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

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

## function tagRECOPI(object $rc): DOMElement    (SEM ALTERAÇÂO)
Node prod/nRECOPI - Reconhecimento e Controle de Papel Imune - OPCIONAL

> Sistema de Registro e Controle das Operações com Papel Imune provê o prévio reconhecimento da não incidência do imposto e o registro das operações realizadas com o papel destinado à impressão de livro, jornal ou periódico (papel imune)

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$rc = [
    'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
    'nRECOPI' => '01234567890123456789' //OBRIGATÓRIO Número do RECOPI [0-9]{20}
];
$mk->tagRECOPI((object) $rc);
```

# FIM das Informações específicas de produtos e serviços


## function tagimposto(object $std): DOMElement    (SEM ALTERAÇÂO)
Node det/imposto - Grupo de Impostos - OBRIGATÓRIO

| Parâmetro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stdClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
$std->vTotTrib = 0; //opcional Valor estimado total de impostos federais, estaduais e municipais 2 decimais
$mk->tagimposto($std);
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


