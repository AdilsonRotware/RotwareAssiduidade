@extends('layouts.app')

@section('title', 'Lista de Presenças')

@section('content_header')
    <h1 class="m-0 text-dark">Lista de Presenças</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Registro de Presenças</h3>

        <!-- Formulário de Pesquisa -->
        <form action="{{ route('presencas.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar aluno..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </form>

        <a href="{{ route('presencas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Registrar Presença</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Aluno</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if($presencas->count() > 0)
                        @foreach($presencas as $presenca)
                            <tr>
                                <td>{{ $presenca->aluno->nome }}</td>
                                <td>{{ \Carbon\Carbon::parse($presenca->data_hora_presenca)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge {{ $presenca->status == 'entrada' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($presenca->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('presencas.edit', $presenca) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                    <form action="{{ route('presencas.destroy', $presenca) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma presença encontrada para este aluno.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center mt-3">
            {{ $presencas->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endsection
