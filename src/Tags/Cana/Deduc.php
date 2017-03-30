<?php

namespace NFePHP\NFe\Tags\Cana;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Deduc extends Base implements TagInterface
{
    const TAG_NAME = 'deduc';
    
    /**
     * C 1-60
     * @var string
     */
    public $xDed;
    /**
     * 13v2
     * @var float
     */
    public $vDed;
    
    public $parameters = [
        'xDed' => 'string',
        'vDed' => 'double'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->xDed = $this->std->xded;
        $this->vDed = $this->std->vded;
    }

    public function toNode()
    {
        $deducTag = $this->dom->createElement("deduc");
        $this->dom->addChild(
            $deducTag,
            "xDed",
            $this->xDed,
            true
        );
        $this->dom->addChild(
            $deducTag,
            "vDed",
            number_format($this->vDed, 2, '.', ''),
            true
        );
        $this->node = $deducTag;
        return $deducTag;
    }
}
