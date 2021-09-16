<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class VirtualModel extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->singular()->studly();

        static::put(
            app_path("Virtual/Models"),
            $name.'.php',
            self::qualifyContent(
                __DIR__.'/../stubs/Virtual/Models/Model.stub',
                $name
            )
        );


    }
}
