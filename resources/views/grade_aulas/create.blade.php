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
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 0; $i < $tamanhoMax; $i++)
                                        <tr id="row-{{ $dia }}-{{ $i }}">
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success split-block" data-dia="{{ $dia }}" data-index="{{ $i }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <input type="time" name="schedule[{{ $dia }}][{{ $i }}][inicio]" value="{{ old('schedule.'.$dia.'.'.$i.'.inicio', $schedule[$dia][$i]['inicio'] ?? '') }}" class="form-control" required>
                                            </td>
                                            <td>
                                                <input type="time" name="schedule[{{ $dia }}][{{ $i }}][fim]" value="{{ old('schedule.'.$dia.'.'.$i.'.fim', $schedule[$dia][$i]['fim'] ?? '') }}" class="form-control" required>
                                            </td>
                                            <td>
                                                <select name="schedule[{{ $dia }}][{{ $i }}][disciplina]" class="form-control">
                                                    <option value="99">Livre</option>
                                                    @foreach($recreiosTurma as $recreio)
                                                        <option value="Intervalo-{{ $recreio['nome'] }}">{{ $recreio['nome'] }} ({{ $recreio['inicio'] }} - {{ $recreio['fim'] }})</option>
                                                    @endforeach
                                                    @foreach($disciplinas as $disciplina)
                                                        <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                                                    @endforeach
                                                </select>
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

<!-- Scripts  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Função para clonar os horários de um dia para os outros (só os horários de início e fim)
    function clonarHorarios(diaOrigem) {
        const dias = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];

        dias.forEach(dia => {
            if (dia !== diaOrigem) {
                // Para clonar o horário de início
                document.querySelectorAll(`[name="schedule[${dia}][0][inicio]"]`).forEach((input, index) => {
                    const origemInicio = document.querySelector(`[name="schedule[${diaOrigem}][${index}][inicio]"]`);
                    if (origemInicio) {
                        input.value = origemInicio.value;
                    }
                });

                // Para clonar o horário de fim
                document.querySelectorAll(`[name="schedule[${dia}][0][fim]"]`).forEach((input, index) => {
                    const origemFim = document.querySelector(`[name="schedule[${diaOrigem}][${index}][fim]"]`);
                    if (origemFim) {
                        input.value = origemFim.value;
                    }
                });
            }
        });
    }

    // Função para clonar uma linha de horário
    function clonarLinha(dia, index) {
        let currentRow = document.getElementById(`row-${dia}-${index}`);
        if (!currentRow) return;

        let newIndex = index + 1000; // Novo índice para a linha clonada
        let newRow = currentRow.cloneNode(true);
        newRow.id = `row-${dia}-${newIndex}`;
        newRow.querySelector('.split-block').setAttribute('data-index', newIndex);

        // Limpar valores dos inputs da nova linha
        newRow.querySelectorAll("input, select").forEach(input => input.value = "");

        // Inserir a nova linha abaixo da linha original
        currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);

        // Garantir que os campos clonados sejam válidos e focáveis
        newRow.querySelectorAll("input, select").forEach(input => {
            input.removeAttribute("readonly");
            input.setAttribute("required", "required");
        });
    }

    // Monitorando a mudança nos horários de início e fim de cada dia
    const dias = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];
    dias.forEach(dia => {
        const inicioInputs = document.querySelectorAll(`[name="schedule[${dia}][0][inicio]"]`);
        const fimInputs = document.querySelectorAll(`[name="schedule[${dia}][0][fim]"]`);

        inicioInputs.forEach((input, index) => {
            input.addEventListener('change', function() {
                clonarHorarios(dia); // Chama a função de clonagem de horários
            });
        });

        fimInputs.forEach((input, index) => {
            input.addEventListener('change', function() {
                clonarHorarios(dia); // Chama a função de clonagem de horários
            });
        });
    });

    // Clonagem de linhas
    document.querySelectorAll('.split-block').forEach(button => {
        button.addEventListener('click', function() {
            let dia = this.getAttribute('data-dia');
            let index = parseInt(this.getAttribute('data-index'));
            clonarLinha(dia, index); // Chama a função de clonagem de linha
        });
    });
});


</script>  

@endsection

@section('footer')
    <strong>Feito por Alex Messias <a href="https://adminlte.io">SisEdu</a>.</strong>
@stop
