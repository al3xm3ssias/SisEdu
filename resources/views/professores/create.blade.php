@extends('adminlte::page')

@section('title', 'Adicionar Professor')

@section('content_header')
    <h1>Adicionar Professor</h1>
@stop

@section('content')
    <form action="{{ route('professores.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome do Professor</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="turmas">Turmas</label>
            <select name="turmas[]" id="turmas" class="form-control" multiple required>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="disciplinas">Disciplinas</label>
            <select name="disciplinas[]" id="disciplinas" class="form-control" multiple required>
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@stop
