@extends('adminlte::page')

@section('title', 'Baixar CSV')

@section('content_header')
    <h1>Baixar Arquivo CSV</h1>
@stop

@section('content')
    <!-- Exibir Mensagem de Sucesso ou Erro -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Botão para Baixar CSV -->
    <form action="{{ route('baixar-csv') }}" method="GET">
        <button type="submit" class="btn btn-primary">Baixar CSV</button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Página de download CSV!'); </script>
@stop
