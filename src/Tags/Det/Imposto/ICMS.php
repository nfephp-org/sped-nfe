<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class ICMS extends Base implements TagInterface
{
    const TAG_NAME = 'ICMS';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
