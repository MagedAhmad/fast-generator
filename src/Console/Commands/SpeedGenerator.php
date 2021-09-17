<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class SpeedGenerator
{
    /**
     * @param $name
     * This will create model from stub file
     */
    public static function model($name)
    {
        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            static::getStubs('Model')
        );

        file_put_contents(app_path("/{$name}.php"), $template);
    }

    /**
     * @param $name
     * This will create Request from stub file
     */
    public static function request($name)
    {
        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            static::getStubs('Request')
        );

        if (! file_exists($path = app_path('/Http/Requests/'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $template);
    }

    /**
     * @param $name
     * This will create migration using artisan command
     */
    public static function migration($name)
    {
        Artisan::call('make:migration create_'.strtolower(Str::plural($name)).'_table --create='.strtolower(Str::plural($name)));
    }

    /**
     * @param $name
     * This will create route in api.php file
     */
    public static function route($name)
    {
        $path_to_file = base_path('routes/api.php');
        $append_route = 'Route::apiResource(\''.Str::plural(strtolower($name))."', '{$name}Controller'); \n";
        File::append($path_to_file, $append_route);
    }

    protected static function qualifyContent($stub, $name)
    {
        return str_replace(
            [
                '{{studlySingular}}',
                '{{studlyPlural}}',
                '{{lowercaseSingular}}',
                '{{lowercasePlural}}',
                '{{lowercaseDisplayPlural}}',
                '{{lowercaseDisplaySingular}}',
                '{{uppercaseDisplayPlural}}',
                '{{uppercaseDisplaySingular}}',
            ],
            [
                $studlySingular = Str::of($name)->singular()->studly(),
                $studlyPlural = Str::of($name)->plural()->studly(),
                $lowercaseSingular = Str::of($name)->snake()->singular()->lower(),
                $lowercasePlural = Str::of($name)->snake()->plural()->lower(),
                $lowercaseDisplayPlural = Str::of($name)->snake()->replace('_', ' ')->plural()->lower(),
                $lowercaseDisplaySingular = Str::of($name)->snake()->replace('_', ' ')->singular()->lower(),
                $uppercaseDisplayPlural = Str::of($name)->snake()->replace('_', ' ')->ucfirst()->plural()->lower(),
                $uppercaseDisplaySingular = Str::of($name)->snake()->replace('_', ' ')->ucfirst()->singular()->lower(),
            ],
            file_get_contents($stub)
        );
    }

    protected static function qualifyContentNew($stub, $name, $data)
    {
        return str_replace(
            [
                '{{studlySingular}}',
                '{{studlyPlural}}',
                '{{lowercaseSingular}}',
                '{{lowercasePlural}}',
                '{{lowercaseDisplayPlural}}',
                '{{lowercaseDisplaySingular}}',
                '{{uppercaseDisplayPlural}}',
                '{{uppercaseDisplaySingular}}',
                
                '{{translated_columns}}',
                '{{translated_data}}',
                '{{migration_data}}',
                '{{columns}}',
                '{{faktories}}',
                '{{resource}}',
                '{{formItems}}',
                '{{indexItemsKeys}}',
                '{{indexItemsValues}}',
                '{{showItems}}',
                '{{formTranslationItems}}'
            ],
            [
                $studlySingular = Str::of($name)->singular()->studly(),
                $studlyPlural = Str::of($name)->plural()->studly(),
                $lowercaseSingular = Str::of($name)->snake()->singular()->lower(),
                $lowercasePlural = Str::of($name)->snake()->plural()->lower(),
                $lowercaseDisplayPlural = Str::of($name)->snake()->replace('_', ' ')->plural()->lower(),
                $lowercaseDisplaySingular = Str::of($name)->snake()->replace('_', ' ')->singular()->lower(),
                $uppercaseDisplayPlural = Str::of($name)->snake()->replace('_', ' ')->ucfirst()->plural()->lower(),
                $uppercaseDisplaySingular = Str::of($name)->snake()->replace('_', ' ')->ucfirst()->singular()->lower(),
                
                $translated_columns = isset($data['translated_columns']) ? implode(', ', $data['translated_columns']) : null ,
                $translated_data = isset($data['translated_data']) ? $data['translated_data'] : null ,
                $migration_data = isset($data['migration_data']) ? $data['migration_data'] : null ,
                $columns = isset($data['columns']) ? implode(', ', $data['columns']) : null ,
                $faktories = isset($data['faktories']) ? $data['faktories'] : null ,
                $resource = isset($data['resource']) ? $data['resource'] : null ,
                $formItems = isset($data['formItems']) ? $data['formItems'] : null ,
                $indexItemsKeys = isset($data['indexItemsKeys']) ? $data['indexItemsKeys'] : null ,
                $indexItemsValues = isset($data['indexItemsValues']) ? $data['indexItemsValues'] : null ,
                $showItems = isset($data['showItems']) ? $data['showItems'] : null ,
                $formTranslationItems = isset($data['formTranslationItems']) ? $data['formTranslationItems'] : null ,
            ],
            file_get_contents($stub)
        );
    }

    protected static function put($path, $file, $content)
    {
        if (! is_dir($path)) {
            // dir doesn't exist, make it
            mkdir($path, 0777, true);
        }

        if (file_exists($path.'/'.$file)) {
            return;
        }

        file_put_contents($path.'/'.$file, $content);
    }


    protected static function getFields($command)
    {
        $data = [];

        // get translation fields
        if(config('speed-generator.' . $command->argument('name') . '.translatable.active')) {
            $translation_fields = config('speed-generator.' . $command->argument('name') . '.translatable.translatable_fields');
        
            $translated_data = '';
            $translated_columns = [];
            foreach($translation_fields as $field) {
                // make db line
                $options = '';
                foreach($field['options'] as $key => $value) {
                    $options = $options . '->' . $key . '('.$value.')';
                }
                $db_line = '$table->' . $field['type'] . '("'. $field['name'] .'")' . $options .';';
                // end make db line
                
                array_push($translated_columns, "'" .$field['name'] . "'");
                $translated_data = $translated_data . $db_line;
            }
            $data['translated_data'] = $translated_data;
            $data['translated_columns'] = $translated_columns;
        }

        $normal_fields = config('speed-generator.' . $command->argument('name') . '.database_fields');
        $columns = [];
        $migration_data = '';
        
        foreach ($normal_fields as $field) {
            // make db line
            $options = '';
            foreach($field['options'] as $key => $value) {
                $options = $options . '->' . $key . '('.$value.')';
            }
            $db_line = '$table->' . $field['type'] . '("'. $field['name'] .'")' . $options .';';
            // end make db line
            
            
            array_push($columns, "'" .$field['name'] . "'");
            $migration_data = $migration_data . $db_line;
        }
        $data['migration_data'] = $migration_data;
        $data['columns'] = $columns;

        return $data;
    }

    protected static function getFormItems($command){
        
        $fields = config('speed-generator.' . $command->argument('name') . '.database_fields');
        $form = '';
        foreach($fields as $field) {
            if($field['type'] == 'string') {
                $form = $form . ' {{BsForm::text("' . $field['name'] . '") }}' ;
            }elseif($field['type'] == 'text' || $field['type'] == 'longText') {
                $form = $form . '{{ BsForm::textarea("' . $field['name'] .'")->attribute("class", "form-control editor") }}';
            }elseif($field['type'] == 'integer' || $field['type'] == 'float' || $field['type'] == 'tinyInteger') {
                $form = $form . ' {{BsForm::number("' . $field['name'] . '") }}' ;
            }elseif($field['type'] == 'date') {
                $form = $form . ' {{BsForm::date("' . $field['name'] . '") }}' ;
            }elseif($field['type'] == 'boolean') {
                $form = $form . ' {{ BsForm::checkbox("'. $field['name'].'")->checked(false) }}' ;
            }
        }

        return $form;
    }  

    protected static function getFormTranslationItems($command){
        
        $fields = config('speed-generator.' . $command->argument('name'))['translatable']['translatable_fields'];
        $form = '';
        foreach($fields as $field) {
            if($field['type'] == 'string') {
                $form = $form . ' {{BsForm::text("' . $field['name'] . '") }}' ;
            }elseif($field['type'] == 'text' || $field['type'] == 'longText') {
                $form = $form . '{{ BsForm::textarea("' . $field['name'] .'")->attribute("class", "form-control editor") }}';
            }elseif($field['type'] == 'integer' || $field['type'] == 'float' || $field['type'] == 'tinyInteger') {
                $form = $form . ' {{BsForm::number("' . $field['name'] . '") }}' ;
            }elseif($field['type'] == 'date') {
                $form = $form . ' {{BsForm::date("' . $field['name'] . '") }}' ;
            }elseif($field['type'] == 'boolean') {
                $form = $form . ' {{ BsForm::checkbox("'. $field['name'].'")->checked(false) }}' ;
            }
        }

        return $form;
    } 
    
    protected static function getIndexItemValues($command, $table){
        
        $fields = config('speed-generator.' . $command->argument('name'))['translatable']['translatable_fields'];
        
        $items = '';
        foreach($fields as $field) {
            $items = $items . '
                <td>' .
                    '{{ $' . $table .'->' . $field['name'] .  ' }}' .
                '</td>';
        }

        $fields = config('speed-generator.' . $command->argument('name') . '.database_fields');
        
        foreach($fields as $field) {
            $items = $items . '
                <td>' .
                    '{{ $' . $table .'->' . $field['name'] .  ' }}' .
                '</td>
            ';
        }

        return $items;
    } 

    protected static function getIndexItemKeys($command, $table){
        
        $fields = config('speed-generator.' . $command->argument('name'))['translatable']['translatable_fields'];
        
        $items = '';
        foreach($fields as $field) {
            $items = $items . '
            <th>
                @lang("' . $table . '.attributes.'.$field['name'].'")
            </th>';
        }

        $fields = config('speed-generator.' . $command->argument('name') . '.database_fields');
        
        foreach($fields as $field) {
            $items = $items . '
            <th>
                @lang("' . $table . '.attributes.'.$field['name'].'")
            </th>';
        }

        return $items;
    } 


    protected static function getShowItems($command, $table, $name){
        
        $fields = config('speed-generator.' . $command->argument('name'))['translatable']['translatable_fields'];
        
        $items = '';
        foreach($fields as $field) {
            
            if($field['type'] == 'text' || $field['type'] == 'longText') {
                $items = $items . '
                        <tr>
                            <th width="200">@lang("' . $table . '.attributes.'.$field['name'].'")</th>
                            <td>' . '{!! $' . $name .'->' . $field['name'] .  ' !!}' .'</td>
                        </tr>
                ';
                continue;
            }

            $items = $items . '
                        <tr>
                            <th width="200">@lang("' . $table . '.attributes.'.$field['name'].'")</th>
                            <td>' . '{{ $' . $name .'->' . $field['name'] .  ' }}' .'</td>
                        </tr>
            ';
        }

        $fields = config('speed-generator.' . $command->argument('name') . '.database_fields');
        
        foreach($fields as $field) {
            if($field['type'] == 'text' || $field['type'] == 'longText') {
                $items = $items . '
                        <tr>
                            <th width="200">@lang("' . $table . '.attributes.'.$field['name'].'")</th>
                            <td>' . '{!! $' . $name .'->' . $field['name'] .  ' !!}' .'</td>
                        </tr>
                ';
                continue;
            }
            $items = $items . '
                        <tr>
                            <th width="200">@lang("' . $table . '.attributes.'.$field['name'].'")</th>
                            <td>' . '{{ $' . $name .'->' . $field['name'] .  ' }}' .'</td>
                        </tr>
            ';
        }

        return $items;
    } 


    protected static function getFieldsTranslationAr($command){
        
        $fields = config('speed-generator.' . $command->argument('name'))['translatable']['translatable_fields'];
        
        $ar = '';
        foreach($fields as $field) {
            $ar = $ar . '
            "' . $field['name'] . '" => "' . $field['lang']['ar'] . '",';
            $ar = $ar . '
            "%' . $field['name'] . '%" => "' . $field['lang']['ar'] . '",';
        }
        $fields = config('speed-generator.' . $command->argument('name') . '.database_fields');
        foreach($fields as $field) {
            $ar = $ar . '
            "' . $field['name'] . '" => "' . $field['lang']['ar'] . '",';
            
        }

        return $ar;
    } 

    protected static function getFieldsTranslationEn($command){
        
        $fields = config('speed-generator.' . $command->argument('name'))['translatable']['translatable_fields'];
        
        $en = '';
        foreach($fields as $field) {
            
            $en = $en . '
            "' . $field['name'] . '" => "' . $field['lang']['en'] . '",';
            $en = $en . '
            "%' . $field['name'] . '%" => "' . $field['lang']['en'] . '",';
        }
        $fields = config('speed-generator.' . $command->argument('name') . '.database_fields');
        foreach($fields as $field) {
            
            $en = $en . '
            "' . $field['name'] . '" => "' . $field['lang']['en'] . '",';
        }

        return $en;
    } 
    
}
