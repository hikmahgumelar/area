<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import_region = storage_path('app/file/hms_region.sql');
        $import_province = storage_path('app/file/hms_province.sql');
        \DB::unprepared(file_get_contents($import_region));
        $this->command->info('Region table seeded!');
        \DB::unprepared(file_get_contents($import_province));
        $this->command->info('Province table seeded!');
    }
}
