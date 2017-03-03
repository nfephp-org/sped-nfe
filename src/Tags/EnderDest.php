<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class EnderDest extends Base implements TagInterface
{
    const TAG_NAME = 'enderDest';
    
    /**
     * @var string
     */
    public $xLgr;
    /**
     * @var int
     */
    public $nro;
    /**
     * @var string
     */
    public $xCpl;
    /**
     * @var string
     */
    public $xBairro;
    /**
     * @var int
     */
    public $cMun;
    /**
     * @var string
     */
    public $xMun;
    /**
     * @var string
     */
    public $UF;
    /**
     * @var int
     */
    public $CEP;
    /**
     * @var int
     */
    public $cPais;
    /**
     * @var string
     */
    public $xPais;
    /**
     * @var string
     */
    public $fone;
    
    public $parameters = [
        'xLgr' => 'string',
        'nro' => 'integer',
        'xCpl' => 'string',
        'xBairro' => 'string',
        'cMun' => 'integer',
        'xMun' => 'string',
        'UF' => 'string',
        'CEP' => 'integer',
        'cPais' => 'integer',
        'xPais' => 'string',
        'fone' => 'string'
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
        $enderDestTag = $this->dom->createElement("enderDest");
        $this->dom->addChild(
            $enderDestTag,
            "xLgr",
            $this->xLgr,
            true
        );
        $this->dom->addChild(
            $enderDestTag,
            "nro",
            $this->nro,
            true
        );
        $this->dom->addChild(
            $enderDestTag,
            "xCpl",
            $this->xCpl,
            false
        );
        $this->dom->addChild(
            $enderDestTag,
            "xBairro",
            $this->xBairro,
            true
        );
        $this->dom->addChild(
            $enderDestTag,
            "cMun",
            $this->cMun,
            true
        );
        $this->dom->addChild(
            $enderDestTag,
            "xMun",
            $this->xMun,
            true
        );
        $this->dom->addChild(
            $enderDestTag,
            "UF",
            $this->UF,
            true
        );
        $this->dom->addChild(
            $enderDestTag,
            "CEP",
            $this->CEP,
            false
        );
        $this->dom->addChild(
            $enderDestTag,
            "cPais",
            $this->cPais,
            false
        );
        $this->dom->addChild(
            $enderDestTag,
            "xPais",
            $this->xPais,
            false
        );
        $this->dom->addChild(
            $enderDestTag,
            "fone",
            $this->fone,
            false
        );
        $this->node = $enderDestTag;
        return $enderDestTag;
    }
}
