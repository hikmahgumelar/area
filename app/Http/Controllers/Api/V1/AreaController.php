<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.service');
        $this->middleware('permission:order-view', ['only' => 'index']);
    }

    public function index(Request $request)
    {
        return "test";
    }
}
