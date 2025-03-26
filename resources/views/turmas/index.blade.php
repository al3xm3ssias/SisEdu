@extends('adminlte::page')

@section('title', 'Turmas')

@section('content')

    <!-- Card para tabela -->
    <div class="card shadow-lg">
        <div class="card-header text-black d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Turmas Cadastradas</h4>
            <a href="{{ route('turmas.create') }}" class="btn btn-outline-primary btn-sm ml-auto d-flex align-items-center">➕ Adicionar Turma</a>
        </div>
        
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
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
                                <a href="{{ route('turmas.edit', $turma->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
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
