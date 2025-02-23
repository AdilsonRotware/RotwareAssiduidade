<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Função</label>
        <select name="role" class="form-select">
            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
            <option value="normal" {{ old('role', $user->role) == 'normal' ? 'selected' : '' }}>Usuário Normal</option>
        </select>
    </div>

    @if($method === 'POST')
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" required>
        </div>
    @endif

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
