<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MigrateController extends Controller
{

    public function index()
    {
        Artisan::call('migrate');
        return response()->json(['Instalation success']);
    }

    public function refresh()
    {

        Artisan::call('migrate:refresh');
        return response()->json(['Instalation refresh success']);
    }

}
