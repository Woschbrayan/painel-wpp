<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    public function form()
    {
        return view('messages.form');
    }

    public function send(Request $request)
    {
        $request->validate([
            'instance' => 'required',
            'number' => 'required',
            'type' => 'required',
        ]);

        $instance = $request->input('instance');
        $number = $request->input('number');
        $type = $request->input('type');

        $apiKey = env('WPP_API_KEY');
        $urlBase = env('WPP_API_URL'); // ex: https://wpp.brayanwosch.com.br

        $response = null;

        switch ($type) {
            case 'text':
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                ])->post("{$urlBase}/message/text/{$instance}", [
                    'number' => $number,
                    'message' => $request->input('message'),
                    'mentions' => [],
                ]);
                break;

            case 'image':
            case 'video':
            case 'audio':
            case 'doc':
                $endpoint = "message/{$type}/{$instance}";
                $response = Http::attach('file', $request->file('file')->get(), $request->file('file')->getClientOriginalName())
                    ->asMultipart()
                    ->withHeaders(['x-api-key' => $apiKey])
                    ->post("{$urlBase}/{$endpoint}", [
                        'number' => $number,
                        'caption' => $request->input('caption'),
                        'viewOnce' => $request->boolean('viewOnce'),
                    ]);
                break;

            case 'presence':
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                ])->post("{$urlBase}/message/set-presence/{$instance}", [
                    'number' => $number,
                    'status' => $request->input('status'),
                    'delay' => $request->input('delay', 0),
                ]);
                break;

            case 'seen':
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                ])->post("{$urlBase}/message/send-seen/{$instance}", [
                    'number' => $number,
                ]);
                break;
        }

        return back()->with('success', 'Mensagem enviada!')->with('response', $response?->json());
    }
}
