# MANIFESTAÇÃO DE DESTINATÁRIO

Função: Serviço destinado à recepção de mensagem de Evento da NF-e.
Este serviço permite que o destinatário da Nota Fiscal eletrônica confirme a sua participação
na operação acobertada pela Nota Fiscal eletrônica emitida para o seu CNPJ, através do
envio da mensagem de:




Confirmação da Operação – confirmando a ocorrência da operação e o recebimento da
mercadoria (para as operações com circulação de mercadoria);
Desconhecimento da Operação – declarando o desconhecimento da operação;
Operação Não Realizada – declarando que a operação não foi realizada (com recusa do
Recebimento da mercadoria e outros) e a justificativa do porquê a operação não se
realizou;
Ciência da Emissão (ou Ciência da Operação) – declarando ter ciência da operação
destinada ao CNPJ, mas ainda não possuir elementos suficientes para apresentar uma
manifestação conclusiva, como as acima citadas. Este evento era chamado de Ciência da
Operação.
O autor do evento é o destinatário da NF-e. A mensagem XML do evento será assinada com
o certificado digital que tenha o CNPJ-Base (8 primeiras posições do CNPJ) do Destinatário
da NF-e.
A ciência da emissão é um evento opcional que pode ser utilizado pelo destinatário para
declarar que tem ciência da existência da operação, mas ainda não tem elementos suficientes
para apresentar uma manifestação conclusiva.
O destinatário deve apresentar uma manifestação conclusiva dentro de um prazo máximo
definido, contados a partir da data de autorização da NF-e.
Processo: síncrono.
Método: nfeRecepcaoEvento
