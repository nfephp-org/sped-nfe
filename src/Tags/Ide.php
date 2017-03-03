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
     * @var integer
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
     * @var DateTime
     */
    public $dhEmi;
    /**
     * @var DateTime
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
     * @var Contingency
     */
    public $contingency;
    /**
     * @var DateTimeZone
     */
    protected $tzd;
    /**
     * @var string
     */
    protected $dhSaiEntString;
    /**
     * @var array
     */
    protected $parameters = [
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
    }
    
    /**
     * Adjust all propreties to build
     */
    private function adjustProperties()
    {
        $this->tzd = new DateTimeZone(TimeZoneByUF::get($this->cUF));
        if (empty($this->dhEmi)) {
            $this->dhEmi = new DateTime();
        }
        $this->dhEmi = $this->dhEmi->setTimeZone($this->tzd);
        if (!empty($this->dhSaiEnt)) {
            $this->dhSaiEnt->setTimeZone($this->tzd);
            $this->dhSaiEntString = $this->dhSaiEnt->format('Y-m-d\TH:i:sP');
        }
        if (empty($this->cNF)) {
            $this->cNF = $this->nNF;
        }
        if (!empty($this->contingency)) {
            $this->tpEmis = $this->contingency->tpEmis;
            if ($this->tpEmis != 1) {
                $dt = new \DateTime();
                $dt->setTimezone($this->tzd);
                $dt->setTimestamp($this->contingency->timestamp);
                $this->dhCont = $dt->format('Y-m-d\TH:i:sP');
                $this->xJust = $this->contingency->motive;
            }
        }
        if (empty($this->tpEmis)) {
            $this->tpEmis = 1;
        }
    }
    
    /**
     * Build DOMElement form class properties
     * @return DOMElement
     */
    public function toNode()
    {
        $this->adjustProperties();
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
            str_pad($this->cNF, 8, '0', STR_PAD_LEFT),
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
            $this->dhEmi->format('Y-m-d\TH:i:sP'),
            true
        );
        $this->dom->addChild(
            $ideTag,
            "dhSaiEnt",
            $this->dhSaiEntString,
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
