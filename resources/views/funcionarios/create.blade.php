@extends('adminlte::page')

@section('title', 'Cadastrar Funcionário')

@section('content_header')
    <h1>Cadastrar Funcionário</h1>
@stop

@section('content')
    <form action="{{ route('funcionarios.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome') }}" required>
        </div>

        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" name="matricula" class="form-control" value="{{ old('matricula') }}" required>
        </div>

        <div class="form-group">
    <label for="cargo">Cargo</label>
    <select id="cargo" name="cargo_id" class="form-control" required>
        @foreach($cargos as $cargo)
            <option value="{{ $cargo->id }}">{{ ucfirst(str_replace('_', ' ', $cargo->nome)) }}</option>
        @endforeach
    </select>
</div>

        <div class="form-group">
            <label for="tipo_funcionario">Tipo de Funcionário</label>
            <select id="tipo_funcionario" name="tipo_funcionario" class="form-control" required>
                <option value="0">Concursado</option>
                <option value="1">Terceirizado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
