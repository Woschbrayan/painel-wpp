<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WppApiService;

class ProfileWppController extends Controller
{
    /**
     * Exibe o perfil do número WhatsApp selecionado.
     * A view exibe a foto, nome e status do perfil da instância conectada.
     * Rota esperada: /dashboard/profile-wpp
     */
    public function index(Request $request, WppApiService $wpp)
    {
        // Lista todas as instâncias para o dropdown de seleção
        $instances = $wpp->listInstances();

        // Instância selecionada no filtro
        $selectedInstance = $request->get('instance');

        $profile = null;

        if ($selectedInstance) {
            // Obtém o perfil da instância (nome, status, imagem)
            $profile = $wpp->getProfile($selectedInstance);
        }

        // Retorna para a view com os dados
        return view('profileWpp.index', compact('instances', 'selectedInstance', 'profile'));
    }
}
