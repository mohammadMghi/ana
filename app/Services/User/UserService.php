<?php

namespace App\Services\User;
use App\Exceptions\ConfrimCodeNotValid;
use App\Exceptions\TokenNotValidException;
use App\Models\User;
use App\Services\User\Contracts\IUserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;


class UserService implements IUserService
{

    public function confrimCode(string $mobile , string $code) : bool
    {

        if(!$this->getCode($mobile) == $code)
        {
            throw new ConfrimCodeNotValid("Code not valid");
        }

        return true;
        
    } 
    
    public function sendCode(string $mobile) : bool
    {

        $user = User::where('mobile' , $mobile)->first();

        if(is_null($user))
        {
            $user = new User();

            $user->phone_number = $mobile;

            $user->save();

            $this->insertCodeIntoRedis($mobile , $this->codeGenerator());

            return true;
        }

        $this->insertCodeIntoRedis($mobile,$this->codeGenerator());

        return true;
    }

    public function insertCodeIntoRedis($mobile , $code)
    {

        $timestamp = Carbon::now();  

        Redis::set($mobile, json_encode(['code' => $code, 'timestamp' => $timestamp]));

        Redis::expire($mobile, 120); 
    }

    public function codeGenerator() : string
    {
        return rand(1000,9999);
    }

    public function getCode(String $mobile) : string
    {
        $redis = Redis::get($mobile);

        if ($redis != null) 
        {
            $code = json_decode($redis , true);

            var_dump($code['code']);

            return $code['code'];
        }
        return "";

    }


}