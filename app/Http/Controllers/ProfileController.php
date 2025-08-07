<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Exibe o formulário de edição do perfil do usuário autenticado.
     * Rota esperada: /dashboard/perfil
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Atualiza os dados do perfil do usuário autenticado.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Preenche os campos validados
        $request->user()->fill($request->validated());

        // Caso o e-mail tenha sido alterado, remove a verificação
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Exclui permanentemente a conta do usuário autenticado.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Valida a senha atual para segurança
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout(); // Encerra a sessão

        $user->delete(); // Deleta o usuário

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Lista todos os usuários (para área administrativa).
     * Rota esperada: /dashboard/usuarios
     */
    public function list(): View
    {
        $users = User::all();
        return view('profile.index', compact('users'));
    }

    /**
     * Formulário de edição de outro usuário (admin).
     * Rota esperada: /dashboard/usuarios/{user}/editar
     */
    public function editUser(User $user): View
    {
        return view('profile.edit', ['user' => $user]);
    }
}
