<?php

return [
    'keys' => [
        /*'identifier' => 'key','server*/
        'dcm' =>
            [
                'key'=>'af390c31cb9d27c0580efa087c16ef35de210e0b',
                'base_url' => 'http://dcm'
            ],
        'dcmc' =>
            [
                'key'=>'5201310b866eae89855a2e7c6d5e576499511313',
                'base_url' => 'http://dcmc'
            ],
    ],
    'servers' => [
        /*  ['identifier','name','address_type','address','municipality_identifier','district_identifier','province_identifier'],*/
            //['dcm','Organization Name 1','0','address 01',null,null,null],
            //['dcmc','Organization ','0','address 02',null,null,null],

        ['dcm','org name','address'],
        ['dcmc','org name c','address c']
    ]
];
