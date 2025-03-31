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
    <tbody>
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
                    <input type="time" name="schedule[{{ $dia }}][{{ $i }}][inicio]" 
                        value="{{ old('schedule.'.$dia.'.'.$i.'.inicio', $schedule[$dia][$i]['inicio'] ?? '') }}" 
                        class="form-control" required>
                </td>
                <td>
                    <input type="time" name="schedule[{{ $dia }}][{{ $i }}][fim]" 
                        value="{{ old('schedule.'.$dia.'.'.$i.'.fim', $schedule[$dia][$i]['fim'] ?? '') }}" 
                        class="form-control" required>
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



 
<!-- Scripts -->
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const dias = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];

    // Função para clonar horários de um dia para os outros
    function clonarHorarios(diaOrigem) {
        dias.forEach(dia => {
            if (dia !== diaOrigem) {
                document.querySelectorAll(`[name="schedule[${diaOrigem}][0][inicio]"]`).forEach((origemInicio, index) => {
                    let destinoInicio = document.querySelector(`[name="schedule[${dia}][${index}][inicio]"]`);
                    if (destinoInicio) destinoInicio.value = origemInicio.value;
                });

                document.querySelectorAll(`[name="schedule[${diaOrigem}][0][fim]"]`).forEach((origemFim, index) => {
                    let destinoFim = document.querySelector(`[name="schedule[${dia}][${index}][fim]"]`);
                    if (destinoFim) destinoFim.value = origemFim.value;
                });
            }
        });
    }

    // Função para clonar uma linha de horário
    function clonarLinha(dia, index) {
        let currentRow = document.getElementById(`row-${dia}-${index}`);
        if (!currentRow) return;

        let newIndex = index + 1;
        let newRow = currentRow.cloneNode(true);
        newRow.id = `row-${dia}-${newIndex}`;
        newRow.querySelector('.split-block').setAttribute('data-index', newIndex);
        newRow.querySelector('.remove-block').setAttribute('data-index', newIndex);

        newRow.querySelectorAll("input, select").forEach(input => {
            input.value = "";
            input.setAttribute("data-index", newIndex);
        });

        currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);
    }

    // Função para remover uma linha (mas sempre mantendo pelo menos uma)
    function removerLinha(dia, index) {
        let rows = document.querySelectorAll(`[id^="row-${dia}-"]`);
        if (rows.length > 1) {
            let rowToDelete = document.getElementById(`row-${dia}-${index}`);
            if (rowToDelete) rowToDelete.remove();
        } else {
            alert("Não é possível excluir todas as linhas. Pelo menos uma deve permanecer.");
        }
    }

    // Atribuir eventos aos inputs de horários
    dias.forEach(dia => {
        document.querySelectorAll(`[name="schedule[${dia}][0][inicio]"], [name="schedule[${dia}][0][fim]"]`)
            .forEach(input => input.addEventListener('change', () => clonarHorarios(dia)));
    });

    // Eventos para clonar e remover linhas
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('split-block')) {
            let dia = event.target.getAttribute('data-dia');
            let index = parseInt(event.target.getAttribute('data-index'));
            clonarLinha(dia, index);
        }

        if (event.target.classList.contains('remove-block')) {
            let dia = event.target.getAttribute('data-dia');
            let index = parseInt(event.target.getAttribute('data-index'));
            removerLinha(dia, index);
        }
    });

    // Evento para atualizar o status de recreio
    document.querySelectorAll('.disciplina-select').forEach(select => {
        select.addEventListener('change', function() {
            let dia = this.dataset.dia;
            let index = this.dataset.index;
            let selectedOption = this.options[this.selectedIndex];
            let checkbox = document.querySelector(`.is-recreio-checkbox[data-dia="${dia}"][data-index="${index}"]`);
            let hiddenField = document.querySelector(`.is-recreio-hidden[name="schedule[${dia}][${index}][is_recreio]"]`);

            if (selectedOption.dataset.tipo === 'recreio') {
                checkbox.checked = true;
                checkbox.disabled = false;
                hiddenField.value = 1;
            } else {
                checkbox.checked = false;
                checkbox.disabled = true;
                hiddenField.value = 0;
            }
        });
    });
});
</script>



@section('footer')
    <strong>Feito por Alex Messias <a href="https://adminlte.io">SisEdu</a>.</strong>
@stop
