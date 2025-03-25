@extends('adminlte::page')

@section('content')
    <div class="container">
        <h1>Definir Horários para a Turma: {{ $turma->nome }}</h1>

        <form method="POST" action="{{ route('salvar.horarios', $turma->id) }}">
            @csrf

            <!-- Campo para selecionar a disciplina -->
            <div class="form-group">
                <label for="disciplina_id">Disciplina</label>
                <select class="form-control" name="disciplina_id" required>
                    <option value="">Selecione a Disciplina</option>
                    @foreach($disciplinas as $disciplina)
                        <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Campo para selecionar o dia da semana -->
            <div class="form-group">
                <label for="dia">Dia da Semana</label>
                <select class="form-control" name="dia" required>
                    <option value="segunda">Segunda-feira</option>
                    <option value="terca">Terça-feira</option>
                    <option value="quarta">Quarta-feira</option>
                    <option value="quinta">Quinta-feira</option>
                    <option value="sexta">Sexta-feira</option>
                </select>
            </div>

            <!-- Campo para selecionar o horário de início -->
            <div class="form-group">
                <label for="inicio">Início</label>
                <input type="time" class="form-control" name="inicio" required>
            </div>

            <!-- Campo para selecionar o horário de fim -->
            <div class="form-group">
                <label for="fim">Fim</label>
                <input type="time" class="form-control" name="fim" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Horário</button>
        </form>
    </div>
@endsection
