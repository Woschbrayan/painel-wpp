<x-app-layout>
    {{-- Título com ícone --}}
    <x-slot name="header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" style="color: #4F46E5;">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
            <h2 class="text-2xl font-extrabold text-gray-800">
                Lista de Contatos
            </h2>
        </div>
    </x-slot>

    <div style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-top: 24px;">
        {{-- Filtro de instância --}}
        <form method="GET" action="{{ route('contacts.index') }}" style="margin-bottom: 20px;">
            <label for="instance" style="font-size: 14px; color: #374151;">Selecione a Instância:</label>
            <select name="instance" id="instance" onchange="this.form.submit()"
                style="display: block; margin-top: 6px; padding: 10px; border: 1px solid #D1D5DB; border-radius: 6px; width: 300px;">
                <option value="">-- Escolha uma instância --</option>
                @foreach ($instances as $instance)
                    <option value="{{ $instance['instance_key'] }}" {{ request('instance') === $instance['instance_key'] ? 'selected' : '' }}>
                        {{ $instance['instance_key'] }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Lista de contatos --}}
        @if($contacts->count())
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background-color: #F3F4F6;">
                        <tr style="text-align: left; font-size: 13px; text-transform: uppercase; color: #6B7280;">
                            <th style="padding: 12px; border-bottom: 1px solid #E5E7EB;">Nome</th>
                            <th style="padding: 12px; border-bottom: 1px solid #E5E7EB;">Número</th>
                            <th style="padding: 12px; border-bottom: 1px solid #E5E7EB;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                            <tr style="border-bottom: 1px solid #E5E7EB; font-size: 14px;">
                                <td style="padding: 12px;">
                                    {{ $contact['name'] ?: str_replace('@s.whatsapp.net', '', $contact['id']) }}
                                </td>
                                <td style="padding: 12px;">
                                    {{ str_replace('@s.whatsapp.net', '', $contact['id']) }}
                                </td>
                                <td style="padding: 12px;">
                                    <a href="{{ route('messages.form') }}?number={{ str_replace('@s.whatsapp.net', '', $contact['id']) }}&instance={{ request('instance') }}"
                                        style="background-color: #10B981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; text-decoration: none;">
                                        Enviar Mensagem
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            <div style="margin-top: 24px; display: flex; justify-content: center; gap: 6px;">
                @if ($contacts->onFirstPage())
                    <span style="padding: 6px 10px; background: #E5E7EB; color: #6B7280; border-radius: 6px;">«</span>
                @else
                    <a href="{{ $contacts->previousPageUrl() }}"
                        style="padding: 6px 10px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none;">«</a>
                @endif

                @for ($i = 1; $i <= $contacts->lastPage(); $i++)
                    @if ($i == $contacts->currentPage())
                        <span style="padding: 6px 12px; background: #3B82F6; color: white; font-weight: bold; border-radius: 6px;">{{ $i }}</span>
                    @else
                        <a href="{{ $contacts->url($i) }}"
                            style="padding: 6px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none;">{{ $i }}</a>
                    @endif
                @endfor

                @if ($contacts->hasMorePages())
                    <a href="{{ $contacts->nextPageUrl() }}"
                        style="padding: 6px 10px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none;">»</a>
                @else
                    <span style="padding: 6px 10px; background: #E5E7EB; color: #6B7280; border-radius: 6px;">»</span>
                @endif
            </div>
        @else
            <p style="color: #6B7280; font-size: 15px;">Nenhum contato encontrado.</p>
        @endif
    </div>
</x-app-layout>
