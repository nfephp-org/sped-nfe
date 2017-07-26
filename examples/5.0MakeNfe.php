<?php

namespace App\Helpers\Fiscal;


use App\Helpers\HeaderFunctions;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapCurl;
use NFePHP\NFe\Make;

class Nfe
{

    private $environment = 2; //1 - producao | 2 - homologaçao
    private $modelo = 55;
    private $nfe;
    private $error;
    private $response;
    private $config;
    private $version = '4.00';
    private $certificado;
    private $senhaCertificado;
    private $auth;
    private $unidadeModel;
    private $ide;
    private $ref;
    private $emit;
    private $dest;
    private $produtos;
    private $total;
    private $transportador;
    private $faturamento;


    protected $cUFlist = array(
        'AC'=>'12',
        'AL'=>'27',
        'AM'=>'13',
        'AN'=>'91',
        'AP'=>'16',
        'BA'=>'29',
        'CE'=>'23',
        'DF'=>'53',
        'ES'=>'32',
        'GO'=>'52',
        'MA'=>'21',
        'MG'=>'31',
        'MS'=>'50',
        'MT'=>'51',
        'PA'=>'15',
        'PB'=>'25',
        'PE'=>'26',
        'PI'=>'22',
        'PR'=>'41',
        'RJ'=>'33',
        'RN'=>'24',
        'RO'=>'11',
        'RR'=>'14',
        'RS'=>'43',
        'SC'=>'42',
        'SE'=>'28',
        'SP'=>'35',
        'TO'=>'17',
        'SVAN' => '91'
    );

    /**
     * @return mixed
     */
    public function getCertificado()
    {
        return $this->certificado;
    }

    /**
     * @param mixed $certificado
     */
    public function setCertificado($certificado)
    {
        $this->certificado = $certificado;
    }

    /**
     * @return mixed
     */
    public function getSenhaCertificado()
    {
        return $this->senhaCertificado;
    }

    /**
     * @param mixed $senhaCertificado
     */
    public function setSenhaCertificado($senhaCertificado)
    {
        $this->senhaCertificado = $senhaCertificado;
    }

    /**
     * @return int
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param int $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return int
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param int $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @return mixed
     */
    public function getNfe()
    {
        return $this->nfe;
    }

    /**
     * @param mixed $nfe
     */
    public function setNfe($nfe)
    {
        $this->nfe = $nfe;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param mixed $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function getUnidadeModel()
    {
        return $this->unidadeModel;
    }

    /**
     * @param mixed $unidadeModel
     */
    public function setUnidadeModel($unidadeModel)
    {
        $this->unidadeModel = $unidadeModel;
    }

    /**
     * @return mixed
     */
    public function getIde()
    {
        return $this->ide;
    }

    /**
     * @param mixed $ide
     */
    public function setIde($ide)
    {
        $this->ide = $ide;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param mixed $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return mixed
     */
    public function getEmit()
    {
        return $this->emit;
    }

    /**
     * @param mixed $emit
     */
    public function setEmit($emit)
    {
        $this->emit = $emit;
    }

    /**
     * @return mixed
     */
    public function getDest()
    {
        return $this->dest;
    }

    /**
     * @param mixed $dest
     */
    public function setDest($dest)
    {
        $this->dest = $dest;
    }

    /**
     * @return mixed
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * @param mixed $produtos
     */
    public function setProdutos($produtos)
    {
        $this->produtos = $produtos;
    }

    public function addProdutos($produtos)
    {
        $this->produtos[] = $produtos;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getTransportador()
    {
        return $this->transportador;
    }

    /**
     * @param mixed $transportador
     */
    public function setTransportador($transportador)
    {
        $this->transportador = $transportador;
    }

    /**
     * @return mixed
     */
    public function getFaturamento()
    {
        return $this->faturamento;
    }

    /**
     * @param mixed $faturamento
     */
    public function setFaturamento($faturamento)
    {
        $this->faturamento = $faturamento;
    }


    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        $this->auth = new \App\Services\Auth;
        $this->auth = $this->auth->getIdentity();

//        $unidadeNegocio = \App\Models\UnidadeNegocio::findFirstByCdUnidade($this->auth['unidade']);
        $unidadeNegocio = \App\Models\UnidadeNegocio::findFirstByCdUnidade(246);

        if (!$unidadeNegocio) {
            $this->error[] = 'Unidade de negocio não foi encontrada para gerar a configuração da nota fiscal';
            return false;
        }

        $this->setCertificado($unidadeNegocio->getCertificado());
        $this->setSenhaCertificado($unidadeNegocio->getSenhaCert());

        $this->setUnidadeModel($unidadeNegocio);


        switch ($_SERVER['SERVER_NAME']) {
            case 'localhost':
            case '127.0.0.1':
            case 'pdvfiber':
            case 'fiber':
            case 'dev.solinter.com.br':
            case 'dev.piscinafiber.com.br':
                $this->setEnvironment(2);
                break;
            default:
                $this->setEnvironment(2);
//                $this->setEnvironment(1);
                break;
        }
    }

    public function makeConfig()
    {

        $config = [
            "atualizacao" => date('Y-m-d H:i:s'),
            "tpAmb" => $this->getEnvironment(),
            "razaosocial" => $this->getUnidadeModel()->descricao,
            "siglaUF" => $this->getUnidadeModel()->Empresa->Endereco[0]->Uf->getSigla(),
            "cnpj" => $this->getUnidadeModel()->Empresa->getCpfCnpjSomenteNumeros(),
            "schemes" => "PL_009_V4",
            "versao" => $this->getVersion(),
            "tokenIBPT" => "",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G", //nao existe o campo ainda
            "CSCid" => "000002", // nao existe o id ainda
            "aProxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]
        ];

        return json_encode($config);
    }


    public function gerarXmlNfe($nfe)
    {
        $nfePhp = Make::v400();

        $dataChave = \DateTime::createFromFormat('Y-m-d', $nfe->getIde()->getDhEmi());

        $config = \json_decode($nfe->getConfig());

        $chave = \App\Helpers\Fiscal\NfeCommon::montaChave(
            $nfe->getIde()->getCUf(),
            date('y', strtotime($nfe->getIde()->getDhEmi())),
            date('m', strtotime($nfe->getIde()->getDhEmi())),
            $nfe->getEmit()->getCnpj(),
            $nfe->getIde()->getMod(),
            $nfe->getIde()->getSerie(),
            $nfe->getIde()->getNNf(),
            $nfe->getIde()->getTpEmis(),
            $nfe->getIde()->getCNf()
        );

        $resp = $nfePhp->taginfNFe($chave, '4.00');
        $cDV = substr($chave, -1);

        $resp = $nfePhp->tagide(
            $nfe->getIde()->getCUf(),
            $nfe->getIde()->getCNf(),
            $nfe->getIde()->getNatOp(),
            $nfe->getIde()->getIndPag(),
            $nfe->getIde()->getMod(),
            $nfe->getIde()->getSerie(),
            $nfe->getIde()->getNNf(),
            $nfe->getIde()->getDhEmi(),
            $nfe->getIde()->getDhSaiEnt(),
            $nfe->getIde()->getTpEmis(),
            $nfe->getIde()->getIdDest(),
            $nfe->getIde()->getCMunFg(),
            $nfe->getIde()->getTpImp(),
            $nfe->getIde()->getTpEmis(),
            $nfe->getIde()->getCDv(),
            $nfe->getIde()->getTpAmb(),
            $nfe->getIde()->getFinNFe(),
            $nfe->getIde()->getIndFinal(),
            $nfe->getIde()->getIndPres(),
            $nfe->getIde()->getProcEmi(),
            $nfe->getIde()->getVerProc(),
            $nfe->getIde()->getDhCont(),
            $nfe->getIde()->getXJust()
        );

        $resp = $nfePhp->tagemit(
            $nfe->getEmit()->getCnpj(),
            $nfe->getEmit()->getCpf(),
            $nfe->getEmit()->getXNome(),
            $nfe->getEmit()->getXFant(),
            $nfe->getEmit()->getIe(),
            $nfe->getEmit()->getIest(),
            $nfe->getEmit()->getIm(),
            $nfe->getEmit()->getCnae(),
            $nfe->getEmit()->getCrt()
        );

        $resp = $nfePhp->tagenderEmit(
            $nfe->getEmit()->getXLgr(),
            $nfe->getEmit()->getNro(),
            $nfe->getEmit()->getXCpl(),
            $nfe->getEmit()->getXBairro(),
            $nfe->getEmit()->getCMun(),
            $nfe->getEmit()->getXMun(),
            $nfe->getEmit()->getUf(),
            $nfe->getEmit()->getCep(),
            $nfe->getEmit()->getCPais(),
            $nfe->getEmit()->getXPais(),
            $nfe->getEmit()->getFone()
        );

        $resp = $nfePhp->tagdest(
            $nfe->getDest()->getCnpj(),
            $nfe->getDest()->getCpf(),
            $nfe->getDest()->getIdEstrangeiro(),
            $nfe->getDest()->getXNome(),
            $nfe->getDest()->getIndIeDest(),
            $nfe->getDest()->getIe(),
            $nfe->getDest()->getIsuf(),
            $nfe->getDest()->getIm(),
            $nfe->getDest()->getEmail()
        );

        $resp = $nfePhp->tagenderDest(
            $nfe->getDest()->getXLgr(),
            $nfe->getDest()->getNro(),
            $nfe->getDest()->getXCpl(),
            $nfe->getDest()->getXBairro(),
            $nfe->getDest()->getCMun(),
            $nfe->getDest()->getXMun(),
            $nfe->getDest()->getUf(),
            $nfe->getDest()->getCep(),
            $nfe->getDest()->getCPais(),
            $nfe->getDest()->getXPais(),
            $nfe->getDest()->getFone()
        );

        foreach ($nfe->getProdutos() as $produto) {
            $resp = $nfePhp->tagprod(
                $produto->getNItem(),
                $produto->getCProd(),
                $produto->getCEAN(),
                $produto->getXProd(),
                $produto->getNcm(),
                $produto->getCBenef(),
                $produto->getExtipi(),
                $produto->getCfop(),
                $produto->getUCom(),
                $produto->getQCom(),
                $produto->getVUnCom(),
                $produto->getVProd(),
                $produto->getCEanTrib(),
                $produto->getUTrib(),
                $produto->getQTrib(),
                $produto->getVUnTrib(),
                $produto->getVFrete(),
                $produto->getVSeg(),
                $produto->getVDesc(),
                $produto->getVOutro(),
                $produto->getIndTot(),
                $produto->getXPed(),
                $produto->getNItemPed(),
                $produto->getNFci()
            );
            if ($produto->getCest()) {
                $nfePhp->tagCEST($produto->getNItem(), $produto->getCest());
            }
            $nfePhp->taginfAdProd($produto->getNItem(), $produto->getInfAdProd());
            $resp = $nfePhp->tagimposto(
                $produto->getNItem(),
                $produto->getIcms()->getVICMS() +
                $produto->getIcms()->getVICMSST() +
                $produto->getIpi()->getVIPI() +
                $produto->getPis()->getVPIS() +
                $produto->getCofins()->getVCOFINS()
            );

            switch (get_class($produto->getIcms())) {
                case 'App\Helpers\Fiscal\Icms\NfeIcmsSn':
                    $resp = $nfePhp->tagICMSSN(
                        $produto->getIcms()->getNItem(),
                        $produto->getIcms()->getOrig(),
                        $produto->getIcms()->getCsosn(),
                        $produto->getIcms()->getModBC(),
                        $produto->getIcms()->getVBC(),
                        $produto->getIcms()->getPRedBC(),
                        $produto->getIcms()->getPICMS(),
                        $produto->getIcms()->getVICMS(),
                        $produto->getIcms()->getPCredSN(),
                        $produto->getIcms()->getVCredICMSSN(),
                        $produto->getIcms()->getModBCST(),
                        $produto->getIcms()->getPMVAST(),
                        $produto->getIcms()->getPRedBCST(),
                        $produto->getIcms()->getVBCST(),
                        $produto->getIcms()->getPICMSST(),
                        $produto->getIcms()->getVICMSST(),
                        $produto->getIcms()->getVBCSTRet(),
                        $produto->getIcms()->getVICMSSTRet()
                    );
                    break;
                default:
                    $resp = $nfePhp->tagICMS(
                        $produto->getIcms()->getNItem(),
                        $produto->getIcms()->getOrig(),
                        $produto->getIcms()->getCst(),
                        $produto->getIcms()->getModBC(),
                        $produto->getIcms()->getPRedBC(),
                        $produto->getIcms()->getVBC(),
                        $produto->getIcms()->getPICMS(),
                        $produto->getIcms()->getVICMSDeson(),
                        $produto->getIcms()->getMotDesICMS(),
                        $produto->getIcms()->getModBCST(),
                        $produto->getIcms()->getPMVAST(),
                        $produto->getIcms()->getPRedBCST(),
                        $produto->getIcms()->getVBCST(),
                        $produto->getIcms()->getPICMSST(),
                        $produto->getIcms()->getVICMSST(),
                        $produto->getIcms()->getPDif(),
                        $produto->getIcms()->getVICMSDif(),
                        $produto->getIcms()->getVICMSOp(),
                        $produto->getIcms()->getVBCSTRet(),
                        $produto->getIcms()->getVICMSSTRet()
                    );
                    break;
            }

            if ($produto->getIpi()->getCst()) {
                $resp = $nfePhp->tagIPI(
                    $produto->getIpi()->getNItem(),
                    $produto->getIpi()->getCst(),
                    $produto->getIpi()->getClEnq(),
                    $produto->getIpi()->getCnpjProd(),
                    $produto->getIpi()->getCSelo(),
                    $produto->getIpi()->getQSelo(),
                    $produto->getIpi()->getCEnq(),
                    $produto->getIpi()->getVBC(),
                    $produto->getIpi()->getPIPI(),
                    $produto->getIpi()->getQUnid(),
                    $produto->getIpi()->getVUnid(),
                    $produto->getIpi()->getVIPI()
                );
            }


            $resp = $nfePhp->tagPIS(
                $produto->getPis()->getNItem(),
                $produto->getPis()->getCst(),
                $produto->getPis()->getVBC(),
                $produto->getPis()->getPPIS(),
                $produto->getPis()->getVPIS(),
                $produto->getPis()->getQBCProd(),
                $produto->getPis()->getVAliqProd()
            );

            $resp = $nfePhp->tagCOFINS(
                $produto->getCofins()->getNItem(),
                $produto->getCofins()->getCst(),
                $produto->getCofins()->getVBC(),
                $produto->getCofins()->getPCOFINS(),
                $produto->getCofins()->getVCOFINS(),
                $produto->getCofins()->getQBCProd(),
                $produto->getCofins()->getVAliqProd()
            );

        }

        $resp = $nfePhp->tagICMSTot(
            $nfe->getTotal()->getVBC(),
            $nfe->getTotal()->getVICMS(),
            $nfe->getTotal()->getVICMSDeson(),
            $nfe->getTotal()->getVFCP(),
            $nfe->getTotal()->getVBCST(),
            $nfe->getTotal()->getVST(),
            $nfe->getTotal()->getVFCPST(),
            $nfe->getTotal()->getVFCPSTRet(),
            $nfe->getTotal()->getVProd(),
            $nfe->getTotal()->getVFrete(),
            $nfe->getTotal()->getVSeg(),
            $nfe->getTotal()->getVDesc(),
            $nfe->getTotal()->getVII(),
            $nfe->getTotal()->getVIPI(),
            $nfe->getTotal()->getVIPIDevol(),
            $nfe->getTotal()->getVPIS(),
            $nfe->getTotal()->getVCOFINS(),
            $nfe->getTotal()->getVOutro(),
            $nfe->getTotal()->getVNF(),
            $nfe->getTotal()->getVTotTrib()
        );

        $resp = $nfePhp->tagtransp(
            $nfe->getTransportador()->getModFrete()
        );

        if ($nfe->getTransportador()->getModFrete() != 9) {
            $resp = $nfePhp->tagtransporta(
                $nfe->getTransportador()->getCnpj(),
                $nfe->getTransportador()->getCpf(),
                $nfe->getTransportador()->getXNome(),
                $nfe->getTransportador()->getIe(),
                $nfe->getTransportador()->getXEnder(),
                $nfe->getTransportador()->getXMun(),
                $nfe->getTransportador()->getUF()
            );

            if (
                !empty($nfe->getTransportador()->getPlaca()) &&
                !empty($nfe->getTransportador()->getPlacaUf())
            ) {
                $resp = $nfePhp->tagveicTransp(
                    $nfe->getTransportador()->getPlaca(),
                    $nfe->getTransportador()->getPlacaUf(),
                    $nfe->getTransportador()->getRNTC()
                );
            }

            if (count($nfe->getTransportador()->getReboque())) {
                foreach ($nfe->getTransportador()->getReboque() as $reboque){
                    if (
                        !empty($reboque->getPlaca()) &&
                        !empty($reboque->getUF())
                    ) {
                        $resp = $nfePhp->tagreboque(
                            $reboque->getPlaca(),
                            $reboque->getUF(),
                            $reboque->getRNTC(),
                            $reboque->getVagao(),
                            $reboque->getBalsa()
                        );
                    }
                }
            }

            if (count($nfe->getTransportador()->getVolume())) {
                foreach ($nfe->getTransportador()->getVolume() as $volume){
                    if (
                        !empty($volume->getQVolume()) &&
                        !empty($volume->getEspecie()) &&
                        !empty($volume->getMarca())
                    ){
                        $nfePhp->tagvol(
                            $volume->getQVolume(),
                            $volume->getEspecie(),
                            $volume->getMarca(),
                            $volume->getNVolume(),
                            $volume->getPesoL(),
                            $volume->getPesoB(),
                            $volume->getALacre()
                        );
                    }
                }
            }
        }

        $resp = $nfePhp->tagfat(
            $nfe->getFaturamento()->getNFatura(),
            $nfe->getFaturamento()->getVOriginal(),
            $nfe->getFaturamento()->getVDesc(),
            $nfe->getFaturamento()->getVLiquido()
        );

        if (count($nfe->getFaturamento()->getDuplicata())) {
            foreach($nfe->getFaturamento()->getDuplicata() as $duplicata) {
                $resp = $nfePhp->tagdup(
                    $duplicata->getCDuplicata(),
                    $duplicata->getDVencimento(),
                    $duplicata->getVDuplicata()
                );
            }

        }

        $resp = $nfePhp->taginfAdic('', 'teste');

        $resp = $nfePhp->montaNFe();
        if ($resp) {
            $xml = $nfePhp->getXML();
            return $xml;
        }
        return $resp;
    }

    public function enviarNfe($xml)
    {
        $certificado = file_get_contents(NFE_PATH_CERTS_ARQUIVOS.$this->getCertificado());

        $tools = new Tools($this->config, Certificate::readPfx($certificado, $this->getSenhaCertificado()));
        $tools->model('55');
        $tools->version('4.00');
        $xml = $tools->signNFe($xml);
        print_r($xml);

    }

}
