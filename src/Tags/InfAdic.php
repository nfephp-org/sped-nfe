<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class InfAdic extends Base implements TagInterface
{
    const TAG_NAME = 'infAdic';
    
    public $infAdFisco;
    public $infCpl;
    public $obsCont = [];
    public $obsFisco = [];
    public $procRef = [];
    
    public $parameters = [
        'infAdFisco' => 'string',
        'infCpl' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->infAdFisco = $this->std->infadfisco;
        $this->infCpl = $this->std->infcpl;
    }
    
    public function toNode()
    {
        $infAdicTag = $this->dom->createElement("infAdic");
        $this->dom->addChild(
            $infAdicTag,
            "infAdFisco",
            $this->infAdFisco,
            false
        );
        $this->dom->addChild(
            $infAdicTag,
            "infCpl",
            $this->infCpl,
            false
        );
        foreach ($this->obsCont as $obs) {
            $this->dom->appExternalChild($infAdicTag, $obs->toNode());
        }
        foreach ($this->obsFisco as $obs) {
            $this->dom->appExternalChild($infAdicTag, $obs->toNode());
        }
        foreach ($this->procRef as $obs) {
            $this->dom->appExternalChild($infAdicTag, $obs->toNode());
        }
        $this->node = $infAdicTag;
        return $infAdicTag;
    }
}
