<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Dest extends Base implements TagInterface
{
    const TAG_NAME = 'dest';

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
    public $idEstrangeiro;
    /**
     * @var string
     */
    public $xNome;
    /**
     * @var int
     */
    public $indIEDest;
    /**
     * @var string
     */
    public $IE;
    /**
     * @var string
     */
    public $ISUF;
    /**
     * @var string
     */
    public $IM;
    /**
     * @var string
     */
    public $email;
    /**
     * @var EnderDest
     */
    public $enderDest;
    
    public $parameters = [
        'CNPJ'=>'string',
        'CPF'=>'string',
        'idEstrangeiro'=>'string',
        'xNome'=>'string',
        'indIEDest'=>'integer',
        'IE'=>'string',
        'ISUF'=>'string',
        'IM'=>'string',
        'email'=>'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->CNPJ = $this->std->cnpj;
        $this->CPF = $this->std->cpf;
        $this->idEstrangeiro = $this->std->idestrangeiro;
        $this->xNome = $this->std->xnome;
        $this->indIEDest = $this->std->indiedest;
        $this->IE = $this->std->ie;
        $this->ISUF = $this->std->isuf;
        $this->IM = $this->std->im;
        $this->email = $this->std->email;
    }
    
    public function toNode()
    {
        $destTag = $this->dom->createElement("dest");
        $this->dom->addChild(
            $destTag,
            "CNPJ",
            $this->CNPJ,
            false
        );
        $this->dom->addChild(
            $destTag,
            "CPF",
            $this->CPF,
            false
        );
        $this->dom->addChild(
            $destTag,
            "idEstrangeiro",
            $this->idEstrangeiro,
            false
        );
        $this->dom->addChild(
            $destTag,
            "xNome",
            $this->xNome,
            false
        );
        $this->dom->addChild(
            $destTag,
            "indIEDest",
            $this->indIEDest,
            true
        );
        $this->dom->addChild(
            $destTag,
            "IE",
            $this->IE,
            false
        );
        $this->dom->addChild(
            $destTag,
            "ISUF",
            $this->ISUF,
            false
        );
        $this->dom->addChild(
            $destTag,
            "IM",
            $this->IM,
            false
        );
        $this->dom->addChild(
            $destTag,
            "email",
            $this->email,
            false
        );
        if (!empty($this->enderDest)) {
            $this->dom->appExternalChildBefore($destTag, $this->enderDest->toNode(), 'indIEDest');
        }
        $this->node = $destTag;
        return $destTag;
    }
}
