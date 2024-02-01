<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationsResource;
use App\Traits\SuccessMessage;

class OrganizationController extends Controller
{
    use SuccessMessage;

    public function indexConfig()
    {
        $organization = config('interconnect.servers');
        foreach($organization as $i => $server){
            if($server[0] == config('organization.identifier') ){
                unset($organization[$i]);
                break;
            }
        }
        return OrganizationsResource::collection($organization);
    }

}
