@extends('adminlte::page')

@section('title', 'Relacionamento Turma-Professor')

@section('content_header')
    <h1>Relacionamento entre Turmas e Professores</h1>
@stop

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Turma</th>
                <th>Professor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($turmasProfessores as $turmaProfessor)
                <tr>
                    <td>{{ $turmaProfessor->turma->nome }}</td>
                    <td>{{ $turmaProfessor->professor->nome }}</td>
                    <td>
                        <a href="{{ route('turma_professor.edit', $turmaProfessor->id) }}" class="btn btn-warning">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('turma_professor.create') }}" class="btn btn-primary">Adicionar Relacionamento</a>

@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
@stop
