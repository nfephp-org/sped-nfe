<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class PIS extends Base implements TagInterface
{
    const TAG_NAME = 'PIS';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
