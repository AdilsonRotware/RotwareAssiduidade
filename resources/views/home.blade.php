@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Bem-vindo')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Bem-vindo')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Exibir mensagem de erro caso o usuário tente acessar uma rota sem permissão --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <p>Bem-vindo a este belo painel de administração.</p>
    
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Adicione aqui estilos adicionais --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script> console.log("Oi, estou usando o pacote Laravel-AdminLTE!"); </script>
@endpush
