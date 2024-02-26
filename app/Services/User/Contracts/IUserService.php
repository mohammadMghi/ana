<?php

namespace App\Services\User\Contracts;


interface IUserService
{
    public function confrimCode(string $mobile , string $code) : string;
    public function sendCode(string $mobile) : bool;
}