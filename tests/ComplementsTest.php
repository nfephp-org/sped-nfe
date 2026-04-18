<?php

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Complements;
use NFePHP\NFe\Exception\DocumentsException;
use NFePHP\NFe\Tests\NFeTestCase;

class ComplementsTest extends NFeTestCase
{
    public function test_to_authorize_nfe_valid()
    {
        $request = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/retEnviNFe.xml');
        $nfeProtocoled = Complements::toAuthorize($request, $response);
        $this->assertStringContainsString('143220000009921', $nfeProtocoled);
    }

    public function test_to_authorize_nfe_invalid_digest()
    {
        $this->expectException(DocumentsException::class);
        $request = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/retEnviNFe2.xml');
        Complements::toAuthorize($request, $response);
    }

    public function test_to_authorize_inut_cpf(): void
    {
        $request = file_get_contents(__DIR__ . '/fixtures/xml/request_inut_cpf.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/response_inut_cpf.xml');
        $output = Complements::toAuthorize($request, $response);
        $dom = new \DOMDocument();
        $dom->loadXML($output);
        $tag = $dom->getElementsByTagName('ProcInutNFe')->item(0);
        $numeroProtocolo = $tag->getElementsByTagName('nProt')->item(0)->nodeValue;
        $this->assertEquals('151250011427132', $numeroProtocolo);
    }

    public function test_to_authorize_inut_cnpj(): void
    {
        $request = file_get_contents(__DIR__ . '/fixtures/xml/request_inut_cnpj.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/response_inut_cnpj.xml');
        $output = Complements::toAuthorize($request, $response);
        $dom = new \DOMDocument();
        $dom->loadXML($output);
        $tag = $dom->getElementsByTagName('ProcInutNFe')->item(0);
        $numeroProtocolo = $tag->getElementsByTagName('nProt')->item(0)->nodeValue;
        $this->assertEquals('152250025831513', $numeroProtocolo);
    }

    public function testToAuthorizeEvent()
    {
        $request = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<envEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<idLote>123456</idLote>'
            . '<evento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<infEvento Id="ID1101113512345678901234550010000099230100009923">'
            . '<cOrgao>35</cOrgao><tpAmb>2</tpAmb><CNPJ>12345678901234</CNPJ>'
            . '<chNFe>35123456789012345500100000992301000099230</chNFe>'
            . '<dhEvento>2017-11-17T08:26:54-02:00</dhEvento>'
            . '<tpEvento>110110</tpEvento><nSeqEvento>1</nSeqEvento>'
            . '<verEvento>1.00</verEvento>'
            . '<detEvento versao="1.00"><descEvento>Carta de Correcao</descEvento>'
            . '<xCorrecao>Correcao de teste</xCorrecao>'
            . '<xCondUso>A Carta de Correcao e disciplinada pelo paragrafo 1o-A do art. 7o do Convenio S/N</xCondUso>'
            . '</detEvento></infEvento></evento></envEvento>';

        $response = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<retEnvEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<idLote>123456</idLote><tpAmb>2</tpAmb><verAplic>SP_EVENTOS_PL_100</verAplic>'
            . '<cOrgao>35</cOrgao><cStat>128</cStat><xMotivo>Lote de Evento Processado</xMotivo>'
            . '<retEvento versao="1.00"><infEvento Id="ID1101103512345678901234">'
            . '<tpAmb>2</tpAmb><verAplic>SP_EVENTOS_PL_100</verAplic>'
            . '<cOrgao>35</cOrgao><cStat>135</cStat>'
            . '<xMotivo>Evento registrado e vinculado a NF-e</xMotivo>'
            . '<chNFe>35123456789012345500100000992301000099230</chNFe>'
            . '<tpEvento>110110</tpEvento><xEvento>Carta de Correcao</xEvento>'
            . '<nSeqEvento>1</nSeqEvento>'
            . '<dhRegEvento>2017-11-17T08:27:00-02:00</dhRegEvento>'
            . '<nProt>135170000000001</nProt>'
            . '</infEvento></retEvento></retEnvEvento>';

        $result = Complements::toAuthorize($request, $response);
        $this->assertStringContainsString('procEventoNFe', $result);
        $this->assertStringContainsString('135170000000001', $result);
    }

    public function testToAuthorizeFailWrongDocument()
    {
        $this->expectException(DocumentsException::class);
        $request = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<consStatServ xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00">'
            . '<tpAmb>2</tpAmb><cUF>35</cUF><xServ>STATUS</xServ></consStatServ>';
        $response = '<retConsStatServ xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00">'
            . '<tpAmb>2</tpAmb><verAplic>SP</verAplic><cStat>107</cStat>'
            . '<xMotivo>Servico em Operacao</xMotivo><cUF>35</cUF>'
            . '<dhRecbto>2017-11-17T08:26:54-02:00</dhRecbto><tMed>1</tMed>'
            . '</retConsStatServ>';
        Complements::toAuthorize($request, $response);
    }

    public function testToAuthorizeFailNotXML()
    {
        $this->expectException(\Throwable::class);
        Complements::toAuthorize('not xml', 'not xml');
    }

    public function testToAuthorizeFailWrongNode()
    {
        $this->expectException(\Throwable::class);
        Complements::toAuthorize('', '<response/>');
    }

    public function testCancelRegister()
    {
        $nfe = file_get_contents(__DIR__ . '/fixtures/xml/nfe_layout4_com_prot.xml');

        $dom = new \DOMDocument();
        $dom->loadXML($nfe);
        $chNFe = $dom->getElementsByTagName('chNFe')->item(0)->nodeValue;

        $cancelamento = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<retEnvEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<idLote>1</idLote><tpAmb>2</tpAmb><verAplic>SP</verAplic>'
            . '<cOrgao>43</cOrgao><cStat>128</cStat><xMotivo>Lote Processado</xMotivo>'
            . '<retEvento versao="1.00"><infEvento>'
            . '<tpAmb>2</tpAmb><verAplic>SP</verAplic><cOrgao>43</cOrgao>'
            . '<cStat>135</cStat><xMotivo>Evento registrado</xMotivo>'
            . '<chNFe>' . $chNFe . '</chNFe>'
            . '<tpEvento>110111</tpEvento>'
            . '<xEvento>Cancelamento</xEvento><nSeqEvento>1</nSeqEvento>'
            . '<dhRegEvento>2018-09-25T16:00:00-03:00</dhRegEvento>'
            . '<nProt>143180006932433</nProt>'
            . '</infEvento></retEvento></retEnvEvento>';

        $result = Complements::cancelRegister($nfe, $cancelamento);
        $this->assertStringContainsString('retEvento', $result);
        $this->assertStringContainsString('110111', $result);
    }

    public function testCancelRegisterFailNotNFe()
    {
        $this->expectException(DocumentsException::class);
        $nfe = '<?xml version="1.0" encoding="UTF-8"?><NFe xmlns="http://www.portalfiscal.inf.br/nfe">'
            . '<infNFe Id="NFe35170358716523000119550010000000301000000300" versao="4.00">'
            . '</infNFe></NFe>';
        $cancelamento = '<retEnvEvento xmlns="http://www.portalfiscal.inf.br/nfe"><retEvento>'
            . '<infEvento><cStat>135</cStat><nProt>123</nProt><chNFe>123</chNFe>'
            . '<tpEvento>110111</tpEvento></infEvento></retEvento></retEnvEvento>';
        Complements::cancelRegister($nfe, $cancelamento);
    }

    public function testB2B()
    {
        $nfe = file_get_contents(__DIR__ . '/fixtures/xml/nfe_layout4_com_prot.xml');
        $b2b = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<NFeB2BFin xmlns="http://www.portalfiscal.inf.br/nfe">'
            . '<infB2BFin><indPag>0</indPag><vOrigPag>100.00</vOrigPag></infB2BFin>'
            . '</NFeB2BFin>';

        $result = Complements::b2bTag($nfe, $b2b);
        $this->assertStringContainsString('nfeProcB2B', $result);
        $this->assertStringContainsString('NFeB2BFin', $result);
        $this->assertStringContainsString('nfeProc', $result);
    }

    public function testB2BFailNotNFe()
    {
        $this->expectException(DocumentsException::class);
        $nfe = '<?xml version="1.0" encoding="UTF-8"?><NFe xmlns="http://www.portalfiscal.inf.br/nfe">'
            . '<infNFe Id="NFe123" versao="4.00"></infNFe></NFe>';
        $b2b = '<NFeB2BFin><infB2BFin/></NFeB2BFin>';
        Complements::b2bTag($nfe, $b2b);
    }

    public function testB2BFailWrongNode()
    {
        $this->expectException(DocumentsException::class);
        $nfe = file_get_contents(__DIR__ . '/fixtures/xml/nfe_layout4_com_prot.xml');
        $b2b = '<?xml version="1.0" encoding="UTF-8"?><WrongTag><data/></WrongTag>';
        Complements::b2bTag($nfe, $b2b);
    }

    public function testToAuthorizeFailEmptyRequest()
    {
        $this->expectException(DocumentsException::class);
        $this->expectExceptionMessage('protocolar');
        Complements::toAuthorize('', '<retorno/>');
    }

    public function testToAuthorizeFailEmptyResponse()
    {
        $this->expectException(DocumentsException::class);
        $this->expectExceptionMessage('retorno');
        $request = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        Complements::toAuthorize($request, '');
    }

    public function testCancelRegisterNonMatchingChave()
    {
        $nfe = file_get_contents(__DIR__ . '/fixtures/xml/nfe_layout4_com_prot.xml');

        $cancelamento = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<retEnvEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<idLote>1</idLote><tpAmb>2</tpAmb><verAplic>SP</verAplic>'
            . '<cOrgao>43</cOrgao><cStat>128</cStat><xMotivo>Lote Processado</xMotivo>'
            . '<retEvento versao="1.00"><infEvento>'
            . '<tpAmb>2</tpAmb><verAplic>SP</verAplic><cOrgao>43</cOrgao>'
            . '<cStat>135</cStat><xMotivo>Evento registrado</xMotivo>'
            . '<chNFe>99999999999999999999999999999999999999999999</chNFe>'
            . '<tpEvento>110111</tpEvento>'
            . '<xEvento>Cancelamento</xEvento><nSeqEvento>1</nSeqEvento>'
            . '<dhRegEvento>2018-09-25T16:00:00-03:00</dhRegEvento>'
            . '<nProt>143180006932433</nProt>'
            . '</infEvento></retEvento></retEnvEvento>';

        // Non-matching chave should return the NFe without appending retEvento
        $result = Complements::cancelRegister($nfe, $cancelamento);
        $this->assertStringContainsString('nfeProc', $result);
        // retEvento should NOT be appended since chNFe doesn't match
        $resultDom = new \DOMDocument();
        $resultDom->loadXML($result);
        $retEventos = $resultDom->getElementsByTagName('retEvento');
        $this->assertEquals(0, $retEventos->length);
    }
}
