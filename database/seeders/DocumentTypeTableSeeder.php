<?php

namespace Database\Seeders;

use App\Models\FileType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["type 1"],
            ["type 2"],
            ["type 3"],
            ["type 4"],
            ["type 5"],
            ["type 6"],
        ];
        foreach ($data as $datum) {
            $docType = new FileType();
            $docType->name = $datum[0];
            $docType->save();
        }
    }
}
