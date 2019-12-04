# Cadastro de Parceiros 

Esse cadastro envolve todo e qualquer participante de operações fiscais, como:
- clientes
- fornecedores
- transportadoras
- prestadores de serviços

Com base nas regras do EFD ICMS, temos:

- Não é permitida a troca de Inscrição Estadual de um participante já declarado em EFDs anteriores, ou seja, caso haja a alteração de uma IE de um participante um novo registro deve ser criado OBRIGTÓRIAMENTE.



|Campo|Detalhe|Tipo|Index|
|:---:|:---:|:---:|:---:|
|id|id da tabela|integer|primary|
|fantasia|nome fantasia do participante|varchar(100)|unique|
|razao|razão social do participante|varchar(100)||
|tipo|tipo de documento 1-CNPJ 2-CPF 3-extrangeiro|integer||
|doc|documento numero do CNPJ ou CPF ou extrangeiro|varchar(14)||
|ie|numero da inscrição estadual|varchar(15)||
|im|numero da inscrição municipal|varchar(15)||



