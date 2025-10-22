<?php

namespace NFePHP\NFe;

use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;
use NFePHP\NFe\Traits\TraitCalculations;
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
    use TraitCalculations;

    const METHOD_CALCULATION_V1 = 1; //by values, calculate vItem and vNFTot
    const METHOD_CALCULATION_V2 = 1; //by tags, calculate vItem and vNFTot

    protected int $schema; //esta propriedade da classe estabelece qual é a versão do schema sendo considerado
    protected int $tpAmb = 2;
    protected int $crt;
    public array $errors = [];
    public ?string $chNFe;
    public string $xml;
    protected int $calculationMethod = 2;
    protected string $version;
    protected string $mod = '55';
    protected string $csrt;
    protected string $cst_ibscbs;
    protected int $indDeduzDeson = 0;
    protected bool $checkgtin = false;
    protected bool $replaceAccentedChars = false;
    public Dom $dom;
    public stdClass $stdTot;
    protected stdClass $stdISSQNTot;
    protected stdClass $stdIStot;
    protected stdClass $stdIBSCBSTot;
    protected DOMElement $NFe;
    protected DOMElement $infNFe;
    protected DOMElement $ide;
    protected ?DOMElement $gCompraGov;
    protected ?DOMElement $gPagAntecipado;
    protected DOMElement $emit;
    protected DOMElement $enderEmit;
    protected DOMElement $dest;
    protected ?DOMElement $enderDest;
    protected ?DOMElement $retirada;
    protected ?DOMElement $entrega;
    protected ?DOMElement $infAdic;
    protected ?DOMElement $infRespTec;
    protected ?DOMElement $cobr;
    protected DOMElement $pag;
    protected ?DOMElement $transp;
    protected ?DOMElement $transporta;
    protected ?DOMElement $retTransp;
    protected ?DOMElement $veicTransp;
    protected ?DOMElement $compra;
    protected ?DOMElement $exporta;
    protected ?DOMElement $balsa;
    protected ?DOMElement $vagao;
    protected DOMElement $ICMSTot;
    protected ?DOMElement $ISSQNTot;
    protected ?DOMElement $ISTot;
    protected ?DOMElement $IBSCBSTot;
    protected ?DOMElement $retTrib;
    protected ?DOMElement $infIntermed;
    protected ?DOMElement $agropecuarioGuia; //Não Existe na PL_010
    protected ?DOMElement $cana;
    protected ?DOMElement $infNFeSupl;
    protected array $aReboque = [];
    protected array $aVol = [];
    protected array $aLacre = [];
    protected array $aNFref = [];
    protected array $aAutXML = [];
    protected array $aProd = [];
    protected array $aGCred = [];
    protected array $aCest = [];
    protected array $aNVE = [];
    protected array $aRECOPI = [];
    protected array $aRastro = [];
    protected array $aDFeReferenciado = [];
    protected array $aVeicProd = [];
    protected array $aMed = [];
    protected array $aArma = [];
    protected array $aDI = [];
    protected array $aAdi = [];
    protected array $aDetExport = [];
    protected array $aImposto = [];
    protected array $aImpostoDevol = [];
    protected array $aISSQN = [];
    protected array $aICMS = [];
    protected array $aICMSPart = [];
    protected array $aICMSUFDest = [];
    protected array $aICMSSN = [];
    protected array $aICMSST = [];
    protected array $aIPI = [];
    protected array $aPIS = [];
    protected array $aPISST = [];
    protected array $aCOFINS = [];
    protected array $aCOFINSST = [];
    protected array $aInfAdProd = [];
    protected array $aIBSCBS = [];
    protected array $aGTribRegular = [];
    protected array $aIBSCredPres = [];
    protected array $aCBSCredPres = [];
    protected array $aGTribCompraGov = [];
    protected array $aGIBSCBSMono = [];
    protected array $aGTransfCred = [];
    protected array $aGCredPresIBSZFM = [];
    protected array $aGAjusteCompet = [];
    protected array $aGEstornoCred = [];
    protected array $aGCredPresOper = [];
    protected array $aIS = [];
    protected array $aII = [];
    protected array $aObsItem = [];
    protected array $aVItem = [];
    protected array $aVItemStruct = [];
    protected array $aDetPag = [];
    protected array $aObsCont = [];
    protected array $aObsFisco = [];
    protected array $aProcRef = [];
    protected array $aForDia = [];
    protected array $aDeduc = [];
    protected array $aComb = [];
    protected array $aEncerrante = [];
    protected array $aOrigComb = [];
    protected array $aAgropecuarioDefensivo = [];

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

        //elemento de calculo do vItem
        $this->aVItemStruct = [
            'indTot' => 0,
            'vProd' => 0,
            'vDesc' => 0,
            'vICMSST' => 0,
            'vICMSMonoReten' => 0,
            'vFCPST' => 0,
            'vFrete' => 0,
            'vSeg' => 0,
            'vOutro' => 0,
            'vII' => 0,
            'vIPI' => 0,
            'vIPIDevol' => 0,
            'vServ' => 0,
            'vPIS' => 0,
            'vCOFINS' => 0,
            'indDeduzDeson' => 0,
            'vDescDeson' => 0,
            'indSomaPISST' => 0,
            'vPISST' => 0,
            'indSomaCOFINSST' => 0,
            'vCOFINSST' => 0,
            'vIBS' => 0,
            'vCBS' => 0,
            'vIS' => 0,
            'vTotIBSMonoItem' => 0,
            'vTotCBSMonoItem' => 0,
            'vItem',
            'vItemCalculated',
        ];
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
        $this->stdTot->vPISST = 0;
        $this->stdTot->vCOFINSST = 0;
        $this->stdTot->vOutro = 0;
        $this->stdTot->vNF = 0;
        $this->stdTot->vTotTrib = 0;
        //PL_010 IBS CBS vNFTot
        $this->stdTot->vIBS = 0;
        $this->stdTot->vCBS = 0;
        $this->stdTot->vIS = 0;
        $this->stdTot->vNFTot = 0;
        $this->stdTot->vNFTotCalculated = 0;
        //ISSQN
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
        //IS
        $this->stdIStot = new stdClass();
        $this->stdIStot->vIS = 0;
        //IBSCBS
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
        $this->stdIBSCBSTot->gEstornoCred = new stdClass();
        $this->stdIBSCBSTot->gEstornoCred->vIBSEstCred = 0;
        $this->stdIBSCBSTot->gEstornoCred->vCBSEstCred = 0;
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
     * Seleciona o forma de calculo do valor de vItem e do valor de VNFTot
     * METHOD_CALCULATION_V1 = usa os valores recolhidos durante a entrada de dados
     * METHOD_CALCULATION_V1 = obtem os valores das tags já construidas dos itens
     * @param int $method
     * @return void
     */
    public function setCalculationMethod(int $method = self::METHOD_CALCULATION_V2)
    {
        $this->calculationMethod = $method;
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
            //calcula totais e vNF
            $this->buildTotalICMS();
            //cria a tag NFe
            $this->buildNFe();
            //tag NFref => tag ide
            $this->addTagRefToIde();
            //tag gCompraGov => tag ide Existe apenas a partir da PL_010
            if ($this->schema > 9) {
                $this->addTag($this->ide, $this->gCompraGov ?? null, 'Falta a tag "ide"');
                $this->addTag($this->ide, $this->gPagAntecipado ?? null, 'Falta a tag "ide"');
            }
            //tag ide => tag infNfe
            $this->addTag($this->infNFe, $this->ide ?? null, 'Falta a tag "infNFe"');
            //tag emit => tag infNfe
            $this->addTagEmit();
            //tag dest => tag infNFe
            $this->addTagDest();
            //tag retirada  => tag infNFe
            $this->addTag($this->infNFe, $this->retirada ?? null, 'Falta a tag "infNFe"');
            //tag entrega => tag infNFe
            $this->addTag($this->infNFe, $this->entrega ?? null, 'Falta a tag "infNFe"');
            //tag autXMl => tag infNFe
            $this->addTagAutXML();
            //tag det => tag infNFe
            $this->addTagDet();
            //tag total => tag infNfe
            $this->addTagTotal();

            //tag transp => tag infNfe
            $this->addTagTransp();
            //tag cobr => tag infNFe
            $this->addTag($this->infNFe, $this->cobr ?? null, 'Falta a tag "infNFe"');
            //tag pag => tag infNFe
            $this->addTagPag();
            //tag infIntermed => tag infNFe
            $this->addTag($this->infNFe, $this->infIntermed ?? null, 'Falta a tag "infNFe"');
            //tag infAdic => tag infNFe
            $this->buildInfoTags();
            $this->addTag($this->infNFe, $this->infAdic ?? null, 'Falta a tag "infNFe"');
            //tag exporta => tag infNFe
            $this->addTag($this->infNFe, $this->exporta ?? null, 'Falta a tag "infNFe"');
            //tag compra => tag infNFe
            $this->addTag($this->infNFe, $this->compra ?? null, 'Falta a tag "infNFe"');
            //tag cana => tag infNFe
            $this->addTagCana();
            //tag infRespTec => tag infNFe
            $this->addTag($this->infNFe, $this->infRespTec ?? null, 'Falta a tag "infNFe"');
            //Add tag agropecuario
            $this->addTagAgropecuario();
            //Add tag infNfe => tag NFe
            $this->addTag($this->NFe, $this->infNFe ?? null, 'Falta a tag "NFe"');
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
                    //REMOVIDO PELA NT 2025.002_v1.30 - PL_010_V1.30
                    if (!empty($this->aIBSCredPres[$item]) && !empty($gIBSCBS)) {
                        $gIBSCBS->appendChild($this->aIBSCredPres[$item]);
                    }
                    //REMOVIDO PELA NT 2025.002_v1.30 - PL_010_V1.30
                    if (!empty($this->aCBSCredPres[$item]) && !empty($gIBSCBS)) {
                        $gIBSCBS->appendChild($this->aCBSCredPres[$item]);
                    }
                    if (!empty($this->aGTribCompraGov[$item]) && !empty($gIBSCBS)) {
                        $gIBSCBS->appendChild($this->aGTribCompraGov[$item]);
                    }
                    //CHOICE gIBSCBS, gIBSCBSMono, gTranfCred, gAjusteCompet
                    //existe o grupo gIBSCBS no node IBSCBS ?
                    if (!empty($gIBSCBS)) {
                        //add gIBSCBS ao node imposto
                        $this->addTag($ibscbs, $gIBSCBS, 'Falta a tag IBSCBS!');
                    } elseif (!empty($this->aGIBSCBSMono[$item])) {
                        //não existe gIBSCBS, então add gIBSCBSMono
                        $this->addTag($ibscbs, $this->aGIBSCBSMono[$item], 'Falta a tag IBSCBS!');
                    } elseif (!empty($this->aGTransfCred[$item])) {
                        //não existe gIBSCBS, nem gIBSCBSMono então add gTransfCred
                        $this->addTag($ibscbs, $this->aGTransfCred[$item], 'Falta a tag IBSCBS!');
                    } elseif (!empty($this->aGAjusteCompet[$item])) {
                        //não existe gIBSCBS, nem gIBSCBSMono, nem gTransfCred entao add gAjusteCompet
                        $this->addTag($ibscbs, $this->aGAjusteCompet[$item], 'Falta a tag IBSCBS!');
                    }
                    //gEstornoCred
                    if (!empty($this->aGEstornoCred[$item])) {
                        $this->addTag($ibscbs, $this->aGEstornoCred[$item], 'Falta a tag IBSCBS!');
                    }
                    //gCredPresOper
                    if (!empty($this->aGCredPresOper[$item])) {
                        $this->addTag($ibscbs, $this->aGCredPresOper[$item], 'Falta a tag IBSCBS!');
                    } elseif (!empty($this->aGCredPresIBSZFM[$item])) {
                        $this->addTag($ibscbs, $this->aGCredPresIBSZFM[$item], 'Falta a tag IBSCBS!');
                    }
                    $this->addTag($imposto, $ibscbs, 'Falta a tag det/imposto!');
                }
            }
            //adiciona imposto ao node det
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
                //calcula os valores de vItem para todos os itens da NF
                if ($this->calculationMethod == self::METHOD_CALCULATION_V1) {
                    $this->calculateTtensValues1();
                } else {
                    $this->calculateTtensValues2($det);
                }
                //adiciona o vItem informado ou o calculado
                if (!empty($this->aVItem[$item]['vItem'])) {
                    $this->dom->addChild(
                        $det,
                        "vItem",
                        $this->conditionalNumberFormatting($this->aVItem[$item]['vItem']),
                        true,
                        "det nItem $item Valor Total do Item da NF-e"
                    );
                } else {
                    $this->dom->addChild(
                        $det,
                        "vItem",
                        $this->conditionalNumberFormatting($this->aVItem[$item]['vItemCalculated']),
                        true,
                        "det nItem $item Valor Total do Item da NF-e"
                    );
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
    protected function buildTotalICMS()
    {
        //round all values
        $this->stdTot->vBC = round($this->stdTot->vBC, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vICMS = round($this->stdTot->vICMS, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vICMSDeson = round($this->stdTot->vICMSDeson, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vFCP = round($this->stdTot->vFCP, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vFCPUFDest = round($this->stdTot->vFCPUFDest, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vICMSUFDest = round($this->stdTot->vICMSUFDest, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vICMSUFRemet = round($this->stdTot->vICMSUFRemet, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vBCST = round($this->stdTot->vBCST, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vST = round($this->stdTot->vST, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vFCPST = round($this->stdTot->vFCPST, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vFCPSTRet = round($this->stdTot->vFCPSTRet, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vProd = round($this->stdTot->vProd, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vFrete = round($this->stdTot->vFrete, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vSeg = round($this->stdTot->vSeg, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vDesc = round($this->stdTot->vDesc, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vII = round($this->stdTot->vII, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vIPI = round($this->stdTot->vIPI, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vIPIDevol = round($this->stdTot->vIPIDevol, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vPIS = round($this->stdTot->vPIS, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vCOFINS = round($this->stdTot->vCOFINS, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vOutro = round($this->stdTot->vOutro, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vNF = round($this->stdTot->vNF, 2, PHP_ROUND_HALF_UP);
        $this->stdTot->vTotTrib = round($this->stdTot->vTotTrib, 2, PHP_ROUND_HALF_UP);

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
        $enddest = !empty($this->dest->getElementsByTagName('enderDest')->item(0))
            ? $this->dest->getElementsByTagName('enderDest')->item(0)
            : null;
        if (is_null($enddest) && !empty($this->enderDest)) {
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
        $this->addTag($this->transp, $this->transporta ?? null);
        $this->addTag($this->transp, $this->retTransp ?? null);
        $this->addTag($this->transp, $this->veicTransp ?? null);
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
        $this->addTag($total, $this->ISSQNTot ?? null);
        //Grupo Retenções de Tributos
        if (!empty($this->retTrib)) {
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
                $vNFTotRecalculated = $this->reCalculateNFTotValue();
                //add vNFTot informado ou calculado
                if (!empty($this->stdTot->vNFTot)) {
                    $this->dom->addChild(
                        $total,
                        "vNFTot",
                        $this->conditionalNumberFormatting($this->stdTot->vNFTot, 2),
                        false,
                        "$identificador Valor total da NF-e com IBS / CBS / IS"
                    );
                } elseif (!empty($vNFTotRecalculated)) {
                    $this->dom->addChild(
                        $total,
                        "vNFTot",
                        $this->conditionalNumberFormatting($vNFTotRecalculated, 2),
                        false,
                        "$identificador Valor total da NF-e com IBS / CBS / IS"
                    );
                } else {
                    $this->errors[] = "tag total - O valor de vNFTot não pode ser ZERO.";
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
