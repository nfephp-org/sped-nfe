<?php

error_reporting(E_ERROR);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\Common\Certificate;
use NFePHP\Common\Exception\ValidatorException;
use NFePHP\Common\Signer;
use NFePHP\Common\Validator;
use NFePHP\NFe\MakeDev;

try {
    $schema = 'PL_010_V1'; //PL_010_V1
    $mk = new MakeDev($schema);
    $mk->setOnlyAscii(false);
    $mk->setCheckGtin(true);

    //############################## TAG <infNFe> OBRIGATÓRIA #########################################################
    $inf = [
        'Id' => null, //opcional id da NFe, se deixado em branco será gerado automaticamente
        'versao' => '4.00' //OBRIGATÓRIO indicar a versão do documento
    ];
    $infNFe = $mk->taginfNFe((object)$inf);

    //############################## TAG <ide> OBRIGATÓRIA #########################################################
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
        //06=Pagamento antecipado
        //07=Perda em estoque
        'tpNFCredito' => '01', //opcional apenas PL_010 em diante
        //01 = Multa e juros
        //02 = Apropriação de crédito presumido de IBS sobre o saldo devedor na ZFM (art. 450, § 1º, LC 214/25)
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

    //############################## TAG <emit> OBRIGATÓRIA #########################################################
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
        'CNPJ' => '12345678901234', //opcional [0-9]{14} ##### NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2} ####
        'CPF' => '12345678901', //opcional [0-9]{11} - se os dois campos forem inclusos o CNPJ tem prioridade
    ];
    $mk->tagEmit((object)$emi);

    //############################## TAG <emit> OBRIGATÓRIA #########################################################
    $end = [
        'xLgr' => 'RUA 10',
        'nro' => '897',
        'xCpl' => 'LJ 01',
        'xBairro' => 'Sto Antonio',
        'cMun' => 2111300,
        'xMun' => 'São Luis',
        'UF' => 'MA',
        'CEP' => '65091514',
        'cPais' => 1058,
        'xPais' => 'Brasil',
        'fone' => '9820677300',
    ];
    $mk->tagenderEmit((object)$end);

    //############################## TAG <NFref> opcional #########################################################
    $ref = [
        'refNFe' => '12345678901234567890123456789012345678901234'
    ];
    $refNFe = $mk->tagrefNFe((object)$ref);
    $ref = [
        'refNFe' => ' 22222222222222222222222222222222222222221111'
    ];
    $refNFe = $mk->tagrefNFe((object)$ref);

    //refNF OPCIONAL
    $nf = [
        'cUF' => 35,
        'AAMM' => 1801,
        'CNPJ' => '12345678901234', //NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
        'mod' => '01',
        'serie' => 0,
        'nNF' => 123456789
    ];
    $refNF = $mk->tagrefNF((object)$nf);

    //refNF OPCIONAL
    $nf = [
        'cUF' => 35,
        'AAMM' => 1801,
        'CNPJ' => '12345678901234', //NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
        'mod' => '01',
        'serie' => 0,
        'nNF' => 6789
    ];
    $refNF = $mk->tagrefNF((object)$nf);

    //refNFP OPCIONAL
    $nfp = [
        'cUF' => 35,
        'AAMM' => 1801,
        //'CNPJ' => '12345678901234', //NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
        'CPF' => '12345678901',
        'IE' => '123456',
        'mod' => '04',
        'serie' => 0,
        'nNF' => 9999
    ];
    $refNF = $mk->tagrefNFP((object)$nfp);

    //refCTe OPCIONAL
    $cte = [
        'refCTe' => '11111111111111111111111111111111111111111111'
    ];
    $refNFe = $mk->tagrefCTe((object)$cte);

    //refCTe OPCIONAL
    $cte = [
        'refCTe' => '22222222222222222222222222222222222222222222'
    ];
    $refNFe = $mk->tagrefCTe((object)$cte);

    //refECF OPCIONAL
    $ecf = [
        'mod' => '2D',
        'nECF' => '012',
        'nCOO' => 678901
    ];
    $refNF = $mk->tagrefECF((object)$ecf);

    //############################## TAG <gCompraGov> opcional Grupo de Compras Governamentais #######################
    $gcg = [
        'tpEnteGov' => 1, //OBRIGATÓRIO
        //1 União
        //2 Estados
        //3 Distrito Federal
        //4 Municípios
        'pRedutor' => 10.0000, //OBRIGATÓRIO Percentual de redução de alíquota em compra governamental
        'tpOperGov' => 1
        //1 Fornecimento
        //2 Recebimento do pagamento, conforme fato gerador do IBS/CBS definido no Art. 10 § 2º
    ];
    $gcgov = $mk->taggCompraGov((object)$gcg);

    //############################## TAG <gPagAntecipado> opcional Grupo de notas de antecipação de pagamento #########
    $ref = [
        'refNfe' => [
            '12345678901234567890123456789012345678901234',
            '12345678901234567890123456789012345678901234',
            '12345678901234567890123456789012345678901234',
            '12345678901234567890123456789012345678901234',
            '12345678901234567890123456789012345678901234',
        ]
    ];
    $gpagant = $mk->taggPagAntecipado((object) $ref);

    //############################## TAG <dest> opcional #######################
    $dest = [
        'xNome' => 'Eu Ltda',
        'CNPJ' => '12345678901234', //NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
        'CPF' => '12345678901',
        'idEstrangeiro' => null,
        'indIEDest' => 9,
        'IE' => null,
        'ISUF' => '12345679',
        'IM' => 'XYZ6543212',
        'email' => 'seila@seila.com.br'
    ];
    $dest = $mk->tagdest((object)$dest);

    //enderDest OPCIONAL
    $end = [
        'xLgr' => 'Estrada do Canguçu',
        'nro' => 'km 12',
        'xCpl' => null,
        'xBairro' => 'Vila Escondida',
        'cMun' => '9999999',
        'xMun' => 'Apratos',
        'UF' => 'EX',
        'CEP' => '00999999',
        'cPais' => 1600,
        'xPais' => 'China',
        'fone' => '1111111111'
    ];
    $ret = $mk->tagenderdest((object)$end);

    //############################## TAG <retirada> opcional #######################
    //retirada OPCIONAL
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
    $tret = $mk->tagretirada((object)$ret);

    //############################## TAG <entrega> opcional #######################
    //entrega OPCIONAL
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
    $tent = $mk->tagentrega((object)$ent);


    //############################## TAG <autXML> opcional #######################
    //autXML OPCIONAL até 10 ocorrências no maximo
    $aut = [
        'CNPJ' => '01234123456789',
        'CPF' => '12345678901'
    ];
    $taut = $mk->tagautxml((object)$aut);
    //autXML OPCIONAL
    $aut = [
        'CNPJ' => '12345678901234',
        'CPF' => '012345678901'
    ];
    $taut = $mk->tagautxml((object)$aut);


    //############################## TAG <prod> OBRIGATÓRIA #####################################################
    //até 990 ocorrências no maximo
    //prod OBRIGATÓRIA
    $std = new stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe 1 a 990
    $std->cProd = '23qq'; //OBRIGATÓRIO de 1 à 60 caracteres
    $std->cEAN = "SEM GTIN";//OBRIGATÓRIO SEM GTIN|[0-9]{0}|[0-9]{8}|[0-9]{12,14}
    $std->cBarra = "SEM GTIN";//opcional de 3 à 30 caracteres
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
    $std->indBemMovelUsado = null; //opcional
        // Somente para fornecimentos de bem móvel usado adquirido de pessoa física que não seja contribuinte
        // ou que seja inscrita como MEI. 1 - Bem Móvel Usado ou null
    $std->xPed = '12345';
    $std->nItemPed = 1;
    $std->nFCI = '12345678-1234-1234-1234-123456789012';
    $std->vItem = null; //opcional Valor total do Item, correspondente à sua participação no total da nota.
        // A soma dos itens deverá corresponder ao total da nota. com duas decimais
    $prod = $mk->tagprod($std);

    //############################## TAG <prod/infAdProd> opcional #################################################
    //Informações adicionais do produto (norma referenciada, informações complementares, etc)
    $inf = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe 1 a 990
        'infAdProd' => 'Informação especifica sobre o item do produto' //OBRIGATÓRIO de 1 a 500 caracteres
    ];
    $mk->taginfAdProd((object) $inf);

    //############################## TAG <prod/infAdProd/obsItem> opcional #################################################
    //Grupo de observações de uso livre (para o item da NF-e)
    $obs = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe 1 a 990
        'obsCont_xCampo' => 'nome', //opcional nome do campo de 1 a 20 caracteres
        'obsCont_xTexto' => 'informação', //opcional informação do campo de 1 a 60 caracteres
        'obsFisco_xCampo' => 'nome', //opcional nome do campo de 1 a 20 caracteres
        'obsFisco_xTexto' => 'informação', //opcional informação do campo de 1 a 60 caracteres
    ];
    $mk->tagObsItem((object) $obs);

    //############################## TAG <det/DFeReferenciado> opcional ##############################################
    //Documento Fiscal Eletrônico Referenciado
    $ref = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe 1 a 990
        'chaveAcesso' => '12345678901234567890123456789012345678901234', //OBRIGATÓRIO Chave de acesso do DF-e referenciado
        'nIem' => 2, //opcional Número do item do documento referenciado.
    ];
    $mk->tagDFeReferenciado((object) $ref);

    //############################## TAG <prod/gCred> opcional #####################################################
    // Grupo de informações sobre o CréditoPresumido até 4 ocorrencias sobre o mesmo item
    $gc = [
        'item' => 1, //OBRIGATÓRIO
        'cCredPresumido' => '12AFCJE7', //OBRIGATÓRIO com 8 ou 10 caracteres
        'pCredPresumido' => 1.00, //OBRIGATÓRIO percentual com 2 ou 4 decimais
        'vCredPresumido' => 1.00 //OBRIGATÓRIO valor com 2 decimais
    ];
    $mk->taggCred((object)$gc);
    $gc = [
        'item' => 1, //OBRIGATÓRIO
        'cCredPresumido' => '1234567890', //OBRIGATÓRIO com 8 ou 10 caracteres
        'pCredPresumido' => 2.0000, //OBRIGATÓRIO percentual com 2 ou 4 decimais
        'vCredPresumido' => 2.00 //OBRIGATÓRIO valor com 2 decimais
    ];
    $mk->taggCred((object)$gc);

    //############################## TAG <prod/NVE> opcional #####################################################
    //Nomenclatura de Valor aduaneiro e Estatístico podem ocorrer até no máximo 8 repetições
    //nve OPCIONAL
    $std = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'NVE' => 'AZ3456' //OBRIGATÓRIO [A-Z]{2}[0-9]{4}
    ];
    $mk->tagnve((object)$std);
    //nve OPCIONAL
    $std = [
        'item' => 1,  //OBRIGATÓRIO referencia ao item da NFe
        'NVE' => 'AA4777'  //OBRIGATÓRIO [A-Z]{2}[0-9]{4}
    ];
    $mk->tagnve((object)$std);

    //############################## TAG <prod/DI> opcional #####################################################
    //Delcaração de Importação podem ter até 100 DI por item da NFe
    //DI OPCIONAL
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

    //############################## TAG <prod/DI/adi> #####################################################
    //Adições da DI OBRIGATÓRIA se existir a DI até 999 adi para cada DI
    //adi OPCIONAL
    $std = new \stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->nDI = '123049'; //OBRIGATÓRIO referencia à DI
    $std->nAdicao = 1; //opcional Número da Adição [1-9]{1}[0-9]{0,2}
    $std->nSeqAdic = 1; //OBRIGATÓRIO Número seqüencial do item [1-9]{1}[0-9]{0,4}
    $std->cFabricante = 'ZZZZZZ'; //OBRIGATÓRIO Código do fabricante estrangeiro de 1 à 60 caracteres
    $std->vDescDI = 10.00; //opcional Valor do desconto do item até duas decimais
    $std->nDraw = null; //opcional Número do ato concessório de Drawback de 1 à 20 caracteres
    $adi = $mk->tagadi($std);

    //adi OPCIONAL
    $std = new \stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->nDI = '123049'; //OBRIGATÓRIO referencia à DI
    $std->nAdicao = 2; //opcional Número da Adição [1-9]{1}[0-9]{0,2}
    $std->nSeqAdic = 2; //OBRIGATÓRIO Número seqüencial do item [1-9]{1}[0-9]{0,4}
    $std->cFabricante = 'ZZZZZZ'; //OBRIGATÓRIO Código do fabricante estrangeiro de 1 à 60 caracteres
    $std->vDescDI = null; //opcional Valor do desconto do item até duas decimais
    $std->nDraw = null; //opcional Número do ato concessório de Drawback de 1 à 20 caracteres
    $di = $mk->tagadi($std);

    //############################## TAG <prod/detExport> opcional #####################################################
    //Detalhe da exportação até 500 ocorrências
    //detexport OPCIONAL
    $std = new \stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->nDraw = '029309'; //opcional Número do ato concessório de Drawback de 1 à 20 caracteres
    $std->nRE = '123456789012'; //opcional Registro de exportação [0-9]{0,12}
    $std->chNFe = '12345678901234567890123456789012345678901234'; //opcional Chave de acesso da NF-e recebida
    // para exportação campo OBRIGATÓRIO se nRE for informado
    $std->qExport = 12455.9000; //opcional Quantidade do item efetivamente exportado até 4 decimais
    $mk->tagdetExport($std);

    //############################## TAG <prod/rastro> opcional #####################################################
    //Dados de rastreabilidade uso em medicamentos, podem ocorrer até 500 repetições por item da NFe
    $std = new \stdClass();
    $std->item = 1;
    $std->nLote = 'ACBDE17272'; //OBRIGATÓRIO Número do lote do produto de 1 à 20 caracteres
    $std->qLote = 20; //OBRIGATÓRIO Quantidade de produto no lote.
    $std->dFab = '2025-01-23'; //OBRIGATÓRIO data da fabricação AAAA-MM-DD
    $std->dVal = '2026-01-23'; //OBRIGATÓRIO data de fim da validade AAAA-MM-DD
    //Informar o último dia do mês caso a validade não especifique o dia
    $std->cAgreg = '12345678901234'; //opcional Código de Agregação de 1 à 20 caracteres
    $mk->tagrastro($std);

    //################################################################################################################
    //                        Informações específicas de produtos e serviços
    //################################################################################################################
    //CHOICE veicProd ou med ou arma ou comb ou RECOPI
    //############################## TAG <prod/veicProd> opcional #####################################################
    //Veículos novos
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
    //$mk->tagveicProd((object)$veic);

    //############################## TAG <prod/med> opcional #####################################################
    //Detalhamento de Medicamentos e de matérias-primas farmacêuticas
    $std = new stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->cProdANVISA = 'AAB0492321110'; //OBRIGATÓRIO Utilizar o número do registro ANVISA
    // ou preencher com o literal “ISENTO”
    $std->xMotivoIsencao = ''; //opcional de 1 à 255 caracteres
    // Obs.: Para medicamento isento de registro na ANVISA, informar o número da decisão que o isenta,
    // como por exemplo o número da Resolução da Diretoria Colegiada da ANVISA (RDC).
    $std->vPMC = 200.00; //OBRIGATÓRIO Preço máximo consumidor com até duas decimais
    //$mk->tagmed($std);

    //############################## TAG <prod/arma> opcional #####################################################
    //Detalhamento de Armamento
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

    //############################## TAG <prod/comb> opcional #####################################################
    //Informar apenas para operações com combustíveis líquidos
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
    //$mk->tagcomb((object) $comb);

    //############################## TAG <prod/comb/encerrante> opcional ##############################################
    //Informações do grupo de encerrante
    $enc = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'nBico' => 12, //OBRIGATÓRIO Numero de identificação do Bico utilizado no abastecimento [0-9]{1,3}
        'nBomba' => 2, //opcional Numero de identificação da bomba ao qual o bico está interligado [0-9]{1,3}
        'nTanque' => 4, //OBRIGATÓRIO  Numero de identificação do tanque ao qual o bico está interligado [0-9]{1,3}
        'vEncIni' => '12123456', //OBRIGATÓRIO Valor do Encerrante no ínicio do abastecimento 0|0\.[0-9]{3}|[1-9]{1}[0-9]{0,11}(\.[0-9]{3})?
        'vEncFin' => '12345678', //OBRIGATÓRIO Valor do Encerrante no final do abastecimento  0|0\.[0-9]{3}|[1-9]{1}[0-9]{0,11}(\.[0-9]{3})?
    ];
    //$mk->tagencerrante((object) $enc);

    //############################## TAG <prod/comb/origComb> opcional ##############################################
    //Grupo indicador da origem do combustível de 0 até 30 ocorrencias
    $g1 = [
        'item' => 1,  //OBRIGATÓRIO referencia ao item da NFe
        'indImport' => 0, //OBRIGATÓRIO Indicador de importação
            // 0 Nacional;
            // 1 Importado;
        'cUFOrig' => '35', //OBRIGATÓRIO UF de origem do produtor ou do importado
        'pOrig' => 100, //OBRIGATÓRIO Percentual originário para a UF
    ];
    //$mk->tagorigComb((object) $g1);

    $g2 = [
        'item' => 1,  //OBRIGATÓRIO referencia ao item da NFe
        'indImport' => 1, //OBRIGATÓRIO Indicador de importação
            // 0 Nacional;
            // 1 Importado;
        'cUFOrig' => '21', //OBRIGATÓRIO UF de origem do produtor ou do importado
        'pOrig' => 100, //OBRIGATÓRIO Percentual originário para a UF
    ];
    //$mk->tagorigComb((object) $g2);

    $rc = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'nRECOPI' => '01234567890123456789' //OBRIGATÓRIO Número do RECOPI [0-9]{20}
    ];
    //$mk->tagRECOPI((object) $rc);

    //############################## TAG <det/imposto> OBRIGATÓRIA #####################################################
    $std = new stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->vTotTrib = 100; //opcional Valor estimado total de impostos federais, estaduais e municipais 2 decimais
    $mk->tagimposto($std);

    //############################## TAG <det/imposto/ICMS> opcional ###################################################
    //choice ICMS ou ICMSPart ou ICMSSN ou ICMSST
    //ICMS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->orig = 0;
    $std->CST = '00';
    $std->modBC = '3';
    $std->vBC = '1200';
    $std->pICMS = 10;
    $std->vICMS = 120;
    $std->pFCP = null;
    $std->vFCP = null;
    $std->vBCFCP = null;
    $std->modBCST = null;
    $std->pMVAST = null;
    $std->pRedBCST = null;
    $std->vBCST = null;
    $std->pICMSST = null;
    $std->vICMSST = null;
    $std->vBCFCPST = null;
    $std->pFCPST = null;
    $std->vFCPST = null;
    $std->vICMSDeson = null;
    $std->motDesICMS = null;
    $std->pRedBC = null;
    $std->vICMSOp = null;
    $std->pDif = null;
    $std->vICMSDif = null;
    $std->vBCSTRet = null;
    $std->pST = null;
    $std->vICMSSTRet = null;
    $std->vBCFCPSTRet = null;
    $std->pFCPSTRet = null;
    $std->vFCPSTRet = null;
    $std->pRedBCEfet = null;
    $std->vBCEfet = null;
    $std->pICMSEfet = null;
    $std->vICMSEfet = null;
    $std->vICMSSubstituto = null;
    $mk->tagICMS($std);

    //ICMSPart
    //Partilha do ICMS entre a UF de origem e UF de destino ou a UF definida na legislação
    //Operação interestadual para consumidor final com partilha do ICMS  devido na operação entre a UF de origem e a
    //UF do destinatário ou ou a UF definida na legislação. (Ex. UF da concessionária de entrega do veículos)
    $ic = [
        'item',
        'orig',
        'CST',
        'modBC',
        'vBC',
        'pRedBC',
        'pICMS',
        'vICMS',
        'modBCST',
        'pMVAST',
        'pRedBCST',
        'vBCST',
        'pICMSST',
        'vICMSST',
        'vBCFCPST',
        'pFCPST',
        'vFCPST',
        'pBCOp',
        'UFST'
    ];
    $mk->tagICMSPart((object)$ic);

    //ICMSSN
    //Tributação do ICMS pelo SIMPLES NACIONAL
    $ic = [
        'item',
        'orig',
        'CSOSN',
        'pCredSN',
        'vCredICMSSN',
        'modBCST',
        'pMVAST',
        'pRedBCST',
        'vBCST',
        'pICMSST',
        'vICMSST',
        'vBCFCPST',
        'pFCPST',
        'vFCPST',
        'vBCSTRet',
        'pST',
        'vICMSSTRet',
        'vBCFCPSTRet',
        'pFCPSTRet',
        'vFCPSTRet',
        'modBC',
        'vBC',
        'pRedBC',
        'pICMS',
        'vICMS',
        'pRedBCEfet',
        'vBCEfet',
        'pICMSEfet',
        'vICMSEfet',
        'vICMSSubstituto'
    ];
    $mk->tagICMSSN((object)$ic);

    //ICMSST
    //Grupo de informação do ICMSST devido para a UF de destino, nas operações interestaduais de produtos que
    //tiveram retenção antecipada de ICMS por ST na UF do remetente. Repasse via Substituto Tributário.
    $ic = [
        'item',
        'orig',
        'CST',
        'vBCSTRet',
        'vICMSSTRet',
        'vBCSTDest',
        'vICMSSTDest',
        'vBCFCPSTRet',
        'pFCPSTRet',
        'vFCPSTRet',
        'pST',
        'vICMSSubstituto',
        'pRedBCEfet',
        'vBCEfet',
        'pICMSEfet',
        'vICMSEfet'
    ];


    //############################## TAG <det/imposto/ICMSUFDest> opcional #############################################
    //Grupo a ser informado nas vendas interestarduais para consumidor final, não contribuinte de ICMS
    $ufd = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'vBCUFDest' => 200, //OBRIGATÓRIO Valor da Base de Cálculo do ICMS na UF do destinatário 2 decimais
        'vBCFCPUFDest' => 200, //opcional Valor da Base de Cálculo do FCP na UF do destinatário. 2 decimais
        'pFCPUFDest' => 2, //opcional Percentual adicional inserido na alíquota interna da UF
            // de destino, relativo ao Fundo de Combate à Pobreza (FCP) naquela UF. até 4 decimais
        'pICMSUFDest' => 21.5, //OBRIGATÓRIO Alíquota adotada nas operações internas na UF do
            // destinatário para o produto / mercadoria. até 4 decimais
        'pICMSInter' => 7, //OBRIGATÓRIO Alíquota interestadual das UF envolvidas 4.00 ou 7.00 ou 12.00
        //'pICMSInterPart' => 100, //DEFAULT 100 Percentual de partilha para a UF do destinatário
        'vFCPUFDest' => 3.45, //opcional Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF 2 decimais
        'vICMSUFDest' => 34.97, //OBRIGATÓRIO Valor do ICMS de partilha para a UF do destinatário 2 decimais
        //'vICMSUFRemet' => 0 //DEFAULT ZERO Valor do ICMS de partilha para a UF do remetente.
    ];
    $mk->tagICMSUFDest((object)$ufd);

    //############################## TAG <det/imposto/IPI> opcional ####################################################
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

    //############################## TAG <det/imposto/II> opcional #####################################################
    //Dados do Imposto de Importação
    $ii = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'vBC' => 100.22, //OBRIGATÓRIO Base da BC do Imposto de Importação 2 decimais
        'vDespAdu' => 21.87, //OBRIGATÓRIO  Valor das despesas aduaneiras 2 decimais
        'vII' => 10.01, //OBRIGATÓRIO Valor do Imposto de Importação 2 decimais
        'vIOF' => 0.21 //OBRIGATÓRIO Valor do Imposto sobre Operações Financeiras 2 decimais
    ];
    $mk->tagII((object) $ii);

    //############################## TAG <det/imposto/ISSQN> opcional #################################################
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


    //############################## TAG <det/imposto/PIS> opcional ###################################################
    //choice PISAliq ou PISQtde ou PISNT ou PISOutr
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

    //############################## TAG <det/imposto/PISST> opcional #################################################
    $pst = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'vPIS' => 20.22, //OBRIGATÓRIO
        'vBC' => 389.98, //opcional
        'pPIS' => 4.33, //opcional
        'qBCProd' => 2000, //opcional
        'vAliqProd' => 12, //opcional
        'indSomaPISST' => 1, //opcional
    ];
    $mk->tagPISST((object) $pst);

    //############################## TAG <det/imposto/COFINS> opcional ################################################
    //COFINS
    $std = new stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->CST = '99';
    $std->vBC = 10000;
    $std->pCOFINS = 7;
    $std->vCOFINS = 12.00;
    $std->qBCProd = 12;
    $std->vAliqProd = 1;
    $mk->tagCOFINS($std);

    //############################## TAG <det/imposto/COFINSST> opcional ##############################################
    $cst = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'vBC' => 2000.33, //OBRIGATÓRIO Valor da BC do COFINS ST 2 decimais
        'vCOFINS' => 14.22, //OBRIGATÓRIO
        'pCOFINS' => 7.1111, //opcional Alíquota do COFINS ST(em percentual) até 4 decimais
        'qBCProd' => 2039.3882, //opcional Quantidade Vendida até 4 decimais
        'vAliqProd' => 12.2342, //opcional Alíquota do COFINS ST(em reais)  até 4 decimais
        'indSomaCOFINSST' => 1 //opcional Indica se o valor da COFINS ST compõe o valor total da NFe
            //0-não
            //1-sim
    ];
    $mk->tagCOFINSST((object) $cst);

    //############################## TAG <det/imposto/IS> opcional ####################################################
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
    //$mk->tagIS((object) $is);

    //############################## TAG <det/imposto/IBCCBS> opcional ################################################
    $ibs = [
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
        'vBC' => 100, //opcional Base de cálculo do IBS e CBS 13v2
        //dados IBS Estadual
        'gIBSUF_pIBSUF' => 10, //opcional Alíquota do IBS de competência das UF 3v2-4, OBRIGATÓRIO se vBC for informado
        //removido 'gIBSUF_vTribOp' => 2, //opcional Valor bruto do tributo na operação 13v2
        'gIBSUF_pDif' => 5, //opcional Percentual do diferimento 3v2-4
        'gIBSUF_vDif' => 30, //opcional Valor do Diferimento 13v2
        'gIBSUF_vDevTrib' => 10, //opcional Valor do tributo devolvido 13v2
        'gIBSUF_pRedAliq' => 10, //opcional Percentual da redução de alíquota 3v2-4
        'gIBSUF_pAliqEfet' => 20, //opcional Alíquota Efetiva do IBS de competência das UF que será aplicada a BC 3v2-4
        'gIBSUF_vIBSUF' => 10, //OBRIGATÓRIO Valor do IBS de competência da UF 13v2
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
        // removido 'gCBS_vCBSOp' => 0, //opcional Valor da CBS Bruto na operação '0|0\.[0-9]{2}
        'gCBS_vDif' => 20, //opcional Valor do Diferimento 13v2
        'gCBS_vDevTrib' => 10, //opcional Valor do tributo devolvido 13v2
        'gCBS_pRedAliq' => 20, //opcional Percentual da redução de alíquota 3v2-4
        'gCBS_pAliqEfet' => 3.54, //opcional Alíquota Efetiva da CBS que será aplicada a Base de Cálculo 3v2
        'gCBS_vCBS' => 21.83, //opcional Valor da CBS 13v2
    ];
    $mk->tagIBSCBS((object) $ibs);

    //############################## TAG <det/imposto/IBSCBS/gIBSCBS/gTribRegular> opcional ###########################
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

    //############################## TAG <det/imposto/IBSCBS/gIBSCBS/gIBSCredPres> opcional ###########################
    $cred = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'cCredPres' => '11', //OBRIGATÓRIO Código de Classificação do Crédito Presumido 2 caracteres
        'pCredPres' => 2.3234, //OBRIGATÓRIO Percentual do Crédito Presumido 3v2-4
        'vCredPres' => 22.30, //OBRIGATÓRIO Valor do Crédito Presumido 13v2
        'vCredPresCondSus' => 0, //OBRIGATÓRIO Valor do Crédito Presumido em condição suspensiva 13v2
    ];
    $mk->tagIBSCredPres((object) $cred);

    //############################## TAG <det/imposto/IBSCBS/gIBSCBS/gCBSCredPres> opcional ###########################
    $cred = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'cCredPres' => '11', //OBRIGATÓRIO Código de Classificação do Crédito Presumido 2 caracteres
        'pCredPres' => 2.1111, //OBRIGATÓRIO Percentual do Crédito Presumido 3v2-4
        'vCredPres' => 12.34, //OBRIGATÓRIO Valor do Crédito Presumido 13v2
        'vCredPresCondSus' => 9.00, //OBRIGATÓRIO Valor do Crédito Presumido em condição suspensiva 13v2
    ];
    $mk->tagCBSCredPres((object) $cred);

    //############################## TAG <det/imposto/IBSCBS/gIBSCBSMono> opcional ####################################
    //Grupo de Informações do IBS e CBS em operações com imposto monofásico
    $mono = [
        'item', //OBRIGATÓRIO referencia ao item da NFe
        'qBCMono', //OBRIGATÓRIO
        'adRemIBS', //OBRIGATÓRIO
        'adRemCBS', //OBRIGATÓRIO
        'vIBSMono', //OBRIGATÓRIO
        'vCBSMono', //OBRIGATÓRIO
        'qBCMonoReten', //opcional
        'adRemIBSReten', //opcional
        'vIBSMonoReten', //opcional
        'adRemCBSReten', //opcional
        'vCBSMonoReten', //opcional
        'qBCMonoReten', //opcional
        'adRemIBSRet', //opcional
        'vIBSMonoRet', //opcional
        'adRemCBSRet', //opcional
        'vCBSMonoRet', //opcional
        'pDifIBS', //opcional Percentual do diferimento do imposto monofásico. 3v2-4
        // Se declarado todos abaixo serão OBRIGATÓRIOS
        'vIBSMonoDif', //opcionalValor do IBS monofásico diferido 13v2
        'pDifCBS', //opcional Percentual do diferimento do imposto monofásico. 3v2-4
        // Se declarado todos abaixo serão OBRIGATÓRIOS
        'vCBSMonoDif', //opcional Valor do IBS monofásico diferido 13v2
        'vTotIBSMonoItem', //opcional Total de IBS Monofásico 13v2
        'vTotCBSMonoItem' //opcional Total da CBS Monofásica 13v2
    ];

    //############################## TAG <det/imposto/gTransfCred> opcional ##########################################
    //Transferências de Crédito
    $transf = [
        'item' => 1, //OBRIGATÓRIO
        'vIBS' => 200.00, //OBRIGATÓRIO Valor do IBS a ser transferido 13v2
        'vCBS' => 35.23, //OBRIGATÓRIO Valor do CBS a ser transferido 13v2
    ];
    $mk->taggTranfCred((object) $transf);

    //############################## TAG <det/imposto/gCredPresIBSZFM> opcional ##########################################
    //Informações do crédito presumido de IBS para fornecimentos a partir da ZFM
    $zfm = [
        'item' => 1, //OBRIGATÓRIO
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

    //############################## TAG <det/imposto/impostoDevol> opcional ##########################################
    //Informação do Imposto devolvido
    //O motivo da devolução deverá ser informado pela empresa no campo de Informações Adicionais do Produto (tag:infAdProd).
    $idev = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'pDevol' => 85.00, //OBRIGATRÓRIO Percentual da mercadoria devolvida 2 devimais max = 100.00
        'vIPIDevol' => 0.00 ////OBRIGATRÓRIO Valor do IPI devolvido 2 decimais
    ];
    $mk->tagimpostoDevol((object) $idev);

    //############################## TAG <transp> OBRIGATÓRIA #####################################################
    //transp OBRIGATÓRIA
    $tr = [
        'modFrete' => 0 //OBRIGATÓRIO
            //0 - Contratação do Frete por conta do Remetente (CIF);
            //1 - Contratação do Frete por conta do destinatário/remetente (FOB);
            //2 - Contratação do Frete por conta de terceiros;
            //3 - Transporte próprio por conta do remetente;
            //4 - Transporte próprio por conta do destinatário;
            //9 - Sem Ocorrência de transporte.
    ];
    $transp = $mk->tagtransp((object)$tr);

    //############################## TAG <transp/transporta> opcional #####################################################
    //transporta OPCIONAL Dados do Transportador
    $std = [
        'CNPJ' => '01234123456789', //opcional
        'CPF' => '12345678901', //opcional
        'xNome' => 'Joãozinho', //opcional 2 a 60 caracteres
        'xEnder' => 'Rua Direita do Sul, 1245 - fundos',
        'IE' => '123456',
        'xMun' => 'São Vito',
        'UF' => 'SP'
    ];
    $tns = $mk->tagtransporta((object)$std);

    //############################## TAG <transp/retTransp> opcional #####################################################
    //retTransp OPCIONAL
    $std = [
        'vServ' => 1500.00,
        'vBCRet' => 1500.00,
        'pICMSRet' => 10.0,
        'vICMSRet' => 150.00,
        'CFOP' => '1111',
        'cMunFG' => 3512345,
    ];
    $retTrans = $mk->tagrettransp((object)$std);

    //############################## TAG <transp/veicTransp> opcional #####################################################
    //veicTransp OPCIONAL
    $std = [
        'placa' => 'XYZ9999',
        'UF' => 'SP',
        'RNTC' => '123-AZV-222',
    ];
    $veic = $mk->tagveictransp((object)$std);

    //############################## TAG <transp/reboque> opcional #####################################################
    //reboque OPCIONAL até 5 registros no maximo
    $std = new \stdClass();
    $std->placa = 'ABC0011';
    $std->UF = 'RJ';
    $std->RNTC = 'R0011';
    $veic = $mk->tagreboque($std);

    //reboque OPCIONAL
    $std = new \stdClass();
    $std->placa = 'ABC0012';
    $std->UF = 'RJ';
    $std->RNTC = 'R0012';
    $veic = $mk->tagreboque($std);

    //############################## TAG <transp/vagao> opcional #####################################################
    //vagao OPCIONAL
    //somente será inserida se nenhum dos anteriores existir
    $std = new \stdClass();
    $std->vagao = 'HTRE-20930';
    $mk->tagvagao($std);

    //############################## TAG <transp/balsa> opcional #####################################################
    //balsa OPCIONAL
    //somente será inserida se nenhum dos anteriores existir
    $std = new \stdClass();
    $std->balsa = '111-ARR-STS';
    $mk->tagbalsa($std);

    //############################## TAG <transp/vol> opcional #####################################################
    //vol OPCIONAL até 5000 NOTA: cada volume é identificado com um número indovidual item.
    $std = [
        'item' => 1,
        'qVol' => 12,
        'esp' => 'CAIXAS',
        'marca' => 'RR',
        'nVol' => '001,002,003,006.008,231,2990,392,42,788,9874,054',
        'pesoL' => 222.30,
        'pesoB' => 225.60,
    ];
    $vol = $mk->tagvol((object)$std);

    //vol OPCIONAL
    $std = [
        'item' => 2,
        'qVol' => 2,
        'esp' => 'BALDES',
        'marca' => 'XXX',
        //'nVol' => '001,002,003,006.008,231,2990,392,42,788,9874,054',
        'pesoL' => 12.00,
        'pesoB' => 13.30,
    ];
    $vol = $mk->tagvol((object)$std);

    //############################## TAG <transp/vol/lacres> opcional #####################################################
    //lacres OPCIONAL referenciada a uma tag vol pelo identificador item
    for ($x = 111; $x <= 112; $x++) {
        $std = new \stdClass();
        $std->item = 2;
        $std->nLacre = 'LCR' . str_pad($x, 5, '0', STR_PAD_LEFT);
        $vol = $mk->taglacres($std);
    }

    //############################## TAG <cobr/fat> opcional #####################################################
    //bloco fat (FATURA)
    $fat = [
        'nFat' => 'FAT. 1234567', //opcional 1 a 60 caracteres
        'vOrig' => 1455.95, //opcional numero com até 2 casas decimais
        'vDesc' => 5.95, //opcional numero com até 2 casas decimais
        'vLiq' => 1450.00 //opcional numero com até 2 casas decimais
    ];
    $tfat = $mk->tagfat((object)$fat);

    //############################## TAG <cobr/dup> opcional #####################################################
    //bloco de duplicadas (boletos)
    //nDup opcional string 1 a 60 caracteres
    //dVenc opcional data de vencimento no formato AAAA-MM-DD
    //vDup OBRIGATÓRIO numero com até 2 decimais
    $dups = [
        ['nDup' => '001', 'dVenc' => '2018-08-22', 'vDup' => 52.69],
        ['nDup' => '002', 'dVenc' => '2018-09-22', 'vDup' => 52.72],
        ['nDup' => '003', 'dVenc' => '2018-10-22', 'vDup' => 52.80]
    ];
    foreach ($dups as $key => $dup) {
        $mk->tagdup((object)$dup);
    }

    //############################## TAG <pag> OBRIGATÓRIA #####################################################
    $pag = ['vTroco' => 123.44];
    $tpag = $mk->tagpag((object)$pag);

    //############################## TAG <pag/detPag> OBRIGATÓRIA #####################################################
    //detPag OBRIGATÓRIA
    $detpag = [
        'indPag' => 0, //opcional null ou 0 - Pagamento à Vista 1 - Pagamento à Prazo
        'tPag' => '03', //OBRIGATÓRIO
        //01 Dinheiro
        //02 Cheque
        //03 Cartão de Crédito
        //04 Cartão de Débito
        //05 Crédito Loja
        //10 Vale Alimentação
        //11 Vale Refeição
        //12 Vale Presente
        //13 Vale Combustível
        //15 Boleto Bancário
        //16 Depósito Bancário
        //17 Pagamento Instantâneo (PIX)
        //18 Transferência bancária, Carteira Digital
        //19 Programa fidelidade, Cashback, Créd Virt
        //20 Pagamento Instantâneo (PIX) - Estático
        //21 Crédito em Loja
        //22 Pagamento Eletrônico não Informado - falha de hardware do sistema emissor
        //90 Sem pagamento
        //99 Outros
        'xPag' => null, //opcional 2 a 60 caracteres NOTA: obrigatório se tPag = 99
        'vPag' => 22.66, //OBRIGATÓRIO numero com até 2 decimais
        'dPag' => '2018-08-22', //opcional data de pagamento no formato AAAA-MM-DD
        //dados de Grupo de Cartões, PIX, Boletos e outros Pagamentos Eletrônicos
        //TODOS OS CAMPOS ABAIXO SOMENTE DEVEM SER DECLARADOS CASO NECESSÁRIO
        'tpIntegra' => 2, //OBRIGATÓRIO
        //1 Pagamento integrado com o sistema de automação da empresa
        // (Ex.: equipamento TEF, Comércio Eletrônico, POS Integrado)
        //2 Pagamento não integrado com o sistema de automação da empresa (Ex.: equipamento POS Simples)
        'CNPJ' => '31551765000143', //opcional CNPJ da instituição de pagamento
        //Caso o pagamento seja processado pelo intermediador da transação, informar o CNPJ do intermediador
        'tBand' => '01', //opcional Bandeira da operadora de cartão de crédito e/ou débito
        //01 Visa
        //02 Mastercard
        //03 American Express
        //04 Sorocred
        //05 Diners Club
        //06 Elo
        //07 Hipercard
        //08 Aura
        //09 Cabal
        //10 Alelo
        //11 Banes Card
        //12 CalCard
        //13 Credz
        //14 Discover
        //15 GoodCard
        //16 GreenCard
        //17 Hiper
        //18 JcB
        //19 Mais
        //20 MaxVan
        //21 Policard
        //22 RedeCompras
        //23 Sodexo
        //24 ValeCard
        //25 Verocheque
        //26 VR
        //27 Ticket
        //99 Outros
        'cAut' => 'AK2939FGRQ93093', //opcional Número de autorização da operação com cartões, PIX, boletos e outros pagamentos eletrônicos
        //string de 1 a 128 caracteres
        //Preencher informando o CNPJ do estabelecimento e a UF onde o pagamento foi processado/transacionado/recebido
        //quando a emissão do documento fiscal ocorrer em estabelecimento distinto.
        'CNPJPag' => null, //opcional
        'UFPag' => null, //opcional
        'CNPJReceb' => null, //opcional CNPJ do beneficiário do pagamento
        'idTermPag' => null //opcional Identificador do terminal de pagamento
    ];
    $tdpag = $mk->tagdetpag((object)$detpag);

    //############################## TAG <infIntermed> opcional #####################################################
    $inf = [
        'CNPJ' => "12345678901234",
        'idCadIntTran' => 'lojasem'
    ];
    $intermed = $mk->tagIntermed((object)$inf);

    //############################## TAG <infCpl> opcional #####################################################
    //Grupo de Informações adicionais da NF-e
    //infAdFisco - opcional Informações adicionais de interesse do Fisco, de 1 a 2000 caracteres
    //infCpl - opcional Informações complementares de interesse do Contribuinte, de 1 a 5000 caracteres
    $inf = [
        'infAdFisco' => 'Conforme Lei 234/33 redução de impostos para charretes azuis.',
        'infCpl' => "I - Documento emitido por ME ou EPP optante pelo Simples Nacional; e II - Não gera direito a crédito fiscal de ICMS, ISS e de IPI. Sr. Jose vai retirar a mercadoria na filial em Tangará da Serra"
    ];
    $info = $mk->taginfadic((object)$inf);

    //############################## TAG <obsCont> opcional #######################
    //Campo de uso livre do contribuinte informar o nome do campo no atributo xCampo e o conteúdo do campo no xTexto
    //obsCont opcional
    $obs = [
        'xCampo' => 'email', //OBRIGATÓRIO de 1 a 20 caracteres
        'xTexto' => 'ciclano@mail.com' //OBRIGATÓRIO de 1 a 60 caracteres
    ];
    $tobs = $mk->tagobsCont((object)$obs);
    //obsCont opcional
    $obs = [
        'xCampo' => 'email',
        'xTexto' => 'beltrano@mail.com'
    ];
    $obs = $mk->tagobsCont((object)$obs);

    //############################## TAG <obsFisco> opcional #######################
    //Campo de uso exclusivo do Fisco informar o nome do campo no atributo xCampo e o conteúdo do campo no xTexto
    //NOTA: como é de uso exclusivo do fisco, convêm não utilizar.
    //obsFisco opcional
    $obs = [
        'xCampo' => 'nota',
        'xTexto' => 'Ajuste SINEF 2.2'
    ];
    $obs = $mk->tagobsFisco((object)$obs);

    //############################## TAG <procRef> opcional #######################
    //Grupo Processo referenciado
    for ($x = 1; $x <= 10; $x++) {
        $std = [
            'nProc' => str_pad($x, 3, '0', STR_PAD_LEFT) . 'AB5356-222-45.200', //OBRIGATÓRIO de 1 a 60 caracteres
            'indProc' => 0 //OBRIGATÓRIO origem
            //0 SEFAZ;
            //1 Justiça Federal;
            //2 Justiça Estadual;
            //3 Secex/RFB;
            //9 Outros
        ];
        $mk->tagprocRef((object)$std);
    }

    //############################## TAG <exporta> opcional #######################
    //Informar apenas na exportação.
    $std = [
        'UFSaidaPais' => 'SP', //OBRIGATÓRIO 2 caracteres NÃO ACEITA 'EX'
        'xLocExporta' => 'Porto de Santos', //OBRIGATÓRIO de 1 à 60 caracteres
        'xLocDespacho' => 'Pier 14 doca 22' //opcional de 1 à 60 caracteres
    ];
    $exporta = $mk->tagexporta((object)$std);

    //############################## TAG <compra> opcional #######################
    //Informação adicional de compra
    $std = [
        'xNEmp' => '456789', //opcional de 1 a 22 caracteres
        'xPed' => 'PED-220011', //opcional de 1 à 60 caracteres
        'xCont' => 'AZ123' //opcional de 1 a 60 caracteres
    ];
    $compra = $mk->tagcompra((object)$std);

    //############################## TAG <cana> opcional #######################
    //Informações de registro aquisições de cana
    $std = [
        'safra' => '2018', //OBRIGATÓRIO formato AAAA ou AAAA/AAAA
        'ref' => '07/2018', //OBRIGATÓRIO formato MM/AAAA
        'qTotMes' => 310000.0, //OBRIGATÓRIO
        'qTotAnt' => 30000.0, //OBRIGATÓRIO
        'qTotGer' => 61000.0, //OBRIGATÓRIO
        'vFor' => 578000.00, //OBRIGATÓRIO
        'vTotDed' => 100000.00, //OBRIGATÓRIO
        'vLiqFor' => 468877.25 //OBRIGATÓRIO
    ];
    $compra = $mk->tagcana((object)$std);

    //############################## TAG <forDia> opcional #######################
    //tag forDia OBRIGATÓRIA se existir a tag cana até 31 dias
    for ($x = 1; $x <= 31; $x++) {
        $std = [
            'dia' => $x, //OBRIGATÓRIO dia de 1 até 31 referente ao mês declarado anteriormente
            'qtde' => 10000 //OBRIGATÓRIO
        ];
        $fordia = $mk->tagfordia((object)$std);
    }

    //############################## TAG <deduc> opcional #######################
    //tag deduc opcional - até 10 repetições
    $std = [
        'xDed' => 'Sei la o que escrever', //OBRIGATÓRIO de 1 a 60 caracteres
        'vDed' => 145987.55, //OBRIGATÓRIO
    ];
    $ded = $mk->tagdeduc((object)$std);
    //tag deduc opcional - até 10 repetições
    $std = [
        'xDed' => 'Sei la 2.0', //OBRIGATÓRIO de 1 a 60 caracteres
        'vDed' => 12.55, //OBRIGATÓRIO
    ];
    $ded = $mk->tagdeduc((object)$std);

    //############################## TAG <infRespTec> opcional ########################################################
    $inf = [
        'CNPJ' => '99999999999999', //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
        'xContato' => 'Fulano de Tal', //Nome da pessoa a ser contatada
        'email' => 'fulano@soft.com.br', //E-mail da pessoa jurídica a ser contatada
        'fone' => '1155551122', //Telefone da pessoa jurídica/física a ser contatada
        'CSRT' => 'G8063VRTNDMO886SFNK5LDUDEI24XJ22YIPO', //Código de Segurança do Responsável Técnico
        'idCSRT' => '01' //Identificador do CSRT
    ];
    $mk->taginfRespTec((object)$inf);

    //############################## TAG <agropecuario> opcional #####################################################
    //Produtos Agropecurários Animais, Vegetais e Florestais NÃO EXISTE NA PL010 !!!
    //choice defencivo ou guia de transito

    //Guias De Trânsito de produtos agropecurários animais, vegetais e de origem florestal.
    $agro = [
        'tpGuia' => 1, //OBRIGATÓRIO Tipo da Guia:
            // 1 - GTA;
            // 2 - TTA;
            // 3 - DTA;
            // 4 - ATV;
            // 5 - PTV;
            // 6 - GTV;
            // 7 - Guia Florestal (DOF, SisFlora - PA e MT, SIAM - MG)
        'UFGuia' => 'SP', //OBRIGATÓRIO 2 caracteres
        'serieGuia' => 'CC0001', //opcional Série da Guia de 1 a 9 caracteres
        'nGuia' => 12 //OBRIGATÓRIO de 1 a 9 digitos
    ];
    //$agro = $mk->tagAgropecuarioGuia((object)$agro);

    //Defensivo Agrícola / Agrotóxico
    $agro = [
        'nReceituario' => 'A0001', //OBRIGATÒRIO Número do Receituário ou Receita do Defensivo / Agrotóxico
            // de 1 a 30 caracteres
        'CPFRespTec' => '12345678901' //OBRIGATÒRIO CPF do Responsável Técnico pelo receituário
    ];
    $mk->tagAgropecuarioDefensivo((object)$agro);
    $agro = [
        'nReceituario' => 'B0002', //OBRIGATÒRIO Número do Receituário ou Receita do Defensivo / Agrotóxico
        // de 1 a 30 caracteres
        'CPFRespTec' => '12345678901' //OBRIGATÒRIO CPF do Responsável Técnico pelo receituário
    ];
    $mk->tagAgropecuarioDefensivo((object)$agro);

    //############################################  FIM  ##############################################################

    //rederiza o xml
    $xml = $mk->render();
    $cert = file_get_contents(__DIR__ .'/fixtures/expired_certificate.pfx');
    $certificate = Certificate::readPfx($cert, 'associacao');

    $xml = Signer::sign(
        $certificate,
        $xml,
        'infNFe',
        'Id'
    );

    $xsd = __DIR__ . "/../schemes/PL_009_V4/nfe_v4.00.xsd";
    if ($schema === 'PL_010_V1') {
        $xsd = __DIR__ . "/../schemes/PL_010_V1/nfe_v4.00.xsd";
    }
    $erroxsd = null;
    try {
        Validator::isValid($xml, $xsd);
    } catch (ValidatorException $e) {
        $erroxsd = $e->getMessage();
    }
    //obtem a chave do documento que foi analisada e recriada
    $chave = $mk->getChave();
    //obtem os erros gerados no input de dados
    $error = $mk->getErrors();
    if (!empty($error) || !empty($erroxsd)) {
        foreach ($error as $e) {
            echo $e;
            echo "<br>";
        }
        if (!empty($erroxsd)) {
            echo $erroxsd;
            echo "<br>";
        }
        $dom = new DOMDocument('1.0', 'UTF-8');;
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($xml);
        $txt = htmlentities($dom->saveXML());
        echo "<pre>";
        echo $txt;
        echo "</pre>";

    } else {
        header('Content-type: text/xml');
        echo $xml;
   }

} catch (\Exception $e) {
    echo $e->getMessage();
}
