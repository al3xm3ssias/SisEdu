@extends('adminlte::page')

@section('title', 'Criar Grade de Horários')

@section('content')
<div class="container">
    <h2>Montar Grade de Aulas</h2>
    
    <form action="{{ route('grade_aulas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="turma_id" value="{{ $turma->id }}"> <!-- Campo oculto para enviar o ID da turma -->
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Horário</th>
                    <th colspan="5" class="text-center">Dias da Semana</th>
                </tr>
                <tr>
                    <th>Segunda</th>
                    <th>Terça</th>
                    <th>Quarta</th>
                    <th>Quinta</th>
                    <th>Sexta</th>
                </tr>
            </thead>
            <tbody>
            @foreach($horarios as $index => $horario)
                <tr>
                    <td>{{ $horario['inicio'] }} - {{ $horario['fim'] }}</td>
                    @for ($i = 0; $i < 5; $i++)
                        <td>
                            <select name="disciplinas[{{ $index }}][{{ $i }}]" class="form-control">
                                <option value="">-</option>
                                @foreach($disciplinas as $disciplina)
                                    <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                                @endforeach
                            </select>
                        </td>
                    @endfor
                </tr>
            @endforeach
            </tbody>
        </table>
        
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="reset" class="btn btn-secondary">Cancelar</button>
    </form>
</div>
@endsection
