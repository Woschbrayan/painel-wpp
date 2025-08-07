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

// Redireciona raiz para login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard principal (após login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Agrupa todas as rotas que exigem autenticação
Route::middleware('auth')->group(function () {

    /** -------------------- PERFIL DO USUÁRIO -------------------- */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Editar perfil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Atualizar perfil
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Excluir conta

    /** -------------------- INSTÂNCIAS -------------------- */
    Route::get('/instancias', [InstanceController::class, 'index'])->name('instances.index'); // Lista de instâncias
    Route::post('/instances', [InstanceController::class, 'store'])->name('instances.store'); // Criar nova instância
    Route::get('/instancias/{key}/qr', [InstanceController::class, 'qr'])->name('instances.qr'); // Ver QR Code
    Route::get('/instancias/{key}/connect', [InstanceController::class, 'connect'])->name('instances.connect'); // Conectar instância
    Route::delete('/instances/logout/{name}', [InstanceController::class, 'logout'])->name('instances.logout'); // Desconectar instância
    Route::delete('/instances/delete/{name}', [InstanceController::class, 'destroy'])->name('instances.destroy'); // Excluir instância

    /** -------------------- CONTATOS, GRUPOS, RÓTULOS -------------------- */
    Route::get('/contatos', [ContactController::class, 'index'])->name('contacts.index'); // Lista de contatos
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index'); // Lista de grupos
    Route::get('/labels', [LabelController::class, 'index'])->name('labels.index'); // Lista de etiquetas

    /** -------------------- MENSAGENS -------------------- */
    Route::get('/mensagens', [MessageController::class, 'form'])->name('messages.form'); // Formulário de envio
    Route::post('/mensagens/enviar', [MessageController::class, 'send'])->name('messages.send'); // Enviar mensagem

    /** -------------------- PERFIL WHATSAPP -------------------- */
    Route::get('/profileWpp', [ProfileWppController::class, 'index'])->name('profileWpp.index');

    /** -------------------- USUÁRIOS (ADMINISTRAÇÃO) -------------------- */
    Route::get('/usuarios', [ProfileController::class, 'list'])->name('users.index'); // Lista de usuários

    // Formulário de novo usuário (abre no mesmo layout do painel)
Route::get('/usuarios/novo', function () {
    return view('auth.register');
})->name('users.create');
    // Formulário de edição de usuário
    Route::get('/usuarios/{user}/editar', [ProfileController::class, 'editUser'])->name('users.edit');
});

require __DIR__ . '/auth.php'; // Inclui rotas de autenticação padrão do Laravel Breeze / Jetstream
