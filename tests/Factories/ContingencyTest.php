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

    public function testActivateExceptionFailForcedType()
    {
        $this->expectException(\RuntimeException::class);
        $contingency = new Contingency();
        $result = $contingency->activate('SP', 'Testes Unitarios', 'SVAN');
    }

    public function testActivateExceptionFailIncorrectSmallerMotive()
    {
        $this->expectException(\RuntimeException::class);
        $contingency = new Contingency();
        $result = $contingency->activate('SP', 'Testes');
    }

    public function testActivateExceptionFailIncorrectGreaterMotive()
    {
        $this->expectException(\RuntimeException::class);
        $contingency = new Contingency();
        $motive = "Eu fui emitir uma NFe e a SEFAZ autorizadora estava fora do ar, "
            . "entrei em contato com o técnico de informática que me mandou acionar o modo de contingência, "
            . "indicando o motivo. Nosso diretor está exigindo a emissão da NFe agora, e sei não sei mais o que fazer."
            ." Então fiz essa tentativa agora.";
        $result = $contingency->activate('SP', $motive);
    }

    public function testActivateForcedTypeSVCAN()
    {
        $contingency = new Contingency();
        $result = $contingency->activate('AM', 'Testes Unitarios', 'SVCAN');
        $std = json_decode($result);
        $this->assertEquals($std->motive, 'Testes Unitarios');
        $this->assertEquals($std->type, 'SVCAN');
        $this->assertEquals($std->tpEmis, 6);
    }

    public function testActivateForcedTypeSVCRS()
    {
        $contingency = new Contingency();
        $result = $contingency->activate('SP', 'Testes Unitarios', 'SVCRS');
        $std = json_decode($result);
        $this->assertEquals($std->motive, 'Testes Unitarios');
        $this->assertEquals($std->type, 'SVCRS');
        $this->assertEquals($std->tpEmis, 7);
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
