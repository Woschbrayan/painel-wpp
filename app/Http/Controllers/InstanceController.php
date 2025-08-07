<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WppApiService;

class InstanceController extends Controller
{
    /**
     * Lista todas as instâncias disponíveis.
     * Rota: /dashboard/instancias
     */
    public function index(WppApiService $wpp)
    {
        $instances = $wpp->listInstances();

        return view('instances.index', compact('instances'));
    }

    /**
     * Exibe o QR Code da instância.
     * Rota: /dashboard/instancias/{key}/qr
     */
    public function qr($key, WppApiService $wpp)
    {
        $qrcode = $wpp->getQrCode($key);

        return view('instances.qr', [
            'instanceKey' => $key,
            'qrcode' => $qrcode
        ]);
    }

    /**
     * Força a conexão da instância e retorna novo QR Code.
     * Rota: /dashboard/instancias/{key}/connect
     */
    public function connect($key, WppApiService $wpp)
    {
        $qrcode = $wpp->connectInstance($key);

        return view('instances.connect', [
            'instanceKey' => $key,
            'qrcode' => $qrcode
        ]);
    }

    /**
     * Cria uma nova instância com ou sem webhook.
     * Rota: POST /dashboard/instances
     */
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

    /**
     * Desconecta (faz logout) da instância.
     * Rota: DELETE /dashboard/instances/logout/{name}
     */
    public function logout($name, WppApiService $wpp)
    {
        $success = $wpp->logoutInstance($name);

        return response()->json(['success' => $success]);
    }

    /**
     * Remove a instância permanentemente.
     * Rota: DELETE /dashboard/instances/delete/{name}
     */
    public function destroy($name, WppApiService $wpp)
    {
        $success = $wpp->deleteInstance($name);

        return response()->json(['success' => $success]);
    }
}
