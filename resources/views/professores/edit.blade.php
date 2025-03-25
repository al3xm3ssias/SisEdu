@extends('adminlte::page')

@section('title', 'Editar Professor')

@section('content_header')
    <h1>Editar Professor</h1>
@stop

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@section('content')
<div class="container">
    <h2>Editar Professor: {{ $professor->nome }}</h2>

    <form id="professorForm" action="{{ route('turma_professor_disciplinas.update', $turmaDisciplina->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Listar Turmas e Disciplinas Associadas -->
        <h3>Turmas e Disciplinas Associadas</h3>
        <table class="table" id="turmasDisciplinasTable">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Disciplina</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            @foreach($turmaDisciplina->disciplinas as $disciplina)
                <td>{{ $disciplina->nome }}</td>
            @endforeach
            </tbody>
        </table>

        <!-- Selecione a Turma -->
        <div class="mb-3">
            <label for="turma" class="form-label">Adicionar/Editar Turma</label>
            <select id="turma" name="turma_id" class="form-control">
                <option value="">Selecione uma turma</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ isset($turmaDisciplina) && $turmaDisciplina->turma_id == $turma->id ? 'selected' : '' }}>
                        {{ $turma->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Selecione as Disciplinas -->
        <div class="mb-3">
            <label for="disciplinas" class="form-label">Selecione as Disciplinas</label>
            <select id="disciplinas" name="disciplinas_id[]" class="form-control" multiple>
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}" 
                            {{ isset($turmaDisciplina) && in_array($disciplina->id, $turmaDisciplina->disciplinas->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $disciplina->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@stop

@section('js')
<script>
    // Função para selecionar a linha da tabela (caso precise)
    function selectRow(id) {
        const row = document.getElementById('row-' + id);
        
        // Pega os valores da turma e disciplina da linha
        const turmaId = row.querySelector('.turma').getAttribute('data-turma-id');
        const disciplinaId = row.querySelector('.disciplina').getAttribute('data-disciplina-id');

        // Preenche os selects de turma e disciplina
        const turmaSelect = document.getElementById('turma');
        const disciplinaSelect = document.getElementById('disciplinas');

        // Define o valor do select de turma
        turmaSelect.value = turmaId;

        // Marca a disciplina correspondente no select de disciplinas
        const options = disciplinaSelect.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].value == disciplinaId) {
                options[i].selected = true;
            } else {
                options[i].selected = false;
            }
        }
    }
</script>
@stop
