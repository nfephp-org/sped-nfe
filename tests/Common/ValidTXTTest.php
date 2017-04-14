<?php

namespace NFePHP\NFe\Tests\Common;

use NFePHP\NFe\Common\ValidTXT;
use NFePHP\NFe\Tests\NFeTestCase;

class ValidTXTTest extends NFeTestCase
{
    /**
     * @covers ClassName::<protected>
     */
    public function testIsValid()
    {
        $expected = json_decode(
            file_get_contents($this->fixturesPath . 'nfe_errado.json'),
            true
        );
        $txt = file_get_contents($this->fixturesPath . 'nfe_errado.txt');
        $actual = ValidTXT::isValid($txt);
        $this->assertEquals(
            $expected,
            $actual,
            "\$canonicalize = true",
            $delta = 0.0,
            $maxDepth = 1,
            $canonicalize = true
        );
    }
}
