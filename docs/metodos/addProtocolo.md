# ADICIONA PROTOCOLO NO XML ASSINADO


**Função:** destinado a adicionar os dados de protocolo recebidos da sefaz no xml assinado.

**Método:** NFePHP\NFe\Factories\Protocol::add


```php
use NFePHP\NFe\Factories\Protocol;

try {

	$protocol = new Protocol();

	//$xmlAssinado = xml que foi enviado para a sefaz, e que teve sucesso na emissão
	//$protocolo = xml recebido ao consultar o número de recibo
	$xmlProtocolado = $protocol->add($xmlAssinado,$protocolo);
	
	header('Content-type: text/xml; charset=UTF-8');
    echo $xmlProtocolado;
    
} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}

```