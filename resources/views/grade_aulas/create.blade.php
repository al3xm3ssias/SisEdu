@extends('adminlte::page')

@section('title', 'Criar Grade de Horários')

@section('content')
<div class="container">
    <h2>Montar Grade de Aulas</h2>
    <form action="{{ route('grade_aulas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="turma_id" value="{{ $turma_id }}">
        
        <!-- Abas para cada dia da semana -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach($diasSemana as $key => $dia)
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if($key == 0) active @endif" id="{{ $dia }}-tab" data-bs-toggle="tab" href="#{{ $dia }}" role="tab" aria-controls="{{ $dia }}" aria-selected="true">{{ $dia }}</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < 4; $i++) <!-- 8 blocos de horário -->
                                <tr>
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
                                    <select name="schedule[{{ $dia }}][{{ $i }}][disciplina]" class="form-control">
    <!-- Adicionando a opção 'Livre' com o valor 99 -->
    <option value="99" 
        @if(old("schedule.$dia.$i.disciplina") == 99) selected @endif>
        Livre
    </option>

    <!-- Loop para os intervalos -->
    @foreach($recreiosTurma as $recreio)
        @php
            $intervalo = "Intervalo-" . $recreio['nome'];
        @endphp
        <option value="{{ $intervalo }}" 
                @if(old("schedule.$dia.$i.disciplina") == $intervalo) selected @endif>
            {{ $recreio['nome'] }} ({{ $recreio['inicio'] }} - {{ $recreio['fim'] }})
        </option>
    @endforeach

    <!-- Loop para as disciplinas, sem incluir o "Livre" novamente -->
    @foreach($disciplinas as $disciplina)
        @if($disciplina->id != 99) <!-- Verifica se a disciplina não é "Livre" -->
            <option value="{{ $disciplina->id }}" 
                    @if(old("schedule.$dia.$i.disciplina") == $disciplina->id) selected @endif>
                {{ $disciplina->nome }}
            </option>
        @endif
    @endforeach
</select>


                                    </td>
                                </tr>
                            @endfor
                            <!-- Intervalos 
                            @foreach($recreios as $recreio)
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <strong>Intervalo: {{ $recreio['nome'] }}</strong><br>
                                        Início: {{ $recreio['inicio'] }} - Fim: {{ $recreio['fim'] }}
                                    </td>
                                </tr>
                            @endforeach

                            -->
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
    </form>
</div>

<!-- Adicionando o JavaScript necessário para alternar as abas -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inicializar a primeira aba como ativa
        var myTab = new bootstrap.Tab(document.querySelector('.nav-tabs a'));
        myTab.show();

        // Alternar entre as abas
        var tabs = document.querySelectorAll('.nav-tabs a');
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                var target = document.querySelector(tab.getAttribute('href'));
                var bsTab = new bootstrap.Tab(tab);
                bsTab.show();
            });
        });
    });
</script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
    // Array com os dias da semana para iteração
    const dias = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];
    
    // Função para clonar os horários de um dia para os outros
    function clonarHorarios(diaOrigem) {
        dias.forEach(dia => {
            if (dia !== diaOrigem) {
                // Para cada linha de horários (no caso, o índice [0], [1], [2], etc.)
                for (let i = 0; i < 4; i++) { // 8 blocos de horários
                    // Clonando o horário de início
                    const origemInicio = document.querySelector(`[name="schedule[${diaOrigem}][${i}][inicio]"]`);
                    const destinoInicio = document.querySelector(`[name="schedule[${dia}][${i}][inicio]"]`);
                    if (origemInicio && destinoInicio) {
                        destinoInicio.value = origemInicio.value;
                    }

                    // Clonando o horário de fim
                    const origemFim = document.querySelector(`[name="schedule[${diaOrigem}][${i}][fim]"]`);
                    const destinoFim = document.querySelector(`[name="schedule[${dia}][${i}][fim]"]`);
                    if (origemFim && destinoFim) {
                        destinoFim.value = origemFim.value;
                    }
                }
            }
        });
    }

    // Monitorando a mudança nos horários de início e fim de cada dia
    dias.forEach(dia => {
        // Encontrando todos os inputs de horário de início e fim para cada dia
        for (let i = 0; i < 4; i++) { // 8 blocos de horários
            const inicioInput = document.querySelector(`[name="schedule[${dia}][${i}][inicio]"]`);
            const fimInput = document.querySelector(`[name="schedule[${dia}][${i}][fim]"]`);

            if (inicioInput) {
                inicioInput.addEventListener('change', function() {
                    clonarHorarios(dia);
                });
            }

            if (fimInput) {
                fimInput.addEventListener('change', function() {
                    clonarHorarios(dia);
                });
            }
        }
    });
});


</script>


@endsection
