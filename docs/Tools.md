# Tools::class

A classe Tools é a responsável por fazer a comunicação entre o aplicativo e o webservice da SEFAZ.

## Dependencias



## Propriedades publicas





## Methods

### public function __construct($configJson, Certificate $certificate, Contingency $contingency = null)

**Config**

**Certificate**

**Contingency**

### public function setEnvironmentTimeZone($acronym)
Sets the PHP environment time zone

@param string $acronym (ou seja a sigla do estado ex. 'SP')

@return void

>Este método é invocado automaticamente na instanciação da classe e ajusta o timezone do PHP para a localidade indicada no config.json.
Mas pode ser usado posteriormente a instanciação da classe para alterar essa condição. Isso é necessário pois um mesmo servidor poderá acessar e enviar dados para mais de um autorizador em estados diferentes com zonas de tempo diferentes, lembrando que no Brasil existem 4 zonas de tempo e com variáções em função do horário de verão *(das zero horas do terceiro domingo de outubro até as zero horas do terceiro domingo de fevereiro)*.

### public function loadSoapClass(SoapInterface $soap)
Load Soap Class

Soap Class may be \NFePHP\Common\Soap\SoapNative or \NFePHP\Common\Soap\SoapCurl from package nfephp-org/sped-common

@param SoapInterface $soap

@return void

>O uso deste método é opcional, já que a classe SoapCurl é instanciada automaticamente na instanciação da classe Tools. Este método é mais usado em condições de testes unitários. Ou em desenvolvimento, pois a classe SoapNative ainda não está operacional com os webservices da SEFAZ.

### public function setSignAlgorithm($algorithm = OPENSSL_ALGO_SHA1)
Set OPENSSL Algorithm using OPENSSL constants

@param int $algorithm

@return void

>O uso deste método é opcional e está aqui apenas para a previsão futura de mudanças no algoritimo da assinatura digital dos xml. A condição default do framework é usar SHA1.

### public function model($model = null)
Set or get model of document NFe = 55 or NFCe = 65

@param int $model

@return int modelo class parameter

>Este método pode ser usado para setar o modelo de documento fiscal a ser usado 55 para NFe ou 65 para NFCe, ou para obter o numero do modelo atualmente setado na classe caso não seja passado parametro algum na chamado do método.

>A condição default da classe é usar o modelo '55' então caso queira usar o NFCe (modelo 65), é obrigatorio o uso desse metodo toda a vez que a classe for instanciada. Caso contrario poderá ocorrer excptions ao tentar usar algum recurso. Ou mesmo não haver retornos da SEFAZ.

>Algumas chamadas de métodos poderão identificar incorreção do uso do modelo em função dos dados fornecidos, mas isso não ocorre em todos os casos.

### public function version($version = '')
Set or get teh parameter versao do layout 

@param string $version

@return string

>Este método pode ser usado para setar a versão cdo layout da NFe sendo utilizado pela API, caso o parametro seja passado com uma string vazia o método irá retornar a versão atualmente setada na classe.

### public function getcUF($acronym)
Recover cUF number from 

@param string $acronym Sigal do estado

@return int number cUF

### public function getAcronym($cUF)
Recover Federation unit acronym by cUF number

@param int $cUF

@return string acronym sigla

### public function signNFe($xml)
Sign NFe or NFCe xml string (dont is a file path)

@param  string  $xml NFe xml content

@return string singed NFe xml

@throws \RuntimeException

>Este método assina a NFe ou a NFCe e testa sua validade com o respectivo XSD.

### Ativando as contingências
Ao carregar a classe é instanciada a classe Factories\Contingency automaticamente na propriedade publica $contingency e a partir dessa propriedade podem ser ativadas ou desativdos os modos de contingencia. Lembrando que isso deverá ser levado em conta também na criação dos XML das NFe.

A classe Contingencia pode ser passada por parâmetro na instanciação da classe Tools ou porteriormente, como indicado abaixo.

**ATIVANDO**
```php
$contJson = $tools->contingency->activate($sigla, $motivo, $tipo = '');
```
O modo de contingência pode ser melhor entendido ao se estudar [Contingency](Contingency.md). O parametro tipo é opcional e só deve ser passado em caso do uso de contingência FS-DA, EPEC ou OFFLINE (para NFCe).

**REATIVANDO**
Cada vez que a classe é invocada o modo de contingência esta desabilitado, e nesta versão da API passa a ser trabalho do aplicativo manter o estado da contingência a sua maneira em arquivo ou em base de dados. Caso o sistema de contigência ainda esteja ativo é necessário recarrega-lo na classe, com os mesmos parâmetros de sua ativação. Para isso usamos a string json retornada na ativação.

```php
$tools->contingency->load($contJson);
```

**DESATIVANDO**
```php
$contJson = $tools->contingency->deactivate();
```
Ao desativar o modo de contingência é retornado um json com os parametros default.

**Envio de NFe em contingência**
Ao tenta fazer o envio de lotes em contingência a NFe são modificadas para atender aos requisitos da SEFAZ.

**MODO EPEC**
Ao enviar NFe ou NFCe em modo de contingência EPEC os dados das NFe enviadas serão extraidos das mesmas, as condições basicas serão modificadas na tag &lt;ide&gt; e a NFe será novamente assinada, o retorno 







