#NFe

Toda a estrutura das NFe foi desmembrada em um grupo de classes dentro do namespace NFePHP\NFe\Tags, e devem ser instanciadas diretamente pela classe Tag::class.

Essas sub classes que representam os "NODES" do XML recebem como parametro uma stdClass do PHP, e as propriedades dessa stdClass representam os elementos contidos no "NODE".

Existem 15 NODES principais, que podem ser adicionados a classe NFe 

1. [ide](#ide)
2. [NFref](#NFref)
3. [emit](#emit)
4. [dest](#dest)
5. [retirada](#retirada)
6. [entrega](#entrega)
7. [autXML](#autXML)
8. [det](#det)
9. [total](#total)
10. [transp](#transp)
11. [cobr](#cobr)
12. [pag](#pag)
13. [exporta](#exporta)
14. [compra](#compra)
15. [cana](#cana)

Porém vários desses NODES possuem subnodes.
Alguns dos subnodes possuem outros subnodes também e que ao final representam a totalidade dos dados a serem inclusos em uma NFe.


##Classes a adicionar a NFe::class


###<a name="ide"></a>[Ide::class](Ide.md) [ 1 - 1 ]
*OBRIGATÓRIA, identificação do documento, apenas uma instancia é permitida, não possui subnodes*  


###<a name="NFref"></a>[NFref::class](NFref.md) [ 0 - 500 ]
*(opcional), Indica as Notas referenciadas*
*Podem ser criadas até 500 instancias dessa classe, 5 possiveis subnodes, mas apenas um pode ser incluso a cada NFref*

>RefNFe::class  (opcional)  NFe referenciadas [ 0 - 1]

>RefCTe::class  (opcional)  CTe referenciadas [ 0 - 1]

>RefNF::class   (opcional)  NF referenciadas [ 0 - 1]

>RefNFP::class  (opcional)  NFP referenciadas [ 0 - 1]

>RefECF::class  (opcional)  ECF referenciadas [ 0 - 1]

>NOTA: Caso sejam inclusos mais de um subnode em cada instancia da classe principal, apenas um será usado, obedecendo a ordem acima.

###<a name="emit"></a>[Emit::class](Emit.md) [ 1 - 1 ]
*OBRIGATÓRIA, Dados do Emitente, apenas uma instancia*

>EnderEmit::class (OBRIGATÓRIA) Endereco [ 1 - 1 ]

###<a name="dest"></a>[Dest::class](Dest.md) [ 0 - 1 ]
*(opcional em alguns casos), Dados do  Destinatario, se existir, apenas uma instancia é permitida*

>EnderDest::class (opcional) Endereco [ 0 - 1 ], se existir, apenas uma instancia é permitida

###<a name="retirada"></a>[Retirada::class](Retirada.md) [ 0 - 1 ]
*(opcional)  Local da Retirada, se houver, apenas uma instancia é permitida, não possui subnodes*

###<a name="entrega"></a>[Entrega::class](Entrega.md) [ 0 - 1 ]
*(opcional), Local da Entrega, se houver, apenas uma instancia é permitida, não possui subnodes*

###<a name="autXML"></a>[AutXML::class](AutXML.md) [ 0 - 10 ]
*(opcional), Identificação dos autorizados a obter o XML, até 10 instancias são permitidas, não possui subnodes*

###<a name="det"></a>[Det::class](Det.md) [ 1 - 990 ]
*OBRIGATÓRIA, Detalhamento dos itens da NFe, até 990 instancias são permitidas*

>Prod::class (OBRIGATÓRIO) [ 1 - 1 ]

>>DI::class (opcional) [0 - 100] Dados da importação

>>>Adi::class (opcional) [1 - 100] Adições

>>DetExport::class (opcional) [0 - 500] Drawback e exportação

>>>ExportInd::class (opcional) [0 - 1] exportação indireta

>>VeicProd::class (opcional) [0 - 1] Veiculos NOVOS

>>Med::class (opcional) [0 - 500] Medicamentos

>>Arma::class (opcional) [0 - 500] Armamentos e munições

>>Comb::class  (opcional) [0 - 1] Combustiveis

>Imposto::class (OBRIGATÓRIO) [1 - 1] Impostos

>>ICMS::class (opcional) [0 - 1] ICMS

>>ICMSPart::class  (opcional) [0 - 1] ICMS Partilha

>>ICMSST::class  (opcional) [0 - 1] Repasse de ICMS ST retido

>>ICMSSN::class  (opcional) [0 - 1] ICMS Simples Nacional

>>IPI::class (opcional) [0 - 1] Imposto produtos industrializados

>>II::class  (opcional) [0 - 1] Imposto de importação

>>PIS::class (opcional) [0 - 1] Contribuição de PIS

>>COFINS::class (opcional) [0 - 1]  Contribuição de COFINS

>>ISSQN::class (opcional) [0 - 1] Imposto sobre Serviços

>ImpostoDevol::class  (opcional) [0 - 1] Informação do Imposto devolvido

>InfAdProd::class (Opcional) [0 - 500] Informações do produto

###<a name="total"></a>[Total::class](Total.md) [ 1 - 1 ]
*OBRIGATÓRIA, totalizações*

>ICMSTot::class (OBRIGATÓRIO) [1 - 1] Totalizações de Impostos
	
>ISSQNtot::class (opcional) [0 - 1] Totalização de ISS
	
>RetTrib::class (opcional) [0 - 1] Retenção de Tributos

###<a name="transp"></a>[Transp::class](Transp.md) [ 1 - 1 ]
*OBRIGATÓRIA, Informações sobre o transporte*

>Transporta::class (opcional) [0 - 1] Dados da trensportadora
    
>RetTransp::class (opcional) [0 - 1] Retenção ICMS no transporte
    
>VeicTransp::class (opcional) [0 - 1]Dados do veiculo
    
>Reboque::class (opcional) [0 - 5] Dados dos reboques
    
>Vol::class (opcional) [0 - 5000] Dados dos Volumes
>>Lacres::class (opcional) [0 - 5000]  Lacres 

###<a name="cobr"></a>[Cobr::class](Cobr.md) [ 0 - 1 ]
*(opcional em alguns casos)  Cobrança*

    Fat::class (opcional) Dados da Fatura
    Dup::class (opcional) Dados das Duplicatas

###<a name="infAdic"></a>[InfAdic::class](InfAdic.md) [ 0 - 1 ]
*(opcional), Informações adicionais*

>ObsCont::class (opcional) [0-10] Observações do contribuinte
	
>ObsFisco::class (opcional) [0-10] Observações do Fisco
	
>ProcRef::class (opcional) [0-100] Processo Referenciado

###<a name="pag"></a>[Pag::class](Pag.md) [ 0 - 100 ]
*(opcional), Informações sobre o pagamento, até 100 instancias da classe são aceitos*

>Card::class (opcional) [0 - 1], Dados do cartão de crédito ou débito, somente para nodes Pag onde tPag = 3 ou 4, pagamento com cartões. 

###<a name="exporta"></a>[Exporta::class](Exporta.md) [ 0 - 1 ]
*(opcional), Dados de Exportacao, não possui subnodes*

###<a name="compra"></a>[Compra::class](Compra.md) [ 0 - 1 ]
*(opcional), Dados de Compra, não possui subnodes*

###<a name="cana"></a>[Cana::class](Cana.md) [ 0 - 1 ]
*(opcional), Informações do Registro de Aquisição de Cana*

>ForDia::class [0 - 31] (opcional) Fornecimento diário
    
>Deduc::class  [0 - 10] (opcional) Deduções

##Forma de Uso

A classe NFe, possui apenas 2 métodos publicos

**function add(TagInterface $tag);**

Este método recebe como parâmetro uma das 15 tags principais, acima listadas e a adiciona à respectiva propriedade da classe.
 
**function build();**

Este médodo realiza a construção do XML propriamente dita e retorna o XML em uma string.


```php

use NFePHP\NFe\NFe;

//adiona as tags, providas pelas classes construtoras
$nfe->add(Tags\Ide($std));
$nfe->add(Tags\Emit($std));
.
.
.

//monta o XML, com base noa dados providos pelas classes construtoras
$xml = $nfe->build();


```

   