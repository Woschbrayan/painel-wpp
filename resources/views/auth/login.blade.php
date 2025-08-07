<x-guest-layout>
    <div style="max-width: 420px; margin: 60px auto; padding: 30px; background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

        {{-- Título --}}
        <h2 style="text-align: center; font-size: 24px; font-weight: bold; margin-bottom: 24px; color: #1F2937;">Acessar Painel</h2>

        {{-- Status da sessão --}}
        @if (session('status'))
            <div style="background-color: #D1FAE5; color: #065F46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-size: 14px; color: #374151; margin-bottom: 6px;">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 15px;" />
                @error('email')
                    <div style="color: #DC2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Senha --}}
            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; font-size: 14px; color: #374151; margin-bottom: 6px;">Senha</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 15px;" />
                @error('password')
                    <div style="color: #DC2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lembrar-me + Esqueci senha --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <label style="font-size: 14px; color: #4B5563;">
                    <input type="checkbox" name="remember" style="margin-right: 6px;" />
                    Manter conectado
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 14px; color: #2563EB; text-decoration: none;">
                        Esqueceu a senha?
                    </a>
                @endif
            </div>

            {{-- Botão login --}}
            <button type="submit"
                style="width: 100%; background-color: #3B82F6; color: white; padding: 12px; border: none; border-radius: 6px; font-size: 15px; cursor: pointer;">
                Entrar
            </button>
        </form>
    </div>
</x-guest-layout>
