<?php

namespace NFePHP\NFe\Tests;

use NFePHP\Common\Certificate;
use PHPUnit\Framework\TestCase;

class CertificateTest extends TestCase
{
    public function test_certificado_pj(): void
    {
        $conteudo = file_get_contents(TESTS_FIXTURES  . '/certs/novo_cert_cnpj_06157250000116_senha_minhasenha.pfx');
        $certificado = Certificate::readPfx($conteudo, 'minhasenha');
        $this->assertSame('06157250000116', $certificado->getCnpj());
        $this->assertSame('05/06/2034', $certificado->getValidTo()->format('d/m/Y'));
    }

    public function test_certificado_pf(): void
    {
        $conteudo = file_get_contents(TESTS_FIXTURES  . '/certs/novo_cert_cpf_90483926086_minhasenha.pfx');
        $certificado = Certificate::readPfx($conteudo, 'minhasenha');
        $this->assertSame('90483926086', $certificado->getCpf());
        $this->assertSame('03/06/2034', $certificado->getValidTo()->format('d/m/Y'));
    }
}
