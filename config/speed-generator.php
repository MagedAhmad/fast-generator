<?php

/**
 * Speed generator
 * 
 * To help generate new cruds
 */
return [

    /**
     * Supported database fields
     * 
     * 'string', 'text', 'longText', 'tinyText', 'integer', 'tinyInteger',
     * 'float', 'bigInteger', 'decimal', 'double', 'date', 
     * 'time', 'boolean', 'timestamp', 'timestamps'
     */
    'expirement' => [
        /**
         * Set arabic translation
         * 
         * Make sure to provide 4 words like the example
         */
        'arabic' => ['التجربة', 'التجارب', 'تجربة', 'تجارب'],
        
        'database_fields' => [
            [
                'name' => 'duration',
                'type' => 'integer',
                'lang' => [
                    'ar' => 'المدة',
                    'en' => 'Duration',
                ],
                'options' => [
                    'default' => '0'
                ],
            ],
        ],

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
                    ],
                    'lang' => [
                        'ar' => 'اسم التجرب',
                        'en' => 'Experiment name',
                    ],
                ],
                [
                    'name' => 'description',
                    'type' => 'text',
                    'options' => [
                        'nullable' => '',
                    ],
                    'lang' => [
                        'ar' => 'الوصف',
                        'en' => 'Description',
                    ],
                ]
            ],
        ],
    ]
];