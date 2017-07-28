<?php

namespace NFePHP\NFe\Tests\Common;

use NFePHP\NFe\Common\Config;
use NFePHP\NFe\Tests\NFeTestCase;

class ConfigTest extends NFeTestCase
{
    public function testValidate()
    {
        $resp = Config::validate($this->configJson);
        $this->assertTrue($resp);
    }
    
    public function testValidadeWithoutSomeOptionalData()
    {
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_008i2",
            "versao" => "3.10",
            //"tokenIBPT" => "AAAAAAA",
            //"CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            //"CSCid" => "000001",
            //"aProxyConf" => [
            //    "proxyIp" => "",
            //    "proxyPort" => "",
            //    "proxyUser" => "",
            //    "proxyPass" => ""
            //]
        ];
        $resp = Config::validate(json_encode($config));
        $this->assertTrue($resp);
    }
    
    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testValidadeFailWithoutTpAmb()
    {
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            //"tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_008i2",
            "versao" => "3.10",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            "aProxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]
        ];
        $resp = Config::validate(json_encode($config));
        $this->assertFalse($resp);
    }
    
    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testValidadeFailWithoutRazao()
    {
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            //"razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_008i2",
            "versao" => "3.10",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            //"aProxyConf" => [
            //    "proxyIp" => "",
            //    "proxyPort" => "",
            //    "proxyUser" => "",
            //    "proxyPass" => ""
            //]
        ];
        $resp = Config::validate(json_encode($config));
        $this->assertFalse($resp);
    }
    
    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testValidadeFailWithoutUF()
    {
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            //"siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_008i2",
            "versao" => "3.10",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            //"aProxyConf" => [
            //    "proxyIp" => "",
            //    "proxyPort" => "",
            //    "proxyUser" => "",
            //    "proxyPass" => ""
            //]
        ];
        $resp = Config::validate(json_encode($config));
        $this->assertFalse($resp);
    }
    
    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testValidadeFailWithoutCNPJ()
    {
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            //"cnpj" => "99999999999999",
            "schemes" => "PL_008i2",
            "versao" => "3.10",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            //"aProxyConf" => [
            //    "proxyIp" => "",
            //    "proxyPort" => "",
            //    "proxyUser" => "",
            //    "proxyPass" => ""
            //]
        ];
        $resp = Config::validate(json_encode($config));
        $this->assertFalse($resp);
    }

    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testValidadeFailWithoutSchemes()
    {
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            //"schemes" => "PL_008i2",
            "versao" => "3.10",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            //"aProxyConf" => [
            //    "proxyIp" => "",
            //    "proxyPort" => "",
            //    "proxyUser" => "",
            //    "proxyPass" => ""
            //]
        ];
        $resp = Config::validate(json_encode($config));
        $this->assertFalse($resp);
    }
    
    /**
     * @expectedException NFePHP\NFe\Exception\DocumentsException
     */
    public function testValidadeFailWithoutVersao()
    {
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_008i2",
            //"versao" => "3.10",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            //"aProxyConf" => [
            //    "proxyIp" => "",
            //    "proxyPort" => "",
            //    "proxyUser" => "",
            //    "proxyPass" => ""
            //]
        ];
        $resp = Config::validate(json_encode($config));
        $this->assertFalse($resp);
    }
}
