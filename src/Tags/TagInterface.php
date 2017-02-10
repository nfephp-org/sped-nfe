<?php

namespace NFePHP\NFe\Tags;

interface TagInterface
{
    public function toNode();
    
    public function __toString();
}
