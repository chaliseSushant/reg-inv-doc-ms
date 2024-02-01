<?php

namespace Database\Seeders;

use App\Models\Privilege;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivilegeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['manage-roles','Manage Roles'],
            ['manage-users','Manage Users'],
            ['manage-privileges','Manage Privileges'],
            ['manage-districts','Manage Districts'],
            ['manage-provinces','Manage Provinces'],
            ['manage-municipalities','Manage Municipalities'],
            ['manage-fiscal-years','Manage Fiscal Years'],
            ['manage-departments','Manage Departments'],
            ['manage-services','Manage Services'],
            ['manage-registrations','Manage Registrations'],
            ['read-activities','Read Activities'],
        ];
        $cruds = ['1111','1000','0000','1010','1110','0101','0001','1100'];
        foreach ($data as $datum)
        {
            $privilege = new Privilege();
            $privilege->identifier = $datum[0];
            $privilege->name = $datum[1];
            $privilege->save();
             for ($i = 1; $i<=3; $i++)
             {
                 $key = array_rand($cruds);
                 $privilege->roles()->attach(Role::find($i), ['crud' => '1111'] /*['crud' =>$cruds[$key]]*/);
             }
        }
    }
}
