<?php

namespace App\Interfaces;

interface UserInterface
{
    public function createUser($request);
    public function selectUser($request);
    public function updateUser($token, $name);
}
