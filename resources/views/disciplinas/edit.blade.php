<!-- resources/views/disciplinas/edit.blade.php -->
@extends('adminlte::page')
@section('title', 'Editar Disciplina')
@section('content_header')
    <h1>Editar Disciplina</h1>
@stop
@section('content')
    <form action="{{ route('disciplinas.update', $disciplina->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nome">Nome da Disciplina</label>
            <input type="text" id="nome" name="nome" class="form-control" value="{{ $disciplina->nome }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@stop