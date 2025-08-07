<x-app-layout>
    <x-slot name="header">
            <div style="display: flex; align-items: center; gap: 10px;">
            <i data-lucide="chart-gantt" class="icon" style="color: #2563eb;"></i>
              <h2 class="text-2xl font-extrabold text-gray-800">
                Dashboard

            </h2>
        </div>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">
        {{-- Visão Geral --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-100 text-blue-800 p-4 rounded-lg shadow-sm">
                <h3 class="text-sm font-medium">Total de Instâncias</h3>
                <p class="text-2xl font-bold mt-1">{{ $total }}</p>
            </div>

            <div class="bg-green-100 text-green-800 p-4 rounded-lg shadow-sm">
                <h3 class="text-sm font-medium">Instâncias Conectadas</h3>
                <p class="text-2xl font-bold mt-1">{{ $conectadas }}</p>
            </div>

            <div class="bg-red-100 text-red-800 p-4 rounded-lg shadow-sm">
                <h3 class="text-sm font-medium">Instâncias Desconectadas</h3>
                <p class="text-2xl font-bold mt-1">{{ $desconectadas }}</p>
            </div>
        </div>



        {{-- Lista de Instâncias com Detalhes --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Instâncias</h3>

            <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-sm">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Chave</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Usuário</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($instances as $i => $instance)
                            <tr>
                                <td class="px-6 py-3">{{ $i + 1 }}</td>
                                <td class="px-6 py-3">{{ $instance['instance_key'] ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    @if(!empty($instance['phone_connected']) && $instance['phone_connected'] === true)
                                        <span class="text-green-600 font-semibold">Conectado</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Desconectado</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">{{ $instance['user']['id'] ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-center text-gray-500">Nenhuma instância encontrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>