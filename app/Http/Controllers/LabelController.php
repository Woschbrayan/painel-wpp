<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\WppApiService;

class LabelController extends Controller
{
    /**
     * Lista as etiquetas (labels) da instância selecionada.
     * Rota: /dashboard/rotulos
     */
    public function index(Request $request, WppApiService $wpp)
    {
        // 🔹 Lista de instâncias para selecionar
        $instances = $wpp->listInstances();

        // 🔹 Pega a instância selecionada via query string (?instance=nome)
        $selectedInstance = $request->get('instance');

        $labels = collect(); // Lista vazia por padrão

        if ($selectedInstance) {
            // 🔹 Consulta as labels da instância
            $allLabels = $wpp->getLabels($selectedInstance);

            // 🔹 Paginação manual dos dados
            $labels = $this->paginate($allLabels, 10);
        }

        // 🔹 Renderiza a view com os dados
        return view('labels.index', compact('instances', 'labels'));
    }

    /**
     * Paginação manual para arrays vindos da API externa
     */
    protected function paginate(array $items, $perPage = 10)
    {
        $page = request()->get('page', 1);
        $collection = collect($items);
        $currentPageItems = $collection->slice(($page - 1) * $perPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),   // mantém /dashboard/rotulos
                'query' => request()->query() // mantém filtros ativos
            ]
        );
    }
}
