<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class ICMSPart extends Base implements TagInterface
{
    const TAG_NAME = 'ICMSPart';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
