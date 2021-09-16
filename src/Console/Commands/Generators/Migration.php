<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Migration extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $data = self::getFields($command);
        
        $name = Str::of($command->argument('name'))->singular()->studly();

        $translatable = config('speed-generator.' . $command->argument('name') . '.translatable.active');

        $filterStub = $translatable
            ? __DIR__.'/../stubs/translatable_migration.stub'
            : __DIR__.'/../stubs/migration.stub';

        $table = Str::of($name)->snake()->lower()->plural();

        static::put(
            database_path("migrations"),
            date('Y_m_d_His')."_create_{$table}_table.php",
            self::qualifyContentNew(
                $filterStub,
                $name,
                $data
            )
        );
    }
}
