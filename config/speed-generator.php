<?php
return [
    /**
     * Supported database fields
     * 
     * 'string', 'text', 'longText', 'tinyText',
     * 'integer', 'tinyInteger', 'float', 'bigInteger', 'decimal', 'double',
     * 'date', 'time', 'boolean', 'timestamp', 'timestamps'
     */

    
    'expirement' => [
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
                    'name' => 'name',
                    'type' => 'string',
                    /**
                     * Any thing you want to add to the migration line you can here
                     * 
                     * ex: $table->string('age')->nullable()->default(0);
                     * nullable = key, '' = value
                     * default = key, 0 = value
                     */
                    'options' => [
                        'nullable' => '',
                    ],
                ],
                [
                    'name' => 'description',
                    'type' => 'text',
                    'options' => [
                        'nullable' => '',
                    ],
                ]
            ],
        ],
        'database_fields' => [
            [
                'name' => 'age',
                'type' => 'integer',
                'options' => [
                    'default' => '0'
                ],
            ],
        ]
    ]
];