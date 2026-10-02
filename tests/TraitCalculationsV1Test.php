<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Traits\TraitCalculations;
use PHPUnit\Framework\TestCase;
use stdClass;

class TraitCalculationsV1Test extends TestCase
{
    /**
     * @param array<string, float|int> $overrides
     */
    private function calculate(array $overrides): float
    {
        $probe = new class {
            use TraitCalculations;

            /** @var array<int, array<string, float|int>> */
            public $aVItem;

            /** @var stdClass */
            public $stdTot;

            public function run(): void
            {
                $this->calculateTtensValues1();
            }
        };
        $probe->stdTot = new stdClass();
        $probe->stdTot->vNFTotCalculated = 0;
        $item = [
            'tpOp' => 0,
            'indTot' => 1,
            'vProd' => 0,
            'indDeduzDeson' => 0,
            'indSomaPISST' => 0,
            'indSomaCOFINSST' => 0,
            'vIBS' => 0,
            'vCBS' => 0,
            'vIS' => 0,
            'vTotIBSMonoItem' => 0,
            'vTotCBSMonoItem' => 0,
        ];
        $probe->aVItem = [1 => array_merge($item, $overrides)];
        $probe->run();

        return (float) $probe->aVItem[1]['vItemCalculated'];
    }

    public function testProductValueSurvivesWhenTheNewTaxesAreZero(): void
    {
        $this->assertEqualsWithDelta(100.0, $this->calculate(['vProd' => 100]), 0.001);
    }

    public function testNewTaxesAreNotFoldedIntoTheItemDuring2026(): void
    {
        $this->assertEqualsWithDelta(100.0, $this->calculate([
            'vProd' => 100,
            'vIBS' => 0.9,
            'vCBS' => 0.1,
            'vTotIBSMonoItem' => 2,
            'vTotCBSMonoItem' => 3,
        ]), 0.001);
    }
}
