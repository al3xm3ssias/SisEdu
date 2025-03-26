<!-- resources/views/disciplinas/create.blade.php -->
@extends('adminlte::page')
@section('title', 'Criar Disciplina')
@section('content_header')
    <h1>Adicionar Nova Disciplina</h1>
@stop
@section('content')
    <form action="{{ route('disciplinas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome da Disciplina</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="carga_horaria_max">Carga horária Máxima</label>
            <input type="text" id="carga_horaria_max" name="carga_horaria_max" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@stop
