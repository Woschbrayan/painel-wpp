<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" style="color: #4F46E5;">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
            <h2 style="font-size: 24px; font-weight: bold; color: #1F2937;">Perfil</h2>
        </div>
    </x-slot>

    <div style="padding: 48px 0;">
        <div style="max-width: 960px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">

            {{-- Informações do Perfil --}}
            <div style="background: #fff; padding: 32px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="max-width: 640px;">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Alterar Senha --}}
            <div style="background: #fff; padding: 32px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="max-width: 640px;">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Excluir Conta --}}
            <div style="background: #fff; padding: 32px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="max-width: 640px;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
