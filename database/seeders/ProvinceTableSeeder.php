<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["Province No. 1",1],
            ["Madhesh",2],
            ["Bagmati",3],
            ["Gandaki",4],
            ["Lumbini",5],
            ["Karnali",6],
            ["Sudurpashchim",7],
        ];
        foreach ($data as $datum) {
            $provience = new Province();
            $provience->name = $datum[0];
            $provience->identifier = $datum[1];
            $provience->save();
        }
    }
}
