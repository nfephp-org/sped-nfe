<?php

use NFePHP\NFe\Convertion\Base;

class AEntity extends Base
{
    public $key;
    public $version;
    
    public function __construct($lin)
    {
        parent::__construct($lin);
    }
}
