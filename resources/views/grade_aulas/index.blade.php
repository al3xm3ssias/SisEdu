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
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Incluir Grade
                    </button>
                </form>
            </div>
        </div>

        <!-- Cartão para exibir as grades existentes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grades de Aulas</h3>
            </div>
            <div class="card-body">
                @if($grades->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Não há grades de aulas salvas.
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
                          
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
