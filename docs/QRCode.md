# QRCode na NFCe

O QRCode é um campo OBRIGATÓRIO nas NFCe (modelo 65).

Esse é um campo CDATA, pertencente ao XML, conforme mostrado abaixo:

```xml
</infNFe>
    <infNFeSupl>
        <qrCode><![CDATA[http://www.dfeportal.fazenda.pr.gov.br/dfe-portal/rest/servico/consultaNFCe?chNFe=41170410422724000187650010000005101000010235&nVersao=100&tpAmb=2&dhEmi=323031372d30342d31325431373a31343a30372d30333a3030&vNF=1500.00&vICMS=0.00&digVal=45433541594a33337247436131674a757967656d4c337550426b493d&cIdToken=000001&cHashQRCode=7BD57045E529D6F14D97F1BAE333D35B27921441]]></qrCode>
    </infNFeSupl>
<Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
```

> NOTA: caso essa TAG não esteja presente no XML de NFCe a SEFAZ acusará o erro **394 - Nota Fiscal sem a informação do QR-Code** e a NFCE não será aceita.

Essa TAG é inserida **AUTOMATICAMENTE** pela API durante a fase de assinatura da NFCe (método signNFe da classe Tools), desde que:

1. O config.json contenha as informações sobre o CSC e CSC_id (denominados também como "tokenNFCe" e "tokenNFCeId"). Essas referencias (tokens) devem ser obtidas pelo emitente junto a SEFAZ de seu estado.  
2. Deve existir uma URL referenciando o serviço de consulta pelo QRCode no arquivo: sped-nfe/storage/wsnfe_4.00_mod65.xml, como no exemplo abaixo:

```xml
<UF>
    <sigla>AC</sigla>
    <!-- NOTA: AC usa o SVRS -->
    <homologacao>
      <NfeConsultaQR method="QR-CODE" operation="NfeConsultaQR" version="100">http://hml.sefaznet.ac.gov.br/nfce/qrcode</NfeConsultaQR>
    </homologacao>
    <producao>
      <NfeConsultaQR method="QR-CODE" operation="NfeConsultaQR" version="100">http://www.sefaznet.ac.gov.br/nfce/qrcode</NfeConsultaQR>
    </producao>
  </UF>
```

Caso algum desses dados não exista; a TAG do QRCode **não será inserida** no XML.

> NOTA: especificamente para a versão >= 5.0 da API, deverá ocorrer uma EXCEPTION, caso falte alguma informação necessaria na construção do QRCode (que é obrigatório no xml). 

> NOTA: podem estar faltando URL's para o QRCode no arquivo ou essas URL's podem "MUDAR", como o mantenedor deste pacote não usa NFCe, fica dificil saber o que foi incluso e o que mudou, se não houver **ajuda por parte dos usuários da API**. Portanto **COLABORE** informando os erros e falhas.