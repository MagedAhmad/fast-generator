<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Factory extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $faktories = '';
        $data = [];

        // get database fields
        $records = config('speed-generator.' . $command->argument('name'))['database_fields'];

        foreach($records as $field) {
            if($field['type'] == 'string') {
                $faktories = $faktories . '"' . $field['name'] . '" => $this->faker->word,';
            }elseif(in_array($field['type'], ['text', 'longText', 'tinyText'])) {
                $faktories = $faktories . '"' . $field['name'] . '" => $this->faker->paragraph,';
            }elseif(in_array($field['type'], ['integer', 'tinyInteger', 'float', 'bigInteger', 'decimal', 'double'])) {
                $faktories = $faktories . '"' . $field['name'] . '" => $this->faker->randomDigit,';
            }elseif(in_array($field['type'], ['date', 'time'])) {
                $faktories = $faktories . '"' . $field['name'] . '" => $this->faker->date,';
            }else {
                $faktories = $faktories . '"' . $field['name'] . '" => 1,';
            }
        }

        // get translation fields
        $records = config('speed-generator.' . $command->argument('name'))['translatable']['translatable_fields'];
        foreach($records as $field) {
            if($field['type'] == 'string') {
                $faktories = $faktories . '"' . $field['name'] . '" => $this->faker->word,';
            }elseif(in_array($field['type'], ['text', 'longText', 'tinyText'])) {
                $faktories = $faktories . '"' . $field['name'] . '" => $this->faker->paragraph,';
            }elseif(in_array($field['type'], ['integer', 'tinyInteger', 'float', 'bigInteger', 'decimal', 'double'])) {
                $faktories = $faktories . '"' . $field['name'] . '" => $this->faker->randomDigit,';
            }elseif(in_array($field['type'], ['date', 'time'])) {
                $faktories = $faktories . '"' . $field['name'] . '" => $this->faker->date,';
            }
        }
        
        $data['faktories'] = $faktories;
        
        $name = Str::of($command->argument('name'))->singular()->studly();

        $stub = __DIR__.'/../stubs/Factory.stub';

        static::put(
            database_path('factories'),
            $name.'Factory.php',
            self::qualifyContentNew(
                $stub,
                $name,
                $data
            )
        );
    }
}
