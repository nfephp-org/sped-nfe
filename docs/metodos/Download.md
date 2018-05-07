# DOWNLOAD DA NFe
Download de NF-e Confirmadas


**Função:** Serviço de Download da NF-e para uma determinada Chave de Acesso informada, para as NF-e **confirmadas pelo destinatário**.

**Processo:** síncrono.

**Método:** nfeDownloadNF

## Descrição

Este serviço disponibiliza para alguns atores as NFe's de seu interesse.

Os documentos fiscais eletrônicos estarão disponíveis para o download por um periodo após sua recepção pelo Ambiente Nacional da NF-e. 

**NOTA: Este serviço NÃO está disponivel para os emitentes, mas apenas aos destinatários, transportadores e outros autorizados, desde que essa NFe tenha sido previamente manifestada !!!**

## Dependências
[NFePHP\Common\Certificate::class](Certificate.md)

[NFePHP\NFe\Tools::class](Tools.md)

[NFePHP\NFe\Common\Standardize::class](Standardize.md)


## Exemplo de Uso

```php
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;

try {
    
    $tools = new Tools($configJson, Certificate::readPfx($pfxcontent, $password));
    //só funciona para o modelo 55
    $tools->model('55');
    //este serviço somente opera em ambiente de produção
    $this->tools->setEnvironment(1);
    $chave = '35180174283375000142550010000234761182919182';
    $response = $tools->sefazDownload($chave);
    header('Content-type: text/xml; charset=UTF-8');
    echo $response;
    
} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}

```

## Parametros

| Variável | Detalhamento  |
| :---:  | :--- |
| $configJson | String Json com os dados de configuração (OBRIGATÓRIO) |
| $pfxcontent | String com o conteúdo do certificado PFX (OBRIGATÓRIO) |
| $password | String com a senha de acesso ao certificado PFX (OBRIGATÓRIO) |
| $chave | Chave de 44 digitos da NFe de interesse |

## Mensagens

### ENVIO

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
  <soap:Body>
    <nfeDistDFeInteresse xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeDistribuicaoDFe">
      <nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeDistribuicaoDFe">
        <distDFeInt xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.01">
          <tpAmb>1</tpAmb>
          <cUFAutor>35</cUFAutor>
          <CNPJ>58716523000119</CNPJ>
          <consChNFe>
            <chNFe>35180174283375000142550010000234761182919182</chNFe>
          </consChNFe>
        </distDFeInt>
      </nfeDadosMsg>
    </nfeDistDFeInteresse>
  </soap:Body>
</soap:Envelope>
```

### RETORNO

A variavel $response no exemplo conterá esse XML, ou algo semelhante.

```xml
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body>
        <nfeDistDFeInteresseResponse xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeDistribuicaoDFe">
            <nfeDistDFeInteresseResult>
                <retDistDFeInt xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" versao="1.01" xmlns="http://www.portalfiscal.inf.br/nfe">
                    <tpAmb>1</tpAmb>
                    <verAplic>1.1.9</verAplic>
                    <cStat>640</cStat>
                    <xMotivo>Rejeicao: CNPJ/CPF do interessado nao possui permissao para consultar esta NF-e</xMotivo>
                    <dhResp>2018-01-25T09:21:54-02:00</dhResp>
                </retDistDFeInt>
            </nfeDistDFeInteresseResult>
        </nfeDistDFeInteresseResponse>
    </soap:Body>
</soap:Envelope>
```
```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body>
        <nfeDistDFeInteresseResponse xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeDistribuicaoDFe">
            <nfeDistDFeInteresseResult>
                <retDistDFeInt xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.01">
                    <tpAmb>1</tpAmb>
                    <verAplic>1.1.9</verAplic>
                    <cStat>138</cStat>
                    <xMotivo>Documento localizado</xMotivo>
                    <dhResp>2018-01-25T09:09:29-02:00</dhResp>
                    <loteDistDFeInt>
                        <docZip NSU="000000000031322" schema="procNFe_v3.10.xsd">H4sIAAAAAAAEAO06abOiypJ/xTjvo9OHXaUfbQS7qOygwpcbCAgoiwoC+uungLN337m338yXF2+Mo5WVlZVbZSaVeqj8EGrXwh/V4bX0ih9P2DMCP43aLM3LH09xVZ2/Q1DTNM/n4lp56SEpfS99TvLD8/4Kgb1Pc0oRwt+iB5Nuy2eBUvDjCWAxApnByBRHZxg2JWAYRnCUACMCQBjF8OkEQWYoiZDgs2MVhHPKt4U5RlBQN1K+IsxfKQAKzKjcq9Tz3OAt1VDUkcnLI0nhbNMyJHotuTRLqxQ00ADVAs2L5igFvUBUVgRzAjDvRqoMr0k4RyhoAKgcsO+VAgw6SUHMZ8kchZHZNxj5hpAWgnzHyO8I/A1Gv8MwBQ0EVHXutKSgfgRGcGFZdfMXiPLlWy6IwCiUIGEcmDHMwT4pOw8bOwDMAbtyQPQQ5XObTvtuAKt0th8WO4A6JEDJXv0XqDNXSHIvncO9wQPcO+EalnNy8EIHUmcQIp3qgPAVpMABdpEzFw1ypAj8qDtICnrFdtYAEWGWAINYRVvOP58qBfVIqlWKLJyzqsLvaHUk0+sFbY74EcebvLJR1xtJ5hVLHa0tjqaggZhqBS+vvuwBiz2WCvMgvPK92HYdXef0hlckjgZkhigp9HrEm7rNGwAD/jYSPaKVBS0CDODQ0VP5tZgjGAIOvYOolvGSKwA02gD7RoxBm9Ja6pR5WeiP6/NhgV3d59JWOImWAGmPA/FpahTUhSnLa0AGiiAwCXzWzShf87qzhIkubnuYavthkAiYDMhDkYNDRHACQ2bgBU6zQ1DQB7slfo7DUxSsTrp8oSCAoFjDmmNAFhgAcU8X9NHWnwMxmyITAsW6w0HIz4cjSDJt8ezI4neWtP58FL3UIWp77xk3bxQU5UjzqmtSVF750aszcvrqVPaczmlDpl2Qjl0w9Ig3X0vn5OrlkfezkwkYg2efnGyCENBoe63+iZthHIWnMP4vuhmFJ9Mp1uXuRzcPBoPskPi33H2bdO7vNsKTCYwhXU507ocGZwdhNcqlKsx+PCFPfV4FnU7dIADTdqDQdaVMG/A8rYygTsF+XVJNkBcjei2qHDBaASkHQ8hopIEM4WlOHbGc/Dz6NpIsXu5OaGCisPKcQGEChDRQpZsBt5jWnBxenVvAjGIFVZuDCO5CpAOpG1tk85VIQT1AXbpPYvo8nU4Am35G1XbejRjxDL+9QAUYsFTdy0dhFH1GQIWs322yrsm+s+vWAYOMHqIu/fAuZcAChj3ws5xhHbjeKl4PoYP6IgVkJdm5KCsQPBIrm8MnDs+p4ppEXSXrR4oF1hNddHRegF5poGGLJg0fijUQwtNXwhck1FOwqiApb+PPxO946JUUelMOPA/poHeOEVbFNS9A8lz9xEtHRnh4HpUgoxRhNMLBi/hnZ+MreRdTn0MK/fcLKQR+nuL4b4UUNp08d5X270fUu5D/j6gPETXDcfQvIgr7GlHIDp7O/jyiNLp7TIymMwHFRrsRMjLVkcFzI9MdGVMQSMZC5aQvkYSDm13/0PnfRRI6fUawnyIJIZ8xEjzUsF9FEoFOwJ7fiaR3IZ8j6Wcx/1GR9DdqE/5vFEmzZ3Bz+rNIAneJX0QSQT5Pkd+KpDchv46kdzH/UZH0ZzWpApfJdLCuN75m2Dn83HsIQFTdW/KCGKzqB3AjK/KP+AHRbe90f2XQ6V+/I/rp8KwBCn182NTCNazCV7phAnaG0dtWAFI1kOK/YnoYaCO9qSF1U+19rnWIzsUviN7b9YsPX3CvHq3VWwXuwy/YYULVoI9817RrKqE3R0EvnqvAjbo89x3toDbSd7UvJgyrXc/+2hCALhyZzPC+IcA+NwSaoWqGpL41Af2FF4ERgpwQ4OY7XHhbvrspz58B1QD99XUd+qhFXQClLxvwCS6P/UiFQH+WlnZdt9fB1Bkc5nqOoPgzuI6AfOinPZb5jGUA854h9OqGPsASvwe63qPz18i0TXDzAYUG9JaCasjgZmRYzyNQVkbgLmR0NJCpPY9G4Mj+lBj7L9BWSsMGTYJQkMr/fO4juu9xoDfJ0PBNyJwykyj3qtv1V9+jNNhzcY0AFxiGYBICBEGZRP94GnaFgZQfQACwXl7kie+lycOrkiKXwyoughGdRiD9qzj7FUvL6LgikMGz3wDbbz6C5986DOhaiKeucr3p9XfYfdXwWnrfythDek4gx8NrmPvhyDakH0//+P2veqzu3A7FNSs/wL+nUZjXYVqcw+Bb+WpYr9zfZPfX/oI+KsklEej4/hXPvXltYLHx0ls4Z/cbJgwmJ2vHrM8LaDndjzEszypi6/+goI+UFPTmbQB/jJK38xwI9VTfbfImrLDZmBtHD/KWT24Su13UKn4cl0Ydpb6x2zN3enNZqyq0j08bssSE4+R+gm9LjRDXhXuJHtPDbKuOw0Yolie2jM6peWh3/nbvrRaocXGbo8Y+TkwtBCXTXGGuphkPbqRDteKSVJvYMdfMGIRGFCNvaNPEJ2IplaXLICTp7F25WRWnB6sRyCbDyHtuhlMHbseeWe4ONnyQzT1u5oI3JYyUqe6kh+WcFi8kIdTLexN7D0xkZ05dL+IqOgiR6koLpBYf+q25iGuUYJLIVbw9jsh4ZByiSFgIKXeos7hYLO/xlX5MpreSkfzzxqHjB6bOdvL6ogm3an9hx069QqaeX50QI6jOmXiPVejY/PgxOP2Do6lVeB9OYEfAJOd15a2D2PBaJQeQtqACy5Ik8Q+WZQ63iG4kho4kSeRRV1lcElVoGk53lqvCleLaV2idXzM63fgWv5bpk0gjNs/EMqunUss/aIOJlA1DFxZ7SjmbRVg/Ex7etmmVIw0Pa6W13iipgy3TQBTu3paPXJGP7GxzdLcp7JiM6G6NFOwrJdGoJX55d3bKec/SlSQsRf3Ib2RG7uXSrSzrthxtToJs2npkn1xWZvAdZ/GYbNGNfJQamYtaZVN0OPwLrolCv2Uf9HLQy7Ho09KU9bJhdYfb6LrEN0vL5nhdpvHBzlZemOlGNfiUMS3ekhm+x7OxvDJtRV/bL7pyPCpz+rDWypWNbo5+toGd3fIM7DuBt+luldTbGbHEu6krbu7OtgF+mEV6vox9NC0lFh7sMZxGoHt91nyDmMZJilwT4ayUWUk838qG3fDN63rL2AljWbZgbgRlacB4q1n0dLBPthRe0azTxtHtWQRoZJMXLIm3I4PfWIZNbC243Zo2IlipoUl8axs8P1Ee+l3l5IfysIHf6FbhpCaK+ESmYZE1L6Ip7TFO5xlat2kalxiuobv1FV2AONK5uDnCyRJd8X4s+OPSDk5bcS22MvDVxLtDR2sJRWMlC4FO0G1BHy7agwlUCfZXnNhs7mvOLM90IZhXT22C2kni8Vja8wGzbKfILTwfl8HEz8StJ2zYgMAXHj8uyVMwWeFeXMgZxLHlRYQNUGzc+yXinPMm0jc7TwhVTEkSBJ6FE5wR9TxLJFW+BfdCSI/G2hrnqnqYSvzqssHVy4pFyXWFnRdpPT3pygLk3v2qS7Q8Rqf10sxoo0gYzjLRhVDHOYOl1eWwZcJKDS6qFq1a4mpwZDK57h5u2eT6YbaccqRr51VtrjfY9eycSqU2NVvccs66rWyTo+3JTcvvgoUz/L0hZdN0Y4VYQQcYkRvGoCOZoWnxGEUyCnKXk48sk0WOtGochtHtBchRPnLgJnKKZqO/42V6JZrbGA4W9GR9J88ORlfOS7ytczfei+nJQTf3QEwzb6vErkjeHZM47lH45uRS7WzlKgB56W2Nu5t9nS9ROSEaBQX59UmmKC7fZdYOpjR/Q9aQgwZsMbTU0Bx96GJ4Ycq8yNHbiDEWNz12UX6NnuoHdmA2s2XBrAxXGOcP5jbQ0rz7YFJZlEUmY2Ral5ilxbiy4IssW4ogXgUG1DrhVBXBwmjUZFYDPZr19rXeEKizbc+uqKR+bpzdLD06W6P2M/7moGS1zpb3NSoc17vBFj9zkzVqNM4dicF72LtYZg7wiSs6XU4wvV7GjI8OpyY6OI09YYyCH4vW/+GZ7EXlvt5+1is4SjdQb0tZMCP7wujxifi1zZx0e+F1dHdL2Nu6ZwcVTntsGa8zpd6bROIn5Bf7yNLBpOoXsQBqXtOYHrMo+K2oo2823t0dUwP7YMD3vL8TwGYmeXlO3FyURAfftkcga6vb7dJg/2cZXNTHikbrC6grOnS0AxkCd/U3WOr6Vmb0D2cus0wUXZmIFxjd5xiOZZphv8FI4kSWRCwy2jLYKmdnS9S6COzONrizJYH8tnB28tv5FxwsMtsutmS+AEVQPtKIzDmtavmYfHRw5SF1MA7eXe38xVvC5MfpIR9tWBUUUJIVvWD1V55swZS8uNnI5kaxjI0c6XCqgxoNavgJlLGlYPExY53Gkag7gsM3DN2oEU/r6s81exUJzStNGHGRLv+ky5d6zjZ9PWdpnRGyB3c84GbrxtI4ZQhhe7tMT1N6WtzroqlwPVPdQB83alub50hBCihQYzk21UXYnlt3d9ysbafNfSGWSlLAZ6wzKemZvlWbFFm0XskRpyQ6n2dqdoxa7dZmmrsj7vqevU1bb0MQZCBEGM/M2DF/WSy2WssnMSNEFhotSDmbkTmK3hYnj0+z6yNR4O0yOka1tq5XDXrcnXiS54xsyfJuoniXVZVAJHpJpgwUaeT4yocMm0T15OFKDkPz5xDGstJ88OPDSthljqKTfHv0tjCBHeLr5HaRojpBAnZRLln6PIkF08JrW9kFGHtxhX3LGlpuc4bgHQ3kJNsBnKYs6qvHKzMd2/khXFcJ5x+NXRxgq6oETccxck53PWOQ60UZP3zXu6BihUsIk9k+nxt+sUcO2S2AYkQuNLk0zdteZO4gpJQMWd4vU1PMdnuHCITZ9bBJCQgKcdhvfVLjQHe+oU9R4Ee1vVB0lLRnDLo/Io+7lLRs0I6hzGVOil+B0ma3NBNs3Rs4+AwqJi3OEfDkuPRk0j0boiBohwabZiG6vh3l1WrMc9ODcLhqFnkuU4hz8NVZFKe3JV7stsg+2Tfru2NY+wfKLSIIw896bF/yB8JKOYTGlXly1quHTtzDSJ7sbVscq7yG0o842khrIRJK5hxdykqtj/QxjvRQFpYLTA75KEb8WEzuy93sUqELMbBqN/Gx0y2z0UdGQ26Y090F+OvtdsAMN1/o7Tb8fk8GcN8Jn69F9dM/B/Q9ugZW+v8SkAKkbx1hHJ1MYXxGPP38UzfYTp9T0GOb2h+KwP+hrf+A4VmC9j9PDyuUH3cSf6cLpaBhDxXERujvq+LLT/04/B3Abz/1v9BQeaf6/IvSFDSgqSCJQJPwF+3dCxHlm5UHWHX8B5Bq5aJK6mJO3yrQYD68oBgVo1tZjILu+7RvYfcty0DRf90wyIRe3Aygl3//mP838Mk8aAgiAAA=</docZip>
                    </loteDistDFeInt>
                </retDistDFeInt>
            </nfeDistDFeInteresseResult>
        </nfeDistDFeInteresseResponse>
    </soap:Body>
</soap:Envelope>
```

## Exemplo de extração do XML da NFe retornado

```php

use NFePHP\NFe\Common\Standardize;

try {
    $stz = new Standardize($response);
    $std = $stz->toStd();
    if ($std->cStat != 138) {
        echo "Documento não retornado. [$std->cStat] $std->xMotivo";  
        die;
    }    
    $zip = $std->loteDistDFeInt->docZip;
    $xml = gzdecode(base64_decode($zip));

    header('Content-type: text/xml; charset=UTF-8');
    echo $xml;

} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}

```

| Variável | Detalhamento  |
| :---:  | :--- |
| $response | XML retornado no método sefazDownload() (vide acima) OBRIGATÓRIO |

```
stdClass Object
(
    [attributes] => stdClass Object
        (
            [versao] => 1.01
        )

    [tpAmb] => 1
    [verAplic] => 1.1.9
    [cStat] => 138
    [xMotivo] => Documento localizado
    [dhResp] => 2018-01-25T09:09:29-02:00
    [loteDistDFeInt] => stdClass Object
        (
            [docZip] => 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
        )

)
```
