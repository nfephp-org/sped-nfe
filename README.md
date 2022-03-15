# SPED-NFE 

Biblioteca para geração e comunicação das NFe com as SEFAZ autorizadoras, e visa fornecer os meios para gerar, assinar e enviar os dados relativos ao projeto Sped NFe das SEFAZ.

## Atualizado 

- NT 2020.006 Intermediarios
- NT 2020.007 Evento Ator Interessado na NFe - Transportador
- NT 2021_001 Evento de COMPROVANTE DE ENTREGA
- NT 2021.004 v1.20 Regras de Validação e Novos Campos (válido em produção a partir de 16/05/2022)

> **NOTA: Estas NT afetam principalmente o uso do TXT para conversão em XML, mesmo que os campos ainda não sejam exigidos.**

## TODO: A conversão com o PADRÃO SEBRAE ainda está incompleta!!

*Utilize o chat do Gitter para iniciar discussões específicas sobre o desenvolvimento deste pacote.*

![PHP Supported Version][ico-php]
![Actions](https://github.com/nfephp-org/sped-nfe/actions/workflows/ci.yml/badge.svg)
[![Chat][ico-gitter]][link-gitter]

[![Latest Stable Version][ico-stable]][link-packagist]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![License][ico-license]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

[![Issues][ico-issues]][link-issues]
[![Forks][ico-forks]][link-forks]
[![Stars][ico-stars]][link-stars]

## Estados atendidos

### NFe (modelo 55) TODOS

### NFCe (modelo 65) Todos

### NFe com eCPF (emissor pessoa física)

> Os estados de **CE**, **PR** e **SP** **NÃO ACEITAM EMISSÃO com eCPF**

> AM e GO não foi possivel verificar por problemas na comunicação

> Todos os demais estados (aparentemente) já aceitam emissão por eCPF

Este pacote é aderente com os [PSR-1], [PSR-2] e [PSR-4]. Se você observar negligências de conformidade, por favor envie um patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

Não deixe de se cadastrar no [grupo de discussão do NFePHP](http://groups.google.com/group/nfephp) para acompanhar o desenvolvimento e participar das discussões e tirar dúvidas!

## Install

**Este pacote está listado no [Packgist](https://packagist.org/) foi desenvolvido para uso do [Composer](https://getcomposer.org/), portanto não será explicitada nenhuma alternativa de instalação.**

*E deve ser instalado com:*
```bash
composer require nfephp-org/sped-nfe
```
Ou ainda alterando o composer.json do seu aplicativo inserindo:
```json
"require": {
    "nfephp-org/sped-nfe" : "^5.0"
}
```

*Para utilizar o pacote em desenvolvimento (branch master) deve ser instalado com:*
```bash
composer require nfephp-org/sped-nfe:dev-master
```

*Ou ainda alterando o composer.json do seu aplicativo inserindo:*
```json
"require": {
    "nfephp-org/sped-nfe" : "dev-master"
}
```

> NOTA: Ao utilizar este pacote na versão em desenvolvimento não se esqueça de alterar o composer.json da sua aplicação para aceitar pacotes em desenvolvimento, alterando a propriedade "minimum-stability" de "stable" para "dev".
> ```json
> "minimum-stability": "dev"
> ```

## Requirements

Para que este pacote possa funcionar são necessários os seguintes requisitos do PHP e outros pacotes dos quais esse depende.

- PHP 7.x (recomendável PHP 7.2) 
- ext-curl
- ext-dom
- ext-json
- ext-gd
- ext-mbstring
- ext-mcrypt
- ext-openssl
- ext-soap
- ext-xml
- ext-zip
- [sped-common](https://github.com/nfephp-org/sped-common)

> Para outras ações necessárias ao SPED, podem ser usados (opcionalmente) outros pacotes, como:

> - [sped-da](https://github.com/nfephp-org/sped-da) Geração dos documentos impressos (DANFE, DACTE, etc.)
> - [sped-mail](https://github.com/nfephp-org/sped-mail) Envio de email com as notas e outros documentos fiscais 
> - [sped-ibpt](https://github.com/nfephp-org/sped-ibpt) Consulta dos impostos aproximados na venda a consumidor
> - [sped-gnre](https://github.com/nfephp-org/sped-gnre) Geração do GNRE
> - [posprint](https://github.com/nfephp-org/posprint) Impressão de documentos em impressoras térmicas POS


## Como eu faço uso desta API no meu projeto?

Primeiro, esta API faz uso dos recursos mais atuais do PHP para classes e objetos, portanto abaixo vai um exemplo ERRADO de uso:
```
require 'sped-nfe/src/Make.php';

$nfe = new Make();
```
Portanto, você deve primeiro entender que para usar esta API você precisará trabalhar com NAMESPACES pois esta API trabalha com NAMESPACES.

Agora que você sabe que NAMESPACES é requerido, o uso correto para o exemplo acima seria:
```
// VENDOR_DIR = pasta vendor da sua instalação composer
require VENDOR_DIR . 'autoload.php';

use NFePHP\NFe\Make;

$nfe = new Make();
```


## Donations

**Estamos em busca de *doadores* e *patrocinadores* para ajudar a financiar parte do desenvolvimento deste pacote e de outros pacotes, aqueles que estiverem interessados por favor entrem em contato com o autor pelo email linux.rlm@gmail.com** 

Este é um projeto totalmente *Open Source*, para usá-lo, copiá-lo ou modificá-lo você não paga absolutamente nada. Porém para continuarmos a mantê-lo de forma adequada é necessária alguma contribuição seja feita, seja auxiliando na codificação, na documentação, na realização de testes e identificação de falhas e BUGs.

Mas também, caso você ache que qualquer informação obtida aqui, lhe foi útil e que isso vale algum dinheiro e está disposto a doar algo, sinta-se livre para enviar qualquer quantia, seja diretamente ao autor ou através do PayPal e do PagSeguro.

<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=linux%2erlm%40gmail%2ecom&lc=BR&item_name=NFePHP%20OpenSource%20API&item_number=nfephp&currency_code=BRL&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest">
<img alt="Doar com Paypal" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif"/></a>

<a target="_blank" href="https://pag.ae/bkXPq4">
<img alt="Doar PagSeguro" src="https://stc.pagseguro.uol.com.br/public/img/botoes/doacoes/120x53-doar.gif"/></a>


## Acknowledgments

- A todos os colegas que colaboram de alguma forma com o desenvolvimento contínuo desta API.

<a href="https://www.jetbrains.com/?from=NFePHP"><img src="https://github.com/robmachado/sped-nfe/blob/master/docs/images/jetbrains.png" alt="JetBrains" width="80"></a> | A JetBrains pelo fornecimento de uma licença do PHPStorm um dos melhores IDE para desenvolvimento em PHP.
----- | -----

## Documentation

O processo de documentação ainda está no inicio, mas já existem alguns documentos úteis.

[Documentação](docs/Funcionalidades.md)

## Contributing

Para contribuir com correções de BUGS, melhoria no código, documentação, elaboração de testes ou qualquer outro auxílio técnico e de programação por favor observe o [CONTRIBUTING](CONTRIBUTING.md) e o  [Código de Conduta](CONDUCT.md) para maiores detalhes.

## Change log

Acompanhe o [CHANGELOG](CHANGELOG.md) para maiores informações sobre as alterações recentes.

## Testing

Todos os testes são desenvolvidos para operar com o PHPUNIT

## Security

Caso você encontre algum problema relativo a segurança, por favor envie um email diretamente aos mantenedores do pacote ao invés de abrir um ISSUE.

## Credits

Roberto L. Machado (owner and developer)

## License

Este pacote está diponibilizado sob LGPLv3 ou MIT License (MIT). Leia  [Arquivo de Licença](LICENSE.md) para maiores informações.

[ico-php]: https://img.shields.io/packagist/php-v/nfephp-org/sped-da
[ico-stable]: https://poser.pugx.org/nfephp-org/sped-nfe/version
[ico-stars]: https://img.shields.io/github/stars/nfephp-org/sped-nfe.svg?style=flat-square
[ico-forks]: https://img.shields.io/github/forks/nfephp-org/sped-nfe.svg?style=flat-square
[ico-issues]: https://img.shields.io/github/issues/nfephp-org/sped-nfe.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nfephp-org/sped-nfe.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/nfephp-org/sped-nfe.svg?style=flat-square
[ico-license]: https://poser.pugx.org/nfephp-org/nfephp/license.svg?style=flat-square
[ico-gitter]: https://img.shields.io/badge/GITTER-4%20users%20online-green.svg?style=flat-square


[link-packagist]: https://packagist.org/packages/nfephp-org/sped-nfe
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-nfe
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-nfe/issues
[link-forks]: https://github.com/nfephp-org/sped-nfe/network
[link-stars]: https://github.com/nfephp-org/sped-nfe/stargazers
[link-gitter]: https://gitter.im/nfephp-org/sped-nfe?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge
