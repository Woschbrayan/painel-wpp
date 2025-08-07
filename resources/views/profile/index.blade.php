<x-app-layout>
    {{-- Título com ícone --}}
    <x-slot name="header">

        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0 2.28-1.72 4-4 4s-4-1.72-4-4 1.72-4 4-4 4 1.72 4 4zM22 11c0 2.28-1.72 4-4 4s-4-1.72-4-4 1.72-4 4-4 4 1.72 4 4z" />
            </svg>
            <h2 class="text-2xl font-extrabold text-gray-800">
                Lista de Usuários
            </h2>
            <a href="{{ route('users.create') }}"
                class="ml-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-sm transition-all">
                Novo Usuário
            </a>


        </div>



    </x-slot>

    <div
        style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-top: 24px;">
        {{-- Botão de novo usuário --}}


        {{-- Tabela de usuários --}}
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: #F3F4F6;">
                    <tr style="text-align: left; font-size: 13px; text-transform: uppercase; color: #6B7280;">
                        <th style="padding: 12px; border-bottom: 1px solid #E5E7EB;">Nome</th>
                        <th style="padding: 12px; border-bottom: 1px solid #E5E7EB;">Email</th>
                        <th style="padding: 12px; border-bottom: 1px solid #E5E7EB;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr style="border-bottom: 1px solid #E5E7EB; font-size: 14px;">
                            <td style="padding: 12px;">{{ $user->name }}</td>
                            <td style="padding: 12px;">{{ $user->email }}</td>

                            <td style="padding: 12px;">
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                    class="ml-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-sm transition-all">
                                    Editar</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>