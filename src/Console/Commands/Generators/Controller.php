<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Controller extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->singular()->studly();

        $namespace = Str::of($name)->plural()->studly();

        $hasMedia = $command->option('has-media');

        // ApiController
        static::put(
            app_path("Http/Controllers/Api"),
            $name.'Controller.php',
            self::qualifyContent(
                __DIR__.'/../stubs/Controllers/Api/Controller.stub',
                $name
            )
        );

        $stub = $hasMedia
            ? __DIR__.'/../stubs/Controllers/Dashboard/MediaController.stub'
            : __DIR__.'/../stubs/Controllers/Dashboard/Controller.stub';

        // DashboardController
        static::put(
            app_path("Http/Controllers/Dashboard"),
            $name.'Controller.php',
            self::qualifyContent(
                $stub,
                $name
            )
        );
    }
}
