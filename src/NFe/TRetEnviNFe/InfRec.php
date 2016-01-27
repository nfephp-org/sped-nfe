<?php

namespace NFePHP\NFe\NFe\TRetEnviNFe;

/**
 * Class representing InfRec
 */
class InfRec
{

    /**
     * Número do Recibo
     *
     * @property string $nRec
     */
    private $nRec = null;

    /**
     * Tempo médio de resposta do serviço (em segundos) dos últimos 5 minutos
     *
     * @property string $tMed
     */
    private $tMed = null;

    /**
     * Gets as nRec
     *
     * Número do Recibo
     *
     * @return string
     */
    public function getNRec()
    {
        return $this->nRec;
    }

    /**
     * Sets a new nRec
     *
     * Número do Recibo
     *
     * @param string $nRec
     * @return self
     */
    public function setNRec($nRec)
    {
        $this->nRec = $nRec;
        return $this;
    }

    /**
     * Gets as tMed
     *
     * Tempo médio de resposta do serviço (em segundos) dos últimos 5 minutos
     *
     * @return string
     */
    public function getTMed()
    {
        return $this->tMed;
    }

    /**
     * Sets a new tMed
     *
     * Tempo médio de resposta do serviço (em segundos) dos últimos 5 minutos
     *
     * @param string $tMed
     * @return self
     */
    public function setTMed($tMed)
    {
        $this->tMed = $tMed;
        return $this;
    }


}

