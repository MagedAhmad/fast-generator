<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Model extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->singular()->studly();


        // see if model has translation
        $translatable = config('speed-generator.' . $command->argument('name') . '.translatable.active');
        $hasMedia = $command->option('has-media');

        if ($translatable) {
            $data = self::getFields($command);

            static::put(
                app_path("Models/Translations"),
                $name.'Translation.php',
                self::qualifyContentNew(
                    __DIR__.'/../stubs/Model/Translations/Translation.stub',
                    $name,
                    $data
                )
            );
        }

        if ($translatable && $hasMedia) {
            $data = self::getFields($command);

            static::put(
                app_path("Models"),
                $name.'.php',
                self::qualifyContentNew(
                    __DIR__.'/../stubs/Model/TranslatableMediaModel.stub',
                    $name,
                    $data
                )
            );
        } elseif ($translatable && ! $hasMedia) {
            $data = self::getFields($command);

            static::put(
                app_path("Models"),
                $name.'.php',
                self::qualifyContentNew(
                    __DIR__.'/../stubs/Model/TranslatableModel.stub',
                    $name,
                    $data
                )
            );
        } elseif (! $translatable && $hasMedia) {
            static::put(
                app_path("Models"),
                $name.'.php',
                self::qualifyContent(
                    __DIR__.'/../stubs/Model/MediaModel.stub',
                    $name
                )
            );
        } elseif (! $translatable && ! $hasMedia) {
            static::put(
                app_path("Models"),
                $name.'.php',
                self::qualifyContent(
                    __DIR__.'/../stubs/Model/Model.stub',
                    $name
                )
            );
        }
    }
}
