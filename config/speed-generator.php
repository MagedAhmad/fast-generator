<?php
return [
    
    //model name
    'vat' => [
        'arabic' => ['التجربة', 'التجارب', 'تجربة', 'تجارب'],
        
        // Make  sure model need translatable fields
        'translatable' => [
            'active' => true,
            
            'translatable_fields' => [
                [
                    'name' => 'username',
                    'type' => 'string',
                    'options' => [
                        'nullable' => '',
                        'default' => '0'
                    ],
                ],
                [
                    'name' => 'description',
                    'type' => 'text',
                    'options' => [
                        'nullable' => '',
                        'default' => '0'
                    ],
                ]
            ],
        ],
        'database_fields' => [
            [
                'name' => 'username',
                'type' => 'string',
                'options' => [
                    'nullable' => '',
                    'default' => '0'
                ],
            ],
        ]
    ]
];