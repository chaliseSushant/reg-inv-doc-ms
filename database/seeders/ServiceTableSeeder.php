<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'कित्ताकाट',
            'हाल साविक भिडाउने',
            'शिक्षा सेवा',
            'जनस्वास्थ्य',
            'नक्सा भिडाउने',
            'सुचना प्रविधि',
            'सोधपुछ',
            'लेखा व्यवस्थापन',
            'अनुमतिपत्र एकिकरण',
            'अन्य',
        ];

        foreach ($data as $datum)
        {
            $service = new Service();
            $service->title = $datum;
            $service->save();
        }
    }
}
