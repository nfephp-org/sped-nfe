<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class IPI extends Base implements TagInterface
{
    const TAG_NAME = 'IPI';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
