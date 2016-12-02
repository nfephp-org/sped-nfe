#CONTINGENCY
Em condições normais as NFe emitidas tem a propriedade &lt;tpEmis&gt; com o valor igual a 1, ou seja emissão normal.
Quando a conexão via internet com a SEFAZ autorizadora não é possivel existem alternativas para permitir a emissão dos documentos mesmo nessas condições.

Ao ativar qualquer contigência o XML da NFe deve ser remontado ou modificado e assinado novamente com as seguintes alterações:
- &lt;tpEmis&gt; indicar o numero do modo de contingência utilizado
- &lt;dhCont&gt; Data e Hora da entrada em contingência no formato com TZD
- &lt;xJust&gt; Justificativa da entrada em contingência com 15 até 256 caracteres

###~~FS-IA IMPRESSOR AUTÔNOMO (tpEmis = 2 OBSOLETO)~~
Este modo de contingência permite que a NFe seja emitida sem que haja a prévia autorização pela SEFAZ autorizadora através da impressão do DANFE em formulário de segurança de impressor autônomo.
**Uso: Não maus usado**
**Este modelo de contingência está desabilitado desde 2011. E não pode mais ser usado**
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 2

###~~SCAN (tpEmis = 3 OBSOLETO)~~
Sistema de Contingência do Ambiente Nacional, **este serviço foi desabilitado e portanto não está mais disponivel para uso**.
**Uso: Não maus usado**
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 3

###~~DPEC (tpEmis = 4 OBSOLETO)~~
Declaração Prévia da Emissão em Contingência
Este tipo de contingência foi substituido pelo modo EPEC que utiliza eventos para registrar a emissão. Veja EPEC.
**Uso: Não maus usado**
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 4

###EPEC (tpEmis = 4)
Evento Prévio da Emissão em Contingência
**Uso: SEFAZ OFF e SVC OFF mas emitente com acesso à internet.**
Este mode em contingência é diferente dos demais por que na verdade irá enviar um evento especifico para o webservices de Registro de Eventos do Ambiente Nacional. Normalmente usa-se esse tipo de contingência em caso da SEFAZ autorizadora estar fora do ar, bem como o Serviço Virtual de Contingência também, e isso é uma situação muito rara de ocorrer.
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 4


###FS-DA DOCUMENTO AUXILIAR (tpEmis = 5)
Este modo de contingência permite que a NFe seja emitida sem que haja a prévia autorização pela SEFAZ autorizadora através da impressão do DANFE em formulário de segurança.
**Uso: Sem acesso a internet.**
Este modo de contingência permite que a NFe seja emitida sem que haja a prévia autorização pela SEFAZ autorizadora através da impressão do DANFE em formulário de segurança.
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 2
>Não é recomendável o uso desse tipo de contingência, por vários motivos. O primeiro é o custo, pois os formulários de segurança são caros e deve-se manter controle estrito sobre os mesmos, pois cada folha é identifica individualmente e pode ser usada indevidamente.
>Devemos considerar também a necessidade adicional de controle dessas notas e posterior envio à SEFAZ autorizadora qunado o sistema estiver novamente on-line.
>Outro motivo é a possibilidade de a NFe ser reprovada após o processo posterior de envio a SEFAZ autorizadora, com isso o tranporte e recebimento da mercadoria se torna uma operção "ilegal" e sujeita a punições.
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 5

###SVC-AN (tpEmis = 6)
SEFAZ Virtual de Contingência do Ambiente Nacional
Este sistema de contingência é o melhor de todos e permite que as notas sejam emitidas com poucas altereções e sem a necessidade de reenvio posterior. Nesse modo as motas enviadas serão sincronizadas automaticamente pelos orgãos autorizadores sem a necessidade que qualquer outra ação pelo emitente. Este serviço atende:
AC, AL, AP, DF, ES, MG, PB, RJ, RN, RO, RR, RS, SC, SE, SP, TO 
**Uso: SEFAZ OFF, mas emitente com acesso à internet.**
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 6

###SVC-RS (tpEmis = 7)
SEFAZ Virtual de Contingência do RS
Este sistema de contingência é o melhor de todos e permite que as notas sejam emitidas com poucas altereções e sem a necessidade de reenvio posterior. Nesse modo as motas enviadas serão sincronizadas automaticamente pelos orgãos autorizadores sem a necessidade que qualquer outra ação pelo emitente. Este serviço atende:
AM, BA, CE, GO, MA, MS, MT, PA, PE, PI, PR
**Uso: SEFAZ OFF, mas emitente com acesso à internet.**
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 7

###OFF-LINE (tpEmis = 9 NFCe)
Para a NFC-e somente estão disponíveis e são válidas as opções de contingência 5 (FS-DA) e 9 (OFF-LINE).
>*IMPORTANTE*: Esse modo de contingência serve exclusivamente para as notas modelo 65 e não podem ser usadas em notas modelo 55.
**Uso: SEFAZ OFF, mas emitente com acesso à internet.**
Nesse caso o xml da NFe deve indicar na propriedade &lt;tpEmis&gt; o valor 9

#Class Contingency

