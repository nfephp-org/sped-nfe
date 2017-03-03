<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class RetTransp extends Base implements TagInterface
{
    const TAG_NAME = 'retTransp';
 
    public $vServ;
    public $vBCRet;
    public $pICMSRet;
    public $vICMSRet;
    public $CFOP;
    public $cMunFG;
    
    public $parameters = [
        'vServ' => 'double',
        'vBCRet' => 'double',
        'pICMSRet' => 'double',
        'vICMSRet' => 'double',
        'CFOP' => 'integer',
        'cMunFG' => 'integer'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);

        $this->vServ = $this->std->vserv;
        $this->vBCRet = $this->std->vbcret;
        $this->pICMSRet = $this->std->picmsret;
        $this->vICMSRet = $this->std->vicmsret;
        $this->CFOP = $this->std->cfop;
        $this->cMunFG = $this->std->cmunfg;
    }
    
    public function toNode()
    {
        $retTranspTag = $this->dom->createElement("retTransp");
        $this->dom->addChild(
            $retTranspTag,
            "vServ",
            $this->vServ,
            true
        );
        $this->dom->addChild(
            $retTranspTag,
            "vBCRet",
            $this->vBCRet,
            true
        );
        $this->dom->addChild(
            $retTranspTag,
            "pICMSRet",
            $this->pICMSRet,
            true
        );
        $this->dom->addChild(
            $retTranspTag,
            "vICMSRet",
            $this->vICMSRet,
            true
        );
        $this->dom->addChild(
            $retTranspTag,
            "CFOP",
            $this->CFOP,
            true
        );
        $this->dom->addChild(
            $retTranspTag,
            "cMunFG",
            $this->cMunFG,
            true
        );
        $this->node = $retTranspTag;
        return $retTranspTag;
    }
}
