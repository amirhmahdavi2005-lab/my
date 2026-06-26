<?php


use \Modules\Users\Models\User;
use \Illuminate\Support\Facades\Hash;
use \Modules\Users\Contracts\UserRepositoryInterface;
function getAdminForTest(){
    $userRepo=app(UserRepositoryInterface::class);
    $user=User::where(['role'=>'admin'])->first();
    $user=$userRepo->first(['role'=>'admin']);
    if($user){
        return $user;
    }
    else{
        return  $userRepo->create([
            'username'=>'admin',
            'password'=>Hash::make('admin'),
            'role'=>'admin',
            'status'=>1
        ]);
    }
}
