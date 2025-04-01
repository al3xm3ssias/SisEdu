@extends('adminlte::page')

@section('title', 'Visualizar Grade de Horários')

@section('content')
<div class="container">
    <h2>Visualizar Grade de Aulas</h2>

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
                    @foreach($schedule[$dia] ?? [] as $gradeAula)
                        <tr>
                            <td>
                                <input type="time" 
                                       value="{{ $gradeAula->hora_inicio }}" 
                                       class="form-control" disabled>
                            </td>
                            <td>
                                <input type="time" 
                                       value="{{ $gradeAula->hora_fim }}" 
                                       class="form-control" disabled>
                            </td>
                            <td>
                                <select class="form-control" disabled>
                                    <!-- Opção 'Livre' -->
                                    <option value="99" 
                                        @if($gradeAula->disciplina_id == 99) selected @endif>
                                        Livre
                                    </option>

                                    <!-- Loop para os intervalos -->
                                    @foreach($recreiosTurma as $recreio)
    @php
        // Criando o valor do recreio com o prefixo "Intervalo-"
        $intervalo = "Intervalo-" . $recreio['nome'];
    @endphp
    <option value="{{ $intervalo }}" 
            @if($gradeAula->recreio_turma_id == $intervalo) selected @endif>
        {{ $recreio['nome'] }} ({{ $recreio['inicio'] }} - {{ $recreio['fim'] }})
    </option>
@endforeach

<!-- Loop para as disciplinas -->
@foreach($disciplinas as $disciplina)
    @if($disciplina->id != 99) <!-- Verifica se a disciplina não é "Livre" -->
        <option value="{{ $disciplina->id }}" 
                @if($gradeAula->disciplina_id == $disciplina->id) selected @endif>
            {{ $disciplina->nome }}
        </option>
    @endif
@endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    </div>

    <a href="{{ route('grade_aulas.index') }}" class="btn btn-primary mt-3">Voltar</a>
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

@endsection
