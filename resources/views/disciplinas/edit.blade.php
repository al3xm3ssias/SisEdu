<!-- resources/views/disciplinas/edit.blade.php -->
@extends('adminlte::page')
@section('title', 'Editar Disciplina')
@section('content_header')
    <h1>Editar Disciplina</h1>
@stop

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@section('content')
    <h1>Editar Aula</h1>

    <form action="{{ route('disciplinas.update', $disciplina->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome da Disciplina</label>
            <input type="text" name="nome" id="nome" class="form-control"
                value="{{ old('nome', $disciplina->nome) }}" required>
        </div>

        
        <div class="form-group">
    <label for="carga_horaria_horas">Carga Horária Máxima</label>
    <div class="d-flex">
        <input type="number" name="carga_horaria_horas" id="carga_horaria_horas" class="form-control"
            value="{{ old('carga_horaria_horas', intdiv($disciplina->carga_horaria_max, 60)) }}" required min="0">
        <span class="mx-2 align-self-center">h</span>
        <input type="number" name="carga_horaria_minutos" id="carga_horaria_minutos" class="form-control"
            value="{{ old('carga_horaria_minutos', $disciplina->carga_horaria_max % 60) }}" required min="0" max="59">
        <span class="mx-2 align-self-center">min</span>
    </div>
</div>
        <button type="submit" class="btn btn-warning">Atualizar</button>
    </form>
@endsection

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop

