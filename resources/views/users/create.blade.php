@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Criar Usuário</h1>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirme a Senha</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Função</label>
                <select name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="normal">Normal</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </div>
@endsection
