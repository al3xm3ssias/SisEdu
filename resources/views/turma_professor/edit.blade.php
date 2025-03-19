@extends('adminlte::page')

@section('title', 'Editar Relacionamento')

@section('content_header')
    <h1>Editar Relacionamento entre Turma e Professor</h1>
@stop

@section('content')

    <form action="{{ route('turma_professor.update', $turmaProfessor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="turma_id">Turma</label>
            <select name="turma_id" id="turma_id" class="form-control" required>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ $turmaProfessor->turma_id == $turma->id ? 'selected' : '' }}>{{ $turma->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="professor_id">Professor</label>
            <select name="professor_id" id="professor_id" class="form-control" required>
                @foreach($professores as $professor)
                    <option value="{{ $professor->id }}" {{ $turmaProfessor->professor_id == $professor->id ? 'selected' : '' }}>{{ $professor->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>

@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
@stop
