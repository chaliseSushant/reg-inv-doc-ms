<?php

namespace Tests\Feature;

use App\Models\FiscalYear;
use Database\Factories\FiscalYearFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FiscalYearTest extends TestCase
{
    use RefreshDatabase;
    //use DatabaseMigrations;


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fiscal_year_route_exists()
    {
        $response = $this->get('/fiscal-years');

        $response->assertStatus(200);
    }

    /*public function test_user_can_browse_fiscal_year()
    {
        $response = $this->post('/fiscal-year/save',[
            'year' => '2077/22',
            'active' => 0
        ]);



        $response = $this->get('/fiscal-years');

        //$response->assertDontSee(['year' => '2077/12','active' => 0]);

        $response->assertSee(['year' => '2077/22','active' => 0]);
    }*/

    public function test_it_stores_and_redirect_new_fiscal_year()
    {
        $response = $this->post('/fiscal-year/save',[
            'year' => '2077/12',
             'active' => 0
            ]);

        $response->assertStatus(201);
    }

    public function test_it_stores_updates_and_redirect_new_fiscal_year()
    {
        $this->post('/fiscal-year/save',[
            'year' => '2077/12',
            'active' => 0
        ]);

        $response = $this->put('/fiscal-year/update',[
            'id' => FiscalYear::all('id')->pluck('id')[0],
            'year' => '2077/12',
            'active' => 1
        ]);

        $this->assertDatabaseCount('fiscal_years', 1);

        $this->assertDatabaseHas('fiscal_years', [
            'year' => '2077/12'
        ]);

        $this->assertDatabaseHas('fiscal_years', [
            'active' => 1
        ]);

        //$response->assertRedirect('/fiscal-years');
        $response->assertStatus(202);
    }

    public function test_user_can_delete_fiscal_year()
    {
        $this->post('/fiscal-year/save',[
            'year' => '2077/22',
            'active' => 0
        ]);

        /*$fiscalyear = FiscalYear::factory()->create();

        dd($fiscalyear);*/


        $response = $this->delete('/fiscal-year/delete/'.FiscalYear::all('id')->pluck('id')[0] );

        //$response->assertRedirect('/fiscal-years');
        //$response->assertStatus(204);
        //$response->assertExactJson(['redirect' => '/fiscal-years']);
        $response->assertStatus(202);
    }

    public function test_fiscal_year_soft_deletes()
    {
        $this->post('/fiscal-year/save',[
            'year' => '2077/22',
            'active' => 0
        ]);

        $this->delete('/fiscal-year/delete/'.FiscalYear::all('id')->pluck('id')[0] );

        $this->get('/fiscal-years');

        //$fiscalyear = FiscalYear::all();
        //dd($fiscalyear->onlyTrashed()->get());

        $this->assertSoftDeleted(FiscalYear::all()->first());

    }

  /*  public function test_province_does_not_get_unwanted_data()
    {

        $response = $this->post('/fiscal-year/save',[
            'year' => '2077/22',
            'active' => 0
        ]);



        $response = $this->get('/fiscal-years');

        $response->assertDontSee('something');

        //$response->assertSee(['year' => '2077/22','active' => 0]);

    }*/

    public function test_database_has_inserted_fiscal_year()
    {
        $response = $this->post('/fiscal-year/save',[
            'year' => '20772',
            'active' => 0
        ]);

        $this->assertDatabaseCount('fiscal_years', 1);

      $this->assertDatabaseHas('fiscal_years', [
            'year' => '20772'
        ]);

    }
}
