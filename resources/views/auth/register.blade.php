<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0 2.28-1.72 4-4 4s-4-1.72-4-4 1.72-4 4-4 4 1.72 4 4zM22 11c0 2.28-1.72 4-4 4s-4-1.72-4-4 1.72-4 4-4 4 1.72 4 4z" />
            </svg>
            <h2 class="text-2xl font-extrabold text-gray-800">Novo Usuário</h2>
        </div>
    </x-slot>

    <div style="max-width: 600px; margin: 24px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nome --}}
            <div style="margin-bottom: 20px;">
                <label for="name" style="display: block; font-size: 14px; color: #374151; margin-bottom: 6px;">Nome</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 15px;" />
                @error('name')
                    <div style="color: #DC2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-size: 14px; color: #374151; margin-bottom: 6px;">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 15px;" />
                @error('email')
                    <div style="color: #DC2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Senha --}}
            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; font-size: 14px; color: #374151; margin-bottom: 6px;">Senha</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 15px;" />
                @error('password')
                    <div style="color: #DC2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirmação de Senha --}}
            <div style="margin-bottom: 20px;">
                <label for="password_confirmation" style="display: block; font-size: 14px; color: #374151; margin-bottom: 6px;">Confirmar Senha</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 15px;" />
                @error('password_confirmation')
                    <div style="color: #DC2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Ações --}}
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('users.index') }}"
                   style="padding: 10px 16px; background: #E5E7EB; color: #374151; border-radius: 6px; text-decoration: none;">Cancelar</a>
                <button type="submit"
                    style="padding: 10px 16px; background-color: #3B82F6; color: white; border: none; border-radius: 6px; font-size: 15px;">
                    Cadastrar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
