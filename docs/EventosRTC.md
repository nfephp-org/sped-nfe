# Eventos RTC

- Conforme NT 2025.002 v1.20 
- 14 novos eventos de NFe


## Evento: Informação de efetivo pagamento integral para liberar crédito presumido do adquirente
> Função: Permitir que o emitente da NFe informe o efetivo pagamento integral a fim de liberar crédito presumido do adquirente\
Modelo: NF-e modelo 55\
Autor do Evento: Emitente da NFe\
Código do Tipo de Evento: 112110

### Método sefazInfoPagtoIntegral();

```php
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1;  //opcional DEFAULT = 1
    
    $response = $tools->sefazInfoPagtoIntegral($std);
```

## Evento: Solicitação de Apropriação de crédito presumido
> Função: Evento a ser gerado pelo adquirente em relação às notas fiscais de aquisição de emissão de terceiros e que lhe gerem o dire ito à apropriação
de crédito presumido.\
Autor: Adquirente/Destinatário (quando os dois estiverem preenchidos, devem ser iguais) da nota fiscal\
Modelo: NF-e modelo 55\
Código do Tipo de Evento: 211110

### Método sefazSolApropCredPresumido();

```php
    $itens = []; //de 1 até 990 itens
    $itens[1] = [
        'item' => 1,
        'vBC' => 100.00,
        'gIBS' => [
            'cCredPres' => '01',
            'pCredPres' => 2.5000,
            'vCredPres' => 2.50
        ],
        'gCBS' => [
            'cCredPres' => '01',
            'pCredPres' => 2.5000,
            'vCredPres' => 2.50
        ]
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857';
    //$std->nSeqEvento = 1;  //opcional DEFAULT = 1
    $std->itens = json_decode(json_encode($itens));
    
    $response = $tools->sefazSolApropCredPresumido($std);
```

## Evento: Destinação de item para consumo pessoal
> Função: Permitir ao adquirente informar quando uma aquisição for destinada para o consumo de pessoa física, hipótese em que não haverá direito à
apropriação de crédito. Evento a ser registrado após a emissão da nota de bens destinados para uso e consumo pessoal.
Uma mesma NFe de aquisição pode receber vários Eventos desse tipo, com nSeqEvento diferentes (eventos cumulativos).\
Modelo: NF-e modelo 55\
Autor do Evento: Destinatário da NF-e\
Código do Tipo de Evento: 211120

### Método sefazDestinoConsumoPessoal()

```php
    $itens = []; //de 1 até 990 itens
    $itens[] = [
        'item' => 1,
        'vIBS' => 10.00,
        'vCBS' => 10.00,
        'quantidade' => 10.0000,
        'unidade' => 'PC',
        'chave' => '35250530057049000141550010000280181030656857',
        'nItem' => 1
    ];
    $itens[] = [
        'item' => 2,
        'vIBS' => 123.45,
        'vCBS' => 45.76,
        'quantidade' => 1.0000,
        'unidade' => 'PC',
        'chave' => '35250530057049000141550010000280181030656857',
        'nItem' => 2
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    $std->tpAutor = 2; //OBRIGATÓRIO
    //Caso NF-e de Importação, informar 1-Empresa Emitente, nos demais casos 2-Empresa destinatária.
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $std->itens = json_decode(json_encode($itens));
    
    $response = $tools->sefazDestinoConsumoPessoal($std);
```

## Evento: Aceite de débito na apuração por emissão de nota de crédito
> Função: Permitir ao destinatário informar que concorda com os valores constantes em nota de crédito emitida pelo fornecedor ou pelo adquirente que
serão lançados a débito na apuração assistida de IBS e CBS\
Modelo: NF-e modelo 55\
Autor do Evento: Destinatário da NF-e\
Código do Tipo de Evento: 211128

### Método sefazAceiteDebito()

```php
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1;  //opcional DEFAULT = 1
    
    $response = $tools->sefazAceiteDebito($std);
```

## Evento: Imobilização de Item
> Função: Evento a ser gerado pelo adquirente de bem, quando este for integrado ao seu ativo imobilizado, a fim de viabilizar a adequada identificação,
pelos sistemas da administração tributária, de prazo-limite para apreciação de eventuais pedidos de ressarcimento do respectivo crédito, nos termos
do art. 40, I da LC 214/2025.\ 
Modelo: NF-e modelo 55\
Autor do Evento: Destinatário da NF-e (Adquirente)\
Código do Tipo de Evento: 211130

### Método sefazImobilizacaoItem()

```php
    $itens = []; //de 1 até 990 itens
    $itens[] = (object)[
        'item' => 1,
        'vIBS' => 10.00,
        'vCBS' => 10.00,
        'quantidade' => 10.0000,
        'unidade' => 'PC'
    ];
    $itens[] = (object)[
        'item' => 2,
        'vIBS' => 1234.32,
        'vCBS' => 786.20,
        'quantidade' => 1.0000,
        'unidade' => 'UN'
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $std->itens = $itens;

    $response = $tools->sefazImobilizacaoItem($std);
```

## Evento: Solicitação de Apropriação de Crédito de Combustível
> Função: Evento a ser gerado pelo adquirente de combustível listado no art. 172 da LC 214/2025 e que pertença à cadeia produtiva desses
combustíveis, para solicitar a apropriação de crédito referente à parcela que for consumida em sua atividade comercial.\
Modelo: NF-e modelo 55\
Autor do Evento: Destinatário da NF-e (Adquirente de combustível que faça parte da cadeia produtiva de combustíveis)\
Código do Tipo de Evento: 211140

### Método sefazApropriacaoCreditoComb()

```php
    $itens = []; //de 1 até 990 itens
    $itens[] = [
        'item' => 1,
        'vIBS' => 10.00,
        'vCBS' => 10.00,
        'quantidade' => 10.0000,
        'unidade' => 'LT'
    ];
    $itens[] = [
        'item' => 2,
        'vIBS' => 210.00,
        'vCBS' => 210.00,
        'quantidade' => 210.0000,
        'unidade' => 'LT'
    ];
    $itens[] = [
        'item' => 3,
        'vIBS' => 1210.00,
        'vCBS' => 1210.00,
        'quantidade' => 1210.0000,
        'unidade' => 'LT'
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $std->itens = json_decode(json_encode($itens));

    $response = $tools->sefazApropriacaoCreditoComb($std);
```

## Evento: Solicitação de Apropriação de Crédito para bens e serviços que dependem de atividade do adquirente
> Função: Evento a ser gerado pelo adquirente para apropriação de crédito de bens e serviços que dependam da sua atividade\
Modelo: NF-e modelo 55\
Autor do Evento: Destinatário da NFe (adquirente).\
Código do Tipo de Evento: 211150

### Método sefazApropriacaoCreditoBens()

```php
    $itens = []; //de 1 até 990 itens
    $itens[] = [
        'item' => 1,
        'vIBS' => 10.00,
        'vCBS' => 10.00,
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $std->itens = json_decode(json_encode($itens));

    $response = $tools->sefazApropriacaoCreditoBens($std);
```

## Evento: Manifestação sobre Pedido de Transferência de Crédito de IBS em Operações de Sucessão
> Função: Evento a ser gerado pela sucessora em relação às notas fiscais de transferência de crédito de outra sucessora da mesma empresa sucedida
para informar aceite da transferência de crédito de IBS.\
Autor: Empresa sucessora\
Modelo: NF-e modelo 55\
Código do Tipo de Evento: 212110

### Método sefazManifestacaoTransfCredIBS()

```php
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $response = $tools->sefazManifestacaoTransfCredIBS($std);
```

## Evento: Manifestação sobre Pedido de Transferência de Crédito de CBS em Operações de Sucessão
> Função: Evento a ser gerado pela sucessora em relação às notas fiscais de transferência de crédito de outra sucessora da mesma empresa sucedida
para informar aceite da transferência de crédito de CBS.\
Autor: Empresa sucessora\
Modelo: NF-e modelo 55\
Código do Tipo de Evento: 212120

### Método sefazManifestacaoTransfCredCBS()

```php
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $response = $tools->sefazManifestacaoTransfCredCBS($std);
```

## Evento: Cancelamento de Evento
> Função: Permitir que o autor de um Evento já autorizado possa proceder o seu cancelamento.\
Modelo: NF-e modelo 55\
Autor do Evento: O mesmo Autor do Evento que está sendo cancelado.\
Tipo de Evento (Código - Descrição): 110001 - Cancelamento de Evento

### Método sefazCancelaEvento()

```php
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    $std->tpAutor = 1;  //OBRIGATÓRIO deve ser o mesmo que criou o evento a ser cancelado
    $std->tpEventoAut = '112110';  //OBRIGATÓRIO tipo do evento a ser cancelado
    $std->nProtEvento = '123456789012345';  //OBRIGATÓRIO numero do protocolo de autorização do evento a ser cancelado
    $response = $tools->sefazCancelaEvento($std);
```
|cStat|Erro|Correção|
|:---:|:---|:---|
|459|Rejeição: Cancelamento de Evento inexistente|Verificar os paramêtros e ver se não errou a chNFe e o tipo de evento|
|1113|Rejeição: Autor do Evento de Cancelamento diverge do Autor do Evento a ser cancelado|Corrija o autor do evento|
|460|Rejeição: Protocolo do Evento difere do cadastrado|Corrija o numero do protocolo|


## Evento: Importação em ALC/ZFM não convertida em isenção
> Função: Permitir que o adquirente das regiões incentivadas (ALC/ZFM) informe que a tributação na importação não se converteu em isenção de um
determinado item por não atender as condições da legislação.\
Modelo: NF-e modelo 55\
Autor do Evento: emitente da NFe (adquirente)\
Código do Tipo de Evento: 112120

### Método sefazImportacaoZFM()

```php
    $itens = [];
    $itens[] = (object)[
        'item' => 1,
        'vIBS' => 10.00,
        'vCBS' => 10.00,
        'quantidade' => 10,
        'unidade' => 'PC'
    ];
    $itens[] = (object)[
        'item' => 2,
        'vIBS' => 1234.32,
        'vCBS' => 786.20,
        'quantidade' => 1,
        'unidade' => 'UN'
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $std->itens = $itens;

    $response = $tools->sefazImportacaoZFM($std);
```

## Evento: Perecimento, perda, roubo ou furto durante o transporte contratado pelo adquirente
> Função: Permitir ao adquirente informar quando uma aquisição for objeto de roubo, perda, furto ou perecimento.
Observação: O evento atual está relacionado aos bens que foram objeto de perecimento, perda, roubo ou furto em trânsito, em fornecimentos com
frete FOB.\
Modelo: NF-e modelo 55\
Autor do Evento: Destinatário da NF-e em notas de saída\
Código do Tipo de Evento: 211124


### Método sefazRouboPerdaTransporteAdquirente()

```php
    $itens = [];
    $itens[] = (object)[
        'item' => 1,
        'vIBS' => 10.00,
        'vCBS' => 10.00,
        'quantidade' => 10,
        'unidade' => 'PC'
    ];
    $itens[] = (object)[
        'item' => 2,
        'vIBS' => 1234.32,
        'vCBS' => 786.20,
        'quantidade' => 1,
        'unidade' => 'UN'
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $std->itens = $itens;

    $response = $tools->sefazRouboPerdaTransporteAdquirente($std);
```

## Evento: Perecimento, perda, roubo ou furto durante o transporte contratado pelo fornecedor
> Função: Permitir ao fornecedor informar quando um bem for objeto de roubo, perda, furto ou perecimento antes da entrega, durante o transporte
contratado pelo fornecedor.\
Observação: O evento atual está relacionado aos bens móveis materiais que foram objeto de perecimento, perda, roubo ou furto em trânsito, em
fornecimentos com frete CIF.\
Modelo: NF-e modelo 55\
Autor do Evento: emitente da NF-e em notas de saída.\
Código do Tipo de Evento: 112130

### Método sefazRouboPerdaTransporteFornecedor()

```php
    $itens = [];
    $itens[] = (object)[
        'item' => 1,
        'vIBS' => 10.00,
        'vCBS' => 10.00,
        'quantidade' => 10,
        'unidade' => 'PC'
    ];
    $itens[] = (object)[
        'item' => 2,
        'vIBS' => 1234.32,
        'vCBS' => 786.20,
        'quantidade' => 1,
        'unidade' => 'UN'
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $std->itens = $itens;

    $response = $tools->sefazRouboPerdaTransporteFornecedor($std);
```

## Evento: Fornecimento não realizado com pagamento antecipado
> Função: Permitir ao fornecedor informar que um pagamento antecipado não teve o respectivo fornecimento realizado.\
Modelo: NF-e modelo 55\
Autor do Evento: emitente da NF-e de nota de débito do tipo 06 = Pagamento antecipado\
Código do Tipo de Evento: 112140

### Método sefazFornecimentoNaoRealizado()

```php
    $itens = [];
    $itens[] = (object)[
        'item' => 1,
        'vIBS' => 10.00,
        'vCBS' => 10.00,
        'quantidade' => 10,
        'unidade' => 'PC'
    ];
    $itens[] = (object)[
        'item' => 2,
        'vIBS' => 1234.32,
        'vCBS' => 786.20,
        'quantidade' => 1,
        'unidade' => 'UN'
    ];
    $std = new stdClass();
    $std->chNFe = '35250530057049000141550010000280181030656857'; //OBRIGATÓRIO
    //$std->nSeqEvento = 1; //opcional DEFAULT = 1
    $std->itens = $itens;

    $response = $tools->sefazFornecimentoNaoRealizado($std)
```
