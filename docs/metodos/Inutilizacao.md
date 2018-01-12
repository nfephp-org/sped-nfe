# INUTILIZAÇÃO DE FAIXA DE NUMEROS DE NFe

**Função:** serviço destinado ao atendimento de solicitações de inutilização de numeração.

**Processo:** síncrono.

**Método:** nfeInutilizacao

## Descrição
Este método será responsável por receber as solicitações referentes à inutilização de faixas de numeração de notas fiscais eletrônicas. Ao receber a solicitação, a aplicação NFE realiza o processamento da solicitação e devolve o resultado do processamento para o aplicativo do transmissor.

A mensagem de pedido de inutilização de numeração de NF-e é um documento eletrônico e deve ser assinado digitalmente pelo emitente da NF-e.

## Dependências

[NFePHP\Common\Certificate::class](Certificate.md)

[NFePHP\NFe\Tools::class](Tools.md)

[NFePHP\NFe\Common\Standardize::class](Standardize.md)

## Exemplo de Uso

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Complements;

try {

    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);

    $nSerie = '1';
    $nIni = '116698';
    $nFin = '116700';
    $xJust = 'Erro de digitação dos números sequencias das notas'
    $response = $tools->sefazInutiliza($nSerie, $nIni, $nFin, $xJust);

    //você pode padronizar os dados de retorno atraves da classe abaixo
    //de forma a facilitar a extração dos dados do XML
    //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
    //      quando houver a necessidade de protocolos
    $stdCl = new Standardize($response);
    //nesse caso $std irá conter uma representação em stdClass do XML
    $std = $stdCl->toStd();
    //nesse caso o $arr irá conter uma representação em array do XML
    $arr = $stdCl->toArray();
    //nesse caso o $json irá conter uma representação em JSON do XML
    $json = $stdCl->toJson();
    
} catch (\Exception $e) {
    echo $e->getMessage();
}

```

## Parametros

| Variável | Detalhamento  |
| :---:  | :--- |
| $configJson | String Json com os dados de configuração (OBRIGATÓRIO) |
| $content | String com o conteúdo do certificado PFX (OBRIGATÓRIO) |
| $certificado | Classe Certificate::class contendo o certificado digital(OBRIGATÓRIO)  |
| $nSerie | Série da NF-e (OBRIGATÓRIO) |
| $nIni | Número da NF-e inicial a ser inutilizada (OBRIGATÓRIO) |
| $nFin | Número da NF-e final a ser inutilizada (OBRIGATÓRIO) |
| $xJust | Informar a justificativa do pedido de inutilização (OBRIGATÓRIO) |


## SUCESSO

A consulta com sucesso poderá resultar:

| cStat | xMotivo |
| :---: | :--- | 
| 102 | Inutilizacao de numero homologado |
