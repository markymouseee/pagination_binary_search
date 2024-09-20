<?php

namespace Database\Seeders;

use App\Models\UsersInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UsersInfo::factory(1000)->create();
    }
}
