<?php

namespace App\Exceptions\User;

use Exception;

class AlreadyExistUserByIdentificationException extends Exception
{
    //
    public function __construct($identification){
        parent::__construct("Ya existe un usuario con la identificación $identification.");
    }
}
