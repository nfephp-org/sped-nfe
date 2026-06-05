<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\SAE;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;
use NFePHP\NFe\Common\FakePretty;

try {

    $soap = new SoapFake();
    $soap->disableCertValidation(true);

    $content = file_get_contents('../tests/fixtures/certs/novo_expired_certificate.pfx');
    $certificate = Certificate::readPfx($content, 'associacao');

    $sae = new SAE($certificate, 'SP', SAE::TPAMB_HOMOLOGACAO);
    $sae->loadSoapClass($soap);

    // -----------------------------------------------------------
    // SERVIÇO 1 — NFCeListagemChaves
    // -----------------------------------------------------------
    $dataHoraInicial = '2024-01-01T00:00';
    $dataHoraFinal   = '2024-01-31T23:59';

    $response = $sae->listagemChaves($dataHoraInicial, $dataHoraFinal);

    echo "<h3>NFCeListagemChaves — Request</h3>";
    echo FakePretty::prettyPrint($sae->lastRequest);

    echo "<h3>NFCeListagemChaves — Response</h3>";
    echo FakePretty::prettyPrint($response);

    // -----------------------------------------------------------
    // SERVIÇO 2 — NFCeDownloadXML
    // -----------------------------------------------------------
    $chNFCe = '35240193623057000128650010000002401717268120';

    $response = $sae->downloadXML($chNFCe);

    echo "<h3>NFCeDownloadXML — Request</h3>";
    echo FakePretty::prettyPrint($sae->lastRequest);

    echo "<h3>NFCeDownloadXML — Response</h3>";
    echo FakePretty::prettyPrint($response);

} catch (\Exception $e) {
    echo $e->getMessage();
}
