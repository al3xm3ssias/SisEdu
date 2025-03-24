@extends('adminlte::page')

@section('title', isset($professor) ? 'Editar Professor' : 'Cadastrar Professor')

@section('content_header')
    <h1>{{ isset($professor) ? 'Editar Professor' : 'Cadastrar Professor' }}</h1>
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
    <h2>{{ isset($professor) ? 'Editar Professor' : 'Cadastrar Professor' }}</h2>

    <form id="professorForm" action="{{ route('turma_professor_disciplinas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="professor" class="form-label">Professor</label>
            <select id="professor" name="professor_id" class="form-control">
                <option value="">Selecione um professor</option>
                @foreach($professores as $professor)
                    <option value="{{ $professor->id }}" {{ isset($professor) && $professor->id == old('professor_id', $professor->id) ? 'selected' : '' }}>
                        {{ $professor->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="turma" class="form-label">Selecione a Turma</label>
            <select id="turma" name="turma_id" class="form-control">
                <option value="">Selecione uma turma</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ isset($turma_id) && $turma->id == old('turma_id', $turma->id) ? 'selected' : '' }}>
                        {{ $turma->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <button type="button" id="carregar-disciplinas" class="btn btn-info">Carregar Disciplinas</button>
        </div>

        <label for="disciplinas" class="form-label">Selecione as Disciplinas</label>
<select id="disciplinas" name="disciplinas_id[]" class="form-control" multiple>
    @foreach($disciplinas as $disciplina)
        <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
    @endforeach
</select>

        <h4>Disciplinas Selecionadas</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Disciplina</th>
                </tr>
            </thead>
            <tbody id="disciplinasTableBody">
                </tbody>
        </table>

        <input type="hidden" id="disciplinasInput" name="disciplina_id[]" value="{{ is_array(old('disciplina_id')) ? implode(',', old('disciplina_id')) : old('disciplina_id') }}">

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#turma').on('change', function () {
            var turmaId = $(this).val();

            if (!turmaId) {
                $('#disciplinas').empty(); // Limpa as opções se nenhuma turma for escolhida
                return;
            }

            // Faz a requisição AJAX para buscar as disciplinas da turma selecionada
            $.ajax({
                url: '/api/disciplinas/' + turmaId,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    var disciplinasSelect = $('#disciplinas');
                    disciplinasSelect.empty(); // Limpa as opções atuais

                    if (data.length > 0) {
                        data.forEach(function (disciplina) {
                            disciplinasSelect.append('<option value="' + disciplina.id + '">' + disciplina.nome + '</option>');
                        });
                    } else {
                        alert('Nenhuma disciplina encontrada para essa turma.');
                    }
                },
                error: function () {
                    alert('Erro ao carregar disciplinas.');
                }
            });
        });
    });
</script>

@stop