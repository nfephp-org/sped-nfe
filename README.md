# SPED-NFE 

Biblioteca para geração e comunicação das NFe com as SEFAZ autorizadoras, e visa fornecer os meios para gerar, assinar e enviar os dados relativos ao projeto Sped NFe das SEFAZ.

## Atualizado 

- Nota Técnica 2025.001 v.1.00 Divulga Simplificação Operacional: NFC-e: Leiaute do QR-Code versão 3 NF-e
- Nota Técnica 2025.002 v.1.01 Nota técnica de adequação dos leiautes da NF-e e da NFC-e Reforma Tributária do Consumo - RTC.
- Nota Técnica Conjunta 2025.001 Divulga orientações sobre implementação do CNPJ alfanumérico nos documentos fiscais eletrônicos
- Nota Técnica 2024.003 v.1.04 Alteração nas regras de validação 
- Nota Técnica 2021.003 v.1.40 Validação GTIN
- Nota Técnica 2024.003 v.1.05 Informações de Produtos da Agricultura, Pecuária e Produção Florestal e Alteração de regra de validação
- Nota Técnica 2023.001 v.1.60 Tributação Monofásica sobre Combustíveis
- Nota Técnica 2025.001 v.1.00 Simplificação Operacional: NFC-e (QR-Code versão 3) (Envio sincrono NFe)
- Nota Técnica 2025.002-RTC v.1.10 Reforma Tributária do Consumo – Adequações NF-e / NFC-e
- Schema PL_010v1.10b de 09/06/2025
- Nota Técnica 2025.002-RTC v.1.20 Reforma Tributária do Consumo – Adequações NF-e / NFC-e
- Schema PL_010v1.20b de 30/07/2025


![PHP Supported Version][ico-php]
![Actions](https://github.com/nfephp-org/sped-nfe/actions/workflows/ci.yml/badge.svg)
[![codecov](https://codecov.io/gh/nfephp-org/sped-nfe/branch/master/graph/badge.svg?token=UsZnjTNKKh)](https://codecov.io/gh/nfephp-org/sped-nfe)

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

- PHP 7.x (minimo PHP 7.4 veja sempre nos badges) 
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


## Como eu faço uso desta biblioteca no meu projeto?

Primeiro, esta biblioteca faz uso dos recursos mais atuais do PHP para classes e objetos, portanto abaixo vai um exemplo ERRADO de uso:
```
require 'sped-nfe/src/Make.php';

$nfe = new Make();
```
Portanto, você deve primeiro entender que para usar esta biblioteca você precisará trabalhar com NAMESPACES pois trabalhamos com NAMESPACES.

Agora que você sabe que NAMESPACES é requerido, o uso correto para o exemplo acima seria:
```
// VENDOR_DIR = pasta vendor da sua instalação composer
require VENDOR_DIR . 'autoload.php';

use NFePHP\NFe\Make;

$nfe = new Make();
```

## Acknowledgments

- A todos os colegas que colaboram de alguma forma com o desenvolvimento contínuo desta biblioteca.


## Documentation

O processo de documentação ainda está no inicio, mas já existem alguns documentos úteis.

[Documentação](docs/Funcionalidades.md)

### Para tirar suas duvidas não inicie uma ISSUE, mas se inscreva no grupo do google [NFePHP](http://groups.google.com/group/nfephp).
 
## Contributing

Para contribuir com correções de BUGS, melhoria no código, documentação, elaboração de testes ou qualquer outro auxílio técnico e de programação por favor observe o [CONTRIBUTING](CONTRIBUTING.md) e o  [Código de Conduta](CONDUCT.md) para maiores detalhes.

### Etapas para contribuir com Código

1. Faça um fork do projeto em sua conta no GitHub
2. Baixe a biblioteca na sua maquina de desenvolvimento a partir do seu próprio fork
3. Execute o composer install na raiz do projeto (prefira usar o PHP 8.2 ou 8.3)
4. Crie uma relação com o projeto original usando o git, com isso criará um bloco denominado "upstream" com uma cópia do projeto original
```
git remote add upstream git@github.com:nfephp-org/sped-nfe.git
```
5. Antes de começar a codar sobre sua cópia sempre sincronize o projeto com o repositório principal
```
git fetch upstream
git merge upstream/master
git push
```
6. Agora pode codar sobre sua cópia da biblioteca
7. Ao terminar, sempre teste suas alterações para garantir o funcionamento, para isso recomendo criar uma pasta denominada "local" na raiz, e esta pasta não será enviada ao repositório, então poderá ter dados sensíveis.
8. Sempre, antes de fazer envio ao seu repositório execute os comandos abaixo, a partir de raiz do projeto na sua maquina: 
```
composer phpcbf
composer phpcs
composer stan
composer test
```
9. Se nenhum erro for indicado pos esses testes, pode enviar ao seu repositório, lá serão executados os comandos do GitHub Actions
10. Se passar nos testes, pode fazer um pull request para o projeto original.
11. Se o PR for aceito, não esqueça de repetir os comandos do passo 5.
 
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


[link-packagist]: https://packagist.org/packages/nfephp-org/sped-nfe
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-nfe
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-nfe/issues
[link-forks]: https://github.com/nfephp-org/sped-nfe/network
[link-stars]: https://github.com/nfephp-org/sped-nfe/stargazers
[link-gitter]: https://gitter.im/nfephp-org/sped-nfe?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge
