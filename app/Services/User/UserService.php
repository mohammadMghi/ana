<?php

namespace App\Services\User;
use App\Exceptions\ConfrimCodeNotValid;
use App\Exceptions\TokenNotValidException;
use App\Services\User\Contracts\IUserService;


class UserService implements IUserService
{

    public function confrimCode(string $mobile) : string
    {

        

        throw new ConfrimCodeNotValid("Code not valid");
    } 
    public function sendCode(string $mobile) : bool
    {

    }
}