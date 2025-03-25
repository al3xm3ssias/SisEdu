@extends('adminlte::page')

@section('title', 'Editar Professor')

@section('content_header')
    <h1>Editar Professor</h1>
@stop

@section('content')
<div class="container">
    <h2>Editar Professor: {{ $professor->nome }}</h2>

    <!-- Listar Turmas e Disciplinas Associadas -->
    <h3>Turmas e Disciplinas Vinculadas</h3>
    <table class="table">
    <thead>
        <tr>
            <th>Turma</th>
            <th>Disciplinas</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($relacoes->groupBy('turma.id') as $turmaId => $dados)
            <tr>
                <td>{{ $dados->first()->turma->nome }}</td>
                <td>
                    @foreach($dados as $relacao)
                        {{ $relacao->disciplina->nome }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                <form action="{{ route('turma_professor_disciplinas.destroy', ['professor_id' => $professor->id, 'turma_id' => $dados->first()->turma->id]) }}" 
      method="POST" 
      style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
</form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


    <!-- Formulário para Adicionar/Editar -->
    <h3>Adicionar/Editar Turma e Disciplinas</h3>
    <form id="professorForm" action="{{ route('turma_professor_disciplinas.update', $professor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="turma" class="form-label">Selecione a Turma</label>
            <select id="turma" name="turma_id" class="form-control">
                <option value="">Selecione uma turma</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="disciplinas" class="form-label">Selecione as Disciplinas</label>
            <select id="disciplinas" name="disciplinas_id[]" class="form-control" multiple>
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@stop

@section('js')
<script>
    function editarTurmaDisciplina(turmaId) {
        document.getElementById('turma').value = turmaId;
    }
</script>
@stop
