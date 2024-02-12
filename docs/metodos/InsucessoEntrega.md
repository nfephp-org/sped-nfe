# Registro de Insucesso na Entrega da Mercadoria

**Função:** Evento fiscal da NF-e visa registrar as operações de transporte que ocorreram, mas que por algum motivo (recusa do destinatário ou a sua não localização, por exemplo), não foi possível a conclusão do serviço com a efetivação da entrega da mercadoria ao recebedor.

**Processo:** síncrono.

**Método:** nfeRecepcaoEvento

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {
    //$content = conteúdo do certificado PFX
    $tools = new Tools($configJson, Certificate::readPfx($content, 'senha'));
    
    //dados do evento de insucesso na entrega
    $std = new \stdClass();
    //$std->verAplic = '1.2.3'; //opcional se declarado anteriormente - versão da aplicação que está gerando o evento
    $std->nSeqEvento = 1;
    $std->chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $std->imagem = 'kakakakakakakakak'; // aqui pode ser colocada uma imagem ou uma string que fará parte do hash
    $std->latitude = null;
    $std->longitude = null;
    $std->data_tentativa = '2021-04-25T10:34:13-03:00'; //data de recebimento
    $std->tentativas = 3;
    $std->tipo_motivo = 1;
        //1 – Recebedor não encontrado
        //2 – Recusa do recebedor
        //3 – Endereço inexistente
        //4 – Outros (exige informar justificativa)
    $std->justificativa = null;
    $std->cancelar = false; //permite cancelar um registro de insucesso de entrega se for true

    $response = $tools->sefazInsucessoEntrega($std);
    
    //transforma o xml de retorno em um stdClass
    $st = new Standardize();
    $std = $st->toStd($xmlResp);

    //verifique se o evento foi processado
    if ($std->cStat != 128) {
        //houve alguma falha e o evento não foi processado
        //TRATAR
    } else {
        $cStat = $std->retEvento->infEvento->cStat;
        if ($cStat == '135' || $cStat == '136') {
            //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
            $xml = Complements::toAuthorize($tools->lastRequest, $xmlResp);
            //grave o XML protocolado 
        } else {
            //houve alguma falha no evento 
            //TRATAR
        }
    }  
} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}
```

# Cancelamento de evento de Insucesso na Entrega

**Função:** Cancelar o evento de insucesso na entrega anteriormente autorizado

**Processo:** síncrono.

**Método:** nfeRecepcaoEvento

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {
    //$content = conteúdo do certificado PFX
    $tools = new Tools($configJson, Certificate::readPfx($content, 'senha'));
    
    //dados do evento de insucesso na entrega
    $std = new \stdClass();
    //$std->verAplic = '1.2.3'; //opcional se declarado anteriormente - versão da aplicação que está gerando o evento
    $std->nSeqEvento = 1;
    $std->chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $std->protocolo = '123456789012345'; //protocolo de autoriação do evento que se deseja cancelar
    $std->cancelar = true; //permite cancelar um registro de insucesso de entrega se for true

    $response = $tools->sefazInsucessoEntrega($std);
    
    //transforma o xml de retorno em um stdClass
    $st = new Standardize();
    $std = $st->toStd($xmlResp);

    //verifique se o evento foi processado
    if ($std->cStat != 128) {
        //houve alguma falha e o evento não foi processado
        //TRATAR
    } else {
        $cStat = $std->retEvento->infEvento->cStat;
        if ($cStat == '135' || $cStat == '136') {
            //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
            $xml = Complements::toAuthorize($tools->lastRequest, $xmlResp);
            //grave o XML protocolado 
        } else {
            //houve alguma falha no evento 
            //TRATAR
        }
    }  
} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}
```

