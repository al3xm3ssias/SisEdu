@extends('adminlte::page')

@section('title', 'Criar Grade de Horários')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center mb-0">Montar Grade de Aulas</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('grade_aulas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="turma_id" value="{{ $turma_id }}">

                <!-- Abas para os dias da semana -->
                <ul class="nav nav-tabs" id="scheduleTabs" role="tablist">
                    @foreach($diasSemana as $key => $dia)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if($key == 0) active @endif" id="{{ $dia }}-tab" data-bs-toggle="tab" href="#{{ $dia }}" role="tab">{{ $dia }}</a>
                        </li>
                    @endforeach
                </ul>

                <!-- Conteúdo das abas -->
                <div class="tab-content mt-3" id="scheduleTabContent">
                    @foreach($diasSemana as $key => $dia)
                        <div class="tab-pane fade @if($key == 0) show active @endif" id="{{ $dia }}" role="tabpanel">
                            <table class="table table-striped table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Ação</th>
                                        <th>Início</th>
                                        <th>Fim</th>
                                        <th>Disciplina</th>
                                        <th>É Intervalo?</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-{{ $dia }}">
                                    @for($i = 0; $i < $tamanhoMax; $i++)
                                        <tr id="row-{{ $dia }}-{{ $i }}">
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success split-block" data-dia="{{ $dia }}" data-index="{{ $i }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger remove-block" data-dia="{{ $dia }}" data-index="{{ $i }}">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <input type="time" name="schedule[{{ $dia }}][{{ $i }}][inicio]" class="form-control" required>
                                            </td>
                                            <td>
                                                <input type="time" name="schedule[{{ $dia }}][{{ $i }}][fim]" class="form-control" required>
                                            </td>
                                            <td>
                                                <select name="schedule[{{ $dia }}][{{ $i }}][disciplina]" class="form-control disciplina-select" data-dia="{{ $dia }}" data-index="{{ $i }}">
                                                    <option value="">Selecione</option>
                                                    <option value="99">Livre</option>
                                                    @foreach ($recreiosTurma as $recreio)
                                                        <option value="{{ $recreio['recreio_turma_id'] }}" data-tipo="recreio">{{ $recreio['nome'] }}</option>
                                                    @endforeach
                                                    @foreach ($disciplinas as $disciplina)
                                                        <option value="{{ $disciplina->id }}" data-tipo="aula">{{ $disciplina->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="checkbox" class="is-recreio-checkbox" data-dia="{{ $dia }}" data-index="{{ $i }}" disabled>
                                                <input type="hidden" name="schedule[{{ $dia }}][{{ $i }}][is_recreio]" class="is-recreio-hidden" value="0">
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary mt-3">Salvar</button>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Função para clonar uma linha
    function clonarLinha(dia, index) {
        let tbody = document.getElementById(`tbody-${dia}`);
        let currentRow = document.getElementById(`row-${dia}-${index}`);
        if (!currentRow) return;

        let newIndex = tbody.children.length;
        let newRow = currentRow.cloneNode(true);
        newRow.id = `row-${dia}-${newIndex}`;

        // Atualiza atributos e limpa valores
        newRow.querySelectorAll("input, select").forEach(input => {
            let name = input.getAttribute("name");
            if (name) {
                input.setAttribute("name", name.replace(/\[\d+\]/, `[${newIndex}]`));
            }
            input.value = "";
        });

        let newSelect = newRow.querySelector('.disciplina-select');
        let newCheckbox = newRow.querySelector('.is-recreio-checkbox');
        let newHiddenField = newRow.querySelector('.is-recreio-hidden');

        newSelect.setAttribute('data-index', newIndex);
        newCheckbox.setAttribute('data-index', newIndex);
        newHiddenField.setAttribute('name', `schedule[${dia}][${newIndex}][is_recreio]`);

        // Remove eventos antigos e adiciona um novo evento ao select clonado
        newSelect.addEventListener('change', function() {
            atualizarCheckboxRecreio(dia, newIndex, newSelect, newCheckbox, newHiddenField);
        });

        newRow.querySelector('.split-block').setAttribute('data-index', newIndex);
        newRow.querySelector('.remove-block').setAttribute('data-index', newIndex);
        tbody.appendChild(newRow);
    }

    // Função para remover uma linha
    function removerLinha(dia, index) {
        let tbody = document.getElementById(`tbody-${dia}`);
        let rowToDelete = document.getElementById(`row-${dia}-${index}`);
        if (tbody.children.length > 1 && rowToDelete) {
            rowToDelete.remove();
        } else {
            alert("Não é possível excluir todas as linhas. Pelo menos uma deve permanecer.");
        }
    }

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

    // Delegação de eventos para clonar e remover linhas
    document.addEventListener('click', function(event) {
        let button = event.target.closest('.split-block, .remove-block');
        if (!button) return;
        
        let dia = button.getAttribute('data-dia');
        let index = parseInt(button.getAttribute('data-index'));
        
        if (button.classList.contains('split-block')) {
            clonarLinha(dia, index);
        } else if (button.classList.contains('remove-block')) {
            removerLinha(dia, index);
        }
    });

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
});

document.addEventListener("DOMContentLoaded", function() {
    let triggerTabList = [].slice.call(document.querySelectorAll('#scheduleTabs a'));
    triggerTabList.forEach(function(tab) {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            let tabTarget = new bootstrap.Tab(tab);
            tabTarget.show();
        });
    });
});

</script>
@endsection
