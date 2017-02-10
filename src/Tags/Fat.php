<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Fat extends Base implements TagInterface
{
    const TAG_NAME = 'fat';
    
    /**
     * @var string
     */
    public $nFat;
    /**
     * 13v2
     * @var float
     */
    public $vOrig;
    /**
     * 13v2
     * @var float
     */
    public $vDesc;
    /**
     * 13v2
     * @var float
     */
    public $vLiq;
    
    public $parameters = [
        'nFat' => 'string',
        'vOrig' => 'double',
        'vDesc' => 'double',
        'vLiq' => 'double'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->nFat = $this->std->nfat;
        $this->vOrig = $this->std->vorig;
        $this->vDesc = $this->std->vdesc;
        $this->vLiq = $this->std->vliq;
    }

    public function toNode()
    {
        $fatTag = $this->dom->createElement("fat");
        $this->dom->addChild(
            $fatTag,
            "nFat",
            $this->nFat,
            false
        );
        $this->dom->addChild(
            $fatTag,
            "vOrig",
            number_format($this->vOrig, 2, '.', ''),
            false
        );
        $this->dom->addChild(
            $fatTag,
            "vDesc",
            number_format($this->vDesc, 2, '.', ''),
            false
        );
        $this->dom->addChild(
            $fatTag,
            "vLiq",
            number_format($this->vLiq, 2, '.', ''),
            false
        );
        $this->node = $fatTag;
        return $fatTag;
    }
}
