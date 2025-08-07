<?php
namespace App\Http\Controllers;

use App\Services\WppApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class GroupController extends Controller
{
    public function index(Request $request, WppApiService $wpp)
    {
        $instances = $wpp->listInstances();
        $selectedInstance = $request->get('instance');
        $groups = collect();

        if ($selectedInstance) {
            $allGroups = $wpp->getGroups($selectedInstance);
            $groups = $this->paginate($allGroups, 10);
        }

        return view('groups.index', compact('instances', 'groups'));
    }

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
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
