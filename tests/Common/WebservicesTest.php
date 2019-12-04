<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 28/09/18
 * Time: 18:00
 */

namespace NFePHP\NFe\Tests\Common;

use NFePHP\NFe\Common\Webservices;
use PHPUnit\Framework\TestCase;

class WebservicesTest extends TestCase
{
    const SEFAZ_AMB_HOMOLOG = '2';
    const NFE_MODELO_55 = 55;
    const AN_INVALID_BRAZILIAN_UF_ABREV = 'XY';

    /**
     * @var string
     */
    protected $xml;

    protected function setUp(): void
    {
        $filepath = __DIR__ . '/../../storage/wsnfe_4.00_mod55.xml';
        $this->xml = file_get_contents($filepath);
    }

    public function testIcanInstantiate()
    {
        $this->assertInstanceOf('NFePHP\NFe\Common\Webservices', new Webservices($this->xml));
    }

    public function testGetWebserviceValidUF()
    {
        $ws = new Webservices($this->xml);
        $ret = $ws->get('RS', self::SEFAZ_AMB_HOMOLOG, self::NFE_MODELO_55);
        $this->assertInstanceOf('\\stdClass', $ret);
    }

    public function testRuntimeExceptionUsingAnInvalidUF()
    {
        $this->expectException(\RuntimeException::class);
        $ws = new Webservices($this->xml);
        $ws->get(self::AN_INVALID_BRAZILIAN_UF_ABREV, self::SEFAZ_AMB_HOMOLOG, self::NFE_MODELO_55);
    }
}
