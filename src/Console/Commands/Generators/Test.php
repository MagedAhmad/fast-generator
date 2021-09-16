<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Test extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->singular()->studly();

        $dir = $name->plural();

        $translatable = config('speed-generator.' . $command->argument('name') . '.translatable.active');


        $path = $translatable
            ? __DIR__.'/../stubs/Tests/Dashboard/TranslatableTest.stub'
            : __DIR__.'/../stubs/Tests/Dashboard/Test.stub';

        static::put(
            base_path("tests/Feature/Api"),
            $name.'Test.php',
            self::qualifyContent(
                __DIR__.'/../stubs/Tests/Api/Test.stub',
                $name
            )
        );

        static::put(
            base_path("tests/Feature/Dashboard"),
            $name.'Test.php',
            self::qualifyContent($path, $name)
        );
    }
}
