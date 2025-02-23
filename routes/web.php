<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    AlunoController,
    PresencaController,
    HomeController,
    UserController,
    ProfileController
};
use App\Models\Aluno;
use Illuminate\Http\Request;

// 🔹 Rota inicial para login
Route::view('/', 'auth.login')->name('login');

// 🔹 Rotas de Autenticação
Auth::routes();

// 🔹 Grupo de rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {

    // 🔹 Buscar aluno pelo QR Code
    Route::get('/alunos/qrcode/{qrcode}', [AlunoController::class, 'buscarPorQRCode'])
        ->name('alunos.qrcode');

    // 🔹 Perfil do usuário
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    });

    // 🔹 Página inicial após login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // 🔹 Rotas de alunos acessíveis para todos os usuários autenticados
    Route::prefix('alunos')->group(function () {
        Route::get('/', [AlunoController::class, 'index'])->name('alunos.index');
        Route::get('/{aluno}', [AlunoController::class, 'show'])->name('alunos.show');
    });

    // 🔹 Todos os usuários autenticados podem registrar presença
    Route::resource('presencas', PresencaController::class)->only(['index', 'show', 'create', 'store']);

    // 🔹 Rotas exclusivas para administradores
    Route::middleware(['admin'])->group(function () {
        
        // 🔹 CRUD completo para alunos (exceto visualização)
        Route::resource('alunos', AlunoController::class)->except(['index', 'show']);

        // 🔹 Admin pode editar e excluir presenças
        Route::resource('presencas', PresencaController::class)->only(['edit', 'update', 'destroy']);

        // 🔹 Gestão de usuários (CRUD completo)
        Route::resource('users', UserController::class);
    });

    // 🔹 Rota para buscar aluno pelo QR Code
    Route::get('/buscar-aluno', function (Request $request) {
        $qrcode = $request->input('qrcode');

        if (!$qrcode) {
            return response()->json(['success' => false, 'message' => 'QR Code não fornecido'], 400);
        }

        $aluno = Aluno::where('qrcode', $qrcode)->first();

        if ($aluno) {
            return response()->json(['success' => true, 'nome' => $aluno->nome]);
        }

        return response()->json(['success' => false, 'message' => 'Aluno não encontrado'], 404);
    });

});
