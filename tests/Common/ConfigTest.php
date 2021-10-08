<?php

namespace NFePHP\NFe\Tests\Common;

use NFePHP\NFe\Common\Config;
use NFePHP\NFe\Tests\NFeTestCase;

class ConfigTest extends NFeTestCase
{
    public function testValidate()
    {
        $resp = Config::validate($this->configJson);
        $b = is_object($resp);
        $this->assertTrue($b);
    }

    public function testValidadeWithoutSomeOptionalData()
    {
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
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
        $b = is_object($resp);
        $this->assertTrue($b);
    }

    public function testValidadeFailWithArray()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
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
        //@phpstan-ignore-next-line
        Config::validate($config);
    }

    public function testValidadeFailWithoutJsonString()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $resp = Config::validate('');
    }

    public function testValidadeFailWithoutTpAmb()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            //"tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
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
    }

    public function testValidadeFailWithoutRazao()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            //"razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
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
    }

    public function testValidadeFailWithoutUF()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            //"siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
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
    }

    public function testValidadeFailWithoutCNPJ()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            //"cnpj" => "99999999999999",
            "schemes" => "PL_008_V4",
            "versao" => "4.00",
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
    }

    public function testValidadeFailWithoutSchemes()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            //"schemes" => "PL_009_V4",
            "versao" => "4.00",
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
    }

    public function testValidadeFailWithoutVersao()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999999",
            "schemes" => "PL_009_V4",
            //"versao" => "4.00",
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
    }

    public function testValidadeWithCPF()
    {
        $config = [
            //"atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "99999999999", //CPF
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
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
        $b = is_object($resp);
        $this->assertTrue($b);
    }
}
