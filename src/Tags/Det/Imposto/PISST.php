<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class PISST extends Base implements TagInterface
{
    const TAG_NAME = 'PISST';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
