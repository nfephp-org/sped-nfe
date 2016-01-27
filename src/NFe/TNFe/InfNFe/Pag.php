<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe;

/**
 * Class representing Pag
 */
class Pag
{

    /**
     * Forma de Pagamento:01-Dinheiro;02-Cheque;03-Cartão de Crédito;04-Cartão de
     * Débito;05-Crédito Loja;10-Vale Alimentação;11-Vale Refeição;12-Vale
     * Presente;13-Vale Combustível;99 - Outros
     *
     * @property string $tPag
     */
    private $tPag = null;

    /**
     * Valor do Pagamento
     *
     * @property string $vPag
     */
    private $vPag = null;

    /**
     * Grupo de Cartões
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Pag\Card $card
     */
    private $card = null;

    /**
     * Gets as tPag
     *
     * Forma de Pagamento:01-Dinheiro;02-Cheque;03-Cartão de Crédito;04-Cartão de
     * Débito;05-Crédito Loja;10-Vale Alimentação;11-Vale Refeição;12-Vale
     * Presente;13-Vale Combustível;99 - Outros
     *
     * @return string
     */
    public function getTPag()
    {
        return $this->tPag;
    }

    /**
     * Sets a new tPag
     *
     * Forma de Pagamento:01-Dinheiro;02-Cheque;03-Cartão de Crédito;04-Cartão de
     * Débito;05-Crédito Loja;10-Vale Alimentação;11-Vale Refeição;12-Vale
     * Presente;13-Vale Combustível;99 - Outros
     *
     * @param string $tPag
     * @return self
     */
    public function setTPag($tPag)
    {
        $this->tPag = $tPag;
        return $this;
    }

    /**
     * Gets as vPag
     *
     * Valor do Pagamento
     *
     * @return string
     */
    public function getVPag()
    {
        return $this->vPag;
    }

    /**
     * Sets a new vPag
     *
     * Valor do Pagamento
     *
     * @param string $vPag
     * @return self
     */
    public function setVPag($vPag)
    {
        $this->vPag = $vPag;
        return $this;
    }

    /**
     * Gets as card
     *
     * Grupo de Cartões
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Pag\Card
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Sets a new card
     *
     * Grupo de Cartões
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Pag\Card $card
     * @return self
     */
    public function setCard(\NFePHP\NFe\NFe\TNFe\InfNFe\Pag\Card $card)
    {
        $this->card = $card;
        return $this;
    }


}

