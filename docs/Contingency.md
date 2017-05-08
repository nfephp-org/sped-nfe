# CONTINGENCY
Em condições normais as NFe emitidas tem a propriedade &lt;tpEmis&gt; com o valor igual a 1, ou seja emissão normal.

Quando a conexão via internet com a SEFAZ autorizadora não é possivel existem alternativas para permitir a emissão dos documentos mesmo nessas condições.

Ao ativar qualquer contigência o XML da NFe deve ser remontado ou modificado e assinado novamente com as seguintes alterações:
- &lt;tpEmis&gt; indicar o numero do modo de contingência utilizado
- &lt;dhCont&gt; Data e Hora da entrada em contingência no formato com TZD
- &lt;xJust&gt; Justificativa da entrada em contingência com 15 até 256 caracteres

### ~~FS-IA IMPRESSOR AUTÔNOMO (tpEmis = 2 OBSOLETO)~~
Este modo de contingência permite que a NFe seja emitida sem que haja a prévia autorização pela SEFAZ autorizadora através da impressão do DANFE em formulário de segurança de impressor autônomo.

**Uso: Não mais pode ser usado**

**Este modelo de contingência está desabilitado desde 2011. E não pode mais ser usado**

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 2

### ~~SCAN (tpEmis = 3 OBSOLETO)~~
Sistema de Contingência do Ambiente Nacional, **este serviço foi desabilitado e portanto não está mais disponivel para uso**.

**Uso: Não mais pode ser usado**

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 3

### ~~DPEC (tpEmis = 4 OBSOLETO)~~
Declaração Prévia da Emissão em Contingência

Este tipo de contingência foi substituido pelo modo EPEC que utiliza eventos para registrar a emissão. Veja EPEC.

**Uso: Não mais pode ser usado**

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 4

### EPEC (tpEmis = 4) *NFe e NFCe*
Evento Prévio da Emissão em Contingência

**Uso: SEFAZ OFF e SVC OFF mas emitente com acesso à internet.**

Este modo de contingência é diferente dos demais por que na verdade irá enviar um evento especifico para o webservices de Registro de Eventos do Ambiente Nacional. Normalmente usa-se esse tipo de contingência em caso da SEFAZ autorizadora estar fora do ar, bem como o Serviço Virtual de Contingência também, e isso é uma situação muito rara de ocorrer.

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 4

### FS-DA DOCUMENTO AUXILIAR (tpEmis = 5) *NFe e NFCe*
Este modo de contingência permite que a NFe seja emitida sem que haja a prévia autorização pela SEFAZ autorizadora através da impressão do DANFE em formulário de segurança.

**Uso: Sem acesso a internet.**

Este modo de contingência permite que a NFe seja emitida sem que haja a prévia autorização pela SEFAZ autorizadora através da impressão do DANFE em formulário de segurança.

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 2
> Não é recomendável o uso desse tipo de contingência com a NFe, por vários motivos. O primeiro é o custo, pois os formulários de segurança são caros e deve-se manter controle estrito sobre os mesmos, pois cada folha é identificada individualmente e pode ser usada indevidamente.

> Devemos considerar também a necessidade adicional de controle dessas notas e posterior envio à SEFAZ autorizadora qunado o sistema estiver novamente on-line.

> Outro motivo é a possibilidade de a NFe ser reprovada após o processo posterior de envio a SEFAZ autorizadora, com isso o tranporte e recebimento da mercadoria se torna uma operação "ilegal" e sujeita a punições.

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 5

### SVC-AN (tpEmis = 6) *Apenas NFe (modelo 55)*
SEFAZ Virtual de Contingência do Ambiente Nacional

Este sistema de contingência é o melhor de todos e permite que as notas sejam emitidas com poucas altereções e sem a necessidade de reenvio posterior. Nesse modo as motas enviadas serão sincronizadas automaticamente pelos orgãos autorizadores sem a necessidade que qualquer outra ação pelo emitente. Este serviço atende:
AC, AL, AP, DF, ES, MG, PB, RJ, RN, RO, RR, RS, SC, SE, SP, TO 

**Uso: SEFAZ OFF, mas emitente com acesso à internet.**

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 6

### SVC-RS (tpEmis = 7) *Apenas NFe (modelo 55)*
SEFAZ Virtual de Contingência do RS

Este sistema de contingência é o melhor de todos e permite que as notas sejam emitidas com poucas altereções e sem a necessidade de reenvio posterior. Nesse modo as motas enviadas serão sincronizadas automaticamente pelos orgãos autorizadores sem a necessidade que qualquer outra ação pelo emitente. Este serviço atende:
AM, BA, CE, GO, MA, MS, MT, PA, PE, PI, PR

**Uso: SEFAZ OFF, mas emitente com acesso à internet.**

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 7

### OFF-LINE (tpEmis = 9) *EXCLUSIVO PARA NFCe*
Para a NFCe somente estão disponíveis e são válidas as opções de contingência 5 (FS-DA) e 9 (OFF-LINE).

> *IMPORTANTE*: Esse modo de contingência serve exclusivamente para as notas modelo 65 e não podem ser usadas em notas modelo 55.

**Uso: Sem acesso a internet.**

Nesse caso o xml da NFCe deve indicar na propriedade &lt;tpEmis&gt; o valor 9

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

Tente novamente, após alguns segundos. Nesse qunado for reenviada a NFe pode ocorrer o seguinte:

- envio aceito com retorno do recibo, nesse caso vai em frente e esqueça o problema.
- retorna o ERRO 204 - Duplicidade de NF-e, nesse caso o lote foi aceito (antes de dar o "timeout") e a NFe foi processada a autorizada ou denegada. Nessa caso você deve fazer uma consulta usando a chave de 44 digitos da NFe, essa consulta irá te retornar os dados do protocolo da NFe (autorizado ou denegado), é só adicionar a NFe e prosseguir. 

Mas se continua dando "timeout", ai observe os comentários abaixo: 

> Quando a falha é originada na SEFAZ, a própria Secretaria, ao perceber que irá demorar a retomar o serviço, habilita o SVC (AN ou RS) e posta isso em sua página, esse é o unico jeito seguro de saber que essa contingência está habilitada. Eles somente fazem isso depois de parar totalmente o serviço e sincronizar os dados com a Receita Federal e com o SEFAZ RS, para garantir que dois sistemas não operem simultaneamente, o que poderia causar duplicidades inconciliáveis posteriormente.

> Nesse caso especifico de usar o SVC (AN ou RS) não é recomendável que se mude sem que haja a consulta à página da SEFAZ, mas o seu sistema pode ser preparado para após um determinado tempo em timeout (com a checagem de status) mude automaticamente para a contigência SVC.

> Se essa alteração for feita sem a consulta a página da SEFAZ, você pode receber uma rejeição informando que a contingência não foi habilitada pelo SEFAZ autorizador. Nesse caso deve continuar tentando e usando o status para  tentar ver qual dos dois retorna primeiro. Isso acaba requerendo uma lógica mais complexa e muito bem pensada para não fazer bobagem.

> Se o SVC também estiver dando timeout então o jeito é usar o EPEC, e posteriormente mandar a NFe completa.

> Caso o sistema do autorizador acuse que a Nota já existe é porque já foi registrada, nesse caso puxe o protocolo com a consulta pela chave, já que não temos o recibo.

> Veja que em nenhum momento foi alterado o numero da NFe, apenas as condições de contingência.

### Timeout na CONSULTA DE RECIBO
Essa é uma outra condição que pode ocorrer, a nota ser recebida, e depois quando você consulta o sistema da SEFAZ paraliza.

Como você não sabe se essa nota está autorizada ou não, você pode tentar novamente consultar o recibo.

Se continuar dando "timeout", verifique se a SEFAZ em sua página indica que entrou em contingência, se sim passe também para contingência e tente obter o protocolo pela contingência SVC, usando o recibo ou a chave da NFe.


## NFCe
Já no caso da NFCe o jeito é usar a contingência OFFLINE ou o SAT@ECF (se for SP). E como estamos atendendo na boca do caixa é IMPRESCINDIVEL que a nota seja emitida **AGORA!!** Não importa o que ocorra.

O aplicativo emissor no caso da NFCe deve ter a capacidade de operar sem a INTERNET como um aplicativo DESKTOP, nesse caso eu sugiro o uso do ELECTRON JS para reproduzir o ambiente WEB e um banco de dados LOCAL como o sqLite para guardar as informações do frente de caixa e emitir a NFCe, ou o que for mais conveniente (Java, .NET, C#, Delphi, etc.).

### Timeout no ENVIO DE LOTE
Nesse caso, não temos como saber nem se a NFe foi ou não recebida pois não conseguimos obter o recibo.

**O que fazer então ?**
Incremente o numero e emita outra OFFLINE, e imprima a DANFE, a seguir cancele a nota a qual você não recebeu o recibo.

Se nesse cancelamento retornar um erro informando que a nota não existe, inutilize o numero dela.

*Complicado né !!!*

### Timeout na CONSULTA DE RECIBO
Tente novamente !!

Se continuar sem resposta, siga o indicado acima, cancele e emita outra.

# Class Factories\Contingency

## USAGE

**Habilitando o modo de contingência**

```
use NFePHP\NFe\Factories\Contingency;

$contingency = new Contingency();

$acronym = 'SP';
$motive = 'SEFAZ fora do AR';
$type = 'SVCAN';

$status = $contingency->activate($acronym, $motive, $type);

```
$status irá conter uma string JSON ENCODED, com as informações sobre a condição de contingência. 

```
{
   "motive":"SEFAZ fora do AR",
   "timestamp":1484747583,
   "type":"SVCAN",
   "tpEmis":6
}
```
Essa string deverá ser arquivada, em disco ou em base de dados para uso posterior, até que o modo de contingencia seja desabilitado. 
Ou seja, a cada vez que carregar a classe Tools deverá ser passada a classe contingency, ou será considerado que o ambiente é normal. 

**Desabilitando o modo de contingência**
```
use NFePHP\NFe\Factories\Contingency;

//onde $status é a string obtida quando entrou em modo de contingência.
$contingency = new Contingency($status);

$status = $contingency->deactivate();

```
$status irá conter dados padrões em condições normais.
```
{
   "motive":"",
   "timestamp":0,
   "type":"",
   "tpEmis":1
}
```
Essa string deverá ser arquivada, em disco ou em base de dados para uso posterior, ou apenas ignorada, e o arquivo ou registro da base de dados removida.


## Properties

public $type;

@var string
> Tipo da contingência FSDA, SVCAN, SVCRS, EPEC, OFFLINE 


public $motive;

@var int
> Motivo da entrada em contingência, texto com no minimo 15 caracteres e no máximo 255.

> NOTA: remova todo e qualquer caracter especial desse texto.

public $timestamp;

@var int
>Timestmap do PHP que representa a data e hora em que a contignência foi ativada.


public $tpEmis;

@var int
> Codigo numerico que representa os tipos de contingência acima indicados. Esse codigo fará parte na montagem as NFe no campo &lt;tpEmis&gt;.


## Methods

```
Contingency::construct($string)
```
Construtor, caso seja passado o parametro, uma string JSON, a condição de contingencia contida nessa string será registrada na classe.
Caso nada seja passado a classe irá considerar condição de emissão normal.

```
Contingency::load($string)
```
Essa é outra forma de passar o paramtro (string JSON) para a classe.

```
Contingency::activate($acronym, $motive, $type)
```
Esse método ativa o modo de contignência da classe.
Os parametros são:

$acronym --- sigla do estado

$motive --- texto com o motivo da entrada em contingência

$type --- podem ser usadas as constantes:

- Contingency::SVCAN
- Contingency::SVCRS
- Contingency::FSDA
- Contingency::OFFLINE
- Contingency::EPEC


```
Contingency::deactivate()
```
Esse método desativa o modo de contingência e retorna uma string json com os valores padrões.
