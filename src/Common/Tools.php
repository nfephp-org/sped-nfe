<?php

namespace NFePHP\NFe\Common;

/**
 * Class base responsible for communication with SEFAZ
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Tools
 * @copyright NFePHP Copyright (c) 2008-2019
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
use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Factories\ContingencyNFe;
use NFePHP\NFe\Factories\Header;
use NFePHP\NFe\Factories\QRCode;

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
    protected $versao = '4.00';
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
    protected $availableVersions = ['4.00' => 'PL_009_V4'];
    /**
     * @var string
     */
    protected $typePerson = 'J';
    /**
     * @var string
     */
    protected $timezone;

    /**
     * Loads configurations and Digital Certificate, map all paths, set timezone and instanciate Contingency::class
     * @param string $configJson content of config in json format
     * @param Certificate $certificate
     * @param Contingency|null $contingency
     */
    public function __construct($configJson, Certificate $certificate, Contingency $contingency = null)
    {
        $this->pathwsfiles = realpath(__DIR__ . '/../../storage') . '/';
        //valid config json string
        $this->config = Config::validate($configJson);
        $this->version($this->config->versao);
        $this->setEnvironmentTimeZone($this->config->siglaUF);
        $this->certificate = $certificate;
        $this->typePerson = $this->getTypeOfPersonFromCertificate();
        $this->setEnvironment($this->config->tpAmb);
        if (empty($contingency)) {
            $this->contingency = new Contingency();
        }
    }

    /**
     * Sets environment time zone
     * @param string $acronym (ou seja a sigla do estado)
     * @return void
     */
    public function setEnvironmentTimeZone($acronym)
    {
        $this->timezone = TimeZoneByUF::get($acronym);
    }

    /**
     * Return J or F from existing type in ASN.1 certificate
     * J - pessoa juridica (CNPJ)
     * F - pessoa física (CPF)
     * @return string
     */
    public function getTypeOfPersonFromCertificate()
    {
        $cnpj = $this->certificate->getCnpj();
        $type = 'J';
        if (empty($cnpj)) {
            //não é CNPJ, então verificar se é CPF
            $cpf = $this->certificate->getCpf();
            if (!empty($cpf)) {
                $type = 'F';
            } else {
                //não foi localizado nem CNPJ e nem CPF esse certificado não é usável
                //throw new RuntimeException('Faltam elementos CNPJ/CPF no certificado digital.');
                $type = '';
            }
        }
        return $type;
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
     * @return string signed NFe xml
     * @throws RuntimeException
     */
    public function signNFe($xml)
    {
        if (empty($xml)) {
            throw new InvalidArgumentException('O argumento xml passado para ser assinado está vazio.');
        }
        //remove all invalid strings
        $xml = Strings::clearXmlString($xml);
        if ($this->contingency->type !== '') {
            $xml = ContingencyNFe::adjust($xml, $this->contingency);
        }
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
        $isInfNFeSupl = !empty($dom->getElementsByTagName('infNFeSupl')->item(0));
        if ($modelo == 65 && !$isInfNFeSupl) {
            $signed = $this->addQRCode($dom);
        }
        //exception will be throw if NFe is not valid
        $this->isValid($this->versao, $signed, 'nfe');
        return $signed;
    }

    /**
     * Corrects NFe fields when in contingency mode
     * @param string $xml NFe xml content
     * @return string
     */
    protected function correctNFeForContingencyMode($xml)
    {
        return $this->contingency->type == '' ? $xml : $this->signNFe($xml);
    }

    /**
     * Performs xml validation with its respective XSD structure definition document
     * NOTE: if don't exists the XSD file will return true
     * @param string $version layout version
     * @param string $body
     * @param string $method
     * @return bool
     */
    protected function isValid($version, $body, $method)
    {
        $schema = $this->pathschemes.$method."_v$version.xsd";
        if (!is_file($schema)) {
            return true;
        }
        return Validator::isValid($body, $schema);
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
    public function canonicalOptions(array $opt = [true, false, null, null])
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
     * @param int $tpAmb 1-Production or 2-Homologation
     * @param bool $ignoreContingency
     * @throws RuntimeException
     * @return void
     */
    protected function servico($service, $uf, $tpAmb, $ignoreContingency = false)
    {
        $webs = new Webservices($this->getXmlUrlPath());
        $sigla = $uf;
        if (!$ignoreContingency) {
            $contType = $this->contingency->type;
            if (!empty($contType) && ($contType == 'SVCRS' || $contType == 'SVCAN')) {
                $sigla = $contType;
            }
        }
        $stdServ = $webs->get($sigla, $tpAmb, $this->modelo);
        if (empty($stdServ->$service->url)) {
            throw new \RuntimeException("Servico [$service] indisponivel UF [$uf] ou modelo [$this->modelo]");
        }
        $this->urlcUF = $this->getcUF($uf); //recuperação do cUF
        if ($this->urlcUF > 91) {
            $this->urlcUF = $this->getcUF($this->config->siglaUF); //foi solicitado dado de SVCRS ou SVCAN
        }
        $this->urlVersion = $stdServ->$service->version; //recuperação da versão
        $this->urlService = $stdServ->$service->url; //recuperação da url do serviço
        $this->urlMethod = $stdServ->$service->method; //recuperação do método
        $this->urlOperation = $stdServ->$service->operation; //recuperação da operação
        $this->urlNamespace = sprintf("%s/wsdl/%s", $this->urlPortal, $this->urlOperation); //monta namespace
        //montagem do cabeçalho da comunicação SOAP
        $this->urlHeader = Header::get($this->urlNamespace, $this->urlcUF, $this->urlVersion);
        $this->urlAction = "\"$this->urlNamespace/$this->urlMethod\"";
    }

    /**
     * Send request message to webservice
     * @param string $request
     * @param array $parameters
     * @return string
     * @throws RuntimeException
     */
    protected function sendRequest($request, array $parameters = [])
    {
        if (in_array($this->contingency->tpEmis, [Contingency::TPEMIS_FSDA, Contingency::TPEMIS_OFFLINE])) {
            throw new \RuntimeException('Em contingencia FSDA ou OFFLINE não é possivel acessar os webservices.');
        }
        $this->checkSoap();
        $response = (string) $this->soap->send(
            $this->urlService,
            $this->urlMethod,
            $this->urlAction,
            SOAP_1_2,
            $parameters,
            $this->soapnamespaces,
            $request,
            $this->objHeader
        );
        return Strings::normalize($response);
    }

    /**
     * Recover path to xml data base with list of soap services
     * @return string
     */
    protected function getXmlUrlPath()
    {
        $file = "wsnfe_" . $this->versao . "_mod55.xml";
        if ($this->modelo == 65) {
            $file = str_replace('55', '65', $file);
        }
        
        $path = $this->pathwsfiles . $file;
        if (! file_exists($path)) {
            return '';
        }
        return file_get_contents($path);
    }

    /**
     * Add QRCode Tag to signed XML from a NFCe
     * @param DOMDocument $dom
     * @return string
     */
    protected function addQRCode(DOMDocument $dom)
    {
        if (empty($this->config->CSC) || empty($this->config->CSCid)) {
            throw new \RuntimeException("O QRCode não pode ser criado pois faltam dados CSC e/ou CSCId");
        }
        $memmod = $this->modelo;
        $this->modelo = 65;
        $cUF = $dom->getElementsByTagName('cUF')->item(0)->nodeValue;
        $tpAmb = $dom->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $uf = UFList::getUFByCode($cUF);
        $this->servico('NfeConsultaQR', $uf, $tpAmb);
        $signed = QRCode::putQRTag(
            $dom,
            $this->config->CSC,
            $this->config->CSCid,
            $this->urlVersion,
            $this->urlService,
            $this->getURIConsultaNFCe($uf, $tpAmb)
        );
        $this->modelo = $memmod;
        return Strings::clearXmlString($signed);
    }

    /**
     * Get URI for search NFCe by key (chave)
     * @param string $uf Abbreviation of the UF
     * @param string $tpAmb SEFAZ environment, 1-Production or 2-Homologation
     * @return string
     */
    protected function getURIConsultaNFCe($uf, $tpAmb)
    {
        $arr = json_decode(file_get_contents($this->pathwsfiles . 'uri_consulta_nfce.json'), true);
        $std = json_decode(json_encode($arr[$tpAmb]));
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
