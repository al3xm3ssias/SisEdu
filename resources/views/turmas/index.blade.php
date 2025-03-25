@extends('adminlte::page')

@section('title', 'Turmas')

@section('content_header')
    <h1>Lista de Turmas</h1>
@stop

@section('content')
<a href="{{ route('turmas.create') }}" class="btn btn-primary">Adicionar Turma</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($turmas as $index => $turma)
                <tr>
                <td>{{ $index + 1 }}</td> <!-- Contador de 1 até N -->
                    <td>{{ $turma->nome }}</td>
                    <td>
                        <a href="{{ route('turmas.edit', $turma->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    

@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
@stop
