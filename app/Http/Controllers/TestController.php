<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Document;
use App\Models\User;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\Concerns\Has;

class TestController extends Controller
{
    use SuccessMessage;

    public function invokable(Request $request){
        if ($request->hasHeader('Interconnect-Request')) {
            if ($request->header('Interconnect-Request') == 'A') {
                return $this->getUsers();
            } elseif ($request->header('Interconnect-Request') == 'AB') {
                return $this->getDepartments();
            }
            else
            {
                return response()->json(['error'=> 'Request source not allowed. Request not validated.'],401);
            }
        }
        else
        {
            return response()->json(['error'=> 'Request source not allowed. Request not allowed.'],401);
        }
    }

    private function getUsers(){
        $users = User::all();
        return $users;
    }

    private function getDepartments(){
        $departments = Department::all();
        return $departments;
    }

    /*public function test($id)
    {
        foreach (config('server') as $server)
        {
            if ($server[0] == $id)
            {
                return $server[1].', '.$server[2];
            }
        }
        return 'Could not authenticate server request.';
    }*/
    public function test3()
    {
        dd(Document::find(2)->assigns);
    }
    public function test()
    {
        $compare = Hash::check(config('server.org.private_key'),config('server.keys.org_01'));
        return $compare;
    }
    public function test2()
    {
        $value = "8HA5K3MP2xMNw6QtaebmBNenKIz0xfdQlOApcDfbQ6xdMGBjQxZ1xOvfXPSuUHlwcjk1NZ3htDqTtMVkEkdkEQEBNQrXHTm4iBwspNj5uewjJNvAkXnwDDW8i1w3SnHKsTZLDttENupMwfHdUxEmzIvcFB2skM4nmtUVuThXT1ejUgsSrAWZXsDrlvQpCJlAUkNqrWP1Su8R2dKTqCFkrZzvgaHTXKIiwpFjvhS2JJX7towxwwDaQP2xjBa8PRX6";
        return Hash::make($value);
    }
    public function result($server, $key)
    {
        return Hash::check(config('server.key.'.$server),$key);
    }
    public function check()
    {

        $url = 'http://dcm2/result';
        $fields = array('$server' => config('server.org.identifier'), '$key' => config('server.org.private_key'));
        $postdata = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $result;
    }

    public function allDocuments()
    {
        /*return User::find(1)->allDocuments()->get()->count();*/
        return Document::find(1)->departments;
    }
    public function shaTest()
    {
        //dd(config('interconnect.keys.id_1.base_url'));

        $a = 'GfIMfgpbL5MVM1zGFNuqyb1FNTl3L9dRGrJ4PXLdOOXIfmUOs7r1Uhjn0DMRJp4vjBlj0IXl9ide5KIqh2XwYBFjsd8l8mrXYurmKmKFb72uof5qx5ZDu4bJMFbIp3M09QQaqQIACq50DIIZncJxBZEOQHdj0VdbOzWbtdNKzWhDPOrR2fwtEZwnnttKt5E7UKZ8RKOHbFmI86m5mqdS4vAj3otAHlhySTWDiGmgsJ4QUgDbUiIDxo2i87v4bpRuYZdGl2G7TvZKXfl4bNG25pkxi7JUraVL8Q4Bv94rbOQffxdKdm17xu5n8i3cLfX27o708rCkKfiScl93EN3IwtntzXDc796Qs55BLefIc5qLKy41rc7ExHZzsAtBpvwv8EVsDk8jw5jAjuTBhoYr2Li8Nq6jaHPS0odok1vtCblsLBlDFLLuZB0UOfnEDbFPZWTAGBe3fevsxZnL40aBTC9EuXyn87oh4J1EbuAzSodXuF42U62Wx8Irt3AtaVoe';
        $b = 'af390c31cb9d27c0580efa087c16ef35de210e0b';
        $c = '01956b7e25a7df6da2ea7f52d4c910a521f8175';
        if ($b == sha1($a))
        {
            return 'success';
        }
        else
        {
            return 'fail';
        }
    }

    public function interserverDepartments($organization_identifier)
    {
        $configuration = config('interconnect.keys.'.$organization_identifier);
        $key = $configuration['key'];
        $url = $configuration['base_url'].'/interconnect';
        $response = Http::withHeaders([
            'Interconnect-Token' => $key , 'Interconnect-Request' => 'A'
        ])->get($url);

        return $response;
    }

    public function interserverUsers($organization_identifier)
    {
        $configuration = config('interconnect.keys.'.$organization_identifier);
        $key = $configuration['key'];
        $url = $configuration['base_url'].'/interconnect';
        $response = Http::withHeaders([
            'Interconnect-Token' => $key , 'Interconnect-Request' => 'AB'
        ])->get($url);

        return $response;
    }

    public function interserverDepartmentUsers($organization_identifier,$department_id)
    {
        $configuration = config('interconnect.keys.'.$organization_identifier);
        $key = $configuration['key'];
        $url = $configuration['base_url'].'/interconnect';
        $response = Http::withHeaders([
            'Interconnect-Token' => $key ,
            'Interconnect-Request' => 'AC' ,
            'Interconnect-Data' => $department_id
        ])->get($url);

        return $response;
    }



    //public function

}
