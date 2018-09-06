# FUNCIONALIDADES DA API

Os processos envolvendo a gestão de NFe, são vários e alguns um tanto "complexos".

# As operações cobertas por este projeto são:

## Converter um TXT no padrão da SEFAZ em um XML

Muitos sistemas legados, tem dificuldade em trabalhar diretamente com XML, então a melhor forma de integra-los ao NFePHP é fazendo com que criem as NFe em um formato intermediário em TXT onde os campos são separados por "pipes" (|) e cada linha é um determinado conjunto de informações que irão compor a NFe.

Para estabelecer a estrutura do TXT, foi preciso fazer engenharia reversa usando o emissor gratuito fornecido pela SEFAZ, pois o manual disponível contêm erros e omissões (não é mantido atualizado).

Algumas informações úteis sobre a estutura desse TXT podem ser obtidas aqui [Estrutura do TXT para NFe](EstruturaTxt.md)

Pois bem, como esse TXT não pode ser usado diretamente, devemos fazer sua conversão para xml, e para isso usamos a classe **Convert::class**, para maiores detalhes e exemplos de uso consulte [Convert::class](Convert.md)

Leia [Convert::class](Convert.md)

## Montagem direta do XML

A API pode montar diretamente os xml com o uso da classe Make:class


Leia [Make (construtor de XML)](Make.md)


## Contingência

O uso dos sistemas de contingência é uma necessidade e para isso deve ser instanciada e injetada a class Contingency::class.
Os dados referentes a contignência devem ser mantidos de alguma forma pelo aplicativo. 
Estão disponíveis alguns modos de contingência (SVC, EPEC, FS-DA e OFF-LINE).

Leia [Gerenciamento de Contingências](Contingency.md)

## Certificado digital e outros recursos necessários ao funcionamento da API

Leia [nfephp-org/sped-common](https://github.com/nfephp-org/sped-common)

## Interação com os webservices

Leia [Ferramentas de comunicação](Tools.md)

## Facilidades para a leitura dos dados retornados dos XML

Leia [Ferramentas de leitura e conversão dos XML em outros formatos](Standardize.md)


## Armazenamento e envio dos documentos fiscais

Leia [Complementos](Complements.md)


## [Notas sobre TimeOUT](TimeOut.md)

## Impressão dos DANFES

[nfephp-org/sped-da](https://github.com/nfephp-org/sped-da)
[nfephp-org/posprint](https://github.com/nfephp-org/posprint)

## Envio de emails aos destinatários

[nfephp-org/sped-mail](https://github.com/nfephp-org/sped-mail)

## Obtenção de dados sobre impostos 

[nfephp-org/sped-ibpt](https://github.com/nfephp-org/sped-ibpt)

## Geração dos GNRE

[nfephp-org/sped-gnre](https://github.com/nfephp-org/sped-gnre)


