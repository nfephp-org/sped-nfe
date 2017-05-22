# CONSTRUÇÃO DO XML

Para construir o XML da NFe (ou da NFCe) deve ser usada a classe Make::class


# Exemplo de uso

```php
use NFePHP\NFe\Make;

$nfe = Make::v310();

$nfe->tagide();

$xml = $nfe->getXML();
if (empty($xml)) {
    //existem falhas
    print_r($nfe->erros);
    die;
}

//se não houveram erros a nota pode ser processada
//outros erros podem ser identificados na fase de assinatura da 
//nota com a classe Tool::class pois será validada com relação ao
//seu respsctivo XSD

```


