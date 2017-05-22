# Número sequencial de Eventos

Sempre que um evento, qualquer que seja for gerado, será solicitado que um numero sequencial seja fornecido pelo emitente.

Isso se deve ao fato que alguns eventos permitem multiplas ocorrências, notadamente:

- [Carta de Correção - CCe](CartaCorrecao.md)
- [EPP - Solicitação de Prorrogação](EPP.md)

## Como gerar esse numero sequencial?

O numero sequencial do evento será inicialmente sempre "1" e será incrementado (em uma unidade), sempre que houver um novo evento de mesmo tipo para uma mesma NFe.

Por exemplo:

Foi feita uma carta de correção para a NFe n. 1234, foi a primeira CCe, então:

| NFe | Evento | Seq | Motivo |
| :---: | :---:  | :---: | :--- |
| 1234 | 110110 | **1** | Erro de digitação no nome do produto |

Caso seja necessária uma segunda carta de correção, então :

| NFe | Evento | Seq | Motivo |
| :---: | :---:  | :---: | :--- |
| 1234 | 110110 | 1 | Erro de digitação no nome do produto |
| 1234 | 110110 | **2** | Erro na informação adicional da NFe; Erro de digitação no nome do produto |

> Portanto **deve existir** um controle sobre esses eventos, para cada NFe e se forem gerados eventos repetidos, esse numero de controle "sequencial" deverá ser incrementado.

Agora vamos pedir uma prorrogação de prazo de isenção de ICMS, um EPP, sobre essa mesma nota de remessa para industrialização:

| NFe | Evento | Seq | Motivo |
| :---: | :---:  | :---: | :--- |
| 1234 | 110110 | 1 | Erro de digitação no nome do produto |
| 1234 | 110110 | 2 | Erro na informação adicional da NFe; Erro de digitação no nome do produto |
| 1234 | 111500 | **1** | Solitação de prorrogação de prazo itens 1,2 | 

E se houverem mais solicitações de prorrogação: 

| NFe | Evento | Seq | Motivo |
| :---: | :---:  | :---: | :--- |
| 1234 | 110110 | 1 | Erro de digitação no nome do produto |
| 1234 | 110110 | 2 | Erro na informação adicional da NFe; Erro de digitação no nome do produto |
| 1234 | 111500 | 1 | Solitação de prorrogação de prazo itens 1,2 | 
| 1234 | 111501 | **1** | Solitação de prorrogação de 2o prazo item 1 | 
| 1234 | 111500 | **2** | Solitação de prorrogação de prazo itens 3,7 | 
| 1234 | 111501 | **2** | Solitação de prorrogação de 2o prazo item 2 | 

> Veja que no caso da solicitação de prorrogação, passam a ser pertinentes também os **itens da NFe** que estão sendo declarados nessa solicitação.

**Que inhaca !!**
