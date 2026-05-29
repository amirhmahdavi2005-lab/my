<?php

namespace Modules\Main\Contracts;


use Illuminate\Http\Request;

interface CrudRepositoryInterface
{
    public function index(Request $request);
    public function find($id);

    public function delete($id);

    public function restore($id);

}
