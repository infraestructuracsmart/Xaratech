<?php

namespace App\Services\User;

use App\Models\User;

use App\Exceptions\User\AlreadyExistUserByEmailException;
use App\Exceptions\User\AlreadyExistUserByIdentificationException;

class StoreUser{

    /**
     * Crea un usuario
     * @param string $name,
     * @param string $lastname,
     * @param string $email,
     * @param $identification,
     * @param $password,
     * @param $isAdmin = false,
     * @param $isActive = true
     * @return User
     */
    public function handle(
        string $name,
        string $lastname,
        string $email,
        $birthday,
        $identification,
        $password,
        $isAdmin = false,
        $isActive = true
    ){

        $this->validateIdentification($identification);
        $this->validateEmail($email);
        $user = User::create([
            'name' => strtoupper($name),
            'lastname' => strtoupper($lastname),
            'email' => $email,
            'birthdate' => $birthday,
            'identification' => $identification,
            'password' => bcrypt($password),
            'is_admin' => $isAdmin,
            'active' => $isActive
        ]);
        return $user;
    }

    /**
     * Valida si la identificación ya existe en un usuario
     * @param $identification
     * @return bool
     */
    public function validateIdentification($identification){
        $user = User::where('identification', $identification)->first();
        if($user){
            throw new AlreadyExistUserByIdentificationException($identification);
        }
        return false;
    }

    /**
     * Valida si el email ya existe en un usuario
     * @param $email
     * @return bool
     */
    public function validateEmail($email){
        $user = User::where('email', $email)->first();
        if($user){
            throw new AlreadyExistUserByEmailException($email);
        }
        return false;
    }
}