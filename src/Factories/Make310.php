<?php

namespace NFePHP\NFe\Factories;

/**
 * Classe a construção do xml da NFe modelo 55 e modelo 65
 * Apenas para a versão 3.10 do layout
 * @category  NFePHP
 * @package   NFePHP\NFe\Factories\Make310
 * @copyright Copyright (c) 2008-2017
 * @copyright NFePHP Copyright (c) 2008
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\NFe\Factories\MakeBasic;
use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use \RuntimeException;
use \DOMDocument;
use \DOMElement;
use \DOMNode;

class Make310 extends MakeBasic
{
    /**
     * @var string
     */
    protected $versao = '3.10';

    public function __construct()
    {
        parent::__construct();
    }

    
    /**
     * Detalhamento de medicamentos K01 pai I90
     * tag NFe/infNFe/det[]/prod/med (opcional)
     * @param  string $nItem
     * @param  string $nLote
     * @param  string $qLote
     * @param  string $dFab
     * @param  string $dVal
     * @param  string $vPMC
     * @return DOMElement
     */
    public function tagmed(
        $nItem = '',
        $nLote = '',
        $qLote = '',
        $dFab = '',
        $dVal = '',
        $vPMC = ''
    ) {
        $identificador = 'K01 <med> - ';
        $med = $this->dom->createElement("med");
        $this->dom->addChild(
            $med,
            "nLote",
            $nLote,
            true,
            "$identificador [item $nItem] Número do Lote de medicamentos ou de matérias-primas farmacêuticas"
        );
        $this->dom->addChild(
            $med,
            "qLote",
            $qLote,
            true,
            "$identificador [item $nItem] Quantidade de produto no Lote de medicamentos "
                . "ou de matérias-primas farmacêuticas"
        );
        $this->dom->addChild(
            $med,
            "dFab",
            $dFab,
            true,
            "$identificador [item $nItem] Data de fabricação"
        );
        $this->dom->addChild(
            $med,
            "dVal",
            $dVal,
            true,
            "$identificador [item $nItem] Data de validade"
        );
        $this->dom->addChild(
            $med,
            "vPMC",
            $vPMC,
            true,
            "$identificador [item $nItem] Preço máximo consumidor"
        );
        $this->aMed[$nItem] = $med;
        return $med;
    }
      
    /**
     * Grupo de Formas de Pagamento YA01 pai A01
     * tag NFe/infNFe/pag (opcional)
     * Apenas para o modelo 65 NFCe
     * @param  string $tPag
     * @param  string $vPag
     * @return DOMElement
     */
    public function tagpag(
        $tPag = '',
        $vPag = ''
    ) {
        $num = $this->buildPag();
        $pag = $this->dom->createElement("pag");
        $this->dom->addChild(
            $this->aPag[$num-1],
            "tPag",
            $tPag,
            true,
            "Forma de pagamento"
        );
        $this->dom->addChild(
            $this->aPag[$num-1],
            "vPag",
            $vPag,
            true,
            "Valor do Pagamento"
        );
        return $pag;
    }
}
