<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;
use Stichoza\GoogleTranslate\GoogleTranslate;

class View extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $data = self::getFields($command);

        // form data
        $formItems = self::getFormItems($command);
        $formTranslationItems = self::getFormTranslationItems($command);
        
        $data['formItems'] = $formItems;
        $data['formTranslationItems'] = $formTranslationItems;
        // end form data

        // index data
        $table = Str::of($command->argument('name'))->snake()->plural()->lower();

        $indexItemsKeys = self::getIndexItemKeys($command, $table);
        $indexItemsValues = self::getIndexItemValues($command, $command->argument('name'));

        $data['indexItemsKeys'] = $indexItemsKeys;
        $data['indexItemsValues'] = $indexItemsValues;
        // end index data

        // show data 
        $showItems = self::getShowItems($command, $table, $command->argument('name'));

        $data['showItems'] = $showItems;
        // end show data

        $name = Str::of($command->argument('name'))->plural()->snake();

        $translatable = config('speed-generator.' . $command->argument('name') . '.translatable.active');


        $hasMedia = $command->option('has-media');

        if ($translatable && $hasMedia) {
            $stubPath = __DIR__.'/../stubs/Views/translatable_has_media';
        } elseif ($translatable && ! $hasMedia) {
            $stubPath = __DIR__.'/../stubs/Views/translatable';
        } elseif (! $translatable && $hasMedia) {
            $stubPath = __DIR__.'/../stubs/Views/has_media';
        } else {
            $stubPath = __DIR__.'/../stubs/Views/default';
        }

        // Actions
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'create.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/create.blade.stub',
                $name,
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'delete.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/delete.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'edit.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/edit.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'show.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/show.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'sidebar.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/sidebar.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'restore.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/restore.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'trashed.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/trashed.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'link.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/link.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials/actions"),
            'forceDelete.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/actions/forceDelete.blade.stub',
                $name
            )
        );
        // Partials
        static::put(
            resource_path("views/dashboard/{$name}/partials"),
            'filter.blade.php',
            self::qualifyContent(
                $stubPath.'/partials/filter.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}/partials"),
            'form.blade.php',
            self::qualifyContentNew(
                $stubPath.'/partials/form.blade.stub',
                $name,
                $data
            )
        );
        // Resource
        static::put(
            resource_path("views/dashboard/{$name}"),
            'create.blade.php',
            self::qualifyContent(
                $stubPath.'/create.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}"),
            'edit.blade.php',
            self::qualifyContent(
                $stubPath.'/edit.blade.stub',
                $name
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}"),
            'index.blade.php',
            self::qualifyContentNew(
                $stubPath.'/index.blade.stub',
                $name,
                $data
            )
        );
        static::put(
            resource_path("views/dashboard/{$name}"),
            'trashed.blade.php',
            self::qualifyContent(
                $stubPath.'/trashed.blade.stub',
                $name
            )
        );

        static::put(
            resource_path("views/dashboard/{$name}"),
            'show.blade.php',
            self::qualifyContentNew(
                $stubPath.'/show.blade.stub',
                $name,
                $data
            )
        );
    }
}
