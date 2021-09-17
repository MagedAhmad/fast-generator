<?php

namespace MagedAhmad\SpeedGenerator\Console\Commands\Generators;

use Illuminate\Support\Str;
use MagedAhmad\SpeedGenerator\Console\Commands\SpeedGenerator;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class Lang extends SpeedGenerator
{
    public static function generate(CrudMakeCommand $command)
    {
        $ar_translation = self::getFieldsTranslationAr($command);
        $en_translation = self::getFieldsTranslationEn($command);
        $data = [];
        $data['ar_translation'] = $ar_translation;
        $data['en_translation'] = $en_translation;


        $name = Str::of($command->argument('name'))->plural()->snake();

        self::ensureArabicWasRegistered($name);

        $translatable = config('speed-generator.' . $command->argument('name') . '.translatable.active');

        $hasMedia = $command->option('has-media');

        if ($translatable && $hasMedia) {
            $stub = __DIR__.'/../stubs/lang/translatable_media_lang.stub';
        } elseif ($translatable && ! $hasMedia) {
            $stub = __DIR__.'/../stubs/lang/translatable_lang.stub';
        } elseif (! $translatable && $hasMedia) {
            $stub = __DIR__.'/../stubs/lang/media_lang.stub';
        } else {
            $stub = __DIR__.'/../stubs/lang/lang.stub';
        }

        static::put(
            resource_path("lang/en"),
            $name.'.php',
            self::qualifyContent(
                $stub,
                $name,
                'en',
                $data
            )
        );

        static::put(
            resource_path("lang/ar"),
            $name.'.php',
            self::qualifyContent(
                $stub,
                $name,
                'ar',
                $data
            )
        );
    }

    protected static function qualifyContent($stub, $name, $lang = null, $data = [])
    {
        $replaceArray = static::englishResourceLang($name, $data['en_translation']);
        $translations = $data['en_translation'];

        if ($lang == 'ar') {
            $translations = $data['ar_translation'];
            $replaceArray = static::arabicResourceLang($name, $data['ar_translation']);
        }

        return str_replace(
            [
                "{{singular}}",
                "{{plural}}",
                "{{empty}}",
                "{{count}}",
                "{{search}}",
                "{{select}}",
                "{{permission}}",
                "{{trashed}}",
                "{{perPage}}",
                "{{filter}}",
                "{{actions.list}}",
                "{{actions.create}}",
                "{{actions.show}}",
                "{{actions.edit}}",
                "{{actions.delete}}",
                "{{actions.options}}",
                "{{actions.save}}",
                "{{actions.filter}}",
                "{{messages.created}}",
                "{{messages.updated}}",
                "{{messages.deleted}}",
                "{{messages.restored}}",
                "{{attributes.name}}",
                "{{attributes.%name%}}",
                "{{translations}}",
                "{{attributes.image}}",
                "{{attributes.created_at}}",
                "{{attributes.deleted_at}}",
                "{{dialogs.delete.title}}",
                "{{dialogs.delete.info}}",
                "{{dialogs.delete.confirm}}",
                "{{dialogs.delete.cancel}}",
                "{{dialogs.restore.title}}",
                "{{dialogs.restore.info}}",
                "{{dialogs.restore.confirm}}",
                "{{dialogs.restore.cancel}}",
                "{{dialogs.forceDelete.title}}",
                "{{dialogs.forceDelete.info}}",
                "{{dialogs.forceDelete.confirm}}",
                "{{dialogs.forceDelete.cancel}}",
            ],
            $replaceArray,
            file_get_contents($stub)
        );
    }

    public static function arabicResourceLang($resource, $ar_translation)
    {
        $name = (string) Str::of($resource)->singular()->snake();

        $names = static::getModel($name)['arabic'];

        $singular1 = $names[0];
        $singular2 = $names[2];
        $plural1 = $names[1];
        $plural2 = $names[3];

        return [
            $singular1,
            $plural1,
            "لا يوجد $plural2 حتى الان",
            "عدد $plural1",
            "بحث",
            "اختر $singular1",
            "ادارة $plural1",
            "$plural1 المحذوفين",
            "عدد النتائج بالصفحة",
            "ابحث عن $singular2",
            "عرض الكل",
            "اضافة $singular2",
            "عرض $singular1",
            "تعديل $singular1",
            "حذف $singular1",
            "خيارات",
            "حفظ",
            "بحث",
            "تم اضافة $singular1 بنجاح.",
            "تم تعديل $singular1 بنجاح.",
            "تم حذف $singular1 بنجاح.",
            "تم استعادة $singular1 بنجاح.",
            "اسم $singular1",
            "اسم $singular1",
            $ar_translation,
            "صورة $singular1",
            "اضافة في",
            "حذف في",
            "تحذير !",
            "هل انت متأكد انك تريد حذف $singular1",
            "حذف",
            "الغاء",
            "تحذير !",
            "هل انت متأكد انك تريد استعادة هذا $singular1",
            "استعادة",
            "الغاء",
            "تحذير !",
            "هل أنت متأكد انك تريد حذف هذا $singular1 نهائياً?",
            "حذف نهائي",
            "الغاء",
        ];
    }

    public static function englishResourceLang($resource, $en_translation)
    {
        $studlySingular = Str::of($resource)->singular()->snake()->replace('_', ' ')->ucfirst();
        $studlyPlural = Str::of($resource)->plural()->snake()->replace('_', ' ')->ucfirst();
        $lowercaseSingular = Str::of($resource)->singular()->snake()->replace('_', ' ')->lower();
        $lowercasePlural = Str::of($resource)->plural()->snake()->replace('_', ' ')->lower();

        return [
            $studlySingular,
            $studlyPlural,
            "There are no $lowercasePlural yet.",
            "$studlyPlural Count.",
            "Search",
            "Select $studlySingular",
            "Manage $lowercasePlural",
            "$lowercasePlural Trashed",
            "Results Per Page",
            "Search for $lowercaseSingular",
            "List All",
            "Create a new $lowercaseSingular",
            "Show $lowercaseSingular",
            "Edit $lowercaseSingular",
            "Delete $lowercaseSingular",
            "Options",
            "Save",
            "Filter",
            "The $lowercaseSingular has been created successfully.",
            "The $lowercaseSingular has been updated successfully.",
            "The $lowercaseSingular has been deleted successfully.",
            "The $lowercaseSingular has been restored successfully.",
            "$studlySingular name",
            "$studlySingular name",
            $en_translation,
            "$studlySingular image",
            "Created At",
            "Deleted At",
            "Warning !",
            "Are you sure you want to delete the $lowercaseSingular?",
            "Delete",
            "Cancel",
            "Warning !",
            "Are you sure you want to restore the $lowercaseSingular?",
            "Restore",
            "Cancel",
            "Warning !",
            "Are you sure you want to force delete the $lowercaseSingular?",
            "Force",
            "Cancel",
        ];
    }

    public static function getModel($name)
    {
        return config('speed-generator.'. $name);
    }

    public static function ensureArabicWasRegistered($resource)
    {
        $name = (string) Str::of($resource)->singular()->snake();

        if (! isset(static::getModel($name)['arabic'])) {
            throw new \Exception("The '$name' word doesn't register.");
        }
    }
}
