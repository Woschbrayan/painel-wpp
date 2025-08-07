<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WppApiService
{
    protected $baseUrl;
    protected $apiKey;


    public function __construct()
    {
        $this->baseUrl = 'https://wpp.brayanwosch.com.br';
        $this->apiKey = 'chavefortebrayan123';
    }

    public function listInstances(): array
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get("{$this->baseUrl}/instance/list");

        if ($response->successful()) {
            return $response->json('data') ?? [];
        }

        return [];
    }
    public function getContacts(string $instanceKey): array
    {

        $instanceKey = "brayan";
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get("{$this->baseUrl}/contacts/all/brayan");

        if ($response->successful()) {
            return $response->json('contacts') ?? [];
        }

        return [];
    }
    public function getQrCode(string $instanceKey): ?string
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get("{$this->baseUrl}/instance/qr/{$instanceKey}");

        if ($response->successful()) {
            return $response->json('response.qrcode') ?? null;
        }

        return null;
    }
    public function connectInstance(string $instanceKey): ?string
{
    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
    ])->get("{$this->baseUrl}/instance/connect/{$instanceKey}");

    if ($response->successful()) {
        return $response->json('qrcode') ?? null;
    }

    return null;
}
public function contacts(string $instance): array
{
    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
    ])->get("{$this->baseUrl}/chat/all/{$instance}");

    if ($response->successful()) {
        return $response->json('data') ?? [];
    }

    return [];
}

public function createInstance(string $name, bool $webhook = false, ?string $webhookUrl = null): bool
{
    $payload = [
        'name' => $name,
        'webhook' => $webhook,
    ];

    if ($webhook && $webhookUrl) {
        $payload['webhookUrl'] = $webhookUrl;
    }

    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
    ])->post("{$this->baseUrl}/instance/create", $payload);

    return $response->successful();
}
public function getGroups(string $instance): array
{
    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
    ])->get("{$this->baseUrl}/group/all/{$instance}");

    if ($response->successful()) {
        return $response->json('data') ?? [];
    }

    return [];
}

public function getLabels(string $instance): array
{
    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
    ])->get("{$this->baseUrl}/label/all/{$instance}");

    if ($response->successful()) {
        return $response->json('data') ?? [];
    }

    return [];
}
public function getProfile(string $instance): ?array
{
    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
    ])->get("{$this->baseUrl}/instance/profile/{$instance}");

    if ($response->successful()) {
        return $response->json('data') ?? null;
    }

    return null;
}
public function logoutInstance(string $name): bool
{
    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
    ])->delete("{$this->baseUrl}/instance/logout/{$name}");

    return $response->ok();
}

public function deleteInstance(string $name): bool
{
    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
    ])->delete("{$this->baseUrl}/instance/delete/{$name}");

    return $response->ok();
}



}
