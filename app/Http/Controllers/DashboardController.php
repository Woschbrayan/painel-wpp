<?php

namespace App\Http\Controllers;

use App\Services\WppApiService;

class DashboardController extends Controller
{
    /**
     * Exibe o painel principal com status das instâncias.
     * Rota: /dashboard
     */
    public function index(WppApiService $wpp)
    {
        // 🔹 Busca todas as instâncias do painel
        $instances = $wpp->listInstances();

        // 🔹 Contagem geral
        $total = count($instances);
        $conectadas = collect($instances)->where('phone_connected', true)->count();
        $desconectadas = $total - $conectadas;

        // 🔹 Renderiza a view com os dados
        return view('dashboard', compact(
            'instances',
            'total',
            'conectadas',
            'desconectadas'
        ));
    }
}
