<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiscalYearTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['२०७४/७५',0],
            ['२०७५/७६',0],
            ['२०७६/७७',0],
            ['२०७७/७८',0],
            ['२०७८/७९',1],
        ];
        foreach ($data as $datum) {
            $fiscalyear = new FiscalYear();
            $fiscalyear->year = $datum[0];
            $fiscalyear->active = $datum[1];
            $fiscalyear->save();
        }
    }
}
