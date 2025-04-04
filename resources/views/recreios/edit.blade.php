@extends('adminlte::page')

@section('title', 'Editar Recreio')

@section('content_header')
    <h1 class="text-center">Editar Recreio</h1>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-header bg-warning">
            <h3 class="mb-0">Atualize os detalhes do Recreio</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('recreios.update', $recreio->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control"
                        value="{{ old('nome', $recreio->nome) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inicio">🕒 Início</label>
                        <input type="time" name="inicio" id="inicio" class="form-control"
                            value="{{ old('inicio', $recreio->inicio) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fim">🕒 Fim</label>
                        <input type="time" name="fim" id="fim" class="form-control"
                            value="{{ old('fim', $recreio->fim) }}" required>
                    </div>
                </div>

                  <div class="form-group mt-3">
                    <label>🏫 Turmas</label>
                    <div class="border p-2 rounded">
                       @foreach($turmas as $turma)
                        <input type="checkbox" name="turmas[]" value="{{ $turma->id }}"
                            {{ in_array($turma->id, $recreio->turmas->pluck('id')->toArray()) ? 'checked' : '' }}>
                        {{ $turma->nome }}
                       @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-warning btn-block">💾 Atualizar</button>
            </form>
        </div>
    </div>
@stop

@section('footer')
    <strong>Feito por Alex Messias <a href="https://adminlte.io">SisEdu</a>.</strong>

    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
