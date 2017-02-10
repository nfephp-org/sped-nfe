<?php

namespace NFePHP\NFe;

use \InvalidArgumentException;

class Tag
{
    private static $available = [
        'ide'       => Tags\Ide::class,
        'emit'      => Tags\Emit::class,
        'enderemit' => Tags\EnderEmit::class,
        'dest'      => Tags\Dest::class,
        'enderdest' => Tags\EnderDest::class,
        'refnfe'    => Tags\RefNFe::class,
        'refnf'     => Tags\RefNF::class,
        'refnfp'    => Tags\RefNFP::class,
        'refcte'    => Tags\RefCTe::class,
        'refecf'    => Tags\RefECF::class,
        'retirada'  => Tags\Retirada::class,
        'entrega'   => Tags\Entrega::class,
        'autxml'    => Tags\AutXML::class,
        'transp'    => Tags\Transp::class,
        'transporta'=> Tags\Transporta::class,
        'rettransp' => Tags\RetTransp::class,
        'veicTransp'=> Tags\VeicTransp::class,
        'reboque'   => Tags\Reboque::class,
        'vol'       => Tags\Vol::class,
        'lacres'    => Tags\Lacres::class,
        'fat'       => Tags\Fat::class,
        'dup'       => Tags\Dup::class,
        'pag'       => Tags\Pag::class,
        'card'      => Tags\Card::class,
        'infadic'   => Tags\InfAdic::class,
        'obscont'   => Tags\ObsCont::class,
        'obsfisco'  => Tags\ObsFisco::class,
        'procref'   => Tags\ProcRef::class,
        'exporta'   => Tags\Exporta::class,
        'compra'    => Tags\Compra::class,
        'cana'      => Tags\Cana::class,
        'fordia'    => Tags\ForDia::class,
        'deduc'     => Tags\Deduc::class,
        
        
        
/*
    
    prod
    Rastro
    NVE
    CEST
    RECOPI
    infAdProd
    DI
    adi
    detExport
    veicProd
    med
    arma
    comb
    encerrante
    imposto
    ICMS
    ICMSPart
    ICMSST
    ICMSSN
    ICMSUFDest
    IPI
    II
    PIS
    PISST
    COFINS
    COFINSST
    ISSQN
    impostoDevol
    ICMSTot
    ISSQNTot
    retTrib
    
*/
    ];
    
    public static function __callStatic($name, $arguments)
    {
        $className = self::$available[strtolower($name)];
        if (empty($className)) {
            throw new InvalidArgumentException('Esta tag não foi encontrada.');
        }
        return new $className($arguments[0]);
    }
}
