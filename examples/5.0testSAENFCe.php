<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\SAE;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;

/**
 * SAE-NFC-e - Serviços de Apoio à Escrituração da NFC-e
 *
 * Webservice da Prefeitura de São Paulo para consulta e download de XMLs de NFC-e.
 * Documentação: https://portal.fazenda.sp.gov.br/servicos/nfce/Paginas/sae-nfce.aspx
 *
 * REQUISITOS:
 *  - Certificado digital e-CNPJ do contribuinte
 *  - O CNPJ do certificado deve ser o emitente das NFC-es consultadas
 *  - Período máximo de consulta: 100 dias
 *  - Limite de retorno: 2000 chaves por requisição (paginação via dhEmisUltNfce)
 *
 * AMBIENTES:
 *  - SAE::TPAMB_HOMOLOGACAO (2) — homologacao.nfce.fazenda.sp.gov.br
 *  - SAE::TPAMB_PRODUCAO    (1) — nfce.fazenda.sp.gov.br
 */

//Carrega o certificado e-CNPJ do contribuinte.
//O CNPJ presente no certificado é o utilizado como filtro pelo webservice.
$pfxContent  = file_get_contents('../tests/fixtures/certs/novo_expired_certificate.pfx');
$certificate = Certificate::readPfx($pfxContent, 'associacao');

$soap = new SoapFake();
$soap->disableCertValidation(true);

//Instancia a classe SAE informando o estado (UF) e o ambiente desejado.
//Para adicionar outros estados, configure os endpoints em storage/wsae_nfce.json.
$sae = new SAE($certificate, 'SP', SAE::TPAMB_HOMOLOGACAO);
$sae->loadSoapClass($soap);

// ============================================================
// SERVIÇO 1 — NFCeListagemChaves
// Retorna as chaves de acesso das NFC-es autorizadas para o
// CNPJ do certificado em um dado período.
// ============================================================

$dataHoraInicial = '2024-01-01T00:00';
$dataHoraFinal   = '2024-01-31T23:59'; // opcional — omitir para buscar até o momento atual

$responseListagem = $sae->listagemChaves($dataHoraInicial, $dataHoraFinal);

echo "=== NFCeListagemChaves ===\n";
echo "Request:\n" . $sae->lastRequest . "\n\n";
echo "Response:\n" . $responseListagem . "\n\n";

//Interpretação básica da resposta (só aplicável com webservice real; SoapFake retorna JSON)
$dom = new DOMDocument();
if (@$dom->loadXML($responseListagem)) {
    $cStat   = $dom->getElementsByTagName('cStat')->item(0)?->nodeValue;
    $xMotivo = $dom->getElementsByTagName('xMotivo')->item(0)?->nodeValue;
    echo "cStat: $cStat — $xMotivo\n";

    if ($cStat === '100') {
        //Consulta realizada com sucesso — lista completa
        $chaves = $dom->getElementsByTagName('chNFCe');
        echo "Total de chaves retornadas: " . $chaves->length . "\n";
        foreach ($chaves as $chave) {
            echo "  " . $chave->nodeValue . "\n";
        }
    } elseif ($cStat === '101') {
        //Lista incompleta — há mais de 2000 NFC-es no período
        //Use dhEmisUltNfce como próximo dataHoraInicial para paginar
        $dhEmisUltNfce = $dom->getElementsByTagName('dhEmisUltNfce')->item(0)?->nodeValue;
        echo "Lista incompleta. Próximo dataHoraInicial: $dhEmisUltNfce\n";
    } elseif ($cStat === '107') {
        echo "Nenhuma NFC-e encontrada no período informado.\n";
    }
}

// ============================================================
// SERVIÇO 2 — NFCeDownloadXML
// Baixa o XML completo de uma NFC-e (incluindo eventos como
// cancelamento) a partir da chave de acesso.
// O CNPJ na chave deve coincidir com o CNPJ do certificado.
// ============================================================

$chNFCe = '35240193623057000128650010000002401717268120';

$responseDownload = $sae->downloadXML($chNFCe);

echo "\n=== NFCeDownloadXML ===\n";
echo "Request:\n" . $sae->lastRequest . "\n\n";
echo "Response:\n" . $responseDownload . "\n\n";

//Interpretação básica da resposta (só aplicável com webservice real; SoapFake retorna JSON)
if (@$dom->loadXML($responseDownload)) {
    $cStat   = $dom->getElementsByTagName('cStat')->item(0)?->nodeValue;
    $xMotivo = $dom->getElementsByTagName('xMotivo')->item(0)?->nodeValue;
    echo "cStat: $cStat — $xMotivo\n";

    if ($cStat === '200') {
        //Download realizado com sucesso
        //O elemento <proc> contém o XML da NFC-e autorizada e seus eventos
        $nfeProc = $dom->getElementsByTagName('nfeProc')->item(0);
        if ($nfeProc) {
            echo "NFC-e encontrada. Protocolo: "
                . $dom->getElementsByTagName('nProt')->item(0)?->nodeValue . "\n";
        }
        $eventos = $dom->getElementsByTagName('procEventoNFe');
        echo "Eventos associados: " . $eventos->length . "\n";
    }
}
