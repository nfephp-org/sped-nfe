#NFe

Toda a estrutura das NFe foi desmembrada em um grupo de classes dentro do namespace NFePHP\NFe\Tags, e devem ser instanciadas diretamente pela classe Tag::class.

Essas sub classes que representam os "NODES" do XML recebem como parametro uma stdClass do PHP, e as propriedades dessa stdClass representam os elementos contidos no "NODE".

Existem 15 NODES principais, que podem ser adicionados a classe NFe 

1. ide
2. NFref
3. emit
4. dest
5. retirada
6. entrega
7. autXML
8. det
9. total
10. transp
11. cobr
12. pag
13. exporta
14. compra
15. cana

Porém vários desses NODES possuem subnodes.
Alguns dos subnodes possuem outros subnode também e que ao final representam a totalidade dos dados a serem inclusos em uma NFe.


##Classes a adicionar a NFe::class


###[Ide::class](Ide.md)
*OBRIGATÓRIA, identificação do documento*  


###[NFref::class](NFref.md) 
*(opcional), Indica as Notas referenciadas*

    RefNFe::class  (opcional)  NFe referenciadas
    RefCTe::class  (opcional)  CTe referenciadas
    RefNF::class   (opcional)  NF referenciadas
    RefNFP::class  (opcional)  NFP referenciadas
    RefECF::class  (opcional)  ECF referenciadas

###[Emit::class](Emit.md)
*OBRIGATÓRIA, Dados do Emitente*

    EnderEmit::class (OBRIGATÓRIA) Endereco

###[Dest::class](Dest.md)
*(opcional em alguns casos), Dados do  Destinatario

    EnderDest::class (opcional) Endereco

###[Retirada::class](Retirada.md)
*(opcional)  Local da Retirada*

###[Entrega::class](Entrega.md)
*(opcional), Local da Entrega*

###[AutXML::class](AutXML.md)
*(opcional), Identificação dos autorizados a obter o XML*

###[Det::class](Det.md)
*OBRIGATÓRIA, Detalhamento dos itens da NFe*

	Prod::class (OBRIGATÓRIO) 
	InfAdProd::class (Opcional) [0 - 500] Informações do produto

###[Total::class](Total.md)
*OBRIGATÓRIA, totalizações*

	ICMSTot::class (OBRIGATÓRIO) Totalizações de Impostos
	
	ISSQNtot::class (opcional) Totalização de ISS
	
	RetTrib::class (opcional) Retenção de Tributos

###[Transp::class](Transp.md)
*OBRIGATÓRIA, Informações sobre o transporte*

    Transporta::class (opcional) Dados da trensportadora
    
    RetTransp::class (opcional) Retenção ICMS no transporte
    
    VeicTransp::class (opcional) Dados do veiculo
    
    Reboque::class (opcional) [0 - 5] Dados dos reboques
    
    Vol::class (opcional) [0 - 5000] Dados dos Volumes
    		Lacres::class (opcional) [0 - 5000]  Lacres 

###[Cobr::class](Cobr.md)
*(opcional em alguns casos)  Cobrança*

    Fat::class (opcional) Dados da Fatura
    Dup::class (opcional) Dados das Duplicatas

###[InfAdic::class](InfAdic.md)
*(opcional), Informações adicionais*

	ObsCont::class (opcional) Observações do contribuinte
	
	ObsFisco::class (opcional) Observações do Fisco
	
	ProcRef::class (opcional) Processo Referenciado

###[Pag::class](Pag.md)
*(opcional), Informações sobre o pagamento*

###[Exporta::class](Exporta.md)
*(opcional), Dados de Exportacao*

###[Compra::class](Compra.md)
*(opcional), Dados de Compra*

###[Cana::class](Cana.md)
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

   