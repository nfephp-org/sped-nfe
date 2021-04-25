# COMPROVANTE DE ENTREGA DE NFE (NT 2021_001_v1_00)


**Função:** serviço destinado a informar que a NFe foi entregue (canhoto eletôrnico).


**Processo:** síncrono.

**Método:** nfeRecepcaoEvento


```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {
    //$content = conteúdo do certificado PFX
    $tools = new Tools($configJson, Certificate::readPfx($content, 'senha'));
    
    //evento de comprovante de entregua
    $std = new \stdClass();
    $std->chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $std->imagem = 'kakakakakakakakak'; // aqui pode ser colocada uma imagem ou uma string que fará parte do hash 
    $std->nSeqEvento = 1;
    $std->verAplic = '1.2.3'; //versão da aplicação que está gerando o evento
    $std->data_recebimento = '2021-04-25T10:34:13-03:00'; //data de recebimento
    $std->documento_recebedor = '12345678901'; //numero do documento do recebedor
    $std->nome_recebedor = 'Jose da Silva';
    $std->latitude = -23.61849;
    $std->longitude = -46.60987;
    $std->cancelar = false; //permite cancelar um comprovante de entrega se for true
    
    $xmlResp = $tools->sefazComprovanteEntrega($std);
    
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
            $xml = Complements::toAuthorize($tools->lastRequest, $response);
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
