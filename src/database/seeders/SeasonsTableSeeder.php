<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Season;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('seasons')->insert($seasons);
        $seasons = ['春', '夏', '秋', '冬'];
        foreach ($seasons as $season) {
            Season::create(['name' => $season]);
        }
    }
}
