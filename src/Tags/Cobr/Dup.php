<?php

namespace NFePHP\NFe\Tags\Cobr;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Dup extends Base implements TagInterface
{
    const TAG_NAME = 'dup';

    /**
     * @var string
     */
    public $nDup;
    /**
     * @var string
     */
    public $dVenc;
    /**
     * 13v2
     * @var float
     */
    public $vDup;

    public $parameters = [
        'nDup' => 'string',
        'dVenc' => 'string',
        'vDup' => 'double'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);

        $this->nDup = $this->std->ndup;
        $this->dVenc = $this->std->dvenc;
        $this->vDup = $this->std->vdup;
    }

    public function toNode()
    {
        $dupTag = $this->dom->createElement("dup");
        $this->dom->addChild(
            $dupTag,
            "nDup",
            $this->nDup,
            false
        );
        $this->dom->addChild(
            $dupTag,
            "dVenc",
            $this->dVenc,
            false
        );
        $this->dom->addChild(
            $dupTag,
            "vDup",
            number_format($this->vDup, 2, '.', ''),
            true
        );
        $this->node = $dupTag;
        return $dupTag;
    }
}
