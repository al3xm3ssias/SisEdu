@extends('adminlte::page')

@section('title', 'Tela Inicial')

@section('content_header')
    <h1>Bem-vindo ao Sistema!</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Informações importantes</h3>
        </div>
        <div class="card-body">
            <p>Esta é a tela inicial do seu sistema. Aqui você pode acessar todas as funcionalidades e acompanhar o andamento do seu trabalho.</p>
            <p>Para começar, clique nos itens do menu lateral.</p>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Tela inicial carregada!'); </script>
@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
