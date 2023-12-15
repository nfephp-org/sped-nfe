# EVENTO DE ATOR INTERESSADO (NT2020.007_v1.00a)

**Função:** Serviço destinado à recepção de mensagem de Evento da NF-e.

Este serviço permite que o emitente ou destinatário da Nota Fiscal eletrônica informe a identificação do Transportador a qualquer momento, como uma das pessoas autorizadas a acessar o XML da NF-e.

No momento da emissão da NF-e, muitas vezes o emitente ainda não definiu o Transportador que ficará responsável pela entrega da mercadoria, impedindo, portanto, que essa informação conste em campo específico da NF-e (tag: CNPJ/CPF, id: X04/X05), ou mesmo no grupo de pessoas autorizadas a acessar o XML da NF-e (tag: autXML, Id: GA01). Em vários outros casos, o responsável pelo transporte é o destinatário e, nesses casos, o Emitente não tem condições de informar o Transportador no XML da NF-e

No caso em que o transporte não é de responsabilidade do Emitente, o Destinatário poderá gerar o evento, com o mesmo objetivo de autorizar que o Transportador fique autorizado a acessar o XML da NF-e. 

Nos casos de Redespacho ou Subcontratação, definido o transportador contratado, este poderá também autorizar outro transportador participante da mesma operação de transporte a acessar o XML da NF-e.

O Transportador precisa dos dados da NF-e para instrumentalizar seus processos de transporte e, a partir da geração deste evento, possibilita o transportador em buscar o XML da NF-e no Ambiente Nacional, por meio do “Web Service de Distribuição de DF-e de Interesse dos Atores da NF-e”, conforme documentado na NT2014.002

**Processo:** síncrono.

**Método:** nfeRecepcaoEvento

## Exemplo de Uso

### public function sefazAtorInteressado($std)
Inclui atores interessados (transportadores permitindo oou não a baixar o xml da NFe), conforme descrito na documentação da SEFAZ

```php
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {
    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);
    $tools->model('55');

    $std = new \stdClass();
    $std->chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $std->tpAutor = 1; //1-emitente 2-destinatário 3-transportador indica quem está incluindo ou removendo atores
    $std->verAplic = '1.2.3'; //versão da aplicação que está gerando o evento
    $std->nSeqEvento = 1; //numero sequencial do evento, incrementar ao incluir outros ou remover
    $std->tpAutorizacao = 1; //0-não autorizo ou 1-autorizo
    $std->CNPJ = '12345678901234';
    $std->CPF = null;
    
    $response = $tools->sefazAtorInteressado($std);

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


