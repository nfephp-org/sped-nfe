<?php

namespace NFePHP\NFe;

/**
 * Class NFe Tag constructor
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Tag
 * @copyright NFePHP Copyright (c) 2008 - 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use \InvalidArgumentException;

class Tag
{
    private static $available = [
        'ide'       => Tags\Ide::class,
        
        'emit'      => Tags\Emit::class,
        'enderemit' => Tags\Emit\EnderEmit::class,
        
        'dest'      => Tags\Dest::class,
        'enderdest' => Tags\Dest\EnderDest::class,
        
        'refnfe'    => Tags\NFref\RefNFe::class,
        'refnf'     => Tags\NFref\RefNF::class,
        'refnfp'    => Tags\NFref\RefNFP::class,
        'refcte'    => Tags\NFref\RefCTe::class,
        'refecf'    => Tags\NFref\RefECF::class,
        
        'retirada'  => Tags\Retirada::class,
        'entrega'   => Tags\Entrega::class,
        'autxml'    => Tags\AutXML::class,
        
        'det'       => Tags\Det::class,
        'prod'      => Tags\Det\Prod::class,
        'veicprod'  => Tags\Det\Prod\VeicProd::class,
        'med'       => Tags\Det\Prod\Med::class,
        'arma'      => Tags\Det\Prod\Arma::class,
        'comb'      => Tags\Det\Prod\Comb::class,
        'cide'      => Tags\Det\Prod\Comb\Cide::class,
        'rastro'    => Tags\Det\Prod\Rastro::class,
        
        'di'        => Tags\Det\DI::class,
        'adi'       => Tags\Det\DI\Adi::class,
        
        'infadprod' => Tags\Det\Prod\InfAdProd::class,
        
        'rastro'    => Tags\Rastro::class,
        'nve'       => Tags\Nve::class,
        'cest'      => Tags\Cest::class,
        'recopi'    => Tags\Recopi::class,
                
        'imposto'   => Tags\Det\Imposto::class,
        'icms'      => Tags\Det\Imposto\Icms::class,
        'icmspart'  => Tags\Det\Imposto\IcmsPart::class,
        'icmsst'    => Tags\Det\Imposto\IcmsST::class,
        'icmssn'    => Tags\Det\Imposto\IcmsSN::class,
        'icmsufdest'=> Tags\Det\Imposto\IcmsUFDest::class,
        'ipi'       => Tags\Det\Imposto\Ipi::class,
        'ii'        => Tags\Det\Imposto\II::class,
        'pis'       => Tags\Det\Imposto\Pis::class,
        'pisst'     => Tags\Det\Imposto\PisST::class,
        'cofins'    => Tags\Det\Imposto\Cofins::class,
        'cofinsst'  => Tags\Det\Imposto\CofinsST::class,
        'issqn'     => Tags\Det\Imposto\IssQN::class,
        
        'impostodevol'=> Tags\Det\ImpostoDevol::class,
        
        'total'     => Tags\Total::class,
        'icmstot'   => Tags\Total\IcmsTot::class,
        'issqntot'  => Tags\Total\IssQNTot::class,
        'rettrib'   => Tags\Total\RetTrib::class,
        
        'transp'    => Tags\Transp::class,
        'transporta'=> Tags\Transp\Transporta::class,
        'rettransp' => Tags\Transp\RetTransp::class,
        'veicTransp'=> Tags\Transp\VeicTransp::class,
        'reboque'   => Tags\Transp\Reboque::class,
        'vol'       => Tags\Transp\Vol::class,
        'lacres'    => Tags\Transp\Lacres::class,
        
        'cobr'      => Tags\Cobr::class,
        'fat'       => Tags\Cobr\Fat::class,
        'dup'       => Tags\Cobr\Dup::class,
        'pag'       => Tags\Pag::class,
        'card'      => Tags\Pag\Card::class,
        
        'infadic'   => Tags\InfAdic::class,
        'obscont'   => Tags\InfAdic\ObsCont::class,
        'obsfisco'  => Tags\InfAdic\ObsFisco::class,
        'procref'   => Tags\InfAdic\ProcRef::class,
        'exporta'   => Tags\Exporta::class,
        'compra'    => Tags\Compra::class,

        'detexport' => Tags\DetExport::class,
        'encerrante'=> Tags\Encerrante::class,

        
        'cana'      => Tags\Cana::class,
        'fordia'    => Tags\Cana\ForDia::class,
        'deduc'     => Tags\Cana\Deduc::class,
        
        
        
    ];
    
    /**
     * Call classes to build XML NFe
     * @param type $name
     * @param type $arguments
     * @return \NFePHP\NFe\className
     * @throws InvalidArgumentException
     */
    public static function __callStatic($name, $arguments)
    {
        $className = self::$available[strtolower($name)];
        if (empty($className)) {
            throw new InvalidArgumentException('Tag name not found.');
        }
        return new $className($arguments[0]);
    }
}
