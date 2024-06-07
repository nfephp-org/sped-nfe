<?php

namespace NFePHP\NFe\Tests;

use PHPUnit\Framework\TestCase;

class NFeTestCase extends TestCase
{
    public string $fixturesPath = '';

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->fixturesPath = dirname(__FILE__) . '/fixtures/';
    }
}
