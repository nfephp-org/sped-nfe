# SPED-NFE v5.0 (em desenvolvimento)
## Este release está sendo preparado para atender a versão 4.0 do layout da SEFAZ!

>Ambiente de Homologação (ambiente de teste das empresas): 01/06/2017;

>*Ambiente de Produção: 01/08/17;*

>*Desativação da versão anterior 3.10: 02/04/18.*

>**IMPORTANTE: Até 06/11/2017 esta versão será movida para master e as anteriores se tornam automaticamente OBSOLETAS e não mais receberão correções ou atualizações.**

[![Chat][ico-gitter]][link-gitter]

Framework para geração e comunicação das NFe com as SEFAZ autorizadoras.

Esta versão do pacote está em desenvolvimento, não é funcional e não deve ser utilizado para nada além de testes. 

[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![License][ico-license]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

[![Issues][ico-issues]][link-issues]
[![Forks][ico-forks]][link-forks]
[![Stars][ico-stars]][link-stars]


Este pacote visa fornecer os meios para gerar, assinar e anviar os dados relativos ao projeto Sped NFe.

Este pacote faz parte da API NFePHP e atende aos parâmetros das PSR2 e PSR4, bem como é desenvolvida para de adequar as versões ATIVAS do PHP e aos layouts da NFe em vigor.

Não deixe de se cadastrar no [grupo de discussão do NFePHP](http://groups.google.com/group/nfephp) para acompanhar o desenvolvimento e participar das discussões e tirar duvidas!

## Install

*Durante a fase de desenvolvimento e testes*
composer install nfephp-org/sped-nfe:v5.0.x-dev

*Após os stable realeases estarem disponíveis*
composer install nfephp-org/sped-nfe

## Requirements

- PHP 5.6 or PHP 7.x
- ext-curl
- ext-dom
- ext-gd
- ext-mbstring
- ext-mcrypt
- ext-openssl
- ext-soap
- ext-xml
- ext-zip
- [sped-common:v5.x](https://github.com/nfephp-org/sped-common/tree/v5.0)

## Change log

Acompanhe o [CHANGELOG](CHANGELOG.md) para maiores informações sobre as alterações recentes.

## Testing

Todos os testes são desenvolvidos para operar com o PHPUNIT

## Donations

**Estamos em busca de *doadores* e *patrocinadores* para ajudar a financiar parte do desenvolvimento deste pacote e de outros pacotes, aqueles que estiverem interessados por favor entrem em contato com o autor pelo email linux.rlm@gmail.com** 

Este é um projeto totalmente *OpenSource*, para usa-lo, copia-lo e modifica-lo você não paga absolutamente nada. Porém para continuarmos a mante-lo é necessário qua alguma contribuição seja feita, seja auxiliando na codificação, na documentação, na realização de testes e identificação de falhas e BUGs.

Mas também, caso você ache que qualquer informação obtida aqui, lhe foi útil e que isso vale de algum dinheiro e está disposto a doar algo, sinta-se livre para enviar qualquer quantia através de :

<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=linux%2erlm%40gmail%2ecom&lc=BR&item_name=NFePHP%20OpenSource%20API&item_number=nfephp&currency_code=BRL&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest">
<img alt="Doar com Paypal" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif"/></a>
[![](https://stc.pagseguro.uol.com.br/public/img/botoes/doacoes/209x48-doar-assina.gif)](https://pag.ae/bkXPq4) 


*Agradecemos a colaboração e o patrocinio, pois sem eles o desenvolvimento desse projeto seria muito mais lento a talvez até impossivel.*

> Walber Sales - *Patrocinador Gold*



## Contributing

Para contribuir com correções de BUGS, melhoria no código, documentação, elaboração de testes ou qualquer outro auxilio técnico e de programação por favor observe o [CONTRIBUTING](CONTRIBUTING.md) e o  [Código de Conduta](CONDUCT.md) para maiores detalhes.

## Security

Caso você encontre algum problema relativo a segurança, por favor envie um email diretamente aos mantenedores do pacote ao invés de abrir um ISSUE.

## Credits

Roberto L. Machado (owner and developer)

## License

Este pacote está diponibilizado sob LGPLv3 ou MIT License (MIT). Leia  [Arquivo de Licença](LICENSE.md) para maiores informações.


[ico-stars]: https://img.shields.io/github/stars/nfephp-org/sped-nfe.svg?style=flat-square
[ico-forks]: https://img.shields.io/github/forks/nfephp-org/sped-nfe.svg?style=flat-square
[ico-issues]: https://img.shields.io/github/issues/nfephp-org/sped-nfe.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/nfephp-org/sped-nfe/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/nfephp-org/sped-nfe.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nfephp-org/sped-nfe.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nfephp-org/sped-nfe.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/nfephp-org/sped-nfe.svg?style=flat-square
[ico-license]: https://poser.pugx.org/nfephp-org/nfephp/license.svg?style=flat-square
[ico-gitter]: https://img.shields.io/badge/GITTER-4%20users%20online-green.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/nfephp-org/sped-nfe
[link-travis]: https://travis-ci.org/nfephp-org/sped-nfe
[link-scrutinizer]: https://scrutinizer-ci.com/g/nfephp-org/sped-nfe/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nfephp-org/sped-nfe
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-nfe
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-nfe/issues
[link-forks]: https://github.com/nfephp-org/sped-nfe/network
[link-stars]: https://github.com/nfephp-org/sped-nfe/stargazers
[link-gitter]: https://gitter.im/nfephp-org/sped-nfe?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge