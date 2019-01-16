<?php
namespace NFePHP\NFe\Tests\Factories;

use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Tests\NFeTestCase;

class ContingencyTest extends NFeTestCase
{
    public function testIcanInstantiate()
    {
        $contingency = new Contingency();
        $this->assertInstanceOf('NFePHP\NFe\Factories\Contingency', $contingency);
    }
    
    public function testActivate()
    {
        $contingency = new Contingency();
        $result = $contingency->activate('SP', 'Testes Unitarios');
        $std = json_decode($result);
        $this->assertEquals($std->motive, 'Testes Unitarios');
        $this->assertEquals($std->type, 'SVCAN');
        $this->assertEquals($std->tpEmis, 6);
    }
    
    public function testLoad()
    {
        $cont = [
            'motive' => 'Testes Unitarios',
            'timestamp' => 1480700623,
            'type' => 'SVCAN',
            'tpEmis' => 6
        ];
        $contJson = json_encode($cont);
        $contingency = new Contingency();
        $contingency->load($contJson);
        $this->assertEquals($contJson, $contingency->__toString());
        $this->assertEquals($cont['motive'], $contingency->motive);
        $this->assertEquals($cont['timestamp'], $contingency->timestamp);
        $this->assertEquals($cont['type'], $contingency->type);
        $this->assertEquals($cont['tpEmis'], $contingency->tpEmis);
    }
    
    public function testDeactivate()
    {
        $cont = [
            'motive' => 'Testes Unitarios',
            'timestamp' => 1480700623,
            'type' => 'SVCAN',
            'tpEmis' => 6
        ];
        $contJson = json_encode($cont);
        $contingency = new Contingency($contJson);
        $this->assertEquals($contJson, $contingency->__toString());
        $cont = [
            'motive' => '',
            'timestamp' => 0,
            'type' => '',
            'tpEmis' => 1
        ];
        $contJson = json_encode($cont);
        $contingency->deactivate();
        $this->assertEquals($contJson, $contingency->__toString());
    }
}
