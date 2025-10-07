<?php

namespace App\Exceptions\User;

use Exception;

class AlreadyExistUserByEmailException extends Exception
{
    //
    public function __construct($email){
        parent::__construct("Ya existe un usuario con el email $email.");
    }
}
