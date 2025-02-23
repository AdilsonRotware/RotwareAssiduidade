@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-warning text-white">
            <h4 class="fw-bold mb-0">✏️ Editar Aluno</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('alunos.update', $aluno) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label fw-semibold">Nome:</label>
                    <input type="text" name="nome" class="form-control" value="{{ old('nome', $aluno->nome) }}" required>
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label fw-semibold">CPF:</label>
                    <input type="text" name="cpf" class="form-control" value="{{ old('cpf', $aluno->cpf) }}" required>
                </div>

                <div class="mb-3">
                    <label for="data_nascimento" class="form-label fw-semibold">Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" class="form-control" value="{{ old('data_nascimento', $aluno->data_nascimento) }}" required>
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label fw-semibold">Endereço:</label>
                    <input type="text" name="endereco" class="form-control" value="{{ old('endereco', $aluno->endereco) }}" required>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label fw-semibold">Telefone:</label>
                    <input type="text" name="telefone" class="form-control" value="{{ old('telefone', $aluno->telefone) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">E-mail:</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $aluno->email) }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('alunos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
