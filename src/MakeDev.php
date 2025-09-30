<?php

namespace NFePHP\NFe;

use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;
use NFePHP\NFe\Traits\TraitTagAgropecuario;
use NFePHP\NFe\Traits\TraitTagCana;
use NFePHP\NFe\Traits\TraitTagComb;
use NFePHP\NFe\Traits\TraitTagCompra;
use NFePHP\NFe\Traits\TraitTagDet;
use NFePHP\NFe\Traits\TraitTagDetCOFINS;
use NFePHP\NFe\Traits\TraitTagDetCEST;
use NFePHP\NFe\Traits\TraitTagDetII;
use NFePHP\NFe\Traits\TraitTagDetImposto;
use NFePHP\NFe\Traits\TraitTagDetICMS;
use NFePHP\NFe\Traits\TraitTagDetIPI;
use NFePHP\NFe\Traits\TraitTagDetISSQN;
use NFePHP\NFe\Traits\TraitTagDetOptions;
use NFePHP\NFe\Traits\TraitTagDetPIS;
use NFePHP\NFe\Traits\TraitTagExporta;
use NFePHP\NFe\Traits\TraitTagGCompraGov;
use NFePHP\NFe\Traits\TraitTagDetIBSCBS;
use NFePHP\NFe\Traits\TraitTagGPagAntecipado;
use NFePHP\NFe\Traits\TraitTagInfAdic;
use NFePHP\NFe\Traits\TraitTagAutXml;
use NFePHP\NFe\Traits\TraitTagCobr;
use NFePHP\NFe\Traits\TraitTagEntrega;
use NFePHP\NFe\Traits\TraitTagIde;
use NFePHP\NFe\Traits\TraitTagInfIntermed;
use NFePHP\NFe\Traits\TraitTagInfNfe;
use NFePHP\NFe\Traits\TraitTagEmit;
use NFePHP\NFe\Traits\TraitTagInfRespTec;
use NFePHP\NFe\Traits\TraitTagDetIS;
use NFePHP\NFe\Traits\TraitTagPag;
use NFePHP\NFe\Traits\TraitTagRefs;
use NFePHP\NFe\Traits\TraitTagDest;
use NFePHP\NFe\Traits\TraitTagRetirada;
use NFePHP\NFe\Traits\TraitTagTotal;
use NFePHP\NFe\Traits\TraitTagTransp;
use stdClass;
use DOMElement;
use DateTime;

final class MakeDev
{
    use TraitTagInfNfe;
    use TraitTagIde;
    use TraitTagGCompraGov;
    use TraitTagGPagAntecipado;
    use TraitTagEmit;
    use TraitTagRefs;
    use TraitTagDest;
    use TraitTagRetirada;
    use TraitTagEntrega;
    use TraitTagAutXml;
    use TraitTagDet;
    use TraitTagDetOptions;
    use TraitTagDetImposto;
    use TraitTagDetICMS;
    use TraitTagDetISSQN;
    use TraitTagDetIPI;
    use TraitTagDetII;
    use TraitTagDetPIS;
    use TraitTagDetCOFINS;
    use TraitTagDetCEST;
    use TraitTagDetIS;
    use TraitTagDetIBSCBS;
    use TraitTagComb;
    use TraitTagDetImposto;
    use TraitTagInfAdic;
    use TraitTagInfRespTec;
    use TraitTagCobr;
    use TraitTagPag;
    use TraitTagInfIntermed;
    use TraitTagTransp;
    use TraitTagExporta;
    use TraitTagCompra;
    use TraitTagCana;
    use TraitTagAgropecuario;
    use TraitTagTotal;

    /**
     * @var int
     */
    protected $schema; //esta propriedade da classe estabelece qual é a versão do schema sendo considerado
    /**
     * @var int
     */
    protected $tpAmb = 2;
    /**
     * @var int
     */
    protected $crt;
    /**
     * @var array
     */
    public $errors = [];
    /**
     * @var string
     */
    public $chNFe;
    /**
     * @var string
     */
    public string $xml;
    /**
     * @var string
     */
    protected string $version;
    /**
     * @var string
     */
    protected string $mod = '55';
    /**
     * @var string
     */
    protected string $csrt;
    /**
     * @var string
     */
    protected $cst_ibscbs;
    /**
     * @var int
     */
    protected $indDeduzDeson = 0;
    /**
     * @var bool
     */
    protected bool $checkgtin = false;
    /**
     * @var bool
     */
    protected bool $replaceAccentedChars = false;
    /**
     * @var object|Dom
     */
    public $dom;
    /**
     * @var float|null
     */
    protected $vNFTot;
    /**
     * @var stdClass
     */
    public $stdTot;
    /**
     * @var stdClass
     */
    protected $stdISSQNTot;
    /**
     * @var stdClass
     */
    protected $stdIStot;
    /**
     * @var stdClass
     */
    protected $stdIBSCBSTot;
    /**
     * @var DOMElement
     */
    protected DOMElement $NFe;
    /**
     * @var DOMElement
     */
    protected $infNFe;
    /**
     * @var DOMElement
     */
    protected $ide;
    /**
     * @var DOMElement
     */
    protected $gCompraGov;
    /**
     * @var DOMElement
     */
    protected $gPagAntecipado;
    /**
     * @var DOMElement
     */
    protected $emit;
    /**
     * @var DOMElement
     */
    protected $enderEmit;
    /**
     * @var DOMElement
     */
    protected $dest;
    /**
     * @var DOMElement
     */
    protected $enderDest;
    /**
     * @var DOMElement
     */
    protected $retirada;
    /**
     * @var DomElement
     */
    protected $entrega;
    /**
     * @var DOMElement
     */
    protected $infAdic;
    /**
     * @var DOMElement
     */
    protected $infRespTec;
    /**
     * @var DOMElement
     */
    protected $cobr;
    /**
     * @var DOMElement
     */
    protected $pag;
    /**
     * @var DOMElement
     */
    protected $transp;
    /**
     * @var DOMElement
     */
    protected $transporta;
    /**
     * @var DOMElement
     */
    protected $retTransp;
    /**
     * @var DOMElement
     */
    protected $veicTransp;
    /**
     * @var DOMElement
     */
    protected $compra;
    /**
     * @var DOMElement
     */
    protected $exporta;
    /**
     * @var DOMElement
     */
    protected $balsa;
    /**
     * @var DOMElement
     */
    protected $vagao;
    /**
     * @var DOMElement
     */
    protected $ICMSTot;
    /**
     * @var DOMElement
     */
    protected $ISSQNTot;
    /**
     * @var DOMElement
     */
    protected $ISTot;
    /**
     * @var DOMElement
     */
    protected $IBSCBSTot;
    /**
     * @var DOMElement
     */
    protected $retTrib;
    /**
     * @var DOMElement
     */
    protected $infIntermed;
    /**
     * @var DOMElement
     */
    protected $agropecuarioGuia; //Não Existe na PL_010
    /**
     * @var DOMElement
     */
    protected $cana;
    /**
     * @var DOMElement
     */
    protected $infNFeSupl;
    /**
     * @var array
     */
    protected $aReboque = [];
    /**
     * @var array
     */
    protected $aVol = [];
    /**
     * @var array
     */
    protected $aLacre = [];
    /**
     * @var array
     */
    protected $aNFref = [];
    /**
     * @var array
     */
    protected $aAutXML = [];
    /**
     * @var array
     */
    protected $aProd = [];
    /**
     * @var array
     */
    protected $aGCred = [];
    /**
     * @var array
     */
    protected $aCest = [];
    /**
     * @var array
     */
    protected $aNVE = [];
    /**
     * @var array
     */
    protected $aRECOPI = [];
    /**
     * @var array
     */
    protected $aRastro = [];
    /**
     * @var array
     */
    protected $aDFeReferenciado = [];
    /**
     * @var array
     */
    protected $aVeicProd = [];
    /**
     * @var array
     */
    protected $aMed = [];
    /**
     * @var array
     */
    protected $aArma = [];
    /**
     * @var array
     */
    protected $aDI = [];
    /**
     * @var array
     */
    protected $aAdi = [];
    /**
     * @var array
     */
    protected $aDetExport = [];
    /**
     * @var array
     */
    protected $aImposto = [];
    /**
     * var array
     */
    protected $aImpostoDevol = [];
    /**
     * @var array
     */
    protected $aISSQN = [];
    /**
     * @var array
     */
    protected $aICMS = [];
    /**
     * @var array
     */
    protected $aICMSPart = [];
    /**
     * @var array
     */
    protected $aICMSUFDest = [];
    /**
     * @var array
     */
    protected $aICMSSN = [];
    /**
     * @var array
     */
    protected $aICMSST = [];
    /**
     * @var array
     */
    protected $aIPI = [];
    /**
     * @var array
     */
    protected $aPIS = [];
    /**
     * @var array
     */
    protected $aPISST = [];
    /**
     * @var array
     */
    protected $aCOFINS = [];
    /**
     * @var array
     */
    protected $aCOFINSST = [];
    /**
     * @var array
     */
    protected $aInfAdProd = [];
    /**
     * @var array
     */
    protected $aIBSCBS = [];
    /**
     * @var array
     */
    protected $aIBSCBSCredPres = [];
    /**
     * @var array
     */
    protected $aIS = [];
    /**
     * @var array
     */
    protected $aII = [];
    /**
     * @var array
     */
    protected $aGTribRegular = [];
    /**
     * @var array
     */
    protected $aIBSCredPres = [];
    /**
     * @var array
     */
    protected $aCBSCredPres = [];
    /**
     * @var array
     */
    protected $aGTribCompraGov = [];
    /**
     * @var array
     */
    protected $aGIBSCBSMono = [];
    /**
     * @var array
     */
    protected $aGTransfCred = [];
    /**
     * @var array
     */
    protected $aGCredPresIBSZFM = [];
    /**
     * @var array
     */
    protected $aObsItem = [];
    /**
     * @var array
     */
    protected $aVItem = [];
    /**
     * @var array
     */
    protected $aDetPag = [];
    /**
     * @var array
     */
    protected $aObsCont = [];
    /**
     * @var array
     */
    protected $aObsFisco = [];
    /**
     * @var array
     */
    protected $aProcRef = [];
    /**
     * @var array
     */
    protected $aForDia = [];
    /**
     * @var array
     */
    protected $aDeduc = [];
    /**
     * @var array
     */
    protected $aComb = [];
    /**
     * @var array
     */
    protected $aEncerrante = [];
    /**
     * @var array
     */
    protected $aOrigComb = [];
    /**
     * @var array
     */
    protected $aAgropecuarioDefensivo = [];

    /**
     * Função construtora cria um objeto DOMDocument
     * que será carregado com o documento fiscal
     */
    public function __construct($schema = null)
    {
        $this->schema = 9; //PL_009_V4
        if (!empty($schema)) {
            $this->schema = (int)preg_replace("/[^0-9]/", "", substr($schema, 0, 6));
        }
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;

        //elemento totalizador
        $this->stdTot = new stdClass();
        $this->stdTot->vBC = 0;
        $this->stdTot->vICMS = 0;
        $this->stdTot->vICMSDeson = 0;
        $this->stdTot->vFCPUFDest = 0;
        $this->stdTot->vICMSUFDest = 0;
        $this->stdTot->vICMSUFRemet = 0;
        $this->stdTot->vFCP = 0;
        $this->stdTot->vBCST = 0;
        $this->stdTot->vST = 0;
        $this->stdTot->vFCPST = 0;
        $this->stdTot->vFCPSTRet = 0;
        $this->stdTot->qBCMono = 0;
        $this->stdTot->vICMSMono = 0;
        $this->stdTot->qBCMonoReten = 0;
        $this->stdTot->vICMSMonoReten = 0;
        $this->stdTot->qBCMonoRet = 0;
        $this->stdTot->vICMSMonoRet = 0;
        $this->stdTot->vProd = 0;
        $this->stdTot->vFrete = 0;
        $this->stdTot->vSeg = 0;
        $this->stdTot->vDesc = 0;
        $this->stdTot->vII = 0;
        $this->stdTot->vIPI = 0;
        $this->stdTot->vIPIDevol = 0;
        $this->stdTot->vPIS = 0;
        $this->stdTot->vCOFINS = 0;
        $this->stdTot->vPISST = 0; //??
        $this->stdTot->vCOFINSST = 0; //??
        $this->stdTot->vOutro = 0;
        $this->stdTot->vNF = 0;
        $this->stdTot->vTotTrib = 0;
        //PL_010
        $this->stdTot->vIBS = 0;
        $this->stdTot->vCBS = 0;
        $this->stdTot->vIS = 0;
        $this->stdTot->vNFTot = 0;

        $this->stdISSQNTot = new stdClass();
        $this->stdISSQNTot->vServ = 0;
        $this->stdISSQNTot->vBC = 0;
        $this->stdISSQNTot->vISS = 0;
        $this->stdISSQNTot->vPIS = 0;
        $this->stdISSQNTot->vCOFINS = 0;
        $this->stdISSQNTot->dCompet = null;
        $this->stdISSQNTot->vDeducao = 0;
        $this->stdISSQNTot->vOutro = 0;
        $this->stdISSQNTot->vDescIncond = 0;
        $this->stdISSQNTot->vDescCond = 0;
        $this->stdISSQNTot->vISSRet = 0;
        $this->stdISSQNTot->cRegTrib = 0;

        $this->stdIStot = new stdClass();
        $this->stdIStot->vIS = 0;

        $this->stdIBSCBSTot = new stdClass();
        $this->stdIBSCBSTot->vBCIBSCBS = 0;
        $this->stdIBSCBSTot->vIBS = 0;
        $this->stdIBSCBSTot->vCBS = 0;
        $this->stdIBSCBSTot->vCredPres = 0;
        $this->stdIBSCBSTot->vCredPresCondSus = 0;

        $this->stdIBSCBSTot->gIBSUF = new stdClass();
        $this->stdIBSCBSTot->gIBSUF->vDif = 0;
        $this->stdIBSCBSTot->gIBSUF->vDevTrib = 0;
        $this->stdIBSCBSTot->gIBSUF->vIBSUF = 0;

        $this->stdIBSCBSTot->gIBSMun = new stdClass();
        $this->stdIBSCBSTot->gIBSMun->vDif = 0;
        $this->stdIBSCBSTot->gIBSMun->vDevTrib = 0;
        $this->stdIBSCBSTot->gIBSMun->vIBSMun = 0;

        $this->stdIBSCBSTot->gCBS = new stdClass();
        $this->stdIBSCBSTot->gCBS->vDif = 0;
        $this->stdIBSCBSTot->gCBS->vDevTrib = 0;

        $this->stdIBSCBSTot->gMono = new stdClass();
        $this->stdIBSCBSTot->gMono->vIBSMono = 0;
        $this->stdIBSCBSTot->gMono->vCBSMono = 0;
        $this->stdIBSCBSTot->gMono->vIBSMonoReten = 0;
        $this->stdIBSCBSTot->gMono->vCBSMonoReten = 0;
        $this->stdIBSCBSTot->gMono->vIBSMonoRet = 0;
        $this->stdIBSCBSTot->gMono->vCBSMonoRet = 0;
    }

    /**
     * Getter para propriedades protegidas
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        return $this->$name;
    }

    /**
     * Returns xml string and assembly it is necessary
     */
    public function getXML(): string
    {
        if (empty($this->xml)) {
            $this->render();
        }
        return $this->xml;
    }

    /**
     * Retorns the key number of NFe (44 digits)
     */
    public function getChave(): string
    {
        return $this->chNFe ?? '';
    }

    /**
     * Returns the model of NFe 55 or 65
     */
    public function getModelo(): int
    {
        return (int)$this->mod;
    }

    /**
     * Retorna os erros detectados
     */
    public function getErrors(): array
    {
        return array_merge($this->errors, $this->dom->errors);
    }

    /**
     * Set character convertion to ASCII only ou not
     */
    public function setOnlyAscii(bool $option = false): void
    {
        $this->replaceAccentedChars = $option;
    }

    /**
     * Set if GTIN is or not validate
     * @param bool $option
     * @return void
     */
    public function setCheckGtin(bool $option = true): void
    {
        $this->checkgtin = $option;
    }


    /**
     * Call method of xml assembly. For compatibility only.
     * @return string
     */
    public function montaNFe(): string
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function render(): string
    {
        try {
            //calcula total vNF
            $this->buildTotal();
            //cria a tag NFe
            $this->buildNFe();
            //tag NFref => tag ide
            $this->addTagRefToIde();
            //tag gCompraGov => tag ide Existe apenas a partir da PL_010
            if ($this->schema > 9) {
                $this->addTag($this->ide, $this->gCompraGov, 'Falta a tag "ide"');
                $this->addTag($this->ide, $this->gPagAntecipado, 'Falta a tag "ide"');
            }
            //tag ide => tag infNfe
            $this->addTag($this->infNFe, $this->ide, 'Falta a tag "infNFe"');
            //tag emit => tag infNfe
            $this->addTagEmit();
            //tag dest => tag infNFe
            $this->addTagDest();
            //tag retirada  => tag infNFe
            $this->addTag($this->infNFe, $this->retirada, 'Falta a tag "infNFe"');
            //tag entrega => tag infNFe
            $this->addTag($this->infNFe, $this->entrega, 'Falta a tag "infNFe"');
            //tag autXMl => tag infNFe
            $this->addTagAutXML();
            //tag det => tag infNFe
            $this->addTagDet();
            //tag total => tag infNfe
            $this->addTagTotal();

            //tag transp => tag infNfe
            $this->addTagTransp();
            //tag cobr => tag infNFe
            $this->addTag($this->infNFe, $this->cobr, 'Falta a tag "infNFe"');
            //tag pag => tag infNFe
            $this->addTagPag();
            //tag infIntermed => tag infNFe
            $this->addTag($this->infNFe, $this->infIntermed, 'Falta a tag "infNFe"');
            //tag infAdic => tag infNFe
            $this->buildInfoTags();
            $this->addTag($this->infNFe, $this->infAdic, 'Falta a tag "infNFe"');
            //tag exporta => tag infNFe
            $this->addTag($this->infNFe, $this->exporta, 'Falta a tag "infNFe"');
            //tag compra => tag infNFe
            $this->addTag($this->infNFe, $this->compra, 'Falta a tag "infNFe"');
            //tag cana => tag infNFe
            $this->addTagCana();
            //tag infRespTec => tag infNFe
            $this->addTag($this->infNFe, $this->infRespTec, 'Falta a tag "infNFe"');
            //Add tag agropecuario
            $this->addTagAgropecuario();
            //Add tag infNfe => tag NFe
            $this->addTag($this->NFe, $this->infNFe, 'Falta a tag "NFe"');
            //Add tag NFe => XML
            $this->dom->appendChild($this->NFe);
            // testa cMunFGIBS
            // testa da chave e inclui ajustes na NFe (id e cDV)
            $this->checkNFeKey($this->dom);
            //grava XML na propriedades da classe
            $this->xml = $this->dom->saveXML();
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        //retorna o XML (sem assinatura)
        return $this->xml ?? '';
    }

    /**
     * Monta e adiciona as tags det a tag infNFe
     * @return void
     * @throws \DOMException
     */
    protected function addTagDet()
    {
        if (empty($this->aProd)) {
            $this->errors[] = 'Falta a tag "prod"';
            return;
        }
        $this->aProd = array_slice($this->aProd, 0, 990, true);
        //para cada tag prod
        ksort($this->aProd);
        foreach ($this->aProd as $item => $prod) {
            $det = $this->dom->createElement("det");
            $det->setAttribute("nItem", $item);
            //NVE => prod até 8 registros
            if (!empty($this->aNVE[$item])) {
                $nves = $this->aNVE[$item];
                if (count($nves) > 8) {
                    $this->errors[] = "I05a <NVE> Item: $item - As tags NVE são limitadas a 8 repetições "
                        . "por item da NFe";
                    $nves = array_slice($nves, 0, 8);
                }
                $node = $prod->getElementsByTagName("NCM")->item(0);
                foreach ($nves as $nve) {
                    $this->dom->insertAfter($nve, $node);
                }
            }
            //gCred => prod até 4 registros PL_010
            if (!empty($this->aGCred[$item]) && $this->schema > 9) {
                $gcs = $this->aGCred[$item];
                if (count($gcs) > 4) {
                    $this->errors[] = "<gCred> Item: $item - As tags gCred são limitadas a 4 "
                        . "repetições por item da NFe";
                    $gbs = array_slice($gcs, 0, 4);
                }
                $node = $prod->getElementsByTagName("EXTIPI")->item(0);
                if (empty($node)) {
                    $node = $prod->getElementsByTagName("CFOP")->item(0);
                }
                foreach ($gcs as $gc) {
                    $prod->insertBefore($gc, $node);
                }
            }
            //DI => prod
            if (!empty($this->aDI[$item])) {
                $ind = $prod->getElementsByTagName("indBemMovelUsado")->item(0) ?? null;
                if (empty($ind)) {
                    $ind = $prod->getElementsByTagName("indTot")->item(0);
                }
                $dis = $this->aDI[$item];
                if (count($dis) > 100) {
                    $this->errors[] = "I18 <DI> Item: $item - As tags DI estão limitadas a 100 registros "
                        . "por item da NFe";
                    $dis = array_slice($dis, 0, 100, true);
                }
                foreach ($dis as $di) {
                    $nDI = $di->getElementsByTagName("nDI")->item(0)->nodeValue ?? 0;
                    //adi => DI
                    $adis = $this->aAdi[$item][$nDI];
                    if (empty($adis)) {
                        $this->errors[] = "I18 <DI> N. $nDI Item: $item - Deve existir pelo menos uma adi por DI.";
                    }
                    if (count($adis) > 999) {
                        $this->errors[] = "I18 <DI> N. $nDI Item: $item - As tags adi estão limitadas "
                            . "à até 999 por DI.";
                        $adis = array_slice($adis, 0, 999, true);
                    }
                    foreach ($adis as $adi) {
                        $this->addTag($di, $adi, 'Falta parente DI!');
                    }
                    $this->dom->insertAfter($di, $ind);
                }
            }
            //detExport => prod
            if (!empty($this->aDetExport[$item])) {
                $node = $prod->getElementsByTagName("xPed")->item(0);
                if (empty($node)) {
                    $node = $prod->getElementsByTagName("nItemPed")->item(0);
                    if (empty($node)) {
                        $node = $prod->getElementsByTagName("nFCI")->item(0);
                    }
                }
                $dex = $this->aDetExport[$item];
                if (count($dex) > 500) {
                    $this->errors[] = "I50 <detExport> Item: $item - As tags detExpot estão limitadas "
                        . "à até 500 por item.";
                    $dex = array_slice($dex, 0, 500, true);
                }
                foreach ($dex as $d) {
                    $prod->insertBefore($d, $node);
                }
            }
            //rastro => prod
            if (!empty($this->aRastro[$item])) {
                $ras = $this->aRastro[$item];
                if (count($ras) > 500) {
                    $this->errors[] = "I80 <rastro> Item: $item - As tags rastro estão limitadas "
                        . "à até 500 por item.";
                    $ras = array_slice($ras, 0, 500, true);
                }
                foreach ($ras as $ra) {
                    $this->addTag($prod, $ra, 'Falta tag prod!');
                }
            }
            //CHOICE
            $flagChoice = false;
            //veicProd => prod
            if (!empty($this->aVeicProd[$item]) && $flagChoice === false) {
                $this->addTag($prod, $this->aVeicProd[$item], 'Falta tag prod!');
                $flagChoice = true;
            }
            //med => prod
            if (!empty($this->aMed[$item]) && $flagChoice === false) {
                $this->addTag($prod, $this->aMed[$item], 'Falta tag prod!');
                $flagChoice = true;
            }
            //arma => prod
            if (!empty($this->aArma[$item]) && $flagChoice === false) {
                $arms = $this->aArma[$item];
                if (count($arms) > 500) {
                    $this->errors[] = "L01 <arma> Item: $item - As tags arma estão limitadas "
                        . "à até 500 por item.";
                    $ras = array_slice($arms, 0, 500, true);
                }
                foreach ($arms as $arm) {
                    $this->addTag($prod, $arm, 'Falta tag prod!');
                }
                $flagChoice = true;
            }
            //comb => prod
            if (!empty($this->aComb[$item]) && $flagChoice === false) {
                $comb = $this->aComb[$item];
                if (!empty($this->aEncerrante)) {
                    $encerrante = $this->aEncerrante[$item];
                    if (!empty($encerrante)) {
                        $pbio = $comb->getElementsByTagName("pBio")->item(0);
                        if (!empty($pbio)) {
                            $comb->insertBefore($encerrante, $pbio);
                        } else {
                            $this->addTag($comb, $encerrante, 'Falta tag comb!');
                        }
                    }
                }
                //incluso NT 2023.001-1.10 /1.20
                if (!empty($this->aOrigComb[$item])) {
                    foreach ($this->aOrigComb[$item] as $origcomb) {
                        $this->addTag($comb, $origcomb, 'Falta a tag comb!');
                    }
                }
                $this->addTag($prod, $this->aComb[$item]);
                $flagChoice = true;
            }
            //RECOPI => prod
            if (!empty($this->aRECOPI[$item]) && $flagChoice === false) {
                $prod->appendChild($this->aRECOPI[$item]);
            }
            $this->addTag($det, $prod, 'Falta a tag det!');

            //imposto => det
            $imposto = $this->dom->createElement("imposto");
            if (!empty($this->aImposto[$item])) {
                $imposto = $this->aImposto[$item];
            }
            //ICMS => imposto
            $flagICMS = false;
            if (!empty($this->aICMS[$item])) {
                $flagICMS = true;
                $icms = $this->dom->createElement("ICMS");
                $this->addTag($icms, $this->aICMS[$item]);
                $this->addTag($imposto, $icms, 'Falta a tag det/imposto!');
            }
            if (!empty($this->aICMSSN[$item])) {
                $flagICMS = true;
                $icmssn = $this->dom->createElement("ICMS");
                $this->addTag($icmssn, $this->aICMSSN[$item]);
                $this->addTag($imposto, $icmssn, 'Falta a tag det/imposto!');
            }
            //IPI => imposto
            if (!empty($this->aIPI[$item])) {
                $this->addTag($imposto, $this->aIPI[$item], 'Falta a tag det/imposto!');
            }
            //II => imposto
            if (!empty($this->aII[$item])) {
                $this->addTag($imposto, $this->aII[$item], 'Falta a tag det/imposto!');
            }
            //ISSQN => imposto
            if (!empty($this->aISSQN[$item]) && !$flagICMS) {
                //ou temos ISSQN ou temos ICMS não podemos ter os dois no mesmo item
                $this->addTag($imposto, $this->aISSQN[$item], 'Falta a tag det/imposto!');
            }
            //PIS => imposto
            if (!empty($this->aPIS[$item])) {
                $this->addTag($imposto, $this->aPIS[$item], 'Falta a tag det/imposto!');
            }
            //PISST => imposto
            if (!empty($this->aPISST[$item]) && empty($this->aPIS[$item])) {
                //ou o PIS normal ou PISST não pode haver os dois no mesmo item
                $this->addTag($imposto, $this->aPISST[$item], 'Falta a tag det/imposto!');
            }
            //COFINS => imposto
            if (!empty($this->aCOFINS[$item])) {
                $this->addTag($imposto, $this->aCOFINS[$item], 'Falta a tag det/imposto!');
            }
            //COFINSST => imposto
            if (!empty($this->aCOFINSST[$item]) && empty($this->aCOFINS[$item])) {
                //ou o COFINS normal ou CONFINSST não pode haver os dois no mesmo item
                $this->addTag($imposto, $this->aCOFINSST[$item], 'Falta a tag det/imposto!');
            }
            //ICMSUFDest => imposto
            if (!empty($this->aICMSUFDest[$item])) {
                $this->addTag($imposto, $this->aICMSUFDest[$item], 'Falta a tag det/imposto!');
            }
            if ($this->schema > 9) {
                //IS => imposto - somente para PL_010 em diante
                if (!empty($this->aIS[$item])) {
                    $this->addTag($imposto, $this->aIS[$item], 'Falta a tag det/imposto!');
                }
                //IBSCBS => imposto - somente para PL_010 em diante
                if (!empty($this->aIBSCBS[$item])) {
                    $ibscbs = $this->aIBSCBS[$item];
                    //existe o grupo gIBSCBS no node IBSCBS ?
                    $gIBSCBS = $ibscbs->getElementsByTagName("gIBSCBS")->item(0);
                    if (!empty($this->aGTribRegular[$item]) && !empty($gIBSCBS)) {
                        //add gTribRegular
                        $gIBSCBS->appendChild($this->aGTribRegular[$item]);
                    }
                    if (!empty($this->aIBSCredPres[$item]) && !empty($gIBSCBS)) {
                        $gIBSCBS->appendChild($this->aIBSCredPres[$item]);
                    }
                    if (!empty($this->aCBSCredPres[$item]) && !empty($gIBSCBS)) {
                        $gIBSCBS->appendChild($this->aCBSCredPres[$item]);
                    }
                    if (!empty($this->aGTribCompraGov[$item]) && !empty($gIBSCBS)) {
                        $gIBSCBS->appendChild($this->aGTribCompraGov[$item]);
                    }
                    //CHICE gIBSCBS, gIBSCBSMono, gTranfCred
                    //existe o grupo gIBSCBS no node IBSCBS ?
                    ///$gIBSCBS = $ibscbs->getElementsByTagName("gIBSCBS")->item(0);
                    if (!empty($gIBSCBS)) {
                        //add gIBSCBS ao node imposto
                        $this->addTag($ibscbs, $gIBSCBS, 'Falta a tag IBSCBS!');
                    } elseif (!empty($this->aGIBSCBSMono[$item])) {
                        //não existe gIBSCBS, então add gIBSCBSMono
                        $this->addTag($ibscbs, $this->aGIBSCBSMono[$item], 'Falta a tag IBSCBS!');
                    } elseif (!empty($this->aGTransfCred[$item])) {
                        //não existe gIBSCBS, nem gIBSCBSMono então add gTransfCred
                        $this->addTag($ibscbs, $this->aGTransfCred[$item], 'Falta a tag IBSCBS!');
                    }
                    //gCredPresIBSZFM
                    if (!empty($this->aGCredPresIBSZFM[$item])) {
                        $this->addTag($ibscbs, $this->aGCredPresIBSZFM[$item], 'Falta a tag IBSCBS!');
                    }
                    $this->addTag($imposto, $ibscbs, 'Falta a tag det/imposto!');
                }
            }
            //adioiona imposto ao node det
            $this->addTag($det, $imposto);
            //impostoDevol => det
            if (!empty($this->aImpostoDevol[$item])) {
                $this->addTag($det, $this->aImpostoDevol[$item], 'Falta a tag det!');
            }
            //infAdProd => det
            if (!empty($this->aInfAdProd[$item])) {
                $this->addTag($det, $this->aInfAdProd[$item], 'Falta a tag det!');
            }
            //obsItem => det
            if (!empty($this->aObsItem[$item])) {
                $this->addTag($det, $this->aObsItem[$item], 'Falta a tag det!');
            }
            if ($this->schema > 9) {
                //vItem => det  ...  incluso tagProd() PL_010
                //if (empty($this->aVItem[$item])) {
                //não foi passado o vItem totalizando os valores a serem processados
                //    $this->aVItem[$item] = $this->calculateItemValue($det);
                //}
                if (!empty($this->aVItem[$item])) {
                    $this->addTag($det, $this->aVItem[$item]);
                }
                //DFEReferenciado => det PL_010
                if (!empty($this->aDFeReferenciado[$item])) {
                    $this->addTag($det, $this->aDFeReferenciado[$item], 'Falta a tag det!');
                }
            }
            $this->addTag($this->infNFe, $det, 'Fala a tag infNFe!');
        }
    }

    /**
     * Grupo Totais da NF-e W01 pai A01
     * tag NFe/infNFe/total
     */
    protected function buildTotal()
    {
        //round all values
        $this->stdTot->vBC = round($this->stdTot->vBC, 2);
        $this->stdTot->vICMS = round($this->stdTot->vICMS, 2);
        $this->stdTot->vICMSDeson = round($this->stdTot->vICMSDeson, 2);
        $this->stdTot->vFCP = round($this->stdTot->vFCP, 2);
        $this->stdTot->vFCPUFDest = round($this->stdTot->vFCPUFDest, 2);
        $this->stdTot->vICMSUFDest = round($this->stdTot->vICMSUFDest, 2);
        $this->stdTot->vICMSUFRemet = round($this->stdTot->vICMSUFRemet, 2);
        $this->stdTot->vBCST = round($this->stdTot->vBCST, 2);
        $this->stdTot->vST = round($this->stdTot->vST, 2);
        $this->stdTot->vFCPST = round($this->stdTot->vFCPST, 2);
        $this->stdTot->vFCPSTRet = round($this->stdTot->vFCPSTRet, 2);
        $this->stdTot->vProd = round($this->stdTot->vProd, 2);
        $this->stdTot->vFrete = round($this->stdTot->vFrete, 2);
        $this->stdTot->vSeg = round($this->stdTot->vSeg, 2);
        $this->stdTot->vDesc = round($this->stdTot->vDesc, 2);
        $this->stdTot->vII = round($this->stdTot->vII, 2);
        $this->stdTot->vIPI = round($this->stdTot->vIPI, 2);
        $this->stdTot->vIPIDevol = round($this->stdTot->vIPIDevol, 2);
        $this->stdTot->vPIS = round($this->stdTot->vPIS, 2);
        $this->stdTot->vCOFINS = round($this->stdTot->vCOFINS, 2);
        $this->stdTot->vOutro = round($this->stdTot->vOutro, 2);
        $this->stdTot->vNF = round($this->stdTot->vNF, 2);
        $this->stdTot->vTotTrib = round($this->stdTot->vTotTrib, 2);

        $this->stdTot->vNF = $this->stdTot->vProd
            - $this->stdTot->vDesc
            - $this->stdTot->vICMSDeson * $this->indDeduzDeson
            + $this->stdTot->vST
            + $this->stdTot->vFCPST
            + $this->stdTot->vICMSMonoReten
            + $this->stdTot->vFrete
            + $this->stdTot->vSeg
            + $this->stdTot->vOutro
            + $this->stdTot->vII
            + $this->stdTot->vIPI
            + $this->stdTot->vIPIDevol
            + $this->stdISSQNTot->vServ
            + $this->stdTot->vPISST
            + $this->stdTot->vCOFINSST;
    }

    /**
     * Calcula o vItem compo introduzido com o PL_010 que se refere ao total do item com o IBS/CBS/IS
     * @param DOMElement $det
     * @return DOMElement
     * @throws \DOMException
     */
    protected function calculateItemValue(DOMElement $det): DOMElement
    {
        $veicProd = $det->getElementsByTagName("veicProd")->item(0) ?? null;
        $imposto = $det->getElementsByTagName("imposto")->item(0);
        $impostoDevol = $det->getElementsByTagName("imposto")->item(0) ?? null;
        $icms = $imposto->getElementsByTagName("ICMS")->item(0) ?? null;
        $ipi = $imposto->getElementsByTagName("IPI")->item(0) ?? null;
        $ii = $imposto->getElementsByTagName("II")->item(0) ?? null;
        $pisst = $imposto->getElementsByTagName("PISST")->item(0) ?? null;
        $cofinsst = $imposto->getElementsByTagName("COFINSST")->item(0) ?? null;
        $is = $imposto->getElementsByTagName("IS")->item(0) ?? null;
        $cbs = $imposto->getElementsByTagName("IBSCBS")->item(0) ?? null;

        $tpOP = 0;
        if (!empty($veicProd)) {
            $value = $veicProd->getElementsByTagName("tpOp")->item(0)->nodeValue ?? null;
            $tpOP = (int)isset($value) ? $value : 0;
        }
        //Valor do imposto de importação
        $vII = 0;
        if (!empty($ii)) {
            $value = $ii->getElementsByTagName("vII")->item(0)->nodeValue ?? null;
            $vII = (float)!empty($value) ? $value : 0;
        }
        $vProd = (float)!empty($det->getElementsByTagName("vProd")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vProd")->item(0)->nodeValue : 0;
        $vDesc = (float)!empty($det->getElementsByTagName("vDesc")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vDesc")->item(0)->nodeValue : 0;
        $vFrete = (float)!empty($det->getElementsByTagName("vFrete")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vFrete")->item(0)->nodeValue : 0;
        $vSeg = (float)!empty($det->getElementsByTagName("vSeg")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vSeg")->item(0)->nodeValue : 0;
        $vOutro = (float)!empty($det->getElementsByTagName("vOutro")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vOutro")->item(0)->nodeValue : 0;
        $icmsdeson = 0;
        $vICMSST = 0;
        $vICMSMonoReten = 0;
        $vFCPST = 0;
        if (!empty($icms)) {
            //aplica desoneração caso indDeduzDeson = 1
            $indDeduzDeson = (int)!empty($icms->getElementsByTagName("indDeduzDeson")
                ->item(0)->nodeValue) ?
                $icms->getElementsByTagName("indDeduzDeson")->item(0)->nodeValue :
                0;
            $vICMSDeson = (float)!empty($icms->getElementsByTagName("vICMSDeson")
                ->item(0)->nodeValue) ?
                $icms->getElementsByTagName("vICMSDeson")->item(0)->nodeValue : 0;
            $icmsdeson = $vICMSDeson * $indDeduzDeson;
            $vICMSST = (float)!empty($icms->getElementsByTagName("vICMSST")->item(0)->nodeValue) ?
                $icms->getElementsByTagName("vICMSST")->item(0)->nodeValue : 0;
            $vICMSMonoReten = (float)!empty($icms->getElementsByTagName("vICMSMonoReten")
                ->item(0)->nodeValue) ?
                $icms->getElementsByTagName("vICMSMonoReten")->item(0)->nodeValue : 0;
            $vFCPST = (float)!empty($icms->getElementsByTagName("vFCPST")->item(0)->nodeValue) ?
                $icms->getElementsByTagName("vFCPST")->item(0)->nodeValue : 0;
        }
        //IPI
        $vIPI = 0;
        if (!empty($ipi)) {
            $vIPI = (float)!empty($ipi->getElementsByTagName("vIPI")->item(0)->nodeValue) ?
                $ipi->getElementsByTagName("vIPI")->item(0)->nodeValue : 0;
        }
        //IPIDevol
        $vIPIDevol = 0;
        if (!empty($impostoDevol)) {
            $vIPIDevol = (float)!empty($impostoDevol->getElementsByTagName("vIPIDevol")
                ->item(0)->nodeValue) ?
                $impostoDevol->getElementsByTagName("vIPIDevol")->item(0)->nodeValue : 0;
        }
        //Serviços
        $vServ = 0; //esse campo não existe no item mas é igual a vProd !! ignorar
        //PISST
        $vPIS = 0;
        if (!empty($pisst)) {
            $indSomaPISST = (int)!empty($pisst->getElementsByTagName("indSomaPISST")
                ->item(0)->nodeValue) ?
                $pisst->getElementsByTagName("indSomaPISST")->item(0)->nodeValue : 0;
            $vPIS = (float)!empty($pisst->getElementsByTagName("vPIS")->item(0)->nodeValue) ?
                $pisst->getElementsByTagName("vPIS")->item(0)->nodeValue : 0;
            $vPIS = $vPIS * $indSomaPISST;
        }
        //COFINSST
        $vCOFINS = 0;
        if (!empty($cofinsst)) {
            $indSomaCOFINSST = (int)!empty($cofinsst->getElementsByTagName("indSomaCOFINSST")
                ->item(0)->nodeValue) ?
                $cofinsst->getElementsByTagName("indSomaCOFINSST")->item(0)->nodeValue : 0;
            $vCOFINS = (float)!empty($cofinsst->getElementsByTagName("vCOFINS")->item(0)->nodeValue)
                ? $cofinsst->getElementsByTagName("vCOFINS")->item(0)->nodeValue : 0;
            $vCOFINS = $vCOFINS * $indSomaCOFINSST;
        }
        //IBSCBS
        $vIBSUF = 0;
        $vIBSMun = 0;
        $vCBS = 0;
        $vTotIBSMonoItem = 0;
        $vTotCBSMonoItem = 0;
        if (!empty($cbs) && $this->schema > 9) {
            $vIBSUF = (float)!empty($cbs->getElementsByTagName("vIBSUF")->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vIBSUF")->item(0)->nodeValue : 0;
            $vIBSMun = (float)!empty($cbs->getElementsByTagName("vIBSMun")->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vIBSMun")->item(0)->nodeValue : 0;
            $vCBS = (float)!empty($cbs->getElementsByTagName("vCBS")->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vCBS")->item(0)->nodeValue : 0;
            $vTotIBSMonoItem = (float)!empty($cbs->getElementsByTagName("vTotIBSMonoItem")
                ->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vTotIBSMonoItem")->item(0)->nodeValue : 0;
            $vTotCBSMonoItem = (float)!empty($cbs->getElementsByTagName("vTotCBSMonoItem")
                ->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vTotCBSMonoItem")->item(0)->nodeValue : 0;
        }
        //IS
        $vIS = 0;
        if (!empty($is) && $this->schema > 9) {
            $vIS = (float)!empty($is->getElementsByTagName("vIS")->item(0)->nodeValue) ?
                $is->getElementsByTagName("vIS")->item(0)->nodeValue : 0;
        }
        //Somatório
        if ($tpOP != 2) {
            //todas as operações exceto venda de veiculos novas
            $vitem = round(
                $vProd
                - $vDesc
                - $icmsdeson
                + $vICMSST
                + $vICMSMonoReten
                + $vFCPST
                + $vFrete
                + $vSeg
                + $vOutro
                + $vII
                + $vIPI
                + $vIPIDevol
                + $vServ
                + $vPIS
                + $vCOFINS
                + $vIBSUF  //2026 remover esse campo da soma
                + $vIBSMun //2026 remover esse campo da soma
                + $vCBS    //2026 remover esse campo da soma
                + $vIS     //2026 remover esse campo da soma
                + $vTotIBSMonoItem  //2026 remover esse campo da soma
                + $vTotCBSMonoItem,
                2
            ); //2026 remover esse campo da soma
        } else {
            //venda de veiculos novos
            $vitem = round(
                $vProd
                - $vDesc
                - $icmsdeson
                + $vFrete
                + $vSeg
                + $vOutro
                + $vII
                + $vIPI
                + $vServ
                + $vPIS
                + $vCOFINS
                + $vIBSUF  //2026 remover esse campo da soma
                + $vIBSMun //2026 remover esse campo da soma
                + $vCBS    //2026 remover esse campo da soma
                + $vIS,
                2
            );     //2026 remover esse campo da soma
        }
        return $this->dom->createElement(
            "vItem",
            $this->conditionalNumberFormatting($vitem, 2)
        );
    }

    /**
     * Adiciona as tags NFref na tag ide
     * NFref => tag ide
     * @return void
     */
    protected function addTagRefToIde()
    {
        if (empty($this->ide)) {
            $this->errors[] = 'Falta a tag "ide"';
            return;
        }
        if (empty($this->aNFref)) {
            return;
        }
        //[1] tags NFref
        //processa NFref e coloca as tags na tag ide
        if (count($this->aNFref) > 999) {
            $this->errors[] = "Existe limite de no máximo 999 tags NFref";
            $this->aNFref = array_slice($this->aNFref, 0, 999);
        }
        foreach ($this->aNFref as $nfeRef) {
            $this->dom->appChild($this->ide, $nfeRef);
        }
    }

    /**
     * Adiciona a tag emit na tag infNFe
     * @return void
     */
    protected function addTagEmit()
    {
        if (empty($this->enderEmit) && empty($this->emit)) {
            return;
        }
        if (empty($this->infNFe)) {
            $this->errors[] = 'Falta a tag "infNFe"';
            return;
        }
        //[8] tag emit (C01)
        //verifica se o endereço do emitente já existe na tag emit
        $endemit = $this->emit->getElementsByTagName('enderEmit')->item(0);
        if (empty($endemit) && !empty($this->enderEmit) && !empty($this->emit)) {
            //se enderEmit não estiver já inserido na tag emit, então inserir
            $node = $this->emit->getElementsByTagName("IE")->item(0);
            $this->emit->insertBefore($this->enderEmit, $node);
        }
        $this->dom->appChild($this->infNFe, $this->emit, '');
    }

    /**
     * Adiciona a tag dest na tag infNFe
     * @return void
     */
    protected function addTagDest()
    {
        if (empty($this->dest)) {
            return;
        }
        if (empty($this->infNFe)) {
            $this->errors[] = 'Falta a tag "infNFe"';
            return;
        }
        //verifica se o endereço do destinatário já existe na tag dest
        $enddest = $this->dest->getElementsByTagName('enderDest')->item(0) ?? null;
        if (is_null($enddest) && !is_null($this->enderDest)) {
            $node = $this->dest->getElementsByTagName("indIEDest")->item(0);
            if (!isset($node)) {
                $node = $this->dest->getElementsByTagName("IE")->item(0);
            }
            $this->dest->insertBefore($this->enderDest, $node);
        }
        $this->dom->appChild($this->infNFe, $this->dest);
    }

    /**
     * Adiciona as tags autXML na tag infNFe
     * @return void
     */
    protected function addTagAutXML()
    {
        if (count($this->aAutXML) == 0) {
            return;
        }
        if (empty($this->infNFe)) {
            $this->errors[] = 'Falta a tag "infNFe"';
            return;
        }
        foreach ($this->aAutXML as $aut) {
            $this->dom->appChild($this->infNFe, $aut);
        }
    }

    /**
     * Adiciona a tag transp na tag infNFe
     * @return void
     */
    protected function addTagTransp()
    {
        if (empty($this->transp)) {
            return;
        }
        if (empty($this->infNFe)) {
            $this->errors[] = 'Falta a tag "infNFe"';
            return;
        }
        $this->addTag($this->transp, $this->transporta);
        $this->addTag($this->transp, $this->retTransp);
        $this->addTag($this->transp, $this->veicTransp);
        if (!empty($this->aReboque)) {
            $this->aReboque = array_slice($this->aReboque, 0, 5);
            foreach ($this->aReboque as $reboque) {
                $this->addTag($this->transp, $reboque);
            }
        }
        if (!empty($this->vagao) && empty($this->veicTransp) && empty($this->aReboque)) {
            $this->addTag($this->transp, $this->vagao);
        }
        if (!empty($this->balsa) && empty($this->veicTransp) && empty($this->aReboque) && empty($this->vagao)) {
            $this->addTag($this->transp, $this->balsa);
        }
        if (!empty($this->aVol)) {
            $this->aVol = array_slice($this->aVol, 0, 5000, true);
            foreach ($this->aVol as $item => $vol) {
                if (!empty($this->aLacre[$item])) {
                    $lacres = $this->aLacre[$item];
                    foreach ($lacres as $lacre) {
                        $this->addTag($vol, $lacre);
                    }
                }
                $this->addTag($this->transp, $vol);
            }
        }
        $this->dom->appChild($this->infNFe, $this->transp);
    }

    /**
     * Adiciona a tag pag a infNFe
     * @return void
     */
    protected function addTagPag()
    {
        if (empty($this->pag)) {
            $this->errors[] = 'Falta a tag "pag" OBRIGATÓRIA';
            return;
        }
        if (empty($this->aDetPag)) {
            $this->errors[] = 'Falta a tag "detPag" OBRIGATÓRIA';
            return;
        }
        if (empty($this->infNFe)) {
            $this->errors[] = 'Falta a tag "infNFe"';
            return;
        }
        $node = !empty($this->pag->getElementsByTagName("vTroco")->item(0))
            ? $this->pag->getElementsByTagName("vTroco")->item(0)
            : null;
        if (!empty($node)) {
            foreach ($this->aDetPag as $detPag) {
                $this->pag->insertBefore($detPag, $node);
            }
        } else {
            foreach ($this->aDetPag as $detPag) {
                $this->dom->appChild($this->pag, $detPag, '');
            }
        }
        $this->dom->appChild($this->infNFe, $this->pag, '');
    }

    /**
     * Adiciona a tag cana a infNFe
     * @return void
     */
    protected function addTagCana()
    {
        if (empty($this->cana)) {
            return;
        }
        if (empty($this->aForDia)) {
            $this->errors[] = 'Falta a tag "forDia"';
            return;
        }
        if (count($this->aForDia) > 31) {
            $this->errors[] = 'A tag forDia (produção diária de cana) pode ter até 31 dias no maximo.';
        }
        if (empty($this->infNFe)) {
            $this->errors[] = 'Falta a tag "infNFe"';
            return;
        }
        $qTotMes = $this->cana->getElementsByTagName('qTotMes')->item(0) ?? null;
        if (!empty($qTotMes)) {
            foreach ($this->aForDia as $forDia) {
                $this->cana->insertBefore($forDia, $qTotMes);
            }
        }
        if (!empty($this->aDeduc)) {
            if (count($this->aDeduc) > 10) {
                $this->errors[] = 'A tag deduc (deduções na produção de cana) podem ter até 10 registros no máximo.';
            }
            $vFor = $this->cana->getElementsByTagName('vFor')->item(0) ?? null;
            if (!empty($vFor)) {
                foreach ($this->aDeduc as $deduc) {
                    $this->cana->insertBefore($deduc, $vFor);
                }
            }
        }
        $this->dom->appChild($this->infNFe, $this->cana, '');
    }

    /**
     * Adiciona a tag agropacuario. Esta tag foi removida no PL_010
     * @return void
     * @throws \DOMException
     */
    protected function addTagAgropecuario()
    {
        //o schema estabelece qual PL está sendo usado para a montagem da NFe/NFCe
        if ($this->schema < 10) {
            //Esta tag não existe na PL_009
            return;
        }
        if (!empty($this->agropecuarioGuia)) {
            $agrop = $this->dom->createElement('agropecuario');
            $this->addTag($agrop, $this->agropecuarioGuia);
            $this->addTag($this->infNFe, $agrop);
        } elseif (!empty($this->aAgropecuarioDefensivo)) {
            $agrop = $this->dom->createElement('agropecuario');
            if (count($this->aAgropecuarioDefensivo) > 20) {
                $this->errors[] = 'Podem existir no máximo 20 tag agropecuario/defensivo.';
                $this->aAgropecuarioDefensivo = array_slice($this->aAgropecuarioDefensivo, 0, 20);
            }
            foreach ($this->aAgropecuarioDefensivo as $agropecuarioDefensivo) {
                $this->addTag($agrop, $agropecuarioDefensivo);
            }
            $this->addTag($this->infNFe, $agrop);
        }
    }

    /**
     * Monta e adiciona a tag total na tag infNFe
     * @return void
     * @throws \DOMException
     */
    protected function addTagTotal()
    {
        $vNFTot = null;
        $identificador = 'W01 <total> -';
        $total = $this->dom->createElement('total');
        //Grupo Totais referentes ao ICMS
        if (empty($this->ICMSTot)) {
            $icms = [
                'vBC' => null,
                'vICMS' => null,
                'vICMSDeson' => null,
                'vBCST' => null,
                'vST' => null,
                'vProd' => null,
                'vFrete' => null,
                'vSeg' => null,
                'vDesc' => null,
                'vII' => null,
                'vIPI' => null,
                'vPIS' => null,
                'vCOFINS' => null,
                'vOutro' => null,
                'vNF' => null,
                'vIPIDevol' => null,
                'vTotTrib' => null,
                'vFCP' => null,
                'vFCPST' => null,
                'vFCPSTRet' => null,
                'vFCPUFDest' => null,
                'vICMSUFDest' => null,
                'vICMSUFRemet' => null,
                'qBCMono' => null,
                'vICMSMono' => null,
                'qBCMonoReten' => null,
                'vICMSMonoReten' => null,
                'qBCMonoRet' => null,
                'vICMSMonoRet' => null,
            ];
            $this->tagICMSTot((object)$icms);
        }
        //Até 2036 esta tag deverá existir segundo a documentação atual da SEFAZ
        $this->addTag($total, $this->ICMSTot);
        //Grupo Totais referentes ao ISSQN
        if (empty($this->ISSQNTot) && $this->stdISSQNTot->vServ > 0) {
            $iss = [
                'vServ' => null,
                'vBC' => null,
                'vISS' => null,
                'vPIS' => null,
                'vCOFINS' => null,
                'dCompet' => null,
                'vDeducao' => null,
                'vOutro' => null,
                'vDescIncond' => null,
                'vDescCond' => null,
                'vISSRet' => null,
                'cRegTrib' => null
            ];
            $this->tagISSQNTot((object)$iss);
        }
        $this->addTag($total, $this->ISSQNTot);
        //Grupo Retenções de Tributos
        if (!is_null($this->retTrib)) {
            $this->addTag($total, $this->retTrib);
        }
        if ($this->schema > 9) {
            //Totalizador do IS
            if (empty($this->ISTot) && !empty($this->stdIStot->vIS)) {
                //não foi informado o total do IS, obter do calculado
                $tis = [
                    'vIS' => $this->stdIStot->vIS
                ];
                $this->tagISTot((object)$tis);
            }
            if (!empty($this->ISTot)) {
                $this->addTag($total, $this->ISTot);
            }
            //Totalizador do IBSCBS
            if (empty($this->IBSCBSTot) && !empty($this->cst_ibscbs)) {
                //não foi informado o total do IBSCBS, obter do calculado
                $ib = [
                    'vBCIBSCBS',
                    'gIBS_vIBS',
                    'gIBS_vCredPres',
                    'gIBS_vCredPresCondSus',
                    'gIBSUF_vDif',
                    'gIBSUF_vDevTrib',
                    'gIBSUF_vIBSUF',
                    'gIBSMun_vDif',
                    'gIBSMun_vDevTrib',
                    'gIBSMun_vIBSMun',
                    'gCBS_vDif',
                    'gCBS_vDevTrib',
                    'gCBS_vCBS',
                    'gCBS_vCredPres',
                    'gCBS_vCredPresCondSus',
                    'gMono_vIBSMono',
                    'gMono_vCBSMono',
                    'gMono_vIBSMonoReten',
                    'gMono_vCBSMonoReten',
                    'gMono_vIBSMonoRet',
                    'gMono_vCBSMonoRet',
                ];
                $this->tagIBSCBSTot((object)$ib);
            }
            if (!empty($this->IBSCBSTot)) {
                $this->addTag($total, $this->IBSCBSTot);
                //campo vNFTot PL_010
                //if (empty($this->vNFTot)) {
                    //$this->vNFTot = $this->stdTot->vNF;
                    //@todo 2026 + $this->stdTot->vIBS + $this->stdTot->vCBS + $this->stdTot->vIS;
                //}
                if (!empty($this->vNFTot)) {
                    $this->dom->addChild(
                        $total,
                        "vNFTot",
                        $this->conditionalNumberFormatting($this->vNFTot, 2),
                        false,
                        "$identificador Valor total da NF-e com IBS / CBS / IS"
                    );
                }
            }
        }
        $this->addTag($this->infNFe, $total);
    }

    /**
     * Adiciona tag filhas a tag Pai
     * @param DOMElement|null $parent
     * @param DOMElement|null $child
     * @param string $msg
     * @return void
     */
    protected function addTag(&$parent = null, $child = null, $msg = '')
    {
        if (empty($child)) {
            return;
        }
        if (empty($parent)) {
            if (empty($msg)) {
                $msg = "ERRO parent null no método addTag()";
            }
            $this->errors[] = $msg;
            return;
        }
        $this->dom->appChild($parent, $child, $msg);
    }

    /**
     * Tag raiz da NFe
     * tag NFe DOMNode
     * Função chamada pelo método [ render ]
     * @return DOMElement
     * @throws \DOMException
     */
    protected function buildNFe(): DOMElement
    {
        if (empty($this->NFe)) {
            $this->NFe = $this->dom->createElement("NFe");
            $this->NFe->setAttribute("xmlns", "http://www.portalfiscal.inf.br/nfe");
        }
        return $this->NFe;
    }

    /**
     * Remonta a chave da NFe de 44 digitos com base em seus dados
     * já contidos na NFE.
     * Isso é útil no caso da chave informada estar errada
     * se a chave estiver errada a mesma é substituida
     * @param Dom $dom
     * @return void
     * @throws \Exception
     */
    protected function checkNFeKey(Dom $dom): void
    {
        try {
            $infNFe = $dom->getElementsByTagName("infNFe")->item(0);
            $ide = $dom->getElementsByTagName("ide")->item(0);
            if (empty($ide)) {
                return;
            }
            $emit = $dom->getElementsByTagName("emit")->item(0);
            if (empty($emit)) {
                return;
            }
            $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
            $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
            if (!empty($emit->getElementsByTagName('CNPJ')->item(0)->nodeValue)) {
                $doc = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
            } else {
                $doc = $emit->getElementsByTagName('CPF')->item(0)->nodeValue;
            }
            $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
            $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
            $nNF = $ide->getElementsByTagName('nNF')->item(0)->nodeValue;
            $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
            $cNF = $ide->getElementsByTagName('cNF')->item(0)->nodeValue;
            $chave = str_replace('NFe', '', $infNFe->getAttribute("Id"));
            $dt = new DateTime($dhEmi);
            $infRespTec = $dom->getElementsByTagName("infRespTec")->item(0);
            $chaveMontada = Keys::build(
                $cUF,
                $dt->format('y'),
                $dt->format('m'),
                $doc,
                $mod,
                $serie,
                $nNF,
                $tpEmis,
                $cNF
            );
            if (empty($chave)) {
                //chave não foi passada por parâmetro então colocar a chavemontada
                $infNFe->setAttribute('Id', "NFe$chaveMontada");
                $chave = $chaveMontada;
                $this->chNFe = $chaveMontada;
                $ide->getElementsByTagName('cDV')->item(0)->nodeValue = substr($chave, -1);
                //trocar também o hash se o CSRT for passado
                if (!empty($this->csrt)) {
                    $hashCSRT = $this->hashCSRT($this->csrt);
                    $infRespTec->getElementsByTagName("hashCSRT")
                        ->item(0)->nodeValue = $hashCSRT;
                }
            }
            //caso a chave contida na NFe esteja errada
            //substituir a chave
            if ($chaveMontada != $chave) {
                $this->chNFe = $chaveMontada;
                $this->errors[] = "A chave informada está incorreta [$chave] => [correto: $chaveMontada].";
            }
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
    }

    /**
     * Includes missing or unsupported properties in stdClass
     * Convert all properties of object in lower case
     * Replace all unsuported chars from data
     * @param stdClass $std
     * @param string[] $possible
     * @return stdClass
     */
    protected function equilizeParameters(stdClass $std, array $possible): stdClass
    {
        $ppl = array_map('strtolower', $possible);
        $std = self::propertiesToLower($std);
        $equalized = Strings::equilizeParameters(
            $std,
            $ppl,
            $this->replaceAccentedChars
        );
        return self::propertiesToBack($equalized, $possible);
    }

    /**
     * Change properties names of object to lower case
     * @param stdClass $data
     * @return stdClass
     */
    protected static function propertiesToLower(stdClass $data): stdClass
    {
        $properties = get_object_vars($data);
        $clone = new stdClass();
        foreach ($properties as $key => $value) {
            if ($value instanceof stdClass) {
                $value = self::propertiesToLower($value);
            }
            $nk = trim(strtolower($key));
            $clone->{$nk} = $value;
        }
        return $clone;
    }

    /**
     * Return properties do original name
     * @param stdClass $data
     * @param array $possible
     * @return stdClass
     */
    protected static function propertiesToBack(stdClass $data, array $possible): stdClass
    {
        $new = new stdClass();
        $properties = get_object_vars($data);
        foreach ($properties as $key => $value) {
            foreach ($possible as $p) {
                if (strtolower($p) === $key) {
                    $new->$p = $value;
                    break;
                }
            }
        }
        return $new;
    }

    /**
     * Adjust the text size to the maximum acceptable size
     * @param string|null $string
     * @param int $max
     * @return string|null
     */
    protected function adjustingStrings($string, $max = 0): ?string
    {
        if (is_null($string)) {
            return null;
        }
        if (empty($string)) {
            return '';
        }
        if ($max === 0) {
            return $string;
        }
        return substr($string, 0, $max);
    }

    /**
     * Formatação numerica condicional
     * @param string|float|int|null $value
     * @param int $decimal
     * @return string|null
     */
    protected function conditionalNumberFormatting($value = null, int $decimal = 2): ?string
    {
        if (is_numeric($value)) {
            return number_format($value, $decimal, '.', '');
        }
        return null;
    }
}
