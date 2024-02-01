<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Revision;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images =
            [
                '/storage/test/1.jpg',
                '/storage/test/2.jpg',
                '/storage/test/3.jpg',
            ];

        $user_size = 3;
        $document_size = 30;
        $factory = new Factory();
        $file_sizes = 0;
        for ($i = 1; $i <=$document_size; $i++)
        {
            $random_file_size = rand(3,7);
            $file_sizes = $file_sizes + $random_file_size;
            for ($j = 1; $j<= $random_file_size; $j++)
            {
                $file = new File();
                $file->document_id = $i;
                $file->name = "File ".$i." ".$j;
                $file->save();
            }
        }

        for ($h=1; $h<= $file_sizes; $h++) {

            $random_revision_size = rand(2, 4);
            for ($k = 1; $k <= $random_revision_size; $k++) {
                $random_image = rand(0, 2);
                $rev = new Revision();
                $rev->file_id = $h;
                $rev->url = $images[$random_image];
                $rev->user_id = rand(1, $user_size);
                $rev->save();
            }
        }


    }
}
