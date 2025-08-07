<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ProfileWppController;

// Redireciona raiz para login do painel
Route::redirect('/', '/dashboard/login');

// Prefixa tudo com /dashboard
Route::prefix('dashboard')->group(function () {

    // Dashboard principal (após login)
    Route::get('/', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    // Autenticado
    Route::middleware('auth')->group(function () {

        /** -------------------- PERFIL DO USUÁRIO -------------------- */
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        /** -------------------- INSTÂNCIAS -------------------- */
        Route::get('/instancias', [InstanceController::class, 'index'])->name('instances.index');
        Route::post('/instances', [InstanceController::class, 'store'])->name('instances.store');
        Route::get('/instancias/{key}/qr', [InstanceController::class, 'qr'])->name('instances.qr');
        Route::get('/instancias/{key}/connect', [InstanceController::class, 'connect'])->name('instances.connect');
        Route::delete('/instances/logout/{name}', [InstanceController::class, 'logout'])->name('instances.logout');
        Route::delete('/instances/delete/{name}', [InstanceController::class, 'destroy'])->name('instances.destroy');

        /** -------------------- CONTATOS, GRUPOS, RÓTULOS -------------------- */
        Route::get('/contatos', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('/grupos', [GroupController::class, 'index'])->name('groups.index');
        Route::get('/rotulos', [LabelController::class, 'index'])->name('labels.index');

        /** -------------------- MENSAGENS -------------------- */
        Route::get('/mensagens', [MessageController::class, 'form'])->name('messages.form');
        Route::post('/mensagens/enviar', [MessageController::class, 'send'])->name('messages.send');

        /** -------------------- PERFIL WHATSAPP -------------------- */
        Route::get('/profileWpp', [ProfileWppController::class, 'index'])->name('profileWpp.index');

        /** -------------------- USUÁRIOS (ADMINISTRAÇÃO) -------------------- */
        Route::get('/usuarios', [ProfileController::class, 'list'])->name('users.index');
        Route::get('/usuarios/novo', function () {
            return view('auth.register');
        })->name('users.create');
        Route::get('/usuarios/{user}/editar', [ProfileController::class, 'editUser'])->name('users.edit');
    });

    // Rotas de autenticação (login, register, etc)
    require __DIR__ . '/auth.php';
});
