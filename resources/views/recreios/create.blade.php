@extends('adminlte::page')

@section('title', 'Novo Recreio')

@section('content_header')
    <h1 class="text-center">Adicionar Recreio</h1>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Preencha os detalhes do Recreio</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('recreios.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required placeholder="Ex: Recreio Matutino">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inicio">🕒 Início</label>
                        <input type="time" name="inicio" id="inicio" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fim">🕒 Fim</label>
                        <input type="time" name="fim" id="fim" class="form-control" required>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>🏫 Turmas</label>
                    <div class="border p-2 rounded">
                        @foreach ($turmas as $turma)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="turmas[]" value="{{ $turma->id }}">
                                <label class="form-check-label">{{ $turma->nome }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-block">💾 Salvar</button>
            </form>
        </div>
    </div>
@stop


@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
