<x-app-layout>
    {{-- Cabeçalho da Página --}}
    <x-slot name="header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i data-lucide="user-circle" class="icon" style="color: #2563eb;"></i>
             <h2 class="text-2xl font-extrabold text-gray-800">
                Perfil da Instancia
            </h2>
        </div>
    </x-slot>

    <div style="background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
        {{-- Formulário de Seleção de Instância --}}
        <form method="GET" action="{{ route('profile.index') }}" style="margin-bottom: 32px;">
            <label for="instance" style="display: block; font-size: 14px; margin-bottom: 6px; color: #4b5563;">Selecione a Instância:</label>
            <select name="instance" id="instance" onchange="this.form.submit()"
                style="padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; width: 100%; max-width: 400px;">
                <option value="">-- Escolha uma instância --</option>
                @foreach ($instances as $instance)
                    <option value="{{ $instance['instance_key'] }}" {{ $selectedInstance === $instance['instance_key'] ? 'selected' : '' }}>
                        {{ $instance['instance_key'] }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Exibição dos Dados da Instância --}}
        @if ($profile)
            <div style="display: flex; align-items: center; gap: 24px;">
                {{-- Foto de Perfil da Instância --}}
                <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; border: 4px solid #2563eb; background: #f3f4f6; box-shadow: 0 0 6px rgba(0,0,0,0.05);">
                    @if (!empty($profile['picture']))
                        <img src="{{ $profile['picture'] }}" alt="Foto de Perfil" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="display: flex; justify-content: center; align-items: center; height: 100%; color: #9ca3af;">
                            Sem imagem
                        </div>
                    @endif
                </div>

                {{-- Informações da Instância --}}
                <div style="flex: 1;">
                    <h3 style="font-size: 20px; font-weight: bold; color: #1f2937;">
                        {{ $profile['name'] ?: $profile['id'] }}
                    </h3>

                    <p style="color: #4b5563; margin-top: 4px;"><strong>ID:</strong> {{ $profile['id'] ?? '-' }}</p>
                    <p style="color: #4b5563;"><strong>Instância:</strong> {{ $selectedInstance }}</p>
                    <p style="color: #4b5563;">
                        <strong>Status:</strong>
                        @if($profile['error'] ?? false)
                            <span style="color: #dc2626; font-weight: 600;">Desconectado</span>
                        @else
                            <span style="color: #16a34a; font-weight: 600;">Conectado</span>
                        @endif
                    </p>
                </div>
            </div>
        @elseif ($selectedInstance)
            {{-- Caso não consiga carregar o perfil da instância --}}
            <p style="margin-top: 20px; color: #6b7280;">Não foi possível carregar o perfil desta instância.</p>
        @endif
    </div>

    {{-- Ativa os ícones Lucide (caso ainda não estejam sendo ativados globalmente no layout) --}}
    @push('scripts')
        <script>
            lucide.createIcons();
        </script>
    @endpush

</x-app-layout>
