@extends('adminlte::page')

@section('content')
    <h1>Listagem de Aulas</h1>
    <a href="{{ route('aulas.create') }}" class="btn btn-primary">Adicionar Aula</a>

    <table class="table">
        <thead>
            <tr>
                <th>Turma</th>
                <th>Professor</th>
                <th>Disciplina</th>
                <th>Horário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aulas as $aula)
                <tr>
                    <td>{{ $aula->turma->nome }}</td>
                    <td>{{ $aula->professor->nome }}</td>
                    <td>{{ $aula->disciplina->nome }}</td>
                    <td>{{ $aula->horario }}</td>
                    <td>
                        <a href="{{ route('aulas.edit', $aula->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('aulas.destroy', $aula->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
