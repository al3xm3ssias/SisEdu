@extends('adminlte::page')

@section('title', 'Turma')

@section('content_header')
    <h1>Turma</h1>
@stop



@extends('adminlte::page')

@section('title', 'Editar Turma')

@section('content_header')
    <h1>Editar Turma</h1>
@stop

@section('content')

    <form action="{{ route('turmas.update', $turma->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nome">Nome da Turma</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $turma->nome) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>

@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
@stop









@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
