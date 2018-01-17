<?php

namespace NFePHP\NFe\Common;

/**
 * Class base responsible for communication with SEFAZ
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Tools
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use DOMDocument;
use InvalidArgumentException;
use RuntimeException;
use NFePHP\Common\Certificate;
use NFePHP\Common\Signer;
use NFePHP\Common\Soap\SoapCurl;
use NFePHP\Common\Soap\SoapInterface;
use NFePHP\Common\Strings;
use NFePHP\Common\TimeZoneByUF;
use NFePHP\Common\UFList;
use NFePHP\Common\Validator;
use NFePHP\NFe\Common\Config;
use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Factories\ContingencyNFe;
use NFePHP\NFe\Factories\Header;
use NFePHP\NFe\Factories\QRCode;
use SoapHeader;

class Tools
{
    /**
     * config class
     * @var \stdClass
     */
    public $config;
    /**
     * Path to storage folder
     * @var string
     */
    public $pathwsfiles = '';
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
     * Application version
     * @var string
     */
    public $verAplic = '';
    /**
     * last soap request
     * @var string
     */
    public $lastRequest = '';
    /**
     * last soap response
     * @var string
     */
    public $lastResponse = '';
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
     * Canonical conversion options
     * @var array
     */
    protected $canonical = [true,false,null,null];
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
     * urlcUF
     * @var int
     */
    protected $urlcUF;
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
     * @var \SoapHeader | null
     */
    protected $objHeader = null;
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
     * @var array
     */
    protected $availableVersions = [
        '3.10' => 'PL_008i2',
        '4.00' => 'PL_009_V4'
    ];
    
    /**
     * Constructor
     * load configurations,
     * load Digital Certificate,
     * map all paths,
     * set timezone and
     * and instanciate Contingency::class
     * @param string $configJson content of config in json format
     * @param Certificate $certificate
     */
    public function __construct($configJson, Certificate $certificate)
    {
        $this->pathwsfiles = realpath(
            __DIR__ . '/../../storage'
        ).'/';
        //valid config json string
        $this->config = Config::validate($configJson);
        
        $this->version($this->config->versao);
        $this->setEnvironmentTimeZone($this->config->siglaUF);
        $this->certificate = $certificate;
        $this->setEnvironment($this->config->tpAmb);
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
        date_default_timezone_set(TimeZoneByUF::get($acronym));
    }
    
    /**
     * Set application version
     * @param string $ver
     */
    public function setVerAplic($ver)
    {
        $this->verAplic = $ver;
    }

    /**
     * Load Soap Class
     * Soap Class may be \NFePHP\Common\Soap\SoapNative
     * or \NFePHP\Common\Soap\SoapCurl
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
     * Set or get parameter layout version
     * @param string $version
     * @return string
     * @throws InvalidArgumentException
     */
    public function version($version = null)
    {
        if (null === $version) {
            return $this->versao;
        }
        //Verify version template is defined
        if (false === isset($this->availableVersions[$version])) {
            throw new \InvalidArgumentException('Essa versão de layout não está disponível');
        }
        
        $this->versao = $version;
        $this->config->schemes = $this->availableVersions[$version];
        $this->pathschemes = realpath(
            __DIR__ . '/../../schemes/'. $this->config->schemes
        ).'/';
        
        return $this->versao;
    }
    
    /**
     * Recover cUF number from state acronym
     * @param string $acronym Sigla do estado
     * @return int number cUF
     */
    public function getcUF($acronym)
    {
        return UFlist::getCodeByUF($acronym);
    }
    
    /**
     * Recover state acronym from cUF number
     * @param int $cUF
     * @return string acronym sigla
     */
    public function getAcronym($cUF)
    {
        return UFlist::getUFByCode($cUF);
    }
    
    /**
     * Validate cUF from the key content and returns the state acronym
     * @param string $chave
     * @return string
     * @throws InvalidArgumentException
     */
    public function validKeyByUF($chave)
    {
        $uf = $this->config->siglaUF;
        if ($uf != UFList::getUFByCode(substr($chave, 0, 2))) {
            throw new \InvalidArgumentException(
                "A chave da NFe indicada [$chave] não pertence a [$uf]."
            );
        }
        return $uf;
    }
    
    /**
     * Sign NFe or NFCe
     * @param  string  $xml NFe xml content
     * @return string singed NFe xml
     * @throws RuntimeException
     */
    public function signNFe($xml)
    {
        //remove all invalid strings
        $xml = Strings::clearXmlString($xml);
        $signed = Signer::sign(
            $this->certificate,
            $xml,
            'infNFe',
            'Id',
            $this->algorithm,
            $this->canonical
        );
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($signed);
        $modelo = $dom->getElementsByTagName('mod')->item(0)->nodeValue;
        if ($modelo == 65) {
            $signed = $this->addQRCode($dom);
        }
        //exception will be throw if NFe is not valid
        $this->isValid($this->versao, $signed, 'nfe');
        return $signed;
    }
    
    /**
     * Corret NFe fields when in contingency mode is set
     * @param string $xml NFe xml content
     * @return string
     */
    protected function correctNFeForContingencyMode($xml)
    {
        if ($this->contingency->type == '') {
            return $xml;
        }
        $xml = ContingencyNFe::adjust($xml, $this->contingency);
        return $this->signNFe($xml);
    }

    /**
     * Performs xml validation with its respective
     * XSD structure definition document
     * NOTE: if dont exists the XSD file will return true
     * @param string $version layout version
     * @param string $body
     * @param string $method
     * @return boolean
     */
    protected function isValid($version, $body, $method)
    {
        $schema = $this->pathschemes.$method."_v$version.xsd";
        if (!is_file($schema)) {
            return true;
        }
        return Validator::isValid(
            $body,
            $schema
        );
    }
    
    /**
     * Verifies the existence of the service
     * @param string $service
     * @throws RuntimeException
     */
    protected function checkContingencyForWebServices($service)
    {
        $permit = [
            55 => ['SVCAN', 'SVCRS', 'EPEC', 'FSDA'],
            65 => ['FSDA', 'EPEC', 'OFFLINE']
        ];
        
        $type = $this->contingency->type;
        $mod = $this->modelo;
        if (!empty($type)) {
            if (array_search($type, $permit[$mod]) === false) {
                throw new RuntimeException(
                    "Esse modo de contingência [$type] não é aceito "
                    . "para o modelo [$mod]"
                );
            }
        }
        
        //se a contingencia é OFFLINE ou FSDA nenhum servidor está disponivel
        //se a contigencia EPEC está ativa apenas o envio de Lote está ativo,
        //então gerar um RunTimeException
        if ($type == 'FSDA'
            || $type == 'OFFLINE'
            || ($type == 'EPEC' && $service != 'RecepcaoEvento')
        ) {
            throw new RuntimeException(
                "Quando operando em modo de contingência ["
                . $this->contingency->type
                . "], este serviço [$service] não está disponível."
            );
        }
    }
    
    /**
     * Alter environment from "homologacao" to "producao" and vice-versa
     * @param int $tpAmb
     * @return void
     */
    public function setEnvironment($tpAmb = 2)
    {
        if (!empty($tpAmb) && ($tpAmb == 1 || $tpAmb == 2)) {
            $this->tpAmb = $tpAmb;
            $this->ambiente = ($tpAmb == 1) ? 'producao' : 'homologacao';
        }
    }
    
    /**
     * Set option for canonical transformation see C14n
     * @param array $opt
     * @return array
     */
    public function canonicalOptions($opt = [true,false,null,null])
    {
        if (!empty($opt) && is_array($opt)) {
            $this->canonical = $opt;
        }
        return $this->canonical;
    }
    
    /**
     * Assembles all the necessary parameters for soap communication
     * @param string $service
     * @param string $uf
     * @param int $tpAmb
     * @param bool $ignoreContingency
     * @return void
     */
    protected function servico(
        $service,
        $uf,
        $tpAmb,
        $ignoreContingency = false
    ) {
        $ambiente = $tpAmb == 1 ? "producao" : "homologacao";
        $webs = new Webservices($this->getXmlUrlPath());
        $sigla = $uf;
        if (!$ignoreContingency) {
            $contType = $this->contingency->type;
            if (!empty($contType)
                && ($contType == 'SVCRS' || $contType == 'SVCAN')
            ) {
                $sigla = $contType;
            }
        }
        $stdServ = $webs->get($sigla, $ambiente, $this->modelo);
        if ($stdServ === false) {
            throw new \RuntimeException(
                "Nenhum serviço foi localizado para esta unidade "
                . "da federação [$sigla], com o modelo [$this->modelo]."
            );
        }
        if (empty($stdServ->$service->url)) {
            throw new \RuntimeException(
                "Este serviço [$service] não está disponivel para esta "
                . "unidade da federação [$uf] ou para este modelo de Nota ["
                . $this->modelo
                ."]."
            );
        }
        //recuperação do cUF
        $this->urlcUF = $this->getcUF($uf);
        if ($this->urlcUF > 91) {
            //foi solicitado dado de SVCRS ou SVCAN
            $this->urlcUF = $this->getcUF($this->config->siglaUF);
        }
        //recuperação da versão
        $this->urlVersion = $stdServ->$service->version;
        //recuperação da url do serviço
        $this->urlService = $stdServ->$service->url;
        //recuperação do método
        $this->urlMethod = $stdServ->$service->method;
        //recuperação da operação
        $this->urlOperation = $stdServ->$service->operation;
        //montagem do namespace do serviço
        $this->urlNamespace = sprintf(
            "%s/wsdl/%s",
            $this->urlPortal,
            $this->urlOperation
        );
        //montagem do cabeçalho da comunicação SOAP
        $this->urlHeader = Header::get(
            $this->urlNamespace,
            $this->urlcUF,
            $this->urlVersion
        );
        $this->urlAction = "\""
            . $this->urlNamespace
            . "/"
            . $this->urlMethod
            . "\"";
        //montagem do SOAP Header
        //para versões posteriores a 3.10 não incluir o SoapHeader !!!!
        if ($this->versao < '4.00') {
            $this->objHeader = new SoapHeader(
                $this->urlNamespace,
                'nfeCabecMsg',
                ['cUF' => $this->urlcUF, 'versaoDados' => $this->urlVersion]
            );
        }
    }
    
    /**
     * Send request message to webservice
     * @param array $parameters
     * @param string $request
     * @return string
     */
    protected function sendRequest($request, array $parameters = [])
    {
        $this->checkSoap();
        return (string) $this->soap->send(
            $this->urlService,
            $this->urlMethod,
            $this->urlAction,
            SOAP_1_2,
            $parameters,
            $this->soapnamespaces,
            $request,
            $this->objHeader
        );
    }
    
    /**
     * Recover path to xml data base with list of soap services
     * @return string
     */
    protected function getXmlUrlPath()
    {
        $file = $this->pathwsfiles
            //. DIRECTORY_SEPARATOR
            . "wsnfe_".$this->versao."_mod55.xml";
        if ($this->modelo == 65) {
            $file = str_replace('55', '65', $file);
        }
        if (! file_exists($file)) {
            return '';
        }
        return file_get_contents($file);
    }
    
    /**
     * Add QRCode Tag to signed XML from a NFCe
     * @param DOMDocument $dom
     * @return string
     */
    protected function addQRCode(DOMDocument $dom)
    {
        $memmod = $this->modelo;
        $this->modelo = 65;
        $uf = UFList::getUFByCode(
            $dom->getElementsByTagName('cUF')->item(0)->nodeValue
        );
        $this->servico(
            'NfeConsultaQR',
            $uf,
            $dom->getElementsByTagName('tpAmb')->item(0)->nodeValue
        );
        $signed = QRCode::putQRTag(
            $dom,
            $this->config->CSC,
            $this->config->CSCid,
            $this->urlVersion,
            $this->urlService,
            $this->getURIConsultaNFCe($uf)
        );
        $this->modelo = $memmod;
        return Strings::clearXmlString($signed);
    }

    /**
     * Get URI for search NFCe by chave
     * NOTE: exists only in 4.00 layout
     * @param string $uf
     * @return string
     */
    protected function getURIConsultaNFCe($uf)
    {
        if ($this->versao < '4.00') {
            return '';
        }
        //existe no XML apenas para layout >= 4.x
        //os URI estão em storage/uri_consulta_nfce.json
        $std = json_decode(
            file_get_contents(
                $this->pathwsfiles.'uri_consulta_nfce.json'
            )
        );
        return $std->$uf;
    }
    
    /**
     * Verify if SOAP class is loaded, if not, force load SoapCurl
     */
    protected function checkSoap()
    {
        if (empty($this->soap)) {
            $this->soap = new SoapCurl($this->certificate);
        }
    }
}
