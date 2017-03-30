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
     * EXCLUIDO na versão 4.0 do layout
     * @var integer
     */
    public $indPag;
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
        'cUF' => [
            'type' => 'integer',
            'format'=> '2',
            'required' => true,
            'force' => false
        ],
        'cNF' => [
            'type' => 'integer',
            'format'=> '8',
            'required' => true,
            'force' => false
        ],
        'natOp' => [
            'type' => 'string',
            'format'=> '60',
            'required' => true,
            'force' => false
        ],
        'mod' => [
            'type' => 'integer',
            'format'=> '2',
            'required' => true,
            'force' => false
        ],
        'serie' => [
            'type' => 'integer',
            'format'=> '3',
            'required' => true,
            'force' => false

        ],
        'nNF' => [
            'type' => 'integer',
            'format'=> '9',
            'required' => true,
            'force' => false
        ],
        'dhEmi' => [
            'type' => 'objetct:DateTime',
            'format'=> 'Y-m-d\TH:i:sP',
            'required' => true,
            'force' => false
        ],//obrigatorio e do tipo \DateTime
        'dhSaiEnt' =>  [
            'type' => 'objetct:DateTime',
            'format'=> 'Y-m-d\TH:i:sP',
            'required' => false,
            'force' => false
        ],
        'tpNF' => [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'idDest' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'cMunFG' =>  [
            'type' => 'integer',
            'format'=> '7',
            'required' => true,
            'force' => false
        ],
        'tpImp' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'cDV' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'tpAmb' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'finNFe' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'indFinal' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'indPag' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => false,
            'force' => false
        ],
        'indPres' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'procEmi' =>  [
            'type' => 'integer',
            'format'=> '1',
            'required' => true,
            'force' => false
        ],
        'verProc'   =>  [
            'type' => 'string',
            'format'=> '20',
            'required' => true,
            'force' => false
        ],
        'contingency' =>  [
            'type' => 'object:NFePHP\NFe\Factories\Contingency',
            'format'=> '',
            'required' => false,
            'force' => false
        ]
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
            self::formatToTag($this->parameters['cUF'], $this->cUF),
            $this->parameters['cUF']['required']
        );
        $this->dom->addChild(
            $ideTag,
            "cNF",
            self::formatToTag($this->parameters['cNF'], $this->cNF),
            $this->parameters['cNF']['required']
        );
        $this->dom->addChild(
            $ideTag,
            "natOp",
            self::formatToTag($this->parameters['natOp'], $this->natOp),
            $this->parameters['natOp']['required']
        );
        //excluido na versão 4.0 do layout
        $this->dom->addChild(
            $ideTag,
            "indPag",
            self::formatToTag($this->parameters['indPag'], $this->indPag),
            $this->parameters['indPag']['required']
        );
        $this->dom->addChild(
            $ideTag,
            "mod",
            self::formatToTag($this->parameters['mod'], $this->mod),
            $this->parameters['mod']['required']
        );
        $this->dom->addChild(
            $ideTag,
            "serie",
            $this->serie,
            self::formatToTag($this->parameters['serie'], $this->serie),
            $this->parameters['serie']['required']
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
