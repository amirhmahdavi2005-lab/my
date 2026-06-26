<?php

namespace Modules\PriceVariation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UpdatePricesController extends Controller
{
    public function __invoke(Request $request)
    {
        // TODO: implement price update logic
        return response()->json(['message' => 'ok']);
    }
}
