@extends('adminlte::page')

@section('title', 'Vincular Professor')

@section('content_header')
    <h1>Vincular Professor a Turma e Disciplina</h1>
@stop

@section('content')
    <form action="{{ route('vincular.professor') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="funcionario_id">Selecione o Professor</label>
            <select name="funcionario_id" id="funcionario_id" class="form-control">
                <option value="">Selecione o Professor</option>
                @foreach ($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}">{{ $funcionario->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="disciplinas">Disciplinas</label>
            <select name="disciplinas[]" id="disciplinas" class="form-control" multiple>
                @foreach ($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="turmas">Turmas</label>
            <select name="turmas[]" id="turmas" class="form-control" multiple>
                @foreach ($turmas as $turma)
                    <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Vincular</button>
    </form>
@stop
