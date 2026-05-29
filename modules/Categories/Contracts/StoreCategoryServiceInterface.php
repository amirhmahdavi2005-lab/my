<?php

namespace Modules\Categories\Contracts;

use Illuminate\Http\Request;

interface StoreCategoryServiceInterface
{
public function handel(Request $request);
}
