# MANUTENÇÃO DO CSC

Administração do Código de Segurança do Contribuinte - CSC

[Acesso ao CSC](http://nfce.encat.org/empresario/csc/)

## IMPORTANTE: Esse serviço, via webservice, não foi ainda liberado para uso, então que necessitar de um CSC para a emissão de NFCe (modelo 65) deverá proceder conforme estabelecido pela sua unidade autorizadora (SEFAZ do seu estado)

**Função:** serviço destinado às opções de consulta, requisição e revogação dos números de CSC NFC-e.

**Processo:** síncrono.

**Método:** admCscNFCe

## Descrição

Este método objetiva que as empresas emissoras de Nota Fiscal de Consumidor Eletrônica - NFC-e - possam efetuar o gerenciamento dos números de CSC NFC-e por meio do uso de Web Service.

Esse serviço poderá ser usado como alternativa às soluções já existentes de gerenciamento do CSC NFC-e por meio de página web.
O CSC NFC-e e seu respectivo número de identificação constituem informações fundamentais para a correta geração do QR-Code que deverá ser impresso no DANFE NFC-e.

O serviço de manutenção do CSC NFC-e oferecerá três funcionalidades distintas: 

- consulta de códigos de segurança ativos;
- revogação de código de segurança ativo;
- requisição de novo código de segurança.

Cada contribuinte (CNPJ Raiz) poderá manter até dois CSC ativos simultaneamente. Na hipótese de haver dois CSC ativos, só será aceita a requisição de novo CSC após a revogação de um deles. A funcionalidade de consulta de CSC ativos poderá ser usada a qualquer tempo sem nenhum tipo de restrição

## Dependências

[NFePHP\Common\Certificate::class](Certificate.md)

[NFePHP\NFe\Tools::class](Tools.md)

[NFePHP\NFe\Common\Standardize::class](Standardize.md)

## Exemplo de Uso

```php

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Common\Complements;

try {

    $certificate = Certificate::readPfx($content, 'senha');
    $tools = new Tools($configJson, $certificate);
    $tools->model('55');

    $indOp = 1;
    $response = $tools->sefazCsc($indOp);

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
    
    //verifique se o evento foi processado
    if ($std->cStat != 128) {
        //houve alguma falha e o evento não foi processado
        //TRATAR
    } else {
        $cStat = $std->retEvento->infEvento->cStat;
        if ($cStat == '101' || $cStat == '155') {
            //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
            $xml = Complements::toAuthorize($tools->lastRequest, $response);
            //grave o XML protocolado 
        } else {
            //houve alguma falha no evento 
            //TRATAR
        }
    }    
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
| $indOp | Identificador do tipo de operação: 1 - Consulta CSC Ativos; 2 - Solicita novo CSC;  3 - Revoga CSC Ativo (OBRIGATÓRIO) |


## Mensagens

### ENVIO 

*Consulta CSC  Ativos*

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
  <soap:Header>
    <nfeCabecMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/CscNFCe">
      <cUF>52</cUF>
      <versaoDados>1.00</versaoDados>
    </nfeCabecMsg>
  </soap:Header>
  <soap:Body>
    <nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/CscNFCe">
      <admCscNFCe xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
        <tpAmb>2</tpAmb>
        <indOp>1</indOp>
        <raizCNPJ>58716523</raizCNPJ>
      </admCscNFCe>
    </nfeDadosMsg>
  </soap:Body>
</soap:Envelope>
```
*Solicita outro CSC*

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
  <soap:Header>
    <nfeCabecMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/CscNFCe">
      <cUF>52</cUF>
      <versaoDados>1.00</versaoDados>
    </nfeCabecMsg>
  </soap:Header>
  <soap:Body>
    <nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/CscNFCe">
      <admCscNFCe xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
        <tpAmb>2</tpAmb>
        <indOp>2</indOp>
        <raizCNPJ>58716523</raizCNPJ>
      </admCscNFCe>
    </nfeDadosMsg>
  </soap:Body>
</soap:Envelope>
```

*Cancela CSC Ativo*

>NOTA: O CSC e o CSCid estão contidos no config.json

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
  <soap:Header>
    <nfeCabecMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/CscNFCe">
      <cUF>52</cUF>
      <versaoDados>1.00</versaoDados>
    </nfeCabecMsg>
  </soap:Header>
  <soap:Body>
    <nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/CscNFCe">
      <admCscNFCe xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
        <tpAmb>2</tpAmb>
        <indOp>3</indOp>
        <raizCNPJ>58716523</raizCNPJ>
        <dadosCsc>
          <idCsc>000002</idCsc>
          <codigoCsc>GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G</codigoCsc>
        </dadosCsc>
      </admCscNFCe>
    </nfeDadosMsg>
  </soap:Body>
</soap:Envelope>
```