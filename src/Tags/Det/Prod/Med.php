<?php

namespace NFePHP\NFe\Tags\Det\Prod;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;

class Med extends Base implements TagInterface
{
    /**
     * Layout v4.0
     * @var string
     */
    public $cProdANVISA;
    /**
     * EXCLUIDO do layout 4.0
     * @var string
     */
    public $nLote;
    /**
     * EXCLUIDO do layout 4.0
     * 8v3
     * @var float
     */
    public $qLote;
    /**
     * EXCLUIDO do layout 4.0
     * @var DateTime
     */
    public $dFab;
    /**
     * EXCLUIDO do layout 4.0
     * @var DateTime
     */
    public $dVal;
    /**
     * 13v2
     * @var float
     */
    public $vPMC;
    
     /**
     * @var array
     */
    protected $parameters = [
        'cProdANVISA'   => 'string',
        'nLote'         => 'string',
        'qLote'         => 'double',
        'dFab'          => 'object:\DateTime',
        'dVal'          => 'object:\DateTime',
        'vPMC'          => 'double'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }
    
    /**
     * Build DOMElement form class properties
     * @return DOMElement
     */
    public function toNode()
    {
    }
}
