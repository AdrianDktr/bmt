<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = now();
        $data =[
            [
                'name' => 'Adrian ',
                'email' => 'admin@admin.com',
                'password' =>  bcrypt('Dktr19'),
                'is_admin'=>true,
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp

            ],
            [
                'name' => 'Ashraf fikri Yathier',
                'email' => 'admin2@admin.com',
                'password' =>  bcrypt('Black12'),
                'is_admin'=>true,
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ]
        ];

        DB::table('users')->insert($data);

    }
}
