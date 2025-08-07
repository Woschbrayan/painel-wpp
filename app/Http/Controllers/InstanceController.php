<?php

namespace App\Http\Controllers;

use App\Services\WppApiService;
use Illuminate\Http\Request;

class InstanceController extends Controller
{
    public function index(WppApiService $wpp)
    {
        $instances = $wpp->listInstances();

        return view('instances.index', compact('instances'));
    }
    public function qr($key, WppApiService $wpp)
    {
        $qrcode = $wpp->getQrCode($key);

        return view('instances.qr', [
            'instanceKey' => $key,
            'qrcode' => $qrcode
        ]);
    }
    public function connect($key, WppApiService $wpp)
    {
        $qrcode = $wpp->connectInstance($key);

        return view('instances.connect', [
            'instanceKey' => $key,
            'qrcode' => $qrcode
        ]);
    }
    public function store(Request $request, WppApiService $wpp)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'webhook' => 'nullable|boolean',
            'webhookUrl' => 'nullable|url',
        ]);

        $name = $validated['name'];
        $webhook = $request->has('webhook');
        $webhookUrl = $validated['webhookUrl'] ?? null;

        $success = $wpp->createInstance($name, $webhook, $webhookUrl);

        if ($success) {
            return redirect()->route('instances.index')->with('success', 'Instância criada com sucesso!');
        }

        return back()->withErrors(['error' => 'Erro ao criar instância.']);
    }
    
    public function logout($name, WppApiService $wpp)
{
    $success = $wpp->logoutInstance($name);

    return response()->json(['success' => $success]);
}

public function destroy($name, WppApiService $wpp)
{
    $success = $wpp->deleteInstance($name);

    return response()->json(['success' => $success]);
}



}
