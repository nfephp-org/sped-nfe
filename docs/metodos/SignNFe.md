# ASSINATURA DE NFe

Realiza a ssinatura digital do XML com o certificado A1.

**Função:** Para um documento ser aceito pelas SEFAZ é necessária a assinatura para a garantia de autenticidade.

> NOTA: este processo deve ser realizado sempre antes do envio de uma NFe.

## Dependências

[NFePHP\Common\Certificate::class](Certificate.md)

[NFePHP\NFe\Tools::class](Tools.md)

## Exemplo de Uso 

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;

try {
    $tools = new Tools($configJson, Certificate::readPfx($content, $password));
    $response = $tools->signNFe($xml);
   
} catch (\Exception $e) {
    //aqui você trata possiveis exceptions
    echo $e->getMessage();
}    
```

## Parametros

| Variável | Detalhamento  |
| :---:  | :--- |
| $configJson | string json de configuração |
| $content | conteudo do certificado A1 (pfx) |
| $password | senha do certificado A1 (pfx) |
| $xml | String contendo o xml de uma NFe |

## Retorno

O método signNFe() irá retornar uma string, contendo o XML já assinado.

## Exceptions

Caso algo esteja incorreto você poderá receber os seguintes exceptions:

