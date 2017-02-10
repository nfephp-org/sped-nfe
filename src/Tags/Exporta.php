<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Exporta extends Base implements TagInterface
{
    const TAG_NAME = 'exporta';
    public $UFSaidaPais;
    public $xLocExporta;
    public $xLocDespacho;
    public $parameters = [
        'UFSaidaPais' => 'string',
        'xLocExporta' => 'string',
        'xLocDespacho' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->UFSaidaPais = $this->std->ufsaidapais;
        $this->xLocExporta = $this->std->xlocexporta;
        $this->xLocDespacho = $this->std->xlocdespacho;
    }
    
    public function toNode()
    {
        $exporta = $this->dom->createElement("exporta");
        $this->dom->addChild(
            $exporta,
            "UFSaidaPais",
            $this->UFSaidaPais,
            true
        );
        $this->dom->addChild(
            $exporta,
            "xLocExporta",
            $this->xLocExporta,
            true
        );
        $this->dom->addChild(
            $exporta,
            "xLocDespacho",
            $this->xLocDespacho,
            false
        );
        $this->node = $exporta;
        return $exporta;
    }
}
