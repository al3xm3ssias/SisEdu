@extends('adminlte::page')

@section('title', 'Lista de Professores')

@section('content_header')
    <h1>Lista de Professores</h1>
@stop

@section('content')
    <a href="{{ route('professores.create') }}" class="btn btn-primary mb-3">Adicionar Professor</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($professores as $professor)
                <tr>
                    <td>{{ $professor->nome }}</td>
                    <td>
                        <a href="{{ route('professores.edit', $professor->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('professores.destroy', $professor->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
