<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WppApiService;
class ProfileWppController extends Controller
{
    public function index(Request $request, WppApiService $wpp)
    {
        $instances = $wpp->listInstances();
        $selectedInstance = $request->get('instance');
        $profile = null;

        if ($selectedInstance) {
            $profile = $wpp->getProfile($selectedInstance);
        }

        return view('profileWpp.index', compact('instances', 'selectedInstance', 'profile'));
    }
}
