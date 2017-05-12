# FUNCIONALIDADES DA API

Os processos envolvendo a gestão de NFe, são vários e alguns um tanto "complexos".

# As operações cobertas por este projeto são:

## Converter um TXT no padrão da SEFAZ em um XML

Muitos sistemas legados, tem dificuldade em trabalhar diretamente com XML, então a melhor forma de integra-los ao NFePHP é fazendo com que criem as NFe em um formato intermediário em TXT onde os campos são separados por "pipes" (|) e cada linha é um determinado conjunto de informações que irão compor a NFe.

Para estabelecer a estrutura do TXT, foi preciso fazer engenharia reversa usando o emissor gratuito fornecido pela SEFAZ, pois o manual disponível contêm erros e omissões (não é mantido atualizado).

Algumas informações úteis sobre a estutura desse TXT podem ser obtidas aqui [Estrutura do TXT para NFe](EstruturaTxt.md)

Pois bem, como esse TXT não pode ser usado diretamente temos a faze em que devemos fazer sua conversão para xml, e para isso usamos a classe **Convert::class**, para maiores detalhes e exemplos de uso consulte [Convert::class](Convert.md)



## [Contingência](Contingency.md)
## [NFe\Make::class](Make.md)
## [NFe\Tools::class](Tools.md)
## [Complementos](Complements.md)
## [Standardize](Standardize.md)
