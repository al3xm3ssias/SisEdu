@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <!-- Card para adicionar nova grade -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Adicionar Nova Grade</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('grade_aulas.create') }}" method="GET">
                    <div class="form-group">
                        <label for="turma_id">Selecione a Turma</label>
                        <select name="turma_id" id="turma_id" class="form-control" required>
                            <option value="" disabled selected>Selecione a turma</option>
                            @foreach($turmas as $turma)
                                <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
        <label for="tamanho_max">Quantidade de Blocos:</label>
        <input type="number" name="tamanho_max" id="tamanho_max" class="form-control" value="{{ request('tamanho_max', 5) }}" min="1" required>
    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Incluir Grade
                    </button>
                </form>
            </div>
        </div>

        <!-- Cartão para exibir as turmas com grades existentes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Turmas com Grades de Aulas</h3>
            </div>
            <div class="card-body">
                @if($turmasComGrade->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Não há turmas com grades de aulas salvas.
                    </div>
                @else
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Turma</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($turmasComGrade as $turma)
                                <tr>
                                    <td>{{ $turma->nome }}</td>
                                    <td>
                                        <!-- Botão para ver a grade -->
                                        <a href="{{ route('grade_aulas.show', $turma->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>

                                        <!-- Botão para editar a grade -->
                                        <a href="{{ route('grade_aulas.edit', $turma->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <!-- Botão para deletar a grade -->
                                        <form action="{{ route('grade_aulas.destroy', $turma->id) }}" method="POST" style="display: inline;" 
                                            onsubmit="return confirm('Tem certeza que deseja excluir esta grade?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Deletar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection



@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
