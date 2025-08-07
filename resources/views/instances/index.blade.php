<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0 2.28-1.72 4-4 4s-4-1.72-4-4 1.72-4 4-4 4 1.72 4 4zM22 11c0 2.28-1.72 4-4 4s-4-1.72-4-4 1.72-4 4-4 4 1.72 4 4z" />
            </svg>
            <h2 class="text-2xl font-extrabold text-gray-800">
                Lista de Instâncias
            </h2>
            <a href="#" onclick="openInstanceModal()"
                class="ml-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-sm transition-all">
                Nova Instância
            </a>
        </div>
    </x-slot>

    <div class="bg-white shadow-md rounded-xl p-6 mt-6 overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Instância</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Usuário</th>
                    <th class="px-4 py-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($instances as $index => $instance)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 flex items-center gap-2 font-semibold text-gray-800">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ $instance['instance_key'] ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            @if(!empty($instance['phone_connected']) && $instance['phone_connected'] === true)
                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                    Conectado
                                </span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                    Desconectado
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-700">
                            {{ $instance['user']['id'] ?? 'Não vinculado' }}
                        </td>
                        <td class="px-4 py-3 text-center flex gap-2 justify-center flex-wrap">
                            {{-- Botão conectar --}}
                            <a href="{{ route('instances.connect', ['key' => $instance['instance_key']]) }}"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold text-xs px-3 py-1 rounded shadow transition">
                                Conectar
                            </a>

                            {{-- Botão desconectar --}}
                            <button onclick="logoutInstance('{{ $instance['instance_key'] }}')"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold text-xs px-3 py-1 rounded shadow transition">
                                Desconectar
                            </button>

                            {{-- Botão deletar --}}
                            <button onclick="deleteInstance('{{ $instance['instance_key'] }}')"
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold text-xs px-3 py-1 rounded shadow transition">
                                Deletar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Nenhuma instância encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

{{-- Modal --}}
<div id="instanceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 relative">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Criar Nova Instância</h3>

        <form method="POST" action="{{ route('instances.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-sm text-gray-700">Nome da Instância</label>
                <input type="text" name="name" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" id="webhook-toggle" name="webhook" value="1" class="rounded">
                    Ativar Webhook?
                </label>
            </div>

            <div id="webhook-url-field" class="mb-4 hidden">
                <label class="block font-semibold mb-1 text-sm text-gray-700">URL do Webhook</label>
                <input type="url" name="webhookUrl"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeInstanceModal()"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm">Cancelar</button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-semibold">Criar</button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
<script>
    const modal = document.getElementById('instanceModal');
    const webhookToggle = document.getElementById('webhook-toggle');
    const webhookField = document.getElementById('webhook-url-field');

    function openInstanceModal() {
        modal.classList.remove('hidden');
    }

    function closeInstanceModal() {
        modal.classList.add('hidden');
    }

    webhookToggle.addEventListener('change', function () {
        webhookField.classList.toggle('hidden', !this.checked);
    });

    async function logoutInstance(name) {
        if (!confirm(`Deseja realmente desconectar a instância ${name}?`)) return;

        try {
            const response = await fetch(`/instances/logout/${name}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            if (response.ok) {
                alert('Instância desconectada com sucesso!');
                location.reload();
            } else {
                alert('Erro ao desconectar a instância.');
            }
        } catch (error) {
            alert('Erro inesperado.');
        }
    }

    async function deleteInstance(name) {
        if (!confirm(`Tem certeza que deseja excluir a instância ${name}? Essa ação é irreversível.`)) return;

        try {
            const response = await fetch(`/instances/delete/${name}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            if (response.ok) {
                alert('Instância deletada com sucesso!');
                location.reload();
            } else {
                alert('Erro ao deletar a instância.');
            }
        } catch (error) {
            alert('Erro inesperado.');
        }
    }
</script>
