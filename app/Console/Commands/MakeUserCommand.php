<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\User\StoreUser;

use App\Exceptions\User\AlreadyExistUserByEmailException;
use App\Exceptions\User\AlreadyExistUserByIdentificationException;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rules\Password;

class MakeUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {name} {lastname} {email} {identification} {birthday} {password} {is_admin} {is_active}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un usuario con su rol';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $lastname = $this->argument('lastname');
        $identification = $this->argument('identification');
        $birthday = $this->argument('birthday');
        $password = $this->argument('password');
        $email = $this->argument('email');
        $isAdmin = $this->argument('is_admin');
        $isActive = $this->argument('is_active');

        $validator = Validator::make([
                'name' => $name,
                'lastname' => $lastname,
                'email' => $email,
                'identification' => $identification,
                'birthday' => $birthday,
                'password' => $password,
                'is_admin' => $isAdmin,
                'is_active' => $isActive,
            ],
            [
                'name' => ['required', 'string', 'min:3'],
                'lastname' => ['required', 'string', 'min:3'],
                'identification' => ['required', 'integer', 'unique:users,identification'],
                'email' => ['required', 'email', 'unique:users,email'],
                'birthday' => ['required', 'date'],
                'password' => ['required', 'min:9', Password::min(9)->letters()->numbers()],
                'is_admin' => ['required', 'boolean'],
                'is_active' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            $this->info('Usuario de personal no creado. Vea los mensajes de error a continuación:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return false;
        }

        $user = new StoreUser();

        try{
            $user->handle(
                $name,
                $lastname,
                $email,
                $birthday,
                $identification,
                $password,
                $isAdmin,
                $isActive,
            );    
        }catch(AlreadyExistUserByEmailException $ex){
            $this->error($ex->getMessage());
            return false;
        }catch(AlreadyExistUserByIdentificationException $ex){
            $this->error($ex->getMessage());
            return false;
        }
        $this->info('Se ha creado el usuario');
        return true;
    }
}
