<?php
return [
    /**
     * Supported database fields
     * 
     * 'string', 'text', 'longText', 'tinyText',
     * 'integer', 'tinyInteger', 'float', 'bigInteger', 'decimal', 'double',
     * 'date', 'time'
     */

    
    'vat' => [
        /**
         * Set arabic translation
         * 
         * Make sure to provide 4 words like the example
         */
        'arabic' => ['التجربة', 'التجارب', 'تجربة', 'تجارب'],
        
        /**
         * Make active equal to true if you want to add translation fields
         * then add translatable fields
         */
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