
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel WPP</title>

    <!-- Estilo base -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-light text-dark" style="font-family: sans-serif; margin: 0;">
    <div style="display: flex; min-height: 100vh;">
        <!-- Sidebar -->
        <aside style="width: 240px; background: #fff; box-shadow: 2px 0 6px rgba(0,0,0,0.05); position: fixed; inset: 0 0 0 0;">
            <div style="padding: 24px; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 20px; font-weight: bold; color: #2563eb;">Bailyes Dashboard</h1>
            </div>

<nav style="padding: 16px; display: flex; flex-direction: column; gap: 10px;">
    <a href="{{ route('dashboard') }}" class="sidebar-link">
        <i data-lucide="layout-dashboard" class="icon"></i> Dashboard
    </a>
    <a href="{{ route('instances.index') }}" class="sidebar-link">
        <i data-lucide="server" class="icon"></i> Instância
    </a>
    <a href="{{ route('contacts.index') }}" class="sidebar-link">
        <i data-lucide="users" class="icon"></i> Contatos
    </a>
    <a href="{{ route('groups.index') }}" class="sidebar-link">
        <i data-lucide="message-circle" class="icon"></i> Grupos
    </a>
    <a href="{{ route('labels.index') }}" class="sidebar-link">
        <i data-lucide="tag" class="icon"></i> Etiquetas
    </a>
    <a href="{{ route('profileWpp.index') }}" class="sidebar-link">
        <i data-lucide="user-circle" class="icon"></i> Perfil
    </a>

    <!-- Menu de Configurações -->
    <div style="margin-top: 16px;">
        <div style="font-size: 13px; font-weight: bold; color: #6b7280; margin: 12px 8px 4px;">CONFIGURAÇÕES</div>
      <a href="{{ route('users.index') }}" class="sidebar-link">
    <i data-lucide="user-plus" class="icon"></i> Usuários
</a>
    </div>

    <form method="POST" action="{{ route('logout') }}" style="margin-top: 24px;">
        @csrf
        <button type="submit" class="sidebar-link" style="color: #dc2626;">
            <i data-lucide="log-out" class="icon"></i> Sair
        </button>
    </form>
</nav>
 
        </aside>

        <!-- Main Content -->
        <main style="flex: 1; margin-left: 240px; padding: 32px; background: #f9fafb;">
            @if (isset($header))
                <div style="margin-bottom: 24px;">
                    <h2 style="font-size: 24px; font-weight: bold; color: #111827; display: flex; align-items: center; gap: 8px;">
                        {{ $header }}
                    </h2>
                </div>
            @endif

            <div style="background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                {{ $slot }}
            </div>
        </main>
    </div>

    @stack('modals')
    @stack('scripts')

    <!-- Ativação dos ícones -->
    <script>
        lucide.createIcons();
    </script>

    <!-- Estilo inline básico (ou coloque no seu app.css) -->
    <style>
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: #1f2937;
            transition: background 0.2s;
        }

        .sidebar-link:hover {
            background: #e0e7ff;
        }

        .icon {
            width: 18px;
            height: 18px;
            color: #2563eb;
        }
    </style>
</body>

</html>
