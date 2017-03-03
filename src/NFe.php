<?php

namespace NFePHP\NFe;

use NFePHP\NFe\Tags\TagInterface;
use NFePHP\NFe\Tags;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Keys;
use DOMElement;
use stdClass;

class NFe
{
    /**
     * @var Dom
     */
    protected $dom;

    /**
     * @var string
     */
    public $versao = '4.0';
    /**
     * @var string
     */
    public $id = '';
    /**
     * @var Tags\Ide
     */
    public $ide;
    /**
     * @var Tags\NFref
     */
    public $NFref;
    /**
     * @var Tags\Emit
     */
    public $emit;
    /**
     * @var Tags\Dest
     */
    public $dest;
    /**
     * @var Tags\Retirada
     */
    public $retirada;
    /**
     * @var Tags\Entrega
     */
    public $entrega;
    /**
     * @var Tags\AutXML
     */
    public $autXML;
    /**
     * @var Tags\Transp
     */
    public $transp;
    /**
     * @var Tags\Cobr
     */
    public $cobr;
    /**
     * @var array Tags\Pag
     */
    public $pag;
    /**
     * @var Tags\InfAdic
     */
    public $infAdic;
    /**
     * @var Tags\Exporta
     */
    public $exporta;
    /**
     * @var Tags\Compra
     */
    public $compra;
    /**
     * @var Tags\Cana
     */
    public $cana;

    public function __construct($versao = '4.0')
    {
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;
        $this->versao = $versao;
    }
    
    public function add(TagInterface $tag)
    {
        $className = $tag::TAG_NAME;
        if (is_array($this->$className)) {
            $this->$className[] = $tag;
        } else {
            $this->$className = $tag;
        }
    }
    
    public function build()
    {
        if (empty($this->ide) || empty($this->emit)) {
            return;
        }
        $nfe = $this->buildNFe();
        $this->id = $this->buildKey();
        $this->ide->cDV = substr($this->id, -1);
        $this->ide->std->cdv = $this->ide->cDV;
        $infNFe = $this->dom->createElement("infNFe");
        $infNFe->setAttribute("Id", 'NFe' . $this->id);
        $infNFe->setAttribute("versao", $this->versao);
        //tag <ide> (5 B01)
        $this->dom->appExternalChild($infNFe, $this->ide->toNode());
        //tag <NFref> (29x.1 BA01)
        $infNFe = $this->buildNFref($infNFe);
        //tag emit (30 C01)
        $infNFe = $this->buildEmit($infNFe);
        //tag <dest> (62 E01)
        $infNFe = $this->buildDest($infNFe);
        //tag <retirada> (80 F01)
        $this->append($infNFe, $this->retirada);
        //tag <entrega> (89 G01)
        $this->append($infNFe, $this->entrega);
        //tag <autXML> (97a.1 GA01)
        $infNFe = $this->buildAut($infNFe);
        //tag <det> (98 H01)
        
        
        
        //tag <transp> (356 X01)
        
        //tag <cobr> (389 Y01)
        $infNFe = $this->buildCobr($infNFe);
        //tag <pag> (398a YA01)
        $infNFe = $this->buildPag($infNFe);
        //tag <infAdic> (399 Z01)
        $infNFe = $this->buildInfAdic($infNFe);
        //tag <exporta> (402 ZA01)
        $this->append($infNFe, $this->exporta);
        //tag <compra> (405 ZB01)
        $this->append($infNFe, $this->compra);
        //tag <cana> (409 ZC01)
        $infNFe = $this->buildCana($infNFe);
        //tag <infNFe>
        $this->dom->appChild($nfe, $infNFe, 'Falta tag "NFe"');
        //tag <NFe>
        $this->dom->appendChild($nfe);
    }
    
    private function buildDet(DOMElement $infNFe)
    {
        return $infNFe;
    }
    
    private function append(DOMElement &$node, TagInterface $cl = null)
    {
        if ($cl == null) {
            return;
        }
        $this->dom->appExternalChild($node, $cl->toNode());
    }
    
    private function buildTransp(DOMElement $infNFe)
    {
    }
    
    private function buildCobr(DOMElement $infNFe)
    {
        if (!empty($this->fat) || !empty($this->dup)) {
            $cobr = $this->dom->createElement("cobr");
            $this->append($cobr, $this->fat);
            foreach ($this->dup as $dup) {
                $this->append($cobr, $dup);
            }
            $this->dom->appChild($infNFe, $cobr);
        }
        return $infNFe;
    }


    private function buildCana(DOMElement $infNFe)
    {
        //tag <forDia> (412 ZC04)
        $this->cana->forDia = $this->forDia;
        //tag <deduc> (418 ZC10)
        $this->cana->deduc = $this->deduc;
        $this->append($infNFe, $this->cana);
        return $infNFe;
    }
    
    private function buildPag(DOMElement $infNFe)
    {
        foreach ($this->pag as $p) {
            $this->append($infNFe, $p);
        }
        return $infNFe;
    }


    private function buildAut(DOMElement $infNFe)
    {
        //tag <autXML> (97a.1 GA01)
        foreach ($this->autXML as $aut) {
            $this->append($infNFe, $aut);
        }
        return $infNFe;
    }
    
    private function buildEmit(DOMElement $infNFe)
    {
        //tag <enderEmit> (34 C05)
        if (!empty($this->enderEmit)) {
            $this->emit->enderEmit = $this->enderEmit;
        }
        //tag emit (30 C01)
        $this->append($infNFe, $this->emit);
        return $infNFe;
    }
    
    private function buildDest(DOMElement $infNFe)
    {
        //tag <enderDest> (66 E05)
        if (!empty($this->enderDest) && !empty($this->dest)) {
            $this->dest->enderDest = $this->enderDest;
        }
        //tag <dest> (62 E01)
        $this->append($infNFe, $this->dest);
        return $infNFe;
    }
    
    private function buildInfAdic(DOMElement $infNFe)
    {
        if (empty($this->infAdic) &&
           (!empty($this->obsCont) ||
            !empty($this->obsFisco) ||
            !empty($this->procRef))
        ) {
            $inf = new stdClass();
            $inf->infAdFisco = '';
            $inf->infCpl = '';
            $this->infAdic = Tag::infAdic($inf);
        }
        if (!empty($this->infAdic)) {
            //tag <obsCont> (401a Z04)
            $this->infAdic->obsCont = $this->obsCont;
            //tag <obsFisco> (401d Z07)
            $this->infAdic->obsFisco = $this->obsFisco;
            //tag <procRef> (401g Z10)
            $this->infAdic->procRef = $this->procRef;
            $this->append($infNFe, $this->infAdic);
        }
        return $infNFe;
    }
    
    public function __toString()
    {
        return $this->dom->saveXML();
    }
    
    /**
     * Tag raiz da NFe
     * tag NFe DOMNode
     * Função chamada pelo método [ monta ]
     * @return DOMElement
     */
    private function buildNFe()
    {
        $nfe = $this->dom->createElement("NFe");
        $nfe->setAttribute("xmlns", "http://www.portalfiscal.inf.br/nfe");
        return $nfe;
    }
    
    private function buildNFref(DOMElement $infNFe)
    {
        //tag <refNFe> (29x.2 BA02)
        if (!empty($this->refNFe)) {
            $refs = $this->refNFe->toNode()->getElementsByTagName("NFref");
            $len = $refs->length;
            foreach ($refs as $node) {
                $this->dom->appExternalChild($infNFe, $node);
            }
        }
        //tag <refNF> (29x.3 BA03)
        foreach ($this->refNF as $ref) {
            $this->dom->appExternalChild($infNFe, $ref->toNode());
        }
        //tag <refNFP> (29x.10 BA10)
        foreach ($this->refNFP as $ref) {
            $this->dom->appExternalChild($infNFe, $ref->toNode());
        }
        //tag <refCTe> (29x.19 BA19)
        if (!empty($this->refCTe)) {
            $refs = $this->refCTe->toNode()->getElementsByTagName("NFref");
            $len = $refs->length;
            foreach ($refs as $node) {
                $this->dom->appExternalChild($infNFe, $node);
            }
        }
        //tag <refECF> (29x.20 BA20)
        foreach ($this->refECF as $ref) {
            $this->dom->appExternalChild($infNFe, $ref->toNode());
        }
        return $infNFe;
    }
    
    private function buildKey()
    {
        return Keys::build(
            $this->ide->cUF,
            $this->ide->std->dhemi->format('y'),
            $this->ide->std->dhemi->format('m'),
            $this->emit->CNPJ,
            $this->ide->mod,
            $this->ide->serie,
            $this->ide->nNF,
            $this->ide->tpEmis,
            $this->ide->cNF
        );
    }
}
