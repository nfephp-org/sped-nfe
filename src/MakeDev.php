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
use NFePHP\NFe\Traits\TraitTagTransp;
use stdClass;
use DOMElement;
use DateTime;

class MakeDev
{
    use TraitTagIde;
    use TraitTagInfNfe;
    use TraitTagEmit;
    use TraitTagRefs;
    use TraitTagGCompraGov;
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

    /**
     * @var mixed
     */
    protected $config;
    /**
     * @var int
     */
    protected $schema; //esta propriedade da classe estabelece qual é a versão do schema sendo considerado
    /**
     * @var int
     */
    protected $tpAmb;
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
     * @var int
     */
    protected int $mod = 55;
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
     * @var stdClass
     */
    protected $stdTot;
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
    protected $emit;
    /**
     * @var DOMElement
     */
    protected $enderEmit;
    /**
     * @var DOMElement
     */
    protected $gCompraGov;
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
    protected $intermed;
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
    protected $total;
    /**
     * @var DOMElement
     */
    protected $infIntermed;
    /**
     * @var DOMElement
     */
    protected $agropecuarioGuia; //Não Existe na PL_010
    /**
     * @var array
     */
    protected $aReboque;
    /**
     * @var array
     */
    protected $aVol;
    /**
     * @var array
     */
    protected $aLacre;
    /**
     * @var array
     */
    protected $aNFref;
    /**
     * @var array
     */
    protected $aAutXML;
    /**
     * @var array
     */
    protected $aProd;
    /**
     * @var array
     */
    protected $aCest;
    /**
     * @var array
     */
    protected $aNVE;
    /**
     * @var array
     */
    protected $aRECOPI;
    /**
     * @var array
     */
    protected $aRastro;
    /**
     * @var array
     */
    protected $aVeicProd;
    /**
     * @var array
     */
    protected $aMed;
    /**
     * @var array
     */
    protected $aArma;
    /**
     * @var array
     */
    protected $aDI;
    /**
     * @var array
     */
    protected $aAdi;
    /**
     * @var array
     */
    protected $aDetExport;
    /**
     * @var array
     */
    protected $aImposto;
    /**
     * @var array
     */
    protected $aICMS;
    /**
     * @var array
     */
    protected $aICMSPart;
    /**
     * @var array
     */
    protected $aICMSUFDest;
    /**
     * @var array
     */
    protected $aICMSSN;
    /**
     * @var array
     */
    protected $aICMSST;
    /**
     * @var array
     */
    protected $aPIS;
    /**
     * @var array
     */
    protected $aCOFINS;
    /**
     * @var array
     */
    protected $aInfAdProd;
    /**
     * @var array
     */
    protected $aObsItem;
    /**
     * @var array
     */
    protected $aVItem;
    /**
     * @var array
     */
    protected $aDetPag;
    /**
     * @var array
     */
    protected $aObsCont;
    /**
     * @var array
     */
    protected $aObsFisco;
    /**
     * @var array
     */
    protected $aProcRef;
    /**
     * @var array
     */
    protected $aForDia;
    /**
     * @var array
     */
    protected $aDeduc;
    /**
     * @var array
     */
    protected $aComb;
    /**
     * @var array
     */
    protected $aEncerrante;
    /**
     * @var array
     */
    protected $aOrigComb;
    /**
     * @var array
     */
    protected $aAgropecuarioDefencivo;

    /**
     * Função construtora cria um objeto DOMDocument
     * que será carregado com o documento fiscal
     */
    public function __construct(string $schema)
    {
        $this->schema = 9; //PL_009_V4
        if (!empty($schema)) {
            $this->schema = (int) preg_replace("/[^0-9]/", "", substr($schema, 0, 6));
        }
        $this->tpAmb = (int) $this->config->tpAmb ?? 2;
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;

        //elemento totalizador
        $this->stdTot = new \stdClass();
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

        $this->stdISSQNTot = new \stdClass();
        $this->stdISSQNTot->vServ = null;
        $this->stdISSQNTot->vBC = null;
        $this->stdISSQNTot->vISS = null;
        $this->stdISSQNTot->vPIS = null;
        $this->stdISSQNTot->vCOFINS = null;
        $this->stdISSQNTot->dCompet = null;
        $this->stdISSQNTot->vDeducao = null;
        $this->stdISSQNTot->vOutro = null;
        $this->stdISSQNTot->vDescIncond = null;
        $this->stdISSQNTot->vDescCond = null;
        $this->stdISSQNTot->vISSRet = null;
        $this->stdISSQNTot->cRegTrib = null;

        $this->stdIStot  = new \stdClass();
        $this->stdIStot->vIS = null;

        $this->stdIBSCBSTot = new \stdClass();
        $this->stdIBSCBSTot->vBCIBSCBS = null;
        $this->stdIBSCBSTot->vIBS = null;
        $this->stdIBSCBSTot->vCredPres = null;
        $this->stdIBSCBSTot->vCredPresCondSus = null;

        $this->stdIBSCBSTot->gIBSUF = new \stdClass();
        $this->stdIBSCBSTot->gIBSUF->vDif = null;
        $this->stdIBSCBSTot->gIBSUF->vDevTrib = null;
        $this->stdIBSCBSTot->gIBSUF->vIBSUF = null;

        $this->stdIBSCBSTot->gIBSMun = new \stdClass();
        $this->stdIBSCBSTot->gIBSMun->vDif = null;
        $this->stdIBSCBSTot->gIBSMun->vDevTrib = null;
        $this->stdIBSCBSTot->gIBSMun->vIBSMun = null;

        $this->stdIBSCBSTot->gCBS = new \stdClass();
        $this->stdIBSCBSTot->gCBS->vDif = null;
        $this->stdIBSCBSTot->gCBS->vDevTrib = null;
        $this->stdIBSCBSTot->gCBS->vCBS = null;
        $this->stdIBSCBSTot->gCBS->vCredPres = null;
        $this->stdIBSCBSTot->gCBS->vCredPresCondSus = null;

        $this->stdIBSCBSTot->gMono = new \stdClass();
        $this->stdIBSCBSTot->gMono->vIBSMono = null;
        $this->stdIBSCBSTot->gMono->vCBSMono = null;
        $this->stdIBSCBSTot->gMono->vIBSMonoReten = null;
        $this->stdIBSCBSTot->gMono->vCBSMonoReten = null;
        $this->stdIBSCBSTot->gMono->vIBSMonoRet = null;
        $this->stdIBSCBSTot->gMono->vCBSMonoRet = null;
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
        return (int) $this->mod;
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
     */
    public function montaNFe(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        try {
            //cria a tag NFe
            $this->buildNFe();
            //tag NFref => tag ide
            $this->addTagRefToIde();
            //tag gCompraGov => tag ide Existe apenas a partir da PL_010
            if ($this->schema > 9) {
                $this->addTag($this->ide, $this->gCompraGov, 'Falta a tag "ide"');
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
                    $nves = array_slice($nves, 0, 8) ;
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
                    $gbs = array_slice($gcs, 0, 4) ;
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
                $indTot = $prod->getElementsByTagName("indTot")->item(0);
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
                        $this->addTag($di, $adi);
                    }
                    $this->dom->insertAfter($di, $indTot);
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
                    $this->addTag($prod, $ra);
                }
            }
            //CHOICE
            $flagChoice = false;
            //veicProd => prod
            if (!empty($this->aVeicProd[$item]) && $flagChoice === false) {
                $this->addTag($prod, $this->aVeicProd[$item]);
                $flagChoice = true;
            }
            //med => prod
            if (!empty($this->aMed[$item]) && $flagChoice === false) {
                $this->addTag($prod, $this->aMed[$item]);
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
                    $this->addTag($prod, $arm);
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
                            $this->addTag($comb, $encerrante);
                        }
                    }
                }
                //incluso NT 2023.001-1.10 /1.20
                if (!empty($this->aOrigComb[$item])) {
                    foreach ($this->aOrigComb[$item] as $origcomb) {
                        $this->addTag($comb, $origcomb);
                    }
                }
                $this->addTag($prod, $this->aComb[$item]);
                $flagChoice = true;
            }
            //RECOPI => prod
            if (!empty($this->aRECOPI[$item]) && $flagChoice === false) {
                $prod->appendChild($this->aRECOPI[$item]);
            }
            $this->addTag($det, $prod);

            //imposto => det
            $imposto = $this->dom->createElement("imposto");
            if (!empty($this->aImposto[$item])) {
                $imposto = $this->aImposto[$item];
            }
            //ICMS => imposto
            if (!empty($this->aICMS[$item])) {
                $this->addTag($imposto, $this->aICMS[$item]);
            }
            //IPI => imposto
            if (!empty($this->aIPI[$item])) {
                $this->addTag($imposto, $this->aIPI[$item]);
            }
            //II => imposto
            if (!empty($this->aII[$item])) {
                $this->addTag($imposto, $this->aII[$item]);
            }
            //ISSQN => imposto
            if (!empty($this->aISSQN[$item])) {
                $this->addTag($imposto, $this->aISSQN[$item]);
            }
            //PIS => imposto
            if (!empty($this->aPIS[$item])) {
                $this->addTag($imposto, $this->aPIS[$item]);
            }
            //PISST => imposto
            if (!empty($this->aPISST[$item])) {
                $this->addTag($imposto, $this->aPISST[$item]);
            }
            //COFINS => imposto
            if (!empty($this->aCOFINS[$item])) {
                $this->addTag($imposto, $this->aCOFINS[$item]);
            }
            //COFINSST => imposto
            if (!empty($this->aCOFINSST[$item])) {
                $this->addTag($imposto, $this->aCOFINSST[$item]);
            }
            //ICMSUFDest => imposto
            if (!empty($this->aICMSUFDest[$item])) {
                $this->addTag($imposto, $this->aICMSUFDest[$item]);
            }
            //IS => imposto - somente para PL_010 em diante
            if (!empty($this->aIS[$item]) && $this->schema > 9) {
                $this->addTag($imposto, $this->aIS[$item]);
            }
            //IBSCBS => imposto - somente para PL_010 em diante
            if (!empty($this->aIBSCBS[$item])  && $this->schema > 9) {
                $this->addTag($imposto, $this->aIBSCBS[$item]);
            }
            $this->addTag($det, $imposto);
            //impostoDevol => det
            if (!empty($this->aImpostoDevol[$item])) {
                $this->addTag($imposto, $this->aImpostoDevol[$item]);
            }
            //infAdProd => det
            if (!empty($this->aInfAdProd[$item])) {
                $this->addTag($det, $this->aInfAdProd[$item]);
            }
            //obsItem => det
            if (!empty($this->aObsItem[$item])) {
                $this->addTag($det, $this->aObsItem[$item]);
            }
            //vItem => det  ...  incluso no método tagProd() PL_010
            if (!empty($this->aVItem[$item]) && $this->schema > 9) {
                $this->addTag($det, $this->aVItem[$item]);
            }
            //DFEReferenciado => det PL_010
            if (!empty($this->aDFeReferenciado[$item]) && $this->schema > 9) {
                $this->addTag($det, $this->aDFeReferenciado[$item]);
            }
            $this->addTag($this->infNFe, $det);
        }
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
        if (empty($this->enderDest) && empty($this->dest)) {
            return;
        }
        if (empty($this->infNFe)) {
            $this->errors[] = 'Falta a tag "infNFe"';
            return;
        }
        //verifica se o endereço do destinatário já existe na tag dest
        $enddest = $this->dest->getElementsByTagName('enderDest')->item(0);
        if (empty($enddest) && !empty($this->enderDest)) {
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
        if (empty($this->aAutXMl)) {
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
     * Adiciona a tag agropacuario
     * @return void
     * @throws \DOMException
     */
    protected function addTagAgropecuario()
    {
        //o schema estabelece qual PL está sendo usado para a montegem da NFe/NFCe
        if ($this->schema > 9) {
            return;
        }
        if (!empty($this->agropecuarioGuia)) {
            $agrop = $this->dom->createElement('agropecuario');
            $this->addTag($agrop, $this->agropecuarioGuia);
            $this->addTag($this->infNFe, $agrop);
        } elseif (!empty($this->aAgropecuarioDefencivo)) {
            $agrop = $this->dom->createElement('agropecuario');
            if (count($this->aAgropecuarioDefencivo) > 20) {
                $this->errors[] = 'Podem existir no máximo 20 tag agropecuario/defencivo.';
                $this->aAgropecuarioDefencivo = array_slice($this->aAgropecuarioDefencivo, 0, 20);
            }
            foreach ($this->aAgropecuarioDefencivo as $agropecuarioDefencivo) {
                $this->addTag($agrop, $agropecuarioDefencivo);
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

        $icmstot = $this->dom->createElement('ICMSTot');
        $issqntot = $this->dom->createElement('ISSQNtot');
        $rettrib = $this->dom->createElement('retTrib');
        $istot = $this->dom->createElement('ISTot');
        $ibscbdtot = $this->dom->createElement('IBSCBSTot');
        $this->dom->addChild(
            $total,
            "vNFTot",
            $this->conditionalNumberFormatting($vNFTot, 2),
            false,
            "$identificador Valor total da NF-e com IBS / CBS / IS"
        );
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
        $equalized =  Strings::equilizeParameters(
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
        foreach ($data as $key => $value) {
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
     * @return false|string|null
     */
    protected function adjustingStrings(string $string = null, int $max = 0): ?string
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
