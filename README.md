# Very short description of the package

[![Latest Stable Version](http://poser.pugx.org/magedahmad/speed-generator/v)](https://packagist.org/packages/magedahmad/speed-generator) [![Total Downloads](http://poser.pugx.org/magedahmad/speed-generator/downloads)](https://packagist.org/packages/magedahmad/speed-generator) [![Latest Unstable Version](http://poser.pugx.org/magedahmad/speed-generator/v/unstable)](https://packagist.org/packages/magedahmad/speed-generator) [![License](http://poser.pugx.org/magedahmad/speed-generator/license)](https://packagist.org/packages/magedahmad/speed-generator) [![PHP Version Require](http://poser.pugx.org/magedahmad/speed-generator/require/php)](https://packagist.org/packages/magedahmad/speed-generator)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

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

```php
php artisan crud:create cat
```

then run 
```
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

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
