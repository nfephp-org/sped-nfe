<?php

namespace NFePHP\NFe\Tags\Transp;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Vol extends Base implements TagInterface
{
    const TAG_NAME = 'vol';
    
    /**
     * @var integer
     */
    public $qVol;
    /**
     * @var string
     */
    public $esp;
    /**
     * @var string
     */
    public $marca;
    /**
     * @var integer
     */
    public $nVol;
    /**
     * @var float
     */
    public $pesoL;
    /**
     * @var float
     */
    public $pesoB;
    /**
     * @var array Tags\Lacres
     */
    public $lacres = [];
    /**
     * @var array
     */
    public $parameters = [
        'qVol' => 'integer',
        'esp' => 'string',
        'marca' => 'string',
        'nVol' => 'integer',
        'pesoL' => 'double',
        'pesoB' => 'double'
    ];
    public function __construct(stdClass $std)
    {
        parent::__construct($std);

        $this->qVol = $this->std->qvol;
        $this->esp = $this->std->esp;
        $this->marca = $this->std->marca;
        $this->nVol = $this->std->nvol;
        $this->pesoL = $this->std->pesol;
        $this->pesoB = $this->std->pesob;
    }

    public function toNode()
    {
        $volTag = $this->dom->createElement("vol");
        $this->dom->addChild(
            $volTag,
            "qVol",
            $this->qVol,
            false
        );
        $this->dom->addChild(
            $volTag,
            "esp",
            $this->esp,
            false
        );
        $this->dom->addChild(
            $volTag,
            "marca",
            $this->marca,
            false
        );
        $this->dom->addChild(
            $volTag,
            "nVol",
            $this->nVol,
            false
        );
        $this->dom->addChild(
            $volTag,
            "pesoL",
            $this->pesoL,
            false
        );
        $this->dom->addChild(
            $volTag,
            "pesoB",
            $this->pesoB,
            false
        );
        foreach ($this->lacres as $lacre) {
            $this->dom->appExternalChild($volTag, $lacre->toNode());
        }
        $this->node = $volTag;
        return $volTag;
    }
}
