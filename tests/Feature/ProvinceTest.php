<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProvinceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_province_route_exists()
    {
        $response = $this->withoutExceptionHandling()->get('/provinces');

        $response->assertStatus(200);
    }

    public function test_it_stores_and_redirect_new_province(){
        $response = $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        //$response->assertStatus(302);

       // $response->assertRedirect('/provinces');
        $response->assertStatus(201);
    }

    /*public function test_session_flash_message_after_save_update_and_delete_of_province()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $message = session('success');

        $this->assertEquals($message,"Province created successfully.");

        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->put('/province/update',[
            'id' => Province::all('id')->pluck('id')[0],
            'name' => 'name12',
            'identifier' => 'randomss'
        ]);

        $message = session('update');

        $this->assertEquals($message,"Province updated successfully.");


        $this->delete('/province/delete/'.Province::all('id')->pluck('id')[0] );

        $message = session('destroy');

        $this->assertEquals($message,"Province removed successfully.");

        //dd($message);
        //$this->assertSessionHasErrors();
        //$this->assertEquals($message->get('Success')[0],"Province created successfully.");
    }*/

    public function test_it_stores_updates_and_redirect_new_province()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->put('/province/update',[
            'id' => Province::all('id')->pluck('id')[0],
            'name' => 'name12',
            'identifier' => 'randomss'
        ]);

        $this->assertDatabaseCount('provinces', 1);

        $this->assertDatabaseHas('provinces', [
            'name' => ucwords('name12'),
        ]);

        $this->assertDatabaseHas('provinces', [
            'identifier' => 'randomss'
        ]);

        //$response->assertRedirect('/provinces');
        $response->assertStatus(202);
    }

    /*public function test_user_can_browse_province()
    {
        $response = $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->get('/provinces');

        $response->assertSee(['name' => ucwords('name1'),
            'identifier' => 'random']);
    }*/

    public function test_database_has_inserted_province()
    {
        $response = $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $this->assertDatabaseCount('provinces', 1);

        $this->assertDatabaseHas('provinces', [
            'name' => ucwords('name1'),
        ]);

    }

    /*public function test_province_does_not_get_unwanted_data()
    {

        $response = $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->get('/provinces');

        $response->assertDontSee('something');
    }*/

    public function test_user_can_delete_province()
    {
        $this->post('/province/save',[
            'name' => 'name1',
            'identifier' => 'random'
        ]);

        $response = $this->delete('/province/delete/'.Province::all('id')->pluck('id')[0] );

        //$response->assertRedirect('/provinces');
        //$response->assertStatus(204);
        //$response->assertExactJson(['redirect' => '/provinces']);
        $response->assertStatus(202);
    }

    public function test_province_soft_deletes()
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
            'province_id' => District::all('id')->pluck('id')[0],
            'name' => 'name123',
            'identifier' => 'random'
        ]);

        $this->delete('/province/delete/'.Province::all('id')->pluck('id')[0] );

        $this->get('/provinces');

        $this->assertSoftDeleted(Province::all()->first());
        $this->assertSoftDeleted(District::all()->first());
        $this->assertSoftDeleted(Municipality::all()->first());
    }

    /*public function test_session_has_error_message()
    {
        $response = $this->post('/province/save',[
            'name' => '',
            'identifier' => 'random'
        ]);

        $this->assertDatabaseCount('provinces', 0);

        $response->assertSessionHasErrors([
            'name' => 'Please enter Province Name !!!'
        ]);
    }*/

}
