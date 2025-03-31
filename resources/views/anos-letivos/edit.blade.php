@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Editar Ano Letivo</h1>

    <form action="{{ route('anos-letivos.update', $anos_letivo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ $anos_letivo->nome }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Data de Início</label>
            <input type="date" name="inicio" class="form-control" value="{{ $anos_letivo->inicio }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Data de Fim</label>
            <input type="date" name="fim" class="form-control" value="{{ $anos_letivo->fim }}" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('anos-letivos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
