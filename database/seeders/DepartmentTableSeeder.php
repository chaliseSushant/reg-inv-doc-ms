<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['main', 'Main'],
            ['fin', 'Finance'],
            ['reg', 'Registration'],
            ['head', 'Head of Office'],
            ['hr', 'Human Resource'],

        ];
        foreach ($data as $datum)
        {
            $department = new Department();
            $department->identifier = $datum[0];
            $department->interconnect = 1;
            $department->name = $datum[1];
            $department->save();
        }
    }
}
