<?php

namespace App\Http\Controllers\Auth;

use App\Facade\LogActivityFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email'=>$request->email , 'password' => $request->password])){
            $user = Auth::user();
            //dd($user->id);

            if(Token::where('user_id', $user->id)->update(['revoked' => true]))
                LogActivityFacade::addToLog('User Revoked');

            $responseArray = [];
            $responseArray ['token'] = $user->createToken('DCM')->accessToken;
            $responseArray ['name'] = $user->name;
            $responseArray ['role'] = $user->role->role;
            LogActivityFacade::addToLog('User logged in', $user->id);
            return response()->json($responseArray,200);

        } else {
            return response()->json(['error' => 'Unauthenticated'],203);
        }

    }

    public function logout(Request $request)
    {
        if($request->user()->token()->revoke()){

            LogActivityFacade::addToLog('User logged out');

            return response()->json(['success' => 'user logged out'],200);

        }else {
            return response()->json(['error' => 'Cannot logout Something went wrong'],203);
        }
    }

}
