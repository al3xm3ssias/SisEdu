<!-- resources/views/disciplinas/edit.blade.php -->
@extends('adminlte::page')
@section('title', 'Editar Disciplina')
@section('content_header')
    <h1>Editar Disciplina</h1>
@stop
@section('content')
    <h1>Criar Aula</h1>

    <form action="{{ route('aulas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="turma_id">Turma</label>
            <select name="turma_id" id="turma_id" class="form-control" required>
                <option value="">Selecione a turma</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="professor_id">Professor</label>
            <select name="professor_id" id="professor_id" class="form-control" required>
                <option value="">Selecione o professor</option>
                @foreach($professores as $professor)
                    <option value="{{ $professor->id }}">{{ $professor->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="disciplina_id">Disciplina</label>
            <select name="disciplina_id" id="disciplina_id" class="form-control" required>
                <option value="">Selecione a disciplina</option>
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="horario">Horário</label>
            <input type="text" name="horario" id="horario" class="form-control" placeholder="Ex: 08:00 - 09:00" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@endsection