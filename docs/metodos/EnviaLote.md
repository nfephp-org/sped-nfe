# ENVIO DO LOTE DE NFe

**Função:** serviço destinado à recepção de mensagens de lote de NF-e.

**Processo:** assíncrono.

**Método:** nfeAutorizacaoLote


```php
use NFePHP\NFe\Convert;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {
    $st = new Standardize();
    $tools = new Tools($configJson, Certificate::readPfx($content, 'fima'));
    $idLote = str_pad($nfemit->id, 15, '0', STR_PAD_LEFT);
    //envia o xml para pedir autorização ao SEFAZ
    $resp = $this->tools->sefazEnviaLote([$xml], $idLote);
    //transforma o xml de retorno em um stdClass
    $std = $st->toStd($resp);
    if ($std->cStat != 103) {
        //erro registrar e voltar
        return "[$std->cStat] $std->xMotivo";
    }
    $recibo = $std->infRec->nRec;
    //esse recibo deve ser guardado para a proxima operação que é a consulta do recibo
    header('Content-type: text/xml; charset=UTF-8');
    echo $resp;
} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}

```