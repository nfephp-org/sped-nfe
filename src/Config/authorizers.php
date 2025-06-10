<?php

return [
    /*
    |--------------------------------------------------------------------------
    | NF-e/NFC-e Models
    |--------------------------------------------------------------------------
    |
    | Here you define which models should be used for NF-e and NFC-e
    |
    */
    'models' => [
        'nfe'  => env('NFE_MODEL', 55),
        'nfce' => env('NFCE_MODEL', 65),
    ],

    /*
    |--------------------------------------------------------------------------
    | NF-e Authorizers
    |--------------------------------------------------------------------------
    |
    | Here you define which authorization models should be used
    |
    */
    '55' => [
        'AC'    => env('NFE_AUTHORIZER_AC', 'SVRS'),
        'AL'    => env('NFE_AUTHORIZER_AL', 'SVRS'),
        'AM'    => env('NFE_AUTHORIZER_AM', 'AM'),
        'AN'    => env('NFE_AUTHORIZER_AN', 'AN'),
        'AP'    => env('NFE_AUTHORIZER_AP', 'SVRS'),
        'BA'    => env('NFE_AUTHORIZER_BA', 'BA'),
        'CE'    => env('NFE_AUTHORIZER_CE', 'SVRS'),
        'DF'    => env('NFE_AUTHORIZER_DF', 'SVRS'),
        'ES'    => env('NFE_AUTHORIZER_ES', 'SVRS'),
        'GO'    => env('NFE_AUTHORIZER_GO', 'GO'),
        'MA'    => env('NFE_AUTHORIZER_MA', 'SVAN'),
        'MG'    => env('NFE_AUTHORIZER_MG', 'MG'),
        'MS'    => env('NFE_AUTHORIZER_MS', 'MS'),
        'MT'    => env('NFE_AUTHORIZER_MT', 'MT'),
        'PA'    => env('NFE_AUTHORIZER_PA', 'SVRS'),
        'PB'    => env('NFE_AUTHORIZER_PB', 'SVRS'),
        'PE'    => env('NFE_AUTHORIZER_PE', 'PE'),
        'PI'    => env('NFE_AUTHORIZER_PI', 'SVRS'),
        'PR'    => env('NFE_AUTHORIZER_PR', 'PR'),
        'RJ'    => env('NFE_AUTHORIZER_RJ', 'SVRS'),
        'RN'    => env('NFE_AUTHORIZER_RN', 'SVRS'),
        'RO'    => env('NFE_AUTHORIZER_RO', 'SVRS'),
        'RR'    => env('NFE_AUTHORIZER_RR', 'SVRS'),
        'RS'    => env('NFE_AUTHORIZER_RS', 'RS'),
        'SC'    => env('NFE_AUTHORIZER_SC', 'SVRS'),
        'SE'    => env('NFE_AUTHORIZER_SE', 'SVRS'),
        'SP'    => env('NFE_AUTHORIZER_SP', 'SP'),
        'TO'    => env('NFE_AUTHORIZER_TO', 'SVRS'),
        'SVAN'  => env('NFE_AUTHORIZER_SVAN', 'SVAN'),
        'SVRS'  => env('NFE_AUTHORIZER_SVRS', 'SVRS'),
        'SVCAN' => env('NFE_AUTHORIZER_SVCAN', 'SVCAN'),
        'SVCRS' => env('NFE_AUTHORIZER_SVCRS', 'SVCRS'),
    ],
    /*
    |--------------------------------------------------------------------------
    | NFC-e Authorizers
    |--------------------------------------------------------------------------
    |
    | Here you define which authorization models should be used
    |
    */
    '65' => [
        'AC'   => env('NFCE_AUTHORIZER_AC', 'SVRS'),
        'AL'   => env('NFCE_AUTHORIZER_AL', 'SVRS'),
        'AM'   => env('NFCE_AUTHORIZER_AM', 'AM'),
        'AP'   => env('NFCE_AUTHORIZER_AP', 'SVRS'),
        'BA'   => env('NFCE_AUTHORIZER_BA', 'SVRS'),
        'CE'   => env('NFCE_AUTHORIZER_CE', 'SVRS'),
        'DF'   => env('NFCE_AUTHORIZER_DF', 'SVRS'),
        'ES'   => env('NFCE_AUTHORIZER_ES', 'SVRS'),
        'GO'   => env('NFCE_AUTHORIZER_GO', 'GO'),
        'MA'   => env('NFCE_AUTHORIZER_MA', 'SVRS'),
        'MG'   => env('NFCE_AUTHORIZER_MG', 'MG'),
        'MS'   => env('NFCE_AUTHORIZER_MS', 'MS'),
        'MT'   => env('NFCE_AUTHORIZER_MT', 'MT'),
        'PA'   => env('NFCE_AUTHORIZER_PA', 'SVRS'),
        'PB'   => env('NFCE_AUTHORIZER_PB', 'SVRS'),
        'PE'   => env('NFCE_AUTHORIZER_PE', 'SVRS'),
        'PI'   => env('NFCE_AUTHORIZER_PI', 'SVRS'),
        'PR'   => env('NFCE_AUTHORIZER_PR', 'PR'),
        'RJ'   => env('NFCE_AUTHORIZER_RJ', 'SVRS'),
        'RN'   => env('NFCE_AUTHORIZER_RN', 'SVRS'),
        'RO'   => env('NFCE_AUTHORIZER_RO', 'SVRS'),
        'RR'   => env('NFCE_AUTHORIZER_RR', 'SVRS'),
        'RS'   => env('NFCE_AUTHORIZER_RS', 'RS'),
        'SC'   => env('NFCE_AUTHORIZER_SC', 'SVRS'),
        'SE'   => env('NFCE_AUTHORIZER_SE', 'SVRS'),
        'SP'   => env('NFCE_AUTHORIZER_SP', 'SP'),
        'TO'   => env('NFCE_AUTHORIZER_TO', 'SVRS'),
        'SVRS' => env('NFCE_AUTHORIZER_SVRS', 'SVRS'),
    ],
];
