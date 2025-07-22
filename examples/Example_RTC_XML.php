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
        'cUF' => 35, //OBRIGATÒRIO numero da UF
        'cNF' => null, //opcional 8 digitos max, será preenchido automaticamente com zeros a esquerda
        //se deixado com null, será inserido um valor aleatório de acordo com as regras da SEFAZ
        //se forem informados mais de 8 digitos o valor será truncado para 8 digitos
        'natOp' => 'VENDA DE PRODUTO PROPRIO', //OBRIGATÒRIO max 60 caracteres
        'mod' => 55, //OBRIGATÒRIO modelo 55 ou 65
        'serie' => 1, //OBRIGATÒRIO série normal 0-889 SCAN 900-999
        'nNF' => 100, //OBRIGATÒRIO até 9 digitos
        'dhEmi' => null, //opcional se deixado com null, será inserida a data e hora atual para a UF
        'dhSaiEnt' => null, //opcional
        //CUIDADO ao inserir deve corresponder a data e hora correta para a UF e deve ser maior ou igual a dhEmi
        'tpNF' => 1, //OBRIGATÒRIO 0-entrada; 1-saída
        'idDest' => 2, //OBRIGATÒRIO 1-Interna;2-Interestadual;3-Exterior
        'cMunFG' => 3550308, //OBRIGATÒRIO 7 digitos IBGE Código do Município de Ocorrência do Fato Gerador
        'cMunFGIBS' => 3550308, //opcional 7 digitos IBGE apenas PL_010 em diante
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
        'tpNFDebito' => null, //opcional apenas PL_010 em diante
        //01=Transferência de créditos para Cooperativas;
        //02=Anulação de Crédito por Saídas Imunes/Isentas;
        //03=Débitos de notas fiscais não processadas na apuração;
        //04=Multa e juros;
        //05=Transferência de crédito de sucessão.
        //06=Pagamento antecipado
        //07=Perda em estoque
        'tpNFCredito' => null, //opcional apenas PL_010 em diante
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
        'dhCont' => null, //opcional data e hora da entrada em contingência
        'xJust' => null, //opcional motivo da entrada em contingência entre 15 e 256 caracateres
    ];
    $mk->tagide((object)$ide);

    //############################## TAG <emit> OBRIGATÓRIA #########################################################
    $emi = [
        'xNome' => 'TESTE LTDA', //OBRIGATÓRIO razão social com 2 até 60 caracteres
        'xFant' => 'TESTE', //opcional nome fantasia com 1 até 60 caracteres
        'IE' => '111111111111', //OBRIGATÓRIO [0-9]{2,14}|ISENTO
        'IEST' => null, //opcional [0-9]{2,14}
        'IM' => null, //opcional de 1 a 15 caracteres
        'CNAE' => null, //opcional [0-9]{7}
        'CRT' => 3, //OBRIGATóRIO
        //1 – Simples Nacional;
        //2 – Simples Nacional – excesso de sublimite de receita bruta;
        //3 – Regime Normal.
        //4 - Simples Nacional - Microempreendedor individual - MEI
        'CNPJ' => '12345678901234', //opcional [0-9]{14} ##### NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2} ####
        'CPF' => null, //opcional [0-9]{11} - se os dois campos forem inclusos o CNPJ tem prioridade
    ];
    $mk->tagEmit((object)$emi);

    //############################## TAG <emit> OBRIGATÓRIA #########################################################
    $end = [
        'xLgr' => 'RUA Lucas Orbes',
        'nro' => '520',
        'xCpl' => null,
        'xBairro' => 'Ipiranga',
        'cMun' => 3550308,
        'xMun' => 'São Paulo',
        'UF' => 'SP',
        'CEP' => '04262000',
        'cPais' => 1058,
        'xPais' => 'Brasil',
        'fone' => null,
    ];
    $mk->tagenderEmit((object)$end);

    //############################## TAG <dest> opcional #######################
    $dest = [
        'xNome' => 'Ciclano e Cia Ltda',
        'CNPJ' => '12345678901234', //NOTA: a partir de 2026 ALFA [A-Z0-9]{12}[0-9]{2}
        'CPF' => null,
        'idEstrangeiro' => null,
        'indIEDest' => 1,
        'IE' => '2222222222',
        'ISUF' => null,
        'IM' => null,
        'email' => 'comercial@ciclano.com.br'
    ];
    $dest = $mk->tagdest((object)$dest);

    //enderDest OPCIONAL
    $end = [
        'xLgr' => 'Rua Alberto Santos',
        'nro' => '334',
        'xCpl' => 'Lj 101',
        'xBairro' => 'Soteco',
        'cMun' => '3205200',
        'xMun' => 'Vila Velha',
        'UF' => 'ES',
        'CEP' => '29106100',
        'cPais' => 1600,
        'xPais' => 'Brasil',
        'fone' => null
    ];
    $ret = $mk->tagenderdest((object)$end);

    //############################## TAG <prod> OBRIGATÓRIA #####################################################
    //até 990 ocorrências no maximo
    //prod OBRIGATÓRIA
    $std = new stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe 1 a 990
    $std->cProd = '23qq'; //OBRIGATÓRIO de 1 à 60 caracteres
    $std->cEAN = "SEM GTIN";//OBRIGATÓRIO SEM GTIN|[0-9]{0}|[0-9]{8}|[0-9]{12,14}
    $std->cBarra = "SEM GTIN";//opcional de 3 à 30 caracteres
    $std->xProd = 'FEEL SMART TINTO'; //OBRIGATÓRIO 1 a 120 caracteres
    $std->NCM = 60063220; //OBRIGATÓRIO [0-9]{2}|[0-9]{8}
    $std->CEST = null; //opcional usado apenas para produtos com ST 7 digitos
    $std->indEscala = 'S'; //opcional usado junto com CEST, S-escala relevante N-escala NÃO relevante
    $std->CNPJFab = null; //opcional usado junto com CEST e qunado indEscala = N
    $std->cBenef = null; //opcional codigo beneficio fiscal ([!-ÿ]{8}|[!-ÿ]{10}|SEM CBENEF)?
    $std->EXTIPI = null;
    $std->CFOP = 6101;
    $std->uCom = 'kg';
    $std->qCom = 14.4;
    $std->vUnCom = 43.68;
    $std->vProd = 628.99;
    $std->cEANTrib = "SEM GTIN";//'6361425485451';
    $std->uTrib = 'kg';
    $std->qTrib = 14.4;
    $std->vUnTrib = 43.68;
    $std->vFrete = null;
    $std->vSeg = null;
    $std->vDesc = null;
    $std->vOutro = null;
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
        'infAdProd' => 'PRETO Lote: 2319/H' //OBRIGATÓRIO de 1 a 500 caracteres
    ];
    $mk->taginfAdProd((object) $inf);


    //############################## TAG <det/imposto> OBRIGATÓRIA #####################################################
    $std = new stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->vTotTrib = null; //opcional Valor estimado total de impostos federais, estaduais e municipais 2 decimais
    $mk->tagimposto($std);

    //############################## TAG <det/imposto/ICMS> opcional ###################################################
    //choice ICMS ou ICMSPart ou ICMSSN ou ICMSST
    //ICMS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->orig = 3;
    $std->CST = '00';
    $std->modBC = '3';
    $std->vBC = 628.99;
    $std->pICMS = 4;
    $std->vICMS = 25.16;
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



    //############################## TAG <det/imposto/IPI> opcional ####################################################
    $ipi = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'CNPJProd' => null, //opcional CNPJ do produtor da mercadoria, quando diferente do emitente.
            // Somente para os casos de exportação direta ou indireta.
        'cSelo' => null, //opcional Código do selo de controle do IPI de 1 60 caracteres
        'qSelo' => null, //opcional Quantidade de selo de controle do IPI até 12 digitos
        'cEnq' => '122', //OBRIGATÓRIO Código de Enquadramento Legal do IPI (tabela a ser criada pela RFB) de 1 a 3 caracteres
        'CST' => '55', //OBRIGATÓRIO
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
        'vBC' => null, //opcional Valor da BC do IPI 2 decimais
        'pIPI' => null, //opcional Alíquota do IPI até 4 decimais
        'vIPI' => null, //opcional Valor do IPI 2 decimais
        'qUnid' => null, //opcional Quantidade total na unidade padrão para tributação até 4 decimais
        'vUnid' => null //opcional Valor por Unidade Tributável.
            // Informar o valor do imposto Pauta por unidade de medida até 4 decimais.
    ];
    $mk->tagIPI((object)$ipi);


    //############################## TAG <det/imposto/PIS> opcional ###################################################
    //choice PISAliq ou PISQtde ou PISNT ou PISOutr
    $std = new stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->CST = '01';  //OBRIGATÓRIO Código de Situação Tributária do PIS
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
    $std->vBC = 628.99; //opcional Valor da BC do PIS 2 decimais
    $std->pPIS = 1.65; //opcional Alíquota do PIS (em percentual) até 4 decimais
    $std->vPIS = 10.38; //opcional Valor do PIS 2 decimais
    $std->qBCProd = null; //opcional Quantidade Vendida  (NT2011/004) até 4 decimais
    $std->vAliqProd = null; //opcionalAlíquota do PIS (em reais) (NT2011/004) até 4 decimais
    $mk->tagPIS($std);


    //############################## TAG <det/imposto/COFINS> opcional ################################################
    //COFINS
    $std = new stdClass();
    $std->item = 1; //OBRIGATÓRIO referencia ao item da NFe
    $std->CST = '01';
    $std->vBC = 628.99;
    $std->pCOFINS = 7.60;
    $std->vCOFINS = 47.80;
    $std->qBCProd = null;
    $std->vAliqProd = null;
    $mk->tagCOFINS($std);


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
        'cClassTrib' => '000001', //OBRIGATÓRIO
        'vBC' => 545.65, //opcional Base de cálculo do IBS e CBS 13v2
        //dados IBS Estadual
        'gIBSUF_pIBSUF' => 1.0, //opcional Alíquota do IBS de competência das UF 3v2-4, OBRIGATÓRIO se vBC for informado
        //removido 'gIBSUF_vTribOp' => 2, //opcional Valor bruto do tributo na operação 13v2
        'gIBSUF_pDif' => null, //opcional Percentual do diferimento 3v2-4
        'gIBSUF_vDif' => null, //opcional Valor do Diferimento 13v2
        'gIBSUF_vDevTrib' => null, //opcional Valor do tributo devolvido 13v2
        'gIBSUF_pRedAliq' => null, //opcional Percentual da redução de alíquota 3v2-4
        'gIBSUF_pAliqEfet' => 1.0, //opcional Alíquota Efetiva do IBS de competência das UF que será aplicada a BC 3v2-4
        'gIBSUF_vIBSUF' => 5.46, //OBRIGATÓRIO Valor do IBS de competência da UF 13v2
        //dados IBS Municipal
        'gIBSMun_pIBSMun' => 0, //opcional Alíquota do IBS de competência do município 3v2-4,OBRIGATÓRIO se vBC for informado
        //removido 'gIBSMun_vTribOp' => 2, //opcional Valor bruto do tributo na operação 13v2
        'gIBSMun_pDif' => null, //opcional Percentual do diferimento 3v2-4
        'gIBSMun_vDif' => null, //opcional Valor do Diferimento 13v2
        'gIBSMun_vDevTrib' => null, //opcional Valor do tributo devolvido 13v2
        'gIBSMun_pRedAliq' => null, //opcional Percentual da redução de alíquota 3v2-4
        'gIBSMun_pAliqEfet' => null, //opcional Alíquota Efetiva do IBS de competência do Município que será aplicada a BC 3v2
        'gIBSMun_vIBSMun' => 0, //opcional Valor do IBS de competência do Município 13v2
        // dados CBS (imposto federal)
        'gCBS_pCBS' => 9, //opcional Alíquota da CBS 3v2-4, OBRIGATÓRIO se vBC for informado
        'gCBS_pDif' => null, //opcional Percentual do diferimento 3v2-4
        'gCBS_vCBSOp' => null, //opcional Valor da CBS Bruto na operação '0|0\.[0-9]{2}
        'gCBS_vDif' => null, //opcional Valor do Diferimento 13v2
        'gCBS_vDevTrib' => null, //opcional Valor do tributo devolvido 13v2
        'gCBS_pRedAliq' => null, //opcional Percentual da redução de alíquota 3v2-4
        'gCBS_pAliqEfet' => 9.0, //opcional Alíquota Efetiva da CBS que será aplicada a Base de Cálculo 3v2
        'gCBS_vCBS' => 49.11, //opcional Valor da CBS 13v2
    ];
    $mk->tagIBSCBS((object) $ibs);

    //############################## TAG <det/imposto/IBSCBS/gIBSCBS/gTribRegular> opcional ###########################
    $reg = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'CSTReg' => '000', //OBRIGATÓRIO Código de Situação Tributária do IBS e CBS 3 digitos
        'cClassTribReg' => '000001', //OBRIGATÓRIO Código de Classificação Tributária do IBS e CBS 6
        'pAliqEfetRegIBSUF' => 1, //OBRIGATÓRIO Valor da alíquota do IBS da UF 3v2-4
        'vTribRegIBSUF' => 5.46, //OBRIGATÓRIO Valor do Tributo do IBS da UF 13v2
        'pAliqEfetRegIBSMun' => 0, //OBRIGATÓRIO Valor da alíquota do IBS do Município 3v2-4
        'vTribRegIBSMun' => 0, //OBRIGATÓRIO Valor do Tributo do IBS do Município 13v2
        'pAliqEfetRegCBS' => 9, //OBRIGATÓRIO Valor da alíquota da CBS 3v2-4
        'vTribRegCBS' => 49.11, //OBRIGATÓRIO Valor do Tributo da CBS 13v2
    ];
    $mk->tagIBSCBSTribRegular((object) $reg);

    /*
    //############################## TAG <det/imposto/IBSCBS/gIBSCBS/gIBSCredPres> opcional ###########################
    $cred = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'cCredPres' => '11', //OBRIGATÓRIO Código de Classificação do Crédito Presumido 2 caracteres
        'pCredPres' => 2.3234, //OBRIGATÓRIO Percentual do Crédito Presumido 3v2-4
        'vCredPres' => 22.30, //OBRIGATÓRIO Valor do Crédito Presumido 13v2
        'vCredPresCondSus' => 0, //OBRIGATÓRIO Valor do Crédito Presumido em condição suspensiva 13v2
    ];
    $mk->tagIBSCredPres((object) $cred);
    */
    /*
    //############################## TAG <det/imposto/IBSCBS/gIBSCBS/gCBSCredPres> opcional ###########################
    $cred = [
        'item' => 1, //OBRIGATÓRIO referencia ao item da NFe
        'cCredPres' => '11', //OBRIGATÓRIO Código de Classificação do Crédito Presumido 2 caracteres
        'pCredPres' => 2.1111, //OBRIGATÓRIO Percentual do Crédito Presumido 3v2-4
        'vCredPres' => 12.34, //OBRIGATÓRIO Valor do Crédito Presumido 13v2
        'vCredPresCondSus' => 9.00, //OBRIGATÓRIO Valor do Crédito Presumido em condição suspensiva 13v2
    ];
    $mk->tagCBSCredPres((object) $cred);
    */
    /*
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
    */
    /*
    //############################## TAG <det/imposto/gTransfCred> opcional ##########################################
    //Transferências de Crédito
    $transf = [
        'item' => 1, //OBRIGATÓRIO
        'vIBS' => 200.00, //OBRIGATÓRIO Valor do IBS a ser transferido 13v2
        'vCBS' => 35.23, //OBRIGATÓRIO Valor do CBS a ser transferido 13v2
    ];
    $mk->taggTranfCred((object) $transf);
    */
    /*
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
    */

    //############################## TAG <transp> OBRIGATÓRIA #####################################################
    //transp OBRIGATÓRIA
    $tr = [
        'modFrete' => 1 //OBRIGATÓRIO
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
        'CNPJ' => null, //opcional
        'CPF' => null, //opcional
        'xNome' => 'Cliente Retira', //opcional 2 a 60 caracteres
        'xEnder' => null,
        'IE' => null,
        'xMun' => null,
        'UF' => null
    ];
    $tns = $mk->tagtransporta((object)$std);

    //############################## TAG <transp/vol> opcional #####################################################
    //vol OPCIONAL até 5000 NOTA: cada volume é identificado com um número indovidual item.
    $std = [
        'item' => 1,
        'qVol' => 1,
        'esp' => 'Rolo',
        'marca' => null,
        'nVol' => null,
        'pesoL' => 14.40,
        'pesoB' => 14.75,
    ];
    $vol = $mk->tagvol((object)$std);



    //############################## TAG <cobr/fat> opcional #####################################################
    //bloco fat (FATURA)
    $fat = [
        'nFat' => 'FAT. 1234567', //opcional 1 a 60 caracteres
        'vOrig' => 628.99, //opcional numero com até 2 casas decimais
        'vDesc' => null, //opcional numero com até 2 casas decimais
        'vLiq' => 628.99 //opcional numero com até 2 casas decimais
    ];
    $tfat = $mk->tagfat((object)$fat);

    //############################## TAG <cobr/dup> opcional #####################################################
    //bloco de duplicadas (boletos)
    //nDup opcional string 1 a 60 caracteres
    //dVenc opcional data de vencimento no formato AAAA-MM-DD
    //vDup OBRIGATÓRIO numero com até 2 decimais
    $dups = [
        ['nDup' => '001', 'dVenc' => '2025-08-22', 'vDup' => 314.50],
        ['nDup' => '002', 'dVenc' => '2025-09-22', 'vDup' => 314.49],
    ];
    foreach ($dups as $key => $dup) {
        $mk->tagdup((object)$dup);
    }

    //############################## TAG <pag> OBRIGATÓRIA #####################################################
    $pag = ['vTroco' => 0];
    $tpag = $mk->tagpag((object)$pag);

    //############################## TAG <pag/detPag> OBRIGATÓRIA #####################################################
    //detPag OBRIGATÓRIA
    $detpag = [
        'indPag' => 0, //opcional null ou 0 - Pagamento à Vista 1 - Pagamento à Prazo
        'tPag' => '15', //OBRIGATÓRIO
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
        'vPag' => 628.99, //OBRIGATÓRIO numero com até 2 decimais
        'dPag' => null, //opcional data de pagamento no formato AAAA-MM-DD
        //dados de Grupo de Cartões, PIX, Boletos e outros Pagamentos Eletrônicos
        //TODOS OS CAMPOS ABAIXO SOMENTE DEVEM SER DECLARADOS CASO NECESSÁRIO
        'tpIntegra' => 2, //OBRIGATÓRIO
        //1 Pagamento integrado com o sistema de automação da empresa
        // (Ex.: equipamento TEF, Comércio Eletrônico, POS Integrado)
        //2 Pagamento não integrado com o sistema de automação da empresa (Ex.: equipamento POS Simples)
        'CNPJ' => null, //opcional CNPJ da instituição de pagamento
        //Caso o pagamento seja processado pelo intermediador da transação, informar o CNPJ do intermediador
        'tBand' => null, //opcional Bandeira da operadora de cartão de crédito e/ou débito
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
        'cAut' => null, //opcional Número de autorização da operação com cartões, PIX, boletos e outros pagamentos eletrônicos
        //string de 1 a 128 caracteres
        //Preencher informando o CNPJ do estabelecimento e a UF onde o pagamento foi processado/transacionado/recebido
        //quando a emissão do documento fiscal ocorrer em estabelecimento distinto.
        'CNPJPag' => null, //opcional
        'UFPag' => null, //opcional
        'CNPJReceb' => null, //opcional CNPJ do beneficiário do pagamento
        'idTermPag' => null //opcional Identificador do terminal de pagamento
    ];
    $tdpag = $mk->tagdetpag((object)$detpag);


    //############################## TAG <infCpl> opcional #####################################################
    //Grupo de Informações adicionais da NF-e
    //infAdFisco - opcional Informações adicionais de interesse do Fisco, de 1 a 2000 caracteres
    //infCpl - opcional Informações complementares de interesse do Contribuinte, de 1 a 5000 caracteres
    $inf = [
        'infAdFisco' => 'SAIDA COM SUSPENSAO DO IPI CONFORME ART 29 DA LEI 10.637',
        'infCpl' => null
    ];
    $info = $mk->taginfadic((object)$inf);


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
