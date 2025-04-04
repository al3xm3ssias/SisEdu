@extends('adminlte::page')

@section('title', 'Detalhes do Funcionário')

@section('content_header')
    <h1>Detalhes do Funcionário</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>{{ $funcionario->nome }}</h3>
            <p><strong>Cargo:</strong> {{ ucfirst(str_replace('_', ' ', $funcionario->cargo)) }}</p>
            <p><strong>Status:</strong> {{ $funcionario->status == 0 ? 'Concursado' : 'Terceirizado' }}</p>
            <a href="{{ route('funcionarios.index') }}" class="btn btn-primary">Voltar para a lista</a>
        </div>
    </div>
@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop

