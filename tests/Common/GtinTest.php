<?php

namespace NFePHP\NFe\Tests\Common;

use NFePHP\NFe\Common\Gtin;
use PHPUnit\Framework\TestCase;

class GtinTest extends TestCase
{
    /**
     * @return void
     */
    public function test_is_valid()
    {
        $this->assertTrue(Gtin::isValid(''));
        $this->assertTrue(Gtin::isValid('SEM GTIN'));
        $this->assertTrue(Gtin::isValid('7898357410015'));
    }

    /**
     * @return void
     */
    public function test_is_invalid_1()
    {
        $this->expectException(\InvalidArgumentException::class);
        Gtin::isValid('7898357410010');
    }

    /**
     * @return void
     */
    public function test_is_invalid_2()
    {
        $this->expectException(\InvalidArgumentException::class);
        Gtin::isValid('abc');
    }
}
