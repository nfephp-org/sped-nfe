# DISTRIBUIÇÃO DE DOCUMENTOS FISCAIS

Este é o retorno de um evento protocolado fornecido pelo sistema de distribuições de documentos fiscias DFe.

Este XML podem ser eventos manifestados pelos parceiros relacionados a operação fiscal, como Clientes, Fornecedores, Tranportadoras ou ainda por integrantes da Receita (Estatual ou Federal). 

- Evento de Cancelamento
- Evento de Carta de Correção
- Eventos de Manifestação do Destinatário
- Eventos da Suframa (Vistoria/Internalização)
- Eventos de Pedido de Prorrogação de Prazo
- Eventos do Fisco em Resposta ao Pedido de Prorrogação

## Evento de Cancelamento

## Evento de Carta de Correção

## Eventos de Manifestação do Destinatário

**Exemplo do XML retornado na consulta**
 
```xml
<?xml version="1.0"?>
<procEventoNFe xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
  <evento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
    <infEvento Id="ID2102003516125871652300011955000000043990187017606801">
      <cOrgao>91</cOrgao>
      <tpAmb>1</tpAmb>
      <CNPJ>89850341000160</CNPJ>
      <chNFe>35161258716523000119550000000439901870176068</chNFe>
      <dhEvento>2016-12-30T19:19:41-02:00</dhEvento>
      <tpEvento>210200</tpEvento>
      <nSeqEvento>1</nSeqEvento>
      <verEvento>1.00</verEvento>
      <detEvento versao="1.00">
        <descEvento>Confirmacao da Operacao</descEvento>
      </detEvento>
    </infEvento>
    <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
      <SignedInfo>
        <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
        <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
        <Reference URI="#ID2102003516125871652300011955000000043990187017606801">
          <Transforms>
            <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
            <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
          </Transforms>
          <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
          <DigestValue>L0dyybBYp0+UsrJVV9bl502VT2c=</DigestValue>
        </Reference>
      </SignedInfo>
      <SignatureValue>Wl4z4lCDe8vrR2DFdTh3Dlfd5xTTUjTnoI97ZAdv7Po3m+BsH4iwZbsendPYkNwjw14SrHo8jMWSBjqiQDCqhEhT3Cenv7pYPqE/6mNOjtC/K/MMkuouZR8za401a6wa6QkmCjs6ei/dLVS+w/HmnbC3w//C5aYFZTMcorNjKQy1p+fLG6XWMtzpETUbMI55MhhNIWcEPUTH85H0Se+lW1CEILJ3O5pbZAaSeyKVxINeiISUR7qwYoOF4dYkcLPZgnMjKyCrQ9v2SlqQS+jyPpcp0Ig8LmUXUNxM9oSXvuV/8rX0G2h9/VX0zfqpnFozQnXDkkw18FOuum1St2Bm9Q==</SignatureValue>
      <KeyInfo>
        <X509Data>
          <X509Certificate>MIIIRTCCBi2gAwIBAgIQXbpMKT4uhbjPb/biOacjXDANBgkqhkiG9w0BAQsFADB0MQswCQYDVQQGEwJCUjETMBEGA1UEChMKSUNQLUJyYXNpbDEtMCsGA1UECxMkQ2VydGlzaWduIENlcnRpZmljYWRvcmEgRGlnaXRhbCBTLkEuMSEwHwYDVQQDExhBQyBDZXJ0aXNpZ24gTXVsdGlwbGEgRzUwHhcNMTYwNjI4MDAwMDAwWhcNMTcwNjI3MjM1OTU5WjCBxjELMAkGA1UEBhMCQlIxEzARBgNVBAoUCklDUC1CcmFzaWwxJDAiBgNVBAsUG0F1dGVudGljYWRvIHBvciBBUiBESUdJQ0VSVDEbMBkGA1UECxQSQXNzaW5hdHVyYSBUaXBvIEExMRYwFAYDVQQLFA1JRCAtIDEwNTkzODUzMRUwEwYDVQQDEwxHUkVOREVORSBTIEExMDAuBgkqhkiG9w0BCQEWIWpvc2lhbmUuYmlhbmNoaW5pQGdyZW5kZW5lLmNvbS5icjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBALJsJ7pxh8n49EFmaCePxlt1/bk90kINznPpFeY4M4ZIojIYAjCBkVxjBQ8E/p1n5o2aYwSGdLYjhrYNKhjtBf0mW9oRpm0y1WrPdpzgBQHi3Hx9JPeCMyXM0u+G3U4fSHZhD3LD/SqFtbAM6Na2KE48gbyPMdQMtoYgYr1Lf8lrwaF62Jhv0byOnn0djfMq+Yjep+ZBtMQRzrumOzf9erIZXSQaV/ut4OT/B7oBDLUUAdAfIuk2teFLhAO7xGF6brGNxRe/tSMduIA79119PGY+PdKtlTESLsM1JlzQ+heY5oj+hXXI1ZYUM3o/SrnmV4DG5XwyKkc1FnT5HojkY40CAwEAAaOCA34wggN6MIHEBgNVHREEgbwwgbmgPQYFYEwBAwSgNAQyMTQwMjE5NTMxNDg0MTE0Mjk5MTAwMDAwMDAwMDAwMDAwMDAyMDMxMDk0NDQxU1NQUlOgIQYFYEwBAwKgGAQWR0VMU09OIExVSVMgUk9TVElST0xMQaAZBgVgTAEDA6AQBA44OTg1MDM0MTAwMDE2MKAXBgVgTAEDB6AOBAwwMDAwMDAwMDAwMDCBIWpvc2lhbmUuYmlhbmNoaW5pQGdyZW5kZW5lLmNvbS5icjAJBgNVHRMEAjAAMB8GA1UdIwQYMBaAFJ1Qz73/JMqvsTPrF+JCeo5pKo5TMA4GA1UdDwEB/wQEAwIF4DCBiQYDVR0gBIGBMH8wfQYGYEwBAgELMHMwcQYIKwYBBQUHAgEWZWh0dHA6Ly9pY3AtYnJhc2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vZHBjL0FDX0NlcnRpc2lnbl9NdWx0aXBsYS9EUENfQUNfQ2VydGlTaWduTXVsdGlwbGEucGRmMIIBJQYDVR0fBIIBHDCCARgwXKBaoFiGVmh0dHA6Ly9pY3AtYnJhc2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vbGNyL0FDQ2VydGlzaWduTXVsdGlwbGFHNS9MYXRlc3RDUkwuY3JsMFugWaBXhlVodHRwOi8vaWNwLWJyYXNpbC5vdXRyYWxjci5jb20uYnIvcmVwb3NpdG9yaW8vbGNyL0FDQ2VydGlzaWduTXVsdGlwbGFHNS9MYXRlc3RDUkwuY3JsMFugWaBXhlVodHRwOi8vcmVwb3NpdG9yaW8uaWNwYnJhc2lsLmdvdi5ici9sY3IvQ2VydGlzaWduL0FDQ2VydGlzaWduTXVsdGlwbGFHNS9MYXRlc3RDUkwuY3JsMB0GA1UdJQQWMBQGCCsGAQUFBwMCBggrBgEFBQcDBDCBoAYIKwYBBQUHAQEEgZMwgZAwZAYIKwYBBQUHMAKGWGh0dHA6Ly9pY3AtYnJhc2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vY2VydGlmaWNhZG9zL0FDX0NlcnRpc2lnbl9NdWx0aXBsYV9HNS5wN2MwKAYIKwYBBQUHMAGGHGh0dHA6Ly9vY3NwLmNlcnRpc2lnbi5jb20uYnIwDQYJKoZIhvcNAQELBQADggIBAL81YulnHdabDOgFb8Xn98js8SJenNobFkTIVp/39HRs7iqym8uoLzHT/171GCEOQJlGTYov5tayavMgytTjiNWiuX9NaUobQiwus6a4KQQphLkRyYSTVUnlUcnYW6N/O6IQc0ZEJjvUaOd295C7Scz5sn2N3cebIodGaYFCIRGE16b431ZiOaIunwXYVzg/nVpG9J9Vy+Y45jLa7b+flKOR6VWAxdfYNYqF6eh5mCMtmmJIrt4wpTdSv3iUhwRiOZzd4zEgc0nWLFoksuwBtGPEqDp9s/bs2AKYB/4QswF7cVlnj+b2pSQ0gL2l8DaCfBtUI6oPx+k5d8JoBzJHmXmkZhI2dx3Qdlc2rA9aR3fEyDfxhw1TZsKMxakDsMQbBmR//xrjLdZkTo7fXhFhJAzJG1138/TK2sDtDHAWlV5UMosI/JaDOMeHhx/FpELKrFW7WI0CmHUl0B9fwLMGY6lqoY3avLNhAURYGfYdaEn5DH6gyNrgExZ5TLCP7HBeSpoADZbvSsp499VuEgEk0ij3+lUoKSqsmNb4t6C9QDBqKAqJqtEOEkDG7LRJF4vqCjnGsv+TreJQkwfuBT1KBy7rpPFUmwXta6ePIP9TAi/kpjz0PlgT3u/EIeYrDry6p44K9waOrgFiYu7JqPZzNzVHyC06eR2DaDWVnwPphlFA</X509Certificate>
        </X509Data>
      </KeyInfo>
    </Signature>
  </evento>
  <retEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">
    <infEvento Id="ID891161800271770">
      <tpAmb>1</tpAmb>
      <verAplic>AN_1.0.0</verAplic>
      <cOrgao>91</cOrgao>
      <cStat>135</cStat>
      <xMotivo>Evento registrado e vinculado a NF-e</xMotivo>
      <chNFe>35161258716523000119550000000439901870176068</chNFe>
      <tpEvento>210200</tpEvento>
      <xEvento>Confirmacao da Operacao</xEvento>
      <nSeqEvento>1</nSeqEvento>
      <CNPJDest>89850341000160</CNPJDest>
      <dhRegEvento>2016-12-30T19:20:00-02:00</dhRegEvento>
      <nProt>891161800271770</nProt>
    </infEvento>
  </retEvento>
</procEventoNFe>
```

**O mesmo exmplo anterior convertido em um stdClass, por Stardardize::class**

```php
stdClass Object
(
    [attributes] => stdClass Object
        (
            [versao] => 1.00
        )

    [evento] => stdClass Object
        (
            [attributes] => stdClass Object
                (
                    [versao] => 1.00
                )

            [infEvento] => stdClass Object
                (
                    [attributes] => stdClass Object
                        (
                            [Id] => ID2102003516125871652300011955000000043990187017606801
                        )

                    [cOrgao] => 91
                    [tpAmb] => 1
                    [CNPJ] => 89850341000160
                    [chNFe] => 35161258716523000119550000000439901870176068
                    [dhEvento] => 2016-12-30T19:19:41-02:00
                    [tpEvento] => 210200
                    [nSeqEvento] => 1
                    [verEvento] => 1.00
                    [detEvento] => stdClass Object
                        (
                            [attributes] => stdClass Object
                                (
                                    [versao] => 1.00
                                )

                            [descEvento] => Confirmacao da Operacao
                        )

                )

            [Signature] => stdClass Object
                (
                    [SignedInfo] => stdClass Object
                        (
                            [CanonicalizationMethod] => stdClass Object
                                (
                                    [attributes] => stdClass Object
                                        (
                                            [Algorithm] => http://www.w3.org/TR/2001/REC-xml-c14n-20010315
                                        )

                                )

                            [SignatureMethod] => stdClass Object
                                (
                                    [attributes] => stdClass Object
                                        (
                                            [Algorithm] => http://www.w3.org/2000/09/xmldsig#rsa-sha1
                                        )

                                )

                            [Reference] => stdClass Object
                                (
                                    [attributes] => stdClass Object
                                        (
                                            [URI] => #ID2102003516125871652300011955000000043990187017606801
                                        )

                                    [Transforms] => stdClass Object
                                        (
                                            [Transform] => Array
                                                (
                                                    [0] => stdClass Object
                                                        (
                                                            [attributes] => stdClass Object
                                                                (
                                                                    [Algorithm] => http://www.w3.org/2000/09/xmldsig#enveloped-signature
                                                                )

                                                        )

                                                    [1] => stdClass Object
                                                        (
                                                            [attributes] => stdClass Object
                                                                (
                                                                    [Algorithm] => http://www.w3.org/TR/2001/REC-xml-c14n-20010315
                                                                )

                                                        )

                                                )

                                        )

                                    [DigestMethod] => stdClass Object
                                        (
                                            [attributes] => stdClass Object
                                                (
                                                    [Algorithm] => http://www.w3.org/2000/09/xmldsig#sha1
                                                )

                                        )

                                    [DigestValue] => L0dyybBYp0+UsrJVV9bl502VT2c=
                                )

                        )

                    [SignatureValue] => Wl4z4lCDe8vrR2DFdTh3Dlfd5xTTUjTnoI97ZAdv7Po3m+BsH4iwZbsendPYkNwjw14SrHo8jMWSBjqiQDCqhEhT3Cenv7pYPqE/6mNOjtC/K/MMkuouZR8za401a6wa6QkmCjs6ei/dLVS+w/HmnbC3w//C5aYFZTMcorNjKQy1p+fLG6XWMtzpETUbMI55MhhNIWcEPUTH85H0Se+lW1CEILJ3O5pbZAaSeyKVxINeiISUR7qwYoOF4dYkcLPZgnMjKyCrQ9v2SlqQS+jyPpcp0Ig8LmUXUNxM9oSXvuV/8rX0G2h9/VX0zfqpnFozQnXDkkw18FOuum1St2Bm9Q==
                    [KeyInfo] => stdClass Object
                        (
                            [X509Data] => stdClass Object
                                (
                                    [X509Certificate] => MIIIRTCCBi2gAwIBAgIQXbpMKT4uhbjPb/biOacjXDANBgkqhkiG9w0BAQsFADB0MQswCQYDVQQGEwJCUjETMBEGA1UEChMKSUNQLUJyYXNpbDEtMCsGA1UECxMkQ2VydGlzaWduIENlcnRpZmljYWRvcmEgRGlnaXRhbCBTLkEuMSEwHwYDVQQDExhBQyBDZXJ0aXNpZ24gTXVsdGlwbGEgRzUwHhcNMTYwNjI4MDAwMDAwWhcNMTcwNjI3MjM1OTU5WjCBxjELMAkGA1UEBhMCQlIxEzARBgNVBAoUCklDUC1CcmFzaWwxJDAiBgNVBAsUG0F1dGVudGljYWRvIHBvciBBUiBESUdJQ0VSVDEbMBkGA1UECxQSQXNzaW5hdHVyYSBUaXBvIEExMRYwFAYDVQQLFA1JRCAtIDEwNTkzODUzMRUwEwYDVQQDEwxHUkVOREVORSBTIEExMDAuBgkqhkiG9w0BCQEWIWpvc2lhbmUuYmlhbmNoaW5pQGdyZW5kZW5lLmNvbS5icjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBALJsJ7pxh8n49EFmaCePxlt1/bk90kINznPpFeY4M4ZIojIYAjCBkVxjBQ8E/p1n5o2aYwSGdLYjhrYNKhjtBf0mW9oRpm0y1WrPdpzgBQHi3Hx9JPeCMyXM0u+G3U4fSHZhD3LD/SqFtbAM6Na2KE48gbyPMdQMtoYgYr1Lf8lrwaF62Jhv0byOnn0djfMq+Yjep+ZBtMQRzrumOzf9erIZXSQaV/ut4OT/B7oBDLUUAdAfIuk2teFLhAO7xGF6brGNxRe/tSMduIA79119PGY+PdKtlTESLsM1JlzQ+heY5oj+hXXI1ZYUM3o/SrnmV4DG5XwyKkc1FnT5HojkY40CAwEAAaOCA34wggN6MIHEBgNVHREEgbwwgbmgPQYFYEwBAwSgNAQyMTQwMjE5NTMxNDg0MTE0Mjk5MTAwMDAwMDAwMDAwMDAwMDAyMDMxMDk0NDQxU1NQUlOgIQYFYEwBAwKgGAQWR0VMU09OIExVSVMgUk9TVElST0xMQaAZBgVgTAEDA6AQBA44OTg1MDM0MTAwMDE2MKAXBgVgTAEDB6AOBAwwMDAwMDAwMDAwMDCBIWpvc2lhbmUuYmlhbmNoaW5pQGdyZW5kZW5lLmNvbS5icjAJBgNVHRMEAjAAMB8GA1UdIwQYMBaAFJ1Qz73/JMqvsTPrF+JCeo5pKo5TMA4GA1UdDwEB/wQEAwIF4DCBiQYDVR0gBIGBMH8wfQYGYEwBAgELMHMwcQYIKwYBBQUHAgEWZWh0dHA6Ly9pY3AtYnJhc2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vZHBjL0FDX0NlcnRpc2lnbl9NdWx0aXBsYS9EUENfQUNfQ2VydGlTaWduTXVsdGlwbGEucGRmMIIBJQYDVR0fBIIBHDCCARgwXKBaoFiGVmh0dHA6Ly9pY3AtYnJhc2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vbGNyL0FDQ2VydGlzaWduTXVsdGlwbGFHNS9MYXRlc3RDUkwuY3JsMFugWaBXhlVodHRwOi8vaWNwLWJyYXNpbC5vdXRyYWxjci5jb20uYnIvcmVwb3NpdG9yaW8vbGNyL0FDQ2VydGlzaWduTXVsdGlwbGFHNS9MYXRlc3RDUkwuY3JsMFugWaBXhlVodHRwOi8vcmVwb3NpdG9yaW8uaWNwYnJhc2lsLmdvdi5ici9sY3IvQ2VydGlzaWduL0FDQ2VydGlzaWduTXVsdGlwbGFHNS9MYXRlc3RDUkwuY3JsMB0GA1UdJQQWMBQGCCsGAQUFBwMCBggrBgEFBQcDBDCBoAYIKwYBBQUHAQEEgZMwgZAwZAYIKwYBBQUHMAKGWGh0dHA6Ly9pY3AtYnJhc2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vY2VydGlmaWNhZG9zL0FDX0NlcnRpc2lnbl9NdWx0aXBsYV9HNS5wN2MwKAYIKwYBBQUHMAGGHGh0dHA6Ly9vY3NwLmNlcnRpc2lnbi5jb20uYnIwDQYJKoZIhvcNAQELBQADggIBAL81YulnHdabDOgFb8Xn98js8SJenNobFkTIVp/39HRs7iqym8uoLzHT/171GCEOQJlGTYov5tayavMgytTjiNWiuX9NaUobQiwus6a4KQQphLkRyYSTVUnlUcnYW6N/O6IQc0ZEJjvUaOd295C7Scz5sn2N3cebIodGaYFCIRGE16b431ZiOaIunwXYVzg/nVpG9J9Vy+Y45jLa7b+flKOR6VWAxdfYNYqF6eh5mCMtmmJIrt4wpTdSv3iUhwRiOZzd4zEgc0nWLFoksuwBtGPEqDp9s/bs2AKYB/4QswF7cVlnj+b2pSQ0gL2l8DaCfBtUI6oPx+k5d8JoBzJHmXmkZhI2dx3Qdlc2rA9aR3fEyDfxhw1TZsKMxakDsMQbBmR//xrjLdZkTo7fXhFhJAzJG1138/TK2sDtDHAWlV5UMosI/JaDOMeHhx/FpELKrFW7WI0CmHUl0B9fwLMGY6lqoY3avLNhAURYGfYdaEn5DH6gyNrgExZ5TLCP7HBeSpoADZbvSsp499VuEgEk0ij3+lUoKSqsmNb4t6C9QDBqKAqJqtEOEkDG7LRJF4vqCjnGsv+TreJQkwfuBT1KBy7rpPFUmwXta6ePIP9TAi/kpjz0PlgT3u/EIeYrDry6p44K9waOrgFiYu7JqPZzNzVHyC06eR2DaDWVnwPphlFA
                                )

                        )

                )

        )

    [retEvento] => stdClass Object
        (
            [attributes] => stdClass Object
                (
                    [versao] => 1.00
                )

            [infEvento] => stdClass Object
                (
                    [attributes] => stdClass Object
                        (
                            [Id] => ID891161800271770
                        )

                    [tpAmb] => 1
                    [verAplic] => AN_1.0.0
                    [cOrgao] => 91
                    [cStat] => 135
                    [xMotivo] => Evento registrado e vinculado a NF-e
                    [chNFe] => 35161258716523000119550000000439901870176068
                    [tpEvento] => 210200
                    [xEvento] => Confirmacao da Operacao
                    [nSeqEvento] => 1
                    [CNPJDest] => 89850341000160
                    [dhRegEvento] => 2016-12-30T19:20:00-02:00
                    [nProt] => 891161800271770
                )
        )
)
```


## Eventos da Suframa (Vistoria/Internalização)

## Eventos de Pedido de Prorrogação de Prazo

## Eventos do Fisco em Resposta ao Pedido de Prorrogação
