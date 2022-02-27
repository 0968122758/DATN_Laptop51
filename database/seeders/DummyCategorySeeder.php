<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyCategorySeeder extends Seeder
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
        for ($i = 1; $i < 50; $i++) {
            $dataSeeders[] = [
                'name' => 'Category' . $i,
                'overview' => 'Text ' . $i . 'Text ' . $i . 'Text' . $i,
                'icon' => 'https://static.tapchitaichinh.vn/images/upload/buituananh/04052019/20170729112530-3cbd.jpg',
                'views' => 10 + $i,
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ];
        }
        DB::table('categories')->truncate();
        DB::table('categories')->insert($dataSeeders);
    }
}
