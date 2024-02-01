<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents_count = 30;
        for ($i = 1; $i <= $documents_count; $i++)
        {
            $document = Document::find($i);
            $document->registrations()->attach($i);

        }
        $documents_min = 31;
        $documents_max = 60;
        for ($i = $documents_min; $i <= $documents_max; $i++)
        {
            $document = Document::find($i);
            $document->invoices()->attach($i-30);
        }
    }
}
