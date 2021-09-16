<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Breadcrumb extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->plural()->snake();

        $stub = __DIR__.'/../stubs/breadcrumbs.stub';

        static::put(
            base_path("routes/breadcrumbs"),
            $name.'.php',
            self::qualifyContent(
                $stub,
                $name
            )
        );
    }
}
