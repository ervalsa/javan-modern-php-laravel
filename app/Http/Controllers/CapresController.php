<?php

namespace App\Http\Controllers;

use App\Services\ApiCapresService;

class CapresController extends Controller
{
    public function index()
    {
        $data = ApiCapresService::capresData();

        return view('welcome', [
            'data' => $data,
        ]);
    }
}
