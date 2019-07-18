## CST - Código da Situação Tributária

NOTA: Alteração esperada para 2022, tando no CRT como nos CST com a extinção dos COSN

> Este conteúdo é aplicavel apenas as empresas cujo CRT (codigo de regime triburário) igual a 3 (Regime Normal) ou em casos especiais como por exemplo uma DEVOLUÇÃO de mercadoria de uma Empresa classificada nos codigos 1 ou 2  (Simples Nacional), para uma empresa do Regime Normal que forneceu as mercadorias, para fins de retornos dos impostos declarados pela empresa fornecedora.
> O Regime Normal, engloba empresas que declaram por "LUCRO REAL" ou por "LUCRO PRESUMIDO".

### ICMS

|CST|Descrição|
|:---:|:---|
|00|Tributada integralmente|
|10|Tributada e com cobrança do ICMS por **substituição tributária**|
|20|Com redução da BC|
|30|Isenta / não tributada e com cobrança do ICMS por **substituição tributária**|
|40|Isenta|
|41|Não tributada|
|50|Com suspensão|
|51|Com diferimento|
|60|ICMS cobrado anteriormente por **substituição tributária**|
|70|Com redução da BC e cobrança do ICMS por **substituição tributária**|
|90|Outras|

O CST é um atributo que pertence e se ajusta a duas condições:
1. **O produto**, sim, o CST depende do produto, e mais especificamente do NCM (nomenclatura do Mercosul).
2. **A operação fiscal**, algumas operações, como por exemplo as REMESSAS deverão usar outros CST pois nessas operações não haverá a incidência de ICMS.

### IPI

**SAÍDAS**

|CST|Descrição|
|:---:|:---|
|50|Saída Tributada|
|51|Saída Tributável com Alíquota Zero|
|52|Saída Isenta|
|53|Saída Não Tributada|
|54|Saída Imune|
|55|Saída com Suspensão|
|99|Outras Saídas|

**ENTRADAS**

|CST|Descrição|
|:---:|:---|
|00|Entrada com Recuperação de Crédito|
|01|Entrada Tributada com Alíquota Zero|
|02|Entrada Isenta|
|03|Entrada Não Tributada|
|04|Entrada Imune|
|05|Entrada com Suspensão|
|49|Outras Entrada|

A Receita Federal do Brasil (RFB), poderá utilizar-se do CST do IPI em outras obrigações, para padronização, na prestação ou na manutenção, pelos contribuintes, de informações relativas às operações de que participem. A Instrução Normativa RFB nº 1.009/2010 da Receita Federal, que trás a última Tabela divulgada por este órgão fiscalizador. Normativa RFB nº 1.009, de 10 de fevereiro de 2010. Os CST devem ser utilizados para a parametrização dos produtos contidos na empresa,

A finalidade do CST é descrever, de forma objetiva, qual a tributação do IPI que está sendo aplicada sobre **o produto** nas operações.

Novamente, O CST é um atributo que pertence e se ajusta a duas condições:
1. **O produto**, sim, o CST depende do produto, e mais especificamente do NCM (nomenclatura do Mercosul).
2. **A operação fiscal**, algumas operações, como por exemplo as REMESSAS deverão usar outros CST pois nessas operações não haverá a incidência de IPI.
