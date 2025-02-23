@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Cadastrar Aluno</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('alunos.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" class="form-control" required autocomplete="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" name="cpf" class="form-control" required autocomplete="off" oninput="gerarQRCode()">
                        </div>
                    </div>
                </div>

                <div class="form-group" id="qrcode-container" style="display: none;">
                    <label>QR Code</label>
                    <canvas id="qrcode"></canvas>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" required autocomplete="bday">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control" required autocomplete="tel">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" class="form-control" required autocomplete="street-address">
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required autocomplete="email">
                </div>

                <button type="submit" class="btn btn-success btn-block mt-3">Salvar</button>
            </form>
        </div>
    </div>
</div>

<!-- Importa a biblioteca qrious.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script>
    function gerarQRCode() {
        var cpf = document.getElementById("cpf").value;
        var qrContainer = document.getElementById("qrcode-container");
        var qrCanvas = document.getElementById("qrcode");

        if (cpf.length >= 11) { // Quando o CPF estiver completo
            qrContainer.style.display = "block";

            var qr = new QRious({
                element: qrCanvas,
                value: cpf,
                size: 150
            });
        } else {
            qrContainer.style.display = "none";
        }
    }
</script>
@endsection
