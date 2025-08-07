<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight">
            Conectar Instância: {{ $instanceKey }}
        </h2>
    </x-slot>

    <div class="p-6">
        @if($qrcode)
            <img src="{{ $qrcode }}" alt="QR Code" class="mx-auto border rounded shadow w-72 h-72">
            <p class="text-center mt-4 text-gray-600">Escaneie com o WhatsApp para conectar</p>
        @else
            <p class="text-red-600">QR Code não disponível no momento.</p>
        @endif
    </div>
</x-app-layout>
