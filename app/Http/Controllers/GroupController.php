<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\WppApiService;

class GroupController extends Controller
{
    /**
     * Exibe os grupos da instância selecionada, paginados.
     * Rota: /dashboard/grupos
     */
    public function index(Request $request, WppApiService $wpp)
    {
        // 🔹 Lista de instâncias disponíveis
        $instances = $wpp->listInstances();

        // 🔹 Instância selecionada via query (?instance=...)
        $selectedInstance = $request->get('instance');

        $groups = collect(); // Lista vazia por padrão

        if ($selectedInstance) {
            // 🔹 Obtém os grupos da instância selecionada
            $allGroups = $wpp->getGroups($selectedInstance);

            // 🔹 Pagina os grupos manualmente (10 por página)
            $groups = $this->paginate($allGroups, 10);
        }

        // 🔹 Renderiza a view com dados
        return view('groups.index', compact('instances', 'groups'));
    }

    /**
     * Paginação manual (para arrays vindos de APIs externas)
     */
    protected function paginate(array $items, $perPage = 10)
    {
        $page = request()->get('page', 1);
        $collection = collect($items);
        $currentPageItems = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),       // mantém /dashboard/grupos
                'query' => request()->query()     // preserva filtros (ex: ?instance=...)
            ]
        );
    }
}
