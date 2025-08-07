<x-app-layout>
    {{-- Cabeçalho com ícone --}}
    <x-slot name="header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i data-lucide="tags" class="icon" style="color: #2563eb;"></i>
             <h2 class="text-2xl font-extrabold text-gray-800">
                Lista de Etiquetas
            </h2>
        </div>
    </x-slot>

    <div style="background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); max-width: 1000px; margin: 0 auto;">
        {{-- Filtro de Instância --}}
        <form method="GET" action="{{ route('labels.index') }}" style="margin-bottom: 32px;">
            <label for="instance" style="display: block; font-size: 14px; margin-bottom: 6px; color: #4b5563;">
                Selecione a Instância:
            </label>
            <select name="instance" id="instance" onchange="this.form.submit()"
                style="padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; width: 100%; max-width: 400px;">
                <option value="">-- Escolha uma instância --</option>
                @foreach ($instances as $instance)
                    <option value="{{ $instance['instance_key'] }}" {{ request('instance') === $instance['instance_key'] ? 'selected' : '' }}>
                        {{ $instance['instance_key'] }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Tabela de Etiquetas --}}
        @if($labels->count())
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: #fff;">
                    <thead style="background: #f3f4f6; text-transform: uppercase; font-size: 14px; color: #374151;">
                        <tr>
                            <th style="text-align: left; padding: 12px; border-bottom: 2px solid #e5e7eb;">Nome</th>
                            <th style="text-align: left; padding: 12px; border-bottom: 2px solid #e5e7eb;">ID</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px; color: #374151;">
                        @foreach($labels as $label)
                            <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                                <td style="padding: 12px;">{{ $label['name'] ?? '-' }}</td>
                                <td style="padding: 12px;">{{ $label['id'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            <div style="margin-top: 24px; display: flex; justify-content: center; gap: 4px; flex-wrap: wrap;">
                {{-- Anterior --}}
                @if ($labels->onFirstPage())
                    <span style="padding: 6px 12px; background: #d1d5db; color: #6b7280; border-radius: 4px;">«</span>
                @else
                    <a href="{{ $labels->previousPageUrl() }}"
                        style="padding: 6px 12px; background: #e5e7eb; color: #374151; border-radius: 4px; text-decoration: none;">«</a>
                @endif

                {{-- Páginas --}}
                @for ($i = 1; $i <= $labels->lastPage(); $i++)
                    @if ($i == $labels->currentPage())
                        <span style="padding: 6px 12px; background: #2563eb; color: white; font-weight: 600; border-radius: 4px;">{{ $i }}</span>
                    @else
                        <a href="{{ $labels->url($i) }}"
                            style="padding: 6px 12px; background: #e5e7eb; color: #374151; border-radius: 4px; text-decoration: none;">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Próximo --}}
                @if ($labels->hasMorePages())
                    <a href="{{ $labels->nextPageUrl() }}"
                        style="padding: 6px 12px; background: #e5e7eb; color: #374151; border-radius: 4px; text-decoration: none;">»</a>
                @else
                    <span style="padding: 6px 12px; background: #d1d5db; color: #6b7280; border-radius: 4px;">»</span>
                @endif
            </div>
        @else
            <p style="color: #6b7280; margin-top: 20px;">Nenhuma etiqueta encontrada para esta instância.</p>
        @endif
    </div>

    {{-- Ativa ícones Lucide --}}
    @push('scripts')
        <script>
            lucide.createIcons();
        </script>
    @endpush
</x-app-layout>
