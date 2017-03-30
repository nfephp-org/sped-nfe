<?php

namespace NFePHP\NFe\Tags\Transp;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Reboque extends Base implements TagInterface
{
    const TAG_NAME = 'reboque';
    /**
     * @var string
     */
    public $placa;
    /**
     * @var string
     */
    public $UF;
    /**
     * @var string
     */
    public $RNTC;
    /**
     * @var array
     */
    public $parameters = [
        'placa' => 'string',
        'UF' => 'string',
        'RNTC' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->placa = $this->std->placa;
        $this->UF = $this->std->uf;
        $this->RNTC = $this->std->rntc;
    }
    
    public function toNode()
    {
        $reboqueTag = $this->dom->createElement("reboque");
        $this->dom->addChild(
            $reboqueTag,
            "placa",
            $this->placa,
            true
        );
        $this->dom->addChild(
            $reboqueTag,
            "UF",
            $this->UF,
            true
        );
        $this->dom->addChild(
            $reboqueTag,
            "RNTC",
            $this->RNTC,
            false
        );
        $this->node = $reboqueTag;
        return $reboqueTag;
    }
}
