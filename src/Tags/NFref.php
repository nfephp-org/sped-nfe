<?php

namespace NFePHP\NFe\Tags;

class NFref extends Base implements TagInterface
{
    const TAG_NAME = 'NFref';
    
    
    protected $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }
    
    public function toNode()
    {
    }
}
