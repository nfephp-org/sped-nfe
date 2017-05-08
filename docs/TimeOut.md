# Esclarecimentos sobre TIMEOUT

As vezes a internet está "ON LINE" mas comunicação com a SEFAZ pode estar muito RUIM (isso é BRASIL), nesses casos fica a pergunta **o que fazer ?**.
Não tem uma resposta simples para todos os casos, pois esse timeout pode ser causado por:

1. falhas no servidor da SEFAZ
2. sobrecarga dos servidores (congestionamento ou lentidão no processamento)
3. problemas de DNS
4. falhas nos roteadores da operadora
5. etc.

## NFe (modelo 55)
Por definição a emissão de NFe (modelo 55) não é URGENTE pois não está atendendo na boca do caixa, ou seja não é uma loja (se fosse loja então seria uma NFCe). Dito isso a SEFAZ não tem pressa em liberar a contingência e nem você deveria ter . Tome um chá de camolila e relaxe pois estamos no Brasil !!!

### Timeout no ENVIO DE LOTE

Nesse caso, não temos como saber nem se a NFe foi ou não recebida pois não conseguimos obter o recibo.

**O QUE FAZER ?**

Tente novamente, após alguns segundos. Nesse caso, quando for reenviada, pode ocorrer o seguinte:

- envio aceito com retorno do recibo, vai em frente e esqueça o problema.
- retorna o **ERRO 204 - Duplicidade de NF-e**, nesse caso o lote foi aceito (antes de dar o "timeout") e a NFe foi processada a autorizada ou denegada. Nessa caso você deve fazer uma consulta usando a chave de 44 digitos da NFe, essa consulta irá te retornar os dados do protocolo da NFe (autorizado ou denegado), é só adicionar a NFe e prosseguir.

Mas se continua dando "timeout", ai observe os comentários abaixo: 

> Quando a falha é originada na SEFAZ, a própria Secretaria, ao perceber que irá demorar a retomar o serviço, habilita o SVC (AN ou RS) e posta isso em sua página, esse é o unico jeito seguro de saber que essa contingência está habilitada. Eles somente fazem isso depois de parar totalmente o serviço e sincronizar os dados com a Receita Federal e com o SEFAZ RS, para garantir que dois sistemas não operem simultaneamente, o que poderia causar duplicidades inconciliáveis posteriormente.

> Nesse caso especifico de usar o SVC (AN ou RS) não é recomendável que se mude sem que haja a consulta à página da SEFAZ, mas o seu sistema pode ser preparado para após um determinado tempo em timeout (com a checagem de status) mude automaticamente para a contigência SVC.

> Se essa alteração for feita sem a consulta a página da SEFAZ, você pode receber uma rejeição informando que a contingência não foi habilitada pelo SEFAZ autorizador. Nesse caso deve continuar tentando e usando o status para  tentar ver qual dos dois retorna primeiro. Isso acaba requerendo uma lógica mais complexa e muito bem pensada para não fazer bobagem.

> Se o SVC também estiver dando timeout então o jeito é usar o EPEC, e posteriormente mandar a NFe completa.

> Caso o sistema do autorizador acuse que a Nota já existe é porque já foi registrada, nesse caso puxe o protocolo com a consulta pela chave, já que não temos o recibo.

> Veja que em nenhum momento foi alterado o numero da NFe, apenas as condições de contingência.

### Timeout na CONSULTA DE RECIBO

Essa é uma outra condição que pode ocorrer, a nota ser recebida, e depois quando você consulta o sistema da SEFAZ paraliza e dá "timeout".

**O QUE FAZER ?**

Como você não sabe se essa nota está autorizada ou não, você pode tentar novamente consultar o recibo.

Se continuar dando "timeout", verifique se a SEFAZ em sua página indica que entrou em contingência, se sim passe também para contingência e tente obter o protocolo pela contingência SVC, usando o recibo ou a chave da NFe.


## NFCe (modelo 55)

Já no caso da NFCe (modelo 55) o jeito é usar a contingência OFFLINE ou o SAT@ECF (se for SP). E como estamos atendendo na boca do caixa é IMPRESCINDIVEL que a nota seja emitida **AGORA!!** Não importa o que ocorra.

O aplicativo emissor no caso da NFCe deve ter a capacidade de operar sem a INTERNET como um aplicativo DESKTOP, nesse caso eu sugiro o uso do ELECTRON JS para reproduzir o ambiente WEB e um banco de dados LOCAL como o sqLite para guardar as informações do frente de caixa e emitir a NFCe, ou o que for mais conveniente (Java, .NET, C#, Delphi, etc.).

### Timeout no ENVIO DE LOTE (mod. 65)

Nesse caso, não temos como saber nem se a NFe foi ou não recebida pois não conseguimos obter o recibo.

**O QUE FAZER ?**

Incremente o numero e emita outra OFFLINE, e imprima a DANFE, a seguir cancele a nota a qual você não recebeu o recibo.

Se nesse cancelamento retornar um erro informando que a nota não existe, inutilize o numero dela.

*Complicado né !!!*

### Timeout na CONSULTA DE RECIBO

Tente novamente !!

Se continuar sem resposta, siga o indicado acima, cancele e emita outra.
