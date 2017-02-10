<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class EnderEmit extends Base implements TagInterface
{
    const TAG_NAME = 'enderEmit';

    public $xLgr;
    public $nro;
    public $xCpl;
    public $xBairro;
    public $cMun;
    public $xMun;
    public $UF;
    public $CEP;
    public $cPais;
    public $xPais;
    public $fone;
    
    public $parameters = [
        'xLgr'=>'string',
        'nro'=>'string',
        'xCpl'=>'string',
        'xBairro'=>'string',
        'cMun'=>'string',
        'xMun'=>'string',
        'UF'=>'string',
        'CEP'=>'string',
        'cPais'=>'string',
        'xPais'=>'string',
        'fone'=>'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->xLgr = $this->std->xlgr;
        $this->nro = $this->std->nro;
        $this->xCpl = $this->std->xcpl;
        $this->xBairro = $this->std->xbairro;
        $this->cMun = $this->std->cmun;
        $this->xMun = $this->std->xmun;
        $this->UF = $this->std->uf;
        $this->CEP = $this->std->cep;
        $this->cPais = $this->std->cpais;
        $this->xPais = $this->std->xpais;
        $this->fone = $this->std->fone;
    }
    
    public function toNode()
    {
        $enderEmitTag = $this->dom->createElement("enderEmit");
        $this->dom->addChild(
            $enderEmitTag,
            "xLgr",
            $this->xLgr,
            true
        );
        $this->dom->addChild(
            $enderEmitTag,
            "nro",
            $this->nro,
            true
        );
        $this->dom->addChild(
            $enderEmitTag,
            "xCpl",
            $this->xCpl,
            false
        );
        $this->dom->addChild(
            $enderEmitTag,
            "xBairro",
            $this->xBairro,
            true
        );
        $this->dom->addChild(
            $enderEmitTag,
            "cMun",
            $this->cMun,
            true
        );
        $this->dom->addChild(
            $enderEmitTag,
            "xMun",
            $this->xMun,
            true
        );
        $this->dom->addChild(
            $enderEmitTag,
            "UF",
            $this->UF,
            true
        );
        $this->dom->addChild(
            $enderEmitTag,
            "CEP",
            $this->CEP,
            true
        );
        $this->dom->addChild(
            $enderEmitTag,
            "cPais",
            $this->cPais,
            false
        );
        $this->dom->addChild(
            $enderEmitTag,
            "xPais",
            $this->xPais,
            false
        );
        $this->dom->addChild(
            $enderEmitTag,
            "fone",
            $this->fone,
            false
        );
        $this->node = $enderEmitTag;
        return $enderEmitTag;
    }
}
