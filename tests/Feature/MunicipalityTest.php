<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MunicipalityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_municipality_route_exists()
    {
        $response = $this->withoutExceptionHandling()->get('/municipalities');

        $response->assertStatus(200);
    }

    public function test_it_stores_and_redirect_new_municipality()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name12',
            'identifier' => 'random'
        ]);

        $response = $this->post('/municipality/save',[
            'district_id' => District::all('id')->pluck('id')[0],
            'name' => 'name123',
            'identifier' => 'random'
        ]);

        //$response->assertRedirect('/municipalities');
        $response->assertStatus(201);
    }

    public function test_it_stores_updates_and_redirect_new_municipality()
    {
        $this->post('/province/save',[
            'name' => 'prov1',
            'identifier' => 'idnprov1'
        ]);

        $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'dist1',
            'identifier' => 'idndist1'
        ]);

        $this->post('/municipality/save',[
            'district_id' => District::all('id')->pluck('id')[0],
            'name' => 'mun1',
            'identifier' => 'idnmun1'
        ]);

        $response = $this->put('/municipality/update',[
            'id' => Municipality::all('id')->pluck('id')[0],
            'district_id' => District::all('id')->pluck('id')[0],
            'name' => 'mun2',
            'identifier' => 'indmun2'
        ]);

        $this->assertDatabaseCount('municipalities', 1);

        $this->assertDatabaseHas('municipalities', [
            'name' => ucwords('mun2'),
        ]);

        $this->assertDatabaseHas('municipalities', [
            'identifier' => 'indmun2'
        ]);

        //$response->assertRedirect('/municipalities');
        $response->assertStatus(202);
    }



    /*public function test_user_can_browse_municipality()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name12',
            'identifier' => 'random'
        ]);

        $this->post('/municipality/save',[
            'district_id' => District::all('id')->pluck('id')[0],
            'name' => 'name123',
            'identifier' => 'random'
        ]);

        $response = $this->get('/municipalities');

        $response->assertSee(['name' => ucwords('name123'),
            'identifier' => 'random']);
    }*/

    public function test_database_has_inserted_municipality()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name12',
            'identifier' => 'random'
        ]);

        $this->post('/municipality/save',[
            'district_id' => District::all('id')->pluck('id')[0],
            'name' => 'name123',
            'identifier' => 'random'
        ]);

        $this->assertDatabaseCount('municipalities', 1);

        $this->assertDatabaseHas('municipalities', [
            'name' => ucwords('name123'),
        ]);

    }

   /* public function test_municipality_does_not_get_unwanted_data()
    {

        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name12',
            'identifier' => 'random'
        ]);

        $this->post('/municipality/save',[
            'district_id' => District::all('id')->pluck('id')[0],
            'name' => 'name123',
            'identifier' => 'random'
        ]);

        $response = $this->get('/municipalities');

        $response->assertDontSee('something');
    }*/

    public function test_user_can_delete_municipality()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name12',
            'identifier' => 'random'
        ]);

        $this->post('/municipality/save',[
            'district_id' => District::all('id')->pluck('id')[0],
            'name' => 'name123',
            'identifier' => 'random'
        ]);

        $response = $this->delete('/municipality/delete/'.District::all('id')->pluck('id')[0] );

        //$response->assertRedirect('/municipalities');
        //$response->assertStatus(204);
        //$response->assertExactJson(['redirect' => '/municipalities']);
        $response->assertStatus(202);
    }

    public function test_district_soft_deletes()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name12',
            'identifier' => 'random'
        ]);

        $this->post('/municipality/save',[
            'district_id' => District::all('id')->pluck('id')[0],
            'name' => 'name123',
            'identifier' => 'random'
        ]);

        $this->delete('/municipality/delete/'.Municipality::all('id')->pluck('id')[0] );

        $this->get('/municipalities');

        //$this->assertSoftDeleted(Province::all()->first());
        //$this->assertSoftDeleted(District::all()->first());
        $this->assertSoftDeleted(Municipality::all()->first());
    }

}
