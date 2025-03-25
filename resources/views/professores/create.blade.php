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
        <option value="" {{ old('professor_id') === null ? 'selected' : '' }}>Selecione um professor</option> <!-- Aqui, verificamos se o old está vazio -->
        @foreach($professores as $professor)
            <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
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
            <!-- As disciplinas serão carregadas via AJAX -->
        </select>

        <div class="mb-3">
            <button type="button" id="incluir-disciplina" class="btn btn-primary">Incluir Disciplina</button>
        </div>

        <h4>Disciplinas Selecionadas</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Disciplina</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody id="disciplinasTableBody">
                <!-- As disciplinas selecionadas serão adicionadas aqui -->
            </tbody>
        </table>

        <!-- Container para os inputs ocultos com os pares turma/disciplina -->
        <div id="turma_disciplinas_inputs"></div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Botão para carregar disciplinas no <select> múltiplo
        $('#carregar-disciplinas').on('click', function () {
            var turmaId = $('#turma').val();

            if (!turmaId) {
                alert('Por favor, selecione uma turma.');
                $('#disciplinas').empty().append('<option value="">Selecione uma turma primeiro...</option>');
                return;
            }

            $.ajax({
                url: '/api/disciplinas/' + turmaId,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    var disciplinasSelect = $('#disciplinas');
                    disciplinasSelect.empty();

                    if (data.length > 0) {
                        data.forEach(function (disciplina) {
                            disciplinasSelect.append('<option value="' + disciplina.id + '">' + disciplina.nome + '</option>');
                        });
                    } else {
                        alert('Nenhuma disciplina encontrada para essa turma.');
                        disciplinasSelect.append('<option value="">Nenhuma disciplina disponível</option>');
                    }
                },
                error: function () {
                    alert('Erro ao carregar disciplinas.');
                }
            });
        });

        // Índice global para os inputs ocultos
        var index = 0;

        // Botão para incluir as disciplinas selecionadas na tabela
        $('#incluir-disciplina').on('click', function () {
            var turmaId = $('#turma').val();
            var turmaNome = $('#turma option:selected').text();
            var disciplinasSelecionadas = $('#disciplinas option:selected');

            if (!turmaId) {
                alert('Por favor, selecione uma turma.');
                return;
            }

            if (disciplinasSelecionadas.length === 0) {
                alert('Selecione pelo menos uma disciplina para incluir.');
                return;
            }

            // Limpar o select de disciplinas após inclusão
            $('#disciplinas').empty();

            var disciplinasTable = $('#disciplinasTableBody');

            disciplinasSelecionadas.each(function () {
                var disciplinaId = $(this).val();
                var disciplinaNome = $(this).text();

                // Verifica se a combinação turma-disciplina já foi adicionada
                if ($('#disciplinasTableBody tr[data-turma="' + turmaId + '"][data-disciplina="' + disciplinaId + '"]').length === 0) {
                    // Adiciona a linha na tabela
                    disciplinasTable.append(
                        '<tr data-turma="' + turmaId + '" data-disciplina="' + disciplinaId + '"><td>' + turmaNome + '</td><td>' + disciplinaNome + '</td><td><button type="button" class="btn btn-danger btn-sm remove-discipline">🗑️</button></td></tr>'
                    );
                    // Cria os inputs ocultos para enviar os dados
                    $('#turma_disciplinas_inputs').append(
                        '<input type="hidden" name="turma_disciplinas[' + index + '][turma_id]" value="' + turmaId + '">'
                    );
                    $('#turma_disciplinas_inputs').append(
                        '<input type="hidden" name="turma_disciplinas[' + index + '][disciplina_id]" value="' + disciplinaId + '">'
                    );
                    index++;
                }
            });
        });

        // Função para remover a disciplina da tabela
        $(document).on('click', '.remove-discipline', function () {
            $(this).closest('tr').remove(); // Remove a linha
        });
    });
</script>
@stop
