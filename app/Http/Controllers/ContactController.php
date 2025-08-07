<?php
namespace App\Http\Controllers;

use App\Services\WppApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactController extends Controller
{
public function index(Request $request, WppApiService $wpp)
{
    $instances = $wpp->listInstances();
    $selectedInstance = $request->query('instance');
    $contacts = collect();

    if ($selectedInstance) {
        $allChats = $wpp->contacts($selectedInstance);

        // Agrupar por número único (jid) e pegar a última mensagem
        $contacts = collect($allChats)
            ->where('jid', '!=', null)
            ->groupBy('jid')
            ->map(function ($messages, $jid) {
                $lastMessage = $messages->last();
                return [
                    'id' => $jid,
                    'name' => $lastMessage['name'] ?? '',
                    'last_message' => $lastMessage['conversation'] ?? '',
                    'date' => $lastMessage['date'] ?? '',
                ];
            })
            ->values(); // reorganiza índices
    }

    // Paginação manual
    $page = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 10;
    $contactsPaginated = new LengthAwarePaginator(
        $contacts->slice(($page - 1) * $perPage, $perPage)->values(),
        $contacts->count(),
        $perPage,
        $page,
        ['path' => url()->current(), 'query' => $request->query()]
    );

    return view('contacts.index', [
        'contacts' => $contactsPaginated,
        'instances' => $instances,
    ]);
}

}
