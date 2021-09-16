<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Factory extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->singular()->studly();

        $stub = __DIR__.'/../stubs/Factory.stub';

        static::put(
            database_path('factories'),
            $name.'Factory.php',
            self::qualifyContent(
                $stub,
                $name
            )
        );
    }
}
