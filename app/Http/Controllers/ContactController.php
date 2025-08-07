<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\WppApiService;

class ContactController extends Controller
{
    /**
     * Exibe os contatos da instância selecionada com paginação.
     * Rota: /dashboard/contatos
     */
    public function index(Request $request, WppApiService $wpp)
    {
        // 🔹 Todas as instâncias disponíveis (para dropdown de seleção, por ex.)
        $instances = $wpp->listInstances();

        // 🔹 Instância atualmente selecionada via ?instance=nome
        $selectedInstance = $request->query('instance');

        $contacts = collect(); // Lista vazia por padrão

        if ($selectedInstance) {
            // 🔹 Busca todos os contatos (chats) da instância
            $allChats = $wpp->contacts($selectedInstance);

            // 🔹 Agrupa por número (jid) e pega a última mensagem de cada
            $contacts = collect($allChats)
                ->whereNotNull('jid') // Filtra válidos
                ->groupBy('jid')
                ->map(function ($messages, $jid) {
                    $last = $messages->last();
                    return [
                        'id' => $jid,
                        'name' => $last['name'] ?? '',
                        'last_message' => $last['conversation'] ?? '',
                        'date' => $last['date'] ?? '',
                    ];
                })
                ->values(); // Reindexa
        }

        // 🔹 Paginação manual dos contatos (10 por página)
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $contactsPaginated = new LengthAwarePaginator(
            $contacts->slice(($page - 1) * $perPage, $perPage)->values(),
            $contacts->count(),
            $perPage,
            $page,
            [
                'path' => url()->current(), // mantém o /dashboard/contatos
                'query' => $request->query() // preserva os filtros
            ]
        );

        // 🔹 Renderiza a view com dados
        return view('contacts.index', [
            'contacts' => $contactsPaginated,
            'instances' => $instances,
        ]);
    }
}
