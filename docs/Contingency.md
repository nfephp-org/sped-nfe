# CONTINGÊNCIAS

Em condições normais as NFe emitidas tem a propriedade &lt;tpEmis&gt; com o valor igual a 1-Emissão normal.

Quando a conexão via internet com a SEFAZ autorizadora não é possivel, existem alternativas para permitir a emissão dos documentos mesmo nessas condições (offline).

Para uma melhor compreensão, o ENCAT lançou um documento que visa facilitar o entendimento:

[Manual de Boas Práticas no desenvolvimento de emissor de NFC-e – BP 2018.001 – versão 1.0](http://www.nfe.fazenda.gov.br/portal/exibirArquivo.aspx?conteudo=gONQatXTm1U=)

Após lê-lo, os procedimentos abaixo podem ser realizadas na biblioteca, há uma sessão interessante sobre contigência.

Ao ativar qualquer contigência o XML da NFe deve ser remontado ou modificado e assinado novamente com as seguintes alterações:
- &lt;tpEmis&gt; indicar o número do modo de contingência utilizado
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

> Devemos considerar também a necessidade adicional de controle dessas notas e posterior envio à SEFAZ autorizadora quando o sistema estiver novamente on-line.

> Outro motivo é a possibilidade de a NFe ser reprovada após o processo posterior de envio a SEFAZ autorizadora, com isso o transporte e recebimento da mercadoria se torna uma operação "ilegal" e sujeita a punições.

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 5

### SVC-AN (tpEmis = 6) *Apenas NFe (modelo 55)*
SEFAZ Virtual de Contingência do Ambiente Nacional

Este sistema de contingência é o **melhor de todos** e permite que as notas sejam emitidas com poucas alterações e sem a necessidade de reenvio posterior. Nesse modo as notas enviadas serão sincronizadas automaticamente pelos orgãos autorizadores sem a necessidade que qualquer outra ação pelo emitente. Este serviço atende:
AC, AL, AP, DF, ES, MG, PB, RJ, RN, RO, RR, RS, SC, SE, SP, TO 

**Uso: SEFAZ OFF, mas emitente com acesso à internet.**

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 6

### SVC-RS (tpEmis = 7) *Apenas NFe (modelo 55)*
SEFAZ Virtual de Contingência do RS

Este sistema de contingência é o melhor de todos e permite que as notas sejam emitidas com poucas altereções e sem a necessidade de reenvio posterior. Nesse modo as notas enviadas serão sincronizadas automaticamente pelos orgãos autorizadores sem a necessidade que qualquer outra ação pelo emitente. Este serviço atende:
AM, BA, CE, GO, MA, MS, MT, PA, PE, PI, PR

**Uso: SEFAZ OFF, mas emitente com acesso à internet.**

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 7

### OFF-LINE (tpEmis = 9) *EXCLUSIVO PARA NFCe*
Para a NFCe somente estão disponíveis e são válidas as opções de contingência 5 (FS-DA) e 9 (OFF-LINE).

> *IMPORTANTE*: Esse modo de contingência serve exclusivamente para as notas modelo 65 e não podem ser usadas em notas modelo 55.

**Uso: Sem acesso a internet.**

Nesse caso o xml da NFCe deve indicar na propriedade &lt;tpEmis&gt; o valor 9

# [Esclarecimentos sobre TIMEOUT](TimeOut.md)


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
Ou seja, a cada vez que carregar a classe Tools deverá ser passada a classe contingency, ou será considerado que o ambiente é normal. Exemplo:
```
$tools->contingency = $contingency;
```



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
