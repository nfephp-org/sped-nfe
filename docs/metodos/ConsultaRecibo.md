# CONSULTA PELO RECIBO


**Função:** serviço destinado a retornar o resultado do processamento do lote de NF-e.

A mensagem de retorno poderá ser utilizada pela SEFAZ para enviar mensagens de interesse da SEFAZ para o emissor.

**Processo:** assíncrono.

**Método:** nfeRetAutorizacao


```php
use NFePHP\NFe\Convert;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {
    //$content = conteúdo do certificado PFX
    $tools = new Tools($configJson, Certificate::readPfx($content, 'senha'));
    
    //consulta número de recibo
    //$numeroRecibo = número do recíbo do envio do lote
    $xmlResp = $tools->sefazConsultaRecibo($numeroRecibo, $tpAmb);
    
    //transforma o xml de retorno em um stdClass
    $st = new Standardize();
    $std = $st->toStd($xmlResp);

    if($std->cStat=='103') { //lote enviado
        //Lote ainda não foi precessado pela SEFAZ;
    }
    if($std->cStat=='105') { //lote em processamento
        //tente novamente mais tarde
    }
    
    if($std->cStat=='104'){ //lote processado (tudo ok)
        if($std->protNFe->infProt->cStat=='100'){ //Autorizado o uso da NF-e
            $return = ["situacao"=>"autorizada",
                       "numeroProtocolo"=>$std->protNFe->infProt->nProt,
                       "xmlProtocolo"=>$xmlResp];
        }elseif(in_array($std->protNFe->infProt->cStat,["302"])){ //DENEGADAS
            $return = ["situacao"=>"denegada",
                       "numeroProtocolo"=>$std->protNFe->infProt->nProt,
                       "motivo"=>$std->protNFe->infProt->xMotivo,
                       "cstat"=>$std->protNFe->infProt->cStat,
                       "xmlProtocolo"=>$xmlResp];
        }else{ //não autorizada (rejeição)
            $return = ["situacao"=>"rejeitada",
                       "motivo"=>$std->protNFe->infProt->xMotivo,
                       "cstat"=>$std->protNFe->infProt->cStat];
        }
    } else { //outros erros possíveis
        $return = ["situacao"=>"rejeitada",
                   "motivo"=>$std->xMotivo,
                   "cstat"=>$std->cStat];
    }
    
} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}

```
