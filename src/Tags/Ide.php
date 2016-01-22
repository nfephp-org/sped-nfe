<?php

namespace NFePHP\NFe\Tags;

/**
 * Esta classe representa a TAG <ide>
 * da NFe
 */

use NFePHP\NFe\Tags\Tag;

class Ide extends Tag
{
    public $cUF = '';
    public $cNF = '';
    public $natOp = '';
    public $indPag = '';
    public $mod = '';
    public $serie = '';
    public $nNF = '';
    public $dhEmi = '';
    public $dhSaiEnt = '';
    public $tpNF = '';
    public $idDest = '';
    public $cMunFG = '';
    public $tpImp = '';
    public $tpEmis = '';
    public $cDV = '';
    public $tpAmb = '';
    public $finNFe = '';
    public $indFinal = '';
    public $indPres = '';
    public $procEmi = '';
    public $verProc = '';
    public $dhCont = '';
    public $Just = '';
    
    protected function validate()
    {
        $this->loadProperties($this);
    }

    protected function create()
    {
        return $this;
    }
}
