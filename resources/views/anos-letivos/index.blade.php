@extends('adminlte::page')

@section('title', 'Anos Letivos')

@section('right_sidebar')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
            📅 Ano Letivo: {{ \App\Models\AnoLetivo::find(session('ano_letivo_id'))->nome ?? 'Não definido' }}
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <form action="{{ route('anos-letivos.mudar') }}" method="POST">
                @csrf
                <select name="ano_letivo_id" class="form-control" onchange="this.form.submit()">
                    @foreach($anosLetivos as $ano)
                        <option value="{{ $ano->id }}" {{ session('ano_letivo_id') == $ano->id ? 'selected' : '' }}>
                            {{ $ano->nome }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </li>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-header text-black d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Lista de Anos Letivos</h3>
            <a href="{{ route('anos-letivos.create') }}" class="btn btn-outline-primary btn-sm ml-auto d-flex align-items-center">➕ Novo Ano Letivo</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>📖 Nome</th>
                        <th>🕒 Início</th>
                        <th>🕒 Fim</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anosLetivos as $ano)
                        <tr class="text-center">
                            <td>{{ $ano->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($ano->inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($ano->fim)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('anos-letivos.edit', $ano->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                                <form action="{{ route('anos-letivos.destroy', $ano->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este ano letivo?');">🗑️ Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop