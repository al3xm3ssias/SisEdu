@extends('adminlte::page')

@section('title', 'Gerar Ciência')

@section('content_header')
    <h1>Gerar Ciência de Funcionários</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('gerar.ciencia') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="referente">Referente a:</label>
                    <input type="text" class="form-control" id="referente" name="referente" required>
                </div>

                <div class="form-group">
                    <label for="tipo_funcionario">Tipo de Funcionário:</label>
                    <select name="tipo_funcionario" class="form-control" required>
                        <option value="todos">Todos</option>
                        <option value="concursados">Concursados</option>
                        <option value="professoras">Professoras</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Gerar Ciência</button>
            </form>
        </div>
    </div>
@stop
