<?php

namespace NFePHP\NFe\Tests;

use NFePHP\Common\Certificate;
use NFePHP\NFe\Tools;

class ToolsTest extends NFeTestCase
{
    /**
     * @var Tools
     */
    protected $tools;
    
    protected function setUp()
    {
        $this->tools = new Tools($this->configJson, Certificate::readPfx($this->contentpfx, $this->passwordpfx));
    }
    
    /**
     * Testa a consulta pelo número do recibo validando o parâmetro vazio.
     */
    public function testSefazConsultaReciboThrowsInvalidArgExceptionSemRecibo()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaRecibo('');
    }
    
    /**
     * Testa a consulta pela chave validando o parâmetro da chave vazio.
     */
    public function testSefazConsultaChaveThrowsInvalidArgExceptionSemChave()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('');
    }
    
    /**
     * Testa a consulta pela chave validando o parâmetro de chave incompleta (comprimento diferente de 44 dígitos).
     */
    public function testSefazConsultaChaveThrowsInvalidArgExceptionChaveCompleta()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('1234567890123456789012345678901234567890123'); // 43 dígitos
    }
    
    /**
     * Testa a consulta pela chave validando uma chave alfanumérica.
     */
    public function testSefazConsultaChaveThrowsInvalidArgExceptionChaveNaoNumerica()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('aqui temos uma chave nao numerica');
    }
}
