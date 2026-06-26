<?php

namespace Modules\Users\Contracts;

interface UserRepositoryInterface
{
    public function first(array $condition);
    public function create( array $data);
}
