@extends('adminlte::page')

@section('title', 'Disciplinas')

@section('content')

    <!-- Card para tabela -->
    <div class="card shadow-lg">
        <div class="card-header  text-black d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Disciplinas Cadastradas</h4>
            <a href="{{ route('disciplinas.create') }}" class="btn btn-outline-primary btn-sm ml-auto d-flex align-items-center">➕ Nova Disciplina</a>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Nº</th>
                        <th>Nome</th>
                        <th>Carga Horária</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($disciplinas as $index => $disciplina)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Contador de 1 até N -->
                            <td>{{ $disciplina->nome }}</td>
                            <td>{{ $disciplina->carga_horaria_max }} min</td>
                            <td>
                                <a href="{{ route('disciplinas.edit', $disciplina) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('disciplinas.destroy', $disciplina) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
@stop
