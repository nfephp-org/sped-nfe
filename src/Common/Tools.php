<?php

namespace NFePHP\NFe\Common;

use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapInterface;
use NFePHP\Common\Signer;
use NFePHP\Common\Validator;
use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Factories\Header;

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
     * Aplicative version
     * @var string
     */
    public $verAplic;
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
     * urlPortal
     * Instância do WebService
     * @var string
     */
    protected $urlPortal = '';
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
     * urlMethod
     * @var string
     */
    protected $urlMethod = '';
    /**
     * urlOperation
     * @var string
     */
    protected $urlOperation = '';
    /**
     * urlNamespace
     * @var string
     */
    protected $urlNamespace = '';
    /**
     * urlHeader
     * @var string
     */
    protected $urlHeader = '';
    
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
            'config' .
            DIRECTORY_SEPARATOR;
        $this->pathschemes = __DIR__ .
            DIRECTORY_SEPARATOR .
            'schemes' .
            DIRECTORY_SEPARATOR .
            $this->config->schemesNFe .
            DIRECTORY_SEPARATOR;
        $this->setEnvironmentTimeZone($this->config->siglaUF);
        $this->certificate = $certificate;
        $this->setAmbiente($this->config->tpAmb);
        $this->contingency = new Contingency();
    }
    
    /**
     * Sets environment time zone
     * @param string $sigla
     */
    public function setEnvironmentTimeZone($sigla)
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
        date_default_timezone_set($tz[$sigla]);
    }

    /**
     * Alter environment from "homologacao" to "producao" and vice-versa
     * @param int $tpAmb
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
     * ativaContingencia
     * Ativa a contingencia SVCAN ou SVCRS conforme a
     * sigla do estado ou EPEC
     * @param  string $sigla
     * @param  string $motivo
     * @return string json string with contingency data
     */
    public function ativaContingencia($sigla, $motivo)
    {
        $this->contingency->activate($sigla, $motivo);
        return (string) "{$this->contingency}";
    }
    
    /**
     * desativaContingencia
     * Desliga opção de contingência
     * @return boolean
     */
    public function desativaContingencia()
    {
        $this->contingency->deativate();
        return true;
    }
      
    /**
     * Load Soap Class
     * Soap Class may be \NFePHP\Common\Soap\SoapNative or \NFePHP\Common\Soap\SoapCurl
     * @param SoapInterface $soap
     */
    public function setSoapClass(SoapInterface $soap)
    {
        $this->soap = $soap;
        $this->soap->loadCertificate($this->certificate);
    }
    
    /**
     * Set OPENSSL Algorithm using OPENSSL constants
     * @param int $algorithm
     */
    public function setSignAlgorithm($algorithm = OPENSSL_ALGO_SHA1)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * setModel
     * Set model of documento to 55 or 65
     * @param int $model
     */
    public function setModel($model)
    {
        if ($model != 55 && $model != 65) {
            $model = 55;
        }
        $this->modelo = $model;
    }
    
    /**
     * getModel
     * Return documento model
     * @return int
     */
    public function getModelo()
    {
        return $this->modelo;
    }
    
    /**
     * Executa a validação da mensagem XML com base no XSD
     * @param string $versao versão dos schemas
     * @param string $body corpo do XML a ser validado
     * @param string $method Denominação do método
     * @param string $suffix Alguns xsd possuem sulfixos
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function validar($versao, $body, $method = '', $suffix = 'v')
    {
        $ver = str_pad($versao, 2, '0', STR_PAD_LEFT);
        $path = $this->pathschemes . DIRECTORY_SEPARATOR . $this->config->schemesNFe;
        $schema = $path . DIRECTORY_SEPARATOR . $method . ".xsd";
        if ($suffix) {
            $schema = $path . DIRECTORY_SEPARATOR . $method . "_v$ver.xsd";
        }
        if (!is_file($schema)) {
            throw new \InvalidArgumentException("XSD file not found. [$schema]");
        }
        return Validator::isValid(
            $body,
            $schema
        );
    }
    
    /**
     * setVerAplic
     * @param string $versao
     */
    public function setVerAplic($versao)
    {
        $this->verAplic = $versao;
    }
     
    /**
     * getcUF
     * @param string $sigla
     * @return int number cUF
     */
    public function getcUF($sigla)
    {
        return $this->cUFlist[$sigla];
    }
    
    /**
     * getSigla
     * @param int $cUF
     * @return string UF sigla
     */
    public function getSigla($cUF)
    {
        return array_search($cUF, $this->cUFlist);
    }
    
    /**
     * servico
     * Monta o namespace e o cabecalho da comunicação SOAP
     * @param string $service
     * @param string $uf
     * @param string $tpAmb
     */
    public function servico(
        $service,
        $uf,
        $tpAmb
    ) {
        $ambiente = $tpAmb == 1 ? "producao" : "homologacao";
        $webs = new Webservices($this->getXmlUrlPath());
        $sigla = !empty($this->contingency->config->type) ? $this->contingency->config->type : $uf;
        $stdServ = $webs->get($sigla, $ambiente, $this->modelo);
        //fazer duas verificações
        //1 - se o serviço existe
        //2 - se o url do serviço existe
        //caso ocorra qualquer um deles disparar uma excpetion
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
    }
    
    /**
     * getXmlUrlPath
     * @param string $tipo
     * @return string
     */
    protected function getXmlUrlPath()
    {
        $file = $this->config->pathXmlUrlFileNFe;
        $file = str_replace('65', '55', $file);
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
