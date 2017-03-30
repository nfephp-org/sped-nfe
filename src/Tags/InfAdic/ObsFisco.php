<?php

namespace NFePHP\NFe\Tags\InfAdic;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class ObsFisco extends Base implements TagInterface
{
    const TAG_NAME = 'obsFisco';
    public $xCampo;
    public $xTexto;
    public $parameters = [
        'xCampo' => 'string',
        'xTexto' => 'string'
    ];

    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->xCampo = $this->std->xcampo;
        $this->xTexto = $this->std->xtexto;
    }

    public function toNode()
    {
        $obsFiscoTag = $this->dom->createElement(self::TAG_NAME);
        $this->dom->addChild(
            $obsFiscoTag,
            "xCampo",
            $this->xCampo,
            true
        );
        $this->dom->addChild(
            $obsFiscoTag,
            "xTexto",
            $this->xTexto,
            true
        );
        $this->node = $obsFiscoTag;
        return $obsFiscoTag;
    }
}
