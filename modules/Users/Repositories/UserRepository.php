<?php

namespace Modules\Users\Repositories;

use Modules\Users\Contracts\UserRepositoryInterface;
use Modules\Users\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function first(array $condition)
    {
        return User::where($condition)->first();
    }

    public function create(array $data)
    {
        return  User::create($data);
    }
}
