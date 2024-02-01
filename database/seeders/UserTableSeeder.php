<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['Super Administrator','sadmin'],
            ['Administrator','admin'],
            ['Sub Administrator','sbadmin'],
        ];

        foreach ($data as $datum)
        {
            $role = new Role();
            $role->title = $datum[0];
            $role->role = $datum[1];
            $role->save();
        }

        $data = [
            ['IT Head','ithead@gmail.com','password1','sadmin', 1],
            ['IT Heads','itheads@gmail.com','password1','sadmin', 1],
            ['Division Officer','divisionofficer@gmail.com','password2','admin', 2],
            ['Division Officers','divisionofficers@gmail.com','password2','admin', 2],
            ['Assistant Officer','assistantofficer@gmail.com','password3','sbadmin', 3],
            ['Assistant Officers','assistantofficers@gmail.com','password3','sbadmin', 3],
            ['IT Heads 4','ithead4@gmail.com','password1','sadmin', 4],
            ['Division Officers 4','divisionofficer4@gmail.com','password2','admin', 4],
            ['Assistant Officer5','assistantofficer5@gmail.com','password3','sbadmin', 5],
            ['IT Heads 5','ithead5@gmail.com','password1','sadmin', 5],
        ];

        foreach ($data as $datum)
        {
            $user = new User();
            $user->name = $datum[0];
            $user->email = $datum[1];
            $user->password = Hash::make($datum[2]);
            $user->role_id = Role::where('role',$datum[3])->first()->id;
            $user->department_id = $datum[4];
            $user->save();
        }
    }
}
