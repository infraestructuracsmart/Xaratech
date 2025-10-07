<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\User\StoreUser;

use App\Http\Requests\User\StoreUserRequest;

use App\Exceptions\User\AlreadyExistUserByEmailException;
use App\Exceptions\User\AlreadyExistUserByIdentificationException;

class UsersController extends Controller
{
    /**
     * index
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){

    }

    /**
     * get
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(){

    }

    /**
     * Crea un usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request){
        $storeUser = new StoreUser();
        try{
            $user = $storeUser->handle(
                $request->name,
                $request->lastname,
                $request->email,
                $request->birthday,
                $request->identification,
                $request->password,
                $request->is_active,
                $isAdmin = false,
            );
        }catch(AlreadyExistUserByEmailException $ex){
            abort(405, $ex->getMessage());
        }catch(AlreadyExistUserByIdentificationException $ex){
            abort(405, $ex->getMessage());
        }
        return response()->json([
            'data' => $user,
        ]);
    }

    /**
     * update
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuanate\Http\Response
     */
    public function update(){

    }

    /**
     * delete
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(){

    }
}
