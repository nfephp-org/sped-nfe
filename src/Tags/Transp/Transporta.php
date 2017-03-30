<?php

namespace NFePHP\NFe\Tags\Transp;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Transporta extends Base implements TagInterface
{
    const TAG_NAME = 'transporta';
 
    /**
     * @var string
     */
    public $CNPJ;
    /**
     * @var string
     */
    public $CPF;
    /**
     * @var string
     */
    public $xNome;
    /**
     * @var string
     */
    public $IE;
    /**
     * @var string
     */
    public $xEnder;
    /**
     * @var string
     */
    public $xMun;
    /**
     * @var string
     */
    public $UF;
    
    /**
     * @var string
     */
    public $nLacre;
    
    public $parameters = [
        'CNPJ' => 'string',
        'CPF' => 'string',
        'xNome' => 'string',
        'IE' => 'string',
        'xEnder' => 'string',
        'xMun' => 'string',
        'UF' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);

        $this->CNPJ = $this->std->cnpj;
        $this->CPF = $this->std->cpf;
        $this->xNome = $this->std->xnome;
        $this->IE = $this->std->ie;
        $this->xEnder = $this->std->xender;
        $this->xMun = $this->std->xmun;
        $this->UF = $this->std->uf;
    }
    
    public function toNode()
    {
        $transportaTag = $this->dom->createElement("transporta");
        $this->dom->addChild(
            $transportaTag,
            "CNPJ",
            $this->CNPJ,
            false
        );
        $this->dom->addChild(
            $transportaTag,
            "CPF",
            $this->CPF,
            false
        );
        $this->dom->addChild(
            $transportaTag,
            "xNome",
            $this->xNome,
            false
        );
        $this->dom->addChild(
            $transportaTag,
            "IE",
            $this->IE,
            false
        );
        $this->dom->addChild(
            $transportaTag,
            "xEnder",
            $this->xEnder,
            false
        );
        $this->dom->addChild(
            $transportaTag,
            "xMun",
            $this->xMun,
            false
        );
        $this->dom->addChild(
            $transportaTag,
            "UF",
            $this->UF,
            false
        );
        $this->node = $transportaTag;
        return $transportaTag;
    }
}
