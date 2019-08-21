# Desconto em NFe com ICMS

Desconto é um abatimento no valor da venda. Este tipo de “agrado” ao cliente poderá ser concedido por vários motivos, como por exemplo: promoção e liquidação de estoque, produtos que eram utilizados como mostruário, produtos com defeitos, valor “x” de compra por determinado cliente, enfim, as razões para se conceder um desconto ao cliente são muitas e depende de negociação entre as partes envolvidas.

Na Nota Fiscal Eletrônica, o desconto deve ser especificado em cada item, ou seja, ele não pode ser dado somente no total da nota.

Se o desconto que você quer dar é de 10% no valor da nota, deve então informar o valor correspondente do desconto para cada item. O campo desconto da Nota Fiscal Eletrônica não é um campo obrigatório, o que significa que em uma mesma nota, você pode ter itens que tem desconto e outros sem desconto.

O programa de Nota Fiscal Eletrônica fica encarregado de fazer a somatória do desconto de cada item e de subtrair esse valor do total da nota na seção de totais. Assim, quando houver desconto, os valores unitários de comercialização, tributação e o valor total bruto de cada item devem ser informados sem o desconto, somente no total geral os descontos serão considerados.

Para fins da tributação do ICMS e do IPI existem dois tipos de desconto: condicional e incondicional.

## 1 – DESCONTO CONDICIONAL (não se declara na NFe)

Descontos condicionais, como o próprio nome diz, são aqueles concedidos sob condição, que normalmente, constam das condições de pagamento da própria duplicata, ou seja, se o cliente efetuar o pagamento da compra até o dia “x” terá um desconto no pagamento.

Então, para poder aproveitar-se do desconto, o cliente terá que cumprir uma certa “condição”.

Como exemplo, podemos citar a venda de mercadoria no valor de R$ 250,00 sendo informado no boleto de pagamento que se o comprador da mercadoria efetuar o pagamento até o dia 10 do mês seguinte, haverá um desconto de R$ 20,00. Portanto, este desconto está condicionado a um evento futuro, ou seja, o adquirente poderá ou não efetuar o pagamento desta compra até o dia 10 do mês seguinte.

### Tributação do IPI:

De acordo com o art. 190, do RIPI/10, haverá a tributação do IPI normalmente sobre o valor da venda da mercadoria, independentemente de ter havido ou não desconto com condição futura. Portanto, se a venda foi no valor de R$ 250,00 a tributação do IPI será sobre os R$ 250,00.

Cabe lembrar que haverá a tributação do IPI apenas se o emitente da nota fiscal de venda for estabelecimento industrial ou equiparado a industrial, conforme arts. 4º, 9º e seguintes do Decreto nº 7.212/10 (RIPI/10).

### Tributação do ICMS:

Como o ICMS é um imposto estadual, a tributação dependerá do Estado onde a operação está sendo realizada.

Como o desconto condicional está atrelado a uma condição futura, a venda da mercadoria será tributada normalmente pelo ICMS, ou seja, se a venda da mercadoria foi no valor de R$ 400,00 com desconto de R$ 30,00 se o adquirente pagar a compra até o 5º dia útil do mês seguinte, por exemplo, haverá a tributação do ICMS normalmente sobre o valor dos R$ 400,00 (RICMS-SC/01, art. 22, II, “a”).

Emissão do Documento Fiscal:

Por tratar-se de desconto condicionado a um evento futuro, o desconto condicional não deverá ser mencionado em nenhum documento fiscal, ou seja, este desconto aparecerá apenas no boleto para pagamento da compra (RICMS-SC/01, Anexo 5, art. 36 e Manual de Orientação da NF-e).

Portanto, considerando a venda no Valor de R$ 600,00 com tributação de 17% de ICMS e de 20% do IPI na emissão da nota fiscal os dados serão os seguintes:

a) Valor do produto: R$ 600,00;
b) Base de cálculo do ICMS: R$ 600,00
c) Valor do ICMS: R$ 102,00;
d) Valor do IPI: R$ 120,00;
e) Valor total da nota fiscal: R$ 720,00.

Caso a empresa queira mencionar em Dados Adicionais que poderá haver um desconto se a condição estipulada for atendida, não vemos problemas, pois esta informação não interferirá nos demais valores da nota fiscal.


## 2 – DESCONTO INCONDICIONAL (declarado na NFe com redução do total da NFe e do ICMS)

O desconto incondicional não tem condição nenhuma que precise ser cumprida para que o desconto seja oferecido, não precisa ser compra à vista, nem acima de tantas unidades, nem pagamento antecipado. O desconto será oferecido independente de alguma condição imposta pelo vendedor.

Por exemplo, podemos citar a venda de R$ 700,00 em mercadorias com desconto de R$ 100,00 de ICMS, será cobrado do cliente o valor de R$ 600,00.

### Tributação do IPI:

De acordo com o art. 190, do RIPI/10, haverá a tributação do IPI normalmente sobre o valor da venda da mercadoria, independentemente de ter havido ou não desconto incondicional. Portanto, se a venda foi no valor de R$ 700,00 a tributação do IPI será sobre os R$ 700,00, mesmo que o cliente pague apenas R$ 600,00 devido a um desconto de R$ 100,00.

Cabe lembrar que haverá a tributação do IPI apenas se o emitente da nota fiscal de venda for estabelecimento industrial ou equiparado a industrial, conforme arts. 4º e 9º, do RIPI/10.

Porém, o Senado Federal, através da Resolução SF nº 01/17, declarou que esta parte do Regulamento do IPI é inconstitucional, ou seja, não deve ser aplicado tributação do IPI sobre o valor do desconto dado incondicionalmente.

Desta forma, em uma venda de R$ 700,00 com R$ 100,00 de desconto a tributação do IPI será apenas sobre o valor de R$ 600,00 (R$ 700,00 – R$ 100,00).

### Tributação do ICMS:

Segundo a alínea “a”, do inciso II, do art. 23, do RICMS-SC/01, o desconto concedido de forma incondicional não integra a base de cálculo do ICMS.

Portanto, em uma venda de R$ 700,00 com R$ 100,00 de desconto a tributação do ICMS será apenas sobre o valor de R$ 600,00 (R$ 700,00 – R$ 100,00).

Emissão do Documento Fiscal:

Por tratar-se de desconto incondicional dado ao cliente no momento da venda da mercadoria, este constará no documento fiscal (RICMS-SC/01, Anexo 5, art. 36 e Manual de Orientação da NF-e).

Portanto, considerando a venda no Valor de R$ 700,00 com tributação de 17% de ICMS e de 20% do IPI e com desconto de R$ 100,00 na emissão da nota fiscal os dados serão os seguintes:

a) Valor do produto: R$ 700,00;
b) Base de cálculo do ICMS: R$ 600,00;
c) Valor do ICMS: R$ 102,00;
d) Base de Cálculo do IPI: R$ 600,00
d) Valor do IPI: R$ 120,00;
e) valor do desconto: R$ 100,00
f) Valor total da nota fiscal: R$ 720,00.

Como a nota fiscal de modelo 1 ou 1-A não possui campo próprio para esta informação, a empresa poderá informar no corpo da nota fiscal “Desconto concedido”, informando o valor efetivo do desconto (RICMS-SC/01, Anexo 5, art. 36).

Já a NF-e possui campo específico chamado de “Desconto” em que deverá ser informado o valor do desconto e este abatimento será informado de acordo com cada produto constante na nota fiscal (Manual de Orientação da NF-e).
