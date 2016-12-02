<?php

namespace NFePHP\NFe\Common;

use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapInterface;
use NFePHP\Common\Signer;
use NFePHP\Common\Validator;
use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Factories\Header;
use NFePHP\Common\Soap\SoapCurl;

class Tools
{
    /**
     * config class
     * @var \stdClass
     */
    public $config;
    /**
     * Path to config folder
     * @var string
     */
    public $pathconfig = '';
    /**
     * Path to schemes folder
     * @var string
     */
    public $pathschemes = '';
    /**
     * ambiente
     * @var string
     */
    public $ambiente = 'homologacao';
    /**
     * Environment
     * @var int
     */
    public $tpAmb = 2;
    /**
     * contingency class
     * @var Contingency
     */
    public $contingency;
    /**
     * soap class
     * @var SoapInterface
     */
    public $soap;
    /**
     * certificate class
     * @var Certificate
     */
    protected $certificate;
    /**
     * Sign algorithm from OPENSSL
     * @var int
     */
    protected $algorithm = OPENSSL_ALGO_SHA1;
    /**
     * Model of NFe 55 or 65
     * @var int
     */
    protected $modelo = 55;
    /**
     * Version of layout
     * @var string
     */
    protected $versao = '3.10';
    /**
     * urlPortal
     * Instância do WebService
     *
     * @var string
     */
    protected $urlPortal = 'http://www.portalfiscal.inf.br/nfe';
    /**
     * cUFlist
     * @var array
     */
    protected $cUFlist = [
        'AC'=>12,
        'AL'=>27,
        'AM'=>13,
        'AN'=>91,
        'AP'=>16,
        'BA'=>29,
        'CE'=>23,
        'DF'=>53,
        'ES'=>32,
        'GO'=>52,
        'MA'=>21,
        'MG'=>31,
        'MS'=>50,
        'MT'=>51,
        'PA'=>15,
        'PB'=>25,
        'PE'=>26,
        'PI'=>22,
        'PR'=>41,
        'RJ'=>33,
        'RN'=>24,
        'RO'=>11,
        'RR'=>14,
        'RS'=>43,
        'SC'=>42,
        'SE'=>28,
        'SP'=>35,
        'TO'=>17,
        'SVAN' => 91
    ];
    /**
     * urlcUF
     * @var string
     */
    protected $urlcUF = '';
    /**
     * urlVersion
     * @var string
     */
    protected $urlVersion = '';
    /**
     * urlService
     * @var string
     */
    protected $urlService = '';
    /**
     * @var string
     */
    protected $urlMethod = '';
    /**
     * @var string
     */
    protected $urlOperation = '';
    /**
     * @var string
     */
    protected $urlNamespace = '';
    /**
     * @var string
     */
    protected $urlAction = '';
    /**
     * @var \SOAPHeader
     */
    protected $objHeader;
    /**
     * @var string
     */
    protected $urlHeader = '';
    /**
     * @var array
     */
    protected $soapnamespaces = [
        'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance",
        'xmlns:xsd' => "http://www.w3.org/2001/XMLSchema",
        'xmlns:soap' => "http://www.w3.org/2003/05/soap-envelope"
    ];


    /**
     * Constructor
     * load configurations,
     * load Digital Certificate,
     * map all paths,
     * set timezone and
     * check if is in contingency
     * @param string $configJson content of config in json format
     * @param Certificate $certificate
     */
    public function __construct($configJson, Certificate $certificate)
    {
        $this->config = json_decode($configJson);
        $this->pathconfig = __DIR__ .
            DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
            'config' .
            DIRECTORY_SEPARATOR;
        $this->pathschemes = __DIR__ .
            DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
            'schemes' .
            DIRECTORY_SEPARATOR .
            $this->config->schemes .
            DIRECTORY_SEPARATOR;
        $this->version($this->config->versao);
        $this->setEnvironmentTimeZone($this->config->uf);
        $this->certificate = $certificate;
        $this->setEnvironment($this->config->ambiente);
        $this->contingency = new Contingency();
        $this->soap = new SoapCurl($certificate);
    }
    
    /**
     * Sets environment time zone
     * @param string $acronym (ou seja a sigla do estado)
     * @return void
     */
    public function setEnvironmentTimeZone($acronym)
    {
        $tz = [
            'AC'=>'America/Rio_Branco',
            'AL'=>'America/Maceio',
            'AM'=>'America/Manaus',
            'AP'=>'America/Belem',
            'BA'=>'America/Bahia',
            'CE'=>'America/Fortaleza',
            'DF'=>'America/Sao_Paulo',
            'ES'=>'America/Sao_Paulo',
            'GO'=>'America/Sao_Paulo',
            'MA'=>'America/Fortaleza',
            'MG'=>'America/Sao_Paulo',
            'MS'=>'America/Campo_Grande',
            'MT'=>'America/Cuiaba',
            'PA'=>'America/Belem',
            'PB'=>'America/Fortaleza',
            'PE'=>'America/Recife',
            'PI'=>'America/Fortaleza',
            'PR'=>'America/Sao_Paulo',
            'RJ'=>'America/Sao_Paulo',
            'RN'=>'America/Fortaleza',
            'RO'=>'America/Porto_Velho',
            'RR'=>'America/Boa_Vista',
            'RS'=>'America/Sao_Paulo',
            'SC'=>'America/Sao_Paulo',
            'SE'=>'America/Maceio',
            'SP'=>'America/Sao_Paulo',
            'TO'=>'America/Araguaina'
        ];
        date_default_timezone_set($tz[$acronym]);
    }

    /**
     * Alter environment from "homologacao" to "producao" and vice-versa
     * @param int $tpAmb
     * @return void
     */
    protected function setEnvironment($tpAmb = 2)
    {
        $this->tpAmb = $tpAmb;
        $this->ambiente = 'homologacao';
        if ($tpAmb == 1) {
            $this->ambiente = 'producao';
        }
    }
    
    /**
     * Load Soap Class
     * Soap Class may be \NFePHP\Common\Soap\SoapNative or \NFePHP\Common\Soap\SoapCurl
     * @param SoapInterface $soap
     * @return void
     */
    public function loadSoapClass(SoapInterface $soap)
    {
        $this->soap = $soap;
        $this->soap->loadCertificate($this->certificate);
    }
    
    /**
     * Set OPENSSL Algorithm using OPENSSL constants
     * @param int $algorithm
     * @return void
     */
    public function setSignAlgorithm($algorithm = OPENSSL_ALGO_SHA1)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Set or get model of document NFe = 55 or NFCe = 65
     * @param int $model
     * @return int modelo class parameter
     */
    public function model($model = null)
    {
        if ($model == 55 || $model == 65) {
            $this->modelo = $model;
        }
        return $this->modelo;
    }
    
    /**
     * Set or get teh parameter versao do layout
     * NOTE: for new layout this will be removed because it is no longer necessary
     * @param string $version
     * @return string
     */
    public function version($version = '')
    {
        if (!empty($version)) {
            $this->versao = $version;
        }
        return $this->versao;
    }
    
    /**
     * Recover cUF number from
     * @param string $acronym Sigal do estado
     * @return int number cUF
     */
    public function getcUF($acronym)
    {
        return $this->cUFlist[$acronym];
    }
    
    /**
     * Recover Federation unit acronym by cUF number
     * @param int $cUF
     * @return string acronym sigla
     */
    public function getAcronym($cUF)
    {
        return array_search($cUF, $this->cUFlist);
    }
    
    /**
     * Sign NFe or NFCe
     * @param  string  $xml NFe xml content
     * @return string singed NFe xml
     * @throws \RuntimeException
     */
    public function signNFe($xml)
    {
        try {
            $xml = preg_replace('/>\s+</', '><', $xml);
            $signed = Signer::sign($this->certificate, $xml, 'infNFe', 'Id', $this->algorithm, [false,false,null,null]);
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = false;
            $dom->loadXML($signed);
            $modelo = $dom->getElementsByTagName('mod')->item(0)->nodeValue;
            if ($modelo == 65) {
                $signed = $this->addQRCode($dom);
            }
            $this->isValid($this->urlVersion, $signed, 'nfe');
        } catch (NFePHP\Common\Exception\SignerException $e) {
            throw new \RuntimeException($e->getMessage);
        } catch (\InvalidArgumentException $e) {
            throw new \RuntimeException($e->getMessage);
        }
        return $signed;
    }

    /**
     * Performs xml validation with its respective XSD structure definition document
     * @param string $version
     * @param type $body
     * @param type $method
     * @return type
     * @throws \InvalidArgumentException
     */
    protected function isValid($version, $body, $method)
    {
        $schema = $this->pathschemes.$method."_v$version.xsd";
        if (!is_file($schema)) {
            throw new \InvalidArgumentException("XSD file not found. [$schema]");
        }
        return Validator::isValid(
            $body,
            $schema
        );
    }
    
    /**
     * Assembles all the necessary parameters for soap communication
     * @param string $service
     * @param string $uf
     * @param string $tpAmb
     * @return void
     */
    protected function servico(
        $service,
        $uf,
        $tpAmb
    ) {
        $ambiente = $tpAmb == 1 ? "producao" : "homologacao";
        $webs = new Webservices($this->getXmlUrlPath());
        $sigla = $uf;
        $cont = $this->contingency->type();
        if (!empty($cont)) {
            $sigla = $cont;
        }
        $stdServ = $webs->get($sigla, $ambiente, $this->modelo);
        if ($stdServ === false) {
            throw \RuntimeException('Não foram localizados serviços para essa unidade.');
        }
        if (empty($stdServ->$service->url)) {
            throw \RuntimeException('Esse serviço não é disponibilizado para essa unidade da federação.');
        }
        //recuperação do cUF
        $this->urlcUF = $this->getcUF($uf);
        //recuperação da versão
        $this->urlVersion = $stdServ->$service->version;
        //recuperação da url do serviço
        $this->urlService = $stdServ->$service->url;
        //recuperação do método
        $this->urlMethod = $stdServ->$service->method;
        //recuperação da operação
        $this->urlOperation = $stdServ->$service->operation;
        //montagem do namespace do serviço
        $this->urlNamespace = sprintf("%s/wsdl/%s", $this->urlPortal, $this->urlOperation);
        //montagem do cabeçalho da comunicação SOAP
        $this->urlHeader = Header::get($this->urlNamespace, $this->urlcUF, $this->urlVersion);
        //montagem do SOAP Header
        $this->objHeader = new \SOAPHeader(
            $this->urlNamespace,
            'nfeCabecMsg',
            ['cUF' => $this->urlcUF, 'versaoDados' => $this->urlVersion]
        );
        $this->urlAction = "\"" . $this->urlNamespace . "/" . $this->urlMethod . "\"";
    }
    
    /**
     * Send request message to webservice
     * @param string $request
     * @return string
     */
    protected function sendRequest($request)
    {
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return (string) $this->soap->send(
            $this->urlService,
            $this->urlMethod,
            $this->urlAction,
            SOAP_1_2,
            $parameters,
            $this->soapnamespaces,
            $body,
            $this->objHeader
        );
    }
    
    /**
     * Recover path to xml data base with list of soap services
     * @return string
     */
    protected function getXmlUrlPath()
    {
        $file = "wsnfe_".$this->versao."_mod55.xml";
        if ($this->modelo == 65) {
            $file = str_replace('55', '65', $file);
        }
        return $this->pathconfig . DIRECTORY_SEPARATOR . $file;
    }
    
    /**
     * Add QRCode Tag to signed XML from a NFCe
     * @param \DOMDocument $dom
     * @return string
     */
    protected function addQRCode(\DOMDocument $dom)
    {
        $memmod = $this->modelo;
        $this->modelo = 65;
        $uf = $this->getSigla($dom->getElementsByTagName('cUF')->item(0)->nodeValue);
        $this->servico(
            'NfeConsultaQR',
            $uf,
            $dom->getElementsByTagName('tpAmb')->item(0)->nodeValue
        );
        $signed = QRCode::putQRTag(
            $dom,
            $this->config->tokenNFCe,
            $this->config->tokenNFCeId,
            $uf,
            $this->urlVersion,
            $this->urlService
        );
        $this->modelo = $memmod;
        return $signed;
    }
}
