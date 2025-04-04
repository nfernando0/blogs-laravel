<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Programming',
            'description' => 'Programming'
        ]);
        DB::table('categories')->insert([
            'name' => 'Gaming',
            'description' => 'Gaming'
        ]);
        DB::table('categories')->insert([
            'name' => 'Food',
            'description' => 'Food'
        ]);
        DB::table('categories')->insert([
            'name' => 'Traveling',
            'description' => 'Traveling'
        ]);
    }
}
