@extends('adminlte::page')

@section('title', 'Editar Grade de Aulas')

@section('content')
<div class="container">
    <h2>Editar Grade de Aulas</h2>

    <form id="gradeAulasForm" action="{{ route('grade_aulas.update', $turma_id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Método PUT para atualização -->

        <!-- Abas para cada dia da semana -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach($diasSemana as $key => $dia)
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if($key == 0) active @endif" id="{{ $dia }}-tab" data-bs-toggle="tab" href="#{{ $dia }}" role="tab" aria-controls="{{ $dia }}" aria-selected="true">{{ ucfirst($dia) }}</a>
                </li>
            @endforeach
        </ul>

        <!-- Conteúdo das abas -->
        <div class="tab-content" id="myTabContent">
            @foreach($diasSemana as $key => $dia)
            <div class="tab-pane fade @if($key == 0) show active @endif" id="{{ $dia }}" role="tabpanel" aria-labelledby="{{ $dia }}-tab">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Horário de Início</th>
                            <th>Horário de Fim</th>
                            <th>Disciplina</th>
                            <th>Recreio</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-{{ $dia }}">
                    @foreach($schedule[$dia] ?? [] as $index => $gradeAula)
                        <tr>
                            <td><input type="time" name="schedule[{{ $dia }}][{{ $index }}][inicio]" value="{{ $gradeAula['inicio'] ?? '' }}" class="form-control"></td>
                            <td><input type="time" name="schedule[{{ $dia }}][{{ $index }}][fim]" value="{{ $gradeAula['fim'] ?? '' }}" class="form-control"></td>
                            <td>
                                <select name="schedule[{{ $dia }}][{{ $index }}][disciplina]" class="form-control disciplina-select" data-dia="{{ $dia }}" data-index="{{ $index }}">
                                    <option value="">Selecione</option>
                                    @foreach($recreiosTurma as $recreio)
                                        <option value="{{ $recreio['recreio_turma_id'] }}" data-tipo="recreio" 
                                            @if(($gradeAula['disciplina'] ?? '') == $recreio['recreio_turma_id']) selected @endif>
                                            {{ $recreio['nome'] }} (Recreio)
                                        </option>
                                    @endforeach
                                    @foreach($disciplinas as $disciplina)
                                        @if($disciplina->id != 99)
                                            <option value="{{ $disciplina->id }}" 
                                                @if(($gradeAula['disciplina'] ?? '') == $disciplina->id) selected @endif>
                                                {{ $disciplina->nome }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="checkbox" class="is-recreio-checkbox" data-dia="{{ $dia }}" data-index="{{ $index }}"
                                    @if(isset($gradeAula['is_recreio']) && $gradeAula['is_recreio']) checked @endif disabled>
                                <input type="hidden" name="schedule[{{ $dia }}][{{ $index }}][is_recreio]" class="is-recreio-hidden"
                                    value="{{ isset($gradeAula['is_recreio']) && $gradeAula['is_recreio'] ? 1 : 0 }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                    <i class="fas fa-minus"></i> Remover
                                </button>
                                <button type="button" class="btn btn-success btn-sm add-row" data-dia="{{ $dia }}">
                                    <i class="fas fa-plus"></i> Adicionar Linha
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="{{ route('grade_aulas.index') }}" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>

<!-- Adicionando o JavaScript necessário para manipular a tabela -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Atualiza o checkbox de recreio corretamente
        function atualizarCheckboxRecreio(dia, index, select, checkbox, hiddenField) {
            let selectedOption = select.options[select.selectedIndex];

            if (selectedOption.dataset.tipo === 'recreio') {
                checkbox.checked = true;
                checkbox.disabled = false;
                hiddenField.value = 1;
            } else {
                checkbox.checked = false;
                checkbox.disabled = true;
                hiddenField.value = 0;
            }
        }

        // Delegação de eventos para atualizar o status de recreio
        document.addEventListener('change', function(event) {
            let select = event.target.closest('.disciplina-select');
            if (!select) return;
            
            let dia = select.dataset.dia;
            let index = select.dataset.index;
            let checkbox = document.querySelector(`.is-recreio-checkbox[data-dia="${dia}"][data-index="${index}"]`);
            let hiddenField = document.querySelector(`.is-recreio-hidden[name="schedule[${dia}][${index}][is_recreio]"]`);

            atualizarCheckboxRecreio(dia, index, select, checkbox, hiddenField);
        });

        // Adicionar nova linha
        document.querySelectorAll('.add-row').forEach(function(button) {
            button.addEventListener('click', function() {
                let dia = this.getAttribute('data-dia');
                let tbody = document.getElementById('tbody-' + dia);
                let index = tbody.children.length;

                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="time" name="schedule[${dia}][${index}][inicio]" class="form-control" required></td>
                    <td><input type="time" name="schedule[${dia}][${index}][fim]" class="form-control" required></td>
                    <td>
                        <select name="schedule[${dia}][${index}][disciplina]" class="form-control disciplina-select" data-dia="${dia}" data-index="${index}">
                            <option value="">Selecione</option>
                            @foreach($recreiosTurma as $recreio)
                                <option value="{{ $recreio['recreio_turma_id'] }}" data-tipo="recreio">{{ $recreio['nome'] }} (Recreio)</option>
                            @endforeach
                            @foreach($disciplinas as $disciplina)
                                @if($disciplina->id != 99)
                                    <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" class="is-recreio-checkbox" data-dia="${dia}" data-index="${index}" disabled>
                        <input type="hidden" name="schedule[${dia}][${index}][is_recreio]" class="is-recreio-hidden" value="0">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">Remover</button>
                    </td>
                `;
                tbody.appendChild(newRow);
            });
        });

        // Remover linha
        document.addEventListener('click', function(event) {
            if (event.target.closest('.remove-row')) {
                event.target.closest('tr').remove();
            }
        });

    });
</script>
@endsection
