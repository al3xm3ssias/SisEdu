@extends('adminlte::page')

@section('title', 'Lista de Professores')

@section('content_header')
    <h1>Lista de Professores</h1>
@stop

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2>Professores</h2>
        <a href="{{ route('professores.create') }}" class="btn btn-success">Incluir Professor</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Disciplinas Ministradas</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($professores as $professor)
                <tr>
                    <td>{{ $professor->nome }}</td>
                    <td>
    @php
        $disciplinas = \App\Models\TurmaProfessorDisciplinas::where('professor_id', $professor->id)
            ->pluck('disciplina_id')
            ->toArray();
        
        $nomes_disciplinas = \App\Models\Disciplina::whereIn('id', $disciplinas)->pluck('nome')->toArray();
    @endphp
    {{ count($nomes_disciplinas) > 0 ? implode(', ', $nomes_disciplinas) : 'Nenhuma' }}
</td>

                    <td>
                        <a href="{{ route('professores.edit', $professor->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('professores.destroy', $professor->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
