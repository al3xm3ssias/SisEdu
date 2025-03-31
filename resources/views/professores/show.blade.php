@extends('adminlte::page')

@section('title', 'Detalhes do Professor')

@section('content_header')
    <h1>Detalhes do Professor</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informações do Professor</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $professor->id }}</p>
            <p><strong>Nome:</strong> {{ $professor->nome }}</p>

            <h4>Disciplinas e Turmas:</h4>
            <ul>
                @forelse($professor->disciplinas as $disciplina)
                    <li>
                        <strong>Disciplina:</strong> {{ $disciplina->nome }}  
                        - <strong>Turma:</strong> {{ $disciplina->turma->nome ?? 'Não atribuída' }}
                    </li>
                @empty
                    <p>Este professor não tem disciplinas vinculadas.</p>
                @endforelse
            </ul>

            <a href="{{ route('professores.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <a href="{{ route('professores.edit', $professor->id) }}" class="btn btn-warning">
                <i class="fas fa-pencil-alt"></i> Editar
            </a>
        </div>
    </div>

@stop
