@extends('layouts.app')

@section('content')
    <h2>Editar Presença</h2>
    <form action="{{ route('presencas.update', $presenca) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Aluno:</label>
        <select name="aluno_id">
            @foreach($alunos as $aluno)
                <option value="{{ $aluno->id }}" {{ $aluno->id == $presenca->aluno_id ? 'selected' : '' }}>
                    {{ $aluno->nome }}
                </option>
            @endforeach
        </select>

        <label>Data:</label>
        <input type="date" name="data" value="{{ $presenca->data }}" required>

        <label>Status:</label>
        <select name="status">
            <option value="presente" {{ $presenca->status == 'presente' ? 'selected' : '' }}>Presente</option>
            <option value="ausente" {{ $presenca->status == 'ausente' ? 'selected' : '' }}>Ausente</option>
            <option value="atrasado" {{ $presenca->status == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
        </select>

        <button type="submit">Salvar</button>
    </form>
@endsection
