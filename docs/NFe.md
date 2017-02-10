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


###<a name="ide"></a>[Ide::class](Ide.md)
*OBRIGATÓRIA, identificação do documento*  


###<a name="NFref"></a>[NFref::class](NFref.md) 
*(opcional), Indica as Notas referenciadas*

    RefNFe::class  (opcional)  NFe referenciadas
    RefCTe::class  (opcional)  CTe referenciadas
    RefNF::class   (opcional)  NF referenciadas
    RefNFP::class  (opcional)  NFP referenciadas
    RefECF::class  (opcional)  ECF referenciadas

###<a name="emit"></a>[Emit::class](Emit.md)
*OBRIGATÓRIA, Dados do Emitente*

    EnderEmit::class (OBRIGATÓRIA) Endereco

###<a name="dest"></a>[Dest::class](Dest.md)
*(opcional em alguns casos), Dados do  Destinatario

    EnderDest::class (opcional) Endereco

###<a name="retirada"></a>[Retirada::class](Retirada.md)
*(opcional)  Local da Retirada*

###<a name="entrega"></a>[Entrega::class](Entrega.md)
*(opcional), Local da Entrega*

###<a name="autXML"></a>[AutXML::class](AutXML.md)
*(opcional), Identificação dos autorizados a obter o XML*

###<a name="det"></a>[Det::class](Det.md)
*OBRIGATÓRIA, Detalhamento dos itens da NFe*

	Prod::class (OBRIGATÓRIO) 
	InfAdProd::class (Opcional) [0 - 500] Informações do produto

###<a name="total"></a>[Total::class](Total.md)
*OBRIGATÓRIA, totalizações*

	ICMSTot::class (OBRIGATÓRIO) Totalizações de Impostos
	
	ISSQNtot::class (opcional) Totalização de ISS
	
	RetTrib::class (opcional) Retenção de Tributos

###<a name="transp"></a>[Transp::class](Transp.md)
*OBRIGATÓRIA, Informações sobre o transporte*

    Transporta::class (opcional) Dados da trensportadora
    
    RetTransp::class (opcional) Retenção ICMS no transporte
    
    VeicTransp::class (opcional) Dados do veiculo
    
    Reboque::class (opcional) [0 - 5] Dados dos reboques
    
    Vol::class (opcional) [0 - 5000] Dados dos Volumes
    		Lacres::class (opcional) [0 - 5000]  Lacres 

###<a name="cabr"></a>[Cobr::class](Cobr.md)
*(opcional em alguns casos)  Cobrança*

    Fat::class (opcional) Dados da Fatura
    Dup::class (opcional) Dados das Duplicatas

###<a name="infAdic"></a>[InfAdic::class](InfAdic.md)
*(opcional), Informações adicionais*

	ObsCont::class (opcional) Observações do contribuinte
	
	ObsFisco::class (opcional) Observações do Fisco
	
	ProcRef::class (opcional) Processo Referenciado

###<a name="pag"></a>[Pag::class](Pag.md)
*(opcional), Informações sobre o pagamento*

###<a name="exporta"></a>[Exporta::class](Exporta.md)
*(opcional), Dados de Exportacao*

###<a name="compra"></a>[Compra::class](Compra.md)
*(opcional), Dados de Compra*

###<a name="cana"></a>[Cana::class](Cana.md)
*(opcional), Informações do Registro de Aquisição de Cana*

    ForDia::class [0 - 31] (opcional) Fornecimento diário
    
    Deduc::class  [0 - 10] (opcional) Deduções

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

   