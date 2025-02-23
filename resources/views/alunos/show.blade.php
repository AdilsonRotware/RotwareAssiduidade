@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Detalhes do Aluno</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nome:</strong> {{ $aluno->nome }}</p>
                    <p><strong>CPF:</strong> {{ $aluno->cpf }}</p>
                    <p><strong>Data de Nascimento:</strong> {{ $aluno->data_nascimento }}</p>
                    <p><strong>Endereço:</strong> {{ $aluno->endereco }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Telefone:</strong> {{ $aluno->telefone }}</p>
                    <p><strong>E-mail:</strong> {{ $aluno->email }}</p>
                    <p><strong>QR Code:</strong></p>
                    <div class="text-center">
                        {!! QrCode::size(200)->generate($aluno->qrcode) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('alunos.qrcode', $aluno) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Baixar QR Code
            </a>
            <a href="{{ route('alunos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>
@endsection