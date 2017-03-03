<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Cana extends Base implements TagInterface
{
    const TAG_NAME = 'cana';
    
    /**
     * AAAA or AAAA/AAAA
     * @var string
     */
    public $safra;
    /**
     * MM/AAAA
     * @var string
     */
    public $ref;
    /**
     * 11v10
     * @var float
     */
    public $qTotMes;
    /**
     * 11v10
     * @var float
     */
    public $qTotAnt;
    /**
     * 11v10
     * @var float
     */
    public $qTotGer;
    /**
     * 13v2
     * @var float
     */
    public $vFor;
    /**
     * 13v2
     * @var float
     */
    public $vTotDed;
    /**
     * 13v2
     * @var float
     */
    public $vLiqFor;
    /**
     * @var array Tags\ForDia
     */
    public $forDia = [];
    /**
     * @var array Tags\Deduc
     */
    public $deduc = [];
    
    public $parameters = [
        'safra' => 'string',
        'ref' => 'string',
        'qTotMes' => 'double',
        'qTotAnt' => 'double',
        'qTotGer' => 'double',
        'vFor' => 'double',
        'vTotDed' => 'double',
        'vLiqFor' => 'double'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->safra = $this->std->safra;
        $this->ref = $this->std->ref;
        $this->qTotMes = $this->std->qtotmes;
        $this->qTotAnt = $this->std->qtotant;
        $this->qTotGer = $this->std->qtotger;
        $this->vFor = $this->std->vfor;
        $this->vTotDed = $this->std->vtotded;
        $this->vLiqFor = $this->std->vliqfor;
    }
    
    public function toNode()
    {
        $canaTag = $this->dom->createElement("cana");
        $this->dom->addChild(
            $canaTag,
            "safra",
            $this->safra,
            true
        );
        $this->dom->addChild(
            $canaTag,
            "ref",
            $this->ref,
            true
        );
        foreach ($this->forDia as $fd) {
            $this->dom->appExternalChild($canaTag, $fd->toNode());
        }
        $this->dom->addChild(
            $canaTag,
            "qTotMes",
            number_format($this->qTotMes, 10, '.', ''),
            true
        );
        $this->dom->addChild(
            $canaTag,
            "qTotAnt",
            number_format($this->qTotAnt, 10, '.', ''),
            true
        );
        $this->dom->addChild(
            $canaTag,
            "qTotGer",
            number_format($this->qTotGer, 10, '.', ''),
            true
        );
        if (!empty($this->deduc)) {
            $this->vTotDed = 0;
        }
        foreach ($this->deduc as $ded) {
            $this->dom->appExternalChild($canaTag, $ded->toNode());
            $this->vTotDed += $ded->vDed;
        }
        $this->dom->addChild(
            $canaTag,
            "vFor",
            number_format($this->vFor, 2, '.', ''),
            true
        );
        $this->dom->addChild(
            $canaTag,
            "vTotDed",
            number_format($this->vTotDed, 2, '.', ''),
            true
        );
        $this->vLiqFor = $this->vFor - $this->vTotDed;
        $this->dom->addChild(
            $canaTag,
            "vLiqFor",
            number_format($this->vLiqFor, 2, '.', ''),
            true
        );
        $this->node = $canaTag;
        return $canaTag;
    }
}
