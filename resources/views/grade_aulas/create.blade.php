@extends('adminlte::page')

@section('title', 'Criar Grade de Horários')

@section('content')
<div class="container">
    <h2>Montar Grade de Aulas</h2>
    <form action="{{ route('grade_aulas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="turma_id" value="{{ $turma_id }}">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Horário de Início</th>
                    <th>Horário de Fim</th>
                    @foreach($diasSemana as $dia)
                        <th>{{ $dia }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{-- Definindo manualmente os horários dos blocos --}}
                @for($i = 0; $i < 8; $i++) <!-- 8 blocos -->
                    <tr>
                        <td>
                            <input type="time" name="schedule[{{ $i }}][inicio]" 
                                   value="{{ old('schedule.'.$i.'.inicio') }}" 
                                   class="form-control" required>
                        </td>
                        <td>
                            <input type="time" name="schedule[{{ $i }}][fim]" 
                                   value="{{ old('schedule.'.$i.'.fim') }}" 
                                   class="form-control" required>
                        </td>
                        @foreach($diasSemana as $dia)
                        <td>
    {{-- Verificando se o bloco já possui disciplina ou intervalo --}}
    @if(isset($schedule[$dia][$i]))
        @if($schedule[$dia][$i]['tipo'] == 'intervalo')
            {{-- Exibindo o intervalo --}}
            @php
                // Encontrar o intervalo correspondente para esse bloco
                $intervalo = null;
                foreach ($recreiosTurma as $recTurma) {
                    if ($recTurma->inicio === $schedule[$dia][$i]['fim']) {
                        $intervalo = $recTurma;
                        break;
                    }
                }
            @endphp

            <input type="text" class="form-control" 
                   value="{{ $intervalo ? $intervalo->nome : 'Intervalo' }}" 
                   disabled>
        @else
            {{-- Seleção de disciplina --}}
            <select name="schedule[{{ $dia }}][{{ $i }}][disciplina]" class="form-control">
                <option value="Livre" @if($schedule[$dia][$i]['conteudo'] == 'Livre') selected @endif>Livre</option>
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}" 
                        @if(strpos($schedule[$dia][$i]['conteudo'], $disciplina->nome) !== false) selected @endif>
                        {{ $disciplina->nome }}
                    </option>
                @endforeach
            </select>
        @endif
    @else
        -
    @endif
</td>
                        @endforeach
                    </tr>
                @endfor
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
