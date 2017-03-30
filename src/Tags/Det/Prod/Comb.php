<?php

namespace NFePHP\NFe\Tags\Det\Prod;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use NFePHP\NFe\Tags\Comb\CIDE;
use stdClass;

class Comb extends Base implements TagInterface
{
    const TAG_NAME = 'comb';
    
    /**
     * @var integer
     */
    public $cProdANP;
    /**
     * EXCLUIDO na versão 4.0 do layout
     * 3v4
     * @var float
     */
    public $pMixGN;
    /**
     * INCLUIDO v4.0
     * @var string
     */
    public $descANP;
    /**
     * INCLUIDO v4.0
     * 1v4
     * @var float
     */
    public $pGLP;
    /**
     * INCLUIDO v4.0
     * 1v4
     * @var float
     */
    public $pGNn;
    /**
     * INCLUIDO v4.0
     * 1v4
     * @var float
     */
    public $pGNi;
    /**
     * INCLUIDO v4.0
     * 13v2
     * @var float
     */
    public $vPart;
    /**
     * @var string
     */
    public $CODIF;
    /**
     * 12v4
     * @var float
     */
    public $qTemp;
    /**
     * @var string
     */
    public $UFCons;
    /**
     * @var CIDE
     */
    public $CIDE;
    
    /**
     * @var array
     */
    protected $parameters = [
        'qBCProd' => ['double', ],
        'vAliqProd' => ['double'],
        'vCIDE' => ['double']
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
        $combTag = $this->dom->createElement(self::TAG_NAME);
        $this->dom->addChild(
            $combTag,
            "cProdANP",
            $this->cProdANP,
            true
        );
        $this->dom->addChild(
            $combTag,
            "cProdANP",
            $this->cProdANP,
            true
        );
   
        //public $pMixGN;
        //public $descANP;
        //public $pGLP;
        //public $pGNn;
        //public $pGNi;
        //public $vPart;
        //public $CODIF;
        //public $qTemp;
        //public $UFCons;
        //public $CIDE;
    }
}
