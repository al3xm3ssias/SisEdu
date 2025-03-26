@extends('adminlte::page')

@section('title', 'Recreios')

@section('content_header')
    <h1 class="text-center">📅 Recreios</h1>
@stop

@section('content')
    <div class="card shadow-lg">
    <div class="card-header  text-black d-flex justify-content-between align-items-center">
    <h3 class="mb-0">Lista de Recreios</h3>
    <a href="{{ route('recreios.create') }}" class="btn btn-outline-primary btn-sm ml-auto d-flex align-items-center">➕ Novo Recreio</a>
</div>

        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Nome</th>
                        <th>🕒 Início</th>
                        <th>🕒 Fim</th>
                        <th>🏫 Turmas</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recreios as $recreio)
                        <tr class="text-center">
                            <td>{{ $recreio->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($recreio->inicio)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($recreio->fim)->format('H:i') }}</td>
                            <td>
                                @foreach ($recreio->turmas as $turma)
                                    <span class="badge badge-info">{{ $turma->nome }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('recreios.edit', $recreio->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                                <form action="{{ route('recreios.destroy', $recreio->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir este recreio?');">🗑️ Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
