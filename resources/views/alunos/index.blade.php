@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary fw-bold">📌 Lista de Alunos</h1>
        @can('admin')
        <a href="{{ route('alunos.create') }}" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Adicionar Aluno
        </a>
        @endcan
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Nome</th>
                            <th class="text-center">QR Code</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alunos as $aluno)
                            <tr>
                                <td class="fw-semibold">{{ $aluno->nome }}</td>
                                <td class="text-center">
                                    <div class="border p-2 d-inline-block bg-light rounded shadow-sm">
                                        {!! QrCode::size(100)->generate($aluno->qrcode) !!}
                                    </div>
                                </td>
                                <td class="text-center">
                                @can('admin')
                                    <a href="{{ route('alunos.show', $aluno) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('alunos.edit', $aluno) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('alunos.destroy', $aluno) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Tem certeza que deseja deletar este aluno?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Deletar
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
