<?php

namespace App\Services\User\Contracts;


interface IUserService
{
    public function confrimCode(string $mobile) : string;
    public function sendCode(string $mobile) : bool;
}