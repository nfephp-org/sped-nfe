<?php

namespace App\Helpers\Fiscal;

class NfePagto
{
    private $tPag;
    private $vPag;
    private $vTroco;

    private $card;

    /**
     * @return mixed
     */
    public function getTPag()
    {
        return $this->tPag;
    }

    /**
     * @param mixed $tPag
     */
    public function setTPag($tPag)
    {
        $this->tPag = $tPag;
    }

    /**
     * @return mixed
     */
    public function getVPag()
    {
        return $this->vPag;
    }

    /**
     * @param mixed $vPag
     */
    public function setVPag($vPag)
    {
        $this->vPag = $vPag;
    }

    /**
     * @return mixed
     */
    public function getVTroco()
    {
        return $this->vTroco;
    }

    /**
     * @param mixed $vTroco
     */
    public function setVTroco($vTroco)
    {
        $this->vTroco = $vTroco;
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     */
    public function setCard(\App\Helpers\Fiscal\NfeCard $card)
    {
        $this->card = $card;
    }

    public function addCard(\App\Helpers\Fiscal\NfeCard $card)
    {
        $this->card[] = $card;
    }





}