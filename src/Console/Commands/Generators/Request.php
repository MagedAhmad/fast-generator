<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Request extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $name = Str::of($command->argument('name'))->singular()->studly();

        $translatable = config('speed-generator.' . $command->argument('name') . '.translatable.active');


        $namespace = Str::of($name)->plural()->studly();

        $stub = $translatable
            ? __DIR__.'/../stubs/Requests/TranslatableRequest.stub'
            : __DIR__.'/../stubs/Requests/Request.stub';

        static::put(
            app_path("Http/Requests/Dashboard"),
            $name.'Request.php',
            self::qualifyContent(
                $stub,
                $name
            )
        );
    }
}
