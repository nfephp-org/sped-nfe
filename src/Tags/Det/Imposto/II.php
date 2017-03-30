<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class II extends Base implements TagInterface
{
    const TAG_NAME = 'II';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
