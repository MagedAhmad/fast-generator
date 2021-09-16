<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Import extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->plural()->studly();

        static::put(
            app_path("Imports"),
            $name.'Import.php',
            self::qualifyContent(
                __DIR__.'/../stubs/Imports/Import.stub',
                $name
            )
        );


    }
}
