<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class Modifier
{
    public static function routes($name)
    {
        $pattern = '\/\*  The routes of generated crud will set here: Don\'t remove this line  \*\/';

        $place = '/*  The routes of generated crud will set here: Don\'t remove this line  */';

        $dashboard = file_get_contents(base_path('routes/dashboard.php'));

        $api = file_get_contents(base_path('routes/api.php'));

        $controllerName = Str::of($name)->singular()->studly().'Controller';

        $resource = Str::of($name)->plural()->snake();
        $singularName = Str::of($name)->singular()->snake();

        $dashboardRoute = "
        Route::get('trashed/$resource', '$controllerName@trashed')->name('$resource.trashed');
        Route::get('trashed/$resource/{trashed_$singularName}', '$controllerName@showTrashed')->name('$resource.trashed.show');
        Route::post('$resource/{trashed_$singularName}/restore', '$controllerName@restore')->name('$resource.restore');
        Route::delete('$resource/{trashed_$singularName}/forceDelete', '$controllerName@forceDelete')->name('$resource.forceDelete');
        Route::resource('$resource', '$controllerName');\n$place
        ";
        $apiRoutes = "Route::apiResource('$resource', '$controllerName');\nRoute::get('/select/$resource', '$controllerName@select')->name('{$resource}.select');\n$place";

        $dashboard = preg_replace("/$pattern/", $dashboardRoute, $dashboard);

        $api = preg_replace("/$pattern/", $apiRoutes, $api);

        file_put_contents(base_path('routes/dashboard.php'), $dashboard);

        file_put_contents(base_path('routes/api.php'), $api);
    }

    public function sidebar($name)
    {
        $pattern = '\{\{-- The sidebar of generated crud will set here: Don\'t remove this line --\}\}';

        $place = '{{-- The sidebar of generated crud will set here: Don\'t remove this line --}}';

        $resource = Str::of($name)->plural()->snake();

        $sidebarFile = file_get_contents(resource_path('views/layouts/sidebar.blade.php'));

        $sidebar = "@include('dashboard.$resource.partials.actions.sidebar')\n$place";

        $sidebarFile = preg_replace("/$pattern/", $sidebar, $sidebarFile);

        file_put_contents(resource_path('views/layouts/sidebar.blade.php'), $sidebarFile);
    }

    /**
     * TODO
     *
     * @param [type] $name
     * @return void
     */
    public function permission($name)
    {
        $pattern = '\{\{--  The permissions of generated crud will set here: Don\'t remove this line  --\}\}';

        $place = '{{-- The permissions of generated crud will set here: Don\'t remove this line --}}';

        $resource = Str::of($name)->plural()->studly();

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        $data = [
            ['name' => $resource. ' create', 'type' => $resource, 'guard_name' => 'web'],
            ['name' => $resource . ' update', 'type' => $resource, 'guard_name' => 'web'],
            ['name' => $resource . ' list', 'type' => $resource, 'guard_name' => 'web'],
            ['name' => $resource . ' show', 'type' => $resource, 'guard_name' => 'web'],
            ['name' => $resource . ' delete', 'type' => $resource, 'guard_name' => 'web'],
        ];

        $rolesAndPermissionsFile = file_get_contents(app_path('database/seeds/RolesAndPermissionsSeeder.php'));

        $sidebar = "@include('dashboard.$resource.partials.actions.sidebar')\n$place";

        foreach ($data as $datum) {
            // create permissions
            Permission::firstOrCreate($datum);
        }

        // $pattern2 = '\{\{--  The tables of generated crud will set here: Don\'t remove this line  --\}\}';

        // $place2 = '{{-- The tables of generated crud will set here: Don\'t remove this line --}}';

        
        
    }


    public function softDeletes($name)
    {
        $resource = Str::of($name)->singular()->snake();
        $resourceSingular = Str::of($name)->singular()->studly();

        $soft_deletes_route_bindings = @json_decode(file_get_contents(storage_path('soft_deletes_route_binding.json'))) ?? [];
        $soft_deletes_route_bindings->{"trashed_".$resource}  = "App\\Models\\$resourceSingular";

        file_put_contents(storage_path('soft_deletes_route_binding.json'), json_encode($soft_deletes_route_bindings, JSON_PRETTY_PRINT));
    }

    public function seeder($name)
    {
        $resource = Str::of($name)->singular()->studly();

        $pattern = '\/\*  The seeders of generated crud will set here: Don\'t remove this line  \*\/';

        $place = '/*  The seeders of generated crud will set here: Don\'t remove this line  */';

        $seederFile = file_get_contents(database_path('seeds/DummyDataSeeder.php'));

        $seeder = "\$this->call({$resource}Seeder::class);\n$place";

        $seederFile = preg_replace("/$pattern/", $seeder, $seederFile);

        file_put_contents(database_path('seeds/DummyDataSeeder.php'), $seederFile);
    }
}