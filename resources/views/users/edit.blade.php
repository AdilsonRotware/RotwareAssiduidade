@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Usuário</h1>
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label>Senha (Deixe em branco para manter)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Função</label>
                <select name="role" class="form-control" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="normal" {{ $user->role == 'normal' ? 'selected' : '' }}>Normal</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Atualizar</button>
        </form>
    </div>
@endsection
