<?php

return [
    /*
    |--------------------------------------------------------------------------
    | URLs for NFC-e
    |--------------------------------------------------------------------------
    |
    | Here you define the URLs for NFC-e consultation in each state.
    | The keys are the state acronyms, and the values are the URLs.
    | The first level of the array is for production URLs, and the second level
    | is for homologation URLs.
    |
    */
    'nfce' => [
        '1' => [ // Production
            'AC' => env('NFCE_URL_AC_PROD', 'www.sefaznet.ac.gov.br/nfce/consulta'),
            'AL' => env('NFCE_URL_AL_PROD', 'www.sefaz.al.gov.br/nfce/consulta'),
            'AP' => env('NFCE_URL_AP_PROD', 'www.sefaz.ap.gov.br/nfce/consulta'),
            'AM' => env('NFCE_URL_AM_PROD', 'www.sefaz.am.gov.br/nfce/consulta'),
            'BA' => env('NFCE_URL_BA_PROD', 'http://www.sefaz.ba.gov.br/nfce/consulta'),
            'CE' => env('NFCE_URL_CE_PROD', 'www.sefaz.ce.gov.br/nfce/consulta'),
            'DF' => env('NFCE_URL_DF_PROD', 'www.fazenda.df.gov.br/nfce/consulta'),
            'ES' => env('NFCE_URL_ES_PROD', 'www.sefaz.es.gov.br/nfce/consulta'),
            'GO' => env('NFCE_URL_GO_PROD', 'www.sefaz.go.gov.br/nfce/consulta'),
            'MA' => env('NFCE_URL_MA_PROD', 'www.sefaz.ma.gov.br/nfce/consulta'),
            'MG' => env('NFCE_URL_MG_PROD', 'https://portalsped.fazenda.mg.gov.br/portalnfce'),
            'MS' => env('NFCE_URL_MS_PROD', 'http://www.dfe.ms.gov.br/nfce/consulta'),
            'MT' => env('NFCE_URL_MT_PROD', 'http://www.sefaz.mt.gov.br/nfce/consultanfce'),
            'PA' => env('NFCE_URL_PA_PROD', 'www.sefa.pa.gov.br/nfce/consulta'),
            'PB' => env('NFCE_URL_PB_PROD', 'www.sefaz.pb.gov.br/nfce/consulta'),
            'PE' => env('NFCE_URL_PE_PROD', 'nfce.sefaz.pe.gov.br/nfce/consulta'),
            'PR' => env('NFCE_URL_PR_PROD', 'http://www.fazenda.pr.gov.br/nfce/consulta'),
            'PI' => env('NFCE_URL_PI_PROD', 'www.sefaz.pi.gov.br/nfce/consulta'),
            'RJ' => env('NFCE_URL_RJ_PROD', 'www.fazenda.rj.gov.br/nfce/consulta'),
            'RN' => env('NFCE_URL_RN_PROD', 'www.set.rn.gov.br/nfce/consulta'),
            'RO' => env('NFCE_URL_RO_PROD', 'www.sefin.ro.gov.br/nfce/consulta'),
            'RR' => env('NFCE_URL_RR_PROD', 'www.sefaz.rr.gov.br/nfce/consulta'),
            'RS' => env('NFCE_URL_RS_PROD', 'www.sefaz.rs.gov.br/nfce/consulta'),
            'SC' => env('NFCE_URL_SC_PROD', 'https://sat.sef.sc.gov.br/nfce/consulta'),
            'SE' => env('NFCE_URL_SE_PROD', 'http://www.nfce.se.gov.br/nfce/consulta'),
            'SP' => env('NFCE_URL_SP_PROD', 'https://www.nfce.fazenda.sp.gov.br/NFCeConsultaPublica'),
            'TO' => env('NFCE_URL_TO_PROD', 'www.sefaz.to.gov.br/nfce/consulta'),
        ],
        '2' => [ // Homologation
            'AC' => env('NFCE_URL_AC_HOMOLOG', 'www.sefaznet.ac.gov.br/nfce/consulta'),
            'AL' => env('NFCE_URL_AL_HOMOLOG', 'www.sefaz.al.gov.br/nfce/consulta'),
            'AP' => env('NFCE_URL_AP_HOMOLOG', 'www.sefaz.ap.gov.br/nfce/consulta'),
            'AM' => env('NFCE_URL_AM_HOMOLOG', 'www.sefaz.am.gov.br/nfce/consulta'),
            'BA' => env('NFCE_URL_BA_HOMOLOG', 'http://hinternet.sefaz.ba.gov.br/nfce/consulta'),
            'CE' => env('NFCE_URL_CE_HOMOLOG', 'www.sefaz.ce.gov.br/nfce/consulta'),
            'DF' => env('NFCE_URL_DF_HOMOLOG', 'www.fazenda.df.gov.br/nfce/consulta'),
            'ES' => env('NFCE_URL_ES_HOMOLOG', 'www.sefaz.es.gov.br/nfce/consulta'),
            'GO' => env('NFCE_URL_GO_HOMOLOG', 'www.nfce.go.gov.br/post/ver/214413/consulta-nfc-e-homologacao'),
            'MA' => env('NFCE_URL_MA_HOMOLOG', 'www.sefaz.ma.gov.br/nfce/consulta'),
            'MG' => env('NFCE_URL_MG_HOMOLOG', 'https://hportalsped.fazenda.mg.gov.br/portalnfce'),
            'MS' => env('NFCE_URL_MS_HOMOLOG', 'http://www.dfe.ms.gov.br/nfce/consulta'),
            'MT' => env('NFCE_URL_MT_HOMOLOG', 'http://homologacao.sefaz.mt.gov.br/nfce/consultanfce'),
            'PA' => env('NFCE_URL_PA_HOMOLOG', 'www.sefa.pa.gov.br/nfce/consulta'),
            'PB' => env('NFCE_URL_PB_HOMOLOG', 'www.sefaz.pb.gov.br/nfcehom'),
            'PE' => env('NFCE_URL_PE_HOMOLOG', 'nfce.sefaz.pe.gov.br/nfce/consulta'),
            'PR' => env('NFCE_URL_PR_HOMOLOG', 'http://www.fazenda.pr.gov.br/nfce/consulta'),
            'PI' => env('NFCE_URL_PI_HOMOLOG', 'www.sefaz.pi.gov.br/nfce/consulta'),
            'RJ' => env('NFCE_URL_RJ_HOMOLOG', 'www.fazenda.rj.gov.br/nfce/consulta'),
            'RN' => env('NFCE_URL_RN_HOMOLOG', 'www.set.rn.gov.br/nfce/consulta'),
            'RO' => env('NFCE_URL_RO_HOMOLOG', 'www.sefin.ro.gov.br/nfce/consulta'),
            'RR' => env('NFCE_URL_RR_HOMOLOG', 'www.sefaz.rr.gov.br/nfce/consulta'),
            'RS' => env('NFCE_URL_RS_HOMOLOG', 'www.sefaz.rs.gov.br/nfce/consulta'),
            'SC' => env('NFCE_URL_SC_HOMOLOG', 'https://hom.sat.sef.sc.gov.br/nfce/consulta'),
            'SE' => env('NFCE_URL_SE_HOMOLOG', 'http://www.hom.nfe.se.gov.br/nfce/consulta'),
            'SP' => env('NFCE_URL_SP_HOMOLOG', 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica'),
            'TO' => env('NFCE_URL_TO_HOMOLOG', 'http://homologacao.sefaz.to.gov.br/nfce/consulta.jsf'),
        ],
    ]
];
