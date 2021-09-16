<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Lang;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Test;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\View;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Model;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Filter;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Policy;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Seeder;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Factory;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Request;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Resource;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Migration;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Breadcrumb;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Controller;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\VirtualResource;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\VirtualModel;
use MagedAhmad\SpeedGenerator\Console\Commands\Generators\Import;

class CrudMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:create
                            {name : Class (Singular), e.g User, Place, Car}
                            {--has-media}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all Crud operations with a single command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Lang::generate($this);
        Breadcrumb::generate($this); // done
        View::generate($this);
        Resource::generate($this);
        Migration::generate($this); // done
        Factory::generate($this);
        Seeder::generate($this);
        Policy::generate($this);
        Controller::generate($this);
        Model::generate($this); // done
        Request::generate($this);
        Filter::generate($this);
        Test::generate($this);
        VirtualResource::generate($this);
        VirtualModel::generate($this);
        Import::generate($this);

        $name = $this->argument('name');

        app(Modifier::class)->routes($name);

        app(Modifier::class)->sidebar($name);

        app(Modifier::class)->seeder($name);

        app(Modifier::class)->permission($name);

        app(Modifier::class)->softDeletes($name);

        $seederName = Str::of($name)->singular()->studly().'Seeder';

        $this->info('Api Crud for '.$name.' created successfully 🎉');
        $this->warn('Please run "composer dump-autoload && php artisan migrate && php artisan db:seed --class='.$seederName.' && php artisan l5-swagger:generate"');
    }
}
