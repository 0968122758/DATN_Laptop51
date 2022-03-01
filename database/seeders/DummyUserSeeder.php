<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
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
            $gender = rand(0,3);
            $phone = rand(100,200);
            $dataSeeders[] = [
                'name' => 'User' . $i,
                'email' => 'emailtest' . $i . '@gmail.com ',
                'email_verified_at'=> NULL,
                'phone' =>'08'. $i .'668'.$i.$phone,
                'avatar' => 'https://35express.org/wp-content/uploads/2022/01/tom-tat-tieu-su-ly-lich-ve-thong-soai-ca-35express.jpg',
                'gender' => $gender,
                'birthdate' => date('Y_m_d'),
                'password' => Hash::make('12345678'),
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ];
        }
        DB::table('users')->truncate();
        DB::table('users')->insert($dataSeeders);
    }
}
