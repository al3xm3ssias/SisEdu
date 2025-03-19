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
