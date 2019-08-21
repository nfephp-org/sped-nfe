## cBenef Código de Benefício Fiscal

Validação Nota Técnica 2019.001 - v 1.10

cBenef => function(produto,CST,CFOP,UF)

Esse codigo deve ser declarado se:

1 - a UF assim determinar na tabela (http://www.sped.fazenda.gov.br/spedtabelas/AppConsulta/publico/aspx/ConsultaTabelasExternas.aspx?CodSistema=SpedFiscal)
    5.2 - Tabela de Informações Adicionais da Apuração - Valores Declaratórios

Existem duas unidades da federação que exigem isso RJ e PR

Esse campo deverá vir de uma TABELA que relacione o Produto ou o NCM com o CST CFOP e a UF

Exemplo:

|Campo|Detalhe|Tipo|Index|
|:---:|:---:|:---:|:---:|
|id|id da tabela|integer|primary|
|ncm_id|id do ncm|integer|fk_ncm_table|
|uf_id|id da UF|integer|fk_uf_table|
|cst_id|CST relativo a operação|integer|fk_cst_table|
|cfop_id|codigo da operação fiscal|integer|fk_cfop_table|
|cBenef|Código de Benefício Fiscal|varchar(10)|none|
