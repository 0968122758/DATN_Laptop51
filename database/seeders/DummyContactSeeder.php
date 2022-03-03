<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        $dataSeeders = [];
        for ($i = 1; $i < 60; $i++) {
            $dataSeeders[] = [
                'email' => 'Contact ' . $i,
                'title' => 'Title ' . $i ,
                'body' => 'Body contact ' . $i,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }
        DB::table('contacts')->truncate();
        DB::table('contacts')->insert($dataSeeders);
    }
}
