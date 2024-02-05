<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            ['name' => 'Berita Terkini'],
            ['name' => 'Politik'],
            ['name' => 'Ekonomi'],
            ['name' => 'Olahraga'],
            ['name' => 'Hiburan'],
            ['name' => 'Teknologi'],
            ['name' => 'Kesehatan'],
            ['name' => 'Sains'],
            ['name' => 'Lingkungan'],
            ['name' => 'Internasional'],
            ['name' => 'Pendidikan'],
            ['name' => 'Gaya Hidup'],
            ['name' => 'Opini dan Editorial'],
            ['name' => 'Teknologi'],

        ];
        DB::table('news_category')->insert($data);
    }
}
