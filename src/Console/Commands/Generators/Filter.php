<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Filter extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->singular()->studly();

        $namespace = Str::of($name)->plural()->studly();

        $translatable = config('speed-generator.' . $command->argument('name') . '.translatable.active');


        $filterStub = $translatable
            ? __DIR__.'/../stubs/Filters/TranslatableFilter.stub'
            : __DIR__.'/../stubs/Filters/Filter.stub';

        static::put(
            app_path("Http/Filters"),
            $name.'Filter.php',
            self::qualifyContent(
                $filterStub,
                $name
            )
        );
    }
}
