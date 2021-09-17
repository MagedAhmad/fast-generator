# Fast Generator

[![Latest Stable Version](http://poser.pugx.org/magedahmad/speed-generator/v)](https://packagist.org/packages/magedahmad/speed-generator) [![Total Downloads](http://poser.pugx.org/magedahmad/speed-generator/downloads)](https://packagist.org/packages/magedahmad/speed-generator) [![Latest Unstable Version](http://poser.pugx.org/magedahmad/speed-generator/v/unstable)](https://packagist.org/packages/magedahmad/speed-generator) [![License](http://poser.pugx.org/magedahmad/speed-generator/license)](https://packagist.org/packages/magedahmad/speed-generator) [![PHP Version Require](http://poser.pugx.org/magedahmad/speed-generator/require/php)](https://packagist.org/packages/magedahmad/speed-generator)

This package is used to fasten your creating of new crud operations.

## Installation

You can install the package via composer:

```bash
composer require magedahmad/speed-generator --dev
```

## Configuration

You can install the package via composer:

```bash
php artisan vendor:publish --provider="MagedAhmad\SpeedGenerator\SpeedGeneratorServiceProvider"
```

## Usage

Add your model&migration data in `config/speed-generator` then run
```php
php artisan crud:create cat
```
or if the model has media add `--has-media` flag

```php
php artisan crud:create cat --media
```

example 

```php
'cat' => [
        'arabic' => ['القطة', 'القطط', 'قطه', 'قطط'],

        'translatable' => [
            'active' => false,
            'translatable_fields' => [
            ],
        ],

        'database_fields' => [
            [
                'name' => 'name',
                'type' => 'string',
                'options' => [
                    'nullable' => ''
                ],
            ],
        ]
    ]
```



then run 
```
php artisan crud:create cat

composer dump-autoload && php artisan migrate && php artisan db:seed --class=CatSeeder && php artisan l5-swagger:generate
```

and that's it 🎉

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email maged.ahmedr@gmail.com instead of using the issue tracker.

## Credits

-   [Maged Ahmed](https://github.com/magedahmad)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## TODO

- Add (foreign keys) functionalities

- Handling files (pdf, docs, etc)

- Customize sidebar icon

- Automatically Add modedl counter to dashboard home page