<?php

namespace Database\Seeders;

use App\Models\Assign;
use App\Models\Department;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Province;
use App\Models\Registration;
use App\Models\User;
use Database\Factories\InvoiceFactory;
use Database\Factories\RegistrationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //$this->call(AttributeTableSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(MunicipalityTableSeeder::class);
        $this->call(FiscalYearTableSeeder::class);
        $this->call(PrivilegeTableSeeder::class);
        Registration::factory()->count(30)->create();
        Invoice::factory()->count(30)->create();
        Document::factory()->count(60)->create();
        $this->call(DocumentableSeeder::class);
        $this->call(AssignableTableSeeder::class);
        $this->call(DocumentTypeTableSeeder::class);
        $this->call(FileSeeder::class);
        //$this->call(AssignableTableSeeder::class);
        //Document::factory()->count(20000)->create();
        //Document::factory()->count(20000)->create();
        //Registration::factory()->count(15000)->create();
        //Invoice::factory()->count(15000)->create();

        //$this->call(AssignSeeder::class);
        //$this->call(AssignSeeder::class);
        //$this->call(AssignSeeder::class);
        //$this->call(AssignSeeder::class);

    }
}
