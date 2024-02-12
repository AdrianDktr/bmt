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
                'name' => 'Adrian Adhi Wicaksana',
                'email' => 'admin@admin.com',
                'password' =>  bcrypt('Dktr19'),
                'is_admin'=>true,
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp

            ],
            [
                'name' => 'Farhan Rahmat',
                'email' => 'farhan.rahmat@admin.com',
                'password' =>  bcrypt('BIKININaja'),
                'is_admin'=>true,
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp

            ],
            [
                'name' => 'Zulfihadi',
                'email' => 'zulfihadi@admin.com',
                'password' =>  bcrypt('CeraikanDuluIstrimu'),
                'is_admin'=>true,
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ],
            [
                'name' => 'Ardiansyah',
                'email' => 'ardiansyah@admin.com',
                'password' =>  bcrypt('NGOPI'),
                'is_admin'=>true,
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ]
        ];

        DB::table('users')->insert($data);

    }
}
