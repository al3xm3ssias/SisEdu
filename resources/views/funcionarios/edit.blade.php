@extends('adminlte::page')

@section('title', isset($funcionario) ? 'Editar Funcionário' : 'Cadastrar Funcionário')

@section('content_header')
    <h1>{{ isset($funcionario) ? 'Editar Funcionário' : 'Cadastrar Funcionário' }}</h1>
@stop

@section('content')
    <form action="{{ isset($funcionario) ? route('funcionarios.update', $funcionario->id) : route('funcionarios.store') }}" method="POST">
        @csrf
        @if(isset($funcionario))
            @method('PUT') <!-- Necessário para atualização -->
        @endif
        
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $funcionario->nome ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" name="matricula" class="form-control" value="{{ old('matricula', $funcionario->matricula ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="cargo_id">Cargo</label>
            <select id="cargo_id" name="cargo_id" class="form-control" required>
                @foreach($cargos as $cargo)
                    <option value="{{ $cargo->id }}"
                        @if(old('cargo_id', $funcionario->cargo_id ?? '') == $cargo->id) selected @endif
                        data-nome="{{ $cargo->nome }}">
                        {{ $cargo->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" id="turno-group">
            <label for="turno">Turno</label>
            <select id="turno" name="turno_id" class="form-control" required>
                <option value="1" @if(old('turno_id', $funcionario->turno_id ?? 3) == 3) selected @endif>Integral</option>
                <option value="2" @if(old('turno_id', $funcionario->turno_id ?? '') == 1) selected @endif>Manhã</option>
                <option value="3" @if(old('turno_id', $funcionario->turno_id ?? '') == 2) selected @endif>Tarde</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_funcionario">Tipo de Funcionário</label>
            <select id="tipo_funcionario" name="tipo_funcionario" class="form-control" required>
                <option value="0" {{ old('tipo_funcionario', $funcionario->tipo_funcionario ?? '') == 0 ? 'selected' : '' }}>Concursado</option>
                <option value="1" {{ old('tipo_funcionario', $funcionario->tipo_funcionario ?? '') == 1 ? 'selected' : '' }}>Terceirizado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var cargoSelect = document.getElementById('cargo_id');
    var turnoGroup = document.getElementById('turno-group');
    var turnoSelect = document.getElementById('turno');

    function toggleTurnoField() {
        var selectedCargoId = cargoSelect.options[cargoSelect.selectedIndex].value;
        
        if (selectedCargoId === '8') { // Professor 20h
            turnoGroup.style.display = 'block'; 
            turnoSelect.innerHTML = ` 
                <option value="1">Manhã</option>
                <option value="2">Tarde</option>
            `;

            // Se o turno atual não for válido, define um padrão
            if (![1, 2].includes(parseInt(turnoSelect.value))) {
                turnoSelect.value = "1"; // Manhã como padrão
            }
        } else {
            turnoGroup.style.display = 'none';
            
            // Garante que o turno seja enviado corretamente
            turnoSelect.innerHTML = `
                <option value="3" selected>Integral</option>
            `;
        }
    }

    toggleTurnoField();
    cargoSelect.addEventListener('change', toggleTurnoField);
});

</script>
@stop
