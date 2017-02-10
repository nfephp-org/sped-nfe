<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class ProcRef extends Base implements TagInterface
{
    const TAG_NAME = 'procRef';
    public $nProc;
    public $indProc;
    
    public $parameters = [
        'nProc' => 'string',
        'indProc' => 'integer'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->nProc = $this->std->nproc;
        $this->indProc = $this->std->indproc;
    }

    public function toNode()
    {
        $procRefTag = $this->dom->createElement("procRef");
        $this->dom->addChild(
            $procRefTag,
            "nProc",
            $this->nProc,
            true
        );
        $this->dom->addChild(
            $procRefTag,
            "indProc",
            $this->indProc,
            true
        );
        $this->node = $procRefTag;
        return $procRefTag;
    }
}
