# CONSULTA PELA CHAVE
Consulta situação atual da NF-e

**Função:** Serviço destinado ao atendimento de solicitações de consulta da situação atual da NF-e na Base de Dados do Portal da Secretaria de Fazenda Estadual.

**Processo:** síncrono.

**Método:** nfeConsulta

## Descrição

A consulta pela chave é um recurso que deve ser usado normalmente nas seguintes situações:

1. Para verificar a situação e dados do protocolo de notas recebidas de terceiros.

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

    $chave = '52170522555994000145550010000009651275106690';
    $response = $tools->sefazConsultaChave($chave);

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



