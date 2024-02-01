<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DistrictTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_district_route_exists()
    {
        $response = $this->withoutExceptionHandling()->get('/districts');

        $response->assertStatus(200);
    }

    public function test_it_stores_and_redirect_new_district()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        //$response->assertStatus(302);

        //$response->assertRedirect('/districts');
        $response->assertStatus(201);
    }

    public function test_it_stores_updates_and_redirect_new_district()
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

        $response = $this->put('/district/update',[
            'id' => District::all('id')->pluck('id')[0],
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'dist12',
            'identifier' => 'inddist2'
        ]);

        $this->assertDatabaseCount('districts', 1);

        $this->assertDatabaseHas('districts', [
            'name' => ucwords('dist12'),
        ]);

        $this->assertDatabaseHas('districts', [
            'identifier' => 'inddist2'
        ]);

        //$response->assertRedirect('/districts');
        $response->assertStatus(202);

    }

    /*public function test_user_can_browse_district()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->get('/districts');

        $response->assertSee(['name' => ucwords('name1'),
            'identifier' => 'random']);
    }*/

    public function test_database_has_inserted_district()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->assertDatabaseCount('districts', 1);

        $this->assertDatabaseHas('districts', [
            'name' => ucwords('name1'),
        ]);

    }

    /*public function test_district_does_not_get_unwanted_data()
    {

        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->get('/districts');

        $response->assertDontSee('something');
    }*/

    public function test_user_can_delete_district()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->post('/district/save',[
            'province_id' => Province::all('id')->pluck('id')[0],
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->delete('/district/delete/'.Province::all('id')->pluck('id')[0] );

        //$response->assertRedirect('/districts');
        //$response->assertStatus(204);
        //$response->assertExactJson(['redirect' => '/districts']);
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

        $this->delete('/district/delete/'.District::all('id')->pluck('id')[0] );

        $this->get('/districts');

        //$this->assertSoftDeleted(Province::all()->first());
        $this->assertSoftDeleted(District::all()->first());
        $this->assertSoftDeleted(Municipality::all()->first());
    }

}
