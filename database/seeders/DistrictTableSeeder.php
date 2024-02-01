<?php

namespace Database\Seeders;

use App\Models\District;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* $data = [
            ['Bhojpur', 'Dhankuta', 'Ilam', 'Jhapa', 'Khotang', 'Morang', 'Okhaldhunga', 'Panchthar', 'Sankhuwasabha', 'Solukhumbu', 'Sunsari', 'Taplejung', 'Terhathum', 'Udayapur',],
            ['Parsa', 'Bara', 'Rautahat', 'Sarlahi', 'Mahottari', 'Dhanusha', 'Siraha', 'Saptari',],
            []
        ];*/

        $data = [
            ["Bhojpur",1],["Dhankuta",1],["Ilam",1],["Jhapa",1],["Khotang",1],["Morang",1],["Okhaldhunga",1],["Panchthar",1],["Sankhuwasabha",1],["Solukhumbu",1],["Sunsari",1],["Taplejung",1],["Terhathum",1],["Udayapur",1],
            ["Parsa",2],["Bara",2],["Rautahat",2],["Sarlahi",2],["Dhanusha",2],["Siraha",2],["Mahottari",2],["Saptari",2],
            ["Sindhuli",3],["Ramechhap",3],["Dolakha",3],["Bhaktapur",3],["Dhading",3],["Kathmandu",3],["Kavrepalanchok",3],["Lalitpur",3],["Nuwakot",3],["Rasuwa",3],["Sindhupalchok",3],["Chitwan",3],["Makawanpur",3],
            ["Baglung",4],["Gorkha",4],["Kaski",4],["Lamjung",4],["Manang",4],["Mustang",4],["Myagdi",4],["Nawalpur",4],["Parbat",4],["Syangja",4],["Tanahun",4],
            ["Kapilvastu",5],["Parasi",5],["Rupandehi",5],["Arghakhanchi",5],["Gulmi",5],["Palpa",5],["Dang",5],["Pyuthan",5],["Rolpa",5],["Eastern Rukum",5],["Banke",5],["Bardiya",5],
            ["Western Rukum",6],["Salyan",6],["Dolpa",6],["Humla",6],["Jumla",6],["Kalikot",6],["Mugu",6],["Surkhet",6],["Dailekh",6],["Jajarkot",6],
            ["Kailali",7],["Achham",7],["Doti",7],["Bajhang",7],["Bajura",7],["Kanchanpur",7],["Dadeldhura",7],["Baitadi",7],["Darchula",7],
        ];

        foreach ($data as $datum) {
            $district = new District();
            $district->name = $datum[0];
            $district->province_id = $datum[1];
            $district->identifier = $datum[1].'_'.strtolower(str_replace(' ','_',$datum[0]));
            $district->save();
        }
    }
}
