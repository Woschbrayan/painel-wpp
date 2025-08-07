<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    /**
     * Exibe o formulário de envio de mensagens.
     * Rota esperada: /dashboard/mensagens
     */
    public function form()
    {
        return view('messages.form');
    }

    /**
     * Envia a mensagem para o número selecionado, via API Baileys.
     * Suporta múltiplos tipos: texto, imagem, vídeo, áudio, documento, presença e visualizado.
     */
    public function send(Request $request)
    {
        // 🔒 Valida os campos obrigatórios
        $request->validate([
            'instance' => 'required', // nome da instância
            'number' => 'required',   // número de destino
            'type' => 'required',     // tipo de mensagem
        ]);

        $instance = $request->input('instance');
        $number = $request->input('number');
        $type = $request->input('type');

        // 🔐 Informações da API (definidas no .env)
        $apiKey = env('WPP_API_KEY');
        $urlBase = env('WPP_API_URL'); // Ex: https://wpp.brayanwosch.com.br

        $response = null;

        // 🚀 Escolhe o tipo de envio baseado no tipo informado
        switch ($type) {
            case 'text':
                // Envio de mensagem de texto simples
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                ])->post("{$urlBase}/message/text/{$instance}", [
                    'number' => $number,
                    'message' => $request->input('message'),
                    'mentions' => [], // suporte futuro a menções
                ]);
                break;

            case 'image':
            case 'video':
            case 'audio':
            case 'doc':
                // Envio de mídias usando multipart/form-data
                $endpoint = "message/{$type}/{$instance}";
                $file = $request->file('file');
                $response = Http::attach('file', $file->get(), $file->getClientOriginalName())
                    ->asMultipart()
                    ->withHeaders(['x-api-key' => $apiKey])
                    ->post("{$urlBase}/{$endpoint}", [
                        'number' => $number,
                        'caption' => $request->input('caption'), // legenda opcional
                        'viewOnce' => $request->boolean('viewOnce'), // imagem com visualização única
                    ]);
                break;

            case 'presence':
                // Simular presença digitando / gravando
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                ])->post("{$urlBase}/message/set-presence/{$instance}", [
                    'number' => $number,
                    'status' => $request->input('status'), // typing, recording, etc.
                    'delay' => $request->input('delay', 0),
                ]);
                break;

            case 'seen':
                // Marca como visualizado
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                ])->post("{$urlBase}/message/send-seen/{$instance}", [
                    'number' => $number,
                ]);
                break;
        }

        // ✅ Retorna para o formulário com sucesso e dados da resposta
        return back()->with('success', 'Mensagem enviada!')
                     ->with('response', $response?->json());
    }
}
