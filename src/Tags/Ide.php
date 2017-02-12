<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use NFePHP\Common\TimeZoneByUF;
use stdClass;
use DateTime;
use DateTimeZone;

class Ide extends Base implements TagInterface
{
    const TAG_NAME = 'ide';
    
    /**
     * @var integer
     */
    public $cUF;
    /**
     * @var string
     */
    public $cNF;
    /**
     * @var string
     */
    public $natOp;
    /**
     * @var integer
     */
    public $mod;
    /**
     * @var integer
     */
    public $serie;
    /**
     * @var integer
     */
    public $nNF;
    /**
     * @var string
     */
    public $dhEmi;
    /**
     * @var string
     */
    public $dhSaiEnt;
    /**
     * @var integer
     */
    public $tpNF;
    /**
     * @var integer
     */
    public $idDest;
    /**
     * @var integer
     */
    public $cMunFG;
    /**
     * @var integer
     */
    public $tpImp;
    /**
     * @var integer
     */
    public $cDV;
    /**
     * @var integer
     */
    public $tpAmb;
    /**
     * @var integer
     */
    public $finNFe;
    /**
     * @var integer
     */
    public $indFinal;
    /**
     * @var integer
     */
    public $indPres;
    /**
     * @var integer
     */
    public $procEmi;
    /**
     * @var string
     */
    public $verProc;
    /**
     * @var integer
     */
    public $tpEmis;
    /**
     * @var string
     */
    public $dhCont;
    /**
     * @var string
     */
    public $xJust;
    /**
     * @var DateTimeZone
     */
    public $tzd;
    
    public $parameters = [
        'cUF'       =>  'string',
        'cNF'       =>  'integer',
        'natOp'     =>  'string',
        'mod'       =>  'integer',
        'serie'     =>  'integer',
        'nNF'       =>  'integer',
        'dhEmi'     =>  'object:\DateTime',//obrigatorio e do tipo \DateTime
        'dhSaiEnt'  =>  'object',
        'tpNF'      =>  'integer',
        'idDest'    =>  'integer',
        'cMunFG'    =>  'integer',
        'tpImp'     =>  'integer',
        'cDV'       =>  'integer',
        'tpAmb'     =>  'integer',
        'finNFe'    =>  'integer',
        'indFinal'  =>  'integer',
        'indPres'   =>  'integer',
        'procEmi'   =>  'integer',
        'verProc'   =>  'string',
        'contingency'=>'object:NFePHP\NFe\Factories\Contingency'//obrigatorio
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        $this->tzd = new DateTimeZone(TimeZoneByUF::get($this->std->cuf));
        if (empty($this->std->dhemi)) {
            $this->std->dhemi = new DateTime();
        }
        $this->dhEmi = $this->std->dhemi->setTimeZone($this->tzd);
        $this->cUF = $this->std->cuf;
        if (empty($this->std->cnf)) {
            $this->std->cnf = $this->std->nnf;
        }
        $this->cNF = str_pad($this->std->cnf, 8, '0', STR_PAD_LEFT);
        $this->natOp = $this->std->natop;
        $this->mod = $this->std->mod;
        $this->serie = $this->std->serie;
        $this->nNF = $this->std->nnf;
        $this->dhEmi = $this->std->dhemi->format('Y-m-d\TH:i:sP');
        $this->dhSaiEnt = '';
        if (!empty($this->std->dhsaient)) {
            $this->std->dhsaient->setTimeZone($this->tzd);
            $this->dhSaiEnt = $this->std->dhsaient->format('Y-m-d\TH:i:sP');
        }
        $this->tpNF = $this->std->tpnf;
        $this->idDest = $this->std->iddest;
        $this->cMunFG = $this->std->cmunfg;
        $this->tpImp = $this->std->tpimp;
        $this->cDV = $this->std->cdv;
        $this->tpAmb = $this->std->tpamb;
        $this->finNFe = $this->std->finnfe;
        $this->indFinal = $this->std->indfinal;
        $this->indPres = $this->std->indpres;
        $this->procEmi = $this->std->procemi;
        $this->verProc = $this->std->verproc;
        $this->tpEmis = $this->std->contingency->tpEmis;
        $this->dhCont = '';
        if ($this->std->contingency->timestamp > 0) {
            $dt = new \DateTime();
            $dt->setTimezone($this->tzd);
            $dt->setTimestamp($this->std->contingency->timestamp);
            $this->dhCont = $dt->format('Y-m-d\TH:i:sP');
        }
        $this->xJust = $this->std->contingency->motive;
    }
    
    private function adjustProperties()
    {
        
    }
    
    /**
     * Build DOMElement form class properties
     * @return DOMElement
     */
    public function toNode()
    {
        $ideTag = $this->dom->createElement("ide");
        $this->dom->addChild(
            $ideTag,
            "cUF",
            $this->cUF,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "cNF",
            $this->cNF,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "natOp",
            $this->natOp,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "mod",
            $this->mod,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "serie",
            $this->serie,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "nNF",
            $this->nNF,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "dhEmi",
            $this->dhEmi,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "dhSaiEnt",
            $this->dhSaiEnt,
            false
        );
        $this->dom->addChild(
            $ideTag,
            "tpNF",
            $this->tpNF,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "idDest",
            $this->idDest,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "cMunFG",
            $this->cMunFG,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "tpImp",
            $this->tpImp,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "tpEmis",
            $this->tpEmis,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "cDV",
            $this->cDV,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "tpAmb",
            $this->tpAmb,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "finNFe",
            $this->finNFe,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "indFinal",
            $this->indFinal,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "indPres",
            $this->indPres,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "procEmi",
            $this->procEmi,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "verProc",
            $this->verProc,
            true
        );
        $this->dom->addChild(
            $ideTag,
            "dhCont",
            $this->dhCont,
            false
        );
        $this->dom->addChild(
            $ideTag,
            "xJust",
            $this->xJust,
            false
        );
        $this->node = $ideTag;
        return $this->node;
    }
}
