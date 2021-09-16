<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Resource extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->singular()->studly();

        $namespace = Str::of($name)->plural()->studly();

        $hasMedia = $command->option('has-media');

        $stub = __DIR__.'/../stubs/Resources/Resource.stub';

        static::put(
            app_path("Http/Resources"),
            $name.'Resource.php',
            self::qualifyContent(
                $stub,
                $name
            )
        );
    }
}
