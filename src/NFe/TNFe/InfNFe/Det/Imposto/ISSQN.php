<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto;

/**
 * Class representing ISSQN
 */
class ISSQN
{

    /**
     * Valor da BC do ISSQN
     *
     * @property string $vBC
     */
    private $vBC = null;

    /**
     * Alíquota do ISSQN
     *
     * @property string $vAliq
     */
    private $vAliq = null;

    /**
     * Valor da do ISSQN
     *
     * @property string $vISSQN
     */
    private $vISSQN = null;

    /**
     * Informar o município de ocorrência do fato gerador do ISSQN. Utilizar a Tabela
     * do IBGE (Anexo VII - Tabela de UF, Município e País). “Atenção, não
     * vincular com os campos B12, C10 ou E10” v2.0
     *
     * @property string $cMunFG
     */
    private $cMunFG = null;

    /**
     * Informar o Item da lista de serviços da LC 116/03 em que se classifica o
     * serviço.
     *
     * @property string $cListServ
     */
    private $cListServ = null;

    /**
     * Valor dedução para redução da base de cálculo
     *
     * @property string $vDeducao
     */
    private $vDeducao = null;

    /**
     * Valor outras retenções
     *
     * @property string $vOutro
     */
    private $vOutro = null;

    /**
     * Valor desconto incondicionado
     *
     * @property string $vDescIncond
     */
    private $vDescIncond = null;

    /**
     * Valor desconto condicionado
     *
     * @property string $vDescCond
     */
    private $vDescCond = null;

    /**
     * Valor Retenção ISS
     *
     * @property string $vISSRet
     */
    private $vISSRet = null;

    /**
     * Exibilidade do ISS:1-Exigível;2-Não
     * incidente;3-Isenção;4-Exportação;5-Imunidade;6-Exig.Susp.
     * Judicial;7-Exig.Susp. ADM
     *
     * @property string $indISS
     */
    private $indISS = null;

    /**
     * Código do serviço prestado dentro do município
     *
     * @property string $cServico
     */
    private $cServico = null;

    /**
     * Código do Município de Incidência do Imposto
     *
     * @property string $cMun
     */
    private $cMun = null;

    /**
     * Código do país onde o serviço foi prestado
     *
     * @property string $cPais
     */
    private $cPais = null;

    /**
     * Número do Processo administrativo ou judicial de suspenção do processo
     *
     * @property string $nProcesso
     */
    private $nProcesso = null;

    /**
     * Indicador de Incentivo Fiscal. 1=Sim; 2=Não
     *
     * @property string $indIncentivo
     */
    private $indIncentivo = null;

    /**
     * Gets as vBC
     *
     * Valor da BC do ISSQN
     *
     * @return string
     */
    public function getVBC()
    {
        return $this->vBC;
    }

    /**
     * Sets a new vBC
     *
     * Valor da BC do ISSQN
     *
     * @param string $vBC
     * @return self
     */
    public function setVBC($vBC)
    {
        $this->vBC = $vBC;
        return $this;
    }

    /**
     * Gets as vAliq
     *
     * Alíquota do ISSQN
     *
     * @return string
     */
    public function getVAliq()
    {
        return $this->vAliq;
    }

    /**
     * Sets a new vAliq
     *
     * Alíquota do ISSQN
     *
     * @param string $vAliq
     * @return self
     */
    public function setVAliq($vAliq)
    {
        $this->vAliq = $vAliq;
        return $this;
    }

    /**
     * Gets as vISSQN
     *
     * Valor da do ISSQN
     *
     * @return string
     */
    public function getVISSQN()
    {
        return $this->vISSQN;
    }

    /**
     * Sets a new vISSQN
     *
     * Valor da do ISSQN
     *
     * @param string $vISSQN
     * @return self
     */
    public function setVISSQN($vISSQN)
    {
        $this->vISSQN = $vISSQN;
        return $this;
    }

    /**
     * Gets as cMunFG
     *
     * Informar o município de ocorrência do fato gerador do ISSQN. Utilizar a Tabela
     * do IBGE (Anexo VII - Tabela de UF, Município e País). “Atenção, não
     * vincular com os campos B12, C10 ou E10” v2.0
     *
     * @return string
     */
    public function getCMunFG()
    {
        return $this->cMunFG;
    }

    /**
     * Sets a new cMunFG
     *
     * Informar o município de ocorrência do fato gerador do ISSQN. Utilizar a Tabela
     * do IBGE (Anexo VII - Tabela de UF, Município e País). “Atenção, não
     * vincular com os campos B12, C10 ou E10” v2.0
     *
     * @param string $cMunFG
     * @return self
     */
    public function setCMunFG($cMunFG)
    {
        $this->cMunFG = $cMunFG;
        return $this;
    }

    /**
     * Gets as cListServ
     *
     * Informar o Item da lista de serviços da LC 116/03 em que se classifica o
     * serviço.
     *
     * @return string
     */
    public function getCListServ()
    {
        return $this->cListServ;
    }

    /**
     * Sets a new cListServ
     *
     * Informar o Item da lista de serviços da LC 116/03 em que se classifica o
     * serviço.
     *
     * @param string $cListServ
     * @return self
     */
    public function setCListServ($cListServ)
    {
        $this->cListServ = $cListServ;
        return $this;
    }

    /**
     * Gets as vDeducao
     *
     * Valor dedução para redução da base de cálculo
     *
     * @return string
     */
    public function getVDeducao()
    {
        return $this->vDeducao;
    }

    /**
     * Sets a new vDeducao
     *
     * Valor dedução para redução da base de cálculo
     *
     * @param string $vDeducao
     * @return self
     */
    public function setVDeducao($vDeducao)
    {
        $this->vDeducao = $vDeducao;
        return $this;
    }

    /**
     * Gets as vOutro
     *
     * Valor outras retenções
     *
     * @return string
     */
    public function getVOutro()
    {
        return $this->vOutro;
    }

    /**
     * Sets a new vOutro
     *
     * Valor outras retenções
     *
     * @param string $vOutro
     * @return self
     */
    public function setVOutro($vOutro)
    {
        $this->vOutro = $vOutro;
        return $this;
    }

    /**
     * Gets as vDescIncond
     *
     * Valor desconto incondicionado
     *
     * @return string
     */
    public function getVDescIncond()
    {
        return $this->vDescIncond;
    }

    /**
     * Sets a new vDescIncond
     *
     * Valor desconto incondicionado
     *
     * @param string $vDescIncond
     * @return self
     */
    public function setVDescIncond($vDescIncond)
    {
        $this->vDescIncond = $vDescIncond;
        return $this;
    }

    /**
     * Gets as vDescCond
     *
     * Valor desconto condicionado
     *
     * @return string
     */
    public function getVDescCond()
    {
        return $this->vDescCond;
    }

    /**
     * Sets a new vDescCond
     *
     * Valor desconto condicionado
     *
     * @param string $vDescCond
     * @return self
     */
    public function setVDescCond($vDescCond)
    {
        $this->vDescCond = $vDescCond;
        return $this;
    }

    /**
     * Gets as vISSRet
     *
     * Valor Retenção ISS
     *
     * @return string
     */
    public function getVISSRet()
    {
        return $this->vISSRet;
    }

    /**
     * Sets a new vISSRet
     *
     * Valor Retenção ISS
     *
     * @param string $vISSRet
     * @return self
     */
    public function setVISSRet($vISSRet)
    {
        $this->vISSRet = $vISSRet;
        return $this;
    }

    /**
     * Gets as indISS
     *
     * Exibilidade do ISS:1-Exigível;2-Não
     * incidente;3-Isenção;4-Exportação;5-Imunidade;6-Exig.Susp.
     * Judicial;7-Exig.Susp. ADM
     *
     * @return string
     */
    public function getIndISS()
    {
        return $this->indISS;
    }

    /**
     * Sets a new indISS
     *
     * Exibilidade do ISS:1-Exigível;2-Não
     * incidente;3-Isenção;4-Exportação;5-Imunidade;6-Exig.Susp.
     * Judicial;7-Exig.Susp. ADM
     *
     * @param string $indISS
     * @return self
     */
    public function setIndISS($indISS)
    {
        $this->indISS = $indISS;
        return $this;
    }

    /**
     * Gets as cServico
     *
     * Código do serviço prestado dentro do município
     *
     * @return string
     */
    public function getCServico()
    {
        return $this->cServico;
    }

    /**
     * Sets a new cServico
     *
     * Código do serviço prestado dentro do município
     *
     * @param string $cServico
     * @return self
     */
    public function setCServico($cServico)
    {
        $this->cServico = $cServico;
        return $this;
    }

    /**
     * Gets as cMun
     *
     * Código do Município de Incidência do Imposto
     *
     * @return string
     */
    public function getCMun()
    {
        return $this->cMun;
    }

    /**
     * Sets a new cMun
     *
     * Código do Município de Incidência do Imposto
     *
     * @param string $cMun
     * @return self
     */
    public function setCMun($cMun)
    {
        $this->cMun = $cMun;
        return $this;
    }

    /**
     * Gets as cPais
     *
     * Código do país onde o serviço foi prestado
     *
     * @return string
     */
    public function getCPais()
    {
        return $this->cPais;
    }

    /**
     * Sets a new cPais
     *
     * Código do país onde o serviço foi prestado
     *
     * @param string $cPais
     * @return self
     */
    public function setCPais($cPais)
    {
        $this->cPais = $cPais;
        return $this;
    }

    /**
     * Gets as nProcesso
     *
     * Número do Processo administrativo ou judicial de suspenção do processo
     *
     * @return string
     */
    public function getNProcesso()
    {
        return $this->nProcesso;
    }

    /**
     * Sets a new nProcesso
     *
     * Número do Processo administrativo ou judicial de suspenção do processo
     *
     * @param string $nProcesso
     * @return self
     */
    public function setNProcesso($nProcesso)
    {
        $this->nProcesso = $nProcesso;
        return $this;
    }

    /**
     * Gets as indIncentivo
     *
     * Indicador de Incentivo Fiscal. 1=Sim; 2=Não
     *
     * @return string
     */
    public function getIndIncentivo()
    {
        return $this->indIncentivo;
    }

    /**
     * Sets a new indIncentivo
     *
     * Indicador de Incentivo Fiscal. 1=Sim; 2=Não
     *
     * @param string $indIncentivo
     * @return self
     */
    public function setIndIncentivo($indIncentivo)
    {
        $this->indIncentivo = $indIncentivo;
        return $this;
    }


}

