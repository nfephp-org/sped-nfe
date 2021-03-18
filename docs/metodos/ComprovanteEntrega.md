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
    $std->chave = '12345678901234567890123456789012345678901234';
    $std->verAplic = '1.0.0';
    $std->data_recebimento = '2021-03-18T12:45:29-03:00';
    $std->documento_recebedor = '12345678901';
    $std->nome_recebedor = 'Fulano de Tal';
    $std->latitude = null;
    $std->longitude = null;
    $std->imagem = null;
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
