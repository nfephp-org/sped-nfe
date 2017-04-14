# Contribuindo (*Contributing*)

Todas as contribuições são **bem vindas** e serão totalmente **creditadas** aos seus autores.

*Contributions are **welcome** and will be fully **credited**.*

Nós aceitamos contribuições via "pull request" através do repositório no [GitHub](https://github.com/nfephp-org/sped-nfe).

*We accept contributions via Pull Requests on [Github](https://github.com/nfephp-org/sped-nfe).*


# Ambiente

Nossos scripts e exemplos são direcionados para ambiente LINUX, pois esse é com certeza onde a maior parte dos aplicativos em PHP são executados.

Caso o desenvolvimento esteja sendo feito em Windows ou ainda em MacOS é recomendável que ou seja instalado uma interface tipo BASH como console ou que sejam usados outros meios e scripts para a execução das tarefas necessárias. 

## Pull Requests

- **[PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)** - A forma mais facil de aplicar as convenções é atraves do PHP Code Sniffer. *The easiest way to apply the conventions is to install [PHP Code Sniffer](http://pear.php.net/package/PHP_CodeSniffer).*

- **Add tests!** - Seus patchs não serão aceitos caso não tenham testes. *Your patch won't be accepted if it doesn't have tests.*

- **Document any change in behaviour** - Tenha certeza de manter o `README.md` e qualquer outra documentação relevante atualizada com o seu patch. *Make sure the `README.md` and any other relevant documentation are kept up-to-date.*

- **Consider our release cycle** - Nós tentamos seguir a especificação SemVer v2.0.0. Quebrar aleatóriamente uma API publica não é uma opção. *We try to follow [SemVer v2.0.0](http://semver.org/). Randomly breaking public APIs is not an option.*

- **Create feature branches** - Não nos peça para puxar do seu branch master. *Don't ask us to pull from your master branch.*

- **One pull request per feature** - Se você quiser fazer mais de uma coisa, envie várias solicitações de pull, não coloque tudo de uma vez. *If you want to do more than one thing, send multiple pull requests.*

- **Send coherent history** - Certifique-se que cada commit individual em seu pull request é significativo. Se você tivesse que fazer várias commits intermediários durante o desenvolvimento, por favor junte antes de submeter.  *Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.*

> Quanto PSR-2, são disponibilizados na instalação de desenvolvimento pelo composer, os pacotes phpcs e phpcbf, ambos auxiliam a terefa de deixar o codigo coerente os esses requisitos.
> A forma de usar essas ferramentas é, estando na raiz do projeto e digitar no console:

```sh
vendor/bin/phpcbf --standard=psr2 src/
```
ou alternativamente 
```sh
composer phpcbf
```
O comando acima irá promover a limpeza dos codigos de todos os arquivos .php contidos na pasta src/

```sh
vendor/bin/phpcs --standard=psr2 src/
```
ou alternativamente 
```sh
composer phpcs
```
O comando acima analizar os codigos de todos os arquivos .php contidos na pasta src/ e irá retornar quaisquer erros encontrados, que por sua vez deverão ser corrigidos antes da submissão do pull request.

O mesmo deverá ser executado na pasta tests/ que contêm os testes unitários com o PHPUNIT

## Running Tests

``` bash
$ composer test
```


**Happy coding**!