# CONTINGÊNCIAS

Em condições normais as NFe emitidas tem a propriedade &lt;tpEmis&gt; com o valor igual a 1-Emissão normal.

Quando a conexão via internet com a SEFAZ autorizadora não é possivel, existem alternativas para permitir a emissão dos documentos mesmo nessas condições.

Ao ativar qualquer contigência o XML da NFe deve ser remontado ou modificado e assinado novamente com as seguintes alterações:
- &lt;tpEmis&gt; indicar o número do modo de contingência utilizado
- &lt;dhCont&gt; Data e Hora da entrada em contingência no formato com TZD
- &lt;xJust&gt; Justificativa da entrada em contingência com 15 até 256 caracteres

## FS-DA DOCUMENTO AUXILIAR (tpEmis = 5) *apenas NFe (mod 55)*
Este modo de contingência permite que a NFe seja emitida sem que haja a prévia autorização pela SEFAZ autorizadora através da impressão do DANFE em formulário de segurança.

**Uso: Sem acesso a internet ou com a SEFAZ offline.**

**E ao retornar o serviço da SEFAZ autorizadora estes documentos deverão ser enviados dentro do prazo limite de 24 horas**.

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 5
> Não é recomendável o uso desse tipo de contingência com a NFe, por vários motivos. O primeiro é o custo, pois os formulários de segurança são caros e deve-se manter controle estrito sobre os mesmos, pois cada folha é identificada individualmente e pode ser usada indevidamente.

> Devemos considerar também a necessidade adicional de controle dessas notas e posterior envio à SEFAZ autorizadora quando o sistema estiver novamente on-line.

> Outro motivo é a possibilidade de a NFe ser reprovada após o processo posterior de envio a SEFAZ autorizadora, com isso o transporte e recebimento da mercadoria se torna uma operação "ilegal" e sujeita a punições.
> Se for usar esse método melhore o sistema emissão com muitas validações, para garantir que erros sejam identificados antes de geração do documento, para evitar problemas posteriores e multas. 


## SVC-AN (tpEmis = 6) *Apenas NFe (modelo 55)*

SEFAZ Virtual de Contingência do Ambiente Nacional

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 6

Este sistema de contingência é o **melhor de todos** e permite que as notas sejam emitidas com poucas alterações e sem a necessidade de reenvio posterior. Nesse modo as notas enviadas serão sincronizadas automaticamente pelos orgãos autorizadores sem a necessidade que qualquer outra ação pelo emitente. Este serviço atende:
AC, AL, AP, CE, DF, ES, MG, PA, PB, PI, RJ, RN, RO, RR, RS, SC, SE, SP, TO 

> Este é o caso de uso da classe Contingency da nossa biblioteca, inclusive NFe emitida em modo normal será automaticamente ajustada para o ambiente de contingência e novamente assinada quando contingencia SVCAN estiver ativada na class Tools.

> IMPORTANTE: este processo **irá alterar a chave da NFe**, e portanto deverá ser **regravada em sua base de dados** (com a chave nova gerada pelo processo de envio).  

**Uso: SEFAZ OFFLINE, mas emitente com acesso à internet, e sistema de contigência SVCAN ativado pela SEFAZ autorizadora do seu estado.**


## SVC-RS (tpEmis = 7) *Apenas NFe (modelo 55)*

SEFAZ Virtual de Contingência do RS

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 7

Este sistema de contingência é o **melhor de todos** e permite que as notas sejam emitidas com poucas altereções e sem a necessidade de reenvio posterior. Nesse modo as notas enviadas serão sincronizadas automaticamente pelos orgãos autorizadores sem a necessidade que qualquer outra ação pelo emitente. Este serviço atende:
AM, BA, GO, MA, MS, MT, PE, PR

> Este é o caso de uso da classe Contingency da nossa biblioteca, inclusive NFe emitida em modo normal será automaticamente ajustada para o ambiente de contingência e novamente assinada quando contingencia SVCRS estiver ativada na class Tools.

> IMPORTANTE: este processo irá **alterar a chave da NFe**, e portanto deverá ser **regravada em sua base de dados** (com a chave nova gerada pelo processo de envio).

**Uso: SEFAZ OFFLINE, mas emitente com acesso à internet, e sistema de contigência SVCRS ativado pela SEFAZ autorizadora do seu estado.**


## OFF-LINE (tpEmis = 9) *EXCLUSIVO PARA NFCe*

Este modo de contingência permite que a NFCe seja emitida sem que haja a prévia autorização pela SEFAZ autorizadora através da impressão do DANFCE.

**E ao retornar o serviço da SEFAZ autorizadora estes documentos deverão ser enviados dentro do prazo limite de 24 horas**.

Nesse caso o xml da NFCe deve indicar na propriedade &lt;tpEmis&gt; o valor 9

> *IMPORTANTE*: Esse modo de contingência serve exclusivamente para as notas modelo 65 e não podem ser usadas em notas modelo 55.

> Todos os estados permitem a emissão de NFCe em modo OFFLINE, exceto SP, onde é obrigátorio o uso do SAT@ecf ou da emissão por EPEC NFCe.

> Outro problema com essas NFCe-OFFLINE é a possibilidade de a NFe ser reprovada após o processo posterior de envio a SEFAZ autorizadora, com isso o transporte e recebimento da mercadoria se torna uma operação "ilegal" e sujeita a punições.
> Se for usar esse método melhore o sistema emissão com muitas validações, para garantir que erros sejam identificados antes de geração do documento, para evitar problemas posteriores e multas.
> Mas em caso de erro detectado pela SEFAZ pode corrigir a mesma NFCe, assinar novamente e enviar dentro do prazo estabelecido, mas o documento impresso originalmente estará diferente da versão final e em principio deverá ser substituido com o consumidor.

**Uso: Sem acesso a internet ou com a SEFAZ offline.**

## EPEC (tpEmis = 4) *NFe e NFCe*

Evento Prévio da Emissão em Contingência

Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 4

Este é o processo **mais complexo e "arriscado"** entre todos os modos de contigência.

São dois tipos diferentes mas que seguem basicamente as mesmas regras estruturas e condições, apenas são direcionados para webservices diferentes.

Em ambos os casos são criados eventos EPEC Evento Prévio de Emissão em Contingência, e para emitir em EPEC devem ser observados os seguintes passos:

1. criar a NFe ou a NFCe já marcada em contignência EPEC com **tpEmis = 4**, **dhCont = data hora de entrada em contingência** e **xJust = justificativa**
2. criar e enviar o evento EPEC pelos métodos da classe Tools, sendo:
   - $tools->sefazEPEC($xml, $verAplic) para NFe (mod 55)
   - $tools->sefazEpecNfce($xml, $verAplic) para NFCe (mod 65)
3. verificar se o evento foi autorizado, se sim protocolar, se não tratar o erro até o evento ser autorizado
4. usar o xml da NFe/NFCe e os dados do EPEC autorizado para imprimir o DANFE ou DANFCE
5. enviar o xml assim que a SEFAZ autorizadora retornar a operação normal

### EPEC NFe (mod 55)

Este processo envia o EPEC para o ambiente nacional da NFe.

### EPEC NFCe (mod 65)

Este processo envia o EPEC para o webservice de registro de EPEC especifico para NFCe, exclusivamente no estado de São Paulo.

> NOTA: não existe EPEC para NFCe em outros estados, neles deve ser usada a contingência OFFLINE

Este modo de contingência é diferente dos demais por que na verdade irá enviar um evento especifico para o webservices de Registro de Eventos do Ambiente Nacional. Normalmente usa-se esse tipo de contingência em caso da SEFAZ autorizadora estar fora do ar, bem como o Serviço Virtual de Contingência também, e isso é uma situação muito rara de ocorrer.

> IMPORTANTE: a emissão de um evento EPEC cria a pendência do envio de uma nota que seja autorizada ou denegada dentro do limite de 7 dias para que seja vinculada ao EPEC, caso contrario, se algum evento EPEC não for vinculado ao uma NFe/NFCe, o emitente ficará **bloqueado e não mais porderá enviar eventos EPEC**. 

**Uso: NFe SEFAZ OFF e SVC OFF mas emitente com acesso à internet.**

**Uso: NFCe SEFAZ-SP OFF e EPEC-NFCe-SP ativo e emitente com acesso à internet.**

# [Esclarecimentos sobre TIMEOUT](TimeOut.md)


## USO

A classe Contingency somente será usada para envio de NFe (mod 55) para as contigências SVC-AN ou SVC-RS, que são substitutos diretos à emissão normal.

Os demais tipos de contingência como:

- FS-DA DOCUMENTO AUXILIAR (tpEmis = 5), o xml é criado em modo contigência e a NFe é impressa nesse formulário e posteriormente enviada para a SEFAZ autorizadora.
- OFFLINE NFCe (mod 65), o xml é criado já em modo de contingência OFFLINE (tpEmis = 9) e a NFCe é impressa e posteriormente enviada para a SEFAZ autorizadora.
- EPEC NFe (mod 55), o xml é criado em modo de contingência EPEC, e usado para criar o evento EPEC, se o evento for aceito poderá ser usado conjuntamente com a NFe para imprimir a DANFE e posteriormente enviar a NFe para a SEFAZ autorizadora.  
- EPEC NFCe (mod 65) exclusivo para o estado de SP, o xml é criado em modo de contingência EPEC, e usado para criar o evento EPEC NFCe (apenas em SP), se o evento for aceito poderá ser usado conjuntamente com a NFCe para imprimir a DANFCE e posteriormente enviar a NFCe para a SEFAZ SP.

Como deve ser feito o processo no seu sistema:

1. ao entrar em contingência SVCAN ou SVCRS, sempre verifique se o webservice de contingência está ativo para o seu estado;
2. ative o modo de contingência e grave o json retornado em um cache ou base de dados, para habilitar seu uso continuo;
3. ao enviar uma NFe (mod 55), sempre verifique esse json no cache ou na base de dados, e o recarregue em Contingency::class
4. injete a Contingency::class na classe principal Tools::class
```php

$cert = Certificate::readPfx(file_get_contents('certificado.pfx'), 'senha');
//recarrega a contingencia que foi enteriormente ativada e gravada em cache
$cont = null;
if (!empty($json_contingencia_do_cache)) {
    $cont = new Contingency($json_contingencia_do_cache);
}    
//inicia o serviço da Tools::class em contingência se ela estiver ativa
$tools = new Tools($configJson, $cert, $cont);
$tools->model(55); 
```
5. ou carregue diretamente a proriedade publica da classe $tools->contingency 
```php
$cert = Certificate::readPfx(file_get_contents('certificado.pfx'), 'senha');
//recarrega a contingencia que foi enteriormente ativada e gravada em cache
$cont = null;
if (!empty($json_contingencia_do_cache)) {
    $cont = new Contingency($json_contingencia_do_cache);
}    
//inicia o serviço da Tools::class em contingência se ela estiver ativa
$tools = new Tools($configJson, $cert);
$tools->contingency = $cont;
$tools->model(55); 
```

## Habilitando o modo de contingência

```php
use NFePHP\NFe\Factories\Contingency;

$contingency = new Contingency();

$acronym = 'SP'; //Obrigatório
$motive = 'SEFAZ fora do AR'; //Obrigatório
$type = 'SVCAN'; //opcional, opções SVCAN ou SVCRS, se não informado será usado o tipo relativo à UF informada

$status = $contingency->activate($acronym, $motive, $type);

```
$status irá conter uma string JSON ENCODED, com as informações sobre a condição de contingência.

Como mostrado abaixo:

```json
{
   "motive":"SEFAZ fora do AR",
   "timestamp":1484747583,
   "type":"SVCAN",
   "tpEmis":6
}
```

Essa string deverá ser mantida, em disco, cache ou em base de dados para uso posterior, até que o modo de contingencia seja desabilitado. 
Ou seja, a cada vez que carregar a classe Tools deverá ser passada a classe Contingency, ou será considerado que o ambiente está normal.

Exemplo:

```php
$status_contingencia = '{
   "motive":"SEFAZ fora do AR",
   "timestamp":1484747583,
   "type":"SVCAN",
   "tpEmis":6
}';

$contingency = (new Contingency())->load($status_contingencia);
$tools->contingency = $contingency;
```

**Desabilitando o modo de contingência**

Você pode simplesmente apagar o registro anterior da string json da contigência ou desativa-la como indicado abaixo, e gravar onde estava registrada a anterior.

```php
//onde $status é a string json obtida quando entrou em modo de contingência.
$contingency = new Contingency($status);
$status = $contingency->deactivate(); ///grave o retorno no cache ou na base de dados

```
$status irá conter dados padrões em condições normais.
```json
{
   "motive":"",
   "timestamp":0,
   "type":"",
   "tpEmis":1
}
```
Essa string deverá ser arquivada, em disco ou em base de dados para uso posterior, ou apenas ignorada, e o arquivo ou registro da base de dados removida.


## Propriedades

public $type;

@var string
> Tipo da contingência apenas SVCAN, SVCRS 


public $motive;

@var string
> Motivo da entrada em contingência, texto com no minimo 15 caracteres e no máximo 255.

> NOTA: somente são aceitos caracteres UTF-8 e não devem ser usados simbolos.

public $timestamp;

@var int
>Timestmap do PHP que representa a data e hora em que a contigência foi ativada (GMT).


public $tpEmis;

@var int
> Codigo numerico que representa os tipos de contingência acima indicados. Esse codigo fará parte na montagem as NFe no campo &lt;tpEmis&gt;.


## Métodos

Construtor, caso seja passado o parametro, uma string JSON, a condição de contingência contida nessa string será registrada na classe.
Caso nada seja passado a classe irá considerar condição de emissão normal.
```php
$cont = new Contingency($string_Json_Contingencia);
```

Essa é outra forma de passar o parametro (string JSON) para a classe.
```php
$cont = (new Contingency())->load($string_Json_Contingencia);
```

Esse método ativa o modo de continência da classe.
Os parametros são:
```php
$sigla = 'SP'; //a sigla do estado do emitente da NFe
$motivo = 'SEFAZ SP fora do ar por problemas técnicos'; //motivo da entrada em contingencia de 15 a 256 caracteres UTF-8
$tipo = ''; //não é necessario de forma geral 
$cont = (new Contingency())->activate($sigla, $motivo, $tipo);
```

Esse método desativa o modo de contingência e retorna uma string json com os valores padrões.
```php
$sigla = 'SP'; //a sigla do estado do emitente da NFe
$motivo = 'SEFAZ SP fora do ar por problemas técnicos'; //motivo da entrada em contingencia de 15 a 256 caracteres UTF-8
$tipo = ''; //não é necessario de forma geral
$cont = new Contingency();
$status_json_contingencia_ativada = $cont->activate($sigla, $motivo, $tipo);

$status_json_contingencia_desativada = $cont->deactivate();
```
