<?php

namespace App\Http\Controllers;

use App\Services\User\Contracts\IUserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    
    var IUserService $userService;
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }


    public function sendCode(Request $request)
    {
        try{

            $request->validate(
                [
                    'mobile' => 'required|string'
                ]
            );

            if($this->userService->sendCode($request->mobile))
            {
                return response()->json(
                    [
                        'status' => 'SUCCESS',
                    ]
                );
            } 

        }catch(Exception $e)
        {
            return response()->json(
                [
                    'status' => 'ERROR',
                    'message' => $e->getMessage()
                ] , 500
            );
        }   
    }


    public function confrimCode(Request $request)
    {
        try{

            $request->validate(
                [
                    'mobile' => 'required|string',
                    'code' => 'required|string'
                ]
            );

            $jwt = $this->userService->confrimCode($request->mobile , $request->code);
            
            if(is_string($jwt))
            {
                return response()->json(
                    [
                        'status' => 'SUCCESS',
                        'token' => $jwt
                    ]
                );
            } 

        }catch(Exception $e)
        {
            return response()->json(
                [
                    'status' => 'ERROR',
                    'message' => $e->getMessage()
                ] , 500
            );
        }   
    }
}
