<?php
namespace App\Http\Controllers;

use App\Services\WppApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LabelController extends Controller
{
    public function index(Request $request, WppApiService $wpp)
    {
        $instances = $wpp->listInstances();
        $selectedInstance = $request->get('instance');
        $labels = collect();

        if ($selectedInstance) {
            $allLabels = $wpp->getLabels($selectedInstance);
            $labels = $this->paginate($allLabels, 10);
        }

        return view('labels.index', compact('instances', 'labels'));
    }

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
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
