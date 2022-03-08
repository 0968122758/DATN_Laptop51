<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyAdminsSeeder extends Seeder
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
                'email' => 'truongtuan ' . $i,
                'name' => 'Trương Ngọc Tuấn ' . $i ,
                'rule' => '1',
                'password' => '123 ' . $i,
                'remember_token' => 'abcdef' . $i ,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }
        DB::table('admins')->truncate();
        DB::table('admins')->insert($dataSeeders);
    }
}
