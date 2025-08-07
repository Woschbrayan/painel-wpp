<?php

namespace App\Http\Controllers;

use App\Services\WppApiService;

class DashboardController extends Controller
{
public function index(WppApiService $wpp)
{
    $instances = $wpp->listInstances();

    $total = count($instances);
    $conectadas = collect($instances)->where('phone_connected', true)->count();
    $desconectadas = $total - $conectadas;

    return view('dashboard', compact('instances', 'total', 'conectadas', 'desconectadas'));
}

}
