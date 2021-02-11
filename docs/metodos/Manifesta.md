# MANIFESTAÇÃO DE DESTINATÁRIO

**Função:** Serviço destinado à recepção de mensagem de Evento da NF-e.

Este serviço permite que o destinatário da Nota Fiscal eletrônica confirme a sua participação na operação acobertada pela Nota Fiscal eletrônica emitida para o seu CNPJ, através do envio da mensagem de:

- *Confirmação da Operação* – confirmando a ocorrência da operação e o recebimento da mercadoria (para as operações com circulação de mercadoria);
- *Desconhecimento da Operação* – declarando o desconhecimento da operação;
- *Operação Não Realizada* – declarando que a operação não foi realizada (com recusa do Recebimento da mercadoria e outros) e a justificativa do porquê a operação não se realizou;
- *Ciência da Emissão (ou Ciência da Operação)* – declarando ter ciência da operação destinada ao CNPJ, mas ainda não possuir elementos suficientes para apresentar uma manifestação conclusiva, como as acima citadas. Este evento era chamado de Ciência da Operação.

O autor do evento é o destinatário da NF-e. A mensagem XML do evento será assinada com o certificado digital que tenha o CNPJ-Base (8 primeiras posições do CNPJ) do Destinatário da NF-e.

A ciência da emissão é um evento opcional que pode ser utilizado pelo destinatário para declarar que tem ciência da existência da operação, mas ainda não tem elementos suficientes para apresentar uma manifestação conclusiva.

O destinatário deve apresentar uma manifestação conclusiva dentro de um prazo máximo definido, contados a partir da data de autorização da NF-e.

**Processo:** síncrono.

**Método:** nfeRecepcaoEvento

**Lista de Eventos**
|Evento|Código|Justificativa Obrigatória?|
|------|:----:|-------------------------:|
|Confirmação da Operação|210200|Não|
|Ciência da Emissão|210210|Não|
|Desconhecimento da Operação|210220|Não|
|Operação não Realizada|210240|Sim|

## [Veja os Prazos para manifestação](PrazoManifestacao.md) 


## Exemplo de Uso

### public function sefazManifesta($chNFe,$tpEvento,$xJust = '',$nSeqEvento = 1)
Manifestação individual de uma nota fiscal. (processo usual)    

```php
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {
    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);
    $tools->model('55');

    $chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $tpEvento = '210210'; //ciencia da operação
    $xJust = ''; //a ciencia não requer justificativa
    $nSeqEvento = 1; //a ciencia em geral será numero inicial de uma sequencia para essa nota e evento

    $response = $tools->sefazManifesta($chNFe,$tpEvento,$xJust = '',$nSeqEvento = 1);
    //você pode padronizar os dados de retorno atraves da classe abaixo
    //de forma a facilitar a extração dos dados do XML
    //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
    //      quando houver a necessidade de protocolos
    $st = new Standardize($response);
    //nesse caso $std irá conter uma representação em stdClass do XML
    $stdRes = $st->toStd();
    //nesse caso o $arr irá conter uma representação em array do XML
    $arr = $st->toArray();
    //nesse caso o $json irá conter uma representação em JSON do XML
    $json = $st->toJson();
    

} catch (\Exception $e) {
    echo $e->getMessage();
}
```


### public function sefazManifestaLote($std)
Manifestação em LOTE de várias notas fiscais (até 20). (processo EVENTUAL)    

```php
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {
    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);
    $tools->model('55');

    $std = new stdClass();
    $std->evento[0] =  new stdClass();
    $std->evento[0]->chNFe = '02345678901234567890123456789012345678901234';
    $std->evento[0]->tpEvento = 210210; //evento ciencia da operação
    $std->evento[0]->xJust = null;
    $std->evento[0]->nSeqEvento = 1;
    
    $std->evento[1] =  new stdClass();
    $std->evento[1]->chNFe = '12345678901234567890123456789012345678901234';
    $std->evento[1]->tpEvento = 210210; //evento ciencia da operação
    $std->evento[1]->xJust = null;
    $std->evento[1]->nSeqEvento = 1;
    
    $std->evento[2] =  new stdClass();
    $std->evento[2]->chNFe = '22345678901234567890123456789012345678901234';
    $std->evento[2]->tpEvento = 210210; //evento ciencia da operação
    $std->evento[2]->xJust = null;
    $std->evento[2]->nSeqEvento = 1;
    
    $std->evento[3] =  new stdClass();
    $std->evento[3]->chNFe = '32345678901234567890123456789012345678901234';
    $std->evento[3]->tpEvento = 210210; //evento ciencia da operação
    $std->evento[3]->xJust = null;
    $std->evento[3]->nSeqEvento = 1;
    
    $std->evento[4] =  new stdClass();
    $std->evento[4]->chNFe = '42345678901234567890123456789012345678901234';
    $std->evento[4]->tpEvento = 210210; //evento ciencia da operação
    $std->evento[4]->xJust = null;
    $std->evento[4]->nSeqEvento = 1;
    
    $std->evento[5] =  new stdClass();
    $std->evento[5]->chNFe = '52345678901234567890123456789012345678901234';
    $std->evento[5]->tpEvento = 210210; //evento ciencia da operação
    $std->evento[5]->xJust = null;
    $std->evento[5]->nSeqEvento = 1;
    
    $std->evento[6] =  new stdClass();
    $std->evento[6]->chNFe = '62345678901234567890123456789012345678901234';
    $std->evento[6]->tpEvento = 210210; //evento ciencia da operação
    $std->evento[6]->xJust = null;
    $std->evento[6]->nSeqEvento = 1;    
    
    $std->evento[7] =  new stdClass();
    $std->evento[7]->chNFe = '72345678901234567890123456789012345678901234';
    $std->evento[7]->tpEvento = 210210; //evento ciencia da operação
    $std->evento[7]->xJust = null;
    $std->evento[7]->nSeqEvento = 1;
    
    $std->evento[8] =  new stdClass();
    $std->evento[8]->chNFe = '72345678901234567890123456789012345678901234';
    $std->evento[8]->tpEvento = 210240; //evento não realizada
    $std->evento[8]->xJust = 'Entrega de produto não solicitado.';
    $std->evento[8]->nSeqEvento = 2;
    
    $std->evento[9] =  new stdClass();
    $std->evento[9]->chNFe = '82345678901234567890123456789012345678901234';
    $std->evento[9]->tpEvento = 210200; //evento confirmação
    $std->evento[9]->xJust = null;
    $std->evento[9]->nSeqEvento = 1;        

    $response = $tools->sefazManifestaLote($std);

    //você pode padronizar os dados de retorno atraves da classe abaixo
    //de forma a facilitar a extração dos dados do XML
    //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
    //      quando houver a necessidade de protocolos
    $st = new Standardize($response);
    //nesse caso $std irá conter uma representação em stdClass do XML
    $stdRes = $st->toStd();
    //nesse caso o $arr irá conter uma representação em array do XML
    $arr = $st->toArray();
    //nesse caso o $json irá conter uma representação em JSON do XML
    $json = $st->toJson();
    

} catch (\Exception $e) {
    echo $e->getMessage();
}
```
