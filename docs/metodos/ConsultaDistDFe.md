# CONSULTA DE DOCUMENTOS DESTINADOS

Consulta todos os documentos (NFe, e eventos) emitidos contra determinando CNPJ ou CPF (produtor rural)

**Função:** Serviço para consultar os documentos vinculados ao contribuinte e a ele detinados.

**Processo:** síncrono. A solicitação e o retorno ocorrem numa única fase.

**Método:** NfeDistribuicaoDFe

## Descrição
Permite consultar os documentos destinados em grupos usando o ultnsu, ou individualmente usando o numero único de NSU ou ainda a propria chave de acesso (44 digitos) do documento.

Para as buscas em grupo vide [DistDFe.md](DistDFe.md).

> NOTA: funciona somente para modelo 55 (NFe), e existem regras muito restritivas para seu uso. As consultas individuais estão limitadas a apenas 20 consultas por hora e no caso da consulta de grupo usnado o ultimo NSU recebido, deve ser realizado um loop com até 20 consulta por hora.
> NOTA: quando é mensionada a hora acima, significa que o INTERVALO entre as consultas deve ser de no mínimo UMA hora, terá de ser criado um controle interno no seu sistema para garantir esse intervalo minimo.

**Disponibilidade:** Todas as unidades autorizadoras de NFe, fornecem os dados para a Receita Federal disponibilizar, mas esse processo ocorre em batch e não em tempo real portanto pode haver um delay entre a autorização da NFe e a disponibilização na Receita Federal.

## Dependências

[NFePHP\Common\Certificate::class](Certificate.md)

[NFePHP\NFe\Tools::class](Tools.md)

[NFePHP\NFe\Common\Standardize::class](Standardize.md)


## Exemplo de Uso

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

try {

    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);
    $tools->model('55');

    $uf = 'SP';
    $cnpj = '00822602000111';
    $iest = '';
    $cpf = '';
    
    //consulta individual por numero NSU
    $response = $tools->sefazDistDFe(0, 1234);
    
    //consulta individual por chave da acesso
    $response = $tools->sefazDistDFe(0, 0, '12345678901234567890123456789012345678901234');

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
