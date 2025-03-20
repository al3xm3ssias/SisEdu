@extends('adminlte::page')

@section('title', 'Disciplinas')

@section('content')
    <h1>Disciplinas</h1>
    <a href="{{ route('disciplinas.create') }}" class="btn btn-primary">Nova Disciplina</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disciplinas as $disciplina)
                <tr>
                    <td>{{ $disciplina->nome }}</td>
                    <td>
                        <a href="{{ route('disciplinas.edit', $disciplina) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('disciplinas.destroy', $disciplina) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
