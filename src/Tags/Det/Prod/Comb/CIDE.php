<?php

namespace NFePHP\NFe\Tags\Det\Prod\Comb;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class CIDE extends Base implements TagInterface
{
    const TAG_NAME = 'CIDE';
    
    /**
     * 12v4
     * @var float
     */
    public $qBCProd;
    /**
     * 11v4
     * @var float
     */
    public $vAliqProd;
    /**
     * 12v2
     * @var float
     */
    public $vCIDE;
    
    /**
     * @var array
     */
    protected $parameters = [
        'qBCProd' => [
            'type'=>'double',
            'format'=>'12v4',
            'required'=>true,
            'force'=>true
        ],
        'vAliqProd' => [
            'type'=>'double',
            'format'=>'11v4',
            'required'=>true,
            'force'=>true
        ],
        'vCIDE' => [
            'type'=>'double',
            'format'=>'12v2',
            'required'=>true,
            'force'=>true
        ]
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }
    
     /**
     * Build DOMElement form class properties
     * @return DOMElement
     */
    public function toNode()
    {
        $cideTag = $this->dom->createElement("CIDE");
        $this->dom->addChild(
            $cideTag,
            "qBCProd",
            number_format($this->qBCProd, 4, '.', ','),
            true
        );
        $this->dom->addChild(
            $cideTag,
            "vAliqProd",
            number_format($this->vAliqProd, 4, '.', ','),
            true
        );
        $this->dom->addChild(
            $cideTag,
            "vCIDE",
            number_format($this->vCIDE, 2, '.', ','),
            true
        );
        $this->node = $cideTag;
        return $this->node;
    }
}
