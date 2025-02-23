@extends('layouts.app')

@section('title', 'Registrar Presença')
@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Registrar Presença</h3>
            <a href="{{ route('presencas.index') }}" class="btn btn-warning"><i class="fas fa-list"></i> Ver Lista</a>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success" id="success-message">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" id="error-message">{{ session('error') }}</div>
            @endif

            <div class="text-center mb-3">
                <label class="font-weight-bold">Escaneie seu QR Code:</label>
                <video id="scanner" class="border rounded shadow-sm" playsinline></video>
            </div>
            
            <form action="{{ route('presencas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="qrcode" id="qrcode" required>
                
                <div class="form-group">
                    <label for="nome">Nome do Aluno:</label>
                    <input type="text" name="nome" id="nome" class="form-control" required readonly>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_hora_presenca">Data e Hora:</label>
                            <input type="datetime-local" name="data_hora_presenca" id="data_hora_presenca" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-check"></i> Confirmar Presença</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    #scanner {
        width: 100%;
        max-width: 500px;
        margin: 10px auto;
        display: block;
        transform: scaleX(-1);
    }

    .alert {
        transition: opacity 0.5s ease-in-out;
    }
</style>
@stop

@section('js')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });

    Instascan.Camera.getCameras().then(cameras => {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('Nenhuma câmera encontrada!');
        }
    });

    scanner.addListener('scan', function(content) {
        document.getElementById('qrcode').value = content;

        fetch("{{ url('/buscar-aluno') }}?qrcode=" + content)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('nome').value = data.nome;
                    document.getElementById('data_hora_presenca').value = new Date().toISOString().slice(0, -8);

                    fetch("{{ url('/verificar-presenca') }}?qrcode=" + content)
                        .then(response => response.json())
                        .then(presenca => {
                            document.getElementById('status').value = presenca.status === 'entrada' ? 'saida' : 'entrada';
                        });
                } else {
                    alert('Aluno não encontrado!');
                }
            });
    });

    setTimeout(() => {
        let successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.opacity = '0';
            setTimeout(() => { successMessage.style.display = 'none'; }, 500);
        }
    }, 5000);
});
</script>
@stop
